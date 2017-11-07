
    <footer class="<?php if ( of_get_option('fullwidth') ) {  }else{ ?>container<?php } ?>">

    	<?php if ( function_exists( 'dynamic_sidebar' ) && is_active_sidebar( 'footer' ) ) : ?>

    		<?php if ( of_get_option('fullwidth') ) { ?><div class="container"><?php } ?>

    			<div class="col-lg-12 col-md-12">
    				<?php dynamic_sidebar( 'footer' ); ?>
    			</div>

    		<?php if ( of_get_option('fullwidth') ) { ?></div><?php } ?>

    	<?php endif; ?>

		<!--
      <?php if ( of_get_option('fullwidth') ) { ?><div class="container"><?php } ?>
      <div class="span12">
           <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer widgets') ) : ?>
                <?php dynamic_sidebar('footer'); ?>
           <?php endif; ?>
      </div>
    <?php if ( of_get_option('fullwidth') ) { ?></div><?php } ?>
    -->

<?php  echo of_get_option('googlean'); ?>

<?php if(function_exists('bbp_has_forums')){
            if ( bbp_has_forums() ){ ?>
<script>
/*global jQuery:false */
var forumtitle = jQuery('.bbpress .title_wrapper h1');
var newforumtitle = "<?php esc_html_e('Forums', 'blackfyre'); ?>";
forumtitle.html(newforumtitle);
</script>

<?php }} ?>

<script>
    function social_startlogin(provider, proceed) {
        "use strict";
        var CurrentLocation = "<?php
        if (is_single()) {
            echo esc_url(wp_get_shortlink());
        } else {
        	 if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
        	 	echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        	 }else{
        	 	echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        	 }

        }

        ?>";
        window.location.replace(settings.authlocation+"handler/index.php?initiatelogin=" + provider + "&returnto=" + encodeURIComponent(CurrentLocation));
    }
    <?php
    if (isset($_SESSION['needtorefresh'])) {
        if ($_SESSION['needtorefresh'] == true) {
            unset ($_SESSION['needtorefresh']);
            echo 'setTimeout(function(){
                   window.location.reload(1);
                }, 1000);';
        }
    }

    ?>

</script>

<script type="text/javascript">var switchTo5x=true;</script>
<?php if(of_get_option('share_this')){ ?>
<?php if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') { ?>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<?php }else{ ?>
<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
<?php } ?>
<?php } ?>
<script type="text/javascript">stLight.options({publisher: "792f28c8-2c7b-4057-a45f-90bfa085bb60", doNotHash: false, doNotCopy: true, hashAddressBar: false});</script>

<!-- AJAX CALLS -->
<?php
if(!isset($data['scores'])){$data['scores']='';}


if (get_post_type() == 'matches') {
  $myid = get_current_user_id();
  if ($myid > 0) {
  	global $wpClanWars;
    $myteams = blackfyre_get_user_clans($myid);
	$match_id = blackfyre_return_match_id_by_post_id($post->ID);
	$match = $wpClanWars->get_match(array('id' => $match_id[0]->id, 'sum_tickets' => true));
	if(!empty($myteams)){
	      foreach ($myteams as $team){
		   $team_id = blackfyre_return_team_id_by_post_id($team);
	        if ($match[0]->team1 == $team_id[0]->id) {
	          $takehome = $team;
	        }
	        if ($match[0]->team2 == $team_id[0]->id) {
	          $takehome = $team;
	        }
	      }
	  }
  }
}

