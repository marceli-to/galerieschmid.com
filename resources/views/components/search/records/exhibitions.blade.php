@props(['record' => ''])
<article class="search-result">
  <a href="{{ $record['url'] }}" title="{{ __('Mehr anzeigen') }}">{!! $record['title'] !!}</a>
  {{-- <div class="search-result__preview-text">
    {!! $record['text'] !!}
  </div> --}}
  <p class="search-result__page">{{ __("Gefunden in 'Ausstellungen'") }}</p>

</article>