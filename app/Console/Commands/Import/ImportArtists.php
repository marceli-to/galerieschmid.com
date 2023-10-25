<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\Artist;
use App\Models\ArtistAddress;

class ImportArtists extends Command
{
  protected $signature = 'import:artists';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_kuenstler.json';

  protected $model = Artist::class;

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
        $artist = $this->model::create([
          'id' => $item->KUENSTLER_ID,
          'salutation' => $item->ANREDE ?? NULL,
          'artist_name' => $item->KUENSTLER_NAME ?? NULL,
          'firstname' => $item->VORNAME ?? NULL,
          'lastname' => $item->NAME ?? NULL,
          'website' => $item->HREF ?? NULL,
          'biography_de' => $item->BIO_TEXT ?? NULL,
          'biography_en' => $item->BIO_TEXT_EN ?? NULL,
          'bank_account' => $item->BANKDATEN ?? NULL,
          'mobile' => $item->NATEL ?? NULL,
          'email' => $item->EMAIL ?? NULL,
          'newsletter_subscriber' => $item->NEWSLETTER_SUBSCRIBE ?? NULL,
          'artist_type_id' => $item->KUENSTLER_TYPE ?? NULL,
          'position' => $item->POS ?? -1,
          'publish' => $item->STATUS,
          'user_id' => 1,
        ]);

        // Handle Files
        if ($item->BIO_PDF)
        {
          // Collection: artist_files
          // The source file is located at /storage/app/import/file_data/kuenstler/{KUENSTLER_ID}/doc
          $pathToFile = storage_path('app/import/file_data/kuenstler/' . $item->KUENSTLER_ID . '/doc/' . $item->BIO_PDF);

          // check if file physically exists
          if (!file_exists($pathToFile))
          {
            $this->logError('Artist - [File BIO] ' . $item->BIO_PDF . ' does not exist for artist with id: ' . $item->KUENSTLER_ID);
          }
          else
          {
            $artist->copyMedia($pathToFile)->toMediaCollection('artist_files');
          }
        }

        // Handle Images
        if ($item->BILD)
        {
          // Collection: artist_portraits
          // The source file is located at /storage/app/import/file_data/kuenstler/{KUENSTLER_ID}/img
          $pathToFile = storage_path('app/import/file_data/kuenstler/' . $item->KUENSTLER_ID . '/img/' . $item->BILD);

          // check if file physically exists
          if (!file_exists($pathToFile))
          {
            $this->logError('Artist - [Image Portrait] ' . $item->BILD . ' does not exist for artist with id: ' . $item->KUENSTLER_ID);
          }
          else
          {
            $artist->copyMedia($pathToFile)->toMediaCollection('artist_portraits');
          }
        }

        // Handle Addresses
        if (
          $item->ADRESSE1_1 ||
          $item->ADRESSE2_1 ||
          $item->STRASSE_1 ||
          $item->POSTFACH_1 ||
          $item->PLZ_1 ||
          $item->ORT_1 ||
          $item->LAND_1 ||
          $item->TELEFON_P_1 ||
          $item->TELEFON_G_1 ||
          $item->FAX_1
        ) {
          $address = ArtistAddress::create([
            'address' => $item->ADRESSE1_1 ?? NULL,
            'address_additional' => $item->ADRESSE2_1 ?? NULL,
            'street' => $item->STRASSE_1 ?? NULL,
            'box' => $item->POSTFACH_1 ?? NULL,
            'zip' => $item->PLZ_1 ?? NULL,
            'city' => $item->ORT_1 ?? NULL,
            'country' => $item->LAND_1 ?? NULL,
            'phone' => $item->TELEFON_P_1 ?? NULL,
            'phone_business' => $item->TELEFON_G_1 ?? NULL,
            'fax' => $item->FAX_1 ?? NULL,
            'artist_id' => $artist->id,
            'user_id' => 1,
          ]);
        }

        if (
          $item->ADRESSE1_2 ||
          $item->ADRESSE2_2 ||
          $item->STRASSE_2 ||
          $item->POSTFACH_2 ||
          $item->PLZ_2 ||
          $item->ORT_2 ||
          $item->LAND_2 ||
          $item->TELEFON_P_2 ||
          $item->TELEFON_G_2 ||
          $item->FAX_2
        ) {
          $address = ArtistAddress::create([
            'address' => $item->ADRESSE1_2 ?? NULL,
            'address_additional' => $item->ADRESSE2_2 ?? NULL,
            'street' => $item->STRASSE_2 ?? NULL,
            'box' => $item->POSTFACH_2 ?? NULL,
            'zip' => $item->PLZ_2 ?? NULL,
            'city' => $item->ORT_2 ?? NULL,
            'country' => $item->LAND_2 ?? NULL,
            'phone' => $item->TELEFON_P_2 ?? NULL,
            'phone_business' => $item->TELEFON_G_2 ?? NULL,
            'fax' => $item->FAX_2 ?? NULL,
            'artist_id' => $artist->id,
            'user_id' => 1,
          ]);
        }

        if (
          $item->ADRESSE1_3 ||
          $item->ADRESSE2_3 ||
          $item->STRASSE_3 ||
          $item->POSTFACH_3 ||
          $item->PLZ_3 ||
          $item->ORT_3 ||
          $item->LAND_3 ||
          $item->TELEFON_P_3 ||
          $item->TELEFON_G_3 ||
          $item->FAX_3
        ) {
          $address = ArtistAddress::create([
            'address' => $item->ADRESSE1_3 ?? NULL,
            'address_additional' => $item->ADRESSE2_3 ?? NULL,
            'street' => $item->STRASSE_3 ?? NULL,
            'box' => $item->POSTFACH_3 ?? NULL,
            'zip' => $item->PLZ_3 ?? NULL,
            'city' => $item->ORT_3 ?? NULL,
            'country' => $item->LAND_3 ?? NULL,
            'phone' => $item->TELEFON_P_3 ?? NULL,
            'phone_business' => $item->TELEFON_G_3 ?? NULL,
            'fax' => $item->FAX_3 ?? NULL,
            'artist_id' => $artist->id,
            'user_id' => 1,
          ]);
        }
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }

  public function logError($message)
  {
    $logFile = storage_path('app/import/logs/import_artist.txt');

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
