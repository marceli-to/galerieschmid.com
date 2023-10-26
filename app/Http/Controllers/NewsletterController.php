<?php
namespace App\Http\Controllers;
use App\Services\Newsletter as NewsletterService;
use App\Models\Newsletter;
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
    return view('pages.newsletter.index', [
      'newsletters' => (new NewsletterService())->get('archive'),
    ]);
  }

  /**
   * Shows the newsletter preview page
   * 
   * @param Newsletter $newsletter
   * @return \Illuminate\Http\Response
   */
  public function preview(Newsletter $newsletter)
  {
    return view('pages.newsletter.show', [
      'newsletter' => (new NewsletterService())->find($newsletter),
      'isPreview' => true,
    ]);
  }

  /**
   * Shows the newsletter archive page
   * 
   * @param Newsletter $newsletter
   * @return \Illuminate\Http\Response
   */
  public function archive(Newsletter $newsletter)
  {
    return view('pages.newsletter.show', [
      'newsletter' => (new NewsletterService())->find($newsletter),
      'isPreview' => false,
    ]);
  }
}
