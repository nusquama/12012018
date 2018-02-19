<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

include JNEWS_SPEED_DIR . '/include/minify/css.php';
include JNEWS_SPEED_DIR . '/include/minify/js.php';

class JNews_Speed
{
    /**
     * @var JNews_View_Counter
     */
    private static $instance;

    /**
     * Save css handle to move it to footer
     * @var array
     */
    private $css_handle = array();

    /**
     * @var bool
     */
    public $debug = false;

    /**
     * @return JNews_View_Counter
     */
    public static function getInstance()
    {
        if (null === static::$instance)
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        add_action('init', array($this,'speed_hook'));
        add_action( 'customize_save_after', array( $this, 'do_clear_cache' ) );
    }

    public function speed_hook()
    {
        if($this->is_frontend())
        {
            if($this->check_login())
            {
                if( jnews_get_option('bottom_script', 'enable') === 'enable' )
                {
                    $this->move_script_bottom();
                }

                if( jnews_get_option('concat_script', 'enable') === 'enable' )
                {
                    $this->concat_minify_script();
                }

                if( jnews_get_option('above_the_fold_script', 'enable') === 'enable' )
                {
                    $this->above_the_fold();
                }

                if( jnews_get_option('minify_html', 'enable') === 'enable' )
                {
                    $this->minify_html();
                }
            }
        } else
            {
            $this->clear_cache_button();
        }
    }

    public function check_login()
    {
        if(is_user_logged_in())
        {
            return jnews_get_option('enable_logged_user', 'disable') === 'enable';
        } else {
            return true;
        }
    }

    public function is_frontend()
    {
        if(!is_admin() && !$this->is_login_page() && !is_customize_preview())
        {
            return true;
        }
        return false;
    }

    public function is_login_page()
    {
        return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
    }

    /**
     * move script bottom
     */
    public function move_script_bottom()
    {
        if ( jnews_get_option('above_jquery', false) ) 
        {
            add_action('wp_head', array( $this, 'register_jquery' ));
        }

        add_action( 'wp_enqueue_scripts', array( $this, 'move_js_to_bottom' ) );
        add_action( 'wp_print_styles', array( $this, 'move_css_to_bottom' ) );
        add_action( 'get_footer', array($this, 'print_footer_css') );
    }

    public function register_jquery()
    {
        // need to register jquery on top of page
        if( wp_script_is( 'jquery', 'registered' ) ) {
            wp_print_scripts( 'jquery' );
        }
    }

    /**
     * move js to bottom
     */
    public function move_js_to_bottom()
    {
        remove_action('wp_head', 'wp_print_scripts');
        remove_action('wp_head', 'wp_print_head_scripts', 9);
        remove_action('wp_head', 'wp_enqueue_scripts', 1);
    }

    /**
     * move css to bottom
     */
    public function move_css_to_bottom()
    {
        global $wp_styles ;
        foreach( $wp_styles->queue as $handle ) {
            $this->css_handle[] = $handle;
            wp_dequeue_style($handle);
        }
    }

    /**
     * print footer css
     */
    public function print_footer_css()
    {
        foreach($this->css_handle as $handle) {
            wp_enqueue_style($handle);
        }
    }

    /**
     * Clear Cache
     */
    public function clear_cache_button()
    {
        add_filter( 'plugin_action_links_' . plugin_basename( JNEWS_SPEED_FILE ), array( $this, 'plugin_action_link_cache_bump' ) );

        // Maybe purge minit cache
        add_action( 'admin_init', array( $this, 'cache_bump' ) );
    }

    public function plugin_action_link_cache_bump($links)
    {
        $links[] = sprintf(
            '<a href="%s">%s</a>',
            wp_nonce_url( add_query_arg( 'jnews_purge_cache', true ), 'jnews_purge_cache' ),
            __( 'Purge cache', 'jnews-speed' )
        );

        return $links;
    }

    public function cache_bump()
    {
        if ( ! isset( $_GET['jnews_purge_cache'] ) || ! check_admin_referer( 'jnews_purge_cache' ) ) {
            return;
        }

        $this->do_clear_cache();

        add_action( 'admin_notices', array( $this, 'cache_bump_notice' ) );
    }

    public function cache_bump_notice()
    {
        printf(
            '<div class="updated"><p>%s</p></div>',
            __( 'Success: JNews asset cache purged.', 'jnews-speed' )
        );
    }

    public function do_clear_cache()
    {
        // Use this as a global cache version number
        update_option( 'minit_cache_ver', time() );

        $wp_upload_dir = wp_upload_dir();
        $files = glob( $wp_upload_dir['basedir'] . '/minit/*', GLOB_NOSORT );

        if ( $files ) {
            foreach ( $files as $file ) {
                unlink( $file );
            }
        }
    }

    public function concat_minify_script()
    {
        include JNEWS_SPEED_DIR . '/include/minit/minit-assets.php';
        include JNEWS_SPEED_DIR . '/include/minit/minit-js.php';
        include JNEWS_SPEED_DIR . '/include/minit/minit-css.php';
        include JNEWS_SPEED_DIR . '/include/minit/helpers.php';

        $js = new Minit_Js( $this );
        $css = new Minit_Css( $this );

        $js->init();
        $css->init();
    }

    /**
     * above the fold
     */
    public function above_the_fold()
    {
        add_action('wp_head', array($this, 'above_the_fold_generator'));
    }

    public function above_the_fold_generator()
    {
        $desktop_css = file_get_contents( JNEWS_SPEED_DIR .'/abovethefold.css' );

        ob_start();
        include "dynamic-style.php";
        $dynamic_css = ob_get_clean();

        echo "<style>" . $desktop_css . $dynamic_css . "</style>";
    }

    /**
     * minify html
     */
    public function minify_html()
    {
        include JNEWS_SPEED_DIR . '/include/minify/html.php';

        add_action('get_header', array($this, 'html_compress_start'));
    }

    public function html_compress_start()
    {
        ob_start(array($this, 'html_compression_finish'));
    }

    public function html_compression_finish($html)
    {
        return jnews_minify_html_output($html);
    }
}
