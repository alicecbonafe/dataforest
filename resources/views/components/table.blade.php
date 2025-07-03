<div class="card">
    <div class="card-header py-3">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="input-group">
                    <input 
                        type="text" 
                        wire:model.debounce.300ms="search" 
                        placeholder="Search..." 
                        class="form-control"
                    />
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>
            
            <div class="col-md-2">
                <select wire:model="perPage" class="form-select">
                    @foreach($this->perPageOptions as $option)
                        <option value="{{ $option }}">{{ $option }} per page</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="columnToggleDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Columns
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="columnToggleDropdown">
                        @foreach($columns as $name => $column)
                            <li>
                                <div class="dropdown-item">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            id="column-{{ $name }}"
                                            wire:click="toggleColumn('{{ $name }}')"
                                            @if(!in_array($name, $this->hiddenColumns)) checked @endif
                                        />
                                        <label class="form-check-label" for="column-{{ $name }}">
                                            {{ $column->label }}
                                        </label>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            @if(config('dataforest.features.export', true))
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Export
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                        @foreach(config('dataforest.export.formats', ['csv', 'excel', 'pdf']) as $format)
                            <li>
                                <button class="dropdown-item" wire:click="export('{{ $format }}')">
                                    {{ strtoupper($format) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        @foreach($this->columnOrder as $columnName)
                            @if(!in_array($columnName, $this->hiddenColumns))
                                <th 
                                    @if(isset($columns[$columnName]->sortable) && $columns[$columnName]->sortable)
                                        wire:click="sortBy('{{ $columns[$columnName]->field ?? '' }}')"
                                        class="{{ $this->sortField === ($columns[$columnName]->field ?? '') ? 'table-active' : '' }}"
                                        style="cursor: pointer;"
                                    @endif
                                    draggable="true"
                                    wire:key="column-{{ $columnName }}"
                                    @if(config('dataforest.features.column_reordering', true))
                                        ondragstart="event.dataTransfer.setData('text/plain', {{ $loop->index }})"
                                        ondragover="event.preventDefault()"
                                        ondrop="
                                            event.preventDefault();
                                            const oldIndex = event.dataTransfer.getData('text/plain');
                                            @this.reorderColumn(oldIndex, {{ $loop->index }})
                                        "
                                    @endif
                                >
                                    {{ $columns[$columnName]->label }}
                                    
                                    @if($this->sortField === ($columns[$columnName]->field ?? ''))
                                        <span class="ms-1">
                                            @if($this->sortDirection === 'asc')
                                                <i class="bi bi-arrow-up"></i>
                                            @else
                                                <i class="bi bi-arrow-down"></i>
                                            @endif
                                        </span>
                                    @endif
                                </th>
                            @endif
                        @endforeach
                    </tr>
                    
                    @if(config('dataforest.features.filtering', true))
                    <tr>
                        @foreach($this->columnOrder as $columnName)
                            @if(!in_array($columnName, $this->hiddenColumns))
                                <th>
                                    @if(isset($columns[$columnName]->filterable) && $columns[$columnName]->filterable)
                                        <input 
                                            type="text" 
                                            wire:model.debounce.300ms="filters.{{ $columns[$columnName]->field }}" 
                                            placeholder="Filter..." 
                                            class="form-control form-control-sm"
                                        />
                                    @endif
                                </th>
                            @endif
                        @endforeach
                    </tr>
                    @endif
                </thead>
                
                <tbody>
                    @forelse($data as $row)
                        <tr wire:key="row-{{ $row->id }}">
                            @foreach($this->columnOrder as $columnName)
                                @if(!in_array($columnName, $this->hiddenColumns))
                                    <td>
                                        @if(isset($columns[$columnName]->view) && !is_null($columns[$columnName]->view))
                                            @include($columns[$columnName]->view, ['row' => $row])
                                        @elseif(isset($columns[$columnName]->format) && !is_null($columns[$columnName]->format))
                                            {!! $columns[$columnName]->format($row) !!}
                                        @else
                                            {{ $row->{$columns[$columnName]->field ?? ''} }}
                                        @endif
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) - count($this->hiddenColumns) }}" class="text-center py-3">
                                {{ config('dataforest.empty_message', 'No records found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if(config('dataforest.features.pagination', true))
    <div class="card-footer">
        <div class="d-flex justify-content-center">
            {{ $data->links() }}
        </div>
    </div>
    @endif
</div>
