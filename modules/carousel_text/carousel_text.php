<?php
/**
 * Plugin Name: Divi Module Testimonial Carousel
 * Description: Custom module for Divi create testimonial Carousel
 * Version: 1.0.0
 * Author: Marie Comet
 * Author URI: http://mariecomet.fr
 * License: MIT License
 * Text Domain: Divi
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
function MC_Carousel_Testimonial() {
	if(class_exists("ET_Builder_Module")){
		class ET_Builder_Module_Carousel_Testi extends ET_Builder_Module {
			function init() {
				wp_register_script( 'slick-carousel', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array('jquery'), '', true);
				wp_register_script( 'slick-carousel-text', plugin_dir_url( __FILE__ ) . 'slick-carousel-text.js', array('jquery','slick-carousel') );
				wp_register_style('slick-css', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css');
				wp_register_style('slick-theme', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css');
				wp_enqueue_style( 'carousel-text', plugin_dir_url( __FILE__ ) . 'carousel-text.css'  );

				if(!is_admin()) {
					wp_enqueue_script('slick-carousel');
					wp_enqueue_script('slick-carousel-text');
					wp_enqueue_style('slick-css');
					wp_enqueue_style('slick-theme');
				}

				$this->name            = esc_html__( 'Carousel Personnes' );
				$this->slug            = 'et_pb_slick_slider_mc_testi';
				$this->child_slug      = 'et_pb_slick_slide_mc_testi';
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
					'<div class="et_pb_module et_pb_slick_slider_mc_testi">
						<div class="slick-carousel-testi">
							%1$s
						</div> <!-- .et_pb_slides -->
					</div> <!-- .et_pb_slick_slider_mc_testi -->
					',
					$content
				);

				return $output;
			}
		}
		new ET_Builder_Module_Carousel_Testi;


		class ET_Builder_Module_Carousel_Testi_Item extends ET_Builder_Module {
			function init() {
				$this->name                        = esc_html__( 'Carousel Item' );
				$this->slug                        = 'et_pb_slick_slide_mc_testi';
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
					),
					'name' => array(
						'label'       => esc_html__( 'Nom', 'et_builder' ),
						'type'        => 'text',
						'description' => esc_html__( 'Nom à afficher', 'et_builder' ),
					),
					'fonction' => array(
						'label'       => esc_html__( 'Fonction', 'et_builder' ),
						'type'        => 'text',
						'description' => esc_html__( 'Fonction à afficher', 'et_builder' ),
					),
				);
				return $fields;
			}

			function shortcode_callback( $atts, $content = null, $function_name ) {

				$background_image = $this->shortcode_atts['background_image'];
				$url_image = $this->shortcode_atts['image_url'];
				$name = $this->shortcode_atts['name'];
				$fonction = $this->shortcode_atts['fonction'];

				$output = sprintf(
					'<div class="slide">
						<div class="et_pb_container clearfix">
							<div class="et_pb_slide_description">
								<div class="et_pb_slide_content">
									<a href="%2$s">
										<img src="%1$s" />
									</a>
									<p class="name">%3$s</p>
									<p class="fonction">%4$s</p>
								</div>
							</div> <!-- .et_pb_slide_description -->
						</div> <!-- .et_pb_container -->
					</div>			
					',
					$background_image, 
					$url_image,
					$name,
					$fonction);

				return $output;
			}
		}
		new ET_Builder_Module_Carousel_Testi_Item;
	} else {
		add_action( 'admin_notices', 'MC_admin_notice' );      
		return;
	}
}

add_action('et_builder_ready', 'MC_Carousel_Testimonial');