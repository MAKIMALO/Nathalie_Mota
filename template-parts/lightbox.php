<?php
$args = array(
    'post_type' => 'photos',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'categorie', // Le nom de votre taxonomie
            'field'    => 'term_id', // Le champ sur lequel effectuer la requête (dans ce cas, l'identifiant du terme)
        ),
    ),
);

// Exécutez la requête WP_Query
$query = new WP_Query($args);

// Vérifiez si des photos ont été trouvées
if ($query->have_posts()) :
?>

<div id="photo-slider" class="slider-container">
    <?php
    // Boucle à travers les photos et affichez-les dans le slider
    while ($query->have_posts()) : $query->the_post();
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
    ?>
        <div>
            <a href="<?php echo esc_url($image_url); ?>" data-fancybox="gallery">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
            </a>
        </div>
    <?php
    endwhile;
    ?>
</div>
<?php
// Réinitialisez les données de la requête
wp_reset_postdata();
endif;
?>

<div id="lightbox" class="lightbox-overlay">
    <div class="lightbox_container">
        <div class="close_lightbox" href="#">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/close_btn.png" alt="Croix de fermeture du menu">
        </div>
        <div class="lightbox_arrows">
            <img class="arrow_previous" src="<?php echo get_template_directory_uri() . '/assets/images/arrow_previous.webp'; ?>" alt="Flèche gauche de la lightbox">
            <img class="arrow_next" src="<?php echo get_template_directory_uri() . '/assets/images/arrow_next.webp'; ?>" alt="Flèche droite de la lightbox">
        </div>
        <div class="lightbox_block">
            <a class="lightbox_reference"></a>
            <a class="lightbox_categorie"></a>
        </div>

    </div>
</div>