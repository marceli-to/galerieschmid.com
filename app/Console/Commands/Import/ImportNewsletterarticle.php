<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\NewsletterArticle;

class ImportNewsletterarticle extends Command
{
  protected $signature = 'import:newsletterarticle';

  protected $description = 'Imports and maps data from the old database to the new database';

  protected $file = 'tbl_newsletter_articles.json';

  protected $model = NewsletterArticle::class;

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


        // +"id": "85"
        // +"title": "#2 Carolyn Heer - K&uuml;nstlerap&eacute;ro"
        // +"body": "<p style="margin: 0px 0px 16px 0px; line-height: 20px;">Bald ist es soweit. Am Donnerstag, 20. April 2017 um <strong>18.00h</strong> startet die zweite Ausstellung in der neuen Galerie Schmid in Zug. Lernen Sie die K&uuml;nstlerin bei einem Glas Champagner kennen und lassen Sie sich begeistern von ihrem eindr&uuml;cklichen Schaffen.</p>"
        // +"imagePath": "http://www.galerieschmid.com/_newsletter/media/Titelbild_Einladung_DL.jpg"
        // +"sortIndex": "1"
        // +"newsletterId": "30"

        // 'id',
        // 'title',
        // 'text',
        // 'position',
        // 'user_id',

        // newsletter_articles

        if ($item->newsletterId >= 30)
        {
          $newsletter_article = $this->model::create([
            'id' => $item->id,
            'title' => html_entity_decode($item->title),
            'text' => html_entity_decode($item->body),
            'position' => $item->sortIndex,
            'newsletter_id' => $item->newsletterId,
            'user_id' => 1,
          ]);

          // Handle Images
          if ($item->imagePath)
          {
            // Remove http://www.galerieschmid.com/_newsletter/media/ from imagePath
            $image = str_replace(['http://www.galerieschmid.com/_newsletter/media/', 'https://www.galerieschmid.com/_newsletter/media/'], [], $item->imagePath);

            // The source file is located at /storage/app/import/file_data/newsletter/$image
            $pathToFile = storage_path('app/import/file_data/newsletter/' . $image); 


            // check if file physically exists
            if (!file_exists($pathToFile))
            {
              $this->logError('Newsletter Article - [Image] ' . $pathToFile . ' does not exist for newsletter article with id: ' . $newsletter_article->id);
            }
            else
            {
              $newsletter_article->copyMedia($pathToFile)->toMediaCollection('newsletter_articles');
            }
          }
        }
      }
    }

    $this->info('Import of file '.$this->file .' ended. A total of '. $this->model::count() .' records were imported.');
  }

  public function logError($message)
  {
    $logFile = storage_path('app/import/logs/import_newsletter_article.txt');

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
