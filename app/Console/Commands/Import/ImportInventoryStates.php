<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\InventoryState;

class ImportInventoryStates extends Command
{
  protected $signature = 'import:inventorystates';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_reflist_bestandes_status.json';

  protected $model = InventoryState::class;

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

      // Create entry for "unknown"
      $this->model::create([
        'id' => 14,
        'description_de' => 'Unbekannt',
        'description_en' => 'Unbekannt (en)',
        'user_id' => null,
      ]);
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }
}
