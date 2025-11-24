<?php
namespace App\Livewire;
use Livewire\Attributes\Rule; 
use Livewire\Component;
use \App\Models\ArtistPublication;
use App\Notifications\ContactForm;
use Illuminate\Support\Facades\Notification;
use App\Services\Newsletter as NewsletterService;

class Contact extends Component
{
  #[Rule('required')]
  public $firstname;

  #[Rule('required')]
  public $lastname;

  #[Rule('required|email')]
  public $email;

  public $street;

  public $location;

  public $phone;

  public $mobile;

  public $message;

  public $newsletter;

  // Spam protection
  #[Rule('nullable|max:0')]
  public $website;

  public $formStartTime;

  public function save()
  {
    $this->validate();

    // Time-based spam protection (minimum 3 seconds)
    if ($this->formStartTime) {
      $elapsedTime = now()->timestamp * 1000 - $this->formStartTime;
      if ($elapsedTime < 3000) {
        $this->addError('error_message', 'Something went wrong. Please try again.');
        return;
      }
    }

    // Send Email
    Notification::route('mail', env('MAIL_TO'))->notify(new ContactForm([
      'firstname' => $this->firstname,
      'lastname' => $this->lastname,
      'email' => $this->email,
      'street' => $this->street,
      'location' => $this->location,
      'phone' => $this->phone,
      'mobile' => $this->mobile,
      'message' => $this->message,
      'publications' => session()->has('cart') ? ArtistPublication::whereIn('id', session('cart'))->get() : [],
    ]));

    // Subscribe to Newsletter
    if (isset($this->newsletter) && $this->newsletter)
    {
      (new NewsletterService())->subscribe([
        'firstname' => $this->firstname,
        'lastname' => $this->lastname,
        'email' => $this->email,
      ]);
    }

    // empty cart
    session()->forget('cart');
    session()->flash('submitted', true);
    $this->reset();

    return redirect()->route('page.contact');
  }

  public function mount()
  {
    $this->cart = session('cart');
    $this->formStartTime = now()->timestamp * 1000;
  }

  public function render()
  {
    return view('livewire.contact');
  }

}
