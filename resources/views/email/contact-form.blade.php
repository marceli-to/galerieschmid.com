@component('mail::layout')
  @slot('header')
    @component('mail::header', ['url' => config('app.url')])
    @endcomponent
  @endslot

  <div class="notification notification--contact-form">
    <h1 class="notification__heading">Kontaktformular</h1>
    <div class="table">
      <table>
        <tr>
          <td>Vorname</td>
          <td>{{ $data['firstname'] }}</td>
        </tr>
        <tr>
          <td>Name</td>
          <td>{{ $data['lastname'] }}</td>
        </tr>
        <tr>
          <td>E-Mail</td>
          <td>{{ $data['email'] }}</td>
        </tr>
        <tr>
          <td>Strasse, Nr.</td>
          <td>{{ $data['street'] }}</td>
        </tr>
        <tr>
          <td>PLZ / Ort</td>
          <td>{{ $data['location'] }}</td>
        </tr>
        <tr>
          <td>Telefon</td>
          <td>{{ $data['phone'] }}</td>
        </tr>
        <tr>
          <td>Mobile</td>
          <td>{{ $data['mobile'] }}</td>
        </tr>
      </table>
    </div>
    <br>
    @if ($data['publications'])
        <div style="padding-bottom: 3px;">
          <strong>Bestellte Publikationen</strong>
        </div>
        <ul>
          @foreach($data['publications'] as $publication)
            <li style="padding-bottom: 3px;">«{{ $publication->title_de }}» von {{ $publication->artist->full_name }}</li>
          @endforeach
        </ul>
        <br><br>
    @endif
  </div>

  @slot('footer')
    @component('mail::footer', ['data' => $data, 'unsubscribe' => false])
    @endcomponent
  @endslot
@endcomponent
