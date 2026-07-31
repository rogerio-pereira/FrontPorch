<?php

namespace App\Models;

use App\Observers\CaseStudyObserver;
use Database\Factories\CaseStudyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $client
 * @property string $industry
 * @property string $challenge
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['title', 'description', 'client', 'industry', 'challenge', 'content'])]
#[ObservedBy(CaseStudyObserver::class)]
class CaseStudy extends Model
{
    /** @use HasFactory<CaseStudyFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The gallery images, ordered so the first one is the cover.
     *
     * @return HasMany<CaseStudyImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(CaseStudyImage::class)
                    ->orderBy('sort_order');
    }

    /**
     * The services delivered on this case study.
     *
     * @return BelongsToMany<Service, $this>
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'case_study_service')
                    ->withTimestamps();
    }

    /**
     * The lowest sorted gallery image, used as cover on listings and home.
     */
    public function coverImage(): ?CaseStudyImage
    {
        return $this->images()->first();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }
}
