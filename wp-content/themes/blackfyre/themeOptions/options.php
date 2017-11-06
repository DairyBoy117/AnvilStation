<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */
function optionsframework_option_name() {
    // This gets the theme name from the stylesheet (lowercase and without spaces)
    $themename = wp_get_theme();
    $themename = $themename['Name'];
    $themename = preg_replace("/\W/", "", strtolower($themename) );
    $optionsframework_settings = get_option('optionsframework');
    $optionsframework_settings['id'] = $themename;
    update_option('optionsframework', $optionsframework_settings);
}
function optionsframework_options() {
    // Slider Options
    $slider_choice_array = array("none" => "No Showcase", "accordion" => "Accordion", "wpheader" => "WordPress Header", "image" => "Your Image", "easing" => "Easing Slider", "custom" => "Custom Slider");
    // Pull all the categories into an array
    $options_categories = array();
    $options_categories_obj = get_categories();
    foreach ($options_categories_obj as $category) {
        $options_categories[$category->cat_ID] = $category->cat_name;
    }
    // Pull all the pages into an array
    $options_pages = array();
    $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
    $options_pages[''] = 'Select a page:';
    foreach ($options_pages_obj as $page) {
        $options_pages[$page->ID] = $page->post_title;
    }
    // If using image radio buttons, define a directory path
    $radioimagepath =  get_stylesheet_directory_uri() . '/themeOptions/images/';
    // define sample image directory path
    $imagepath =  get_template_directory_uri() . '/images/demo/';
    $options = array();
    $options[] = array( "name" => esc_html__("General Settings", 'blackfyre'),
                        "type" => "heading");
   $options[] = array( "name" => esc_html__("General Settings", 'blackfyre'),
                     "type" => "info");
    $options[] = array( "name" => esc_html__("Upload Your Logo", 'blackfyre'),
                        "desc" => esc_html__("Upload your logo. We recommend keeping it within reasonable size. Max 150px and minimum height of 90px but not more than 120px.", 'blackfyre'),
                        "id" => "logo",
                        "std" => get_template_directory_uri()."/img/logo.png",
                        "type" => "upload");
   $options[] = array( "name" => esc_html__("Login button in the menu", 'blackfyre'),
                        "desc" => esc_html__("Enable the login avatar in the menu", 'blackfyre'),
                        "id" => "login_menu",
                        "std" => "1",
                        "type" => "jqueryselect");
	$options[] = array( "name" => esc_html__("Jquery Scrollbar", 'blackfyre'),
                        "desc" => esc_html__("Enable the option of a smooth jquery scrollbar.", 'blackfyre'),
                        "id" => "scrollbar",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Image appear effect", 'blackfyre'),
                        "desc" => esc_html__("Enable the image appearing effect when scrolling down.", 'blackfyre'),
                        "id" => "appear",
                        "std" => "1",
                        "type" => "jqueryselect");

	$options[] = array( "name" => esc_html__("Share this", 'blackfyre'),
                        "desc" => esc_html__("Enable the share this option. This addon has massive inpact on website performance", 'blackfyre'),
                        "id" => "share_this",
                        "std" => "0",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Auto slider", 'blackfyre'),
                        "desc" => esc_html__("Enable auto slider option for homepage.", 'blackfyre'),
                        "id" => "auto_slider",
                        "std" => "0",
                        "type" => "jqueryselect");
     $options[] = array( "name" => esc_html__("Slider speed", 'blackfyre'),
                        "desc" => esc_html__("Add slider speed in miliseconds.", 'blackfyre'),
                        "id" => "slider_speed",
                        "std" => "4000",
                        "type" => "text");
	 $options[] = array( "name" => esc_html__("Admin toolbar", 'blackfyre'),
                        "desc" => esc_html__("Enable admin toolbar in front end.", 'blackfyre'),
                        "id" => "admin_toolbar",
                        "std" => "0",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Terms & Conditions", 'blackfyre'),
                        "desc" => esc_html__("Add link to your t&c file", 'blackfyre'),
                        "id" => "terms",
                        "std" => "",
                        "type" => "text");
   $options[] = array( "name" => esc_html__("Contact email", 'blackfyre'),
                        "desc" => esc_html__("Add your contact email here.", 'blackfyre'),
                        "id" => "email",
                        "std" => "",
                        "type" => "text");
    $options[] = array( "name" => esc_html__("News Ticker", 'blackfyre'),
                     "type" => "info");
    $options[] = array( "name" => esc_html__("Show news ticker", 'blackfyre'),
                        "desc" => esc_html__("Enable news ticker.", 'blackfyre'),
                        "id" => "newsticker",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Ticker title", 'blackfyre'),
                        "desc" => esc_html__("Add ticker title.", 'blackfyre'),
                        "id" => "tickertitle",
                        "std" => "",
                        "type" => "text");
    $options[] = array( "name" => esc_html__("Ticker items", 'blackfyre'),
                        "desc" => esc_html__("Add ticker items. Use || sign to separate items.", 'blackfyre'),
                        "id" => "tickeritems",
                        "std" => "",
                        "type" => "textarea");


	$options[] = array( "name" => esc_html__("Archive page template", 'blackfyre'),
                     "type" => "info");

	$options[] = array(
		'name' => esc_html__( 'Select category/archive page template', 'blackfyre' ),
		'desc' => esc_html__( 'Choose template for your category/archive page.', 'blackfyre' ),
		'id' => 'archive_template',
		'std' => 'right',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
				'full' => esc_html__( 'Full width', 'blackfyre' ),
				'right' => esc_html__( 'Right Sidebar', 'blackfyre' ),
				'left' => esc_html__( 'Left Sidebar', 'blackfyre' )
		)
	);

	$options[] = array( "name" => esc_html__("Posts", 'blackfyre'),
                     "type" => "info");

	$options[] = array(
		'name' => esc_html__( 'Select rating type', 'blackfyre' ),
		'desc' => esc_html__( 'Choose rating type for your posts', 'blackfyre' ),
		'id' => 'rating_type',
		'std' => 'stars',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
				'numbers' => esc_html__( 'Numbers', 'blackfyre' ),
				'stars' => esc_html__( 'Stars', 'blackfyre' )
		)
	);


	$options[] = array(
		'name' => esc_html__( 'Heart rating', 'blackfyre' ),
		'desc' => esc_html__( 'Disbale heart rating in post pages', 'blackfyre' ),
		'id' => 'heart_rating',
	    'std' => "1",
        'type' => "jqueryselect"
	);

	$options[] = array( "name" => esc_html__("Registration page", 'blackfyre'),
                     "type" => "info");
	 $options[] = array( "name" => esc_html__("Registration page title", 'blackfyre'),
                        "desc" => esc_html__("Add text for registration page title.", 'blackfyre'),
                        "id" => "cpagetitle",
                        "std" => "JOIN BLACKFYRE TODAY FOR free!",
                        "type" => "text");


	 $options[] = array( "name" => esc_html__("Clan Wars", 'blackfyre'),
                        "type" => "heading");

	 $options[] = array( "name" => esc_html__("Allow all users to create clans", 'blackfyre'),
                        "desc" => esc_html__("Enable clan creation.", 'blackfyre'),
                        "id" => "clan_creation",
                        "std" => "1",
                        "type" => "jqueryselect");

	$options[] = array( "name" => esc_html__("Number of users in members page.", 'blackfyre'),
                        "desc" => esc_html__("Add number of users you want to display in members page.", 'blackfyre'),
                        "id" => "members_num",
                        "std" => "",
                        "type" => "text");
