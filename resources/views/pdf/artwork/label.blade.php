@include('pdf.partials.header')
@include('pdf.partials.css.portrait')
@include('pdf.partials.css.labels')
@php
// group the records in groups of 2
$records = $records->chunk(2);
@endphp
<div class="page page-labels">
  <table class="labels">
    @foreach($records as $group)
      <tr class="label-row {{ $loop->iteration > 0 && $loop->iteration % 5 == 0 ? 'is-last-row' : ''}}">
        @foreach($group as $record)
          <td class="label {{ $loop->index == 0 ? 'has-border-right' : ''}}">
            <div>
              <strong>{{ $record->artist->lastname }} {{ $record->artist->firstname }}</strong>
            </div>
            <div class="text-sm" style="margin-top: 4.5mm">
              <strong>{{ $record->inventory_number }}</strong>
            </div>
            <div style="margin-top: .5mm">
              <strong>{{ $record->description_de }}{{ $record->year ? ', ' . $record->year : '' }}</strong>
            </div>
            <div class="text-sm" style="margin-top: 4.5mm">
              <div style="margin-bottom: .5mm">{{ $record->artworkTechnique->description_de }}@if ($record->litho_number), {{ $record->litho_number }}@endif</div>
              <div style="margin-bottom: .5mm; margin-top: .5mm">{{ $record->dimensions ?? '' }}</div>
              <div style="margin-bottom: .5mm; margin-top: .5mm">{{ $record->artworkFrame->description_de ?? '' }}</div>
            </div>
            <div style="{{ $record->sale_price_internal > 0 && $record->sale_price_soll > 0 ? 'margin-top: 4mm' : 'margin-top: 8mm' }}">

              {{-- if (!empty($v->VK_PREIS_INTERN) && !empty($v->VK_PREIS_SOLL)) --}}
              @if ($record->sale_price_internal > 0 && $record->sale_price_soll > 0)
                <div class="text-sm">
                  Bisher CHF {{ number_format($record->sale_price_internal, 2, ".", "'"); }}
                </div>
                <div style="color: red; margin-top: 1mm">
                  <strong>JETZT CHF {{ number_format($record->sale_price_soll, 2, ".", "'"); }}</strong>
                </div>
              @else
                <strong>CHF {{ number_format($record->sale_price_internal, 2, ".", "'"); }}</strong>
              @endif
            </div>
          </td>
          @if ($loop->last && $group->count() == 1)
            <td class="label"></td>
          @endif
        @endforeach
      </tr>
    @endforeach
</table>

</div>
@include('pdf.partials.footer')