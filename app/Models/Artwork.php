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

class Artwork extends Model implements HasMedia
{
  use SoftDeletes, InteractsWithMedia;

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
    'bank_account_number',
    'bank_account_info',
    'order',
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
    'date_in' => 'date:Y-m-d',
    'date_out' => 'date:Y-m-d',
    'date_sold' => 'date:Y-m-d',
    'date_billed' => 'date:Y-m-d',
  ];

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

  public function additional_fields(): HasMany
  {
    return $this->hasMany(ArtworkAdditionalField::class);
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
    $this->addMediaCollection('artwork_images');
  }

}
