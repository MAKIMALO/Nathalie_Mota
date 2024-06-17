console.log("le fichier lightbox.js fonctionne");

// ACTION SUR L'ICONE FULLSCREEN DU FICHIER "PHOTO_BLOCK.PHP"
jQuery(document).ready(function($) {

    $('.fullscreen-icon').click(function(e) {
        e.preventDefault();
        console.log('Fullscreen icon clicked.');

        var imageUrl = $(this).closest('#photo-block').data('image-url');
        var caption = $(this).data('caption');

        console.log('Image URL:', imageUrl);
        console.log('Caption:', caption);

        openLightbox(imageUrl, caption);
    });

    function openLightbox(imageUrl, caption) {
        console.log('Opening lightbox with image URL:', imageUrl, 'and caption:', caption);

        var lightboxHTML = `
            <div class="custom-lightbox-overlay">
                <div class="lightbox-content">
                    <img src="${imageUrl}" alt="${caption}">
                    <p class="lightbox-caption">${caption}</p>
                    <button class="close-lightbox">Close</button>
                </div>
            </div>
        `;

        $('body').append(lightboxHTML);

        $('.close-lightbox').click(function() {
            console.log('Closing lightbox.');
            $('.custom-lightbox-overlay').remove();
        });
    }
});