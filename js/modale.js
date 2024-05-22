console.log("le fichier modale.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
  var modal = document.getElementById('contactModal');
  var links = document.querySelectorAll('.contactLink');
  var closeBtn = document.querySelector('.closeBtn');
  var body = document.querySelector('body');

  // Ouvrir la modale
  links.forEach(function(link) {
      link.addEventListener('click', function(event) {
          event.preventDefault();
          event.stopPropagation(); // Empêche la propagation de l'événement de clic
          modal.classList.add('open');
      });
  });

  // Fermer la modale via la croix
  closeBtn.addEventListener('click', function(event) {
      event.stopPropagation(); // Empêche la propagation de l'événement de clic
      closeModal();
  });

  // Fermer la modale en cliquant en dehors de la modale
  body.addEventListener('click', function(event) {
      if (modal.classList.contains('open') && !modal.contains(event.target)) {
          closeModal();
      }
  });

  // Fonction pour fermer la modale
  function closeModal() {
      modal.classList.remove('open');
  }
});