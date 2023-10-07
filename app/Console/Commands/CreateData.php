<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;

class CreateData extends Command
{
  protected $signature = 'create:data';

  protected $description = 'Runs migrations, creates and admin user and calls all import commands to import data from the old database to the new database';

  protected $commands = [
    'migrate:fresh',
    'create:admin',
    'import:inventorystates',
    'import:artisttypes',
    'import:vattypes',
    'import:objectframes',
    'import:objecttechnique',
    'import:objectstates',
    'import:artists',
    'import:clients',
    'import:artistpublications',
  ];

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $this->info('Import records started...');
    foreach($this->commands as $command)
    {
      $this->call($command);
    }
    $this->info('Import records ended!');
  }
}
