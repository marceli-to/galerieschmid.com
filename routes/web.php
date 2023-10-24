<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Notification;
use App\Models\Newsletter;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});
Route::get('/artwork-label', [PdfController::class, 'createArtworkLabel']);


Route::get('/newsletter/preview/{newsletter}', function (Newsletter $newsletter) {
  $newsletter = Newsletter::with('articles.media')->find($newsletter->id);
  return view('pages.newsletter.preview', compact('newsletter'));
})->name('newsletter.preview');

