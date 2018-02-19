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
Class JNews_Review_Option
{
    /**
     * @var JNews_Review_Option
     */
    private static $instance;

    /**
     * @var Jeg\Customizer
     */
    private $customizer;

    /**
     * @return JNews_Review_Option
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
            'id' => 'jnews_review_section',
            'title' => esc_html__('Review', 'jnews-review'),
            'panel' => 'jnews_global_panel',
            'priority' => 177,
        ));
    }

    public function set_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_option[price_front]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '$',
            'type'          => 'text',
            'section'       => 'jnews_review_section',
            'label'         => esc_html__('Text in front of price text', 'jnews-review'),
            'description'   => esc_html__('You can use this as your currency text.', 'jnews-review'),
            'postvar'       => array( array(
                'redirect'  => 'single_review_tag',
                'refresh'   => true
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[price_behind]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => 'jnews_review_section',
            'label'         => esc_html__('Text behind of price text', 'jnews-review'),
            'description'   => esc_html__('You can use this as your currency text.', 'jnews-review'),
            'postvar'       => array( array(
                'redirect'  => 'single_review_tag',
                'refresh'   => true
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[price_float_position]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'right',
            'type'          => 'jnews-select',
            'section'       => 'jnews_review_section',
            'label'         => esc_html__('Price float','jnews-review'),
            'description'   => esc_html__('Show price float box on post content.','jnews-review'),
            'multiple'      => 1,
            'choices'     => array(
                'none' => esc_attr__( 'Hide', 'jnews-review' ),
                'right' => esc_attr__( 'Show', 'jnews-review' ),
            ),
            'postvar'       => array( array(
                'redirect'  => 'single_review_tag',
                'refresh'   => true
            ) )
        ));
    }
}