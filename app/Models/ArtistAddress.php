<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ArtistAddress extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'address',
    'address_additional',
    'street',
    'box',
    'zip',
    'city',
    'country',
    'phone',
    'phone_business',
    'fax',
    'artist_id',
    'user_id'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function artist(): BelongsTo
  {
    return $this->belongsTo(Artist::class);
  }

}
