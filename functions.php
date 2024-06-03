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

        // Enqueue custom script
        wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.2', true );
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


// Récupération des données JSON des photos de WP (utilisation sur le fichier single-photos.php pour l'affichage des miniatures aux flèches)
function get_photo_data_for_js() {
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC'
    );

    $photos = get_posts($args);

    $photo_data = array();

    foreach ($photos as $photo) {
        $thumbnail_url = get_the_post_thumbnail_url($photo->ID);

        $photo_data[] = array(
            'id' => $photo->ID,
            'thumbnail_url' => $thumbnail_url,
        );
    }

    return $photo_data;
}

// Localisation du script JavaScript avec les données des photos
function localize_photo_data_script() {
    // Récupérer les données des photos
    $photo_data = get_photo_data_for_js();

    // Localiser le script JavaScript et y transmettre les données
    wp_localize_script( 'script', 'photoData', $photo_data );
}
add_action( 'wp_enqueue_scripts', 'localize_photo_data_script' );

?>