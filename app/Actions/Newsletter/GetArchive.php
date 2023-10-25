<?php
namespace App\Actions\Newsletter;
use App\Models\Newsletter;

class GetArchive
{
  public function execute($key = NULL)
  {
    return Newsletter::archive()->get();
  }
}