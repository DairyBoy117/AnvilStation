<?php
global $current_user, $wp_roles, $error;
wp_get_current_user();
$a_id = bp_displayed_user_id();
$c_id = get_current_user_id();
$about =  get_user_meta($a_id, 'description',true);

?>


                            <div id="post-<?php the_ID(); ?>">
                                <div class="entry-content entry settings_user">
                                    <?php //the_content(); ?>
                                    <?php if ( !is_user_logged_in() ) : ?>
                                        <p class="warning">
                                            <?php esc_html_e('You must be logged in to edit your profile.', 'blackfyre'); ?>
                                        </p><!-- .warning -->
                                    <?php else : ?>

                                    	<?php if((current_user_can( 'manage_options' ))){ ?>
                                        <?php
                                        if ((is_array($error)) AND (count($error) > 0))
                                            echo '<p class="error">' . implode("<br />", $error) . '</p>';
                                        ?>
                                        <form method="post" id="adduser">
                                            <fieldset class="form-username">
                                                <p><label for="first-name"><?php esc_html_e('First Name', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta('first_name', $a_id); ?>" />
                                                	</span>
                                            </p></fieldset><!-- .form-username -->
                                            <fieldset class="form-username">
                                                <p><label for="last-name"><?php esc_html_e('Last Name', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta('last_name', $a_id); ?>" />
                                                	</span>
                                            </p></fieldset><!-- .form-username -->
                                             <fieldset class="form-username">
                                                <p><label for="last-name"><?php esc_html_e('Nickname', 'blackfyre'); ?></label>
                                                		<span class="cust_input">
                                                <input class="text-input" name="nickname" type="text" id="nickname" value="<?php the_author_meta('nickname', $a_id); ?>" />
                                                	</span>
                                            </p></fieldset><!-- .form-username -->
											<fieldset class="user_display_name">
												<p><label for="user_display_name"><?php esc_html_e( 'Display name publicly as', 'blackfyre' ) ?></label>
													<span class="cust_input">
												<select name="user_display_name" id="user_display_name">
												<?php
												$profileuser = get_user_by( 'id', $a_id );
												$public_display = array();
												$public_display['display_username'] = $profileuser->user_login;
												$public_display['display_nickname'] = $profileuser->nickname;

												if ( !empty( $profileuser->first_name ) )
												$public_display['display_firstname'] = $profileuser->first_name;

												if ( !empty( $profileuser->last_name ) )
												$public_display['display_lastname'] = $profileuser->last_name;

												if ( !empty( $profileuser->first_name ) && !empty( $profileuser->last_name ) ) {
												$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
												$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
												}

												if ( !in_array( $profileuser->display_name, $public_display ) ) {
												$public_display = array('display_displayname' => $profileuser->display_name) + $public_display;
												}

												$public_display = array_map( 'trim', $public_display );
												$public_display = array_unique( $public_display );

												foreach ($public_display as $id => $item) {
												?>
												<option id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr( $item ); ?>"<?php selected( $profileuser->display_name, $item ); ?>><?php echo esc_attr($item); ?></option>
												<?php
												}
												?>
												</select>
												</span>
											</p></fieldset>
                                            <fieldset class="form-age">
                                                <p><label for="age"><?php esc_html_e('Birthday', 'blackfyre'); ?></label>
                                                   <?php $age = get_user_meta( $current_user -> ID, 'age',true); ?>
                                   				<span class="cust_input">
                                   					<?php if(!isset($age)) $age = ''; ?>
													<?php  echo '<input value="'.esc_attr($age).'" type ="text" id="birthday_field" name="birthday_field">';
						                              echo "
						                                <script>
						                                jQuery(document).ready(function() {
						                                    jQuery('#birthday_field').datepicker({
						                                      dateFormat: '".blackfyre_dateFormatTojQuery(get_option('date_format'))."',
						                                      changeMonth: true,
      														  changeYear: true,
      														  maxDate: '-1Y',
      														  minDate: '-70Y',
                                                              yearRange: '1950:+0',
						                                    });
						                                });
						                                </script>
						                              "; ?>
													</span>
                                            </p></fieldset><!-- .form-username -->


                                            <fieldset class="form-email">
                                                <p><label for="email"><?php esc_html_e('E-mail *', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta('user_email', $a_id); ?>" />
                                                </span>
                                            </p></fieldset><!-- .form-email -->
                                            <fieldset class="form-url">
                                                <p><label for="user_url"><?php esc_html_e('Website', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="user_url" type="text" id="user_url" value="<?php the_author_meta('user_url', $a_id); ?>" />
                                                </span>
                                            </p></fieldset><!-- .form-url -->
                                            <fieldset class="form-password">
                                                <p><label for="pass1"><?php esc_html_e('Password *', 'blackfyre'); ?> </label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="pass1" type="password" id="pass1" />
                                                </span>
                                            </p></fieldset><!-- .form-password -->
                                            <fieldset class="form-password">
                                                <p><label for="pass2"><?php esc_html_e('Repeat Password *', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="pass2" type="password" id="pass2" />
                                                </span>
                                            </p></fieldset><!-- .form-password -->
                                            <fieldset class="form-textarea">
                                                <p><label for="description"><?php esc_html_e('About me', 'blackfyre') ?></label>
                                                	<span class="cust_input">
                                                <?php

                                                  if(isset($about)) {
                                                       $aboutMe = $about;
                                                 }

                                                $wp_editor_settings = array(

                                                'textarea_name' => 'aboutMe',

                                                'media_buttons' => true,

                                                'editor_class' => 'widefat',

                                                'textarea_rows' => 10,

                                                'teeny' => true);

                                             if(!isset($aboutMe)){$aboutMe='';}

                                             add_filter('user_can_richedit', '__return_true'); // anyone can add media

                                            add_filter('is_user_logged_in', 'the_returner');

                                            function the_returner() {

                                                return true;

                                            }

                                            wp_editor($aboutMe, "aboutMe", $wp_editor_settings); ?>

                                            </span>
                                            </p></fieldset><!-- .form-textarea -->
                                            <fieldset><p>
                                            		<span class="cust_input">
                                                <?php
                                                $id = $a_id;
                                                $usercountry_id = get_user_meta($id, 'usercountry_id',true);?>
                                                <p><label for="usercountry_id"><?php esc_html_e('Country', 'blackfyre'); ?></label>
                                                <?php
                                                global $wpdb;
                                                $table = $wpdb->prefix."user_countries";
                                                $countries = $wpdb->get_results("SELECT * FROM $table ORDER BY name");
                                                ?>
                                                <select name="usercountry_id">
                                                    <option value="0"><?php esc_html_e('- Select -','blackfyre') ?></option>
                                                        <?php
                                                        foreach ($countries as $country) {
                                                            $selected="";
                                                            if ($usercountry_id==$country->id_country) { $selected="selected";}
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
                                            </p></fieldset>
                                            <fieldset class="form-city">
                                                <p><label for="city"><?php esc_html_e('City', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="city" type="text" id="city" value="<?php the_author_meta('city', $a_id); ?>" />
                                                </span>
                                            </p></fieldset>
                                            <?php
                                            	//tusi
                                            	global $wpdb;
												$custom_profile_fields = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_fields');
												$required_marker= " *";
												if (is_array($custom_profile_fields)) {
													foreach ($custom_profile_fields as $field) {
														if ($field->type == "textbox") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');
															?>
															<fieldset class="form-textbox">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<input type="text" name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="text-input" size="20" value="<?php echo esc_attr($query->value); ?>"  />
															 	</span>
															 </p></fieldset>
															<?php
															unset($query);
														} elseif ($field->type == "checkbox") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');
															?>
															<fieldset class="form-checkbox">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<?php
																	foreach ($custom_profile_fields as $tempfield) {
																		if ($tempfield->parent_id == $field->id) {
																			echo '<input type ="checkbox" name="custom_fields['.$field->id.']['.$tempfield->id.']"';
																			if (is_array(unserialize($query->value)) && (in_array($tempfield->name, unserialize($query->value)))) {
																				echo ' checked="yes"';
																			}
																			echo '>'.$tempfield->name."<br />";
																		}
																	}

																?>
																</span>
															 </p></fieldset>

															<?php
															unset($query);
														}elseif ($field->type == "selectbox") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-selectbox">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<select name="<?php echo 'custom_fields['.$field->id.']'; ?>">
																<?php
																	foreach ($custom_profile_fields as $tempfield) {
																		if ($tempfield->parent_id == $field->id) {
																			//selected
																			$selected="";
																			if ($tempfield->name == $query->value) {
																				$selected = 'selected';
																			}
																			echo '<option '.$selected.' value='.$tempfield->id.'>'.$tempfield->name.'</option>';

																		}
																	}

																?>
																</select>
																</span>
															 </p></fieldset>

															<?php
															unset($query);
														}elseif ($field->type == "radio") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-radio">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<?php
																	foreach ($custom_profile_fields as $tempfield) {
																		if ($tempfield->parent_id == $field->id) {
																			//selected
																			$selected="";
																			if ($tempfield->name == $query->value) {
																				$selected = 'checked="yes"';
																			}
																			echo '<input type="radio"  value='.$tempfield->id.' name="custom_fields['.$field->id.']" '.$selected.'>'.$tempfield->name.'<br />';

																		}
																	}

																?>
																</span>
															 </p></fieldset>

															<?php
															unset($query);
														}elseif ($field->type == "number") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-number">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<input type="text" name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="text-input limit_to_numbers" size="20" value="<?php echo esc_attr($query->value); ?>"  />
															 	</span>
															 </p></fieldset>
															<?php
															unset($query);
														} elseif ($field->type == "url") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-url">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<input type="text" name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="text-input limit_to_url" size="20" value="<?php echo esc_attr($query->value); ?>"  />
															 	</span>
															 </p></fieldset>
															<?php
															unset($query);
														}  elseif ($field->type == "textarea") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-textarea">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<textarea name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="input textarea" size="20"  /><?php echo esc_attr($query->value); ?></textarea><br />
															 	</span>
															 </p></fieldset>
															<?php
															unset($query);
														}elseif ($field->type == "multiselectbox") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');
															;
															?>
															<fieldset class="form-multiselect">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<?php
																	foreach ($custom_profile_fields as $tempfield) {
																		if ($tempfield->parent_id == $field->id) {
																			echo '<input type ="checkbox" name="custom_fields['.$field->id.']['.$tempfield->id.']"';
																			if (is_array(unserialize($query->value)) && (in_array($tempfield->name, unserialize($query->value)))) {
																				echo ' checked="yes"';
																			}
																			echo '>'.$tempfield->name."<br />";
																		}
																	}

																?>
																</span>
															 </p></fieldset>

															<?php
															unset($query);
														}
													}
												}

                                            ?>





                                            <fieldset><p>
                                                <p class="form-submit">
                                                    <input name="updateuser" type="submit" id="updateuser" class="submit button button-green button-small" value="<?php esc_html_e('Update', 'blackfyre'); ?>" />
                                                    <?php wp_nonce_field( 'update-user' ) ?>
                                                    <input name="action" type="hidden" id="action" value="update-user" />
                                                </p><!-- .form-submit -->
                                            </p></fieldset>
                                            </form><!-- #adduser -->

                                            <?php }else{ ?>
                                            	 <?php
                                        if ((is_array($error)) AND (count($error) > 0))
                                            echo '<p class="error">' . implode("<br />", $error) . '</p>';
                                        ?>
                                        <form method="post" id="adduser">
                                            <fieldset class="form-username">
                                                <p><label for="first-name"><?php esc_html_e('First Name', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta('first_name', $current_user -> ID); ?>" />
                                                </span>
                                            </p></fieldset><!-- .form-username -->
                                            <fieldset class="form-username">
                                                <p><label for="last-name"><?php esc_html_e('Last Name', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta('last_name', $current_user -> ID); ?>" />
                                                </span>
                                            </p></fieldset><!-- .form-username -->
                                             <fieldset class="form-username">
                                                <p><label for="last-name"><?php esc_html_e('Nickname', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="nickname" type="text" id="nickname" value="<?php the_author_meta('nickname', $current_user -> ID); ?>" />
                                                </span>
                                            </p></fieldset><!-- .form-username -->
											<fieldset class="user_display_name">
												<p><label for="user_display_name"><?php esc_html_e( 'Display name publicly as', 'blackfyre' ) ?></label>
													<span class="cust_input">
												<select name="user_display_name" id="user_display_name">
												<?php
												$profileuser = wp_get_current_user();
												$public_display = array();
												$public_display['display_username'] = $profileuser->user_login;
												$public_display['display_nickname'] = $profileuser->nickname;

												if ( !empty( $profileuser->first_name ) )
												$public_display['display_firstname'] = $profileuser->first_name;

												if ( !empty( $profileuser->last_name ) )
												$public_display['display_lastname'] = $profileuser->last_name;

												if ( !empty( $profileuser->first_name ) && !empty( $profileuser->last_name ) ) {
												$public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
												$public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
												}

												if ( !in_array( $profileuser->display_name, $public_display ) ) {
												$public_display = array('display_displayname' => $profileuser->display_name) + $public_display;
												}

												$public_display = array_map( 'trim', $public_display );
												$public_display = array_unique( $public_display );

												foreach ($public_display as $id => $item) {
												?>
												<option id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr( $item ); ?>"<?php selected( $profileuser->display_name, $item ); ?>><?php echo esc_attr($item); ?></option>
												<?php
												}
												?>
												</select>
												</span>
											</p></fieldset>

                                            <fieldset class="form-age">
                                                <p><label for="age"><?php esc_html_e('Birthday', 'blackfyre'); ?></label>
                                                   <?php $age = get_user_meta( $current_user -> ID, 'age',true); ?>
                                   				<span class="cust_input">
                                   					<?php if(!isset($age)) $age = ''; ?>
													<?php  echo '<input value="'.esc_attr($age).'" type ="text" id="birthday_field" name="birthday_field">';
						                              echo "
						                                <script>
						                                jQuery(document).ready(function() {
						                                    jQuery('#birthday_field').datepicker({
						                                      dateFormat: '".blackfyre_dateFormatTojQuery(get_option('date_format'))."',
						                                      changeMonth: true,
      														  changeYear: true,
      														  maxDate: '-1Y',
      														  minDate: '-70Y',
                                                              yearRange: '1950:+0',
						                                    });
						                                });
						                                </script>
						                              "; ?>
													</span>
                                            </p></fieldset><!-- .form-username -->


                                            <fieldset class="form-email">
                                                <p><label for="email"><?php esc_html_e('E-mail *', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta('user_email', $current_user -> ID); ?>" />
                                                </span>
                                            </p></fieldset><!-- .form-email -->
                                            <fieldset class="form-url">
                                                <p><label for="user_url"><?php esc_html_e('Website', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="user_url" type="text" id="user_url" value="<?php the_author_meta('user_url', $current_user -> ID); ?>" />
                                                </span>
                                            </p></fieldset><!-- .form-url -->
                                            <fieldset class="form-password">
                                                <p><label for="pass1"><?php esc_html_e('Password *', 'blackfyre'); ?> </label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="pass1" type="password" id="pass1" />
                                                </span>
                                            </p></fieldset><!-- .form-password -->
                                            <fieldset class="form-password">
                                                <p><label for="pass2"><?php esc_html_e('Repeat Password *', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="pass2" type="password" id="pass2" />
                                                </span>
                                            </p></fieldset><!-- .form-password -->
                                            <fieldset class="form-textarea">
                                                <p><label for="description"><?php esc_html_e('About me', 'blackfyre') ?></label>
                                                	<span class="cust_input">
                                                <?php

                                                  if(isset($about)) {
                                                       $aboutMe = $about;
                                                 }

                                                $wp_editor_settings = array(

                                                'textarea_name' => 'aboutMe',

                                                'media_buttons' => true,

                                                'editor_class' => 'widefat',

                                                'textarea_rows' => 10,

                                                'teeny' => true);

                                             if(!isset($aboutMe)){$aboutMe='';}

                                             add_filter('user_can_richedit', '__return_true'); // anyone can add media

                                            add_filter('is_user_logged_in', 'the_returner');

                                            function the_returner() {

                                                return true;

                                            }

                                            wp_editor($aboutMe, "aboutMe", $wp_editor_settings); ?>
                                            </span>
                                            </p></fieldset><!-- .form-textarea -->
                                            <fieldset><p>
                                            		<span class="cust_input">
                                                <?php
                                                $id = $current_user -> ID;
                                                $usercountry_id = get_user_meta($id, 'usercountry_id',true);?>
                                                <p><label for="usercountry_id"><?php esc_html_e('Country', 'blackfyre'); ?></label>
                                                <?php
                                                global $wpdb;
                                                $table = $wpdb->prefix."user_countries";
                                                $countries = $wpdb->get_results("SELECT * FROM $table ORDER BY name");
                                                ?>
                                                <select name="usercountry_id">
                                                    <option value="0"><?php esc_html_e('- Select -','blackfyre') ?></option>
                                                        <?php
                                                        foreach ($countries as $country) {
                                                            $selected="";
                                                            if ($usercountry_id==$country->id_country) { $selected="selected";}
                                                            echo '<option '.$selected.' value="'.$country->id_country.'">'.$country->name.'</option>';
                                                        }
                                                        ?>
                                                </select>
                                                </span>
                                            </p></fieldset>
                                            <fieldset class="form-city">
                                                <p><label for="city"><?php esc_html_e('City', 'blackfyre'); ?></label>
                                                	<span class="cust_input">
                                                <input class="text-input" name="city" type="text" id="city" value="<?php the_author_meta('city', $current_user -> ID); ?>" />
                                                </span>
                                            </p></fieldset>

                                            <?php
                                            	//tusi
                                            	global $wpdb;
												$custom_profile_fields = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_fields');
												$required_marker= " *";
												if (is_array($custom_profile_fields)) {
													foreach ($custom_profile_fields as $field) {
														if ($field->type == "textbox") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');
															?>
															<fieldset class="form-textbox">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<input type="text" name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="text-input" size="20" value="<?php echo esc_attr($query->value); ?>"  />
															 	</span>
															 </p></fieldset>
															<?php
															unset($query);
														} elseif ($field->type == "checkbox") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');
															?>
															<fieldset class="form-checkbox">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<?php
																	foreach ($custom_profile_fields as $tempfield) {
																		if ($tempfield->parent_id == $field->id) {
																			echo '<input type ="checkbox" name="custom_fields['.$field->id.']['.$tempfield->id.']"';
																			if (is_array(unserialize($query->value)) && (in_array($tempfield->name, unserialize($query->value)))) {
																				echo ' checked="yes"';
																			}
																			echo '>'.$tempfield->name."<br />";
																		}
																	}

																?>
																</span>
															 </p></fieldset>

															<?php
															unset($query);
														}elseif ($field->type == "selectbox") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-selectbox">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<select name="<?php echo 'custom_fields['.$field->id.']'; ?>">
																<?php
																	foreach ($custom_profile_fields as $tempfield) {
																		if ($tempfield->parent_id == $field->id) {
																			//selected
																			$selected="";
																			if ($tempfield->name == $query->value) {
																				$selected = 'selected';
																			}
																			echo '<option '.$selected.' value='.$tempfield->id.'>'.$tempfield->name.'</option>';

																		}
																	}

																?>
																</select>
																</span>
															 </p></fieldset>

															<?php
															unset($query);
														}elseif ($field->type == "radio") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-radio">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<?php
																	foreach ($custom_profile_fields as $tempfield) {
																		if ($tempfield->parent_id == $field->id) {
																			//selected
																			$selected="";
																			if ($tempfield->name == $query->value) {
																				$selected = 'checked="yes"';
																			}
																			echo '<input type="radio"  value='.$tempfield->id.' name="custom_fields['.$field->id.']" '.$selected.'>'.$tempfield->name.'<br />';

																		}
																	}

																?>
																</span>
															 </p></fieldset>

															<?php
															unset($query);
														}elseif ($field->type == "number") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-number">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<input type="text" name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="text-input limit_to_numbers" size="20" value="<?php echo esc_attr($query->value); ?>"  />
															 	</span>
															 </p></fieldset>
															<?php
															unset($query);
														} elseif ($field->type == "url") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-url">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<input type="text" name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="text-input limit_to_url" size="20" value="<?php echo esc_attr($query->value); ?>"  />
															 	</span>
															 </p></fieldset>
															<?php
															unset($query);
														}  elseif ($field->type == "textarea") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-textarea">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<textarea name="custom_fields[<?php echo esc_attr($field->id); ?>]" id="custom_fields[<?php echo esc_attr($field->id); ?>]" class="input textarea" size="20"  /><?php echo esc_attr($query->value); ?></textarea><br />
															 	</span>
															 </p></fieldset>
															<?php
															unset($query);
														}elseif ($field->type == "multiselectbox") {
															if ($field->is_required == 1) {
																$additional_text = $required_marker;
															} else {
																$additional_text ="";
															}
															$query = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_data WHERE user_id="'.$a_id.'" AND field_id="'.$field->id.'" LIMIT 1');

															?>
															<fieldset class="form-multiselect">
																<p><label for="custom_fields[<?php echo esc_attr($field->id); ?>]"><?php echo esc_attr($field->name); ?><?php echo $additional_text; ?></label>
																	<span class="cust_input">
																<?php
																	foreach ($custom_profile_fields as $tempfield) {
																		if ($tempfield->parent_id == $field->id) {
																			echo '<input type ="checkbox" name="custom_fields['.$field->id.']['.$tempfield->id.']"';
																			if (is_array(unserialize($query->value)) && (in_array($tempfield->name, unserialize($query->value)))) {
																				echo ' checked="yes"';
																			}
																			echo '>'.$tempfield->name."<br />";
																		}
																	}

																?>
																</span>
															 </p></fieldset>

															<?php
															unset($query);
														}
													}
												}

                                            ?>






                                            <fieldset><p>
                                                <p class="form-submit">
                                                    <input name="updateuser" type="submit" id="updateuser" class="submit button button-green button-small" value="<?php esc_html_e('Update', 'blackfyre'); ?>" />
                                                    <?php wp_nonce_field( 'update-user' ) ?>
                                                    <input name="action" type="hidden" id="action" value="update-user" />
                                                </p><!-- .form-submit -->
                                            </p></fieldset>
                                            </form><!-- #adduser -->



                                        <?php    } ?>
                                        <?php endif; ?>
                                    </div><!-- .entry-content -->
                                </div><!-- .hentry .post -->

