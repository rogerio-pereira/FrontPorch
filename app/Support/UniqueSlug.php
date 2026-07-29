<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class UniqueSlug
{
    /**
     * Build a slug from the given title that is unique for the model class.
     *
     * Soft-deleted rows are taken into account so a restored record never
     * collides with a slug that was taken in the meantime.
     *
     * @param  class-string<Model>  $modelClass
     */
    public static function uniqueSlug(string $title, string $modelClass, ?string $ignoreId = null): string
    {
        $base = Str::slug($title);

        if ($base === '') {
            $base = 'item';
        }

        $slug = $base;
        $suffix = 2;

        while (self::exists($slug, $modelClass, $ignoreId)) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    /**
     * Determine whether the slug is already taken by another record.
     *
     * @param  class-string<Model>  $modelClass
     */
    protected static function exists(string $slug, string $modelClass, ?string $ignoreId): bool
    {
        $model = new $modelClass;

        /** @var Builder<Model> $query */
        $query = $model->newQuery()->withoutGlobalScope(SoftDeletingScope::class);

        $query->where('slug', $slug);

        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}
