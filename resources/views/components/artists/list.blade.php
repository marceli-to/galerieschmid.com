@props(['artists', 'current' => NULL])
<nav class="menu-artists">
  @if ($artists)
    <ul class="nav-list js-artist-list">
      @foreach($artists as $artist)
        <li>
          <a 
            href="{{ route('page.artist.show', ['slug' => \Str::slug($artist->full_name), 'artist' => $artist->id]) }}" 
            data-touch 
            title="{{ $artist->full_name }}"
            class="{{ $current && $current == $artist->id ? 'is-active' : ''}}">
            {{ $artist->full_name }}
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</nav>