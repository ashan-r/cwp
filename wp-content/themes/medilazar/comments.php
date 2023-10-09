<?php
if (post_password_required()) {
    return;
}
?>
<div id="comments" class="comments-area">
    <?php

    // You can start editing here -- including this comment!
    if (have_comments()) : ?>
        <div class="comment-list-wap">
            <h2 class="comments-title">
                <?php
                $comments_number = get_comments_number();

                printf(_n('%s Comment', '%s Comments', $comments_number, 'medilazar'), $comments_number);
                ?>
            </h2>
            <ol class="comment-list" data-opal-customizer="otf_comment_template">
                <?php
                wp_list_comments(array(
                    'avatar_size' => 100,
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'reply_text'  => esc_html__('Reply', 'medilazar'),
                ));
                ?>
            </ol>
        </div>
        <?php the_comments_pagination(array(
            'prev_text' => '<span class="fa fa-arrow-left"></span><span class="screen-reader-text">' . esc_html__('Previous page', 'medilazar') . '</span>',
            'next_text' => '<span class="screen-reader-text">' . esc_html__('Next page', 'medilazar') . '</span><span class="fa fa-arrow-right"></span>',
        ));
    endif; // Check for have_comments().

    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'medilazar'); ?></p>
    <?php
    endif;
    $args['submit_button'] = '<button name="%1$s" type="submit" id="%2$s" class="%3$s"><span>%4$s</span></button>';
    $args['label_submit']  = esc_html__('Post Comment', 'medilazar');
    comment_form($args);
    ?>

</div><!-- #comments -->
