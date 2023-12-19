<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;

class CreateNewsletter extends Command
{
  protected $signature = 'create:newsletter';

  protected $description = 'Calls all import commands to import data from the old database to the new database';

  protected $commands = [
    'import:newsletter',
    'import:newsletterarticle',
    'import:newsletterlists',
    'import:newslettersubscribers',
    'import:newsletterlistsubscribers',
  ];

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $this->info('Import of newsletter records started...');
    foreach($this->commands as $command)
    {
      $this->call($command);
    }
    $this->info('Import of newsletter records ended!');
  }
}
