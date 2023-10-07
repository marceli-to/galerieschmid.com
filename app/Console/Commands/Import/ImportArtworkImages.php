<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\Artwork;
use App\Models\Artist;

class ImportArtworkImages extends Command
{
  protected $signature = 'import:artworkimages';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_objekte.json';

  protected $model = Artwork::class;

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // Ask for start
    // $start = $this->ask('From which artwork do you want to start?');

    // // Ask for limit
    // $limit = $this->ask('How many artworks do you want to import?');




    $this->info('Update of file '. $this->file .' started...');
    
    // Read contents of $file located at /storage/app/import
    $json = \File::get(storage_path('app/import/' . $this->file));

    // Parse json
    $data = json_decode($json);

    // Find item with "type = table"
    $table = collect($data)->where('type', 'table')->first();
    dd($table->data[37]);

    if ($table->data)
    {
      foreach($table->data as $item)
      {
        // Handle iages
        $artwork = $this->model::find($item->OBJEKTE_ID);
        
        if ($item->BILD)
        {
          $pathToFile = storage_path('app/import/file_data/objekte/' . $item->OBJEKTE_ID . '/img/' . $item->BILD);
          if (!file_exists($pathToFile))
          {
            $this->logError('Artwork - [File] ' . $item->BILD . ' does not exist for object with id: ' . $item->OBJEKTE_ID);
          }
          else
          {
            $artwork->copyMedia($pathToFile)->toMediaCollection('artwork_images');
          }
        }
      }
    }

    $this->info('Update of file '.$this->file .' ended.');
  }

  public function logError($message)
  {
    $logFile = storage_path('app/import/logs/import_artwork_images.txt');

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
