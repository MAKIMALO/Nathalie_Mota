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
        topnav.classList.remove('active-closing'); // Assurez-vous que la classe de fermeture est retirée
        openBtn.style.display = 'none';
        closeBtn.style.display = 'block';
    }

    function closeMenu() {
        topnav.classList.add('active-closing'); // Ajoutez la classe de fermeture
        // Utilisez un délai ou une écoute sur la fin de la transition CSS pour effectuer ces actions
        setTimeout(() => {
            topnav.classList.remove('active');
            openBtn.style.display = 'block';
            closeBtn.style.display = 'none';
            topnav.classList.remove('active-closing');
        }, 400); // Temps correspondant à la transition CSS
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
        if (window.innerWidth <= 375) {
            openBtn.style.display = 'block';
            closeBtn.style.display = 'none';
            topnav.classList.remove('active');
            topnav.classList.remove('active-closing');
        } else {
            openBtn.style.display = 'none';
            closeBtn.style.display = 'none';
            topnav.classList.add('active');
        }
    }

    window.addEventListener('resize', () => {
        checkWindowSize();
    });

    checkWindowSize();
});