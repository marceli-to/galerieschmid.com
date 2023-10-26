@props(['exhibitions' => [], 'activeExhibitionId' => null])
@if ($exhibitions['upcoming'])
  @foreach($exhibitions['upcoming'] as $exhibition)
    <x-exhibitions.teaser :exhibition="$exhibition" :activeExhibitionId="$activeExhibitionId" />
  @endforeach
@endif

@if ($exhibitions['archived'])
  <h2>{{ __('Vergangene Ausstellungen') }}</h2>
  @foreach($exhibitions['archived'] as $exhibition)
    <x-exhibitions.teaser :exhibition="$exhibition" :activeExhibitionId="$activeExhibitionId" />
  @endforeach
@endif