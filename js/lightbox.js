console.log("Le fichier lightbox.js fonctionne");

jQuery(document).ready(function($) {
    var fullscreenIcons = $(".fullscreen-icon");
    console.log("Nombre d'icônes fullscreen trouvées:", fullscreenIcons.length);

    var lightbox = $("#lightbox");
    var lightboxImage = lightbox.find(".lightbox_image");
    var closeLightboxButton = lightbox.find(".close_lightbox");

    fullscreenIcons.on("click", function(event) {
        event.preventDefault();
        var imageUrl = $(this).closest("#photo-block").data("image-url");
        console.log("URL de l'image pour la lightbox:", imageUrl);
        openLightbox(imageUrl);
    });

    if (closeLightboxButton.length > 0) {
        closeLightboxButton.on("click", function() {
            console.log("Fermeture de la lightbox");
            closeLightbox();
        });
    }

    function openLightbox(imageUrl) {
        if (lightboxImage.length > 0) {
            lightboxImage.attr("src", imageUrl);
        }
        lightbox.addClass("active");
        console.log("Lightbox ouverte avec l'image:", imageUrl);
    }

    function closeLightbox() {
        lightbox.removeClass("active");
        console.log("Lightbox fermée");
    }
});