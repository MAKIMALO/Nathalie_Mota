<?php get_header(); ?>

<main id="main" class="site-main">
	<?php if (is_front_page()) : ?>
	<section class="banner">
		<img class="background_img" src="<?php echo get_template_directory_uri() . '/assets/images/nathalie-11.webp'; ?>" alt="Image d'un mariage en arrière plan">
		<h1>PHOTOGRAPHE EVENT</h1>
	</section>
	<?php endif; ?>
    
    <!-- Affichage de l'ensemble des pages "photos" -->
    <section class="photos-gallery">
        <?php
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 8,
        );
        $loop = new WP_Query( $args );

        if ( $loop->have_posts() ) :
            while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <div class="photo-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'medium' ); // Taille de l'image
                        } ?>
                    </a>
                                <!-- Récupération et affichage des images associées -->
                                <?php
                $related_images = get_field('images_associees'); // Supposons que les images associées sont stockées dans un champ personnalisé ACF nommé 'images_associees'

                if ($related_images) {
                    foreach ($related_images as $image) {
                        $image_url = $image['url'];
                        $image_alt = $image['alt'];

                        // Inclure le template photo_block.php pour chaque image associée
                        include('template_parts/photo_block.php');
                    }
                }
                ?>
            </div>
        <?php endwhile;
        else : ?>
            <p>No photos found</p>
        <?php endif;
        wp_reset_postdata(); ?>
    </section>

</main>

<?php get_footer(); ?>

</body>
</html>