<div>
  <h1>{{ __('Nehmen Sie mit uns Kontakt auf') }}</h1>
  <form wire:submit="save" class="contact-form">

    @if (session()->has('submitted'))
      <x-notification 
        type="success" 
        :message="'Vielen Dank für Ihre Nachricht. Wir melden uns demnächst.'" />
    @endif

    @if ($errors->has('firstname') || $errors->has('lastname') || $errors->has('email'))
      <x-notification
        type="error"
        :message="'Es sind Fehler aufgetreten. Bitte üperprüfen Sie ihre Angaben.'" />
    @endif

    @if ($errors->has('error_message') || $errors->has('website'))
      <x-notification
        type="error"
        :message="'Es ist ein Fehler aufgetreten.'" />
    @endif

    <div class="form-row">
      <label class="@error('firstname') has-error @enderror">Vorname *</label>
      <input type="text" wire:model="firstname" required>
    </div>
    <div class="form-row">
      <label class="@error('lastname') has-error @enderror">Name *</label>
      <input type="text" wire:model="lastname" required>
    </div>
    <div class="form-row">
      <label class="@error('street') has-error @enderror">Strasse</label>
      <input type="text" wire:model="street">
    </div>
    <div class="form-row">
      <label class="@error('location') has-error @enderror">PLZ / Ort</label>
      <input type="text" wire:model="location">
    </div>
    <div class="form-row">
      <label class="@error('email') has-error @enderror">E-Mail *</label>
      <input type="email" wire:model="email" required>
    </div>
    <div class="form-row">
      <label class="@error('phone') has-error @enderror">Telefon</label>
      <input type="text" wire:model="phone">
    </div>
    <div class="form-row">
      <label class="@error('mobile') has-error @enderror">Mobile</label>
      <input type="text" wire:model="mobile">
    </div>
    <div class="form-row">
      <label class="@error('message') has-error @enderror">Mitteilung</label>
      <textarea wire:model="message"></textarea>
    </div>

    <input type="text" name="website" wire:model="website" value="" />
    
    <div class="form-row hover:cursor-pointer">
      <input type="checkbox" name="newsletter" id="newsletter-checkbox" wire:model="newsletter">
      <label class="checkbox-label" for="newsletter-checkbox" class="hover:!cursor-pointer">
        Newsletter abonnieren
      </label>
    </div>

    @livewire('cart-list')
    <div class="form-row">
      <button type="submit"class="btn btn--primary hover:!bg-black transition-background">Absenden</button>
    </div>
    <p><small>* Pflichtfelder</small></p>
  </form>
</div>
