@props(['hits' => 0, 'keywords' => ''])
<p>
  @if ($hits > 0)
    {{ $hits }} {{ __('Resultat/e') }} mit <strong>«{{ $keywords }}»</strong>
  @else 
    {{ __('Keine Resultate') }}
  @endif
</p>