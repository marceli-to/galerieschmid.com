<?php
namespace App\Console\Commands\Import;
use Illuminate\Console\Command;
use App\Models\TeamMember;

class ImportTeam extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'import:team';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Import team';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    TeamMember::create([
      'firstname' => 'Stefan',
      'lastname' => 'Schmid',
      'email' => 'info@gap-art.ch',
      'position' => 0,
      'user_id' => 1,
    ]);

    TeamMember::create([
      'firstname' => 'Barbara',
      'lastname' => 'Bachmann',
      'position' => 1,
      'user_id' => 1,
    ]);
  }
}
