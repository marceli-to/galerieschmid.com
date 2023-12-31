<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\Artwork;
use App\Models\ArtworkTechnique;
use App\Models\ArtworkFrame;
use App\Models\ArtworkAttribute;
use App\Models\Attribute;
use App\Models\ArtworkAdditionalField;
use App\Models\Client;
use App\Models\Artist;

class ImportArtwork extends Command
{
  protected $signature = 'import:artwork';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_objekte.json';

  protected $model = Artwork::class;

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $this->info('Import of file '. $this->file .' started...');
    
    // Read contents of $file located at /storage/app/import
    $json = \File::get(storage_path('app/import/' . $this->file));

    // Parse json
    $data = json_decode($json);

    // Find item with "type = table"
    $table = collect($data)->where('type', 'table')->first();

    if ($table->data)
    {
      foreach($table->data as $item)
      {
        $artwork = $this->model::create([
          'id' => $item->OBJEKTE_ID,
          'image' => $item->BILD ?? null,
          'inventory_number' => $item->INVENTAR_NR ?? null,
          'artist_inventory_number' => $item->KUENSTLER_INV_NR ?? null,
          'litho_number' => $item->LITHO_NR ?? null,
          'description_de' => $item->DESCRX ?? null,
          'description_en' => $item->DESCRX_EN ?? null,
          'height' => $item->HOEHE > 0 ? $item->HOEHE : null,
          'width' => $item->BREITE > 0 ? $item->BREITE : null,
          'depth' => $item->TIEFE > 0 ? $item->TIEFE : null,
          'location' => $item->STANDORT ?? null,
          'previous_client' => $item->BESITZER_ALT ?? null,
          'artwork_state_id' => $item->STATUS == 0 ? 4 : $item->STATUS,
          'inventory_state_id' => $item->BESTANDES_STATUS == 0 ? 14 : $item->BESTANDES_STATUS,
          'vat_type_id' => $item->MWST_CODE == 0 ? 2 : $item->MWST_CODE,
          'year' => $item->DATUM_OBJEKT != null && $item->DATUM_OBJEKT != '' ? $item->DATUM_OBJEKT : null,
          'date_in' => $item->DATUM_EIN && $item->DATUM_EIN > 0 && $item->DATUM_EIN <= now() ? date('Y-m-d', $item->DATUM_EIN) : null,
          'date_out' => $item->DATUM_AUS && $item->DATUM_AUS > 0 && $item->DATUM_AUS <= now() ? date('Y-m-d', $item->DATUM_AUS) : null,
          'date_sold' => $item->DATUM_VERKAUF && $item->DATUM_VERKAUF > 0 && $item->DATUM_VERKAUF <= now() ? date('Y-m-d', $item->DATUM_VERKAUF) : null,
          'date_billed' => $item->DATUM_ABGERECHNET && $item->DATUM_ABGERECHNET > 0 && $item->DATUM_ABGERECHNET <= now() ? date('Y-m-d', $item->DATUM_ABGERECHNET) : null,
          'purchase_price_soll' => $item->EK_PREIS_SOLL ?? '0.00',
          'purchase_price_ist' => $item->EK_PREIS_IST ?? '0.00',
          'purchase_price_frame' => $item->EK_PREIS_RAHMEN ?? '0.00',
          'sale_price_soll' => $item->VK_PREIS_SOLL ?? '0.00',
          'sale_price_ist' => $item->VK_PREIS_IST ?? '0.00',
          'sale_price_internal' => $item->VK_PREIS_INTERN ?? '0.00',
          'sale_price_frame' => $item->VK_PREIS_RAHMEN ?? '0.00',
          'show_exact_price' => $item->EXAKTER_PREIS_ANZEIGEN ?? 0,
          'info' => $item->GALERIE ?? null,
          'info_arttrade' => $item->TEXT_KUNSTHANDEL ?? null,
          'bank_account_number' => $item->KONTONR ?? null,
          'bank_account_info' => $item->BANK ?? null,
          'discount' => $item->RABATT ?? null,
          'position' => $item->SORT ?? -1,
          'publish' => $item->STATUS,
          'user_id' => 1,
        ]);

        if ($item->ATTRIBUTES)
        {
          // $item->ATTRIBUTES can be a comma separated string
          // split the string and add each attribute to ArtworkAttribute
          $attributes = explode(',', $item->ATTRIBUTES);
          foreach($attributes as $attribute)
          {
            // Check if the attribute exists in the new database
            $a = Attribute::find($attribute);

            if ($a)
            {
              ArtworkAttribute::create([
                'artwork_id' => $artwork->id,
                'attribute_id' => $a->id,
              ]);
            }
            else
            {
              $this->logError('Artwork - [Attribute] ' . $attribute . ' not found for artwork id: ' . $item->OBJEKTE_ID . ' (Artwork: ' . $item->DESCRX . ')');
            }
 
          }
        }

        // Set technique
        if ($item->TECHNIK)
        {
          $technique = ArtworkTechnique::where('description_de', $item->TECHNIK)->first();
          if ($technique)
          {
            $artwork->artwork_technique_id = $technique->id;
            $artwork->save();
          }
          else
          {
            $this->logError('Artwork - [Technique] ' . $item->TECHNIK . ' not found for artwork id: ' . $item->OBJEKTE_ID . ' (Artwork: ' . $item->DESCRX . ')');
          }
          //$artwork->artwork_technique_id = $item->TECHNIK_ID;
        }

        // Set frame
        if ($item->RAHMEN)
        {
          $frame = ArtworkFrame::where('description_de', $item->RAHMEN)->first();
          if ($frame)
          {
            $artwork->artwork_frame_id = $frame->id;
            $artwork->save();
          }
          else
          {
            $this->logError('Artwork - [Frame] ' . $item->RAHMEN . ' not found for artwork id: ' . $item->OBJEKTE_ID . ' (Artwork: ' . $item->DESCRX . ')');
          }
        }

        // Set client
        if ($item->BESITZER_ID)
        {
          $client = Client::find($item->BESITZER_ID);
          if (!$client)
          {
            $this->logError('Artwork - [Client] with id ' . $item->BESITZER_ID . ' not found for artwork id: ' . $item->OBJEKTE_ID . ' (Artwork: ' . $item->DESCRX . ')');
          }
          else
          {
            $artwork->client_id = $item->BESITZER_ID;
            $artwork->save();
          }
        }

        // // Set previous client
        // if ($item->BESITZER_ALT)
        // {
        //   $previous_client = Client::where('lastname', $item->BESITZER_ALT)->orWhere('id', $item->BESITZER_ALT)->first();
        //   if (!$previous_client)
        //   {
        //     $this->logError('Artwork - [Previous client] with id ' . $item->BESITZER_ID . ' not found for artwork id: ' . $item->OBJEKTE_ID . ' (Artwork: ' . $item->DESCRX . ')');
        //   }
        //   else
        //   {
        //     $artwork->previous_client = $previous_client->id;
        //     $artwork->save();
        //   }
        // }

        // Set artist
        if ($item->KUENSTLER_ID)
        {
          $artist = Artist::find($item->KUENSTLER_ID);
          if (!$artist)
          {
            $this->logError('Artwork - [Artist] with id ' . $item->KUENSTLER_ID . ' not found for artwork with id: ' . $item->OBJEKTE_ID . ' (Artwork: ' . $item->DESCRX . ')');
          }
          else
          {
            $artwork->artist_id = $item->KUENSTLER_ID;
            $artwork->save();
          }
        }

        // Handle Additional Fields
        for($i = 1; $i <= 9; $i++)
        {
          if ($item->{'FELD_'.$i})
          {
            $additional_field = ArtworkAdditionalField::create([
              'description' => $item->{'FELD_'.$i} ?? NULL,
              'artwork_id' => $artwork->id,
              'user_id' => 1,
            ]);
          }
        }
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');
  }

  public function logError($message)
  {
    $logFile = storage_path('app/import/logs/import_artwork.txt');

    // create the folder if it doesn't exist
    if (!file_exists(storage_path('app/import/logs')))
    {
      mkdir(storage_path('app/import/logs'), 0777, true);
    }

    // create the file if it doesn't exist
    if (!file_exists($logFile))
    {
      \File::put($logFile, '');
    }

    $logMessage = $message . "\n";
    \File::append($logFile, $logMessage);
  }
}
