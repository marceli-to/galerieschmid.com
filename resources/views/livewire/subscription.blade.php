<div>
  <form wire:submit="save" class="contact-form">

    @if (session()->has('subscribed'))
      <x-notification 
        type="success" 
        :message="'Vielen Dank für Ihr Interesse. Sie erhalten in den nächsten Minuten eine E-Mail zur Bestätigung Ihrer E-Mail-Adresse.'" />
    @endif

    @if ($errors->has('firstname') || $errors->has('lastname') || $errors->has('email'))
      <x-notification 
        type="error" 
        :message="'Es sind Fehler aufgetreten. Bitte üperprüfen Sie ihre Angaben.'" />
    @endif  

    <div class="form-row">
      <label class="@error('firstname') has-error @enderror">Vorname *</label>
      <input type="text" wire:model="firstname">
    </div>
    <div class="form-row">
      <label class="@error('lastname') has-error @enderror">Name *</label>
      <input type="text" wire:model="lastname">
    </div>
    <div class="form-row">
      <label class="@error('email') has-error @enderror">E-Mail *</label>
      <input type="email" wire:model="email">
    </div>
    <div class="form-row">
      <button type="submit"class="btn btn--primary hover:!bg-black transition-background">Abonnieren</button>
    </div>
    <p><small>* Pflichtfelder</small></p>
  </form>
</div>
