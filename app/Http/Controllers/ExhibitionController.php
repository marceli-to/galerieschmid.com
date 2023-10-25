<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{
  /**
   * Shows the exhibitions page
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  { 
    return view('pages.exhibitions');
  }

}
