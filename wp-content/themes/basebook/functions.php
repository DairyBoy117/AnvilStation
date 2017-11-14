<?php

	function anvil_scripts() {
	    wp_register_script( 'custom_scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), '1.0.0', true );
	    wp_enqueue_script('custom_scripts');
	}
	add_action( 'init', 'anvil_scripts' );

?>