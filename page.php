<?php get_header(); ?>

<main class="site-main">
	<section class="banner">
		<img class="background_img" src="<?php echo get_template_directory_uri() . '/assets/images/nathalie-11.webp'; ?>" alt="Image d'un mariage en arrière plan">
		<h1>PHOTOGRAPHE EVENT</h1>
	</section>

	<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
    
		<h1><?php the_title(); ?></h1>

    	<?php the_content(); ?>

	<?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>