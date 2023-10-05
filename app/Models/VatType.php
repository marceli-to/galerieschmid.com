<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class VatType extends Model
{
  use HasTranslations, SoftDeletes;
  
  protected $fillable = [
    'display_name',
    'description',
    'user_id'
  ];

  public $translatable = [
    'description'
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
