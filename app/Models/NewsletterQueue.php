<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterQueue extends Model
{
  use SoftDeletes;

  protected $table = 'newsletter_queue';

  protected $fillable = [
    'email',
    'errors',
    'processed',
    'processed_at',
    'newsletter_id',
    'newsletter_subscriber_id',
  ];

  protected $casts = [
    'processed_at' => 'datetime',
  ];

  public function newsletter(): BelongsTo
  {
    return $this->belongsTo(Newsletter::class);
  }

  public function subscriber(): BelongsTo
  {
    return $this->belongsTo(NewsletterSubscriber::class, 'newsletter_subscriber_id');
  }

  public function scopeProcessed($query)
  {
    return $query->where('processed', 1);
  }

  public function scopeUnprocessed($query)
  {
    return $query->where('processed', 0);
  }

  public function scopeProcessedCount($query, $newsletterId)
  {
    return $query->where('newsletter_id', $newsletterId)->where('processed', 1)->count();
  }
}
