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
    'import:artwork',
    'import:contentarticle'
    //'import:artworkimages',
  ];

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    // Remove all folders and subfolders in storage_path('app/public')
    $this->info('Remove all folders and subfolders in storage_path("app/public")');
    \File::deleteDirectory(storage_path('app/public'));

    // Remove all log files in storage_path('app/import/logs')
    $this->info('Remove all log files in storage_path("app/import/logs")');
    \File::deleteDirectory(storage_path('app/import/logs'));

    $this->info('Import records started...');
    foreach($this->commands as $command)
    {
      $this->call($command);
    }
    $this->info('Import records ended!');
  }
}
