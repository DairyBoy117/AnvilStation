<?php
 /*
 * Template Name: Login Template
 */
?>
<?php

if(get_option( 'users_can_register' ) == '0'){wp_redirect( home_url());}
?>
<?php get_header(); ?>

<?php if (has_post_thumbnail()) : $custombck = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); endif; ?>
<?php if(empty($custombck)){}else{ ?>
<style>

</style>
<?php } ?>

<?php
$counterz = 0;

global $noviuser, $error_msg, $wpdb;
$noviuser = '';
$error_msg = '';
if(isset($_POST['wp-submit']))$submit = $_POST['wp-submit'];
if(isset($_POST['user_login']))$user_id = $_POST['user_login'];
if(isset($_POST['user_email']))$user_email = $_POST['user_email'];
if(isset($_POST['user-password']))$userpassword = $_POST['user-password'];
if(isset($_POST['usercountry_id']))$user_country = $_POST['usercountry_id'];
if(isset($_POST['user_city']))$user_city = $_POST['user_city'];
if(isset($_POST['agree']))$term_agree = $_POST['agree'];
if(isset($_POST['premium']))$premium = $_POST['premium'];
if(isset($_POST['custom_fields']))$_POST['custom_fields'][1] = $_POST['user_login'];

//if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'blackfyre_new_user' ) )
  //  die( 'something went wrong, please try again later.' );
$custom_profile_fields = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_fields');

