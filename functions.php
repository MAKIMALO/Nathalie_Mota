<?php
    add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
    function theme_enqueue_styles() {
        // Enqueue theme style
        wp_enqueue_style('theme-style', get_template_directory_uri() . '/sass/theme.css', array(), 
        filemtime(get_stylesheet_directory() . '/sass/theme.css'), 'all');
    }

    add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
    function theme_enqueue_scripts() {
        // Enqueue burger script
        wp_enqueue_script( 'burger-script', get_template_directory_uri() . '/js/burger.js', array(), '1.2', true );
        
        // Enqueue modale script
        wp_enqueue_script( 'modale-script', get_template_directory_uri() . '/js/modale.js', array(), '1.2', true );

        // Enqueue lightbox script
        wp_enqueue_script( 'lightbox-script', get_template_directory_uri() . '/js/lightbox.js', array(), '1.2', true );

        // Enqueue jquery script
	    wp_enqueue_script( 'jquery-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', array('jquery'), '1.0', true);

        // Enqueue arrows_miniature script
        wp_enqueue_script( 'arrows_miniature-script', get_template_directory_uri() . '/js/arrows_miniature.js', array('jquery'), '1.2', true );

        // Enqueue load_more_button script
        wp_enqueue_script( 'load_more_button-script', get_template_directory_uri() . '/js/load_more_button.js', array('jquery'), '1.2', true );
        
         // Localize the load_more_button script with ajax URL
        wp_localize_script('load_more_button-script', 'ajax_params', array('ajax_url' => admin_url('admin-ajax.php')
        ));
    }

    add_action('wp_enqueue_scripts', 'enqueue_select2');
    function enqueue_select2() {
        // CSS de Select2
        wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
        
        // JS de Select2
        wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), null, true);
        
        // Enqueue filters script pour initialiser Select2 et gérer les filtres AJAX
        wp_enqueue_script('filters-js', get_template_directory_uri() . '/js/filters.js', array('jquery', 'select2-js'), null, true);
    }
    

// Ajout de l'onglet "Menus" sur le dashboard dans WP - dossier "Apparence" 
function register_my_menus() {
    register_nav_menus(
        array(
            'main-menu'=> __( 'Menu principal', 'text-domain'),
            'footer-menu' => __( 'Pied de page', 'text-domain')
        )
    );
}
add_action( 'after_setup_theme', 'register_my_menus');


// Ajout de la fonction Walker
function register_custom_nav_walker(){
    require_once get_template_directory() . '/walker-menus.php';
}
add_action( 'after_setup_theme', 'register_custom_nav_walker' );


// Récupération des valeurs du champ personnalisé "Référence" de chaque photo pour personnaliser l'URL
function add_reference_to_permalink($post_link, $post) {
    if ($post->post_type == 'photos') {
        $reference = get_field('reference', $post->ID);
        if ($reference) {
            // Ajouter la référence à la fin de l'URL
            $post_link = trailingslashit($post_link) . sanitize_title($reference);
        }
    }
    return $post_link;
}
add_filter('post_type_link', 'add_reference_to_permalink', 10, 2);


function custom_rewrite_rule() {
    add_rewrite_rule(
        '^photos/([^/]+)/([^/]+)/?$',
        'index.php?post_type=photos&name=$matches[1]&reference=$matches[2]',
        'top'
    );
}
add_action('init', 'custom_rewrite_rule');


function custom_query_vars($vars) {
    $vars[] = 'reference';
    return $vars;
}
add_filter('query_vars', 'custom_query_vars');


function change_photo_slug_structure($args, $post_type) {
    if ($post_type == 'photos') {
        $args['rewrite'] = array(
            'slug' => 'photos',
            'with_front' => false
        );
    }
    return $args;
}
add_filter('register_post_type_args', 'change_photo_slug_structure', 10, 2);


// Ajout de la fonction "load_more_photos" pour traiter la requête Ajax sur le bouton "load_more" de la page "front_page.php"
function load_more_photos() {
    $page = intval($_POST['page']);
    $per_page = intval($_POST['per_page']);

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => $per_page,
        'paged' => $page,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $post_id = get_the_ID();
            $image_url = get_the_post_thumbnail_url($post_id, 'large');
            $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
            include(get_template_directory() . '/template-parts/photo_block.php');
        endwhile;
        wp_reset_postdata();
    else:
        echo '';
    endif;

    wp_die();
}

add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');


// Ajout de la fonction "filters_photos" pour traiter la requête Ajax sur les filtres de la page "front_page.php"
function filter_photos() {
    $category = isset($_POST['category']) ? intval($_POST['category']) : '';
    $format = isset($_POST['format']) ? intval($_POST['format']) : '';
    $date_order = isset($_POST['date_order']) ? sanitize_text_field($_POST['date_order']) : 'DESC';

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'order' => $date_order,
    );

    $tax_query = array('relation' => 'AND');

    if ($category) {
        $tax_query[] = array(
            'taxonomy' => 'categorie', // Utilisez le slug correct de votre taxonomy
            'field' => 'term_id',
            'terms' => $category,
        );
    }

    if ($format) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field' => 'term_id',
            'terms' => $format,
        );
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
            $post_id = get_the_ID();
            include(get_template_directory() . '/template-parts/photo_block.php');
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    die();
}
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

?>