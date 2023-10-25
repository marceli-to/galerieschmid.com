<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Impression extends Model implements HasMedia
{
  use SoftDeletes, InteractsWithMedia;

  protected $fillable = [
    'id',
    'title',
    'position',
    'publish',
    'user_id',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function scopePublished($query)
  {
    return $query->where('publish', 1);
  }

  public function registerMediaConversions(Media $media = null): void
  {
    $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300)->nonQueued();
    $this->addMediaConversion('detail')->fit(Manipulations::FIT_MAX, 1600, 1200)->nonQueued();
  }

  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('impressions');
  }
}
