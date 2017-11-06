<?php

/*
WP-Clanwars 1.5.5
Copyright © 2011 Andrey Mikhaylov
*/



/*
*  THIS IS MODIFIED COPY OF ORIGINAL PLUGIN!
 * Copyright © 2013 Vojimir Vukojevic
*/


class WP_ClanWars_Other_Matches_Widget extends WP_Widget {

    var $default_settings = array();
    var $newer_than_options = array();

    function __construct()
    {
        $widget_ops = array('classname' => 'widget_other_matches', 'description' => esc_html__('Other matches widget', 'blackfyre'));
        parent::__construct('other_matches', esc_html__('Other matches', 'blackfyre'), $widget_ops);

        $this->default_settings = array(
                'title' => esc_html__('Other matches', 'blackfyre'),
                'show_limit' => 10,
                'hide_older_than' => '1m',
                'visible_games' => array()
                );

        $this->newer_than_options = array(
            'all' => array('title' => esc_html__('Show all', 'blackfyre'), 'value' => 0),
            '1w' => array('title' => esc_html__('1 week', 'blackfyre'), 'value' => 60*60*24*7),
            '2w' => array('title' => esc_html__('2 weeks', 'blackfyre'), 'value' => 60*60*24*14),
            '3w' => array('title' => esc_html__('3 weeks', 'blackfyre'), 'value' => 60*60*24*21),
            '1m' => array('title' => esc_html__('1 month', 'blackfyre'), 'value' => 60*60*24*30),
            '2m' => array('title' => esc_html__('2 months', 'blackfyre'), 'value' => 60*60*24*30*2),
            '3m' => array('title' => esc_html__('3 months', 'blackfyre'), 'value' => 60*60*24*30*3),
            '6m' => array('title' => esc_html__('6 months', 'blackfyre'), 'value' => 60*60*24*30*6),
            '1y' => array('title' => esc_html__('1 year', 'blackfyre'), 'value' => 60*60*24*30*12)
        );

        wp_register_script('jquery-cookie', WP_CLANWARS_URL . '/js/jquery.cookie.pack.js', array('jquery'), WP_CLANWARS_VERSION);
        wp_register_script('wp-cw-tabs', WP_CLANWARS_URL . '/js/tabs.js', array('jquery', 'jquery-cookie'), WP_CLANWARS_VERSION);

        wp_enqueue_script('wp-cw-tabs');
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

        extract($args);

        $now = $this->current_time_fixed('timestamp');

        $instance = wp_parse_args((array)$instance, $this->default_settings);

        $title = apply_filters('widget_title', $instance['title']);
        $show_limit = isset($instance['show_limit']) ? absint($instance['show_limit']) : 10;

        $matches = array();
        $games = array();
        $_games = $wpClanWars->get_game(array(
                'id' => empty($instance['visible_games']) ? 'all' : $instance['visible_games'],
                'orderby' => 'title',
                'order' => 'asc'
            ));

        $from_date = 0;
        if(isset($this->newer_than_options[$instance['hide_older_than']])) {
            $age = (int)$this->newer_than_options[$instance['hide_older_than']]['value'];
            // 0 means show all matches
            if($age > 0)
                $from_date = $now - $age;
        }

        foreach($_games as $g) {
            $m = $wpClanWars->get_match(array('status' => array('active', 'done'),'to_date' => $now, 'from_date' => $from_date, 'game_id' => $g->id, 'limit' => $show_limit, 'order' => 'desc', 'orderby' => 'date', 'sum_tickets' => true));
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

        echo $before_widget;
        
        if($title) {
    		echo $before_title . $title . $after_title;
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

        array_unshift($games, $obj);

        for($i = 0; $i < sizeof($games); $i++) :
            $game = $games[$i];
            $link = ($game->id == 0) ? 'all' : 'game-' . $game->id;
            $p = array( 'game_id' => $game->id,'status' => array('active', 'done'));
            $matches_tab = $wpClanWars->get_match($p, false);

            if(!empty($matches_tab)){
        ?>
            <li<?php if($i == 0) echo ' class="selected"'; ?>><a href="#<?php echo esc_attr($link); ?>" title="<?php echo esc_attr($game->title); ?>"><?php echo esc_html($game->abbr); ?></a><div class="clear"></div></li>
        <?php } endfor; ?>
        </ul>
        <div class="clear"></div>
    </li>

    <?php foreach($matches as $i => $match) :
            if($match->status == 'active' || $match->status == 'done'){

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
            $image1 = blackfyre_aq_resize( $img_url1, 25, 25, true ); //resize & crop im

            $team2id = blackfyre_return_team_post__by_team_id($match->team2);
            $img_url2 = get_post_meta($team2id->post_id, 'clan_photo', true);
            $image2 = blackfyre_aq_resize( $img_url2, 25, 25, true ); //resize & crop img

            $is_playing = ( ($now > $timestamp && $now < $timestamp + 3600) && ($t1 == 0 && $t2 == 0) || ($match->status == 'active') && ($t1 == 0 && $t2 == 0) );
    ?>
    <li class="clanwar-item<?php if($i % 2 != 0) echo ' alt'; ?> game-<?php echo esc_attr($match->game_id); ?>">

            <div class="wrap">
                <?php echo '<a href="' . esc_url(get_permalink($match->post_id)) . '" data-toggle="tooltip" data-original-title="' . esc_attr($match->title) . '">'; ?>
                <?php if($is_playing) : ?>
                <div class="playing"><?php esc_html_e('Playing', 'blackfyre'); ?></div>
                <?php else : ?>
                <div class="scores <?php echo esc_attr($wld_class); ?>"><?php echo sprintf('%d:%d', $t1, $t2); ?></div>
                <?php endif; ?>
                <?php if(empty($image1)){ $image1 = get_template_directory_uri().'/img/defaults/clan25x25.jpg';  } ?>
                <?php if(empty($image2)){ $image2 = get_template_directory_uri().'/img/defaults/clan25x25.jpg';  } ?>
                <div class="match-wrap">

                        <img src="<?php echo esc_url($image1);?>" class="clan1img" alt="<?php echo esc_attr($match->title); ?>" />

                        <span class="vs"><?php esc_html_e("vs","blackfyre");?></span>
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
        <?php } endforeach; ?>
</ul>

            <?php echo $after_widget; ?>

        <?php
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {
        global $wpClanWars;

        $instance = wp_parse_args((array)$instance, $this->default_settings);

        $show_limit = (int)$instance['show_limit'];
        $title = esc_attr($instance['title']);
        $visible_games = $instance['visible_games'];

        $games = $wpClanWars->get_game('id=all&orderby=title&order=asc');
    ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'blackfyre'); ?></label> <input class="widefat" name="<?php echo esc_attr($this->get_field_name('title')); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" value="<?php echo esc_attr($title); ?>" type="text" /></p>


        <p><?php esc_html_e('Show games:', 'blackfyre'); ?></p>
        <p style="overflow: auto; max-height: 100px; border: 1px solid #dfdfdf; background: #fff;" class="widefat">
            <?php foreach($games as $item) : ?>
            <label for="<?php echo esc_attr($this->get_field_id('visible_games-' . $item->id)); ?>"><input type="checkbox" name="<?php echo esc_attr($this->get_field_name('visible_games')); ?>[]" id="<?php echo esc_attr($this->get_field_id('visible_games-' . $item->id)); ?>" value="<?php echo esc_attr($item->id); ?>" <?php checked(true, in_array($item->id, $visible_games)); ?>/> <?php echo esc_attr($item->title); ?></label><br/>
            <?php endforeach; ?>
        </p>
        <p class="description"><?php esc_html_e('Do not check any game if you want to show all games.', 'blackfyre'); ?></p>

        <p><label for="<?php echo esc_attr($this->get_field_id('show_limit')); ?>"><?php esc_html_e('Show matches:', 'blackfyre'); ?></label> <input style="width: 45px;" name="<?php echo esc_attr($this->get_field_name('show_limit')); ?>" id="<?php echo esc_attr($this->get_field_id('show_limit')); ?>" value="<?php echo esc_attr($show_limit); ?>" type="text" /></p>
        <p><label for="<?php echo esc_attr($this->get_field_id('hide_older_than')); ?>"><?php esc_html_e('Hide older than', 'blackfyre'); ?></label><br/><select name="<?php echo esc_attr($this->get_field_name('hide_older_than')); ?>" id="<?php echo esc_attr($this->get_field_id('hide_older_than')); ?>">
            <?php foreach($this->newer_than_options as $key => $option) : ?>
                <option value="<?php echo esc_attr($key); ?>"<?php selected($key, $instance['hide_older_than']); ?>><?php echo esc_attr($option['title']); ?></option>
            <?php endforeach; ?>
        </select></p>
    <?php
    }
}

?>