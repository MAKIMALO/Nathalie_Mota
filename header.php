<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nathalie Mota : photographe professionnelle dans l'événementiel</title>
    <meta name="description" content="En tant que photographe professionnelle, Nathalie Mota vous propose des prestations de qualité pour tous vos événements" />
    <?php wp_head(); ?>
</head>

<body>

<?php wp_body_open(); ?>
<div id="page" class="site">
    <header id="header_site_menu">
        <nav class="navbar">
            <div class="logo">
                <a href="http://localhost/nathalie_mota/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.webp" alt="Logo Nathalie Mota">
                </a>
            </div>
            <div id="header_menu" role="navigation" aria-lebel="<?php _e('Menu principal', 'text-domain'); ?>">
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
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/close_burger_menu.png" alt="Croix de fermeture du menu">
            </a>
        </nav>

    </header>

<script src="<?php echo get_template_directory_uri(); ?>/js/burger.js" type="text/javascript"></script>

</body>
</html>