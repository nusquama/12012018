<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Customizer;

use JNews\HeaderBuilder;
use JNews\Util\Cache;

/**
 * Class Theme JNews Customizer
 */
Class HeaderOption extends CustomizerOptionAbstract
{
    // Section Builder
    private $section_header_builder             = 'jnews_header_builder_section';
    private $section_header_block_builder       = 'jnews_header_builder_block_section';

    private $section_desktop_option             = 'jnews_header_desktop_option_section';
    private $section_mobile_option              = 'jnews_header_mobile_option_section';
    private $section_mobile_drawer              = 'jnews_header_drawer_container_section';

    // Section Bar
    private $section_desktop_sticky             = 'jnews_header_desktop_sticky_section';

    // Element
    private $section_logo                       = 'jnews_header_logo_section';
    private $section_menu_topbar                = 'jnews_header_top_bar_menu_section';
    private $section_main_menu                  = 'jnews_header_main_menu_section';
    private $section_social_icon                = 'jnews_header_social_icon_section';
    private $section_date                       = 'jnews_header_date_section';
    private $section_search_icon                = 'jnews_header_search_icon_section';
    private $section_search_form                = 'jnews_header_search_form_section';
    private $section_account                    = 'jnews_header_login_section';
    private $section_nav_icon                   = 'jnews_header_nav_icon_section';
    private $section_cart_icon                  = 'jnews_header_cart_icon_section';
    private $section_cart_detail                = 'jnews_header_cart_detail_section';
    private $section_language_detail            = 'jnews_header_language_section';
    private $section_html                       = 'jnews_header_html_section';
    private $section_button                     = 'jnews_header_button_section';
    private $section_vertical_menu              = 'jnews_header_vertical_menu_section';

    /**
     * Set Section
     */
    public function set_option()
    {
        $this->set_panel();

        // New Header Option
        $this->set_header_builder_field();
        $this->set_header_builder_block_field();

        $this->set_header_desktop_option();
        $this->set_header_desktop_sticky();
        $this->set_header_mobile_option();
        $this->set_header_mobile_drawer_field();

        $this->set_header_logo_field();
        $this->set_header_topbar_field();
        $this->set_header_main_menu_field();
        $this->set_header_social_icon_field();
        $this->set_header_date_field();
        $this->set_header_search_icon_field();
        $this->set_header_search_form_field();
        $this->set_header_account_field();
        $this->set_header_navbar_field();
        $this->set_header_cart_icon_field();
        $this->set_header_cart_detail_field();
        $this->set_header_language_field();
        $this->set_header_html_field();
        $this->set_header_button_field();
        $this->set_header_vertical_menu_field();
    }

    public function refresh_desktop()
    {
        return array (
            'selector'        => '.jeg_header_wrapper',
            'render_callback' => function() {
                get_template_part('fragment/header/desktop-builder');
            },
        );
    }

    public function refresh_mobile()
    {
        return array (
            'selector'        => '.jeg_navbar_mobile_wrapper',
            'render_callback' => function() {
                get_template_part('fragment/header/mobile-builder');
            },
        );
    }

    public function set_panel()
    {
        /** panel */
        $this->customizer->add_panel(array(
            'id'            => 'jnews_header',
            'title'         => esc_html__( 'JNews : Header Option' ,'jnews' ),
            'description'   => esc_html__('JNews Header Option','jnews' ),
            'priority'      => $this->id
        ));
    }

    public function set_header_desktop_option()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_desktop_option,
            'title'         => esc_html__('Header - Desktop Option','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_width',
            'transport'     => 'postMessage',
            'default'       => 'normal',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Desktop Header Width','jnews'),
            'description'   => esc_html__('Choose header container width.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'normal'        => esc_attr__( 'Normal', 'jnews' ),
                'full'          => esc_attr__( 'Fullwidth', 'jnews' )
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_header_wrapper .jeg_header',
                    'property'      => array(
                        'normal'            => 'normal',
                        'full'              => 'full',
                    )
                ),
            )
        ));

        // Setting
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Desktop Header - Topbar ','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_height',
            'transport'     => 'postMessage',
            'default'       => 36,
            'type'          => 'jnews-slider',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Top Bar Height', 'jnews'),
            'choices'     => array(
                'min'  => '20',
                'max'  => '150',
                'step' => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_topbar .jeg_nav_row, .jeg_topbar .jeg_search_no_expand .jeg_search_input',
                    'property'      => 'line-height',
                    'units'         => 'px',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_topbar .jeg_nav_row, .jeg_topbar .jeg_nav_icon',
                    'property'      => 'height',
                    'units'         => 'px',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_scheme',
            'transport'     => 'postMessage',
            'default'       => 'dark',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Top Bar Scheme','jnews'),
            'description'   => esc_html__('Choose your top bar menu scheme.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'normal'        => esc_attr__( 'Normal Style (Light)', 'jnews' ),
                'dark'          => esc_attr__( 'Dark Style', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_topbar',
                    'property'      => array(
                        'normal'            => 'normal',
                        'dark'              => 'dark',
                    )
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Background Color','jnews'),
            'description'   => esc_html__('Top bar background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_topbar, .jeg_topbar.dark, .jeg_topbar.custom',
                    'property'      => 'background',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_border_bottom',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Border Bottom','jnews'),
            'description'   => esc_html__('Top bar border bottom color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_topbar, .jeg_topbar.dark',
                    'property'      => 'border-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_side_border',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Side Border','jnews'),
            'description'   => esc_html__('Top bar side border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_topbar .jeg_nav_item, .jeg_topbar.dark .jeg_nav_item",
                    'property'      => 'border-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Default Text Color','jnews'),
            'description'   => esc_html__('Top bar default text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_topbar, .jeg_topbar.dark",
                    'property'      => 'color',
                )
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_link_color_hover',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Default Link Color','jnews'),
            'description'   => esc_html__('Top bar default link color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_topbar a, .jeg_topbar.dark a',
                    'property'      => 'color',
                )
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_border_top_height',
            'transport'     => 'postMessage',
            'default'       => 0,
            'type'          => 'jnews-slider',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Top Bar Border - Top Height', 'jnews'),
            'description'   => esc_html__('Border height in px.','jnews'),
            'choices'     => array(
                'min'           => '0',
                'max'           => '20',
                'step'          => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_topbar, .jeg_topbar.dark',
                    'property'      => 'border-top-width',
                    'units'         => 'px',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_border_top_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Top Bar Border - Top Color','jnews'),
            'description'   => esc_html__('Top bar border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_topbar, .jeg_topbar.dark',
                    'property'      => 'border-top-color',
                )
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Desktop Header - Middle Bar','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_height',
            'transport'     => 'postMessage',
            'default'       => 130,
            'type'          => 'jnews-slider',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Middle Bar Height', 'jnews'),
            'choices'     => array(
                'min'  => '50',
                'max'  => '350',
                'step' => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_midbar',
                    'property'      => 'height',
                    'units'         => 'px',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_scheme',
            'transport'     => 'postMessage',
            'default'       => 'normal',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Middle Bar Scheme','jnews'),
            'description'   => esc_html__('Choose your middle bar scheme.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'normal'        => esc_attr__( 'Normal Style (Light)', 'jnews' ),
                'dark'          => esc_attr__( 'Dark Style', 'jnews' )
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_midbar',
                    'property'      => array(
                        'normal'            => 'normal',
                        'dark'              => 'dark',
                    )
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_background',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Middle Bar Background Color','jnews'),
            'description'   => esc_html__('Change color of middle bar, you can also use another transparent color for this background.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_midbar, .jeg_midbar.dark',
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_background_image',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'image',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Middle Bar Background Image','jnews' ),
            'description'   => esc_html__('Upload your background image.','jnews' ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_midbar',
                    'property'      => 'background-image',
                    'prefix'        => 'url("',
                    'suffix'        => '")'
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_background_repeat',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Background Repeat', 'jnews'),
            'choices'       => array(
                ''              => '',
                'repeat-x'      => 'Repeat Horizontal',
                'repeat-y'      => 'Repeat Vertical',
                'repeat'        => 'Repeat Image',
                'no-repeat'     => 'No Repeat'
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_midbar',
                    'property'      => 'background-repeat',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_midbar_background_image',
                    'operator' => '!=',
                    'value'    => '',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_background_position',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Background Position', 'jnews'),
            'choices'       => array(
                ''                  => '',
                'left top'         => 'Left Top',
                'left center'       => 'Left Center',
                'left bottom'        => 'Left Bottom',
                'center top'       => 'Center Top',
                'center center'     => 'Center Center',
                'center bottom'      => 'Center Bottom',
                'right top'        => 'Right Top',
                'right center'      => 'Right Center',
                'right bottom'       => 'Right Bottom',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_midbar',
                    'property'      => 'background-position',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_midbar_background_image',
                    'operator' => '!=',
                    'value'    => '',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_background_fixed',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Attachment Background', 'jnews'),
            'choices'       => array(
                ''              => '',
                'fixed'         => 'Fixed',
                'scroll'        => 'Scroll'
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_midbar',
                    'property'      => 'background-attachment',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_midbar_background_image',
                    'operator' => '!=',
                    'value'    => '',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_background_size',
            'transport'     => 'postMessage',
            'default'       => 'inherit',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Background Size', 'jnews'),
            'choices'       => array(
                ''              => '',
                'cover'         => 'Cover',
                'contain'       => 'Contain',
                'initial'       => 'Initial',
                'inherit'       => 'Inherit'
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_midbar',
                    'property'      => 'background-size',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_midbar_background_image',
                    'operator' => '!=',
                    'value'    => '',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_border_bottom_height',
            'transport'     => 'postMessage',
            'default'       => 0,
            'type'          => 'jnews-slider',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Middle Bar Border - Bottom Height', 'jnews'),
            'description'   => esc_html__('Border height in px.','jnews'),
            'choices'     => array(
                'min'           => '0',
                'max'           => '20',
                'step'          => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_midbar, .jeg_midbar.dark',
                    'property'      => 'border-bottom-width',
                    'units'         => 'px',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_midbar_border_bottom_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Middle Bar Border - Bottom Color','jnews'),
            'description'   => esc_html__('Midbar bar border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_midbar, .jeg_midbar.dark',
                    'property'      => 'border-bottom-color',
                )
            ),
        ));



        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mid_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Default Text Color','jnews'),
            'description'   => esc_html__('Middle bar text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_midbar, .jeg_midbar.dark",
                    'property'      => 'color',
                )
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mid_link_color_hover',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Default Link Color','jnews'),
            'description'   => esc_html__('Middle bar link color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_midbar a, .jeg_midbar.dark a',
                    'property'      => 'color',
                )
            ),
        ));


        // Field
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Desktop Header - Bottom Bar','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_height',
            'transport'     => 'postMessage',
            'default'       => 50,
            'type'          => 'jnews-slider',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Bottom Bar Height', 'jnews'),
            'choices'     => array(
                'min'  => '30',
                'max'  => '150',
                'step' => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_bottombar.jeg_navbar,.jeg_bottombar .jeg_nav_icon',
                    'property'      => 'height',
                    'units'         => 'px',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_bottombar.jeg_navbar,
                                        .jeg_header .jeg_bottombar .jeg_main_menu:not(.jeg_menu_style_1) > li > a,
                                        .jeg_header .jeg_bottombar .jeg_menu_style_1 > li,
                                        .jeg_header .jeg_bottombar .jeg_menu:not(.jeg_main_menu) > li > a',
                    'property'      => 'line-height',
                    'units'         => 'px',
                )
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_boxed',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Boxed Navbar','jnews'),
            'description'   => esc_html__('Enable this option and convert nav bar into boxed.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'add-class',
                    'element'       => '.jeg_header .jeg_navbar_wrapper',
                    'property'      => 'jeg_navbar_boxed',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_fitwidth',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Fit Width Navbar','jnews'),
            'description'   => esc_html__('Enable this option and nav bar will have fit width effect.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'add-class',
                    'element'       => '.jeg_header .jeg_navbar_wrapper',
                    'property'      => 'jeg_navbar_fitwidth',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_border',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Navbar Border','jnews'),
            'description'   => esc_html__('Enable this option and nav bar will have border around it.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'add-class',
                    'element'       => '.jeg_header .jeg_navbar_wrapper',
                    'property'      => 'jeg_navbar_menuborder',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_shadow',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Navbar Shadow','jnews'),
            'description'   => esc_html__('Enable this option and nav bar will have shadow around it.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'add-class',
                    'element'       => '.jeg_header .jeg_navbar_wrapper',
                    'property'      => 'jeg_navbar_shadow',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_scheme',
            'transport'     => 'postMessage',
            'default'       => 'jeg_navbar_normal',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Menu Scheme','jnews'),
            'description'   => esc_html__('Choose your menu scheme.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'jeg_navbar_normal'        => esc_attr__( 'Normal Style (Light)', 'jnews' ),
                'jeg_navbar_dark'          => esc_attr__( 'Dark Style', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_header .jeg_navbar_wrapper',
                    'property'      => array(
                        'jeg_navbar_normal'            => 'jeg_navbar_normal',
                        'jeg_navbar_dark'              => 'jeg_navbar_dark',
                    ),
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Bottom Bar Background Color','jnews'),
            'description'   => esc_html__('Bottom bar background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_navbar_wrapper:not(.jeg_navbar_boxed),
                                        .jeg_header .jeg_navbar_boxed .jeg_nav_row",
                    'property'      => 'background',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Border Color','jnews'),
            'description'   => esc_html__('Bottom bar bottom color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_navbar_menuborder .jeg_main_menu > li:not(:last-child),
                                        .jeg_header .jeg_navbar_menuborder .jeg_nav_item, .jeg_navbar_boxed .jeg_nav_row,
                                        .jeg_header .jeg_navbar_menuborder:not(.jeg_navbar_boxed) .jeg_nav_left .jeg_nav_item:first-child",
                    'property'      => 'border-color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Default Text color','jnews'),
            'description'   => esc_html__('Bottom bar text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_bottombar,
                                        .jeg_header .jeg_bottombar.jeg_navbar_dark",
                    'property'      => 'color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_link_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Default Link color','jnews'),
            'description'   => esc_html__('Bottom bar link color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_bottombar a,
                                        .jeg_header .jeg_bottombar.jeg_navbar_dark a",
                    'property'      => 'color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_link_hover_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Default Link Hover color','jnews'),
            'description'   => esc_html__('Bottom bar link hover color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_bottombar a:hover,
                                        .jeg_header .jeg_bottombar.jeg_navbar_dark a:hover,
                                        .jeg_header .jeg_bottombar .jeg_menu:not(.jeg_main_menu) > li > a:hover",
                    'property'      => 'color',
                ),
            ),
        ));



        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_border_top_height',
            'transport'     => 'postMessage',
            'default'       => 0,
            'type'          => 'jnews-slider',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Border Top Height', 'jnews'),
            'choices'     => array(
                'min'           => '0',
                'max'           => '20',
                'step'          => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_bottombar,
                                        .jeg_header .jeg_bottombar.jeg_navbar_dark,
                                        .jeg_navbar_boxed .jeg_nav_row,.jeg_navbar_dark.jeg_navbar_boxed .jeg_nav_row',
                    'property'      => 'border-top-width',
                    'units'         => 'px',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_border_top_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Border Top Color','jnews'),
            'description'   => esc_html__('Bottom Bar border top color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header_wrapper .jeg_bottombar,
                                        .jeg_header_wrapper .jeg_bottombar.jeg_navbar_dark,
                                        .jeg_navbar_boxed .jeg_nav_row,.jeg_navbar_dark.jeg_navbar_boxed .jeg_nav_row',
                    'property'      => 'border-top-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_border_bottom_height',
            'transport'     => 'postMessage',
            'default'       => 1,
            'type'          => 'jnews-slider',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Border Bottom Height', 'jnews'),
            'choices'     => array(
                'min'           => '0',
                'max'           => '20',
                'step'          => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_bottombar,
                                        .jeg_header .jeg_bottombar.jeg_navbar_dark,
                                        .jeg_navbar_boxed .jeg_nav_row,.jeg_navbar_dark.jeg_navbar_boxed .jeg_nav_row',
                    'property'      => 'border-bottom-width',
                    'units'         => 'px',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_bottombar_border_bottom_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_option,
            'label'         => esc_html__('Border Bottom Color','jnews'),
            'description'   => esc_html__('Bottom bar border bottom color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header_wrapper .jeg_bottombar,
                                        .jeg_header_wrapper .jeg_bottombar.jeg_navbar_dark,
                                        .jeg_navbar_boxed .jeg_nav_row,.jeg_navbar_dark.jeg_navbar_boxed .jeg_nav_row',
                    'property'      => 'border-bottom-color',
                )
            ),
        ));

    }

    public function set_header_mobile_option()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_mobile_option,
            'title'         => esc_html__('Header - Mobile Option','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_mobile_menu_follow',
            'transport'     => 'refresh',
            'default'       => 'scroll',
            'type'          => 'jnews-select',
            'section'       => $this->section_mobile_option,
            'label'         => esc_html__('Menu Following Mode','jnews'),
            'description'   => esc_html__('Choose your navbar menu style.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'fixed'         => esc_attr__( 'Always Follow', 'jnews' ),
                'scroll'        => esc_attr__( 'Follow when Scroll Up', 'jnews' ),
                'pinned'        => esc_attr__( 'Show when Scroll', 'jnews' ),
                'normal'        => esc_attr__( 'No follow', 'jnews' ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_midbar_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_mobile_option,
            'label'         => esc_html__('Mobile Header - Middle Bar','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_midbar_scheme',
            'transport'     => 'postMessage',
            'default'       => 'dark',
            'type'          => 'jnews-select',
            'section'       => $this->section_mobile_option,
            'label'         => esc_html__('Middle Bar Scheme','jnews'),
            'description'   => esc_html__('Choose your menu scheme.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'normal'        => esc_attr__( 'Normal Style (Light)', 'jnews' ),
                'dark'          => esc_attr__( 'Dark Style', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_mobile_bottombar',
                    'property'      => array(
                        'normal'            => 'normal',
                        'dark'              => 'dark',
                    ),
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_midbar_height',
            'transport'     => 'postMessage',
            'default'       => 60,
            'type'          => 'jnews-slider',
            'section'       => $this->section_mobile_option,
            'label'         => esc_html__('Middle Bar Height', 'jnews'),
            'choices'     => array(
                'min'  => '30',
                'max'  => '150',
                'step' => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_mobile_bottombar',
                    'property'      => 'height',
                    'units'         => 'px',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_mobile_bottombar',
                    'property'      => 'line-height',
                    'units'         => 'px',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_midbar_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_mobile_option,
            'label'         => esc_html__('Background Color','jnews'),
            'description'   => esc_html__('Set background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_mobile_midbar, .jeg_mobile_midbar.dark",
                    'property'      => 'background',
                ),
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_midbar_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_mobile_option,
            'label'         => esc_html__('Default Text color','jnews'),
            'description'   => esc_html__('Top bar text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_mobile_midbar, .jeg_mobile_midbar.dark",
                    'property'      => 'color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_midbar_link_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_mobile_option,
            'label'         => esc_html__('Default Link color','jnews'),
            'description'   => esc_html__('Middle bar link color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_mobile_midbar a, .jeg_mobile_midbar.dark a",
                    'property'      => 'color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_midbar_border_top_height',
            'transport'     => 'postMessage',
            'default'       => 0,
            'type'          => 'jnews-slider',
            'section'       => $this->section_mobile_option,
            'label'         => esc_html__('Bottom Bar Border Height', 'jnews'),
            'choices'     => array(
                'min'           => '0',
                'max'           => '20',
                'step'          => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_mobile_midbar, .jeg_mobile_midbar.dark',
                    'property'      => 'border-top-width',
                    'units'         => 'px',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_midbar_border_top_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_mobile_option,
            'label'         => esc_html__('Mobile Top Bar Border - Top Color','jnews'),
            'description'   => esc_html__('Mobile top border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_mobile_midbar, .jeg_mobile_midbar.dark',
                    'property'      => 'border-top-color',
                )
            ),
        ));
    }

    public function set_header_builder_field()
    {
        // Section
        $this->customizer->add_section(array(
            'id'            => $this->section_header_builder,
            'title'         => esc_html__('Header - Builder & Layout','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_notice',
            'type'          => 'jnews-alert',
            'default'       => 'warning',
            'section'       => $this->section_header_builder,
            'label'         => esc_html__('Notice','jnews' ),
            'description'   => wp_kses(__(
                '<ul>
                    <li>We will reset all options inside header builder panel when you click one of the starter layout</li>
                    <li>You can modify your header using header builder like normal after choosing header builder layout.</li>
                </ul>',
                'jnews'), wp_kses_allowed_html()),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_layout',
            'transport'     => 'postMessage',
            'default'       => 'jnews_hb_preset',
            'type'          => 'jnews-preset-image',
            'section'       => $this->section_header_builder,
            'label'         => esc_html__('Starter Layout','jnews' ),
            'description'   => esc_html__('Select starter layout of your heading.','jnews' ),
            'choices'       => array(
                '1' => '',
                '2' => '',
                '3' => '',
                '4' => '',
                '5' => '',
                '6' => '',
                '7' => '',
            ),
        ));
    }

    public function set_header_builder_block_field()
    {
        // Section
        $this->customizer->add_section(array(
            'id'            => $this->section_header_block_builder,
            'title'         => esc_html__('Header - Block Builder','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        // Field
        $rows_desktop    = array('top', 'mid', 'bottom');
        $columns_desktop = array('left', 'center', 'right');

        $this->customizer->add_field(array(
            'id'            => "jnews_hb_preset",
            'transport'     => 'refresh',
            'default'       => '',
            'type'          => 'jnews-preset',
            'section'       => $this->section_header_block_builder,
            'label'         => 'Preset',
            'multiple'      => 1,
            'choices'       => $this->header_preset()
        ));

        $this->customizer->add_field(array(
            'id'            => "jnews_hb_arrange_bar",
            'transport'     => 'postMessage',
            'default'       => array('top', 'mid', 'bottom'),
            'type'          => 'jnews-select',
            'section'       => $this->section_header_block_builder,
            'label'         => 'Arrangement',
            'multiple'      => 3,
            'choices'       => array(
                'top'           => esc_attr__( 'Top', 'jnews' ),
                'mid'           => esc_attr__( 'Mid', 'jnews' ),
                'bottom'        => esc_attr__( 'Bottom', 'jnews' ),
            ),
            'partial_refresh' => array (
                'jnews_hb_arrange_bar' => $this->refresh_desktop()
            ),
        ));


        // Column align
        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_align_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_header_block_builder,
            'label'         => esc_html__('Desktop Column Alignment','jnews' ),
        ));

        foreach ($rows_desktop as $row)
        {
            foreach($columns_desktop as $column)
            {
                $this->customizer->add_field(array(
                    'id'            => "jnews_hb_align_desktop_{$row}_{$column}",
                    'transport'     => 'postMessage',
                    'default'       => $column,
                    'type'          => 'jnews-select',
                    'section'       => $this->section_header_block_builder,
                    'label'         => ucfirst($row) . ' ' . ucfirst($column) . ' ' . esc_html__('Align', 'jnews'),
                    'multiple'      => 1,
                    'choices'       => array(
                        'left'          => esc_attr__( 'Left', 'jnews' ),
                        'center'        => esc_attr__( 'Center', 'jnews' ),
                        'right'         => esc_attr__( 'Right', 'jnews' ),
                    ),
                    'output'     => array(
                        array(
                            'method'        => 'class-masking',
                            'element'       => ".jeg_{$row}bar .jeg_nav_{$column} .item_wrap",
                            'property'      => array(
                                'left'          => 'jeg_nav_alignleft',
                                'center'        => 'jeg_nav_aligncenter',
                                'right'         => 'jeg_nav_alignright',
                            ),
                        ),
                    )
                ));
            }
        }

        // Display Setting
        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_display_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_header_block_builder,
            'label'         => esc_html__('Desktop Column Alignment','jnews' ),
        ));

        foreach ($rows_desktop as $row)
        {
            foreach($columns_desktop as $column)
            {
                $this->customizer->add_field(array(
                    'id'            => "jnews_hb_display_desktop_{$row}_{$column}",
                    'transport'     => 'postMessage',
                    'default'       => jnews_header_default("desktop_display_{$row}_{$column}"),
                    'type'          => 'jnews-select',
                    'section'       => $this->section_header_block_builder,
                    'label'         => ucfirst($row) . ' ' . ucfirst($column) . ' ' . esc_html__('Display Type', 'jnews'),
                    'multiple'      => 1,
                    'choices'       => array(
                        'grow'          => esc_attr__( 'Grow', 'jnews' ),
                        'normal'        => esc_attr__( 'Normal', 'jnews' ),
                    ),
                    'output'     => array(
                        array(
                            'method'        => 'class-masking',
                            'element'       => ".jeg_{$row}bar .jeg_nav_{$column}",
                            'property'      => array(
                                'grow'          => 'jeg_nav_grow',
                                'normal'        => 'jeg_nav_normal'
                            ),
                        ),
                    )
                ));
            }
        }

        // Element
        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_element_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_header_block_builder,
            'label'         => esc_html__('Desktop Element','jnews' ),
        ));

        foreach ($rows_desktop as $row)
        {
            foreach($columns_desktop as $column)
            {
                $this->customizer->add_field(array(
                    'id'            => "jnews_hb_element_desktop_{$row}_{$column}",
                    'transport'     => 'postMessage',
                    'default'       => jnews_header_default("desktop_element_{$row}_{$column}"),
                    'type'          => 'jnews-select',
                    'section'       => $this->section_header_block_builder,
                    'label'         => ucfirst($row) . ' ' . ucfirst($column) . ' ' . esc_html__(' Element', 'jnews'),
                    'multiple'      => 100,
                    'choices'       => HeaderBuilder::desktop_header_element(),
                    'partial_refresh' => array (
                        "jnews_hb_element_desktop_{$row}_{$column}" => $this->refresh_desktop()
                    ),
                ));
            }
        }


        /********************************************************************************
         * Mobile Option
         ********************************************************************************/

        $mobile_blocks = array(
            'top'   => array('center'),
            'mid'   => array('left', 'center', 'right'),
        );

        // Align
        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_align_mobile_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_header_block_builder,
            'label'         => esc_html__('Mobile Align','jnews' ),
        ));

        foreach ($mobile_blocks as $row => $columns)
        {
            foreach ($columns as $column)
            {
                $this->customizer->add_field(array(
                    'id'            => "jnews_hb_align_mobile_{$row}_{$column}",
                    'transport'     => 'postMessage',
                    'default'       => $column,
                    'type'          => 'jnews-select',
                    'section'       => $this->section_header_block_builder,
                    'label'         => ucfirst($row) . ' ' . ucfirst($column) . ' ' . esc_html__('Align', 'jnews'),
                    'multiple'      => 1,
                    'choices'       => array(
                        'left'          => esc_attr__( 'Left', 'jnews' ),
                        'center'        => esc_attr__( 'Center', 'jnews' ),
                        'right'         => esc_attr__( 'Right', 'jnews' ),
                    ),
                    'output'     => array(
                        array(
                            'method'        => 'class-masking',
                            'element'       => ".jeg_mobile_{$row}bar .jeg_nav_{$column} .item_wrap",
                            'property'      => array(
                                'left'          => 'jeg_nav_alignleft',
                                'center'        => 'jeg_nav_aligncenter',
                                'right'         => 'jeg_nav_alignright',
                            ),
                        ),
                    )
                ));
            }
        }

        // Display
        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_display_mobile_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_header_block_builder,
            'label'         => esc_html__('Mobile Display','jnews' ),
        ));

        foreach ($mobile_blocks as $row => $columns)
        {
            foreach ($columns as $column)
            {
                $this->customizer->add_field(array(
                    'id'            => "jnews_hb_display_mobile_{$row}_{$column}",
                    'transport'     => 'postMessage',
                    'default'       => jnews_header_default("mobile_display_{$row}_{$column}"),
                    'type'          => 'jnews-select',
                    'section'       => $this->section_header_block_builder,
                    'label'         => ucfirst($row) . ' ' . ucfirst($column) . ' ' . esc_html__('Display Type', 'jnews'),
                    'multiple'      => 1,
                    'choices'       => array(
                        'grow'          => esc_attr__( 'Grow', 'jnews' ),
                        'normal'        => esc_attr__( 'Normal', 'jnews' ),
                    ),
                    'output'     => array(
                        array(
                            'method'        => 'class-masking',
                            'element'       => ".jeg_mobile_{$row}bar .jeg_nav_{$column}",
                            'property'      => array(
                                'grow'          => 'jeg_nav_grow',
                                'normal'        => 'jeg_nav_normal'
                            ),
                        ),
                    )
                ));
            }
        }

        // Element
        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_element_mobile_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_header_block_builder,
            'label'         => esc_html__('Mobile Element','jnews' ),
        ));

        foreach ($mobile_blocks as $row => $columns)
        {
            foreach ($columns as $column)
            {
                $this->customizer->add_field(array(
                    'id'            => "jnews_hb_element_mobile_{$row}_{$column}",
                    'transport'     => 'postMessage',
                    'default'       => jnews_header_default("mobile_element_{$row}_{$column}"),
                    'type'          => 'jnews-select',
                    'section'       => $this->section_header_block_builder,
                    'label'         => ucfirst($row) . ' ' . ucfirst($column) . ' ' . esc_html__(' Element', 'jnews'),
                    'multiple'      => 100,
                    'choices'       => HeaderBuilder::mobile_header_element(),
                    'partial_refresh' => array (
                        "jnews_hb_element_mobile_{$row}_{$column}" => $this->refresh_mobile()
                    ),
                ));
            }
        }

        /********************************************************************************
         * Desktop Sticky Option
         ********************************************************************************/

        $desktop_sticky_blocks = array(
            'mid'   => array('left', 'center', 'right'),
        );

        // Align
        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_align_desktop_sticky_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_header_block_builder,
            'label'         => esc_html__('Desktop Sticky Align','jnews' ),
        ));

        foreach ($desktop_sticky_blocks as $row => $columns)
        {
            foreach ($columns as $column)
            {
                $this->customizer->add_field(array(
                    'id'            => "jnews_hb_align_desktop_sticky_{$row}_{$column}",
                    'transport'     => 'postMessage',
                    'default'       => $column,
                    'type'          => 'jnews-select',
                    'section'       => $this->section_header_block_builder,
                    'label'         => ucfirst($row) . ' ' . ucfirst($column) . ' ' . esc_html__('Align', 'jnews'),
                    'multiple'      => 1,
                    'choices'       => array(
                        'left'          => esc_attr__( 'Left', 'jnews' ),
                        'center'        => esc_attr__( 'Center', 'jnews' ),
                        'right'         => esc_attr__( 'Right', 'jnews' ),
                    ),

                    'output'     => array(
                        array(
                            'method'        => 'class-masking',
                            'element'       => ".jeg_stickybar .jeg_nav_{$column} .item_wrap",
                            'property'      => array(
                                'left'          => 'jeg_nav_alignleft',
                                'center'        => 'jeg_nav_aligncenter',
                                'right'         => 'jeg_nav_alignright',
                            ),
                        ),
                    )
                ));
            }
        }

        // Display
        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_display_desktop_sticky_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_header_block_builder,
            'label'         => esc_html__('Desktop Sticky Display','jnews' ),
        ));

        foreach ($desktop_sticky_blocks as $row => $columns)
        {
            foreach ($columns as $column)
            {
                $this->customizer->add_field(array(
                    'id'            => "jnews_hb_display_desktop_sticky_{$row}_{$column}",
                    'transport'     => 'postMessage',
                    'default'       => jnews_header_default("sticky_display_{$row}_{$column}"),
                    'type'          => 'jnews-select',
                    'section'       => $this->section_header_block_builder,
                    'label'         => ucfirst($row) . ' ' . ucfirst($column) . ' ' . esc_html__('Display Type', 'jnews'),
                    'multiple'      => 1,
                    'choices'       => array(
                        'grow'          => esc_attr__( 'Grow', 'jnews' ),
                        'normal'        => esc_attr__( 'Normal', 'jnews' ),
                    ),
                    'output'     => array(
                        array(
                            'method'        => 'class-masking',
                            'element'       => ".jeg_stickybar .jeg_nav_{$column}",
                            'property'      => array(
                                'grow'          => 'jeg_nav_grow',
                                'normal'        => 'jeg_nav_normal'
                            ),
                        ),
                    )
                ));
            }
        }

        // Element
        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_element_desktop_sticky_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_header_block_builder,
            'label'         => esc_html__('Sticky Display Element','jnews' ),
        ));

        foreach ($desktop_sticky_blocks as $row => $columns)
        {
            foreach ($columns as $column)
            {
                $this->customizer->add_field(array(
                    'id'            => "jnews_hb_element_desktop_sticky_{$row}_{$column}",
                    'transport'     => 'postMessage',
                    'default'       => jnews_header_default("sticky_element_{$row}_{$column}"),
                    'type'          => 'jnews-select',
                    'section'       => $this->section_header_block_builder,
                    'label'         => ucfirst($row) . ' ' . ucfirst($column) . ' ' . esc_html__(' Element', 'jnews'),
                    'multiple'      => 100,
                    'choices'       => HeaderBuilder::desktop_header_element(),
                    'partial_refresh' => array (
                        "jnews_hb_element_desktop_sticky_{$column}" => array (
                            'selector'        => '.jeg_stickybar',
                            'render_callback' => function() {
                                get_template_part('fragment/header/desktop-sticky');
                            },
                        )
                    ),
                ));
            }
        }

        /**
         * Mobile Drawer
         */
        $mobile_drawer_block = array(
            'top'       => array('center'),
            'bottom'    => array('center'),
        );

        $this->customizer->add_field(array(
            'id'            => 'jnews_hb_mobile_drawer_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_header_block_builder,
            'label'         => esc_html__('Mobile Drawer Element','jnews' ),
        ));

        foreach ($mobile_drawer_block as $row => $columns)
        {
            foreach ($columns as $column)
            {
                $this->customizer->add_field(array(
                    'id'            => "jnews_hb_element_mobile_drawer_{$row}_{$column}",
                    'transport'     => 'postMessage',
                    'default'       => jnews_header_default("drawer_element_{$row}"),
                    'type'          => 'jnews-select',
                    'section'       => $this->section_header_block_builder,
                    'label'         => ucfirst($row) . ' ' . ucfirst($column) . ' ' . esc_html__(' Element', 'jnews'),
                    'multiple'      => 100,
                    'choices'       => HeaderBuilder::mobile_drawer_element(),
                    'partial_refresh' => array (
                        "jnews_hb_element_mobile_drawer_{$row}_{$column}" => array (
                            'selector'        => '.jeg_mobile_wrapper',
                            'render_callback' => function() {
                                get_template_part('fragment/header/mobile-menu-content');
                            },
                        )
                    ),
                ));
            }
        }
    }

    /**
     * Social Field
     */
    public function set_header_social_icon_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_social_icon,
            'title'         => esc_html__('Header - Social Icon','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_social_desktop',
            'type'          => 'jnews-header',
            'section'       => $this->section_social_icon,
            'label'         => esc_html__('Social - Desktop Header','jnews')
        ));

        $this->customizer->add_field(array(
            'id'            => "jnews_header_social_icon",
            'transport'     => 'postMessage',
            'default'       => 'nobg',
            'type'          => 'jnews-select',
            'section'       => $this->section_social_icon,
            'label'         => 'Social Icon Type',
            'multiple'      => 1,
            'choices'       => array(
                'square'        => esc_attr__( 'Square', 'jnews' ),
                'rounded'       => esc_attr__( 'Rounded', 'jnews' ),
                'circle'        => esc_attr__( 'Circle', 'jnews' ),
                'nobg'          => esc_attr__( 'No Background', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_header .jeg_social_icon_block',
                    'property'      => array(
                        'square'        => 'square',
                        'rounded'       => 'rounded',
                        'circle'        => 'circle',
                        'nobg'          => 'nobg',
                    ),
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_social_icon_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_social_icon,
            'label'         => esc_html__('Icon Color','jnews'),
            'description'   => esc_html__('Social icon text color.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .socials_widget > a > i.fa:before',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_social_icon_background',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_social_icon,
            'label'         => esc_html__('Background Color','jnews'),
            'description'   => esc_html__('Social icon background.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .socials_widget > a > i.fa',
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_social_mobile_drawer',
            'type'          => 'jnews-header',
            'section'       => $this->section_social_icon,
            'label'         => esc_html__('Social - Mobile Drawer','jnews')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_drawer_social_icon_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_social_icon,
            'label'         => esc_html__('Icon Color','jnews'),
            'description'   => esc_html__('Social icon text color.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_aside_item.socials_widget > a > i.fa:before',
                    'property'      => 'color',
                )
            ),
        ));
    }

    public function set_header_date_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_date,
            'title'         => esc_html__('Header - Date','jnews'),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_date_format',
            'transport'     => 'postMessage',
            'default'       => 'l, F j, Y',
            'type'          => 'text',
            'section'       => $this->section_date,
            'label'         => esc_html__('Date format for Header','jnews'),
            'description'   => wp_kses(sprintf(__("Please set your date format for header, for more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codec</a>.", "jnews"), "https://developer.wordpress.org/reference/functions/current_time/"),
                wp_kses_allowed_html()),
            'partial_refresh' => array (
                'jnews_header_date_format' => array (
                    'selector'        => '.jeg_top_date',
                    'render_callback' => function() {
                        return date_i18n( get_theme_mod('jnews_header_date_format', 'l, F j, Y') );
                    },
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_date_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_date,
            'label'         => esc_html__('Text Color','jnews'),
            'description'   => esc_html__('Date text color.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_date',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_date_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_date,
            'label'         => esc_html__('Background Color','jnews'),
            'description'   => esc_html__('Date background color.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_date',
                    'property'      => 'background',
                )
            ),
        ));
    }

    public function set_header_button_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_button,
            'title'         => esc_html__('Header - Button Element','jnews'),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        for($i = 1; $i <= 3; $i++)
        {
            $partial_refresh = array (
                'selector'        => '.jeg_button_' . $i,
                'render_callback' => function() use ($i) {
                    jnews_create_button($i);
                },
            );

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_button_' . $i,
                'type'          => 'jnews-header',
                'section'       => $this->section_button,
                'label'         => esc_html__('Button','jnews' ) . ' ' . $i,
            ));


            $this->customizer->add_field(array(
                'id'            => 'jnews_header_button_' . $i . '_text',
                'transport'     => 'postMessage',
                'default'       => 'Your text',
                'type'          => 'text',
                'section'       => $this->section_button,
                'label'         => esc_html__('Button Text', 'jnews'),
                'partial_refresh' => array (
                    'jnews_header_button_' . $i . '_text' => $partial_refresh
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_button_' . $i . '_icon',
                'transport'     => 'postMessage',
                'default'       => 'fa fa-envelope',
                'type'          => 'text',
                'section'       => $this->section_button,
                'label'         => esc_html__('Font Icon Class', 'jnews'),
                'partial_refresh' => array (
                    'jnews_header_button_' . $i . '_icon' => $partial_refresh
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_button_' . $i . '_link',
                'transport'     => 'postMessage',
                'default'       => '#',
                'type'          => 'text',
                'section'       => $this->section_button,
                'label'         => esc_html__('Button Link', 'jnews'),
                'partial_refresh' => array (
                    'jnews_header_button_' . $i . '_link' => $partial_refresh
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_button_' . $i . '_target',
                'transport'     => 'postMessage',
                'default'       => '_blank',
                'type'          => 'jnews-select',
                'section'       => $this->section_button,
                'label'         => esc_html__('Link Target', 'jnews'),
                'choices'       => array(
                    '_blank'        => esc_attr__( 'Blank', 'jnews' ),
                    '_self'         => esc_attr__( 'Self', 'jnews' ),
                    '_parent'       => esc_attr__( 'Parent', 'jnews' ),
                ),
                'partial_refresh' => array (
                    'jnews_header_button_' . $i . '_target' => $partial_refresh
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_button_' . $i . '_form',
                'transport'     => 'postMessage',
                'default'       => 'default',
                'type'          => 'jnews-radio-buttonset',
                'section'       => $this->section_button,
                'label'         => esc_html__('Button Style','jnews'),
                'description'   => esc_html__('Choose button style.','jnews'),
                'choices'     => array(
                    'default'   => esc_attr__( 'Default', 'jnews' ),
                    'round' => esc_attr__( 'Round', 'jnews' ),
                    'outline'  => esc_attr__( 'Outline', 'jnews' ),
                ),
                'partial_refresh' => array (
                    'jnews_header_button_' . $i . '_form' => $partial_refresh
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_button_' . $i . '_background_color',
                'transport'     => 'postMessage',
                'default'       => '',
                'type'          => 'jnews-color',
                'section'       => $this->section_button,
                'label'         => esc_html__('Background Color','jnews'),
                'description'   => esc_html__('Background color.','jnews'),
                'output'     => array(
                    array(
                        'method'        => 'inject-style',
                        'element'       => '.jeg_button_' . $i . ' .btn',
                        'property'      => 'background',
                    )
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_button_' . $i . '_background_hover_color',
                'transport'     => 'postMessage',
                'default'       => '',
                'type'          => 'jnews-color',
                'section'       => $this->section_button,
                'label'         => esc_html__('Background Hover Color','jnews'),
                'description'   => esc_html__('Background hover color.','jnews'),
                'output'     => array(
                    array(
                        'method'        => 'inject-style',
                        'element'       => '.jeg_button_' . $i . ' .btn:hover',
                        'property'      => 'background',
                    )
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_button_' . $i . '_text_color',
                'transport'     => 'postMessage',
                'default'       => '',
                'type'          => 'jnews-color',
                'section'       => $this->section_button,
                'label'         => esc_html__('Text Color','jnews'),
                'description'   => esc_html__('Text color.','jnews'),
                'output'     => array(
                    array(
                        'method'        => 'inject-style',
                        'element'       => '.jeg_button_' . $i . ' .btn',
                        'property'      => 'color',
                    )
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_button_' . $i . '_border_color',
                'transport'     => 'postMessage',
                'default'       => '',
                'type'          => 'jnews-color',
                'section'       => $this->section_button,
                'label'         => esc_html__('Border Color','jnews'),
                'description'   => esc_html__('Button border color.','jnews'),
                'output'     => array(
                    array(
                        'method'        => 'inject-style',
                        'element'       => '.jeg_button_' . $i . ' .btn',
                        'property'      => 'border-color',
                    )
                ),
            ));
        }
    }

    public function set_header_vertical_menu_field()
    {
        $menu_list = array();
        $menu_list[] = esc_html__('Select menu', 'jnews');

        if($menus = Cache::get_menu())
        {
            foreach($menus as $menu) $menu_list[$menu->slug] = $menu->name;
        }

        $this->customizer->add_section(array(
            'id'            => $this->section_vertical_menu,
            'title'         => esc_html__('Header - Vertical Menu','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        for($i = 1; $i <= 4; $i++)
        {
            $this->customizer->add_field(array(
                'id'            => 'jnews_header_vertical_menu_header_' . $i,
                'type'          => 'jnews-header',
                'section'       => $this->section_vertical_menu,
                'label'         => esc_html__('Vertical Menu ','jnews' ) . $i,
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_vertical_menu_' . $i,
                'transport'     => 'postMessage',
                'default'       => '',
                'type'          => 'jnews-select',
                'section'       => $this->section_vertical_menu,
                'label'         => esc_html__('Choose Vertical Menu ','jnews'),
                'description'   => esc_html__('Choose menu for your vertical menu.','jnews'),
                'multiple'      => 1,
                'choices'       => $menu_list,
                'partial_refresh' => array (
                    'jnews_header_vertical_menu' . $i => $this->refresh_desktop()
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_vertical_menu_border_height_' . $i,
                'transport'     => 'postMessage',
                'default'       => 6,
                'type'          => 'jnews-slider',
                'section'       => $this->section_vertical_menu,
                'label'         => esc_html__('Top Bar Border Top Height', 'jnews'),
                'description'   => esc_html__('Border height in px.','jnews'),
                'choices'     => array(
                    'min'           => '0',
                    'max'           => '20',
                    'step'          => '1',
                ),
                'output'     => array(
                    array(
                        'method'        => 'inject-style',
                        'element'       => ".jeg_header .jeg_vertical_menu.jeg_vertical_menu_{$i}",
                        'property'      => 'border-top-width',
                        'units'         => 'px',
                    ),
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_vertical_menu_border_color_' . $i,
                'transport'     => 'postMessage',
                'default'       => '',
                'type'          => 'jnews-color',
                'section'       => $this->section_vertical_menu,
                'label'         => esc_html__('Top Bar Border Top Color','jnews'),
                'description'   => esc_html__('Top bar border color.','jnews'),
                'choices'     => array(
                    'alpha'         => true,
                ),
                'output'     => array(
                    array(
                        'method'        => 'inject-style',
                        'element'       => ".jeg_header .jeg_vertical_menu.jeg_vertical_menu_{$i}",
                        'property'      => 'border-top-color',
                    )
                ),
            ));

            $this->customizer->add_field(array(
                'id'            => 'jnews_header_vertical_menu_link_color_' . $i,
                'transport'     => 'postMessage',
                'default'       => '',
                'type'          => 'jnews-color',
                'section'       => $this->section_vertical_menu,
                'label'         => esc_html__('Link color','jnews'),
                'description'   => esc_html__('Link color for vertical menu.','jnews'),
                'choices'     => array(
                    'alpha'         => true,
                ),
                'output'     => array(
                    array(
                        'method'        => 'inject-style',
                        'element'       => ".jeg_header .jeg_vertical_menu.jeg_vertical_menu_{$i} a",
                        'property'      => 'border-top-color',
                    )
                ),
            ));
        }

    }

    public function set_header_html_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_html,
            'title'         => esc_html__('Header - HTML Element','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_html_mobile',
            'transport'     => 'postMessage',
            'sanitize'      => 'jnews_sanitize_by_pass',
            'default'       => '',
            'type'          => 'textarea',
            'section'       => $this->section_html,
            'label'         => esc_html__('Mobile HTML','jnews'),
            'description'   => esc_html__('HTML / Shortcode element.','jnews'),
            'partial_refresh' => array (
                'jnews_header_html_mobile' => $this->refresh_mobile()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_html_1',
            'transport'     => 'postMessage',
            'sanitize'      => 'jnews_sanitize_by_pass',
            'default'       => '',
            'type'          => 'textarea',
            'section'       => $this->section_html,
            'label'         => esc_html__('HTML Element 1','jnews'),
            'description'   => esc_html__('HTML / Shortcode element.','jnews'),
            'partial_refresh' => array (
                'jnews_header_html_1' => $this->refresh_desktop()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_html_2',
            'transport'     => 'postMessage',
            'sanitize'      => 'jnews_sanitize_by_pass',
            'default'       => '',
            'type'          => 'textarea',
            'section'       => $this->section_html,
            'label'         => esc_html__('HTML Element 2','jnews'),
            'description'   => esc_html__('HTML / Shortcode element.','jnews'),
            'partial_refresh' => array (
                'jnews_header_html_2' => $this->refresh_desktop()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_html_3',
            'transport'     => 'postMessage',
            'sanitize'      => 'jnews_sanitize_by_pass',
            'default'       => '',
            'type'          => 'textarea',
            'section'       => $this->section_html,
            'label'         => esc_html__('HTML Element 3','jnews'),
            'description'   => esc_html__('HTML / Shortcode element.','jnews'),
            'partial_refresh' => array (
                'jnews_header_html_3' => $this->refresh_desktop()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_html_4',
            'transport'     => 'postMessage',
            'sanitize'      => 'jnews_sanitize_by_pass',
            'default'       => '',
            'type'          => 'textarea',
            'section'       => $this->section_html,
            'label'         => esc_html__('HTML Element 4','jnews'),
            'description'   => esc_html__('HTML / Shortcode element.','jnews'),
            'partial_refresh' => array (
                'jnews_header_html_4' => $this->refresh_desktop()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_html_5',
            'transport'     => 'postMessage',
            'sanitize'      => 'jnews_sanitize_by_pass',
            'default'       => '',
            'type'          => 'textarea',
            'section'       => $this->section_html,
            'label'         => esc_html__('HTML Element 5','jnews'),
            'description'   => esc_html__('HTML / Shortcode element.','jnews'),
            'partial_refresh' => array (
                'jnews_header_html_5' => $this->refresh_desktop()
            ),
        ));
    }

    public function set_header_language_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_language_detail,
            'title'         => esc_html__('Header - Language Switcher','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_language_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_language_detail,
            'label'         => esc_html__('Text Color','jnews'),
            'description'   => esc_html__('Language text color.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_lang_switcher',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_language_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_language_detail,
            'label'         => esc_html__('Background Color','jnews'),
            'description'   => esc_html__('Language background color.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_lang_switcher',
                    'property'      => 'background',
                )
            ),
        ));
    }

    public function set_header_navbar_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_nav_icon,
            'title'         => esc_html__('Header - Navigation Icon','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_nav_icon_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_nav_icon,
            'label'         => esc_html__('Desktop Navigation Icon Color','jnews'),
            'description'   => esc_html__('Desktop nav icon color.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_nav_icon .jeg_mobile_toggle.toggle_btn',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_nav_icon_mobilcolor',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_nav_icon,
            'label'         => esc_html__('Mobile Navigation Icon Color','jnews'),
            'description'   => esc_html__('Mobile nav icon color.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_navbar_mobile_wrapper .jeg_nav_item a.jeg_mobile_toggle,
                                        .jeg_navbar_mobile_wrapper .dark .jeg_nav_item a.jeg_mobile_toggle',
                    'property'      => 'color',
                )
            ),
        ));
    }

    public function set_header_cart_detail_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_cart_detail,
            'title'         => esc_html__('Header - Cart Detail','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Cart Icon Color','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.cartdetail.woocommerce .jeg_carticon',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_text_price_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Cart Text Color','jnews'),
            'description'   => esc_html__('cart text color','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.cartdetail.woocommerce .cartlink',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_drop_style',
            'type'          => 'jnews-header',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Cart Drop Style','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Cart Drop Background Color','jnews'),
            'description'   => esc_html__('Cart drop content background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_cart.cartdetail .jeg_cartcontent",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Cart Drop Text Color','jnews'),
            'description'   => esc_html__('Cart drop text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".cartdetail.woocommerce ul.cart_list li a,
                                        .cartdetail.woocommerce ul.product_list_widget li a,
                                        .cartdetail.woocommerce .widget_shopping_cart_content .total",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_product_quantity_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Product Quantity Text Color','jnews'),
            'description'   => esc_html__('Product quantity text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".cartdetail.woocommerce .cart_list .quantity,
                                        .cartdetail.woocommerce .product_list_widget .quantity",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Cart Drop Border Color','jnews'),
            'description'   => esc_html__('Cart drop border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".cartdetail.woocommerce .widget_shopping_cart_content .total",
                    'property'      => 'border-top-color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => ".cartdetail.woocommerce .widget_shopping_cart_content .total",
                    'property'      => 'border-bottom-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_button_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Cart Drop Button Background Color','jnews'),
            'description'   => esc_html__('Cart drop button background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".cartdetail.woocommerce .widget_shopping_cart_content .button",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_button_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Cart Drop Button Text Color','jnews'),
            'description'   => esc_html__('Cart drop button text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".cartdetail.woocommerce a.button",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_button_bg_hover_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Cart Drop Button Background Hover Color','jnews'),
            'description'   => esc_html__('Cart drop button background hover color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".cartdetail.woocommerce a.button:hover",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_detail_button_text_hover_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_detail,
            'label'         => esc_html__('Cart Drop Button Text Hover Color','jnews'),
            'description'   => esc_html__('Cart drop button text hover color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".cartdetail.woocommerce a.button:hover",
                    'property'      => 'color',
                )
            ),
        ));
    }

    public function set_header_cart_icon_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_cart_icon,
            'title'         => esc_html__('Header - Cart Icon','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_icon_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_icon,
            'label'         => esc_html__('Cart Icon Color','jnews'),
            'description'   => esc_html__('Cart icon color.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_cart_icon.woocommerce .jeg_carticon',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_icon_drop_style',
            'type'          => 'jnews-header',
            'section'       => $this->section_cart_icon,
            'label'         => esc_html__('Cart Drop Style','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_icon_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_icon,
            'label'         => esc_html__('Cart Background Color','jnews'),
            'description'   => esc_html__('Cart drop content background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_cart_icon .jeg_cartcontent",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_icon_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_icon,
            'label'         => esc_html__('Cart Text Color','jnews'),
            'description'   => esc_html__('Cart drop text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_cart_icon.woocommerce ul.cart_list li a,
                                        .jeg_cart_icon.woocommerce ul.product_list_widget li a,
                                        .jeg_cart_icon.woocommerce .widget_shopping_cart_content .total",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_icon_product_quantity_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_icon,
            'label'         => esc_html__('Product Quantity Color','jnews'),
            'description'   => esc_html__('Product quantity text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_cart_icon.woocommerce .cart_list .quantity,
                                        .jeg_cart_icon.woocommerce .product_list_widget .quantity",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_icon_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_icon,
            'label'         => esc_html__('Cart Border Color','jnews'),
            'description'   => esc_html__('Cart drop border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_cart_icon.woocommerce .widget_shopping_cart_content .total",
                    'property'      => 'border-top-color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_cart_icon.woocommerce .widget_shopping_cart_content .total",
                    'property'      => 'border-bottom-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_icon_button_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_icon,
            'label'         => esc_html__('Cart Button Background Color','jnews'),
            'description'   => esc_html__('Cart drop button background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_cart_icon.woocommerce .widget_shopping_cart_content .button",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_icon_button_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_icon,
            'label'         => esc_html__('Cart Button Color','jnews'),
            'description'   => esc_html__('Cart drop button text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_cart_icon.woocommerce a.button",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_icon_button_bg_hover_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_icon,
            'label'         => esc_html__('Cart Button Background Hover Color','jnews'),
            'description'   => esc_html__('Cart drop button background hover color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_cart_icon.woocommerce a.button:hover",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_cart_icon_button_text_hover_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_cart_icon,
            'label'         => esc_html__('Cart Button Hover Color','jnews'),
            'description'   => esc_html__('Cart drop button text hover color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_cart_icon.woocommerce a.button:hover",
                    'property'      => 'color',
                )
            ),
        ));
    }

    public function set_header_account_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_account,
            'title'         => esc_html__('Header - Account','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_account_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_account,
            'label'         => esc_html__('Text Color','jnews'),
            'description'   => esc_html__('Account text color.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_nav_account,
                                        .jeg_navbar .jeg_nav_account .jeg_menu > li > a,
                                        .jeg_midbar .jeg_nav_account .jeg_menu > li > a',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_account_submenu_background',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_account,
            'label'         => esc_html__('Submenu Background','jnews'),
            'description'   => esc_html__('Top bar submenu background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_menu.jeg_accountlink li > ul",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_account_submenu_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_account,
            'label'         => esc_html__('Submenu Text Color','jnews'),
            'description'   => esc_html__('Top bar submenu text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_menu.jeg_accountlink li > ul,
                                        .jeg_menu.jeg_accountlink li > ul li > a,
	                                    .jeg_menu.jeg_accountlink li > ul li:hover > a,
	                                    .jeg_menu.jeg_accountlink li > ul li.sfHover > a",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_account_submenu_background_hover_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_account,
            'label'         => esc_html__('Submenu Background Hover Color','jnews'),
            'description'   => esc_html__('Top bar menu background hover color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_menu.jeg_accountlink li > ul li:hover > a,
                                        .jeg_menu.jeg_accountlink li > ul li.sfHover > a",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_account_submenu_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_account,
            'label'         => esc_html__('Submenu Border Color','jnews'),
            'description'   => esc_html__('Top bar submenu border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_menu.jeg_accountlink li > ul,
                                        .jeg_menu.jeg_accountlink li > ul li a",
                    'property'      => 'border-color',
                )
            ),
        ));
    }

    public function set_header_search_icon_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_search_icon,
            'title'         => esc_html__('Header - Search Icon','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_icon',
            'type'          => 'jnews-header',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Desktop - Search Icon','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_style',
            'transport'     => 'postMessage',
            'default'       => 'jeg_search_popup_expand',
            'type'          => 'jnews-select',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Style','jnews'),
            'description'   => esc_html__('Choose your navbar search style.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'jeg_search_modal_expand'       => esc_attr__( 'Modal Expand', 'jnews' ),
                'jeg_search_popup_expand'       => esc_attr__( 'Popup Expand', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_header .jeg_search_wrapper.search_icon',
                    'property'      => array(
                        'jeg_search_modal_expand'               => 'jeg_search_modal_expand',
                        'jeg_search_popup_expand'               => 'jeg_search_popup_expand',
                    ),
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_icon_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Icon Color','jnews'),
            'description'   => esc_html__('Set color of search icon.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_wrapper.search_icon .jeg_search_toggle',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_style',
            'type'          => 'jnews-header',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Desktop - Popup Drop Style','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Background Color','jnews'),
            'description'   => esc_html__('Set search header background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_wrapper.jeg_search_popup_expand .jeg_search_form,
                                        .jeg_header .jeg_search_popup_expand .jeg_search_result',
                    'property'      => 'background',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_expanded .jeg_search_popup_expand .jeg_search_form:before',
                    'property'      => 'border-bottom-color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Border Color','jnews'),
            'description'   => esc_html__('Set search outer border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_wrapper.jeg_search_popup_expand .jeg_search_form,
                                        .jeg_header .jeg_search_popup_expand .jeg_search_result,
                                        .jeg_header .jeg_search_popup_expand .jeg_search_result .search-noresult,
                                        .jeg_header .jeg_search_popup_expand .jeg_search_result .search-all-button',
                    'property'      => 'border-color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_expanded .jeg_search_popup_expand .jeg_search_form:after',
                    'property'      => 'border-bottom-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_input_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Input Background Color','jnews'),
            'description'   => esc_html__('Set search input background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_wrapper.jeg_search_popup_expand .jeg_search_form .jeg_search_input',
                    'property'      => 'background',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_input_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Input Border Color','jnews'),
            'description'   => esc_html__('Set search input border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_wrapper.jeg_search_popup_expand .jeg_search_form .jeg_search_input',
                    'property'      => 'border-color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_icon_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Icon Color','jnews'),
            'description'   => esc_html__('Set search icon color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_popup_expand .jeg_search_form .jeg_search_button",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_input_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Input Text Color','jnews'),
            'description'   => esc_html__('Set search input text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_wrapper.jeg_search_popup_expand .jeg_search_form .jeg_search_input,
                                        .jeg_header .jeg_search_popup_expand .jeg_search_result a,
                                        .jeg_header .jeg_search_popup_expand .jeg_search_result .search-link",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_placeholder_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Placeholder Color','jnews'),
            'description'   => esc_html__('Set search placeholder color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_popup_expand .jeg_search_form .jeg_search_input::-webkit-input-placeholder",
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_popup_expand .jeg_search_form .jeg_search_input:-moz-placeholder",
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_popup_expand .jeg_search_form .jeg_search_input::-moz-placeholder",
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_popup_expand .jeg_search_form .jeg_search_input:-ms-input-placeholder",
                    'property'      => 'color',
                )
            ),
        ));

        /* live search result */
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_result_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Desktop - Live Results','jnews' ),
        ));
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_result_input_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Background Color','jnews'),
            'description'   => esc_html__('Live search results background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_popup_expand .jeg_search_result',
                    'property'      => 'background-color',
                )
            ),
        ));
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_result_input_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Border Color','jnews'),
            'description'   => esc_html__('Live search results border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_popup_expand .jeg_search_result,
                                        .jeg_header .jeg_search_popup_expand .jeg_search_result .search-link',
                    'property'      => 'border-color',
                )
            ),
        ));
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_popup_result_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Text Color','jnews'),
            'description'   => esc_html__('Live search results text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_popup_expand .jeg_search_result a,
                                        .jeg_header .jeg_search_popup_expand .jeg_search_result .search-link",
                    'property'      => 'color',
                )
            ),
        ));



        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_modal_style',
            'type'          => 'jnews-header',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Desktop - Modal Style','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_modal_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Modal Color','jnews'),
            'description'   => esc_html__('Search modal color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_expanded .jeg_search_modal_expand .jeg_search_toggle i,
                                        .jeg_header .jeg_search_expanded .jeg_search_modal_expand .jeg_search_button,
                                        .jeg_header .jeg_search_expanded .jeg_search_modal_expand .jeg_search_input",
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_expanded .jeg_search_modal_expand .jeg_search_input",
                    'property'      => 'border-bottom-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_modal_input_placeholder_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Modal Input Placeholder Color','jnews'),
            'description'   => esc_html__('Search modal input placeholder color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_expanded .jeg_search_modal_expand .jeg_search_input::-webkit-input-placeholder',
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_expanded .jeg_search_modal_expand .jeg_search_input:-moz-placeholder',
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_expanded .jeg_search_modal_expand .jeg_search_input::-moz-placeholder',
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_expanded .jeg_search_modal_expand .jeg_search_input:-ms-input-placeholder',
                    'property'      => 'color',
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_modal_background',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Modal Background Color','jnews'),
            'description'   => esc_html__('Search modal background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_expanded .jeg_search_modal_expand",
                    'property'      => 'background',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_icon_mobile',
            'type'          => 'jnews-header',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Mobile - Search Icon','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_mobile_icon_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search icon color','jnews'),
            'description'   => esc_html__('Color of search icon.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_navbar_mobile .jeg_search_wrapper .jeg_search_toggle,
                                        .jeg_navbar_mobile .dark .jeg_search_wrapper .jeg_search_toggle',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_icon_mobile_popup',
            'type'          => 'jnews-header',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Mobile - Popup Drop Style','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_mobile_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Background Color','jnews'),
            'description'   => esc_html__('Search header background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_form,
                                        .jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_result',
                    'property'      => 'background',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_navbar_mobile .jeg_search_expanded .jeg_search_popup_expand .jeg_search_toggle:before',
                    'property'      => 'border-bottom-color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_mobile_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Border Color','jnews'),
            'description'   => esc_html__('Search outer border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_navbar_mobile .jeg_search_wrapper.jeg_search_popup_expand .jeg_search_form,
                                        .jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_result,
                                        .jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_result .search-noresult,
                                        .jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_result .search-all-button',
                    'property'      => 'border-color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_navbar_mobile .jeg_search_expanded .jeg_search_popup_expand .jeg_search_toggle:after',
                    'property'      => 'border-bottom-color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_mobile_input_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Input Background Color','jnews'),
            'description'   => esc_html__('Search input background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_form .jeg_search_input',
                    'property'      => 'background',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_mobile_input_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Input Border Color','jnews'),
            'description'   => esc_html__('Search input border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_form .jeg_search_input',
                    'property'      => 'border-color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_mobile_popup_icon_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Icon Color','jnews'),
            'description'   => esc_html__('Popup search icon color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_form .jeg_search_button',
                    'property'      => 'color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_mobile_input_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Input Text Color','jnews'),
            'description'   => esc_html__('Search input text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_mobile .jeg_search_wrapper.jeg_search_popup_expand .jeg_search_form .jeg_search_input,
                                        .jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_result a,
                                        .jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_result .search-link",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_mobile_placeholder_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_icon,
            'label'         => esc_html__('Search Placeholder Color','jnews'),
            'description'   => esc_html__('Set search placeholder text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_input::-webkit-input-placeholder",
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_input:-moz-placeholder",
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_input::-moz-placeholder",
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_mobile .jeg_search_popup_expand .jeg_search_input:-ms-input-placeholder",
                    'property'      => 'color',
                )
            ),
        ));
    }


    // Search form
    public function set_header_search_form_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_search_form,
            'title'         => esc_html__('Header - Search Form','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_search_form_style',
            'transport'     => 'postMessage',
            'default'       => 'jeg_style_square',
            'type'          => 'jnews-select',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Search Form Style','jnews'),
            'description'   => esc_html__('Select search form input style.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'square'          => esc_attr__( 'Square', 'jnews' ),
                'rounded'       => esc_attr__( 'Rounded', 'jnews' ),
                'round'       => esc_attr__( 'Round', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_search_no_expand',
                    'property'      => array(
                        'square' => 'square',
                        'rounded' => 'rounded',
                        'round' => 'round',
                    ),
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_search_form_width',
            'transport'     => 'postMessage',
            'default'       => 60,
            'type'          => 'jnews-slider',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Form Width', 'jnews'),
            'description'   => esc_html__('Set search input width in percentage.','jnews'),
            'choices'     => array(
                'min'  => '20',
                'max'  => '100',
                'step' => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_nav_search',
                    'property'      => 'width',
                    'units'         => '%',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_no_expand_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Search Form Color Options','jnews' ),
        ));

        // search - no expand
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_search_noexpand_input_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Search Input Background Color','jnews'),
            'description'   => esc_html__('Search input background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_no_expand .jeg_search_form .jeg_search_input',
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_search_noexpand_input_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Search Input Border Color','jnews'),
            'description'   => esc_html__('Search input border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_no_expand .jeg_search_form .jeg_search_input',
                    'property'      => 'border-color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_search_noexpand_icon_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Search Icon Color','jnews'),
            'description'   => esc_html__('Search icon color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_no_expand .jeg_search_form button.jeg_search_button',
                    'property'      => 'color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_search_noexpand_input_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Search Input Text Color','jnews'),
            'description'   => esc_html__('Search input text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_wrapper.jeg_search_no_expand .jeg_search_form .jeg_search_input",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_search_noexpand_input_placeholder_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Search Input Placeholder Color','jnews'),
            'description'   => esc_html__('Search input placeholder color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_no_expand .jeg_search_form .jeg_search_input::-webkit-input-placeholder',
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_no_expand .jeg_search_form .jeg_search_input:-moz-placeholder',
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_no_expand .jeg_search_form .jeg_search_input::-moz-placeholder',
                    'property'      => 'color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_no_expand .jeg_search_form .jeg_search_input:-ms-input-placeholder',
                    'property'      => 'color',
                ),
            ),
        ));

        /* live search result */
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_search_no_expand_result_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Live Results Color Options','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_search_noexpand_input_result_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Background Color','jnews'),
            'description'   => esc_html__('Live search results background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_no_expand .jeg_search_result',
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_search_noexpand_input_result_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Border Color','jnews'),
            'description'   => esc_html__('Live search results border color','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_header .jeg_search_no_expand .jeg_search_result,
                                        .jeg_header .jeg_search_no_expand .jeg_search_result .search-link',
                    'property'      => 'border-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_search_noexpand_result_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_search_form,
            'label'         => esc_html__('Text Color','jnews'),
            'description'   => esc_html__('Live search results text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_search_no_expand .jeg_search_result a,
                                        .jeg_header .jeg_search_no_expand .jeg_search_result .search-link",
                    'property'      => 'color',
                )
            ),
        ));

    }

    public function set_header_main_menu_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_main_menu,
            'title'         => esc_html__('Header - Main Menu','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_main_menu',
            'type'          => 'jnews-header',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Main Menu Style','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_style',
            'transport'     => 'postMessage',
            'default'       => 'jeg_menu_style_1',
            'type'          => 'jnews-select',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Menu Style','jnews'),
            'description'   => esc_html__('Choose your navbar menu style.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'jeg_menu_style_1' => esc_attr__( 'Style 1', 'jnews' ),
                'jeg_menu_style_2' => esc_attr__( 'Style 2', 'jnews' ),
                'jeg_menu_style_3' => esc_attr__( 'Style 3', 'jnews' ),
                'jeg_menu_style_4' => esc_attr__( 'Style 4', 'jnews' ),
                'jeg_menu_style_5' => esc_attr__( 'Style 5', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_menu.jeg_main_menu',
                    'property'      => array(
                        'jeg_menu_style_1'          => 'jeg_menu_style_1',
                        'jeg_menu_style_2'          => 'jeg_menu_style_2',
                        'jeg_menu_style_3'          => 'jeg_menu_style_3',
                        'jeg_menu_style_4'          => 'jeg_menu_style_4',
                        'jeg_menu_style_5'          => 'jeg_menu_style_5',
                    ),
                ),
            )
        ));

        // text color
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Menu Text Color','jnews'),
            'description'   => esc_html__('Menu text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_menu.jeg_main_menu > li > a",
                    'property'      => 'color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_hover_line_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Menu Hover Line Color','jnews'),
            'description'   => esc_html__('Menu hover Line color for menu style 1, 2 and 3.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_menu_style_1 > li > a:before,
                                        .jeg_menu_style_2 > li > a:before,
                                        .jeg_menu_style_3 > li > a:before",
                    'property'      => 'background',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_hover_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Menu Hover Background Color 4','jnews'),
            'description'   => esc_html__('Menu hover background color for menu style 4.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_menu_style_4 > li > a:hover,
                                        .jeg_header .jeg_menu_style_4 > li.sfHover > a,
                                        .jeg_header .jeg_menu_style_4 > li.current-menu-item > a,
                                        .jeg_header .jeg_menu_style_4 > li.current-menu-ancestor > a,
                                        .jeg_navbar_dark .jeg_menu_style_4 > li > a:hover,
                                        .jeg_navbar_dark .jeg_menu_style_4 > li.sfHover > a,
                                        .jeg_navbar_dark .jeg_menu_style_4 > li.current-menu-item > a,
                                        .jeg_navbar_dark .jeg_menu_style_4 > li.current-menu-ancestor > a",
                    'property'      => 'background',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_menu_style',
                    'operator' => '==',
                    'value'    => 'jeg_menu_style_4',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_hover_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Menu Hover Text Color','jnews'),
            'description'   => esc_html__('Set text color on menu hover.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header .jeg_menu.jeg_main_menu > li > a:hover,
                                        .jeg_header .jeg_menu.jeg_main_menu > li.sfHover > a,
                                        .jeg_header .jeg_menu.jeg_main_menu > li > .sf-with-ul:hover:after,
                                        .jeg_header .jeg_menu.jeg_main_menu > li.sfHover > .sf-with-ul:after,
                                        .jeg_header .jeg_menu_style_4 > li.current-menu-item > a,
                                        .jeg_header .jeg_menu_style_4 > li.current-menu-ancestor > a,
                                        .jeg_header .jeg_menu_style_5 > li.current-menu-item > a,
                                        .jeg_header .jeg_menu_style_5 > li.current-menu-ancestor > a",
                    'property'      => 'color',
                )
            ),
        ));

        // Submenu
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_main_submenu',
            'type'          => 'jnews-header',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Main Submenu Style','jnews' ),
        ));

        // icon drop color
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_submenu_icon_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Submenu Arrow Icon Color','jnews'),
            'description'   => esc_html__('Menu arrow drop icon color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_wrapper .sf-arrows .sf-with-ul:after",
                    'property'      => 'color',
                )
            ),
        ));

        // drop background
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_submenu_background',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Submenu Background Color','jnews'),
            'description'   => esc_html__('Submenu background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_wrapper .jeg_menu li > ul",
                    'property'      => 'background',
                )
            ),
        ));

        // drop text color
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_submenu_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Submenu Text Color','jnews'),
            'description'   => esc_html__('Submenu text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_wrapper .jeg_menu li > ul li > a",
                    'property'      => 'color',
                )
            ),
        ));

        // drop background hover
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_submenu_hover_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Submenu Hover Background Color','jnews'),
            'description'   => esc_html__('Submenu hover background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_wrapper .jeg_menu li > ul li:hover > a,
                                        .jeg_navbar_wrapper .jeg_menu li > ul li.sfHover > a,
                                        .jeg_navbar_wrapper .jeg_menu li > ul li.current-menu-item > a,
                                        .jeg_navbar_wrapper .jeg_menu li > ul li.current-menu-ancestor > a",
                    'property'      => 'background',
                )
            ),
        ));
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_submenu_hover_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Submenu Hover Text Color','jnews'),
            'description'   => esc_html__('Submenu Hover text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_wrapper .jeg_menu li > ul li:hover > a,
                                        .jeg_navbar_wrapper .jeg_menu li > ul li.sfHover > a,
                                        .jeg_navbar_wrapper .jeg_menu li > ul li.current-menu-item > a,
                                        .jeg_navbar_wrapper .jeg_menu li > ul li.current-menu-ancestor > a,
                                        .jeg_navbar_wrapper .jeg_menu li > ul li:hover > .sf-with-ul:after,
                                        .jeg_navbar_wrapper .jeg_menu li > ul li.sfHover > .sf-with-ul:after,
                                        .jeg_navbar_wrapper .jeg_menu li > ul li.current-menu-item > .sf-with-ul:after,
                                        .jeg_navbar_wrapper .jeg_menu li > ul li.current-menu-ancestor > .sf-with-ul:after",
                    'property'      => 'color',
                )
            ),
        ));

        // drop border color
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_submenu_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Submenu Border Color','jnews'),
            'description'   => esc_html__('Submenu border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_wrapper .jeg_menu li > ul li a",
                    'property'      => 'border-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Mega Menu','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_subcat_newsfeed_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Subcategory News Feed Background Color','jnews'),
            'description'   => esc_html__('Subcategory news feed background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_subcat",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_subcat_newsfeed_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Subcategory News Feed Border Color','jnews'),
            'description'   => esc_html__('Subcategory news feed border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_subcat",
                    'property'      => 'border-right-color',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_subcat li.active",
                    'property'      => 'border-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_subcat_newsfeed_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Subcategory News Feed Text Color','jnews'),
            'description'   => esc_html__('Subcategory news feed text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_wrapper .jeg_megamenu .sub-menu .jeg_newsfeed_subcat li a",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_subcat_newsfeed_hover_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Subcategory News Feed Hover Text Color','jnews'),
            'description'   => esc_html__('Subcategory news feed hover text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_subcat li.active a",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_subcat_newsfeed_hover_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Subcategory News Feed Hover Background Color','jnews'),
            'description'   => esc_html__('Subcategory news feed hover background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_subcat li.active",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('News Feed Background Color','jnews'),
            'description'   => esc_html__('News feed background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_overlay_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('News Feed Overlay Background Color','jnews'),
            'description'   => esc_html__('News feed overlay background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .newsfeed_overlay",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_preloader_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('News Feed Preloader Color','jnews'),
            'description'   => esc_html__('News feed preloader color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .newsfeed_overlay .jeg_preloader span",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('News Feed Text Color','jnews'),
            'description'   => esc_html__('News feed text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_list .jeg_newsfeed_item .jeg_post_title a",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_tags_heading_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Tags Heading Color','jnews'),
            'description'   => esc_html__('Trending tags heading text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_newsfeed_tags h3",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_tags_list_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Tags List Color','jnews'),
            'description'   => esc_html__('Trending tags list text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_navbar_wrapper .jeg_newsfeed_tags li a",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_tags_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Separator Border Color','jnews'),
            'description'   => esc_html__('Trending tags separator border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_newsfeed_tags",
                    'property'      => 'border-left-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_arrow_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Nav Arrow Color','jnews'),
            'description'   => esc_html__('News feed nav arrow color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_list .newsfeed_carousel.owl-carousel .owl-nav div",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_arrow_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Nav Arrow Background Color','jnews'),
            'description'   => esc_html__('News feed nav arrow Background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_list .newsfeed_carousel.owl-carousel .owl-nav div",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_arrow_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Nav Arrow Border Color','jnews'),
            'description'   => esc_html__('News feed nav arrow border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_list .newsfeed_carousel.owl-carousel .owl-nav div",
                    'property'      => 'border-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_arrow_hover_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Nav Arrow Hover Color','jnews'),
            'description'   => esc_html__('News feed nav arrow hover color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_list .newsfeed_carousel.owl-carousel .owl-nav div:hover",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_arrow_hover_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Nav Arrow Hover Background Color','jnews'),
            'description'   => esc_html__('News feed nav arrow hover Background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_list .newsfeed_carousel.owl-carousel .owl-nav div:hover",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_arrow_hover_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Nav Arrow Hover Border Color','jnews'),
            'description'   => esc_html__('News feed nav arrow hover border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_list .newsfeed_carousel.owl-carousel .owl-nav div:hover",
                    'property'      => 'border-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_arrow_disabled_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Nav Arrow Disabled Color','jnews'),
            'description'   => esc_html__('News feed nav arrow disabled color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_list .newsfeed_carousel.owl-carousel .owl-nav div.disabled",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_arrow_disabled_bg_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Nav Arrow Disabled Background Color','jnews'),
            'description'   => esc_html__('News feed nav arrow disabled Background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_list .newsfeed_carousel.owl-carousel .owl-nav div.disabled",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mega_menu_newsfeed_arrow_disabled_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_main_menu,
            'label'         => esc_html__('Nav Arrow Disabled Border Color','jnews'),
            'description'   => esc_html__('News feed nav arrow disabled border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_megamenu .sub-menu .jeg_newsfeed_list .newsfeed_carousel.owl-carousel .owl-nav div.disabled",
                    'property'      => 'border-color',
                )
            ),
        ));
    }

    /**
     * Topbar Field
     */
    public function set_header_topbar_field()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_menu_topbar,
            'title'         => esc_html__('Header - Top Bar Menu','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_menu_desktop',
            'type'          => 'jnews-header',
            'section'       => $this->section_menu_topbar,
            'label'         => esc_html__('Desktop - Top Bar Menu','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_menu_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_menu_topbar,
            'label'         => esc_html__('Text Color','jnews'),
            'description'   => esc_html__('Top Bar menu text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jnews .jeg_header .jeg_menu.jeg_top_menu > li > a',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_menu_text_color_hover',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_menu_topbar,
            'label'         => esc_html__('Menu Hover Color','jnews'),
            'description'   => esc_html__('Top bar menu text hover color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jnews .jeg_header .jeg_menu.jeg_top_menu > li a:hover',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_menu_drop_arrow_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_menu_topbar,
            'label'         => esc_html__('Drop Arrow Color','jnews'),
            'description'   => esc_html__('Top bar arrow color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jnews .jeg_top_menu.sf-arrows .sf-with-ul:after',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_menu_background',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_menu_topbar,
            'label'         => esc_html__('Submenu Background','jnews'),
            'description'   => esc_html__('Top bar submenu background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jnews .jeg_menu.jeg_top_menu li > ul",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_submenu_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_menu_topbar,
            'label'         => esc_html__('Submenu Text Color','jnews'),
            'description'   => esc_html__('Top bar submenu text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jnews .jeg_menu.jeg_top_menu li > ul,
                                        .jnews .jeg_menu.jeg_top_menu li > ul li > a,
	                                    .jnews .jeg_menu.jeg_top_menu li > ul li:hover > a,
	                                    .jnews .jeg_menu.jeg_top_menu li > ul li.sfHover > a",
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_submenu_background_hover_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_menu_topbar,
            'label'         => esc_html__('Submenu Background Hover Color','jnews'),
            'description'   => esc_html__('Top bar menu background hover color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jnews .jeg_menu.jeg_top_menu li > ul li:hover > a, .jnews .jeg_menu.jeg_top_menu li > ul li.sfHover > a",
                    'property'      => 'background-color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_topbar_submenu_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_menu_topbar,
            'label'         => esc_html__('Submenu Border Color','jnews'),
            'description'   => esc_html__('Top bar submenu border color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jnews .jeg_menu.jeg_top_menu li > ul, .jnews .jeg_menu.jeg_top_menu li > ul li a",
                    'property'      => 'border-color',
                )
            ),
        ));
    }


    /**
     * Logo Field
     */
    public function set_header_logo_field()
    {
        // Section
        $this->customizer->add_section(array(
            'id'            => $this->section_logo,
            'title'         => esc_html__('Header - Logo','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        /**
         * Normal Header Logo
         */

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_section_logo',
            'type'          => 'jnews-header',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Normal Header Logo','jnews' ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_header_logo_type',
            'transport'     => 'postMessage',
            'default'       => 'image',
            'type'          => 'jnews-radio-buttonset',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Choose your header logo type','jnews'),
            'description'   => esc_html__('choose between image logo or text logo', 'jnews'),
            'choices'       => array(
                'image'         => esc_attr__( 'Image Logo', 'jnews' ),
                'text'          => esc_attr__( 'Text Logo', 'jnews' )
            ),
            'partial_refresh' => array (
                'jnews_header_logo_type' => array (
                    'selector'        => '.jeg_desktop_logo.jeg_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_header_logo( false );
                    },
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_logo_text',
            'transport'     => 'postMessage',
            'default'       => 'Logo',
            'type'          => 'text',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Header Logo Text','jnews' ),
            'description'   => esc_html__('Your logo alternate text.','jnews' ),
            'partial_refresh' => array (
                'jnews_header_logo_text' => array (
                    'selector'        => '.jeg_desktop_logo.jeg_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_header_logo( false );
                    },
                ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_logo_type',
                    'operator' => '==',
                    'value'    => 'text',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_logo_text_font',
            'transport'     => 'postMessage',
            'type'          => 'jnews-typography',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Header Logo Text Font', 'jnews' ),
            'description'   => esc_html__('Set font for your header logo text', 'jnews' ),
            'default'     => array (
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'subsets'        => array( ),
                'color'          => ''
            ),
            'output'     => array(
                array(
                    'method'        => 'typography',
                    'element'       => '.jeg_desktop_logo.jeg_logo a, .jeg_desktop_logo.jeg_logo h2'
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_logo_type',
                    'operator' => '==',
                    'value'    => 'text',
                )
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_header_logo',
            'transport'     => 'postMessage',
            'default'       => get_parent_theme_file_uri('assets/img/logo.png'),
            'type'          => 'image',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Header Logo','jnews' ),
            'description'   => esc_html__('Upload your header logo.','jnews' ),
            'partial_refresh' => array (
                'jnews_header_logo' => array (
                    'selector'        => '.jeg_desktop_logo.jeg_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_header_logo( false );
                    },
                ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_logo_type',
                    'operator' => '==',
                    'value'    => 'image',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_logo_retina',
            'transport'     => 'postMessage',
            'default'       => get_parent_theme_file_uri('assets/img/logo@2x.png'),
            'type'          => 'image',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Header Logo Retina','jnews' ),
            'description'   => esc_html__('Upload your header logo retina.','jnews' ),
            'partial_refresh' => array (
                'jnews_header_logo_retina' => array (
                    'selector'        => '.jeg_desktop_logo.jeg_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_header_logo( false );
                    },
                ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_logo_type',
                    'operator' => '==',
                    'value'    => 'image',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_logo_alt',
            'transport'     => 'postMessage',
            'default'       => get_bloginfo('name'),
            'type'          => 'text',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Header Logo Alt','jnews' ),
            'description'   => esc_html__('Your logo alternate text','jnews' ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_logo_type',
                    'operator' => '==',
                    'value'    => 'image',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_logo_spacing',
            'transport'     => 'postMessage',
            'default'     => array(
                'top'    => '0px',
                'bottom' => '0px',
                'left'   => '0px',
                'right'  => '0px',
            ),
            'type'          => 'jnews-spacing',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Logo Spacing','jnews'),
            'description'   => esc_html__('You can use px, em for your logo spacing.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'inline-spacing',
                    'element'       => '.jeg_header .jeg_logo > a',
                    'property'      => 'padding',
                )
            )
        ));


        /**
         * Sticky Header Logo
         */

        $this->customizer->add_field(array(
            'id'            => 'jnews_sticky_section_logo',
            'type'          => 'jnews-header',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Sticky Header Logo','jnews' ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_sticky_logo_type',
            'transport'     => 'postMessage',
            'default'       => 'image',
            'type'          => 'jnews-radio-buttonset',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Choose your sticky header logo type','jnews'),
            'description'   => esc_html__('choose between image logo or text logo', 'jnews'),
            'choices'       => array(
                'image'         => esc_attr__( 'Image Logo', 'jnews' ),
                'text'          => esc_attr__( 'Text Logo', 'jnews' )
            ),
            'partial_refresh' => array (
                'jnews_sticky_logo_type' => array (
                    'selector'        => '.jeg_stickybar .jeg_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_sticky_logo( false );
                    },
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sticky_logo_text',
            'transport'     => 'postMessage',
            'default'       => 'Logo',
            'type'          => 'text',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Header Logo Text','jnews' ),
            'description'   => esc_html__('Your logo alternate text.','jnews' ),
            'partial_refresh' => array (
                'jnews_sticky_logo_text' => array (
                    'selector'        => '.jeg_stickybar .jeg_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_sticky_logo( false );
                    },
                ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sticky_logo_type',
                    'operator' => '==',
                    'value'    => 'text',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sticky_logo_text_font',
            'transport'     => 'postMessage',
            'type'          => 'jnews-typography',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Sticky Logo Text Font', 'jnews' ),
            'description'   => esc_html__('Set font for your sticky logo text', 'jnews' ),
            'default'     => array (
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'subsets'        => array( ),
                'color'          => ''
            ),
            'output'     => array(
                array(
                    'method'        => 'typography',
                    'element'       => '.jeg_stickybar .jeg_logo a, .jeg_stickybar .jeg_logo h2'
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sticky_logo_type',
                    'operator' => '==',
                    'value'    => 'text',
                )
            ),
        ));



        $this->customizer->add_field(array(
            'id'            => 'jnews_sticky_menu_logo',
            'transport'     => 'postMessage',
            'default'       => get_parent_theme_file_uri('assets/img/sticky_logo.png'),
            'type'          => 'image',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Sticky Menu Logo','jnews' ),
            'description'   => esc_html__('Upload your sticky menu logo.','jnews' ),
            'partial_refresh' => array (
                'jnews_sticky_menu_logo' => array (
                    'selector'        => '.jeg_stickybar .jeg_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_sticky_logo( false );
                    },
                ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sticky_logo_type',
                    'operator' => '==',
                    'value'    => 'image',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sticky_menu_logo_retina',
            'transport'     => 'postMessage',
            'default'       => get_parent_theme_file_uri('assets/img/sticky_logo@2x.png'),
            'type'          => 'image',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Sticky Menu Logo Retina','jnews' ),
            'description'   => esc_html__('Upload your sticky menu logo retina.','jnews' ),
            'partial_refresh' => array (
                'jnews_sticky_menu_logo_retina' => array (
                    'selector'        => '.jeg_stickybar .jeg_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_sticky_logo( false );
                    },
                ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sticky_logo_type',
                    'operator' => '==',
                    'value'    => 'image',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sticky_menu_alt',
            'transport'     => 'postMessage',
            'default'       => get_bloginfo('name'),
            'type'          => 'text',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Sticky Menu Alt','jnews' ),
            'description'   => esc_html__('Your logo alternate text.','jnews' ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_sticky_logo_type',
                    'operator' => '==',
                    'value'    => 'image',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_mobile_section_logo',
            'type'          => 'jnews-header',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Mobile Header Logo','jnews' ),
        ));



        $this->customizer->add_field(array(
            'id'            => 'jnews_mobile_logo_type',
            'transport'     => 'postMessage',
            'default'       => 'image',
            'type'          => 'jnews-radio-buttonset',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Choose your mobile header logo type','jnews'),
            'description'   => esc_html__('choose between image logo or text logo', 'jnews'),
            'choices'       => array(
                'image'         => esc_attr__( 'Image Logo', 'jnews' ),
                'text'          => esc_attr__( 'Text Logo', 'jnews' )
            ),
            'partial_refresh' => array (
                'jnews_mobile_logo_type' => array (
                    'selector'        => '.jeg_mobile_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_mobile_logo( false );
                    },
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_mobile_logo_text',
            'transport'     => 'postMessage',
            'default'       => 'Logo',
            'type'          => 'text',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Mobile Logo Text','jnews' ),
            'description'   => esc_html__('Your logo alternate text.','jnews' ),
            'partial_refresh' => array (
                'jnews_mobile_logo_text' => array (
                    'selector'        => '.jeg_mobile_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_mobile_logo( false );
                    },
                ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_mobile_logo_type',
                    'operator' => '==',
                    'value'    => 'text',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_mobile_logo_text_font',
            'transport'     => 'postMessage',
            'type'          => 'jnews-typography',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Mobile Logo Text Font', 'jnews' ),
            'description'   => esc_html__('Set font for your sticky logo text', 'jnews' ),
            'default'     => array (
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'subsets'        => array( ),
                'color'          => ''
            ),
            'output'     => array(
                array(
                    'method'        => 'typography',
                    'element'       => '.jeg_mobile_logo a, .jeg_mobile_logo h2'
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_mobile_logo_type',
                    'operator' => '==',
                    'value'    => 'text',
                )
            ),
        ));



        $this->customizer->add_field(array(
            'id'            => 'jnews_mobile_logo',
            'transport'     => 'postMessage',
            'default'       => get_parent_theme_file_uri('assets/img/logo_mobile.png'),
            'type'          => 'image',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Mobile Device Logo','jnews' ),
            'description'   => esc_html__('Upload your mobile device logo.','jnews' ),
            'partial_refresh' => array (
                'jnews_mobile_logo' => array (
                    'selector'        => '.jeg_mobile_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_mobile_logo( false );
                    },
                ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_mobile_logo_type',
                    'operator' => '==',
                    'value'    => 'image',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_mobile_logo_retina',
            'transport'     => 'postMessage',
            'default'       => get_parent_theme_file_uri('assets/img/logo_mobile@2x.png'),
            'type'          => 'image',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Mobile Device Logo Retina','jnews' ),
            'description'   => esc_html__('Upload your mobile device logo retina.','jnews' ),
            'partial_refresh' => array (
                'jnews_mobile_logo_retina' => array (
                    'selector'        => '.jeg_mobile_logo > a',
                    'render_callback' => function() {
                        return jnews_generate_mobile_logo( false );
                    },
                ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_mobile_logo_type',
                    'operator' => '==',
                    'value'    => 'image',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_mobile_logo_alt',
            'transport'     => 'postMessage',
            'default'       => get_bloginfo('name'),
            'type'          => 'text',
            'section'       => $this->section_logo,
            'label'         => esc_html__('Mobile Logo Alt','jnews' ),
            'description'   => esc_html__('Your logo alternate text.','jnews' ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_mobile_logo_type',
                    'operator' => '==',
                    'value'    => 'image',
                )
            ),
        ));
    }



    /**
     * Desktop Sticky
     */
    function set_header_desktop_sticky()
    {
        // Section
        $this->customizer->add_section(array(
            'id'            => $this->section_desktop_sticky,
            'title'         => esc_html__('Header - Desktop Sticky Option','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        // Field
        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_setting',
            'type'          => 'jnews-header',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Sticky Bar Setting','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_menu_follow',
            'transport'     => 'refresh',
            'default'       => 'scroll',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Menu Following Mode','jnews'),
            'description'   => esc_html__('Choose your navbar menu style.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'fixed'         => esc_attr__( 'Always Follow', 'jnews' ),
                'scroll'        => esc_attr__( 'Follow when Scroll Up', 'jnews' ),
                'pinned'        => esc_attr__( 'Show when Scroll', 'jnews' ),
                'normal'        => esc_attr__( 'No follow', 'jnews' ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_sticky_width',
            'transport'     => 'postMessage',
            'default'       => 'normal',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Header Sticky Width','jnews'),
            'description'   => esc_html__('Choose header container width.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'normal'        => esc_attr__( 'Normal', 'jnews' ),
                'full'          => esc_attr__( 'Fullwidth', 'jnews' )
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_header_sticky .jeg_header',
                    'property'      => array(
                        'normal'            => 'normal',
                        'full'              => 'full',
                    )
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_height',
            'transport'     => 'refresh',
            'default'       => 50,
            'type'          => 'jnews-slider',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Sticky Bar Height', 'jnews'),
            'choices'     => array(
                'min'  => '30',
                'max'  => '150',
                'step' => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_stickybar.jeg_navbar,.jeg_navbar .jeg_nav_icon',
                    'property'      => 'height',
                    'units'         => 'px',
                ),
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_stickybar.jeg_navbar,
                                        .jeg_stickybar .jeg_main_menu:not(.jeg_menu_style_1) > li > a,
                                        .jeg_stickybar .jeg_menu_style_1 > li,
                                        .jeg_stickybar .jeg_menu:not(.jeg_main_menu) > li > a',
                    'property'      => 'line-height',
                    'units'         => 'px',
                )
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_boxed',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Boxed Navbar','jnews'),
            'description'   => esc_html__('Enable this option and convert nav bar into boxed.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'add-class',
                    'element'       => '.jeg_header_sticky .jeg_navbar_wrapper',
                    'property'      => 'jeg_navbar_boxed',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_fitwidth',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Fit Width Navbar','jnews'),
            'description'   => esc_html__('Enable this option and nav bar will have fit width effect.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'add-class',
                    'element'       => '.jeg_header_sticky .jeg_navbar_wrapper',
                    'property'      => 'jeg_navbar_fitwidth',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_border',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Navbar Border','jnews'),
            'description'   => esc_html__('Enable this option and nav bar will have border around it.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'add-class',
                    'element'       => '.jeg_header_sticky .jeg_navbar_wrapper',
                    'property'      => 'jeg_navbar_menuborder',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_shadow',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Navbar Shadow','jnews'),
            'description'   => esc_html__('Enable this option and nav bar will have shadow around it.','jnews'),
            'output'     => array(
                array(
                    'method'        => 'add-class',
                    'element'       => '.jeg_header_sticky .jeg_navbar_wrapper',
                    'property'      => 'jeg_navbar_shadow',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_style',
            'type'          => 'jnews-header',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Sticky Bar Style','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_scheme',
            'transport'     => 'postMessage',
            'default'       => 'jeg_navbar_normal',
            'type'          => 'jnews-select',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Menu Scheme','jnews'),
            'description'   => esc_html__('Choose your menu scheme.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'jeg_navbar_normal'        => esc_attr__( 'Normal Style (Light)', 'jnews' ),
                'jeg_navbar_dark'          => esc_attr__( 'Dark Style', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_header_sticky .jeg_navbar_wrapper',
                    'property'      => array(
                        'jeg_navbar_normal'            => 'jeg_navbar_normal',
                        'jeg_navbar_dark'              => 'jeg_navbar_dark',
                    ),
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Sticky Bar Background Color','jnews'),
            'description'   => esc_html__('Set sticky bar background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header_sticky .jeg_navbar_wrapper:not(.jeg_navbar_boxed),
                                        .jeg_header_sticky .jeg_navbar_boxed .jeg_nav_row",
                    'property'      => 'background',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_border_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Border Color','jnews'),
            'description'   => esc_html__('Sticky bar bottom color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_header_sticky .jeg_navbar_menuborder .jeg_main_menu > li:not(:last-child),
                                        .jeg_header_sticky .jeg_navbar_menuborder .jeg_nav_item, .jeg_navbar_boxed .jeg_nav_row,
                                        .jeg_header_sticky .jeg_navbar_menuborder:not(.jeg_navbar_boxed) .jeg_nav_left .jeg_nav_item:first-child",
                    'property'      => 'border-color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Default Text color','jnews'),
            'description'   => esc_html__('Sticky bar text color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_stickybar, .jeg_stickybar.dark",
                    'property'      => 'color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_link_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Default Link Color','jnews'),
            'description'   => esc_html__('Set sticky bar link color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_stickybar a, .jeg_stickybar.dark a",
                    'property'      => 'color',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_border_bottom_height',
            'transport'     => 'postMessage',
            'default'       => 1,
            'type'          => 'jnews-slider',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Border Bottom Height', 'jnews'),
            'choices'     => array(
                'min'           => '0',
                'max'           => '20',
                'step'          => '1',
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_stickybar, .jeg_stickybar.dark',
                    'property'      => 'border-bottom-width',
                    'units'         => 'px',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_stickybar_border_bottom_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_desktop_sticky,
            'label'         => esc_html__('Border Bottom Color','jnews'),
            'description'   => esc_html__('Set sticky Bar border bottom color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_stickybar, .jeg_stickybar.dark,
                                        .jeg_stickybar.jeg_navbar_boxed .jeg_nav_row',
                    'property'      => 'border-bottom-color',
                )
            ),
        ));
    }

    public function set_header_mobile_drawer_field()
    {
        // Section
        $this->customizer->add_section(array(
            'id'            => $this->section_mobile_drawer,
            'title'         => esc_html__('Header - Mobile Drawer Option','jnews' ),
            'panel'         => 'jnews_header',
            'priority'      => 250,
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_drawer_scheme',
            'transport'     => 'postMessage',
            'default'       => 'normal',
            'type'          => 'jnews-select',
            'section'       => $this->section_mobile_drawer,
            'label'         => esc_html__('Drawer Scheme','jnews'),
            'description'   => esc_html__('Choose your drawer color scheme.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'normal'        => esc_attr__( 'Normal Style (Light)', 'jnews' ),
                'dark'          => esc_attr__( 'Dark Style', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '#jeg_off_canvas',
                    'property'      => array(
                        'normal'            => 'normal',
                        'dark'              => 'dark',
                    ),
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_drawer_background_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_mobile_drawer,
            'label'         => esc_html__('Background Color','jnews'),
            'description'   => esc_html__('Background color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => "#jeg_off_canvas.dark .jeg_mobile_wrapper,
                                        #jeg_off_canvas .jeg_mobile_wrapper",
                    'property'      => 'background',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_drawer_overlay_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => $this->section_mobile_drawer,
            'label'         => esc_html__('Overlay Color','jnews'),
            'description'   => esc_html__('Background image overlay color.','jnews'),
            'choices'     => array(
                'alpha'         => true,
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => ".jeg_mobile_wrapper .nav_wrap:before",
                    'property'      => 'background',
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_drawer_background_image',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'image',
            'section'       => $this->section_mobile_drawer,
            'label'         => esc_html__('Mobile Drawer Background Image','jnews' ),
            'description'   => esc_html__('Upload your background image.','jnews' ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_mobile_wrapper',
                    'property'      => 'background-image',
                    'prefix'        => 'url("',
                    'suffix'        => '")'
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_drawer_background_repeat',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-select',
            'section'       => $this->section_mobile_drawer,
            'label'         => esc_html__('Background Repeat', 'jnews'),
            'choices'       => array(
                ''              => '',
                'repeat-x'      => esc_attr__('Repeat Horizontal', 'jnews'),
                'repeat-y'      => esc_attr__('Repeat Vertical', 'jnews'),
                'repeat'        => esc_attr__('Repeat Image', 'jnews'),
                'no-repeat'     => esc_attr__('No Repeat', 'jnews')
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_mobile_wrapper',
                    'property'      => 'background-repeat',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_mobile_drawer_background_image',
                    'operator' => '!=',
                    'value'    => '',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_drawer_background_position',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-select',
            'section'       => $this->section_mobile_drawer,
            'label'         => esc_html__('Background Position', 'jnews'),
            'choices'       => array(
                ''              => '',
                'left top'      => esc_attr__('Left Top', 'jnews'),
                'left center'   => esc_attr__('Left Center', 'jnews'),
                'left bottom'   => esc_attr__('Left Bottom', 'jnews'),
                'center top'    => esc_attr__('Center Top', 'jnews'),
                'center center' => esc_attr__('Center Center', 'jnews'),
                'center bottom' => esc_attr__('Center Bottom', 'jnews'),
                'right top'     => esc_attr__('Right Top', 'jnews'),
                'right center'  => esc_attr__('Right Center', 'jnews'),
                'right bottom'  => esc_attr__('Right Bottom', 'jnews'),
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_mobile_wrapper',
                    'property'      => 'background-position',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_mobile_drawer_background_image',
                    'operator' => '!=',
                    'value'    => '',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_drawer_background_fixed',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-select',
            'section'       => $this->section_mobile_drawer,
            'label'         => esc_html__('Attachment Background', 'jnews'),
            'choices'       => array(
                ''              => '',
                'fixed'         => esc_attr__('Fixed', 'jnews'),
                'scroll'        => esc_attr__('Scroll', 'jnews')
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_mobile_wrapper',
                    'property'      => 'background-attachment',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_mobile_drawer_background_image',
                    'operator' => '!=',
                    'value'    => '',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_mobile_drawer_background_size',
            'transport'     => 'postMessage',
            'default'       => 'inherit',
            'type'          => 'jnews-select',
            'section'       => $this->section_mobile_drawer,
            'label'         => esc_html__('Background Size', 'jnews'),
            'choices'       => array(
                ''              => '',
                'cover'         => esc_attr__('Cover', 'jnews'),
                'contain'       => esc_attr__('Contain', 'jnews'),
                'initial'       => esc_attr__('Initial', 'jnews'),
                'inherit'       => esc_attr__('Inherit', 'jnews')
            ),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_mobile_wrapper',
                    'property'      => 'background-size',
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_header_mobile_drawer_background_image',
                    'operator' => '!=',
                    'value'    => '',
                )
            )
        ));
    }

    public function header_preset()
    {
        return array(
            '1' => array(
                'label'     => esc_html__('Header 1', 'jnews'),
                'settings'  => array(
                    'jnews_hb_element_desktop_top_left'         => array('top_bar_menu'),
                    'jnews_hb_element_desktop_top_right'        => array('date', 'weather', 'social_icon', 'login'),
                    'jnews_hb_element_desktop_mid_left'         => array('logo'),
                    'jnews_hb_element_desktop_mid_right'        => array('ads'),
                    'jnews_hb_element_desktop_bottom_left'      => array('main_menu'),
                    'jnews_hb_element_desktop_bottom_right'     => array('search_icon'),
                    'jnews_header_social_icon_text_color'       => '#ffffff',
                    'jnews_header_logo'                         => get_parent_theme_file_uri('assets/img/logo.png'),
                    'jnews_header_logo_retina'                  => get_parent_theme_file_uri('assets/img/logo@2x.png'),
                )
            ),
            '2' => array(
                'label'     => esc_html__('Header 2', 'jnews'),
                'settings'  => array(
                    'jnews_hb_arrange_bar'                      => array('top', 'bottom', 'mid'),
                    'jnews_hb_element_desktop_top_left'         => array('top_bar_menu'),
                    'jnews_hb_element_desktop_top_right'        => array('date', 'weather', 'social_icon', 'login'),
                    'jnews_hb_element_desktop_mid_left'         => array('logo'),
                    'jnews_hb_element_desktop_mid_right'        => array('ads'),
                    'jnews_hb_element_desktop_bottom_left'      => array('main_menu'),
                    'jnews_hb_element_desktop_bottom_right'     => array('search_icon'),
                    'jnews_header_social_icon_text_color'       => '#ffffff',
                    'jnews_header_logo'                         => get_parent_theme_file_uri('assets/img/logo.png'),
                    'jnews_header_logo_retina'                  => get_parent_theme_file_uri('assets/img/logo@2x.png'),
                )
            ),
            '3' => array(
                'label'     => esc_html__('Header 3', 'jnews'),
                'settings'  => array(
                    'jnews_hb_element_desktop_top_left'         => array('top_bar_menu'),
                    'jnews_hb_element_desktop_top_right'        => array('date', 'weather', 'social_icon', 'login'),
                    'jnews_hb_element_desktop_mid_left'         => array('logo'),
                    'jnews_hb_element_desktop_mid_right'        => array('main_menu', 'search_icon'),
                    'jnews_hb_element_desktop_bottom_left'      => array(),
                    'jnews_hb_element_desktop_bottom_right'     => array(),
                    'jnews_header_social_icon_text_color'       => '#ffffff',
                    'jnews_header_midbar_border_top_height'     => 1,
                    'jnews_header_midbar_height'                => 90,
                    'jnews_header_logo'                         => get_parent_theme_file_uri('assets/img/logo.png'),
                    'jnews_header_logo_retina'                  => get_parent_theme_file_uri('assets/img/logo@2x.png'),
                )
            ),
            '4' => array(
                'label'     => esc_html__('Header 4', 'jnews'),
                'settings'  => array(
                    'jnews_hb_element_desktop_top_left'         => array('logo', 'top_bar_menu'),
                    'jnews_hb_element_desktop_top_right'        => array('date', 'weather', 'social_icon', 'login'),
                    'jnews_hb_element_desktop_mid_left'         => array(),
                    'jnews_hb_element_desktop_mid_center'       => array('ads'),
                    'jnews_hb_element_desktop_mid_right'        => array(),
                    'jnews_hb_element_desktop_bottom_left'      => array('main_menu'),
                    'jnews_hb_element_desktop_bottom_right'     => array('search_icon'),
                    'jnews_hb_display_desktop_mid_left'         => 'normal',
                    'jnews_hb_display_desktop_mid_center'       => 'grow',
                    'jnews_hb_display_desktop_mid_right'        => 'normal',
                    'jnews_header_topbar_height'                => '55',
                    'jnews_header_midbar_height'                => 150,
                    'jnews_header_topbar_scheme'                => 'normal',
                    'jnews_header_bottombar_scheme'             => 'jeg_navbar_dark',
                    'jnews_header_bottombar_boxed'              => true,
                    'jnews_header_bottombar_fitwidth'           => true,
                    'jnews_header_bottombar_border'             => true,
                    'jnews_header_bottombar_border_color'       => '#515151',
                    'jnews_header_logo'                         => get_parent_theme_file_uri('assets/img/sticky_logo.png'),
                    'jnews_header_logo_retina'                  => get_parent_theme_file_uri('assets/img/sticky_logo@2x.png'),
                )
            ),
            '5' => array(
                'label'     => esc_html__('Header 5', 'jnews'),
                'settings'  => array(
                    'jnews_hb_element_desktop_top_left'         => array('top_bar_menu'),
                    'jnews_hb_element_desktop_top_right'        => array('date', 'weather', 'social_icon', 'login'),
                    'jnews_hb_element_desktop_mid_left'         => array(),
                    'jnews_hb_element_desktop_mid_center'       => array('logo'),
                    'jnews_hb_element_desktop_mid_right'        => array(),
                    'jnews_hb_element_desktop_bottom_left'      => array(),
                    'jnews_hb_element_desktop_bottom_center'    => array('main_menu'),
                    'jnews_hb_element_desktop_bottom_right'     => array('search_icon'),
                    'jnews_hb_display_desktop_mid_left'         => 'normal',
                    'jnews_hb_display_desktop_mid_center'       => 'grow',
                    'jnews_hb_display_desktop_mid_right'        => 'normal',
                    'jnews_hb_display_desktop_bottom_left'      => 'normal',
                    'jnews_hb_display_desktop_bottom_center'    => 'grow',
                    'jnews_hb_display_desktop_bottom_right'     => 'normal',
                    'jnews_header_social_icon_text_color'       => '#ffffff',
                    'jnews_header_logo'                         => get_parent_theme_file_uri('assets/img/logo.png'),
                    'jnews_header_logo_retina'                  => get_parent_theme_file_uri('assets/img/logo@2x.png'),
                )
            ),
            '6' => array(
                'label'     => esc_html__('Header 6', 'jnews'),
                'settings'  => array(
                    'jnews_hb_element_desktop_top_left'         => array('top_bar_menu'),
                    'jnews_hb_element_desktop_top_right'        => array('date', 'weather'),
                    'jnews_hb_element_desktop_mid_left'         => array('social_icon'),
                    'jnews_hb_element_desktop_mid_center'       => array('logo'),
                    'jnews_hb_element_desktop_mid_right'        => array('login'),
                    'jnews_hb_element_desktop_bottom_left'      => array(),
                    'jnews_hb_element_desktop_bottom_center'    => array('main_menu'),
                    'jnews_hb_element_desktop_bottom_right'     => array('search_icon'),
                    'jnews_hb_display_desktop_mid_left'         => 'normal',
                    'jnews_hb_display_desktop_mid_center'       => 'grow',
                    'jnews_hb_display_desktop_mid_right'        => 'normal',
                    'jnews_hb_display_desktop_bottom_left'      => 'normal',
                    'jnews_hb_display_desktop_bottom_center'    => 'grow',
                    'jnews_hb_display_desktop_bottom_right'     => 'normal',
                    'jnews_header_social_icon'                  => 'square',
                    'jnews_header_bottombar_border_top_height'  => 1,
                    'jnews_header_bottombar_height'             => 60,
                    'jnews_header_logo'                         => get_parent_theme_file_uri('assets/img/logo.png'),
                    'jnews_header_logo_retina'                  => get_parent_theme_file_uri('assets/img/logo@2x.png'),
                )
            ),
            '7' => array(
                'label'     => esc_html__('Header 7', 'jnews'),
                'settings'  => array(
                    'jnews_hb_element_desktop_top_left'         => array('top_bar_menu'),
                    'jnews_hb_element_desktop_top_right'        => array('date', 'weather', 'login'),
                    'jnews_hb_element_desktop_mid_left'         => array('logo', 'main_menu'),
                    'jnews_hb_element_desktop_mid_right'        => array('social_icon', 'search_icon'),
                    'jnews_hb_element_desktop_bottom_left'      => array(),
                    'jnews_hb_element_desktop_bottom_right'     => array(),
                    'jnews_header_social_icon_text_color'       => '#333333',
                    'jnews_hb_display_desktop_mid_left'         => 'grow',
                    'jnews_hb_display_desktop_mid_center'       => 'normal',
                    'jnews_hb_display_desktop_mid_right'        => 'normal',
                    'jnews_header_width'                        => 'full',
                    'jnews_header_midbar_border_top_height'     => 1,
                    'jnews_header_midbar_height'                => 90,
                    'jnews_header_logo'                         => get_parent_theme_file_uri('assets/img/logo.png'),
                    'jnews_header_logo_retina'                  => get_parent_theme_file_uri('assets/img/logo@2x.png'),
                )
            ),
        );
    }

}