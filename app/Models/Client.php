<?php
namespace App\Models;
use App\Enums\Gallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
  use SoftDeletes;

  protected $casts = [
    'gallery' => Gallery::class,
  ];

  protected $fillable = [
    'id',
    'salutation',
    'gallery',
    'alfa',
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
    'mobile',
    'email',
    'newsletter_subscriber',
    'language',
    'letter_salutation',
    'remarks',
    'invitations',
    'artists',
    'active',
    'user_id'
  ];

  protected $append = [
    'fullname'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function artists(): HasMany
  {
    return $this->hasMany(Artist::class);
  }

  public function addresses(): HasMany
  {
    return $this->hasMany(ClientAddress::class);
  }
  
  public function additional_fields(): HasMany
  {
    return $this->hasMany(ClientAdditionalField::class);
  }

  public function getFullnameAttribute(): string
  {
    if (!$this->firstname && !$this->lastname)
    {
      return $this->alfa;
    }
    return $this->firstname . ' ' . $this->lastname;
  }
}
