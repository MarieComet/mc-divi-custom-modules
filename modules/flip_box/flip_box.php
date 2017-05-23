<?php
/**
 * @package MC_Divi_Custom_Divi_Flip_Box
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH') ) {
    exit;
}

function MC_Flip_Box() {
	if(class_exists("ET_Builder_Module")){

		class ET_Builder_Module_FlipBox extends ET_Builder_Module {
			function init() {
				$this->name       = esc_html__( 'Flip Box', 'et_builder' );
				$this->slug       = 'et_pb_flipbox';
				$this->fb_support = true;

				$this->whitelisted_fields = array(
					'face_text',
					'back_text',
					'bg_color',
					'bg_img',
					'admin_label',
					'module_id',
					'module_class',
				);

				$this->main_css_element = '%%order_class%%';

				wp_register_style( 'flipbox-css', plugin_dir_url( __FILE__ ) . 'flip-box.css' );
				wp_register_script( 'flip-js', plugin_dir_url( __FILE__ ) . 'flip-js.js', array('jquery') );

				if(!is_admin()) {
					wp_enqueue_style('flipbox-css');
					wp_enqueue_script('flip-js');
				}
			}

			function get_fields() {
				$fields = array(
					'face_text' => array(
						'label'           => esc_html__( 'Texte face', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'basic_option',
						'description'     => esc_html__( 'Texte face', 'et_builder' ),
					),
					'back_text' => array(
						'label'           => esc_html__( 'Texte derrière', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'basic_option',
						'description'     => esc_html__( 'Texte qui apparait au survol', 'et_builder' ),
					),
					'bg_color' => array(
						'label'             => esc_html__( 'Couleur de fond', 'et_builder' ),
						'type'              => 'color-alpha',
						'custom_color'      => true,
						'description'       => esc_html__( 'Couleur de fond', 'et_builder' ),
					),
					'bg_img' => array(
						'label'              => esc_html__( 'Image de fond', 'et_builder' ),
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
				$module_id            = $this->shortcode_atts['module_id'];
				$module_class         = $this->shortcode_atts['module_class'];
				$face_text				= $this->shortcode_atts['face_text'];
				$back_text				= $this->shortcode_atts['back_text'];
				$bg_color				= $this->shortcode_atts['bg_color'];
				$bg_img				= $this->shortcode_atts['bg_img'];

				$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

				//$this->shortcode_content = et_builder_replace_code_content_entities( $this->shortcode_content );

				if ( '' !== $bg_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%%:before',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $bg_color )
						),
					) );
				}

				if ( '' !== $bg_img ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%%',
						'declaration' => sprintf(
							'background-image: url("%1$s");',
							esc_html( $bg_img )
						),
					) );
				}

				$class = " et_pb_module";

				$output = sprintf(
					'<div%4$s class="et_pb_flipbox%3$s%5$s">
						<div class="box">
							<div class="face front">
								<p>%1$s</p>
							</div>
							<div class="face back">
								<p>%2$s</p>						
							</div>			
						</div>		
					</div><!-- .et_pb_flipbox -->',
					esc_html($face_text),
					esc_html($back_text),
					esc_attr( $class ),
					( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
					( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
				);

				return $output;
			}
		}
		new ET_Builder_Module_FlipBox;
	}
}

add_action('et_builder_ready', 'MC_Flip_Box');