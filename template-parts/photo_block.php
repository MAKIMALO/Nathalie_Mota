<?php
// Vérification de la disponibilité des données d'image
if (!isset($image_url) || !isset($image_alt) || !isset($post_id)) {
    echo '<p>Erreur : données d\'image non disponibles.</p>';
    return;
}

// Récupération des informations de la photo depuis le CPT
$category = get_the_terms($post_id, 'categorie');
$reference = get_post_meta($post_id, 'reference', true);

// Vérification et formatage des données de catégorie
if ($category && !is_wp_error($category)) {
    $category = $category[0]->name;
} else {
    $category = 'Aucune catégorie';
}

// Vérification et formatage de la référence
if (!$reference) {
    $reference = 'Aucune référence';
}
?>

<div id="photo-block" data-photo-id="<?php echo esc_attr($post_id); ?>" data-image-url="<?php echo esc_url($image_url); ?>">
    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" id="photo-block__img">
    <div id="photo-block-survol">
        <div id="photo-icon-group">
            <div id="photo_icon_fullscreen">
                <span class="fullscreen-icon"
                      data-image-url="<?php echo esc_url($image_url); ?>"
                      data-reference="<?php echo esc_attr($reference); ?>"
                      data-category="<?php echo esc_attr($category); ?>"
                      data-orientation="<?php echo (getimagesize($image_url)[0] > getimagesize($image_url)[1]) ? 'landscape' : 'portrait'; ?>">
                    <img class="img_icon_fullscreen" src="<?php echo get_template_directory_uri() . '/assets/images/icon_fullscreen.webp'; ?>" alt="Image d'une icône plein écran">
                </span>
            </div>
            <div id="photo_icon_eye">
                <a href="<?php echo get_permalink($post_id); ?>">
                    <img class="img_icon_eye" src="<?php echo get_template_directory_uri() . '/assets/images/icon_eye.webp'; ?>" alt="Image d'un icône oeil">
                </a>
            </div>
        </div>
        <div id="photo-info__details">
            <div class="photo_block_details_left">
                <p class="photo_block_reference"><?php echo esc_html($reference); ?></p>
            </div>
            <div class="photo_block_details_right">
                <p class="photo_block_categorie"><?php echo esc_html($category); ?></p>
            </div>
        </div>
    </div>
</div>