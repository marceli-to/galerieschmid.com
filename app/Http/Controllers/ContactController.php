<?php
namespace App\Http\Controllers;
use App\Actions\Content\GetItem;
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
    return view('pages.contact', [
      'contact_opening_hours' => (new GetItem())->execute('contact_opening_hours'),
      'contact_address' => (new GetItem())->execute('contact_address'),
    ]);
  }

}
