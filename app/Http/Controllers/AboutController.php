<?php
namespace App\Http\Controllers;
use App\Actions\Impressions\GetImpressions;
use App\Actions\Content\GetItem;
use Illuminate\Http\Request;

class AboutController extends Controller
{
  /**
   * Shows the about page
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  { 
    return view('pages.about', [
      'about_gallery' => (new GetItem())->execute('about_gallery'),
      'about_team' => (new GetItem())->execute('about_team'),
      'impressions' => (new GetImpressions())->execute(),
    ]);
  }
}
