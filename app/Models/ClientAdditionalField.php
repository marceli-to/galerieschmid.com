<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ClientAdditionalField extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'description',
    'client_id',
    'user_id'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class);
  }
}
