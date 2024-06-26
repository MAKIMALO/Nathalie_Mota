<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nathalie Mota : photographe professionnelle dans l'événementiel</title>
    <meta name="description" content="En tant que photographe professionnelle, Nathalie Mota vous propose des prestations de qualité pour tous vos événements" />
    <?php wp_head(); ?>
    <?php
    // Récupérer le nombre total de photos dans le CPT "photos"
    $total_photos = wp_count_posts('photos')->publish;
    ?>
    <script>
        // Définir la variable JavaScript pour le nombre total de photos
        var totalPhotos = <?php echo $total_photos; ?>;
    </script>
</head>

<body>

<?php wp_body_open(); ?>

    <header id="header_site_menu">
        <nav class="navbar">
            <div class="logo">
                <a href="http://localhost/nathalie_mota/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.webp" alt="Logo Nathalie Mota">
                </a>
            </div>
            <div class="header_menu" role="navigation" aria-label="<?php _e('Menu principal', 'text-domain'); ?>">
                <?php wp_nav_menu(
                    array(
                        'theme_location' => 'main-menu',
                        'container' => 'false',
                        'walker' => new NMota_Walker_Nav_Menu()
                    )
                ); ?>
            </div>
            <a id="openBtn" href="#">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/burger_menu.png" alt="Logo burger menu">
            </a>
            <a id="closeBtn" href="#">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/close_btn.png" alt="Croix de fermeture du menu">
            </a>
        </nav>

    </header>


</body>
</html>