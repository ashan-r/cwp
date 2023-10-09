<?php
get_header(); ?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();
                    do_action( 'medilazar_single_before_content' );

					get_template_part( 'template-parts/post/content', get_post_format() );

					do_action( 'medilazar_single_after_content' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

            </main> <!-- #main -->
        </div> <!-- #primary -->
		<?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();
