<?php
/**
 * Functions related to handling of pages with required page templates.
 *
 * @package Blackfyre
 * @since Blackfyre 1.4
 */

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

/**
 * Returns data for pages that are required for the theme to function properly.
 *
 * @since Blackfyre 1.4
 *
 * @param string $template_name Specific template name for which the page should be returned. Optional.
 * @return array An array containing page data.
 */
function blackfyre_get_required_pages_data( $template_name = false ) {

	$req_pages = array(
		'tmp-clan-challenge' => array(
			'post_name'     => 'clan-challenge',
			'post_status'   => 'publish',
			'post_title'    => esc_html__( 'Clan challenge', 'blackfyre' ),
			'post_type'     => 'page',
			'page_template' => 'tmp-clan-challenge.php',
			'post_author'   => 1
		),
		'page-user-registration' => array(
			'post_name'     => 'user-registration',
			'post_status'   => 'publish',
			'post_title'    => esc_html__( 'Registration', 'blackfyre' ),
			'post_type'     => 'page',
			'page_template' => 'page-user-registration.php',
			'post_author'   => 1
		),
		'page-user-activation' => array(
			'post_name'     => 'user-activation',
			'post_status'   => 'publish',
			'post_title'    => esc_html__( 'Activation', 'blackfyre' ),
			'post_type'     => 'page',
			'page_template' => 'page-user-activation.php',
			'post_author'   => 1
		),
		'page-all-clans-for-game' => array(
			'post_name'     => 'all-clans-for-game',
			'post_status'   => 'publish',
			'post_title'    => esc_html__( 'List of all clans for selected game', 'blackfyre' ),
			'post_type'     => 'page',
			'page_template' => 'page-all-clans-for-game.php',
			'post_author'   => 1
		)
	);

	if ( array_key_exists( $template_name, $req_pages ) ) {
		return $req_pages[$template_name];
	} else {
		return false;
	}

}



/**
 * Recreates 'bf_pwt_' transients when page with specific
 * template is saved. Runs on 'save_post' action.
 *
 * @since Blackfyre 1.4
 *
 * @param int $post_id ID of the post that is being saved.
 */
function blackfyre_recreate_page_template_transients( $post_id = 0 ) {
	global $post;
	if ( ! is_admin() )
		return $post_id;

	if ( ! $post_id )
		return $post_id;

	// 'Add New' admin page check
	$page = get_post( $post_id );
	if(! empty($post) && is_a($post, 'WP_Post')){
	if ( $post->post_status == 'auto-draft' )
		return $post_id;
	}
	// Autosave check
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	// Capability check
	if(! empty($post) && is_a($post, 'WP_Post')){
	if ( isset( $POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) )
			return;
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;
	}
	}

	if ( get_post_type( $post_id ) == 'page' ) {
		$template = get_post_meta( $post_id, '_wp_page_template', true );

		if ( ! empty( $template ) && $template != 'default' ) {
			$template_name = substr( $template, 0, -4 );

			$is_wpml = function_exists( 'icl_object_id' ) ? true : false;

			if ( $is_wpml ) {
				global $sitepress, $wpdb;

				$default_lang = $sitepress->get_default_language();
				$current_lang = isset( $_POST['icl_post_language'] ) ? $_POST['icl_post_language'] : $default_lang;

				if ( $current_lang != $default_lang ) {
					$template_name = $template_name . '_' . $current_lang;
				}
			}

			set_transient( 'bf_pwt_' . $template_name, $page->ID, 60*60*24*7 );
		}
	}

	return $post_id;
}
add_action( 'save_post', 'blackfyre_recreate_page_template_transients', 99, 1 );



/**
 * Returns first matched page that uses specified template.
 *
 * @since Blackfyre 1.4
 *
 * @param string $template_name The name of template to look for.
 * @param bool $force_default_language Weather to retrieve the page in default language. If false - returns page in current language.
 * @return object Page object
 */
