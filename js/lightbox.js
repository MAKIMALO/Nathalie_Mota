console.log("Le fichier lightbox.js fonctionne");

document.addEventListener("DOMContentLoaded", function () {
    // Sélectionne les éléments de la lightbox
    const lightbox = document.getElementById("lightbox-overlay");
    const closeButton = lightbox.querySelector(".close_lightbox");
    const prevButton = lightbox.querySelector(".lightbox_arrow_prev");
    const nextButton = lightbox.querySelector(".lightbox_arrow_next");
    const lightboxImage = lightbox.querySelector("#lightbox-img");
    const lightboxReference = lightbox.querySelector("#lightbox-reference");
    const lightboxCategory = lightbox.querySelector("#lightbox-category");

    // Initialise les variables pour stocker les images et l'index de l'image actuelle
    let images = [];
    let currentIndex = 0;

    // Fonction pour ouvrir la lightbox
    function openLightbox(imageUrl, reference, category, orientation) {
        console.log("Ouvrir la lightbox pour :", imageUrl, reference, category, orientation);

        lightboxImage.src = imageUrl;
        lightboxReference.textContent = reference;
        lightboxCategory.textContent = category;

        // Vérifie et met à jour les classes landscape et portrait en fonction de l'orientation
        updateLightboxOrientation(orientation);

        lightbox.style.display = "flex";
    }

    // Fonction pour fermer la lightbox
    function closeLightbox() {
        lightbox.style.display = "none";
    }

    // Fonction pour afficher la photo suivante
    function nextPhoto() {
        currentIndex = (currentIndex + 1) % images.length;
        updateLightboxContent(images[currentIndex]);
    }

    // Fonction pour afficher la photo précédente
    function prevPhoto() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateLightboxContent(images[currentIndex]);
    }

    // Fonction pour mettre à jour le contenu de la lightbox
    function updateLightboxContent(data) {
        lightboxImage.src = data.imageUrl;
        lightboxReference.textContent = data.reference;
        lightboxCategory.textContent = data.category;

        // Met à jour l'orientation lorsque le contenu de la lightbox est mis à jour
        updateLightboxOrientation(data.orientation);
    }

    // Fonction pour mettre à jour l'orientation de la lightbox en fonction de l'orientation de l'image
    function updateLightboxOrientation(orientation) {
        if (orientation === 'landscape') {
            lightbox.classList.add('landscape');
            lightbox.classList.remove('portrait');
        } else {
            lightbox.classList.add('portrait');
            lightbox.classList.remove('landscape');
        }
    }

    // Ajoute des écouteurs d'événements aux icônes fullscreen existantes
    function addEventListenersToFullscreenIcons() {
        document.querySelectorAll(".fullscreen-icon").forEach((icon, index) => {
            icon.addEventListener("click", function () {
                const imageUrl = this.dataset.imageUrl;
                const reference = this.dataset.reference;
                const category = this.dataset.category;
                const orientation = this.dataset.orientation || 'portrait'; // Utilisation par défaut de portrait si orientation n'est pas défini

                // Crée un tableau des images en parcourant tous les éléments .fullscreen
                images = Array.from(document.querySelectorAll(".fullscreen-icon")).map((icon) => ({
                    imageUrl: icon.dataset.imageUrl,
                    reference: icon.dataset.reference,
                    category: icon.dataset.category,
                    orientation: icon.dataset.orientation || 'portrait' // Utilisation par défaut de portrait si orientation n'est pas défini
                }));

                // Trouve l'index de l'image actuellement cliquée
                currentIndex = index;

                // Met à jour le contenu de la lightbox avec l'image cliquée
                updateLightboxContent(images[currentIndex]);

                // Affiche la lightbox avec l'orientation correcte
                openLightbox(imageUrl, reference, category, orientation);
            });
        });
    }

    // Utilise MutationObserver pour surveiller les changements dans le DOM
    const observer = new MutationObserver(addEventListenersToFullscreenIcons);

    // Observe les changements dans le document pour ajouter des écouteurs aux nouveaux éléments .fullscreen-icon
    observer.observe(document.body, { childList: true, subtree: true });

    // Ajoute un écouteur d'événement uniquement à la croix de fermeture
    closeButton.addEventListener("click", closeLightbox);

    // Ajoute des écouteurs d'événements aux boutons de contrôle de la lightbox
    if (prevButton) {
        prevButton.addEventListener("click", prevPhoto);
    }
    if (nextButton) {
        nextButton.addEventListener("click", nextPhoto);
    }

    // Appelle la fonction pour ajouter des écouteurs d'événements aux icônes fullscreen existantes
    addEventListenersToFullscreenIcons();
});