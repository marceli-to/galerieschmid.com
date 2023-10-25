<?php
namespace App\Http\Controllers;
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
    return view('pages.artists');
  }
}
