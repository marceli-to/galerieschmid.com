<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\ClientAdditionalField;

class ImportClients extends Command
{
  protected $signature = 'import:clients';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_kunden.json';

  protected $model = Client::class;

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
        $client = $this->model::create([
          'id' => $item->ADRESS_ID,
          'salutation' => $item->ANREDE ?? NULL,
          'alfa' => $item->ALFA ?? NULL,
          'firstname' => $item->VORNAME ?? NULL,
          'lastname' => $item->NAME ?? NULL,
          'website' => $item->HREF ?? NULL,
          'mobile' => $item->NATEL ?? NULL,
          'email' => $item->EMAIL ?? NULL,
          'newsletter_subscriber' => $item->NEWSLETTER_SUBSCRIBE ?? 0,
          'active' => $item->STATUS,
          'gallery' => $item->GALERIE == 2 ? 'gap' : 'eule',
          'artist' => $item->KUENSTLER ?? NULL,
          'language' => $item->LANG ?? NULL,
          'letter_salutation' => $item->BRIEFANREDE ?? NULL,
          'invitations' => $item->EINLADUNGEN ?? NULL,
          'remarks' => $item->REMARK ?? NULL,
          'user_id' => 1,
        ]);

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
          $address = ClientAddress::create([
            'address' => $item->ADRESSE1_1 ?? NULL,
            'address_additional' => $item->ADRESSE2_1 ?? NULL,
            'street' => $item->STRASSE_1 ?? NULL,
            'box' => $item->POSTFACH_1 ?? NULL,
            'zip' => $item->PLZ_1 ?? NULL,
            'city' => $item->ORT_1 ?? NULL,
            'state' => $item->STATE_1 ?? NULL,
            'country' => $item->LAND_1 ?? NULL,
            'phone' => $item->TELEFON_P_1 ?? NULL,
            'phone_business' => $item->TELEFON_G_1 ?? NULL,
            'fax' => $item->FAX_1 ?? NULL,
            'primary' => 1,
            'client_id' => $client->id,
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
          $address = ClientAddress::create([
            'address' => $item->ADRESSE1_2 ?? NULL,
            'address_additional' => $item->ADRESSE2_2 ?? NULL,
            'street' => $item->STRASSE_2 ?? NULL,
            'box' => $item->POSTFACH_2 ?? NULL,
            'zip' => $item->PLZ_2 ?? NULL,
            'city' => $item->ORT_2 ?? NULL,
            'state' => $item->STATE_2 ?? NULL,
            'country' => $item->LAND_2 ?? NULL,
            'phone' => $item->TELEFON_P_2 ?? NULL,
            'phone_business' => $item->TELEFON_G_2 ?? NULL,
            'fax' => $item->FAX_2 ?? NULL,
            'client_id' => $client->id,
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
          $address = ClientAddress::create([
            'address' => $item->ADRESSE1_3 ?? NULL,
            'address_additional' => $item->ADRESSE2_3 ?? NULL,
            'street' => $item->STRASSE_3 ?? NULL,
            'box' => $item->POSTFACH_3 ?? NULL,
            'zip' => $item->PLZ_3 ?? NULL,
            'city' => $item->ORT_3 ?? NULL,
            'state' => $item->STATE_3 ?? NULL,
            'country' => $item->LAND_3 ?? NULL,
            'phone' => $item->TELEFON_P_3 ?? NULL,
            'phone_business' => $item->TELEFON_G_3 ?? NULL,
            'fax' => $item->FAX_3 ?? NULL,
            'client_id' => $client->id,
            'user_id' => 1,
          ]);
        }

        // Handle Additional Fields
        for($i = 1; $i <= 9; $i++)
        {
          if ($item->{'FELD_'.$i})
          {
            $additional_field = ClientAdditionalField::create([
              'description' => $item->{'FELD_'.$i} ?? NULL,
              'client_id' => $client->id,
              'user_id' => 1,
            ]);
          }
        }
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }
}
