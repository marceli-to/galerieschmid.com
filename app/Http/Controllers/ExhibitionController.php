<?php
namespace App\Http\Controllers;
use App\Actions\Exhibition\GetExhibitionList;
use App\Actions\Exhibition\GetExhibition;
use App\Models\Exhibition;
use Illuminate\Http\Request;

class ExhibitionController extends Controller
{

  /**
   * Shows the exhibitions index page
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  { 
    return view('pages.exhibitions.index', [
      'exhibitions' => (new GetExhibitionList())->execute()
    ]);
  }

  /**
   * Shows the exhibitions detail page
   * 
   * @param String $slug
   * @param Exhibition $exhibition
   * 
   * @return \Illuminate\Http\Response
   */
  public function show($slug = NULL, Exhibition $exhibition)
  { 
    return view('pages.exhibitions.show', [
      'exhibition' => (new GetExhibition())->execute($exhibition),
      'exhibitions' => (new GetExhibitionList())->execute()
    ]);
  }
}
