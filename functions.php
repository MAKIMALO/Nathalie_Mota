<?php
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles() {
    // Enqueue theme style
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/sass/theme.css', array(), 
    filemtime(get_stylesheet_directory() . '/sass/theme.css'), 'all');
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
function theme_enqueue_scripts() {
    // Enqueue jquery script
    wp_enqueue_script( 'jquery-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', array('jquery'), '1.0', true);

    // Enqueue custom script
    wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/js/custom-script.js', array(), '1.2', true );

    // Enqueue modale script
    wp_enqueue_script( 'modale-script', get_template_directory_uri() . '/js/modale.js', array(), '1.2', true );

    // Enqueue arrowsMiniature script
    wp_enqueue_script( 'arrowsMiniature-script', get_template_directory_uri() . '/js/arrowsMiniature.js', array('jquery'), '1.2', true );

    // Enqueue burger script
    wp_enqueue_script( 'burger-script', get_template_directory_uri() . '/js/burger.js', array(), '1.2', true );

    // Enqueue photo_gallery script
    wp_enqueue_script( 'photo_gallery-script', get_template_directory_uri() . '/js/photo_gallery.js', array(), '1.2', true );
    wp_localize_script('photo_gallery-script', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('load_photos_nonce')
    ));

    // Enqueue lightbox script
    wp_enqueue_script( 'lightbox-script', get_template_directory_uri() . '/js/lightbox.js', array(), '1.2', true );

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


// Ajout de la fonction Walker sur les menus
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


// Fonction pour charger les photos sur photo_gallery.js via AJAX
function load_photos() {
    check_ajax_referer('load_photos_nonce', 'security');
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $per_page = isset($_POST['per_page']) ? intval($_POST['per_page']) : 8;
    $category = isset($_POST['category']) ? intval($_POST['category']) : '';
    $format = isset($_POST['format']) ? intval($_POST['format']) : '';
    $date_order = isset($_POST['date_order']) ? sanitize_text_field($_POST['date_order']) : 'DESC';

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'order' => $date_order,
    );

    $tax_query = array('relation' => 'AND');

    if ($category) {
        $tax_query[] = array(
            'taxonomy' => 'categorie',
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

    ob_start();

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
            $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
            $post_id = get_the_ID();
            include(get_template_directory() . '/template-parts/photo_block.php');
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée</p>';
    endif;

    $html = ob_get_clean();
    $total = $query->found_posts;

    echo json_encode(array('html' => $html, 'total' => $total, 'success' => true));
    wp_die();
}

add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');


?>