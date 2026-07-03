<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug($model->{$model->slugSourceColumn()});
            }
        });

        static::updating(function ($model) {
            $source = $model->slugSourceColumn();
            if ($model->isDirty($source) && !$model->isDirty('slug')) {
                $model->slug = $model->generateUniqueSlug($model->{$source}, $model->id);
            }
        });
    }

    public function generateUniqueSlug(string $value, $ignoreId = null): string
    {
        $slug = Str::slug($value);
        $original = $slug;
        $count = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function slugSourceColumn(): string
    {
        return 'name';
    }
}