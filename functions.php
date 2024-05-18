<?php
    add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
    function theme_enqueue_styles() {
        // Enqueue theme style
        wp_enqueue_style('theme-style', get_template_directory_uri() . '/sass/theme.css', array(), 
        filemtime(get_stylesheet_directory() . '/sass/theme.css'), 'all');
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

?>