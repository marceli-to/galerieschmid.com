<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArtworkFrame extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'id',
    'description_de',
    'description_en',
    'user_id'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}

