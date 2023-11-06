<?php
namespace App\Http\Controllers;
use App\Actions\Exhibition\SearchExhibitions;
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
    $records = (new SearchExhibitions())->execute($request->keywords);
    return view('pages.search', [
      'keywords' => $request->keywords,
      'hits' => $records->count(),
      'records' => $records
    ]);
  }

}
