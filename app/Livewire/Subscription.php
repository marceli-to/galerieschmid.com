<?php
namespace App\Livewire;
use Livewire\Attributes\Rule; 
use Livewire\Component;
use App\Services\Newsletter as NewsletterService;

class Subscription extends Component
{
  #[Rule('required')]
  public $firstname;

  #[Rule('required')]
  public $lastname;

  #[Rule('required|email')]
  public $email;

  public function save()
  {
    $this->validate();
    (new NewsletterService())->subscribe([
      'firstname' => $this->firstname,
      'lastname' => $this->lastname,
      'email' => $this->email,
    ]);

    session()->flash('subscribed', true);
    $this->reset();
    $this->render();
  }

  public function render()
  {
    return view('livewire.subscription');
  }
}
