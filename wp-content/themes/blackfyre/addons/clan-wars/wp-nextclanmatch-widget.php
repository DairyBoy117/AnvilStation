<?php


class WP_NextClanMatch_Widget extends WP_Widget {

    var $default_settings = array();
    var $newer_than_options = array();

    function __construct()
    {
        $widget_ops = array('classname' => 'NextClanMatch', 'description' => esc_html__('Displays next clan match', 'blackfyre'));
        parent::__construct('NextClanMatch', esc_html__('Next Clan Match', 'blackfyre'), $widget_ops);

        $this->default_settings = array('title' => esc_html__('Next Clan Match', 'blackfyre'),'visible_games' => array());

    }

    function current_time_fixed( $type, $gmt = 0 ) {
        $t =  ( $gmt ) ? gmdate( 'Y-m-d H:i:s' ) : gmdate( 'Y-m-d H:i:s', ( time() + ( get_option( 'gmt_offset' ) * 3600 ) ) );
        switch ( $type ) {
            case 'mysql':
                return $t;
                break;
            case 'timestamp':
                return strtotime($t);
                break;
        }
    }

    function widget($args, $instance) {
        global $wpClanWars;
        global $wpdb;
        $blackfyre_allowed = wp_kses_allowed_html( 'post' );
        extract($args);

        $now = $this->current_time_fixed('timestamp');

        $instance = wp_parse_args((array)$instance, $this->default_settings);

        $title = apply_filters('widget_title', empty($instance['title']) ? esc_html__('ClanWars', 'blackfyre') : $instance['title']);

        $matches = array();
        $games = array();
        $_games = $wpClanWars->get_game(array(
                'id' => empty($instance['visible_games']) ? 'all' : $instance['visible_games'],
                'orderby' => 'title',
                'order' => 'asc'
            ));


        if(empty($from_date)) $from_date = '';
        if(empty($instance['show_limit'])) $instance['show_limit'] = '';
        foreach($_games as $g) {
            $m = $wpClanWars->get_match(array('from_date' => $from_date, 'game_id' => $g->id, 'limit' => $instance['show_limit'], 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true, 'status' => 'active'));

            if(sizeof($m)) {
                $games[] = $g;
                $matches = array_merge($matches, $m);
            }
        }

        usort($matches, create_function('$a, $b', '
            $t1 = mysql2date("U", $a->date);
            $t2 = mysql2date("U", $b->date);

            if($t1 == $t2) return 0;

            return $t1 > $t2 ? -1 : 1;
            '));

        ?>

        <?php echo wp_kses($before_widget,$blackfyre_allowed); ?>
        <div class="nextmatch_widget">
        <?php
            if(empty($instance['hide_title'])) $instance['hide_title'] = '';
            if ( $title && !$instance['hide_title'] )

            echo wp_kses($before_title . $title . $after_title, $blackfyre_allowed);

            $table = array(
                'teams' => 'cw_teams',
                'games' => 'cw_games',
                'matches' => 'cw_matches',
            );
            $table = array_map(create_function('$t', 'global $table_prefix; return $table_prefix . $t; '), $table);
            ?>

    <?php foreach($matches as $i => $match) :
            $is_upcoming = false;
            $date = mysql2date(get_option('date_format') . ', ' . get_option('time_format'), $match->date);
            $timestamp = mysql2date('U', $match->date);

            $is_upcoming = $timestamp > $now;
            global $wpdb;

            if($is_upcoming){

            $team1id = $match->team1;
            $team2id = $match->team2;
            $teams_table = $table['teams'];

            $logo1 = $wpdb->get_results($wpdb->prepare("SELECT logo FROM $teams_table WHERE `id`= %s",$team1id ));
            $logo2 = $wpdb->get_results($wpdb->prepare("SELECT logo FROM $teams_table WHERE `id`= %s", $team2id));


            $team1_title = esc_html($match->team1_title);
            $team2_title = esc_html($match->team2_title);
            $dates[] = array('dates'=>$timestamp, 'id'=>$match->id, 'team1'=> $team1_title, 'team2'=> $team2_title);

             ?>

        <?php }
 endforeach;
        if(empty($dates[0]['dates'])) $dates[0]['dates'] = '';
        $nearest = $dates[0]['dates'];
        $id = $dates[0]['id'];
        for ($i = 0; $i < count($dates); $i++) {
          $date = $dates[$i]['dates'];
          $id =   $dates[$i]['id'];
          $team1 =   $dates[$i]['team1'];
          $team2 =   $dates[$i]['team2'];
          if (abs($date - $now) < abs($nearest - $now))
            $nearest = $date;
            $nextid = $id;
        }
        $matches_table = $table['matches'];
        $games_table = $table['games'];
        $nextmatch = $wpdb->get_results($wpdb->prepare("SELECT * FROM $matches_table WHERE `id`= %s", $nextid));
        $gameid = $nextmatch[0]->game_id;
        $gametitle = $wpdb->get_results($wpdb->prepare("SELECT abbr FROM $games_table WHERE `id`= %s",$gameid));
        $thumb1 = $logo1[0]->logo;
        $img_url1 = esc_url(blackfyre_return_clan_image_big($team1id)); //get img URL
        $image1 = blackfyre_aq_resize( $img_url1, 150, 124, true, true, true ); //resize & crop img
        $thumb2 = $logo2[0]->logo;
        $img_url2 = esc_url(blackfyre_return_clan_image_big($team2id)); //get img URL
        $image2 = blackfyre_aq_resize( $img_url2, 150, 124, true, true, true ); //resize & crop img

        if(!$image1){ $image1 = get_template_directory_uri().'/img/defaults/default-clan.jpg';  }
        if(!$image2){ $image2 = get_template_directory_uri().'/img/defaults/default-clan.jpg';  }
		if(!empty($nextmatch)){
        echo '<a href="' . esc_url(get_permalink($nextmatch[0]->post_id)) . '" title="' . esc_attr($nextmatch[0]->title) . '"><div class="nextmatch_wrap">
                <div class="clan12w"><img src="'.$image1.'" class="clan1" alt="'.$team1.'"></div>
                <div class="clan12w"><img src="'.$image2.'" class="clan2" alt="'.$team2.'"></div>
                <div class="clear"></div>
                <div class="nm-clans">
                    <div class="r-home-team">
                        <span>'.$team1.'</span>
                    </div>
                    <div class="versus">'.esc_html__("VS", "blackfyre").'</div>
                    <div class="r-opponent-team">
                        <span>'.$team2.'</span>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="nm-date">
                    '.$gametitle[0]->abbr.' - '.date(get_option('date_format'), $nearest).' <span>'.date(get_option('time_format'), $nearest).'</span>
                </div>

            </div></a>';
		}else{
			echo '<div class="nextmatch_wrap">';
				esc_html_e('No upcoming matches', 'blackfyre');
			echo '</div>';
		}
        ?>
</div>
            <?php echo wp_kses($after_widget,$blackfyre_allowed); ?>

        <?php
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {
        global $wpClanWars;
        $instance = wp_parse_args((array)$instance, $this->default_settings);
        $title = esc_attr($instance['title']);
		$visible_games = $instance['visible_games'];

        $games = $wpClanWars->get_game('id=all&orderby=title&order=asc');
 ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'blackfyre'); ?></label> <input class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" value="<?php echo esc_attr($title); ?>" type="text" /></p>
		 <p><?php esc_html_e('Show games:', 'blackfyre'); ?></p>
        <p style="overflow: auto; max-height: 100px; border: 1px solid #dfdfdf; background: #fff;" class="widefat">
            <?php foreach($games as $item) : ?>
            <label for="<?php echo esc_attr($this->get_field_id('visible_games-' . $item->id)); ?>"><input type="checkbox" name="<?php echo esc_attr($this->get_field_name('visible_games')); ?>[]" id="<?php echo esc_attr($this->get_field_id('visible_games-' . $item->id)); ?>" value="<?php echo esc_attr($item->id); ?>" <?php checked(true, in_array($item->id, $visible_games)); ?>/> <?php echo esc_html($item->title); ?></label><br/>
            <?php endforeach; ?>
        </p>
    <?php
    }
}

?>