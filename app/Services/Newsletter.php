<?php
namespace App\Services;
use App\Models\Newsletter as NewsletterModel;
use App\Models\NewsletterList as NewsletterListModel;
use App\Models\NewsletterQueue as NewsletterQueueModel;
use App\Models\NewsletterSubscriber as NewsletterSubscriberModel;
use App\Models\NewsletterListNewsletterSubscriber as NewsletterListNewsletterSubscriberModel;
use App\Notifications\Newsletter\Verification;
use Illuminate\Support\Facades\Notification;

class Newsletter
{

  /**
   * Find a newsletter
   * 
   * @param NewsletterModel $newsletter
   * @return NewsletterModel
   */
  
  public function find(NewsletterModel $newsletter): NewsletterModel
  {
    return NewsletterModel::with('articles.media')->find($newsletter->id);
  }

  /**
   * Get all archived newsletters
   * 
   * @param String $type
   * @return \Illuminate\Database\Eloquent\Collection
   */

  public function get($type = NULL): \Illuminate\Database\Eloquent\Collection
  {
    if ($type === 'archive')
    {
      return NewsletterModel::archive()->get();
    }
    return NewsletterModel::get();
  }

  /**
   * Handle subscription
   * 
   * @param Array $data
   * @return NewsletterSubscriberModel
   */
  
  public function subscribe(Array $data = [], $confirm = FALSE): NewsletterSubscriberModel
  {
    // find or create the subscriber
    if ($this->isSubscriber($data['email']))
    {
      $subscriber = $this->findSubscriber($data['email']);
      $subscriber->salutation = $data['salutation'] ?? $subscriber->salutation;
      $subscriber->firstname = $data['firstname'] ?? $subscriber->firstname;
      $subscriber->lastname = $data['lastname'] ?? $subscriber->lastname;
      $subscriber->confirmed_at = $confirm ? now() : NULL;
      $subscriber->save();
      $subscriber->restore();
    }
    else
    {
      $subscriber = NewsletterSubscriberModel::create([
        'salutation' => $data['salutation'] ?? NULL,
        'firstname' => $data['firstname'] ?? NULL,
        'lastname' => $data['lastname'] ?? NULL,
        'email' => $data['email'],
        'hash' => \Str::uuid(),
        'language_id' => 1,
        'confirmed_at' => $confirm ? now() : NULL,
      ]);
    }

    if ($subscriber->confirmed_at)
    {
      $this->addToLists($subscriber);
    }
    else
    {
      $this->sendVerificationNotification($subscriber);
    }
   
    return $subscriber;
  }

  /**
   * Confirm a subscriber
   * 
   * @param NewsletterSubscriberModel $newsletterSubscriber
   * @return void
   */
  
  public function confirm(NewsletterSubscriberModel $newsletterSubscriber): void
  {
    $newsletterSubscriber->confirmed_at = now();
    $newsletterSubscriber->save();
  }

  /** 
   * Unsubscribe a subscriber
   * 
   * @param NewsletterSubscriberModel $newsletterSubscriber
   * @return void
   */
  
  public function unsubscribe(NewsletterSubscriberModel $newsletterSubscriber): void
  {
    foreach ($newsletterSubscriber->newsletterLists as $newsletterList)
    {
      $this->removeFromList($newsletterList, $newsletterSubscriber);
    }
    $newsletterSubscriber->delete();
  }

  /**
   * Add subscribers from a list to the queue
   * 
   * @param NewsletterModel $newsletter
   * @param NewsletterListModel $newsletterList
   * @return array
   */

  public function queue(NewsletterModel $newsletter, NewsletterListModel $newsletterList): array
  {
    // get all subscribers from the list
    $subscribers = $newsletterList->confirmedSubscribers()->get();

    // batch uuid
    $batchUuid = \Str::uuid();

    // loop through the subscribers
    foreach ($subscribers as $subscriber)
    {
      $queue = NewsletterQueueModel::create([
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

  /**
   * Clear the queue
   */

  public function clearQueue(): void
  {
    NewsletterQueueModel::where('processed', 0)->delete();
  }

  /**
   * Check for a subscriber by email
   * 
   * @param String $email
   * @return boolean
   */

  public function isSubscriber($email): bool
  {
    return NewsletterSubscriberModel::withTrashed()->where('email', $email)->exists();
  }

  /**
   * Find a subscriber by email
   * 
   * @param String $email
   * @return NewsletterSubscriberModel
   */

  public function findSubscriber($email): NewsletterSubscriberModel|null
  {
    return NewsletterSubscriberModel::withTrashed()->where('email', $email)->first();
  }

  /**
   * Get all public lists
   * 
   * @return \Illuminate\Database\Eloquent\Collection
   */
  
  public function getLists(): \Illuminate\Database\Eloquent\Collection
  {
    return NewsletterListModel::public()->get();
  }

  /**
   * Add to a list (pivot)
   * 
   * @param NewsletterListModel $newsletterList
   * @param NewsletterSubscriberModel $newsletterSubscriber
   * @return void
   */

  public function addToLists(NewsletterSubscriberModel $newsletterSubscriber): void
  {
    foreach ($this->getLists() as $newsletterList)
    {
      if (!$newsletterList->newsletterSubscribers()->where('subscriber_id', $newsletterSubscriber->id)->exists())
      {
        $newsletterList->newsletterSubscribers()->attach($newsletterSubscriber->id);
      }
    }
  }

  /**
   * Remove from a list (pivot)
   * 
   * @param NewsletterListModel $newsletterList
   * @param NewsletterSubscriberModel $newsletterSubscriber
   * @return void
   */
  
  public function removeFromList(NewsletterListModel $newsletterList, NewsletterSubscriberModel $newsletterSubscriber): void
  {
    if ($newsletterList->newsletterSubscribers()->where('subscriber_id', $newsletterSubscriber->id)->exists())
    {
      $newsletterList->newsletterSubscribers()->detach($newsletterSubscriber->id);
    }
  }
  
  /**
   * Send verification notification
   * @param NewsletterSubscriberModel $newsletterSubscriber
   * @return void
   */
  
  public function sendVerificationNotification(NewsletterSubscriberModel $newsletterSubscriber): void
  {
    Notification::route('mail', $newsletterSubscriber->email)->notify(new Verification($newsletterSubscriber));
  }

  /**
   * Verify a subscriber
   * 
   * @param NewsletterSubscriberModel $newsletterSubscriber
   * @return void
   */

  public function verify(NewsletterSubscriberModel $newsletterSubscriber): void
  {
    $newsletterSubscriber->restore();
    $newsletterSubscriber->confirmed_at = now();
    $newsletterSubscriber->save();
    $this->addToLists($newsletterSubscriber);
  }
}