if (!empty($takehome)) {
  $goingto = get_permalink($takehome);
} else {
  $goingto = get_site_url();
}
?>

     <script type="text/javascript">

                jQuery(document).ready(function ($) {

                      $('#score_fin').on('click', 'a.ajaxsubmitscore', function(){
                            "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_match_score_acc_rej",  "req":$(this).attr('data-req'), "mid":$(this).attr('data-mid') },
                                success: function(data) {
                                   if(data == 'accepted'){
                                    NotifyMe(settingsNoty.score_accepted, "information");
                                   }else if(data == 'rejected'){
                                    NotifyMe(settingsNoty.score_rejected, "information");
                                   }
                                   location.reload();
                                   return false;
                                }
                            });
                        });

                      $('#matches').on('click', 'a.ajaxdeletematch', function(){
                            "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_match_delete", "pid":$(this).attr('data-pid'), "req":$(this).attr('data-req'),  "mid":$(this).attr('data-mid')},
                                success: function(data) {
                                	if(data[1] == 'accepted'){

                                   NotifyMe(settingsNoty.delete_accepted, "information");
                                   var delete_match = $( ".mj" ).find("[data-mid='" + data[0] + "']");
                                   delete_match.parent().empty().html("<?php esc_html_e("Delete accepted!", "blackfyre"); ?>");

                                   }else if(data[1] == 'rejected'){

                                   NotifyMe(settingsNoty.delete_rejected, "information");
                                   var delete_match = $( ".mj" ).find("[data-mid='" + data[0] + "']");
                                   delete_match.parent().empty().html("<?php esc_html_e("Delete rejected!", "blackfyre"); ?>");

                                   }

                                   return false;
                                }
                            });
                        });


						$('#mtch').on('click', 'a.ajaxdeletematch_single', function(){
                            "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {"action": "blackfyre_match_delete_single",  "pid":$(this).attr('data-pid'), "mid":$(this).attr('data-mid')},
                                success: function(data) {
                                   NotifyMe(settingsNoty.match_deleted_request, "information");
                                   location.reload();
                                   return false;
                                }
                            });
                        });


                        $('#score_fin').on('click', 'a.ajaxdeletematchconfirmation', function(){
                            "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_match_delete_confirmation", "pid":$(this).attr('data-pid'), "req":$(this).attr('data-req'), "mid":$(this).attr('data-mid')},
                                success: function(data) {
                                  if(data == "accepted"){
                                   NotifyMe(settingsNoty.match_deleted, "information");
                                   window.location.replace("<?php echo esc_url($goingto); ?>");
                                  }else if(data == "rejected"){
                                  	NotifyMe(settingsNoty.match_delete_rejected, "information");
                                  	 location.reload();
                                  }

                                   return false;
                                }
                            });
                        });


                         $('#score_fin').on('click', 'a.ajaxloadchlsingle', function(){
                            "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_challenge_acc_rej_single", "req":$(this).attr('data-req'), "cid":$(this).attr('data-cid')},
                                success: function(data) {
                                   if(data == "accepted"){
                                   NotifyMe(settingsNoty.challenge_accepted, "information");
                                   var challenge = $( "#score_fin" );
                                   challenge.empty().html("<?php esc_html_e("Challenge accepted!", "blackfyre"); ?>");

                                   }else if(data == 'rejected'){
                                   NotifyMe(settingsNoty.challenge_rejected, "information");
                                   var challenge = $( "#score_fin" );
                                   challenge.empty().html("<?php esc_html_e("Challenge rejected!", "blackfyre"); ?>");

                                   }
                                   location.reload();
                                   return false;
                                }
                            });
                        });


                        $('#matches').on('click', 'a.ajaxloadchl', function(){
                            "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_challenge_acc_rej",  "req":$(this).attr('data-req'), "cid":$(this).attr('data-cid') },
                                success: function(data) {
                                   if(data[1] == 'accepted'){

                                   NotifyMe(settingsNoty.challenge_accepted, "information");
                                   var challenge = $( ".mj" ).find("[data-cid='" + data[0] + "']");
                                   challenge.parent().empty().html("<?php esc_html_e("Challenge accepted!", "blackfyre"); ?>");

                                   }else if(data[1] == 'rejected'){

                                   NotifyMe(settingsNoty.challenge_rejected, "information");
                                   var challenge = $( ".mj" ).find("[data-cid='" + data[0] + "']");
                                   challenge.parent().empty().html("<?php esc_html_e("Challenge rejected!", "blackfyre"); ?>");

                                   }

                                   return false;
                                }
                            });
                        });



                    $('#clan').on('click', 'a.ajaxloadblock', function(event){

                            "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_change_membership_block",  "req": $(this).attr('data-req'), "pid": $(this).attr('data-pid'),"uid": $(this).attr('data-uid') },
                                success: function(data) {
                                  if(data[0] == "join_clan"){
                                    NotifyMe(settingsNoty.join_clan, "information");
                                    var join_button = $('.ajaxloadblock');
                                    var join_container = $('.clan-members-app');
                                    join_button.remove();
                                    join_container.append("<div id='score_fin' class='error_msg'><?php esc_html_e("Your request to join clan is pending!", "blackfyre");?></div>").fadeIn('slow');

                                   }else if(data[0] == 'remove_friend_user'){
                                    NotifyMe(settingsNoty.remove_friend, "information");
                                    var leave_button = $('.ajaxloadblock');
                                    var members_area = $('.clan-members-app');
                                    leave_button.remove();
                                    members_area.append("<div id='score_fin' class='error_msg'><?php esc_html_e("Removed from clan!", "blackfyre"); ?></div>");

                                   }else if(data[0] == 'cancel_request'){
                                    NotifyMe(settingsNoty.remove_friend, "information");
                                    var members_area = $('.clan-members-app');
                                    var noti = $('#score_fin');
                                    var leave_button = $('.ajaxloadblock');
                                    leave_button.remove();
                                    noti.remove();
                                    members_area.append("<div id='score_fin' class='error_msg'><?php esc_html_e("Request canceled!", "blackfyre"); ?></div>");

                                   }
                                   return false;
                                }
                            });
                    });


                     $('#myModalDeleteClan').on('click', 'a.ajaxdeleteclan', function(){
                         "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {"action": "blackfyre_clan_delete", "pid":$(this).attr('data-pid') },
                                success: function(data) {
                                   var modal = $('#myModalDeleteClan');
                                   var modalblack = $('.modal-backdrop');
                                   modal.remove();
                                   modalblack.remove();
                                   NotifyMe(settingsNoty.clan_deleted, "information");
                                   window.location.replace("<?php echo esc_url(home_url()); ?>");
                                   return false;
                                }
                            });
                        });


                    $('#members-list-fn').on('click', 'a.ajaxloadletjoin', function(){
                        "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_change_membership_let_join",  "req": $(this).attr('data-req'), "pid": $(this).attr('data-pid'),"uid": $(this).attr('data-uid') },
                                success: function(data) {

                                  if(data[0] == 'let_this_member_join'){
                                    NotifyMe(settingsNoty.let_this_member_join, "information");
                                    var user = $('.'+data[1]+' .member-list-more');
                                    var user_pen = $('.'+data[1]+'');
                                    var user_pen_text = $('.'+data[1]+' .pending-text');
                                    user.empty().html("<div class='mlm1 mj'><?php esc_html_e("User joined!", "blackfyre"); ?></div>");
                                    user_pen.removeClass("pending");
                                    user_pen_text.remove();

                                   }

                                   return false;
                                }
                            });
                    });


                     $('#members-list-fn').on('click', 'a.ajaxloadremoveadmin', function(){
                        "use strict";
                            $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_change_membership_remove_friend_admin",  "req": $(this).attr('data-req'), "pid": $(this).attr('data-pid'),"uid": $(this).attr('data-uid') },
                                success: function(data) {

                                  if(data[0] == 'remove_friend_admin'){
                                    NotifyMe(settingsNoty.remove_friend, "information");
                                    var user = $('.'+data[1]+' .member-list-more');
                                    var user_pen = $('.'+data[1]+'');
                                    var user_pen_text = $('.'+data[1]+' .pending-text');
                                    user.empty().html("<div class='mlm1 mj'><?php esc_html_e("Removed from clan!", "blackfyre"); ?></div>");
                                    user_pen.removeClass("pending");
                                    user_pen_text.remove();


                                   }

                                   return false;
                                }
                            });
                    });


                    $('#members-list-fn .ajaxloadmakeadmin').live('click', function(event){
                        "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_change_membership_make_administrator",  "req": $(this).attr('data-req'), "pid": $(this).attr('data-pid'),"uid": $(this).attr('data-uid') },
                                success: function(data) {

                                 if(data[0] == 'make_administrator'){
                                    NotifyMe(settingsNoty.make_administrator, "information");
                                    var user = $('.'+data[1]+' .member-list-more');
                                    user.empty().html("<div class='mlm1 mj'><?php esc_html_e("Added as administrator!", "blackfyre"); ?></div>");

                                    }

                                   return false;
                                }
                            });
                    });


                    $('#members-list-fn .ajaxloaddowngrade').live('click', function(event){
                            "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_change_membership_downgrade_to_user",  "req": $(this).attr('data-req'), "pid": $(this).attr('data-pid'),"uid": $(this).attr('data-uid') },
                                success: function(data) {

                                if(data[0] == 'downgrade_to_user'){
                                    NotifyMe(settingsNoty.downgrade_to_user, "information");
                                    var user = $('.'+data[1]+' .member-list-more');
                                    user.empty().html("<div class='mlm1 mj'><?php esc_html_e("Admin downgraded!", "blackfyre"); ?></div>");

                                    }

                                   return false;
                                }
                            });
                    });


                    $('.single-clan .ajaxdeletebck').live('click', function(event){
                        "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {"action": "blackfyre_delete_page_background", "pid": $(this).attr('data-pid') },
                                success: function(data) {
                                    var single_bck = jQuery('body.single-clan');
                                    var delbck_button = jQuery('.ajaxdeletebck');
                                    single_bck.attr('style', 'background: url("<?php echo esc_url(get_template_directory_uri()) ?>/img/bg.jpg")');
                                    delbck_button.remove();
                                    NotifyMe(settingsNoty.delete_page_background, "information");
                                    return false;
                                }
                            });
                    });


                    $('#score_fin').on('click', 'a.ajaxloadeditsingle', function(){ console.log('tu sam');
                            "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_edit_acc_rej_single",  "req":$(this).attr('data-req'), "cid":$(this).attr('data-cid') },
                                success: function(data) { console.log(data);
                                   if(data == "accepted"){

                                   NotifyMe(settingsNoty.edit_accepted, "information");


                                   }else if(data == "rejected"){

                                   NotifyMe(settingsNoty.edit_rejected, "information");


                                   }
								  location.reload();
                                   return false;
                                }
                            });
                        });


                       $('#matches').on('click', 'a.ajaxloadedit', function(){
                            "use strict";
                             $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'json',
                                data: {"action": "blackfyre_edit_acc_rej",  "req":$(this).attr('data-req'), "cid":$(this).attr('data-cid') },
                                success: function(data) {
                                   if(data[1] == "accepted"){

                                   NotifyMe(settingsNoty.edit_accepted, "information");
                                   var challenge = $( ".mj" ).find("[data-cid='" + data[0] + "']");
                                   challenge.parent().empty().html("<?php esc_html_e("Edit accepted!", "blackfyre"); ?>");

                                   }else if(data[1] == "rejected"){

                                   NotifyMe(settingsNoty.edit_rejected, "information");
                                   var challenge = $( ".mj" ).find("[data-cid='" + data[0] + "']");
                                   challenge.parent().empty().html("<?php esc_html_e("Edit rejected!", "blackfyre"); ?>");

                                   }

                                   return false;
                                }
                            });
                        });


                    });
        </script>
