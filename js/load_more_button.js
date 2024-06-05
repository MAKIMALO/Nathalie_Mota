console.log("le fichier load_more_button.js fonctionne");

// Ouverture sur le bouton "Charger plus" de la page "front-page.php"
jQuery(document).ready(function($) {
    var page = 1;
    var per_page = 8;
    var loadedPhotos = [];
    var isLoading = false;


    // Initialiser loadedPhotos avec les IDs des photos déjà chargées
    $('.photos-gallery .photo-block').each(function() {
        var photoId = $(this).data('photo-id');
        if (photoId) {
            loadedPhotos.push(photoId);
        }
    });

    console.log('Initial loaded photos:', loadedPhotos);

    $('.load_more').click(function(e) {
        e.preventDefault();  // Empêche le comportement par défaut du bouton
        if (isLoading) return;
        isLoading = true;

        page++;
        var data = {
            action: 'load_more_photos',
            page: page,
            per_page: per_page,
            loaded_photos: loadedPhotos
        };

        $.post(ajax_params.ajax_url, data, function(response) {
            if (response) {
                var $response = $(response);
                // Ajouter les nouvelles photos et mettre à jour loadedPhotos
                $response.each(function() {
                    var photoId = $(this).data('photo-id');
                    console.log('Loaded photo ID:', photoId); // Log photo ID
                    if (photoId && $.inArray(photoId, loadedPhotos) === -1) {
                        loadedPhotos.push(photoId);
                        $('.photos-gallery').append($(this));
                    }
                });
                console.log('Updated loaded photos:', loadedPhotos);
            } else {
                $('.load_more').hide();
            }
            isLoading = false;
        });

        return false;
    });
});