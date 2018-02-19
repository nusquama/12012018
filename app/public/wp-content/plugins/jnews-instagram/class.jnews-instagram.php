<?php
/**
 * @author Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class JNews_Util_Instagram
 */
Class JNews_Instagram
{
    /**
     * @var integer
     */
    private $row;
    private $column;
    private $count;

    /**
     * @var string
     */
    private $cache_key = "jnews_footer_instagram_cache";
    private $username;
    private $content;
    private $sort;
    private $hover;
    private $newtab;

    /**
     * JNews_Util_Instagram constructor
     */
    public function __construct( $row = 1 )
    {
        $this->row      = $row;
        $this->column   = jnews_get_option('footer_instagram_column', 8);
        $this->username = jnews_get_option('footer_instagram_username', '');
        $this->sort     = jnews_get_option('footer_instagram_sort_type', 'most_recent');
        $this->hover    = jnews_get_option('footer_instagram_hover_style', 'zoom');
        $this->newtab   = jnews_get_option('footer_instagram_newtab', null) ? 'target=\'_blank\'' : '';
        $this->count    = $this->row * $this->column;
    }

    public function render_content( $data )
    {
        $content = $like = '';

        if ( !empty( $data ) && is_array( $data ) ) 
        {
            switch ( $this->sort )
            {
                case 'most_recent':
                    usort($data, function($a, $b)
                    {
                        return $b['time'] - $a['time'];
                    });
                    break;
                case 'least_recent':
                    usort($data, function($a, $b)
                    {
                        return $a['time'] - $b['time'];
                    });
                    break;
                case 'most_like':
                    usort($data, function($a, $b)
                    {
                        return $b['like'] - $a['like'];
                    });
                    break;
                case 'least_like':
                    usort($data, function($a, $b)
                    {
                        return $a['like'] - $b['like'];
                    });
                    break;
                case 'most_comment':
                    usort($data, function($a, $b)
                    {
                        return $b['comment'] - $a['comment'];
                    });
                    break;
                case 'least_comment':
                    usort($data, function($a, $b)
                    {
                        return $a['comment'] - $b['comment'];
                    });
                    break;
            }

            $a = 1;
            foreach ( $data as $image ) 
            {
                if ( $this->hover == 'like' ) 
                {
                    $like =  "<i class='fa fa-heart'>" . jnews_number_format( $image['like'] ) . "</i>";
                } elseif ( $this->hover == 'comment' ) {
                    $like =  "<i class='fa fa-comments'>" . jnews_number_format( $image['comment'] ) . "</i>";
                }

                $image_tag = apply_filters('jnews_single_image', $image['images']['thumbnail'], $image['caption'], '1000');

                $content .= 
                    "<li>
                        <a href='{$image['link'] }' {$this->newtab}>
                            {$like}
                            {$image_tag}
                        </a>
                    </li>";

                if ( $a >= ( $this->row * $this->column ) ) 
                {
                    break;
                }

                $a++;
            }
        }

        $this->content = $content;
    }

    public function scrap_data( $username, $count = 12, $max_id = '' )
    {
        $response = wp_remote_get( $this->get_url( $username, $max_id ) , array(
            'timeout' => 10,
        ));

        if ( !is_wp_error( $response ) && $response['response']['code'] == '200' ) 
        {   
            $images    = '';
            $data      = explode( 'window._sharedData = ', $response['body'] );
            $data_json = explode( ';</script>', $data[1] );
            $data_json = json_decode( $data_json[0], TRUE );

            if ( is_array( $data_json ) && $data_json['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) 
            {
                $images = $data_json['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
            }

            $data_images = array();

            if ( is_array( $images ) && !empty( $images ) ) 
            {
                foreach ( $images as $image ) 
                {
                    $image['display_src']   = explode( '?ig_cache_key', $image['display_src'] );
                    $image['thumbnail_src'] = explode( '?ig_cache_key', $image['thumbnail_src'] );

                    $data_images[] = array(
                        'id'          => $image['id'],
                        'time'        => $image['date'],
                        'like'        => $image['likes']['count'],
                        'comment'     => $image['comments']['count'],
                        'type'        => $image['is_video'] == true ? 'video' : 'image',
                        'caption'     => !empty( $image['caption'] ) ? preg_replace('/[^a-zA-Z0-9\-]/', ' ', $image['caption']) : '',
                        'link'        => trailingslashit( '//instagram.com/p/' . $image['code'] ),
                        'images'      => array(
                            'display'   => $image['display_src'][0],
                            'thumbnail' => $image['thumbnail_src'][0],
                        ),
                    );

                    if ( count($data_images) >= $count ) 
                    {
                        break;
                    }
                }

                if ( (($count - count($data_images)) > 0) && (count($data_images) % 12 == 0) && (count($data_images) > 0) ) 
                {
                    $max_id = end( $data_images );
                    $max_id = $max_id['id'];
                    $next_images = $this->scrap_data( $username, ($count - 12), $max_id );

                    if ( !is_wp_error( $next_images ) ) 
                    {
                        $data_images = array_merge( $data_images, $next_images );
                    }
                }

                return $data_images;
            }
        }

        return null;
    }

    /**
     * Check data cached
     */
    protected function check_cache( $username, $count )
    {
        $now         = current_time('timestamp');
        $expire      = 60 * 60 * 24;

        $temp_cached = array();
        $data_cached = get_option( $this->cache_key );
        
        if( empty($data_cached) ) 
        {
            $data_cached = array();
        }

        $update_feed = false;
        $add_feed    = true;

        if ( !empty( $data_cached ) && is_array( $data_cached ) )
        {
            foreach ( $data_cached as $data )
            {
                if ( $data['username'] == $username ) 
                {
                    if ( count( $data['feed'] ) >= $count ) 
                    {
                        if ( $data['time'] > ($now - $expire) )
                        {
                            // !expired
                            $this->render_content( $data['feed'] );
                        } else {
                            // expired
                            $update_feed = true;
                            $data_scrap = $this->scrap_data( $username, $count );
                            
                            if ( !empty( $data_scrap ) ) 
                            {
                                $data['feed'] = $data_scrap;
                                $data['time'] = current_time('timestamp');
                            }

                            $this->render_content( $data['feed'] );
                        }
                    } else {

                        $update_feed = true;
                        $data_scrap = $this->scrap_data( $username, $count );
                        
                        if ( !empty( $data_scrap ) ) 
                        {
                            $data['feed'] = $data_scrap;
                            $data['time'] = current_time('timestamp');
                        }

                        $this->render_content( $data['feed'] );

                    }

                    $add_feed = false;
                }

                $temp_cached[] = $data;
            }

        }

        if ( $add_feed )
        {
            $data_scrap = $this->scrap_data( $username, $count );

            if ( !empty( $data_scrap ) ) 
            {
                $array[] = array(
                    'username' => $username,
                    'time'     => current_time('timestamp'),
                    'feed'     => $data_scrap,
                );

                $array = array_merge( $data_cached, $array );

                update_option( $this->cache_key, $array );

                $this->render_content( $data_scrap );
            }
        }

        if ( $update_feed )
        {
            update_option( $this->cache_key, $temp_cached );
        }
    }

    /**
     * Generate URl for Scrape
     * 
     * @param  string
     * @param  string
     * 
     * @return string
     * 
     */
    public function get_url( $username, $max_id )
    {
        $username = str_replace( '@', '', $username );

        if ( empty( $max_id ) ) 
        {
            return 'https://www.instagram.com/' . $username;
        } else {
            return 'https://www.instagram.com/' . $username . '?max_id=' . $max_id;
        }
    }

    /**
     * Generate element for Instagram feed
     */
    public function generate_element()
    {
        $output = $follow_button = '';

        if ( $follow_button_option = jnews_get_option('footer_instagram_follow_button', null) ) 
        {
            $follow_button =
                "<h3 class='jeg_instagram_heading'>
                    <a href='//www.instagram.com/{$this->username}' {$this->newtab}>
                        <i class='fa fa-instagram'></i>
                        " . esc_html( $follow_button_option ) . "
                    </a>
                </h3>";
        }

        $this->check_cache( $this->username, $this->count );

        $output = "<div class='jeg_instagram_feed clearfix'>
                        {$follow_button}
                        <ul class='instagram-pics instagram-size-large col{$this->column} {$this->hover}'>{$this->content}</ul>
                    </div>";

        echo $output;
    }
}
