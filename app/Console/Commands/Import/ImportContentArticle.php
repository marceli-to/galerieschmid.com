<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\ContentArticle;

class ImportContentArticle extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'import:contentarticle';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Import content articles from external source';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    ContentArticle::create([
      'key' => 'about_gallery',
      'title_de' => 'Die Galerie',
      'text_de' => '<p>Die Galerie Schmid eröffnete im März 2017 ihre Tore. In wechselnden Ausstellungen zeigt die Galerie nationale und internationale Künstler aus ihrem eigenen Programm. In den frisch renovierten Ausstellungsräumlichkeiten werden auf 100m2  Objekte und Bilder ausgestellt, die zum Ziel haben, Sammler wie auch Freunde der Kunst zu begeistern.</p><p>Die Galerie Schmid bietet zudem ein umfassendes Angebot an Einrahmungen an.</p><p>Kommen Sie vorbei und geniessen Sie etwas Ruhe bei uns in der Ausstellung.</p>',
      'title_en' => null,
      'text_en' => null,
      'user_id' => 1,
    ]);

    ContentArticle::create([
      'key' => 'about_team',
      'title_de' => 'Das Team',
      'text_de' => '<p>Barbara Bachmann<br>Stefan Schmid</p>',
      'title_en' => null,
      'text_en' => null,
      'user_id' => 1,
    ]);

    ContentArticle::create([
      'key' => 'opening_hours',
      'title_de' => 'Öffnungszeiten',
      'text_de' => '<p>Do & Fr 11.00 - 16.00 Uhr<br>Sa 11.00 - 16.00 Uhr<br>So - Mi nach Vereinbarung</p>',
      'title_en' => null,
      'text_en' => null,
      'user_id' => 1,
    ]);
  }
}
