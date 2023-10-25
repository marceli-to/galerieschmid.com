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

  @if ($exhibitions['upcoming'])
    @foreach($exhibitions['upcoming'] as $exhibition)
      <article class="teaser teaser--exhibition" data-touch>
        <a href="">
          <p>
            {{ $exhibition->subtitle_de }}<br>
            {{ $exhibition->title_de }}<br>
            {!! $exhibition->periode !!}
          </p>
        </a>		
      </article>	
    @endforeach
  @endif

  @if ($exhibitions['archived'])
    <h2>{{ __('Vergangene Ausstellungen') }}</h2>
    @foreach($exhibitions['archived'] as $exhibition)
      <article class="teaser teaser--exhibition" data-touch>
        <a href="">
          <p>
            {{ $exhibition->subtitle_de }}<br>
            {{ $exhibition->title_de }}<br>
            {!! $exhibition->periode !!}
          </p>
        </a>		
      </article>	
    @endforeach
  @endif
</section>

<section class="grid__cell grid__cell--1_3 grid-order--1">
  <h2>{{ __('Künstler') }}</h2>
  <nav class="menu-artists">
    @if ($artists)
      <ul class="nav-list">
        @foreach($artists as $artist)
          <li>
            <a 
              href="{{ route('page.artist.show', ['slug' => \Str::slug($artist->full_name), 'artist' => $artist->id]) }}" 
              data-touch 
              title="{{ $artist->full_name }}">
              {{ $artist->full_name }}
            </a>
          </li>
        @endforeach
      </ul>
    @endif
  </nav>
</section>	
@endsection