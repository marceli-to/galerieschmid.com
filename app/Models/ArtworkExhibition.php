<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ArtworkExhibition extends Model
{
  protected $table = 'artwork_exhibition';

  protected $fillable = [
    'artwork_id',
    'exhibition_id',
    'sort'
  ];

  public function artwork(): BelongsTo
  {
    return $this->belongsTo(Artwork::class);
  }

  public function exhibition(): BelongsTo
  {
    return $this->belongsTo(Exhibition::class);
  }

}
