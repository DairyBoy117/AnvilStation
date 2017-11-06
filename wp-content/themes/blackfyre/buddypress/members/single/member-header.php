<?php
//ubacis ovde obradu
$author = get_queried_object();
$a_id = bp_displayed_user_id();
$c_id = get_current_user_id();
$is_mine = false;
$is_admin = false;
$currentlang = apply_filters( "wpml_home_url", home_url() );
if((current_user_can( 'manage_options' )))$is_admin = true;
if($a_id == $c_id)$is_mine = true;
if (($a_id == $c_id) || $is_admin) {

	global $current_user, $wp_roles;
    if(is_user_logged_in() != 1){ wp_redirect( esc_url($currentlang) );}
    $c_id = get_current_user_id();
    if(!isset($_POST['postImage']))$_POST['postImage']='';
    $user_postImage = $_POST['postImage'];
    if(!isset($_POST['postBackground']))$_POST['postBackground']='';
    $project_postBackground = $_POST['postBackground'];
    $post_id = $post->ID;
    $profile_up_thumb = get_user_meta($a_id, 'profile_photo', true);
    $profilebg_up_thumb_id = get_user_meta($a_id, 'profile_bg');
    $campaign_background = wp_get_attachment_url($profilebg_up_thumb_id[0]);
    $about =  get_user_meta($a_id, 'description',true);
    wp_get_current_user();
    $error = array();
	global $wpdb, $error;
		$custom_profile_fields = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_fields');

    /* If profile was saved, update profile. */
    if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) && $_POST['action'] == 'update-user') {
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
		/*
		if (is_array($therequiredfields)) {
			foreach ($therequiredfields as $findfield) {
				if (!isset($posted_customs[$findfield])) {
					$additional_error = true;
					$error[] = esc_html__("Please fill out all required fields. ",'blackfyre');
				}
			}
		}
		*/
		$customs_error = array();
		if (is_array($therequiredfields)) {
			foreach ($therequiredfields as $findfield) {
				if (!isset($posted_customs[$findfield])) {
					$additional_error = true;
					$customs_error[] = esc_html__("Please fill out all required fields. ",'blackfyre');
				} else {
					if ((!(is_array($posted_customs[$findfield]))) AND (!(is_string($posted_customs[$findfield])))) {
						$additional_error = true;
						$customs_error[] = esc_html__("Please fill out all required fields. ",'blackfyre');
					} elseif(is_array($posted_customs[$findfield])) {
						if (!(count($posted_customs[$findfield]) > 0)) {
							$additional_error = true;
							$customs_error[] = esc_html__("Please fill out all required fields. ",'blackfyre');
						}
					} elseif (is_string($posted_customs[$findfield])) {
						if (!(strlen($posted_customs[$findfield]) > 0)) {
							$additional_error = true;
							$customs_error[] = esc_html__("Please fill out all required fields. ",'blackfyre');
						}
					}
				}
			}
		}
        /* Update user password. */
        if (!empty($_POST['pass1']) && !empty($_POST['pass2'])) {
            if ($_POST['pass1'] == $_POST['pass2'])
                wp_update_user(array('ID' => $a_id, 'user_pass' => esc_attr($_POST['pass1'])));
            else
                $error[] = esc_html__('The passwords you entered do not match.  Your password was not updated.', 'blackfyre');
        }
        /* Update user information. */
        //website
        wp_update_user( array ('ID' => $a_id, 'user_url' => esc_url($_POST['user_url'])) ) ;
        if (!empty($_POST['email'])) {

            if (!is_email(esc_attr($_POST['email'])))
                $error[] = esc_html__('The Email you entered is not valid.  please try again.', 'blackfyre');
            elseif (trim (email_exists(esc_attr($_POST['email']))) != "" && email_exists(esc_attr($_POST['email'])) != $a_id)
                $error[] = esc_html__('This email is already used by another user.  try a different one.', 'blackfyre');
            else {
                wp_update_user(array('ID' => $a_id, 'user_email' => esc_attr($_POST['email'])));
            }
        }
        //here we add photo, if the photo was set
        if ($user_postImage != '') {

            $filename   = basename($user_postImage);
            $wp_filetype = wp_check_filetype( $user_postImage, null );
            $attachment = array(
                 'post_mime_type' => $wp_filetype['type'],
                 'post_title'     => sanitize_file_name( $filename ),
                 'post_content'   => '',
                 'post_status'    => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $user_postImage, $post_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id,$user_postImage );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            set_post_thumbnail( $post_id, $attach_id );
            $check_current_pphoto = get_user_meta($a_id, 'profile_photo');

            if (isset($check_current_pphoto)) {
                update_user_meta($a_id, 'profile_photo', wp_get_attachment_url($attach_id));
            } else {
                add_user_meta( $a_id, 'profile_photo', wp_get_attachment_url($attach_id));
            }
        }
        if ($project_postBackground != '') {
            $filename   = basename($project_postBackground);
            $wp_filetype = wp_check_filetype( $project_postBackground, null );
            $attachment = array(
                 'post_mime_type' => $wp_filetype['type'],
                 'post_title'     => sanitize_file_name( $filename ),
                 'post_content'   => '',
                 'post_status'    => 'inherit'
            );
            $attach_id = wp_insert_attachment( $attachment, $project_postBackground, $post_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id,$project_postBackground );
            wp_update_attachment_metadata( $attach_id, $attach_data );
            MultiPostThumbnails::set_meta($post_id, "account", "page-background-projects", $attach_id);
            $check_current_pbg = get_user_meta($a_id, 'profile_bg');
            if (isset($check_current_pbg)) {
                update_user_meta($a_id, 'profile_bg', $attach_id);
            } else {
                add_user_meta($a_id, 'profile_bg', $attach_id);
            }
        }


        if(!empty($_POST['usercountry_id']))
             update_user_meta($a_id, 'usercountry_id', esc_attr($_POST['usercountry_id']));
        if (!empty($_POST['first-name']))
            update_user_meta($a_id, 'first_name', esc_attr($_POST['first-name']));
        if (!empty($_POST['last-name']))
            update_user_meta($a_id, 'last_name', esc_attr($_POST['last-name']));
		if (!empty($_POST['nickname']))
            update_user_meta($a_id, 'nickname', esc_attr($_POST['nickname']));
		if (!empty($_POST['user_display_name'] ))
            wp_update_user(array ('ID' => $a_id, 'display_name' => esc_attr($_POST['user_display_name'])));
        if (!empty($_POST['city']))
            update_user_meta($a_id, 'city', esc_attr($_POST['city']));
        if (!empty($_POST['birthday_field']))
            update_user_meta($a_id, 'age', esc_attr($_POST['birthday_field']));
        if(!empty($_POST['aboutMe']))
            update_user_meta($a_id, 'description', $_POST['aboutMe']);


		$counter = 0;
			if (isset($posted_customs) AND (is_array($posted_customs)) AND (count($customs_error) == 0)) {
				foreach ($posted_customs as $akey => $acustom) {
					//$custom_profile_fields = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'bp_xprofile_fields');
					$holdfield = '';
					foreach ($custom_profile_fields as $thefield) {
						if ($thefield->id == $akey) {
							$holdfield = $thefield;
						}
					}
					if (($holdfield->type == "textbox") OR ($holdfield->type == "number") OR ($holdfield->type == "url") OR ($holdfield->type == "textarea")) {
						$preppedvalue = wp_unslash($acustom);
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
									$preppedvalue[$counter] = $thefield->name;
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
                    
 
						$wpdb->query("DELETE FROM ".$wpdb->prefix."bp_xprofile_data WHERE field_id='".$akey."' AND user_id='".$a_id."'");
						$finishedids[$akey] = $akey;

						$wpdb->insert(
							$wpdb->prefix."bp_xprofile_data",
							array(
								'field_id' => $akey,
								'user_id' => $a_id,
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

				foreach ($custom_profile_fields as $holdit) {
					$allids[$holdit->id] = $holdit->id;
				}
				foreach ($finishedids as $done) {
					if (in_array($done, $allids)) {
						unset($allids[$done]);
					}
				}
				foreach ($allids as $remainder) {
					$wpdb->query("DELETE FROM ".$wpdb->prefix."bp_xprofile_data WHERE field_id='".$remainder."' AND user_id='".$a_id."'");
				}
			} else {
				$error[] = esc_html__("Please fill out all profile fields, custom profile fields were NOT updated", 'blackfyre');
			}



        //if (count($error) == 0) {
        //    wp_redirect(get_permalink());
        //}
    }
}

$campaign_thumbnail = get_the_post_thumbnail($a_id, "full");


?>

<div class="profile">

    <div class="profile-info row">
        <div class="profile-fimage profile-media">

             <?php
            $bgpic = array();
            $bgpic = get_user_meta($a_id, 'profile_bg');
            if(empty($bgpic[0]))$bgpic[0]='';
            $bg_url = wp_get_attachment_url($bgpic[0]);
            if(!empty($bg_url))
            {
                $imagebg = blackfyre_aq_resize($bg_url,  1170, 280, true, true, true ); //resize & crop img
                if (!isset ($imagebg[0]))
                {
                    $bgimage = $bgpic;
                }
                else
                {
                    $bgimage = $imagebg;
                }
                ?>
                <div class="hiddenoverflow"><img alt="img" src="<?php echo esc_url($bgimage); ?>" /></div>
            <?php }else{ ?>
               <div class="hiddenoverflow"><img alt="img" class="attachment-small wp-post-image" src="<?php echo get_template_directory_uri().'/img/defaults/default-banner.jpg'?> "/></div>
            <?php } ?>
		<?php
		if ($is_mine == true || $is_admin == true) {
            		?>
            		<div id="change_bg_pic"><?php echo esc_html__("Click to change", "blackfyre"); ?></div>
					<script>
            			jQuery( document ).ready(function($) {
            				var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
            				//profile-media
						   	jQuery('.profile-media').mouseenter(function(e) {
						   		jQuery('#change_bg_pic').fadeTo('slow', 0.75);
						   	});
						   	jQuery('.profile-media').mouseleave(function(e) {
						   		jQuery('#change_bg_pic').fadeOut();
						   	});
						   	jQuery('.profile-media').click(function(e) {
						   		DoChangeBg();
						   	});
						   	jQuery('#change_bg_pic').click(function(e) {
						   		DoChangeBg();
						   	});
						   	jQuery('.profile-media').css("cursor", "pointer");
						   	jQuery(".profile-media img").css("cursor", "pointer");
						   	jQuery('#change_bg_pic').css("cursor", "pointer");
						   	function DoChangeBg() {
								var send_attachment_bkp = wp.media.editor.send.attachment;
								wp.media.editor.send.attachment = function(props, attachment) {
									jQuery(".profile-media img").fadeOut('slow', function(e) {
										jQuery(".profile-media img").attr('src', attachment.url);
										jQuery(".profile-media img").on('load', function(){
        									jQuery(".profile-media img").fadeIn();
        									jQuery(".profile-media img").css("cursor", "pointer");
										});
										var data = {
											'action': 'update_user_profile_bg',
									        'file': attachment.id
									    };
									    $.post(ajaxurl, data, function(response) {
									    	NotifyMe(response, "information");
											console.log (response);
										});

									});
								    wp.media.editor.send.attachment = send_attachment_bkp;
								}

								wp.media.editor.open();

								return false;
						   	}
						});
            		</script>
		<?php } ?>

        </div>
         <?php if(bp_is_active( 'friends' )){ ?>
			<div class="friendswrapper">
				<div class="friends-count"><i class="fa fa-users"></i>
				<?php if(friends_get_total_friend_count($a_id ) == 0){
				    esc_html_e('0 friends', 'blackfyre');
				}elseif(friends_get_total_friend_count($a_id ) == 1){
				    esc_html_e('1 friend', 'blackfyre');
				}else{
				    echo friends_get_total_friend_count($a_id ); esc_html_e(' friends','blackfyre');
				} ?></div>
				<?php bp_member_add_friend_button(); ?>

			</div>
            <?php } ?>
		<div class="col-lg-12 col-md-12 nav-top-divider"></div>
        
        <?php if(bp_is_active( 'messages' ) && ($a_id != $c_id) ){ ?>
        <div class="messagewrapper">
		<?php if ( is_user_logged_in() ) echo '<a href="' . wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . get_the_author_meta('user_login',$a_id) ) . '" title="'.esc_html__("Send a private message to this user", "blackfyre").'" class="send-message button-small"><i class="fa fa-envelope" aria-hidden="true"></i> '.esc_html__("send a message", "blackfyre").'</a>'; ?>
		</div>
        <?php } ?>
            
        <div class="avatar-card">

            	<?php echo get_avatar($a_id, 250);?>


            <p>
                <?php
                if (get_the_author_meta('display_name', $a_id))
                {
                    echo get_the_author_meta('display_name', $a_id);
                }
                ?>
            </p>
            <?php echo get_the_author_meta('country', $a_id); ?>
            <?php if ( ! $is_mine ) $is_mine = 0; ?>
            <?php if ( ! $is_admin ) $is_admin = 0; ?>
		  <?php
            	if ($is_mine == true || $is_admin == true) {
            		?>
            		<div id="change_profile_pic"><?php echo esc_html__("Click to change", "blackfyre"); ?></div>
            		<script>
            			jQuery( document ).ready(function($) {
            				var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
            				var mine = <?php echo esc_js($is_mine); ?>;
            				var admin = <?php if ($is_admin == true) { echo 1; } else {echo '0'; }  ?>;
            				//profile-media
						   	jQuery('.avatar-card').mouseenter(function(e) {
						   		jQuery('#change_profile_pic').fadeTo('slow', 0.75);
						   	});
						   	jQuery('.avatar-card').mouseleave(function(e) {
						   		jQuery('#change_profile_pic').fadeOut();
						   	});
						   	jQuery('.photo').click(function(e) {
						   		DoChangeProfile();
						   	});

						   	jQuery(".avatar-card img").click(function(e) {
						   		DoChangeProfile();
						   	});
						   	jQuery('#change_profile_pic').click(function(e) {
						   		DoChangeProfile();
						   	});
						   	jQuery('.photo').css("cursor", "pointer");
						   	jQuery(".avatar-card img").css("cursor", "pointer");
						   	jQuery('#change_profile_pic').css("cursor", "pointer");
						   	function DoChangeProfile() {
								var send_attachment_bkp = wp.media.editor.send.attachment;
								wp.media.editor.send.attachment = function(props, attachment) {
									jQuery(".avatar-card img").fadeOut('slow', function(e) {
										jQuery(".avatar-card img").attr('src', attachment.url);
										jQuery(".avatar-card img").on('load', function(){
        									jQuery(".avatar-card img").fadeIn();
        									jQuery(".avatar-card img").css("cursor", "pointer");
										});
										var data = {
											'action': 'update_user_profile_pic',
									        'file': attachment.url
									    };
									    $.post(ajaxurl, data, function(response) {
											NotifyMe(response, "information");
										});

									});

									if(mine == 0 && admin == 1){}else{
									jQuery(".user-avatar img").fadeOut('slow', function(e) {
										jQuery(".user-avatar img").attr('src', attachment.url);
										jQuery(".user-avatar img").on('load', function(){
        									jQuery(".user-avatar img").fadeIn();
										});
									});
									}
								    wp.media.editor.send.attachment = send_attachment_bkp;
								}

								wp.media.editor.open();

								return false;
						   	}
						});
            		</script>


            		<?php
            	}

            ?>
        </div>
</div></div>
