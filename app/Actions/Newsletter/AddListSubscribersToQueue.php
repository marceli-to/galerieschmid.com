<?php
namespace App\Actions\Newsletter;
use App\Models\NewsletterList;

class AddListSubscribersToQueue
{
  public function execute(NewsletterList $newsletterList)
  {
    // dd($newsletterList);
    return [
      'description' => $newsletterList->description,
      'subscribers' => 112
    ];
  }
}