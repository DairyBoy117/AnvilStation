<?php
/*
 *
 * The Template for displaying all single posts.
 *
 * @package WordPress
 */
?><?php
get_header();
?><?php
global $wpClanWars, $wpdb, $post, $refresh, $report, $submitted, $submittedalready;
$submittedalready = '';
$submitted        = '';
$report           = '';
$refresh          = '';
?>
<!-- Page content    ================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->
<?php
if (get_post_type(get_the_ID()) == 'matches') {
?>

	<div class="container normal-page">
		<div class="row">

			<?php
    if (have_posts()):
        while (have_posts()):
            the_post();
?>


			<?php
            $match_id = blackfyre_return_match_id_by_post_id($post->ID);

            $matches      = $wpClanWars->get_match(array(
                'id' => $match_id[0]->id,
                'sum_tickets' => true
            ));
            $m            = $matches[0];
            $t1           = $m->team1_tickets;
            $t2           = $m->team2_tickets;
            $wl_class1    = $t1 < $t2 ? 'lose' : ($t1 > $t2 ? 'win' : '');
            $wl_class2    = $t1 > $t2 ? 'lose' : ($t1 < $t2 ? 'win' : '');
            $teams        = blackfyre_return_teams_by_post_id($post->ID);
            $team1        = $teams->team1;
            $team2        = $teams->team2;
            $match_status = blackfyre_return_match_status_by_post_id($post->ID)->status;
            $tim1         = blackfyre_return_post_id_by_match_id(blackfyre_return_team_ids_from_match_by_post_id($post->ID)->team1);
            $tim2         = blackfyre_return_post_id_by_match_id(blackfyre_return_team_ids_from_match_by_post_id($post->ID)->team2);
            $locked       = blackfyre_return_match_locked($post->ID);


            if (blackfyre_is_admin($tim1->post_id, get_current_user_id())) {
                $team = 'team1';
            } elseif (blackfyre_is_admin($tim2->post_id, get_current_user_id())) {
                $team = 'team2';
            }


            if (blackfyre_is_admin($tim1->post_id, get_current_user_id()) || blackfyre_is_admin($tim2->post_id, get_current_user_id())) {
                $admin = true;
            }
?>

			<div id="matches" class="tab-pane match-page">
				<div class="profile-fimage match-fimage ">

					<div class="mminfow">
						<div class="mminfo">
							<strong><?php
            echo esc_attr($m->title);
?></strong>
							<i class="fa fa-calendar"></i>
								<?php
            echo ' ';
            echo date("F j, Y, g:i a", strtotime($m->date));
?>
						</div><!-- mminfo-->
					</div><!-- mminfow-->

				<div class="dots"></div>

				<div class="hiddenoverflow">
					<img alt="img" class="attachment-small wp-post-image" src="<?php
            echo esc_url(blackfyre_return_game_banner($m->game_id));
?>">
				</div>

				<div class="matched" id="mtch">
				<?php
            if ($match_status != 'done' && isset($admin) && $admin) {

                if ($locked->locked != '1') {

                    if ($match_status == 'pending' && isset($admin) && (get_the_author_meta('ID') == skywarrior_get_author($tim1->post_id) || get_the_author_meta('ID') == skywarrior_get_author($tim2->post_id))) {

                        echo '<a data-mid="' . esc_attr($match_id[0]->id) . '" data-pid="' . esc_attr($post->ID) . '" href="javascript:void(0);" class="ajaxdeletematch_single">';
                        echo '<i data-original-title="' . esc_html__("Delete Match", "blackfyre") . '" data-toggle="tooltip" class="fa fa-times"></i></a>';

                    } elseif (($match_status == 'active' || $match_status == 'rejected_challenge' || $match_status == 'edited1' || $match_status == 'edited2' || $match_status == 'submitted1' || $match_status == 'submitted2') && (get_the_author_meta('ID') == skywarrior_get_author($tim1->post_id) || get_the_author_meta('ID') == skywarrior_get_author($tim2->post_id))) {

                        echo '<a data-mid="' . esc_attr($match_id[0]->id) . '" data-pid="' . esc_attr($post->ID) . '" href="javascript:void(0);" class="ajaxdeletematch_single">';
                        echo '<i data-original-title="' . esc_html__("Delete Match", "blackfyre") . '" data-toggle="tooltip" class="fa fa-times"></i></a>';

                    } elseif ((($match_status == 'deleted1' && $team == 'team2') || ($match_status == 'deleted2' && $team == 'team1')) && (get_the_author_meta('ID') == skywarrior_get_author($tim1->post_id) || get_the_author_meta('ID') == skywarrior_get_author($tim2->post_id))) {

                        echo '<a data-mid="' . esc_attr($match_id[0]->id) . '" data-pid="' . esc_attr($post->ID) . '" href="javascript:void(0);" class="ajaxdeletematch_single">';
                        echo '<i data-original-title="' . esc_html__("Delete Match", "blackfyre") . '" data-toggle="tooltip" class="fa fa-times"></i></a>';

                    }
                }
            }
?>

				<?php
            if ($team == 'team2' || $team == 'team1') {
?>

					<?php
                if ($locked->locked != '1') {
?>
						<a href="#myModalLReport" role="button" class="flag-match" data-toggle="modal">
							<i data-original-title="<?php
                    esc_html_e("Flag match", "blackfyre");
?>" data-toggle="tooltip" class="fa fa-flag"></i>
						</a>
					<?php
                }
?>

					<?php
                if (!empty($_POST) && isset($_POST['report_score'])) {
                    global $wpClanWars;
                    $report   = 'reported';
                    $match_id = blackfyre_return_match_id_by_post_id($post->ID);
                    $clan1    = blackfyre_return_post_id_by_team_id($team1);
                    $clan2    = blackfyre_return_post_id_by_team_id($team2);

                    if (blackfyre_is_admin($clan1->post_id, get_current_user_id())) {
                        $status = 'reported1';
                    } elseif (blackfyre_is_admin($clan2->post_id, get_current_user_id())) {
                        $status = 'reported2';
                    }

                    $arr = array(
                        'reported_reason' => isset($_POST['reason']) ? $_POST['reason'] : '',
                        'status' => $status
                    );

                    $wpClanWars->update_match($match_id[0]->id, $arr);
                }
?>

				<?php
            }
?> <!-- /modal report-->

				<?php
            if (isset($admin) && $admin) {
                if ($locked->locked != '1' && (get_the_author_meta('ID') == skywarrior_get_author($tim1->post_id) || get_the_author_meta('ID') == skywarrior_get_author($tim2->post_id)) && ($match_status == 'done' || $match_status == 'pending')) {

                    echo '<a href="' . esc_url(get_permalink(get_page_by_path('clan-challenge'))) . '?mid=' . esc_attr($match_id[0]->id) . '">';
                    echo '<i data-original-title="' . esc_html__('Edit Match', 'blackfyre') . '" data-toggle="tooltip" class="fa fa-cogs"></i></a>';

                }
            }
?>

				</div><!--matched-->

				<div class="clan-a">
					<div class="clanimgw">
						<?php
            if ($tim1->post_id != '0') {
?>
							<a href="<?php
                echo esc_url(get_post_permalink($tim1->post_id));
?>">
						<?php
            }
?>
							<img alt="img" src="<?php
            echo esc_url(blackfyre_return_clan_image_big($m->team1));
?>" />
						<?php
            if ($tim1->post_id != '0') {
?>
							</a>
						<?php
            }
?>

						<?php
            if (blackfyre_is_admin($tim1->post_id, get_current_user_id()) || blackfyre_is_admin($tim2->post_id, get_current_user_id())) {
                $admin = true;
            } else {
                $admin = false;
            }
?>

						<?php
            if ($match_status == 'done') {
?>

							<div class="clanmfs <?php
                echo esc_attr($wl_class1);
?>">
								<span><?php
                $r1 = $t1 == NULL ? '0' : $t1;
                echo esc_attr($r1);
?></span>
							</div>

						<?php
            } else {
?>

<?php
                if ($match_status == 'submitted1' || $match_status == 'submitted2' || $match_status == 'edited1' || $match_status == 'edited2') {

                    $substatus = true;
                } else {
                    $substatus = false;
                }
?>
<?php
                if ($admin && $substatus) {
?>
 <div class="clanmfs <?php
                    echo esc_attr($wl_class1);
?>">
<span>
<?php
                    $r1 = $t1 == NULL ? '0' : $t1;
                    echo esc_attr($r1);
?></span></div>
<?php
                } else {
?>            <div class="clanmfs"><span>0</span></div>
 <?php
                }
?>
 <?php
            }
?>
 </div>
 <?php
            if ($tim1->post_id != '0') {
?>
   <a href="<?php
                echo esc_url(get_post_permalink($tim1->post_id));
?>">

   		<?php
            }
?>
   		  	<div class="pmi_title"><?php
            echo esc_attr($m->team1_title);
?></div>
   		  	         <?php
            if ($tim1->post_id != '0') {
?>
   		  	         	   	</a>            	<?php
            }
?>
   		  	         	   	     </div>
   		  	         	   	        <div class="mversus"><?php
            esc_html_e('vs', 'blackfyre');
?></div>        <div class="clan-b">            <div class="clanimgw">            	<?php
            if ($tim2->post_id != '0') {
?>            <a href="<?php
                echo esc_url(get_post_permalink($tim2->post_id));
?>">            <?php
            }
?>            	<img alt="img" src="<?php
            echo esc_url(blackfyre_return_clan_image_big($m->team2));
?>" />            	<?php
            if ($tim2->post_id != '0') {
?>            	</a>            	<?php
            }
?>            <?php
            if ($match_status == 'done') {
?>            <div class="clanmfs <?php
                echo esc_attr($wl_class2);
?>"><span><?php
                $r2 = $t2 == NULL ? '0' : $t2;
                echo esc_attr($r2);
?></span></div>             <?php
            } else {
?>            <?php
                if ($admin && $substatus) {
?>            <div class="clanmfs <?php
                    echo esc_attr($wl_class2);
?>"><span><?php
                    $r2 = $t2 == NULL ? '0' : $t2;
                    echo esc_attr($r2);
?></span></div>            <?php
                } else {
?>            <div class="clanmfs"><span>0</span></div>            <?php
                }
?>            <?php
            }
?>            </div> <?php
            if ($tim2->post_id != '0') {
?>            <a href="<?php
                echo esc_url(get_post_permalink($tim2->post_id));
?>">            	<?php
            }
?>            	<div class="pmi_title"><?php
            echo esc_attr($m->team2_title);
?></div>             <?php
            if ($tim2->post_id != '0') {
?>            </a>            <?php
            }
?>        </div>        <div class="clear"></div>        <div class="col-lg-12 col-md-12 nav-top-divider"></div>    </div>              <?php
            if ($team == 'team1') {
                $name = blackfyre_return_team_name_by_team_id($team2);
                $link = $tim2->post_id;
            } elseif ($team == 'team2') {
                $name = blackfyre_return_team_name_by_team_id($team1);
                $link = $tim1->post_id;
            }
?>         <?php
            if (($match_status == 'deleted1' && $team == 'team2') || ($match_status == 'deleted2' && $team == 'team1')) {
?>          <div class="col-lg-12 col-md-12 block ">          <div id="score_fin" class="mcscalert">          <?php
                esc_html_e('Clan', 'blackfyre');
?>&nbsp;<a href="<?php
                echo esc_url(get_post_permalink($link));
?>"> <?php
                echo esc_attr($name[0]->title);
?> </a>&nbsp;<?php
                esc_html_e('has submitted a request to delete this match! Accept?', 'blackfyre');
?>          <a class="ajaxdeletescorenotification" href="javascript:void(0);" data-req="accept_delete" data-mid="<?php
                echo esc_attr($match_id[0]->id);
?>" ><i class="fa fa-check"></i></a>          <a class="ajaxdeletescorenotification" href="javascript:void(0);" data-req="reject_delete" data-mid="<?php
                echo esc_attr($match_id[0]->id);
?>" ><i class="fa fa-times"></i></a>          </div></div>          <?php
            }
?>          <?php
            if (($match_status == 'submitted1' && $team == 'team2') || ($match_status == 'submitted2' && $team == 'team1')) {
?>          <div class="col-lg-12 col-md-12 block ">          <div id="score_fin" class="mcscalert">          <?php
                esc_html_e('Score has been submitted by', 'blackfyre');
?>&nbsp;<a href="<?php
                echo esc_url(get_post_permalink($link));
?>"> <?php
                echo esc_attr($name[0]->title);
?> </a> - <span><?php
                esc_html_e('Accept the score?', 'blackfyre');
?></span>          <a class="ajaxsubmitscore" href="javascript:void(0);" data-req="accept_score" data-mid="<?php
                echo esc_attr($match_id[0]->id);
?>"><i class="fa fa-check"></i></a>          <a class="ajaxsubmitscore" href="javascript:void(0);" data-req="reject_score" data-mid="<?php
                echo esc_attr($match_id[0]->id);
?>"><i class="fa fa-times"></i></a>          </div></div>          <?php
            }
?>          <?php
            if (($match_status == 'submitted1' && $team == 'team1') || ($match_status == 'submitted2' && $team == 'team2')) {
?>          <div class="col-lg-12 col-md-12 block ">          <div id="score_fin" class="mcscalert">           <?php
                if ($team == 'team1') {
                    $name1 = blackfyre_return_team_name_by_team_id($team2);
                    $link1 = $tim2->post_id;
                    esc_html_e('You score has been been submitted! Waiting for', 'blackfyre');
?>&nbsp;<a href="<?php
                    echo esc_url(get_post_permalink($link1));
?>"> <?php
                    echo esc_attr($name1[0]->title);
?> </a>&nbsp;<?php
                    esc_html_e('to accept or reject.', 'blackfyre');
?></span>           <?php
                } elseif ($team == 'team2') {
                    $name2 = blackfyre_return_team_name_by_team_id($team1);
                    $link2 = $tim1->post_id;
                    esc_html_e('You score has been been submitted! Waiting for', 'blackfyre');
?>&nbsp;<a href="<?php
                    echo esc_url(get_post_permalink($link2));
?>"> <?php
                    echo esc_attr($name2[0]->title);
?> </a>&nbsp;<?php
                    esc_html_e('to accept or reject.', 'blackfyre');
?></span>           <?php
                }
?>          </div></div>          <?php
            }
?>		 <?php
            if (($match_status == 'deleted_req_team1' && $team == 'team2') || ($match_status == 'deleted_req_team2' && $team == 'team1')) {
?>		 <div class="col-lg-12 col-md-12 block ">		 <div id="score_fin" class="mcscalert">		 <?php
                esc_html_e('Delete match request has been submitted by', 'blackfyre');
?>&nbsp;<a href="<?php
                echo esc_url(get_post_permalink($link));
?>"> <?php
                echo esc_attr($name[0]->title);
?> </a> - <span><?php
                esc_html_e('Accept request?', 'blackfyre');
?></span>		 <a class="ajaxdeletematchconfirmation" href="javascript:void(0);" data-req="accept_delete_request" data-pid="<?php
                echo esc_attr($post->ID);
?>" data-mid="<?php
                echo esc_attr($match_id[0]->id);
?>"><i class="fa fa-check"></i></a>		 <a class="ajaxdeletematchconfirmation" href="javascript:void(0);" data-req="reject_delete_request" data-pid="<?php
                echo esc_attr($post->ID);
?>" data-mid="<?php
                echo esc_attr($match_id[0]->id);
?>"><i class="fa fa-times"></i></a>		 </div></div>		 <?php
            }
?>		 <?php
            if (($match_status == 'deleted_req_team1' && $team == 'team1') || ($match_status == 'deleted_req_team2' && $team == 'team2')) {
?>		 <div class="col-lg-12 col-md-12 block ">		 <div id="score_fin" class="mcscalert">		  <?php
                if ($team == 'team1') {
                    $name1 = blackfyre_return_team_name_by_team_id($team2);
                    $link1 = $tim2->post_id;
                    esc_html_e('Your request to delete this match is currently pending! Waiting for', 'blackfyre');
?>&nbsp;<a href="<?php
                    echo esc_url(get_post_permalink($link1));
?>"> <?php
                    echo esc_attr($name1[0]->title);
?> </a>&nbsp;<?php
                    esc_html_e('to accept or reject.', 'blackfyre');
?></span>		  <?php
                } elseif ($team == 'team2') {
                    $name2 = blackfyre_return_team_name_by_team_id($team1);
                    $link2 = $tim1->post_id;
                    esc_html_e('Your request to delete this match is currently pending! Waiting for', 'blackfyre');
?>&nbsp;<a href="<?php
                    echo esc_url(get_post_permalink($link2));
?>"> <?php
                    echo esc_attr($name2[0]->title);
?> </a>&nbsp;<?php
                    esc_html_e('to accept or reject.', 'blackfyre');
?></span>		  <?php
                }
?>		 </div></div>		 <?php
            }
?>          <?php
            if ($match_status == 'pending' && $team == 'team2') {
?>          <div class="col-lg-12 col-md-12 block ">          <div id="score_fin" class="mcscalert">          <?php
                esc_html_e('Clan', 'blackfyre');
?>&nbsp;<a href="<?php
                echo esc_url(get_post_permalink($link));
?>"> <?php
                echo esc_attr($name[0]->title);
?> </a>&nbsp;<?php
                esc_html_e('has challenged you to a match! - Accept the challenge?', 'blackfyre');
?>          <a class="ajaxloadchlsingle" href="javascript:void(0);" data-req="accept_challenge" data-cid="<?php
                echo esc_attr($match_id[0]->id);
?>" ><i class="fa fa-check"></i></a>          <a class="ajaxloadchlsingle" href="javascript:void(0);" data-req="reject_challenge" data-cid="<?php
                echo esc_attr($match_id[0]->id);
?>" ><i class="fa fa-times"></i></a>          </div></div>          <?php
            }
?>           <?php
            if ($match_status == 'pending' && $team == 'team1') {
?>          <div class="col-lg-12 col-md-12 block ">          <div id="score_fin" class="mcscalert">          <?php
                esc_html_e('Your request to challenge', 'blackfyre');
?>&nbsp;<a href="<?php
                echo esc_url(get_post_permalink($link));
?>"> <?php
                echo esc_attr($name[0]->title);
?> </a>&nbsp;<?php
                esc_html_e('clan is currently pending!', 'blackfyre');
?>          </div></div>          <?php
            }
?>          <?php
            if ($match_status == 'edited2' && $team == 'team2') {
?>				<div class="col-lg-12 col-md-12 block ">				<div id="score_fin" class="mcscalert">				<?php
                esc_html_e('Your request to edit this match is currently pending!', 'blackfyre');
?>				</div></div>				<?php
            }
?>		<?php
            if ($match_status == 'edited1' && $team == 'team2') {
?>		 <div class="col-lg-12 col-md-12 block ">		 <div id="score_fin" class="mcscalert">		 <?php
                esc_html_e('Team', 'blackfyre');
?>&nbsp;<a href="<?php
                echo esc_url(bp_core_get_user_domain($link));
?>"> <?php
                echo esc_attr($name[0]->title);
?> </a>&nbsp;<?php
                esc_html_e('has edited a match! - Accept the changes?', 'blackfyre');
?>		 <a class="ajaxloadeditsingle" href="javascript:void(0);" data-req="accept_edit" data-cid="<?php
                echo esc_attr($match_id[0]->id);
?>" ><i class="fa fa-check"></i></a>		 <a class="ajaxloadeditsingle" href="javascript:void(0);" data-req="reject_edit" data-cid="<?php
                echo esc_attr($match_id[0]->id);
?>" ><i class="fa fa-times"></i></a>		 </div></div>		 <?php
            }
?>		  <?php
            if ($match_status == 'edited1' && $team == 'team1') {
?>			<div class="col-lg-12 col-md-12 block ">			<div id="score_fin" class="mcscalert">			<?php
                esc_html_e('Your request to edit this match is currently pending!', 'blackfyre');
?>			</div></div>			<?php
            }
?>			 <?php
            if ($match_status == 'edited2' && $team == 'team1') {
?>			 <div class="col-lg-12 col-md-12 block ">			 <div id="score_fin" class="mcscalert">			 <?php
                esc_html_e('Team', 'blackfyre');
?>&nbsp;<a href="<?php
                echo esc_url(bp_core_get_user_domain($link));
?>"> <?php
                echo esc_attr($name[0]->title);
?> </a>&nbsp;<?php
                esc_html_e('has edited a match! - Accept the changes?', 'blackfyre');
?>			 <a class="ajaxloadeditsingle" href="javascript:void(0);" data-req="accept_edit" data-cid="<?php
                echo esc_attr($match_id[0]->id);
?>" ><i class="fa fa-check"></i></a>			 <a class="ajaxloadeditsingle" href="javascript:void(0);" data-req="reject_edit" data-cid="<?php
                echo esc_attr($match_id[0]->id);
?>" ><i class="fa fa-times"></i></a>			 </div></div>			 <?php
            }
?>    <?php
            if (!empty($m->description)) {
?>    <div class="col-lg-6 col-md-6 block mdescription">        <div class="title-wrapper">            <h3 class="widget-title"><i class="fa fa-bullhorn"></i><?php
                esc_html_e(" Match description", "blackfyre");
?></h3></div>        <div class="wcontainer"><?php
                echo wpautop(do_shortcode(stripslashes($m->description)));
?>        	<?php
                if (!empty($m->external_url)) {
?> <i class="fa fa-external-link"></i> <?php
                    esc_html_e('External url:', 'blackfyre');
?>			 <a target="_blank" href="<?php
                    echo esc_url($m->external_url);
?>"><?php
                    echo esc_url($m->external_url);
?></a>			<?php
                }
?>        </div>    </div>    <?php
            }
?>    <div class="col-lg-6 col-md-6 block mmaps block">        <div class="title-wrapper"><h3 class="widget-title"><i class="fa fa-picture-o"></i> <?php
            esc_html_e("Maps", "blackfyre");
?></h3></div>        <ul>            <?php
            $r      = $wpClanWars->get_rounds($m->id);
            $rounds = array();

            foreach ($r as $v) {
                if (!isset($rounds[$v->group_n]))
                    $rounds[$v->group_n] = array();
                $rounds[$v->group_n][] = $v;
            }

            foreach ($rounds as $map_group) {
                $first = $map_group[0];
                $image = wp_get_attachment_image_src($first->screenshot);
?>
				<li>
				<?php
                if (!empty($image))
?>
				<img src="<?php
                echo esc_url($image[0]);
?>" alt="<?php
                echo esc_attr($first->title);
?>" />
				<strong><?php
                echo esc_html($first->title);
?></strong>
				<div class="mscorew">
				<?php
                $map_group = array_reverse($map_group);
                foreach ($map_group as $round) {
                    $t1 = $round->tickets1;
                    $t2 = $round->tickets2;
                    if ($m->status == 'active') {
                        $round_class = 'notsubmitted';
                    } else {
                        $round_class = $t1 < $t2 ? 'mlose' : ($t1 > $t2 ? 'mwin' : 'mtie');
                    }
?>
				<div class="mscore">
				<?php
                    if ($match_status == 'done') {
?>
				<?php
                        echo sprintf(esc_html__('%d:%d', 'blackfyre'), $t1, $t2);
?>
				<?php
                    } else {
?>
				<?php
                        if ($admin && $substatus) {
                            echo sprintf(esc_html__('%d:%d', 'blackfyre'), $t1, $t2);
                        } else {
                            echo '0:0';
                        }
?>
				<?php
                    }
?>
				</div>
				<?php
                }
?>
				</div>
				<div class="clear"></div>
				</li>
				<?php
            }
?>
				</ul>
				</div><!-- modal submit -->
				<?php
            $match_time = strtotime($m->date);
            $time_now   = current_time('timestamp');
?>
				<?php
            if ($match_status == 'active' && ($match_time < $time_now) && ($team == 'team2' || $team == 'team1')) {
?>
				<?php
                if ($locked->locked != '1') {
?>
				<a href="#myModalLSubmit" role="button" class="button-small submit-score" data-toggle="modal">
				<i class="fa fa-share-square-o"></i>&nbsp;
				<?php
                    esc_html_e("Submit scores", 'blackfyre');
?></a>
				<?php
                }
?>
				<?php
            }
?>
				<?php
            if (isset($_POST['submit_score'])) {
                $refresh       = 'go';
                $scores        = $_POST['scores'];
                $rounds_not_in = array();
                $match_id      = blackfyre_return_match_id_by_post_id($post->ID);
                if ($match_status != 'submitted1' && $match_status != 'submitted2') {
                    $submitted = 'submitted';
                    foreach ($scores as $round_group => $r) {
                        for ($i = 0; $i < sizeof($r['team1']); $i++) {
                            $round_id   = $r['round_id'][$i];
                            $round_data = array(
                                'match_id' => $match_id[0]->id,
                                'group_n' => abs($round_group),
                                'map_id' => $r['map_id'],
                                'tickets1' => $r['team1'][$i],
                                'tickets2' => $r['team2'][$i]
                            );
                            if ($round_id > 0) {
                                $wpClanWars->update_round($round_id, $round_data);
                                $rounds_not_in[] = $round_id;
                            }
                        }
                    }
                    $clan1 = blackfyre_return_post_id_by_team_id($team1);
                    $clan2 = blackfyre_return_post_id_by_team_id($team2);
                    if (blackfyre_is_admin($clan1->post_id, get_current_user_id())) {
                        $status = 'submitted1';
                    } elseif (blackfyre_is_admin($clan2->post_id, get_current_user_id())) {
                        $status = 'submitted2';
                    }
                    $p   = array(
                        'status' => $status
                    );
                    $mid = blackfyre_return_match_id_by_post_id($post->ID);
                    $wpClanWars->update_match($mid[0]->id, $p);
                    $wpClanWars->update_match_post($post->ID);
                    unset($_POST['submit_score']);
                } else {
                    $submittedalready = 'submittedalready';
                }
            }
?>
				 <!-- modal submit-->
				<?php
        endwhile;
    endif;
?>
				<div class="col-lg-6 col-md-6 block mcomments">
				<div class="title-wrapper">
				<h3 class="widget-title">
				<i class="fa fa-comments"></i>
				<?php
    esc_html_e(" Match comments", "blackfyre");
?>
				</h3>
				</div>
				<div class="wcontainer">
				<?php
    if (comments_open()) {
?>
				<?php
        comments_template('/short-comments-blog.php');
?>
				<?php
    }
?>
				</div>
				</div>
				<div class="clear"></div>

			</div> <!-- matches -->

			<?php
			    $data = array();
			    $id   = $match_id[0]->id;

			    if ($id > 0) {
			        $t = $wpClanWars->get_match(array(
			            'id' => $id
			        ));

			        if (!empty($t)) {

			            $data           = (array) $t[0];
			            $data['scores'] = array();
			            $post_id        = $data['post_id'];
			            $rounds         = $wpClanWars->get_rounds($data['id']);

			            foreach ($rounds as $round) {
			                $data['scores'][$round->group_n]['map_pic']    = blackfyre_return_map_pic($round->map_id);
			                $data['scores'][$round->group_n]['map_title']  = blackfyre_return_map_title($round->map_id);
			                $data['scores'][$round->group_n]['map_id']     = $round->map_id;
			                $data['scores'][$round->group_n]['round_id'][] = $round->id;
			                $data['scores'][$round->group_n]['team1'][]    = $round->tickets1;
			                $data['scores'][$round->group_n]['team2'][]    = $round->tickets2;
			            }

			        }
			    }


			?>
			<script>
				jQuery(document).ready(function ($) {
					var data = <?php echo json_encode($data['scores']); ?>;

					if(data !== null){
						$.each(data, function (i, item) {
						var m = wpMatchManager.addMap(i, item.map_id);

						for(var j = 0; j < item.team1.length; j++) {
							m.addRound(item.team1[j], item.team2[j], item.round_id[j]);
						};

						var img = $('#mapsite .leftcol img');
						var title = $('#mapsite .map .title span');
						img.prop("src", item.map_pic);
						title.text(item.map_title);
						});
					}
				});
			</script>

		</div>  <!-- /row -->
	</div>  <!-- /container -->

<?php } else { ?>

	<div class="container blog blog-ind">
		<div class="row">
			<div class="col-lg-8 col-md-8 ">

			<?php if (have_posts()): while (have_posts()): the_post(); ?>

 				<div class="blog-post">
 					<div class="blog-image right">

					<?php
            		$key_1_value = get_post_meta($post->ID, '_smartmeta_my-awesome-field77', true);

            		if ($key_1_value != '') {
		                $blackfyre_allowed['iframe'] = array(
		                    'src' => array(),
		                    'height' => array(),
		                    'width' => array(),
		                    'frameborder' => array(),
		                    'allowfullscreen' => array()
		                );
                echo wp_kses($key_1_value, $blackfyre_allowed, array('http','https'));

            	} elseif (has_post_thumbnail()) {

	                $thumb   = get_post_thumbnail_id();
	                $img_url = wp_get_attachment_url($thumb, 'full');
	                $image   = blackfyre_aq_resize($img_url, 817, 320, true, '', true);?>

	                <img alt="img" src="<?php echo esc_url($image[0]); ?>" />

				<?php } else { ?>
					<img alt="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/defaults/default-banner.jpg" />
				<?php } ?>

			<div class="blog-date">
				<span class="date"><?php the_time('M'); ?><br />
					<?php the_time('d'); ?>
				</span>

				<div class="plove">
					<?php if (function_exists('heart_love') && of_get_option('heart_rating') == '1') heart_love();?>
				</div>
			</div>


			<div class="blog-rating">
				<?php
		            $overall_rating_1 = get_post_meta(get_the_ID(), 'overall_rating', true);
		            if ($overall_rating_1 != "0" && $overall_rating_1 == "0.5") {
				?>
					<div class="overall-score"><div class="rating r-05"></div></div>
				<?php } ?>

				<?php
		            $overall_rating_2 = get_post_meta(get_the_ID(), 'overall_rating', true);
		            if ($overall_rating_2 != "0" && $overall_rating_2 == "1") {
				?>
					<div class="overall-score"><div class="rating r-1"></div></div>
				<?php } ?>

				<?php
		            $overall_rating_3 = get_post_meta(get_the_ID(), 'overall_rating', true);
		            if ($overall_rating_3 != "0" && $overall_rating_3 == "1.5") {
				?>
					<div class="overall-score"><div class="rating r-15"></div></div>
				<?php } ?>

				<?php
		            $overall_rating_4 = get_post_meta(get_the_ID(), 'overall_rating', true);
		            if ($overall_rating_4 != "0" && $overall_rating_4 == "2") {
				?>
					<div class="overall-score"><div class="rating r-2"></div></div>
				<?php } ?>

				<?php
		            $overall_rating_5 = get_post_meta(get_the_ID(), 'overall_rating', true);
		            if ($overall_rating_5 != "0" && $overall_rating_5 == "2.5") {
				?>
					<div class="overall-score"><div class="rating r-25"></div></div>
			<?php } ?>

				<?php
		            $overall_rating_6 = get_post_meta(get_the_ID(), 'overall_rating', true);
		            if ($overall_rating_6 != "0" && $overall_rating_6 == "3") {
				?>
					<div class="overall-score"><div class="rating r-3"></div></div>
			<?php } ?>

				<?php
		            $overall_rating_7 = get_post_meta(get_the_ID(), 'overall_rating', true);
		            if ($overall_rating_7 != "0" && $overall_rating_7 == "3.5") {
				?>
					<div class="overall-score"><div class="rating r-35"></div></div>
			<?php } ?>

				<?php
		            $overall_rating_8 = get_post_meta(get_the_ID(), 'overall_rating', true);
		            if ($overall_rating_8 != "0" && $overall_rating_8 == "4") {
				?>
					<div class="overall-score"><div class="rating r-4"></div></div>
				<?php } ?>

				<?php
		            $overall_rating_9 = get_post_meta(get_the_ID(), 'overall_rating', true);
		            if ($overall_rating_9 != "0" && $overall_rating_9 == "4.5") {
				?>
					<div class="overall-score"><div class="rating r-45"></div></div>
			<?php } ?>

			<?php
		            $overall_rating_10 = get_post_meta(get_the_ID(), 'overall_rating', true);
		            if ($overall_rating_10 != "0" && $overall_rating_10 == "5") {
			?>
					<div class="overall-score"><div class="rating r-5"></div></div>
			<?php } ?>

		</div><!-- blog-rating -->

		</div><!-- blog-image -->

		<div class="blog-info">
			<div class="post-pinfo">
				<span class="fa fa-user"></span>
					<a data-original-title="<?php esc_html_e("View all posts by", 'blackfyre'); echo esc_attr(get_the_author());?>" data-toggle="tooltip" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>">
						<?php echo esc_attr(get_the_author()); ?>
					</a> &nbsp;

				<?php
		            $posttags = get_the_tags();
		            if ($posttags) {
				?>  <span class="fa fa-tags"></span>
						<?php
						$i   = 0;
						$len = count($posttags);
						foreach ($posttags as $tag) { ?>
						<a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
							<?php echo esc_attr($tag->name); if ($i != $len - 1) echo ', ';?>
						</a><?php
		                    $i++;
	                	}
            		} ?>
			</div>

			<?php if (of_get_option('share_this')) { ?>
				<div class="sharepost">
				<span class='st_sharethis_hcount' displayText='ShareThis'></span>
				<span class='st_facebook_hcount' displayText='Facebook'></span>
				<span class='st_twitter_hcount' displayText='Tweet'></span>
				<span class='st_reddit_hcount' displayText='Reddit'></span>
				<span class='st_email_hcount' displayText='Email'></span>
				</div>
			<?php } ?>

			<div class="clear"></div>
		</div><!-- post ratings -->

		<?php
            $overall_rating = get_post_meta($post->ID, 'overall_rating', true);
            $rating_one     = get_post_meta($post->ID, 'creteria_1', true);
            $rating_two     = get_post_meta($post->ID, 'creteria_2', true);
            $rating_three   = get_post_meta($post->ID, 'creteria_3', true);
            $rating_four    = get_post_meta($post->ID, 'creteria_4', true);
            $rating_five    = get_post_meta($post->ID, 'creteria_5', true);

            if ($overall_rating == NULL or $rating_one == NULL && $rating_two == NULL && $rating_three == NULL && $rating_four == NULL && $rating_five == NULL) {

            } else {
                include('post-rating.php');
            }
         ?>            <!-- /post ratings -->

				<div class="blog-content wcontainer"><?php the_content(); ?></div> <!-- /.blog-content -->
				<div class="clear"></div>

			</div><!-- /.blog-post -->
		<?php endwhile;endif; ?>
		<div class="clear"></div>

		<?php if (of_get_option('authorsingle')) { ?>
			<div class="block-divider"></div>
				<div class="author-block wcontainer">
					<?php echo get_avatar(get_the_author_meta('ID'), 250); ?>
						<div class="author-content">
							<h3><?php esc_html_e("About ", 'blackfyre'); echo esc_attr(get_the_author()); ?></h3>
						<?php the_author_meta('description'); ?>
						</div>
				<div class="clear"></div>
			</div><!-- /author-block -->
		<?php } ?>

	<?php wp_link_pages(); ?>
	<?php if (comments_open()) { ?>
	<div id="comments"  class="block-divider"></div>
	<?php comments_template('/short-comments-blog.php'); ?>
	<?php } ?>

	</div> <!-- /.span8 -->

	<div class="col-lg-4 col-md-4  ">
	<?php
	    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Blog sidebar')):
		    dynamic_sidebar('three');
	    endif;
	?>
	</div><!-- /.span4 -->


	</div>  <!-- /container -->
</div><!-- /row -->

<?php } ?>


<?php
if ($report == 'reported') {
?>
	<script>
		jQuery( document ).ready(function() {
		NotifyMe(settingsNoty.reported, "information");});
	</script>
<?php
    $report = '';
}
?>

<?php
if ($submitted == 'submitted') {
?>
	<script>
		jQuery(document).ready(function(){
		NotifyMe(settingsNoty.submitted, "information");});
	</script>
<?php
    $submitted = '';
}
?>

<?php
if ($submittedalready == 'submittedalready') {
?>
	<script>
		jQuery(document).ready(function(){
		NotifyMe(settingsNoty.already_submitted, "information");});
	</script>
<?php
    $submittedalready = '';
}
?>


<?php
if ($refresh == 'go') {
    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
        header('Location: http://' . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]);
    } else {
        header('Location: https://' . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]);
    }
    die();
    $refresh = '';
}
?>

<?php get_footer(); ?>