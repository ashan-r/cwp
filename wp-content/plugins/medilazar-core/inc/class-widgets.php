<?php

class OSF_WP_Widget_Recent_Posts extends WP_Widget_Recent_Posts {

	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'medilazar-core' );

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		), $instance ) );

		if ( ! $r->have_posts() ) {
			return;
		}
		?>
		<?php echo $args['before_widget']; ?>
		<?php
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
        <ul>
			<?php foreach ( $r->posts as $recent_post ) : ?>
				<?php
				$post_title = get_the_title( $recent_post->ID );
				$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)', 'medilazar-core' );
				?>
                <li class="item-recent-post">
					<?php if ( has_post_thumbnail( $recent_post->ID ) ): ?>
                        <div class="thumbnail-post"><?php echo get_the_post_thumbnail( $recent_post->ID, 'medilazar-thumbnail' ); ?></div>
					<?php endif; ?>
                    <div class="title-post">
                        <a href="<?php the_permalink( $recent_post->ID ); ?>"><?php echo $title; ?></a>
						<?php if ( $show_date ) : ?>
                            <span class="post-date"><?php echo get_the_date( '', $recent_post->ID ); ?></span>
						<?php endif; ?>
                    </div>
                </li>
			<?php endforeach; ?>
        </ul>
		<?php
		echo $args['after_widget'];
	}
}

function osf_widget_registration() {
	register_widget( 'OSF_WP_Widget_Recent_Posts' );
}

add_action( 'widgets_init', 'osf_widget_registration' );