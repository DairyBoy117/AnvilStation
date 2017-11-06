<?php
$el_clans_title = $el_clans_number = $el_class = '';
global $post;
extract( shortcode_atts( array(
    'el_clans_title' => '',
    'el_clans_number'  => '',
    'el_class' => '',
), $atts ) );
if(empty($css)) $css = '';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column wpb_content_element ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
?>

<div id="buddypress" class="<?php echo esc_attr($css_class); if(!empty($el_class)) echo esc_attr($el_class); ?> clans-block">
    <div class="wpb_wrapper" id="members">
        <div class="title-wrapper">
            <h3 class="widget-title"><i class="fa fa-group"></i> <?php if(!empty($el_clans_title)) echo esc_attr($el_clans_title); ?></h3>
            <div class="clear"></div>
        </div>
       <?php
		global $wpdb;
		$table = $wpdb->prefix."posts";

		$clan_posts = $wpdb->get_results("SELECT `ID`, `post_title` FROM $table WHERE `post_type` = 'clan' AND `post_status` = 'publish'");

		if(isset($clan_posts) && is_array($clan_posts)){
				foreach ($clan_posts as $cln) {

				$tid = blackfyre_return_team_id_by_post_id($cln->ID);
				$team_id = $tid[0]->id;
				$score = blackfyre_return_team_win_lose_score($team_id);
				$cln->score = $score;
			}

			usort($clan_posts, "blackfyre_sort_objects_by_score");
		}


		if(empty($clan_posts)){ ?>
		 	<div class="error_msg"><span><?php  _e('There are no clans at the moment!', 'blackfyre'); ?> </span></div>
		<?php }else{

			$i = 0;
			if(empty($el_clans_number)) $el_clans_number = 99999; ?>

			<ul id="members-list" class="item-list" >

			<?php foreach ($clan_posts as $clan_post) {
				if($i == $el_clans_number) break; ?>

			 <li>
                <div class="clan-list-wrapper">
                    <div class="item-avatar">
                       <a href="<?php echo get_permalink($clan_post->ID); ?> ">
                         <?php $img = get_post_meta( $clan_post->ID, 'clan_photo', true );
                               $image = blackfyre_aq_resize( $img, 50, 50, true, true, true );
                               if(!$image){
                                   $image = get_template_directory_uri().'/img/defaults/default-clan-50x50.jpg';
                               }
                               ?>
                        <img alt="img" src="<?php echo esc_url($image); ?>" class="avatar" >
                       </a>
                    </div>

                    <div class="item">
                        <div class="item-title">
                            <a href="<?php echo get_permalink($clan_post->ID); ?> "> <?php echo esc_attr($clan_post->post_title); ?></a>
                            <div class="item-meta"><span class="activity"> <?php $members = blackfyre_return_number_of_members($clan_post->ID); ?>
            <?php if($members == 1){ echo $members; ?>&nbsp;<?php _e('Member','blackfyre'); }else{ echo esc_attr($members); ?>&nbsp;<?php _e('Members','blackfyre'); } ?></span></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>

            </li>

			<?php	$i++;
			} ?>

			 </ul>
      		<div class="clear"></div>

		<?php
		}
 ?>

    </div>
</div>