<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\ArtworkTechnique;

class ImportObjectTechnique extends Command
{
  protected $signature = 'import:objecttechnique';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_objekte_technik.json';

  protected $model = ArtworkTechnique::class;

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
        if ($item->TECHNIK == '') continue;
        $this->model::create([
          'description_de' => $item->TECHNIK,
          'description_en' => $item->TECHNIK . ' (en)',
          'user_id' => null,
        ]);
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }
}
