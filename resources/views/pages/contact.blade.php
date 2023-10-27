@extends('app')
@section('seo_title', 'Kontakt')
@section('content')
<section class="grid__cell grid__cell--1_3 grid-order--1">
  @if ($contact_opening_hours->title_de || $contact_opening_hours->text_de)
    <article class="text-media">
      <h1>{{ $contact_opening_hours->title_de }}</h1>
      {!! $contact_opening_hours->text_de !!}
    </article>	
  @endif
  @if ($contact_address->title_de || $contact_address->text_de)
    <article class="text-media">
      <h2>{{ $contact_address->title_de }}</h2>
      {!! $contact_address->text_de !!}
    </article>
  @endif
  {{-- <article class="text-media googlemaps" id="js-maps"></article> --}}
</section>
<section class="grid__cell grid__cell--2_3 grid-order--2">
  @livewire('contact')
</section>
@endsection