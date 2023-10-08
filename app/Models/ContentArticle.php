<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentArticle extends Model
{
  use SoftDeletes;
  
  protected $fillable = [
    'key',
    'title_de',
    'title_en',
    'text_de',
    'text_en',
    'user_id',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
