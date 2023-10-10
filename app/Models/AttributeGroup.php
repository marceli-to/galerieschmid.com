<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeGroup extends Model
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

  public function attributes(): HasMany
  {
    return $this->hasMany(Attribute::class);
  }
}
