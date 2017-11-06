<?php

/*
*  Meta box - options
*
*  This template file is used when editing a field group and creates the interface for editing options.
*
*  @type	template
*  @date	23/06/12
*/


// global
global $post;

	
// vars
$options = apply_filters('acf/field_group/get_options', array(), $post->ID);
	

?>
<table class="acf_input widefat" id="acf_options">
	<tr>
		<td class="label">
			<label for=""><?php esc_html_e("Order No.",'blackfyre'); ?></label>
			<p class="description"><?php esc_html_e("Field groups are created in order <br />from lowest to highest",'blackfyre'); ?></p>
		</td>
		<td>
			<?php 
			
			do_action('acf/create_field', array(
				'type'	=>	'number',
				'name'	=>	'menu_order',
				'value'	=>	$post->menu_order,
			));
			
			?>
		</td>
	</tr>
	<tr>
		<td class="label">
			<label for=""><?php esc_html_e("Position",'blackfyre'); ?></label>
		</td>
		<td>
			<?php 
			
			do_action('acf/create_field', array(
				'type'	=>	'select',
				'name'	=>	'options[position]',
				'value'	=>	$options['position'],
				'choices' => array(
					'acf_after_title'	=>	esc_html__("High (after title)",'blackfyre'),
					'normal'			=>	esc_html__("Normal (after content)",'blackfyre'),
					'side'				=>	esc_html__("Side",'blackfyre'),
				),
				'default_value' => 'normal'
			));

			?>
		</td>
	</tr>
	<tr>
		<td class="label">
			<label for="post_type"><?php esc_html_e("Style",'blackfyre'); ?></label>
		</td>
		<td>
			<?php 
			
			do_action('acf/create_field', array(
				'type'	=>	'select',
				'name'	=>	'options[layout]',
				'value'	=>	$options['layout'],
				'choices' => array(
					'no_box'			=>	esc_html__("Seamless (no metabox)",'blackfyre'),
					'default'			=>	esc_html__("Standard (WP metabox)",'blackfyre'),
				)
			));
			
			?>
		</td>
	</tr>
	<tr id="hide-on-screen">
		<td class="label">
			<label for="post_type"><?php esc_html_e("Hide on screen",'blackfyre'); ?></label>
			<p class="description"><?php esc_html_e("<b>Select</b> items to <b>hide</b> them from the edit screen",'blackfyre'); ?></p>
			<p class="description"><?php esc_html_e("If multiple field groups appear on an edit screen, the first field group's options will be used. (the one with the lowest order number)",'blackfyre'); ?></p>
		</td>
		<td>
			<?php 
			
			do_action('acf/create_field', array(
				'type'	=>	'checkbox',
				'name'	=>	'options[hide_on_screen]',
				'value'	=>	$options['hide_on_screen'],
				'choices' => array(
					'permalink'			=>	esc_html__("Permalink", 'blackfyre'),
					'the_content'		=>	esc_html__("Content Editor",'blackfyre'),
					'excerpt'			=>	esc_html__("Excerpt", 'blackfyre'),
					'custom_fields'		=>	esc_html__("Custom Fields", 'blackfyre'),
					'discussion'		=>	esc_html__("Discussion", 'blackfyre'),
					'comments'			=>	esc_html__("Comments", 'blackfyre'),
					'revisions'			=>	esc_html__("Revisions", 'blackfyre'),
					'slug'				=>	esc_html__("Slug", 'blackfyre'),
					'author'			=>	esc_html__("Author", 'blackfyre'),
					'format'			=>	esc_html__("Format", 'blackfyre'),
					'featured_image'	=>	esc_html__("Featured Image", 'blackfyre'),
					'categories'		=>	esc_html__("Categories", 'blackfyre'),
					'tags'				=>	esc_html__("Tags", 'blackfyre'),
					'send-trackbacks'	=>	esc_html__("Send Trackbacks", 'blackfyre'),
				)
			));
			
			?>
		</td>
	</tr>
</table>