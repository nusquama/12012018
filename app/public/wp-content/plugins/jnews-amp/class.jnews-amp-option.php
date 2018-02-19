<?php
/**
 * @author : Jegtheme
 */

/**
 * Class Theme JNews Option
 */
Class JNews_AMP_Option
{
    /**
     * @var JNews_AMP_Option
     */
    private static $instance;

    /**
     * @var Jeg\Customizer
     */
    private $customizer;

    /**
     * @var string
     */
    private $section = 'jnews_ads_amp_section';

    /**
     * @var array
     */
    private $ad_size = array(
        'auto'                  =>  'Auto',
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
        '240x400'               =>  '240 x 400',
        '250x360'               =>  '250 x 360',
    );

    /**
     * @return JNews_AMP_Option
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
     * JNews_AMP_Option constructor
     */
    private function __construct()
    {
        if ( class_exists('Jeg\Customizer') )
        {
            $this->customizer = Jeg\Customizer::getInstance();

            $this->set_section();
            $this->set_field();
        }
    }

    protected function set_section()
    {
        // set panel
        $this->customizer->add_panel(array(
            'id'            => 'jnews_ads',
            'title'         => esc_html__( 'JNews : Advertisement Option', 'jnews' ),
            'description'   => esc_html__( 'JNews Advertisement Option', 'jnews' ),
            'priority'      => 200,
        ));

        // set section
        $this->customizer->add_section(array(
            'id'       => $this->section,
            'title'    => esc_html__( 'AMP Ads', 'jnews-amp' ),
            'panel'    => 'jnews_ads',
            'priority' => 252,
        ));
    }

    protected function set_field()
    {
        $options = array();

        $options[] = array(
            'location'      => 'above_header',
            'label'         => 'Above Header',
            'description'   => 'above header'
        );

        $options[] = array(
            'location'      => 'above_article',
            'label'         => 'Above Article',
            'description'   => 'above article'
        );

        $options[] = array(
            'location'      => 'above_content',
            'label'         => 'Above Content',
            'description'   => 'above content'
        );

        $options[] = array(
            'location'      => 'inline_content',
            'label'         => 'Inline Content',
            'description'   => 'inline content'
        );

        $options[] = array(
            'location'      => 'below_content',
            'label'         => 'Below Content',
            'description'   => 'below content'
        );

        $options[] = array(
            'location'      => 'below_article',
            'label'         => 'Below Article',
            'description'   => 'below article'
        );

        foreach ( $options as $option ) 
        {
            $this->ads_option_generator( $option );
        }
    }

    protected function ads_option_generator( $option )
    {
        if ( empty( $option ) ) return;

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[amp_ads_' . $option['location'] . '_section]',
            'type'          => 'jnews-header',
            'section'       => $this->section,
            'label'         => sprintf( esc_html__( '%s Advertisement', 'jnews-amp' ), $option['label'] ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[amp_ads_' . $option['location'] . '_enable]',
            'transport'     => 'postMessage',
            'option_type'   => 'option',
            'default'       => '',
            'type'          => 'jnews-toggle',
            'section'       => $this->section,
            'label'         => sprintf( esc_html__( 'Enable %s Advertisement', 'jnews-amp' ), $option['label'] ),
            'description'   => sprintf( esc_html__( 'Enable advertisement on %s.', 'jnews-amp' ), $option['description'] )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[amp_ads_' . $option['location'] . '_type]',
            'transport'     => 'postMessage',
            'option_type'   => 'option',
            'default'       => 'googleads',
            'type'          => 'radio',
            'section'       => $this->section,
            'label'         => sprintf( esc_html__( '%s : Advertisement type', 'jnews-amp' ), $option['label'] ),
            'description'   => esc_html__( 'Choose which type of advertisement you want to use.', 'jnews-amp' ),
            'multiple'      => 1,
            'choices'       => array(
                'googleads'     => esc_attr__( 'Google Ads', 'jnews-amp' ),
                'custom'        => esc_attr__( 'Custom Ads', 'jnews-amp' )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_enable]',
                    'operator' => '==',
                    'value'    => true,
                ),
            )
        ));

        if ( $option['location'] === 'inline_content' ) 
        {
            $this->customizer->add_field(array(
                'id'            => 'jnews_option[amp_ads_' . $option['location'] . '_paragraph_random]',
                'transport'     => 'postMessage',
                'option_type'   => 'option',
                'default'       => '',
                'type'          => 'jnews-toggle',
                'section'       => $this->section,
                'label'         => sprintf( esc_html__( '%s : Random Ads Position', 'jnews-amp' ), $option['label'] ),
                'description'   => esc_html__( 'Random on which paragraph ads will show.', 'jnews-amp' ),
                'active_callback'  => array(
                    array(
                        'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_enable]',
                        'operator' => '==',
                        'value'    => true,
                    ),
                )
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_option[amp_ads_' . $option['location'] . '_paragraph]',
                'transport'     => 'postMessage',
                'option_type'   => 'option',
                'default'       => '3',
                'type'          => 'jnews-slider',
                'section'       => $this->section,
                'label'         => sprintf( esc_html__( '%s : After Paragraph', 'jnews-amp' ), $option['label'] ),
                'description'   => esc_html__( 'After which paragraph you want this advertisement to show.', 'jnews-amp' ),
                'choices'       => array(
                    'min'  => '0',
                    'max'  => '20',
                    'step' => '1',
                ),
                'active_callback'  => array(
                    array(
                        'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_enable]',
                        'operator' => '==',
                        'value'    => true,
                    ),
                )
            ));
        }

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[amp_ads_' . $option['location'] . '_google_publisher]',
            'transport'     => 'postMessage',
            'option_type'   => 'option',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section,
            'label'         => sprintf( esc_html__( '%s : Publisher ID', 'jnews-amp' ), $option['label'] ),
            'description'   => esc_html__( 'Insert data-ad-client / google_ad_client content.', 'jnews-amp' ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_enable]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_type]',
                    'operator' => '==',
                    'value'    => 'googleads',
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[amp_ads_' . $option['location'] . '_google_id]',
            'transport'     => 'postMessage',
            'option_type'   => 'option',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section,
            'label'         => sprintf( esc_html__( '%s : Ad Slot ID', 'jnews-amp' ), $option['label'] ),
            'description'   => esc_html__( 'Insert data-ad-slot / google_ad_slot content.', 'jnews-amp' ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_enable]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_type]',
                    'operator' => '==',
                    'value'    => 'googleads',
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[amp_ads_' . $option['location'] . '_size]',
            'transport'     => 'postMessage',
            'option_type'   => 'option',
            'default'       => 'auto',
            'type'          => 'jnews-select',
            'section'       => $this->section,
            'label'         => sprintf( esc_html__( '%s : Ads Size', 'jnews-amp' ), $option['label'] ),
            'description'   => esc_html__( 'Choose ads size, recommended to use auto instead.', 'jnews-amp' ),
            'choices'       => $this->ad_size,
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_enable]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_type]',
                    'operator' => '==',
                    'value'    => 'googleads',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[amp_ads_' . $option['location'] . '_custom]',
            'transport'     => 'postMessage',
            'option_type'   => 'option',
            'default'       => '',
            'type'          => 'textarea',
            'sanitize'      => 'jnews_sanitize_by_pass',
            'section'       => $this->section,
            'label'         => sprintf( esc_html__( '%s : Ad Code', 'jnews-amp' ), $option['label'] ),
            'description'   => esc_html__( 'Insert your custom ad code.', 'jnews-amp' ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_enable]',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'jnews_option[amp_ads_' . $option['location'] . '_type]',
                    'operator' => '==',
                    'value'    => 'custom',
                ),
            )
        ));
    }
}
