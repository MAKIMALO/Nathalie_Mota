<!-- Template du cadre d'une photo -->
<?php

if ( !isset( $image_url ) || !isset( $image_alt ) ) {
    return;
}

// Récupérer les informations de la photo depuis le CPT
$category = get_the_terms( $post_id, 'categorie' );
$reference = get_post_meta( $post_id, 'reference', true );

if ( $category && ! is_wp_error( $category ) ) {
    $category = $category[0]->name;
} else {
    $category = 'Aucune catégorie';
}

if ( !$reference ) {
    $reference = 'Aucune référence';
}
?>

<div id="photo-block">
    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" id="photo-block__img">
    <div id="photo-block-survol">
        <div id="photo_icon_fullscreen" data-fullscreen-url="<?php echo esc_url( $image_url ); ?>">
            <img class="img_icon_fullscreen" src="<?php echo get_template_directory_uri() . '/assets/images/icon_fullscreen.webp'; ?>" alt="Image d'un icône plein écran">
        </div>    
        <div id="photo_icon_eye">
            <a href="<?php echo get_permalink( $post_id ); ?>">
                <img class="img_icon_eye" src="<?php echo get_template_directory_uri() . '/assets/images/icon_eye.webp'; ?>" alt="Image d'un icône oeil">
        </div>
        <div id="photo-info__details">
            <p class="photo_block_reference"><?php echo esc_html( $reference ); ?></p>
            <p class="photo_block_categorie"><?php echo esc_html( $category ); ?></p>
        </div>
    </div>
</div>
