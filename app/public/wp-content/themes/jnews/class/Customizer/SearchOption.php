<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Customizer;

use JNews\Archive\SearchArchive;

/**
 * Class Theme JNews Customizer
 */
Class SearchOption extends CustomizerOptionAbstract
{
    private $section_global_live_search = 'jnews_global_live_search_section';
    private $section_search = 'jnews_global_search_section';

    public function __construct($customizer, $id)
    {
        parent::__construct($customizer, $id);
    }

    public function set_option()
    {
        $this->set_panel();
        $this->set_section();


        $this->set_global_live_search_field();
        $this->set_search_content_field();
    }

    public function set_panel()
    {
        $this->customizer->add_panel(array(
            'id' => 'jnews_search_panel',
            'title' => esc_html__('JNews : Search Option', 'jnews'),
            'description' => esc_html__('Search Option', 'jnews'),
            'priority' => $this->id
        ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id' => $this->section_search,
            'title' => esc_html__('Search Content', 'jnews'),
            'panel' => 'jnews_search_panel',
            'priority' => 250,
        ));

        $this->customizer->add_section(array(
            'id' => $this->section_global_live_search,
            'title' => esc_html__('Live Search Setting', 'jnews'),
            'panel' => 'jnews_search_panel',
            'priority' => 250,
        ));
    }

    /**
     * Set Section
     */
    public function set_search_content_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_search_only_post',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_search,
            'label'         => esc_html__('Only Search Post','jnews'),
            'description'   => esc_html__('WordPress default search will also look for your single page, enable this feature to only search post type.','jnews'),
            'partial_refresh' => array (
                'jnews_search_only_post' => array (
                    'selector'        => '.jnews_search_content_wrapper',
                    'render_callback' => function() {
                        $single = new SearchArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array( array(
                'redirect'  => 'search_tag',
                'refresh'   => false
            ) )
        ));
    }


    public function set_global_live_search_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_live_search_show',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_live_search,
            'label'         => esc_html__('Enable Live Search Block','jnews'),
            'description'   => esc_html__('Turn this option on to enable live search.','jnews'),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_live_search_number_post',
            'transport'     => 'postMessage',
            'default'       => 4,
            'type'          => 'jnews-slider',
            'section'       => $this->section_global_live_search,
            'label'         => esc_html__('Live Search Number of Post', 'jnews'),
            'description'   => esc_html__('Set the number of post on live search result.', 'jnews'),
            'choices'     => array(
                'min'  => '1',
                'max'  => '10',
                'step' => '1',
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_live_search_show',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_live_search_date',
            'transport'     => 'postMessage',
            'default'       => 'default',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_live_search,
            'label'         => esc_html__('Live Search Date Format','jnews'),
            'description'   => esc_html__('Choose which date format you want to use for live search.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'ago' => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
                'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
                'custom' => esc_attr__( 'Custom Format', 'jnews' ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_live_search_show',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_live_search_date_custom',
            'transport'     => 'postMessage',
            'default'       => 'Y/m/d',
            'type'          => 'text',
            'section'       => $this->section_global_live_search,
            'label'         => esc_html__('Custom Live Search Date Format','jnews'),
            'description'   => wp_kses(sprintf(__("Please set custom date format for live search. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews"), "https://developer.wordpress.org/reference/functions/current_time/"),
                wp_kses_allowed_html()),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_live_search_date',
                    'operator' => '==',
                    'value'    => 'custom',
                ),
                array(
                    'setting'  => 'jnews_live_search_show',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));
    }
}