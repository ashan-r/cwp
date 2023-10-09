<?php

defined( 'ABSPATH' ) || exit();

add_action( 'elementor/widgets/register', "osf_include_single_widgets" );

function osf_include_single_widgets( $widgets_manager ) {
	$files = glob( OM_PLUGIN_INC_DIR . "widgets/*.php" );
	foreach ( $files as $file ) {
		$class = "OSF_Elementor_" . ucfirst( basename( str_replace( '.php', '', $file ) ) ) . '_Widget';
		require_once( $file );
		if ( class_exists( $class ) ) {
			$widgets_manager->register( new $class() );
		}

	}
}

/**
 * Hook to delete post elementor related with this menu
 */
add_action( "before_delete_post", "osf_on_delete_menu_item", 9 );
function osf_on_delete_menu_item( $post_id ) {
	if ( is_nav_menu_item( $post_id ) ) {
		$related_id = osf_get_post_related_menu( $post_id );
		if ( $related_id ) {
			wp_delete_post( $related_id, true );
		}
	}
}

// add_filter( 'wp_setup_nav_menu_item','osf_custom_nav_item' );
function osf_custom_nav_item( $menu_item ) {
	$menu_item->mega_data = osf_get_megamenu_item_data( $menu_item->ID );

	return $menu_item;
}


