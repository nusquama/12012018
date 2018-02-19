<?php
/**
 * @author : Jegtheme
 */

/**
 * Class Theme JNews Option
 */
Class JNews_Speed_Option
{
    /**
     * @var JNews_Speed_Option
     */
    private static $instance;

    /**
     * @var Jeg\Customizer
     */
    private $customizer;

    /**
     * @return JNews_Speed_Option
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

            $this->set_section();
            $this->set_field();
        }
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id'            => 'jnews_speed_section',
            'title'         => esc_html__( 'JNews : Speed Option' ,'jnews-speed' ),
            'description'   => esc_html__('JNews Speed Option','jnews-speed' ),
            'panel'         => '',
            'priority'      => 198,
        ));
    }

    public function set_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_speed_alert',
            'type'          => 'jnews-alert',
            'default'       => 'info',
            'section'       => 'jnews_speed_section',
            'label'         => esc_html__('Info','jnews-speed' ),
            'description'   => wp_kses(__(
                "<ul>
                    <li>JNews Speed will increase your point on Google Page Speed.</li>
                    <li>You will need another plugin (such as WP Super Cache) and also need to alter .htaccess to fasten your website load time.</li>
                    <li>For more information, please read the documentation how to speed up your website.</li>
                </ul>",
                "jnews-speed" ), wp_kses_allowed_html())
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_speed_assets_option',
            'type'          => 'jnews-header',
            'section'       => 'jnews_speed_section',
            'label'         => esc_html__('JavaScript &amp; CSS Options','jnews-speed'),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[bottom_script]',
            'option_type'     => 'option',
            'default'         => 'enable',
            'transport'       => 'postMessage',
            'type'            => 'jnews-radio-buttonset',
            'section'         => 'jnews_speed_section',
            'label'           => esc_html__('Move Script to Bottom','jnews-speed'),
            'description'     => esc_html__('Move every script (JS & CSS) to the bottom of the page to speed up load time.','jnews-speed'),
            'choices'     => array(
                'disable' => esc_attr__( 'Disable', 'jnews-speed' ),
                'enable' => esc_attr__( 'Enable', 'jnews-speed' ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[concat_script]',
            'option_type'     => 'option',
            'default'         => 'enable',
            'transport'       => 'postMessage',
            'type'            => 'jnews-radio-buttonset',
            'section'         => 'jnews_speed_section',
            'label'           => esc_html__('Concat, Minify and Defer','jnews-speed'),
            'description'     => esc_html__('Merge all scripts (JS & CSS), Minify all scripts (JS & CSS) and defer load CSS.','jnews-speed'),
            'choices'     => array(
                'disable' => esc_attr__( 'Disable', 'jnews-speed' ),
                'enable' => esc_attr__( 'Enable', 'jnews-speed' ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[above_the_fold_script]',
            'option_type'     => 'option',
            'default'         => 'enable',
            'transport'       => 'postMessage',
            'type'            => 'jnews-radio-buttonset',
            'section'         => 'jnews_speed_section',
            'label'           => esc_html__('Print Above The Fold CSS','jnews-speed'),
            'description'     => esc_html__('We collect all above the fold CSS and print it to the header. This script resolve issues above the fold issues on Google speed analytics.','jnews-speed'),
            'choices'     => array(
                'disable' => esc_attr__( 'Disable', 'jnews-speed' ),
                'enable' => esc_attr__( 'Enable', 'jnews-speed' ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_speed_html_option',
            'type'          => 'jnews-header',
            'section'       => 'jnews_speed_section',
            'label'         => esc_html__('HTML Option','jnews-speed'),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[minify_html]',
            'option_type'     => 'option',
            'default'         => 'enable',
            'transport'       => 'postMessage',
            'type'            => 'jnews-radio-buttonset',
            'section'         => 'jnews_speed_section',
            'label'           => esc_html__('Minify HTML output','jnews-speed'),
            'description'     => esc_html__('Minify HTML output so generated page will be much smaller.','jnews-speed'),
            'choices'     => array(
                'disable' => esc_attr__( 'Disable', 'jnews-speed' ),
                'enable' => esc_attr__( 'Enable', 'jnews-speed' ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_speed_advanced_option',
            'type'          => 'jnews-header',
            'section'       => 'jnews_speed_section',
            'label'         => esc_html__('Advanced Options','jnews-speed'),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[enable_logged_user]',
            'option_type'     => 'option',
            'default'         => 'disable',
            'transport'       => 'postMessage',
            'type'            => 'jnews-radio-buttonset',
            'section'         => 'jnews_speed_section',
            'label'           => esc_html__('Enable JNews Speed when user logged in','jnews-speed'),
            'description'     => esc_html__('enable jnews speed feature when user logged in.','jnews-speed'),
            'choices'     => array(
                'disable' => esc_attr__( 'Disable', 'jnews-speed' ),
                'enable' => esc_attr__( 'Enable', 'jnews-speed' ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[above_jquery]',
            'option_type'     => 'option',
            'default'         => false,
            'transport'       => 'postMessage',
            'type'            => 'jnews-toggle',
            'section'         => 'jnews_speed_section',
            'label'           => esc_html__('Load jQuery Early','jnews-speed'),
            'description'     => wp_kses(__('Enable this option to prevent some potentially JavaScript errors.<br/> <em><strong>Note:</strong> By enabling this option, will make the JavaScript become render blocking.</em>', 'jnews-speed'), wp_kses_allowed_html()),
        ));
    }
}
