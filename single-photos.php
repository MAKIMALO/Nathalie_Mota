<?php get_header(); ?>

<?php
// Effectuer une requête pour obtenir toutes les photos
$all_photos_args = array(
    'post_type' => 'photos',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC'
    // Autres arguments de requête si nécessaire
);
$all_photos_query = new WP_Query($all_photos_args);

// Vérifier si la requête a réussi
if ($all_photos_query->have_posts()) {
    // Récupérer les URLs des miniatures de toutes les photos
    $all_images = array();
    foreach ($all_photos_query->posts as $photo) {
        $image_url = get_the_post_thumbnail_url($photo->ID, 'medium');
        if ($image_url) {
            $all_images[] = array(
                'url' => $image_url,
                'link' => get_permalink($photo->ID)
            );
        }
    }
}
?>
<div class="page-container">
    <section class="single-photos">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="single-photos-part-one">
                <div class="photo-meta">
                    <?php $titre = get_the_title();
                    $titre_modifie = preg_replace('/\s+/', '<br>', $titre, 1); ?>
                    <h2><?php echo $titre_modifie; ?></h2>
                    <?php
                    $reference = get_field('reference');
                    if ($reference) {
                        echo '<p>Référence : ' . $reference . '</p>';
                    }
                    $terms = get_the_terms($post->ID, 'categorie');
                    if ($terms && !is_wp_error($terms)) {
                        $term_names = array();
                        foreach ($terms as $term) {
                            $term_names[] = $term->name;
                        }
                        echo '<p>Catégorie : ' . implode(', ', $term_names) . '</p>';
                    }
                    $terms = get_the_terms($post->ID, 'format');
                    if ($terms && !is_wp_error($terms)) {
                        $term_names = array();
                        foreach ($terms as $term) {
                            $term_names[] = $term->name;
                        }
                        echo '<p>Format : ' . implode(', ', $term_names) . '</p>';
                    }
                    $type = get_field('type');
                    if ($type) {
                        echo '<p>Type : ' . $type . '</p>';
                    }
                    ?>
                    <p>Année : <?php the_time('Y'); ?></p>
                </div>
                <div class="photo-image">
                    <?php if (has_post_thumbnail()) {
                        the_post_thumbnail('medium');
                    } ?>
                </div>
            </div>
            <div class="single-photos-part-two">
                <div class="single-photos-contact-button">
                    <p>Cette photo vous intéresse ?</p>
                    <button class="contactLink">Contact</button>
                </div>
                <div class="single-contact-photo">
                    <div class="thumbnail-photo">
                        <img src="" alt="Photo miniature" id="thumbnail-preview" style="display: none;">
                    </div>
                    <div class="arrows">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        $prev_image_url = $prev_post ? get_the_post_thumbnail_url($prev_post->ID, 'medium') : '';
                        $next_image_url = $next_post ? get_the_post_thumbnail_url($next_post->ID, 'medium') : '';
                        ?>
                        <?php if ($prev_post) : ?>
                            <a class="arrow_left" href="<?php echo get_permalink($prev_post->ID); ?>" data-image="<?php echo esc_url($prev_image_url); ?>">
                                <img src="<?php echo get_template_directory_uri() . '/assets/images/arrow_left.webp'; ?>" alt="Flèche gauche de direction">
                            </a>
                        <?php endif; ?>
                        <?php if ($next_post) : ?>
                            <a class="arrow_right" href="<?php echo get_permalink($next_post->ID); ?>" data-image="<?php echo esc_url($next_image_url); ?>">
                                <img src="<?php echo get_template_directory_uri() . '/assets/images/arrow_right.webp'; ?>" alt="Flèche droite de direction">
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="single-photos-part-three">
                <h3>Vous aimerez aussi</h3>
                <div class="photos-apparentees">
                <?php
                    $current_photo_id = get_the_ID();
                    $terms = get_the_terms($current_photo_id, 'categorie');
                    if ($terms && !is_wp_error($terms)) {
                        $term_ids = wp_list_pluck($terms, 'term_id');
                        $args = array(
                            'post_type' => 'photos',
                            'posts_per_page' => 2,
                            'post__not_in' => array($current_photo_id),
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'categorie',
                                    'field' => 'term_id',
                                    'terms' => $term_ids,
                                ),
                            ),
                        );
                        $related_photos_query = new WP_Query($args);
                        if ($related_photos_query->have_posts()) :
                            while ($related_photos_query->have_posts()) : $related_photos_query->the_post();
                                // Préparation des données à passer à photo_block.php
                                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                                $post_id = get_the_ID();

                                // Passage des données via set_query_var
                                set_query_var('image_url', $image_url);
                                set_query_var('image_alt', $image_alt);
                                set_query_var('post_id', $post_id);

                                // Inclusion du template part
                                get_template_part('template-parts/photo_block');
                            endwhile;
                            wp_reset_postdata();
                        endif;
                    }
                    ?>
                </div>
            </div>
        <?php endwhile;
        endif; ?>
    </section>
</div>

<?php get_footer(); ?>


<script src="<?php echo get_template_directory_uri(); ?>/js/arrows_miniature.js" type="text/javascript"></script>
</body>

</html>