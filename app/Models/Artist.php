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
use Laravel\Scout\Searchable;

class Artist extends Model implements HasMedia
{
  use SoftDeletes, InteractsWithMedia, Searchable;

  protected $fillable = [
    'id',
    'salutation',
    'artist_name',
    'firstname',
    'lastname',
    'address',
    'address_additional',
    'street',
    'box',
    'zip',
    'city',
    'state',
    'country',
    'phone',
    'phone_business',
    'fax',
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

  /**
   * Get the indexable data array for the model.
   *
   * @return array<string, mixed>
   */
  public function toSearchableArray(): array
  { 
    return [
      'artist_name' => $this->artist_name,
      'firstname' => $this->firstname,
      'lastname' => $this->lastname,
      'biography_de' => $this->biography_de,
      'publish' => $this->publish,
    ];
  }

  public function shouldBeSearchable()
  {
    if ($this->publish)
    {
      return true;
    }
    return false;
  }

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

  public function artworksActive(): HasMany
  {
    return $this->hasMany(Artwork::class)->orderBy('position')->orderBy('id', 'DESC')->where('artwork_state_id', 1)->where('publish', 1);
  }

  public function artworks(): HasMany
  {
    return $this->hasMany(Artwork::class)->orderBy('position')->orderBy('id', 'DESC');
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
      ;
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
