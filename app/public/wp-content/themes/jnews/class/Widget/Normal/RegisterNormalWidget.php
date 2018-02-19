<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Widget\Normal;

Class RegisterNormalWidget
{
    /**
     * @var RegisterNormalWidget
     */
    private static $instance;

    /**
     * @return RegisterNormalWidget
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
        include get_parent_theme_file_path ('class/Widget/Normal/normal-widget.php');
        add_action('widgets_init', array($this, 'register_widget_normal') );
    }

    public function register_widget_normal()
    {
        $modules = array(
            "About_Widget",
            "Popular_Widget",
            "Line_Widget",
            "Recent_News_Widget",
            "Tab_Post_Widget",
            "Social_Widget",
            "Social_Counter_Widget",
            "Facebook_Page_Widget",
            "Twitter_Widget",
            "Google_Plus_Widget",
            "Pinterest_Widget",
            "Instagram_Widget",
            "Flickr_Widget",
            "Behance_Widget",
        );

        foreach($modules as $module) {
            register_widget($module);
        }
    }
}

