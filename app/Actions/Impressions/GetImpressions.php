<?php
namespace App\Actions\Impressions;
use App\Models\Impression;

class GetImpressions
{
  public function execute()
  {
    return Impression::published()->orderBy('position')->get();
  }
}