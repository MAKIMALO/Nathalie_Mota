console.log("le fichier filters.js fonctionne");

jQuery(document).ready(function($) {
    // Initialiser Select2 sur les éléments de sélection
    $('#category-filter, #format-filter, #date-filter').select2({
        placeholder: "Sélectionner une option",
        allowClear: true
    });
    
    // Fonction pour effectuer une requête AJAX
    function applyFilters() {
        // Récupérer les valeurs des filtres
        var category = $('#category-filter').val();
        var format = $('#format-filter').val();
        var dateOrder = $('#date-filter').val();

        // Faire une requête AJAX pour obtenir les photos filtrées
        $.ajax({
            url: ajaxurl, // Variable AJAX de WordPress
            type: 'POST',
            data: {
                action: 'filter_photos',
                category: category,
                format: format,
                date_order: dateOrder,
            },
            success: function(response) {
                // Mettre à jour la galerie avec les nouvelles photos
                $('.photos-gallery').html(response);
            }
        });
    }
    // Ajouter des gestionnaires d'événements 'change' aux éléments de sélection
    $('#category-filter, #format-filter, #date-filter').on('change', function() {
        applyFilters();
    });
});