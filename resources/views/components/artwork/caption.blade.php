@props(['artwork'])
<figcaption>
  <strong>
    {{ $artwork->description_de }}{{ $artwork->year ? ', ' . $artwork->year : '' }}{{ $artwork->artist->fullname ? ', ' . $artwork->artist->fullname : '' }}
  </strong>
  <br>
  {{ $artwork->artworkTechnique ? $artwork->artworkTechnique->description_de : '' }}{{ $artwork->litho_number ? ', ' . $artwork->litho_number : '' }}{{ $artwork->dimensions ? ', ' . $artwork->dimensions : '' }}{!! $artwork->artworkFrame ? '<br>' . $artwork->artworkFrame->description_de : '' !!}
</figcaption>