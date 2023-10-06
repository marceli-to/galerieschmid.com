<?php
namespace App\Http\Controllers;
use App\Services\Pdf\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
  protected $headers = [
    'Content-Type: application/pdf',
    'Cache-Control: no-store, no-cache, must-revalidate',
    'Expires: Sun, 01 Jan 2014 00:00:00 GMT',
    'Pragma: no-cache'
  ];

  /**
   * Generate and download a pdf
   * 
   * @return \Illuminate\Http\Response
   */
  public function createArtworkLabel()
  { 
    $pdf = (new Pdf())->create([
      'data' => '',
      'view' => 'artwork-label',
      'name' => 'galerieschmid-artwork-label'
    ]);
    return response()->download($pdf['path'], $pdf['name'], $this->headers);
  }

}
