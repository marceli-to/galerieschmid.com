<?php
namespace App\Actions\Newsletter;
use App\Models\Newsletter;
use App\Models\NewsletterList;
use App\Models\NewsletterQueue;
use App\Models\NewsletterListNewsletterSubscriber;

class AddListSubscribersToQueue
{
  public function execute(Newsletter $newsletter, NewsletterList $newsletterList)
  {
    // get all subscribers from the list
    $subscribers = $newsletterList->confirmedSubscribers()->get();

    // batch uuid
    $batchUuid = \Str::uuid();

    // loop through the subscribers
    foreach ($subscribers as $subscriber)
    {
      $queue = NewsletterQueue::create([
        'batch' => $batchUuid,
        'email' => $subscriber->email,
        'newsletter_id' => $newsletter->id,
        'newsletter_list_id' => $newsletterList->id,
        'newsletter_subscriber_id' => $subscriber->id,
      ]);
    }

    return [
      'description' => $newsletterList->description,
      'subscribers' => $subscribers->count(),
    ];
  }
}