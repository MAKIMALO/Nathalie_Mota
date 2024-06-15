console.log("Le fichier burger.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
    const openBtn = document.getElementById('openBtn');
    const closeBtn = document.getElementById('closeBtn');
    const topnav = document.querySelector('.header_menu');
    
    if (!openBtn || !closeBtn || !topnav) {
        console.error('Un ou plusieurs éléments HTML requis sont manquants.');
        return;
    }

    function openMenu() {
        topnav.classList.add('active');
        openBtn.style.display = 'none'; // Cacher le bouton hamburger
        closeBtn.style.display = 'block'; // Afficher le bouton croix
    }
    
    function closeMenu() {
        topnav.classList.remove('active');
        openBtn.style.display = 'block'; // Afficher le bouton hamburger
        closeBtn.style.display = 'none'; // Cacher le bouton croix
    }
    
    openBtn.addEventListener('click', (e) => {
        e.preventDefault();
        topnav.style.transition = 'right 0.3s ease, opacity 0.3s ease'; // Activer la transition
        openMenu();
    });
    
    closeBtn.addEventListener('click', (e) => {
        e.preventDefault();
        topnav.style.transition = 'right 0.3s ease, opacity 0.3s ease'; // Activer la transition
        closeMenu();
    });
    
    function checkWindowSize() {
        if (window.innerWidth <= 375) {
            openBtn.style.display = 'block'; // Afficher le bouton hamburger
            closeBtn.style.display = 'none'; // Cacher le bouton croix
            topnav.classList.remove('active');
        } else {
            openBtn.style.display = 'none'; // Cacher le bouton hamburger
            closeBtn.style.display = 'none'; // Cacher le bouton croix
            topnav.classList.add('active');
        }
    }
    
    window.addEventListener('resize', () => {
        topnav.style.transition = 'none'; // Désactiver la transition lors du redimensionnement
        checkWindowSize();
        setTimeout(() => {
            topnav.style.transition = ''; // Réactiver la transition
        }, 300); // Durée de la transition CSS
    });
    
    // Appel immédiat pour définir l'état correct au chargement de la page
    checkWindowSize();
});