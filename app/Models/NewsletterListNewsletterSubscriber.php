<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class NewsletterListNewsletterSubscriber extends Model
{
  protected $table = 'newsletter_list_newsletter_subscriber';

  protected $fillable = [
    'list_id',
    'subscriber_id',
  ];

  public function list(): BelongsTo
  {
    return $this->belongsTo(NewsletterList::class);
  }

  public function subscriber(): BelongsTo
  {
    return $this->belongsTo(NewsletterSubscriber::class);
  }

}
