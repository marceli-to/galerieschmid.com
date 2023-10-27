@component('mail::layout')
  @slot('header')
    @component('mail::header', ['url' => config('app.url')])
    @endcomponent
  @endslot

  <div class="notification notification--verification">
    <h1 class="notification__heading">Ihre Anmeldung</h1>
    <p>Vielen Dank für Ihre Anmeldung zu unserem Newsletter.</p>
    <p>Bitte bestätigen Sie ihre E-Mail-Adresse, um unseren Newsletter zu erhalten. Klicken Sie dazu einfach auf den Link unten:</p>
    <p>
      <a href="{{ route('page.newsletter.verify',['subscriber' => $data['subscriber']->hash]) }}">
        {{ route('page.newsletter.verify',['subscriber' => $data['subscriber']->hash]) }}
      </a>
    </p>
    <p>
      Freundliche Grüsse<br>{{ config('app.name') }}
    <p><small>Sollten Sie sich nicht für unseren Newsletter angemeldet haben, ignorieren Sie bitte diese E-Mail.</small></p>
  </div>

  @slot('footer')
    @component('mail::footer', ['data' => $data, 'unsubscribe' => false])
    @endcomponent
  @endslot
@endcomponent
