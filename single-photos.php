<?php get_header(); ?>

<article class="single-photos">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="single-photos-part-one">
            <div class="photo-meta">
                <?php $titre = get_the_title();
                $titre_modifie = preg_replace('/\s+/', '<br>', $titre, 1);
                ?>
                <h2><?php echo $titre_modifie; ?></h2>
                <?php $reference = get_field('reference');
                    if ($reference) {
                        echo '<p>Référence : ' . $reference . '</p>';
                    }
                $terms = get_the_terms( $post->ID, 'categorie' );
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $term_names = array();
                        foreach ( $terms as $term ) {
                            $term_names[] = $term->name;
                        }
                        echo '<p>Catégorie : ' . implode( ', ', $term_names ) . '</p>';
                    }
                $terms = get_the_terms( $post->ID, 'format' );
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $term_names = array();
                        foreach ( $terms as $term ) {
                            $term_names[] = $term->name;
                        }
                        echo '<p>Format : ' . implode( ', ', $term_names ) . '</p>';
                    }
                $type = get_field('type');
                    if ($type) {
                        echo '<p>Type : ' . $type . '</p>';
                    }
                ?>
                <p>Année : <?php the_time('Y'); ?></p>
            </div>
            <div class="photo-image">
                <?php if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'medium' ); // Taille de l'image
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
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/nathalie-11.webp'; ?>" alt="Photo miniature">
                </div>
                <div class="arrows">
                    <img class="arrow_left" src="<?php echo get_template_directory_uri() . '/assets/images/arrow_left.webp'; ?>" alt="Flèche gauche de direction">
                    <img class="arrow_right" src="<?php echo get_template_directory_uri() . '/assets/images/arrow_right.webp'; ?>" alt="Flèche droite de direction">
                </div>
            </div>
        </div>
        <div class="single-photos-part-three">
            <h3>Vous aimerez aussi</h3>
            <div class="photos-apparentees">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/nathalie-12.webp'; ?>" alt="Photo d'un évènement">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/nathalie-13.webp'; ?>" alt="Photo d'un évènement">
            </div>
        </div>
    <?php endwhile; endif; ?>
</article>


<?php get_footer(); ?>