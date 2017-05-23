<?php

function CustomPostSlider(){
	if(class_exists("ET_Builder_Module")){
		class ET_Builder_Custom_Post_Slider extends ET_Builder_Module {
			function init() {
				$this->name = esc_html__( 'Slider Posts à la une', 'et_builder' );
				$this->slug = 'et_pb_mc_fullwidth_post_slider';
				$this->fullwidth  = true;

				// need to use global settings from the fullwidth slider module
				$this->global_settings_slug = 'et_pb_fullwidth_slider';

				$this->whitelisted_fields = array(
					'show_arrows',
					'show_pagination',
					'auto',
					'auto_speed',
					'auto_ignore_hover',
					'parallax',
					'parallax_method',
					'remove_inner_shadow',
					'background_position',
					'background_size',
					'admin_label',
					'module_id',
					'module_class',
					'top_padding',
					'bottom_padding',
					'hide_content_on_mobile',
					'hide_cta_on_mobile',
					'show_image_video_mobile',
					'posts_number',
					'show_more_button',
					'more_text',
					'content_source',
					'background_color',
					'show_image',
					'image_placement',
					'background_image',
					'background_layout',
					'use_bg_overlay',
					'use_text_overlay',
					'bg_overlay_color',
					'text_overlay_color',
					'orderby',
					'show_meta',
					'use_manual_excerpt',
					'excerpt_length',
					'text_border_radius',
					'arrows_custom_color',
					'dot_nav_custom_color',
					'top_padding_tablet',
					'top_padding_phone',
					'bottom_padding_tablet',
					'bottom_padding_phone',
				);

				$this->fields_defaults = array(
					'show_arrows'             => array( 'on' ),
					'show_pagination'         => array( 'on' ),
					'auto'                    => array( 'off' ),
					'auto_speed'              => array( '7000' ),
					'auto_ignore_hover'       => array( 'off' ),
					'parallax'                => array( 'off' ),
					'parallax_method'         => array( 'off' ),
					'remove_inner_shadow'     => array( 'off' ),
					'background_position'     => array( 'default' ),
					'background_size'         => array( 'default' ),
					'hide_content_on_mobile'  => array( 'off' ),
					'hide_cta_on_mobile'      => array( 'off' ),
					'show_image_video_mobile' => array( 'off' ),
					'more_text'               => array( 'Read More' ),
					'background_color'        => array( '' ),
					'image_placement'         => array( 'background' ),
					'background_layout'       => array( 'dark' ),
					'orderby'                 => array( 'date_desc' ),
					'excerpt_length'          => array( '270' ),
					'use_bg_overlay'          => array( 'on' ),
				);

				$this->main_css_element = '%%order_class%%.et_pb_slider';
				$this->advanced_options = array(
					'fonts' => array(
						'header' => array(
							'label'    => esc_html__( 'Header', 'et_builder' ),
							'css'      => array(
								'main' => "{$this->main_css_element} .et_pb_slide_description .et_pb_slide_title",
							),
						),
						'body'   => array(
							'label'    => esc_html__( 'Body', 'et_builder' ),
							'css'      => array(
								'line_height' => "{$this->main_css_element}",
								'main' => "{$this->main_css_element} .et_pb_slide_content",
								'important' => 'all',
							),
						),
						'meta'   => array(
							'label'    => esc_html__( 'Meta', 'et_builder' ),
							'css'      => array(
								'main' => "{$this->main_css_element} .et_pb_slide_content .post-meta, {$this->main_css_element} .et_pb_slide_content .post-meta a",
								'important' => 'all',
							),
							'line_height' => array(
								'default' => '1em',
							),
							'font_size' => array(
								'default' => '16px',
							),
							'letter_spacing' => array(
								'default' => '0',
							),
						),
					),
					'button' => array(
						'button' => array(
							'label' => esc_html__( 'Button', 'et_builder' ),
						),
					),
				);
				$this->custom_css_options = array(
					'slide_description' => array(
						'label'    => esc_html__( 'Slide Description', 'et_builder' ),
						'selector' => '.et_pb_slide_description',
					),
					'slide_title' => array(
						'label'    => esc_html__( 'Slide Title', 'et_builder' ),
						'selector' => '.et_pb_slide_description .et_pb_slide_title',
					),
					'slide_button' => array(
						'label'    => esc_html__( 'Slide Button', 'et_builder' ),
						'selector' => '.et_pb_slider a.et_pb_more_button.et_pb_button',
						'no_space_before_selector' => true,
					),
					'slide_controllers' => array(
						'label'    => esc_html__( 'Slide Controllers', 'et_builder' ),
						'selector' => '.et-pb-controllers',
					),
					'slide_active_controller' => array(
						'label'    => esc_html__( 'Slide Active Controller', 'et_builder' ),
						'selector' => '.et-pb-controllers .et-pb-active-control',
					),
					'slide_image' => array(
						'label'    => esc_html__( 'Slide Image', 'et_builder' ),
						'selector' => '.et_pb_slide_image',
					),
					'slide_arrows' => array(
						'label'    => esc_html__( 'Slide Arrows', 'et_builder' ),
						'selector' => '.et-pb-slider-arrows a',
					),
				);
			}

			function get_fields() {
				$fields = array(
					'posts_number' => array(
						'label'             => esc_html__( 'Posts Number', 'et_builder' ),
						'type'              => 'text',
						'option_category'   => 'configuration',
						'description'       => esc_html__( 'Choose how many posts you would like to display in the slider.', 'et_builder' ),
					),
					'orderby' => array(
						'label'             => esc_html__( 'Order By', 'et_builder' ),
						'type'              => 'select',
						'option_category'   => 'configuration',
						'options'           => array(
							'date_desc'  => esc_html__( 'Date: new to old', 'et_builder' ),
							'date_asc'   => esc_html__( 'Date: old to new', 'et_builder' ),
							'title_asc'  => esc_html__( 'Title: a-z', 'et_builder' ),
							'title_desc' => esc_html__( 'Title: z-a', 'et_builder' ),
							'rand'       => esc_html__( 'Random', 'et_builder' ),
						),
						'description'       => esc_html__( 'Here you can adjust the order in which posts are displayed.', 'et_builder' ),
					),
					'show_arrows'         => array(
						'label'           => esc_html__( 'Show Arrows', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'configuration',
						'options'         => array(
							'on'  => esc_html__( 'yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'description'     => esc_html__( 'This setting will turn on and off the navigation arrows.', 'et_builder' ),
					),
					'show_pagination' => array(
						'label'             => esc_html__( 'Show Controls', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => esc_html__( 'Yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'description'       => esc_html__( 'This setting will turn on and off the circle buttons at the bottom of the slider.', 'et_builder' ),
					),
					'show_more_button' => array(
						'label'             => esc_html__( 'Show Read More Button', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => esc_html__( 'yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'affects' => array(
							'#et_pb_more_text',
						),
						'description'       => esc_html__( 'This setting will turn on and off the read more button.', 'et_builder' ),
					),
					'more_text' => array(
						'label'             => esc_html__( 'Button Text', 'et_builder' ),
						'type'              => 'text',
						'option_category'   => 'configuration',
						'depends_show_if'   => 'on',
						'description'       => esc_html__( 'Define the text which will be displayed on "Read More" button. Leave blank for default ( Read More )', 'et_builder' ),
					),
					'content_source' => array(
						'label'             => esc_html__( 'Content Display', 'et_builder' ),
						'type'              => 'select',
						'option_category'   => 'configuration',
						'options'           => array(
							'off' => esc_html__( 'Show Excerpt', 'et_builder' ),
							'on'  => esc_html__( 'Show Content', 'et_builder' ),
						),
						'affects' => array(
							'#et_pb_use_manual_excerpt',
							'#et_pb_excerpt_length',
						),
						'description'       => esc_html__( 'Showing the full content will not truncate your posts in the slider. Showing the excerpt will only display excerpt text.', 'et_builder' ),
					),
					'use_manual_excerpt' => array(
						'label'             => esc_html__( 'Use Post Excerpt if Defined', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => esc_html__( 'Yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'depends_show_if'   => 'off',
						'description'       => esc_html__( 'Disable this option if you want to ignore manually defined excerpts and always generate it automatically.', 'et_builder' ),
					),
					'excerpt_length' => array(
						'label'             => esc_html__( 'Automatic Excerpt Length', 'et_builder' ),
						'type'              => 'text',
						'option_category'   => 'configuration',
						'depends_show_if'   => 'off',
						'description'       => esc_html__( 'Define the length of automatically generated excerpts. Leave blank for default ( 270 ) ', 'et_builder' ),
					),
					'show_meta' => array(
						'label'           => esc_html__( 'Show Post Meta', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'configuration',
						'options'         => array(
							'on'  => esc_html__( 'yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'description'     => esc_html__( 'This setting will turn on and off the meta section.', 'et_builder' ),
					),
					'background_color' => array(
						'label'        => esc_html__( 'Background Color', 'et_builder' ),
						'type'         => 'color-alpha',
						'custom_color' => true,
						'description'  => esc_html__( 'Use the color picker to choose a background color for this module.', 'et_builder' ),
					),
					'background_image' => array(
						'label'              => esc_html__( 'Background Image', 'et_builder' ),
						'type'               => 'upload',
						'option_category'    => 'basic_option',
						'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
						'choose_text'        => esc_attr__( 'Choose a Background', 'et_builder' ),
						'update_text'        => esc_attr__( 'Set As Background', 'et_builder' ),
						'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to use as the background for the slider.', 'et_builder' ),
					),
					'background_layout' => array(
						'label'           => esc_html__( 'Text Color', 'et_builder' ),
						'type'            => 'select',
						'option_category' => 'color_option',
						'options'         => array(
							'dark'  => esc_html__( 'Light', 'et_builder' ),
							'light' => esc_html__( 'Dark', 'et_builder' ),
						),
						'description'     => esc_html__( 'Here you can choose whether your text is light or dark. If you have a slide with a dark background, then choose light text. If you have a light background, then use dark text.' , 'et_builder' ),
					),
					'show_image' => array(
						'label'             => esc_html__( 'Show Featured Image', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => esc_html__( 'yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'affects' => array(
							'#et_pb_image_placement',
						),
						'description'       => esc_html__( 'This setting will turn on and off the featured image in the slider.', 'et_builder' ),
					),
					'image_placement' => array(
						'label'             => esc_html__( 'Image Placement', 'et_builder' ),
						'type'              => 'select',
						'option_category'   => 'configuration',
						'options'           => array(
							'background' => esc_html__( 'Background', 'et_builder' ),
							'left'       => esc_html__( 'Left', 'et_builder' ),
							'right'      => esc_html__( 'Right', 'et_builder' ),
							'top'        => esc_html__( 'Top', 'et_builder' ),
							'bottom'     => esc_html__( 'Bottom', 'et_builder' ),
						),
						'depends_show_if'   => 'on',
						'affects' => array(
							'#et_pb_parallax',
						),
						'description'       => esc_html__( 'Select how you would like to display the featured image in slides', 'et_builder' ),
					),
					'parallax' => array(
						'label'           => esc_html__( 'Use Parallax effect', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'configuration',
						'options'         => array(
							'off' => esc_html__( 'No', 'et_builder' ),
							'on'  => esc_html__( 'Yes', 'et_builder' ),
						),
						'affects'           => array(
							'#et_pb_parallax_method',
							'#et_pb_background_position',
							'#et_pb_background_size',
						),
						'depends_show_if'    => 'background',
						'description'        => esc_html__( 'Enabling this option will give your background images a fixed position as you scroll.', 'et_builder' ),
					),
					'parallax_method' => array(
						'label'           => esc_html__( 'Parallax method', 'et_builder' ),
						'type'            => 'select',
						'option_category' => 'configuration',
						'options'         => array(
							'off' => esc_html__( 'CSS', 'et_builder' ),
							'on'  => esc_html__( 'True Parallax', 'et_builder' ),
						),
						'depends_show_if'   => 'on',
						'description'       => esc_html__( 'Define the method, used for the parallax effect.', 'et_builder' ),
					),
					'use_bg_overlay'      => array(
						'label'           => esc_html__( 'Use Background Overlay', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'configuration',
						'options'         => array(
							'on'  => esc_html__( 'yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'affects'           => array(
							'#et_pb_bg_overlay_color',
						),
						'description'     => esc_html__( 'When enabled, a custom overlay color will be added above your background image and behind your slider content.', 'et_builder' ),
					),
					'bg_overlay_color' => array(
						'label'             => esc_html__( 'Background Overlay Color', 'et_builder' ),
						'type'              => 'color-alpha',
						'custom_color'      => true,
						'depends_show_if'   => 'on',
						'description'       => esc_html__( 'Use the color picker to choose a color for the background overlay.', 'et_builder' ),
					),
					'use_text_overlay'      => array(
						'label'           => esc_html__( 'Use Text Overlay', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'configuration',
						'options'         => array(
							'off' => esc_html__( 'No', 'et_builder' ),
							'on'  => esc_html__( 'yes', 'et_builder' ),
						),
						'affects'           => array(
							'#et_pb_text_overlay_color',
						),
						'description'     => esc_html__( 'When enabled, a background color is added behind the slider text to make it more readable atop background images.', 'et_builder' ),
					),
					'text_overlay_color' => array(
						'label'             => esc_html__( 'Text Overlay Color', 'et_builder' ),
						'type'              => 'color-alpha',
						'custom_color'      => true,
						'depends_show_if'   => 'on',
						'description'       => esc_html__( 'Use the color picker to choose a color for the text overlay.', 'et_builder' ),
					),
					'remove_inner_shadow' => array(
						'label'           => esc_html__( 'Remove Inner Shadow', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'configuration',
						'options'         => array(
							'off' => esc_html__( 'No', 'et_builder' ),
							'on'  => esc_html__( 'Yes', 'et_builder' ),
						),
					),
					'background_position' => array(
						'label'           => esc_html__( 'Background Image Position', 'et_builder' ),
						'type'            => 'select',
						'option_category' => 'layout',
						'options' => array(
							'default'       => esc_html__( 'Default', 'et_builder' ),
							'top_left'      => esc_html__( 'Top Left', 'et_builder' ),
							'top_center'    => esc_html__( 'Top Center', 'et_builder' ),
							'top_right'     => esc_html__( 'Top Right', 'et_builder' ),
							'center_right'  => esc_html__( 'Center Right', 'et_builder' ),
							'center_left'   => esc_html__( 'Center Left', 'et_builder' ),
							'bottom_left'   => esc_html__( 'Bottom Left', 'et_builder' ),
							'bottom_center' => esc_html__( 'Bottom Center', 'et_builder' ),
							'bottom_right'  => esc_html__( 'Bottom Right', 'et_builder' ),
						),
						'depends_show_if'   => 'off',
					),
					'background_size' => array(
						'label'           => esc_html__( 'Background Image Size', 'et_builder' ),
						'type'            => 'select',
						'option_category' => 'layout',
						'options'         => array(
							'default' => esc_html__( 'Default', 'et_builder' ),
							'contain' => esc_html__( 'Fit', 'et_builder' ),
							'initial' => esc_html__( 'Actual Size', 'et_builder' ),
						),
						'depends_show_if'   => 'off',
					),
					'auto' => array(
						'label'           => esc_html__( 'Automatic Animation', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'configuration',
						'options'         => array(
							'off' => esc_html__( 'Off', 'et_builder' ),
							'on'  => esc_html__( 'On', 'et_builder' ),
						),
						'affects' => array(
							'#et_pb_auto_speed, #et_pb_auto_ignore_hover',
						),
						'description'        => esc_html__( 'If you would like the slider to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'et_builder' ),
					),
					'auto_speed' => array(
						'label'             => esc_html__( 'Automatic Animation Speed (in ms)', 'et_builder' ),
						'type'              => 'text',
						'option_category'   => 'configuration',
						'depends_default'   => true,
						'description'       => esc_html__( "Here you can designate how fast the slider fades between each slide, if 'Automatic Animation' option is enabled above. The higher the number the longer the pause between each rotation.", 'et_builder' ),
					),
					'auto_ignore_hover' => array(
						'label'           => esc_html__( 'Continue Automatic Slide on Hover', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'configuration',
						'depends_default' => true,
						'options'         => array(
							'off' => esc_html__( 'Off', 'et_builder' ),
							'on'  => esc_html__( 'On', 'et_builder' ),
						),
						'description' => esc_html__( 'Turning this on will allow automatic sliding to continue on mouse hover.', 'et_builder' ),
					),
					'top_padding' => array(
						'label'           => esc_html__( 'Top Padding', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'layout',
						'tab_slug'        => 'advanced',
						'mobile_options'  => true,
						'validate_unit'   => true,
					),
					'bottom_padding' => array(
						'label'           => esc_html__( 'Bottom Padding', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'layout',
						'tab_slug'        => 'advanced',
						'mobile_options'  => true,
						'validate_unit'   => true,
					),
					'hide_content_on_mobile' => array(
						'label'           => esc_html__( 'Hide Content On Mobile', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'layout',
						'options'         => array(
							'off' => esc_html__( 'No', 'et_builder' ),
							'on'  => esc_html__( 'Yes', 'et_builder' ),
						),
						'tab_slug'          => 'advanced',
					),
					'hide_cta_on_mobile' => array(
						'label'           => esc_html__( 'Hide CTA On Mobile', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'layout',
						'options'         => array(
							'off' => esc_html__( 'No', 'et_builder' ),
							'on'  => esc_html__( 'Yes', 'et_builder' ),
						),
						'tab_slug'          => 'advanced',
					),
					'show_image_video_mobile' => array(
						'label'           => esc_html__( 'Show Image On Mobile', 'et_builder' ),
						'type'            => 'yes_no_button',
						'option_category' => 'layout',
						'options'         => array(
							'off' => esc_html__( 'No', 'et_builder' ),
							'on'  => esc_html__( 'Yes', 'et_builder' ),
						),
						'tab_slug'        => 'advanced',
					),
					'text_border_radius' => array(
						'label'           => esc_html__( 'Text Overlay Border Radius', 'et_builder' ),
						'type'            => 'range',
						'option_category' => 'layout',
						'default'         => '3',
						'range_settings'  => array(
							'min'  => '0',
							'max'  => '100',
							'step' => '1',
						),
						'tab_slug'        => 'advanced',
					),
					'arrows_custom_color' => array(
						'label'        => esc_html__( 'Arrows Custom Color', 'et_builder' ),
						'type'         => 'color',
						'custom_color' => true,
						'tab_slug'     => 'advanced',
					),
					'dot_nav_custom_color' => array(
						'label'        => esc_html__( 'Dot Nav Custom Color', 'et_builder' ),
						'type'         => 'color',
						'custom_color' => true,
						'tab_slug'     => 'advanced',
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
					'top_padding_tablet' => array(
						'type' => 'skip',
					),
					'top_padding_phone' => array(
						'type' => 'skip',
					),
					'bottom_padding_tablet' => array(
						'type' => 'skip',
					),
					'bottom_padding_phone' => array(
						'type' => 'skip',
					),
				);
				return $fields;
			}

			function shortcode_callback( $atts, $content = null, $function_name ) {
				$module_id               = $this->shortcode_atts['module_id'];
				$module_class            = $this->shortcode_atts['module_class'];
				$show_arrows             = $this->shortcode_atts['show_arrows'];
				$show_pagination         = $this->shortcode_atts['show_pagination'];
				$parallax                = $this->shortcode_atts['parallax'];
				$parallax_method         = $this->shortcode_atts['parallax_method'];
				$auto                    = $this->shortcode_atts['auto'];
				$auto_speed              = $this->shortcode_atts['auto_speed'];
				$auto_ignore_hover       = $this->shortcode_atts['auto_ignore_hover'];
				$top_padding             = $this->shortcode_atts['top_padding'];
				$body_font_size 		 = $this->shortcode_atts['body_font_size'];
				$bottom_padding          = $this->shortcode_atts['bottom_padding'];
				$remove_inner_shadow     = $this->shortcode_atts['remove_inner_shadow'];
				$hide_content_on_mobile  = $this->shortcode_atts['hide_content_on_mobile'];
				$hide_cta_on_mobile      = $this->shortcode_atts['hide_cta_on_mobile'];
				$show_image_video_mobile = $this->shortcode_atts['show_image_video_mobile'];
				$background_position     = $this->shortcode_atts['background_position'];
				$background_size         = $this->shortcode_atts['background_size'];
				$posts_number            = $this->shortcode_atts['posts_number'];
				$show_more_button        = $this->shortcode_atts['show_more_button'];
				$more_text               = $this->shortcode_atts['more_text'];
				$content_source          = $this->shortcode_atts['content_source'];
				$background_color        = $this->shortcode_atts['background_color'];
				$show_image              = $this->shortcode_atts['show_image'];
				$image_placement         = $this->shortcode_atts['image_placement'];
				$background_image        = $this->shortcode_atts['background_image'];
				$background_layout       = $this->shortcode_atts['background_layout'];
				$use_bg_overlay          = $this->shortcode_atts['use_bg_overlay'];
				$bg_overlay_color        = $this->shortcode_atts['bg_overlay_color'];
				$use_text_overlay        = $this->shortcode_atts['use_text_overlay'];
				$text_overlay_color      = $this->shortcode_atts['text_overlay_color'];
				$orderby                 = $this->shortcode_atts['orderby'];
				$show_meta               = $this->shortcode_atts['show_meta'];
				$button_custom           = $this->shortcode_atts['custom_button'];
				$custom_icon             = $this->shortcode_atts['button_icon'];
				$use_manual_excerpt      = $this->shortcode_atts['use_manual_excerpt'];
				$excerpt_length          = $this->shortcode_atts['excerpt_length'];
				$text_border_radius      = $this->shortcode_atts['text_border_radius'];
				$dot_nav_custom_color    = $this->shortcode_atts['dot_nav_custom_color'];
				$arrows_custom_color     = $this->shortcode_atts['arrows_custom_color'];
				$top_padding_tablet      = $this->shortcode_atts['top_padding_tablet'];
				$top_padding_phone       = $this->shortcode_atts['top_padding_phone'];
				$bottom_padding_tablet   = $this->shortcode_atts['bottom_padding_tablet'];
				$bottom_padding_phone    = $this->shortcode_atts['bottom_padding_phone'];

				$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

				$hide_on_mobile_class = self::HIDE_ON_MOBILE;

				if ( '' !== $top_padding || '' !== $top_padding_tablet || '' !== $top_padding_phone ) {
					$padding_values = array(
						'desktop' => $top_padding,
						'tablet'  => $top_padding_tablet,
						'phone'   => $top_padding_phone,
					);

					et_pb_generate_responsive_css( $padding_values, '%%order_class%% .et_pb_slide_description', 'padding-top', $function_name );
				}

				if ( '' !== $bottom_padding || '' !== $bottom_padding_tablet || '' !== $bottom_padding_phone ) {
					$padding_values = array(
						'desktop' => $bottom_padding,
						'tablet'  => $bottom_padding_tablet,
						'phone'   => $bottom_padding_phone,
					);

					et_pb_generate_responsive_css( $padding_values, '%%order_class%% .et_pb_slide_description', 'padding-bottom', $function_name );
				}

				if ( '' !== $bottom_padding || '' !== $top_padding ) {
					ET_Builder_Module::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_pb_slide_description',
						'declaration' => 'padding-right: 0; padding-left: 0;',
					) );
				}

				if ( 'default' !== $background_position && 'off' === $parallax ) {
					$processed_position = str_replace( '_', ' ', $background_position );

					ET_Builder_Module::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_pb_slide',
						'declaration' => sprintf(
							'background-position: %1$s;',
							esc_html( $processed_position )
						),
					) );
				}

				if ( 'default' !== $background_size && 'off' === $parallax ) {
					ET_Builder_Module::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_pb_slide',
						'declaration' => sprintf(
							'-moz-background-size: %1$s;
							-webkit-background-size: %1$s;
							background-size: %1$s;',
							esc_html( $background_size )
						),
					) );


					if ( 'initial' === $background_size ) {
						ET_Builder_Module::set_style( $function_name, array(
							'selector'    => 'body.ie %%order_class%% .et_pb_slide',
							'declaration' => sprintf(
								'-moz-background-size: %1$s;
								-webkit-background-size: %1$s;
								background-size: %1$s;',
								'auto'
							),
						) );
					}
				}

				if ( '' !== $background_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%%.et_pb_post_slider',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $background_color )
						),
					) );
				}

				if ( '' !== $background_image ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%%, %%order_class%%.et_pb_bg_layout_dark, %%order_class%%.et_pb_bg_layout_light',
						'declaration' => sprintf(
							'background-image: url(%1$s);',
							esc_url( $background_image )
						),
					) );
				}

				if ( 'on' === $use_bg_overlay && '' !== $bg_overlay_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_pb_slide .mc_slider_overlay .et_pb_slide_overlay_container',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $bg_overlay_color )
						),
					) );
				}

				if ( 'on' === $use_text_overlay && '' !== $text_overlay_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_pb_slide .et_pb_slide_title, %%order_class%% .et_pb_slide .et_pb_slide_content',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $text_overlay_color )
						),
					) );
				}

				if ( '' !== $text_border_radius ) {
					$border_radius_value = et_builder_process_range_value( $text_border_radius );
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%%.et_pb_slider_with_text_overlay h2.et_pb_slide_title',
						'declaration' => sprintf(
							'-webkit-border-top-left-radius: %1$s;
							-webkit-border-top-right-radius: %1$s;
							-moz-border-radius-topleft: %1$s;
							-moz-border-radius-topright: %1$s;
							border-top-left-radius: %1$s;
							border-top-right-radius: %1$s;',
							esc_html( $border_radius_value )
						),
					) );
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%%.et_pb_slider_with_text_overlay .et_pb_slide_content',
						'declaration' => sprintf(
							'-webkit-border-bottom-right-radius: %1$s;
							-webkit-border-bottom-left-radius: %1$s;
							-moz-border-radius-bottomright: %1$s;
							-moz-border-radius-bottomleft: %1$s;
							border-bottom-right-radius: %1$s;
							border-bottom-left-radius: %1$s;',
							esc_html( $border_radius_value )
						),
					) );
				}

				$fullwidth = 'et_pb_mc_fullwidth_post_slider' === $function_name ? 'on' : 'off';

				$class  = '';
				$class .= 'off' === $fullwidth ? ' et_pb_slider_fullwidth_off' : '';
				$class .= 'off' === $show_arrows ? ' et_pb_slider_no_arrows' : '';
				$class .= 'off' === $show_pagination ? ' et_pb_slider_no_pagination' : '';
				$class .= 'on' === $parallax ? ' et_pb_slider_parallax' : '';
				$class .= 'on' === $auto ? ' et_slider_auto et_slider_speed_' . esc_attr( $auto_speed ) : '';
				$class .= 'on' === $auto_ignore_hover ? ' et_slider_auto_ignore_hover' : '';
				$class .= 'on' === $remove_inner_shadow ? ' et_pb_slider_no_shadow' : '';
				$class .= 'on' === $show_image_video_mobile ? ' et_pb_slider_show_image' : '';
				$class .= ' et_pb_post_slider_image_' . $image_placement;
				$class .= 'on' === $use_bg_overlay ? ' et_pb_slider_with_overlay' : '';
				$class .= 'on' === $use_text_overlay ? ' et_pb_slider_with_text_overlay' : '';

				$data_dot_nav_custom_color = '' !== $dot_nav_custom_color
					? sprintf( ' data-dots_color="%1$s"', esc_attr( $dot_nav_custom_color ) )
					: '';

				$data_arrows_custom_color = '' !== $arrows_custom_color
					? sprintf( ' data-arrows_color="%1$s"', esc_attr( $arrows_custom_color ) )
					: '';

				$sticky = get_option('sticky_posts');

				$args = array(
					'posts_per_page' => (int) $posts_number,
					'post__in' => $sticky
				);


				if ( 'date_desc' !== $orderby ) {
					switch( $orderby ) {
						case 'date_asc' :
							$args['orderby'] = 'date';
							$args['order'] = 'ASC';
							break;
						case 'title_asc' :
							$args['orderby'] = 'title';
							$args['order'] = 'ASC';
							break;
						case 'title_desc' :
							$args['orderby'] = 'title';
							$args['order'] = 'DESC';
							break;
						case 'rand' :
							$args['orderby'] = 'rand';
							break;
					}
				}

				ob_start();

				query_posts( $args );

				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();

						$slide_class = 'off' !== $show_image && in_array( $image_placement, array( 'left', 'right' ) ) && has_post_thumbnail() ? ' et_pb_slide_with_image' : '';
						$slide_class .= " et_pb_bg_layout_{$background_layout}";
					?>
					<div class="mc_slide_post et_pb_slide et_pb_media_alignment_center<?php echo esc_attr( $slide_class ); ?>" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>'" <?php echo $data_dot_nav_custom_color; echo $data_arrows_custom_color; ?>>
						
						<?php if ( 'on' === $parallax && 'off' !== $show_image && 'background' === $image_placement ) { ?>
							<div class="et_parallax_bg"></div>
						<?php } ?>
						<a href="<?php echo get_permalink(); ?>" class="mc_slide_post_overlay_link"></a>
						<?php if ( 'on' === $use_bg_overlay ) { ?>
							<div class="mc_slider_overlay  et_pb_slide_overlay_container"></div>
						<?php } ?>
							<div class="et_pb_container clearfix">
								<?php if ( 'off' !== $show_image && has_post_thumbnail() && ! in_array( $image_placement, array( 'background', 'bottom' ) ) ) { ?>
									<div class="et_pb_slide_image">
										<?php the_post_thumbnail(); ?>
									</div>
								<?php } ?>
								<div class="et_pb_slide_description">
									<div class="meta">
									<?php
									if ( 'off' !== $show_meta ) {
											echo get_the_category_list(', ');
									}
									?>
									</div>
									<h2 class="et_pb_slide_title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h2>
									<?php if ( 'off' !== $show_more_button && '' !== $more_text ) {
											printf(
												'<a href="%1$s" class="et_pb_more_button et_pb_button%4$s%5$s"%3$s>%2$s</a>',
												esc_url( get_permalink() ),
												esc_html( $more_text ),
												'' !== $custom_icon && 'on' === $button_custom ? sprintf(
													' data-icon="%1$s"',
													esc_attr( et_pb_process_font_icon( $custom_icon ) )
												) : '',
												'' !== $custom_icon && 'on' === $button_custom ? ' et_pb_custom_button_icon' : '',
												'on' === $hide_cta_on_mobile ? esc_attr( " {$hide_on_mobile_class}" ) : ''
											);
										}
									?>
								</a> <!-- mc_slide_post_overlay_link -->
								</div> <!-- .et_pb_slide_description -->
								<?php if ( 'off' !== $show_image && has_post_thumbnail() && 'bottom' === $image_placement ) { ?>
									<div class="et_pb_slide_image">
										<?php the_post_thumbnail(); ?>
									</div>
								<?php } ?>
							</div> <!-- .et_pb_container -->
					</div> <!-- .et_pb_slide -->
				<?php
					} // end while
					wp_reset_query();
				} // end if

				$content = ob_get_contents();

				ob_end_clean();
				$output = '
				<style type="text/css">
				/* custom module slide post */
				.mc_slide_post div.et_pb_container {
				    width: 100%;
				}
				.mc_slide_post.et_pb_slide {
				    padding: 1% 6%;
				}
				@media(min-width: 2400px) {
				    .mc_slide_post.et_pb_slide {
				        padding-top: 5%;
				        padding-bottom: 1%;
				    }
				}
				.mc_slide_post a.mc_slide_post_overlay_link {
				    position: absolute;
				    width: 100%;
				    height: 80%;
				    z-index: 999;
				    left: 0;
				    top: 0;
				}
				.mc_slider_overlay.et_pb_slide_overlay_container {
				    width: 45% !important;
				    right: 0;
				    left: inherit;
				}
				.mc_slide_post .et_pb_slider .et_pb_container {
				    width: 100%;
				    max-width: 1200px;
				}
				.mc_slide_post .et_pb_slide_description {
				    padding: 10% 0 10% 61%;
				    text-align: left;
				}
				.mc_slide_post .et_pb_slide_description .meta {
				   padding-bottom: 15px;
				}
				.mc_slide_post .et_pb_slide_description .meta a {
				   color: #ffffff;
				}
				.mc_slide_post .et_pb_slide_description .et_pb_slide_title {
				    min-height: 115px;
				    border-top: 1px solid white;
				    padding-top: 15px;
				   font-size: 35px !important;
				}
				@media(max-width: 980px) {
				    .mc_slider_overlay.et_pb_slide_overlay_container {
				        width: 100% !important;
				    }
				    .mc_slide_post .et_pb_slide_description {
				        padding: 10% 0 25% 10%;
				    }
				    .mc_slide_post .et_pb_slide_description .et_pb_slide_title {
				        font-size: 20px !important;
				    }
				}</style>';
				$output .= sprintf(
					'<div%3$s class="et_pb_module et_pb_slider et_pb_post_slider%1$s%4$s">
						<div class="et_pb_slides">
							%2$s
						</div> <!-- .et_pb_slides -->
					</div> <!-- .et_pb_slider -->
					',
					$class,
					$content,
					( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
					( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
				);

				return $output;
			}
		}
		new ET_Builder_Custom_Post_Slider;
	}
}
add_action('et_builder_ready', 'CustomPostSlider');
