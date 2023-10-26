<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\ArtworkExhibition;

class ImportExhibitionArtwork extends Command
{
  protected $signature = 'import:exhibitionartwork';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_ausstellungen_objekte.json';

  protected $model = ArtworkExhibition::class;

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
        $artwork_exhibition = $this->model::create([
          'id' => $item->id,
          'exhibition_id' => $item->fk_ausstellungen_id ?? NULL,
          'artwork_id' => $item->fk_objekte_id ?? NULL,
          'sort' => $item->sort ?? NULL,
        ]);
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }

  public function logError($message)
  {
    $logFile = storage_path('app/import/logs/import_exhibition_artwork.txt');

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
