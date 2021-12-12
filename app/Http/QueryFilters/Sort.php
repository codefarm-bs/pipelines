<?php

namespace App\Http\QueryFilters;

class Sort extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder->orderBy('name', request($this->filterName()));
    }
}
