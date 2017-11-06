<?php
global $post, $current_user;
$el_countries = $el_languages = $el_founded = $el_link1 = $el_link_text1 = $el_link2 = $el_link_text2 = $el_link3 = $el_link_text3 = $el_link4 = $el_link_text4 = $el_link5 = $el_link_text5 = '';
extract( shortcode_atts( array(
    'el_class' => '',
    'el_countries' => '',
    'el_languages' => '',
    'el_founded' => '',
    'el_link1' => '',
    'el_link_text1' => '',
    'el_link2' => '',
    'el_link_text2' => '',
    'el_link3' => '',
    'el_link_text3' => '',
    'el_link4' => '',
    'el_link_text4' => '',
    'el_link5' => '',
    'el_link_text5' => '',
), $atts) );
?>
<div class="<?php echo esc_attr($css_class); if(!empty($el_class)) echo esc_attr($el_class); ?> clan-generali block">

		<div class="clan-members-app"><i class="fa fa-users"></i><strong>
		    <?php  if(! empty($post) && is_a($post, 'WP_Post')){
		    	$members = blackfyre_return_number_of_members($post->ID);
			}else{
		    	$members = 0;
		    } ?>
		    <?php if($members == 1){ echo esc_attr($members); ?>&nbsp;<?php _e('Member','blackfyre'); }else{ echo esc_attr($members); ?>&nbsp;<?php _e('Members','blackfyre'); } ?></strong>
			<br />
			 <?php  if(! empty($post) && is_a($post, 'WP_Post')){ ?>
			<?php if (is_user_logged_in()) { ?>

                <?php if(blackfyre_is_super_admin($post->ID, $current_user->ID)){?>

                <?php }elseif (blackfyre_is_pending_member($post->ID, $current_user->ID)){ ?>

                   <div id='score_fin' class='error_msg'> <?php _e("Your request to join clan is pending!", "blackfyre");?></div>
                    <a href="javascript:void(0)" class="button-small ajaxloadblock" data-req="cancel_request" data-pid="<?php echo esc_attr($post->ID); ?>" data-uid="<?php echo esc_attr($current_user->ID); ?>">
                <i class="fa fa-user"></i> <?php _e('Cancel request', 'blackfyre');?> </a>

                <?php }elseif(blackfyre_is_member($post->ID, $current_user->ID) or blackfyre_is_admin($post->ID, $current_user->ID)){ ?>

                 <a href="javascript:void(0)" class="button-small ajaxloadblock" data-req="remove_friend_user" data-pid="<?php echo esc_attr($post->ID); ?>" data-uid="<?php echo esc_attr($current_user->ID); ?>">
                <i class="fa fa-user"></i> <?php _e('Leave clan', 'blackfyre');?> </a>

                <?php }else{ ?>

    			<a href="javascript:void(0)" class="button-small ajaxloadblock" data-req="join_clan" data-pid="<?php echo esc_attr($post->ID); ?>" data-uid="<?php echo esc_attr($current_user->ID); ?>">
    			    <i class="fa fa-user"></i> <?php _e('Request to join', 'blackfyre');?> </a>

                <?php }  ?>
			<?php }  ?>


			<?php } ?>
		</div>
		<ul class="clan-members-mi">
			<?php if(!empty($el_founded)){ ?>
			<li><strong><?php _e('Founded', 'blackfyre'); ?></strong><?php echo esc_attr($el_founded); ?></li>
			<?php } ?>
			<?php if(!empty($el_languages)){ ?>
			<li><strong><?php _e('Language', 'blackfyre'); ?></strong><?php echo esc_attr($el_languages); ?></li>
			<?php } ?>
			<?php if(!empty($el_countries)){ ?>
			<li><strong><?php _e('Location', 'blackfyre'); ?></strong><?php echo esc_attr($el_countries); ?></li>
			<?php } ?>
		</ul>
		<ul class="clan-members-links">

		    <?php if(!empty($el_link1) && !empty($el_link_text1)){ ?>
			<li><a href="<?php echo esc_url($el_link1); ?>"><?php echo esc_attr($el_link_text1); ?><i class="fa fa-external-link"></i></a></li>
			<?php } ?>

			<?php if(!empty($el_link2) && !empty($el_link_text2)){ ?>
            <li><a href="<?php echo esc_url($el_link2); ?>"><?php echo esc_attr($el_link_text2); ?><i class="fa fa-external-link"></i></a></li>
            <?php } ?>

            <?php if(!empty($el_link3) && !empty($el_link_text3)){ ?>
            <li><a href="<?php echo esc_url($el_link3); ?>"><?php echo esc_attr($el_link_text3); ?><i class="fa fa-external-link"></i></a></li>
            <?php } ?>

            <?php if(!empty($el_link4) && !empty($el_link_text4)){ ?>
            <li><a href="<?php echo esc_url($el_link4); ?>"><?php echo esc_attr($el_link_text4); ?><i class="fa fa-external-link"></i></a></li>
            <?php } ?>

            <?php if(!empty($el_link5) && !empty($el_link_text5)){ ?>
            <li><a href="<?php echo esc_url($el_link5); ?>"><?php echo esc_attr($el_link_text5); ?><i class="fa fa-external-link"></i></a></li>
            <?php } ?>

		</ul>

</div>