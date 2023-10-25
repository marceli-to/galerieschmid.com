<?php
namespace App\Actions\Content;
use App\Models\ContentArticle;

class GetItem
{
  public function execute($key = NULL)
  {
    return ContentArticle::where('key', $key)->first();
  }
}