<?php
global $noviuser, $error_msg;
if(isset($noviuser) && $noviuser == 'sub' && empty($error_msg)){ ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        "use strict";
      NotifyMe('Registration successful!', "information");
    });
</script>

<?php } ?>


<script>
    function composer_front_editor(uid) {
    "use strict";
        jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType:'json',
        data: {"action": "blackfyre_redirect", idc: uid },
        success: function(data) {

        window.location = adminUrl +"post.php?vc_action=vc_inline&post_id="+data+"&post_type=clan"
        return false;
        }
        });
    }
</script>



</footer>

<div class="copyright container <?php if ( of_get_option('fullwidth') ) {  }else{ ?>span12<?php } ?>">
        <?php if ( of_get_option('fullwidth') ) { ?><div class="container"><?php } ?>
            <p>© <?php echo date("Y"); ?>&nbsp;<?php if(of_get_option('copyright')!=""){ echo of_get_option('copyright');} ?>
                &nbsp;
            <div class="social">
            <?php if ( of_get_option('rss') ) { ?> <a class="rss" target="_blank" href="<?php  echo esc_url(of_get_option('rss_link'));  ?>"><i class="fa fa-rss"></i> </a><?php } ?>
            <?php if ( of_get_option('dribbble') ) { ?> <a class="dribbble" target="_blank" href="<?php  echo esc_url(of_get_option('dribbble_link'));  ?>"><i class="fa fa-dribbble"></i> </a><?php } ?>
            <?php if ( of_get_option('vimeo') ) { ?> <a class="vimeo" target="_blank" href="<?php echo esc_url(of_get_option('vimeo_link'));   ?>"><i class="fa fa-vimeo-square"></i> </a><?php } ?>
            <?php if ( of_get_option('youtube') ) { ?> <a class="youtube" target="_blank" href="<?php echo esc_url(of_get_option('youtube_link'));   ?>"><i class="fa fa-youtube"></i> </a><?php } ?>
            <?php if ( of_get_option('twitch') ) { ?> <a class="twitch" target="_blank" href="<?php echo esc_url(of_get_option('twitch_link'));   ?>"><i class="fa fa-twitch"></i></a><?php } ?>
            <?php if ( of_get_option('instagram') ) { ?> <a class="instagram" target="_blank" href="<?php echo esc_url(of_get_option('instagram_link'));   ?>"><i class="fa fa-instagram"></i></a><?php } ?>
            <?php if ( of_get_option('steam') ) { ?> <a class="steam" target="_blank" href="<?php echo esc_url(of_get_option('steam_link'));   ?>"><i class="fa fa-steam"></i></a><?php } ?>
            <?php if ( of_get_option('pinterest') ) { ?> <a class="pinterest" target="_blank" href="<?php  echo esc_url(of_get_option('pinterest_link'));   ?>"><i class="fa fa-pinterest"></i> </a><?php } ?>
            <?php if ( of_get_option('googleplus') ) { ?> <a class="google-plus" target="_blank" href="<?php echo esc_url(of_get_option('google_link'));   ?>"><i class="fa fa-google-plus"></i></a><?php } ?>
            <?php if ( of_get_option('twitter') ) { ?> <a class="twitter" target="_blank" href="<?php  echo esc_url(of_get_option('twitter_link'));   ?>"><i class="fa fa-twitter"></i></a><?php } ?>
            <?php if ( of_get_option('facebook') ) { ?> <a class="facebook" target="_blank" href="<?php echo esc_url(of_get_option('facebook_link'));   ?>"><i class="fa fa-facebook"></i></a><?php } ?>
                </div>

    </div>

    <?php if ( of_get_option('fullwidth') ) { ?></div><?php } ?>
    <div class="container back-to-topw">
        <a href="#" class="back-to-top"></a>
    </div>
    <?php wp_reset_postdata(); ?>
