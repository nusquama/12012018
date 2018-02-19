<?php
/**
 * @author : Jegtheme
 */

/**
 * Class Theme JNews Option
 */
Class JNews_Social_Login_Option
{
    /**
     * @var JNews_Social_Login_Option
     */
    private static $instance;

    /**
     * @var Jeg\Customizer
     */
    private $customizer;

    /**
     * @return JNews_Social_Login_Option
     */
    public static function getInstance()
    {
        if ( null === static::$instance )
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * JNews_Social_Login_Option constructor
     */
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

    /**
     * Social login panel
     */
    public function set_panel()
    {
        $this->customizer->add_panel(array(
            'id' => 'jnews_social_panel',
            'title' => esc_html__('JNews : Social, Like & View', 'jnews'),
            'description' => esc_html__('Social, Like & View Option', 'jnews'),
            'priority' => 200
        ));
    }

    /**
     * Social login section
     */
    public function set_section()
    {
        $this->customizer->add_section(array(
            'id'       => 'jnews_social_login_section',
            'title'    => esc_html__('Social Login Setting', 'jnews-social-login'),
            'panel'    => 'jnews_social_panel',
            'priority' => 253,
        ));
    }

    /**
     * Social login option field
     */
    public function set_field()
    {
        $user_role = array(
            'subscriber'  => esc_html__('Subscriber', 'jnews-social-login'),
            'contributor' => esc_html__('Contributor', 'jnews-social-login'),
        );

        if ( $this->bbpress_plugin_check() ) 
        {
            $user_role['participant'] = esc_html__('Participant', 'jnews-social-login');
        }

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_alert]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => 'info',
            'type'            => 'jnews-alert',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Social Login Info','jnews-social-login'),
            'description'     => $this->show_social_info(),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_show]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => 'hide',
            'type'            => 'jnews-select',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Show Social Login','jnews-social-login'),
            'description'     => esc_html__('Choose the location to display the social login & registration.','jnews-social-login'),
            'choices'         => array(
                'login'    => esc_html__('Login Only', 'jnews-social-login'),
                'register' => esc_html__('Registration Only', 'jnews-social-login'),
                'both'     => esc_html__('Show on Both', 'jnews-social-login'),
                'hide'     => esc_html__('Hide', 'jnews-social-login'),
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_user_role]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => 'subscriber',
            'type'            => 'jnews-select',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('User Role','jnews-social-login'),
            'description'     => esc_html__('Choose new user default role.','jnews-social-login'),
            'choices'         => $user_role,
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_style]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => 'normal',
            'type'            => 'jnews-select',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Social Login Style','jnews-social-login'),
            'description'     => esc_html__('Choose social login button style.','jnews-social-login'),
            'choices'         => array(
                'normal' => esc_html__('Normal', 'jnews-social-login'),
                'light'  => esc_html__('Light', 'jnews-social-login'),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_enable_facebook]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => '',
            'type'            => 'jnews-toggle',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Facebook Integration','jnews-social-login'),
            'description'     => esc_html__('Enable Facebook login and registration.','jnews-social-login'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_facebook_id]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => '',
            'type'            => 'text',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Facebook App ID','jnews-social-login'),
            'description'     => sprintf(__('You can create an application and get Facebook App ID <a href="%s" target="_blank">here</a>.', 'jnews-social-login'), 'https://developers.facebook.com/docs/apps/register'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                ),
                array(
                    'setting'  => 'jnews_option[social_login_enable_facebook]',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_facebook_secret]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => '',
            'type'            => 'text',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Facebook App Secret','jnews-social-login'),
            'description'     => sprintf(__('You can create an application and get Facebook App Secret <a href="%s" target="_blank">here</a>.', 'jnews-social-login'), 'https://developers.facebook.com/docs/apps/register'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                ),
                array(
                    'setting'  => 'jnews_option[social_login_enable_facebook]',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_enable_google]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => '',
            'type'            => 'jnews-toggle',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Google Integration','jnews-social-login'),
            'description'     => esc_html__('Enable Google login and registration.','jnews-social-login'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_google_app_name]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => '',
            'type'            => 'text',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Google Apps Name','jnews-social-login'),
            'description'     => sprintf(__('You can create an application and get Google Apps <a href="%s" target="_blank">here</a>.', 'jnews-social-login'), 'https://developers.google.com/+/web/api/rest/oauth'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                ),
                array(
                    'setting'  => 'jnews_option[social_login_enable_google]',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_google_id]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => '',
            'type'            => 'text',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Google Client ID','jnews-social-login'),
            'description'     => sprintf(__('You can create an application and get Google Client ID <a href="%s" target="_blank">here</a>.', 'jnews-social-login'), 'https://developers.google.com/+/web/api/rest/oauth'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                ),
                array(
                    'setting'  => 'jnews_option[social_login_enable_google]',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_google_secret]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => '',
            'type'            => 'text',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Google Client Secret','jnews-social-login'),
            'description'     => sprintf(__('You can create an application and get Google Client Secret <a href="%s" target="_blank">here</a>.', 'jnews-social-login'), 'https://developers.google.com/+/web/api/rest/oauth'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                ),
                array(
                    'setting'  => 'jnews_option[social_login_enable_google]',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_enable_linkedin]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => '',
            'type'            => 'jnews-toggle',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Linked In Integration','jnews-social-login'),
            'description'     => esc_html__('Enable Linked In login and registration.','jnews-social-login'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_linkedin_id]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => '',
            'type'            => 'text',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Linked In Client ID','jnews-social-login'),
            'description'     => sprintf(__('You can create an application and get Linked In Client ID <a href="%s" target="_blank">here</a>.', 'jnews-social-login'), 'https://www.linkedin.com/secure/developer'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                ),
                array(
                    'setting'  => 'jnews_option[social_login_enable_linkedin]',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'              => 'jnews_option[social_login_linkedin_secret]',
            'option_type'     => 'option',
            'transport'       => 'postMessage',
            'default'         => '',
            'type'            => 'text',
            'section'         => 'jnews_social_login_section',
            'label'           => esc_html__('Linked In Client Secret','jnews-social-login'),
            'description'     => sprintf(__('You can create an application and get Linked In Client Secret <a href="%s" target="_blank">here</a>.', 'jnews-social-login'), 'https://www.linkedin.com/secure/developer'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[social_login_show]',
                    'operator' => '!=',
                    'value'    => 'hide',
                ),
                array(
                    'setting'  => 'jnews_option[social_login_enable_linkedin]',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));
    }

    /**
     * Check bbpress plugin
     * 
     * @return boolean
     * 
     */
    public function bbpress_plugin_check()
    {
        if ( !function_exists( 'get_plugins' ) ) 
        {
            require_once ABSPATH . '/wp-admin/includes/plugin.php';
        }

        if ( get_plugins('/bbpress') ) 
        {
            if ( is_plugin_active('bbpress/bbpress.php') ) 
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Social login info
     * 
     * @return string
     * 
     */
    public function show_social_info()
    {
        $facebook_url = apply_filters( 'jeg_social_url_filter', '', 'facebook' );
        $google_url   = apply_filters( 'jeg_social_url_filter', '', 'google' );
        $linkedin_url = apply_filters( 'jeg_social_url_filter', '', 'linkedin' );

        if ( get_option( 'permalink_structure' ) ) 
        {
            return wp_kses(
                        sprintf(
                            __("You will be asked to enter callback url when you configure apps. Please use below url :
                                <ol>
                                    <li><strong>Facebook</strong> : %s</li>
                                    <li><strong>Google</strong> : %s</li>
                                    <li><strong>Linked In</strong> : %s</li>
                                 </ol>", "jnews-weather"), 
                        $facebook_url, $google_url, $linkedin_url ), wp_kses_allowed_html()
                    );
        } else {
            return wp_kses(__("Please <strong>Do not use Plain Permalink setting</strong>. To change this setting, please go to Settings > Permalinks.", 'jnews-social-login' ), wp_kses_allowed_html());
        }
    }
}
