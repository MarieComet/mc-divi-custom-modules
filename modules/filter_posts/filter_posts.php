<?php

function FilterPost(){
	if(class_exists("ET_Builder_Module")){
		class ET_Builder_Filter_Blog extends ET_Builder_Module {
			function init() {

				add_action('wp_enqueue_scripts', array( $this, 'enqueue_custom_css' ));
				
				$this->name = esc_html__( 'Blog Filtrable', 'et_builder' );
				$this->slug = 'et_pb_filterable_blog_mc';

				$this->whitelisted_fields = array(
					'posts_number',
					'include_categories',
					'show_title',
					'show_categories',
					'show_pagination',
					'background_layout',
					'admin_label',
					'module_id',
					'module_class',
					'filter_bg_color',
				);

				$this->fields_defaults = array(
					'posts_number'      => array( 10, 'add_default_setting' ),
					'show_title'        => array( 'on' ),
					'show_categories'   => array( 'on' ),
					'show_pagination'   => array( 'on' ),
					'background_layout' => array( 'light' ),
				);

				$this->main_css_element = '%%order_class%%.et_pb_filterable_portfolio';
				$this->advanced_options = array(
					'fonts' => array(
						'title'   => array(
							'label'    => esc_html__( 'Title', 'et_builder' ),
							'css'      => array(
								'main' => "{$this->main_css_element} h2",
								'important' => 'all',
							),
						),
						'caption' => array(
							'label'    => esc_html__( 'Meta', 'et_builder' ),
							'css'      => array(
								'main' => "{$this->main_css_element} .post-meta, {$this->main_css_element} .post-meta a",
							),
						),
						'filter' => array(
							'label'    => esc_html__( 'Filter', 'et_builder' ),
							'css'      => array(
								'main' => "{$this->main_css_element} .et_pb_portfolio_filter",
							),
						),
					),
					'background' => array(
						'settings' => array(
							'color' => 'alpha',
						),
					),
					'border' => array(
						'css' => array(
							'main' => "{$this->main_css_element} .et_pb_portfolio_item",
						),
					),
				);
				$this->custom_css_options = array(
					'portfolio_filters' => array(
						'label'    => esc_html__( 'Portfolio Filters', 'et_builder' ),
						'selector' => '.et_pb_filterable_blog_mc .et_pb_portfolio_filters',
					),
					'active_portfolio_filter' => array(
						'label'    => esc_html__( 'Active Portfolio Filter', 'et_builder' ),
						'selector' => '.et_pb_filterable_blog_mc .et_pb_portfolio_filters li a.active',
					),
					'portfolio_image' => array(
						'label'    => esc_html__( 'Portfolio Image', 'et_builder' ),
						'selector' => '.et_portfolio_image',
					),
					'overlay' => array(
						'label'    => esc_html__( 'Overlay', 'et_builder' ),
						'selector' => '.et_overlay',
					),
					'overlay_icon' => array(
						'label'    => esc_html__( 'Overlay Icon', 'et_builder' ),
						'selector' => '.et_overlay:before',
					),
					'portfolio_title' => array(
						'label'    => esc_html__( 'Portfolio Title', 'et_builder' ),
						'selector' => '.et_pb_portfolio_item h2',
					),
					'portfolio_post_meta' => array(
						'label'    => esc_html__( 'Portfolio Post Meta', 'et_builder' ),
						'selector' => '.et_pb_portfolio_item .post-meta',
					),
					'portfolio_pagination' => array(
						'label'    => esc_html__( 'Portfolio Pagination', 'et_builder' ),
						'selector' => '.et_pb_portofolio_pagination',
					),
					'portfolio_pagination_active' => array(
						'label'    => esc_html__( 'Pagination Active Page', 'et_builder' ),
						'selector' => '.et_pb_portofolio_pagination a.active',
					),
				);
			}

			function enqueue_custom_css() {
				wp_enqueue_style( 'filter-posts-css', plugin_dir_url( __FILE__ ) . 'filter-posts-css.css'  );
			}
			function get_fields() {
				$fields = array(
					'posts_number' => array(
						'label'             => esc_html__( 'Posts Number', 'et_builder' ),
						'type'              => 'text',
						'option_category'   => 'configuration',
						'description'       => esc_html__( 'Define the number of projects that should be displayed per page.', 'et_builder' ),
					),
					'include_categories' => array(
						'label'            => esc_html__( 'Include Categories', 'et_builder' ),
						'renderer'         => 'et_builder_include_categories_option',
						'option_category'  => 'basic_option',
						'renderer_options' => array(
							'use_terms' => false,
						),
						'description'     => esc_html__( 'Select the categories that you would like to include in the feed.', 'et_builder' ),
					),
					'show_title' => array(
						'label'             => esc_html__( 'Show Title', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => esc_html__( 'Yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'description'        => esc_html__( 'Turn project titles on or off.', 'et_builder' ),
					),
					'show_categories' => array(
						'label'             => esc_html__( 'Show Categories', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => esc_html__( 'Yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'description'        => esc_html__( 'Turn the category links on or off.', 'et_builder' ),
					),
					'show_pagination' => array(
						'label'             => esc_html__( 'Show Pagination', 'et_builder' ),
						'type'              => 'yes_no_button',
						'option_category'   => 'configuration',
						'options'           => array(
							'on'  => esc_html__( 'Yes', 'et_builder' ),
							'off' => esc_html__( 'No', 'et_builder' ),
						),
						'description'        => esc_html__( 'Enable or disable pagination for this feed.', 'et_builder' ),
					),
					'background_layout' => array(
						'label'           => esc_html__( 'Text Color', 'et_builder' ),
						'type'            => 'select',
						'option_category' => 'color_option',
						'options' => array(
							'light'  => esc_html__( 'Dark', 'et_builder' ),
							'dark' => esc_html__( 'Light', 'et_builder' ),
						),
						'description'        => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'et_builder' ),
					),
					'filter_bg_color' => array(
						'label'             => esc_html__( 'Couleur d\'arrière plan des filtres', 'et_builder' ),
						'type'              => 'color-alpha',
						'custom_color'      => true,
						'tab_slug'          => 'advanced',
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
				$module_id          = $this->shortcode_atts['module_id'];
				$module_class       = $this->shortcode_atts['module_class'];
				$posts_number       = $this->shortcode_atts['posts_number'];
				$include_categories = $this->shortcode_atts['include_categories'];
				$show_title         = $this->shortcode_atts['show_title'];
				$show_categories    = $this->shortcode_atts['show_categories'];
				$show_pagination    = $this->shortcode_atts['show_pagination'];
				$background_layout  = $this->shortcode_atts['background_layout'];
				$filter_bg_color = $this->shortcode_atts['filter_bg_color'];

				$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

				wp_enqueue_script( 'hashchange' );

				$args = array();

				if ( '' !== $filter_bg_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_pb_portfolio_filter a',
						'declaration' => sprintf(
							'background-color: %1$s !important;',
							esc_html( $filter_bg_color )
						),
					) );
				}

				$args['post_type'] = 'post';

				if( 'on' === $show_pagination ) {
					$args['nopaging'] = true;
				} else {
					$args['posts_per_page'] = (int) $posts_number;
				}

				if ( '' !== $include_categories ) {
					$args['tax_query'] = array(
						array(
							'taxonomy' => 'category',
							'field' => 'id',
							'terms' => explode( ',', $include_categories ),
							'operator' => 'IN',
						)
					);
				}

				$included_categories = explode(',', $include_categories);

				$posts = array();

				foreach($included_categories as $include_categorie) {

					$args = array(
						'posts_per_page' => $posts_number,
						'offset' => 0,
						'cat' => $include_categorie,
						'orderby' => 'post_date',
						'order' => 'DESC',
						'post_type' => 'post',
						'post_status' => 'publish',
						'ignore_sticky_posts' => true,
						'no_found_rows'  => true
					);

					$query = new WP_Query( $args );

					if ( $query->have_posts() ) {
						
						while ( $query->have_posts() ) {
							$query->the_post();
							$post_id = $query->post->ID;
							$posts[] = $post_id;

						}
						wp_reset_postdata();
					}			
				}
				
			
				ob_start();

				$posts_unique = array_unique($posts);
				if( $posts_unique ) {
					shuffle($posts_unique);
					//var_dump($posts_unique);

					$args2 = array(
						'post__in' => $posts_unique,
						'posts_per_page' => -1,
						'orderby' => 'post_date',
						'order' => 'DESC',						
						'post_status' => 'publish'
					);
					$query2 = new WP_Query( $args2 );

					while ( $query2->have_posts() ) {

						$query2->the_post();
						$post_id = $query2->post->ID;
						$category_classes = array();
						$categories = get_the_terms( $post_id, 'category' );
						//$first_cat = $categories[0];

						if ( class_exists('WPSEO_Primary_Term') ) {

							$wpseo_primary_term = new WPSEO_Primary_Term( 'category', $post_id );
							$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
							$term = get_term( $wpseo_primary_term );
							$category_classes = array();
							if (is_wp_error($term)) { 

								if ( $categories ) {
									foreach ( $categories as $category ) {
									// Default to first category (not Yoast) if an error is returned
									$category_classes[] = 'project_category_' . urldecode(  $category->slug );
									//$categories_included = $first_cat->term_id;
									}
									
								}	
							} else { 
								// Yoast Primary category
								$yoast_category_classes = array();
								$yoast_category_classes[] = 'project_category_' . urldecode( $term->slug );
								$category_classes[] = 'project_category_' . urldecode(  $category->slug );
								//$categories_included = $term->term_id;
								$category_classes = array_merge($category_classes, $yoast_category_classes);
							}
						} else {
							foreach ( $categories as $category ) {
								// Default, display the first category in WP's list of assigned categories
								$category_classes = 'project_category_' . urldecode( $category->slug );
								//$categories_included = $first_cat->term_id;
							}
						}

						$category_classes = implode( ' ', $category_classes );
						$main_post_class = sprintf(
							'et_pb_portfolio_item %1$s',
							$category_classes
						);
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

										<?php if ( 'on' === $show_categories ) : ?>
											<span class="post-meta"><?php echo get_the_term_list( $post_id, 'category', '', ', ' ); ?></span></div>
										<?php endif; ?>
									</div>
								</a>
						<?php endif; ?>

						</div><!-- .et_pb_portfolio_item -->
						<?php
					}
				}
				wp_reset_postdata();

				$posts = ob_get_clean();

				$terms_args = array(
					'taxonomy' => 'category',
					'include' => $included_categories,
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => true,
				);
				$terms = get_terms( $terms_args );

				$category_filters = '<ul class="clearfix">';
				$category_filters .= sprintf( '<li class="et_pb_portfolio_filter et_pb_portfolio_filter_all"><a href="#" class="active" data-category-slug="all">%1$s</a></li>',
					esc_html__( 'Categories', 'et_builder' )
				);
				foreach ( $terms as $term  ) {
					$category_filters .= sprintf( '<li class="et_pb_portfolio_filter"><a href="#" data-category-slug="%1$s">%2$s</a></li>',
						esc_attr( urldecode( $term->slug ) ),
						esc_html( $term->name )
					);
				}
				$category_filters .= '</ul>';

				$class = " et_pb_module et_pb_bg_layout_{$background_layout}";
				$output = sprintf(
					'<div%5$s class="et_filter_blog et_pb_filterable_portfolio %1$s%4$s%6$s" data-posts-number="%7$d"%10$s>
						<div class="et_pb_portfolio_filters clearfix">%2$s</div><!-- .et_pb_portfolio_filters -->

						<div class="et_pb_portfolio_items_wrapper %8$s">
							<div class="et_pb_portfolio_items">%3$s</div><!-- .et_pb_portfolio_items -->
						</div>
						%9$s
					</div> <!-- .et_pb_filterable_blog_mc -->',
					( 'et_pb_filterable_portfolio_grid clearfix' ),
					$category_filters,
					$posts,
					esc_attr( $class ),
					( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
					( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
					esc_attr( $posts_number),
					('on' === $show_pagination ? '' : 'no_pagination' ),
					('on' === $show_pagination ? '<div class="et_pb_portofolio_pagination"></div>' : '' ),
					is_rtl() ? ' data-rtl="true"' : ''
				);

				return $output;
			}
		}
		new ET_Builder_Filter_Blog;
	}
}
add_action('after_setup_theme', 'prepareFilterPost', 999);
function prepareFilterPost(){
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
		add_action($action_hook, 'FilterPost', 9999);
	}
}