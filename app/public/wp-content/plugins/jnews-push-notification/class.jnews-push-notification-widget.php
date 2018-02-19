<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}

Class JNews_Push_Notification_Widget extends WP_Widget
{
     /**
     * @var JNews_Push_Notification
     */
    private $push_notification_instance;

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct (
            'jnews_push_notification', // Base ID
            esc_html__('Push Notification', 'jnews'), // Name
            array(
                'description' =>  esc_html__('Push Notification for JNews', 'jnews'),
                'customize_selective_refresh' => true
            ), // Args
            null
        );
    }

    public function form($instance)
    {
        $options = array (
            'title' => array(
                'title'     => esc_html__('Title', 'jnews-push-notification'),
                'desc'      => esc_html__('Title on widget header.', 'jnews-push-notification'),
                'type'      => 'text'
            ),
            'description' => array(
                'title'     => esc_html__('Subscribe Description', 'jnews-push-notification'),
                'desc'      => esc_html__('You may use standard HTML tags and attributes for subscribe description.', 'jnews-push-notification'),
                'type'      => 'textarea'
            ),
            'btn_subscribe' => array(
                'title'     => esc_html__('Subscribe Button Text', 'jnews-push-notification'),
                'desc'      => esc_html__('Insert text for subscribe button.', 'jnews-push-notification'),
                'type'      => 'text',
            ),
            'btn_unsubscribe' => array(
                'title'     => esc_html__('Unsubscribe Button Text', 'jnews-push-notification'),
                'desc'      => esc_html__('Insert text for unsubscribe button.', 'jnews-push-notification'),
                'type'      => 'text',
            ),
            'btn_processing' => array(
                'title'     => esc_html__('Processing Button Text', 'jnews-push-notification'),
                'desc'      => esc_html__('Insert text for processing button.', 'jnews-push-notification'),
                'type'      => 'text'
            ),
        );

        $generator = new \JNews\Widget\WidgetGenerator($this);
        $generator->render_form($options, $instance);
    }

    /**
     * Init widget
     * 
     * @param  array $args    
     * @param  array $instance
     * 
     */
    public function widget( $args, $instance )
    {
        $title = apply_filters( 'widget_title', isset($instance['title']) ? $instance['title'] : "" );

        echo $args['before_widget'];

        if ( ! empty( $title ) ) 
        {
            echo $args['before_title'] . wp_kses( $title, wp_kses_allowed_html() ) . $args['after_title'];
        }

        $this->render_content( $instance );

        echo $args['after_widget'];
    }

    /**
     * Render widget content
     * 
     * @param  array $instance
     *  
     */
    public function render_content( $instance )
    {
        if ( empty( $instance['btn_subscribe'] ) ) 
        {
            $instance = jnews_return_translation( 'Subscribe', 'jnews-push-notification', 'push_notification_subscribe' );
        }

        if ( empty( $instance['btn_unsubscribe'] ) ) 
        {
            $instance = jnews_return_translation( 'Unsubscribe', 'jnews-push-notification', 'push_notification_unsubscribe' );
        }

        if ( empty( $instance['btn_processing'] ) ) 
        {
            $instance = jnews_return_translation( 'Processing . . .', 'jnews-push-notification', 'push_notification_processing' );
        }

        $output = "<div class=\"jeg_push_notification loading\">
                        <div class=\"jeg_push_notification_content\">
                            <p>" . str_replace( PHP_EOL, "<br>", $instance['description'] ) . "</p>
                            <div class=\"jeg_push_notification_button\">
                                <input type=\"hidden\" name=\"button-subscribe\" value=\"{$instance['btn_subscribe']}\">
                                <input type=\"hidden\" name=\"button-unsubscribe\" value=\"{$instance['btn_unsubscribe']}\">
                                <input type=\"hidden\" name=\"button-processing\" value=\"{$instance['btn_processing']}\">
                                <a data-action=\"subscribe\" class=\"button\" data-type=\"general\" href=\"#\">
                                    <i class=\"fa fa-bell-o\"></i>
                                    {$instance['btn_subscribe']}
                                </a>
                            </div>
                        </div>
                    </div>";

        if ( ! class_exists('OneSignal_Admin') )
        {
            $output =
                "<div class=\"alert alert-error\">
                    <strong>" . esc_html__('Plugin Install','jnews') . "</strong>" . ' : ' . esc_html__('Subscribe Push Notification need OneSignal plugin to be installed', 'jnews') .
                "</div>";
        }

        echo $output;
    }
}