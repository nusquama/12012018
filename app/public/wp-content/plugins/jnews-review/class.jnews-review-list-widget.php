<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

Class JNews_Review_List_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'jnews_review',
            esc_html__('JNews : Review List Widget', 'jnews-review'), // Name
            array(
                'description' =>  esc_html__('Review List for JNews', 'jnews-review'),
                'customize_selective_refresh' => true
        ), null);
    }

    /**
     * Register widget with WordPress.
     */
    public function form($instance)
    {
        $options = array (
            'title'     => array(
                'title'     => esc_html__('Title', 'jnews-review'),
                'desc'      => esc_html__('Title on widget header.', 'jnews-review'),
                'type'      => 'text'
            ),
            'limit'   => array(
                'title'     => esc_html__('Total limit post', 'jnews'),
                'desc'      => esc_html__('Set the number of post shown on widget.', 'jnews'),
                'type'      => 'slider',
                'options'    => array(
                    'min'  => '2',
                    'max'  => '15',
                    'step' => '1',
                ),
                'default'   => 6,
            ),
        );

        $generator = new \JNews\Widget\WidgetGenerator($this);
        $generator->render_form($options, $instance);
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance )
    {
        $title = apply_filters( 'widget_title', isset($instance['title']) ? $instance['title'] : "" );

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        $this->render_widget($instance);

        echo $args['after_widget'];
    }

    /**
     * Render widget content
     *
     * @param  array $instance
     *
     */
    public function render_widget( $instance )
    {
        require_once 'class.jnews-review-frontend.php';
        $review = \JNews_Review_Frontend::getInstance();

        $output =
            "<div class='jeg_review_list_widget'>" .
                $review->review_list($instance) .
            "</div>";

        echo $output;
    }
}