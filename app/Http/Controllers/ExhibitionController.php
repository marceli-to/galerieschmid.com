<?php
namespace App\Http\Controllers;
use App\Actions\Exhibition\GetExhibitionList;
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
    return view('pages.exhibitions.index', [
      'exhibitions' => (new GetExhibitionList())->execute()
    ]);
  }
}
