console.log("le fichier modale.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('contactModal');
    var links = document.querySelectorAll('.contactLink');
  
    // Ouvrir la modale
    links.forEach(function(link) {
      link.onclick = function(event) {
        event.preventDefault();
        modal.classList.add('open');
      }
    });
  
    // Fermer la modale
    function closeModal() {
        modal.classList.remove('open');
    }

    window.onclick = function(event) {
        if (event.target == modal ) {
          modal.style.display = "none";
        }
    }
  });