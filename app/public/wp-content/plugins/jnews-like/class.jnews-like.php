<?php
/**
 * @author Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class JNews Like Count
 */
Class JNews_Like
{
    /**
     * @var JNews_Like
     */
    private static $instance;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $table_name = "jnews_post_like";
    private $meta_name  = "jnews_like_counter";

    /**
     * @return JNews_Like
     */
    public static function getInstance()
    {
        if (null === static::$instance)
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * JNews_Like constructor.
     */
    private function __construct()
    {
        $this->setup_hook();
    }

    /**
     * Create table for post like count
     */
    public function check_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_name;

        if ( $wpdb->get_var("show tables like '$table_name'") != $table_name )
        {
            $sql = "CREATE TABLE " . $table_name . " (
                    `id` bigint(11) NOT NULL AUTO_INCREMENT,
                    `post_id` int(11) NOT NULL,
                    `date_time` datetime NOT NULL,
                    `value` int(2) NOT NULL,
                    `user_id` int(11) NOT NULL DEFAULT '0',
                    PRIMARY KEY (`id`), INDEX (`post_id`)
                )";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    /**
     * Activation hook plugin
     */
    public function activation_hook()
    {
        $this->check_table();
        $this->flush_rewrite_rules();
    }

    /**
     * Setup hook function
     */
    public function setup_hook()
    {
        add_action( 'init',                      array( $this, 'add_rewrite_rule' ) );
        add_action( 'template_include',          array( $this, 'add_page_template' ) );
        add_action( 'wp_print_styles',           array( $this, 'load_assets' ) );
        
        add_action( 'jnews_ajax_like_handler',   array( $this, 'ajax_do_action_type' ) );

        add_filter( 'jnews_dropdown_link',       array( $this, 'dropdown_link' ) );
    }

    /**
     * Load plugin assest
     */
    public function load_assets()
    {
        wp_enqueue_script( 'jnews-like',    JNEWS_LIKE_URL . '/assets/js/plugin.js', null, JNEWS_LIKE_VERSION, true );
    }

    /**
     * Get total like and dislike
     * 
     * @param  integer $post_id
     * @param  string  $type
     * 
     * @return string  $result
     * 
     */
    public function get_count( $post_id, $type = null )
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_name;

        if ( $type === "like" )
        {
            $result = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(id) FROM $table_name WHERE post_id = %d AND value > 0",
                    $post_id
                )
            );

            return $result;
        }

        if ( $type === "dislike" )
        {
            $result = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(id) FROM $table_name WHERE post_id = %d AND value < 0",
                    $post_id
                )
            );

            return $result;
        }

        return false;
    }

    /**
     * Get status if have liked or disliked
     * 
     * @param  integer $post_id
     * 
     * @return int  $status
     * 
     */
    public function get_status( $post_id )
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_name;

        $status = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT value FROM $table_name WHERE post_id = %d AND user_id = %d",
                $post_id, get_current_user_id()
            )
        );

        return $status;
    }

    /**
     * Get liked / disliked posts
     * 
     * @return array
     * 
     */
    public function get_posts()
    {
        $value = 0;

        if ( $this->type === 'liked' ) 
        {
            $value = 1;
        }

        if ( $this->type === 'disliked' ) 
        {
            $value = -1;
        }

        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_name;

        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT post_id FROM $table_name WHERE user_id = %d AND value = %d",
                $this->user_id, $value
            ),
            ARRAY_N
        );

        if ( !empty( $result ) ) 
        {
            $result = call_user_func_array( 'array_merge', $result );
        }

        return $result;
    }

    /**
     * Main function
     * 
     * @param  integer $post_id
     * @param  string  $type
     * 
     * @return json
     * 
     */
    public function do_action_type( $post_id, $type )
    {
        $status = $this->get_status( $post_id );
        $value  = $this->get_value( $status, $type );

        if ( $status == null )
        {
            $result = $this->insert_value( $post_id, $value );

            if ( $result )
            {
                update_post_meta( $post_id, $this->meta_name, $this->get_count( $post_id, 'like' ) );

                wp_send_json(
                    array(
                        'response' => 1,
                        'message'  => jnews_return_translation( 'Thanks for your vote!', 'jnews-like', 'thanks_for_your_vote' ),
                        'like'     => $this->get_total_like( $post_id ),
                        'dislike'  => $this->get_total_dislike( $post_id ),
                        'value'    => $value
                    )
                );
            } else {
                wp_send_json(
                    array(
                        'response' => 0,
                        'message'  => jnews_return_translation( 'Internal DB Error!', 'jnews-like', 'internal_db_error' ),
                    )
                );
            }
        } else {
            $result = $this->update_value( $post_id, $value );

            if ( $result )
            {
                update_post_meta( $post_id, $this->meta_name, $this->get_count( $post_id, 'like' ) );

                wp_send_json(
                    array(
                        'response' => 1,
                        'message'  => jnews_return_translation( 'Thanks for your vote!', 'jnews-like', 'thanks_for_your_vote' ),
                        'like'     => $this->get_total_like( $post_id ),
                        'dislike'  => $this->get_total_dislike( $post_id ),
                        'value'    => $value
                    )
                );
            } else {
                wp_send_json(
                    array(
                        'response' => 0,
                        'message'  => jnews_return_translation( 'Internal DB Error!', 'jnews-like', 'internal_db_error' ),
                    )
                );
            }
        }
    }

    /**
     * Main function for ajax
     */
    public function ajax_do_action_type()
    {
        if ( is_user_logged_in() ) 
        {
           $this->do_action_type( $_POST['post_id'], $_POST['type'] );
        } else {
            wp_send_json(
                array(
                    'response' => -1,
                    'message'  => jnews_return_translation( 'You must login to vote!', 'jnews-like', 'must_login' ),
                )
            );
        }

        die();
    }

    /**
     * Get value of action
     * 
     * @param  string $status
     * @param  string $action
     * 
     * @return int
     *         
     */
    public function get_value( $status, $action )
    {
        $value  = 0;

        if ( $status === '1' ) 
        {
            $status = 'like';
        } else if ( $status === '-1' ) {
            $status = 'dislike';
        }

        if ( $action === 'like' ) 
        {
            $value = 1;
        }

        if ( $action === 'dislike' ) 
        {
            $value = -1;
        }

        if ( $status === $action ) 
        {
            $value = 0;
        }

        return $value;
    }

    /**
     * Insert data into database
     * 
     * @param  integer $post_id
     * @param  string  $value
     * 
     * @return bool
     * 
     */
    public function insert_value( $post_id, $value )
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_name;

        $query = $wpdb->prepare(
            "INSERT INTO $table_name SET 
                    post_id = %d, 
                    date_time = '" . date( 'Y-m-d H:i:s' ) . "',
                    user_id = %d, 
                    value = %d",
            $post_id, get_current_user_id(), $value
        );

        $resutl = $wpdb->query( $query );

        return $resutl;
    }

    /**
     * Update data value into database
     * 
     * @param  integer $post_id
     * @param  string  $value
     * 
     * @return bool
     * 
     */
    public function update_value( $post_id, $value )
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $this->table_name;

        $query = $wpdb->prepare(
            "UPDATE $table_name SET 
                    value = %d, 
                    date_time = '" . date( 'Y-m-d H:i:s' ) . "'
                    WHERE post_id = %d AND user_id = %d",
            $value, $post_id, get_current_user_id()
        );

        $resutl = $wpdb->query( $query );

        return $resutl;
    }

    /**
     * Get total like of post
     * 
     * @param  int $post_id
     * 
     * @return string
     *          
     */
    public function get_total_like( $post_id )
    {
        $like = apply_filters( 'jnews_total_like', $this->get_count( $post_id, 'like' ), $post_id );

        return jnews_number_format( $like );
    }

    /**
     * Get total dislike of post
     * 
     * @param  int $post_id
     * 
     * @return string
     *          
     */
    public function get_total_dislike( $post_id )
    {
        $dislike = apply_filters( 'jnews_total_dislike', $this->get_count( $post_id, 'dislike' ), $post_id );

        return jnews_number_format( $dislike );
    }

    /**
     * Generate dislike element
     * 
     * @param  int $post_id
     * 
     * @return string
     *          
     */
    public function generate_like( $post_id )
    {
        $icon   = $this->status === '1' ? 'fa-thumbs-up' : 'fa-thumbs-o-up';
        $total  = $this->get_total_like( $post_id );

        $output = "<a class='like' href='#' data-id='{$post_id}' data-type='like' data-message=''>
                        <i class='fa {$icon}'></i> <span>{$total}</span>
                    </a>";

        return apply_filters( 'jnews_like_render_like', $output );
    }

    /**
     * Generate like element
     * 
     * @param  int $post_id
     * 
     * @return string         
     * 
     */
    public function generate_dislike( $post_id )
    {
        $icon   = $this->status === '-1' ? 'fa-thumbs-down' : 'fa-thumbs-o-down';
        $total  = $this->get_total_dislike( $post_id );

        $output = "<a class='dislike' href='#' data-id='{$post_id}' data-type='dislike' data-message=''>
                        <i class='fa {$icon} fa-flip-horizontal'></i> <span>{$total}</span>
                    </a>";

        return apply_filters( 'jnews_like_render_dislike', $output );
    }

    /**
     * Get like & dislike element
     * 
     * @param  int $post_id
     * 
     * @return string
     *          
     */
    public function get_element( $post_id )
    {
        $element = '';
        $show    = jnews_get_option( 'single_show_like', 'both' );

        $this->status = $this->get_status( $post_id );

        if ( $show === 'like' )
        {
            $element = $this->generate_like( $post_id );
        } else if ( $show === 'both' ) {
            $element = $this->generate_like( $post_id ) . $this->generate_dislike( $post_id );
        }

        return $element;
    }

    /**
     * Generate like & dislike element
     * 
     * @param  int $post_id
     * 
     * @return string         
     * 
     */
    public function generate_element( $post_id )
    {
        $element = $this->get_element( $post_id );

        $output =
            "<div class='jeg_meta_like_container jeg_meta_like'>
                {$element}
            </div>";

        echo $output;
    }

    /**
     * Register rewrite rules
     */
    public function add_rewrite_rule()
    {
        $endpoints = array(
            'like'    => 'post-liked',
            'dislike' => 'post-disliked'
        );

        foreach ( $endpoints as $endpoint ) 
        {
            add_rewrite_endpoint( $endpoint , EP_ROOT | EP_PAGES );
            add_rewrite_rule( '^' . $endpoint . '/page/?([0-9]{1,})/?$', 'index.php?&paged=$matches[1]&' . $endpoint, 'top' );
        }
    }

    /**
     * Refresh rewrite rules
     */
    public function flush_rewrite_rules()
    {
        $this->add_rewrite_rule();

        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }

    /**
     * Build archive page url
     * 
     * @param  string $type
     * 
     * @return string      
     * 
     */
    public function archive_page_url( $type )
    {
        $url = home_url() . '/post-' . $type;

        return $url;
    }

    /**
     * Register dropdown link
     * 
     * @param  array $dropdown
     * 
     * @return array          
     * 
     */
    public function dropdown_link( $dropdown )
    {
        $show = jnews_get_option( 'single_show_like', 'both' );

        if ( $show === 'like' || $show === 'both' )
        {
            $item['liked'] = array(
                'text' => jnews_return_translation( 'Liked Post', 'jnews-like', 'liked_post' ),
                'url'  => $this->archive_page_url( 'liked' )
            );
        }

        if ( $show === 'both' ) 
        {
            $item['disliked'] = array(
                'text' => jnews_return_translation( 'Disliked Post', 'jnews-like', 'disliked_post' ),
                'url'  => $this->archive_page_url( 'disliked' )
            );
        }

        if ( isset( $item ) ) 
        {
            $dropdown = array_merge( $item, $dropdown );
        }

        return $dropdown;
    }

     /**
     * Add archive page template
     * 
     * @param  string $template
     * 
     * @return string      
     * 
     */
    public function add_page_template( $template )
    {
        global $wp;

        if ( is_user_logged_in() )
        {
            if ( isset( $wp->query_vars['post-liked'] ) ) 
            {
                $template = $this->get_template( 'liked' );
            }

            if ( isset( $wp->query_vars['post-disliked'] ) ) 
            {
                $template = $this->get_template( 'disliked' );
            }

            $this->user_id = get_current_user_id();
        }

        return $template;
    }

    /**
     * Get archive page template
     * 
     * @param  string $type
     * 
     * @return string      
     * 
     */
    public function get_template( $type )
    {
        $this->type = $type;
        $template   = JNEWS_LIKE_DIR . 'template/archive.php';
                    
        if ( file_exists( $template ) ) 
        {
            return $template;
        }
    }

    /**
     * Get archive page title
     */
    public function get_archive_title()
    {
        if ( $this->type === 'liked' ) 
        {
            return jnews_print_translation( 'Liked Post', 'jnews-like', 'liked_post' );
        }

        if ( $this->type === 'disliked' ) 
        {
            return jnews_print_translation( 'Disliked Post', 'jnews-like', 'disliked_post' );
        }

        return false;
    }

    /**
     * Empty content
     */
    public function empty_content()
    {
        echo "<div class='jeg_empty_module'>" . jnews_return_translation('No Content Available','jnews', 'no_content_available') . "</div>";
    }
}