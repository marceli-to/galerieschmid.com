<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArtworkAdditionalField extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'description',
    'artwork_id',
    'user_id'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function artwork(): BelongsTo
  {
    return $this->belongsTo(Artwork::class);
  }
}
