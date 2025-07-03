<?php

namespace Dataforest\Traits;

trait WithFiltering
{
    public $filters = [];

    public function applyFilter($field, $value)
    {
        if (empty($value)) {
            unset($this->filters[$field]);
        } else {
            $this->filters[$field] = $value;
        }
    }

    public function resetFilters()
    {
        $this->filters = [];
    }

    public function applyFilters($query)
    {
        foreach ($this->filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }

        return $query;
    }
}
