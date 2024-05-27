<?php get_header(); ?>

<main class="site-main">
	<?php if (is_front_page()) : ?>
	<section class="banner">
		<img class="background_img" src="<?php echo get_template_directory_uri() . '/assets/images/nathalie-11.webp'; ?>" alt="Image d'un mariage en arrière plan">
		<h1>PHOTOGRAPHE EVENT</h1>
	</section>
	<?php endif; ?>

    <!-- Affichage de chaque page du menu individuellement -->
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="page-content">
                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                <div class="page-body">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
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
                        <h2><?php the_title(); ?></h2>

                    </a>
                </div>
            <?php endwhile;
        else : ?>
            <p>No photos found</p>
        <?php endif;
        wp_reset_postdata(); ?>
    </section>

</main>

<?php get_footer(); ?>