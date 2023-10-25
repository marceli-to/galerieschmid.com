<?php
namespace App\Actions\Exhibition;
use App\Models\Exhibition;

class GetExhibitionList
{
  public function execute()
  {

    return [
      'current'  => Exhibition::active()->upcoming()->first(),
      'upcoming' =>Exhibition::active()->upcoming()->get(),
      'archived' => Exhibition::active()->archived()->orderBy('date_start', 'DESC')->get()
    ];
    // dd($upcoming);
    // $exhibitions_temp = Exhibition::active()->get();
		// $exhibitions = [];	
		
		// foreach($exhibitions_temp as $e)
		// {
		// 	// prep exhibition images
		// 	$objects_temp = $this->ausstellungen->getObjekteActive($e['AUSSTELLUNGEN_ID']);
		// 	$objects      = array();
		// 	if (!empty($objects_temp))
		// 	{
		// 		foreach($objects_temp as $o)
		// 		{
		// 			$dims = '';
		// 			if ($o['HOEHE'] AND $o['BREITE'])
		// 			{
		// 				$dims = number_format($o['HOEHE']) . ' x ' . number_format($o['BREITE']);
		// 				if ($o['TIEFE'])
		// 				{
		// 					$dims .= ' x ' . number_format($o['TIEFE']);
		// 				}
		// 				$dims .= ' cm';
		// 			}					
					
		// 			$objects[] = array(
		// 				'id'			=> $o['OBJEKTE_ID'],
		// 				'title'			=> utf8_encode($o['objektTitel']),
		// 				'desc' 		 	=> utf8_encode($o['DESCRX']),
		// 				'technique'  	=> utf8_encode($o['TECHNIK']),
		// 				'attributes' 	=> utf8_encode($o['_attributes']),
		// 				'litho'		 	=> $o['LITHO_NR'],
		// 				'frame'		 	=> utf8_encode($o['RAHMEN']),
		// 				'date'		 	=> $o['DATUM_OBJEKT'],
		// 				'height' 	 	=> utf8_encode($o['HOEHE']),
		// 				'width' 	 	=> utf8_encode($o['BREITE']),
		// 				'depth' 	 	=> utf8_encode($o['TIEFE']),
		// 				'dims'		 	=> $dims,						
		// 				'image'			=> $o['BILD'],
		// 				'image_full'	=> $o['_bild'],
		// 			);
		// 		}
		// 	}

		// 	$start = strtotime($e['DATUM_VON']);
		// 	$end   = strtotime($e['DATUM_BIS']);
		// 	$now   = time();
		// 	$key   = '';
			
		// 	if (($start <= $now && $end >= $now) || ($start > $now && $end > $now))
		// 	{
		// 		$key = 'current_upcoming';
		// 	}

		// 	if ($start < $now && $end < $now)
		// 	{
		// 		$key = 'archive';
		// 	}				
			
		// 	// prep exhibition data
		// 	$exhibitions[$key][] = array(
		// 		'id' 			=> $e['AUSSTELLUNGEN_ID'],
		// 		'title' 		=> utf8_encode($e['TITEL']),
		// 		'subtitle' 		=> utf8_encode($e['SUBTITEL']),
		// 		'summary' 		=> utf8_encode($e['ZUSAMMENFASSUNG']),
		// 		'text' 			=> utf8_encode($e['TEXT']),
		// 		'dateFrom' 		=> $e['DATUM_VON'],
		// 		'dateTo' 		=> $e['DATUM_BIS'],
		// 		'datePeriod' 	=> utf8_encode($e['_datum_von_text']) . ' &mdash; ' . utf8_encode($e['_datum_bis_text']),
		// 		'isCurrent' 	=> $e['IS_CURRENT'],
		// 		'isArchive'		=> ($end < $now) ? TRUE : FALSE,
		// 		'url'			=> url_title(convert_accented_characters(utf8_encode($e['TITEL'])), '-', TRUE) . '/' . $e['AUSSTELLUNGEN_ID'] . '/',
		// 		'cover'			=> !empty($e['_cover']) ? $e['_cover'] : NULL,
		// 		'objects'		=> $objects
		// 	);
		// }
		
  }
}