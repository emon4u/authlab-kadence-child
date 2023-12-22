<?php

/**
 * Register Page Meta Box
 */
function authlab_register_page_meta_box() {
	add_meta_box(
		'authlab_page_meta_box',
		__( 'Authlab Settings', 'authlab-kadence-child' ),
		'authlab_display_page_meta_box',
		'page',
		'normal'
	);
}

add_action( 'admin_menu', 'authlab_register_page_meta_box' );

/**
 * Display Page Meta Box
 */
function authlab_display_page_meta_box( $page ) {
	$header_id = get_post_meta( $page->ID, '_authlab_page_header_id', true );
	$footer_id = get_post_meta( $page->ID, '_authlab_page_footer_id', true );

	wp_nonce_field( 'authlab_page_meta_nonce_action', 'authlab_page_meta_nonce' );

	$posts = get_posts( array(
		'post_type'      => 'authlab_templates',
		'posts_per_page' => - 1,
	) );

	ob_start();
	?>
    <p>
        <label for="authlab_page_header_id" style="display: inline-block; margin-right: 30px">
			<?php _e( 'Header Template', 'authlab-kadence-child' ); ?>
        </label>
        <select name="authlab_page_header_id" id="authlab_page_header_id">
            <option value=""><?php _e( 'Select a template', 'authlab-kadence-child' ); ?></option>
			<?php foreach ( $posts as $post ) : ?>
				<?php $selected = selected( $header_id, $post->ID, false ); ?>
                <option value="<?php echo esc_attr( $post->ID ); ?>" <?php echo $selected; ?>>
					<?php echo esc_html( $post->post_title ); ?>
                </option>
			<?php endforeach; ?>
        </select>
    </p>
    <p>
        <label for="authlab_page_footer_id" style="display: inline-block; margin-right: 30px">
			<?php _e( 'Footer Template', 'authlab-kadence-child' ); ?>
        </label>
        <select name="authlab_page_footer_id" id="authlab_page_footer_id">
            <option value=""><?php _e( 'Select a template', 'authlab-kadence-child' ); ?></option>
			<?php foreach ( $posts as $post ) : ?>
				<?php $selected = selected( $footer_id, $post->ID, false ); ?>
                <option value="<?php echo esc_attr( $post->ID ); ?>" <?php echo $selected; ?>>
					<?php echo esc_html( $post->post_title ); ?>
                </option>
			<?php endforeach; ?>
        </select>
    </p>
    <p>
		<?php _e( 'If you use custom template. Please disable default template form Kadence Page Settings',
			'authlab-kadence-child' ) ?>
    </p>
	<?php
	echo ob_get_clean();
}

/**
 * Save Page Meta Box
 */
function authlab_save_page_meta_box( $page_id ) {
	if ( empty( $_POST[ 'authlab_page_meta_nonce' ] ) ) {
		return $page_id;
	}

	if ( ! wp_verify_nonce( $_POST[ 'authlab_page_meta_nonce' ], 'authlab_page_meta_nonce_action' ) ) {
		return $page_id;
	}

	if ( ! current_user_can( 'edit_post', $page_id ) ) {
		return $page_id;
	}

	if ( wp_is_post_autosave( $page_id ) || wp_is_post_revision( $page_id ) ) {
		return $page_id;
	}

	if ( isset( $_POST[ 'authlab_page_header_id' ] ) ) {
		$header_id = sanitize_text_field( $_POST[ 'authlab_page_header_id' ] );
		update_post_meta( $page_id, '_authlab_page_header_id', $header_id );
	}

	if ( isset( $_POST[ 'authlab_page_footer_id' ] ) ) {
		$footer_id = sanitize_text_field( $_POST[ 'authlab_page_footer_id' ] );
		update_post_meta( $page_id, '_authlab_page_footer_id', $footer_id );
	}

	return $page_id;
}

add_action( 'save_post', 'authlab_save_page_meta_box' );