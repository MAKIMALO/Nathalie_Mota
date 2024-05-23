<?php get_header(); ?>

<main class="site-main">
	<section class="banner">
		<img class="background_img" src="<?php echo get_template_directory_uri() . '/assets/images/nathalie-11.webp'; ?>" alt="Image d'un mariage en arrière plan">
		<h1>PHOTOGRAPHE EVENT</h1>
	</section>

	<section class="custom-posts">         

    <?php get_template_part( 'template-parts/single' ); ?>

    </section>

</main>

<?php get_footer(); ?>