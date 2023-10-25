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

class Artist extends Model implements HasMedia
{
  use SoftDeletes, InteractsWithMedia;

  protected $fillable = [
    'id',
    'salutation',
    'artist_name',
    'firstname',
    'lastname',
    'website',
    'biography_de',
    'biography_en',
    'bank_account',
    'mobile',
    'email',
    'newsletter_subscriber',
    'publish',
    'position',
    'artist_type_id',
    'user_id'
  ];

  protected $appends = [
    'fullname'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo(ArtistType::class);
  }

  public function addresses(): HasMany
  {
    return $this->hasMany(ArtistAddress::class);
  }

  public function publications(): HasMany
  {
    return $this->hasMany(ArtistPublication::class);
  }

  public function scopePublished($query)
  {
    return $query->where('publish', 1);
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
    $this->addMediaCollection('artist_portraits');
    $this->addMediaCollection('artist_files');
  }

  public function getFullnameAttribute(): string
  {
    return $this->firstname . ' ' . $this->lastname;
  }
}
