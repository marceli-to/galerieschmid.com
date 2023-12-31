<?php
namespace App\Actions\Exhibition;
use App\Models\Exhibition;

class SearchExhibitions
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
      Exhibition::search($keywords)->get()
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
        'title' => $record->title_de .': '. $record->subtitle_de,
        'url' => route('page.exhibition.show', [
          'slug' => \Str::slug($record->title_de),
          'exhibition' => $record
        ]),
      ];
    }

    return $results;
  }

}