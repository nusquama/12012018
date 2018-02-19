<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class JNews Loader
 */
Class JNews_Split_Option
{
    /**
     * @var JNews_Split_Option
     */
    private static $instance;

    /**
     * @var JNews_Customizer
     */
    private $customizer;

    /**
     * @return JNews_Split_Option
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
        $this->customizer = jnews_customizer();

        $this->set_section();
        $this->set_field();
    }

    public function set_section()
    {
        /** panel */
        $this->customizer->add_panel(array(
            'id' => 'jnews_global_panel',
            'title' => esc_html__('JNews : General Option', 'jnews-split'),
            'description' => esc_html__('JNews General Option', 'jnews-split'),
            'priority' => 170
        ));

        $this->customizer->add_section(array(
            'id' => 'jnews_global_loader_section',
            'title' => esc_html__('Loader Setting', 'jnews-split'),
            'panel' => 'jnews_global_panel',
            'priority' => 260,
        ));
    }

    public function set_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_option[split_loader]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'dot',
            'type'          => 'jnews-select',
            'section'       => 'jnews_global_loader_section',
            'label'         => esc_html__('Post Split Loader Style', 'jnews-split'),
            'description'   => esc_html__('Choose loader style for post split.','jnews-split'),
            'choices'       => array(
                'dot'		    => esc_html__('Dot', 'jnews-split'),
                'circle'		=> esc_html__('Circle', 'jnews-split'),
                'square'		=> esc_html__('Square', 'jnews-split'),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.split-overlay  .preloader_type',
                    'property'      => array(
                        'dot'           => 'preloader_dot',
                        'circle'        => 'preloader_circle',
                        'square'        => 'preloader_square',
                    ),
                ),
            )
        ));
    }
}