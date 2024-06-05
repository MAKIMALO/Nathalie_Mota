console.log("le fichier load_more_button.js fonctionne");

// Ouverture sur le bouton "Charger plus" de la page "front-page.php"
jQuery(document).ready(function($) {
    var page = 1;
    var per_page = 8;
    var total_photos_loaded = 0; // Variable pour suivre le nombre total de photos déjà chargées
    var isLoading = false;

    $('.load_more').click(function(e) {
        e.preventDefault();
        if (isLoading || total_photos_loaded >= totalPhotos) return; // Arrêtez si toutes les photos sont déjà chargées
        isLoading = true;

        page++;
        var data = {
            action: 'load_more_photos',
            page: page,
            per_page: per_page,
            loaded_photos: [...$('.photo-item').map(function() { return $(this).data('photo-id'); })] // Obtenez les IDs de toutes les photos déjà chargées
        };

        console.log('Data sent:', data);

        $.post(ajax_params.ajax_url, data, function(response) {
            console.log('Response:', response);
            if (response) {
                var $response = $(response);
                console.log('Number of new photos:', $response.length);
                $('.photos-gallery').append($response);

                // Ajoutez le nombre de nouvelles photos chargées au nombre total de photos déjà chargées
                total_photos_loaded += $response.length;

                if (total_photos_loaded >= totalPhotos) {
                    $('.load_more').hide(); // Cacher le bouton si toutes les photos sont déjà chargées
                }
            } else {
                $('.load_more').hide(); // Cacher le bouton si la réponse est vide
            }
            isLoading = false;
        });

        return false;
    });
});