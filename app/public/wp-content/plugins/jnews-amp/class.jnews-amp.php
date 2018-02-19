<?php
/**
 * @author Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}

class JNews_AMP
{   
    /**
     * @var JNews_AMP
     */
    private static $instance;

    /**
     * @var boolean
     */
    protected $amp_ads = array();

    /**
     * @return JNews_AMP
     */
    public static function getInstance()
    {
        if ( null === static::$instance )
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * JNews_AMP constructor
     */
    private function __construct()
    {
        $this->setup_init();
        $this->setup_hook();
    }

    /**
     * Setup hook
     */
    protected function setup_hook()
    {
        // customizer
        add_action( 'jnews_register_customizer_option', array( $this, 'customizer_option' ) );

        // amp
        add_filter( 'amp_post_template_head',           array( $this, 'add_script' ) );
        add_filter( 'amp_post_template_data',           array( $this, 'add_googlefont' ) );
        add_filter( 'amp_post_template_data',           array( $this, 'add_body_class' ) );
        add_filter( 'amp_post_template_dir',            array( $this, 'add_template_folder' ) );

        // favicon
        add_action( 'amp_post_template_head',           array( $this, 'add_favicon' ) );

        // ads
        add_action( 'jnews_amp_before_header',          array( $this, 'above_header_ads' ) );
        add_action( 'jnews_amp_before_article',         array( $this, 'above_article_ads' ) );
        add_action( 'jnews_amp_after_article',          array( $this, 'below_article_ads' ) );
        add_action( 'jnews_amp_before_content',         array( $this, 'above_content_ads' ) );
        add_action( 'jnews_amp_after_content',          array( $this, 'below_content_ads' ) );
        add_filter( 'the_content',                      array( $this, 'inline_content_ads' ) );

        // related item
        add_action( 'jnews_amp_after_content',          array( $this, 'related_item' ) );

        // main share button
        add_filter( 'jnews_single_share_main_button_list', array( $this, 'share_main_button' ) );

        // search form
        add_filter( 'jnews_get_permalink', array( $this, 'get_permalink' ) );
    }

    public function add_favicon()
    {
        if ( has_site_icon() ) wp_site_icon();
    }

    public function get_permalink( $url )
    {
        if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) 
        {
            if ( ! is_ssl() )
            {
                $url = preg_replace( "/^http:/i", "", $url );
            }
        }

        return $url;
    }

    /**
     * Setup init
     */
    protected function setup_init()
    {
        $locations  = array( 'above_header', 'above_article', 'below_article', 'above_content', 'inline_content', 'below_content' );

        foreach ( $locations as $location ) 
        {
            $enable_ad = jnews_get_option( 'amp_ads_' . $location . '_enable', false );

            if ( $enable_ad ) 
            {
                $this->amp_ads[$location] = true;
            }
        }
    }

    /**
     * Load customizer option
     */
    public function customizer_option()
    {
        require_once 'class.jnews-amp-option.php';
        JNews_AMP_Option::getInstance();
    }

    /**
     * Load amp template folder
     */
    public function add_template_folder()
    {
        return JNEWS_AMP_DIR . "template";
    }

    /**
     * Add google font
     */
    public function add_googlefont( $amp_data )
    {
        $style_instance = Jeg\Util\StyleGenerator::getInstance(); 
        $font_url       = $style_instance->get_font_url();

        if ( empty( $font_url ) ) return $amp_data;

        $font_url = 'https:' . $font_url;

        $amp_data['font_urls'] = array(
            'customizer-fonts' => $font_url
        );

        return $amp_data;
    }

    /**
     * Add Additional Body Class
     */
    public function add_body_class( $amp_data )
    {
        if ( is_rtl() ) 
        {
            $amp_data['body_class'] .= ' rtl';
        }

        return $amp_data;
    }

    /**
     * Add script
     */
    public function add_script( $amp_template )
    {
        $scripts = array();
        $format  = get_post_format( get_the_ID() );

        if ( $format === 'gallery' ) 
        {
            $scripts[] = array(
                'name'   => 'amp-carousel',
                'source' => 'https://cdn.ampproject.org/v0/amp-carousel-0.1.js'
            );
        }

        if ( $format === 'video' ) 
        {
            $video_url = get_post_meta( get_the_ID(), '_format_video_embed', true );

            if ( jnews_check_video_type( $video_url ) === 'youtube' ) 
            {
                $scripts[] = array(
                    'name'   => 'amp-youtube',
                    'source' => 'https://cdn.ampproject.org/v0/amp-youtube-0.1.js'
                );
            }
            
        }

        if ( !empty( $this->amp_ads ) ) 
        {
            $scripts[] = array(
                'name'   => 'amp-ad',
                'source' => 'https://cdn.ampproject.org/v0/amp-ad-0.1.js'
            );
        }

        // sidebar
        $scripts[] = array(
            'name'   => 'amp-sidebar',
            'source' => 'https://cdn.ampproject.org/v0/amp-sidebar-0.1.js'
        );

        if ( $this->header_search_form() ) 
        {
            // form
            $scripts[] = array(
                'name'   => 'amp-form',
                'source' => 'https://cdn.ampproject.org/v0/amp-form-0.1.js'
            );
        }
        
        foreach ( $scripts as $script ) 
        {
            $loaded_script = $amp_template->get( 'amp_component_scripts', array() );

            if ( !empty( $script['name'] ) && !array_key_exists( $script['name'], $loaded_script ) ) 
            {
                ?>
                <script custom-element="<?php echo esc_attr( $script['name'] ); ?>" src="<?php echo esc_url( $script['source'] ); ?>" async></script>
                <?php
            }
        }
    }

    /**
     * Above header ads
     */
    public function above_header_ads()
    {
        $location = 'above_header';

        if ( array_key_exists( $location, $this->amp_ads ) ) 
        {
            $html = "<div class=\"amp_ad_wrapper jnews_amp_{$location}_ads\">" . $this->render_ads( $location ) . "</div>";

            echo $html;
        }
    }

    /**
     * Above article ads
     */
    public function above_article_ads()
    {
        $location = 'above_article';

        if ( array_key_exists( $location, $this->amp_ads ) ) 
        {
            $html = "<div class=\"amp_ad_wrapper jnews_amp_{$location}_ads\">" . $this->render_ads( $location ) . "</div>";

            echo $html;
        }
    }

    /**
     * Below article ads
     */
    public function below_article_ads()
    {
        $location = 'below_article';

        if ( array_key_exists( $location, $this->amp_ads ) ) 
        {
            $html = "<div class=\"amp_ad_wrapper jnews_amp_{$location}_ads\">" . $this->render_ads( $location ) . "</div>";

            echo $html;
        }
    }

    /**
     * Above content ads
     */
    public function above_content_ads()
    {
        $location = 'above_content';

        if ( array_key_exists( $location, $this->amp_ads ) ) 
        {
            $html = "<div class=\"amp_ad_wrapper jnews_amp_{$location}_ads\">" . $this->render_ads( $location ) . "</div>";

            echo $html;
        }
    }

    /**
     * Below content ads
     */
    public function below_content_ads()
    {
        $location = 'below_content';

        if ( array_key_exists( $location, $this->amp_ads ) ) 
        {
            $html = "<div class=\"amp_ad_wrapper jnews_amp_{$location}_ads\">" . $this->render_ads( $location ) . "</div>";

            echo $html;
        }
    }

    /**
     * Inline content ads
     */
    public function inline_content_ads( $content )
    {
        if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) 
        {
            $location = 'inline_content';

            if ( array_key_exists( $location, $this->amp_ads ) ) 
            {
                $pnumber     = explode( '<p>', $content );
                $adsposition = jnews_get_option( 'amp_ads_' . $location . '_paragraph', 3 );
                $adsrandom   = jnews_get_option( 'amp_ads_' . $location . '_paragraph_random', false );

                if ( $adsrandom )
                {
                    $maxparagraph = count( $pnumber ) - 2;
                    $adsposition  = rand( $adsposition, $maxparagraph );
                }

                $html    = "<div class=\"amp_ad_wrapper jnews_amp_{$location}_ads\">" . $this->render_ads( $location ) . "</div>";
                $content = $this->prefix_insert_after_paragraph( $html, $adsposition, $content );
            }

        }

        return $content;
    }

    /**
     * Render ads
     * 
     * @param  string $location
     * 
     * @return string
     * 
     */
    protected function render_ads( $location )
    {
        $ads_html       = '';

        if ( jnews_get_option( 'amp_ads_' . $location . '_type', '' ) == 'googleads' ) 
        {
            $publisherid    = jnews_get_option( 'amp_ads_' . $location . '_google_publisher', '' );
            $slotid         = jnews_get_option( 'amp_ads_' . $location . '_google_id', '' );

            if ( !empty( $publisherid ) && !empty( $slotid ) )
            {
                $ad_size = jnews_get_option( 'amp_ads_' . $location . '_size', 'auto' );

                if ( $ad_size !== 'auto' ) 
                {
                    $ad_size = explode( 'x', $ad_size );
                } else {
                    $ad_size = array('320', '50');
                }

                $ads_html .=
                    "<amp-ad
                        type=\"adsense\"
                        width={$ad_size[0]} 
                        height={$ad_size[1]}
                        data-ad-client=\"ca-{$publisherid}\"
                        data-ad-slot=\"{$slotid}\">
                    </amp-ad>";
            }
        } else {
            $ads_html = jnews_get_option( 'amp_ads_' . $location . '_custom', '' ) ;
        }

        return $ads_html;
    }

    /**
     * Insert ads into certain paragraph
     * 
     * @param  string $insertion   
     * @param  int    $paragraph_id
     * @param  string $content   
     *   
     * @return string
     *               
     */
    protected function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content )
    {
        $begin_p    = '</p>';
        $paragraphs = explode( $begin_p, $content );

        if ( $paragraph_id == 0 ) 
        {
            return $insertion . $content;
        }

        foreach ( $paragraphs as $index => $paragraph ) 
        {
            if ( ($paragraph_id - 1 ) == $index ) 
            {
                $paragraphs[$index] .= $insertion;
            }

            if ( trim( $paragraph ) ) 
            {
                $paragraphs[$index] .= $begin_p;
            }
        }

        return implode( '', $paragraphs );
    }

    /**
     * Generate related post item
     */
    public function related_item()
    {
        if ( class_exists( 'JNews\\Module\\ModuleQuery' ) ) 
        {
            $match          = get_theme_mod( 'jnews_single_post_related_match', 'category' );
            $post_per_page  = get_theme_mod( 'jnews_single_number_post_related', 5 );
            $related_amp    = '';

            $category = $tag = $result = array();

            if ( $match === 'category' )
            {
                $this->recursive_category( get_the_category(), $result );

                if ( $result ) 
                {
                    foreach ( $result as $cat ) 
                    {
                        $category[] = $cat->term_id;
                    }
                }

            } elseif ( $match === 'tag' ) {

                $tags = get_the_tags();

                if ( $tags ) 
                {
                    foreach ( $tags as $cat ) 
                    {
                        $tag[] = $cat->term_id;
                    }
                }

            }

            $attr = array(
                'post_type'                 => array( 'post' ),
                'pagination_number_post'    => $post_per_page,
                'number_post'               => $post_per_page,
                'include_category'          => implode( ',', $category ),
                'include_tag'               => implode( ',', $tag ),
                'exclude_post'              => get_the_ID(),
                'sort_by'                   => 'latest',
                'post_offset'               => 0,
            );

            $result   = JNews\Module\ModuleQuery::do_query( $attr );
            $contents = $result['result'];

            if ( !empty( $contents ) )
            {
                $related_content = '';

                foreach( $contents as $content )
                {
                    $author             = $content->post_author;
                    $author_name        = get_the_author_meta( 'display_name', $author );
                    $date               = get_the_date( null, $content );
                    $image              = ''; 
                    
                    if ( has_post_thumbnail( $content->ID ) ) 
                    {
                        $image = get_the_post_thumbnail_url( $content->ID, 'jnews-120x86' );
                        $image = "<amp-img src='{$image}' width='120' height='86' layout='responsive' class='amp-related-image'></amp-img>";
                    }

                    $related_content .=
                        "<div class='amp-related-content'>
                            {$image}
                            <div class='amp-related-text'>
                                <h3><a href='" . get_permalink( $content->ID ) . "'>{$content->post_title}</a></h3>
                                <div class='amp-related-meta'>
                                    " . jnews_return_translation( 'By', 'jnews-amp', 'by' ) . "
                                    <span class='amp-related-author'>{$author_name}</span>
                                    <span class='amp-related-date'>{$date}</span>
                                </div>
                            </div>
                        </div>";
                }

                $related_amp =
                    "<div class='amp-related-wrapper'>
                        <h2>" . jnews_return_translation( 'Related Content','jnews-amp', 'related_content' ) . "</h2>
                        {$related_content}
                    </div>";
            }

            echo $related_amp;
        }
    }

    /**
     * Get category list of post
     * 
     * @param  array $categories
     * @param  array &$result
     *           
     */
    protected function recursive_category( $categories, &$result )
    {
        foreach ( $categories as $category )
        {
            $result[] = $category;
            $children = get_categories( array( 'parent' => $category->term_id ) );

            if ( !empty( $children ) ) 
            {
                $this->recursive_category( $children, $result );
            }
        }
    }

    protected function header_search_form()
    {
        $top_element    = get_theme_mod('jnews_hb_element_mobile_drawer_top_center', jnews_header_default("drawer_element_top"));
        $bottom_element = get_theme_mod('jnews_hb_element_mobile_drawer_bottom_center', jnews_header_default("drawer_element_bottom"));
        $elements       = array_merge( $top_element, $bottom_element );

        if ( in_array( 'search_form', $elements ) ) 
        {
            return true;
        }

        return false;
    }

    public function share_main_button( $main_button )
    {
        if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) 
        {
            foreach ( $main_button as $key => $value ) 
            {
                if ( $value['social_share'] == 'wechat' ) 
                {
                    unset( $main_button[$key] );
                }
            }
        }

        return $main_button;
    }
}

