<?php get_header();?>
<?php
    global $post, $current_user, $challenge_sent;
    wp_get_current_user();
    $post_object = get_post( $post->ID );
    $a_id = $post->post_author;
    $c_id = $current_user->ID;
    $p_id = $post->ID;
    $is_mine = false;
	$is_admin = false;
	if((current_user_can( 'manage_options' )))$is_admin = true;
    $team_id = blackfyre_return_team_id_by_post_id($p_id);
    if($c_id == $a_id){$is_mine = true;}
?>
<?php $bg_page_url = get_post_meta($p_id, 'clan_page_bg',true);
      $custombck = wp_get_attachment_url($bg_page_url);
?>
<?php if(empty($custombck)){}else{ ?>
<style>
    body.single-clan{
    background:url(<?php echo esc_url($custombck); ?>);
    background-position:center top !important;
    background-repeat: repeat;
}
</style>
<?php } ?>
<?php if($is_mine or $is_admin){ ?>
                    <div id="change_page_bg_pic"><?php esc_html_e("Click to change", "blackfyre"); ?></div>
                    <?php if($bg_page_url){ ?>
                         <a class="ajaxdeletebck" href="javascript:void(0);" data-pid="<?php echo esc_attr($p_id); ?>" ><i data-original-title="<?php esc_html_e("Delete Background", "blackfyre");?>" data-toggle="tooltip" data-placement="right" class="fa fa-times"></i></a>
                    <?php } ?>

                    <script>
                  jQuery( document ).ready(function($) {

                            var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
                            jQuery('#change_page_bg_pic').click(function(e) {
                                DoChangeBg('<?php echo esc_attr($p_id); ?>');
                            });

                            function DoChangeBg(pid) {
                                var send_attachment_bkp = wp.media.editor.send.attachment;
                                wp.media.editor.send.attachment = function(props, attachment) {

                                        var styles = {
                                          background: "url("+attachment.url+")",
                                          display: 'block'
                                        };

                                        jQuery("body.single-clan").css(styles);

                                        var data = {
                                            'action': 'update_page_bg',
                                            'file': attachment.id,
                                            idp: pid
                                        };
                                        $.post(ajaxurl, data, function(response) {
                                            NotifyMe(response, "information");
                                        });

                                    wp.media.editor.send.attachment = send_attachment_bkp;
                                }
                                wp.media.editor.open();
                                return false;
                            }
                        });
                    </script>

<?php } ?>
<div id="mainwrap" class="container clan-page normal-page">
            <div class="profile-fimage profile-media-clan">

            <?php
            $bgpic = get_post_meta($p_id, 'clan_bg',true);
	        $bg_url = wp_get_attachment_url($bgpic);
            if(!empty($bg_url))
            {
                $imagebg = blackfyre_aq_resize($bg_url,  1170, 259, true, true, true ); //resize & crop img
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
                <div class="hiddenoverflow"><img alt="img" class="attachment-small wp-post-image" src="<?php echo esc_url(get_template_directory_uri()).'/img/defaults/default-banner.jpg'?> "/></div>
            <?php } ?>
            <?php if($is_mine or $is_admin){ ?>
                    <div id="change_bg_pic"><?php esc_html_e("Click to change", "blackfyre"); ?></div>
                    <script>
                        jQuery( document ).ready(function($) {

                            var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
                            //profile-media-clan
                            jQuery('.profile-media-clan').mouseenter(function(e) {
                                jQuery('#change_bg_pic').fadeTo('slow', 0.75);
                            });
                            jQuery('.profile-media-clan').mouseleave(function(e) {
                                jQuery('#change_bg_pic').fadeOut();
                            });
                            jQuery('.profile-media-clan').click(function(e) {
                                DoChangeBg('<?php echo esc_attr($p_id); ?>');
                            });
                            jQuery('#change_bg_pic').click(function(e) {
                                DoChangeBg('<?php echo esc_attr($p_id); ?>');
                            });
                            jQuery('.profile-media-clan').css("cursor", "pointer");
                            jQuery(".profile-media-clan img").css("cursor", "pointer");
                            jQuery('#change_bg_pic').css("cursor", "pointer");
                            function DoChangeBg(pid) {
                                var send_attachment_bkp = wp.media.editor.send.attachment;
                                wp.media.editor.send.attachment = function(props, attachment) {
                                    jQuery(".profile-media-clan img").fadeOut('fast', function(e) {
                                        jQuery(".profile-media-clan img").attr('src', attachment.url);
                                        jQuery(".profile-media-clan img").on('load', function(){
                                            jQuery(".profile-media-clan img").fadeIn(100);
                                            jQuery(".profile-media-clan img").css("cursor", "pointer");
                                        });
                                        var data = {
                                            'action': 'update_user_clan_bg',
                                            'file': attachment.id,
                                            idp: pid
                                        };
                                        $.post(ajaxurl, data, function(response) {
                                            NotifyMe(response, "information");
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
        <div class="col-lg-12 col-md-12 nav-top-divider"></div>
        </div>
        <div class="clear"></div>
           <?php if(!blackfyre_is_user($p_id,$c_id) && !blackfyre_is_admin($p_id,$c_id) && is_user_logged_in() && blackfyre_is_member_of_any_clan($c_id)){ ?>
                <a href="<?php echo blackfyre_get_permalink_for_template('tmp-clan-challenge'); ?>?pid=<?php echo esc_attr($p_id); ?>" class="button-small challenge-clan"><i class="fa fa-crosshairs"></i> <?php esc_html_e('Challenge ', 'blackfyre'); the_title();?></a>
             <?php } ?>
        <div class="clan-avatar-card">
                <?php $pf_url =  get_post_meta($p_id, 'clan_photo',true);

            if(!empty($pf_url))
            {
                $imagebg = blackfyre_aq_resize($pf_url,  211, 174, true, true, true ); //resize & crop img
                if (!isset ($imagebg[0]))
                {
                    $pfimage = $pfpic;
                }
                else
                {
                    $pfimage = $imagebg;
                }
                ?>
                <div class="hiddenoverflow"><img alt="img" src="<?php echo esc_url($pfimage); ?>" /></div>
            <?php }else{ ?>
                <div class="hiddenoverflow"><img alt="img" class="attachment-small wp-post-image" src="<?php echo esc_url(get_template_directory_uri()).'/img/defaults/default-clan.jpg'?> "/></div>
            <?php }

                if ($is_mine == true or $is_admin) {
                    ?>
                    <div id="change_profile_pic"><?php esc_html_e("Click to change", "blackfyre"); ?></div>
                    <script>
                        jQuery( document ).ready(function($) {

                            var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
                            //profile-media-clan
                            jQuery('.clan-avatar-card').mouseenter(function(e) {
                                jQuery('#change_profile_pic').fadeTo('slow', 0.75);
                            });
                            jQuery('.clan-avatar-card').mouseleave(function(e) {
                                jQuery('#change_profile_pic').fadeOut();
                            });
                            jQuery('.photo').click(function(e) {
                                DoChangeProfile('<?php echo esc_attr($p_id); ?>');
                            });
                            jQuery(".clan-avatar-card img").click(function(e) {
                                DoChangeProfile('<?php echo esc_attr($p_id); ?>');
                            });
                            jQuery('#change_profile_pic').click(function(e) {
                                DoChangeProfile('<?php echo esc_attr($p_id); ?>');
                            });
                            jQuery('.photo').css("cursor", "pointer");
                            var style = [{'cursor':'pointer','opacity':'1','display':'block'}];
                            jQuery(".clan-avatar-card img").css(style[0]);
                            jQuery('#change_profile_pic').css("cursor", "pointer");
                            function DoChangeProfile(pid) {
                                var send_attachment_bkp = wp.media.editor.send.attachment;
                                wp.media.editor.send.attachment = function(props, attachment) {
                                    jQuery(".clan-avatar-card img").fadeOut('slow', function(e) {
                                        jQuery(".clan-avatar-card img").attr('src', attachment.url);
                                        jQuery(".clan-avatar-card img").on('load', function(){
                                            jQuery(".clan-avatar-card img").fadeIn();
                                            var style = [{'cursor':'pointer','opacity':'1','display':'block'}];
                                            jQuery(".clan-avatar-card img").css(style[0]);
                                        });
                                        var data = {
                                            'action': 'update_clan_pic',
                                            'file': attachment.url,
                                            idp: pid
                                        };
                                        $.post(ajaxurl, data, function(response) {
                                           NotifyMe(response, "information");
                                        });
                                    });

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
        <div class="pmi_title">
            <h1>  <?php the_title(); ?></h1>

            <?php if(blackfyre_is_super_admin($p_id,$c_id) && !$_GET['vc_editable']){ ?>
                    <a href="#myModalDeleteClan" role="button" class="delete-clan" data-toggle="modal"><i data-original-title="<?php esc_html_e("Delete Clan", "blackfyre");?>" data-toggle="tooltip" class="fa fa-times"></i></a>
                <?php } ?>
        </div>
    <div class="project_page">
        <div class="row">

  <ul class="nav nav-tabs clan-nav">
        <li class="active"><a data-toggle="tab" href="#clan"><i class="fa fa-flag"></i>&nbsp;<?php esc_html_e('Clan Page', 'blackfyre');?></a></li>
        <li><a data-toggle="tab" href="#members_tab"><i class="fa fa-users"></i><?php esc_html_e(' Members', 'blackfyre');?></a>

        	<?php if(blackfyre_is_admin($p_id,$c_id)){
			$post_meta_arr = get_post_meta( $p_id, 'clan', true );
			if(isset($post_meta_arr['users']['pending'])){
				$pending_users = $post_meta_arr['users']['pending'];
			}else{
				$pending_users= 0;
			}

        	if(count($pending_users) > 0){	?>
	        <a class="msg_ntf" data-original-title="<?php esc_html_e("# of new member requests: ", 'blackfyre'); ?><?php echo esc_attr(count($pending_users)); ?>" data-toggle="tooltip" ><?php echo esc_attr(count($pending_users)); ?></a>
    	    <?php } ?>



		<?php } ?>

        </li>
        <li><a data-toggle="tab" href="#matches"><i class="fa fa-crosshairs"></i><?php esc_html_e(' Matches', 'blackfyre');?><?php ?></a>

        	<?php $matches = blackfyre_return_all_clan_matches($team_id[0]->id);
				  $br_notifikacija = 0;
			 foreach ($matches as $match) {
			 	 if($team_id[0]->id != $challenge->team1 && blackfyre_is_admin($p_id, get_current_user_id()) &&
			     ($match->status == 'submitted2' || $match->status == 'submitted1' || $match->status == 'deleted_req_team1' || $match->status == 'deleted_req_team2')){
			     	$br_notifikacija++;
				 }
			} ?>

        <?php if(blackfyre_is_admin($p_id,$c_id)){


        	$challenges = blackfyre_return_all_clan_challenges($team_id[0]->id);
			if(!isset($challenges)) $challenges = NULL;

			$edits = blackfyre_return_all_clan_edits($team_id[0]->id);
			if(!isset($edits)) $edits = NULL;

			if(isset($edits) && count($edits) > 0) $br_notifikacija = $br_notifikacija + count($edits);


			if(count($challenges) > 0 && $br_notifikacija > 0){
        	?>
        <a class="msg_ntf" data-original-title="<?php esc_html_e("# of notifications: ", 'blackfyre'); ?><?php echo count($challenges) + esc_attr($br_notifikacija); ?>" data-toggle="tooltip" ><?php echo count($challenges) + esc_attr($br_notifikacija); ?></a>
        <?php }elseif(count($challenges) > 0){ ?>

		<a class="msg_ntf" data-original-title="<?php esc_html_e("# of challenges: ", 'blackfyre'); ?><?php echo count($challenges); ?>" data-toggle="tooltip" ><?php echo count($challenges); ?></a>

		<?php }elseif($br_notifikacija > 0){ ?>
		<a class="msg_ntf" data-original-title="<?php esc_html_e("# of notifications: ", 'blackfyre'); ?><?php echo esc_attr($br_notifikacija); ?>" data-toggle="tooltip" ><?php echo esc_attr($br_notifikacija); ?></a>
		<?php } } ?>
        </li><!-- / Matches -->
        <?php if(blackfyre_is_admin($p_id,$c_id)){ ?>
        <li><a href="<?php echo esc_url(admin_url()).'post.php?vc_action=vc_inline&post_id='.$p_id.'&post_type=clan&ed=true' ?>"><i class="fa fa-cog"></i>&nbsp;<?php esc_html_e('Settings', 'blackfyre');?></a></li>
        <?php } ?>
  </ul>
<div class="tab-content">
         <!--clan-->
        <div id="clan" class="tab-pane active">
                <div class="p_main_info">

                    <div class="pmi_main">
                        <div>
                        <?php while ( have_posts() ) : the_post(); ?>
                                <?php the_content();?>
                        <?php endwhile; // end of the loop. ?>
                        </div>
                    </div>
                <div class="clear"></div>
                </div>
                         <div class="clear"></div>
        </div>
        <!--/clan-->

        <!--members-->
        <div id="members_tab" class="tab-pane">

<!-- HTML START -->

    <div class="members friends members-block" id="buddypress">
         <?php blackfyre_clan_members($p_id);?>
    </div>
	<script>

		jQuery('#buddypress').on('click', '#pag-top.pagination a, #pag-bottom.pagination a', function(event){
			event.preventDefault();
			jQuery('#buddypress').load(ajaxurl, {
				"action":"blackfyre_clan_members_ajax",
				"page":jQuery(this).attr('href'),
				"pid":<?php echo esc_js($post->ID); ?>,
				"uid":<?php echo esc_js($current_user->ID); ?>
				});
		});
	</script>

<!-- HTML ENDS -->

        </div>
        <!--/members-->

        <!--matches-->
        <div id="matches" class="tab-pane clanpage-matches">


            <?php if(!empty($matches[0])){ ?>

             <?php

                   $results_matches = blackfyre_return_match_score($matches[0]->id);
                   $t1 = $results_matches[0]->team1_tickets;
                   $t2 = $results_matches[0]->team2_tickets;
                   $wl_class1 = $t1 < $t2 ? 'lose' : ($t1 > $t2 ? 'win' : '');
                   $wl_class2 = $t1 > $t2 ? 'lose' : ($t1 < $t2 ? 'win' : '');


                if($matches[0]->status == 'active'){

                    $status = '';
                }else{
                $status1 = $t1 == $t2 ? '' : ($t1 > $t2 ? 'win' : 'lose');
                $status2 = $t1 == $t2 ? '' : ($t1 < $t2 ? 'win' : 'lose');
                } ?>

                <?php if(blackfyre_is_admin($p_id, get_current_user_id()) || blackfyre_is_admin($p_id, get_current_user_id())){
                  $admin = true; }else{ $admin = false; } ?>

            <?php if($matches[0]->status == 'submitted1' || $matches[0]->status == 'submitted2'){
                  $substatus = true; }else{ $substatus = false; } ?>

            <a href="<?php echo esc_url(get_permalink($matches[0]->post_id)); ?>" class="match-fimage-wrapper">
                <div class="profile-fimage match-fimage">
                <div class="mminfow"><div class="mminfo">
                	<?php if(strtotime(date('F j, Y, g:i a')) > strtotime($matches[0]->date)){ ?>
                	<span><?php esc_html_e("LAST MATCH:",'blackfyre');?>&nbsp;</span><strong>
                	<?php }else{ ?>
                	<span><?php esc_html_e("NEXT MATCH:",'blackfyre');?>&nbsp;</span><strong>
                	<?php } ?>
                	<?php echo esc_attr($matches[0]->title); ?></strong>  <i class="fa fa-calendar"></i>  <?php echo date("F j, Y, g:i a", strtotime($matches[0]->date)); ?></div></div>
                <div class="dots"></div>
                 <div class="hiddenoverflow"><img alt="img" class="attachment-small wp-post-image" src="<?php echo esc_url(blackfyre_return_game_banner($matches[0]->game_id)); ?>"></div>
                <div class="clan-a">
                     <div class="clanimgw">
                    <img alt="img" src="<?php echo esc_url(blackfyre_return_clan_image_big($matches[0]->team1)); ?>" />
                        <?php if($matches[0]->status == 'done'){ ?>

                         <div class="clanmfs <?php echo esc_attr($wl_class1); ?>"><span><?php $r1 = $t1 == NULL ? '0' : $t1; echo esc_attr($r1); ?></span></div>

                        <?php }else{ ?>

                       <?php if($admin && $substatus){ ?>
                        <div class="clanmfs <?php echo esc_attr($wl_class1); ?>"><span><?php $r1 = $t1 == NULL ? '0' : $t1; echo esc_attr($r1); ?></span></div>
                        <?php }else{ ?>
                        <div class="clanmfs"><span>0</span></div>
                        <?php } ?>


                        <?php } ?>
                    </div>
                    <div class="pmi_title"><?php $name1 = blackfyre_return_team_name_by_team_id($matches[0]->team1); echo esc_attr($name1[0]->title); ?></div>
                </div>
                <div class="mversus"><?php esc_html_e('vs', 'blackfyre'); ?>
                <?php if($team_id[0]->id != $matches[0]->team1 && blackfyre_is_admin($p_id, get_current_user_id()) &&
                          ($matches[0]->status == 'submitted2' || $matches[0]->status == 'submitted1' || $matches[0]->status == 'deleted1' || $matches[0]->status == 'deleted2')){ ?>
                	<i class="deletematch">!</i>
                <?php } ?>
                </div>
                <div class="clan-b">
                      <div class="clanimgw">
                    <img alt="img" src="<?php echo esc_url(blackfyre_return_clan_image_big($matches[0]->team2)); ?>" />

                        <?php if($matches[0]->status == 'done'){ ?>

                       <div class="clanmfs <?php echo esc_attr($wl_class2); ?>"><span><?php $r2 = $t2 == NULL ? '0' : $t2; echo esc_attr($r2); ?></span></div>

                        <?php }else{ ?>

                       <?php if($admin && $substatus){ ?>
                        <div class="clanmfs <?php echo esc_attr($wl_class2); ?>"><span><?php $r2 = $t2 == NULL ? '0' : $t2; echo esc_attr($r2); ?></span></div>
                        <?php }else{ ?>
                        <div class="clanmfs"><span>0</span></div>
                        <?php } ?>


                        <?php } ?>
                    </div>
                    <div class="pmi_title"><?php $name2 = blackfyre_return_team_name_by_team_id($matches[0]->team2); echo esc_attr($name2[0]->title); ?></div>
                </div>

                <div class="col-lg-12 col-md-12 nav-top-divider"></div>
            </div><div class="clear"></div>
            </a>
            <?php } ?>

            <?php if(blackfyre_is_admin($p_id, get_current_user_id())){ ?>
                 <!-- CHALLENGES -->
            <?php $challenges = blackfyre_return_all_clan_challenges($team_id[0]->id);

			 if(!empty($challenges)){ ?>

			  <div class="title-wrapper"><h3 class="widget-title"><?php esc_html_e('Challenges!', 'blackfyre'); ?></h3><div class="clear"></div></div>
              <ul class="cmatchesw challenges">
            <?php   foreach ($challenges as $challenge) { ?>

                <li class="notsubmitted">
                	<div class="member-list-wrapper">
	                    <a href="<?php echo esc_url(get_permalink($challenge->post_id)); ?>">
	                        <div class="clana">
	                            <img alt="img" src="<?php echo esc_url(blackfyre_return_clan_image($challenge->team1)); ?>" class="avatar" />
	                            <span>0</span>
	                        </div>
	                        <strong><?php esc_html_e('VS', 'blackfyre'); ?></strong>
	                        <div class="clanb">
	                            <img alt="img" src="<?php echo esc_url(blackfyre_return_clan_image($challenge->team2)); ?>"  class="avatar" />
	                            <span>0</span>
	                        </div>
	                        <div class="minfo">
	                            <strong><?php echo esc_attr($challenge->title); ?></strong>
	                            <i class="fa fa-calendar"></i> <?php echo ' '; echo date("F j, Y, g:i a", strtotime($challenge->date)); ?>
	                        </div>
	                        <div class="matchgame"><img alt="img" src="<?php echo esc_url(blackfyre_return_game_image($challenge->game_id)); ?>" class="mgame" /></div>
	                        <div class="matchstatus"></div>
	                        <div class="clear"></div>
	                    </a>
                    </div>
                    <div class="member-list-more">
                    	<div class="mlm1 mj">

                    	    <?php if($team_id[0]->id == $challenge->team1){ ?>
                    		       <?php esc_html_e('Pending challenge!','blackfyre'); ?>
		               		<?php }else{ ?>
		               		    <a href="<?php echo esc_url(get_permalink(blackfyre_return_team_post__by_team_id($challenge->team1)->post_id)); ?>"><?php $n = blackfyre_return_team_name_by_team_id($challenge->team1); echo esc_attr($n[0]->title); ?></a>
		               		    &nbsp;<?php esc_html_e('has challenged you to a match! - Accept the challenge?', 'blackfyre'); ?>
                                <a class="ajaxloadchl"  data-req="accept_challenge" data-cid="<?php echo esc_attr($challenge->id); ?>"><i class="fa fa-check"></i></a>
                                <a class="ajaxloadchl"  data-req="reject_challenge" data-cid="<?php echo esc_attr($challenge->id); ?>"><i class="fa fa-times"></i></a>
		               		<?php } ?>
		            	</div>
                    </div>
                </li>

            <?php } ?>
            </ul>
            <div class="nav-divider-wrapper"><div class="col-lg-12 col-md-12 nav-top-divider"></div></div>
           <!-- /CHALLENGES -->
			<?php } ?>


			<!-- /EDITS -->
 <?php

            		$edits = blackfyre_return_all_clan_edits($team_id[0]->id);
			 if(!empty($edits)){ ?>

			  <div class="title-wrapper"><h3 class="widget-title"><?php esc_html_e('Edits!', 'blackfyre'); ?></h3><div class="clear"></div></div>
              <ul class="cmatchesw challenges">
            <?php   foreach ($edits as $edit) {  ?>

                <li class="notsubmitted">
                	<div class="member-list-wrapper">
	                    <a href="<?php echo esc_url(get_permalink($edit->post_id)); ?>">
	                        <div class="clana">
	                            <img alt="img" src="<?php echo esc_url(blackfyre_return_clan_image($edit->team1)); ?>" class="avatar" />
	                            <span>0</span>
	                        </div>
	                        <strong><?php esc_html_e('VS', 'blackfyre'); ?></strong>
	                        <div class="clanb">
	                            <img alt="img" src="<?php echo esc_url(blackfyre_return_clan_image($edit->team2)); ?>"  class="avatar" />
	                            <span>0</span>
	                        </div>
	                        <div class="minfo">
	                            <strong><?php echo esc_attr($edit->title); ?></strong>
	                            <i class="fa fa-calendar"></i> <?php echo ' '; echo date(get_option('date_format').' '.get_option('time_format'), strtotime($edit->date)); ?>
	                        </div>
	                        <div class="matchgame"><img alt="img" src="<?php echo esc_url(blackfyre_return_game_image($edit->game_id)); ?>" class="mgame" /></div>
	                        <div class="matchstatus"></div>
	                        <div class="clear"></div>
	                    </a>
                    </div>
                    <div class="member-list-more">
                    	<div class="mlm1 mj">
                    		<?php $pid1 = blackfyre_return_team_post__by_team_id($edit->team1);
								  $pid2 = blackfyre_return_team_post__by_team_id($edit->team2); ?>

							<?php if($edit->status == 'edited2' && blackfyre_is_member($pid2->post_id,$c_id)){ ?>
                    		       <?php esc_html_e('Pending edit!','blackfyre'); ?>
		               		<?php }elseif($edit->status == 'edited2' && blackfyre_is_member($pid1->post_id,$c_id)){ ?>
		               		    <a href="<?php echo get_permalink(blackfyre_return_team_post__by_team_id($edit->team2)->post_id); ?>"><?php $n = blackfyre_return_team_name_by_team_id($edit->team2); echo esc_attr($n[0]->title); ?></a>
		               		    &nbsp;<?php esc_html_e('has edited a challenge! - Accept the changes?', 'blackfyre'); ?>
                                <a class="ajaxloadedit"  data-req="accept_edit" data-cid="<?php echo esc_attr($edit->id); ?>"><i class="fa fa-check"></i></a>
                                <a class="ajaxloadedit"  data-req="reject_edit" data-cid="<?php echo esc_attr($edit->id); ?>"><i class="fa fa-times"></i></a>
		               		<?php } ?>

		               		<?php if($edit->status == 'edited1' && blackfyre_is_member($pid1->post_id,$c_id)){ ?>
                    		       <?php esc_html_e('Pending edit!','blackfyre'); ?>
		               		<?php }elseif($edit->status == 'edited1' && blackfyre_is_member($pid2->post_id,$c_id)){ ?>
		               		    <a href="<?php echo get_permalink(blackfyre_return_team_post__by_team_id($challenge->team1)->post_id); ?>"><?php $n = blackfyre_return_team_name_by_team_id($edit->team1); echo esc_attr($n[0]->title); ?></a>
		               		    &nbsp;<?php esc_html_e('has edited a challenge! - Accept the changes?', 'blackfyre'); ?>
                                <a class="ajaxloadedit"  data-req="accept_edit" data-cid="<?php echo esc_attr($edit->id); ?>"><i class="fa fa-check"></i></a>
                                <a class="ajaxloadedit"  data-req="reject_edit" data-cid="<?php echo esc_attr($edit->id); ?>"><i class="fa fa-times"></i></a>
		               		<?php } ?>
		            	</div>
                    </div>
                </li>

            <?php } ?>
            </ul>
            <div class="nav-divider-wrapper"><div class="col-lg-12 col-md-12 nav-top-divider"></div></div>



			 <!-- /EDITS -->
            <?php } ?>


			<!-- /DELETES -->
			<?php

            		$deletes = blackfyre_return_all_clan_deletes($team_id[0]->id);

			 if(!empty($deletes)){ ?>

			  <div class="title-wrapper"><h3 class="widget-title"><?php esc_html_e('Deletes!', 'blackfyre'); ?></h3><div class="clear"></div></div>
              <ul class="cmatchesw challenges">
            <?php   foreach ($deletes as $delete) { ?>

                <li class="notsubmitted">
                	<div class="member-list-wrapper">
	                    <a href="<?php echo esc_url(get_permalink($delete->post_id)); ?>">
	                        <div class="clana">
	                            <img alt="img" src="<?php echo esc_url(blackfyre_return_clan_image($delete->team1)); ?>" class="avatar" />
	                            <span>0</span>
	                        </div>
	                        <strong><?php esc_html_e('VS', 'blackfyre'); ?></strong>
	                        <div class="clanb">
	                            <img alt="img" src="<?php echo esc_url(blackfyre_return_clan_image($delete->team2)); ?>"  class="avatar" />
	                            <span>0</span>
	                        </div>
	                        <div class="minfo">
	                            <strong><?php echo esc_attr($delete->title); ?></strong>
	                            <i class="fa fa-calendar"></i> <?php echo ' '; echo date(get_option('date_format').' '.get_option('time_format'), strtotime($delete->date)); ?>
	                        </div>
	                        <div class="matchgame"><img alt="img" src="<?php echo esc_url(blackfyre_return_game_image($delete->game_id)); ?>" class="mgame" /></div>
	                        <div class="matchstatus"></div>
	                        <div class="clear"></div>
	                    </a>
                    </div>
                    <div class="member-list-more">
                    	<div class="mlm1 mj">
							<?php $pid1 = blackfyre_return_team_post__by_team_id($delete->team1);
								  $pid2 = blackfyre_return_team_post__by_team_id($delete->team2); ?>

							<?php if($delete->status == 'deleted_req_team2' && blackfyre_is_member($pid2->post_id,$c_id)){ ?>
                    		       <?php esc_html_e('Pending delete!','blackfyre'); ?>
		               		<?php }elseif($delete->status == 'deleted_req_team2' && blackfyre_is_member($pid1->post_id,$c_id)){ ?>
		               		    <a href="<?php echo get_permalink(blackfyre_return_team_post__by_team_id($delete->team2)->post_id); ?>"><?php $n = blackfyre_return_team_name_by_team_id($delete->team2); echo esc_attr($n[0]->title); ?></a>
		               		    &nbsp;<?php esc_html_e('has submitted delete request! -  Accept?', 'blackfyre'); ?>
                                <a class="ajaxdeletematch"  data-req="accept_delete" data-pid="<?php echo esc_attr($delete->post_id); ?>" data-mid="<?php echo esc_attr($delete->id); ?>"><i class="fa fa-check"></i></a>
                                <a class="ajaxdeletematch"  data-req="reject_delete" data-pid="<?php echo esc_attr($delete->post_id); ?>" data-mid="<?php echo esc_attr($delete->id); ?>"><i class="fa fa-times"></i></a>
		               		<?php } ?>

                    	    <?php if($delete->status == 'deleted_req_team1' && blackfyre_is_member($pid1->post_id,$c_id)){ ?>
                    		       <?php esc_html_e('Pending delete!','blackfyre'); ?>
		               		<?php }elseif($delete->status == 'deleted_req_team1' && blackfyre_is_member($pid2->post_id,$c_id)){ ?>
		               		    <a href="<?php echo get_permalink(blackfyre_return_team_post__by_team_id($delete->team1)->post_id); ?>"><?php $n = blackfyre_return_team_name_by_team_id($delete->team1); echo esc_attr($n[0]->title); ?></a>
		               		    &nbsp;<?php esc_html_e('has submitted delete request! -  Accept?', 'blackfyre'); ?>
                                <a class="ajaxdeletematch"  data-req="accept_delete" data-pid="<?php echo esc_attr($delete->post_id); ?>" data-mid="<?php echo esc_attr($delete->id); ?>"><i class="fa fa-check"></i></a>
                                <a class="ajaxdeletematch"  data-req="reject_delete" data-pid="<?php echo esc_attr($delete->post_id); ?>" data-mid="<?php echo esc_attr($delete->id); ?>"><i class="fa fa-times"></i></a>
		               		<?php } ?>


		            	</div>
                    </div>
                </li>

            <?php } ?>
            </ul>
            <div class="nav-divider-wrapper"><div class="col-lg-12 col-md-12 nav-top-divider"></div></div>



			 <!-- /DELETES -->
            <?php } ?>

            <?php } ?>
				<?php
                if(!empty($challenges)){
					$challenge_ids = array();
					foreach($challenges as $challenge){
						$challenge_ids[] = $challenge->ID;
					}
					foreach($matches as $key=>$match){
						foreach ($challenge_ids as $challenge_id) {
							if($challenge_id == $match->ID)
							unset($matches[$key]);
						}
					}
				}

				if(!empty($edits)){
					$edit_ids = array();
					foreach($edits as $edit){
						$edit_ids[] = $edit->ID;
					}
					foreach($matches as $key=>$match){
						foreach ($edit_ids as $edit_id) {
							if($edit_id == $match->ID)
							unset($matches[$key]);
						}
					}
				}

				if(!empty($deletes)){
					$delete_ids = array();
					foreach($deletes as $delete){
						$delete_ids[] = $delete->ID;
					}
					foreach($matches as $key=>$match){
						foreach ($delete_ids as $delete_id) {
							if($delete_id == $match->ID)
							unset($matches[$key]);
						}
					}
				}

                unset($matches[0]);
                 ?>

                <?php if(!empty($matches)){ ?>
                <ul class="cmatchesw nochallenges">

               <?php

                foreach ($matches as $match) {

                $results_matches = blackfyre_return_match_score($match->id);

                $t1 = $results_matches[0]->team1_tickets;
                $t2 = $results_matches[0]->team2_tickets;

                if($match->status == 'active' || $match->status == 'submitted1' || $match->status == 'submitted2'){

                    $status = 'notsubmitted';
                }else{

                $status = $t1 == $t2 ? 'mtie' : ($t1 > $t2 ? 'mwin' : 'mlose');
                }
                $teams = blackfyre_return_teams_by_match_id($match->id);
                $team1 = $teams->team1;
                $team2 = $teams->team2;
                $tim1 = blackfyre_return_post_id_by_match_id(blackfyre_return_team_ids_from_match_by_match_id($match->id)->team1);
                $tim2 = blackfyre_return_post_id_by_match_id(blackfyre_return_team_ids_from_match_by_match_id($match->id)->team2);
                 if(blackfyre_is_admin($tim1->post_id, get_current_user_id())){
                    $team = 'team1';
                }elseif(blackfyre_is_admin($tim2->post_id, get_current_user_id())){
                    $team = 'team2';
                }

                if(blackfyre_is_admin($p_id, get_current_user_id()) || blackfyre_is_admin($p_id, get_current_user_id())){
                  $admin = true; }else{ $admin = false; }

                if($match->status == 'submitted1' || $match->status == 'submitted2'){
                  $substatus = true; }else{ $substatus = false; }
                ?>
                 <li class="<?php echo esc_attr($status); ?>">

                    <a href="<?php echo esc_url(get_permalink($match->post_id)); ?>">
                        <?php if(!isset($challenge->team1)){$challenge = new stdClass();$challenge->team1 = '';} ?>
                          <?php if($team_id[0]->id != $challenge->team1 && blackfyre_is_admin($p_id, get_current_user_id()) &&
                          ($match->status == 'submitted2' || $match->status == 'submitted1' || $match->status == 'deleted_req_team1' || $match->status == 'deleted_req_team2')){ ?>
                            <i class="deletematch">!</i>
                            <?php } ?>
                        <div class="clana">
                            <img alt="img" src="<?php echo esc_url(blackfyre_return_clan_image($match->team1)); ?>" class="avatar" />

                           <?php if($match->status == 'done') { ?>

                           <span><?php $r1 = $t1 == NULL ? '0' : $t1; echo esc_attr($r1); ?></span>

                           <?php }else{ ?>


                            <?php if($admin && $substatus){ ?>
                            <span><?php $r1 = $t1 == NULL ? '0' : $t1; echo esc_attr($r1); ?></span>
                            <?php }else{ ?>
                            <span>0</span>
                            <?php } ?>

                             <?php } ?>

                        </div>
                        <strong><?php esc_html_e('VS', 'blackfyre'); ?></strong>
                        <div class="clanb">
                            <img alt="img" src="<?php echo esc_url(blackfyre_return_clan_image($match->team2)); ?>"  class="avatar" />

                            <?php if($match->status == 'done') { ?>

                             <span><?php $r2 = $t2 == NULL ? '0' : $t2; echo esc_attr($r2); ?></span>

                            <?php }else{ ?>

                             <?php if($admin && $substatus){ ?>
                            <span><?php $r2 = $t2 == NULL ? '0' : $t2; echo esc_attr($r2); ?></span>
                            <?php }else{ ?>
                            <span>0</span>
                            <?php } ?>

                            <?php } ?>


                        </div>
                        <div class="minfo">
                            <strong><?php echo esc_attr($match->title); ?></strong>
                            <i class="fa fa-calendar"></i> <?php echo date("F j, Y, g:i a", strtotime($match->date)); ?>
                        </div>
                        <div class="matchgame"><img alt="img" src="<?php echo esc_url(blackfyre_return_game_image($match->game_id)); ?>" class="mgame" /></div>
                        <div class="matchstatus"></div>
                        <div class="clear"></div>
                    </a>
                </li>

                <?php }  ?>
            </ul>
            <?php } ?>

            <?php $matc = blackfyre_return_all_clan_matches($team_id[0]->id); ?>
                 <?php if(empty($matc) && empty($challenges) && blackfyre_is_admin($p_id, get_current_user_id())){ ?>
                  <div class="error_msg"><span>
                  <?php   esc_html_e('Currently you don\'t have any matches, go and challenge someone!', 'blackfyre'); ?>
                  </span></div>
            <?php }elseif(empty($matc) && empty($challenges) && !blackfyre_is_admin($p_id, get_current_user_id())){ ?>
                  <div class="error_msg"><span>
                  <?php   esc_html_e('This clan currently doesn\'t have any matches!', 'blackfyre'); ?>
                  </span></div>

            <?php } ?>
        </div>
        <!--/matches-->

</div><!-- tab conent -->

        </div><!-- row -->
    </div> <!-- /container -->
</div><!-- /mainwrap -->


<?php if($challenge_sent == 'yes'){ ?>
<script>
  jQuery( document ).ready(function($) {
  NotifyMe(settingsNoty.challenge_request_sent, "information");
  });
</script>
<?php
blackfyre_challenge_email($c_id, $p_id);
?>
<?php $challenge_sent = ''; } ?>
<?php get_footer(); ?>