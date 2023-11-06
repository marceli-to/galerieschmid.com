<?php
namespace App\Actions\Artist;
use App\Models\Artist;

class SearchArtists
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
      Artist::search($keywords)->get()
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
        'title' => "{$record->fullname}",
        'url' => route('page.artist.show', [
          'slug' => \Str::slug($record->fullname),
          'artist' => $record,
        ]),
      ];
    }
    return $results;
  }

}