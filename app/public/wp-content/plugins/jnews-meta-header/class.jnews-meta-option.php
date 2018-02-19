<?php
/**
 * @author : Jegtheme
 */

/**
 * Class Theme JNews Option
 */
Class JNews_Social_Meta_Option
{
    /**
     * @var JNews_Social_Meta_Option
     */
    private static $instance;

    /**
     * @var Jeg\Customizer
     */
    private $customizer;

    /**
     * @return JNews_Social_Meta_Option
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
            'id' => 'jnews_social_panel',
            'title' => esc_html__('JNews : Social, Like & View', 'jnews'),
            'description' => esc_html__('Social, Like & View Option', 'jnews'),
            'priority' => 200
        ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id'       => 'jnews_social_meta_section',
            'title'    => esc_html__('Social Meta Setting', 'jnews-meta-header'),
            'panel'    => 'jnews_social_panel',
            'priority' => 252,
        ));
    }

    public function set_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_social_meta_header',
            'type'          => 'jnews-header',
            'section'       => 'jnews_social_meta_section',
            'label'         => esc_html__('Social Meta Setting','jnews-meta-header' ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_meta_fb_app_id]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'type'            => 'text',
            'default'         => '',
            'section'         => 'jnews_social_meta_section',
            'label' => esc_attr__( 'FB App ID', 'jnews' ),
                    'description' => wp_kses(sprintf(__("The unique ID that lets Facebook know the identity of your site. You can create your Facebook App ID <a href='%s' target='_blank'>here</a>.", "jnews"), "https://developers.facebook.com/docs/apps/register"), wp_kses_allowed_html()),
        ));
    }
}