add_filter( 'elementor/editor/footer', 'osf_add_back_button_inspector' );
function osf_add_back_button_inspector() {
	if ( ! isset( $_GET['opal-menu-editable'] ) || ! $_GET['opal-menu-editable'] ) {
		return;
	}
	?>
    <script type="text/javascript">
        (function ($) {
            $('#tmpl-elementor-panel-footer-content').remove();
        })(jQuery);
    </script>
    <script type="text/template" id="tmpl-elementor-panel-footer-content">
        <div id="elementor-panel-footer-back-to-admin" class="elementor-panel-footer-tool elementor-leave-open tooltip-target" data-tooltip="<?php esc_attr_e( 'Back', 'medilazar-core' ); ?>">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </div>
        <div id="elementor-panel-footer-responsive" class="elementor-panel-footer-tool">
            <i class="eicon-device-desktop tooltip-target" aria-hidden="true" data-tooltip="<?php esc_attr_e( 'Responsive Mode', 'medilazar-core' ); ?>"></i>
            <span class="elementor-screen-only">
					<?php echo __( 'Responsive Mode', 'medilazar-core' ); ?>
				</span>
            <div class="elementor-panel-footer-sub-menu-wrapper">
                <div class="elementor-panel-footer-sub-menu">
                    <div class="elementor-panel-footer-sub-menu-item" data-device-mode="desktop">
                        <i class="elementor-icon eicon-device-desktop" aria-hidden="true"></i>
                        <span class="elementor-title"><?php echo __( 'Desktop', 'medilazar-core' ); ?></span>
                        <span class="elementor-description"><?php echo __( 'Default Preview', 'medilazar-core' ); ?></span>
                    </div>
                    <div class="elementor-panel-footer-sub-menu-item" data-device-mode="tablet">
                        <i class="elementor-icon eicon-device-tablet" aria-hidden="true"></i>
                        <span class="elementor-title"><?php echo __( 'Tablet', 'medilazar-core' ); ?></span>
						<?php $breakpoints = Elementor\Core\Responsive\Responsive::get_breakpoints(); ?>
                        <span class="elementor-description"><?php echo sprintf( __( 'Preview for %s', 'medilazar-core' ), $breakpoints['md'] . 'px' ); ?></span>
                    </div>
                    <div class="elementor-panel-footer-sub-menu-item" data-device-mode="mobile">
                        <i class="elementor-icon eicon-device-mobile" aria-hidden="true"></i>
                        <span class="elementor-title"><?php echo __( 'Mobile', 'medilazar-core' ); ?></span>
                        <span class="elementor-description"><?php echo __( 'Preview for 360px', 'medilazar-core' ); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div id="elementor-panel-footer-history" class="elementor-panel-footer-tool elementor-leave-open tooltip-target" data-tooltip="<?php esc_attr_e( 'History', 'medilazar-core' ); ?>">
            <i class="fa fa-history" aria-hidden="true"></i>
            <span class="elementor-screen-only"><?php echo __( 'History', 'medilazar-core' ); ?></span>
        </div>
        <div id="elementor-panel-saver-button-preview" class="elementor-panel-footer-tool tooltip-target" data-tooltip="<?php esc_attr_e( 'Preview Changes', 'medilazar-core' ); ?>">
				<span id="elementor-panel-saver-button-preview-label">
					<i class="fa fa-eye" aria-hidden="true"></i>
					<span class="elementor-screen-only"><?php echo __( 'Preview Changes', 'medilazar-core' ); ?></span>
				</span>
        </div>
        <div id="elementor-panel-saver-publish" class="elementor-panel-footer-tool">
            <button id="elementor-panel-saver-button-publish" class="elementor-button elementor-button-success elementor-saver-disabled">
					<span class="elementor-state-icon">
						<i class="fa fa-spin fa-circle-o-notch" aria-hidden="true"></i>
					</span>
                <span id="elementor-panel-saver-button-publish-label">
						<?php echo __( 'Publish', 'medilazar-core' ); ?>
					</span>
            </button>
        </div>
        <div id="elementor-panel-saver-save-options" class="elementor-panel-footer-tool">
            <button id="elementor-panel-saver-button-save-options" class="elementor-button elementor-button-success tooltip-target elementor-saver-disabled" data-tooltip="<?php esc_attr_e( 'Save Options', 'medilazar-core' ); ?>">
                <i class="fa fa-caret-up" aria-hidden="true"></i>
                <span class="elementor-screen-only"><?php echo __( 'Save Options', 'medilazar-core' ); ?></span>
            </button>
            <div class="elementor-panel-footer-sub-menu-wrapper">
                <p class="elementor-last-edited-wrapper">
						<span class="elementor-state-icon">
							<i class="fa fa-spin fa-circle-o-notch" aria-hidden="true"></i>
						</span>
                    <span class="elementor-last-edited">
							{{{ elementor.config.document.last_edited }}}
						</span>
                </p>
                <div class="elementor-panel-footer-sub-menu">
                    <div id="elementor-panel-saver-menu-save-draft" class="elementor-panel-footer-sub-menu-item elementor-saver-disabled">
                        <i class="elementor-icon fa fa-save" aria-hidden="true"></i>
                        <span class="elementor-title"><?php echo __( 'Save Draft', 'medilazar-core' ); ?></span>
                    </div>
                    <div id="elementor-panel-saver-menu-save-template" class="elementor-panel-footer-sub-menu-item">
                        <i class="elementor-icon fa fa-folder" aria-hidden="true"></i>
                        <span class="elementor-title"><?php echo __( 'Save as Template', 'medilazar-core' ); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </script>

	<?php
}

