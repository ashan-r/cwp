<div class="column-item post-style-1">
    <div class="post-inner">

        <?php if (has_post_thumbnail() && '' !== get_the_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medilazar-featured-image-large'); ?>
                </a>
            </div><!-- .post-thumbnail -->

        <?php endif; ?>
        <div class="post-content">
            <header class="entry-header">
                <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php if ('post' === get_post_type()) : ?>
                    <div class="entry-meta">
                        <?php medilazar_entry_meta(); ?>
                    </div><!-- .entry-meta -->
                <?php endif; ?>

            </header>
            <div class="entry-content">
                <a class="more-link" href="<?php the_permalink(); ?>">
                    <i class="opal-icon-plus" aria-hidden="true"></i>
                    <span><?php echo esc_html__('Read more', 'medilazar') ?></span>
                </a>
            </div>
        </div>

    </div>
</div>