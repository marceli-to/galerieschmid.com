<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
  /**
   * Shows the newsletter page
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  { 
    return view('pages.newsletter');
  }

}