<!-- modal submit -->

         <div id="myModalLSubmit" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                	<div class="modal-content">
	                    <div class="modal-header">
	                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                        <h3><?php esc_html_e("Submit match scores", 'blackfyre'); ?> </h3>
	                    </div>
	                    <div class="modal-body">
	                      <form  method="post"  enctype="multipart/form-data">

	                          <select id="game_id" name="game_id" class="map-select">

	                           <?php if(isset(blackfyre_return_game_id_by_post_id($post->ID)->game_id)){ ?>}
	                           <option value="<?php echo blackfyre_return_game_id_by_post_id($post->ID)->game_id; ?>" selected="selected"></option>
	                           <?php } ?>
                              </select>
	                          <div id="mapsite"></div>
	                          <input type="submit" class="button-primary" id="wp-cw-submit" name="submit_score" value="<?php esc_html_e('Submit scores', 'blackfyre'); ?>">
	                      </form>
	                    </div>
	               	</div>
                </div>
            </div>
<!-- /modal submit -->

<!-- modal report -->
    <div id="myModalLReport" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                	<div class="modal-content">
	                    <div class="modal-header">
	                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                        <h3><?php esc_html_e("Flag match", 'blackfyre'); ?> </h3>
	                    </div>
	                    <div class="modal-body">
	                      <form  method="post" enctype="multipart/form-data">
	                           <textarea name="reason" id="reason"  placeholder="<?php esc_html_e('Please type your reason here...','blackfyre'); ?>" cols="50" rows="10" aria-required="true" ></textarea>
	                          <input type="submit" class="button-primary" id="wp-cw-report" name="report_score" value="<?php esc_html_e('Report', 'blackfyre'); ?>">
	                      </form>
	                    </div>
					</div>
                </div>
            </div>
<!-- modal report -->

<!-- modal delete clan -->
    <div id="myModalDeleteClan" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3><?php esc_html_e("Are you sure you want to delete clan?", 'blackfyre'); ?> </h3>
                        </div>
                        <div class="modal-body">
                          <a  data-pid="<?php echo esc_attr($post->ID); ?>" href="javascript:void(0);" class="ajaxdeleteclan button-small"><?php esc_html_e('Yes', 'blackfyre'); ?></a>
                          <a class="button-small" data-dismiss="modal" aria-hidden="true"><?php esc_html_e('No', 'blackfyre'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
<!-- modal delete clan -->
</div> <!-- End of container -->
<?php wp_footer(); ?>
</body></html>