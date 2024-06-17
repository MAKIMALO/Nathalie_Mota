console.log("Le fichier custom-script.js fonctionne");

// ACTION SUR L'ICONE EYE DU FICHIER "PHOTO_BLOCK.PHP"
document.addEventListener('DOMContentLoaded', function() {
    var eyeIcon = document.getElementById('photo_icon_eye');

    if (eyeIcon) {
        eyeIcon.addEventListener('click', function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du lien

            var link = eyeIcon.querySelector('a').getAttribute('href');
            window.location.href = link; // Redirige vers l'URL spécifiée dans le lien
        });
    } else {
        console.error('Élément avec l\'ID photo_icon_eye non trouvé.');
    }
});

