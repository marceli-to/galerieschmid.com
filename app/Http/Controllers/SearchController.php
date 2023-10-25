<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  /**
   * Shows the search page
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  { 
    return view('pages.search');
  }

}
