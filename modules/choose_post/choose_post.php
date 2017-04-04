<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
function doCustomModules(){

	if(class_exists("ET_Builder_Module")){
		class ET_Builder_Module_Blog_Choose extends ET_Builder_Module {
			function init() {
				$this->name = __( 'Articles choisis', 'et_builder' );
				$this->slug = 'et_pb_blog_choose';

				$this->whitelisted_fields = array(
					'fullwidth',
					'posts_number',
					'include_posts',
					'meta_date',
					'show_thumbnail',
					'show_content',
					'show_more',
					'show_author',
					'show_date',
					'show_categories',
					'show_comments',
					'show_pagination',
					'offset_number',
					'background_layout',
					'admin_label',
					'module_id',
					'module_class',
					'masonry_tile_background_color',
					'use_dropshadow',
					'use_overlay',
					'overlay_icon_color',
					'hover_overlay_color',
					'hover_icon',
					'mobile_options',
				);

				$this->fields_defaults = array(
					'fullwidth'         => array( 'on' ),
					'posts_number'      => array( 10, 'add_default_setting' ),
					'meta_date'         => array( 'M j, Y', 'add_default_setting' ),
					'show_thumbnail'    => array( 'on' ),
					'show_content'      => array( 'off' ),
					'show_more'         => array( 'off' ),
					'show_author'       => array( 'on' ),
					'show_date'         => array( 'on' ),
					'show_categories'   => array( 'on' ),
					'show_comments'     => array( 'off' ),
					'show_pagination'   => array( 'on' ),
					'offset_number'     => array( 0, 'only_default_setting' ),
					'background_layout' => array( 'light' ),
					'use_dropshadow'    => array( 'off' ),
					'use_overlay'       => array( 'off' ),
					'mobile_options' => false,
				);

				$this->main_css_element = '%%order_class%% .et_pb_post';
				$this->custom_css_options = array(
					'title' => array(
						'label'    => __( 'Title', 'et_builder' ),
						'selector' => '.et_pb_post h2',
					),
					'post_meta' => array(
						'label'    => __( 'Post Meta', 'et_builder' ),
						'selector' => '.et_pb_post .post-meta',
					),
					'pagenavi' => array(
						'label'    => __( 'Pagenavi', 'et_builder' ),
						'selector' => '.wp_pagenavi',
					),
					'featured_image' => array(
						'label'    => __( 'Featured Image', 'et_builder' ),
						'selector' => '.et_pb_image_container',
					),
					'read_more' => array(
						'label'    => __( 'Read More Button', 'et_builder' ),
						'selector' => '.et_pb_post .more-link',
					),
				);
			}

			function get_fields() {
				$fields = array(
					'fullwidth' => array(
						'label'             => __( 'Layout', 'et_builder' ),
						'type'              => 'select',
						'option_category'   => 'layout',
						'options'           => array(
							'on'  => __( 'Fullwidth', 'et_builder' ),
							'off' => __( 'Grid', 'et_builder' ),
						),
						'affects'           => array(
							'#et_pb_background_layout',
							'#et_pb_use_dropshadow',
							'#et_pb_masonry_tile_background_color',
						),
						'description'        => __( 'Toggle between the various blog layout types.', 'et_builder' ),
					),
					'posts_number' => array(
						'label'             => __( 'Posts Number', 'et_builder' ),
						'type'              => 'text',
						'option_category'   => 'configuration',
						'description'       => __( 'Choose how much posts you would like to display per page.', 'et_builder' ),
					),
					'include_posts' => array(
						'label'            => __( 'Posts à afficher', 'et_builder' ),
						'option_category'  => 'basic_option',
						'renderer'         => 'et_builder_include_posts_option',				
						'description'      => __( 'Choose which posts you would like to include in the feed.', 'et_builder' ),
					),
					'meta_date' => array(
						'label'             => __( 'Meta Date Format', 'et_builder' ),
						'type'              => 'text',
						'option_category'   => 'configuration',
						'description'       => __( 'If you would like to adjust the date format, input the appropriate PHP date format here.', 'et_builder' ),
					),
					'show_thumbnail' => array(
						'label'             => __( 'Show Featured Image', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => __( 'Yes', 'et_builder' ),
							'off' => __( 'No', 'et_builder' ),
						),
						'description'        => __( 'This will turn thumbnails on and off.', 'et_builder' ),
					),
					'show_content' => array(
						'label'             => __( 'Content', 'et_builder' ),
						'type'              => 'select',
						'option_category'   => 'configuration',
						'options'           => array(
							'off' => __( 'Show Excerpt', 'et_builder' ),
							'on'  => __( 'Show Content', 'et_builder' ),
						),
						'affects'           => array(
							'#et_pb_show_more',
						),
						'description'        => __( 'Showing the full content will not truncate your posts on the index page. Showing the excerpt will only display your excerpt text.', 'et_builder' ),
					),
					'show_more' => array(
						'label'             => __( 'Read More Button', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'off' => __( 'Off', 'et_builder' ),
							'on'  => __( 'On', 'et_builder' ),
						),
						'depends_show_if'   => 'off',
						'description'       => __( 'Here you can define whether to show "read more" link after the excerpts or not.', 'et_builder' ),
					),

					'show_date' => array(
						'label'             => __( 'Show Date', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => __( 'Yes', 'et_builder' ),
							'off' => __( 'No', 'et_builder' ),
						),
						'description'        => __( 'Turn the date on or off.', 'et_builder' ),
					),
					'show_categories' => array(
						'label'             => __( 'Show Categories', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => __( 'Yes', 'et_builder' ),
							'off' => __( 'No', 'et_builder' ),
						),
						'description'        => __( 'Turn the category links on or off.', 'et_builder' ),
					),
					'show_comments' => array(
						'label'             => __( 'Show Comment Count', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => __( 'Yes', 'et_builder' ),
							'off' => __( 'No', 'et_builder' ),
						),
						'description'        => __( 'Turn comment count on and off.', 'et_builder' ),
					),
					'show_pagination' => array(
						'label'             => __( 'Show Pagination', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => __( 'Yes', 'et_builder' ),
							'off' => __( 'No', 'et_builder' ),
						),
						'description'        => __( 'Turn pagination on and off.', 'et_builder' ),
					),
					'offset_number' => array(
						'label'           => __( 'Offset Number', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'configuration',
						'description'     => __( 'Choose how many posts you would like to offset by', 'et_builder' ),
					),
					'use_overlay' => array(
						'label'             => __( 'Featured Image Overlay', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'layout',
						'options'           => array(
							'off' => __( 'Off', 'et_builder' ),
							'on'  => __( 'On', 'et_builder' ),
						),
						'affects'           => array(
							'#et_pb_overlay_icon_color',
							'#et_pb_hover_overlay_color',
							'#et_pb_hover_icon',
						),
						'description'       => __( 'If enabled, an overlay color and icon will be displayed when a visitors hovers over the featured image of a post.', 'et_builder' ),
					),
					'overlay_icon_color' => array(
						'label'             => __( 'Overlay Icon Color', 'et_builder' ),
						'type'              => 'color',
						'custom_color'      => true,
						'depends_show_if'   => 'on',
						'description'       => __( 'Here you can define a custom color for the overlay icon', 'et_builder' ),
					),
					'hover_overlay_color' => array(
						'label'             => __( 'Hover Overlay Color', 'et_builder' ),
						'type'              => 'color-alpha',
						'custom_color'      => true,
						'depends_show_if'   => 'on',
						'description'       => __( 'Here you can define a custom color for the overlay', 'et_builder' ),
					),
					'hover_icon' => array(
						'label'               => __( 'Hover Icon Picker', 'et_builder' ),
						'type'                => 'text',
						'option_category'     => 'configuration',
						'class'               => array( 'et-pb-font-icon' ),
						'renderer'            => 'et_pb_get_font_icon_list',
						'renderer_with_field' => true,
						'depends_show_if'     => 'on',
						'description'         => __( 'Here you can define a custom icon for the overlay', 'et_builder' ),
					),
					'background_layout' => array(
						'label'       => __( 'Text Color', 'et_builder' ),
						'type'        => 'select',
						'option_category' => 'color_option',
						'options'           => array(
							'light' => __( 'Dark', 'et_builder' ),
							'dark'  => __( 'Light', 'et_builder' ),
						),
						'depends_default' => true,
						'description' => __( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'et_builder' ),
					),
					'masonry_tile_background_color' => array(
						'label'             => __( 'Grid Tile Background Color', 'et_builder' ),
						'type'              => 'color-alpha',
						'custom_color'      => true,
						'tab_slug'          => 'advanced',
						'depends_show_if'   => 'off',
					),
					'use_dropshadow' => array(
						'label'             => __( 'Use Dropshadow', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'layout',
						'options'           => array(
							'off' => __( 'Off', 'et_builder' ),
							'on'  => __( 'On', 'et_builder' ),
						),
						'tab_slug'          => 'advanced',
						'depends_show_if'   => 'off',
					),
					'disabled_on' => array(
						'label'           => __( 'Disable on', 'et_builder' ),
						'type'            => 'multiple_checkboxes',
						'options'         => array(
							'phone'   => __( 'Phone', 'et_builder' ),
							'tablet'  => __( 'Tablet', 'et_builder' ),
							'desktop' => __( 'Desktop', 'et_builder' ),
						),
						'additional_att'  => 'disable_on',
						'option_category' => 'configuration',
						'description'     => __( 'This will disable the module on selected devices', 'et_builder' ),
					),
					'admin_label' => array(
						'label'       => __( 'Admin Label', 'et_builder' ),
						'type'        => 'text',
						'description' => __( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
					),
					'module_id' => array(
						'label'           => __( 'CSS ID', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'configuration',
						'tab_slug'        => 'custom_css',
						'option_class'    => 'et_pb_custom_css_regular',
					),
					'module_class' => array(
						'label'           => __( 'CSS Class', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'configuration',
						'tab_slug'        => 'custom_css',
						'option_class'    => 'et_pb_custom_css_regular',
					),
				);
				return $fields;
			}

			function shortcode_callback( $atts, $content = null, $function_name ) {
				$module_id           = $this->shortcode_atts['module_id'];
				$module_class        = $this->shortcode_atts['module_class'];
				$fullwidth           = $this->shortcode_atts['fullwidth'];
				$posts_number        = $this->shortcode_atts['posts_number'];
				$include_posts = $this->shortcode_atts['include_posts'];
				$meta_date           = $this->shortcode_atts['meta_date'];
				$show_thumbnail      = $this->shortcode_atts['show_thumbnail'];
				$show_content        = $this->shortcode_atts['show_content'];
				$show_author         = $this->shortcode_atts['show_author'];
				$show_date           = $this->shortcode_atts['show_date'];
				$show_categories     = $this->shortcode_atts['show_categories'];
				$show_comments       = $this->shortcode_atts['show_comments'];
				$show_pagination     = $this->shortcode_atts['show_pagination'];
				$background_layout   = $this->shortcode_atts['background_layout'];
				$show_more           = $this->shortcode_atts['show_more'];
				$offset_number       = $this->shortcode_atts['offset_number'];
				$masonry_tile_background_color = $this->shortcode_atts['masonry_tile_background_color'];
				$use_dropshadow      = $this->shortcode_atts['use_dropshadow'];
				$overlay_icon_color  = $this->shortcode_atts['overlay_icon_color'];
				$hover_overlay_color = $this->shortcode_atts['hover_overlay_color'];
				$hover_icon          = $this->shortcode_atts['hover_icon'];
				$use_overlay         = $this->shortcode_atts['use_overlay'];

				global $paged;

				$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

				$container_is_closed = false;

				// remove all filters from WP audio shortcode to make sure current theme doesn't add any elements into audio module
				remove_all_filters( 'wp_audio_shortcode_library' );
				remove_all_filters( 'wp_audio_shortcode' );
				remove_all_filters( 'wp_audio_shortcode_class');

				if ( '' !== $masonry_tile_background_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%%.et_pb_blog_grid .et_pb_post',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $masonry_tile_background_color )
						),
					) );
				}

				if ( '' !== $overlay_icon_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_overlay:before',
						'declaration' => sprintf(
							'color: %1$s !important;',
							esc_html( $overlay_icon_color )
						),
					) );
				}

				if ( '' !== $hover_overlay_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_overlay',
						'declaration' => sprintf(
							'background-color: %1$s;',
							esc_html( $hover_overlay_color )
						),
					) );
				}

				if ( 'on' === $use_overlay ) {
					$data_icon = '' !== $hover_icon
						? sprintf(
							' data-icon="%1$s"',
							esc_attr( et_pb_process_font_icon( $hover_icon ) )
						)
						: '';

					$overlay_output = sprintf(
						'<span class="et_overlay%1$s"%2$s></span>',
						( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
						$data_icon
					);
				}

				$overlay_class = 'on' === $use_overlay ? ' et_pb_has_overlay' : '';

				if ( 'on' !== $fullwidth ){
					if ( 'on' === $use_dropshadow ) {
						$module_class .= ' et_pb_blog_grid_dropshadow';
					}

					wp_enqueue_script( 'salvattore' );

					$background_layout = 'light';
				}
				
				
				$args = array( 'posts_per_page' => (int) $posts_number, 'post_type' => 'post');
				
				$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );

				if ( is_front_page() ) {
					$paged = $et_paged;
				}
				if ( '' !== $include_posts )
					$include_posts = array_map('intval', explode(',', $include_posts));
					$args['post__in'] = $include_posts;
					$args['ignore_sticky_posts'] = true;

				if ( ! is_search() ) {
					$args['paged'] = $et_paged;
				}

				if ( '' !== $offset_number && ! empty( $offset_number ) ) {
					/**
					 * Offset + pagination don't play well. Manual offset calculation required
					 * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
					 */
					if ( $paged > 1 ) {
						$args['offset'] = ( ( $et_paged - 1 ) * intval( $posts_number ) ) + intval( $offset_number );
					} else {
						$args['offset'] = intval( $offset_number );
					}
				}

				ob_start();

				$the_query = new WP_Query( $args );
				
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();

						$post_format = et_pb_post_format();

						$thumb = '';

						$width = 'on' === $fullwidth ? 1080 : 400;
						$width = (int) apply_filters( 'et_pb_blog_image_width', $width );

						$height = 'on' === $fullwidth ? 675 : 250;
						$height = (int) apply_filters( 'et_pb_blog_image_height', $height );
						$classtext = 'on' === $fullwidth ? 'et_pb_post_main_image' : '';
						$titletext = get_the_title();
						$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
						$thumb = $thumbnail["thumb"];

						$no_thumb_class = '' === $thumb || 'off' === $show_thumbnail ? ' et_pb_no_thumb' : '';

						if ( in_array( $post_format, array( 'video', 'gallery' ) ) ) {
							$no_thumb_class = '';
						} 
						?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' . $no_thumb_class . $overlay_class  ); ?>>
					<?php
						et_divi_post_format_content();

						if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
							if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
								printf(
									'<div class="et_main_video_container">
										%1$s
									</div>',
									$first_video
								);
							elseif ( 'gallery' === $post_format ) :
								et_pb_gallery_images( 'slider' );
							elseif ( '' !== $thumb && 'on' === $show_thumbnail ) :
								if ( 'on' !== $fullwidth ) echo '<div class="et_pb_image_container">'; ?>
									<a href="<?php the_permalink(); ?>" class="entry-featured-image-url">
										<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
										<?php if ( 'on' === $use_overlay ) {
											echo $overlay_output;
										} ?>
									</a>
							<?php
								if ( 'on' !== $fullwidth ) echo '</div> <!-- .et_pb_image_container -->';
							endif;
						} ?>

					<?php if ( 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) { ?>
						<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) { ?>
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php } ?>

						<?php
							if ( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories || 'on' === $show_comments ) {
								printf( '<p class="post-meta">%1$s %2$s %3$s %4$s %5$s %6$s %7$s</p>',
									(
										'on' === $show_author
											? sprintf( __( 'by %s', 'et_builder' ), '<span class="author vcard">' .  et_pb_get_the_author_posts_link() . '</span>' )
											: ''
									),
									(
										( 'on' === $show_author && 'on' === $show_date )
											? ' | '
											: ''
									),
									(
										'on' === $show_date
											? sprintf( __( '%s', 'et_builder' ), '<span class="published">' . get_the_date( $meta_date ) . '</span>' )
											: ''
									),
									(
										(( 'on' === $show_author || 'on' === $show_date ) && 'on' === $show_categories)
											? ' | '
											: ''
									),
									(
										'on' === $show_categories
											? get_the_category_list(', ')
											: ''
									),
									(
										(( 'on' === $show_author || 'on' === $show_date || 'on' === $show_categories ) && 'on' === $show_comments)
											? ' | '
											: ''
									),
									(
										'on' === $show_comments
											? sprintf( _nx( '1 Comment', '%s Comments', get_comments_number(), 'number of comments', 'et_builder' ), number_format_i18n( get_comments_number() ) )
											: ''
									)
								);
							}

							$post_content = get_the_content();

							// do not display the content if it contains Blog, Post Slider, Fullwidth Post Slider, or Portfolio modules to avoid infinite loops
							if ( ! has_shortcode( $post_content, 'et_pb_blog' ) && ! has_shortcode( $post_content, 'et_pb_portfolio' ) && ! has_shortcode( $post_content, 'et_pb_post_slider' ) && ! has_shortcode( $post_content, 'et_pb_fullwidth_post_slider' ) ) {
								if ( 'on' === $show_content ) {
									global $more;

									// page builder doesn't support more tag, so display the_content() in case of post made with page builder
									if ( et_pb_is_pagebuilder_used( get_the_ID() ) ) {
										$more = 1;
										the_content();
									} else {
										$more = null;
										the_content( __( 'read more...', 'et_builder' ) );
									}
								} else {
									if ( has_excerpt() ) { 
									 the_excerpt(); 
									  } else { ?>
									<div class="thecontent">
									<?php
										truncate_post( 270 );
									} ?>
									</div>
									<?php
								}
							} else if ( has_excerpt() ) {
								the_excerpt();
							}

							if ( 'on' !== $show_content ) {
								$more = 'on' == $show_more ? sprintf( ' <a href="%1$s" class="more-link" >%2$s</a>' , esc_url( get_permalink() ), __( 'read more', 'et_builder' ) )  : '';
								echo $more;
							}
							?>
					<?php } // 'off' === $fullwidth || ! in_array( $post_format, array( 'link', 'audio', 'quote', 'gallery' ?>

					</article> <!-- .et_pb_post -->
					<?php
						} // endwhile

					if ( 'on' === $show_pagination && ! is_search() ) {
						echo '</div> <!-- .et_pb_posts -->';

						$container_is_closed = true;

						if ( function_exists( 'wp_pagenavi' ) ) {
							wp_pagenavi();
						} else {
							if ( et_is_builder_plugin_active() ) {
								include( ET_BUILDER_PLUGIN_DIR . 'includes/navigation.php' );
							} else {
								get_template_part( 'includes/navigation', 'index' );
							}
						}
					}

					wp_reset_query();
				} else {
					if ( et_is_builder_plugin_active() ) {
						include( ET_BUILDER_PLUGIN_DIR . 'includes/no-results.php' );
					} else {
						get_template_part( 'includes/no-results', 'index' );
					}
				}

				$posts = ob_get_contents();

				ob_end_clean();

				$class = " et_pb_module et_pb_bg_layout_{$background_layout}";

				$output = sprintf(
					'<div%5$s class="%1$s%3$s%6$s"%7$s>
						%2$s
					%4$s',
					( 'on' === $fullwidth ? 'et_pb_posts' : 'et_pb_blog_grid clearfix' ),
					$posts,
					esc_attr( $class ),
					( ! $container_is_closed ? '</div> <!-- .et_pb_posts -->' : '' ),
					( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
					( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
					( 'on' !== $fullwidth ? ' data-columns' : '' )
				);

				if ( 'on' !== $fullwidth )
					$output = sprintf( '<div class="et_pb_blog_grid_wrapper">%1$s</div>', $output );

				return $output;
			}
		}
		new ET_Builder_Module_Blog_Choose;
	}
}
add_action('after_setup_theme', 'prepareCustomModule', 999);
function prepareCustomModule(){
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
		add_action($action_hook, 'doCustomModules', 9789);
	}
}

function et_builder_include_posts_option( $args = array() ) {
		  
	$output = "\t" . "<% var et_pb_include_posts_temp = typeof et_pb_include_posts !== 'undefined' ? et_pb_include_posts.split( ',' ) : []; %>" . "\n";
	$myposts = get_posts( array( 'posts_per_page' => -1 ) );
		foreach ( $myposts as $post ) {
		    $contains = sprintf(
		      '<%%= _.contains( et_pb_include_posts_temp, "%1$s" ) ? checked="checked" : "" %%>',
		      esc_html( $post->ID )
		    );

		    $output .= sprintf(
		      '%4$s<label><input type="checkbox" name="et_pb_include_posts" value="%1$s"%3$s> %2$s</label><br/>',
		      esc_attr( $post->ID ),
		      esc_html( get_the_title($post) ),
		      $contains,
		      "\n\t\t\t\t\t"
		    );
		}
	$output = '<div id="et_pb_include_posts">' . $output . '</div>';
	return $output;
}

?>