<?php get_header(); ?>

<article class="single-photos">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="single-photos-part-one">
            <div class="photo-details">
                <div class="photo-meta">
                    <h2><?php the_title(); ?></h2>
                    <?php $reference = get_field('reference');
                        if ($reference) {
                            echo '<p>REFERENCE : ' . $reference . '</p>';
                        }
                        $terms = get_the_terms( $post->ID, 'categorie' );
                        if ( $terms && ! is_wp_error( $terms ) ) {
                            $term_names = array();
                            foreach ( $terms as $term ) {
                                $term_names[] = $term->name;
                            }
                            echo '<p>CATEGORIE : ' . implode( ', ', $term_names ) . '</p>';
                        }
                        $terms = get_the_terms( $post->ID, 'format' );
                        if ( $terms && ! is_wp_error( $terms ) ) {
                            $term_names = array();
                            foreach ( $terms as $term ) {
                                $term_names[] = $term->name;
                            }
                            echo '<p>FORMAT : ' . implode( ', ', $term_names ) . '</p>';
                        }
                        $type = get_field('type');
                        if ($type) {
                            echo '<p>TYPE : ' . $type . '</p>';
                        }
                    ?>
                    <p>ANNEE : <?php the_time('Y'); ?></p>
                </div>
                <div class="photo-image">
                    <?php if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'medium' ); // Taille de l'image
                    } ?>
                </div>
            </div>
            <div class="contact-photo">
                <p>Cette photo vous intéresse ?</p>
                <button class="contact-button contactLink">Contact</button>
                <div class="selection-photo">
                    <img class="card-photo">
                    <img class="arrow arrow_left" src="<?php echo get_template_directory_uri() . '/assets/images/arrow_left.webp'; ?>" alt="Flèche gauche de direction">
                    <img class="arrow arrow_right" src="<?php echo get_template_directory_uri() . '/assets/images/arrow_right.webp'; ?>" alt="Flèche droite de direction">
                </div>
            </div>
        </div>
        <div class="single-photos-part-two">
            <p>VOUS AIMEREZ AUSSI</p>
            <div class="photos-apparentees">
                <img>
                <img>
            </div>
        </div>
    <?php endwhile; endif; ?>
</article>


<?php get_footer(); ?>