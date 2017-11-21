<?php
/**
 * Plugin Name: Anvil File Share
 * Plugin URI: http://anvilstation.com
 * Description: A plugin for sharing images, videos, and other files
 * Version: 1.0.0
 * Author: Austin Verburg
 * Author URI: http://austinverburg.com
 * License: GPL2
 */

function add_pepekura_files($addPep){
    $addPep['pdo'] = 'pepekura/pdo'; //Adding svg extension
    return $addPep;
}
add_filter('upload_mimes', 'add_pepekura_files', 1, 1);


?>