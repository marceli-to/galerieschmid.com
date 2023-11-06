@extends('app')
@section('seo_title', 'Über uns')
@section('content')
<section class="grid__cell grid__cell--3_3 grid__cell--last grid-order--1">
	<h2>{{ __('Suche') }}</h2>
  <x-search.result :hits="$hits" :keywords="$keywords" />
	@foreach ($records as $record)
    <x-search.records.exhibitions :record="$record" />
	@endforeach
</section>
@endsection