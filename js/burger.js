console.log("le fichier burger.js fonctionne");

const topnav = document.querySelector(".header_site_menu");
const openBtn = document.getElementById("openBtn");
const closeBtn = document.getElementById("closeBtn");

function openMenu() {
    topnav.classList.add('active');
    openBtn.style.display = 'none'; // Cacher le bouton hamburger
    closeBtn.style.display = 'block'; // Afficher le bouton croix
    topnav.style.display = 'block'; // Afficher le menu
}

function closeMenu() {
    topnav.classList.remove('active');
    openBtn.style.display = 'block'; // Afficher le bouton hamburger
    closeBtn.style.display = 'none'; // Cacher le bouton croix
    topnav.style.display = 'none'; // Cacher le menu
}

openBtn.addEventListener('click', (e) => {
    e.preventDefault();
    openMenu();
});

closeBtn.addEventListener('click', (e) => {
    e.preventDefault();
    closeMenu();
});

function checkWindowSize() {
    if (window.innerWidth > 375) {
        openBtn.style.display = 'none'; // Cacher le bouton hamburger
        closeBtn.style.display = 'none'; // Cacher le bouton croix
        topnav.style.display = 'flex'; // Afficher le menu
    } else {
        openBtn.style.display = 'block'; // Afficher le bouton hamburger
        closeBtn.style.display = 'none'; // Cacher le bouton croix
        topnav.style.display = 'none'; // Cacher le menu
    }
}

window.addEventListener('resize', checkWindowSize);
document.addEventListener('DOMContentLoaded', checkWindowSize);