@extends('app')
@section('seo_title', 'Künstler – Werke – ' . $artist->fullname)
@section('content')
<section class="grid__cell grid__cell--last grid__cell--2_3 grid-order--2">
  <h1>{{ __('Werke') }}</h1>
  
  <div class="slider artist-showcase swiper-container js-slider">
    @if ($artist->artworksActive && $artist->artworksActive->count() > 1)
      <a href="javascript:;" class="slider-btn slider-btn--prev js-btn-slide-prev">&nbsp;</a>
      <a href="javascript:;" class="slider-btn slider-btn--next js-btn-slide-next">&nbsp;</a>			
    @endif
    <div class="swiper-wrapper">
      @if ($artist->artworksActive && $artist->artworksActive->count() > 1)
        @foreach($artist->artworksActive as $index => $artwork)
          @if ($artwork->media->first())
            <x-media.slide :url="$artwork->media->first()->getUrl('detail')">
              <x-artwork.caption :artwork="$artwork" />
            </x-media.slide>
          @endif
        @endforeach
      @endif
    </div>
  </div>
  @if ($artist->artworksActive && $artist->artworksActive->count() > 1)
    <div class="slider-footer">
      <div class="slider-counter js-slider-pagination"></div>
      <div class="slider-caption js-slider-caption"></div>
    </div>
  @endif
</section>	
<section class="grid__cell grid__cell--1_3 grid-order--1">
  <h2>{{ $artist->fullname }}</h2>
  @if ($artist->artworksActive && $artist->artworksActive->count() > 1)
    <article class="thumbnail-grid js-thumbnail-grid">
      @foreach($artist->artworksActive as $index => $artwork)
        @if ($artwork->media->first())
          <a href="javascript:;" class="js-thumbnail js-slide-goto">
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
@endsection
