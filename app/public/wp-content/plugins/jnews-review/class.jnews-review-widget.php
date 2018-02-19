<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

Class JNews_Review_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'jnews_single_review',
            esc_html__('JNews : Single Post Review Widget', 'jnews-review'), // Name
            array(
                'description' =>  esc_html__('Single Post Review widget for JNews', 'jnews-review'),
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
            'disablerating'   => array(
                'title'     => esc_html__('Disable Rating Point', 'jnews-review'),
                'desc'      => esc_html__('hide rating point on this widget.', 'jnews-review'),
                'type'      => 'checkbox'
            ),
            'showdescription'   => array(
                'title'     => esc_html__('Show summary', 'jnews-review'),
                'desc'      => esc_html__('show review summary on this widget.', 'jnews-review'),
                'type'      => 'checkbox'
            ),
            'hideprocons'   => array(
                'title'     => esc_html__('Hide Pro & Cons', 'jnews-review'),
                'desc'      => esc_html__('hide review summary on this widget.', 'jnews-review'),
                'type'      => 'checkbox'
            ),
            'hideprice'   => array(
                'title'     => esc_html__('Hide Price for Affiliate', 'jnews-review'),
                'desc'      => esc_html__('hide product price on this widget', 'jnews-review'),
                'type'      => 'checkbox'
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
        if(is_single() && jnews_review_enable_review( null, get_the_ID()))
        {
            $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : "");

            echo $args['before_widget'];

            if (!empty($title)) {
                echo $args['before_title'] . esc_html($title) . $args['after_title'];
            }

            $this->render_widget($instance);

            echo $args['after_widget'];
        }
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

        $output = '';

        if(!isset($instance['disablerating'])) {
            $output .= $review->widget_rating();
        }

        if(isset($instance['showdescription']) && $instance['showdescription']) {
            $output .= $review->widget_description();
        }

        if(!isset($instance['hideprocons'])) {
            $output .= $review->widget_procons();
        }

        if(!isset($instance['hideprice'])) {
            $output .= $review->widget_price();
        }


        $output =
            "<div class='jeg_review_widget'>" .
                $output .
            "</div>";

        echo $output;
    }

    protected function get_widget_template(){}
}