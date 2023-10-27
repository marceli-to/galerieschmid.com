<?php
namespace App\Livewire;
use Livewire\Component;

class CartItem extends Component
{
  public $publication;

  public function add()
  {
    if (!session()->has('cart') || !in_array($this->publication->id, session('cart')))
    {
      session()->push('cart', $this->publication->id);
    }
    session()->flash('added_to_cart', true);
    $this->render();
  }

  public function remove()
  {
    if (session()->has('cart') && in_array($this->publication->id, session('cart')))
    {
      session()->forget('cart.' . array_search($this->publication->id, session('cart')));
    }
    session()->flash('removed_from_cart', true);
    $this->render();
  }

  public function mount($publication)
  {
    $this->publication = $publication;
  }

  public function render()
  {
    return view('livewire.cart-item', [
      'publication' => $this->publication,
      'action' => (session()->has('cart') && in_array($this->publication->id, session('cart'))) ? 'remove' : 'add'
    ]);
  }
}
