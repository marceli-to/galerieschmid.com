<?php
namespace App\Actions\Newsletter;
use App\Models\NewsletterQueue;

class ClearQueue
{
  public function execute()
  {
    NewsletterQueue::query()->delete();
  }
}