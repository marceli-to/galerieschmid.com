@extends('app')
@section('seo_title', 'Künstler')
@section('content')
<section class="grid__cell grid__cell--last grid__cell--2_3 grid-order--2">
  @if ($artists && $artists->count() > 0)
    <h2 class="js-artist-name">
      {{ $artists[0]->fullname ? $artists[0]->fullname : '' }}
    </h2>
    
    <div class="slider slider--exhibition swiper-container js-slider is-artist-slider">
      <a href="javascript:;" class="slider-btn slider-btn--prev js-btn-slide-prev">&nbsp;</a>
      <a href="javascript:;" class="slider-btn slider-btn--next js-btn-slide-next">&nbsp;</a>			
      <div class="swiper-wrapper">
        @foreach($artists as $artist)
          @php $artwork = $artist->artworksActive->random(); @endphp
          @if ($artwork && $artwork->media->first())
           <x-media.slide :url="$artwork->media->first()->getUrl('detail')" />
          @endif
        @endforeach
      </div>
    </div>
    <div class="slider-footer">
      <div class="slider-counter js-slider-pagination"></div>
      <div class="slider-caption js-slider-caption"></div>
    </div>
  @endif
</section>

<section class="grid__cell grid__cell--1_3 grid-order--1">
  <h2>{{ __('Künstler') }}</h2>
  <x-artists.list :artists="$artists" />	
</section>
@endsection
