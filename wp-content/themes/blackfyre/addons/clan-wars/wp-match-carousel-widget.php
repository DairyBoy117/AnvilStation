<?php
/**
 * Widget Name: Match Carousel
 * Description: A Match Carousel widget.
 * Version: 1.0
 */

class blackfyre_match_carousel_widget extends WP_Widget {

    var $default_settings = array();
    var $newer_than_options = array();

    function __construct()
    {
        $widget_ops = array('classname' => 'blackfyre_match_carousel_widget', 'description' => esc_html__('Displays match carousel', 'blackfyre'));
        parent::__construct('blackfyre_match_carousel_widget', esc_html__('Next Match Carousel', 'blackfyre'), $widget_ops);

        $this->default_settings = array(
            'title' => esc_html__('Next Match Carousel', 'blackfyre'),
            'show_limit' => 10,
            'visible_games' => array(), 
            'speed' => '8000'
            );

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

        extract($args);

        $now = $this->current_time_fixed('timestamp');

        $instance = wp_parse_args((array)$instance, $this->default_settings);

		$title = apply_filters('widget_title', $instance['title']);
        $show_limit = isset($instance['show_limit']) ? absint($instance['show_limit']) : 10;
        $speed = isset($instance['speed']) ? absint($instance['speed']) : 8000;

        $matches = array();
        $games = array();
        $_games = $wpClanWars->get_game(array(
                'id' => empty($instance['visible_games']) ? 'all' : $instance['visible_games'],
                'orderby' => 'title',
                'order' => 'asc'
            ));

        foreach($_games as $g) {
            $m = $wpClanWars->get_match(array('status' => array('active', 'done'),'from_date' => $now, 'game_id' => $g->id, 'limit' => $show_limit, 'order' => 'asc', 'orderby' => 'date', 'sum_tickets' => true));
            if(sizeof($m)) {
                $games[] = $g;
                $matches = array_merge($matches, $m);
            }
        }

       
        usort($matches, create_function('$a, $b', '
            $t1 = mysql2date("U", $a->date);
            $t2 = mysql2date("U", $b->date);

            if($t1 == $t2) return 0;

            return $t1 < $t2 ? -1 : 1;
            '));

            echo $before_widget;
         
            if($title) {
        		echo $before_title . $title . $after_title;
        	}
        if($matches) {  
            $random_id = rand();
            echo '<div id="matchCarousel'.$random_id.'" class="nextmatchcarusel carousel slide carousel-fade" data-ride="carousel" data-interval="'.$speed.'">
            <div class="carousel-inner" role="listbox">'; 
                $i=0; 
            foreach($matches as $i => $match) :
                $i++;
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
    			$games_table = $table['games'];
    			$gameabr = $wpdb->get_results($wpdb->prepare("SELECT abbr FROM $games_table WHERE `id`= %s",$gameid));
    
    
                $team1id = blackfyre_return_team_post__by_team_id($match->team1);
    			$img_url1 = get_post_meta($team1id->post_id, 'clan_photo', true);
                $image1 = blackfyre_aq_resize( $img_url1, 150, 124, true ); //resize & crop im
    
                $team2id = blackfyre_return_team_post__by_team_id($match->team2);
                $img_url2 = get_post_meta($team2id->post_id, 'clan_photo', true);
                $image2 = blackfyre_aq_resize( $img_url2, 150, 124, true ); //resize & crop img
                
                if(empty($image1)){ $image1 = get_template_directory_uri().'/img/defaults/default-clan.jpg';  }
                if(empty($image2)){ $image2 = get_template_directory_uri().'/img/defaults/default-clan.jpg';  }
                
                $team1_title = esc_html($match->team1_title);
                $team2_title = esc_html($match->team2_title);
                
                $active_class = '';
                if($i==1) {$active_class = ' active';}
                echo '<div class="overlay item'.$active_class.'">';    
                echo '<a href="' . esc_url(get_permalink($match->post_id)) . '" title="' . esc_attr($match->title) . '"><div class="nextmatch_wrap">
                        <div class="clan12w"><img src="'.$image1.'" class="clan1" alt="'.$team1_title.'"></div>
                        <div class="clan12w"><img src="'.$image2.'" class="clan2" alt="'.$team2_title.'"></div>
                        <div class="clear"></div>
                        <div class="nm-clans">
                            <div class="r-home-team">
                                <span>'.$team1_title.'</span>
                            </div>
                            <div class="versus">'.esc_html__("VS", "blackfyre").'</div>
                            <div class="r-opponent-team">
                                <span>'.$team2_title.'</span>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="nm-date">
                            '.$gameabr[0]->abbr.' - '.$date.'</span>
                        </div>
                
                    </div></a>';  
                    echo '</div>';  

            endforeach; 
            echo '</div>';
            if($i > 1) {
            ?>
            <a class="left carousel-control" href="#matchCarousel<?php echo esc_attr($random_id);?>" role="button" data-slide="prev">
                <span class="icon-prev"></span>
            </a>
            <a class="right carousel-control" href="#matchCarousel<?php echo esc_attr($random_id);?>" role="button" data-slide="next">
                <span class="icon-next"></span>
            </a>
            <?php
            } 
                       
            echo '</div>';
        } else {
			echo '<div class="nextmatch_wrap">';
				esc_html_e('No upcoming matches', 'blackfyre');
			echo '</div>';
        }            
            echo $after_widget; 
            
    }

/** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        return $new_instance;
    }

/** @see WP_Widget::form */
    function form($instance) {
    	global $wpClanWars;
		$instance = wp_parse_args((array)$instance, $this->default_settings);
        $title = esc_attr($instance['title']);
        $show_limit = (int)$instance['show_limit'];
		$visible_games = $instance['visible_games'];
		$speed = $instance['speed'];
		$games = $wpClanWars->get_game('id=all&orderby=title&order=asc');
        ?>
         <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'blackfyre'); ?></label> <input class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" value="<?php echo esc_attr($title); ?>" type="text" /></p>

         <p><label for="<?php echo esc_attr($this->get_field_id('speed')); ?>"><?php esc_html_e('Carousel speed in ms:', 'blackfyre'); ?></label> <input class="widefat" name="<?php echo esc_attr($this->get_field_name('speed')); ?>" id="<?php echo esc_attr($this->get_field_id('speed')); ?>" value="<?php echo esc_attr($speed); ?>" type="text" /></p>

		 <p><?php esc_html_e('Show games:', 'blackfyre'); ?></p>
        <p style="overflow: auto; max-height: 100px; border: 1px solid #dfdfdf; background: #fff;" class="widefat">
            <?php foreach($games as $item) : ?>
            <label for="<?php echo esc_attr($this->get_field_id('visible_games-' . $item->id)); ?>"><input type="checkbox" name="<?php echo esc_attr($this->get_field_name('visible_games')); ?>[]" id="<?php echo esc_attr($this->get_field_id('visible_games-' . $item->id)); ?>" value="<?php echo esc_attr($item->id); ?>" <?php checked(true, in_array($item->id, $visible_games)); ?>/> <?php echo esc_html($item->title); ?></label><br/>
            <?php endforeach; ?>
        </p>
        <p><label for="<?php echo esc_attr($this->get_field_id('show_limit')); ?>"><?php esc_html_e('Show matches:', 'blackfyre'); ?></label> <input style="width: 45px;" name="<?php echo esc_attr($this->get_field_name('show_limit')); ?>" id="<?php echo esc_attr($this->get_field_id('show_limit')); ?>" value="<?php echo esc_attr($show_limit); ?>" type="text" /></p>
        <?php
    }

}

?>