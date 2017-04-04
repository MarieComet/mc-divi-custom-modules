<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
function CarouseldoCustomModule() {
	if(class_exists("ET_Builder_Module")){
		class ET_Builder_Module_Carousel extends ET_Builder_Module {
			function init() {
				wp_register_script( 'slick-carousel', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array('jquery'), '', true);
				wp_register_script( 'carousel-divi-module', plugin_dir_url( __FILE__ ) . 'carousel-divi-module.js', array('jquery','slick-carousel') );
				wp_register_style('slick-css', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css');
				wp_register_style('slick-theme', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css');
				if(!is_admin()) {
					wp_enqueue_script('slick-carousel');
					wp_enqueue_script('carousel-divi-module');
					wp_enqueue_style('slick-css');
					wp_enqueue_style('slick-theme');
				}

				$this->name            = esc_html__( 'Carousel' );
				$this->slug            = 'et_pb_slick_slider_mc';
				$this->child_slug      = 'et_pb_slick_slide_mc';
				$this->child_item_text = esc_html__( 'Carousel Item' );

				$this->whitelisted_fields = array();
				foreach ( $this->get_fields() as $name => $field ) {
					$this->whitelisted_fields[] = $name;
				}

			}

			function get_fields() {
				$fields = array(
			        'admin_label' => array(
			                'label'       => __( 'Admin Label', 'et_builder' ),
			                'type'        => 'text',
			                'description' => __( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
			        )
				);
				return $fields;
			}


			function shortcode_callback( $atts, $content = null, $function_name ) {

				$content = $this->shortcode_content;

				$fullwidth = 'et_pb_fullwidth_slider' === $function_name ? 'on' : 'off';


				$output = sprintf(
					'<div class="et_pb_module et_pb_slick_slider_mc">
						<div class="slick-carousel">
							%1$s
						</div> <!-- .et_pb_slides -->
					</div> <!-- .et_pb_slick_slider_mc -->
					',
					$content
				);

				return $output;
			}
		}
		new ET_Builder_Module_Carousel;


		class ET_Builder_Module_Carousel_Item extends ET_Builder_Module {
			function init() {
				$this->name                        = esc_html__( 'Carousel Item' );
				$this->slug                        = 'et_pb_slick_slide_mc';
				$this->type                        = 'child';

				$this->whitelisted_fields = array();
				foreach ( $this->get_fields() as $name => $field ) {
					$this->whitelisted_fields[] = $name;
				}

				$this->fields_defaults = array();

				$this->advanced_setting_title_text = esc_html__( 'Nouvel Item' );
				$this->settings_text               = esc_html__( 'Paramètres Item');
			}

			function get_fields() {
				$fields = array(
					'background_image' => array(
						'label'              => esc_html__( 'Background Image', 'et_builder' ),
						'type'               => 'upload',
						'option_category'    => 'basic_option',
						'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
						'choose_text'        => esc_attr__( 'Choose a Background Image', 'et_builder' ),
						'update_text'        => esc_attr__( 'Set As Background', 'et_builder' ),
						'description'        => esc_html__( 'Image de l\'item', 'et_builder' ),
					),
					'image_url' => array(
						'label'           => esc_html__( 'Url de l\'élément', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'basic_option',
						'description'     => esc_html__( 'Url de l\'item', 'et_builder' ),
					)
				);
				return $fields;
			}

			function shortcode_callback( $atts, $content = null, $function_name ) {

				$background_image = $this->shortcode_atts['background_image'];
				$url_image = $this->shortcode_atts['image_url'];

				$output = sprintf(
					'<div class="slide">
						<div class="et_pb_container clearfix">
							<div class="et_pb_slide_description">
								<div class="et_pb_slide_content"><a href="%2$s"><img src="%1$s" /></a></div>
							</div> <!-- .et_pb_slide_description -->
						</div> <!-- .et_pb_container -->
					</div>			
					',
					$background_image, 
					$url_image);

				return $output;
			}
		}
		new ET_Builder_Module_Carousel_Item;
	}
}
add_action('after_setup_theme', 'prepareCarouselModule', 999);
function prepareCarouselModule(){
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
		add_action($action_hook, 'CarouseldoCustomModule', 9789);
	}
}