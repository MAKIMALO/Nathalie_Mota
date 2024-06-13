<?php get_header(); ?>

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
    <div class="page-container">
        <section class="section-filter">
            <form class="filter-form">
                <div class="filter-group-1">
                    <!-- Formulaire 1 : Catégories -->
                    <div class="filter-group">
                        <?php $categories = get_terms(array(
                            'taxonomy' => 'categorie',
                            'hide_empty' => false,
                        )); ?>
                        <div class="dropdown">
                            <input type="checkbox" class="dropdown__switch" id="category-switch" hidden />
                            <label for="category-switch" class="dropdown__options-filter">
                                <span class="dropdown__filter-selected">Catégories</span>
                                <span class="dropdown__arrow"></span>
                                <ul class="dropdown__filter" role="listbox" tabindex="-1">
                                    <li class="dropdown__select-option" role="option" data-value="">Catégories</li>
                                    <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                                        <?php foreach ($categories as $category) : ?>
                                            <li class="dropdown__select-option" role="option" data-value="<?= $category->term_id; ?>"><?= $category->name; ?></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </label>
                        </div>
                    </div>

                    <!-- Formulaire 2 : Formats -->
                    <div class="filter-group">
                        <?php $formats = get_terms(array(
                            'taxonomy' => 'format',
                            'hide_empty' => false,
                        )); ?>
                        <div class="dropdown">
                            <input type="checkbox" class="dropdown__switch" id="format-switch" hidden />
                            <label for="format-switch" class="dropdown__options-filter">
                                <span class="dropdown__filter-selected">Formats</span>
                                <span class="dropdown__arrow"></span>
                                <ul class="dropdown__filter" role="listbox" tabindex="-1">
                                    <li class="dropdown__select-option" role="option" data-value="">Formats</li>
                                    <?php if (!empty($formats) && !is_wp_error($formats)) : ?>
                                        <?php foreach ($formats as $format) : ?>
                                            <li class="dropdown__select-option" role="option" data-value="<?= $format->term_id; ?>"><?= $format->name; ?></li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="filter-group-2">
                    <!-- Formulaire 3 : Tri par date -->
                    <div class="filter-group">
                        <div class="dropdown">
                            <input type="checkbox" class="dropdown__switch" id="date-switch" hidden />
                            <label for="date-switch" class="dropdown__options-filter">
                                <span class="dropdown__filter-selected">Trier par</span>
                                <span class="dropdown__arrow"></span>
                                <ul class="dropdown__filter" role="listbox" tabindex="-1">
                                    <li class="dropdown__select-option" role="option" data-value="">Trier par</li>
                                    <li class="dropdown__select-option" role="option" data-value="DESC">Des plus récentes aux plus anciennes</li>
                                    <li class="dropdown__select-option" role="option" data-value="ASC">Des plus anciennes aux plus récentes</li>
                                </ul>
                            </label>
                        </div>
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
                    'posts_per_page' => $per_page,
                );
                $query = new WP_Query($args);

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                        $post_id = get_the_ID();
                
                        $categories = wp_get_post_terms($post_id, 'categorie', array('fields' => 'names'));
                        $category = !empty($categories) ? $categories[0] : '';
                
                        $reference = get_post_meta($post_id, 'reference', true);
                
                        include(get_template_directory() . '/template-parts/photo_block.php');
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>Aucune photo trouvée.</p>';
                endif;
                ?>
            </div>
            <div class="load-more-photos">
                <button class="load_more">Charger plus</button>
            </div>
        </section>
    </div>

<?php get_footer(); ?>


</body>
</html>