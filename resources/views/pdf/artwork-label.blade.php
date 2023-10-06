@include('pdf.partials.header')
<div class="page">
  @foreach($records as $record)
    {{ $record->firstname }}{{ $record->lastname }}<br>
  @endforeach
</div>
@include('pdf.partials.footer')