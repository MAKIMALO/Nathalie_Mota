console.log("le fichier script.js fonctionne");

/* Ajout des Events Listeners sur les flèches sur la page single-photos.php */

const clicArrowLeft = document.querySelector(".arrow_left");
const clicArrowRight = document.querySelector(".arrow_right");

clicArrowLeft.addEventListener("click", function() {
    console.log("la flèche gauche fonctionne")
});

clicArrowRight.addEventListener("click", function() {
    console.log("la flèche droite fonctionne")
});