function blackfyre_get_page_by_template( $template_name = '', $force_default_language = false ) {
	if ( $template_name == 'default' )
		return;

	$page = false;

	$is_wpml            = function_exists( 'icl_object_id' ) ? true : false;
	$default_lang       = false;
	$current_lang       = false;
	$orig_template_name = $template_name;

	if ( $is_wpml && ! $force_default_language ) {
		global $sitepress;

		$langs        = icl_get_languages( 'skip_missing=N' );
		$default_lang = $sitepress->get_default_language();
		$current_lang = $sitepress->get_current_language();

		if ( $default_lang != $current_lang ) {
			$template_name = $template_name . '_' . $current_lang;
		}
	} else if ( $is_wpml && $force_default_language ) {
		global $sitepress;

		$default_lang = $sitepress->get_default_language();
		$current_lang = $sitepress->get_default_language();

		$sitepress->switch_lang( $default_lang );
	}

	$page_id = get_transient( 'bf_pwt_' . $template_name );

	if ( false === $page_id ) {
		$args = array(
			'post_status' => 'publish',
			'post_type'   => 'page'
		);

		$allpages = query_posts( $args );

		foreach( $allpages as $pagg ) {
			$template = get_post_meta( $pagg->ID, '_wp_page_template', true );
			if ( $orig_template_name . '.php' == $template ) {
				$page = $pagg;
				set_transient( 'bf_pwt_' . $template_name, $pagg->ID, 60*60*24*7 );
			}
		}
		wp_reset_query();
		if ( ! $page ) {
			$page_to_insert = blackfyre_get_required_pages_data( $orig_template_name );

			if ( $page_to_insert ) {
				if ( $is_wpml && ( $current_lang != $default_lang ) ) {
					$page_to_insert['post_name']  = $current_lang . '-' . $page_to_insert['post_name'];
					$page_to_insert['post_title'] = '[' . $current_lang . '] ' . $page_to_insert['post_title'];
				}

				$new_page_id = wp_insert_post( $page_to_insert );
				add_post_meta( $new_page_id, '_wp_page_template', $template_name . '.php' );

				if ( $is_wpml && ( $current_lang != $default_lang ) ) {
					global $sitepress, $wpdb;

					$orig_page    = blackfyre_get_page_by_template( $orig_template_name, true );
					$orig_page_id = $orig_page->ID;
					$orig_trid    = $sitepress->get_element_trid( $orig_page_id, 'post_page' );

					$wpdb->update( $wpdb->prefix . 'icl_translations', array( 'trid' => $orig_trid, 'element_type' => 'post_page', 'language_code' => $current_lang, 'source_language_code' => $default_lang ), array( 'element_id' => $new_page_id ) );
				}

				if ( $is_wpml )
					$sitepress->switch_lang( $current_lang );

				return blackfyre_get_page_by_template( $orig_template_name, $force_default_language );
			}
		}
	} else {
		$page = get_post( $page_id );

		if ( ( ! $page ) || is_null( $page ) || ( 'publish' != $page->post_status ) ) {
			delete_transient( 'bf_pwt_' . $template_name );

			if ( $is_wpml )
				$sitepress->switch_lang( $current_lang );

			return blackfyre_get_page_by_template( $orig_template_name, $force_default_language );
		}
	}

	if ( $is_wpml && $force_default_language ) {
		$sitepress->switch_lang( $current_lang );
	}

	return $page;
}



/**
 * Returns a permalink for page with specific page template.
 * A permalink for first page found with given template will be returned.
 * The URL will be escaped before returning.
 *
 * @since Blackfyre 1.4
 *
 * @param string $template_name The name of template to look for.
 * @return string Escaped permalink for page with given template.
 */
function blackfyre_get_permalink_for_template( $template_name = false ) {
	if ( ! $template_name ) {
		return false;
	}

	$page = blackfyre_get_page_by_template( $template_name );

	if ( ! $page ) {
		return false;
	} else {
		$page_id = $page->ID;

		$page_permalink = get_permalink( $page_id );

		return esc_url( $page_permalink );
	}
}

?>