<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}

if ( ! class_exists( 'JNews_Push_Notification_Shortcode' ) )
{
    class JNews_Push_Notification_Shortcode
    {
        /**
         * @var JNews_Push_Notification_Shortcode
         */
        private static $instance;

        /**
         * @var string
         */
        private $prefix = 'add';

        /**
         * @var string
         */
        private $separator = '_';

        /**
         * @var string
         */
        private $suffix = 'shortcode';

        /**
         * @return JNews_Push_Notification_Shortcode
         */
        public static function getInstance()
        {
            if (null === static::$instance)
            {
                static::$instance = new static();
            }
            return static::$instance;
        }

        /**
         * JNews_Push_Notification_Shortcode constructor
         */
        private function __construct()
        {
            $this->set_option();
            $this->set_element();
        }

        /**
         * Register shortcode option
         */
        protected function set_option()
        {
            vc_map(
                array(
                    "name"          => 'JNews - Push Notification',
                    "base"          => 'jnews_element_push_notification',
                    "category"      => 'JNews - Element',
                    "icon"          => 'jnews_element_push_notification',
                    "description"   => 'JNews - Push Notification Form',
                    "params" => array(
                        array(
                            'type'          => 'textarea',
                            'param_name'    => 'description',
                            'heading'       => esc_html__('Subscribe Description', 'jnews-push-notification'),
                            'description'   => esc_html__('You may use standard HTML tags and attributes for subscribe description.','jnews-push-notification'),
                        ),
                        array(
                            'type'          => 'textfield',
                            'param_name'    => 'btn_subscribe',
                            'heading'       => esc_html__('Subscribe Button Text', 'jnews-push-notification'),
                            'description'   => esc_html__('Insert text for subscribe button.','jnews-push-notification'),
                        ),
                        array(
                            'type'          => 'textfield',
                            'param_name'    => 'btn_unsubscribe',
                            'heading'       => esc_html__('Unsubscribe Button Text', 'jnews-push-notification'),
                            'description'   => esc_html__('Insert text for unsubscribe button.','jnews-push-notification'),
                        ),
                        array(
                            'type'          => 'textfield',
                            'param_name'    => 'btn_processing',
                            'heading'       => esc_html__('Processing Button Text', 'jnews-push-notification'),
                            'description'   => esc_html__('Insert text for processing button.','jnews-push-notification'),
                        ),
                    )
                )
            );
        }

        /**
         * Register shortcode element
         */
        protected function set_element()
        {   
            call_user_func_array( $this->get_shortcode_func() , array( 
                'jnews_element_push_notification', array( $this, 'render_shortcode' ) 
            ) );
        }

        protected function get_shortcode_func()
        {
            return $this->prefix . $this->separator . $this->suffix;
        }

        /**
         * Render shortcode content
         * 
         * @param  array $atts
         * 
         * @return string
         *       
         */
        public function render_shortcode( $atts )
        {
            if ( function_exists( 'is_amp_endpoint()' ) && is_amp_endpoint() ) return;

            $atts = shortcode_atts(
                array(
                    'description'       => '',
                    'btn_subscribe'     => jnews_return_translation( 'Subscribe', 'jnews-push-notification', 'push_notification_subscribe' ),
                    'btn_unsubscribe'   => jnews_return_translation( 'Unsubscribe', 'jnews-push-notification', 'push_notification_unsubscribe' ),
                    'btn_processing'    => jnews_return_translation( 'Processing . . .', 'jnews-push-notification', 'push_notification_processing' ),
                ),
                $atts
            );

            $output = "<div class=\"jeg_push_notification\">
                            <div class=\"jeg_push_notification_content\">
                                <p>" . str_replace( PHP_EOL, "<br>", $atts['description'] ) . "</p>
                                <div class=\"jeg_push_notification_button\">
                                    <input type=\"hidden\" name=\"button-subscribe\" value=\"{$atts['btn_subscribe']}\">
                                    <input type=\"hidden\" name=\"button-unsubscribe\" value=\"{$atts['btn_unsubscribe']}\">
                                    <input type=\"hidden\" name=\"button-processing\" value=\"{$atts['btn_processing']}\">
                                    <a data-action=\"subscribe\" class=\"button\" data-type=\"general\" href=\"#\">
                                        <i class=\"fa fa-bell-o\"></i>
                                        {$atts['btn_subscribe']}
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

            return $output;
        }
    }
}