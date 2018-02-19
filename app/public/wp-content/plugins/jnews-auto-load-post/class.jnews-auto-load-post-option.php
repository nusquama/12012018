<?php
/**
 * @author : Jegtheme
 */

/**
 * Class Theme JNews Option
 */
Class JNews_Auto_Load_Post_Option
{
    /**
     * @var JNews_Gallery_Option
     */
    private static $instance;

    /**
     * @var Jeg\Customizer
     */
    private $customizer;

    private $section_autoload = 'jnews_autoload_section';


    /**
     * @return JNews_Gallery_Option
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
        /** panel */
        $this->customizer->add_panel(array(
            'id' => 'jnews_global_panel',
            'title' => esc_html__('JNews : General Option', 'jnews-auto-load-post'),
            'description' => esc_html__('JNews General Option', 'jnews-auto-load-post'),
            'priority' => 200
        ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id' => $this->section_autoload,
            'title' => esc_html__('Auto Load Scroll Post Option', 'jnews-auto-load-post'),
            'panel' => 'jnews_single_post_panel',
            'priority' => 200,
        ));
    }

    public function set_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_autoload_blog_alert',
            'type'          => 'jnews-alert',
            'default'       => 'warning',
            'section'       => $this->section_autoload,
            'label'         => esc_html__('Attention','jnews-auto-load-post' ),
            'description'   => wp_kses(__('<ul>
                    <li>All setting on single post customizer option or single post metabox overwritten by this option.</li>
                    <li>Several option will also disabled. Such as Sidebar on Mobile, Next Prev link, Popup for related post.</li>
                    <li>We disable autoload effect on customizer. But you can see it on your website.</li>
                </ul>','jnews-auto-load-post'), wp_kses_allowed_html()),
        ));
        
        $this->customizer->add_field(array(
            'id'            => 'jnews_autoload_blog_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_autoload,
            'label'         => esc_html__('Single Template & Layout','jnews-auto-load-post' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[autoload_blog_template]',
            'transport'     => 'postMessage',
            'option_type'   => 'option',
            'default'       => '1',
            'type'          => 'jnews-radio-image',
            'section'       => $this->section_autoload,
            'label'         => esc_html__('Single Blog Post Template','jnews-auto-load-post' ),
            'description'   => esc_html__('Choose your single blog post template.','jnews-auto-load-post' ),
            'choices'       => array(
                '1' => '',
                '2' => '',
                '3' => '',
                '6' => '',
                '7' => '',
                '8' => '',
                '9' => '',
                '10' => '',
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'single_post_tag',
                    'refresh'   => true
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[autoload_blog_layout]',
            'transport'     => 'postMessage',
            'option_type'   => 'option',
            'default'       => 'right-sidebar',
            'type'          => 'jnews-radio-image',
            'section'       => $this->section_autoload,
            'label'         => esc_html__('Single Blog Post Layout','jnews-auto-load-post' ),
            'description'   => esc_html__('Choose your single blog post layout.','jnews-auto-load-post' ),
            'choices'       => array(
                'right-sidebar'         => '',
                'left-sidebar'          => '',
                'no-sidebar'            => '',
                'no-sidebar-narrow'     => '',
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'single_post_tag',
                    'refresh'   => true
                )
            )
        ));

        $all_sidebar = apply_filters('jnews_get_sidebar_widget', null);

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[autoload_sidebar]',
            'transport'     => 'postMessage',
            'option_type'   => 'option',
            'default'       => 'default-sidebar',
            'type'          => 'jnews-select',
            'section'       => $this->section_autoload,
            'label'         => esc_html__('Single post sidebar','jnews-auto-load-post'),
            'description'   => esc_html__('Choose your post sidebar. If you need another sidebar, you can create from WordPress Admin &raquo; Appearance &raquo; Widget.','jnews-auto-load-post'),
            'multiple'      => 1,
            'choices'       => $all_sidebar,
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_option[autoload_blog_layout]',
                    'operator' => 'contains',
                    'value'    => array('left-sidebar', 'right-sidebar'),
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'single_post_tag',
                    'refresh'   => true
                )
            ),
            'wrapper_class' => array('first_child')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[autoload_disable_comment]',
            'transport'     => 'postMessage',
            'option_type'   => 'option',
            'default'       => 'hide',
            'type'          => 'jnews-select',
            'section'       => $this->section_autoload,
            'label'         => esc_html__('Show / Hide Comment','jnews-auto-load-post'),
            'description'   => esc_html__('Choose if you want to hide comment on single post.','jnews-auto-load-post'),
            'choices'     => array(
                'hide'  => esc_attr__( 'Hide Comment', 'jnews-auto-load-post' ),
                'show'  => esc_attr__( 'Show Comment', 'jnews-auto-load-post' ),
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'single_post_tag',
                    'refresh'   => false
                )
            ),
            'partial_refresh' => array (
                'jnews_option[autoload_disable_comment]' => array (
                    'selector'        => '.jnews_comment_container',
                    'render_callback' => function() {
                        $single = JNews\Single\SinglePost::getInstance();
                        $single->post_comment();
                    },
                ),
            ),
        ));
    }
}
