<?php
namespace App\Actions\Newsletter;
use App\Models\NewsletterQueue;

class ClearQueue
{
  public function execute()
  {
    NewsletterQueue::where('processed', 0)->delete();
  }
}