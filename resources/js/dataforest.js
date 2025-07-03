/**
 * Dataforest - Interactive Data Table
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize column reordering
    initColumnReordering();
    
    // Initialize dropdown functionality
    initDropdowns();
    
    // Listen for Livewire updates to reinitialize
    document.addEventListener('livewire:load', function() {
        initColumnReordering();
        initDropdowns();
    });
    
    document.addEventListener('livewire:update', function() {
        initColumnReordering();
        initDropdowns();
    });
});

/**
 * Initialize column reordering functionality
 */
function initColumnReordering() {
    const headers = document.querySelectorAll('.dataforest-table th[draggable="true"]');
    
    headers.forEach(header => {
        header.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', Array.from(headers).indexOf(header));
            header.classList.add('dataforest-dragging');
        });
        
        header.addEventListener('dragend', function() {
            header.classList.remove('dataforest-dragging');
        });
        
        header.addEventListener('dragover', function(e) {
            e.preventDefault();
            header.classList.add('dataforest-dragover');
        });
        
        header.addEventListener('dragleave', function() {
            header.classList.remove('dataforest-dragover');
        });
        
        header.addEventListener('drop', function(e) {
            e.preventDefault();
            header.classList.remove('dataforest-dragover');
            
            const oldIndex = parseInt(e.dataTransfer.getData('text/plain'));
            const newIndex = Array.from(headers).indexOf(header);
            
            // The actual reordering is handled by Livewire
            // This is just for visual feedback
            header.classList.add('dataforest-drop-highlight');
            setTimeout(() => {
                header.classList.remove('dataforest-drop-highlight');
            }, 300);
        });
    });
}

/**
 * Initialize dropdown functionality
 */
function initDropdowns() {
    const dropdowns = document.querySelectorAll('.dataforest-dropdown');
    
    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dataforest-dropdown-toggle');
        const menu = dropdown.querySelector('.dataforest-dropdown-menu');
        
        if (!toggle || !menu) return;
        
        // For mobile/touch devices, use click instead of hover
        if ('ontouchstart' in window) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close all other dropdowns
                document.querySelectorAll('.dataforest-dropdown-menu.active').forEach(activeMenu => {
                    if (activeMenu !== menu) {
                        activeMenu.classList.remove('active');
                    }
                });
                
                // Toggle current dropdown
                menu.classList.toggle('active');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target)) {
                    menu.classList.remove('active');
                }
            });
        }
    });
}

/**
 * Handle column visibility toggle
 * 
 * @param {string} columnName - The name of the column to toggle
 * @param {object} livewireComponent - The Livewire component instance
 */
function toggleColumnVisibility(columnName, livewireComponent) {
    livewireComponent.call('toggleColumn', columnName);
}

/**
 * Handle export functionality
 * 
 * @param {string} format - The export format (csv, excel, pdf)
 * @param {object} livewireComponent - The Livewire component instance
 */
function exportTable(format, livewireComponent) {
    livewireComponent.call('export', format);
}

/**
 * Refresh the table data
 * 
 * @param {object} livewireComponent - The Livewire component instance
 */
function refreshTable(livewireComponent) {
    livewireComponent.call('$refresh');
}

/**
 * Reset all filters
 * 
 * @param {object} livewireComponent - The Livewire component instance
 */
function resetFilters(livewireComponent) {
    livewireComponent.call('resetFilters');
}

/**
 * Set the number of items per page
 * 
 * @param {number} perPage - Number of items per page
 * @param {object} livewireComponent - The Livewire component instance
 */
function setPerPage(perPage, livewireComponent) {
    livewireComponent.set('perPage', perPage);
}

/**
 * Apply sorting to a column
 * 
 * @param {string} field - The field to sort by
 * @param {object} livewireComponent - The Livewire component instance
 */
function sortBy(field, livewireComponent) {
    livewireComponent.call('sortBy', field);
}

/**
 * Apply a filter to a column
 * 
 * @param {string} field - The field to filter
 * @param {string} value - The filter value
 * @param {object} livewireComponent - The Livewire component instance
 */
function applyFilter(field, value, livewireComponent) {
    livewireComponent.call('applyFilter', field, value);
}

/**
 * Set the search query
 * 
 * @param {string} query - The search query
 * @param {object} livewireComponent - The Livewire component instance
 */
function setSearch(query, livewireComponent) {
    livewireComponent.set('search', query);
}

/**
 * Utility function to add CSS classes to the Dataforest table
 * 
 * @param {string} selector - CSS selector for the element
 * @param {string} classes - CSS classes to add
 */
function addDataforestClasses(selector, classes) {
    const elements = document.querySelectorAll(selector);
    elements.forEach(element => {
        element.classList.add(...classes.split(' '));
    });
}

/**
 * Initialize responsive behavior for the table
 */
function initResponsiveBehavior() {
    const tables = document.querySelectorAll('.dataforest-table');
    
    tables.forEach(table => {
        const wrapper = table.closest('.dataforest-table-wrapper');
        if (!wrapper) return;
        
        // Check if table is wider than its container
        const checkOverflow = () => {
            if (table.offsetWidth > wrapper.offsetWidth) {
                wrapper.classList.add('dataforest-table-overflow');
            } else {
                wrapper.classList.remove('dataforest-table-overflow');
            }
        };
        
        // Check on load and on resize
        checkOverflow();
        window.addEventListener('resize', checkOverflow);
    });
}

// Initialize responsive behavior when DOM is loaded
document.addEventListener('DOMContentLoaded', initResponsiveBehavior);
