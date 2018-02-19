<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Customizer;

/**
 * Class Theme JNews Customizer
 */
Class SocialOption extends CustomizerOptionAbstract
{
    public function __construct($customizer, $id)
    {
        parent::__construct($customizer, $id);
    }

    public function set_option()
    {
        $this->set_panel();
        $this->set_section();
        $this->set_social_icon_field();
    }

    public function set_panel()
    {
        $this->customizer->add_panel(array(
            'id' => 'jnews_social_panel',
            'title' => esc_html__('JNews : Social, Like & View', 'jnews'),
            'description' => esc_html__('Social, Like & View Option', 'jnews'),
            'priority' => $this->id
        ));
    }

    public function set_section()
    {
        /** additional font setting */
        $this->customizer->add_section(array(
            'id'            => 'jnews_social_icon_section',
            'title'         => esc_html__('Social Icon', 'jnews'),
            'panel'         => 'jnews_social_panel',
            'priority'      => $this->id
        ));
    }

    /**
     * Set Section
     */
    public function set_social_icon_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_social_icon_notice',
            'type'          => 'jnews-alert',
            'default'       => 'info',
            'section'       => 'jnews_social_icon_section',
            'label'         => esc_html__('Info','jnews' ),
            'description'   => wp_kses(__(
                '<ul>
                    <li>This social icon will show on header & footer of your website. </li>
                    <li>Also will be used if you install JNews - Meta Header & JNews - JSON LD plugin</li>
                </ul>',
                'jnews'), wp_kses_allowed_html()),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_social_icon',
            'transport'     => 'postMessage',
            'type'          => 'repeater',
            'section'       => 'jnews_social_icon_section',
            'label'         => esc_html__('Add Social Icon', 'jnews'),
            'description'   => esc_html__('Add icon for each of your social account.', 'jnews'),
            'default'       => array(
                array(
                    'social_icon' => 'facebook',
                    'social_url'  => 'https://www.facebook.com/jegtheme/'
                ),
                array(
                    'social_icon' => 'twitter',
                    'social_url'  => 'https://twitter.com/jegtheme'
                ),
            ),
            'row_label'     => array(
                'type' => 'text',
                'value' => esc_attr__( 'Social Icon', 'jnews' ),
                'field' => false,
            ),
            'fields' => array(
                'social_icon' => array(
                    'type'        => 'select',
                    'label'       => esc_attr__( 'Social Icon', 'jnews' ),
                    'default'     => '',
                    'choices'     => array(
                        ''              => esc_attr__( 'Choose Icon', 'jnews' ),
                        'facebook'      => esc_attr__( 'Facebook', 'jnews' ),
                        'twitter'       => esc_attr__( 'Twitter', 'jnews' ),
                        'linkedin'      => esc_attr__( 'Linkedin', 'jnews' ),
                        'googleplus'    => esc_attr__( 'Google+', 'jnews' ),
                        'pinterest'     => esc_attr__( 'Pinterest', 'jnews' ),
                        'behance'       => esc_attr__( 'Behance', 'jnews' ),
                        'github'        => esc_attr__( 'Github', 'jnews' ),
                        'flickr'        => esc_attr__( 'Flickr', 'jnews' ),
                        'tumblr'        => esc_attr__( 'Tumblr', 'jnews' ),
                        'dribbble'      => esc_attr__( 'Dribbble', 'jnews' ),
                        'soundcloud'    => esc_attr__( 'Soundcloud', 'jnews' ),
                        'instagram'     => esc_attr__( 'Instagram', 'jnews' ),
                        'vimeo'         => esc_attr__( 'Vimeo', 'jnews' ),
                        'youtube'       => esc_attr__( 'Youtube', 'jnews' ),
                        'twitch'        => esc_attr__( 'Twitch', 'jnews' ),
                        'vk'            => esc_attr__( 'Vk', 'jnews' ),
                        'reddit'        => esc_attr__( 'Reddit', 'jnews' ),
                        'weibo'         => esc_attr__( 'Weibo', 'jnews' ),
                        'rss'           => esc_attr__( 'RSS', 'jnews' ),
                    ),
                ),
                'social_url' => array(
                    'type'        => 'text',
                    'label'       => esc_attr__( 'Social URL', 'jnews' ),
                    'default'     => '',
                ),
            ),
            'partial_refresh' => array (
                'social_icon' => array (
                    'selector'              => '.jeg_top_socials',
                    'render_callback'       => function() {
                        return jnews_generate_social_icon(false);
                    },
                ),
                'social_icon2' => array (
                    'selector'              => '.jeg_social_icon_block',
                    'render_callback'       => function() {
                        return jnews_generate_social_icon_block(false);
                    },
                ),
                'social_icon3' => array (
                    'selector'              => '.jeg_new_social_icon_block',
                    'render_callback'       => function() {
                        return jnews_generate_social_icon_block(false, true);
                    },
                ),
                'social_icon_mobile_menu' => array (
                    'selector'              => '.jeg_mobile_socials',
                    'render_callback'       => function() {
                        return jnews_generate_social_icon(false);
                    },
                ),
            ),
        ));
    }
}