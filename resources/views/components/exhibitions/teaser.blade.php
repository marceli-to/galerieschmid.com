@props(['exhibition', 'activeExhibitionId' => null])
<article class="teaser teaser--exhibition {{ !Route::is('page.home') && $activeExhibitionId == $exhibition->id ? 'is-active' : '' }}" data-touch>
  <a href="{{ route('page.exhibition.show', ['slug' => \Str::slug($exhibition->title_de), 'exhibition' => $exhibition->id]) }}">
    <p>
      {{ $exhibition->subtitle_de }}<br>
      {{ $exhibition->title_de }}<br>
      {!! $exhibition->periode !!}
    </p>
  </a>		
</article>	