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
      'key' => 'contact_opening_hours',
      'title_de' => 'Öffnungszeiten',
      'text_de' => '<p>Die Galerie ist vom 09. Oktober 2023 bis anfangs Dezember 2023 wegen Sanierung der Liegenschaft am Bundesplatz 14 geschlossen.</p><p>The gallery is closed from 09. Oktober 2023 until begining of december 2023 due to renovation of the building Bundesplatz 14.</p><p>Kontakt:  info@galerieschmid.com / Stefan Schmid</p>',
      'title_en' => null,
      'text_en' => null,
      'user_id' => 1,
    ]);

    ContentArticle::create([
      'key' => 'contact_address',
      'title_de' => 'Adresse',
      'text_de' => '<p>Galerie Schmid<br>GAP ART AG<br>Bundesplatz 14<br>6300 Zug</p><p>T + 41  (0)41 711 08 02<br>M  +41 (0)79 784 71 49<br>info@galerieschmid.com<br>www.galerieschmid.com</p><p>Der Eingang zur Galerie befindet sich in der Gotthardstrasse - hinter dem Bundesplatz.</p>',
      'title_en' => null,
      'text_en' => null,
      'user_id' => 1,
    ]);
  }
}
