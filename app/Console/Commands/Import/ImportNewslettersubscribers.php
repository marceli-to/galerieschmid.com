<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\NewsletterSubscriber;
use App\Enums\Salutation;

class ImportNewslettersubscribers extends Command
{
  protected $signature = 'import:newslettersubscribers';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_newsletter_subscribers.json';

  protected $model = NewsletterSubscriber::class;

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
        $newsletter_subscriber = $this->model::create([
          'id' => $item->id,
          'firstname' => $item->firstname,
          'lastname' => $item->lastname,
          // generate random email address
          'email' => \Str::random(8).'@'.\Str::random(6) . '.com',
          // 'email' => $item->email,
          'hash' => \Str::uuid(),

          // get salutation from enum
          'salutation' => match ($item->genderId) {
            '0' => Salutation::UNBEKANNT,
            '1' => Salutation::HERR,
            '2' => Salutation::FRAU,
            '3' => Salutation::UNBEKANNT,
          },
          'language_id' => $item->languageId,
          'confirmed_at' => date('Y-m-d H:i:s', $item->dateConfirmation),
          'created_at' => date('Y-m-d H:i:s', $item->dateCreate),
          'user_id' => 1,
        ]);
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');
  }
}