//SEO
$options[] = array( "name" => esc_html__("SEO", 'blackfyre'),
                        "type" => "heading");
$options[] = array( "name" => esc_html__("SEO", 'blackfyre'),
                     "type" => "info");
$options[] = array( "name" => esc_html__("Home title", 'blackfyre'),
                        "desc" => esc_html__("Enter home title.", 'blackfyre'),
                        "id" => "hometitle",
                        "std" => "",
                        "type" => "text");
$options[] = array( "name" => esc_html__("Home description", 'blackfyre'),
                        "desc" => esc_html__("Enter home description.", 'blackfyre'),
                        "id" => "metadesc",
                        "std" => "",
                        "type" => "textarea");
$options[] = array( "name" => esc_html__("Keywords", 'blackfyre'),
                        "desc" => esc_html__("Enter keywords comma separated.", 'blackfyre'),
                        "id" => "keywords",
                        "std" => "",
                        "type" => "text");
$options[] = array( "name" => esc_html__("Google analytics", 'blackfyre'),
                        "desc" => esc_html__("Enter google analytics code.", 'blackfyre'),
                        "id" => "googlean",
                        "std" => "",
                        "type" => "textarea");




// Colour Settings
    $options[] = array( "name" => esc_html__("Customize", 'blackfyre'),
                        "type" => "heading");
