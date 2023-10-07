<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;

class ImportRecords extends Command
{
  protected $signature = 'import:records';

  protected $description = 'Calls all import commands to import data from the old database to the new database';

  protected $commands = [
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
