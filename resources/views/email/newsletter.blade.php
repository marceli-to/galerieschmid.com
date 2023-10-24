@component('mail::layout')
  @slot('header')
    @component('mail::header', ['url' => config('app.url')])
    @endcomponent
  @endslot

  <div class="newsletter">
    <h1 class="newsletter__heading">
      {{ $data['newsletter']->title }}
    </h1>
    <div class="newsletter__separator"></div>
    @if ($data['newsletter']->articles)
      @foreach($data['newsletter']->articles as $article)
        <x-newsletter.article :article="$article" />
      @endforeach
    @endif
  </div>

  @slot('footer')
    @component('mail::footer', ['data' => $data])
    @endcomponent
  @endslot
@endcomponent
