<?php

namespace Dataforest\Components;

use Livewire\Component;
use Dataforest\Traits\WithFiltering;
use Dataforest\Traits\WithPagination;
use Dataforest\Traits\WithSearch;
use Dataforest\Traits\WithSorting;

abstract class DataforestTable extends Component
{
    use WithPagination, WithSorting, WithFiltering, WithSearch;

    public $perPage = 10;
    public $perPageOptions = [10, 25, 50, 100];
    public $hiddenColumns = [];
    public $columnOrder = [];
    
    protected $listeners = ['refreshTable' => '$refresh'];

    abstract public function columns(): array;
    abstract public function query();

    public function mount()
    {
        $this->initializeColumnOrder();
    }

    public function initializeColumnOrder()
    {
        if (empty($this->columnOrder)) {
            $this->columnOrder = array_keys($this->columns());
        }
    }

    public function toggleColumn($columnName)
    {
        if (in_array($columnName, $this->hiddenColumns)) {
            $this->hiddenColumns = array_diff($this->hiddenColumns, [$columnName]);
        } else {
            $this->hiddenColumns[] = $columnName;
        }
    }

    public function reorderColumn($oldIndex, $newIndex)
    {
        $column = $this->columnOrder[$oldIndex];
        
        // Remove the column from its old position
        array_splice($this->columnOrder, $oldIndex, 1);
        
        // Insert the column at its new position
        array_splice($this->columnOrder, $newIndex, 0, [$column]);
    }

    public function getData()
    {
        $query = $this->query();
        
        // Apply search if applicable
        $query = $this->applySearch($query);
        
        // Apply filters if applicable
        $query = $this->applyFilters($query);
        
        // Apply sorting
        $query = $this->applySorting($query);
        
        // Apply pagination
        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('dataforest::components.table', [
            'data' => $this->getData(),
            'columns' => $this->columns(),
        ]);
    }
}