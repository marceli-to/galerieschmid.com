<?php
namespace App\Livewire;
use Livewire\Attributes\Rule; 
use Livewire\Component;
use \App\Models\ArtistPublication;
use App\Notifications\ContactForm;
use Illuminate\Support\Facades\Notification;

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

  public function save()
  {
    $this->validate();

    // Send Email
    Notification::route('mail', $this->email)->notify(new ContactForm([
      'firstname' => $this->firstname,
      'lastname' => $this->lastname,
      'email' => $this->email,
      'street' => $this->street,
      'location' => $this->location,
      'phone' => $this->phone,
      'mobile' => $this->mobile,
      'publications' => ArtistPublication::whereIn('id', session('cart'))->get(),
    ]));

    // empty cart
    session()->forget('cart');
    session()->flash('submitted', true);
    $this->reset();
    //$this->render();

    // Redirect to route page.contact
    return redirect()->route('page.contact');
  }

  public function mount()
  {
    $this->cart = session('cart');
  }

  public function render()
  {
    return view('livewire.contact');
  }

}
