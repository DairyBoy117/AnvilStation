<?php

/*
*  Meta box - locations
*
*  This template file is used when editing a field group and creates the interface for editing location rules.
*
*  @type	template
*  @date	23/06/12
*/


// global
global $post;


// vars
$groups = apply_filters('acf/field_group/get_location', array(), $post->ID);


// at lease 1 location rule
if( empty($groups) )
{
	$groups = array(

		// group_0
		array(

			// rule_0
			array(
				'param'		=>	'post_type',
				'operator'	=>	'==',
				'value'		=>	'post',
				'order_no'	=>	0,
				'group_no'	=>	0
			)
		)

	);
}


?>
<table class="acf_input widefat" id="acf_location">
	<tbody>
	<tr>
		<td class="label">
			<label for="post_type"><?php esc_html_e("Rules",'blackfyre'); ?></label>
			<p class="description"><?php esc_html_e("Create a set of rules to determine which edit screens will use these advanced custom fields",'blackfyre'); ?></p>
		</td>
		<td>
			<div class="location-groups">

<?php if( is_array($groups) ): ?>
	<?php foreach( $groups as $group_id => $group ):
		$group_id = 'group_' . $group_id;
		?>
		<div class="location-group" data-id="<?php echo esc_attr($group_id); ?>">
			<?php if( $group_id == 'group_0' ): ?>
				<h4><?php esc_html_e("Show this field group if",'blackfyre'); ?></h4>
			<?php else: ?>
				<h4><?php esc_html_e("or",'blackfyre'); ?></h4>
			<?php endif; ?>
			<?php if( is_array($group) ): ?>
			<table class="acf_input widefat">
				<tbody>
					<?php foreach( $group as $rule_id => $rule ):
						$rule_id = 'rule_' . $rule_id;
					?>
					<tr data-id="<?php echo esc_attr($rule_id); ?>">
					<td class="param"><?php

						$choices = array(
							esc_html__("Basic",'blackfyre') => array(
								'post_type'		=>	esc_html__("Post Type",'blackfyre'),
								'user_type'		=>	esc_html__("Logged in User Type",'blackfyre'),
							),
							esc_html__("Post",'blackfyre') => array(
								'post'			=>	esc_html__("Post",'blackfyre'),
								'post_category'	=>	esc_html__("Post Category",'blackfyre'),
								'post_format'	=>	esc_html__("Post Format",'blackfyre'),
								'post_status'	=>	esc_html__("Post Status",'blackfyre'),
								'taxonomy'		=>	esc_html__("Post Taxonomy",'blackfyre'),
							),
							esc_html__("Page",'blackfyre') => array(
								'page'			=>	esc_html__("Page",'blackfyre'),
								'page_type'		=>	esc_html__("Page Type",'blackfyre'),
								'page_parent'	=>	esc_html__("Page Parent",'blackfyre'),
								'page_template'	=>	esc_html__("Page Template",'blackfyre'),
							),
							esc_html__("Other",'blackfyre') => array(
								'ef_media'		=>	esc_html__("Attachment",'blackfyre'),
								'ef_taxonomy'	=>	esc_html__("Taxonomy Term",'blackfyre'),
								'ef_user'		=>	esc_html__("User",'blackfyre'),
							)
						);


						// allow custom location rules
						$choices = apply_filters( 'acf/location/rule_types', $choices );


						// create field
						$args = array(
							'type'	=>	'select',
							'name'	=>	'location[' . $group_id . '][' . $rule_id . '][param]',
							'value'	=>	$rule['param'],
							'choices' => $choices,
						);

						do_action('acf/create_field', $args);

					?></td>
					<td class="operator"><?php

						$choices = array(
							'=='	=>	esc_html__("is equal to",'blackfyre'),
							'!='	=>	esc_html__("is not equal to",'blackfyre'),
						);


						// allow custom location rules
						$choices = apply_filters( 'acf/location/rule_operators', $choices );


						// create field
						do_action('acf/create_field', array(
							'type'	=>	'select',
							'name'	=>	'location[' . $group_id . '][' . $rule_id . '][operator]',
							'value'	=>	$rule['operator'],
							'choices' => $choices
						));

					?></td>
					<td class="value"><?php

						$this->ajax_render_location(array(
							'group_id' => $group_id,
							'rule_id' => $rule_id,
							'value' => $rule['value'],
							'param' => $rule['param'],
						));

					?></td>
					<td class="add">
						<a href="#" class="location-add-rule button"><?php esc_html_e("and",'blackfyre'); ?></a>
					</td>
					<td class="remove">
						<a href="#" class="location-remove-rule acf-button-remove"></a>
					</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>

	<h4><?php esc_html_e("or",'blackfyre'); ?></h4>

	<a class="button location-add-group" href="#"><?php esc_html_e("Add rule group",'blackfyre'); ?></a>

<?php endif; ?>

			</div>
		</td>
	</tr>
	</tbody>
</table>