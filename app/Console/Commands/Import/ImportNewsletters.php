<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\Newsletter;

class ImportNewsletters extends Command
{
  protected $signature = 'import:newsletter';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_newsletters.json';

  protected $model = Newsletter::class;

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
        if ($item->id >= 30)
        {
          $newsletter = $this->model::create([
            'id' => $item->id,
            'title' => html_entity_decode($item->title),
            'created_at' => date('Y-m-d H:i:s', $item->dateCreate),
            'active' => $item->isActive ?? 0,
            'show_in_archive' => $item->showInArchive ?? 0,
            'language_id' => $item->languageId ?? NULL,
            'user_id' => 1,
          ]);
        }
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');
  }
}
