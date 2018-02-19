<?php
/**
 * @author : Jegtheme
 */

/**
 * Class Theme JNews Option
 */
Class JNews_Gallery_Option
{
    /**
     * @var JNews_Gallery_Option
     */
    private static $instance;

    /**
     * @var Jeg\Customizer
     */
    private $customizer;

    /**
     * @var array
     */
    private $ad_size = array(
        'auto'                  =>  'Auto',
        'hide'                  =>  'Hide',
        '120x90'                =>  '120 x 90',
        '120x240'               =>  '120 x 240',
        '120x600'               =>  '120 x 600',
        '125x125'               =>  '125 x 125',
        '160x90'                =>  '160 x 90',
        '160x600'               =>  '160 x 600',
        '180x90'                =>  '180 x 90',
        '180x150'               =>  '180 x 150',
        '200x90'                =>  '200 x 90',
        '200x200'               =>  '200 x 200',
        '234x60'                =>  '234 x 60',
        '250x250'               =>  '250 x 250',
        '320x100'               =>  '320 x 100',
        '300x250'               =>  '300 x 250',
        '300x600'               =>  '300 x 600',
        '320x50'                =>  '320 x 50',
        '336x280'               =>  '336 x 280',
        '468x15'                =>  '468 x 15',
        '468x60'                =>  '468 x 60',
        '728x15'                =>  '728 x 15',
        '728x90'                =>  '728 x 90',
        '970x90'                =>  '970 x 90',
        '240x400'               =>  '240 x 400',
        '250x360'               =>  '250 x 360',
        '580x400'               =>  '580 x 400',
        '750x100'               =>  '750 x 100',
        '750x200'               =>  '750 x 200',
        '750x300'               =>  '750 x 300',
        '980x120'               =>  '980 x 120',
        '930x180'               =>  '930 x 180',
    );

    /**
     * @return JNews_Gallery_Option
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
        if(class_exists('Jeg\Customizer'))
        {
            $this->customizer = Jeg\Customizer::getInstance();

            $this->set_panel();
            $this->set_section();
            $this->set_field();
        }
    }

    public function set_panel()
    {
	    $this->customizer->add_panel(array(
		    'id' => 'jnews_single_post_panel',
		    'title' => esc_html__('JNews : Single Page & Post Option', 'jnews'),
		    'description' => esc_html__('JNews Single Page and Post Option.', 'jnews'),
		    'priority' => 200
	    ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id' => 'jnews_preview_slider_section',
            'title' => esc_html__('Gallery Shortcode', 'jnews-gallery'),
            'panel' => 'jnews_image_panel',
            'priority' => 250,
        ));

        $this->customizer->add_section(array(
            'id' => 'jnews_preview_slider_ads_section',
            'title' => esc_html__('Preview Slider Ads', 'jnews-gallery'),
            'panel' => 'jnews_ads',
            'priority' => 250,
        ));
    }

    public function set_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_preview_slider_alert',
            'type'          => 'jnews-alert',
            'default'       => 'info',
            'section'       => 'jnews_preview_slider_section',
            'label'         => esc_html__('Gallery Info','jnews-gallery' ),
            'description'   => esc_html__('This gallery option setting is a global setting. Its mean, when you change this setting, all of your gallery setting will follow this setting. But you can override each of this setting on your single gallery.','jnews-gallery' )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_preview_slider_header',
            'type'          => 'jnews-header',
            'section'       => 'jnews_preview_slider_section',
            'label'         => esc_html__('JNews Gallery Default Option','jnews-gallery' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[preview_slider_toggle]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => 'jnews_preview_slider_section',
            'label'         => esc_html__('Turn All Gallery to JNews Gallery', 'jnews-gallery'),
            'description'   => wp_kses(__("Enabling this option will turn all default slider into <strong>JNews Gallery</strong>.", 'jnews-gallery'), wp_kses_allowed_html()),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[preview_slider_desc]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => 'jnews_preview_slider_section',
            'label'         => esc_html__('Use Slider Zoom with Description', 'jnews-gallery'),
            'description'   => wp_kses(__("Enabling this option will turn your <strong>JNews Gallery</strong> to have description when zoomed.", 'jnews-gallery'), wp_kses_allowed_html()),
            'active_callback' => array(
                array(
                    'setting' => 'jnews_option[preview_slider_toggle]',
                    'operator' => '==',
                    'value'    => true
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[preview_slider_ads]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => 'jnews_preview_slider_section',
            'label'         => esc_html__('Show Ads Wrapper', 'jnews-gallery'),
            'description'   => wp_kses(__("Enabling this option will turn your <strong>JNews Gallery</strong> to have ads section when zoomed.", 'jnews-gallery'), wp_kses_allowed_html()),

            'active_callback' => array(
                array(
                    'setting' => 'jnews_option[preview_slider_toggle]',
                    'operator' => '==',
                    'value'    => true
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[preview_slider_loader]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'dot',
            'type'          => 'jnews-select',
            'section'       => 'jnews_preview_slider_section',
            'label'         => esc_html__('Preview Slider Loader Style', 'jnews-gallery'),
            'description'   => esc_html__('Choose loader style that you want to use for gallery.', 'jnews-gallery'),
            'choices'       => array(
                'dot'		    => esc_html__('Dot', 'jnews-gallery'),
                'circle'		=> esc_html__('Circle', 'jnews-gallery'),
                'square'		=> esc_html__('Square', 'jnews-gallery'),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.preview-slider-overlay .preloader_type',
                    'property'      => array(
                        'dot'           => 'preloader_dot',
                        'circle'        => 'preloader_circle',
                        'square'        => 'preloader_square',
                    ),
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_preview_slider_ads_header',
            'type'          => 'jnews-header',
            'section'       => 'jnews_preview_slider_ads_section',
            'label'         => esc_html__('Preview Slider Ads','jnews-gallery' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[ads_preview_slider_type]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'googleads',
            'type'          => 'radio',
            'section'       => 'jnews_preview_slider_ads_section',
            'label'         => esc_html__('Advertisement type','jnews-gallery'),
            'description'   => esc_html__('Choose which type of advertisement you want to use.','jnews-gallery'),
            'multiple'      => 1,
            'choices'       => array(
                'image'         => esc_attr__( 'Image Ads', 'jnews-gallery' ),
                'googleads'     => esc_attr__( 'Google Ads', 'jnews-gallery' ),
                'code'          => esc_attr__( 'Script Code', 'jnews-gallery' ),
                'shortcode'     => esc_attr__( 'Shortcode', 'jnews-gallery' ),
            ),
        ));


        // IMAGE

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[ads_preview_slider_image]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'image',
            'section'       => 'jnews_preview_slider_ads_section',
            'label'         => esc_html__('Advertisement Image','jnews-gallery'),
            'description'   => esc_html__('Upload 300x250 Image size.','jnews-gallery' ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[ads_preview_slider_type]',
                    'operator' => '==',
                    'value'    => 'image',
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[ads_preview_slider_link]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => 'jnews_preview_slider_ads_section',
            'label'         => esc_html__('Advertisement Link','jnews-gallery'),
            'description'   => esc_html__('Please put where this advertisement image will be heading.','jnews-gallery' ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[ads_preview_slider_type]',
                    'operator' => '==',
                    'value'    => 'image',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[ads_preview_slider_text]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => 'jnews_preview_slider_ads_section',
            'label'         => esc_html__('Alternate Text','jnews-gallery' ),
            'description'   => esc_html__('Insert alternate text for advertisement image.','jnews-gallery' ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[ads_preview_slider_type]',
                    'operator' => '==',
                    'value'    => 'image',
                ),
            ),
        ));

        // GOOGLE ADS

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[ads_preview_slider_google_publisher]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => 'jnews_preview_slider_ads_section',
            'label'         => esc_html__('Publisher ID','jnews-gallery'),
            'description'   => esc_html__('Insert data-ad-client / google_ad_client content.','jnews-gallery' ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[ads_preview_slider_type]',
                    'operator' => '==',
                    'value'    => 'googleads',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[ads_preview_slider_google_id]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => 'jnews_preview_slider_ads_section',
            'label'         => esc_html__('Ads Slot ID','jnews-gallery'),
            'description'   => esc_html__('Insert data-ad-slot / google_ad_slot content.','jnews-gallery' ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[ads_preview_slider_type]',
                    'operator' => '==',
                    'value'    => 'googleads',
                ),
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_option[ads_preview_slider_google_desktop]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'auto',
            'type'          => 'jnews-select',
            'section'       => 'jnews_preview_slider_ads_section',
            'label'         => esc_html__('Desktop Ads Size','jnews-gallery'),
            'description'   => esc_html__('Choose ad size to be shown on desktop, recommended to use auto.','jnews-gallery' ),
            'choices'       => $this->ad_size,
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[ads_preview_slider_type]',
                    'operator' => '==',
                    'value'    => 'googleads',
                ),
            ),
        ));


        // CODE

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[ads_preview_slider_code]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'textarea',
            'section'       => 'jnews_preview_slider_ads_section',
            'label'         => esc_html__('Ads code', 'jnews-gallery'),
            'description'   => esc_html__('Put your ad\'s script code right here.', 'jnews-gallery'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[ads_preview_slider_type]',
                    'operator' => '==',
                    'value'    => 'code',
                ),
            ),
        ));

        // SHORTCODE

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[ads_preview_slider_shortcode]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'textarea',
            'section'       => 'jnews_preview_slider_ads_section',
            'label'         => esc_html__('Advertisement code', 'jnews-gallery'),
            'description'   => esc_html__('Put your shortcode ads right here.', 'jnews-gallery'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_option[ads_preview_slider_type]',
                    'operator' => '==',
                    'value'    => 'shortcode',
                ),
            ),
        ));

    }
}
