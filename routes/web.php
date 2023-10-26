<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\ExhibitionController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PdfController;
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

// Page routes
Route::get('/', [HomeController::class, 'index'])->name('page.home');

Route::get('/kuenstler', [ArtistController::class, 'index'])->name('page.artist');
Route::get('/kuenstler/werke/{slug?}/{artist}/{index?}', [ArtistController::class, 'works'])->name('page.artist.works');
Route::get('/kuenstler/{slug?}/{artist}', [ArtistController::class, 'show'])->name('page.artist.show');

Route::get('/ausstellungen', [ExhibitionController::class, 'index'])->name('page.exhibition');
Route::get('/ausstellungen/{slug?}/{exhibition?}', [ExhibitionController::class, 'show'])->name('page.exhibition.show');

Route::get('/ueber-uns', [AboutController::class, 'index'])->name('page.about');
Route::get('/kontakt', [ContactController::class, 'index'])->name('page.contact');
Route::get('/suche', [SearchController::class, 'index'])->name('page.search');

// Export routes
Route::get('/artwork-label', [PdfController::class, 'createArtworkLabel']);

// Newsletter routes
Route::get('/newsletter', [NewsletterController::class, 'index'])->name('page.newsletter');
Route::get('/newsletter/archiv/{newsletter}', [NewsletterController::class, 'archive'])->name('page.newsletter.archive');
Route::get('/newsletter/preview/{newsletter}', [NewsletterController::class, 'preview'])->name('page.newsletter.preview');

