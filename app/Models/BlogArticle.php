<?php

namespace App\Models;

use App\Observers\BlogArticleObserver;
use Database\Factories\BlogArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Presence in the table means published; `slug` and `published_by` are set
 * by the observer and are therefore not mass assignable.
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $category
 * @property string $content
 * @property string $image
 * @property string $published_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['title', 'description', 'category', 'content', 'image'])]
#[ObservedBy(BlogArticleObserver::class)]
class BlogArticle extends Model
{
    /** @use HasFactory<BlogArticleFactory> */
    use HasFactory, HasUuids, SoftDeletes;
}
