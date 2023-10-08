<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\ArtworkState;

class ImportObjectStates extends Command
{
  protected $signature = 'import:objectstates';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_reflist_objekt_status.json';

  protected $model = ArtworkState::class;

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
        $this->model::create([
          'id' => $item->key,
          'description_de' => $item->value,
          'description_en' => $item->value . ' (en)',
          'user_id' => null,
        ]);
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }
}
