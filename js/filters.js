console.log("Le fichier filters.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.dropdown__switch');
    const options = document.querySelectorAll('.dropdown__select-option');
    const loadMoreButton = document.querySelector('.load_more');

    options.forEach((option) => {
        option.addEventListener('click', () => {
            const label = option.closest('.dropdown').querySelector('.dropdown__filter-selected');
            label.textContent = option.textContent;
            label.dataset.value = option.dataset.value;

            // Retirer la classe "selected" de tous les éléments frères
            option.closest('ul').querySelectorAll('.dropdown__select-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            // Ajouter la classe "selected" à l'élément cliqué
            option.classList.add('selected');

            // Appliquer les filtres lorsqu'une option est sélectionnée
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
        const category = document.querySelector('#category-switch').closest('.dropdown').querySelector('.dropdown__filter-selected').dataset.value;
        const format = document.querySelector('#format-switch').closest('.dropdown').querySelector('.dropdown__filter-selected').dataset.value;
        const dateOrder = document.querySelector('#date-switch').closest('.dropdown').querySelector('.dropdown__filter-selected').dataset.value;

        const formData = new FormData();
        formData.append('action', 'filter_photos');
        formData.append('category', category);
        formData.append('format', format);
        formData.append('date_order', dateOrder);
        formData.append('page', page);

        fetch(ajax_params.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector('.photos-gallery').innerHTML = data.html;
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

    // Initial load
    applyFilters();

    loadMoreButton.addEventListener('click', () => {
        const currentPage = parseInt(loadMoreButton.dataset.page) || 1;
        const nextPage = currentPage + 1;

        const category = document.querySelector('#category-switch').closest('.dropdown').querySelector('.dropdown__filter-selected').dataset.value;
        const format = document.querySelector('#format-switch').closest('.dropdown').querySelector('.dropdown__filter-selected').dataset.value;
        const dateOrder = document.querySelector('#date-switch').closest('.dropdown').querySelector('.dropdown__filter-selected').dataset.value;

        const formData = new FormData();
        formData.append('action', 'filter_photos');
        formData.append('category', category);
        formData.append('format', format);
        formData.append('date_order', dateOrder);
        formData.append('page', nextPage);

        fetch(ajax_params.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector('.photos-gallery').innerHTML += data.html;
            if (data.total > nextPage * 8) {
                loadMoreButton.style.display = 'block';
            } else {
                loadMoreButton.style.display = 'none';
            }
            loadMoreButton.dataset.page = nextPage;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});