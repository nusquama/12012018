<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Customizer;

use JNews\Sidefeed\Sidefeed;
use JNews\Sidefeed\SidefeedCategoryWalker;

/**
 * Class Theme JNews Customizer
 */
Class LayoutOption extends CustomizerOptionAbstract
{
    /** section */
    private $section_global_sidefeed = 'jnews_global_sidefeed';
    private $section_global_layout = 'jnews_global_layout_section';
    private $section_global_color = 'jnews_global_color_section';
    private $section_global_browser = 'jnews_global_browser_section';
    private $category = array();

    public function __construct($customizer, $id)
    {
        $categories = get_categories(array(
            'hide_empty' => false,
            'hierarchical' => true
        ));

        $walker = new SidefeedCategoryWalker();
        $walker->walk($categories, 3);

        foreach($walker->cache as $value){
            $this->category[$value['id']] = $value['title'];
        }

        parent::__construct($customizer, $id);
    }

    /**
     * Set Section
     */
    public function set_option()
    {
        $this->set_panel();
        $this->set_section();

        $this->set_global_sidefeed_field();
        $this->set_global_layout_field();
        $this->set_global_color_field();
        $this->set_global_browser_color();
    }

    public function set_panel()
    {
        /** panel */
        $this->customizer->add_panel(array(
            'id' => 'jnews_layout_panel',
            'title' => esc_html__('JNews : Layout, Color & Scheme', 'jnews'),
            'description' => esc_html__('JNews Layout Option', 'jnews'),
            'priority' => $this->id
        ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id' => $this->section_global_layout,
            'title' => esc_html__('Layout & Background', 'jnews'),
            'panel' => 'jnews_layout_panel',
            'priority' => 250,
        ));

        $this->customizer->add_section(array(
            'id' => $this->section_global_sidefeed,
            'title' => esc_html__('Sidefeed Setting', 'jnews'),
            'panel' => 'jnews_layout_panel',
            'priority' => 250,
        ));

        $this->customizer->add_section(array(
            'id' => $this->section_global_color,
            'title' => esc_html__('Scheme & Website Color', 'jnews'),
            'panel' => 'jnews_layout_panel',
            'priority' => 250,
        ));

        $this->customizer->add_section(array(
            'id' => $this->section_global_browser,
            'title' => esc_html__('Mobile Browser Color', 'jnews'),
            'panel' => 'jnews_layout_panel',
            'priority' => 250,
        ));
    }


    public function set_global_sidefeed_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_enable',
            'transport'     => 'refresh',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Enable Sidefeed', 'jnews'),
            'description'   => esc_html__('Turn on this option to enable sidefeed.', 'jnews'),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_enable_ajax',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Enable Ajax Load Sidefeed Post', 'jnews'),
            'description'   => esc_html__('Enable this option, so post on sidefeed will be loaded as ajax on a single post.', 'jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sidefeed_enable',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_number_post',
            'transport'     => 'postMessage',
            'default'       => 12,
            'type'          => 'jnews-slider',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Number of Post', 'jnews'),
            'description'   => esc_html__('Set the number of news feed per load.', 'jnews'),
            'choices'     => array(
                'min'  => '1',
                'max'  => '30',
                'step' => '1',
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sidefeed_enable',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
            'partial_refresh' => array (
                'jnews_sidefeed_number_post' => array (
                    'selector'        => '.jeg_sidefeed',
                    'render_callback' => function() {
                        $feed = new Sidefeed();
                        $ajax = $feed->get_side_feed_content();
                        echo jnews_sanitize_output($ajax['content']);
                    },
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_main_position',
            'transport'     => 'postMessage',
            'default'       => 'center',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Main Content Position', 'jnews'),
            'description'   => esc_html__('Set the position of main content on sidefeed.', 'jnews'),
            'choices'       => array(
                'left'		    => esc_html__('Content Align Left', 'jnews'),
                'center'		=> esc_html__('Content Align Center', 'jnews'),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sidefeed_enable',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => 'body',
                    'property'      => array(
                        'left'          => 'jeg_sidecontent_left',
                        'center'        => 'jeg_sidecontent_center',
                    ),
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_show_trending',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Show Trending Button', 'jnews'),
            'description'   => wp_kses(__('Enable this option to show trending button on sidefeed. <br>You will need to enable <strong>JNews View Counter Plugin</strong> to use this feature.','jnews'), wp_kses_allowed_html()),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sidefeed_enable',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
            'partial_refresh' => array (
                'jnews_sidefeed_show_trending' => array (
                    'selector'        => '.jeg_side_tabs',
                    'render_callback' => function() {
                        $feed = new Sidefeed();
                        echo jnews_sanitize_output($feed->render_side_feed_tab());
                    },
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_trending_range',
            'transport'     => 'postMessage',
            'default'       => 'all',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Trending Range', 'jnews'),
            'description'   => esc_html__('Set trending post range.', 'jnews'),
            'choices'       => array(
                'daily'		    => esc_html__('Last 24 hours', 'jnews'),
                'weekly'		=> esc_html__('Last 7 days', 'jnews'),
                'monthly'		=> esc_html__('Last 30 days', 'jnews'),
                'all'		    => esc_html__('All-time', 'jnews')
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sidefeed_enable',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'jnews_sidefeed_show_trending',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_show_category',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Show Category', 'jnews'),
            'description'   => esc_html__('Enable this option to show category selector button on sidefeed.', 'jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sidefeed_enable',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
            'partial_refresh' => array (
                'jnews_sidefeed_show_category' => array (
                    'selector'        => '.jeg_side_feed_cat_wrapper',
                    'render_callback' => function() {
                        $feed = new Sidefeed();
                        echo jnews_sanitize_output($feed->render_side_feed_category_button());
                    },
                ),
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_category',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Select Category List', 'jnews'),
            'description'   => esc_html__('Select category you want to show on category button.', 'jnews'),
            'multiple'      => 999,
            'choices'       => $this->category,
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sidefeed_enable',
                    'operator' => '==',
                    'value'    => true,
                ),
                array(
                    'setting'  => 'jnews_sidefeed_show_category',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
            'partial_refresh' => array (
                'jnews_sidefeed_category' => array (
                    'selector'        => '.jeg_cat_dropdown',
                    'render_callback' => function() {
                        $feed = new Sidefeed();
                        echo jnews_sanitize_output($feed->render_side_feed_list());
                    },
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_overlay_bgcolor',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Overlay Background Color','jnews'),
            'description'   => esc_html__('If ajax loaded enabled, you can change overlay background color here.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.post-ajax-overlay',
                    'property'      => 'background',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sidefeed_enable',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_feed_date_format',
            'transport'     => 'postMessage',
            'default'       => 'default',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Sidefeed Date Format','jnews'),
            'description'   => esc_html__('Choose which date format you want to use for sidefeed.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'ago' => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
                'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
                'custom' => esc_attr__( 'Custom Format', 'jnews' ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sidefeed_enable',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
            'partial_refresh' => array (
                'jnews_feed_date_format' => array (
                    'selector'        => '.jeg_sidefeed',
                    'render_callback' => function() {
                        $feed = new Sidefeed();
                        $content = $feed->get_side_feed_content();
                        echo jnews_sanitize_output($content['content']);
                    },
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_feed_date_format_custom',
            'transport'     => 'postMessage',
            'default'       => 'Y/m/d',
            'type'          => 'text',
            'section'       => $this->section_global_sidefeed,
            'label'         => esc_html__('Sidefeed Date Format','jnews'),
            'description'   => wp_kses(sprintf(__("Please set custom date format for sidefeed. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews"), "https://developer.wordpress.org/reference/functions/current_time/"),
                wp_kses_allowed_html()),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_feed_date_format',
                    'operator' => '==',
                    'value'    => 'custom',
                ),
                array(
                    'setting'  => 'jnews_sidefeed_enable',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
            'partial_refresh' => array (
                'jnews_feed_date_format_custom' => array (
                    'selector'        => '.jeg_sidefeed',
                    'render_callback' => function() {
                        $feed = new Sidefeed();
                        $content = $feed->get_side_feed_content();
                        echo jnews_sanitize_output($content['content']);
                    },
                ),
            ),
        ));

    }

    public function set_global_browser_color()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_mobile_browser_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_global_browser,
            'label'         => esc_html__('Mobile Browser Background Color','jnews'),
            'description'   => esc_html__('Change color of chrome, firefox, vivaldi, windows phone browser, iOS Safari on mobile device.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
        ));
    }

    public function set_global_layout_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_boxed_layout_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_global_layout,
            'label'         => esc_html__('Box Layout','jnews' ),
        ));

        $boxed_enabled = array(
            'setting'  => 'jnews_boxed_layout',
            'operator' => '==',
            'value'    => true,
        );

        $this->customizer->add_field(array(
            'id'            => 'jnews_boxed_layout',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_layout,
            'label'         => esc_html__('Enable Boxed Layout', 'jnews'),
            'description'   => esc_html__('By enabling boxed layout, you can use background image.', 'jnews'),
            'output'     => array(
                array(
                    'method'        => 'add-class',
                    'element'       => 'body',
                    'property'      => 'jeg_boxed',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_background_color',
            'transport'     => 'postMessage',
            'default'       => '#ffffff',
            'type'          => 'jnews-color',
            'section'       => $this->section_global_layout,
            'label'         => esc_html__('Background Color', 'jnews'),
            'description'   => esc_html__('Set website background color.', 'jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => 'body.jnews',
                    'property'      => 'background-color',
                )
            ),
            'active_callback' => array($boxed_enabled),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_background_image',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'image',
            'section'       => $this->section_global_layout,
            'label'         => esc_html__('Background Image','jnews' ),
            'description'   => esc_html__('Upload your background image.','jnews' ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => 'body.jnews',
                    'property'      => 'background-image',
                    'prefix'        => 'url("',
                    'suffix'        => '")'
                )
            ),
            'active_callback' => array($boxed_enabled),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_background_repeat',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_layout,
            'label'         => esc_html__('Background Repeat', 'jnews'),
            'description'   => esc_html__('Set background image repeat.','jnews' ),
            'choices'       => array(
                ''              => '',
                'repeat-x'		=> 'Repeat Horizontal',
                'repeat-y'		=> 'Repeat Vertical',
                'repeat'		=> 'Repeat Image',
                'no-repeat'		=> 'No Repeat'
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => 'body.jnews',
                    'property'      => 'background-repeat',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_background_image',
                    'operator' => '!=',
                    'value'    => '',
                ),
                $boxed_enabled
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_background_position',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_layout,
            'label'         => esc_html__('Background Position', 'jnews'),
            'description'   => esc_html__('Set background image position.','jnews' ),
            'choices'       => array(
                ''                  => '',
                'left left'		    => 'Left Left',
                'left center'		=> 'Left Center',
                'left right'		=> 'Left Right',
                'center left'	    => 'Center Left',
                'center center'	    => 'Center Center',
                'center right'		=> 'Center Right',
                'right left'		=> 'Right Left',
                'right center'		=> 'Right Center',
                'right right'		=> 'Right Right',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => 'body.jnews',
                    'property'      => 'background-position',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_background_image',
                    'operator' => '!=',
                    'value'    => '',
                ),
                $boxed_enabled
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_background_fixed',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_layout,
            'label'         => esc_html__('Attachment Background', 'jnews'),
            'description'   => esc_html__('Set background image attachment.','jnews' ),
            'choices'       => array(
                ''              => '',
                'fixed'		    => 'Fixed',
                'scroll'		=> 'Scroll'
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => 'body.jnews',
                    'property'      => 'background-attachment',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_background_image',
                    'operator' => '!=',
                    'value'    => '',
                ),
                $boxed_enabled
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_background_size',
            'transport'     => 'postMessage',
            'default'       => 'inherit',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_layout,
            'label'         => esc_html__('Background Size', 'jnews'),
            'description'   => esc_html__('Set background image size.','jnews' ),
            'choices'       => array(
                ''              => '',
                'cover'		    => 'Cover',
                'contain'		=> 'Contain',
                'initial'		=> 'Initial',
                'inherit'		=> 'Inherit'
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => 'body.jnews',
                    'property'      => 'background-size',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_background_image',
                    'operator' => '!=',
                    'value'    => '',
                ),
                $boxed_enabled
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_container_background_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_global_layout,
            'label'         => esc_html__('Container Background','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_container_background',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_global_layout,
            'label'         => esc_html__('Container Background Color', 'jnews'),
            'description'   => esc_html__('Inside container background color.', 'jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_container, .jeg_content, .jeg_boxed .jeg_main .jeg_container, .jeg_cat_header',
                    'property'      => 'background-color',
                )
            )
        ));
    }

    public function set_global_color_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_scheme_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_global_color,
            'label'         => esc_html__('Website Scheme','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_scheme_color',
            'transport'     => 'refresh',
            'default'       => 'normal',
            'type'          => 'jnews-preset',
            'section'       => $this->section_global_color,
            'label'         => esc_html__('Choose your scheme color', 'jnews'),
            'description'   => esc_html__('This option will switch color option of your website. Header & footer option won\'t be affected by this option.','jnews' ),
            'choices'       => array(
                'normal' => array(
                    'label'     => esc_html__('Normal', 'jnews'),
                    'settings'  => array(
                        'jnews_body_color' => '#53585c',
                        'jnews_heading_color' => '#212121',
                        'jnews_container_background' => '#ffffff',
                        // 'jnews_header_topbar_scheme' => 'normal',
                        // 'jnews_header_midbar_scheme' => 'normal',
                        // 'jnews_header_bottombar_scheme' => 'jeg_navbar_normal',
                        // 'jnews_header_stickybar_scheme' => 'jeg_navbar_normal',
                    )
                ),
                'dark' => array(
                    'label'     => esc_html__('Dark', 'jnews'),
                    'settings'  => array(
                        'jnews_body_color' => '#ffffff',
                        'jnews_heading_color' => '#ffffff',
                        'jnews_container_background' => '#111111',
                        // 'jnews_header_topbar_scheme' => 'dark',
                        // 'jnews_header_midbar_scheme' => 'dark',
                        // 'jnews_header_bottombar_scheme' => 'jeg_navbar_dark',
                        // 'jnews_header_stickybar_scheme' => 'jeg_navbar_dark',
                    )
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_webstite_color_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_global_color,
            'label'         => esc_html__('Website Color','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_body_color',
            'transport'     => 'postMessage',
            'type'          => 'jnews-color',
            'section'       => $this->section_global_color,
            'default'       => '#53585c',
            'label'         => esc_html__('Base Text Color (Body)', 'jnews'),
            'description'   => esc_html__('Set body text color.', 'jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => 'body,.newsfeed_carousel.owl-carousel .owl-nav div,.jeg_filter_button,.owl-carousel .owl-nav div,.jeg_readmore,.jeg_hero_style_7 .jeg_post_meta a,.widget_calendar thead th,.widget_calendar tfoot a,.jeg_socialcounter a,.entry-header .jeg_meta_like a,.entry-header .jeg_meta_comment a,.entry-content tbody tr:hover,.entry-content th,.jeg_splitpost_nav li:hover a,#breadcrumbs a,.jeg_author_socials a:hover,.jeg_footer_content a,.jeg_footer_bottom a,.jeg_cartcontent,.woocommerce .woocommerce-breadcrumb a',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_accent_color',
            'transport'     => 'postMessage',
            'type'          => 'jnews-color',
            'section'       => $this->section_global_color,
            'default'       => '#f70d28',
            'label'         => esc_html__('Accent Color', 'jnews'),
            'description'   => esc_html__('Set general accent color.', 'jnews'),
            'output'     => array(
                array(
                    /* Accent Color */
                    'method'        => 'inject-style',
                    'element'       => 'a,.jeg_menu_style_5 > li > a:hover,.jeg_menu_style_5 > li.sfHover > a,.jeg_navbar .jeg_menu:not(.jeg_main_menu) > li > a:hover,.jeg_midbar .jeg_menu:not(.jeg_main_menu) > li > a:hover,.jeg_side_tabs li.active,.jeg_block_heading_5 strong,.jeg_block_heading_6 strong,.jeg_block_heading_7 strong,.jeg_block_heading_8 strong,.jeg_subcat_list li a:hover,.jeg_subcat_list li button:hover,.jeg_pl_lg_7 .jeg_thumb .jeg_post_category a,.jeg_pl_xs_2:before,.jeg_pl_xs_4 .jeg_postblock_content:before,.jeg_postblock .jeg_post_title a:hover,.jeg_hero_style_6 .jeg_post_title a:hover,.jeg_sidefeed .jeg_pl_xs_3 .jeg_post_title a:hover,.widget_jnews_popular .jeg_post_title a:hover,.jeg_meta_author a,.widget_archive li a:hover,.widget_pages li a:hover,.widget_meta li a:hover,.widget_recent_entries li a:hover,.widget_rss li a:hover,.widget_rss cite,.widget_categories li a:hover,.widget_categories li.current-cat > a,#breadcrumbs a:hover,.jeg_share_count .counts,.commentlist .bypostauthor > .comment-body > .comment-author > .fn,span.required,.jeg_review_title,.bestprice .price,.authorlink a:hover,.jeg_vertical_playlist .jeg_video_playlist_play_icon,.jeg_vertical_playlist .jeg_video_playlist_item.active .jeg_video_playlist_thumbnail:before,.jeg_horizontal_playlist .jeg_video_playlist_play,.woocommerce li.product .pricegroup .button,.widget_display_forums li a:hover,.widget_display_topics li:before,.widget_display_replies li:before,.widget_display_views li:before,.bbp-breadcrumb a:hover,.jeg_mobile_menu li.sfHover > a,.jeg_mobile_menu li a:hover',
                    'property'      => 'color',
                ),
                array(
                    /* Accent Background */
                    'method'        => 'inject-style',
                    'element'       => '.jeg_menu_style_1 > li > a:before,.jeg_menu_style_2 > li > a:before,.jeg_menu_style_3 > li > a:before,.jeg_side_toggle,.jeg_slide_caption .jeg_post_category a,.jeg_slider_type_1 .owl-nav .owl-next,.jeg_block_heading_1 .jeg_block_title span,.jeg_block_heading_2 .jeg_block_title span,.jeg_block_heading_3,.jeg_block_heading_4 .jeg_block_title span,.jeg_block_heading_6:after,.jeg_pl_lg_box .jeg_post_category a,.jeg_pl_md_box .jeg_post_category a,.jeg_readmore:hover,.jeg_thumb .jeg_post_category a,.jeg_block_loadmore a:hover, .jeg_postblock.alt .jeg_block_loadmore a:hover,.jeg_block_loadmore a.active,.jeg_postblock_carousel_2 .jeg_post_category a,.jeg_heroblock .jeg_post_category a,.jeg_pagenav_1 .page_number.active,.jeg_pagenav_1 .page_number.active:hover,input[type="submit"],.btn,.button,.widget_tag_cloud a:hover,.popularpost_item:hover .jeg_post_title a:before,.jeg_splitpost_4 .page_nav,.jeg_splitpost_5 .page_nav,.jeg_post_tags a:hover,.comment-reply-title small a:before,.comment-reply-title small a:after,.jeg_storelist .productlink,.authorlink li.active a:before,.jeg_footer.dark .socials_widget:not(.nobg) a:hover .fa,.jeg_breakingnews_title,.jeg_overlay_slider_bottom.owl-carousel .owl-nav div,.jeg_overlay_slider_bottom.owl-carousel .owl-nav div:hover,.jeg_vertical_playlist .jeg_video_playlist_current,.woocommerce span.onsale,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.jeg_popup_post .caption,.jeg_footer.dark input[type="submit"],.jeg_footer.dark .btn,.jeg_footer.dark .button,.footer_widget.widget_tag_cloud a:hover',
                    'property'      => 'background-color',
                ),
                array(
                    /* Accent Border Color */
                    'method'        => 'inject-style',
                    'element'       => '.jeg_block_heading_7 .jeg_block_title span, .jeg_readmore:hover, .jeg_block_loadmore a:hover, .jeg_block_loadmore a.active, .jeg_pagenav_1 .page_number.active, .jeg_pagenav_1 .page_number.active:hover, .jeg_pagenav_3 .page_number:hover, .jeg_prevnext_post a:hover h3, .jeg_overlay_slider .jeg_post_category, .jeg_sidefeed .jeg_post.active, .jeg_vertical_playlist.jeg_vertical_playlist .jeg_video_playlist_item.active .jeg_video_playlist_thumbnail img, .jeg_horizontal_playlist .jeg_video_playlist_item.active',
                    'property'      => 'border-color',
                ),
                array(
                    /* Accent Border Color */
                    'method'        => 'inject-style',
                    'element'       => '.jeg_tabpost_nav li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active',
                    'property'      => 'border-bottom-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_alt_color',
            'transport'     => 'postMessage',
            'type'          => 'jnews-color',
            'section'       => $this->section_global_color,
            'default'       => '#2e9fff',
            'label'         => esc_html__('Alternate Color', 'jnews'),
            'description'   => esc_html__('Alternate color including post meta icon & floated social share.', 'jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_post_meta .fa, .entry-header .jeg_post_meta .fa, .jeg_review_stars, .jeg_price_review_list',
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_share_button.share-float.share-monocrhome a',
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_heading_color',
            'transport'     => 'postMessage',
            'type'          => 'jnews-color',
            'section'       => $this->section_global_color,
            'default'       => '#212121',
            'label'         => esc_html__('Heading Color', 'jnews'),
            'description'   => esc_html__('Post title and other heading elements: H1, H2, H3, H4, H5 and H6.', 'jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => 'h1,h2,h3,h4,h5,h6,.jeg_post_title a,.entry-header .jeg_post_title,.jeg_hero_style_7 .jeg_post_title a,.jeg_block_title,.jeg_splitpost_bar .current_title,.jeg_video_playlist_title,.gallery-caption',
                    'property'      => 'color',
                )
            ),
        ));
    }
}