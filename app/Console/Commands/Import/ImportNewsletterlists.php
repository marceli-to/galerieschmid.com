<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\NewsletterList;

class ImportNewsletterlists extends Command
{
  protected $signature = 'import:newsletterlists';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_newsletter_lists.json';

  protected $model = NewsletterList::class;

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
        $newsletter_article = $this->model::create([
          'id' => $item->id,
          'description' => html_entity_decode($item->description),
          'user_id' => 1,
        ]);
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');
  }
}
