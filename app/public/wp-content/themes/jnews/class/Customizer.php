<?php
/**
 * @author : Jegtheme
 */
namespace JNews;

use JNews\Customizer\AdsOption;
use JNews\Customizer\ArchiveOption;
use JNews\Customizer\CategoryOption;
use JNews\Customizer\CategoryDetailOption;
use JNews\Customizer\CodeOption;
use JNews\Customizer\FontOption;
use JNews\Customizer\FooterOption;
use JNews\Customizer\HeaderOption;
use JNews\Customizer\ImageOption;
use JNews\Customizer\LayoutOption;
use JNews\Customizer\OtherOption;
use JNews\Customizer\SearchOption;
use JNews\Customizer\SingleOption;
use JNews\Customizer\SocialOption;

/**
 * Class Theme JNews Customizer
 */
Class Customizer
{
    /**
     * @var Customizer
     */
    private static $instance;

    /**
     * @var Customizer
     */
    private $customizer = null;

    /**
     * @return Customizer
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
     * construct
     */
    private function __construct()
    {
        // Need to load Customizer early for this kind of request
        if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'jnews_customizer_disable_panel')
        {
            $this->customizer = jnews_customizer();
        }

        add_action( 'customize_preview_init', array($this, 'preview_init'));
        add_action( 'customize_controls_enqueue_scripts', array($this, 'customize_control_js') );
        add_action( 'jnews_register_customizer_option', array($this, 'load_customizer'), 91);
        // add_action( 'admin_bar_menu', array( $this, 'admin_bar' ), 999 );

        add_filter('jnews_font_typography', array($this, 'load_custom_font'), 80);
        add_filter('jnews_font_typography', array($this, 'load_typekit'), 81);
        add_filter('jnews_generate_inline_style', array($this, 'custom_font_css'));
        add_filter('jnews_customizer_style_output', array($this, 'exclude_font'));
        add_filter('jnews_fonts_option_setting', array($this, 'font_option_setting'));

        add_action('init', array($this, 'exclude_font'));
    }


    public function font_option_setting()
    {
        return array(
            'jnews_body_font',
            'jnews_header_font',
            'jnews_main_menu_font',
            'jnews_block_heading_font',
            'jnews_h1_font',
            'jnews_p_font',

            'jnews_header_logo_text_font',
            'jnews_sticky_logo_text_font',
            'jnews_mobile_logo_text_font'
        );
    }

    public function preview_init()
    {
        add_action( 'wp_enqueue_scripts' , array($this, 'load_script'), 99);
    }

    public function customize_control_js()
    {
        wp_enqueue_style( 'jnews-additional-customizer',    get_parent_theme_file_uri('assets/css/admin/additional-customizer.css'));

        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script( 'jnews-extend-control',          get_parent_theme_file_uri('assets/js/admin/extend-control.js'), array( 'jquery' ), null, true );
    }

    public function load_script()
    {
        wp_enqueue_style('jnews-customizer-redirect',   get_parent_theme_file_uri('assets/css/admin/theme-customizer.css') );
        wp_enqueue_style('vex',                         get_parent_theme_file_uri('assets/css/admin/vex.css') );

        wp_enqueue_script( 'vex',                       get_parent_theme_file_uri('assets/js/admin/vex.combined.min.js'), array( 'jquery' ), null, true );
        wp_enqueue_script( 'jnews-partial-refresh',     get_parent_theme_file_uri('assets/js/admin/partial.refresh.js'), array( 'jquery', 'customize-preview' ), null, true );
        wp_enqueue_script( 'jnews-post-message',        get_parent_theme_file_uri('assets/js/admin/post.message.js'), array( 'jquery' ), null, true );
    }

    public function load_customizer()
    {
        $this->customizer = jnews_customizer();

        if($this->get_memory_limit() >= 67108864)
        {
            new LayoutOption($this->customizer, 171);
            new HeaderOption($this->customizer, 172);
            new FooterOption($this->customizer, 173);
            new SingleOption($this->customizer, 174);
            new ImageOption($this->customizer, 175);
            new SocialOption($this->customizer, 176);
            new SearchOption($this->customizer, 177);
            new CategoryOption($this->customizer, 180);
            new ArchiveOption($this->customizer, 185);
            new FontOption($this->customizer, 191);
            new OtherOption($this->customizer, 194);

            if(apply_filters('jnews_load_advertisement_option', false))
            {
                new AdsOption($this->customizer, 193);
            }

            if(apply_filters('jnews_load_detail_customizer_category', false))
            {
                new CategoryDetailOption($this->customizer, 180);
            }

            new CodeOption($this->customizer, 195);
        } else {
        	$this->show_warning();
        }
    }

    protected function show_warning()
    {
	    // show warning
	    $this->customizer->add_panel(array(
		    'id' => 'jnews_memory_warning',
		    'title' => esc_html__('Warning - Increase memory limit', 'jnews'),
		    'description' => wp_kses(__(
			    '<ul>
                        <li>Memory limit is below minimal memory limit (64MB)</li>
                        <li>Most option disabled to prevent fatal error exhausted memory</li>
                        <li>Please increase your memory limit to recommended 128 MB</li>
                    </ul>
                    <span class="span-center">
                        <a href="http://support.jegtheme.com/documentation/system-status/#memory-limit" target="_blank" class="button button-primary">Find out how to Fix</a>
                    </span>',
			    'jnews'), wp_kses_allowed_html()),
		    'type' => 'alert',
		    'priority' => 1,
	    ));
    }


    /**
     * Get memory limit
     *
     * @return int
     */
    protected function get_memory_limit() {
        if ( function_exists( 'ini_get' ) ) {
            $memory_limit = ini_get( 'memory_limit' );
        } else {
            // Sensible default.
            $memory_limit = '128M';
        }

        if ( ! $memory_limit || -1 === $memory_limit ) {
            // Unlimited, set to 32GB.
            $memory_limit = '32000M';
        }

        return intval( $memory_limit ) * 1024 * 1024;
    }

    public function exclude_font($output)
    {
        $excluded_font = array();
        $output = is_array($output) ? $output : array();

        // type kit
        $typekit_font = get_theme_mod('jnews_type_kit', array());
        if(is_array($typekit_font))
        {
            foreach($typekit_font as $font) {
                $excluded_font[] = $font['font_name'];
            }
        }

        $upload_font = get_theme_mod('jnews_additional_font', array());
        if(is_array($upload_font))
        {
            foreach($upload_font as $font) {
                $excluded_font[] = $font['font_name'];
            }
        }

        $excluded_font = array_merge($excluded_font, array('Georgia', 'Helvetica', 'Monaco'));
        $output['excluded_font'] = $excluded_font;
        return $output;
    }

    public function load_typekit($fonts)
    {
        $custom_fonts = get_theme_mod('jnews_type_kit', array());

        if(!empty($custom_fonts))
        {
            $custom_fonts_final = array();

            foreach($custom_fonts as $font)
            {
                $custom_fonts_final[] = array(
                    'family'        => $font['font_name'],
                    'label'         => $font['font_name'],
                    'subsets'       => array(),
                    'is_standard'   => true,
                    'variants'      => array(),
                    'type'          => 'typekit'
                );
            }

            $merged = array_merge( $custom_fonts_final, $fonts );
            return $merged;
        } else {
            return $fonts;
        }
    }

    public function load_custom_font($fonts)
    {
        $custom_fonts = get_theme_mod('jnews_additional_font', array());

        if(!empty($custom_fonts)) {
            $custom_fonts_final = array();
            $variants = array();

            foreach($custom_fonts as $font)
            {
                $variants[$font['font_name']][] = array(
                    'id' => $font['font_weight'] . $font['font_style'],
                    'label' => $font['font_weight'] . ' - '. ucfirst($font['font_style'])
                );
            }

            foreach( $variants as $font => $variant )
            {
                $custom_fonts_final[] = array(
                    'family'        => $font,
                    'label'         => $font,
                    'subsets'       => array(),
                    'is_standard'   => true,
                    'variants'      => $variant,
                    'type'          => 'custom'
                );
            }

            $merged = array_merge( $custom_fonts_final, $fonts );
            return $merged;
        } else {
            return $fonts;
        }
    }

    public function custom_font_css($generated_style)
    {
        $custom_font_style = '';
        $custom_fonts = get_theme_mod('jnews_additional_font', array());

        foreach($custom_fonts as $font)
        {
            if(!empty($font['font_name']))
            {
                $font_src = array();

                if(!empty($font['eot']))
                {
                    $font_src[] = "url('" . wp_get_attachment_url($font['eot']) . "#iefix') format('embedded-opentype')";
                }

                if(!empty($font['woff']))
                {
                    $font_src[] = "url('" . wp_get_attachment_url($font['woff']) . "') format('woff')";
                }

                if(!empty($font['ttf']))
                {
                    $font_src[] = "url('" . wp_get_attachment_url($font['ttf']) . "') format('truetype')";
                }

                if(!empty($font['eot']))
                {
                    $font_src[] = "url('" . wp_get_attachment_url($font['svg']) . "') format('svg')";
                }

                $src = "src: " . implode( ",", $font_src ) . " ;";
                $custom_font_style .= " @font-face { font-family: '" . $font['font_name'] . "'; " . $src . " font-weight: {$font['font_weight']}; font-style: {$font['font_style']}; } ";
            }
        }

        return $custom_font_style . $generated_style;
    }

    public function admin_bar($admin_bar)
    {
        $labels         = $this->get_customizer_label();
        $customize_url = get_admin_url() . 'customize.php?url=' . get_permalink();

        $admin_bar->add_menu(array(
            'id'        => 'jnews',
            'title'     => 'JNews : Customizer',
            'href'      => $customize_url
        ));

        foreach ( $labels as $label )
        {
            $admin_bar->add_menu(
                array(
                    'parent' => 'jnews',
                    'id' => $label['id'],
                    'title' => $label['title'],
                    'href' => $customize_url . '&autofocus[' . $label['type'] . ']=' . $label['id']
                )
            );
        }
    }

    public function add_customizer_label() 
    {
        global $wp_admin_bar;
        global $post;

        if ( is_admin() ) return;
        if ( ! current_user_can( 'manage_options' ) ) return;

        $labels         = $this->get_customizer_label();
        $customize_url = get_admin_url() . 'customize.php?url=' . get_permalink();

        foreach ( $labels as $label ) 
        {
            $wp_admin_bar->add_menu( 
                array(
                    'parent' => 'customize',
                    'id' => $label['id'],
                    'title' => $label['title'],
                    'href' => $customize_url . '&autofocus[' . $label['type'] . ']=' . $label['id']
                )
            );
        }
    }

    protected function get_customizer_label()
    {
        $label = array(
            array(
                'id'    => 'jnews_layout_panel',
                'title' => '<i class="fa fa-magic"></i> ' . esc_html__( 'JNews : Layout, Color &amp; Scheme' , 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_header',
                'title' => '<i class="fa fa-list-alt"></i> ' . esc_html__( 'JNews : Header Option', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_footer',
                'title' => '<i class="fa fa-th-list"></i> ' . esc_html__( 'JNews : Footer Option', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_single_post_panel',
                'title' => '<i class="fa fa-newspaper-o"></i> ' . esc_html__( 'JNews : Single Post Option', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_image_panel',
                'title' => '<i class="fa fa-picture-o"></i> ' . esc_html__( 'JNews : Image & Gallery Option', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_social_panel',
                'title' => '<i class="fa fa-share-alt"></i> ' . esc_html__( 'JNews : Social, Live & View', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_search_panel',
                'title' => '<i class="fa fa-search"></i> ' . esc_html__( 'JNews : Search Option', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_category_panel',
                'title' => '<i class="fa fa-briefcase"></i> ' . esc_html__( 'JNews : Category Template', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_archive',
                'title' => '<i class="fa fa-archive"></i> ' . esc_html__( 'JNews : Other Template', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_font',
                'title' => '<i class="fa fa-font"></i> ' . esc_html__( 'JNews : Font Option', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_ads',
                'title' => '<i class="fa fa-usd"></i> ' . esc_html__( 'JNews : Advertisement Option', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'jnews_global_panel',
                'title' => '<i class="fa fa-cogs"></i> ' . esc_html__( 'JNews : Additional Option', 'jnews'),
                'type'  => 'panel'
            ),
            array(
                'id'    => 'custom_css',
                'title' => '<i class="fa fa-code"></i> ' . esc_html__( 'Additional CSS', 'jnews'),
                'type'  => 'section'
            )
        );

        return $label;
    }
}
