<?php
namespace App\Actions\Exhibition;
use App\Models\Exhibition;

class GetExhibitionList
{
  public function execute()
  {
    return [
      'current'  => Exhibition::active()->with('artworks')->upcoming()->first(),
      'upcoming' =>Exhibition::active()->with('artworks')->upcoming()->get(),
      'archived' => Exhibition::active()->archived()->with('artworks')->orderBy('date_start', 'DESC')->get()
    ];
  }
}