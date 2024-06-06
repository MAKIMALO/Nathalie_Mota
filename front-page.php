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
    
    <!-- Affichage des filtres -->
    <section class="section-filter">
        <form class="filter-form">
            <div class="filter-group-1">
                <!-- Formulaire 1: Catégories -->
                <div class="filter-group">
                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'categorie', // Utilisez le slug correct de votre taxonomy
                        'hide_empty' => false,
                    ));
                    ?>
                    <label for="category-filter" class="visually-hidden">Catégories</label>
                    <select id="category-filter" name="category" placeholder="Catégorie">
                        <option></option> <!-- Option vide -->
                        <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category->term_id; ?>"><?= $category->name; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Formulaire 2: Formats -->
                <div class="filter-group">
                    <?php
                    $formats = get_terms(array(
                        'taxonomy' => 'format',
                        'hide_empty' => false,
                    ));
                    ?>
                    <label for="format-filter" class="visually-hidden">Format</label>
                    <select id="format-filter" name="format" placeholder="Format">
                        <option></option> <!-- Option vide -->
                        <?php if (!empty($formats) && !is_wp_error($formats)) : ?>
                            <?php foreach ($formats as $format) : ?>
                                <option value="<?= $format->term_id; ?>"><?= $format->name; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="filter-group-2">
                <!-- Formulaire 3: Tri par date -->
                <div class="filter-group">
                    <label for="date-filter" class="visually-hidden">Trier par</label>
                    <select id="date-filter" name="date_order" placeholder="Trier par">
                        <option></option> <!-- Option vide -->
                        <option value="DESC">Les plus récentes</option>
                        <option value="ASC">Les plus anciennes</option>
                    </select>
                </div>
            </div>
        </form>
    </section>
    <!-- Affichage de l'ensemble des pages "photos" -->
    <section class="section-gallery">
        <div class="photos-gallery">
        <?php
            $per_page = 8;

            $args = array(
                'post_type' => 'photos',
                'posts_per_page' => 8,
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
            <button class="load_more">Charger plus</button>
        </div>
    </section>

</main>

<?php get_footer(); ?>


</body>
</html>