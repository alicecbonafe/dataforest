<?php

namespace Dataforest\Traits;

use Livewire\WithPagination as LivewireWithPagination;

trait WithPagination
{
    use LivewireWithPagination;

    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
