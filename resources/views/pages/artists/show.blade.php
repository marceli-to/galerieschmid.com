@extends('app')
@section('seo_title', 'Künstler – ' . $artist->fullname)
@section('content')
<section class="grid__cell grid__cell--1_3 grid-order--2">
  <h2>{{ __('Werke') }}</h2>
  @if (Agent::isMobile() && !Agent::isTablet())
    <div class="slider artist-showcase swiper-container js-slider">
      @if ($artist->artwork && $artist->artwork->count() > 1)
        <a href="javascript:;" class="slider-btn slider-btn--prev js-btn-slide-prev">&nbsp;</a>
        <a href="javascript:;" class="slider-btn slider-btn--next js-btn-slide-next">&nbsp;</a>			
      @endif
      <div class="swiper-wrapper">
        @if ($artist->artwork && $artist->artwork->count() > 1)
          @foreach($artist->artwork as $index => $artwork)
            @if ($artwork->media->first())
              <x-media.slide :url="$artwork->media->first()->getUrl('detail')">
                <figcaption>
                  <strong>{{ $artwork->description_de }}</strong><br>
                  {{ $artwork->artworkTechnique ? $artwork->artworkTechnique->description_de : '' }}
                  {{ $artwork->litho_number ? ', ' . $artwork->litho_number : '' }}
                </figcaption>
              </x-media.slide>
            @endif
          @endforeach
        @endif
      </div>
    </div>
    @if ($artist->artwork && $artist->artwork->count() > 1)
      <div class="slider-footer">
        <div class="slider-counter js-slider-pagination"></div>
        <div class="slider-caption js-slider-caption"></div>
      </div>
    @endif
  @else
    <article class="thumbnail-grid js-thumbnail-grid">
      @foreach($artist->artwork as $index => $artwork)
        @if ($artwork->media->first())
          <a 
            href="/{{ __('kuenstler') }}/{{ __('werke') }}/{{ \Str::slug($artist->fullname)}}/{{ $artist->id }}/{{ $index }}" 
            class="js-thumbnail">
            <x-media.image 
              :url="$artwork->media->first()->getUrl('listing')" 
              :alt="$artwork->description_de"
              width="250"
              height="600">
            </x-media.image>
          </a>
        @endif
      @endforeach
    </article>
  @endif
</section>

<section class="grid__cell grid__cell--1_3 grid-order--3 js-wrap-publications">
  <h2 class="narrow">{{ __('Portrait') }}</h2>
  <h1 class="large">{{ $artist->fullname }}</h1>
  <article class="text-media">
    @if(!empty($artist->biography_de))
      {!! $artist->biography_de !!}
    @endif
  </article>

  @if ($artist->publications && $artist->publications->count() > 0)
    <article class="text-media">
      <h2 class="narrow">{{ __('Publikationen') }}</h2>
      @foreach($artist->publications as $publication)
        <div class="publication">
          <div class="media-block">
            @if ($publication->media->first())
              <figure class="media-block__image">
                <img 
                src="{{ $publication->media->first()->getUrl('cover') }}" 
                width="600"
                height="600"
                alt="{{ $publication->title_de }}">
              </figure>
            @endif
            <div class="media-block__text">
              <h3>{{ $publication->title_de }}</h3>
              {!! $publication->text_de !!}
              <a 
                href="javascript:;" 
                class="btn btn--add-order js-btn-add" 
                data-id="{{ $publication->id }}" 
                data-item='{"id":"{{ $publication->id }}", "title":"{{ $publication->title_de }}","artist":"{{ $publication->fullname }}"}'>
                Publikation bestellen
              </a>
              <a 
                href="javascript:;" 
                class="btn btn--remove-order js-btn-remove" 
                data-storage="gs-pub-{{ $publication->id }}" 
                style="display: none;">Aus dem Warenkorb entfernen
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </article>
  @endif
</section>

<section class="grid__cell grid__cell--1_3 grid-order--1">
  <h2>{{ __('Künstler') }}</h2>
  <x-artists.list :artists="$artists" :current="$artist->id" />	
</section>
<x-basket.notice />
@endsection