<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Spatie\Translatable\Facades\Translatable;

class AppServiceProvider extends ServiceProvider
{
  public function register(): void
  {
  }

  public function boot(): void
  {
    Translatable::fallback(
      fallbackLocale: 'en',
    );

    setLocale(LC_ALL, 'de_CH.utf8');
    setlocale (LC_TIME, 'de_CH.utf8');
    \Carbon\Carbon::setLocale('de_CH.utf8');

    // Set global mailto address
    if ($this->app->environment('local') || $this->app->environment('staging'))
    {
      Mail::alwaysTo(env('MAIL_TO'));
    }
  }
}
