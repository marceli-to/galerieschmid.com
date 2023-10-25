<?php
namespace App\Actions\Newsletter;
use App\Models\Newsletter;

class GetNewsletter
{
  public function execute(Newsletter $newsletter)
  {
    return Newsletter::with('articles.media')->find($newsletter->id);
  }
}