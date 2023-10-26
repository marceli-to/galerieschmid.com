<?php
namespace App\Actions\Artist;
use App\Models\Artist;

class GetArtistList
{
  public function execute()
  {
    return Artist::published()->with('artworksActive')->orderBy('position')->get();
  }
}