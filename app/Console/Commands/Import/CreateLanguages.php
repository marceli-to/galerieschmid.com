<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\NewsletterLanguage;

class CreateLanguages extends Command
{
  protected $signature = 'create:languages';

  protected $description = 'Creates languages for the newsletter';

  protected $model = NewsletterLanguage::class;

  public function handle()
  {
    // create languages for newsletter
    // de, fr, it and en

    $this->model::create([
      'acronym' => 'de',
      'description' => 'Deutsch',
      'user_id' => 1,
    ]);

    $this->model::create([
      'acronym' => 'en',
      'description' => 'Englisch',
      'user_id' => 1,
    ]);

    $this->model::create([
      'acronym' => 'fr',
      'description' => 'Französisch',
      'user_id' => 1,
    ]);

    $this->model::create([
      'acronym' => 'it',
      'description' => 'Italienisch',
      'user_id' => 1,
    ]);

  }
}
