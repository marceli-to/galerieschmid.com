@props(['article'])
<article class="newsletter__article">
  <h2 class="text-crimson font-bold mb-[15px]">
    {{ $article->title }}
  </h2>
  <table class="mb-20">
    <td class="w-[160px]">
      <img src="{{ $article->media->first()->getUrl('newsletter') }}" alt="{{ $article->title }}" class="w-[120px] my-2 mr-10">
    </td>
    <td class="align-top">
      {!! $article->text !!}
    </td>
  </table>
</article>