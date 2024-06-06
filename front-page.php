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
    <section id="filter">
        <form id="filter-form">
            <!-- Formulaire 1: Catégories -->
            <div class="filter-group">
                <label for="category-filter">Catégories :</label>
                    <?php
                    $categories = get_categories();
                    ?>
                <select id="category-filter" name="category" placeholder="Sélectionner une catégorie">
                    <option></option> <!-- Option vide -->
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->term_id; ?>"><?= $category->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Formulaire 2: Formats -->
            <div class="filter-group">
                <label for="format-filter">Formats :</label>
                    <?php
                    $formats = get_terms(array(
                        'taxonomy' => 'format',
                        'hide_empty' => false,
                    ));
                    ?>
                <select id="format-filter" name="format" placeholder="Sélectionner un format">
                    <option></option> <!-- Option vide -->
                    <?php foreach ($formats as $format) : ?>
                        <option value="<?= $format->term_id; ?>"><?= $format->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Formulaire 3: Tri par date -->
            <div class="filter-group">
                <label for="date-filter">Trier par date :</label>
                <select id="date-filter" name="date_order" placeholder="Sélectionner un ordre">
                    <option></option> <!-- Option vide -->
                    <option value="DESC">Les plus récentes</option>
                    <option value="ASC">Les plus anciennes</option>
                </select>
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