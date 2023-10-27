<?php
namespace App\Livewire;
use Livewire\Component;
use \App\Models\ArtistPublication;

class CartList extends Component
{
  public $publications;

  public function remove($id)
  {
    if (session()->has('cart') && in_array($id, session('cart')))
    {
      session()->forget('cart.' . array_search($id, session('cart')));
    }
    $this->publications = $this->getPublications();
    $this->render();
  }

  public function mount()
  {
    $this->publications = ArtistPublication::whereIn('id', session('cart'))->get();
  }

  public function render()
  {
    return view('livewire.cart-list', [
      'publications' => $this->publications,
    ]);
  }

  protected function getPublications()
  {
    return ArtistPublication::whereIn('id', session('cart'))->get();
  }
}
