<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
function BreadcrumbdoCustomModule() {
	if(class_exists("ET_Builder_Module")){

		class ET_Builder_Module_Breadcrumb extends ET_Builder_Module {
			function init() {
				$this->name       = esc_html__( 'Fil d\'ariane', 'et_builder' );
				$this->slug       = 'et_pb_breadcrumb';
				$this->fb_support = true;

				$this->whitelisted_fields = array(
					'background_layout',
					'module_id',
					'module_class',
					'admin_label',
				);

				$this->main_css_element = '%%order_class%%';
			}

			function get_fields() {
				$fields = array(
					'background_layout' => array(
						'label'             => esc_html__( 'Text Color', 'et_builder' ),
						'type'              => 'select',
						'option_category'   => 'color_option',
						'options'           => array(
							'light' => esc_html__( 'Dark', 'et_builder' ),
							'dark'  => esc_html__( 'Light', 'et_builder' ),
						),
						'description'       => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'et_builder' ),
					),
					'admin_label' => array(
						'label'       => esc_html__( 'Admin Label', 'et_builder' ),
						'type'        => 'text',
						'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
					),
					'module_id' => array(
						'label'           => esc_html__( 'CSS ID', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'configuration',
						'tab_slug'        => 'custom_css',
						'option_class'    => 'et_pb_custom_css_regular',
					),
					'module_class' => array(
						'label'           => esc_html__( 'CSS Class', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'configuration',
						'tab_slug'        => 'custom_css',
						'option_class'    => 'et_pb_custom_css_regular',
					),
				);
				return $fields;
			}

			function shortcode_callback( $atts, $content = null, $function_name ) {
				$background_layout = $this->shortcode_atts['background_layout'];
				$module_id         = $this->shortcode_atts['module_id'];
				$module_class      = $this->shortcode_atts['module_class'];

				$class = 'et_pb_bg_layout_'.$background_layout;

				include_once( plugin_dir_path( __FILE__ ) .'breadcrumb-function.php' );

				if (function_exists('seomix_content_breadcrumb')) {
					$output = '<div class="breadcrumb '.esc_attr($class).'">';
					$output .= '<style>
						.breadcrumb.et_pb_bg_layout_light {
							color: #9A1418;
						}
						.breadcrumb.et_pb_bg_layout_dark {
							color: #fff;
						}
					</style>';
					$output .= seomix_content_breadcrumb();
					$output .= '</div>';
					return $output;
				}
			}
		}
		new ET_Builder_Module_Breadcrumb;

	}
}

add_action('after_setup_theme', 'prepareBreadcrumbModule', 999);
function prepareBreadcrumbModule(){
	global $pagenow;

	$is_admin = is_admin();
	$action_hook = $is_admin ? 'wp_loaded' : 'wp';
	$required_admin_pages = array( 'edit.php', 'post.php', 'post-new.php', 'admin.php', 'customize.php', 'edit-tags.php', 'admin-ajax.php', 'export.php' ); // list of admin pages where we need to load builder files
	$specific_filter_pages = array( 'edit.php', 'admin.php', 'edit-tags.php' ); // list of admin pages where we need more specific filtering
	$is_edit_library_page = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
	$is_role_editor_page = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
	$is_import_page = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import']; // Page Builder files should be loaded on import page as well to register the et_pb_layout post type properly
	$is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

	if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
		add_action($action_hook, 'BreadcrumbdoCustomModule', 9789);
	}
}