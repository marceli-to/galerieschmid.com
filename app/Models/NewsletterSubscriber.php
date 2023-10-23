<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class NewsletterSubscriber extends Model
{

  protected $fillable = [
    'id',
    'firstname',
    'lastname',
    'email',
    'hash',
    'salutation',
    'confirmed',
    'active',
    'confirmed_at',
    'created_at',
    'language_id',
    'user_id',
  ];

  protected $casts = [
    'confirmed_at' => 'date:d.m.Y',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function language(): BelongsTo
  {
    return $this->belongsTo(Language::class);
  }

  public function newsletterLists(): BelongsToMany
  {
    return $this->belongsToMany(NewsletterList::class, 'newsletter_list_newsletter_subscriber', 'subscriber_id', 'list_id')->withTimestamps();
  }

}
