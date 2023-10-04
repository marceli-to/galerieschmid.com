<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\InventoryState;

class ImportInventoryStates extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'import:inventorystates';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_reflist_bestandes_status.json';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
      parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $this->info('Import of file '.$this->file .' started:');
    
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
        InventoryState::create([
          'id' => $item->key,
          'description_de' => $item->value,
          'description_en' => NULL,
        ]);
      }
    }

    // Get the count of all records from VatType Model
    $count = InventoryState::count();

    $this->info('Import of file '.$this->file .' ended. A total of '.$count.' records were imported.');

  }
}
