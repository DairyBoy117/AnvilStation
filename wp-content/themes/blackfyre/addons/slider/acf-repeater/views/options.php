<?php

// vars
$key = $field['name'];


// validate
if( !$field['row_min'] )
{
	$field['row_min'] = '';
}

if( !$field['row_limit'] )
{
	$field['row_limit'] = '';
}


// add clone
$field['sub_fields'][] = apply_filters('acf/load_field_defaults',  array(
	'key'	=> 'field_clone',
	'label'	=> esc_html__("New Field",'blackfyre'),
	'name'	=> esc_html__("new_field",'blackfyre'),
	'type'	=> 'text',
));


// get name of all fields for use in field type drop down
$fields_names = apply_filters('acf/registered_fields', array());
unset( $fields_names[ esc_html__("Layout",'blackfyre') ]['tab'] );


// conditional logic dummy data
$conditional_logic_rule = array(
	'field' => '',
	'operator' => '==',
	'value' => ''
);


?>
<tr class="field_option field_option_<?php echo esc_attr($this->name); ?> field_option_<?php echo esc_attr($this->name); ?>_fields">
	<td class="label">
		<label><?php esc_html_e("Repeater Fields",'blackfyre'); ?></label>
	</td>
	<td>
	<div class="repeater">
		<div class="fields_header">
			<table class="acf widefat">
				<thead>
					<tr>
						<th class="field_order"><?php esc_html_e('Field Order','blackfyre'); ?></th>
						<th class="field_label"><?php esc_html_e('Field Label','blackfyre'); ?></th>
						<th class="field_name"><?php esc_html_e('Field Name','blackfyre'); ?></th>
						<th class="field_type"><?php esc_html_e('Field Type','blackfyre'); ?></th>
					</tr>
				</thead>
			</table>
		</div>
		<div class="fields">

			<div class="no_fields_message" <?php if(count($field['sub_fields']) > 1){ echo 'style="display:none;"'; } ?>>
				<?php esc_html_e("No fields. Click the \"+ Add Sub Field button\" to create your first field.",'blackfyre'); ?>
			</div>

			<?php foreach($field['sub_fields'] as $sub_field):

				$fake_name =  $key . '][sub_fields][' . $sub_field['key'];

				?>
				<div class="field field_type-<?php echo esc_attr($sub_field['type']); ?> field_key-<?php echo esc_attr($sub_field['key']); ?> sub_field" data-type="<?php echo esc_attr($sub_field['type']); ?>" data-id="<?php echo esc_attr($sub_field['key']); ?>">
					<input type="hidden" class="input-field_key" name="fields[<?php echo esc_attr($fake_name); ?>][key]" value="<?php echo esc_attr($sub_field['key']); ?>" />
					<div class="field_meta">
					<table class="acf widefat">
						<tr>
							<td class="field_order"><span class="circle"><?php echo (int)$sub_field['order_no'] + 1; ?></span></td>
							<td class="field_label">
								<strong>
									<a class="acf_edit_field" title="<?php esc_html_e("Edit this Field",'blackfyre'); ?>" href="javascript:;"><?php echo esc_attr($sub_field['label']); ?></a>
								</strong>
								<div class="row_options">
									<span><a class="acf_edit_field" title="<?php esc_html_e("Edit this Field",'blackfyre'); ?>" href="javascript:;"><?php esc_html_e("Edit",'blackfyre'); ?></a> | </span>
									<span><a title="<?php esc_html_e("Read documentation for this field",'blackfyre'); ?>" href="http://www.advancedcustomfields.com/docs/field-types/" target="_blank"><?php esc_html_e("Docs",'blackfyre'); ?></a> | </span>
									<span><a class="acf_duplicate_field" title="<?php esc_html_e("Duplicate this Field",'blackfyre'); ?>" href="javascript:;"><?php esc_html_e("Duplicate",'blackfyre'); ?></a> | </span>
									<span><a class="acf_delete_field" title="<?php esc_html_e("Delete this Field",'blackfyre'); ?>" href="javascript:;"><?php esc_html_e("Delete",'blackfyre'); ?></a>
								</div>
							</td>
							<td class="field_name"><?php echo esc_attr($sub_field['name']); ?></td>
							<td class="field_type"><?php echo esc_attr($sub_field['type']); ?></td>
						</tr>
					</table>
					</div>

					<div class="field_form_mask">
					<div class="field_form">

						<table class="acf_input widefat">
							<tbody>
								<tr class="field_label">
									<td class="label">
										<label><?php esc_html_e("Field Label",'blackfyre'); ?> <span class="required">*</span></label>
										<p class="description"><?php esc_html_e("This is the name which will appear on the edit page",'blackfyre'); ?></p>
									</td>
									<td>
										<?php
										do_action('acf/create_field', array(
											'type'	=>	'text',
											'name'	=>	'fields[' . $fake_name . '][label]',
											'value'	=>	$sub_field['label'],
											'class'	=>	'label',
										));
										?>
									</td>
								</tr>
								<tr class="field_name">
									<td class="label">
										<label><?php esc_html_e("Field Name",'blackfyre'); ?> <span class="required">*</span></label>
										<p class="description"><?php esc_html_e("Single word, no spaces. Underscores and dashes allowed",'blackfyre'); ?></p>
									</td>
									<td>
										<?php
										do_action('acf/create_field', array(
											'type'	=>	'text',
											'name'	=>	'fields[' . $fake_name . '][name]',
											'value'	=>	$sub_field['name'],
											'class'	=>	'name',
										));
										?>
									</td>
								</tr>
								<tr class="field_type">
									<td class="label"><label><?php esc_html_e("Field Type",'blackfyre'); ?> <span class="required">*</span></label></td>
									<td>
										<?php
										do_action('acf/create_field', array(
											'type'	=>	'select',
											'name'	=>	'fields[' . $fake_name . '][type]',
											'value'	=>	$sub_field['type'],
											'class'	=>	'type',
											'choices'	=>	$fields_names,
											'optgroup' 	=> 	true
										));
										?>
									</td>
								</tr>
								<tr class="field_instructions">
									<td class="label"><label><?php esc_html_e("Field Instructions",'blackfyre'); ?></label></td>
									<td>
										<?php

										if( !isset($sub_field['instructions']) )
										{
											$sub_field['instructions'] = "";
										}

										do_action('acf/create_field', array(
											'type'	=>	'text',
											'name'	=>	'fields[' . $fake_name . '][instructions]',
											'value'	=>	$sub_field['instructions'],
											'class'	=>	'instructions',
										));
										?>
									</td>
								</tr>
								<tr class="required">
									<td class="label"><label><?php esc_html_e("Required?",'blackfyre'); ?></label></td>
									<td>
										<?php
										do_action('acf/create_field', array(
											'type'	=>	'radio',
											'name'	=>	'fields[' .$fake_name . '][required]',
											'value'	=>	$sub_field['required'],
											'choices'	=>	array(
												1	=>	esc_html__("Yes",'blackfyre'),
												0	=>	esc_html__("No",'blackfyre'),
											),
											'layout'	=>	'horizontal',
										));
										?>
									</td>
								</tr>
								<tr class="field_column_width">
									<td class="label">
										<label><?php esc_html_e("Column Width",'blackfyre'); ?></label>
									</td>
									<td>
										<?php

										if( !isset($sub_field['column_width']) )
										{
											$sub_field['column_width'] = "";
										}

										do_action('acf/create_field', array(
											'type'		=>	'number',
											'name'		=>	'fields[' . $fake_name . '][column_width]',
											'value'		=>	$sub_field['column_width'],
											'class'		=>	'column_width',
											'append'	=>	'%'
										));
										?>
									</td>
								</tr>
								<?php

								$sub_field['name'] = $fake_name;
								do_action('acf/create_field_options', $sub_field );

								?>
								<tr class="conditional-logic" data-field_name="<?php echo esc_attr($field['key']); ?>">
									<td class="label"><label><?php esc_html_e("Conditional Logic",'blackfyre'); ?></label></td>
									<td>
										<?php
										do_action('acf/create_field', array(
											'type'	=>	'radio',
											'name'	=>	'fields[' . $fake_name . '][conditional_logic][status]',
											'value'	=>	$sub_field['conditional_logic']['status'],
											'choices'	=>	array(
												1	=>	esc_html__("Yes",'blackfyre'),
												0	=>	esc_html__("No",'blackfyre'),
											),
											'layout'	=>	'horizontal',
										));


										// no rules?
										if( ! $sub_field['conditional_logic']['rules'] )
										{
											$sub_field['conditional_logic']['rules'] = array(
												array() // this will get merged with $conditional_logic_rule
											);
										}

										?>
										<div class="contional-logic-rules-wrapper" <?php if( ! $sub_field['conditional_logic']['status'] ) echo 'style="display:none"'; ?>>
											<table class="conditional-logic-rules widefat acf-rules <?php if( count($sub_field['conditional_logic']['rules']) == 1) echo 'remove-disabled'; ?>">
												<tbody>
												<?php foreach( $sub_field['conditional_logic']['rules'] as $rule_i => $rule ):

													// validate
													$rule = array_merge($conditional_logic_rule, $rule);


													// fix PHP error in 3.5.4.1
													if( strpos($rule['value'],'Undefined index: value in') !== false  )
													{
														$rule['value'] = '';
													}

													?>
													<tr data-i="<?php echo esc_attr($rule_i); ?>">
														<td>
															<input class="conditional-logic-field" type="hidden" name="fields[<?php echo esc_attr($fake_name); ?>][conditional_logic][rules][<?php echo esc_attr($rule_i); ?>][field]" value="<?php echo esc_attr($rule['field']); ?>" />
														</td>
														<td width="25%">
															<?php
															do_action('acf/create_field', array(
																'type'	=>	'select',
																'name'	=>	'fields[' . $fake_name . '][conditional_logic][rules][' . $rule_i . '][operator]',
																'value'	=>	$rule['operator'],
																'choices'	=>	array(
																	'=='	=>	esc_html__("is equal to",'blackfyre'),
																	'!='	=>	esc_html__("is not equal to",'blackfyre'),
																),
															));
															?>
														</td>
														<td><input class="conditional-logic-value" type="hidden" name="fields[<?php echo esc_attr($fake_name); ?>][conditional_logic][rules][<?php echo esc_attr($rule_i); ?>][value]" value="<?php echo esc_attr($rule['value']); ?>" /></td>
														<td class="buttons">
															<ul class="hl clearfix">
																<li><a class="acf-button-remove" href="javascript:;"></a></li>
																<li><a class="acf-button-add" href="javascript:;"></a></li>
															</ul>
														</td>
													</tr>
												<?php endforeach; ?>
												</tbody>
											</table>

											<ul class="hl clearfix">
												<li style="padding:4px 4px 0 0;"><?php esc_html_e("Show this field when",'blackfyre'); ?></li>
												<li><?php do_action('acf/create_field', array(
														'type'	=>	'select',
														'name'	=>	'fields[' . $fake_name . '][conditional_logic][allorany]',
														'value'	=>	$sub_field['conditional_logic']['allorany'],
														'choices' => array(
															'all'	=>	esc_html__("all",'blackfyre'),
															'any'	=>	esc_html__("any",'blackfyre'),
														),
												)); ?></li>
												<li style="padding:4px 0 0 4px;"><?php esc_html_e("these rules are met",'blackfyre'); ?></li>
											</ul>

										</div>

									</td>
								</tr>
								<tr class="field_save">
									<td class="label">
										<!-- <label><?php esc_html_e("Save Field",'blackfyre'); ?></label> -->
									</td>
									<td>
										<ul class="hl clearfix">
											<li>
												<a class="acf_edit_field acf-button grey" title="<?php esc_html_e("Close Field",'blackfyre'); ?>" href="javascript:;"><?php esc_html_e("Close Sub Field",'blackfyre'); ?></a>
											</li>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>

					</div><!-- End Form -->
					</div><!-- End Form Mask -->

				</div>
			<?php endforeach; ?>
		</div>
		<div class="table_footer">
			<div class="order_message"><?php esc_html_e('Drag and drop to reorder','blackfyre'); ?></div>
			<a href="javascript:;" id="add_field" class="acf-button"><?php esc_html_e('+ Add Sub Field','blackfyre'); ?></a>
		</div>
	</div>
	</td>
