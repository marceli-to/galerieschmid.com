<?php
namespace App\Console\Commands\Newsletter;
use Illuminate\Console\Command;
use App\Models\NewsletterQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Newsletter;

class NewsletterSend extends Command
{
  protected $signature = 'newsletter:send';

  protected $description = 'Initiates the newsletter sending process';

  protected $model = NewsletterQueue::class;

  public function handle()
  {
    $queueItems = NewsletterQueue::with('newsletter.articles', 'subscriber')->unprocessed()->get();
    $queueItems = collect($queueItems)->splice(0,1);

    foreach($queueItems->all() as $queueItem)
    {
      $recipient = env('MAIL_TO');
      if ((app()->environment() == 'production') && $queueItem->email)
      {
        $recipient = $queueItem->email;
      }
      
      try
      {
        Notification::route('mail', $recipient)->notify(new Newsletter($queueItem->newsletter, $queueItem->subscriber));
        $queueItem->processed = 1;
        $queueItem->processed_at = now();
        $queueItem->save();
      }
      catch(\Throwable $e)
      {
        \Log::error($e);
        $queueItem->errors = $e;
        $queueItem->processed = 1;
        $queueItem->processed_at = now();
        $queueItem->save();
      }
    }
  }
}
