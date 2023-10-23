<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\NewsletterListNewsletterSubscriber;
use App\Models\NewsletterList;
use App\Models\NewsletterSubscriber;

class ImportNewsletterListSubscribers extends Command
{
  protected $signature = 'import:newsletterlistsubscribers';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_newsletter_lists_subscribers.json';

  protected $model = NewsletterListNewsletterSubscriber::class;

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

        // make sure the list and the subscriber exist
        $newsletterList = NewsletterList::find($item->listId);
        $newsletterSubscriber = NewsletterSubscriber::find($item->subscriberId);

        if (!$newsletterList)
        {
          $this->logError('Newsletter List with ID ' . $item->listId . ' not found for subscriber id: ' . $item->subscriberId);
          continue;
        }
        else if (!$newsletterSubscriber)
        {
          $this->logError('Newsletter Subscriber with ID ' . $item->subscriberId . ' not found for list id: ' . $item->listId);
          continue;
        }

        $newsletterListNewsletterSubscriber =$this->model::create([
          'list_id' => $item->listId,
          'subscriber_id' => $item->subscriberId,
        ]);
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');
  }

  public function logError($message)
  {
    $logFile = storage_path('app/import/logs/import_newsletter_list_subscribers.txt');

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