</tr>
<tr class="field_option field_option_<?php echo esc_attr($this->name); ?>">
	<td class="label">
		<label><?php esc_html_e("Minimum Rows",'blackfyre'); ?></label>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields['.$key.'][row_min]',
			'value'	=>	$field['row_min'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo esc_attr($this->name); ?>">
	<td class="label">
		<label><?php esc_html_e("Maximum Rows",'blackfyre'); ?></label>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields['.$key.'][row_limit]',
			'value'	=>	$field['row_limit'],
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo esc_attr($this->name); ?> field_option_<?php echo esc_attr($this->name); ?>_layout">
	<td class="label">
		<label><?php esc_html_e("Layout",'blackfyre'); ?></label>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'	=>	'radio',
			'name'	=>	'fields['.$key.'][layout]',
			'value'	=>	$field['layout'],
			'layout'	=>	'horizontal',
			'choices'	=>	array(
				'table'	=>	esc_html__("Table",'blackfyre'),
				'row'	=>	esc_html__("Row",'blackfyre')
			)
		));
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo esc_attr($this->name); ?>">
	<td class="label">
		<label><?php esc_html_e("Button Label",'blackfyre'); ?></label>
	</td>
	<td>
		<?php
		do_action('acf/create_field', array(
			'type'	=>	'text',
			'name'	=>	'fields['.$key.'][button_label]',
			'value'	=>	$field['button_label'],
		));
		?>
	</td>
</tr>
