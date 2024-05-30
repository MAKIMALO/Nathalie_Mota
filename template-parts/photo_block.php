<!-- Template du cadre d'une photo -->
    <?php

    if ( !isset( $image_url ) || !isset( $image_alt ) ) {
        return;
    }
    ?>

    <div id="photo-block">
        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" id="photo-block__img">
    </div>
