<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Laravel\Scout\Searchable;

class Artwork extends Model implements HasMedia
{
  use SoftDeletes, InteractsWithMedia, Searchable;

  protected $fillable = [
    'id',
    'image',
    'inventory_number',
    'artist_inventory_number',
    'litho_number',
    'description_de',
    'description_en',
    'location',
    'height',
    'width',
    'depth',
    'diameter',
    'year',
    'date_in',
    'date_out',
    'date_sold',
    'date_billed',
    'purchase_price_soll',
    'purchase_price_ist',
    'purchase_price_frame',
    'sale_price_soll',
    'sale_price_ist',
    'sale_price_internal',
    'sale_price_frame',
    'show_exact_price',
    'discount',
    'info',
    'info_arttrade',
    'bank_account_number',
    'bank_account_info',
    'position',
    'publish',
    'artwork_state_id',
    'artwork_technique_id',
    'artwork_frame_id',
    'vat_type_id',
    'client_id',
    'previous_client',
    'inventory_state_id',
    'artist_id',
    'user_id',
  ];

  protected $casts = [
    'height' => 'decimal:2',
    'width' => 'decimal:2',
    'depth' => 'decimal:2',
    'purchase_price_soll' => 'decimal:2',
    'purchase_price_ist' => 'decimal:2',
    'purchase_price_frame' => 'decimal:2',
    'sale_price_soll' => 'decimal:2',
    'sale_price_ist' => 'decimal:2',
    'sale_price_internal' => 'decimal:2',
    'sale_price_frame' => 'decimal:2',
    'date_in' => 'date:d.m.Y',
    'date_out' => 'date:d.m.Y',
    'date_sold' => 'date:d.m.Y',
    'date_billed' => 'date:d.m.Y',
  ];

  protected $appends = [
    'dimensions',
    'description_full'
  ];

  /**
   * Get the indexable data array for the model.
   *
   * @return array<string, mixed>
   */
  public function toSearchableArray(): array
  { 
    return [
      'description_de' => $this->description_de,
      'description_en' => $this->description_en,
      'artist_inventory_number' => $this->artist_inventory_number,
      'inventory_number' => $this->inventory_number,
      'publish' => $this->publish,
    ];
  }

  public function shouldBeSearchable()
  {
    if ($this->publish && $this->artwork_state_id == 1)
    {
      return true;
    }
    return false;
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function artist(): BelongsTo
  {
    return $this->belongsTo(Artist::class);
  }

  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class);
  }

  public function attributes(): BelongsToMany
  {
    return $this->belongsToMany(Attribute::class, 'artwork_attribute')->withTimestamps();
  }

  public function artworkState(): BelongsTo
  {
    return $this->belongsTo(ArtworkState::class);
  }

  public function artworkTechnique(): BelongsTo
  {
    return $this->belongsTo(ArtworkTechnique::class);
  }

  public function artworkFrame(): BelongsTo
  {
    return $this->belongsTo(ArtworkFrame::class);
  }

  public function vatType(): BelongsTo
  {
    return $this->belongsTo(VatType::class);
  }

  public function inventoryState(): BelongsTo
  {
    return $this->belongsTo(InventoryState::class);
  }

  public function exhibitions(): BelongsToMany
  {
    return $this->belongsToMany(Exhibition::class, 'artwork_exhibition')->withPivot(['sort'])->withTimestamps();
  }

  public function additional_fields(): HasMany
  {
    return $this->hasMany(ArtworkAdditionalField::class);
  }

  public function registerMediaConversions(Media $media = null): void
  {
    $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300);
    $this->addMediaConversion('listing')->fit(Manipulations::FIT_MAX, 250, 600);
    $this->addMediaConversion('detail')->fit(Manipulations::FIT_MAX, 1200, 900);
  }

  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('artwork_images');
  }

  public function getDimensionsAttribute(): mixed
  {
    $dimensions = [];
    if ($this->height)
    {
      $dimensions[] = str_replace('.00', '', $this->height);
    }
    if ($this->width)
    {
      $dimensions[] = str_replace('.00', '', $this->width);
    }
    if ($this->depth)
    {
      $dimensions[] = str_replace('.00', '', $this->depth);
    }
    if ($this->diameter)
    {
      $dimensions[] = str_replace('.00', '', $this->diameter);
    }

    if (count($dimensions) === 0)
    {
      return NULL;
    }

    return implode('x', $dimensions) . ' cm';
  }

  public function getDescriptionFullAttribute(): string
  {
    return $this->description_de . ' ('. $this->inventory_number .')';
  }

}
