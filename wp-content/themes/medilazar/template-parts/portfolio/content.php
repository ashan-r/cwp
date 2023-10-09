<article id="post-<?php the_ID(); ?>" <?php post_class( 'portfolio' ); ?>>
    <div class="portfolio-inner">
        <div class="portfolio-post-thumbnail">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medilazar-gallery-image' ); ?>
			<?php endif; ?>
        </div><!-- .post-thumbnail -->
        <div class="portfolio-content">
            <div class="portfolio-content-inner">
                <div class="entry-category"><?php echo OSF_Custom_Post_Type_Portfolio::getInstance()->get_term_portfolio( get_the_ID() ); ?></div>
                <h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
            </div>
        </div>
    </div>
</article><!-- #post-## -->