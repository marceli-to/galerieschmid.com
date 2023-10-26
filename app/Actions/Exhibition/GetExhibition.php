<?php
namespace App\Actions\Exhibition;
use App\Models\Exhibition;

class GetExhibition
{
  public function execute(Exhibition $exhibition)
  {
    return Exhibition::with('artworks.artworkTechnique', 'artworks.artworkFrame')->find($exhibition->id);
  }
}