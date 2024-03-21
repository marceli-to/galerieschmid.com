<!doctype html>
<html class="bg-white">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@vite('resources/css/app.css')
</head>
<body class="mx-auto w-full max-w-[640px] font-newsletter p-10 text-[14px]">
  @if ($isPreview)
    <div class="bg-crimson text-white leading-none fixed right-15 top-15 p-10 w-auto inline-block">
      <span class="text-[18px]">Vorschau</span>
    </div>
  @endif
  <main class="p-10">
    <header class="h-95 block">
      <x-newsletter.logo />
    </header>
    <section>
      <h1 class="font-normal text-[18px] my-[5px] leading-8">{{ $newsletter->title }}</h1>
    </section>
    <hr class="w-full h-0 border-t border-black mt-[10px] mb-[20px]">
    <section>
      @if ($newsletter->articles)
        @foreach($newsletter->articles as $article)
          <article class="border-b border-crimson mb-15">
            <h2 class="text-crimson font-bold mb-[15px]">
              {{ $article->title }}
            </h2>
            <table class="mb-20">
              <td class="w-[160px]">
                @if ($article->media->first())
                  <img src="{{ $article->media->first()->getUrl('newsletter') }}" alt="{{ $article->title }}" class="w-[120px] my-2 mr-10">
                @endif
              </td>
              <td class="align-top">
                {!! $article->text !!}
              </td>
            </table>
          </article>
        @endforeach
      @endif
    </section>
    <footer>
      <table class="bg-silver w-full text-[12px]"> 
        <td class="p-5 w-[125px] align-top">Galerie Schmid<br>GAP ART AG<br>Bundesplatz 14<br>6300 Zug</td>
        <td class="p-5 align-top">T + 41 (0)41 711 08 02<br>M +41 (0)79 784 71 49<br>info@galerieschmid.com<br>www.galerieschmid.com</td>
        <td class="p-5 align-top text-right">
          <a href="">
            Newsletter abmelden
          </a>
        </td>
      </table>
    </footer>
  </main>
</body>
</html>