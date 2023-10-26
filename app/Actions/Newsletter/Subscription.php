<?php
namespace App\Actions\Newsletter;
use App\Models\NewsletterSubscriber;

class Subscription
{
  public function handle($data = [])
  {
    // Check if the email already exists
    $subscriber = NewsletterSubscriber::withTrashed()->where('email', $data['email'])->first();

    // If the email exists, restore the record
    if ($subscriber->trashed())
    {
      $subscriber->restore();
    }
    else
    {
      // If the email doesn't exist, create a new record
      NewsletterSubscriber::create($data);
    }

  }

  public function store()
  {

  }

  public function restore()
  {

  }

  public function delete()
  {

  }

}