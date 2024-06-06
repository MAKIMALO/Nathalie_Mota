console.log("le fichier filters.js fonctionne");

jQuery(document).ready(function($) {
    // Fonction pour obtenir le label correspondant à l'élément de sélection
    function getPlaceholder(labelFor) {
        return $('label[for="' + labelFor + '"]').text();
    }

    // Test de la fonction getPlaceholder
    console.log("Placeholder pour #category-filter :", getPlaceholder('category-filter'));
    console.log("Placeholder pour #format-filter :", getPlaceholder('format-filter'));
    console.log("Placeholder pour #date-filter :", getPlaceholder('date-filter'));

    // Initialiser Select2 sur les éléments de sélection avec les placeholders dynamiques
    $('#category-filter').select2({
        placeholder: getPlaceholder('category-filter'),
        allowClear: true
    });

    $('#format-filter').select2({
        placeholder: getPlaceholder('format-filter'),
        allowClear: true
    });

    $('#date-filter').select2({
        placeholder: getPlaceholder('date-filter'),
        allowClear: true
    });

    // Fonction pour effectuer une requête AJAX
    function applyFilters() {
        var category = $('#category-filter').val();
        var format = $('#format-filter').val();
        var dateOrder = $('#date-filter').val();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'filter_photos',
                category: category,
                format: format,
                date_order: dateOrder,
            },
            success: function(response) {
                $('.photos-gallery').html(response);
            }
        });
    }

    // Ajouter des gestionnaires d'événements 'change' aux éléments de sélection
    $('#category-filter, #format-filter, #date-filter').on('change', function() {
        applyFilters();
    });
});