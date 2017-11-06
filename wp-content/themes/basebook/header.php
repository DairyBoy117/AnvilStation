<!DOCTYPE html>
<html  <?php language_attributes(); ?> <?php if ( of_get_option('fullwidth') ) { ?> class="fullwidth"<?php } ?>>
    <head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php //globals
    	global $page, $paged, $woocommerce;
    ?>

    <?php include_once 'css/colours.php'; ?>


<?php $currentlang = apply_filters( "wpml_home_url", esc_url(home_url('/')));  ?>
    <!--just vars that will be used later-->
    <script type="text/javascript">
        var templateDir = "<?php echo esc_url( get_template_directory_uri() ); ?>";
        var homeUrl = "<?php echo esc_url( $currentlang ); ?>";
        var adminUrl = "<?php echo esc_url( get_admin_url() ); ?>";
        var ajaxurl = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>";
        var slider_speed = "<?php $speed = of_get_option('slider_speed'); if(empty($speed)){ echo 4000;}else{ echo of_get_option('slider_speed');}; ?>";
    </script>

<?php wp_head();  ?>

</head>
<body <?php body_class();  ?>>
<div id="main_wrapper">
    <div class="above-nav container">
        <div class="social-top">
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

        <div class="clear"></div>
    </div>

    <!-- NAVBAR
    ================================================== -->
      <div class="navbar-wrapper container">

          <div class="logo col-lg-6 col-md-6">
            <a class="brand" href="<?php  echo esc_url(site_url('/')); ?>">
              <div class="row">
                <div class="col-sm-6 col-xs-6"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/monitor.png" alt="logo"  /></div>
                <div class="col-sm-6 col-xs-6"><h1>ANVIL STATION</h1><h2>Halo Costuming Group</h2></div> 
              </div>
            </a>
             
          </div>

            <?php if (of_get_option('login_menu')){ ?>



        <?php
            if ( is_user_logged_in() ) {
                global $current_user;
                global $user_level;
                global $wpmu_version;
				global $usermeta;
                wp_get_current_user();

   				if(of_get_option('clan_creation') == '0'){
   					if($usermeta['_checkbox_clan_user'][0] == "" or $usermeta['_checkbox_clan_user'][0] == NULL or $usermeta['_checkbox_clan_user'][0] == "no"){
   						$noclanclass = 'no-clan';
					}
				};

				if(!isset($noclanclass))$noclanclass = '';
            ?>
                <div class="user-wrap <?php echo esc_attr($noclanclass); ?>">
                    <div class="user-avatar"><a class="username" href="<?php echo get_edit_user_link();?>"><?php echo get_avatar( $current_user->ID, $size = '71' );  ?></a></div>
                    <div class="logged-info">
                    <?php $current_user = wp_get_current_user(); ?>
                    <a class="username" href="<?php echo esc_url(get_edit_user_link());?>"><?php echo esc_attr($current_user->nickname);?><br /><span><?php esc_html_e('Member since ','blackfyre'); echo date("M, Y", strtotime(get_userdata(get_current_user_id( ))->user_registered)); ?></span></a>
                    </div>
                    <?php if ( is_plugin_active( 'buddypress/bp-loader.php' ) && function_exists( 'bp_is_active' ) && bp_is_active( 'messages' )){ $link = bp_loggedin_user_domain() . bp_get_messages_slug() . '/inbox'; ?>
                    <a class="btns messages" data-original-title="<?php esc_html_e( 'View your messages', 'blackfyre' ); ?>" data-toggle="tooltip" href="<?php echo esc_url($link);?>">
                        <i class="fa fa-comments-o"></i><?php if(bp_get_total_unread_messages_count( bp_loggedin_user_id() ) > 0){ ?>

                       <i class="msg_ntf"><?php echo bp_get_total_unread_messages_count( bp_loggedin_user_id() ); ?></i>

                     <?php    }?> </a> <?php  } ?>


                     <?php if(of_get_option('clan_creation') == '1' or $usermeta['_checkbox_clan_user'][0] == "yes"){ ?>
                      <a class="btns cross" onclick="composer_front_editor('<?php echo get_current_user_id(); ?>');" data-original-title="<?php esc_html_e('Create a clan', 'blackfyre'); ?>" data-toggle="tooltip"><i class="fa fa-crosshairs"></i> </a>
                     <?php } ?>


                    <a class="btns settings" data-original-title="<?php esc_html_e( 'View your profile', 'blackfyre' ); ?>" data-toggle="tooltip" href="<?php echo esc_url(get_edit_user_link());?>"><i class="fa fa-cog"></i> </a>
                    <a class="logout btns" data-original-title="<?php esc_html_e( 'Log out', 'blackfyre' ); ?>" data-toggle="tooltip" href="<?php echo esc_url(wp_logout_url( esc_url( $currentlang ))); ?>"><i class="fa fa-times"></i> </a>
                       <?php if ($woocommerce) { if(is_woocommerce()){ ?>
	                    <div class="cart-outer">
	                        <div class="cart-menu-wrap">
	                            <div class="cart-menu">
	                                <a class="cart-contents" href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>"><div class="cart-icon-wrap"><i class="icon-shopping-cart"></i> <div class="cart-wrap"><span><?php echo esc_attr($woocommerce->cart->cart_contents_count); ?> </span></div> </div></a>
	                            </div>
	                        </div>

	                        <div class="cart-notification">
	                            <span class="item-name"></span> <?php  esc_html_e('was successfully added to your cart.', 'blackfyre'); ?>
	                        </div>

	                         <!-- If woocommerce -->
		                <?php if ($woocommerce) { if(is_woocommerce()){ ?>
		                        <?php
		                            // Check for WooCommerce 2.0 and display the cart widget
		                            if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
		                                the_widget( 'WC_Widget_Cart', 'title= ' );
		                            } else {
		                                the_widget( 'WooCommerce_Widget_Cart', 'title= ' );
		                            }
		                        ?>

		                 <?php }} ?>
                 			<!-- Endif woocommerce -->

                       </div>
						<?php }} ?>
                    <div class="clear"></div>
                </div>
            <?php
                }else{
            ?>
    <div class="login-info">
    <?php if(get_option( 'users_can_register' ) == '1'){ ?>
    <a class="register-btn" href="<?php echo esc_url(blackfyre_get_permalink_for_template('page-user-registration')); ?>"><i class="fa fa-pencil-square-o"></i> <span><?php esc_html_e('Register', 'blackfyre'); ?></span></a>
    <i><?php esc_html_e('or','blackfyre'); ?></i>
    <?php } ?>
    <a class="login-btn"><i class="fa fa-lock"></i> <span><?php esc_html_e('Sign in', 'blackfyre'); ?></span></a>

        <div id="mcTooltipWrapper" class="login-tooltip" >
            <div id="mcTooltip" >
                <div id="login_tooltip"><div class="closeto"> <span><i class="fa fa-close"></i> </span></div>
                    <form name="LoginWithAjax_Form" id="LoginWithAjax_Form" action="<?php  echo esc_url(wp_login_url()); ?>" method="post">


                            <input type="text" name="log" placeholder="<?php esc_html_e('Username', 'blackfyre');?>" id="lwa_user_login" class="input" value="" />
                            <input type="password" placeholder="<?php esc_html_e('Password', 'blackfyre');?>" name="pwd" id="lwa_user_pass" class="input" value="" />


                    <?php do_action('login_form'); ?>
                            <input name="rememberme" type="checkbox" id="lwa_rememberme" value="forever">
                            <label><?php esc_html_e("Remember Me","blackfyre");?></label>
                            <a id="LoginWithAjax_Links_Remember" href="<?php echo esc_url(wp_login_url()); ?>?action=lostpassword" title="Password Lost and Found"><?php esc_html_e("Lost your password?","blackfyre");?></a>
                            <button type="submit"  class="button-small"  name="wp-submit" id="lwa_wp-submit" value="<?php esc_html_e('GO', 'blackfyre'); ?> " tabindex="100" ><?php esc_html_e('GO', 'blackfyre'); ?> </button>

                            <input type="hidden" name="redirect_to" value="<?php echo esc_url( $currentlang ); ?>" />
                            <input type="hidden" name="lwa_profile_link" value="<?php echo esc_url($lwa_data['profile_link']) ?>" />
                    </form>
                    <a class="register-link" href="<?php echo esc_url(get_permalink(blackfyre_get_ID_by_slug('user-registration'))); ?>"><?php esc_html_e(" Sign up ", "blackfyre"); ?></a>



                <form name="LoginWithAjax_Form" id="LoginWithAjax_Form1" action="<?php  echo esc_url(wp_login_url()); ?>" method="post">
                    <div id="social_login" class="reg" >
                      <?php if(of_get_option('facebook_btn') or of_get_option('twitter_btn') or of_get_option('twitch_btn') or of_get_option('google_btn') or of_get_option('steam_btn')){ ?>
                     <p><span><?php esc_html_e('Or login with:', 'blackfyre'); ?></span></p>
                     <?php } ?>
                      <?php if(of_get_option('facebook_btn')){ ?>
                        <a id='facebooklogin' class='button-medium facebookloginb'><i class='fa fa-facebook-square'></i></a>
                     <?php } ?>
                       <?php if(of_get_option('twitter_btn')){ ?>
                        <a id='twitterlogin' class='button-medium twitterloginb'><i class='fa fa-twitter-square'></i></a>
                    <?php } ?>
                    <?php if(of_get_option('twitch_btn')){ ?>
                        <a id='twitchlogin' class='button-medium twitchloginb'><i class='fa fa fa-twitch'></i></a>
                    <?php } ?>
                    <?php if(of_get_option('google_btn')){ ?>
                        <a id='googlelogin' class='button-medium googleloginb'><i class='fa fa fa-google-plus-square'></i></a>
                    <?php } ?>
                    <?php if(of_get_option('steam_btn')){ ?>
                        <a id='steamlogin' class='button-medium steamloginb'><i class='fa fa fa-steam-square'></i></a>
                    <?php } ?>
                    </div>
                  </form>
                </div>
            </div>
            <div id="mcttCo"></div>
        </div>

</div>

<?php } ?>
    <?php } ?>

          <div class="col-lg-12 col-md-12 nav-top-divider"></div>
          <div class="navbar navbar-inverse navbar-static-top col-lg-12 col-md-12 " role="navigation">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only"><?php esc_html_e('Toggle navigation', 'blackfyre'); ?></span>
                <span class="fa fa-bars"></span>
              </button>
            </div>
            <div class="navbar-collapse collapse">

                <?php if(has_nav_menu('header-menu')) { ?>
              <?php wp_nav_menu( array( 'theme_location'  => 'header-menu', 'depth' => 0,'sort_column' => 'menu_order', 'items_wrap' => '<ul  class="nav navbar-nav">%3$s</ul>', 'walker' => new blackfyre_Menu_front ) ); ?>
                <?php }else { ?>
                   <ul  class="nav"><li>
                   <a href=""><?php esc_html_e('No menu assigned!', 'blackfyre'); ?></a>
                   </li></ul>
                <?php } ?>   <div class="search-top">
                <form method="get" id="sform" action="<?php echo esc_url( site_url( '/' ) ); ?>">
                    <input type="search" autocomplete="off" name="s">

                    <input type="hidden" name="post_type[]" value="matches" />
                    <input type="hidden" name="post_type[]" value="clan" />
                    <input type="hidden" name="post_type[]" value="post" />
                    <input type="hidden" name="post_type[]" value="page" />
                </form>
            </div>
            </div><!--/.nav-collapse -->
          </div><!-- /.navbar-inner -->
    </div><!-- /.navbar -->
