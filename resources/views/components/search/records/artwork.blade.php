@props(['record' => ''])
<article class="search-result">
  <a href="{{ $record['url'] }}" title="{{ __('Mehr anzeigen') }}">
    {!! $record['title'] !!}
  </a>
  <p class="search-result__page">
    {{ __("Gefunden in 'Kunstobjekte'") }}
  </p>
</article>