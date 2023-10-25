@props(['url'])
<figure class="swiper-slide slide slide--background js-slide" style="background-image: url('{{ $url }}')" data-image="{{ $url }}">
  {{ $slot }}
</figure>