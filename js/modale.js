console.log("le fichier modale.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('contactModal');
    var links = document.querySelectorAll('.contactLink');
    var closeBtn = document.querySelector('.closeBtn');

    // Fonction pour récupérer la référence du chemin de l'URL
    function getReferenceFromURL() {
        var url = window.location.href;
        var regex = /\/photos\/[^\/]+\/([^\/]+)\/$/;
        var match = url.match(regex);
        if (match && match[1]) {
            console.log("Référence trouvée dans l'URL : " + match[1]); // Log pour vérifier la référence
            return match[1];
        }
        console.log("Aucune référence trouvée dans l'URL");
        return null;
    }

    // Ouvrir la modale
    links.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();

            // Récupérer la référence de l'URL
            var reference = getReferenceFromURL();

            // Remplir automatiquement le champ "référence"
            var referenceField = document.getElementById('reference-photo');
            if (referenceField) {
                referenceField.value = reference;
            }

            modal.classList.add('open');
        });
    });

    // Fermer la modale via la croix
    closeBtn.addEventListener('click', function(event) {
        event.stopPropagation();
        closeModal();
    });

    // Fermer la modale en cliquant en dehors de la modale
    document.addEventListener('click', function(event) {
        if (modal.classList.contains('open') && !modal.querySelector('.modale-global').contains(event.target)) {
            closeModal();
        }
    });

    // Empêcher la propagation des clics à l'intérieur de la modale
    modal.querySelector('.modale-global').addEventListener('click', function(event) {
        event.stopPropagation();
    });

    // Fonction pour fermer la modale
    function closeModal() {
        modal.classList.remove('open');
    }
});