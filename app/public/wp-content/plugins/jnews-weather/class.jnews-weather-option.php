<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Theme JNews Option
 */
Class JNews_Weather_Option
{
    /**
     * @var JNews_Weather_Option
     */
    private static $instance;

    /**
     * @var Jeg\Customizer
     */
    private $customizer;

    /**
     * @return JNews_Weather_Option
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
     * JNews_Weather_Option constructor
     */
    private function __construct()
    {
        if(class_exists('Jeg\Customizer'))
        {
            $this->customizer = Jeg\Customizer::getInstance();

            $this->general_weather_setting();
            $this->top_bar_weather_setting();
        }
    }

    /**
     * General setting for weather
     */
    public function general_weather_setting()
    {
        // set panel
        $this->customizer->add_panel(array(
            'id'            => 'jnews_global_panel',
            'title'         => esc_html__('JNews : General Option', 'jnews'),
            'description'   => esc_html__('JNews General Option', 'jnews'),
            'priority'      => 200,
        ));

        // set section
        $this->customizer->add_section(array(
            'id'       => 'jnews_global_weather_section',
            'title'    => esc_html__('Weather Setting', 'jnews-weather'),
            'panel'    => 'jnews_global_panel',
            'priority' => 252,
        ));
        
        $this->general_weather_field();
    }

    /**
     * Header top bar weather setting
     */
    public function top_bar_weather_setting()
    {
        // set panel
        $this->customizer->add_panel(array(
            'id'            => 'jnews_header',
            'title'         => esc_html__('JNews : Header Option', 'jnews-weather'),
            'description'   => esc_html__('JNews Header Option', 'jnews-weather'),
            'priority'      => 200,
        ));

        // set section
        $this->customizer->add_section(array(
            'id'       => 'jnews_header_weather_section',
            'title'    => esc_html__('Header - Weather Setting', 'jnews-weather'),
            'panel'    => 'jnews_header',
            'priority' => 252,
        ));
        
        $this->top_bar_weather_field();
    }

    /**
     * Field options of weather general setting
     */
    public function general_weather_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_option[weather_forecast_alert]',
            'type'          => 'jnews-alert',
            'default'       => 'info',
            'section'       => 'jnews_global_weather_section',
            'label'         => esc_html__('Weather Forecast Info','jnews-weather' ),
            'description'   => wp_kses(__('You will need to refersh the page to see the result of your changes.</br></br> If you want to purge the current cache, you just need to choose <strong>Disable Cache</strong> on the <strong>Weather Cache Expired</strong> option. Then you can setup the <strong>Weather Cache Expired</strong> option again right after you refresh the page.','jnews-weather' ), wp_kses_allowed_html()),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[weather_forecast_source]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'yahoo',
            'type'          => 'jnews-select',
            'section'       => 'jnews_global_weather_section',
            'label'         => esc_html__('Weather Forecast Source','jnews-weather'),
            'description'   => esc_html__('Choose weather forecast source.','jnews-weather'),
            'choices'       => array(
                'yahoo'          => esc_html__('Yahoo Weather', 'jnews-weather'),
                'darksky'        => esc_html__('Dark Sky', 'jnews-weather'),
                'openweathermap' => esc_html__('Open Weather Map', 'jnews-weather'),
                'aerisweather'   => esc_html__('Aeris Weather', 'jnews-weather'),
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[weather_darksky_api_key]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'type'            => 'text',
            'default'         => '',
            'section'         => 'jnews_global_weather_section',
            'label'           => esc_html__('Dark Sky Secret Key','jnews-weather'),
            'description'     => wp_kses(sprintf(__("Insert your Dark Sky Secret Key. Find your Dark Sky Secret Key <a href='%s' target='_blank'>here</a>.", "jnews-weather"), "https://darksky.net/dev/account"), wp_kses_allowed_html()),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[weather_forecast_source]',
                    'operator' => '==',
                    'value'    => 'darksky',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[weather_openweathermap_api_key]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'type'            => 'text',
            'default'         => '',
            'section'         => 'jnews_global_weather_section',
            'label'           => esc_html__('Open Weather Map API Key','jnews-weather'),
            'description'     => wp_kses(sprintf(__("Insert your Open Weather Map API Key. Find your Open Weather Map API Key <a href='%s' target='_blank'>here</a>.", "jnews-weather"), "https://home.openweathermap.org/api_keys"), wp_kses_allowed_html()),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[weather_forecast_source]',
                    'operator' => '==',
                    'value'    => 'openweathermap',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[weather_aerisweather_id]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'type'            => 'text',
            'default'         => '',
            'section'         => 'jnews_global_weather_section',
            'label'           => esc_html__('Aeris Weather Client ID','jnews-weather'),
            'description'     => wp_kses(sprintf(__("Insert your Aeris Weather Client ID. Find your Aeris Weather Client ID <a href='%s' target='_blank'>here</a>.", "jnews-weather"), "http://www.aerisweather.com/account/apps"), wp_kses_allowed_html()),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[weather_forecast_source]',
                    'operator' => '==',
                    'value'    => 'aerisweather',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[weather_aerisweather_secret]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'type'            => 'text',
            'default'         => '',
            'section'         => 'jnews_global_weather_section',
            'label'           => esc_html__('Aeris Weather Client Secret','jnews-weather'),
            'description'     => wp_kses(sprintf(__("Insert your Aeris Weather Client Secret. Find your Aeris Weather Client Secret <a href='%s' target='_blank'>here</a>.", "jnews-weather"), "http://www.aerisweather.com/account/apps"), wp_kses_allowed_html()),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[weather_forecast_source]',
                    'operator' => '==',
                    'value'    => 'aerisweather',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[weather_default_temperature]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'c',
            'type'          => 'jnews-select',
            'section'       => 'jnews_global_weather_section',
            'label'         => esc_html__('Default Temperature Unit','jnews-weather'),
            'description'   => esc_html__('Choose default temperature unit.','jnews-weather'),
            'choices'       => array(
                'c'  => esc_html__('Celsius', 'jnews-weather'),
                'f'  => esc_html__('Fahrenheit', 'jnews-weather'),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[weather_cache_expired]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '1',
            'type'          => 'jnews-select',
            'section'       => 'jnews_global_weather_section',
            'label'         => esc_html__('Weather Cache Expired','jnews-weather'),
            'description'   => esc_html__('Choose the expired time of weather forecast data cache.','jnews-weather'),
            'choices'       => array(
                '1'  => esc_html__('1 Hour', 'jnews-weather'),
                '2'  => esc_html__('2 Hour', 'jnews-weather'),
                '3'  => esc_html__('3 Hour', 'jnews-weather'),
                'no' => esc_html__('Disable Cache', 'jnews-weather'),
            ),
        ));
    }

    /**
     * Field options of header topbar weather setting
     */
    public function top_bar_weather_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_option[top_bar_weather_forecast_alert]',
            'type'          => 'jnews-alert',
            'default'       => 'info',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Top Bar Weather Forecast','jnews-weather' ),
            'description'   => wp_kses(sprintf(__('Please make sure you\'ve been setup <strong>General Weather Forescast Setting</strong>. You can check it right <a href=\'%s\' target=\'_blank\'>here</a>.','jnews-weather' ), get_admin_url() . "customize.php?autofocus[section]=jnews_global_weather_section"), wp_kses_allowed_html()),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[top_bar_weather_location]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Weather Location','jnews-weather'),
            'description'   => wp_kses(sprintf(__("You can insert <strong>\"city name\"</strong> or <strong>\"city name, country code\"</strong>. For more detail information, you can read our documentation <a href='%s' target='_blank'>here</a>", "jnews-weather"), "#"), wp_kses_allowed_html()),
            'partial_refresh' => array(
                'jnews_option[top_bar_weather_location]' => $this->topbar_refresh()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[top_bar_weather_location_auto]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-toggle',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Weather Auto Detect Location','jnews-weather'),
            'description'   => wp_kses(sprintf(__("Enable this option will automatically detect weather location of your site visitor. For more detail information, you can read our documentation <a href='%s' target='_blank'>here</a>", "jnews-weather"), "#"), wp_kses_allowed_html()),
            'partial_refresh' => array(
                'jnews_option[top_bar_weather_location]' => $this->topbar_refresh()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[top_bar_weather_item]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'hide',
            'type'          => 'jnews-select',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Top Bar Weather Item','jnews-weather'),
            'description'   => esc_html__('Show weather forecast for next days.','jnews-weather'),
            'choices'       => array(
                'hide'   => esc_html__('Hide', 'jnews-weather'),
                'normal' => esc_html__('Normal', 'jnews-weather'),
                'slide'  => esc_html__('Slide', 'jnews-weather'),
            ),
            'partial_refresh' => array(
                'jnews_option[top_bar_weather_item]' => $this->topbar_refresh()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[top_bar_weather_item_count]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '4',
            'type'          => 'jnews-slider',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Weather Item Count','jnews-weather'),
            'description'   => esc_html__('The number of weather item to show.','jnews-weather'),
            'choices'       => array(
                'min'  => '3',
                'max'  => '6',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[top_bar_weather_item]',
                    'operator' => '==',
                    'value'    => 'normal',
                ),
            ),
            'partial_refresh' => array(
                'jnews_option[top_bar_weather_item_count]' => $this->topbar_refresh()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[top_bar_weather_item_content]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'temp',
            'type'          => 'jnews-select',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Weather Item Content','jnews-weather'),
            'description'   => esc_html__('The content of weather item to show.','jnews-weather'),
            'choices'       => array(
                'temp'  => 'Only Temperature',
                'icon'  => 'Only Weather Icon',
                'both'  => 'Show Both',
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[top_bar_weather_item]',
                    'operator' => '!=',
                    'value'    => 'hide',
                ),
            ),
            'partial_refresh' => array(
                'jnews_option[top_bar_weather_item_content]' => $this->topbar_refresh()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[top_bar_weather_item_autoplay]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-toggle',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Autoplay Slide Weather Item','jnews-weather'),
            'description'   => esc_html__('Enable this option to make weather item auto slide.','jnews-weather'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[top_bar_weather_item]',
                    'operator' => '==',
                    'value'    => 'slide',
                ),
            ),
            'partial_refresh' => array(
                'jnews_option[top_bar_weather_item_autoplay]' => $this->topbar_refresh()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[top_bar_weather_item_autodelay]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '2',
            'type'          => 'jnews-slider',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Autoplay Slide Speed','jnews-weather'),
            'description'   => esc_html__('Setup the speed of autoplay slide weather item (second).','jnews-weather'),
            'choices'       => array(
                'min'  => '1',
                'max'  => '5',
                'step' => '1',
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[top_bar_weather_item]',
                    'operator' => '==',
                    'value'    => 'slide',
                ),
                array(
                    'setting'  => 'jnews_option[top_bar_weather_item_autoplay]',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
            'partial_refresh' => array(
                'jnews_option[top_bar_weather_item_autodelay]' => $this->topbar_refresh()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[top_bar_weather_item_autohover]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Stop Autoplay Slide','jnews-weather'),
            'description'   => esc_html__('Enable this option to stop autoplay slide when mouse hover on weather item.','jnews-weather'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[top_bar_weather_item]',
                    'operator' => '==',
                    'value'    => 'slide',
                ),
                array(
                    'setting'  => 'jnews_option[top_bar_weather_item_autoplay]',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
            'partial_refresh' => array(
                'jnews_option[top_bar_weather_item_autohover]' => $this->topbar_refresh()
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_weather_style',
            'type'          => 'jnews-header',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Weather Style','jnews-weather' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_weather_bg',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Background Color','jnews-weather'),
            'description'   => esc_html__('weather background color','jnews-weather'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_weather',
                    'property'      => 'background',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_weather_text_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Text Color','jnews-weather'),
            'description'   => esc_html__('weather text color','jnews-weather'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_weather > .jeg_weather_temp,
                                        .jeg_midbar .jeg_top_weather > .jeg_weather_temp > .jeg_weather_unit,
                                        .jeg_top_weather > .jeg_weather_location',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_weather_icon_color',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Icon Color','jnews-weather'),
            'description'   => esc_html__('weather icon color','jnews-weather'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_weather .jeg_weather_condition .jeg_weather_icon',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_weather_drop_bg',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Drop Background Color','jnews-weather'),
            'description'   => esc_html__('weather drop background color','jnews-weather'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_weather .jeg_weather_item',
                    'property'      => 'background',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_weather_drop_bg_hover',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Drop Hover Background Color','jnews-weather'),
            'description'   => esc_html__('weather drop hover background color','jnews-weather'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_weather .jeg_weather_item .jeg_weather_temp:hover, 
                                        .jeg_weather_widget .jeg_weather_item:hover',
                    'property'      => 'background',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_weather_drop_icon',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Drop Weather Icon Color','jnews-weather'),
            'description'   => esc_html__('drop weather icon color','jnews-weather'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_weather .jeg_weather_item .jeg_weather_temp .jeg_weather_icon',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_weather_drop_degree',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Drop Degree Color','jnews-weather'),
            'description'   => esc_html__('weather drop degree color','jnews-weather'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_weather .jeg_weather_item .jeg_weather_temp .jeg_weather_value,
                                        .jeg_top_weather .jeg_weather_item .jeg_weather_temp .jeg_weather_unit',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_weather_drop_days',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Drop Days Color','jnews-weather'),
            'description'   => esc_html__('weather drop days color','jnews-weather'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_weather .jeg_weather_item .jeg_weather_temp .jeg_weather_day',
                    'property'      => 'color',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_weather_drop_border',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'jnews-color',
            'section'       => 'jnews_header_weather_section',
            'label'         => esc_html__('Drop Border Color','jnews-weather'),
            'description'   => esc_html__('drop border color','jnews-weather'),
            'output'     => array(
                array(
                    'method'        => 'inject-style',
                    'element'       => '.jeg_top_weather .jeg_weather_item .jeg_weather_temp .jeg_weather_icon',
                    'property'      => 'border-color',
                )
            ),
        ));
    }

    public function topbar_refresh()
    {
        return array(
            'selector'        => '.jeg_header_wrapper',
            'render_callback' => function()
            {
                $weather_instance = JNews_Weather::getInstance();
                $weather_instance->process_queue();
                get_template_part('fragment/header/desktop-builder');
            },
        );
    }
}
