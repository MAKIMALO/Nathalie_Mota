console.log("Le fichier photo_gallery.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
    const photosGallery = document.querySelector('.photos-gallery');
    const loadMoreButton = document.querySelector('.load_more');
    const options = document.querySelectorAll('.dropdown__select-option');

    // Gestion du bouton "Charger plus"
    if (loadMoreButton) {
        loadMoreButton.addEventListener('click', () => {
            const currentPage = parseInt(loadMoreButton.dataset.page) || 1;
            const nextPage = currentPage + 1;

            loadPhotos(nextPage); // Charger plus de photos
        });
    }

    // Fonction pour charger les photos via AJAX
    function loadPhotos(page = 1) {
        const categorySwitch = document.querySelector('#category-switch');
        const formatSwitch = document.querySelector('#format-switch');
        const dateSwitch = document.querySelector('#date-switch');

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
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur HTTP ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                if (photosGallery) {
                    if (page === 1) {
                        photosGallery.innerHTML = data.html;
                    } else {
                        photosGallery.insertAdjacentHTML('beforeend', data.html);
                    }
                } else {
                    console.error('Element .photos-gallery not found');
                }

                loadMoreButton.dataset.page = page;
                if (data.total > page * 8) {
                    loadMoreButton.style.display = 'block';
                } else {
                    loadMoreButton.style.display = 'none';
                }
            } else {
                console.error('Erreur lors du chargement des photos : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur lors de la requête AJAX : ', error);
        });
    }

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
            loadPhotos(1); // Recharger les photos depuis la première page après application des filtres
        });
    });
});