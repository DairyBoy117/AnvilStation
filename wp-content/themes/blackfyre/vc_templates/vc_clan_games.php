<?php
$el_games =  '';
extract( shortcode_atts( array(
    'el_games' => '',
    'el_class' => '',
    'el_games_title' => ''
), $atts) );

    global $wpClanWars, $post;

    $game_ids = array();
    if ( $el_games != '' ) {
    	?>
<div class="<?php echo $css_class; if(!empty($el_class)) echo $el_class; ?> block">
    <div class="wpb_wrapper">
        <div class="title-wrapper">
            <h3 class="widget-title"><i class="fa fa-gamepad"></i> <?php if(!empty($el_games_title)){ echo esc_attr($el_games_title);}else{ _e('Games', 'blackfyre'); } ?></h3>
            <div class="clear"></div>
        </div>
        <div class="wcontainer">
	    	<ul class="gamesb">
	    	<?php
	        $el_games = explode( ",", $el_games );
            if(empty($el_games)){
                _e('Choose your clan games!','blackfyre');
            }else{
	        foreach ( $el_games as $game ) {
	            $g = $wpClanWars->get_game('id='.$game);
	            array_push( $game_ids, $g[0]->id ); ?>
				<a href="<?php echo esc_url(blackfyre_get_permalink_for_template('page-all-clans-for-game')."?gid=".$g[0]->id); ?>"><li> <img alt="img" src="<?php echo blackfyre_return_game_image($g[0]->id); ?>" /> <strong><?php echo esc_attr($g[0]->title); ?> </strong></li></a>
				<?php

	        }

	        update_post_meta($post->ID, 'games', $game_ids);
            }
			?>
	    	</ul>
    	</div>
    </div>
</div>
    	<?php
    }else{ ?>
       <div class="<?php echo $css_class; if(!empty($el_class)) echo esc_attr($el_class); ?> block">
    <div class="wpb_wrapper">
        <div class="title-wrapper">
            <h3 class="widget-title"><i class="fa fa-gamepad"></i> <?php  _e('Games', 'blackfyre');  ?></h3>
            <div class="clear"></div>
        </div>
        <div class="wcontainer">
            <ul class="gamesb">
            <?php  _e('Choose your games!','blackfyre'); ?>
            </ul>
        </div>
    </div>
</div>

<?php } ?>