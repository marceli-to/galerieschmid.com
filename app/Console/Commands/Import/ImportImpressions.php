<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Impression;

class ImportImpressions extends Command
{
  protected $signature = 'import:impressions';

  protected $description = 'Import images from directory and create impressions';

  public function handle()
  {
    $directory = storage_path('app/import/file_data/ueber_uns');
    $files = glob($directory . '/*.jpg');
    $i = 1;

    foreach ($files as $file)
    {
      $impression = new Impression([
        'position' => $i,
        'publish' => 1,
        'user_id' => 1,
      ]);
      $impression->save();
      $media = $impression->copyMedia($file)->toMediaCollection('impressions');
      $this->info("Imported image: {$media->file_name}");
      $i++;
    }
    $this->info('Import completed!');
  }
}
