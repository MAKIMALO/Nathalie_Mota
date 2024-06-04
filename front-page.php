<?php get_header(); ?>

<main id="main" class="site-main">
    <section class="banner">
        <?php
            $args = array(
                'post_type' => 'photos',
                'posts_per_page' => 1,
                'orderby' => 'rand',
            );

            $loop = new WP_Query($args);

            while ($loop->have_posts()) : $loop->the_post();
                the_post_thumbnail();
            endwhile;
            wp_reset_postdata();
            ?>
        <h1>PHOTOGRAPHE EVENT</h1>
    </section>

    <!-- Affichage de l'ensemble des pages "photos" -->
    <section class="photos-gallery">
        <?php
            $per_page = 8;
            $offset = -1;

            $args = array(
                'post_type' => 'photos',
                'posts_per_page' => 8,
                'offset' => $offset,
            );
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div class="photo-item">
                        <a href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'medium' ); // Taille de l'image
                            } ?>
                        </a>
                    </div>
        <?php endwhile;
        else : ?>
            <p>No photos found</p>
        <?php endif;
        wp_reset_postdata(); ?>
            <a href="<?php echo home_url( '?page=' . $offset + $per_page ); ?>">Charger plus</a>
    </section>

</main>

<?php get_footer(); ?>

</body>
</html>