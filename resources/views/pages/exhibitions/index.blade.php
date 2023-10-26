@extends('app')
@section('seo_title', 'Ausstellungen')
@section('content')
<section class="grid__cell grid__cell--last grid__cell--2_3 grid-order--2">
  @if ($exhibitions['current'])
  <h2>{{ $exhibitions['current']->subtitle_de }}</h2>
  <article class="exhibition exhibition--current">
    <h3>{{ $exhibitions['current']->title_de }}</h3>
    {!! $exhibitions['current']->text_de ? $exhibitions['current']->text_de : '<p></p>' !!}
    <p><strong>{!! $exhibitions['current']->periode !!}</strong></p>
  </article>
  @endif
</section>
<section class="grid__cell grid__cell--1_3 grid-order--1">
  <h2>{{ __('Ausstellungen') }}</h2>
  <x-exhibitions.list :exhibitions="$exhibitions" />
</section>
@endsection