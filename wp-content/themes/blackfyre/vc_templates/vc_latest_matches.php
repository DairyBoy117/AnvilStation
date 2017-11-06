<?php
$el_matches_title = $el_match_games = $el_matches_number = $el_matches_hide = $el_class = '';
$posts = array();
extract( shortcode_atts( array(
    'el_matches_title' => '',
    'el_match_games' => '',
    'el_matches_number' => '',
    'el_matches_hide' => '',
    'el_class' => '',
), $atts ) );
global $wpClanWars, $post;
if(empty($css))$css = '';
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_text_column wpb_content_element ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
?>

<div class="<?php echo esc_attr($css_class); if(!empty($el_class)) echo esc_attr($el_class); ?>">
    <div class="wpb_wrapper widget">
        <div class="title-wrapper">
            <h3 class="widget-title"><i class="fa fa-crosshairs"></i> <?php if(!empty($el_matches_title)) echo esc_attr($el_matches_title); ?></h3>
            <div class="clear"></div>
        </div>
         <?php  if(! empty($post) && is_a($post, 'WP_Post')){ ?>
<?php
        if($post->ID === NULL){ ?>
         <div class="wcontainer">

            <?php   _e('Your matches', 'blackfyre'); ?>

        </div>
        <?php }else{
        $now = $wpClanWars->current_time_fixed('timestamp');
        $current_game = isset($_GET['game']) ? $_GET['game'] : false;
        $matches = array();
        $games = array();
        if(get_post_type($post->ID) == 'clan'){ $clan = true;}
        if(empty($clan)) $clan = '';


        if ( $clan ) {
        	$team_id = blackfyre_return_team_id_by_post_id( $post->ID );
			$clan_games = blackfyre_return_all_games_string( $team_id[0]->id );
        }

        $game_ids = '';

        if ( $el_match_games != '' ) {

            $el_match_games = explode( ",", $el_match_games );

            if ( $clan ) {
            	if ( isset( $clan_games ) && is_array( $clan_games ) ) {
	            	$output = array_intersect( $el_match_games, $clan_games );
            	}
            } else {
            	$output = $el_match_games;
            }

			if ( is_array( $output ) && ! empty( $output ) ) {
				foreach ( $output as $game ) {
	            	$g = $wpClanWars->get_game( 'id=' . $game );

					if ( empty( $game_ids ) ) {
	              		$game_ids = $g[0]->id;
				  	} else {
					  	if ( isset( $g[0] ) ) {
							$game_ids = $game_ids . ', ' . $g[0]->id;
						}
					}
				}
			}
        } else {
             if ( $clan ) {
               $game_ids = $clan_games;
             } else {
               $game_ids = 'all';
             }
        }

        $games = $wpClanWars->get_games('id='.$game_ids.'&orderby=title&order=asc');

     if($el_matches_hide == 'all') $value = 0;
     if($el_matches_hide == '1w') $value = 60*60*24*7;
     if($el_matches_hide == '2w') $value = 60*60*24*14;
     if($el_matches_hide == '3w') $value = 60*60*24*21;
     if($el_matches_hide == '1m') $value = 60*60*24*30;
     if($el_matches_hide == '2m') $value = 60*60*24*30*2;
     if($el_matches_hide == '3m') $value = 60*60*24*30*3;
     if($el_matches_hide == '6m') $value = 60*60*24*30*6;
     if($el_matches_hide == '1y') $value = 60*60*24*30*12;
     if(empty($el_matches_hide))$value = 0;
     $from_date = 0;
        if(isset($el_matches_hide)) {
            $age = (int)$value;
            // 0 means show all matches
            if($age > 0)
                $from_date = $now - $age;
        }
if(!empty($games)){
     foreach($games as $g) {
            $m = $wpClanWars->get_match(array('status' => array('active', 'done'),'from_date' => $from_date, 'game_id' => $g->id, 'limit' => $el_matches_number, 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true));

            if(sizeof($m)) {
                $games1[] = $g;
                $matches = array_merge($matches, $m);
            }
        }
?>

<ul class="clanwar-list">
       <li>
        <ul class="tabs">

            <?php

        $obj = new stdClass();
        $obj->id = 0;
        $obj->title = esc_html__('All', 'blackfyre');
        $obj->abbr = esc_html__('All', 'blackfyre');
        $obj->icon = 0;
		if(!empty($games1))
        array_unshift($games1, $obj);
        for($i = 0; $i < sizeof($games1); $i++) :
            $game = $games1[$i];
            $link = ($game->id == 0) ? 'all' : 'game-' . $game->id;
         if($i == 0){$class = 'selected';}else{$class = '';}
         $p = array( 'game_id' => $game->id, 'status' => array('active', 'done'));
         $matches_tab = $wpClanWars->get_match($p, false);
		    if(!empty($matches_tab)){
        ?>
            <li<?php if($i == 0) echo ' class="selected"'; ?>><a href="#<?php echo esc_attr($link); ?>" title="<?php echo esc_attr($game->title); ?>"><?php echo esc_attr($game->abbr); ?></a><div class="clear"></div></li>
        <?php } endfor; ?>
        </ul>
        <div class="clear"></div>
    </li>

    <?php

        // generate table content
        $j=0;

   foreach($matches as $i => $match) {
    if($match->status == 'active' || $match->status == 'done'){
       if($clan){
            if($match->team1 == $team_id[0]->id or $match->team2 == $team_id[0]->id){
			$is_upcoming = false;
			$t1 = $match->team1_tickets;
			$t2 = $match->team2_tickets;
			$wld_class = $t1 == $t2 ? 'draw' : ($t1 > $t2 ? 'win' : 'loose');
			$date = mysql2date(get_option('date_format') . ', ' . get_option('time_format'), $match->date);
			$timestamp = mysql2date('U', $match->date);
            $table = array(
                'teams' => 'cw_teams',
                'games' => 'cw_games',
            );
            $table = array_map(create_function('$t', 'global $table_prefix; return $table_prefix . $t; '), $table);
			$game_icon = wp_get_attachment_url($match->game_icon);
            $gameid = $match->game_id;
            global $wpdb;

			$gameabr = $wpdb->get_results('SELECT abbr FROM `' . $table['games'] . '` WHERE `id`= ' .$gameid. ' '  );

            $team1id = blackfyre_return_team_post__by_team_id($match->team1);
			$img_url1 = get_post_meta($team1id->post_id, 'clan_photo', true);
            $image1 = blackfyre_aq_resize( $img_url1, 25, 25, true ); //resize & crop img

            $team2id = blackfyre_return_team_post__by_team_id($match->team2);
            $img_url2 = get_post_meta($team2id->post_id, 'clan_photo', true);
            $image2 = blackfyre_aq_resize( $img_url2, 25, 25, true ); //resize & crop img

			$is_upcoming = $timestamp > $now;
			$is_playing = ( ($now > $timestamp && $now < $timestamp + 3600) && ($t1 == 0 && $t2 == 0) || ($match->status == 'active') && ($t1 == 0 && $t2 == 0) );
	?>
            <li class="clanwar-item<?php if($i % 2 != 0) echo ' alt'; ?> game-<?php echo esc_attr($match->game_id); ?>">

			<div class="wrap">
				<?php echo '<a href="' . get_permalink($match->post_id) . '" data-toggle="tooltip" data-original-title="' . esc_attr($match->title) . '">'; ?>
				<?php if($is_upcoming) : ?>
				<div class="upcoming"><?php _e('Upcoming', 'blackfyre'); ?></div>
				<?php elseif($is_playing) : ?>
				<div class="playing"><?php _e('Playing', 'blackfyre'); ?></div>
				<?php else : ?>
				<div class="scores <?php echo esc_attr($wld_class); ?>"><?php echo sprintf(__('%d:%d', 'blackfyre'), $t1, $t2); ?></div>
				<?php endif; ?>
                <?php if(empty($image1)){ $image1 = get_template_directory_uri().'/img/defaults/clan25x25.jpg';  } ?>
                <?php if(empty($image2)){ $image2 = get_template_directory_uri().'/img/defaults/clan25x25.jpg';  } ?>
				<div class="match-wrap">

						<img src="<?php echo esc_url($image1);?>" class="clan1img" alt="<?php echo esc_attr($match->title); ?>" />

						<span class="vs"><?php _e("vs","blackfyre");?></span>
						<div class="opponent-team">
						<img src="<?php echo esc_url($image2);?>" class="clan1img" alt="<?php echo esc_attr($match->title); ?>" />
						</div>

				<div class="clear"></div>
				</div>
				<div class="date"><?php echo esc_attr($gameabr[0]->abbr); ?> - <?php echo esc_attr($date); ?></div>
				<div class="clear"></div>
				</a>
			</div>

	</li>

       <?php
        $j++;
        }

        }else{
                    $is_upcoming = false;
            $t1 = $match->team1_tickets;
            $t2 = $match->team2_tickets;
            $wld_class = $t1 == $t2 ? 'draw' : ($t1 > $t2 ? 'win' : 'loose');
            $date = mysql2date(get_option('date_format') . ', ' . get_option('time_format'), $match->date);
            $timestamp = mysql2date('U', $match->date);
            $table = array(
                'teams' => 'cw_teams',
                'games' => 'cw_games',
            );
            $table = array_map(create_function('$t', 'global $table_prefix; return $table_prefix . $t; '), $table);
            $game_icon = wp_get_attachment_url($match->game_icon);
            $gameid = $match->game_id;
            global $wpdb;

			$gameabr = $wpdb->get_results('SELECT abbr FROM `' . $table['games'] . '` WHERE `id`= ' .$gameid. ' '  );

            $team1id = blackfyre_return_team_post__by_team_id($match->team1);
			$img_url1 = get_post_meta($team1id->post_id, 'clan_photo', true);
            $image1 = blackfyre_aq_resize( $img_url1, 25, 25, true ); //resize & crop img

            $team2id = blackfyre_return_team_post__by_team_id($match->team2);
            $img_url2 = get_post_meta($team2id->post_id, 'clan_photo', true);
            $image2 = blackfyre_aq_resize( $img_url2, 25, 25, true ); //resize & crop img

            $is_upcoming = $timestamp > $now;
            $is_playing = ( ($now > $timestamp && $now < $timestamp + 3600) && ($t1 == 0 && $t2 == 0) || ($match->status == 'active') && ($t1 == 0 && $t2 == 0) );
    ?>
            <li class="clanwar-item<?php if($i % 2 != 0) echo ' alt'; ?> game-<?php echo esc_attr($match->game_id); ?>">

            <div class="wrap">
                <?php echo '<a href="' . get_permalink($match->post_id) . '" data-toggle="tooltip" data-original-title="' . esc_attr($match->title) . '">'; ?>
                <?php if($is_upcoming) : ?>
                <div class="upcoming"><?php _e('Upcoming', 'blackfyre'); ?></div>
                <?php elseif($is_playing) : ?>
                <div class="playing"><?php _e('Playing', 'blackfyre'); ?></div>
                <?php else : ?>
                <div class="scores <?php echo esc_attr($wld_class); ?>"><?php echo sprintf(__('%d:%d', 'blackfyre'), $t1, $t2); ?></div>
                <?php endif; ?>
                <?php if(empty($image1)){ $image1 = get_template_directory_uri().'/img/defaults/clan25x25.jpg';  } ?>
                <?php if(empty($image2)){ $image2 = get_template_directory_uri().'/img/defaults/clan25x25.jpg';  } ?>
                <div class="match-wrap">

                        <img src="<?php echo esc_url($image1);?>" class="clan1img" alt="<?php echo esc_attr($match->title); ?>" />

                        <span class="vs"><?php _e("vs","blackfyre");?></span>
                        <div class="opponent-team">
                        <img src="<?php echo esc_url($image2);?>" class="clan1img" alt="<?php echo esc_attr($match->title); ?>" />
                        </div>

                <div class="clear"></div>
                </div>
                <div class="date"><?php echo esc_attr($gameabr[0]->abbr); ?> - <?php echo esc_attr($date); ?></div>
                <div class="clear"></div>
                </a>
            </div>

    </li>

       <?php
        $j++;

        }
  }}


        ?>

       </ul>
<?php }else{ ?>

     <div class="wcontainer">
        <?php   _e('This clan doesn\'t have any matches yet!', 'blackfyre'); ?>
     </div>

    <?php }

} ?>

<?php } ?>
    </div>
</div>