<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArtworkFrame extends Model
{
  use HasTranslations, SoftDeletes;

  protected $fillable = [
    'id',
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

  public static function rules($locale = null)
  {
    $rules = [
      'description' => ['required_if:locale,' . $locale],
    ];
    return $rules;
  }

}

