<?php
    add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
    function theme_enqueue_styles() {
        // Enqueue theme style
        wp_enqueue_style('theme-style', get_template_directory_uri() . '/theme.css', array(), 
        filemtime(get_stylesheet_directory() . '/theme.css'), 'all');
    }
?>

<?php

function register_my_menu() {
    register_nav_menu( 'main-menu', __( 'Menu principal', 'text-domain' ));
}
add_action( 'after_setup_theme', 'register_my_menu');

?>