add_action( 'wp_ajax_osf_load_menu_data', 'osf_load_menu_data' );
function osf_load_menu_data() {
	$nonce   = ! empty( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
	$menu_id = ! empty( $_POST['menu_id'] ) ? absint( $_POST['menu_id'] ) : false;
	if ( ! wp_verify_nonce( $nonce, 'osf-menu-data-nonce' ) || ! $menu_id ) {
		wp_send_json( array(
			'message' => __( 'Access denied', 'medilazar-core' )
		) );
	}

	$data = osf_get_megamenu_item_data( $menu_id );

	$data = $data ? $data : array();
	if ( isset( $_POST['istop'] ) && absint( $_POST['istop'] ) == 1 ) {
		if ( class_exists( 'Elementor\Plugin' ) ) {
			if ( isset( $data['enabled'] ) && $data['enabled'] ) {
				$related_id = osf_get_post_related_menu( $menu_id );
				if ( ! $related_id ) {
					osf_create_related_post( $menu_id );
					$related_id = osf_get_post_related_menu( $menu_id );
				}

				if ( $related_id && isset( $_REQUEST['menu_id'] ) && is_admin() ) {
					$url                      = Elementor\Plugin::instance()->documents->get( $related_id )->get_edit_url();
					$data['edit_submenu_url'] = add_query_arg( array( 'opal-menu-editable' => 1 ), $url );
				}
			} else {
				$url                      = admin_url();
				$data['edit_submenu_url'] = add_query_arg( array(
					'opal-menu-createable' => 1,
					'menu_id'              => $menu_id
				), $url );
			}
		}
	}

	$results = apply_filters( 'osf_menu_settings_data', array(
		'status' => true,
		'data'   => $data
	) );

	wp_send_json( $results );

}

add_action( 'wp_ajax_osf_update_menu_item_data', 'osf_update_menu_item_data' );
function osf_update_menu_item_data() {
	$nonce = ! empty( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';
	if ( ! wp_verify_nonce( $nonce, 'osf-update-menu-item' ) ) {
		wp_send_json( array(
			'message' => __( 'Access denied', 'medilazar-core' )
		) );
	}

	$settings = ! empty( $_POST['opal-menu-item'] ) ? ( $_POST['opal-menu-item'] ) : array();
	$menu_id  = ! empty( $_POST['menu_id'] ) ? absint( $_POST['menu_id'] ) : false;

	do_action( 'opal_before_update_menu_settings', $settings );


	osf_update_item_data( $menu_id, $settings );

	do_action( 'opal_menu_settings_updated', $settings );
	wp_send_json( array( 'status' => true ) );
}

add_filter( 'opal_nav_menu_args', 'osf_set_menu_args', 99999 );
function osf_set_menu_args( $args ) {
	$args['walker'] = new OSF_Megamenu_Walker();

	return $args;
}

add_action( 'admin_footer', 'osf_menu_underscore_template' );
function osf_menu_underscore_template() {
	global $pagenow;
	if ( $pagenow === 'nav-menus.php' ) { ?>
        <script type="text/html" id="tpl-osf-menu-item-modal">
            <div id="osf-modal" class="osf-modal">
                <div id="osf-modal-body" class="<%= data.edit_submenu === true ? 'edit-menu-active' : ( data.is_loading ? 'loading' : '' ) %>">
                    <% if ( data.edit_submenu !== true && data.is_loading !== true ) { %>
                    <form id="menu-edit-form">
                        <% } %>
                        <div class="osf-modal-content">
                            <% if ( data.edit_submenu === true ) { %>
                            <iframe src="<%= data.edit_submenu_url %>"/>
                            <% } else if ( data.is_loading === true ) { %>
                            <i class="fa fa-spin fa-spinner"></i>
                            <% } else { %>
                            <div class="form-group">
                                <label for="icon_color"><?php _e( 'Menu Description', 'medilazar-core' ) ?></label>
                                <input type="text" name="opal-menu-item[description]" value="<%= data.description %>" class="input" id="menu_description"/>
                            </div>
                            <div class="form-group">
                                <label for="icon"><?php _e( 'Icon', 'medilazar-core' ) ?></label>
                                <select id="icon" name="opal-menu-item[icon]" class="form-control icon-picker">
                                    <option value=""
                                    <%= data.icon == '' ? ' selected' : ''
                                    %>><?php echo esc_html( "No Use", "opalmegamenu" ) ?></option>
									<?php foreach ( osf_get_fontawesome_icons() as $value => $text ) : ?>

                                        <option value="<?php echo esc_attr( $value ) ?>"<%= data.icon == '<?php echo esc_attr( $value ) ?>' ? ' selected' : '' %>><?php echo esc_attr( $text ) ?></option>
									<?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="icon_color"><?php _e( 'Icon Color', 'medilazar-core' ) ?></label>
                                <input class="color-picker" name="opal-menu-item[icon_color]" value="<%= data.icon_color %>" id="icon_color"/>
                            </div>

                            <div class="form-group">
                                <label for="badge_title"><?php _e( 'Badges Title', 'medilazar-core' ) ?></label>
                                <input class="form-control" name="opal-menu-item[badge_title]" value="<%= data.badge_title %>" id="badge_title"/>
                            </div>
                            <div class="form-group">
                                <label for="badge_color"><?php _e( 'Badges Color', 'medilazar-core' ) ?></label>
                                <input class="color-picker" name="opal-menu-item[badge_color]" value="<%= data.badge_color %>" id="badge_color"/>
                            </div>
                            <div class="form-group">
                                <label for="badges_bg_color"><?php _e( 'Badges Bg Color', 'medilazar-core' ) ?></label>
                                <input class="color-picker" name="opal-menu-item[badges_bg_color]" value="<%= data.badges_bg_color %>" id="badges_bg_color"/>
                            </div>

                            <div class="form-group submenu-setting toggle-select-setting">
                                <label><?php _e( 'Mega Submenu Enabled', 'medilazar-core' ) ?></label>
                                <select name="opal-menu-item[enabled]" class="opal-input-switcher opal-input-switcher-true" data-target=".submenu-width-setting">
                                    <option value="1"
                                    <%= data.enabled == 1? 'selected':''
                                    %>> <?php _e( 'Yes', 'medilazar-core' ) ?></opttion>
                                    <option value="0"
                                    <%= data.enabled == 0? 'selected':'' %>><?php _e( 'No', 'medilazar-core' ) ?></opttion>
                                </select>
                                <button id="edit-megamenu" class="button button-primary button-large">
									<?php _e( 'Edit Megamenu Submenu', 'medilazar-core' ) ?>
                                </button>
                            </div>

                            <div class="form-group submenu-width-setting toggle-select-setting" style="display: none">
                                <label><?php _e( 'Sub Megamenu Width', 'medilazar-core' ) ?></label>
                                <select name="opal-menu-item[customwidth]" class="opal-input-switcher opal-input-switcher-true" data-target=".submenu-subwidth-setting">
                                    <option value="1"
                                    <%= data.customwidth == 1? 'selected':''
                                    %>> <?php _e( 'Yes', 'medilazar-core' ) ?></opttion>
                                    <option value="3"
                                    <%= data.customwidth == 3? 'selected':''
                                    %>><?php _e( 'Set Container Width', 'medilazar-core' ) ?></opttion>
                                    <option value="0"
                                    <%= data.customwidth == 0? 'selected':''
                                    %>><?php _e( 'Set Full Width', 'medilazar-core' ) ?></opttion>
                                    <option value="2"
                                    <%= data.customwidth == 2? 'selected':''
                                    %>><?php _e( 'Set Stretch Width', 'medilazar-core' ) ?></opttion>
                                    <option value="4"
                                    <%= data.customwidth == 4? 'selected':''
                                    %>><?php _e( 'Set Left Full Width', 'medilazar-core' ) ?></opttion>
                                </select>
                            </div>

                            <div class="form-group submenu-width-setting submenu-subwidth-setting toggle-select-setting" style="display: none">
                                <label for="menu_subwidth"><?php _e( 'Sub Mega Menu Max Width', 'medilazar-core' ) ?></label>
                                <input type="text" name="opal-menu-item[subwidth]" value="<%= data.subwidth?data.subwidth:'600' %>" class="input" id="menu_subwidth"/>
                                <span class="unit">px</span>
                            </div>

                            <% } %>
                        </div>
                        <% if ( data.is_loading !== true && data.edit_submenu !== true ) { %>
                        <div class="osf-modal-footer">
                            <a href="#" class="close button"><%= osf_memgamnu_params.i18n.close %></a>
							<?php wp_nonce_field( 'osf-update-menu-item', 'nonce' ) ?>
                            <input name="menu_id" value="<%= data.menu_id %>" type="hidden"/>
                            <button type="submit" class="button button-primary button-large menu-save pull-right"><%=
                                osf_memgamnu_params.i18n.submit %>
                            </button>
                        </div>
                        <% } %>
                        <% if ( data.edit_submenu !== true && data.is_loading !== true ) { %>
                    </form>
                    <% } %>
                </div>
                <div class="osf-modal-overlay"></div>
            </div>
        </script>
	<?php }
}







