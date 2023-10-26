<?php
namespace App\Http\Controllers;
use App\Services\Newsletter as NewsletterService;
use App\Models\Newsletter;
use App\Models\NewsletterSubscriber;
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

  /**
   * Verifies the newsletter subscription
   * 
   * @param NewsletterSubscriber $subscriber
   * @return \Illuminate\Http\Response
   */
  public function verify(NewsletterSubscriber $subscriber)
  {
    $subscriber = NewsletterSubscriber::withTrashed()->find($subscriber->id);
    (new NewsletterService())->verify($subscriber);
    session()->flash('verified', true);
    return redirect()->route('page.newsletter');
  }

  /**
   * Unsubscribes the newsletter subscription
   * 
   * @param NewsletterSubscriber $subscriber
   * @return \Illuminate\Http\Response
   */
  public function unsubscribe(NewsletterSubscriber $subscriber)
  {
    $subscriber = NewsletterSubscriber::withTrashed()->find($subscriber->id);
    (new NewsletterService())->unsubscribe($subscriber);
    session()->flash('unsubscribed', true);
    return redirect()->route('page.newsletter');
  }
}
