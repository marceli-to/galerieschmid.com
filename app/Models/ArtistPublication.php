<?php
namespace App\Models;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArtistPublication extends Model implements HasMedia
{
  use SoftDeletes, InteractsWithMedia;

  protected $fillable = [
    'id',
    'title_de',
    'title_en',
    'text_de',
    'text_en',
    'publish',
    'artist_id',
    'user_id'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function artist(): BelongsTo
  {
    return $this->belongsTo(Artist::class);
  }

  public function registerMediaConversions(Media $media = null): void
  {
    $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300);
    $this->addMediaConversion('cover')->fit(Manipulations::FIT_MAX, 600, 600);
  }

  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('artist_publications');
  }

}
