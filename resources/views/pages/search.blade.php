@extends('app')
@section('seo_title', 'Suchresultate')
@section('content')
<section class="grid__cell grid__cell--3_3 grid__cell--last grid-order--1">
	<h2>{{ __('Suche') }}</h2>

  <x-search.result :hits="$hits" :keywords="$keywords" />
  @foreach ($records['artists'] as $record)
    <x-search.records.artist :record="$record" />
  @endforeach

  @foreach ($records['artworks'] as $record)
    <x-search.records.artwork :record="$record" />
	@endforeach
 
	@foreach ($records['exhibitions'] as $record)
    <x-search.records.exhibition :record="$record" />
  @endforeach

</section>
@endsection