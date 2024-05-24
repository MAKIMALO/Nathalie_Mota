console.log("le fichier modale.js fonctionne");

document.addEventListener('DOMContentLoaded', function() {
  var modal = document.getElementById('contactModal');
  var links = document.querySelectorAll('.contactLink');
  var closeBtn = document.querySelector('.closeBtn');

  // Ouvrir la modale
  links.forEach(function(link) {
      link.addEventListener('click', function(event) {
          event.preventDefault();
          event.stopPropagation();
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