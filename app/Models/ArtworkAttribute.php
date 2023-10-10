<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ArtworkAttribute extends Model
{
  protected $table = 'artwork_attribute';

  protected $fillable = [
    'artwork_id',
    'attribute_id',
  ];

  public function artwork(): BelongsTo
  {
    return $this->belongsTo(Artwork::class);
  }

  public function attribute(): BelongsTo
  {
    return $this->belongsTo(Attribute::class);
  }

}
