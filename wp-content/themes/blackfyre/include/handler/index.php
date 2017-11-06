<?php
//the php handler for the social auth stuff
require_once('../../../../../wp-load.php');

if (!isset ($_GET['action']) OR !($_GET['action'] == "logout")) {
	if (isset($_GET['returnto'])) { //save return to for later
		if (isset($_GET['proceed'])) {
			$_SESSION['returnto'] = $_GET['returnto']."?proceed=".$_GET['initiatelogin'];
		} else {

			$_SESSION['returnto'] = $_GET['returnto'];
		}
		$fulluri = 'http://' . $_SERVER['SERVER_NAME']. str_replace("&returnto=".encodeURIComponent($_GET['returnto']), "", $_SERVER['REQUEST_URI']) ;
		header("Location: ".$fulluri);
		die();
	}
}


//determine further course of action
if (isset($_GET['initiatelogin'])) {

	$wordpress_user = wp_get_current_user();

	if ($wordpress_user->ID != 0) {

		wp_logout();
	}

	$config = blackfyre_social_createoptions(); //get session config for the auth we got from wordpress
	//print_r ($config);die();
	require_once( "../Hybrid/Auth.php" ); //include the auth libraries
	//initiatelogin is set, proceed to find out which one
	try {
		if ($_GET['initiatelogin'] == "facebook") {
			//time to do facebook login
			$hybridauth = new Hybrid_Auth( $config );
			$adapter = $hybridauth->authenticate( "facebook" );
			$user_profile = $adapter->getUserProfile();
			$provider = "facebook";
		} elseif ($_GET['initiatelogin'] == "twitter") {
			//time to do twitter login
			$hybridauth = new Hybrid_Auth( $config );
			$adapter = $hybridauth->authenticate( "twitter" );
			$user_profile = $adapter->getUserProfile();
			$provider = "twitter";
		} elseif ($_GET['initiatelogin'] == "google") {
			//time to do tumblr login
			$hybridauth = new Hybrid_Auth( $config );
			$adapter = $hybridauth->authenticate( "Google" );
			$user_profile = $adapter->getUserProfile();
			$provider = "google";

		} elseif ($_GET['initiatelogin'] == "twitchtv") {
			//time to do linkedin login
			$hybridauth = new Hybrid_Auth( $config );
			$adapter = $hybridauth->authenticate( "TwitchTV" );

			$user_profile = $adapter->getUserProfile();

			$provider = "twitchtv";
		}elseif ($_GET['initiatelogin'] == "steam") {
			//time to do linkedin login
			$hybridauth = new Hybrid_Auth( $config );
			$adapter = $hybridauth->authenticate( "Steam" );

			$user_profile = $adapter->getUserProfile();
			$provider = "steam";
		}else {
			//nothing valid set
			die("Error, action not correctly set");
		}

		if (isset($user_profile)) {

			//print_r ($user_profile);
			//die();





			//get correct tokens

			$usertoken['token'] = $adapter->getAccessToken();

			$provider = $_GET['initiatelogin'];
			$identifier = $user_profile->identifier;
			$args = array(
				'meta_key'     => $provider."_id",
				'meta_value'   => $identifier
			 );

			$email = $user_profile->email;
			$identity = wp_hash( $user_profile->identifier."_".$provider);
			if (strlen($email) < 2) {
				$email = $identity."@blackfyrenotsetemail.com";
				$error_flag = true;
			}

			if (strlen($user_profile->lastName) < 1) {
			   $thename = $user_profile->firstName;
			} else {
				$thename = $user_profile->firstName." ".$user_profile->lastName;
			}

            //search by identifier



			$target_user = get_user_by('login', $identity);
			//probably new user BUT check for mail match
			//if ($target_user == false) {
			//	$target_user = get_user_by('email', $email);
			//}

			if ($target_user == false) {
				//new user
				$newuserdata = array( 'user_email' => $email,
	                'user_login' => $identity,
	                'nickname' => $user_profile->displayName,
	                'first_name' => $user_profile->firstName,
	                'last_name' => $user_profile->lastName,
	                'user_pass ' =>wp_hash_password($user_profile->identifier),
	                'display_name' => $user_profile->displayName,
	                'rich_editing' => true,
	                'role' => 'gamer'
	            );
				$new_user_id = wp_insert_user( $newuserdata ); //added user data
				$user = new WP_User ($new_user_id); //load user
				//now save all the provider data to user
				add_user_meta($user->ID, $provider."_id", $user_profile->identifier);
				add_user_meta($user->ID, "profile_photo", $user_profile->photoURL);
				add_user_meta($user->ID, $provider."_name", $thename);
				add_user_meta($user->ID, $provider."_displayname", $user_profile->displayName);
				wp_set_current_user( $user->ID, $user->data->user_login );
				wp_set_auth_cookie( $user->ID , true);
				wp_new_user_notification($user->ID);
			} else {
				$user = $target_user; //since there's only one we might as well do this
	        	$userdata['ID'] = $user->ID;
	        	//$new_user_id = wp_update_user($userdata); DO NOT UPDATE USER, MBY THEY EDITED PROFILE
				update_user_meta($user->ID, $provider."_id", $user_profile->identifier);
				update_user_meta($user->ID, "profile_photo", $user_profile->photoURL);
				update_user_meta($user->ID, $provider."_name", $thename);
				update_user_meta($user->ID, $provider."_displayname", $user_profile->displayName);
				wp_set_current_user( $user->ID, $user->data->user_login );
				wp_set_auth_cookie( $user->ID, true );
			}

			sleep(1);
			if (!isset($_SESSION['returnto'])) {
				header("Location: ".get_site_url());
			} else {
				header("Location: ".$_SESSION['returnto']);
			}

			die();

		}
	} catch (Exception $e) {
		if (isset($_SESSION['returnto'])) {
			$_SESSION['social_success'] = 0;
			$_SESSION['social_error'] = $e->getMessage();
			header("Location: ".$_SESSION['returnto']);

		}
		die($e->getMessage() );
	}

} else if (isset($_GET['action'])) {
	if ($_GET['action'] == "logout") {
		//we do the logout here
		unset($_SESSION['social_login_new']); //just in case unset it
		unset($_SESSION['social_user']); //unset the user data
		$return = $_SESSION['returnto'];
		session_destroy();
		session_start();
		$_SESSION['loggedout'] = true;
		if (!isset ($return)) {
			$return = $_GET['returnto'];
		}
		wp_logout();

        header("Location: ".$return);
		die();
	} else {
		die();
	}

}



function encodeURIComponent($str) {
    $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    return strtr(rawurlencode($str), $revert);
}
?>
