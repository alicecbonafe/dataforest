<?php

namespace Dataforest\Traits;

trait WithSearch
{
    public $search = '';
    public $searchableColumns = [];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function applySearch($query)
    {
        if (empty($this->search)) {
            return $query;
        }

        return $query->where(function ($query) {
            foreach ($this->searchableColumns as $column) {
                $query->orWhere($column, 'like', '%' . $this->search . '%');
            }
        });
    }
}
