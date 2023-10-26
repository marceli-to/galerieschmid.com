<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\Artwork;
use App\Models\Artist;

class ImportArtworkImages extends Command
{
  protected $signature = 'import:artworkimages';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $model = Artwork::class;

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $this->info('Artwork image update started...');

    $artworks = $this->model::where('image', '!=', null)->limit(700)->get();

    // allowed mime types
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
    if ($artworks)
    {
      foreach($artworks as $artwork)
      { 
        // get the mime type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        if ($artwork->image)
        {
          $this->info('Start with image ' . $artwork->image);
          $pathToFile = storage_path('app/import/file_data/objekte/' . $artwork->id . '/img/' . $artwork->image);

          // check import folder too
          if (!file_exists($pathToFile))
          {
            $pathToFile = storage_path('app/import/file_data/objekte_import/' . $artwork->image);
          }
    
          if (!file_exists($pathToFile))
          {
            $this->logError('Artwork - [File] ' . $artwork->image . ' does not exist for object with id: ' . $artwork->id);
          }
          else
          {
            // get the mime type of the file
            $mimeType = finfo_file($finfo, $pathToFile);

            if (!in_array($mimeType, $allowedMimeTypes))
            {
              $this->logError('Artwork - [File, Mimetype] ' . $artwork->image . ' has an invalid mimetype ('.$mimeType.') for object with id: ' . $artwork->id);
            }
            else
            {
              $artwork->copyMedia($pathToFile)->toMediaCollection('artwork_images');
              $this->info('Copied image ' . $artwork->image);
            }
          }

          $artwork->image = NULL;
          $artwork->save();
          $this->info('Set image to NULL ' . $artwork->image);
        }
      }
    }

    $this->info('Artwork image update ended.');
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
