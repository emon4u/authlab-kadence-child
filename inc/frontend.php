<?php

/**
 * Display Custom Header Template
 */
function authlab_render_page_header() {
	global $post;

	if ( is_page() ) {
		$header_id = get_post_meta( $post->ID, '_authlab_page_header_id', true );

		if ( $header_id ) {
			$header_template = get_post( $header_id );

			if ( $header_template ) {
				echo '<header id="masthead" class="site-header" role="banner">';
				echo apply_filters( 'the_content', $header_template->post_content );
				echo '</header>';
			}
		}
	}
}

add_action( 'kadence_after_header', 'authlab_render_page_header' );

/**
 * Display Custom Footer Template
 */
function authlab_render_page_footer() {
	global $post;

	if ( is_page() ) {
		$footer_id = get_post_meta( $post->ID, '_authlab_page_footer_id', true );

		if ( $footer_id ) {
			$footer_template = get_post( $footer_id );

			if ( $footer_template ) {
				echo '<footer id="colophon" class="site-footer" role="contentinfo">';
				echo apply_filters( 'the_content', $footer_template->post_content );
				echo '</footer>';
			}
		}
	}
}

add_action( 'kadence_before_footer', 'authlab_render_page_footer' );

/**
 * Register integration Shortcode
 */
function authlab_integration_shortcode( $atts ) {
	$atts = shortcode_atts(
		[
			'limit' => - 1
		],
		$atts
	);

	$args = array(
		'post_type'           => 'authlab_integration',
		'posts_per_page'      => $atts[ 'limit' ],
		'ignore_sticky_posts' => 1,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);

	$query = new WP_Query( $args );

	ob_start();

	if ( $query->have_posts() ) : ?>
        <div class="authlab-integration-wrap">
            <div class="integration-filters">
                <h4 class="filters-title">Categories</h4>
                <ul class="filters-categories">
                    <li data-filter="*" class="active">All Integration</li>
					<?php
					$categories = get_terms( 'integration_category' );

					foreach ( (array) $categories as $category ) {
						$cat_name = $category->name;
						$cat_slug = $category->slug;

						printf( '<li data-filter=".%1$s">%2$s</li>',
							esc_attr( $cat_slug ),
							esc_html( $cat_name )
						);
					}
					?>
                </ul>
            </div>
            <div class="integration-items">
				<?php while ( $query->have_posts() ): $query->the_post();
					$item_categories = get_the_terms( get_the_ID(), 'integration_category' );
					$item_class      = [ 'integration-item' ];

					if ( $item_categories && ! is_wp_error( $item_categories ) ) {

						foreach ( $item_categories as $category ) {
							$item_class[] = $category->slug;
						}
					}
					?>
                    <div class="<?php echo implode( ' ', $item_class ) ?>">
                        <div class="integration-inner">
							<?php
							if ( has_post_thumbnail() ) {
								echo '<div class="integration-icon">' . get_the_post_thumbnail() . '</div>';
							}

							echo '<h5 class="integration-title">' . get_the_title() . '</h5>';

							if ( has_excerpt() ) {
								echo '<p class="integration-desc">' . get_the_excerpt() . '</p>';
							} else {
								echo '<p class="integration-desc">' . wp_trim_words( get_the_content(), 10 ) . '</p>';
							}
							?>
                        </div>
                    </div>
				<?php endwhile;
				wp_reset_query(); ?>
            </div>
        </div>
	<?php endif;

	return ob_get_clean();
}

add_shortcode( 'authlab_integration', 'authlab_integration_shortcode' );

/**
 * Navigation Menu shortcode
 */
function authlab_navigation_menu( $atts ) {
	$args = shortcode_atts( array(
		'menu_id'      => '',
		'color_scheme' => 'dark',
	), $atts );

	if ( ! $args[ 'menu_id' ] ) {
		return 'Please specify a menu ID using the "menu_id" attribute. Example: [menu_shortcode menu_name="Your Menu Name"]';
	}

	$menu_args = [
		'menu'        => $args[ 'menu_id' ],
		'container'   => '',
		'menu_class'  => 'primary-menu',
		'fallback_cb' => false,
		'depth'       => 4,
	];

	ob_start();
	?>
    <div class="authlab-navigation-menu color-<?php echo esc_attr( $args[ 'color_scheme' ] ) ?>">
        <div class="navigation-wrapper">
			<?php wp_nav_menu( $menu_args ); ?>

            <button class="navbar-close">
                <span></span>
                <span></span>
            </button>
        </div>
        <div class="navigation-overly"></div>
        <button class="navbar-toggler">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </button>
    </div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'authlab_navigation', 'authlab_navigation_menu' );

function authlab_faq_shortcode( $atts ) {
	$atts = shortcode_atts(
		[
			'limit' => - 1,
		],
		$atts
	);

	$args = array(
		'post_type'           => 'authlab_faq',
		'posts_per_page'      => $atts[ 'limit' ],
		'ignore_sticky_posts' => 1,
		'orderby'             => 'date',
		'order'               => 'DESC',
	);

	$query = new WP_Query( $args );

	ob_start();

	if ( $query->have_posts() ) : ?>
        <div class="authlab-faq-wrap">
            <div class="faq-filters">
                <select class="filter-category">
					<?php
					$categories = get_terms( 'faq_category' );

					foreach ( (array) $categories as $index => $category ) {
						$cat_name = $category->name;
						$cat_slug = $category->slug;
						$selected = $index == '0' ? 'selected' : '';

						printf( '<option value="%1$s" %2$s>%3$s</option>',
							esc_attr( $cat_slug ),
							esc_attr( $selected ),
							esc_html( $cat_name )
						);
					}
					?>
                </select>
            </div>
            <div class="faq-accordion">
				<?php while ( $query->have_posts() ): $query->the_post();
					$item_categories = get_the_terms( get_the_ID(), 'faq_category' );
					$item_class      = [];

					if ( $item_categories && ! is_wp_error( $item_categories ) ) {
						foreach ( $item_categories as $category ) {
							$item_class[] = $category->slug;
						}
					}
					?>
                    <div class="accordion-item" data-category="<?php echo implode( ' ', $item_class ) ?>">
                        <div class="accordion-header">
							<?php echo get_the_title(); ?>
                            <span class="icon"></span>
                        </div>
                        <div class="accordion-content">
							<?php echo get_the_content(); ?>
                        </div>
                    </div>
				<?php endwhile;
				wp_reset_query(); ?>
            </div>
        </div>
	<?php endif;

	return ob_get_clean();
}

add_shortcode( 'authlab_faq', 'authlab_faq_shortcode' );