@props(['exhibition'])
<h2>{{ $exhibition->subtitle_de }}</h2>
<article class="exhibition exhibition--current">
  <h3>{{ $exhibition->title_de }}</h3>
  {!! $exhibition->text_de ? $exhibition->text_de : '<p></p>' !!}
  <p><strong>{!! $exhibition->periode !!}</strong></p>
</article>
@if (($exhibition->artworks && $exhibition->artworks->count() > 0) || ($exhibition->media->first() && $exhibition->media->first()->getUrl('cover')))
  <div class="slider slider--exhibition swiper-container js-slider">
    @if ($exhibition->artworks && $exhibition->artworks->count() > 0)
      <a href="javascript:;" class="slider-btn slider-btn--prev js-btn-slide-prev">&nbsp;</a>
      <a href="javascript:;" class="slider-btn slider-btn--next js-btn-slide-next">&nbsp;</a>			
    @endif
    <div class="swiper-wrapper">
      @if ($exhibition->artworks && $exhibition->artworks->count() > 0)
        @foreach($exhibition->artworks->sortBy('pivot.sort') as $artwork)
          @if ($artwork->media->first())
            <x-media.slide :url="$artwork->media->first()->getUrl('detail')">
              <x-artwork.caption :artwork="$artwork" />
            </x-media.slide>
          @endif
        @endforeach
      @endif
      @if ($exhibition->media->first() && $exhibition->media->first()->getUrl('cover'))
        <x-media.slide :url="$exhibition->media->first()->getUrl('cover')"></x-media.slide>			
      @endif
    </div>
  </div>
  @if ($exhibition->artworks && $exhibition->artworks->count() > 0)
    <div class="slider-footer">
      <div class="slider-counter js-slider-pagination"></div>
      <div class="slider-caption js-slider-caption"></div>
    </div>
  @endif
@endif