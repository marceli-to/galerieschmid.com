<?php
namespace App\Actions\Artist;
use App\Models\Artist;

class GetArtist
{
  public function execute(Artist $artist)
  {
    return Artist::with('publications', 'artwork.artworkTechnique', 'artwork.artworkFrame')->find($artist->id);
  }
}