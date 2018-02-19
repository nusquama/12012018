<?php
/*
	Plugin Name: JNews - Push Notification
	Plugin URI: http://jegtheme.com/
	Description: Desktop push notification plugin for JNews Themes
	Version: 1.0.0
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/

defined( 'JNEWS_PUSH_NOTIFICATION' )          or define( 'JNEWS_PUSH_NOTIFICATION', 'jnews-push-notification');
defined( 'JNEWS_PUSH_NOTIFICATION_VERSION' )  or define( 'JNEWS_PUSH_NOTIFICATION_VERSION', '1.0.0' );
defined( 'JNEWS_PUSH_NOTIFICATION_URL' )      or define( 'JNEWS_PUSH_NOTIFICATION_URL', plugins_url('jnews-push-notification') );
defined( 'JNEWS_PUSH_NOTIFICATION_FILE' )     or define( 'JNEWS_PUSH_NOTIFICATION_FILE',  __FILE__ );
defined( 'JNEWS_PUSH_NOTIFICATION_DIR' )      or define( 'JNEWS_PUSH_NOTIFICATION_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Get JNews option
 *
 * @param array $setting
 * @param mixed $default
 * 
 * @return mixed
 * 
 */
if ( !function_exists( 'jnews_get_option' ) )
{
    function jnews_get_option( $setting, $default = null )
    {
        $options = get_option( 'jnews_option', array() );
        $value = $default;

        if ( isset( $options[ $setting ] ) ) 
        {
            $value = $options[ $setting ];
        }
        return $value;
    }
}

/**
 * Register Push Notification Widget
 */
add_action( 'widgets_init', 'register_push_notification_widget' );

if ( !function_exists('register_push_notification_widget') )
{
    function register_push_notification_widget()
    {
        if ( ! defined( 'JNEWS_THEME_URL' ) ) return;

        require_once 'class.jnews-push-notification-widget.php';
        register_widget("JNews_Push_Notification_Widget");
    }
}

/**
 * Register Push Notification Option
 */
add_action( 'jnews_register_customizer_option', 'jnews_push_notification_customizer_option');

if ( !function_exists('jnews_push_notification_customizer_option') )
{
    function jnews_push_notification_customizer_option()
    {
        require_once 'class.jnews-push-notification-option.php';
        JNews_Push_Notification_Option::getInstance();
    }
}

/**
 * Register Push Notification Class
 */
add_action( 'after_setup_theme', 'jnews_push_notification' );

if ( !function_exists( 'jnews_push_notification' ) )
{
    function jnews_push_notification()
    {
        require_once 'class.jnews-push-notification.php';
        JNews_Push_Notification::getInstance();
    }
}

/**
 * Register Push Notification Shortcode
 */
add_action( 'after_setup_theme', 'jnews_push_notification_shortcode' );

if ( !function_exists( 'jnews_push_notification_shortcode' ) )
{
    function jnews_push_notification_shortcode()
    {
       if ( ! class_exists('WPBakeryVisualComposerAbstract') ) return;

        require_once 'class.jnews-push-notification-shortcode.php';
        JNews_Push_Notification_Shortcode::getInstance();
    }
}

/**
 * Print Translation
 */
if ( !function_exists('jnews_print_translation') )
{
    function jnews_print_translation( $string, $domain, $name )
    {
        do_action( 'jnews_print_translation', $string, $domain, $name );
    }
}

if ( !function_exists('jnews_print_main_translation') )
{
    add_action( 'jnews_print_translation', 'jnews_print_main_translation', 10, 2 );

    function jnews_print_main_translation( $string, $domain )
    {
        call_user_func_array( 'esc_html_e', array( $string, $domain ) );
    }
}

/**
 * Return Translation
 */
if ( !function_exists('jnews_return_translation') )
{
    function jnews_return_translation( $string, $domain, $name, $escape = true )
    {
        return apply_filters( 'jnews_return_translation', $string, $domain, $name, $escape );
    }
}

if ( !function_exists('jnews_return_main_translation') )
{
    add_filter( 'jnews_return_translation', 'jnews_return_main_translation', 10, 4 );

    function jnews_return_main_translation( $string, $domain, $name, $escape = true )
    {
        if ( $escape )
        {
            return call_user_func_array( 'esc_html__', array( $string, $domain ) );
        } else {
            return call_user_func_array( '__', array( $string, $domain ) );
        }

    }
}

/**
 * Load Text Domain
 */
function jnews_push_notification_load_textdomain()
{
    load_plugin_textdomain( JNEWS_PUSH_NOTIFICATION, false, basename(__DIR__) . '/languages/' );
}

jnews_push_notification_load_textdomain();