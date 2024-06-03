console.log("le fichier script.js fonctionne");

jQuery(document).ready(function($) {
    console.log("jQuery est prêt");

    // Gestion du survol pour afficher les miniatures
    $('.arrow_left, .arrow_right').hover(
        function() {
            var imageUrl = $(this).data('image');
            console.log("URL de l'image : ", imageUrl);
            if (imageUrl) {
                $('#thumbnail-preview').attr('src', imageUrl).fadeIn();
            }
        },
        function() {
            $('#thumbnail-preview').fadeOut(function() {
                $(this).attr('src', '');
            });
        }
    );

    // Gestion du clic pour ouvrir la photo en grand
    $('.arrow_left, .arrow_right').click(function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien
        var url = $(this).attr('href');
        if (url !== '#') {
            window.location.href = url; // Redirige vers la page correspondante
        }
    });
});