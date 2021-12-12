<?php

namespace App\Http\QueryFilters;

class RSearch extends Filter
{
    protected function applyFilter($builder)
    {
        $evalQueryValue = $this->getValue(request($this->filterName()));
        $relation = $evalQueryValue['key'];
        $searchKey = $evalQueryValue['value'];

        return $builder->wherehas($relation, function ($q) use ($searchKey) {
            return $q->where('name', 'like', '%' . $searchKey . '%');
        });
    }

    protected function getValue($queryValue): array
    {
        $exploded_value = explode('_', $queryValue);

        return [
            'key' => $exploded_value[0],
            'value' => $exploded_value[1]
        ];
    }
}
