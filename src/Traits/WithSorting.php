<?php

namespace Dataforest\Traits;

trait WithSorting
{
    public $sortField = '';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function applySorting($query)
    {
        if (!empty($this->sortField)) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query;
    }
}
