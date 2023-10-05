<?php
namespace App\Console\Commands\User;
use Illuminate\Console\Command;
use App\Models\User;

class CreateAdmin extends Command
{
  protected $signature = 'create:admin';

  protected $description = 'Creates an admin user';

  protected $model = User::class;

  public function __construct()
  {
    parent::__construct();
  }

  public function handle()
  {
    $this->info('Creating admin user...');

    $this->model::create([
      'name' => 'Marcel Stadelmann',
      'email' => 'm@marceli.to',
      'password' => \Hash::make('7aq31rr23'),
      'email_verified_at' => now(),
    ]);

    $this->info('Admin user created!');
  }
}
