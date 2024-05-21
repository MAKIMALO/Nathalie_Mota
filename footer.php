<?php get_template_part( 'template-parts/contact_modale' ); ?>

</main>

<footer class="footer_site_menu">
    <?php wp_nav_menu(
        array(
            'theme_location' => 'footer-menu',
            'container' => 'false'
        )
    );
    ?>

</footer>
</div>

<?php wp_footer(); ?>

<!-- Inclusion du fichier script modale.js -->
<script src="<?php echo get_template_directory_uri(); ?>/js/modale.js" type="text/javascript"></script>

</body>
</html>