/*	$options[] = array( "name" => "Boxed",
                	"desc" => "Enable boxed site layout.",
                	"id" => "boxed_layout",
                	"std" => "1",
                 	"type" => "jqueryselect");*/
// Backgrounds
    $options[] = array( "name" => esc_html__("Backgrounds", 'blackfyre'),
                        "type" => "info");

    $options[] = array( "name" => esc_html__("Top background", 'blackfyre'),
                        "desc" => esc_html__("Background for the header of the site.", 'blackfyre'),
                        "id" => "header_bg",
                        "std" => get_template_directory_uri()."/img/header.jpg",
                        "type" => "upload");

    $options[] = array( "name" => esc_html__("Fixed background", 'blackfyre'),
                        "desc" => esc_html__("Set background to fixed position.", 'blackfyre'),
                        "id" => "background_fix",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Footer background", 'blackfyre'),
                        "desc" => esc_html__("Background for the footer of the site.", 'blackfyre'),
                        "id" => "footer_bg",
                        "std" => "",
                        "type" => "upload");
	$imagepath =  get_template_directory_uri() . '/themeOptions/images/repeat/';
    $options[] = array( "name" => esc_html__("Footer background repeat", 'blackfyre'),
                        "desc" => esc_html__("You could choose to repeat the background image if you want to use a pattern.", 'blackfyre'),
                        "id" => "repeat",
                        "std" =>"b1",
                        "type" => "images",
						"options" => array(
						'b1' => $imagepath . 'b1.jpg',
						'b2' => $imagepath . 'b2.jpg',
						'b3' => $imagepath . 'b3.jpg',
						'b4' => $imagepath . 'b4.jpg',
						));

    $options[] = array( "name" => esc_html__("Background colour", 'blackfyre'),
                    "desc" => esc_html__("Colour for the background.", 'blackfyre'),

                    "id" => "bg_color",

                    "std" => "#1d2031",

                    "type" => "color" );

// Colours

    $options[] = array( "name" => esc_html__("Colours", 'blackfyre'),
                        "type" => "info");

	$options[] = array( "name" => esc_html__("Top gradient", 'blackfyre'),
					"desc" => esc_html__("Top colour for the gradient backgrounds of the site", 'blackfyre'),

					"id" => "top_grad_color",

					"std" => "#26c3f6",

					"type" => "color" );

	$options[] = array( "name" => esc_html__("Bottom gradient", 'blackfyre'),
					"desc" => esc_html__("Bottom colour of the gradient. If you don't want a gradient effect use the same colour as the top gradient.", 'blackfyre'),

					"id" => "bottom_grad_color",

					"std" => "#096aa1",

					"type" => "color" );
	$options[] = array( "name" => esc_html__("Inner shadow gradient", 'blackfyre'),
					"desc" => esc_html__("Affects the same items as the gradient. Adds a shadow inside the block. A light colour is recommended", 'blackfyre'),

					"id" => "inner_shadow_color",

					"std" => "#05c7f7",

					"type" => "color" );

    $options[] = array( "name" => esc_html__("Primary Colour", 'blackfyre'),
                    "desc" => esc_html__("Affects different background and items of the site like links, some buttons, etc.", 'blackfyre'),

                    "id" => "primary_color",

                    "std" => "#25c2f5",

                    "type" => "color" );



