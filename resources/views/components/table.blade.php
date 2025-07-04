@assets
<script src="{{ asset('vendor/dataforest/js/dataforest.js') }}" defer></script>
<link href="{{ asset('vendor/dataforest/css/dataforest.css') }}" rel="stylesheet" />
@endassets

<div class="dataforest-table-wrapper">
    <div class="dataforest-header">
        <div class="dataforest-search">
            <input 
                type="text" 
                wire:model.debounce.300ms="search" 
                placeholder="Search..." 
                class="dataforest-search-input"
            />
        </div>
        
        <div class="dataforest-per-page">
            <select wire:model="perPage" class="dataforest-select">
                @foreach($this->perPageOptions as $option)
                    <option value="{{ $option }}">{{ $option }} per page</option>
                @endforeach
            </select>
        </div>
        
        <div class="dataforest-dropdown">
            <button class="dataforest-dropdown-toggle" onclick="toggleDropdown(this)">
                Columns
            </button>
            <div class="dataforest-dropdown-menu">
                @foreach($columns as $name => $column)
                    <label class="dataforest-dropdown-item">
                        <input 
                            type="checkbox" 
                            wire:click="toggleColumn('{{ $name }}')"
                            @if(!in_array($name, $this->hiddenColumns)) checked @endif
                        />
                        {{ $column->label }}
                    </label>
                @endforeach
            </div>
        </div>
        
        @if(config('dataforest.features.export', true))
        <div class="dataforest-dropdown">
            <button class="dataforest-dropdown-toggle" onclick="toggleDropdown(this)">
                Export
            </button>
            <div class="dataforest-dropdown-menu">
                @foreach(config('dataforest.export.formats', ['csv', 'excel', 'pdf']) as $format)
                    <button class="dataforest-dropdown-item" wire:click="export('{{ $format }}')">
                        {{ strtoupper($format) }}
                    </button>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="dataforest-table-container">
        <table class="dataforest-table">
            <thead>
                <tr>
                    @foreach($this->columnOrder as $columnName)
                        @if(!in_array($columnName, $this->hiddenColumns))
                            <th 
                                @if(isset($columns[$columnName]->sortable) && $columns[$columnName]->sortable)
                                    wire:click="sortBy('{{ $columns[$columnName]->field ?? '' }}')"
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
                                    <span class="dataforest-sort-icon">
                                        @if($this->sortDirection === 'asc')
                                            &#9650;
                                        @else
                                            &#9660;
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
                                        class="dataforest-filter-input"
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
                        <td colspan="{{ count($columns) - count($this->hiddenColumns) }}" class="dataforest-empty">
                            {{ config('dataforest.empty_message', 'No records found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(config('dataforest.features.pagination', true))
    <div class="dataforest-footer">
        <div class="dataforest-pagination">
            {{ $data->links('dataforest::pagination') }}
        </div>
    </div>
    @endif
</div>

<script>
    function toggleDropdown(element) {
        const menu = element.nextElementSibling;
        menu.classList.toggle('active');
    }

    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dataforest-dropdown');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target)) {
                dropdown.querySelector('.dataforest-dropdown-menu').classList.remove('active');
            }
        });
    });
</script>
