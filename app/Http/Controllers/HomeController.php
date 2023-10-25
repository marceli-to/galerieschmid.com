<?php
namespace App\Http\Controllers;
use App\Actions\Artist\GetArtistList;
use App\Actions\Exhibition\GetExhibitionList;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  /**
   * Shows the index page
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  {  

    return view('pages.home', [
      'artists' => (new GetArtistList())->execute(),
      'exhibitions' => (new GetExhibitionList())->execute()
    ]);
  }

}
