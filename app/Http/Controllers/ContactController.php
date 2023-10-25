<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ContactController extends Controller
{
  /**
   * Shows the contact page
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  { 
    return view('pages.contact');
  }

}
