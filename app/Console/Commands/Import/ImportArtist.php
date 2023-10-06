<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\Artist;

class ImportArtist extends Command
{
  protected $signature = 'import:artist';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_kuenstler.json';

  protected $model = Artist::class;

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
      dd($table->data);
      // foreach($table->data as $item)
      // {
      //   $this->model::create([
      //     'id' => $item->key,
      //     'display_name' => $item->value,
      //     'description' => ['de' => $item->value, 'en' => $item->value . ' (en)'],
      //     'user_id' => null,
      //   ]);
      // }

      // $yourModel->addMedia($pathToFile)->toMediaCollection('images');
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }
}