if(isset($submit)) {


	 $error_msg == "";

	if($term_agree == '') {
		$error_msg .= '<p>'.esc_html__("You must agree with terms and conditions. ",'blackfyre').'</p>';
    	}
	if($user_id == '') {
		$error_msg .= '<p>'.esc_html__("Please enter username. ",'blackfyre').'</p>';

	}
	if($user_email == '') {
		$error_msg .= '<p>'.esc_html__("Please enter email. ",'blackfyre').'</p>';

	}
    if( !is_email( $user_email ) ) {
        $error_msg .= '<p>'.esc_html__("Please enter valid email. ", 'blackfyre' ).'</p>';
    }

	if($userpassword == '') {
		$error_msg .= '<p>'.esc_html__("Please enter password. ",'blackfyre').'</p>';
	}


	$posted_customs = $_POST['custom_fields'];
	$additional_error =false;
	$counter = 0;
	if (isset($_POST['custom_fields'])) {
		foreach ($custom_profile_fields as $thefield) {
			if ($thefield->is_required == 1) {
				$therequiredfields[$counter] = $thefield->id;
				$counter ++;
			}
		}
	}
	if (is_array($therequiredfields)) {

		foreach ($therequiredfields as $findfield) {
			if (!isset($posted_customs[$findfield])) {
				$additional_error = true;
				$error_msg .= '<p>'.esc_html__("Please fill out all required fields. ",'blackfyre').'</p>';
			} else {
				if ((!(is_array($posted_customs[$findfield]))) AND (!(is_string($posted_customs[$findfield])))) {
					$additional_error = true;
					$error_msg .= '<p>'.esc_html__("Please fill out all required fields. ",'blackfyre').'</p>';
				} elseif(is_array($posted_customs[$findfield])) {
					if (!(count($posted_customs[$findfield]) > 0)) {
						$additional_error = true;
						$error_msg .= '<p>'.esc_html__("Please fill out all required fields. ",'blackfyre').'</p>';
					}
				} elseif (is_string($posted_customs[$findfield])) {
					if (!(strlen($posted_customs[$findfield]) > 0)) {
						$additional_error = true;
						$error_msg .= '<p>'.esc_html__("Please fill out all required fields. ",'blackfyre').'</p>';
					}
				}
			}
		}
	}





	if($user_id != '' & $user_email != '' & $term_agree != '' & (is_email( $user_email ) !== false ) & $userpassword != '' & ($additional_error == false)) {
        $noviuser = 'sub';
		global $wpdp, $post;
        $getuser_login = get_user_by( 'login', $user_id );
		if(!empty($getuser_login)) {
	 		$error_msg .= '<p>'.esc_html__("Username ",'blackfyre'). $getuser_login->user_login . esc_html__(" is already in use. ",'blackfyre').'</p>';
		}
		$getuser_email = get_user_by( 'email', $user_email );
		if(!empty($getuser_email)) {
	 		$error_msg .= '<p>'.esc_html__("Email ",'blackfyre'). $user_email. esc_html__(" is already in use. ","blackfyre").'</p>';
		}

		if (empty($getuser_login) & empty($getuser_email) ) {
			$userdata = array(
			'user_login' => $user_id,
			'user_pass'  => $userpassword,
			'user_email' => $user_email
			);
			$new_user_id = wp_insert_user( $userdata );
			wp_new_user_notification($new_user_id);
			$hash = md5( $random_number );
			add_user_meta( $new_user_id, 'hash', $hash );
			add_user_meta( $new_user_id, 'active', 'false' );
			$subject = esc_html__('From ','blackfyre').get_bloginfo();
			$message = esc_html__("Username:",'blackfyre')." $user_id \n\n". esc_html__("Password: ",'blackfyre'). "$userpassword";
			$message .= "\n\n";
			$message .= esc_html__('Please click this link to activate your account: ','blackfyre');
			$message .= esc_url(blackfyre_get_permalink_for_template('page-user-activation')).'?id='.$new_user_id.'&key='.$hash;
			$headers = 'From: '.get_bloginfo().' <'.get_option("admin_email").'>' . "\r\n" . 'Reply-To: ' . $user_email;
			wp_mail( $user_email, $subject, $message, $headers );

			if(!empty($user_country))
				update_user_meta($new_user_id, 'usercountry_id', esc_attr($user_country));
			if (!empty($user_city))
				update_user_meta($new_user_id, 'city', esc_attr($user_city));
			if( is_wp_error($new_user_id) ) {
				$error_msg .= $user_id->get_error_message();
			}

			//tusi2
			global $wpdb;

			if (isset($posted_customs) AND (is_array($posted_customs))) {
				foreach ($posted_customs as $akey => $acustom) {
					$custom_profile_fields = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_fields');
					$holdfield = '';
					foreach ($custom_profile_fields as $thefield) {
						if ($thefield->id == $akey) {
							$holdfield = $thefield;
						}
					}
					if (($holdfield->type == "textbox") OR ($holdfield->type == 'datebox') OR ($holdfield->type == "number") OR ($holdfield->type == "url") OR ($holdfield->type == "textarea")) {
						$preppedvalue = $acustom;
					} elseif(($holdfield->type == "checkbox")) {
						$counter = 0;
						unset($preppedvalue);
						foreach ($acustom as $tehkey1 => $holdthecustom1) {
							foreach ($custom_profile_fields as $thefield1) {
								if ($thefield1->id == $tehkey1) {
									$preppedvalue[$counter] = $thefield1->name;
									$counter ++;
								}
							}
						}
					}elseif(($holdfield->type == "multiselectbox")) {
						$counter = 0;
						unset($preppedvalue);
						foreach ($acustom as $tehkey => $holdthecustom) {
							foreach ($custom_profile_fields as $thefield) {
								if ($thefield->id == $tehkey) {
									$preppedvalue[$counter] = $thefield1->name;
									$counter ++;
								}
							}
						}

					} elseif(($holdfield->type == "radio")) {
						//($holdfield->type == "selectbox") OR
						foreach ($custom_profile_fields as $thefield) {
							if ($thefield->id == $acustom) {
								$preppedvalue = $thefield->name;
							}
						}

					}elseif(($holdfield->type == "selectbox")) {
						//($holdfield->type == "selectbox") OR
						foreach ($custom_profile_fields as $thefield) {
							if ($thefield->id == $acustom) {
								$preppedvalue = $thefield->name;
							}
						}
					}

					if (is_array($preppedvalue)) {
						$theholder = serialize($preppedvalue);
					} else {
						$theholder = $preppedvalue;
					}

					$wpdb->insert(
						$wpdb->prefix."bp_xprofile_data",
						array(
							'field_id' => $akey,
							'user_id' => $new_user_id,
							'value' =>  $theholder,
							'last_updated' => time()
						),
						array(
							'%d',
							'%d',
							'%s',
							'%s',
						)
					);


				}
			}
			if(isset($premium) && $premium=='1') {

				$premium_url = of_get_option('premium_url');
				wp_redirect($premium_url);
			} else {  }
		}
	}
}

