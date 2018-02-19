<?php
/**
 * This customizer plugin branch of Kirki Customizer Plugin.
 * https://github.com/aristath/kirki
 *
 * @author : Jegtheme
 */
namespace Jeg;

use Jeg\Customizer\ActiveCallback;
use Jeg\Util\Font;
use Jeg\Util\Sanitize;

Class Customizer
{
    /**
     * @var Customizer
     */
    private static $instance;

    /**
     * An array containing all panels.
     *
     * @access private
     * @var array
     */
    private $panels = array();

    /**
     * An array containing all sections.
     *
     * @access private
     * @var array
     */
    private $sections = array();

    /**
     * An array containing all fields.
     *
     * @access private
     * @var array
     */
    private $fields = array();

    /**
     * An array containing all post message
     *
     * @access private
     * @var array
     */
    private $postvar = array();

    /**
     * An array containing all style output
     *
     * @access private
     * @var array
     */
    private $outputs = array();

    /**
     * An array containing active callback
     *
     * @access private
     * @var array
     */
    private $active_callback = array();

    /**
     * An array containing partial refresh
     *
     * @access private
     * @var array
     */
    private $partial_refresh = array();

    /**
     * @var bool
     */
    private $font_loaded = false;

    /**
     * @var string
     */
    private $disable_option_name = 'disable_customizer_option';

    /**
     * @return Customizer
     */
    public static function getInstance()
    {
        if ( null === static::$instance )
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        add_action( 'customize_register',                   array( $this, 'register_control_types' ) );
        add_action( 'customize_register',                   array( $this, 'register_panel_types' ) );
        add_action( 'customize_register',                   array( $this, 'deploy_panels' ), 97 );
        add_action( 'customize_register',                   array( $this, 'deploy_sections' ), 98 );
        add_action( 'customize_register',                   array( $this, 'deploy_fields' ), 96 );
        add_action( 'customize_preview_init',               array( $this, 'preview_init' ), 99 );
        add_action( 'customize_controls_print_styles',      array( $this, 'customizer_styles' ), 99 );
        add_action( 'customize_controls_enqueue_scripts',   array( $this, 'enqueue_control_script' ) );
        add_action( 'upload_mimes',                         array( $this, 'allow_mime' ) );;
        add_action( 'jnews_register_customizer_option',     array( $this, 'disable_customizer' ));
        add_action( 'jnews_load_all_font',                  array( $this, 'load_all_font' ));

        add_action('customize_register',                    array( $this, 'register_customizer'));
        add_action('wp_ajax_jnews_customizer_disable_panel', array(&$this, 'disable_panel_ajax'));
    }

    public function register_customizer()
    {
        do_action('jnews_register_customizer_option', $this);
    }

    public function allow_mime($mimes)
    {
        return array_merge($mimes,array (
            'webm' => 'video/webm',
            'ico' 	=> 'image/vnd.microsoft.icon',
            'ttf'	=> 'application/octet-stream',
            'otf'	=> 'application/octet-stream',
            'woff'	=> 'application/x-font-woff',
            'svg'	=> 'image/svg+xml',
            'eot'	=> 'application/vnd.ms-fontobject',
            'ogg'   => 'audio/ogg',
            'ogv'   => 'video/ogg'
        ));
    }

    public function load_all_font()
    {
        if(!$this->font_loaded)
        {
            $standard_fonts = Font::get_standard_fonts();
            $google_fonts   = Font::get_google_fonts();
            $all_variants   = Font::get_all_variants();
            $all_subsets    = Font::get_google_font_subsets();

            $standard_fonts_final = array();
            foreach ( $standard_fonts as $key => $value ) {
                $standard_fonts_final[] = array(
                    'family'      => $value['stack'],
                    'label'       => $value['label'],
                    'subsets'     => array(),
                    'is_standard' => true,
                    'variants'    => array(
                        array(
                            'id'    => 'regular',
                            'label' => $all_variants['regular'],
                        ),
                        array(
                            'id'    => 'italic',
                            'label' => $all_variants['italic'],
                        ),
                        array(
                            'id'    => '700',
                            'label' => $all_variants['700'],
                        ),
                        array(
                            'id'    => '700italic',
                            'label' => $all_variants['700italic'],
                        ),
                    ),
                    'type'      => 'native'
                );
            }

            $google_fonts_final = array();
            foreach ( $google_fonts as $family => $args ) {
                $label    = ( isset( $args['label'] ) ) ? $args['label'] : $family;
                $variants = ( isset( $args['variants'] ) ) ? $args['variants'] : array( 'regular', '700' );
                $subsets  = ( isset( $args['subsets'] ) ) ? $args['subsets'] : array();

                $available_variants = array();
                foreach ( $variants as $variant ) {
                    if ( array_key_exists( $variant, $all_variants ) ) {
                        $available_variants[] = array( 'id' => $variant, 'label' => $all_variants[ $variant ] );
                    }
                }

                $available_subsets = array();
                foreach ( $subsets as $subset ) {
                    if ( array_key_exists( $subset, $all_subsets ) ) {
                        $available_subsets[] = array( 'id' => $subset, 'label' => $all_subsets[ $subset ] );
                    }
                }

                $google_fonts_final[] = array(
                    'family'       => $family,
                    'label'        => $label,
                    'variants'     => $available_variants,
                    'subsets'      => $available_subsets,
                );
            }

            $final = apply_filters('jnews_font_typography', array_merge( $standard_fonts_final, $google_fonts_final ));
            wp_localize_script( 'jnews-typography', 'jnewsAllFonts', $final );
            $this->font_loaded = true;
        }
    }

    /**
     * preview init
     */
    public function preview_init()
    {
        add_action( 'wp_enqueue_scripts' , array($this, 'load_script'));
    }

    /**
     * Load css on Customizer Panel
     */
    public function customizer_styles()
    {
        wp_enqueue_style( 'jnews-customizer-css', JEG_URL . '/assets/css/customizer.css', null );
        wp_enqueue_style( 'codemirror', JEG_URL . '/assets/js/vendor/codemirror/lib/codemirror.css', null );
        wp_enqueue_style( 'font-awesome', JEG_URL . '/fonts/font-awesome/font-awesome.min.css', null);

        if(is_rtl()) {
            wp_enqueue_style( 'jnews-customizer-css-rtl', JEG_URL . '/assets/css/customizer-rtl.css', null );
        }
    }

    /**
     * load script on Customizer Panel
     */
    public function enqueue_control_script()
    {
        wp_register_script( 'selectize', JEG_URL . '/assets/js/vendor/selectize.js', array( 'jquery' ) );
        wp_register_script( 'serialize-js', JEG_URL. '/assets/js/vendor/serialize.js' );

        // Register the color-alpha picker.
        wp_enqueue_style( 'wp-color-picker' );
        wp_register_script( 'wp-color-picker-alpha', JEG_URL . '/assets/js/vendor/wp-color-picker-alpha.js', array( 'wp-color-picker' ), null, true );

        // Register the jquery-ui-spinner.
        wp_register_script( 'jquery-ui-spinner', JEG_URL . '/assets/js/vendor/jquery-ui-spinner', array( 'jquery', 'jquery-ui-core', 'jquery-ui-button' ) );

        // Register codemirror.
        wp_register_script( 'codemirror', JEG_URL . '/assets/js/vendor/codemirror/lib/codemirror.js', array( 'jquery' ) );

        // validate css value
        wp_register_script( 'jnews-validate-css', JEG_URL . '/assets/js/customizer/validate-css-value.js', array( 'jquery' ) );

        // active callback test
        wp_enqueue_script( 'jnews-active-callback', JEG_URL . '/assets/js/customizer/active-callback.js', array( 'jquery' ), null, true );
        wp_localize_script( 'jnews-active-callback', 'activecallback', $this->active_callback);

        // search customizer functionality
        wp_enqueue_script( 'jnews-search-customizer', JEG_URL . '/assets/js/customizer/additional-customizer.js', array( 'jquery' ), null, true );
        wp_localize_script( 'jnews-search-customizer', 'searchcustomizer', $this->get_all_search_field());

        // resizable customizer
        wp_enqueue_script( 'jquery-ui-resizable', null, array( 'jquery', 'jquery-ui-core'), null, true );

        // late initialization functionality for control
        wp_enqueue_script( 'jnews-customizer-late-init', JEG_URL . '/assets/js/customizer/late-init-customizer.js', array( 'jquery' ), null, true );

        // disable customizer
        wp_enqueue_script( 'jnews-disable-customizer', JEG_URL . '/assets/js/customizer/disable-customizer.js', array( 'jquery' ), null, true );
        wp_localize_script( 'jnews-disable-customizer', 'disablecustomizer', $this->disable_customizer_panel());
    }

    /**
     * load script at Customizer Preview
     */
    public function load_script()
    {
        // jnews post message
        wp_enqueue_script( 'jnews-post-message', JEG_URL . '/assets/js/customizer/post-message.js', array( 'jquery', 'customize-preview' ), null, true );
        wp_localize_script( 'jnews-post-message', 'postvar', $this->postvar);

        wp_enqueue_script( 'jnews-customizer-output', JEG_URL . '/assets/js/customizer/style-output.js', array( 'jquery', 'customize-preview' ), null, true );
        wp_localize_script( 'jnews-customizer-output', 'outputs', $this->get_style_output());
    }

    /**
     * Add panel
     *
     * @param $panel array
     */
    public function add_panel($panel)
    {
        $this->panels[$panel['id']] = $panel;
    }

    /**
     * Add Section
     *
     * @param $section
     */
    public function add_section($section)
    {
        $this->sections[$section['id']] = $section;
    }

    /**
     * Add field
     *
     * @param $field
     */
    public function add_field($field)
    {
        $this->fields[$field['id']] = $field;

        if(isset($field['postvar']))
        {
            $this->postvar[$field['id']] = $field['postvar'];
        }

        if(isset($field['output']))
        {
            array_walk($field['output'], function(&$item) use ($field){
                $item['type'] = $field['type'];
                $item['default'] = isset($field['default']) ? $field['default'] : '';
            });
            $this->outputs[$field['id']] = $field['output'];
        }

        if(isset($field['active_callback']))
        {
            $this->active_callback[$field['id']] = $field['active_callback'];
        }

        if(isset($field['partial_refresh']))
        {
            $this->partial_refresh[$field['id']] = $field['partial_refresh'];
        }
    }

    public function get_field_path($section)
    {
        $path = '';

        if(isset($this->sections[$section]))
        {
            $section = $this->sections[$section];
            $path = $section['title'];

            if($section['panel']) {
                $panel = $this->panels[$section['panel']];
                $path = $panel['title'] . ' &raquo; ' . $path;
            }
        }

        return $path;
    }

    public function get_all_search_field()
    {
        $search_field = array();

        foreach($this->fields as $field) {
            $field['description'] = isset($field['description']) ? $field['description'] : '';

            $search_field[] = array(
                'id'            => $field['id'],
                'search'        => $field['label'] . ' ' . $field['description'],
                'title'         => $field['label'],
                'path'          => $this->get_field_path($field['section']),
                'description'   => isset($field['description']) ? $field['description'] : ''
            );
        }

        return $search_field;
    }

    public function can_render_section_panel($id)
    {
        $option = get_option($this->disable_option_name);

        if(is_array($option))
        {
            if($id === 'jnews_disable_panel')
            {
                return true;
            } else {
                return in_array($id, $option) ? false : true;
            }
        } else {
            return true;
        }
    }

    /**
     * deploy registered panel
     */
    public function deploy_panels()
    {
        global $wp_customize;
        $activeCallbackClass = ActiveCallback::getInstance();

        foreach($this->panels as $panel)
        {
            $panel['type'] = isset($panel['type']) ? $panel['type'] : 'default';

            switch($panel['type'])
            {
                case 'alert' :
                    $panelClass = 'Jeg\Customizer\Panel\AlertPanel';
                    break;
                default:
                    $panelClass = 'WP_Customize_Panel';
                    break;
            }

            if($this->can_render_section_panel($panel['id']))
            {
                $wp_customize->add_panel( new $panelClass($wp_customize, $panel['id'],
                    array(
                        'title'                 => $panel['title'],
                        'description'           => $panel['description'],
                        'priority'              => $panel['priority'],
                        'active_callback'   => isset($panel['active_callback']) ? function() use($panel, $activeCallbackClass){
                            return $activeCallbackClass->evaluate($panel['active_callback']);
                        } : '__return_true'
                    ) )
                );
            }
        }
    }

    /**
     * deploy registered section
     */
    public function deploy_sections()
    {
        global $wp_customize;
        $activeCallbackClass = ActiveCallback::getInstance();

        foreach($this->sections as $section)
        {
            $section['type'] = isset($section['type']) ? $section['type'] : 'default';

            switch($section['type'])
            {
                case 'jnews-section-helper' :
                    $sectionClass = 'Jeg\Customizer\Section\HelperSection';
                    break;
                default:
                    $sectionClass = 'Jeg\Customizer\Section\DefaultSection';
                    break;
            }

            if($this->can_render_section_panel($section['id']))
            {
                $wp_customize->add_section(new $sectionClass($wp_customize, $section['id'], array(
                    'title' => $section['title'],
                    'panel' => $section['panel'],
                    'priority' => $section['priority'],
                    'active_callback' => isset($section['active_callback']) ? function () use ($section, $activeCallbackClass) {
                        return $activeCallbackClass->evaluate($section['active_callback']);
                    } : '__return_true'
                )));
            }
        }
    }

    /**
     * deploy all registered field
     */
    public function deploy_fields()
    {
        foreach($this->fields as $field)
        {
            $filtered_field = $this->filter_field($field);
            $this->do_add_setting($filtered_field['setting']);
            $this->do_add_control($filtered_field['control']);
        }

        $this->register_partial_refresh();
    }

    /**
     * setup_partial_refresh
     */
    public function register_partial_refresh()
    {
        global $wp_customize;

        if ( ! isset( $wp_customize->selective_refresh ) ) {
            return;
        }

        foreach ( $this->fields as $field_id => $args )
        {
            if ( isset( $args['partial_refresh'] ) && ! empty( $args['partial_refresh'] ) )
            {
                // Start going through each item in the array of partial refreshes.
                foreach ( $args['partial_refresh'] as $partial_refresh => $partial_refresh_args )
                {
                    // If we have all we need, create the selective refresh call.
                    if ( isset( $partial_refresh_args['render_callback'] ) && isset( $partial_refresh_args['selector'] ) )
                    {
                        $wp_customize->selective_refresh->add_partial( $partial_refresh, array(
                            'selector'              => $partial_refresh_args['selector'],
                            'settings'              => array( $args['id'] ),
                            'render_callback'       => $partial_refresh_args['render_callback'],
                            'container_inclusive'   => isset($partial_refresh_args['container_inclusive']) ? $partial_refresh_args['container_inclusive'] : false,
                            'fallback_refresh'      => false
                        ) );
                    }
                }
            }
        }
    }


    /**
     * @param $field array
     * @return array
     *
     * Add wordpress setting
     */
    public function filter_field($field)
    {
        $setting = array();
        $activeCallbackClass = ActiveCallback::getInstance();

        // setting
        $setting['setting']['id']               = $field['id'];
        $setting['setting']['type']             = $field['type'];
        $setting['setting']['option_type']      = isset($field['option_type']) ? $field['option_type'] : 'theme_mod';
        $setting['setting']['default']          = isset($field['default']) ? $field['default'] : '';
        $setting['setting']['transport']        = isset($field['transport']) ? $field['transport'] : 'refresh';
        $setting['setting']['sanitize']         = isset($field['sanitize']) ? $field['sanitize'] : $this->sanitize_handler($field['type']);

        // control
        $setting['control']['id']               = $field['id'];
        $setting['control']['type']             = $field['type'];
        $setting['control']['section']          = $field['section'];
        $setting['control']['label']            = $field['label'];
        $setting['control']['description']      = isset($field['description']) ? $field['description'] : '';
        $setting['control']['multiple']         = isset($field['multiple']) ? $field['multiple'] : 0;
        $setting['control']['default']          = isset($field['default']) ? $field['default'] : 0;
        $setting['control']['choices']          = isset($field['choices']) ? $field['choices'] : array();
        $setting['control']['fields']           = isset($field['fields']) ? $field['fields'] : array();
        $setting['control']['row_label']        = isset($field['row_label']) ? $field['row_label'] : esc_html__('Row', 'jnews');
        $setting['control']['wrapper_class']    = isset($field['wrapper_class']) ? $field['wrapper_class'] : array();
        $setting['control']['active_callback']  = isset($field['active_callback']) ? function() use($field, $activeCallbackClass){
            return $activeCallbackClass->evaluate($field['active_callback']);
        } : '__return_true';

        // buat cropped image
        $setting['control']['flex_width']       = isset($field['flex_width']) ? $field['flex_width'] : true;
        $setting['control']['flex_height']      = isset($field['flex_height']) ? $field['flex_height'] : true;
        $setting['control']['width']            = isset($field['width']) ? $field['width'] : true;
        $setting['control']['height']           = isset($field['height']) ? $field['height'] : true;

        $setting['partial_refresh'] = $this->setup_partial_refresh($field);
        if(!empty($setting['partial_refresh'])) {
            $setting['setting']['transport'] = 'postMessage';
        }

        return $setting;
    }

    /**
     * @param $field
     * @return array
     */
    public function setup_partial_refresh($field)
    {
        if(!isset( $field['partial_refresh'] )) {
            $field['partial_refresh'] = array();
        }

        foreach ( $field['partial_refresh'] as $id => $args ) {
            if ( ! is_array( $args ) || ! isset( $args['selector'] ) || ! isset( $args['render_callback'] ) || ! is_callable( $args['render_callback'] ) ) {
                unset( $this->partial_refresh[ $id ] );
                continue;
            }
        }

        return $field['partial_refresh'];
    }

    /**
     * register control type
     */
    public function register_control_types()
    {
        global $wp_customize;

        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Alert' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Button' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Code' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Color' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Header' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\MultiCheck' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Multicolor' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Number' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Preset' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\PresetImage' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\RadioButtonSet' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\RadioImage' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Select' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Slider' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Sortable' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Spacing' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Switcher' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Toggle' );
        $wp_customize->register_control_type( 'Jeg\Customizer\Control\Typography' );
    }

    public function register_panel_types()
    {
        global $wp_customize;

        $wp_customize->register_control_type( 'Jeg\Customizer\Panel\AlertPanel' );
    }

    /**
     * @param $field
     */
    public function do_add_control($field)
    {
        global $wp_customize;

        switch($field['type']) {

            // default element
            case 'color' :
                $classname = 'WP_Customize_Color_Control';
                break;
            case 'image' :
                $classname = 'WP_Customize_Image_Control';
                break;
            case 'cropped_image' :
                $classname = 'WP_Customize_Cropped_Image_Control';
                break;
            case 'upload' :
                $classname = 'WP_Customize_Upload_Control';
                break;

            // custom control
            case 'jnews-alert' :
                $classname = 'Jeg\Customizer\Control\Alert';
                break;
            case 'jnews-button' :
                $classname = 'Jeg\Customizer\Control\Button';
                break;
            case 'jnews-code' :
                $classname = 'Jeg\Customizer\Control\Code';
                break;
            case 'jnews-color' :
                $classname = 'Jeg\Customizer\Control\Color';
                break;
            case 'jnews-header' :
                $classname = 'Jeg\Customizer\Control\Header';
                break;
            case 'jnews-multicheck' :
                $classname = 'Jeg\Customizer\Control\MultiCheck';
                break;
            case 'jnews-multicolor' :
                $classname = 'Jeg\Customizer\Control\Multicolor';
                break;
            case 'jnews-number' :
                $classname = 'Jeg\Customizer\Control\Number';
                break;
            case 'jnews-preset' :
                $classname = 'Jeg\Customizer\Control\Preset';
                break;
            case 'jnews-preset-image' :
                $classname = 'Jeg\Customizer\Control\PresetImage';
                break;
            case 'jnews-radio-buttonset' :
                $classname = 'Jeg\Customizer\Control\RadioButtonSet';
                break;
            case 'jnews-radio-image' :
                $classname = 'Jeg\Customizer\Control\RadioImage';
                break;
            case 'repeater' :
                $classname = 'Jeg\Customizer\Control\Repeater';
                break;
            case 'jnews-select' :
                $classname = 'Jeg\Customizer\Control\Select';
                break;
            case 'jnews-slider' :
                $classname = 'Jeg\Customizer\Control\Slider';
                break;
            case 'jnews-sortable' :
                $classname = 'Jeg\Customizer\Control\Sortable';
                break;
            case 'jnews-spacing' :
                $classname = 'Jeg\Customizer\Control\Spacing';
                break;
            case 'jnews-switch' :
                $classname = 'Jeg\Customizer\Control\Switcher';
                break;
            case 'jnews-toggle' :
                $classname = 'Jeg\Customizer\Control\Toggle';
                break;
            case 'jnews-typography' :
                $classname = 'Jeg\Customizer\Control\Typography';
                break;


            // fallback to WP Control, checkbox, radio, select, textarea, dropdown-pages
            default :
                $classname = 'WP_Customize_Control';
                break;
        }

        $wp_customize->add_control(new $classname($wp_customize,$field['id'],$field));
    }


    /**
     * @param $type
     * @return array|string
     */
    public function sanitize_handler($type)
    {
        $sanitizeClass = Sanitize::getInstance();

        switch($type)
        {
            case 'jnews-sortable' :
                $sanitize = array($sanitizeClass, 'sortable');
                break;
            case 'checkbox' :
            case 'jnews-toggle' :
            case 'jnews-switch' :
                $sanitize = array($sanitizeClass, 'sanitize_checkbox');
                break;
            case 'cropped_image' :
                $sanitize = array($sanitizeClass, 'sanitize_image_id');
                break;
            case 'image' :
                $sanitize = array($sanitizeClass, 'sanitize_url');
                break;
            case 'dropdown-pages' :
                $sanitize = array($sanitizeClass, 'sanitize_dropdown_pages');
                break;
            case 'jnews-multicolor' :
                $sanitize = array($sanitizeClass, 'sanitize_multi_color');
                break;
            case 'jnews-typography' :
                $sanitize = array($sanitizeClass, 'sanitize_typography');
                break;
            case 'jnews-number' :
            case 'jnews-slider' :
                $sanitize = array($sanitizeClass, 'sanitize_number');
                break;
            case 'repeater' :
                $sanitize = array($sanitizeClass, 'by_pass');
                break;

            // color, jnews-color, radio, select, text, textarea, jnews-code, jnews-select, jnews-multicheck, jnews_control_radio_image, jnews_control_radio_buttonset , jnews-preset
            default :
                $sanitize = array($sanitizeClass, 'sanitize_input');
                break;
        }

        return $sanitize;
    }

    /**
     * @param $setting array
     *
     * Add wordpress setting
     */
    public function do_add_setting($setting)
    {
        global $wp_customize;

        switch($setting['type']) {
            case "repeater" :
                $settingClass = 'Jeg\Customizer\Setting\RepeaterSetting';
                break;
            case "jnews-spacing" :
                $settingClass = 'Jeg\Customizer\Setting\SpacingSetting';
                break;
            default:
                $settingClass = 'Jeg\Customizer\Setting\DefaultSetting';
                break;
        }

        $wp_customize->add_setting(new $settingClass($wp_customize, $setting['id'], array(
            'type'              => $setting['option_type'],
            'default'           => $setting['default'],
            'transport'         => $setting['transport'],
            'sanitize_callback' => $setting['sanitize'],
        )));
    }
    /**
     * @return array
     */
    public function get_fields()
    {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function get_sections()
    {
        return $this->sections;
    }

    /**
     * @return array
     */
    public function get_panels()
    {
        return $this->panels;
    }

    /**
     * @return array
     */
    public function get_outputs()
    {
        return $this->outputs;
    }

    /**
     * @return array
     */
    public function get_style_output()
    {
        $style_output = array(
            'control' => $this->outputs,
        );

        return apply_filters('jnews_customizer_style_output', $style_output);
    }

    public function disable_customizer()
    {
        $this->add_panel(array(
            'id' => 'jnews_disable_panel',
            'title' => esc_html__('JNews : Enable / Disable Customizer', 'jnews'),
            'description' => esc_html__('Make customizer faster by disabling customizer panel', 'jnews'),
            'priority' => 160
        ));
    }

    public function disable_customizer_panel()
    {
        $disable = array();
        $disable['panel'] = array();
        $option = get_option($this->disable_option_name, array());

        foreach($this->get_panels() as $panel)
        {
            if($panel['id'] !== 'jnews_disable_panel')
            {
                $disable['panel'][] = array(
                    'id'        => $panel['id'],
                    'title'     => $panel['title'],
                    'type'      => 'panel',
                    'disabled'  => in_array($panel['id'], $option) ? false : true
                );
            }
        }

        foreach($this->get_sections() as $section)
        {
            if($section['panel'] === '')
            {
                $disable['panel'][] = array(
                    'id'        => $section['id'],
                    'title'     => $section['title'],
                    'type'      => 'panel',
                    'disabled'  => in_array($section['id'], $option) ? false : true
                );
            }
        }

        $disable['header'] = esc_html__('Disable / Enable Panel', 'jnews');
        $disable['button'] = esc_html__('Submit', 'jnews');
        $disable['cancel'] = esc_html__('Cancel', 'jnews');

        return $disable;
    }

    public function get_all_front_panel()
    {
        $all_panel = array();

        foreach($this->get_panels() as $panel)
        {
            if($panel['id'] !== 'jnews_disable_panel')
            {
                $all_panel[] = $panel['id'];
            }
        }

        foreach($this->get_sections() as $section)
        {
            if ($section['panel'] === '')
            {
                $all_panel[] = $section['id'];
            }
        }

        return $all_panel;
    }

    public function disable_panel_ajax()
    {
        $this->register_customizer();

        $request = $_REQUEST['form'];
        $panel_array = array();

        if(is_array($request) && sizeof($request))
        {
            foreach($request as $panel) {
                $panel_array[] = $panel['name'];
            }
        }

        $new_array = array_diff($this->get_all_front_panel(), $panel_array);
        update_option($this->disable_option_name, $new_array);
        die();
    }
}