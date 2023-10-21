<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class NewsletterArticle extends Model implements HasMedia
{
  use SoftDeletes, InteractsWithMedia;

  protected $fillable = [
    'id',
    'title',
    'text',
    'position',
    'newsletter_id',
    'user_id',
  ];

  public function newsletter(): BelongsTo
  {
    return $this->belongsTo(Newsletter::class);
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function registerMediaConversions(Media $media = null): void
  {
    $this
      ->addMediaConversion('preview')
      ->fit(Manipulations::FIT_CROP, 300, 300)
      ->nonQueued();
  }

  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('newsletter_articles');
  }

}