// Footer section start
    $options[] = array( "name" => esc_html__("Footer", 'blackfyre'), "type" => "heading");
    $options[] = array( "name" => esc_html__("Footer", 'blackfyre'),
                     "type" => "info");
                $options[] = array( "name" => esc_html__("Copyright", 'blackfyre'),
                        "desc" => esc_html__("You can use HTML code in here.", 'blackfyre'),
                        "id" => "copyright",
                        "std" => "Made by Skywarrior Themes.",
                        "type" => "textarea");

                        // Social Network setup

    $options[] = array( "name" => esc_html__("Social Settings", 'blackfyre'), "type" => "heading");

    $options[] = array( "name" => esc_html__("Social Settings - Facebook", 'blackfyre'),

                        "type" => "info");

    $options[] = array( "name" => esc_html__("Turn on Facebook", 'blackfyre'),

                        "desc" => esc_html__("Use Facebook for login", 'blackfyre'),

                        "id" => "facebook_btn",

                        "std" => "0",

                        "type" => "jqueryselect");

    $options[] = array( "name" => esc_html__("Facebook App ID", 'blackfyre'),

                        "desc" => esc_html__("Add your Facebook App ID here", 'blackfyre'),

                        "id" => "facebook_app",

                        "std" => "Facebook app ID",

                        "type" => "text");

    $options[] = array( "name" => esc_html__("Facebook App Secret", 'blackfyre'),

                        "desc" => esc_html__("Add your Facebook App Secret here", 'blackfyre'),

                        "id" => "facebook_secret",

                        "std" => "Facebook Secret",

                        "type" => "text");



     $options[] = array( "name" => esc_html__("Social Settings - Twitter", 'blackfyre'),

                        "type" => "info");

     $options[] = array( "name" => esc_html__("Turn on Twitter", 'blackfyre'),

                        "desc" => esc_html__("Use Twitter for login", 'blackfyre'),

                        "id" => "twitter_btn",

                        "std" => "0",

                        "type" => "jqueryselect");

    $options[] = array( "name" => esc_html__("Twitter App ID", 'blackfyre'),

                        "desc" => esc_html__("Add your Twitter API Key here", 'blackfyre'),

                        "id" => "twitter_app",

                        "std" => "Twitter API key",

                        "type" => "text");

    $options[] = array( "name" => esc_html__("Twitter API Secret", 'blackfyre'),

                        "desc" => esc_html__("Add your Twitter API Secret here", 'blackfyre'),

                        "id" => "twitter_secret",

                        "std" => "Twitter Secret",

                        "type" => "text");

    $options[] = array( "name" => esc_html__("Social Settings - Google+", 'blackfyre'),

                        "type" => "info");

     $options[] = array( "name" => esc_html__("Turn on Google+", 'blackfyre'),

                        "desc" => esc_html__("Use Google+ for login", 'blackfyre'),

                        "id" => "google_btn",

                        "std" => "0",

                        "type" => "jqueryselect");

    $options[] = array( "name" => esc_html__("Google+ OAuth Consumer Key", 'blackfyre'),

                        "desc" => esc_html__("Add your Google+ OAuth Consumer Key here", 'blackfyre'),

                        "id" => "google_app",

                        "std" => "Google+ app ID",

                        "type" => "text");

    $options[] = array( "name" => esc_html__("Google+ OAuth Consumer Secret", 'blackfyre'),

                        "desc" => esc_html__("Add your Google+ OAuth Consumer Secret here", 'blackfyre'),

                        "id" => "google_secret",

                        "std" => "Google+ Secret",

                        "type" => "text");

    $options[] = array( "name" => esc_html__("Social Settings - Twitch", 'blackfyre'),

                        "type" => "info");

      $options[] = array( "name" => esc_html__("Turn on Twitch", 'blackfyre'),

                        "desc" => esc_html__("Use Twitch for login", 'blackfyre'),

                        "id" => "twitch_btn",

                        "std" => "0",

                        "type" => "jqueryselect");

     $options[] = array( "name" => esc_html__("Twitch App ID", 'blackfyre'),

                        "desc" => esc_html__("Add your Twitch Client ID here", 'blackfyre'),

                        "id" => "twitch_client_id",

                        "std" => "Twitch Client ID",

                        "type" => "text");

    $options[] = array( "name" => esc_html__("Twitch Client Secret", 'blackfyre'),

                        "desc" => esc_html__("Add your Twitch Client Secret here", 'blackfyre'),

                        "id" => "twitch_secret",

                        "std" => "Twitch Secret",

                        "type" => "text");


 $options[] = array( "name" => esc_html__("Social Settings - Steam", 'blackfyre'),

                        "type" => "info");



 $options[] = array( "name" => esc_html__("Turn on Steam", 'blackfyre'),

                        "desc" => esc_html__("Use Steam for login", 'blackfyre'),

                        "id" => "steam_btn",

                        "std" => "0",

                        "type" => "jqueryselect");

     $options[] = array( "name" => esc_html__("Steam Web API Key:", 'blackfyre'),

                        "desc" => esc_html__("Add your Steam Your Steam Web API Key:", 'blackfyre'),

                        "id" => "steam_app",

                        "std" => "Steam API key",

                        "type" => "text");



