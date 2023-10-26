<div>
  <form wire:submit="save" class="contact-form">
    @if (session()->has('status'))
      <div x-data="{ open: true }" x-show="open">
        <div class="bg-green-600 text-white font-semi font-normal py-10 px-15 pr-25 fixed top-10 left-10 inline-block w-auto z-[101]">
          <div class="relative">
            <a href="javascript:;" x-on:click="open = false">
              Vielen Dank, wir haben Ihre Anfrage erhalten.
            </a>
          </div>
        </div>
      </div>
    @endif
    <div class="form-row">
      <label class="@error('firstname') has-error @enderror">Vorname *</label>
      <input type="text" wire:model="firstname" value="">
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
