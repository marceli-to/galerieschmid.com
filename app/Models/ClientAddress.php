<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
  use SoftDeletes;

  protected $fillable = [
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
    'primary',
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
