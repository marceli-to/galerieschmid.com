<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'id',
    'title',
    'active',
    'show_in_archive',
    'language_id',
    'user_id',
    'sent_at',
    'created_at',
  ];

  protected $casts = [
    'created_at' => 'date:d.m.Y',
    'sent_at' => 'date:d.m.Y',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function articles(): HasMany
  {
    return $this->hasMany(NewsletterArticle::class);
  }

  public function language(): BelongsTo
  {
    return $this->belongsTo(NewsletterLanguage::class);
  }

  public function queued(): HasMany
  {
    return $this->hasMany(NewsletterQueue::class);
  }

  public function processed(): HasMany
  {
    return $this->hasMany(NewsletterQueue::class)->where('processed', '1');
  }

  public function scopeArchive($query)
  {
    return $query->where('show_in_archive', '1')->where('created_at', '>=', now()->subYears(3))->orderBy('created_at', 'desc');
  }
}
