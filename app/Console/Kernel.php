<?php
namespace App\Console;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  /**
   * Define the application's command schedule.
   */
  protected function schedule(Schedule $schedule): void
  {
    // $schedule->command('inspire')->hourly();
    // Call artisan command 'import:artworkimages' every 5 minutes
    $schedule->command('import:artworkimages')->everyFiveMinutes();
  }

  /**
   * Register the commands for the application.
   */
  protected function commands(): void
  {
    $this->load(__DIR__.'/Commands');
    require base_path('routes/console.php');
  }
}
