@props([
  'type' => 'success', 
  'message' => '', 
  'autohide' => false, 
  'timeout' => 3000,
  'show' => false
])
<div 
  x-data="{ show: true }" 
  @if ($autohide)
    x-init="setTimeout(() => show = false, {{ $timeout }})"
  @endif
  >
  <template x-if="show">
    <div class="{{ $type == 'success' ? 'bg-green-600' : 'bg-red-600' }} text-white font-semi font-normal p-15 md:p-10 hyphens-auto fixed top-0 md:top-10 left-0 md:left-10 inline-block w-auto md:max-w-[500px] z-[101]">
      <div class="relative">
        <a href="javascript:;" x-on:click="show = false">
          {{ $message }}
        </a>
      </div>
    </div>
  </template>
</div>