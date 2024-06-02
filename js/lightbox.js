console.log("le fichier lightbox.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
    var fullscreenIcon = document.getElementById('photo_icon_fullscreen');

    if (fullscreenIcon) {
        fullscreenIcon.addEventListener('click', function() {
            var imageUrl = this.getAttribute('data-fullscreen-url');
            openLightbox(imageUrl);
        });
    }
});

function openLightbox(imageUrl) {
    // Créez un conteneur pour la lightbox
    var lightboxContainer = document.createElement('div');
    lightboxContainer.id = 'lightbox-container';
    
    // Créez l'image à afficher
    var lightboxImage = document.createElement('img');
    lightboxImage.src = imageUrl;
    lightboxImage.id = 'lightbox-image';
    
    // Ajoutez l'image au conteneur
    lightboxContainer.appendChild(lightboxImage);
    
    // Ajoutez un écouteur d'événement pour fermer la lightbox en cliquant dessus
    lightboxContainer.addEventListener('click', function() {
        document.body.removeChild(lightboxContainer);
    });
    
    // Ajoutez le conteneur au body
    document.body.appendChild(lightboxContainer);
}