/**
 * Dataforest - Interactive Data Table
 */
document.addEventListener('livewire:load', function () {
    initDataforest();
});

document.addEventListener('livewire:update', function () {
    initDataforest();
});

function initDataforest() {
    // Initialize column reordering
    initColumnReordering();
    
    // Initialize dropdowns
    initDropdowns();
}

/**
 * Initialize column reordering functionality
 */
function initColumnReordering() {
    const headers = document.querySelectorAll('.dataforest-table th[draggable="true"]');
    
    headers.forEach(header => {
        header.addEventListener('dragstart', e => {
            e.dataTransfer.setData('text/plain', Array.from(headers).indexOf(header));
        });
    });
}

/**
 * Initialize dropdown functionality
 */
function initDropdowns() {
    document.querySelectorAll('.dataforest-dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function (event) {
            event.stopPropagation();
            const menu = this.nextElementSibling;
            
            // Close all other dropdowns
            document.querySelectorAll('.dataforest-dropdown-menu.active').forEach(openMenu => {
                if (openMenu !== menu) {
                    openMenu.classList.remove('active');
                }
            });

            menu.classList.toggle('active');
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function (event) {
        document.querySelectorAll('.dataforest-dropdown-menu.active').forEach(menu => {
            if (!menu.parentElement.contains(event.target)) {
                menu.classList.remove('active');
            }
        });
    });
}
