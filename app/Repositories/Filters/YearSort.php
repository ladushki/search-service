<?php


namespace App\Repositories\Filters;

use Illuminate\Database\Eloquent\Builder;

class YearSort implements Filter
{
    /**
     * Apply a given search value to the builder instance.
     *
     * @param  Builder $builder
     * @param  mixed   $value
     * @return Builder $builder
     */
    public static function apply(Builder $builder, $value)
    {
        $direction = !in_array($value, ['desc', 'asc']) ? 'asc' : $value;

        return $builder->orderBy('year_of_purchase', $direction);
    }
}