<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterLanguage extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'id',
    'acronym',
    'description',
    'user_id',
  ];

  public function newsletters(): HasMany
  {
    return $this->hasMany(Newsletter::class);
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
