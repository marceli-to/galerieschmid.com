<div>
  @if (session()->has('added_to_cart'))
    <x-notification 
      type="success" 
      message="Der Artikel wurde zum Warenkorb hinzugefügt. Sie können weitere Publikationen hinzufügen oder über das <a href='/kontakt' class='!text-white !underline hover:!no-underline underline-offset-4'>Kontaktformular</a> die Bestellung abschliessen." />
  @endif

  @if (session()->has('removed_from_cart'))
  <x-notification 
    type="success" 
    :autohide="true"
    :timeout="1500"
    message="Der Artikel wurde aus dem Warenkorb gelöscht." />
  @endif

  @if ($action == 'add')
    <form wire:submit="add" class="cart-form mt-10">
      <button type="submit" class="btn btn--primary !bg-crimson hover:!bg-black transition-background">Im Warenkob ablegen</button>
    </form>
  @endif
  @if ($action == 'remove')
  <form wire:submit="remove" class="cart-form mt-10">
    <button type="submit" class="btn btn--primary !bg-black hover:!bg-crimson transition-background">Aus Warenkorb entfernen</button>
  </form>
@endif
</div>
