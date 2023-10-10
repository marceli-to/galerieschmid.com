<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'id',
    'description_de',
    'description_en',
    'attribute_group_id',
    'user_id'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function attributeGroup(): BelongsTo
  {
    return $this->belongsTo(AttributeGroup::class);
  }

  public function artworks(): BelongsToMany
  {
    return $this->belongsToMany(Artwork::class, 'artwork_attribute')->withTimestamps();
  }
}