?>

<div class="registration-login">
  <div class="container page normal-page">


		<div class="col-lg-7 col-md-12 register-form-wrapper wcontainer">
        <?php if(isset($noviuser) && $noviuser == 'sub' && empty($error_msg)){ ?>
            <i class="fa fa-info-circle"></i>
            <?php esc_html_e(" Registration successful. Activation email has been sent!", "blackfyre"); } else{ ?>

						<div class="title-wrapper">
							<h3 class="widget-title">
							<?php
							if(of_get_option('cpagetitle')){
								echo of_get_option('cpagetitle');
							}else{
						 	esc_html_e("JOIN BLACKFYRE TODAY FOR free!", 'blackfyre');
							} ?>
							</h3>
							<div class="clear"></div>
						</div>


                        <?php if(!empty($error_msg)) {  ?><div class="error_msg"><span><?php
                        $allowed_tags = array(
							'p' => array(),
							);
                             echo wp_kses($error_msg, $allowed_tags ); ?></span></div><?php } ?>
							<form method="post">
								<p>
									<label><?php esc_html_e("Username:", 'blackfyre'); ?></label>
									<span class="cust_input">
									<input type="text" name="user_login" id="user_login" class="input" size="20" tabindex="10" value="<?php if(isset($_POST['user_login'])){echo esc_attr($_POST['user_login']); } ?>" />
									</span>
								</p>
								<p>
									<label><?php esc_html_e("Email:", 'blackfyre'); ?></label>
									<span class="cust_input">
									<input type="text" name="user_email" id="user_email" class="input" size="25" tabindex="20" value="<?php if(isset($_POST['user_email'])){echo esc_attr($_POST['user_email']); } ?>"  />
									</span>
								</p>
								<p>
									<label><?php esc_html_e("Password:", 'blackfyre'); ?></label>
									<span class="cust_input">
									<input type="password" name="user-password" id="user-password" class="input" size="25" tabindex="30" />
									</span>
								</p>
								<p>

									<label for="usercountry_id"><?php esc_html_e('Country:', 'blackfyre'); ?></label>
                                    <?php
									$countries = blackfyre_registration_country_list()
									?>
									<span class="cust_input">
									<select name="usercountry_id">
										<option value="0"><?php esc_html_e('- Select -','blackfyre') ?></option>
										<?php
                                        foreach ($countries as $country) {
                                            $selected="";
                                            if ($_POST['usercountry_id']==$country->id_country) { $selected="selected";}

											if($country->name == 'Afghanistan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Afghanistan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Albania'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Albania', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Algeria'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Algeria', 'blackfyre' ).'</option>';
										}elseif($country->name == 'American Samoa'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'American Samoa', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Andorra'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Andorra', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Angola'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Angola', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Anguilla'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Anguilla', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Antarctica'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Antarctica', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Antigua and Barbuda'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Antigua and Barbuda', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Argentina'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Argentina', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Armenia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Armenia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Aruba'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Aruba', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Australia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Australia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Austria'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Austria', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Azerbaijan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Azerbaijan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bahamas'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bahamas', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bahrain'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bahrain', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bangladesh'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bangladesh', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Barbados'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Barbados', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Belarus'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Belarus', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Belgium'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Belgium', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Belize'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Belize', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Benin'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Benin', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bermuda'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bermuda', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bhutan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bhutan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bolivia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bolivia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bosnia and Herzegowina'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bosnia and Herzegowina', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Botswana'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Botswana', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bouvet Island'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bouvet Island', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Brazil'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Brazil', 'blackfyre' ).'</option>';
										}elseif($country->name == 'British Indian Ocean Territory'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'British Indian Ocean Territory', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Brunei Darussalam'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Brunei Darussalam', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Bulgaria'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Bulgaria', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Burkina Faso'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Burkina Faso', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Burundi'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Burundi', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cambodia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cambodia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cameroon'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cameroon', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Canada'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Canada', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cape Verde'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cape Verde', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cayman Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cayman Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Central African Republic'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Central African Republic', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Chad'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Chad', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Chile'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Chile', 'blackfyre' ).'</option>';
										}elseif($country->name == 'China'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'China', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Christmas Island'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Christmas Island', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cocos (Keeling) Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cocos (Keeling) Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Colombia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Colombia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Comoros'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Comoros', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Congo'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Congo', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cook Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cook Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Costa Rica'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Costa Rica', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cote D\'Ivoire'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cote D\'Ivoire', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Croatia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Croatia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cuba'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cuba', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Cyprus'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Cyprus', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Czech Republic'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Czech Republic', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Denmark'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Denmark', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Djibouti'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Djibouti', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Dominica'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Dominica', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Dominican Republic'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Dominican Republic', 'blackfyre' ).'</option>';
										}elseif($country->name == 'East Timor'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'East Timor', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Ecuador'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Ecuador', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Egypt'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Egypt', 'blackfyre' ).'</option>';
										}elseif($country->name == 'El Salvador'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'El Salvador', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Equatorial Guinea'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Equatorial Guinea', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Eritrea'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Eritrea', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Estonia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Estonia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Ethiopia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Ethiopia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Falkland Islands (Malvinas)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Falkland Islands (Malvinas)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Faroe Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Faroe Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Fiji'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Fiji', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Finland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Finland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'France'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'France', 'blackfyre' ).'</option>';
										}elseif($country->name == 'France, Metropolitan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'France, Metropolitan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'French Guiana'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'French Guiana', 'blackfyre' ).'</option>';
										}elseif($country->name == 'French Polynesia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'French Polynesia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'French Southern Territories'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'French Southern Territories', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Gabon'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Gabon', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Gambia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Gambia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Georgia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Georgia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Germany'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Germany', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Ghana'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Ghana', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Gibraltar'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Gibraltar', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Greece'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Greece', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Greenland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Greenland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Grenada'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Grenada', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guadeloupe'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guadeloupe', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guam'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guam', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guatemala'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guatemala', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guinea'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guinea', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guinea-bissau'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guinea-bissau', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Guyana'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Guyana', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Haiti'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Haiti', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Heard and Mc Donald Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Heard and Mc Donald Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Honduras'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Honduras', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Hong Kong'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Hong Kong', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Hungary'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Hungary', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Iceland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Iceland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'India'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'India', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Indonesia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Indonesia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Iran (Islamic Republic of)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Iran (Islamic Republic of)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Iraq'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Iraq', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Ireland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Ireland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Israel'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Israel', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Italy'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Italy', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Jamaica'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Jamaica', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Japan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Japan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Jordan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Jordan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Kazakhstan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Kazakhstan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Kenya'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Kenya', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Kiribati'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Kiribati', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Korea, Democratic People\'s Republic of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Korea, Democratic People\'s Republic of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Korea, Republic of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Korea, Republic of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Kuwait'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Kuwait', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Kyrgyzstan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Kyrgyzstan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Lao People\'s Democratic Republic'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Lao People\'s Democratic Republic', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Latvia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Latvia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Lebanon'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Lebanon', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Lesotho'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Lesotho', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Liberia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Liberia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Libyan Arab Jamahiriya'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Libyan Arab Jamahiriya', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Liechtenstein'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Liechtenstein', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Lithuania'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Lithuania', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Luxembourg'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Luxembourg', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Macau'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Macau', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Macedonia, The Former Yugoslav Republic of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Macedonia, The Former Yugoslav Republic of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Madagascar'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Madagascar', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Malawi'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Malawi', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Malaysia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Malaysia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Maldives'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Maldives', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mali'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mali', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Malta'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Malta', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Marshall Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Marshall Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Martinique'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Martinique', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mauritania'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mauritania', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mauritius'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mauritius', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mayotte'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mayotte', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mexico'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mexico', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Micronesia, Federated States of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Micronesia, Federated States of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Moldova, Republic of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Moldova, Republic of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Monaco'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Monaco', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mongolia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mongolia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Montserrat'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Montserrat', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Morocco'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Morocco', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Mozambique'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Mozambique', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Myanmar'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Myanmar', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Namibia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Namibia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Nauru'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Nauru', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Nepal'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Nepal', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Netherlands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Netherlands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Netherlands Antilles'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Netherlands Antilles', 'blackfyre' ).'</option>';
										}elseif($country->name == 'New Caledonia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'New Caledonia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'New Zealand'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'New Zealand', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Nicaragua'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Nicaragua', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Niger'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Niger', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Nigeria'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Nigeria', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Niue'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Niue', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Norfolk Island'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Norfolk Island', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Northern Mariana Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Northern Mariana Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Norway'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Norway', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Oman'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Oman', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Pakistan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Pakistan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Palau'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Palau', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Panama'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Panama', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Papua New Guinea'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Papua New Guinea', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Paraguay'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Paraguay', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Peru'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Peru', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Philippines'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Philippines', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Pitcairn'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Pitcairn', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Poland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Poland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Portugal'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Portugal', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Puerto Rico'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Puerto Rico', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Qatar'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Qatar', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Reunion'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Reunion', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Romania'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Romania', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Russian Federation'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Russian Federation', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Rwanda'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Rwanda', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Saint Kitts and Nevis'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Saint Kitts and Nevis', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Saint Lucia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Saint Lucia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Saint Vincent and the Grenadines'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Saint Vincent and the Grenadines', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Samoa'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Samoa', 'blackfyre' ).'</option>';
										}elseif($country->name == 'San Marino'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'San Marino', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Sao Tome and Principe'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Sao Tome and Principe', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Saudi Arabia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Saudi Arabia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Senegal'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Senegal', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Serbia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Serbia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Seychelles'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Seychelles', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Sierra Leone'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Sierra Leone', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Singapore'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Singapore', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Slovakia (Slovak Republic)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Slovakia (Slovak Republic)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Slovenia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Slovenia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Solomon Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Solomon Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Somalia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Somalia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'South Africa'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'South Africa', 'blackfyre' ).'</option>';
										}elseif($country->name == 'South Georgia and the South Sandwich Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'South Georgia and the South Sandwich Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Spain'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Spain', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Sri Lanka'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Sri Lanka', 'blackfyre' ).'</option>';
										}elseif($country->name == 'St. Helena'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'St. Helena', 'blackfyre' ).'</option>';
										}elseif($country->name == 'St. Pierre and Miquelon'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'St. Pierre and Miquelon', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Sudan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Sudan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Suriname'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Suriname', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Svalbard and Jan Mayen Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Svalbard and Jan Mayen Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Swaziland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Swaziland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Sweden'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Sweden', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Switzerland'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Switzerland', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Syrian Arab Republic'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Syrian Arab Republic', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Taiwan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Taiwan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tajikistan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tajikistan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tanzania, United Republic of'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tanzania, United Republic of', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Thailand'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Thailand', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Togo'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Togo', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tokelau'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tokelau', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tonga'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tonga', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Trinidad and Tobago'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Trinidad and Tobago', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tunisia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tunisia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Turkey'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Turkey', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Turkmenistan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Turkmenistan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Turks and Caicos Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Turks and Caicos Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Tuvalu'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Tuvalu', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Uganda'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Uganda', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Ukraine'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Ukraine', 'blackfyre' ).'</option>';
										}elseif($country->name == 'United Arab Emirates'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'United Arab Emirates', 'blackfyre' ).'</option>';
										}elseif($country->name == 'United Kingdom'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'United Kingdom', 'blackfyre' ).'</option>';
										}elseif($country->name == 'United States'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'United States', 'blackfyre' ).'</option>';
										}elseif($country->name == 'United States Minor Outlying Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'United States Minor Outlying Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Uruguay'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Uruguay', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Uzbekistan'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Uzbekistan', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Vanuatu'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Vanuatu', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Vatican City State (Holy See)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Vatican City State (Holy See)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Venezuela'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Venezuela', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Viet Nam'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Viet Nam', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Virgin Islands (British)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Virgin Islands (British)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Virgin Islands (U.S.)'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Virgin Islands (U.S.)', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Wallis and Futuna Islands'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Wallis and Futuna Islands', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Western Sahara'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Western Sahara', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Yemen'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Yemen', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Zaire'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Zaire', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Zambia'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Zambia', 'blackfyre' ).'</option>';
										}elseif($country->name == 'Zimbabwe'){
										           echo '<option '.$selected.' value='.esc_attr($country->id_country).'>'. esc_html__( 'Zimbabwe', 'blackfyre' ).'</option>';

										}
									}
                                        ?>
                                    </select>
                                    </span>
								</p>
								<p>
									<label><?php esc_html_e("City:", 'blackfyre'); ?></label>
									<span class="cust_input">
									<input type="text" name="user_city" id="user_city" class="input" size="25"  value="<?php if(isset($_POST['user_city'])){echo esc_attr($_POST['user_city']); } ?>" />
									</span>
								</p>

								<?php
								//tusi
								$required_marker= " *";
								if (is_array($custom_profile_fields)) {

                  //print_r ($custom_profile_fields);
									foreach ($custom_profile_fields as $field) {
										if($field->id == '1') continue;
										if ($field->type == "textbox") {
											if ($field->is_required == 1) {
												$additional_text = $required_marker;
											} else {
												$additional_text ="";
											}
											?>
											<p>
												<label><?php echo esc_attr($field->name); ?><?php echo esc_attr($additional_text); ?></label>
												<span class="cust_input">
												<input type="text" name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="input" size="20"  />
												</span>
											</p>
											<?php
										} elseif ($field->type == "checkbox") {
											if ($field->is_required == 1) {
												$additional_text = $required_marker;
											} else {
												$additional_text ="";
											}
											?>
											<p>
												<label><?php echo esc_attr($field->name); ?><?php echo esc_attr($additional_text); ?></label>
												<span class="cust_input">
												<?php
													foreach ($custom_profile_fields as $tempfield) {
														if ($tempfield->parent_id == $field->id) {
															echo '<input type ="checkbox" name="custom_fields['.esc_attr($field->id).']['.esc_attr($tempfield->id).']"';
															if ($tempfield->is_default_option == 1) {
																echo ' checked="yes"';
															}
															echo '>'.esc_attr($tempfield->name)."<br />";
														}
													}

												?>
												</span>
											</p>

											<?php
										}elseif ($field->type == "selectbox") {
											if ($field->is_required == 1) {
												$additional_text = $required_marker;
											} else {
												$additional_text ="";
											}
											?>
											<p>
												<label><?php echo esc_attr($field->name); ?><?php echo esc_attr($additional_text); ?></label>
												<span class="cust_input">
												<select name="<?php echo 'custom_fields['.$field->id.']'; ?>">
												<?php
													foreach ($custom_profile_fields as $tempfield) {
														if ($tempfield->parent_id == $field->id) {
															//selected
															$selected="";
															if ($tempfield->is_default_option == 1) {
																$selected = 'selected';
															}
															echo '<option '.esc_attr($selected).' value='.esc_attr($tempfield->id).'>'.esc_attr($tempfield->name).'</option>';

														}
													}

												?>
												</select>
												</span>
											</p>

											<?php
										}elseif ($field->type == "radio") {
											if ($field->is_required == 1) {
												$additional_text = $required_marker;
											} else {
												$additional_text ="";
											}
											?>
											<p>
												<label><?php echo esc_attr($field->name); ?><?php echo esc_attr($additional_text); ?></label>
												<span class="cust_input">
												<?php
													foreach ($custom_profile_fields as $tempfield) {
														if ($tempfield->parent_id == $field->id) {
															//selected
															$selected="";
															if ($tempfield->is_default_option == 1) {
																$selected = 'checked="yes"';
															}
															echo '<input type="radio"  value='.esc_attr($tempfield->id).' name="custom_fields['.esc_attr($field->id).']" '.esc_attr($selected).'>'.esc_attr($tempfield->name).'<br />';

														}
													}

												?>
												</span>
											</p>

											<?php
										}elseif ($field->type == "number") {
											if ($field->is_required == 1) {
												$additional_text = $required_marker;
											} else {
												$additional_text ="";
											}
											?>
											<p>
												<label><?php echo esc_attr($field->name); ?><?php echo esc_attr($additional_text); ?></label>
												<span class="cust_input">
												<input type="text" name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="input limit_to_numbers" size="20"  />
												</span>
											</p>
											<?php
										} elseif ($field->type == "url") {
											if ($field->is_required == 1) {
												$additional_text = $required_marker;
											} else {
												$additional_text ="";
											}
											?>
											<p>
												<label><?php echo esc_attr($field->name); ?><?php echo esc_attr($additional_text); ?></label>
												<span class="cust_input">
												<input type="text" name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="input limit_to_url" size="20"  />
												</span>
											</p>
											<?php
										}  elseif ($field->type == "textarea") {
											if ($field->is_required == 1) {
												$additional_text = $required_marker;
											} else {
												$additional_text ="";
											}
											?>
											<p>
												<label><?php echo esc_attr($field->name); ?><?php echo esc_attr($additional_text); ?></label>
												<span class="cust_input">
												<textarea name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="input textarea" size="20"  /></textarea><br />
												</span>
											</p>
											<?php
										}elseif ($field->type == "multiselectbox") {
											if ($field->is_required == 1) {
												$additional_text = $required_marker;
											} else {
												$additional_text ="";
											}
											?>
											<p>
												<label><?php echo esc_attr($field->name); ?><?php echo esc_attr($additional_text); ?></label>
												<span class="cust_input">
												<?php
													foreach ($custom_profile_fields as $tempfield) {
														if ($tempfield->parent_id == $field->id) {
															echo '<input type ="checkbox" name="custom_fields['.esc_attr($field->id).']['.esc_attr($tempfield->id).']"';
															if ($tempfield->is_default_option == 1) {
																echo ' checked="yes"';
															}
															echo '>'.esc_attr($tempfield->name)."<br />";
														}
													}

												?>
												</span>
											</p>

											<?php
										} elseif ($field->type == "datebox") {
                      if ($field->is_required == 1) {
												$additional_text = $required_marker;
											} else {
												$additional_text ="";
											}

                      ?>
                      <p>
                        <label><?php echo esc_attr($field->name); ?><?php echo esc_attr($additional_text); ?></label>
                        <span class="cust_input">
                        <?php

                              echo '<input type ="text" id="datepicker_'.$counterz.'" name="custom_fields['.esc_attr($field->id).']['.esc_attr($tempfield->id).']"';
                              echo '>'.esc_attr($tempfield->name)."<br />
                                <script>
                                jQuery(document).ready(function() {
                                    jQuery('#datepicker_".$counterz."').datepicker({
                                      dateFormat: '".blackfyre_dateFormatTojQuery(get_option('date_format'))."'
                                    });
                                });
                                </script>
                              ";
                              $counterz++;


                        ?>
                        </span>
                      </p>

                      <?php
                    }
									}
								}
								?>
								<span class="capch">
								<label><?php esc_html_e("Captcha:", 'blackfyre'); ?></label>

								<?php if( function_exists( 'gglcptch_display' ) ) { echo gglcptch_display(); } ; ?>

								</span>
								<br />
                                <?php wp_nonce_field('blackfyre_new_user','blackfyre_new_user_nonce', true, true ); ?>
								<p class="checkbox-reg">

								<label><input type="checkbox" name="agree" id="signupAgree" /> <span for="signupAgree"><?php esc_html_e("I certify that I'm over 18 and I agree to the ", 'blackfyre') ?>
								    <a href="<?php if(of_get_option('terms')){echo esc_url(of_get_option('terms'));}else{echo "#";} ?>" target="_blank"><?php esc_html_e("Terms & Conditions!", 'blackfyre') ?></a></span></label>

								</p>
								<?php do_action('register_form'); ?>

								<p class="submit" id="submit-button"><button name="wp-submit" type="submit" id="wp-submit" class="button-green button-small" onclick="return callValidation();"> <i class="fa fa-sign-in"></i> <?php esc_html_e('Sign up today!', 'blackfyre'); ?></button>
								</p>

								<input type="hidden" name="lwa" value="1" />

								<script type="text/javascript">
								    function callValidation(){
								        if(grecaptcha.getResponse().length == 0){
								            
								        	var submit = document.getElementById('submit-button'),
											    warning = document.createElement('div');
											warning.classList.add("error_msg");
											warning.innerHTML = 'Apologies Reclaimer, but we cannot risk contamination of this facility. Please pass the captcha challenge to verify that you are human.';
											submit.appendChild(warning);

								            return false;
								        }
								        return true;
								    }
								</script>

							</form>
							 <form name="LoginWithAjax_Form" id="LoginWithAjax_Form1" action="<?php  echo esc_url(wp_login_url()); ?>" method="post">
							 	<?php if(of_get_option('facebook_btn') or of_get_option('twitter_btn') or of_get_option('twitch_btn') or of_get_option('google_btn') or of_get_option('steam_btn')){ ?>
			                     <p><span><?php esc_html_e('Or login with:', 'blackfyre'); ?></span></p>
			                     <?php } ?>
			                    <div id="social_login" class="reg" >

			                      <?php if(of_get_option('facebook_btn')){ ?>
			                        <a id='facebooklogin' class='button-medium facebookloginb'><i class='fa fa-facebook-square'></i></a>
			                     <?php } ?>
			                       <?php if(of_get_option('twitter_btn')){ ?>
			                        <a id='twitterlogin' class='button-medium twitterloginb'><i class='fa fa-twitter-square'></i></a>
			                    <?php } ?>
			                    <?php if(of_get_option('twitch_btn')){ ?>
			                        <a id='twitchlogin' class='button-medium twitchloginb'><i class='fa fa fa-twitch'></i></a>
			                    <?php } ?>
			                    <?php if(of_get_option('google_btn')){ ?>
			                        <a id='googlelogin' class='button-medium googleloginb'><i class='fa fa fa-google-plus-square'></i></a>
			                    <?php } ?>
			                    <?php if(of_get_option('steam_btn')){ ?>
			                        <a id='steamlogin' class='button-medium steamloginb'><i class='fa fa fa-steam-square'></i></a>
			                    <?php } ?>
			                    </div>
			                  </form>
            <?php } ?>


		</div>
	</div>

</div>


<?php get_footer(); ?>
