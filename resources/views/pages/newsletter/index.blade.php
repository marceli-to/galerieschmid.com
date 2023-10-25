@extends('app')
@section('seo_title', 'Newsletter')
@section('content')
<section class="grid__cell grid__cell--2_3 grid-order--2 grid__cell--last">
  <h2>{{ __('Newsletter abonnieren') }}</h2>
  @livewire('create-newsletter-subscriber')

</section>
  
<section class="grid__cell grid__cell--1_3 grid-order--1">
  <article class="text-media">
    <h2>{{ __('Newsletter Archiv') }}</h2>
    @if ($newsletters->count() > 0)
    <ul>
      @foreach($newsletters as $newsletter)
        <li>
          <a 
            href="{{ route('page.newsletter.archive', ['newsletter' => $newsletter->id]) }}" 
            target="_blank" 
            title="Newsletter {{ $newsletter->title }} anzeigen">
            {{ $newsletter->title }} ({{ $newsletter->sent_at->format('d.m.Y')  }})
          </a>
        </li>
      @endforeach
    </ul>
    @else
     {{ __('Es sind noch keine Einträge vorhanden.') }}
    @endif
  </article>
</section>
@endsection