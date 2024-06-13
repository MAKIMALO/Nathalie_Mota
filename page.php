<?php get_header(); ?>

<main id="main" class="site-main">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <section class="entry-content">
                <?php the_content(); ?>
            </section>

    <?php endwhile;
    endif; ?>

</main>

<?php get_footer(); ?>