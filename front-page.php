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
    <section class="section-gallery">
        <div class="photos-gallery">
        <?php
            $per_page = 8;
            $offset = -1;

            $args = array(
                'post_type' => 'photos',
                'posts_per_page' => 8,
                'offset' => $offset,
            );
            $query = new WP_Query( $args );

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                    $post_id = get_the_ID();
                    include(get_template_directory() . '/template-parts/photo_block.php');
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
        <div class="load-more-photos">
            <button class="load_more" href="<?php echo home_url( '?page=' . $offset + $per_page ); ?>">Chargez plus</button>
        </div>
    </section>

</main>

<?php get_footer(); ?>

</body>
</html>