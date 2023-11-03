@include('pdf.partials.header')
@include('pdf.partials.css.landscape')
@include('pdf.partials.css.list')
<div class="page page-list">
  <table class="list-table">
    <tr>
      <td class="valign-bottom">
        <h1 class="list-artist">
          {{ $records[0]->artist->lastname }} {{ $records[0]->artist->firstname }}
        </h1>
      </td>
      <td class="align-right valign-bottom" style="vertical-align: bottom; text-align: right">
        <div class="list-date">
          {{ date('d.m.Y', time()) }}
        </div>
      </td>
    </tr>
  </table>
  <table class="list-table list-table--records" style="margin-top: 10mm; page-break-inside: auto">
    <thead>
      <tr>
        <td><strong>Inv.-Nr.</strong></td>
        <td><strong>Kü-Nr.</strong></td>
        <td><strong>Titel</strong></td>
        <td><strong>Jahr</strong></td>
        <td><strong>Dimensionen</strong></td>
        <td><strong>Technik</strong></td>
        <td><strong>Eingang</strong></td>
        <td class="align-right"><strong>VK-Preis</strong></td>
        <td class="align-right" style="padding-right: 0; min-width: 15mm"><strong>Bemerkungen</strong></td>
      </tr>
    </thead>
    @foreach ($records as $record)
      <tr class="{{ $loop->even ? 'even' : 'odd' }}">
        <td>{{ $record->inventory_number }}</td>
        <td>{{ $record->artist_inventory_number }}</td>
        <td>{{ $record->description_de }}</td>
        <td>{{ $record->year }}</td>
        <td>{{ $record->dimensions }}</td>
        <td>{{ $record->artworkTechnique->description_de}}</td>
        <td>{{ $record->date_in ? date('d.m.Y', strtotime($record->date_in)) : '' }}</td>
        <td class="align-right">{{ $record->sale_price_internal > 0 ? $record->sale_price_internal : '' }}</td>
        <td style="padding-right: 0"></td>
      </tr>
    @endforeach
  </table>
</div>
<script type="text/php">
  if ( isset($pdf) ) {
    $date = date('d.m.Y', time());
    $font = $fontMetrics->get_font("AvenirNextLTW01-Medium", "normal");
    $pdf->page_text(43, 555, "Galerie Schmid, Zug", $font, 9, array(0,0,0));
    $pdf->page_text(764, 555, "Seite {PAGE_NUM}/{PAGE_COUNT}", $font, 9, array(0,0,0));
  }
</script>
@include('pdf.partials.footer')