<?php
$style = get_theme_mod('osf_blog_archive_style', '');
if (!empty($style) && $style != 1):
    echo '<div class="row">';
    /* Start the Loop */
    while (have_posts()) : the_post();

        get_template_part('template-parts/posts-grid/item-post', 'style-' . $style); // WPCS: XSS ok.

    endwhile;
    echo '</div>';
else:
    /* Start the Loop */
    while (have_posts()) : the_post();

        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        get_template_part('template-parts/post/content', get_post_format());

    endwhile;
endif;
