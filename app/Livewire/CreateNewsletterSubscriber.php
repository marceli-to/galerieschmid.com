<?php
namespace App\Livewire;
use Livewire\Attributes\Rule; 
use Livewire\Component;
use App\Models\NewsletterSubscriber;

class CreateNewsletterSubscriber extends Component
{
  #[Rule('required')]
  public $firstname;

  #[Rule('required')]
  public $lastname;

  #[Rule('required', 'email')]
  public $email;

  public function save()
  {
    $this->validate();
    
    $subscriber = NewsletterSubscriber::create(
      $this->only([
        'lastname', 
        'firstname',
        'email',
      ])
    );

    $subscriber->active = 1;
    $subscriber->save();

    session()->flash('status', 'Inquiry was submitted');
    $this->reset();
    $this->render();
  }

  public function render()
  {
    return view('livewire.create-newsletter-subscriber');
  }
}
