<?php
/*
	Plugin Name: JNews - Social Login
	Plugin URI: http://jegtheme.com/
	Description: Social Login & Registration Plugin for JNews Themes
	Version: 1.0.1
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/

defined( 'JNEWS_SOCIAL_LOGIN' )          or define( 'JNEWS_SOCIAL_LOGIN', 'jnews-social-login');
defined( 'JNEWS_SOCIAL_LOGIN_VERSION' )  or define( 'JNEWS_SOCIAL_LOGIN_VERSION', '1.0.1' );
defined( 'JNEWS_SOCIAL_LOGIN_URL' )      or define( 'JNEWS_SOCIAL_LOGIN_URL', plugins_url('jnews-social-login') );
defined( 'JNEWS_SOCIAL_LOGIN_FILE' )     or define( 'JNEWS_SOCIAL_LOGIN_FILE',  __FILE__ );
defined( 'JNEWS_SOCIAL_LOGIN_DIR' )      or define( 'JNEWS_SOCIAL_LOGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once 'class.jnews-social-login.php';

/**
 * Get JNews option
 *
 * @param array $setting
 * @param mixed $default
 * 
 * @return mixed
 * 
 */
if ( !function_exists('jnews_get_option') )
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
 * Load Plugin Option
 */
add_action( 'jnews_register_customizer_option', 'jnews_social_login_customizer_option' );

if ( !function_exists('jnews_social_login_customizer_option') )
{
    function jnews_social_login_customizer_option()
    {
        require_once 'include/class.jnews-social-login-option.php';
        JNews_Social_Login_Option::getInstance();
    }
}

/**
 * Activation hook
 */
register_activation_hook( __FILE__, array( JNews_Social_Login::getInstance(), 'flush_rewrite_rules' ) );

/**
 * Load Social Login Class
 */
add_action( 'plugins_loaded', 'jnews_social_login' );

if ( !function_exists('jnews_social_login') )
{
    function jnews_social_login()
    {
        JNews_Social_Login::getInstance();
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
function jnews_social_login_load_textdomain()
{
    load_plugin_textdomain( JNEWS_SOCIAL_LOGIN, false, basename(__DIR__) . '/languages/' );
}

jnews_social_login_load_textdomain();