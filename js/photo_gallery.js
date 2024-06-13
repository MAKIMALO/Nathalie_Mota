console.log("Le fichier photo_gallery.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.dropdown__switch');
    const options = document.querySelectorAll('.dropdown__select-option');
    const loadMoreButton = document.querySelector('.load_more');

    // Gestion des filtres
    options.forEach((option) => {
        option.addEventListener('click', () => {
            const label = option.closest('.dropdown').querySelector('.dropdown__filter-selected');
            label.textContent = option.textContent;
            label.dataset.value = option.dataset.value;

            option.closest('ul').querySelectorAll('.dropdown__select-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            option.classList.add('selected');
            applyFilters();
        });
    });

    toggles.forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const dropdown = toggle.closest('.dropdown');
            dropdown.classList.toggle('dropdown--open');
        });
    });

    document.addEventListener('click', (e) => {
        const element = e.target;

        if (!element.closest('.dropdown')) {
            toggles.forEach((toggle) => {
                toggle.checked = false;
                const dropdown = toggle.closest('.dropdown');
                dropdown.classList.remove('dropdown--open');
            });
        }
    });

    function applyFilters(page = 1) {
        const categorySwitch = document.querySelector('#category-switch');
        const formatSwitch = document.querySelector('#format-switch');
        const dateSwitch = document.querySelector('#date-switch');
    
        // Vérifier que les éléments existent avant d'accéder à closest
        const category = categorySwitch ? categorySwitch.closest('.dropdown').querySelector('.dropdown__filter-selected').dataset.value : '';
        const format = formatSwitch ? formatSwitch.closest('.dropdown').querySelector('.dropdown__filter-selected').dataset.value : '';
        const dateOrder = dateSwitch ? dateSwitch.closest('.dropdown').querySelector('.dropdown__filter-selected').dataset.value : '';
    
        const formData = new FormData();
        formData.append('action', 'load_photos');
        formData.append('category', category);
        formData.append('format', format);
        formData.append('date_order', dateOrder);
        formData.append('page', page);
        formData.append('per_page', 8);
    
        fetch(ajax_params.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (page === 1) {
                document.querySelector('.photos-gallery').innerHTML = data.html;
            } else {
                document.querySelector('.photos-gallery').innerHTML += data.html;
            }
            loadMoreButton.dataset.page = page;
            if (data.total > page * 8) {
                loadMoreButton.style.display = 'block';
            } else {
                loadMoreButton.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    applyFilters();

    // Gestion du bouton "Charger plus"
    loadMoreButton.addEventListener('click', () => {
        const currentPage = parseInt(loadMoreButton.dataset.page) || 1;
        const nextPage = currentPage + 1;

        applyFilters(nextPage);
    });
});