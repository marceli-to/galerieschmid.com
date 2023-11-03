<?php
namespace App\Actions\Content;
use App\Models\TeamMember;

class GetTeam
{
  public function execute($key = NULL)
  {
    return TeamMember::orderBy('position', 'asc')->get();
  }
}