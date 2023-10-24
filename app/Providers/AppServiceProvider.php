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

    // Set global mailto address
    if ($this->app->environment('local') || $this->app->environment('staging'))
    {
      Mail::alwaysTo(env('MAIL_TO'));
    }
  }
}
