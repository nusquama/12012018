<?php
/*
	Plugin Name: JNews - Speed
	Plugin URI: http://jegtheme.com/
	Description: Compress Javascript, CSS, and HTML. also provide functionality to fix above the fold content warning on google page speed.
	Version: 1.0.1
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/

defined( 'JNEWS_SPEED' ) 		        or define( 'JNEWS_SPEED', 'jnews-speed');
defined( 'JNEWS_SPEED_URL' ) 		    or define( 'JNEWS_SPEED_URL', plugins_url(JNEWS_SPEED));
defined( 'JNEWS_SPEED_FILE' ) 		    or define( 'JNEWS_SPEED_FILE',  __FILE__ );
defined( 'JNEWS_SPEED_DIR' ) 		    or define( 'JNEWS_SPEED_DIR', plugin_dir_path( __FILE__ ) );

require "class.jnews-speed.php";

/**
 * Plugin Activation / Deactivation hook
 */
register_activation_hook( __FILE__, array( JNews_Speed::getInstance(), 'do_clear_cache' ) );
register_deactivation_hook( __FILE__, array( JNews_Speed::getInstance(), 'do_clear_cache' ) );

/**
 * Get jnews option
 *
 * @param $setting
 * @param $default
 * @return mixed
 */
if(!function_exists('jnews_get_option'))
{
    function jnews_get_option($setting, $default = null)
    {
        $options = get_option( 'jnews_option', array() );
        $value = $default;
        if ( isset( $options[ $setting ] ) ) {
            $value = $options[ $setting ];
        }
        return $value;
    }
}

/**
 * Register Customizer Option
 */
add_action( 'jnews_register_customizer_option', 'jnews_speed_customizer_option');

if(!function_exists('jnews_speed_customizer_option'))
{
    function jnews_speed_customizer_option()
    {
        require_once 'class.jnews-speed-option.php';
        JNews_Speed_Option::getInstance();
    }
}

/**
 * Load Text Domain
 */

function jnews_speed_load_textdomain()
{
    load_plugin_textdomain( JNEWS_SPEED, false, basename(__DIR__) . '/languages/' );
}

jnews_speed_load_textdomain();