<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exhibition extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'id',
    'name',
    'title_de',
    'title_en',
    'subtitle_de',
    'subtitle_en',
    'summary_de',
    'summary_en',
    'text_de',
    'text_en',
    'keywords_de',
    'keywords_en',
    'date_start',
    'date_end',
    'date_show_from',
    'date_show_to',
    'active',
  ];

  protected $casts = [
    'date_start' => 'date:d.m.Y',
    'date_end' => 'date:d.m.Y',
    'date_show_from' => 'date:d.m.Y',
    'date_show_to' => 'date:d.m.Y',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function artworks(): BelongsToMany
  {
    return $this->belongsToMany(Artwork::class, 'artwork_exhibition')->withPivot(['position'])->withTimestamps();
  }

}
