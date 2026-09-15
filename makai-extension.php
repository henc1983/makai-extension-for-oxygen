<?php

/**
 * Plugin Name: Makai's Extensions for Oxygen
 * Plugin URI: https://makaihenrik.hu/
 * Description: Wordpress extensions, custom elements and settings for Oxygen 6
 * Author: Makai Henrik
 * Author URI: https://makaihenrik.hu/
 * License: GPLv2
 * Text Domain: makai
 * Domain Path: /languages/
 * Version: 1.0.0
 */


// define main namespace
namespace MakaiExtensions;


// Exit if try to access directly
defined('ABSPATH') or die('Hey! Are You human?!');



// Constants
define( 'MEX_VERSION' , '1.0.0' );
define( 'MEX_PLUGIN_DIR' , untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'MEX_PLUGIN_URI' , untrailingslashit( plugin_dir_url( __FILE__ ) ) );



// Including files
require_once MEX_PLUGIN_DIR . '/inc/init.php';
require_once MEX_PLUGIN_DIR . '/inc/functions.php';
require_once MEX_PLUGIN_DIR . '/inc/requests.php';
require_once MEX_PLUGIN_DIR . '/inc/snippets.php';
require_once MEX_PLUGIN_DIR . '/inc/enqueue.php';
require_once MEX_PLUGIN_DIR . '/inc/ajax_handlers.php';
require_once MEX_PLUGIN_DIR . '/inc/elements_register.php';
require_once MEX_PLUGIN_DIR . '/inc/pre_get_posts.php';


if( is_admin() ) {
    require_once MEX_PLUGIN_DIR . '/inc/update.php';
}