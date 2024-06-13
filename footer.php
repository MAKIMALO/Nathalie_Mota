
<footer>
    <div class="modal-overlay">    
        <?php get_template_part('template-parts/contact_modale'); ?>
    </div>
    <div id="lightbox-overlay">
        <?php get_template_part('template-parts/lightbox'); ?>
    </div>
    <div class="footer_site_menu">
    <?php wp_nav_menu(
        array(
            'theme_location' => 'footer-menu',
            'container' => 'false'
        )
    );
    ?>
    </div>
</footer>

<?php wp_footer(); ?>



</body>
</html>