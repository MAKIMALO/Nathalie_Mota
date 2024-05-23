<?php get_header(); ?>

<section class="custom-posts">

        <?php
        // Arguments de la requête pour le CPT
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 8,
        );

        // La requête WP pour le CPT
        $query = new WP_Query($args);

        // La boucle pour le CPT
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-thumbnail">
                        <?php
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('thumbnail');
                        } else {
                            echo 'Pas d\'image mise en avant';
                        }
                        ?>
                    </div>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
				</article>
            <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>Aucun contenu trouvé</p>';
        endif;
        ?>

</section>

<?php get_footer(); ?>