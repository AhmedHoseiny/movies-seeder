<?php

namespace Hoseiny\Movies\Traits;

trait Sortable
{

    public function scopeSort($query, $column, $sortType)
    {
        return $query->orderBy($column, $sortType);
    }
}
