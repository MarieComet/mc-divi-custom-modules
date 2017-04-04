<?php
/**
 * @package MC_Divi_Custom_Divi_Button
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH') ) {
    exit;
}
function ButtonDown(){
	if(class_exists("ET_Builder_Module")){
		class ET_Builder_Module_Button_Down extends ET_Builder_Module {
			function init() {
				$this->name       = esc_html__( 'Bouton bas', 'et_builder' );
				$this->slug       = 'et_pb_button_down';
				$this->fb_support = true;

				$this->whitelisted_fields = array(
					'button_url',
					'url_new_window',
					'src_img',
					'admin_label',
					'module_id',
					'module_class',
				);

				$this->fields_defaults = array(
					'url_new_window'    => array( 'off' ),
				);

				$this->main_css_element = '%%order_class%%';

				$this->custom_css_options = array(
					'main_element' => array(
						'label'    => esc_html__( 'Main Element', 'et_builder' ),
						'selector' => '.et_pb_button_down.et_pb_module',
						'no_space_before_selector' => true,
					)
				);
			}

			function get_fields() {
				$fields = array(
					'button_url' => array(
						'label'           => esc_html__( 'Bouton bas URL', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'basic_option',
						'description'     => esc_html__( 'Input the destination URL for your button.', 'et_builder' ),
					),
					'url_new_window' => array(
						'label'           => esc_html__( 'Url Opens', 'et_builder' ),
						'type'            => 'select',
						'option_category' => 'configuration',
						'options'         => array(
							'off' => esc_html__( 'In The Same Window', 'et_builder' ),
							'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
						),
						'description'       => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
					),
					'src_img' => array(
						'label'              => esc_html__( 'URL de l\'icône', 'et_builder' ),
						'type'               => 'upload',
						'option_category'    => 'basic_option',
						'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
						'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
						'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
						'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder' ),
					),
					'disabled_on' => array(
						'label'           => esc_html__( 'Disable on', 'et_builder' ),
						'type'            => 'multiple_checkboxes',
						'options'         => array(
							'phone'   => esc_html__( 'Phone', 'et_builder' ),
							'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
							'desktop' => esc_html__( 'Desktop', 'et_builder' ),
						),
						'additional_att'  => 'disable_on',
						'option_category' => 'configuration',
						'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
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
				$module_id         = $this->shortcode_atts['module_id'];
				$module_class      = $this->shortcode_atts['module_class'];
				$button_url        = $this->shortcode_atts['button_url'];
				$url_new_window    = $this->shortcode_atts['url_new_window'];
				$src_img           = $this->shortcode_atts['src_img'];

				// Nothing to output if neither Bouton bas Text nor Bouton bas URL defined
				if ( '' === $button_url ) {
					return;
				}

				$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

				$module_class .= " et_pb_module";
				$output = sprintf(
					'<div class="et_pb_button_down_module_wrapper et_pb_module">
						<style>
						body #page-container .et_pb_button_down_module_wrapper > a {
							display: inline-block;
							margin: 0;
							padding: 0;
							width: 100%%;
							text-align: center;
							margin-top: -25px;
						}
						body #page-container a.et_pb_button_down:before {
							display: none;
						}
						body #page-container .et_pb_button_down_module_wrapper > a img {
							max-width: 50px;
						}
						</style>
						<a class="et_pb_button_down%3$s%4$s" href="%1$s"%2$s><img %5$s /></a>
					</div>',
					esc_url( $button_url ),
					( 'on' === $url_new_window ? ' target="_blank"' : '' ),
					( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
					( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
					( '' !== $src_img ? sprintf( ' src="%1$s"', esc_url( $src_img ) ) : 'src="'.plugin_dir_url( __FILE__ ).'arrow-down.png"' )

				);

				return $output;
			}
		}
		new ET_Builder_Module_Button_Down;
	}
}
add_action('after_setup_theme', 'prepareButtonDown', 999);
function prepareButtonDown(){
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
		add_action($action_hook, 'ButtonDown', 9999);
	}
}