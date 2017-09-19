<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
function MC_Custom_Blog(){

	if(class_exists("ET_Builder_Module")){

		class ET_Builder_Module_Custom_Blog extends ET_Builder_Module {
			function init() {

				add_action('wp_enqueue_scripts', array( $this, 'enqueue_custom_css' ));

				$this->name       = esc_html__( 'Blog PS', 'et_builder' );
				$this->slug       = 'et_pb_custom_blog';
				$this->fb_support = true;

				$this->whitelisted_fields = array(
					'posts_number',
					'include_categories',
					'meta_date',
					'admin_label',
					'module_id',
					'module_class',
				);

				$this->fields_defaults = array(
					'posts_number'      => array( 9, 'add_default_setting' ),
					'meta_date'         => array( 'j M, Y', 'add_default_setting' ),
				);

				$this->main_css_element = '%%order_class%% .et_pb_post';

				$this->options_toggles = array(
					'general'  => array(
						'toggles' => array(
							'main_content' => esc_html__( 'Content', 'et_builder' ),
							'elements'     => esc_html__( 'Elements', 'et_builder' ),
							'background'   => esc_html__( 'Background', 'et_builder' ),
						),
					),
					'advanced' => array(
						'toggles' => array(
							'layout'  => esc_html__( 'Layout', 'et_builder' ),
							'overlay' => esc_html__( 'Overlay', 'et_builder' ),
							'text'    => array(
								'title'    => esc_html__( 'Text', 'et_builder' ),
								'priority' => 49,
							),
						),
					),
				);
			}
			function enqueue_custom_css() {
				wp_enqueue_style( 'custom-blog-css', plugin_dir_url( __FILE__ ) . 'custom-blog-css.css'  );
			}
			function get_fields() {
				$fields = array(
					'posts_number' => array(
						'label'             => esc_html__( 'Posts Number', 'et_builder' ),
						'type'              => 'text',
						'option_category'   => 'configuration',
						'description'       => esc_html__( 'Choose how much posts you would like to display per page.', 'et_builder' ),
						'computed_affects'   => array(
							'__posts',
						),
						'toggle_slug'       => 'main_content',
					),
					'include_categories' => array(
						'label'            => esc_html__( 'Include Categories', 'et_builder' ),
						'renderer'         => 'et_builder_include_categories_option',
						'option_category'  => 'basic_option',
						'renderer_options' => array(
							'use_terms' => false,
						),
						'description'      => esc_html__( 'Choose which categories you would like to include in the feed.', 'et_builder' ),
						'toggle_slug'      => 'main_content',
						'computed_affects' => array(
							'__posts',
						),
					),
					'meta_date' => array(
						'label'             => esc_html__( 'Meta Date Format', 'et_builder' ),
						'type'              => 'text',
						'option_category'   => 'configuration',
						'description'       => esc_html__( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'et_builder' ),
						'toggle_slug'       => 'main_content',
						'computed_affects'  => array(
							'__posts',
						),
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
					'__posts' => array(
						'type' => 'computed',
						'computed_callback' => array( 'ET_Builder_Module_Custom_Blog', 'get_blog_posts' ),
						'computed_depends_on' => array(
							'posts_number',
							'include_categories',
							'meta_date',
						),
					),
				);
				return $fields;
			}

			/**
			 * Get blog posts for blog module
			 *
			 * @param array   arguments that is being used by et_pb_custom_blog
			 * @return string blog post markup
			 */
			static function get_blog_posts( $args = array(), $conditional_tags = array(), $current_page = array() ) {
				global $paged, $post, $wp_query, $et_fb_processing_shortcode_object, $et_pb_rendering_column_content;

				$global_processing_original_value = $et_fb_processing_shortcode_object;

				// Default params are combination of attributes that is used by et_pb_custom_blog and
				// conditional tags that need to be simulated (due to AJAX nature) by passing args
				$defaults = array(
					'posts_number'                  => '',
					'include_categories'            => '',
					'meta_date'                     => '',
				);

				// WordPress' native conditional tag is only available during page load. It'll fail during component update because
				// et_pb_process_computed_property() is loaded in admin-ajax.php. Thus, use WordPress' conditional tags on page load and
				// rely to passed $conditional_tags for AJAX call
				$is_front_page               = et_fb_conditional_tag( 'is_front_page', $conditional_tags );
				$is_search                   = et_fb_conditional_tag( 'is_search', $conditional_tags );
				$is_single                   = et_fb_conditional_tag( 'is_single', $conditional_tags );
				$et_is_builder_plugin_active = et_fb_conditional_tag( 'et_is_builder_plugin_active', $conditional_tags );

				$container_is_closed = false;

				// remove all filters from WP audio shortcode to make sure current theme doesn't add any elements into audio module
				remove_all_filters( 'wp_audio_shortcode_library' );
				remove_all_filters( 'wp_audio_shortcode' );
				remove_all_filters( 'wp_audio_shortcode_class');

				$args = wp_parse_args( $args, $defaults );


				$query_args = array(
					'posts_per_page' => intval( $args['posts_number'] ),
					'post_status'    => 'publish',
				);

				if ( defined( 'DOING_AJAX' ) && isset( $current_page[ 'paged'] ) ) {
					$paged = intval( $current_page[ 'paged' ] );
				} else {
					$paged = $is_front_page ? get_query_var( 'page' ) : get_query_var( 'paged' );
				}

				if ( '' !== $args['include_categories'] ) {
					$query_args['cat'] = $args['include_categories'];
				}

				if ( ! $is_search ) {
					$query_args['paged'] = $paged;
				}

				if ( $is_single ) {
					$query_args['post__not_in'][] = get_the_ID();
				}

				// Get query
				$query = new WP_Query( $query_args );

				// Keep page's $wp_query global
				$wp_query_page = $wp_query;

				// Turn page's $wp_query into this module's query
				$wp_query = $query;

				ob_start();

				if ( $query->have_posts() ) {

					while( $query->have_posts() ) {
						$query->the_post();
						global $et_fb_processing_shortcode_object;

						$post_id = get_the_ID();
						$global_processing_original_value = $et_fb_processing_shortcode_object;

						// reset the fb processing flag
						$et_fb_processing_shortcode_object = false;

						?>
						<div id="post-<?php echo $post_id; ?>" <?php post_class( $main_post_class ); ?>>
						<?php
							$thumb = '';

							$titletext = get_the_title();
							//$thumbnail = get_the_post_thumbnail( $post, 'thumbnail' );
							$thumb = get_the_post_thumbnail( $post_id, 'et-pb-post-main-image' ); ?>

							<?php if ( '' !== $thumb ) : ?>
								<a href="<?php echo get_the_permalink($post_id); ?>">
									<span class="et_portfolio_image">
										<?php echo $thumb; ?>
									</span>
									<div class="blog-filter-content-wrapper">
										<?php if ( 'on' === $show_title ) : ?>
											<h2><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h2>
										<?php endif; ?>
										<div class="excerpt">
											<?php
											$post_content = et_strip_shortcodes( et_delete_post_first_video( get_the_content() ), true );
											if ( '' !== $post_content ) {
												// set the $et_fb_processing_shortcode_object to false, to retrieve the content inside truncate_post() correctly
												//$et_fb_processing_shortcode_object = false;
												echo wpautop( et_delete_post_first_video( truncate_post( 40, false, get_post($post_id), true ) ) );
												// reset the $et_fb_processing_shortcode_object to its original value
												//$et_fb_processing_shortcode_object = $global_processing_original_value;
											} else {
												echo '';
											}
											
											?>
										</div>
										<div class="blog-post-meta"><!--<span class="views"><i class="fa fa-eye"></i>&nbsp;<?php // echo getPostViews_anthemes($post); ?> vues</span> -->
										<span class="post-meta"><?php echo get_the_term_list( $post_id, 'category', '', ', ' ); ?></span></div>
									</div>
								</a>
						<?php endif; ?>

						</div><!-- .et_pb_portfolio_item -->
						<?php

						$et_fb_processing_shortcode_object = $global_processing_original_value;
					} // endwhile

					if ( 'on' === $args['show_pagination'] && ! $is_search ) {
						// echo '</div> <!-- .et_pb_posts -->'; // @todo this causes closing tag issue

						$container_is_closed = true;

						if ( function_exists( 'wp_pagenavi' ) ) {
							wp_pagenavi( array(
								'query' => $query
							) );
						} else {
							if ( $et_is_builder_plugin_active ) {
								include( ET_BUILDER_PLUGIN_DIR . 'includes/navigation.php' );
							} else {
								get_template_part( 'includes/navigation', 'index' );
							}
						}
					}

					wp_reset_query();
				} else {
					if ( $et_is_builder_plugin_active ) {
						include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
					} else {
						get_template_part( 'includes/no-results', 'index' );
					}
				}

				wp_reset_postdata();

				// Reset $wp_query to its origin
				$wp_query = $wp_query_page;

				$posts = ob_get_contents();

				ob_end_clean();

				return $posts;
			}

			function shortcode_callback( $atts, $content = null, $function_name ) {
				/**
				 * Cached $wp_filter so it can be restored at the end of the callback.
				 * This is needed because this callback uses the_content filter / calls a function
				 * which uses the_content filter. WordPress doesn't support nested filter
				 */
				global $wp_filter;
				$wp_filter_cache = $wp_filter;

				$module_id           = $this->shortcode_atts['module_id'];
				$module_class        = $this->shortcode_atts['module_class'];
				$posts_number        = $this->shortcode_atts['posts_number'];
				$include_categories  = $this->shortcode_atts['include_categories'];
				$meta_date           = $this->shortcode_atts['meta_date'];

				global $paged;

				$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

				$container_is_closed = false;

				// remove all filters from WP audio shortcode to make sure current theme doesn't add any elements into audio module
				remove_all_filters( 'wp_audio_shortcode_library' );
				remove_all_filters( 'wp_audio_shortcode' );
				remove_all_filters( 'wp_audio_shortcode_class');

				$args = array( 'posts_per_page' => (int) $posts_number );

				$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );

				if ( is_front_page() ) {
					$paged = $et_paged;
				}

				if ( '' !== $include_categories )
					$args['cat'] = $include_categories;

				if ( ! is_search() ) {
					$args['paged'] = $et_paged;
				}

				if ( is_single() && ! isset( $args['post__not_in'] ) ) {
					$args['post__not_in'] = array( get_the_ID() );
				}

				ob_start();

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						 $query->the_post();

						$post_format = et_pb_post_format();
						$post_id = get_the_ID();
						 ?>

					<div id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
					<?php
						$thumb = '';

						$titletext = get_the_title();
						//$thumbnail = get_the_post_thumbnail( $post, 'thumbnail' );
						$thumb = get_the_post_thumbnail( $post_id, 'et-pb-post-main-image' ); ?>

						<?php if ( '' !== $thumb ) : ?>
							<a href="<?php echo get_the_permalink($post_id); ?>">
								<span class="et_portfolio_image">
									<?php echo $thumb; ?>
								</span>
								<div class="blog-filter-content-wrapper">
									<h2><a href="<?php echo get_the_permalink($post_id); ?>"><?php echo get_the_title($post_id); ?></a></h2>
									<div class="excerpt">
										<?php
										$post_content = et_strip_shortcodes( et_delete_post_first_video( get_the_content() ), true );
										if ( '' !== $post_content ) {
											// set the $et_fb_processing_shortcode_object to false, to retrieve the content inside truncate_post() correctly
											//$et_fb_processing_shortcode_object = false;
											echo wpautop( et_delete_post_first_video( truncate_post( 40, false, get_post($post_id), true ) ) );
											// reset the $et_fb_processing_shortcode_object to its original value
											//$et_fb_processing_shortcode_object = $global_processing_original_value;
										} else {
											echo '';
										}
										
										?>
									</div>
									 <div class="blog-post-meta"><!--<span class="views"><i class="fa fa-eye"></i>&nbsp;<?php // echo getPostViews_anthemes($post); ?> vues</span> -->
										<span class="post-meta"><?php echo get_the_term_list( $post_id, 'category', '', ', ' ); ?></span>
										<span class="post-date"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php the_time( 'j F Y' ); ?> </span>
									</div>
									
								</div>
							</a>
					<?php endif; ?>

					</div><!-- .et_pb_portfolio_item -->
			<?php
					} // endwhile

				} else {
					if ( et_is_builder_plugin_active() ) {
						include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
					} else {
						get_template_part( 'includes/no-results', 'index' );
					}
				}

				wp_reset_query();

				$posts = ob_get_contents();

				ob_end_clean();

				$class = "et_custom_blog et_pb_module et_pb_bg_layout";

				$output = sprintf(
					'<div%4$s class="%2$s %5$s">
						<div class="et_pb_portfolio_items_wrapper">
						%1$s
						</div>
					%3$s',
					$posts,
					esc_attr( $class ),
					( ! $container_is_closed ? '</div> <!-- .et_pb_posts -->' : '' ),
					( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
					( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
				);

				// Restore $wp_filter
				$wp_filter = $wp_filter_cache;
				unset($wp_filter_cache);

				return $output;
			}
		}
		new ET_Builder_Module_Custom_Blog;

	}
}
add_action('et_builder_ready', 'MC_Custom_Blog');