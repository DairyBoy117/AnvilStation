<?php
global $wpdb;

function rcopy($src, $dst)
{
	
	if (is_dir($src))
	{
		mkdir($dst);
		$files = scandir($src);
		foreach ($files as $file)
		if ($file != "." && $file != "..") rcopy("$src/$file", "$dst/$file");
	}
	else if (file_exists($src)) copy($src, $dst);
}

$base = dirname(__FILE__);

if (@file_exists(dirname(dirname(dirname(dirname($base))))."/wp-load.php"))
{
	$wpblogheader = (dirname(dirname(dirname(dirname($base)))))."/wp-load.php";
}
else if (@file_exists(dirname(dirname($base))."/wp-load.php"))
{
	$wpblogheader = dirname(dirname($base))."/wp-load.php";
}
else if ($wpblogheader != false)
{
	$wpblogheader = str_replace("\\", "/", $path);
}

//error handling
if ( ! file_exists( $wpblogheader ) ) {
die ( "error" );
} elseif (file_exists($wpblogheader)) {
	require ($wpblogheader);
}


$table_prefix = $wpdb->prefix;
//drop, create and insert data for commentmeta

$siteurl = home_url();
$upload_dir = wp_upload_dir();
$uploaddir = $upload_dir['baseurl'];

include_once('import_bp_friends.php');
include_once('import_cw_games.php');
include_once('import_cw_maps.php');
include_once('import_cw_matches.php');
include_once('import_cw_rounds.php');
include_once('import_cw_teams.php');
include_once('import_options.php');
include_once('import_postmeta.php');
include_once('import_posts.php');
include_once('import_terms.php');
include_once('import_term_relationships.php');
include_once('import_term_taxonomy.php');
include_once('import_user_countries.php');
include_once('import_usermeta.php');
include_once('import_users.php');



rcopy("uploads/", "../../../uploads/");
echo "success";

?>