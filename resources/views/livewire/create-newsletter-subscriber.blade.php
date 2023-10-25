<div>
  <form wire:submit="save" class="contact-form">
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
      <input type="text" wire:model="email">
    </div>
    <div class="form-row">
      <button type="submit"class="btn btn--primary">Abonnieren</button>
    </div>
    <p><small>* Pflichtfelder</small></p>
  </form>
</div>
