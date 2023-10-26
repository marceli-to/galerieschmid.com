@props(['exhibition', 'active' => false])
<article class="teaser teaser--exhibition {{ !Route::is('page.home') && $active ? 'is-active' : '' }}" data-touch>
  <a href="">
    <p>
      {{ $exhibition->subtitle_de }}<br>
      {{ $exhibition->title_de }}<br>
      {!! $exhibition->periode !!}
    </p>
  </a>		
</article>	