<?php

namespace App\Traits;

use App\Filters\FiltersBetween;
use App\Filters\FiltersContains;
use App\Filters\FiltersEquals;
use App\Filters\FiltersGreaterOrEquals;
use App\Filters\FiltersIn;
use App\Filters\FiltersStartsWith;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;

trait Filterable
{
    const DATE_RANGES = [
        'created_at',
        'updated_at',
        'started_at',
        'ended_at',
    ];

    private function queryFilter(array $filters = [])
    {
        foreach (self::DATE_RANGES as $dateField) {
            $filters[] = AllowedFilter::callback($dateField, function ($query, $value) use ($dateField) {
                if (is_array($value) && count($value) === 2) {
                    $query->whereBetween($dateField, [$value[0], $value[1]]);
                }
            });
        }

        return $filters;
    }

    private function customqueryFilter(array $filters = [], array $queryFilters = [])
    {
        foreach ($queryFilters as $key => $value) {
            $filterKey = 'filter.'.$key;
            if (request()->has($filterKey)) {
                if (Str::contains($key, '_contains')) {
                    $dbField = Str::replaceLast('_contains', '', $key);
                    $filters[] = AllowedFilter::custom($key, new FiltersContains($dbField));
                } elseif (Str::contains($key, '_startswith')) {
                    $dbField = Str::replaceLast('_startswith', '', $key);
                    $filters[] = AllowedFilter::custom($key, new FiltersStartsWith($dbField));
                } elseif (Str::contains($key, '_between')) {
                    $dbField = Str::replaceLast('_between', '', $key);
                    $filters[] = AllowedFilter::custom($key, new FiltersBetween($dbField));
                } elseif (Str::contains($key, '_in')) {
                    $dbField = Str::replaceLast('_in', '', $key);
                    $filters[] = AllowedFilter::custom($key, new FiltersIn($dbField));
                } elseif (Str::contains($key, '_gte')) {
                    $dbField = Str::replaceLast('_gte', '', $key);
                    $filters[] = AllowedFilter::custom($key, new FiltersGreaterOrEquals($dbField));
                } else {
                    $dbField = $key;
                    $filters[] = AllowedFilter::custom($key, new FiltersEquals($dbField));
                }
            }
        }

        return $filters;
    }
}
