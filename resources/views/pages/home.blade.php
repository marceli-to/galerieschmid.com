@extends('app')
@section('seo_title', 'Home')
@section('content')

<section class="grid__cell grid__cell--1_3 grid-order--3">
  <h2>{{ __('Aktuelle Ausstellung') }}</h2>
  <article class="teaser teaser--exhibition teaser--current">
    @if ($exhibitions['current'])
      <a href="">
        <p>
          {{ $exhibitions['current']->subtitle_de }}<br>
          {{ $exhibitions['current']->title_de }}<br>
        </p>
        <p>
          <strong>
            {!! $exhibitions['current']->periode !!}
          </strong>
        </p>
        @if ($exhibitions['current']->media->first())
          <figure>
            <img 
            src="{{ $exhibitions['current']->media->first()->getUrl('cover') }}" 
            width="1200"
            height="900"
            alt="{{ $exhibitions['current']->title_de }}">
          </figure>
        @endif
      </a>
    @endif
  </article>

</section>

<section class="grid__cell grid__cell--1_3 grid-order--2">
  <h2>{{ __('Ausstellungen') }}</h2>
  <x-exhibitions.list :exhibitions="$exhibitions" />
</section>

<section class="grid__cell grid__cell--1_3 grid-order--1">
  <h2>{{ __('Künstler') }}</h2>
  <x-artists.list :artists="$artists" />
</section>	
@endsection