// Social Media
    $options[] = array( "name" => esc_html__("Social Media", 'blackfyre'),
                        "type" => "heading");
 $options[] = array( "name" => esc_html__("Social Media", 'blackfyre'),
                     "type" => "info");
     $options[] = array( "name" => esc_html__("Enable Twitter", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the Twitter icon that shows on the footer section.", 'blackfyre'),
                        "id" => "twitter",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Twitter Link", 'blackfyre'),
                        "desc" => esc_html__("Paste your twitter link here.", 'blackfyre'),
                        "id" => "twitter_link",
                        "std" => "#",
                        "type" => "text");
    $options[] = array( "name" => esc_html__("Enable Facebook", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the Facebook icon that shows on the footer section.", 'blackfyre'),
                        "id" => "facebook",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Facebook Link", 'blackfyre'),
                        "desc" => esc_html__("Paste your facebook link here.", 'blackfyre'),
                        "id" => "facebook_link",
                        "std" => "#",
                        "type" => "text");
    $options[] = array( "name" => esc_html__("Enable Steam", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the Steam icon that shows on the footer section.", 'blackfyre'),
                        "id" => "steam",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Steam Link", 'blackfyre'),
                        "desc" => esc_html__("Paste your Steam link here.", 'blackfyre'),
                        "id" => "steam_link",
                        "std" => "#",
                        "type" => "text");

    $options[] = array( "name" => esc_html__("Enable Pinterest", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the Pinterest icon that shows on the footer section.", 'blackfyre'),
                        "id" => "pinterest",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Pinterest Link", 'blackfyre'),
                        "desc" => esc_html__("Paste your pinterest link here.", 'blackfyre'),
                        "id" => "pinterest_link",
                        "std" => "#",
                        "type" => "text");

    $options[] = array( "name" => esc_html__("Enable Google+", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the Google+ icon that shows on the footer section.", 'blackfyre'),
                        "id" => "googleplus",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Google+ Link", 'blackfyre'),
                        "desc" => esc_html__("Paste your google+ link here.", 'blackfyre'),
                        "id" => "google_link",
                        "std" => "#",
                        "type" => "text");
    $options[] = array( "name" => esc_html__("Enable dribbble", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the dribbble icon that shows on the footer section.", 'blackfyre'),
                        "id" => "dribbble",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Dribbble link", 'blackfyre'),
                        "desc" => esc_html__("Paste your dribbble link here.", 'blackfyre'),
                        "id" => "dribbble_link",
                        "std" => "#",
                        "type" => "text");
    $options[] = array( "name" => esc_html__("Enable vimeo", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the vimeo icon that shows on the footer section.", 'blackfyre'),
                        "id" => "vimeo",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Vimeo link", 'blackfyre'),
                        "desc" => esc_html__("Paste your vimeo link here.", 'blackfyre'),
                        "id" => "vimeo_link",
                        "std" => "#",
                        "type" => "text");
      $options[] = array( "name" => esc_html__("Enable youtube", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the youtube icon that shows on the footer section.", 'blackfyre'),
                        "id" => "youtube",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Youtube link", 'blackfyre'),
                        "desc" => esc_html__("Paste your youtube link here.", 'blackfyre'),
                        "id" => "youtube_link",
                        "std" => "#",
                        "type" => "text");
      $options[] = array( "name" => esc_html__("Enable twitch", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the twitch icon that shows on the footer section.", 'blackfyre'),
                        "id" => "twitch",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Twitch link", 'blackfyre'),
                        "desc" => esc_html__("Paste your twitch link here.", 'blackfyre'),
                        "id" => "twitch_link",
                        "std" => "#",
                        "type" => "text");

	      $options[] = array( "name" => esc_html__("Enable Instagram", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the isntagram icon that shows on the footer section.", 'blackfyre'),
                        "id" => "instagram",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("Instagram link", 'blackfyre'),
                        "desc" => esc_html__("Paste your Instagram link here.", 'blackfyre'),
                        "id" => "instagram_link",
                        "std" => "#",
                        "type" => "text");

    $options[] = array( "name" => esc_html__("Instagram link", 'blackfyre'),
                        "desc" => esc_html__("Paste your Instagram link here.", 'blackfyre'),
                        "id" => "instagram_link",
                        "std" => "#",
                        "type" => "text");

    $options[] = array( "name" => esc_html__("Enable RSS", 'blackfyre'),
                        "desc" => esc_html__("Show or hide the RSS icon that shows on the footer section.", 'blackfyre'),
                        "id" => "rss",
                        "std" => "1",
                        "type" => "jqueryselect");
    $options[] = array( "name" => esc_html__("RSS Link", 'blackfyre'),
                        "desc" => esc_html__("Paste your RSS link here.", 'blackfyre'),
                        "id" => "rss_link",
                        "std" => "#",
                        "type" => "text");
// WooCommerce

$options[] = array( "name" => esc_html__("WooCommerce", 'blackfyre'),
                        "type" => "heading");
$options[] = array( "name" => esc_html__("WooCommerce", 'blackfyre'),
                        "type" => "info");
$imagepath =  get_template_directory_uri() . '/themeOptions/images/sidebar/';
    $options[] = array( "name" => esc_html__("Main shop page sidebar", 'blackfyre'),
                        "desc" => esc_html__("Choose page layout that you want to use on main WooCommerce page.", 'blackfyre'),
                        "id" => "mainshop",
                        "std" =>"s3",
                        "type" => "images",
                        "options" => array(
                        's1' => $imagepath . 'full.png',
                        's2' => $imagepath . 'left.png',
                        's3' => $imagepath . 'right.png',

                        ));


    $options[] = array( "name" => esc_html__("Single product page sidebar", 'blackfyre'),
                        "desc" => esc_html__("Choose page layout that you want to use on single product WooCommerce page.", 'blackfyre'),
                        "id" => "singleprod",
                        "std" =>"s1",
                        "type" => "images",
                        "options" => array(
                        's1' => $imagepath . 'full.png',
                        's2' => $imagepath . 'left.png',
                        's3' => $imagepath . 'right.png',

                        ));

	//added by shark
	$options[] = array( "name" => esc_html__("One click install", 'blackfyre'),
                       "type" => "heading");
 	$options[] = array( "name" => esc_html__("One click install", 'blackfyre'),
                     "type" => "info");
	$options[] = array( "name" => esc_html__("demo install", 'blackfyre'),
                        "desc" => esc_html__("Click to install pre-inserted demo contents. *****Use admin/admin to log in*****", 'blackfyre'),
                        "id" => "demo_install",
                        "std" => "0",
                        "type" => "impbutton");



    return $options;
}
?>