<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\ArtworkFrame;

class ImportObjectFrames extends Command
{
  protected $signature = 'import:objectframes';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_objekte_rahmen.json';

  protected $model = ArtworkFrame::class;

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
        if ($item->RAHMEN == '') continue;
        $this->model::create([
          'description_de' => $item->RAHMEN,
          'description_en' => $item->RAHMEN . ' (en)',
          'user_id' => null,
        ]);
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }
}
