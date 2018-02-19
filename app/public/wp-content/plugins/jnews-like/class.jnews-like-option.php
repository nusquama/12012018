<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Theme JNews Option
 */
Class JNews_Like_Option
{
    /**
     * @var JNews_Like_Option
     */
    private static $instance;

    /**
     * @var Jeg\Customizer
     */
    private $customizer;

    /**
     * @return JNews_Like_Option
     */
    public static function getInstance()
    {
        if (null === static::$instance)
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function __construct()
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
        /** panel */
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
            'id' => 'jnews_like_section',
            'title' => esc_html__('Like Button Setting', 'jnews-like'),
            'panel' => 'jnews_social_panel',
            'priority' => 262,
        ));
    }

    public function set_field()
    {
        $single_post_tag = array(
            'redirect'  => 'single_post_tag',
            'refresh'   => false
        );

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_like_header',
            'type'          => 'jnews-header',
            'section'       => 'jnews_like_section',
            'label'         => esc_html__('Like Option','jnews-like' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[single_show_like]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'both',
            'type'          => 'jnews-select',
            'section'       => 'jnews_like_section',
            'label'         => esc_html__('Show Like Button','jnews-like'),
            'description'   => esc_html__('Adjust the post like button on post meta container.','jnews-like'),
            'multiple'      => 1,
            'choices'     => array(
                'both' => esc_attr__( 'Like + Dislike', 'jnews-like' ),
                'like' => esc_attr__( 'Only Like', 'jnews-like' ),
                'hide' => esc_attr__( 'Hide All', 'jnews-like' ),
            ),
            'partial_refresh' => array (
                'jnews_option[single_show_like]' => array (
                    'selector'        => '.jeg_meta_like_container',
                    'render_callback' => function() {
                        return JNews_Like::getInstance()->get_element(get_the_ID());
                    },
                )
            ),
            'postvar'       => array( $single_post_tag )
        ));
    }
}