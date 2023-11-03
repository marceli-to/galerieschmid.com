@extends('app')
@section('seo_title', 'Über uns')
@section('content')
<section class="grid__cell grid__cell--1_3 grid-order--1">
  <article class="text-media">
    <h1>{{ $about_gallery->title_de }}</h1>
    {!! $about_gallery->text_de !!}
  </article>
  @if ($team)
    <article class="text-media">
      <h1>Das Team</h1>
      @foreach($team as $t)
        {{ $t->firstname }} {{ $t->lastname }}<br>
      @endforeach
    </article>
  @endif	
</section>

<section class="grid__cell grid__cell--2_3 grid-order--2">
  <h2>{{ __('Impressionen') }}</h2>
  <div class="slider slider--exhibition swiper-container js-slider">
    <div class="swiper-wrapper">
      @if ($impressions && $impressions->count() > 0)
        @foreach($impressions as $impression)
          <x-media.slide :url="$impression->media->first()->getUrl('detail')" />
        @endforeach
      @endif
    </div>
    <a href="javascript:;" class="slider-btn slider-btn--prev js-btn-slide-prev">&nbsp;</a>
    <a href="javascript:;" class="slider-btn slider-btn--next js-btn-slide-next">&nbsp;</a>			
  </div>
    
  <div class="slider-footer">
    <div class="slider-counter js-slider-pagination"></div>
  </div>          
</section>
@endsection