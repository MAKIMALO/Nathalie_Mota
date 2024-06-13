console.log("le fichier arrows_miniature.js fonctionne");

// Animations des flèches sous la photo miniature sur le fichier single-photos.php
jQuery(document).ready(function($) {
    $('.arrow_left, .arrow_right').hover(function() {
        var imageSrc = $(this).data('image');
        $('#thumbnail-preview').attr('src', imageSrc).show();
    }, function() {
        $('#thumbnail-preview').hide();
    });

    $('.arrow_left, .arrow_right').click(function(e) {
        e.preventDefault();
        var imageSrc = $(this).data('image');
        var postID = $(this).data('post-id');
        
        // Redirection vers la page de la photo au clic sur la flèche
        window.location.href = $(this).attr('href');
    });
});