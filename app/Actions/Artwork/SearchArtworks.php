<?php
namespace App\Actions\Artwork;
use App\Models\Artwork;
use App\Models\Artist;

class SearchArtworks
{
  /**
   * Search for exhibitions
   * 
   * @param String $keywords
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function execute(String $keywords)
  {
    return $this->results(
      Artwork::search($keywords)->get()
    );
  }

  /**
   * Format the results
   * 
   * @param \Illuminate\Database\Eloquent\Collection $records
   * @return array
   */

  private function results($records)
  {
    $results = [];
    foreach($records as $record)
    {
      $results[] = [
        'title' => "{$record->description_de}: {$record->artist->fullname}",
        'url' => route('page.artist.works', [
          'slug' => \Str::slug($record->artist->fullname),
          'artist' => $record->artist,
          'index' => $this->getArtworkIndex($record->artist, $record)
        ]),
      ];
    }
    return $results;
  }

  /**
   * Get the index of the artwork
   * 
   * @param Artist $artist
   * @param Artwork $artwork
   * @return int
   */
  private function getArtworkIndex(Artist $artist, Artwork $artwork)
  {
    $artworks = Artist::with('artworksActive')->find($artist->id);

    // filter out artworks without media
    $artworks->artworksActive = $artworks->artworksActive->filter(function($artwork) {
      return $artwork->media->first() !== null;
    });

    $index = 0;

    foreach($artworks->artworksActive as $key => $value)
    {
      if($value->id === $artwork->id)
      {
        return $index;
      }
      $index++;
    }
  }

}