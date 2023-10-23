<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterList extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'id',
    'description',
    'user_id',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function newsletterSubscribers(): BelongsToMany
  {
    return $this->belongsToMany(NewsletterSubscriber::class, 'newsletter_list_newsletter_subscriber', 'list_id', 'subscriber_id');
  }

  // get confirmed subscribers for a list
  public function confirmedSubscribers()
  {
    return $this->newsletterSubscribers()->where('confirmed', 1);
  }
}
