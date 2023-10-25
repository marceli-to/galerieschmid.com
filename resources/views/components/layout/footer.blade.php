@props(['slideIndex' => 0])
@if (Route::is('page.contact'))
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEusGhp2vS00IdyyHBTFDxwlAtelBtAng"></script>
@endif
@livewireScripts
<script src="{{ asset('legacy/js/script.js') }}?v={{ date('dmY', time()) }}"></script>
<script>SlideshowUi.init({index: {{ $slideIndex }}});</script>
@vite('resources/js/app.js')
</body>
<!-- made with ❤ by jamon.digital & marceli.to -->
</html>