<?php
/*
	Plugin Name: JNews - Auto Load Next Post
	Plugin URI: http://jegtheme.com/
	Description: Auto load next post when scroll for JNews
	Version: 1.0.3
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/

defined( 'JNEWS_AUTOLOAD_POST' ) 		        or define( 'JNEWS_AUTOLOAD_POST', 'jnews-auto-load-post');
defined( 'JNEWS_AUTOLOAD_POST_URL' ) 		    or define( 'JNEWS_AUTOLOAD_POST_URL', plugins_url(JNEWS_AUTOLOAD_POST));
defined( 'JNEWS_AUTOLOAD_POST_FILE' ) 		    or define( 'JNEWS_AUTOLOAD_POST_FILE',  __FILE__ );
defined( 'JNEWS_AUTOLOAD_POST_DIR' ) 		    or define( 'JNEWS_AUTOLOAD_POST_DIR', plugin_dir_path( __FILE__ ) );

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
 * Load script for JNews Autoload
 */
add_action('wp_enqueue_scripts', 'jnews_auto_load_assets');

if( !function_exists('jnews_auto_load_assets') )
{
    function jnews_auto_load_assets()
    {
        if(!is_customize_preview())
        {
            wp_enqueue_script('jnews-autoload', JNEWS_AUTOLOAD_POST_URL . '/assets/js/jquery.autoload.js', array('jquery'), null, true);
        }
    }
}

/**
 * Single post load class
 */
add_filter( 'jnews_post_wrap_class' , 'jnews_autoload_post_wrap_class');

if(!function_exists('jnews_autoload_post_wrap_class'))
{
    function jnews_autoload_post_wrap_class($class)
    {
        $class .= ' post-autoload ';
        return $class;
    }
}

/**
 * Single post autoload attribute
 */
add_filter('jnews_post_wrap_attribute', 'jnews_autoload_post_wrap_attribute', null, 2);

if(!function_exists('jnews_autoload_post_wrap_attribute'))
{
    function jnews_autoload_post_wrap_attribute($attribute, $post_id)
    {
        $attribute .= " data-url=\"" . get_permalink($post_id) . "\" data-title=\"" . esc_attr(get_the_title($post_id)) . "\" data-id=\"" . esc_attr(get_the_ID()) . "\" ";

        $prev_post = get_previous_post();

        if(!empty($prev_post)) {
            $attribute .= " data-prev=\"" . esc_url(get_permalink($prev_post->ID)) . "\" ";
        }

        return $attribute;
    }
}

/**
 * Single post prev next
 */
add_filter('jnews_single_show_prev_next_post', 'jnews_autoload_single_show_prev_next_post');

if(!function_exists('jnews_autoload_single_show_prev_next_post'))
{
    function jnews_autoload_single_show_prev_next_post()
    {
        return false;
    }
}

/**
 * Single popup post
 */
add_filter('jnews_single_show_popup_post', 'jnews_autoload_single_show_popup_post');

if(!function_exists('jnews_autoload_single_show_popup_post'))
{
    function jnews_autoload_single_show_popup_post()
    {
        return false;
    }
}

/**
 * Add Rewrite Endpoint
 */
add_action( 'init', 'jnews_load_next_post_rewrite_endpoint');

if(!function_exists('jnews_load_next_post_rewrite_endpoint'))
{
    function jnews_load_next_post_rewrite_endpoint()
    {
        add_rewrite_endpoint('autoload', EP_PERMALINK);
    }
}

/**
 * Activation hook
 */
if(!function_exists('jnews_autoload_activation_hook'))
{
    register_activation_hook( __FILE__, 'jnews_autoload_activation_hook' );

    function jnews_autoload_activation_hook()
    {
        jnews_load_next_post_rewrite_endpoint();

        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }
}

/**
 * Template Redirect
 */
add_action('template_redirect', 'jnews_auto_load_next_post_template_redirect');

if(!function_exists('jnews_auto_load_next_post_template_redirect'))
{
    function jnews_auto_load_next_post_template_redirect()
    {
        global $wp_query;

        if ( ! isset($wp_query->query_vars['autoload']) || ! is_singular()) {
            return;
        }

        require 'autoload-template.php';
        exit;
    }
}

/**
 * Register customizer option
 */
add_action( 'jnews_register_customizer_option', 'jnews_autoload_customizer_option');

if(!function_exists('jnews_autoload_customizer_option'))
{
    function jnews_autoload_customizer_option()
    {
        require_once 'class.jnews-auto-load-post-option.php';
        JNews_Auto_Load_Post_Option::getInstance();
    }
}

add_filter( 'jnews_single_post_template', 'jnews_auto_load_single_post_template' );

if(!function_exists('jnews_auto_load_single_post_template'))
{
    function jnews_auto_load_single_post_template()
    {
        return jnews_get_option('autoload_blog_template', '1');
    }
}

add_filter( 'jnews_single_post_layout', 'jnews_auto_load_single_post_layout' );

if(!function_exists('jnews_auto_load_single_post_layout'))
{
    function jnews_auto_load_single_post_layout()
    {
        if(wp_is_mobile()) {
            return 'no-sidebar';
        } else {
            return jnews_get_option('autoload_blog_layout', 'right-sidebar');
        }

    }
}

add_filter( 'jnews_single_post_sidebar', 'jnews_auto_load_single_post_sidebar' );

if(!function_exists('jnews_auto_load_single_post_sidebar'))
{
    function jnews_auto_load_single_post_sidebar()
    {
        return jnews_get_option('autoload_sidebar', 'default-sidebar');
    }
}

/**
 * JNews Single Post
 */
add_action('jnews_single_post_after_content', 'jnews_auto_load_single_post_after_content', 45);

if(!function_exists('jnews_auto_load_single_post_after_content'))
{
    function jnews_auto_load_single_post_after_content()
    {
        $post_attr = jnews_autoload_post_wrap_attribute('', get_the_ID());
        echo "<div class='jnews-autoload-splitter' {$post_attr}></div>";
    }
}

/**
 * JNews Remove Comment
 */
add_filter('jnews_single_show_comment', 'jnews_auto_load_remove_comment');

function jnews_auto_load_remove_comment()
{
    if(jnews_get_option('autoload_disable_comment', 'hide') === 'hide')
    {
        return false;
    }

    return true;
}


/**
 * Load Text Domain
 */

function jnews_auto_load_post_textdomain()
{
    load_plugin_textdomain( JNEWS_AUTOLOAD_POST, false, basename(__DIR__) . '/languages/' );
}

jnews_auto_load_post_textdomain();