<?php if(of_get_option('newsticker')){ ?>
        <div class="after-nav container">
                <div class="ticker-title"><i class="fa fa-bullhorn"></i> &nbsp;<?php if(of_get_option('tickertitle')){ echo of_get_option('tickertitle'); } ?></div>
                <?php  if(of_get_option('tickeritems')){ $news = explode('||', of_get_option('tickeritems')); ?>
                    <ul id="webticker" >
                        <?php $i = 0; foreach ($news as $new) { $i ++; ?>
                            <li id='item<?php echo esc_attr($i); ?>'>
                                <?php $blackfyre_allowed = wp_kses_allowed_html( 'post' ); ?>
                                <?php echo wp_kses($new,$blackfyre_allowed); ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
        </div>
<?php } ?>

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->
<?php
if(is_plugin_active('buddypress/bp-loader.php') && function_exists( 'bp_current_component' ) ){
    $component = bp_current_component();
    if($component == 'members'){ ?>
        <div class="title_wrapper <?php if ( of_get_option('fullwidth') ) {  }else{ ?>container<?php } ?>">
        <div class="col-lg-12">
            <div class="col-lg-6">
            <h1><?php esc_html_e('Search members', 'blackfyre'); ?>
            </h1>
            </div>
            </div>
        <div class="clear"></div>
</div>
    <?php }
}else{
    $component = false;
}
?>
<?php if(is_singular('clan') or $component or is_front_page() or is_page_template('tmp-home.php') or is_page_template('single-clan.php') or is_page_template('profile.php') or is_page_template('tmp-no-title.php') or is_page_template('tmp-home-left.php') or is_page_template('tmp-home-right.php') or is_page_template('tmp-home-news.php')){}elseif(is_search()){ ?>
<div class="title_wrapper <?php if ( of_get_option('fullwidth') ) {  }else{ ?>container<?php } ?>">
        <div class="col-lg-12">
            <div class="col-lg-6"><h1><?php esc_html_e('Search: ', 'blackfyre');  echo get_search_query(); ?></h1></div>
            <div class="col-lg-6 breadcrumbs"><strong><?php blackfyre_breadcrumbs(); ?></strong></div>
        </div>
</div>
<?php }else{ ?>
<div class="title_wrapper <?php if ( of_get_option('fullwidth') ) {  }else{ ?>container<?php } ?>">
        <div class="col-lg-12">

            <div class="col-lg-6">
            <h1><?php
                 if ( is_plugin_active( 'woocommerce/woocommerce.php' )){
                    if (is_shop()){ echo get_the_title(skywarrior_get_id_by_slug ('shop'));}
                    else{ if(is_tag()){esc_html_e("Tag: ",'blackfyre');echo get_query_var('tag' ); }elseif(is_category()){esc_html_e("Category: ",'blackfyre');echo get_the_category_by_ID(get_query_var('cat'));}elseif(is_author()){esc_html_e("Author: ",'blackfyre');echo get_the_author_meta('user_login', get_query_var('author' ));}elseif(is_archive()){ ?>
				  	<?php if ( is_day() ) : ?>
				        <?php printf( esc_html__( 'Daily Archives: %s', 'blackfyre' ), get_the_date() ); ?>
				    <?php elseif ( is_month() ) : ?>
				        <?php printf( esc_html__( 'Monthly Archives: %s', 'blackfyre' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'blackfyre' ) ) ); ?>
				    <?php elseif ( is_year() ) : ?>
				        <?php printf( esc_html__( 'Yearly Archives: %s', 'blackfyre' ), get_the_date( _x( 'Y', 'yearly archives date format', 'blackfyre' ) ) ); ?>
				    <?php else : ?>
				        <?php esc_html_e( 'Blog Archives', 'blackfyre' ); ?>
				    <?php endif; }else{the_title();} }
                 }else{  if(is_tag()){esc_html_e("Tag: ",'blackfyre');echo get_query_var('tag' );}elseif(is_category()){esc_html_e("Category: ",'blackfyre');echo get_the_category_by_ID(get_query_var('cat'));}elseif(is_author()){esc_html_e("Author: ",'blackfyre');echo get_the_author_meta('user_login', get_query_var('author' ));}elseif(is_archive()){ ?>
				  	<?php if ( is_day() ) : ?>
				        <?php printf( esc_html__( 'Daily Archives: %s', 'blackfyre' ), get_the_date() ); ?>
				    <?php elseif ( is_month() ) : ?>
				        <?php printf( esc_html__( 'Monthly Archives: %s', 'blackfyre' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'blackfyre' ) ) ); ?>
				    <?php elseif ( is_year() ) : ?>
				        <?php printf( esc_html__( 'Yearly Archives: %s', 'blackfyre' ), get_the_date( _x( 'Y', 'yearly archives date format', 'blackfyre' ) ) ); ?>
				    <?php else : ?>
				        <?php esc_html_e( 'Blog Archives', 'blackfyre' ); ?>
				    <?php endif; }else{the_title();} } ?>
            </h1>
            </div>
            <div class="col-lg-6 breadcrumbs"><strong><?php blackfyre_breadcrumbs(); ?></strong></div>
        </div>
        <div class="clear"></div>
</div>
<?php } ?>