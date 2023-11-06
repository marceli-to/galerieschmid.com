<?php
namespace App\Http\Controllers;
use App\Actions\Exhibition\SearchExhibitions;
use App\Actions\Artwork\SearchArtworks;
use App\Actions\Artist\SearchArtists;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  /**
   * Shows the search page
   * 
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  { 
    $exhibitions = (new SearchExhibitions())->execute($request->keywords);
    $artworks = (new SearchArtworks())->execute($request->keywords);
    $artists = (new SearchArtists())->execute($request->keywords);

    return view('pages.search', [
      'hits' => count($exhibitions) + count($artworks),
      'records' => [
        'exhibitions' => $exhibitions,
        'artworks' => $artworks,
        'artists' => $artists,
     ],
      'keywords' => $request->keywords,
    ]);
  }
}
