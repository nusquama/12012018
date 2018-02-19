<?php
/*
	Plugin Name: JNews - Instagram Feed
	Plugin URI: http://jegtheme.com/
	Description: Put your instagram feed on the header and footer of your website
	Version: 1.0.0
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/


defined( 'JNEWS_INSTAGRAM' ) 		        or define( 'JNEWS_INSTAGRAM', 'jnews-instagram');
defined( 'JNEWS_INSTAGRAM_URL' ) 		    or define( 'JNEWS_INSTAGRAM_URL', plugins_url(JNEWS_INSTAGRAM));
defined( 'JNEWS_INSTAGRAM_FILE' ) 		    or define( 'JNEWS_INSTAGRAM_FILE',  __FILE__ );
defined( 'JNEWS_INSTAGRAM_DIR' ) 		    or define( 'JNEWS_INSTAGRAM_DIR', plugin_dir_path( __FILE__ ) );

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
 * Instagram Feed Option
 */
add_action( 'jnews_register_customizer_option', 'jnews_instagram_customizer_option');

if(!function_exists('jnews_instagram_customizer_option'))
{
    function jnews_instagram_customizer_option()
    {
        require_once 'class.jnews-instagram-option.php';
        JNews_Instagram_Option::getInstance();
    }
}

/**
 * Render Instagram Feed - Header
 */
add_action( 'jnews_render_instagram_feed_header', 'jnews_instagram_feed_header' );

if ( ! function_exists('jnews_instagram_feed_header') ) 
{
    function jnews_instagram_feed_header()
    {
        require_once 'class.jnews-instagram.php';

        $option = jnews_get_option('instagram_feed_enable', 'hide');

        if ( $option === 'only_header' || $option === 'both' ) 
        {
            $instagram = new JNews_Instagram();
            $instagram->generate_element();
        }
    }
}

/**
 * Render Instagram Feed - Footer
 */
add_action( 'jnews_render_instagram_feed_footer', 'jnews_instagram_feed_footer' );

if ( ! function_exists('jnews_instagram_feed_footer') ) 
{
    function jnews_instagram_feed_footer()
    {
        require_once 'class.jnews-instagram.php';

        $option = jnews_get_option('instagram_feed_enable', 'hide');

        if ( $option === 'only_footer' || $option === 'both' ) 
        {
            $row = jnews_get_option('footer_instagram_row', 1);

            $instagram = new JNews_Instagram( $row );
            $instagram->generate_element();
        }
    }
}

/**
 * Load Text Domain
 */
function jnews_instagram_load_textdomain()
{
    load_plugin_textdomain( JNEWS_INSTAGRAM, false, basename(__DIR__) . '/languages/' );
}

jnews_instagram_load_textdomain();