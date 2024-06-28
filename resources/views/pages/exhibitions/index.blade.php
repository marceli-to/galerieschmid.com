@extends('app')
@section('seo_title', 'Ausstellungen')
@section('content')
<section class="grid__cell grid__cell--last grid__cell--2_3 grid-order--2">
  @if ($exhibitions['current'])
    <x-exhibitions.show :exhibition="$exhibitions['current']" />
  @endif
</section>
<section class="grid__cell grid__cell--1_3 grid-order--1">
  <h2>{{ __('Ausstellungen') }}</h2>
  {{-- <x-exhibitions.list :exhibitions="$exhibitions" :activeExhibitionId="$exhibitions['current']->id" /> --}}
</section>
@endsection