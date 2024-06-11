console.log("Le fichier lightbox.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour réinitialiser FancyBox
    function reinitializeFancyBox() {
        $('[data-fancybox="gallery"]').fancybox({
            loop: true,
            buttons: [
                "close"
            ],
            afterShow: function(instance, current) {
                var reference = current.opts.$orig.data('reference');
                var category = current.opts.$orig.data('category');

                $('.fancybox-caption').html('<p>Référence: ' + reference + '</p><p>Catégorie: ' + category + '</p>');
            }
        });
    }

    // Fonction pour charger toutes les photos du CPT via une requête Ajax
    function loadAllPhotos() {
        $.ajax({
            url: "<?php echo admin_url('/wp-admin/admin-ajax.php'); ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load_photos', // Action pour récupérer les photos du CPT
            },
            success: function(response) {
                if (response && response.length > 0) {
                    var sliderContent = '';
    
                    // Créer le contenu HTML du slider avec les images récupérées
                    response.forEach(function(photo) {
                        sliderContent += '<div><img src="' + photo.url + '" alt="' + photo.alt + '"></div>';
                    });
    
                    // Ajouter le contenu du slider à votre élément HTML
                    $('.slider-container').html(sliderContent);
    
                    // Réinitialiser FancyBox après avoir chargé les photos
                    reinitializeFancyBox();
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Appeler la fonction pour charger toutes les photos du CPT
    loadAllPhotos();

    // Attacher la fonction de réinitialisation à l'événement personnalisé
    document.addEventListener('photosLoaded', reinitializeFancyBox);
});