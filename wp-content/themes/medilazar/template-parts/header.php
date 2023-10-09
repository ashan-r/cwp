<div class="site-header">
    <?php
    if (medilazar_is_header_builder()) { ?>
        <div class="container">
            <?php medilazar_the_header_builder(); ?>
        </div>
    <?php } else {
        $container = get_theme_mod('osf_header_width', true) ? 'container1' : 'container-fluid';
        ?>
        <div id="opal-header-content" class="header-content osf-sticky-active">
            <div class="custom-header container">
                <div class="header-main-content d-flex flex-wrap align-items-center justify-content-lg-between <?php echo get_theme_mod('osf_header_layout_is_sticky', false) ? ' opal-element-sticky' : ''; ?>">
                    <?php get_template_part('template-parts/header/site', 'branding'); ?>
                    <div class="header-right">
                        <?php get_search_form(); ?>
                        <?php if (has_nav_menu('top')) : ?>
                            <div class="navigation-top text-center">
                                <?php get_template_part('template-parts/header/navigation'); ?>
                            </div><!-- .navigation-top -->
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
        <?php
    }
    ?>
</div>
