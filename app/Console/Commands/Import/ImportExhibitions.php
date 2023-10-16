<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\Exhibition;

class ImportExhibitions extends Command
{
  protected $signature = 'import:exhibitions';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_ausstellungen.json';

  protected $model = Exhibition::class;

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
        $exhibition = $this->model::create([
          'id' => $item->AUSSTELLUNGEN_ID,
          'title_de' => $item->TITEL ?? NULL,
          'title_en' => $item->TITEL_EN ?? NULL,
          'subtitle_de' => $item->SUBTITEL ?? NULL,
          'subtitle_en' => $item->SUBTITEL_EN ?? NULL,
          'summary_de' => $item->ZUSAMMENFASSUNG ?? NULL,
          'summary_en' => $item->ZUSAMMENFASSUNG_EN ?? NULL,
          'text_de' => $item->TEXT ?? NULL,
          'text_en' => $item->TEXT_EN ?? NULL,
          'keywords_de' => $item->KEYWORDS ?? NULL,
          'keywords_en' => $item->KEYWORDS_EN ?? NULL,
          'date_start' => $item->DATUM_VON && $item->DATUM_VON > 0 && $item->DATUM_VON <= now() ? date('Y-m-d', $item->DATUM_VON) : null,
          'date_end' => $item->DATUM_BIS && $item->DATUM_BIS > 0 && $item->DATUM_BIS <= now() ? date('Y-m-d', $item->DATUM_BIS) : null,
          'date_show_from' => $item->DATUM_START_WEB && $item->DATUM_START_WEB > 0 && $item->DATUM_START_WEB <= now() ? date('Y-m-d', $item->DATUM_START_WEB) : null,
          'date_show_to' => $item->DATUM_STOP_WEB && $item->DATUM_STOP_WEB > 0 && $item->DATUM_STOP_WEB <= now() ? date('Y-m-d', $item->DATUM_STOP_WEB) : null,
          'active' => $item->STATUS ?? NULL,
          'user_id' => 1,
        ]);
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');

  }

  public function logError($message)
  {
    $logFile = storage_path('app/import/logs/import_exhibition.txt');

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
