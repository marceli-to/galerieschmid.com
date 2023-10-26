<?php
namespace App\Services;
use App\Models\Newsletter as NewsletterModel;
use App\Models\NewsletterList as NewsletterListModel;
use App\Models\NewsletterQueue as NewsletterQueueModel;
use App\Models\NewsletterSubscriber as NewsletterSubscriberModel;
use App\Models\NewsletterListNewsletterSubscriber as NewsletterListNewsletterSubscriberModel;

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
      NewsletterModel::archive()->get();
    }
    return NewsletterModel::get();
  }

  /**
   * Handle subscription
   * 
   * @param Array $data
   * @return NewsletterSubscriberModel
   */
  
  public function subscribe(Array $data = []): NewsletterSubscriberModel
  {
    // find or create the subscriber
    if ($this->isSubscriber($data['email']))
    {
      $subscriber = $this->findSubscriber($data['email']);
      $subscriber->firstname = $data['firstname'];
      $subscriber->lastname = $data['lastname'];
      $subscriber->restore();

      // Add to list if confirmed
      if ($subscriber->confirmed_at)
      {
        $this->addToLists($subscriber);
      }
      else
      {
        // @todo: send confirmation email
      }
    }
    else
    {
      $subscriber = NewsletterSubscriberModel::create([
        'firstname' => $data['firstname'],
        'lastname' => $data['lastname'],
        'email' => $data['email'],
        'language_id' => 1,
      ]);
      // @todo: send confirmation email
    }
   
    return $subscriber;
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

  public function findSubscriber($email): NewsletterSubscriberModel
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
  
}