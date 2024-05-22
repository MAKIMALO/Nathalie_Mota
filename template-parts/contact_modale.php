
<!-- Ajout de la modale de contact -->

<div id="contactModal" class="modale-overlay">
    <div class="modale-global">    
        <div class="modale-header">
            <span class="closeBtn">X</span>
            <img class="img_contact_modale" src="<?php echo get_template_directory_uri() . '/assets/images/Contact-header.webp'; ?>" alt="Titre de la modale de contact">
        </div>
        <div class="modale">
            <?php echo do_shortcode('[contact-form-7 id="87f570d" title="Modale contact"]');?>
        </div>
    </div>
</div>


</body>
</html>