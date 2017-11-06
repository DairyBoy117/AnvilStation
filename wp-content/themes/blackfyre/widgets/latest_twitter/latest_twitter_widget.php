<?php
/*
Plugin Name: Latest twitter sidebar widget
Plugin URI: http://www.tacticaltechnique.com/wordpress/latest-twitter-sidebar-widget/
Description: Creates a sidebar widget that displays the latest twitter updates for any user with public tweets.
Author: Corey Salzano
Email: coreysalzano@gmail.com
Version: 0.120328
Author URI: http://www.tacticaltechnique.com/
*/
class latest_twitter_widget extends WP_Widget {

    function __construct() {
    	 parent::__construct(
        'latest_twitter_widget', // Base ID
        esc_html__('Latest twitter widget', 'blackfyre'), // Name
        array( 'description' => esc_html__( 'Displays your latest twitter.com updates', 'blackfyre' ), ) // Args
    );
 }
    function form($instance) {
        // outputs the options form on admin
        if ( !function_exists('quot') ){
            function quot($txt){
                return str_replace( "\"", "&quot;", $txt );
            }
        }
        // format some of the options as valid html
        @$username = htmlspecialchars($instance['user'], ENT_QUOTES);
        @$api = htmlspecialchars($instance['api'], ENT_QUOTES);
        @$apisecret = htmlspecialchars($instance['apisecret'], ENT_QUOTES);
        @$token = htmlspecialchars($instance['token'], ENT_QUOTES);
        @$tokensecret = htmlspecialchars($instance['tokensecret'], ENT_QUOTES);
        @$updateCount = htmlspecialchars($instance['count'], ENT_QUOTES);
        @$showTwitterIconTF = $instance['showTwitterIconTF'];
        @$showProfilePicTF = $instance['showProfilePicTF'];
        @$showTweetTimeTF = $instance['showTweetTimeTF'];
        @$widgetTitle = stripslashes(quot($instance['widgetTitle']));
        @$includeRepliesTF = $instance['includeRepliesTF'];
    ?>
        <p>
            <label for="<?php echo $this->get_field_id('user'); ?>" style="line-height:35px;display:block;"><?php esc_html_e("Twitter user: @", 'blackfyre') ?><input type="text" size="12" id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>" value="<?php echo $username; ?>" /></label>
            <label for="<?php echo $this->get_field_id('count'); ?>" style="line-height:35px;display:block;"><?php esc_html_e("Show", 'blackfyre') ?> <input type="text" id="<?php echo $this->get_field_id('count'); ?>" size="2" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $updateCount; ?>" /><?php esc_html_e("twitter updates", 'blackfyre'); ?></label>
            <label for="<?php echo $this->get_field_id('widgetTitle'); ?>" style="line-height:35px;display:block;"><?php esc_html_e("Widget title:", 'blackfyre') ?> <input type="text" id="<?php echo $this->get_field_id('widgetTitle'); ?>" size="16" name="<?php echo $this->get_field_name('widgetTitle'); ?>" value="<?php echo $widgetTitle; ?>" /></label>
            <p><input type="checkbox" id="<?php echo $this->get_field_id('includeRepliesTF'); ?>" value="1" name="<?php echo $this->get_field_name('includeRepliesTF'); ?>"<?php if($includeRepliesTF){ ?> checked="checked"<?php } ?>> <label for="<?php echo $this->get_field_id('includeRepliesTF'); ?>"><?php esc_html_e("Include replies", 'blackfyre') ?></label></p>
            <br />
            <?php esc_html_e('If your tweets doesn&#8217;t show up with this Application settings please register another twitter APP on https://apps.twitter.com/app', 'blackfyre') ?>
            <br></br>
            <label for="<?php echo $this->get_field_id('api'); ?>" style="line-height:35px;display:block;"><?php esc_html_e("Api key:", 'blackfyre') ?><input placeholder="Cz2crWMRSc62Nlp1yagt9w" type="text" size="35" id="<?php echo $this->get_field_id('api'); ?>" name="<?php echo $this->get_field_name('api'); ?>" value="<?php echo $api; ?>" /></label>
            <label for="<?php echo $this->get_field_id('apisecret'); ?>" style="line-height:35px;display:block;"><?php esc_html_e("Api key secret: ", 'blackfyre') ?><input placeholder="UOwKXRriyG2l4oL8NKuqsEwr0pXEkPNEkhrxrftI4lE" type="text" size="35" id="<?php echo $this->get_field_id('apisecret'); ?>" name="<?php echo $this->get_field_name('apisecret'); ?>" value="<?php echo $apisecret; ?>" /></label>
            <label for="<?php echo $this->get_field_id('token'); ?>" style="line-height:35px;display:block;"><?php esc_html_e("Token: ", 'blackfyre') ?><input placeholder="764237641-JLC4OqK2WNkpWlNgc3pHWN68bmjl0s9669nldZ5I" type="text" size="35" id="<?php echo $this->get_field_id('token'); ?>" name="<?php echo $this->get_field_name('token'); ?>" value="<?php echo $token; ?>" /></label>
            <label for="<?php echo $this->get_field_id('tokensecret'); ?>" style="line-height:35px;display:block;"><?php esc_html_e("Token secret: ", 'blackfyre') ?><input placeholder="8Lo97YIwwLJn78FlFwZ80lw2iOHEyZ8wwcJ9xCTVv8" type="text" size="35" id="<?php echo $this->get_field_id('tokensecret'); ?>" name="<?php echo $this->get_field_name('tokensecret'); ?>" value="<?php echo $tokensecret; ?>" /></label>
            <p><?php esc_html_e("To style the output of the widget, modify", 'blackfyre') ?> <a href="<?php echo  home_url(); ?>/wp-content/plugins/latest-twitter-sidebar-widget/latest_twitter_widget.css"><?php esc_html_e("this CSS stylesheet", 'blackfyre') ?></a>. <?php esc_html_e("You should also back this file up before updating the plugin.", 'blackfyre') ?></p>
        </p>
<?php
    }
    function update($new_instance, $old_instance) {
        // processes widget options to be saved
        $instance = $old_instance;
        $instance['user'] = esc_html($new_instance['user']);
        $instance['api'] = esc_html($new_instance['api']);
        $instance['apisecret'] = esc_html($new_instance['apisecret']);
        $instance['token'] = esc_html($new_instance['token']);
        $instance['tokensecret'] = esc_html($new_instance['tokensecret']);
        $instance['count'] = esc_html($new_instance['count']);
        $instance['widgetTitle'] = esc_html( $new_instance['widgetTitle']);
        $instance['showTwitterIconTF'] = false;
        $instance['showProfilePicTF'] = false;
		if (strlen ($instance['api']) < 5) {
			$instance['api'] = "Cz2crWMRSc62Nlp1yagt9w";
		}
		if (strlen ($instance['apisecret']) < 10) {
			$instance['apisecret'] = "UOwKXRriyG2l4oL8NKuqsEwr0pXEkPNEkhrxrftI4lE";
		}
        if (strlen ($instance['token']) < 10) {
			$instance['token'] = "764237641-JLC4OqK2WNkpWlNgc3pHWN68bmjl0s9669nldZ5I";
		}
		if (strlen ($instance['tokensecret']) < 10) {
			$instance['tokensecret'] = "8Lo97YIwwLJn78FlFwZ80lw2iOHEyZ8wwcJ9xCTVv8";
		}
        switch( $new_instance['showIconOrPic'] ){
            case "icon":
                $instance['showTwitterIconTF'] = true;
                break;
            case "pic":
                $instance['showProfilePicTF'] = true;
                break;
            case "none":
                break;
        }
        if( $new_instance['showTweetTimeTF']=="1"){
            $instance['showTweetTimeTF'] = true;
        } else{
            $instance['showTweetTimeTF'] = false;
        }
        if( $new_instance['includeRepliesTF']=="1"){
            $instance['includeRepliesTF'] = true;
        } else{
            $instance['includeRepliesTF'] = false;
        }
        return $instance;
    }
    function widget($args, $instance) {

        extract($args, EXTR_SKIP);

        $query_arg['count']              = $instance['count'] ? $instance['count'] : 3;
        $query_arg['exclude_replies']    = !($instance['includeRepliesTF']);
        $query_arg['include_rts']        = false;
        $query_arg['screen_name'] = $instance['user'];
        $title = $instance['widgetTitle'];

        if( !class_exists( 'Codebird' ) ) {
            require_once( get_template_directory() . '/widgets/latest_twitter/codebird.php' );
        }

		if (strlen ($instance['api']) < 5) {
			$instance['api'] = "Cz2crWMRSc62Nlp1yagt9w";
		}
		if (strlen ($instance['apisecret']) < 10) {
			$instance['apisecret'] = "UOwKXRriyG2l4oL8NKuqsEwr0pXEkPNEkhrxrftI4lE";
		}
        if (strlen ($instance['token']) < 10) {
			$instance['token'] = "764237641-JLC4OqK2WNkpWlNgc3pHWN68bmjl0s9669nldZ5I";
		}
		if (strlen ($instance['tokensecret']) < 10) {
			$instance['tokensecret'] = "8Lo97YIwwLJn78FlFwZ80lw2iOHEyZ8wwcJ9xCTVv8";
		}

		Codebird::setConsumerKey( $instance["api"], $instance["apisecret"] );

        $codebird_instance = Codebird::getInstance();


        $codebird_instance->setToken( $instance["token"], $instance["tokensecret"] );

        $codebird_instance->setReturnFormat( CODEBIRD_RETURNFORMAT_ARRAY );

        try {
            $latest_tweet = $codebird_instance->statuses_userTimeline( $query_arg );
        }
        catch( Exception $e ) {
            echo  'Error retrieving tweets';
        }

        echo $before_widget;
        echo $before_title . $title . $after_title;



		if (isset($latest_tweet['errors'][0])) {
			//error handling here plz
			echo "Error code ".$latest_tweet['errors'][0]['code'].": ".$latest_tweet['errors'][0]['message'];
		} else {
			foreach( $latest_tweet as $single_tweet ) {
				$tweet_text = $single_tweet['text'];
				$tweet_text      = preg_replace( "/[^^](http:\/\/+[\S]*)/", '<a href="$0">$0</a>', $tweet_text );

				$screen_name     = $single_tweet['user']['screen_name'];
				$user_permalink  = 'http://twitter.com/#!/' . $screen_name;
				$tweet_permalink = 'http://twitter.com/#!/' . $screen_name . '/status/' . $single_tweet['id_str'];

				if( $tweet_text ) {
					echo '<div class="latest-twitter-tweet"><i class="fa fa-twitter"></i> &quot;' . $tweet_text . '&quot;</div>';
				}
			}
		}
        $username = $instance['user'];
        echo '<div id="latest-twitter-follow-link"><a href="http://twitter.com/' . $username . '">';
        printf( esc_html__( 'Follow %s on Twitter', 'blackfyre' ), $username );
        echo '</a></div>';
        echo $after_widget;
    }
}
if( !function_exists('register_latest_twitter_widget')){
    add_action('widgets_init', 'register_latest_twitter_widget');
    function register_latest_twitter_widget() {
        register_widget('latest_twitter_widget');
    }
}
if( !function_exists('latest_twitter_widget_css')){
    function latest_twitter_widget_css( ){ ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/widgets/latest_twitter/latest_twitter_widget.css" />
    <?php
     }
    add_action('wp_head', 'latest_twitter_widget_css');
}
?>