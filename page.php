<?php get_header(); ?>

<main class="site-main">
	<?php if (is_front_page()) : ?>
	<section class="banner">
		<img class="background_img" src="<?php echo get_template_directory_uri() . '/assets/images/nathalie-11.webp'; ?>" alt="Image d'un mariage en arrière plan">
		<h1>PHOTOGRAPHE EVENT</h1>
	</section>
	<?php endif; ?>

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


    <?php if (is_front_page()) : ?>
        <?php get_template_part('template-parts/single-photos'); ?>
    <?php endif; ?>

</main>

<?php get_footer(); ?>