<?php

if(isset($_POST['submit_add_match'])) {

    $wpClanWars = new WP_ClanWars();
        $date = $_POST['date'];
        $ENTRY_CREATED = @mktime($date['hh'],$date['mn'],0,$date['mm'],$date['jj'],$date['yy']);
        if ($ENTRY_CREATED !== FALSE) $ENTRY_CREATED = date('Y-m-d H:i:s', $ENTRY_CREATED );
        else $ENTRY_CREATED = current_time( 'mysql' );

	$match_status = blackfyre_return_match_status_by_match_id($_POST['match_id']);
    $team1_id = blackfyre_return_team_id_by_post_id($_POST['team1']);
    $team2_id = blackfyre_return_team_id_by_post_id($_POST['post_id']);

    if($_POST['match_id']!=0){ /*UPDATE*/
	$match = $wpClanWars->get_match(array('id' => $_POST['match_id']));
    $match = (array) $match[0];

	$team1_id = blackfyre_return_team_post__by_team_id($match['team1']);
    $team2_id = blackfyre_return_team_post__by_team_id($match['team2']);

    if(blackfyre_is_admin($team1_id->post_id, get_current_user_id())){
		$status = 'edited1';
	}elseif(blackfyre_is_admin($team2_id->post_id, get_current_user_id())){
		$status = 'edited2';
	}

	update_post_meta($_POST['match_id'], 'status_backup', $match_status->status);

	    if($match_status->status == 'done' or $match_status->status == 'pending'){
		$pid = blackfyre_return_post_id_by_match_id_from_matches($_POST['match_id']);
			if($match_status->status == 'done'){

				$arr = array(
		            'title' => isset($_POST['m_title']) ? $_POST['m_title'] : '',
		            'description' => isset($_POST['description']) ? $_POST['description'] : '',
		            'external_url' => isset($_POST['external_url']) ? $_POST['external_url'] : '',
		            'status' => $status
		    	);

			}else{

				 $arr = array(
		     		'title' => isset($_POST['m_title']) ? $_POST['m_title'] : '',
		     		'description' => isset($_POST['description']) ? $_POST['description'] : '',
		            'external_url' => isset($_POST['external_url']) ? $_POST['external_url'] : '',
		            'match_status' => isset($_POST['match_status']) ? $_POST['match_status'] : 0,
		            'date' => $ENTRY_CREATED,
		            'status' => $status
		            );
			}


		update_post_meta($pid, 'date_edit', $match['date']);
		update_post_meta($pid, 'match_status_edit', $match['status']);
		update_post_meta($pid, 'title_edit', $match['title']);
		update_post_meta($pid, 'description_edit', $match['description']);
		update_post_meta($pid, 'external_url_edit', $match['external_url']);

	    }else{

	     $arr = array(
	            'title' => isset($_POST['m_title']) ? $_POST['m_title'] : '',
	            'date' => $ENTRY_CREATED,
	            'game_id' => isset($_POST['game_id']) ? $_POST['game_id'] : 0,
	            'match_status' => isset($_POST['match_status']) ? $_POST['match_status'] : 0,
	            'description' => isset($_POST['description']) ? $_POST['description'] : '',
	            'external_url' => isset($_POST['external_url']) ? $_POST['external_url'] : '',
	            'status' => $status
	    );
	    }
    }else{ /*INSERT*/

    $arr = array(
            'title' => isset($_POST['m_title']) ? $_POST['m_title'] : '',
            'date' => $ENTRY_CREATED,  #$wpClanWars->current_time_fixed('timestamp', 0),
            /*'post_id' => 0,*/
            'team1' => $team1_id[0]->id,
            'team2' => $team2_id[0]->id,
            'scores' => array(),
            'game_id' => isset($_POST['game_id']) ? $_POST['game_id'] : 0,
            'match_status' => isset($_POST['match_status']) ? $_POST['match_status'] : 0,
            'description' => isset($_POST['description']) ? $_POST['description'] : '',
            'external_url' => isset($_POST['external_url']) ? $_POST['external_url'] : '',
            'status' => "pending"
    );

    global $challenge_sent;
    $challenge_sent = 'yes';
    }

    if ($_POST['match_id']==0) {   /****  INSERT ****/
         $match_id = $wpClanWars->add_match($arr);
         $wpClanWars->update_match_post($match_id);

    if($arr) {
            $scores = $_POST['scores'];
            foreach($scores as $round_group => $r) {

            for($i = 0; $i < sizeof($r['team1']); $i++) {

                    $wpClanWars->add_round(array('match_id' => $match_id,
                    'group_n' => abs($round_group),
                    'map_id' => $r['map_id'],
                    'tickets1' => 0,
                    'tickets2' => 0
                    ));
            }
        }
    }
    }
    elseif ($_POST['match_id']!=0) { /****  UPDATE ****/
        $wpClanWars->update_match($_POST['match_id'], $arr);
    }
}