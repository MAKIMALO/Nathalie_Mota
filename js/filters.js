console.log("le fichier filters.js fonctionne");

// Change option selected
const labels = document.querySelectorAll('.dropdown__filter-selected');
const options = document.querySelectorAll('.dropdown__select-option');

options.forEach((option) => {
    option.addEventListener('click', () => {
        const label = option.closest('.dropdown').querySelector('.dropdown__filter-selected');
        label.textContent = option.textContent;
        label.dataset.value = option.dataset.value;

        // Trigger a change event
        const event = new Event('change');
        label.dispatchEvent(event);
    });
});

// Close dropdown onclick outside
document.addEventListener('click', (e) => {
    const toggles = document.querySelectorAll('.dropdown__switch');
    const element = e.target;

    if (Array.from(toggles).includes(element)) return;

    const isDropdownChild = element.closest('.dropdown__filter');
    
    if (!isDropdownChild) {
        toggles.forEach(toggle => toggle.checked = false);
    }
});

jQuery(document).ready(function($) {
    function applyFilters() {
        var category = $('#category-switch').closest('.dropdown').find('.dropdown__filter-selected').data('value');
        var format = $('#format-switch').closest('.dropdown').find('.dropdown__filter-selected').data('value');
        var dateOrder = $('#date-switch').closest('.dropdown').find('.dropdown__filter-selected').data('value');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'filter_photos',
                category: category,
                format: format,
                date_order: dateOrder,
            },
            success: function(response) {
                $('.photos-gallery').html(response);
            }
        });
    }

    // Apply filters when a dropdown option is selected
    $('.dropdown__filter-selected').on('change', function() {
        applyFilters();
    });
});