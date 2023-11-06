<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Laravel\Scout\Searchable;

class Exhibition extends Model implements HasMedia
{
  use SoftDeletes, InteractsWithMedia, Searchable;

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

  protected $appends = [
    'periode'
  ];

  /**
   * Get the indexable data array for the model.
   *
   * @return array<string, mixed>
   */
  public function toSearchableArray(): array
  { 
    return [
      'id' => (int) $this->id,
      'title_de' => $this->title_de,
      'subtitle_de' => $this->subtitle_de,
      'summary_de' => $this->summary_de,
      'text_de' => $this->text_de,
      'keywords_de' => $this->keywords_de,
      'title_en' => $this->title_en,
      'subtitle_en' => $this->subtitle_en,
      'summary_en' => $this->summary_en,
      'text_en' => $this->text_en,
      'keywords_en' => $this->keywords_en,
      'active' => $this->active
    ];
  }

  public function shouldBeSearchable()
  {
    if ($this->active)
    {
      return true;
    }
    return false;
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function artworks(): BelongsToMany
  {
    return $this->belongsToMany(Artwork::class, 'artwork_exhibition')->where('artwork_state_id', 1)->withPivot(['sort'])->withTimestamps();
  }

  public function scopeActive($query)
  {
    return $query->where('active', 1);
  }

  public function scopeUpcoming($query)
  {
    return $query->where('date_start', '<=', now())
      ->where('date_end', '>=', now())
      ->orWhere('date_start', '>', now())
      ->where('date_end', '>', now());
  }

  public function scopeArchived($query)
  {
    return $query->where('date_start', '<', now())->where('date_end', '<', now());
  }

  public function getPeriodeAttribute()
  {
    if ($this->date_start && $this->date_end)
    {
      return \Carbon\Carbon::parse($this->date_start)->translatedFormat('j. F Y') . ' &mdash; ' . \Carbon\Carbon::parse($this->date_end)->translatedFormat('j. F Y');
    }
  }

  public function registerMediaConversions(Media $media = null): void
  {
    $this->addMediaConversion('preview')->fit(Manipulations::FIT_CROP, 300, 300);
    $this->addMediaConversion('cover')->fit(Manipulations::FIT_MAX, 1200, 900);
  }

  public function registerMediaCollections(): void
  {
    $this->addMediaCollection('exhibition_cover');
  }

}
