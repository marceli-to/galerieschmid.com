<div>
  @if ($publications && $publications->count() > 0)
    <div class="mb-25">
      <h2 class="mb-5">Publikationen</h2>
      @foreach($publications as $publication)
        <div class="border-b border-b-black pb-15 mb-15">
          <div class="">
            <h3>«{{ $publication->title_de }}» – {{ $publication->artist->fullname }}</h3>
            <div class="mb-4">
              {!! $publication->text_de !!}
            </div>
            <div class="flex justify-start">
              <a 
                href="javascript:;"
                wire:click="remove({{ $publication->id}})"
                class="inline-flex items-center no-underline text-crimson hover:underline underline-offset-4 text-base leading-none">
                <x-icons.trash class="w-17 h-17 mr-6 shrink-0" />
                Entfernen
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>