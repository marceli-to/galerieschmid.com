<?php
namespace App\Http\Controllers;
use App\Actions\Impressions\GetImpressions;
use App\Actions\Content\GetItem;
use App\Actions\Content\GetTeam;
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
      'team' => (new GetTeam())->execute(),
      'impressions' => (new GetImpressions())->execute(),
    ]);
  }
}
