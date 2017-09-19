<?php
/**
 * @package MC_Divi_Custom_Divi_Title
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH') ) {
    exit;
}

function MC_Title_Module() {
    if(class_exists("ET_Builder_Module")){

        class ET_Builder_Module_Title extends ET_Builder_Module {
            function init() {
                $this->name       = esc_html__( 'Title', 'et_builder' );
                $this->slug       = 'et_pb_mc_title';
                $this->fb_support = true;

                $this->whitelisted_fields = array(
                    'title_level',
                    'background_layout',
                    'text_orientation',
                    'content_title',
                    'admin_label',
                    'module_id',
                    'module_class',
                );

                $this->fields_defaults = array(
                    'background_layout' => array( 'light' ),
                    'text_orientation'  => array( 'left' ),
                );

                $this->options_toggles = array(
                    'general'  => array(
                        'toggles' => array(
                            'main_content' => esc_html__( 'Text', 'et_builder' ),
                        ),
                    ),
                    'advanced' => array(
                        'toggles' => array(
                            'text' => array(
                                'title'    => esc_html__( 'Text', 'et_builder' ),
                                'priority' => 49,
                            ),
                        ),
                    ),
                );

                $this->main_css_element = '%%order_class%%';
                $this->advanced_options = array(
                    'fonts' => array(
                        'text'   => array(
                            'label'    => esc_html__( 'Text', 'et_builder' ),
                            'css'      => array(
                                'main' => "{$this->main_css_element} .title",
                                'line_height' => "{$this->main_css_element} .title",
                                'color' => "{$this->main_css_element} .title",
                                'font_size' => "{$this->main_css_element} .title",
                            ),
                            'line_height' => array(
                                'default' => '1em',
                            ),
                            'font_size' => array(
                                'default' => '18px',
                                'range_settings' => array(
                                    'min'  => '12',
                                    'max'  => '44',
                                    'step' => '1',
                                ),
                            ),
                            'letter_spacing' => array(
                                'default' => '0px',
                                'range_settings' => array(
                                    'min'  => '0',
                                    'max'  => '8',
                                    'step' => '1',
                                ),
                            ),
                            'toggle_slug' => 'text',
                        )
                    ),
                    'background' => array(
                        'settings' => array(
                            'color' => 'alpha',
                        ),
                    ),
                    'custom_margin_padding' => array(
                        'css' => array(
                            'important' => 'all',
                        ),
                    ),
                );
            }

            function get_fields() {
                $fields = array(
                    'title_level' => array(
                        'label'             => esc_html__( 'Niveau', 'et_builder' ),
                        'type'              => 'select',
                        'option_category'   => 'configuration',
                        'options'           => array(
                            'h1' => esc_html__( 'H1', 'et_builder' ),
                            'h2'  => esc_html__( 'H2', 'et_builder' ),
                            'h3'  => esc_html__( 'H3', 'et_builder' ),
                            'h4'  => esc_html__( 'H4', 'et_builder' ),
                            'h5'  => esc_html__( 'H5', 'et_builder' ),
                        ),
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'text',
                        'description'       => esc_html__( 'Choisissez le niveau du titre', 'et_builder' ),
                    ),
                    'background_layout' => array(
                        'label'             => esc_html__( 'Text Color', 'et_builder' ),
                        'type'              => 'select',
                        'option_category'   => 'configuration',
                        'options'           => array(
                            'light' => esc_html__( 'Dark', 'et_builder' ),
                            'dark'  => esc_html__( 'Light', 'et_builder' ),
                        ),
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'text',
                        'description'       => esc_html__( 'Here you can choose the value of your text. If you are working with a dark background, then your text should be set to light. If you are working with a light background, then your text should be dark.', 'et_builder' ),
                    ),
                    'text_orientation' => array(
                        'label'             => esc_html__( 'Text Orientation', 'et_builder' ),
                        'type'              => 'select',
                        'option_category'   => 'layout',
                        'options'           => et_builder_get_text_orientation_options(),
                        'tab_slug'          => 'advanced',
                        'toggle_slug'       => 'text',
                        'description'       => esc_html__( 'This controls the how your text is aligned within the module.', 'et_builder' ),
                    ),
                    'content_title' => array(
                        'label'           => esc_html__( 'Content', 'et_builder' ),
                        'type'            => 'text',
                        'option_category' => 'basic_option',
                        'description'     => esc_html__( 'Here you can create the content that will be used within the module.', 'et_builder' ),
                        'toggle_slug'     => 'main_content',
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
                        'tab_slug'        => 'custom_css',
                        'toggle_slug'     => 'visibility',
                    ),
                    'admin_label' => array(
                        'label'       => esc_html__( 'Admin Label', 'et_builder' ),
                        'type'        => 'text',
                        'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
                        'toggle_slug' => 'admin_label',
                    ),
                    'module_id' => array(
                        'label'           => esc_html__( 'CSS ID', 'et_builder' ),
                        'type'            => 'text',
                        'option_category' => 'configuration',
                        'tab_slug'        => 'custom_css',
                        'toggle_slug'     => 'classes',
                        'option_class'    => 'et_pb_custom_css_regular',
                    ),
                    'module_class' => array(
                        'label'           => esc_html__( 'CSS Class', 'et_builder' ),
                        'type'            => 'text',
                        'option_category' => 'configuration',
                        'tab_slug'        => 'custom_css',
                        'toggle_slug'     => 'classes',
                        'option_class'    => 'et_pb_custom_css_regular',
                    ),
                );

                return $fields;
            }

            function shortcode_callback( $atts, $content = null, $function_name ) {
                $title = $this->shortcode_atts['content_title'];
                $title_level            = $this->shortcode_atts['title_level'];
                $module_id            = $this->shortcode_atts['module_id'];
                $module_class         = $this->shortcode_atts['module_class'];
                $background_layout    = $this->shortcode_atts['background_layout'];
                $text_orientation     = $this->shortcode_atts['text_orientation'];

                $title_font_size = $this->shortcode_atts['text_font_size'];

                $module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

                if ( '' !== $title_font_size ) {
                    ET_Builder_Element::set_style( $function_name, array(
                        'selector'    => '%%order_class%% %2$s;',
                        'declaration' => sprintf(
                            'font-size: %1$s;',
                            esc_html( $title_font_size ),
                            esc_html($title_level)
                        ),
                    ) );
                }

                $this->shortcode_content = et_builder_replace_code_content_entities( $this->shortcode_content );

                if ( is_rtl() && 'left' === $text_orientation ) {
                    $text_orientation = 'right';
                }

                $class = " et_pb_module et_pb_bg_layout_{$background_layout} et_pb_text_align_{$text_orientation}";

                $output = sprintf(
                    '<div%3$s class="et_pb_mc_title%2$s%4$s">
                        <div class="et_pb_mc_title_inner">
                            <%5$s class="title">%1$s</%5$s>
                        </div>
                    </div> <!-- .et_pb_mc_title -->',
                    $title,
                    esc_attr( $class ),
                    ( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
                    ( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
                    $title_level
                );

                return $output;
            }
        }
        new ET_Builder_Module_Title;
    }
}

add_action('et_builder_ready', 'MC_Title_Module');