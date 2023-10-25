<?php
namespace App\Http\Controllers;
use App\Actions\Artist\GetArtist;
use App\Actions\Artist\GetArtistList;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
  /**
   * Shows the artists page
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  { 
    return view('pages.artists.index', [
      'artists' => (new GetArtistList())->execute()
    ]);
  }

  /**
   * Shows the artist page
   * 
   * @param  string $slug
   * @param  Artist $artist
   * @return \Illuminate\Http\Response
   */

  public function show($slug, Artist $artist)
  {
    return view('pages.artists.show', [
      'artist' => (new GetArtist())->execute($artist),
      'artists' => (new GetArtistList())->execute(),
    ]);
  }
}

