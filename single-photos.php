<?php get_header(); ?>

<article class="single-photos">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="single-photos-part-one">
            <div class="photo-details">
                <div class="photo-text-informations">
                    <?php the_content(); ?>
                </div>
                <div class="photo-meta">
                    <span>Posted on: <?php the_date(); ?></span>
                    <span>Category: <?php the_terms( $post->ID, 'photo_category', '', ', ' ); ?></span>
                </div>
                <div class="photo-image">
                    <?php if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'large' ); // Taille de l'image
                    } ?>
                </div>
            </div>
            <div class="contact-photo">
                <p>Cette photo vous intéresse ?</p>
                <button class="contact-button"></button>
                <div class="selection-photo">
                    <img class="card-photo">
                    <img class="arrow arrow_left">
                    <img class="arrow arrow_right">
                </div>
            </div>
        </div>
        <div class="single-photos-part-two">
            <p>VOUS AIMEREZ AUSSI</>
            <div class="photos-apparentees">
                <img>
                <img>
            </div>
        </div>
    <?php endwhile; endif; ?>
</article>


<?php get_footer(); ?>