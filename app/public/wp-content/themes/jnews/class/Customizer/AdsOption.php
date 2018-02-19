<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Customizer;

use JNews\Ads;
use JNews\Sidefeed\Sidefeed;

/**
 * Class Theme JNews Customizer
 */
Class AdsOption extends CustomizerOptionAbstract
{

    private $section_header = 'jnews_ads_header';
    private $section_article = 'jnews_ads_article';
    private $section_sidefeed = 'jnews_ads_sidefeed';
    private $section_global = 'jnews_ads_global';
    private $section_mobile = 'jnews_ads_mobile';

    protected function get_ad_size()
    {
        return array(
            'auto'                  =>  esc_attr__('Auto', 'jnews'),
            'hide'                  =>  esc_attr__('Hide', 'jnews'),
            '120x90'                =>  esc_attr__('120 x 90', 'jnews'),
            '120x240'               =>  esc_attr__('120 x 240', 'jnews'),
            '120x600'               =>  esc_attr__('120 x 600', 'jnews'),
            '125x125'               =>  esc_attr__('125 x 125', 'jnews'),
            '160x90'                =>  esc_attr__('160 x 90', 'jnews'),
            '160x600'               =>  esc_attr__('160 x 600', 'jnews'),
            '180x90'                =>  esc_attr__('180 x 90', 'jnews'),
            '180x150'               =>  esc_attr__('180 x 150', 'jnews'),
            '200x90'                =>  esc_attr__('200 x 90', 'jnews'),
            '200x200'               =>  esc_attr__('200 x 200', 'jnews'),
            '234x60'                =>  esc_attr__('234 x 60', 'jnews'),
            '250x250'               =>  esc_attr__('250 x 250', 'jnews'),
            '320x100'               =>  esc_attr__('320 x 100', 'jnews'),
            '300x250'               =>  esc_attr__('300 x 250', 'jnews'),
            '300x600'               =>  esc_attr__('300 x 600', 'jnews'),
            '320x50'                =>  esc_attr__('320 x 50', 'jnews'),
            '336x280'               =>  esc_attr__('336 x 280', 'jnews'),
            '468x15'                =>  esc_attr__('468 x 15', 'jnews'),
            '468x60'                =>  esc_attr__('468 x 60', 'jnews'),
            '728x15'                =>  esc_attr__('728 x 15', 'jnews'),
            '728x90'                =>  esc_attr__('728 x 90', 'jnews'),
            '970x90'                =>  esc_attr__('970 x 90', 'jnews'),
            '240x400'               =>  esc_attr__('240 x 400', 'jnews'),
            '250x360'               =>  esc_attr__('250 x 360', 'jnews'),
            '580x400'               =>  esc_attr__('580 x 400', 'jnews'),
            '750x100'               =>  esc_attr__('750 x 100', 'jnews'),
            '750x200'               =>  esc_attr__('750 x 200', 'jnews'),
            '750x300'               =>  esc_attr__('750 x 300', 'jnews'),
            '980x120'               =>  esc_attr__('980 x 120', 'jnews'),
            '930x180'               =>  esc_attr__('930 x 180', 'jnews')
        );
    }

    public function set_option()
    {
        $this->set_panel();
        $this->set_section();
        $this->set_field();
    }

    public function set_panel()
    {
        $this->customizer->add_panel(array(
            'id'            => 'jnews_ads',
            'title'         => esc_html__( 'JNews : Advertisement Option' ,'jnews' ),
            'description'   => esc_html__('JNews Advertisement Option','jnews' ),
            'priority'      => $this->id
        ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_header,
            'title'         => esc_html__('Header Ads','jnews' ),
            'panel'         => 'jnews_ads',
            'priority'      => 250,
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_article,
            'title'         => esc_html__('Article Ads','jnews' ),
            'panel'         => 'jnews_ads',
            'priority'      => 250,
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_sidefeed,
            'title'         => esc_html__('Sidefeed Ads','jnews' ),
            'panel'         => 'jnews_ads',
            'priority'      => 250,
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_global,
            'title'         => esc_html__('Global Ads','jnews' ),
            'panel'         => 'jnews_ads',
            'priority'      => 250,
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_mobile,
            'title'         => esc_html__('Mobile Ads','jnews' ),
            'panel'         => 'jnews_ads',
            'priority'      => 250,
        ));
    }

    private function default_value($name, $default, $ads_default)
    {
        if(isset($ads_default[$name])) {
            return $ads_default[$name];
        } else {
            return $default;
        }
    }

    public function ads_option_generator($location, $title, $section, $default_size, $visibility, $additional_callback = null, $postvar = null, $default = array())
    {
        // header
        $section_header = array(
            'id'            => 'jnews_ads_' . $location . '_section',
            'type'          => 'jnews-header',
            'section'       => $section,
            'label'         => sprintf(esc_html__('%s Advertisement','jnews'), $title),
        );

        if($additional_callback !== null) $section_header['active_callback'] = array($additional_callback);
        $this->customizer->add_field($section_header);

        // enable
        if($location === 'content_inline') {
            $section_enable = array(
                'id'            => 'jnews_ads_' . $location . '_enable',
                'transport'     => 'postMessage',
                'default'       => $this->default_value('jnews_ads_' . $location . '_enable', false, $default),
                'type'          => 'jnews-toggle',
                'section'       => $section,
                'label'         => sprintf(esc_html__('Enable %s Advertisement','jnews'), $title),
                'description'   => sprintf(esc_html__('Show advertisement on %s.','jnews'), $title),
                'partial_refresh' => array (
                    'jnews_ads_' . $location . '_enable' => array (
                        'selector'              => '.content-inner',
                        'render_callback'       => function() use($location) {
                            $content_post = get_post(get_the_ID());
                            $content = $content_post->post_content;
                            $content = apply_filters('the_content', $content);
                            $content = str_replace(']]>', ']]&gt;', $content);
                            echo jnews_sanitize_output($content);
                        },
                    ),
                ),
                'postvar'       => $postvar
            );
        } else if($location === 'sidefeed') {
            $section_enable = array(
                'id'            => 'jnews_ads_' . $location . '_enable',
                'transport'     => 'postMessage',
                'default'       => $this->default_value('jnews_ads_' . $location . '_enable', false, $default),
                'type'          => 'jnews-toggle',
                'section'       => $section,
                'label'         => sprintf(esc_html__('Enable %s Advertisement','jnews'), $title),
                'description'   => sprintf(esc_html__('Show advertisement on %s.','jnews'), $title),
                'partial_refresh' => array (
                    'jnews_ads_' . $location . '_enable' => array (
                        'selector'        => '.jeg_sidefeed',
                        'render_callback' => function() {
                            $feed = new Sidefeed();
                            $ajax = $feed->get_side_feed_content();
                            echo jnews_sanitize_output($ajax['content']);
                        },
                    ),
                ),
                'postvar'       => $postvar
            );
        } else {
            $section_enable = array(
                'id'            => 'jnews_ads_' . $location . '_enable',
                'transport'     => 'postMessage',
                'default'       => $this->default_value('jnews_ads_' . $location . '_enable', false, $default),
                'type'          => 'jnews-toggle',
                'section'       => $section,
                'label'         => sprintf(esc_html__('Enable %s Advertisement','jnews'), $title),
                'description'   => sprintf(esc_html__('Show advertisement on %s.','jnews'), $title),
                'partial_refresh' => array (
                    'jnews_ads_' . $location . '_enable' => array (
                        'selector'              => '.jnews_' . $location . '_ads',
                        'render_callback'       => function() use($location) {
                            $instance = Ads::getInstance();
                            call_user_func(array($instance, $location));
                        },
                    ),
                ),
                'postvar'       => $postvar
            );
        }



        if($additional_callback !== null) $section_enable['active_callback'] = array($additional_callback);
        $this->customizer->add_field($section_enable);

        // type

        $type_callback = array(array(
            'setting'  => 'jnews_ads_' . $location . '_enable',
            'operator' => '==',
            'value'    => true,
        ));
        if($additional_callback !== null) $type_callback[] = $additional_callback;

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_' . $location . '_type',
            'transport'     => 'postMessage',
            'default'       => $this->default_value('jnews_ads_' . $location . '_type', 'googleads', $default),
            'type'          => 'radio',
            'section'       => $section,
            'label'         => sprintf(esc_html__('%s : Advertisement type','jnews'), $title),
            'description'   => esc_html__('Choose which type of advertisement you want to use.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'image'         => esc_attr__( 'Image Ads', 'jnews' ),
                'googleads'     => esc_attr__( 'Google Ads', 'jnews' ),
                'code'          => esc_attr__( 'Script Code', 'jnews' ),
                'shortcode'     => esc_attr__( 'Shortcode', 'jnews' ),
            ),
            'active_callback'  => $type_callback,
            'partial_refresh' => array (
                'jnews_ads_' . $location . '_type' => array (
                    'selector'              => '.jnews_' . $location . '_ads',
                    'render_callback'       => function() use($location) {
                        $instance = Ads::getInstance();
                        call_user_func(array($instance, $location));
                    },
                ),
            ),
            'postvar'       => $postvar
        ));

        // ADDITIONAL OPTION - BEGIN

        if($location === 'sidefeed')
        {
            $this->customizer->add_field(array(
                'id'            => 'jnews_ads_' . $location . '_sequence',
                'transport'     => 'refresh',
                'default'       => $this->default_value('jnews_ads_' . $location . '_sequence', '3', $default),
                'type'          => 'jnews-slider',
                'section'       => $section,
                'label'         => sprintf(esc_html__('%s : Sidefeed Sequence','jnews'), $title),
                'description'   => esc_html__('Set after which sequence you want to show this ad.','jnews'),
                'choices'     => array(
                    'min'  => '1',
                    'max'  => '20',
                    'step' => '1',
                ),
                'active_callback'  => $type_callback,
                'partial_refresh' => array (
                    'jnews_ads_' . $location . '_sequence' => array (
                        'selector'        => '.jeg_sidefeed',
                        'render_callback' => function() {
                            $feed = new Sidefeed();
                            $ajax = $feed->get_side_feed_content();
                            echo jnews_sanitize_output($ajax['content']);
                        },
                    ),
                ),
                'postvar'       => $postvar
            ));
        }

        if($location === 'content_inline')
        {
            $this->customizer->add_field(array(
                'id'            => 'jnews_ads_' . $location . '_paragraph_random',
                'transport'     => 'postMessage',
                'default'       => $this->default_value('jnews_ads_' . $location . '_paragraph_random', false, $default),
                'type'          => 'jnews-toggle',
                'section'       => $section,
                'label'         => sprintf(esc_html__('Random ads position','jnews'), $title),
                'description'   => sprintf(esc_html__('Set random on which paragraph the ad will show.','jnews'), $title),
                'active_callback'  => $type_callback,
                'partial_refresh' => array (
                    'jnews_ads_' . $location . '_paragraph_random' => array (
                        'selector'        => '.content-inner',
                        'render_callback' => function() {
                            $content_post = get_post(get_the_ID());
                            $content = $content_post->post_content;
                            $content = apply_filters('the_content', $content);
                            $content = str_replace(']]>', ']]&gt;', $content);
                            echo jnews_sanitize_output($content);
                        },
                    ),
                ),
                'postvar'       => $postvar
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_ads_' . $location . '_paragraph',
                'transport'     => 'refresh',
                'default'       => $this->default_value('jnews_ads_' . $location . '_paragraph', '3', $default),
                'type'          => 'jnews-slider',
                'section'       => $section,
                'label'         => sprintf(esc_html__('%s : After Paragraph','jnews'), $title),
                'description'   => esc_html__('Set after which paragraph you want this advertisement to show.','jnews'),
                'choices'     => array(
                    'min'  => '0',
                    'max'  => '20',
                    'step' => '1',
                ),
                'active_callback'  => $type_callback,
                'partial_refresh' => array (
                    'jnews_ads_' . $location . '_paragraph' => array (
                        'selector'              => '.content-inner',
                        'render_callback'       => function() use($location) {
                            $content_post = get_post(get_the_ID());
                            $content = $content_post->post_content;
                            $content = apply_filters('the_content', $content);
                            $content = str_replace(']]>', ']]&gt;', $content);
                            echo jnews_sanitize_output($content);
                        },
                    ),
                ),
                'postvar'       => $postvar
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_ads_' . $location . '_align',
                'transport'     => 'postMessage',
                'default'       => $this->default_value('jnews_ads_' . $location . '_align', 'center', $default),
                'type'          => 'jnews-select',
                'section'       => $section,
                'label'         => sprintf(esc_html__('%s : Advertisement align','jnews'), $title),
                'description'   => esc_html__('Alignment of ad inside your content paragraph.','jnews'),
                'multiple'      => 1,
                'choices'       => array(
                    'center'        => esc_attr__( 'Center', 'jnews' ),
                    'left'          => esc_attr__( 'Left', 'jnews' ),
                    'right'         => esc_attr__( 'Right', 'jnews' ),
                ),
                'active_callback'  => $type_callback,
                'partial_refresh' => array (
                    'jnews_ads_' . $location . '_align' => array (
                        'selector'              => '.jnews_' . $location . '_ads',
                        'render_callback'       => function() use($location) {
                            $instance = Ads::getInstance();
                            call_user_func(array($instance, $location));
                        },
                    ),
                ),
                'postvar'       => $postvar
            ));
        }

        // ADDITIONAL OPTION - END

        // IMAGE
        $image_callback = array(
            array(
                'setting'  => 'jnews_ads_' . $location . '_type',
                'operator' => '==',
                'value'    => 'image',
            ),
            array(
                'setting'  => 'jnews_ads_' . $location . '_enable',
                'operator' => '==',
                'value'    => true,
            ),
        );

        if($additional_callback !== null) $image_callback[] = $additional_callback;

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_' . $location . '_image',
            'transport'     => 'postMessage',
            'default'       => $this->default_value('jnews_ads_' . $location . '_image', '', $default),
            'type'          => 'image',
            'section'       => $section,
            'label'         => sprintf(esc_html__('%s : Advertisement Image','jnews'), $title),
            'description'   => sprintf(esc_html__('Upload %s Image size.','jnews' ), $default_size),
            'active_callback'  => $image_callback,
            'partial_refresh' => array (
                'jnews_ads_' . $location . '_image' => array (
                    'selector'              => '.jnews_' . $location . '_ads',
                    'render_callback'       => function() use($location) {
                        $instance = Ads::getInstance();
                        call_user_func(array($instance, $location));
                    },
                ),
            ),
            'postvar'       => $postvar
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_' . $location . '_link',
            'transport'     => 'postMessage',
            'default'       => $this->default_value('jnews_ads_' . $location . '_link', '', $default),
            'type'          => 'text',
            'section'       => $section,
            'label'         => sprintf(esc_html__('%s : Advertisement Link','jnews'), $title),
            'description'   => esc_html__('Please put where this advertisement image will be heading.','jnews' ),
            'active_callback'  => $image_callback,
            'partial_refresh' => array (
                'jnews_ads_' . $location . '_link' => array (
                    'selector'              => '.jnews_' . $location . '_ads',
                    'render_callback'       => function() use($location) {
                        $instance = Ads::getInstance();
                        call_user_func(array($instance, $location));
                    },
                ),
            ),
            'postvar'       => $postvar
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_' . $location . '_text',
            'transport'     => 'postMessage',
            'default'       => $this->default_value('jnews_ads_' . $location . '_text', '', $default),
            'type'          => 'text',
            'section'       => $section,
            'label'         => sprintf(esc_html__('%s : Alternate Text','jnews' ), $title),
            'description'   => esc_html__('Insert alternate text for advertisement image.','jnews' ),
            'active_callback'  => $image_callback,
            'partial_refresh' => array (
                'jnews_ads_' . $location . '_text' => array (
                    'selector'              => '.jnews_' . $location . '_ads',
                    'render_callback'       => function() use($location) {
                        $instance = Ads::getInstance();
                        call_user_func(array($instance, $location));
                    },
                ),
            ),
            'postvar'       => $postvar
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_' . $location . '_open_tab',
            'transport'     => 'postMessage',
            'default'       => $this->default_value('jnews_ads_' . $location . '_open_tab', '', $default),
            'type'          => 'jnews-toggle',
            'section'       => $section,
            'label'         => sprintf(esc_html__('%s : Open in New Tab','jnews'), $title),
            'description'   => esc_html__('Enable open in new tab when advertisement image is clicked.','jnews' ),
            'active_callback'  => $image_callback,
            'partial_refresh' => array (
                'jnews_ads_' . $location . '_open_tab' => array (
                    'selector'              => '.jnews_' . $location . '_ads',
                    'render_callback'       => function() use($location) {
                        $instance = Ads::getInstance();
                        call_user_func(array($instance, $location));
                    },
                ),
            ),
            'postvar'       => $postvar
        ));

        // GOOGLE ADS

        $google_callback = array(
            array(
                'setting'  => 'jnews_ads_' . $location . '_type',
                'operator' => '==',
                'value'    => 'googleads',
            ),
            array(
                'setting'  => 'jnews_ads_' . $location . '_enable',
                'operator' => '==',
                'value'    => true,
            ),
        );

        if($additional_callback !== null) $google_callback[] = $additional_callback;

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_' . $location . '_google_publisher',
            'transport'     => 'postMessage',
            'default'       => $this->default_value('jnews_ads_' . $location . '_google_publisher', '', $default),
            'type'          => 'text',
            'section'       => $section,
            'label'         => sprintf(esc_html__('%s : Publisher ID','jnews'), $title),
            'description'   => esc_html__('Insert data-ad-client / google_ad_client content.','jnews' ),
            'active_callback'  => $google_callback,
            'partial_refresh' => array (
                'jnews_ads_' . $location . '_google_publisher' => array (
                    'selector'              => '.jnews_' . $location . '_ads',
                    'render_callback'       => function() use($location) {
                        $instance = Ads::getInstance();
                        call_user_func(array($instance, $location));
                    },
                ),
            ),
            'postvar'       => $postvar
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_' . $location . '_google_id',
            'transport'     => 'postMessage',
            'default'       => $this->default_value('jnews_ads_' . $location . '_google_id', '', $default),
            'type'          => 'text',
            'section'       => $section,
            'label'         => sprintf(esc_html__('%s : Ad Slot ID','jnews'), $title),
            'description'   => esc_html__('Insert data-ad-slot / google_ad_slot content.','jnews' ),
            'active_callback'  => $google_callback,
            'partial_refresh' => array (
                'jnews_ads_' . $location . '_google_id' => array (
                    'selector'              => '.jnews_' . $location . '_ads',
                    'render_callback'       => function() use($location) {
                        $instance = Ads::getInstance();
                        call_user_func(array($instance, $location));
                    },
                ),
            ),
            'postvar'       => $postvar
        ));

        if($visibility['desktop'])
        {
            $this->customizer->add_field(array(
                'id'            => 'jnews_ads_' . $location . '_google_desktop',
                'transport'     => 'postMessage',
                'default'       => $this->default_value('jnews_ads_' . $location . '_google_desktop', 'auto', $default),
                'type'          => 'jnews-select',
                'section'       => $section,
                'label'         => sprintf(esc_html__('%s : Desktop Ad Size','jnews'), $title),
                'description'   => esc_html__('Choose ad size to be shown on desktop, recommended to use auto.','jnews' ),
                'choices'       => $this->get_ad_size(),
                'active_callback'  => $google_callback,
                'partial_refresh' => array (
                    'jnews_ads_' . $location . '_google_desktop' => array (
                        'selector'              => '.jnews_' . $location . '_ads',
                        'render_callback'       => function() use($location) {
                            $instance = Ads::getInstance();
                            call_user_func(array($instance, $location));
                        },
                    ),
                ),
                'postvar'       => $postvar
            ));
        }

        if($visibility['tab'])
        {
            $this->customizer->add_field(array(
                'id'            => 'jnews_ads_' . $location . '_google_tab',
                'transport'     => 'postMessage',
                'default'       => $this->default_value('jnews_ads_' . $location . '_google_tab', 'auto', $default),
                'type'          => 'jnews-select',
                'section'       => $section,
                'label'         => sprintf(esc_html__('%s : Tab Ad Size','jnews'), $title),
                'description'   => esc_html__('Choose ad size to be shown on tablet, recommended to use auto.','jnews' ),
                'choices'       => $this->get_ad_size(),
                'active_callback'  => $google_callback,
                'partial_refresh' => array (
                    'jnews_ads_' . $location . '_google_tab' => array (
                        'selector'              => '.jnews_' . $location . '_ads',
                        'render_callback'       => function() use($location) {
                            $instance = Ads::getInstance();
                            call_user_func(array($instance, $location));
                        },
                    ),
                ),
                'postvar'       => $postvar
            ));
        }

        if($visibility['phone'])
        {
            $this->customizer->add_field(array(
                'id' => 'jnews_ads_' . $location . '_google_phone',
                'transport' => 'postMessage',
                'default' => $this->default_value('jnews_ads_' . $location . '_google_phone', 'auto', $default),
                'type' => 'jnews-select',
                'section' => $section,
                'label' => sprintf(esc_html__('%s : Phone Ad Size', 'jnews'), $title),
                'description' => esc_html__('Choose ad size to be shown on phone, recommended to use auto.', 'jnews'),
                'choices' => $this->get_ad_size(),
                'active_callback'  => $google_callback,
                'partial_refresh' => array(
                    'jnews_ads_' . $location . '_google_phone' => array(
                        'selector' => '.jnews_' . $location . '_ads',
                        'render_callback' => function () use ($location) {
                            $instance = Ads::getInstance();
                            call_user_func(array($instance, $location));
                        },
                    ),
                ),
                'postvar'       => $postvar
            ));
        }

        // CODE

        $code_callback = array(
            array(
                'setting'  => 'jnews_ads_' . $location . '_type',
                'operator' => '==',
                'value'    => 'code',
            ),
            array(
                'setting'  => 'jnews_ads_' . $location . '_enable',
                'operator' => '==',
                'value'    => true,
            ),
        );

        if($additional_callback !== null) $code_callback[] = $additional_callback;

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_' . $location . '_code',
            'transport'     => 'postMessage',
            'sanitize'      => 'jnews_sanitize_by_pass',
            'default'       => $this->default_value('jnews_ads_' . $location . '_code', '', $default),
            'type'          => 'textarea',
            'section'       => $section,
            'label'         => sprintf(esc_html__('%s : Ad code', 'jnews'), $title),
            'description'   => esc_html__('Put your ad\'s script code right here.', 'jnews'),
            'active_callback'  => $code_callback,
            'partial_refresh' => array (
                'jnews_ads_' . $location . '_code' => array (
                    'selector'              => '.jnews_' . $location . '_ads',
                    'render_callback'       => function() use($location) {
                        $instance = Ads::getInstance();
                        call_user_func(array($instance, $location));
                    },
                ),
            ),
            'postvar'       => $postvar
        ));


        // SHORTCODE

        $shortcode_callback = array(
            array(
                'setting'  => 'jnews_ads_' . $location . '_type',
                'operator' => '==',
                'value'    => 'shortcode',
            ),
            array(
                'setting'  => 'jnews_ads_' . $location . '_enable',
                'operator' => '==',
                'value'    => true,
            ),
        );

        if($additional_callback !== null) $shortcode_callback[] = $additional_callback;

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_' . $location . '_shortcode',
            'transport'     => 'postMessage',
            'default'       => $this->default_value('jnews_ads_' . $location . '_shortcode', '', $default),
            'type'          => 'textarea',
            'section'       => $section,
            'label'         => sprintf(esc_html__('%s : Advertisement code', 'jnews'), $title),
            'description'   => esc_html__('Put your ad\'s shortcode right here.', 'jnews'),
            'active_callback'  => $shortcode_callback,
            'partial_refresh' => array (
                'jnews_ads_' . $location . '_shortcode' => array (
                    'selector'              => '.jnews_' . $location . '_ads',
                    'render_callback'       => function() use($location) {
                        $instance = Ads::getInstance();
                        call_user_func(array($instance, $location));
                    },
                ),
            ),
            'postvar'       => $postvar
        ));
    }


    public function set_field()
    {
        $visibility_all = array('desktop' => true, 'tab' => true, 'phone' => true);
        $visibility_desktop = array('desktop' => true, 'tab' => false, 'phone' => false);

        // Header
        $this->ads_option_generator('header_top', esc_html__('Above Header', 'jnews'), $this->section_header, '970x90', $visibility_all);

        $this->ads_option_generator('header', esc_html__('Header', 'jnews'), $this->section_header, '728x90', $visibility_desktop, null, null, array(
            'jnews_ads_header_enable' => 1,
            'jnews_ads_header_type' => 'image',
            'jnews_ads_header_image' => get_parent_theme_file_uri('assets/img/ad_728x90.png'),
            'jnews_ads_header_link' => '#',
            'jnews_ads_header_text' => esc_html__('Advertisement', 'jnews')
        ));

        // ARTICLE
        $single_postvar = array(array(
            'redirect'  => 'single_post_tag',
            'refresh'   => false
        ));

        $this->ads_option_generator('article_top', esc_html__('Above Article', 'jnews'), $this->section_article, '970x90', $visibility_all, null, $single_postvar);
        $this->ads_option_generator('content_top', esc_html__('Top Content', 'jnews'), $this->section_article, '728x90', $visibility_all, null, $single_postvar);
        $this->ads_option_generator('content_inline', esc_html__('Inline Content', 'jnews'), $this->section_article, '728x90', $visibility_all, null, $single_postvar);
        $this->ads_option_generator('content_bottom', esc_html__('Bottom Content', 'jnews'), $this->section_article, '728x90', $visibility_all, null, $single_postvar);
        $this->ads_option_generator('article_bottom', esc_html__('Below Article', 'jnews'), $this->section_article, '970x90', $visibility_all, null, $single_postvar);

        // SIDEFEED
        $this->ads_option_generator('sidefeed', esc_html__('Sidefeed', 'jnews'), $this->section_sidefeed, '300x250', $visibility_all, array(
            'setting'  => 'jnews_sidefeed_enable',
            'operator' => '==',
            'value'    => true,
        ));

        // GLOBAL
        $this->customizer->add_field(array(
            'id'            => 'jnews_background_ads_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_global,
            'label'         => esc_html__('Background Ad','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_background_ads_header_alert',
            'type'          => 'jnews-alert',
            'default'       => 'info',
            'section'       => $this->section_global,
            'label'         => esc_html__('Background Ad\'s Image','jnews' ),
            'description'   => wp_kses(__("You can set your image background from <strong>JNews : Global Option</strong> &raquo; <strong>Layout & Background</strong>.", 'jnews'), wp_kses_allowed_html()),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_background_ads_url',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_global,
            'label'         => esc_html__('Background Ad\'s URL','jnews'),
            'description'   => esc_html__('Put your Background Ad\'s URL.','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_background_ads_open_tab',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Open URL on New Tab', 'jnews'),
            'description'   => esc_html__('Open advertisement\'s URL in new tab.', 'jnews'),
        ));

        $this->ads_option_generator('above_footer', esc_html__('Above Footer', 'jnews'), $this->section_global, '970x90', $visibility_all);


        // MOBILE
        $this->ads_option_generator('mobile_sticky', esc_html__('Sticky Mobile', 'jnews'), $this->section_mobile, '320x50', array(
            'desktop' => false,
            'tab' => false,
            'phone' => true
        ));



        // Page level ads

        $this->customizer->add_field(array(
            'id'            => 'jnews_page_level_ads_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_mobile,
            'label'         => esc_html__('Adsense - Page Level Ads','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_page_level_ads_enable',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_mobile,
            'label'         => esc_html__('Enable Page Level Ads','jnews'),
            'description'   => esc_html__('Enable this option to enable page level ads for mobile site.','jnews'),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_page_level_google_publisher',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_mobile,
            'label'         => esc_html__('Ad Client ID','jnews'),
            'description'   => esc_html__('Insert data-ad-client / google_ad_client content.','jnews' ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_page_level_ads_enable',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));



        $this->customizer->add_field(array(
            'id'            => 'jnews_page_level_anchor_enable',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_mobile,
            'label'         => esc_html__('Enable Page Level Anchor Ads','jnews'),
            'description'   => esc_html__('Enable this option to enable page level anchor ads for mobile site.','jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_page_level_ads_enable',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_page_level_anchor_google_channel',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_mobile,
            'label'         => esc_html__('Page Level Anchor Ads Google Channel','jnews'),
            'description'   => esc_html__('Insert google_ad_channel content.','jnews' ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_page_level_ads_enable',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'jnews_page_level_anchor_enable',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_page_level_vignette_enable',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_mobile,
            'label'         => esc_html__('Enable Page Level Vignette Ads','jnews'),
            'description'   => esc_html__('Enable this option to enable page level vignette ads for mobile site.','jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_page_level_ads_enable',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_ads_page_level_vignette_google_channel',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_mobile,
            'label'         => esc_html__('Page Level Vignette Ads Google Channel','jnews'),
            'description'   => esc_html__('Insert google_ad_channel content.','jnews' ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_page_level_ads_enable',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'jnews_page_level_vignette_enable',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

    }

}