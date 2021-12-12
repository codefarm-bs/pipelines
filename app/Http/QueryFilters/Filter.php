<?php

namespace App\Http\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle(Builder $builder, Closure $next)
    {
        if (request()->has($this->filterName())) {
            return $this->applyFilter($next($builder));
        }

        return $next($builder);
    }

    protected function filterName(): string
    {
        return Str::snake(class_basename($this));
    }

    protected abstract function applyFilter($builder);

}
