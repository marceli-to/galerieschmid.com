<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\Artist;
use App\Models\ArtistPublication;

class ImportArtistPublications extends Command
{
  protected $signature = 'import:artistpublications';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_publikationen.json';

  protected $model = ArtistPublication::class;

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
        
        // Check if artist exists
        $artist = Artist::find($item->KUENSTLER_ID);
        if (!$artist)
        {
          $this->info('Artist with ID ' . $item->KUENSTLER_ID . ' does not exist.');
          continue;
        }

        $publication = $this->model::create([
          'title_de' => $item->TITEL,
          'title_en' => $item->TITEL_EN ?? null,
          'text_de' => $item->TEXT ?? null,
          'text_en' => $item->TEXT_EN ?? null,
          'artist_id' => $item->KUENSTLER_ID,
          'user_id' => 1,
        ]);

        // Handle Images/Files
        if ($item->FILE)
        {
          // Collection: artist_portraits
          // The source file is located at /storage/app/import/file_data/kuenstler/{KUENSTLER_ID}/img
          $pathToFile = storage_path('app/import/file_data/kuenstler/' . $item->KUENSTLER_ID . '/doc/' . $item->FILE);

          // check if file physically exists
          if (!file_exists($pathToFile))
          {
            $this->info('File ' . $pathToFile . ' does not exist.');
          }
          else
          {
            $publication->copyMedia($pathToFile)->toMediaCollection('artist_publications');
          }
        }
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }
}
