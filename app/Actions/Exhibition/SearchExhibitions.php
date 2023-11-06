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
    // Perform a Scout search for each keyword
    $records = Exhibition::search($keywords)
      ->where('active', 1)
      ->get();
    return $this->formattedResults($records, $keywords);
  }

  /**
   * Format the results
   * 
   * @param \Illuminate\Database\Eloquent\Collection $records
   * @param String $keywords
   * @return array
   */

  private function formattedResults($records, $keywords)
  {
    $results = [];

    foreach ($records as $record)
    {
      $title = $record->title_de . ': ' . $record->subtitle_de;
      $text = $record->text_de;

      // Find all occurrences of the keyword in the title and text
      $titleMatches = $this->findMatches($title, $keywords);
      $textMatches = $this->findMatches($text, $keywords);

      // Create a snippet for each match
      // $snippets = array_merge($titleMatches, $textMatches);
      // $snippets = array_unique($snippets);
      $snippets = $textMatches;
      $snippets = array_map(function ($match) use ($text) {
        $start = max(0, strpos($text, $match) - 25);
        $end = strpos($text, $match) + strlen($match) + 45;
        return substr($text, $start, $end - $start);
      }, $snippets);

      // Highlight the keyword in the title
      $title = preg_replace("/($keywords)/i", "<em>$1</em>", $title);

      // Highlight the keyword in each snippet
      $snippets = array_map(function ($snippet) use ($keywords) {
        return preg_replace("/($keywords)/i", "<em>$1</em>", $snippet);
      }, $snippets);


      // Add the result to the array
      $result = [
        'title' => $title,
        //'text' => collect($snippets)->first(),
        'url' => route('page.exhibition.show', ['slug' => \Str::slug($record->title_de), 'exhibition' => $record->id]),
      ];

      $results[] = collect($result);
    }

    return collect($results);
  }

  /**
   * Find all occurrences of a keyword in a string
   * 
   * @param String $string
   * @param String $keyword
   * @return array
   */

  private function findMatches($string, $keyword)
  {
    $matches = [];
    $pos = 0;

    while (($pos = stripos($string, $keyword, $pos)) !== false)
    {
      $matches[] = $keyword;
      $pos += strlen($keyword);
    }

    return $matches;
  }
}