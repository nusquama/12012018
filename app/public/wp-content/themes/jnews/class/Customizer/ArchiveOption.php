<?php
/**
* @author : Jegtheme
*/
namespace JNews\Customizer;
use JNews\Archive\AuthorArchive;
use JNews\Archive\NotFoundArchive;
use JNews\Archive\SearchArchive;
use JNews\Archive\SingleArchive;

/**
 * Class Theme JNews Customizer
 */
Class ArchiveOption extends CustomizerOptionAbstract
{
    private $section_archive = 'jnews_archive_section';
    private $section_search = 'jnews_search_section';
    private $section_author = 'jnews_author_section';
    private $section_attachment = 'jnews_attachment_section';
    private $section_404 = 'jnews_404_section';
    private $section_woocommerce = 'jnews_woocommerce';
    private $section_bbpress = 'jnews_bbpress';

    private $all_sidebar = null;

    public function set_option()
    {
        $this->all_sidebar = apply_filters('jnews_get_sidebar_widget', null);

        $this->set_panel();
        $this->set_section();
        $this->set_archive_field();
        $this->set_search_field();
        $this->set_author_field();
        $this->set_attachment_field();
        $this->set_404_field();

        if ( function_exists( 'is_woocommerce' ) ) {
            $this->set_woocommerce_field();
        }
        if ( function_exists( 'is_bbpress' ) ) {
            $this->set_bbpress_field();
        }
    }


    public function set_panel()
    {
        /** panel */
        $this->customizer->add_panel(array(
            'id'            => 'jnews_archive',
            'title'         => esc_html__( 'JNews : Other Template', 'jnews' ),
            'description'   => esc_html__( 'JNews template for archive, search and author.', 'jnews' ),
            'priority'      => $this->id
        ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_archive,
            'title'         => esc_html__('Archive Template', 'jnews' ),
            'panel'         => 'jnews_archive',
            'priority'      => 250,
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_search,
            'title'         => esc_html__('Search Template', 'jnews' ),
            'panel'         => 'jnews_archive',
            'priority'      => 250,
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_author,
            'title'         => esc_html__('Author Template', 'jnews' ),
            'panel'         => 'jnews_archive',
            'priority'      => 250,
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_attachment,
            'title'         => esc_html__('Attachment Template', 'jnews' ),
            'panel'         => 'jnews_archive',
            'priority'      => 250,
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_404,
            'title'         => esc_html__('404 (Not Found) Template', 'jnews' ),
            'panel'         => 'jnews_archive',
            'priority'      => 250,
        ));

        if ( function_exists( 'is_woocommerce' ) )
        {
            $this->customizer->add_section(array(
                'id' => $this->section_woocommerce,
                'title' => esc_html__('WooCommerce Template', 'jnews'),
                'panel' => 'jnews_archive',
                'priority' => 250,
            ));
        }

        if ( function_exists( 'is_bbpress' ) )
        {
            $this->customizer->add_section(array(
                'id' => $this->section_bbpress,
                'title' => esc_html__('BBPress Template', 'jnews'),
                'panel' => 'jnews_archive',
                'priority' => 250,
            ));
        }
    }

    public function set_archive_field()
    {
        // sidebar section
        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_sidebar_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Archive Sidebar','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_show_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Show Sidebar','jnews'),
            'description'   => esc_html__('Show sidebar for archive.','jnews'),
            'postvar'       => array( array(
                'redirect'  => 'archive_tag',
                'refresh'   => true
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_sidebar',
            'transport'     => 'postMessage',
            'default'       => 'default-sidebar',
            'type'          => 'jnews-select',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Archive Sidebar','jnews'),
            'description'   => wp_kses(__("Choose your archive sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews'), wp_kses_allowed_html()),
            'multiple'      => 1,
            'choices'       => $this->all_sidebar,
            'postvar'       => array(
                array(
                    'redirect'  => 'archive_tag',
                    'refresh'   => true
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_archive_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_sticky_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Archive Sticky Sidebar','jnews'),
            'description'   => esc_html__('Enable sticky sidebar on archive page.','jnews'),
            'postvar'       => array(
                array(
                    'redirect'  => 'archive_tag',
                    'refresh'   => true
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_archive_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        // content type
        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_content_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Archive Content','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_content',
            'transport'     => 'postMessage',
            'default'       => '3',
            'type'          => 'jnews-radio-image',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Archive Content Layout','jnews'),
            'description'   => esc_html__('Choose your archive content layout.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                '3'  => '',
                '4'  => '',
                '5'  => '',
                '6'  => '',
                '7'  => '',
                '9'  => '',
                '10' => '',
                '11' => '',
                '12' => '',
                '14' => '',
                '15' => '',
                '18' => '',
                '22' => '',
                '23' => '',
                '25' => '',
                '26' => '',
                '27' => '',
            ),
            'partial_refresh' => array (
                'jnews_archive_content' => array (
                    'selector'        => '.jnews_archive_content_wrapper',
                    'render_callback' => function() {
                        $single = new SingleArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array( array(
                'redirect'  => 'archive_tag',
                'refresh'   => false
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_content_excerpt',
            'transport'     => 'postMessage',
            'default'       => 20,
            'type'          => 'jnews-number',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Excerpt Length', 'jnews'),
            'description'   => esc_html__('Set word length of excerpt on post.', 'jnews'),
            'choices'     => array(
                'min'  => '0',
                'max'  => '200',
                'step' => '1',
            ),
            'partial_refresh' => array (
                'jnews_archive_content_excerpt' => array (
                    'selector'        => '.jnews_archive_content_wrapper',
                    'render_callback' => function() {
                        $single = new SingleArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array( array(
                'redirect'  => 'archive_tag',
                'refresh'   => false
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_content_date',
            'transport'     => 'postMessage',
            'default'       => 'default',
            'type'          => 'jnews-select',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Content Date Format','jnews'),
            'description'   => esc_html__('Choose which date format you want to use for archive content.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'ago' => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
                'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
                'custom' => esc_attr__( 'Custom Format', 'jnews' ),
            ),
            'partial_refresh' => array (
                'jnews_archive_content_date' => array (
                    'selector'        => '.jnews_archive_content_wrapper',
                    'render_callback' => function() {
                        $single = new SingleArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'archive_tag',
                    'refresh'   => false
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_content_date_custom',
            'transport'     => 'postMessage',
            'default'       => 'Y/m/d',
            'type'          => 'text',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Custom Date Format for Content','jnews'),
            'description'   => wp_kses(sprintf(__("Please set custom date format for post content. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews"), "https://developer.wordpress.org/reference/functions/current_time/"),
                wp_kses_allowed_html()),
            'postvar'       => array(
                array(
                    'redirect'  => 'archive_tag',
                    'refresh'   => false
                )
            ),
            'partial_refresh' => array (
                'jnews_archive_content_date_custom' => array (
                    'selector'        => '.jnews_archive_content_wrapper',
                    'render_callback' => function() {
                        $single = new SingleArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_archive_content_date',
                    'operator' => '==',
                    'value'    => 'custom',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_content_pagination',
            'transport'     => 'postMessage',
            'default'       => 'nav_1',
            'type'          => 'jnews-select',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Choose Pagination Mode','jnews'),
            'description'   => esc_html__('Choose which pagination mode that fit with your archive content.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'nav_1' => esc_attr__( 'Normal - Navigation 1', 'jnews' ),
                'nav_2' => esc_attr__( 'Normal - Navigation 2', 'jnews' ),
                'nav_3' => esc_attr__( 'Normal - Navigation 3', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_navigation.jeg_pagination',
                    'property'      => array(
                        'nav_1'         => 'jeg_pagenav_1',
                        'nav_2'         => 'jeg_pagenav_2',
                        'nav_3'         => 'jeg_pagenav_3',
                    ),
                ),
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'archive_tag',
                    'refresh'   => false
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_content_pagination_align',
            'transport'     => 'postMessage',
            'default'       => 'center',
            'type'          => 'jnews-select',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Pagination Align','jnews'),
            'description'   => esc_html__('Choose pagination alignment.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'left' => esc_attr__( 'Left', 'jnews' ),
                'center' => esc_attr__( 'Center', 'jnews' ),
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'archive_tag',
                    'refresh'   => false
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_archive_content_pagination',
                    'operator' => 'in',
                    'value'    => array('nav_1', 'nav_2', 'nav_3'),
                )
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_navigation.jeg_pagination',
                    'property'      => array(
                        'left'          => 'jeg_alignleft',
                        'center'        => 'jeg_aligncenter',
                    ),
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_content_pagination_show_navtext',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Show Navigation Text','jnews'),
            'description'   => esc_html__('Show navigation text (next, prev).','jnews'),
            'postvar'       => array( array(
                'redirect'  => 'archive_tag',
                'refresh'   => false
            ) ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_archive_content_pagination',
                    'operator' => 'in',
                    'value'    => array('nav_1', 'nav_2', 'nav_3'),
                )
            ),
            'output'     => array(
                array(
                    'method'        => 'remove-class',
                    'element'       => '.jeg_navigation.jeg_pagination ',
                    'property'      => 'no_navtext',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_archive_content_pagination_show_pageinfo',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_archive,
            'label'         => esc_html__('Show Page Info','jnews'),
            'description'   => esc_html__('Show page info text (Page x of y).','jnews'),
            'postvar'       => array( array(
                'redirect'  => 'archive_tag',
                'refresh'   => false
            ) ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_archive_content_pagination',
                    'operator' => 'in',
                    'value'    => array('nav_1', 'nav_2', 'nav_3'),
                )
            ),
            'output'     => array(
                array(
                    'method'        => 'remove-class',
                    'element'       => '.jeg_navigation.jeg_pagination ',
                    'property'      => 'no_pageinfo',
                )
            ),
        ));
    }

    public function set_search_field()
    {
        // sidebar section
        $this->customizer->add_field(array(
            'id'            => 'jnews_search_sidebar_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_search,
            'label'         => esc_html__('Search Sidebar','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_show_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_search,
            'label'         => esc_html__('Show Sidebar','jnews'),
            'description'   => esc_html__('Show sidebar for search.','jnews'),
            'postvar'       => array( array(
                'redirect'  => 'search_tag',
                'refresh'   => true
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_sidebar',
            'transport'     => 'postMessage',
            'default'       => 'default-sidebar',
            'type'          => 'jnews-select',
            'section'       => $this->section_search,
            'label'         => esc_html__('Search Sidebar','jnews'),
            'description'   => wp_kses(__("Choose your search sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews'), wp_kses_allowed_html()),
            'multiple'      => 1,
            'choices'       => $this->all_sidebar,
            'postvar'       => array(
                array(
                    'redirect'  => 'search_tag',
                    'refresh'   => true
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_search_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_sticky_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_search,
            'label'         => esc_html__('Search Sticky Sidebar','jnews'),
            'description'   => esc_html__('Enable sticky sidebar on search result page.','jnews'),
            'postvar'       => array(
                array(
                    'redirect'  => 'search_tag',
                    'refresh'   => true
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_search_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));


        // content type
        $this->customizer->add_field(array(
            'id'            => 'jnews_search_content_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_search,
            'label'         => esc_html__('Search Content','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_content',
            'transport'     => 'postMessage',
            'default'       => '3',
            'type'          => 'jnews-radio-image',
            'section'       => $this->section_search,
            'label'         => esc_html__('Search Content Layout','jnews'),
            'description'   => esc_html__('Choose your search content layout.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                '3'  => '',
                '4'  => '',
                '5'  => '',
                '6'  => '',
                '7'  => '',
                '9'  => '',
                '10' => '',
                '11' => '',
                '12' => '',
                '14' => '',
                '15' => '',
                '18' => '',
                '22' => '',
                '23' => '',
                '25' => '',
                '26' => '',
                '27' => '',
            ),
            'partial_refresh' => array (
                'jnews_search_content' => array (
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

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_content_excerpt',
            'transport'     => 'postMessage',
            'default'       => 20,
            'type'          => 'jnews-number',
            'section'       => $this->section_search,
            'label'         => esc_html__('Excerpt Length', 'jnews'),
            'description'   => esc_html__('Set the word length of excerpt on post.', 'jnews'),
            'choices'     => array(
                'min'  => '0',
                'max'  => '200',
                'step' => '1',
            ),
            'partial_refresh' => array (
                'jnews_search_content_excerpt' => array (
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

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_content_date',
            'transport'     => 'postMessage',
            'default'       => 'default',
            'type'          => 'jnews-select',
            'section'       => $this->section_search,
            'label'         => esc_html__('Content Date Format','jnews'),
            'description'   => esc_html__('Choose which date format you want to use for search for content.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'ago' => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
                'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
                'custom' => esc_attr__( 'Custom Format', 'jnews' ),
            ),
            'partial_refresh' => array (
                'jnews_search_content_date' => array (
                    'selector'        => '.jnews_search_content_wrapper',
                    'render_callback' => function() {
                        $single = new SearchArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'search_tag',
                    'refresh'   => false
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_content_date_custom',
            'transport'     => 'postMessage',
            'default'       => 'Y/m/d',
            'type'          => 'text',
            'section'       => $this->section_search,
            'label'         => esc_html__('Custom Date Format for Content','jnews'),
            'description'   => wp_kses(sprintf(__("Please set custom date format for post content. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews"), "https://developer.wordpress.org/reference/functions/current_time/"),
                wp_kses_allowed_html()),
            'postvar'       => array(
                array(
                    'redirect'  => 'search_tag',
                    'refresh'   => false
                )
            ),
            'partial_refresh' => array (
                'jnews_search_content_date_custom' => array (
                    'selector'        => '.jnews_search_content_wrapper',
                    'render_callback' => function() {
                        $single = new SearchArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_search_content_date',
                    'operator' => '==',
                    'value'    => 'custom',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_content_pagination',
            'transport'     => 'postMessage',
            'default'       => 'nav_1',
            'type'          => 'jnews-select',
            'section'       => $this->section_search,
            'label'         => esc_html__('Choose Pagination Mode','jnews'),
            'description'   => esc_html__('Choose which pagination mode that fit with your block.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'nav_1' => esc_attr__( 'Normal - Navigation 1', 'jnews' ),
                'nav_2' => esc_attr__( 'Normal - Navigation 2', 'jnews' ),
                'nav_3' => esc_attr__( 'Normal - Navigation 3', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_navigation.jeg_pagination',
                    'property'      => array(
                        'nav_1'         => 'jeg_pagenav_1',
                        'nav_2'         => 'jeg_pagenav_2',
                        'nav_3'         => 'jeg_pagenav_3',
                    ),
                ),
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'search_tag',
                    'refresh'   => false
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_content_pagination_align',
            'transport'     => 'postMessage',
            'default'       => 'center',
            'type'          => 'jnews-select',
            'section'       => $this->section_search,
            'label'         => esc_html__('Pagination Align','jnews'),
            'description'   => esc_html__('Choose pagination alignment.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'left' => esc_attr__( 'Left', 'jnews' ),
                'center' => esc_attr__( 'Center', 'jnews' ),
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'search_tag',
                    'refresh'   => false
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_search_content_pagination',
                    'operator' => 'in',
                    'value'    => array('nav_1', 'nav_2', 'nav_3'),
                )
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_navigation.jeg_pagination',
                    'property'      => array(
                        'left'          => 'jeg_alignleft',
                        'center'        => 'jeg_aligncenter',
                    ),
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_content_pagination_show_navtext',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_search,
            'label'         => esc_html__('Show Navigation Text','jnews'),
            'description'   => esc_html__('Show navigation text (next, prev).','jnews'),
            'postvar'       => array( array(
                'redirect'  => 'search_tag',
                'refresh'   => false
            ) ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_search_content_pagination',
                    'operator' => 'in',
                    'value'    => array('nav_1', 'nav_2', 'nav_3'),
                )
            ),
            'output'     => array(
                array(
                    'method'        => 'remove-class',
                    'element'       => '.jeg_navigation.jeg_pagination ',
                    'property'      => 'no_navtext',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_search_content_pagination_show_pageinfo',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_search,
            'label'         => esc_html__('Show Page Info','jnews'),
            'description'   => esc_html__('Show page info text (Page x of y).','jnews'),
            'postvar'       => array( array(
                'redirect'  => 'search_tag',
                'refresh'   => false
            ) ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_search_content_pagination',
                    'operator' => 'in',
                    'value'    => array('nav_1', 'nav_2', 'nav_3'),
                )
            ),
            'output'     => array(
                array(
                    'method'        => 'remove-class',
                    'element'       => '.jeg_navigation.jeg_pagination ',
                    'property'      => 'no_pageinfo',
                )
            ),
        ));
    }

    public function set_author_field()
    {
        // sidebar section
        $this->customizer->add_field(array(
            'id'            => 'jnews_author_sidebar_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_author,
            'label'         => esc_html__('Author Sidebar','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_show_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_author,
            'label'         => esc_html__('Show Sidebar','jnews'),
            'description'   => esc_html__('Show sidebar for author.','jnews'),
            'postvar'       => array( array(
                'redirect'  => 'author_tag',
                'refresh'   => true
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_sidebar',
            'transport'     => 'postMessage',
            'default'       => 'default-sidebar',
            'type'          => 'jnews-select',
            'section'       => $this->section_author,
            'label'         => esc_html__('Author Sidebar','jnews'),
            'description'   => wp_kses(__("Choose your author sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews'), wp_kses_allowed_html()),
            'multiple'      => 1,
            'choices'       => $this->all_sidebar,
            'postvar'       => array(
                array(
                    'redirect'  => 'author_tag',
                    'refresh'   => true
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_author_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_sticky_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_author,
            'label'         => esc_html__('Author Sticky Sidebar','jnews'),
            'description'   => esc_html__('Enable sticky sidebar on author page.','jnews'),
            'postvar'       => array(
                array(
                    'redirect'  => 'author_tag',
                    'refresh'   => true
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_author_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        // content type
        $this->customizer->add_field(array(
            'id'            => 'jnews_author_content_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_author,
            'label'         => esc_html__('Author Content','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_content',
            'transport'     => 'postMessage',
            'default'       => '3',
            'type'          => 'jnews-radio-image',
            'section'       => $this->section_author,
            'label'         => esc_html__('Author Content Layout','jnews'),
            'description'   => esc_html__('Choose your author content layout.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                '3'  => '',
                '4'  => '',
                '5'  => '',
                '6'  => '',
                '7'  => '',
                '9'  => '',
                '10' => '',
                '11' => '',
                '12' => '',
                '14' => '',
                '15' => '',
                '18' => '',
                '22' => '',
                '23' => '',
                '25' => '',
                '26' => '',
                '27' => '',
            ),
            'partial_refresh' => array (
                'jnews_author_content' => array (
                    'selector'        => '.jnews_author_content_wrapper',
                    'render_callback' => function() {
                        $single = new AuthorArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array( array(
                'redirect'  => 'author_tag',
                'refresh'   => false
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_content_excerpt',
            'transport'     => 'postMessage',
            'default'       => 20,
            'type'          => 'jnews-number',
            'section'       => $this->section_author,
            'label'         => esc_html__('Excerpt Length', 'jnews'),
            'description'   => esc_html__('Set the word length of excerpt on post.', 'jnews'),
            'choices'     => array(
                'min'  => '0',
                'max'  => '200',
                'step' => '1',
            ),
            'partial_refresh' => array (
                'jnews_author_content_excerpt' => array (
                    'selector'        => '.jnews_author_content_wrapper',
                    'render_callback' => function() {
                        $single = new AuthorArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array( array(
                'redirect'  => 'author_tag',
                'refresh'   => false
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_content_date',
            'transport'     => 'postMessage',
            'default'       => 'default',
            'type'          => 'jnews-select',
            'section'       => $this->section_author,
            'label'         => esc_html__('Content Date Format','jnews'),
            'description'   => esc_html__('Choose which date format you want to use for author for content.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'ago' => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
                'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
                'custom' => esc_attr__( 'Custom Format', 'jnews' ),
            ),
            'partial_refresh' => array (
                'jnews_author_content_date' => array (
                    'selector'        => '.jnews_author_content_wrapper',
                    'render_callback' => function() {
                        $single = new AuthorArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'author_tag',
                    'refresh'   => false
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_content_date_custom',
            'transport'     => 'postMessage',
            'default'       => 'Y/m/d',
            'type'          => 'text',
            'section'       => $this->section_author,
            'label'         => esc_html__('Custom Date Format for Content','jnews'),
            'description'   => wp_kses(sprintf(__("Please set custom date format for post content. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews"), "https://developer.wordpress.org/reference/functions/current_time/"),
                wp_kses_allowed_html()),
            'postvar'       => array(
                array(
                    'redirect'  => 'author_tag',
                    'refresh'   => false
                )
            ),
            'partial_refresh' => array (
                'jnews_author_content_date_custom' => array (
                    'selector'        => '.jnews_author_content_wrapper',
                    'render_callback' => function() {
                        $single = new AuthorArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_author_content_date',
                    'operator' => '==',
                    'value'    => 'custom',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_content_pagination',
            'transport'     => 'postMessage',
            'default'       => 'nav_1',
            'type'          => 'jnews-select',
            'section'       => $this->section_author,
            'label'         => esc_html__('Choose Pagination Mode','jnews'),
            'description'   => esc_html__('Choose which pagination mode that fit with your block.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'nav_1' => esc_attr__( 'Normal - Navigation 1', 'jnews' ),
                'nav_2' => esc_attr__( 'Normal - Navigation 2', 'jnews' ),
                'nav_3' => esc_attr__( 'Normal - Navigation 3', 'jnews' ),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_navigation.jeg_pagination',
                    'property'      => array(
                        'nav_1'         => 'jeg_pagenav_1',
                        'nav_2'         => 'jeg_pagenav_2',
                        'nav_3'         => 'jeg_pagenav_3',
                    ),
                ),
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'author_tag',
                    'refresh'   => false
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_content_pagination_align',
            'transport'     => 'postMessage',
            'default'       => 'center',
            'type'          => 'jnews-select',
            'section'       => $this->section_author,
            'label'         => esc_html__('Pagination Align','jnews'),
            'description'   => esc_html__('Choose pagination alignment.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'left' => esc_attr__( 'Left', 'jnews' ),
                'center' => esc_attr__( 'Center', 'jnews' ),
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'author_tag',
                    'refresh'   => false
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_author_content_pagination',
                    'operator' => 'in',
                    'value'    => array('nav_1', 'nav_2', 'nav_3'),
                )
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_navigation.jeg_pagination',
                    'property'      => array(
                        'left'          => 'jeg_alignleft',
                        'center'        => 'jeg_aligncenter',
                    ),
                ),
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_content_pagination_show_navtext',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_author,
            'label'         => esc_html__('Show Navigation Text','jnews'),
            'description'   => esc_html__('Show navigation text (next, prev).','jnews'),
            'postvar'       => array( array(
                'redirect'  => 'author_tag',
                'refresh'   => false
            ) ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_author_content_pagination',
                    'operator' => 'in',
                    'value'    => array('nav_1', 'nav_2', 'nav_3'),
                )
            ),
            'output'     => array(
                array(
                    'method'        => 'remove-class',
                    'element'       => '.jeg_navigation.jeg_pagination ',
                    'property'      => 'no_navtext',
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_author_content_pagination_show_pageinfo',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_author,
            'label'         => esc_html__('Show Page Info','jnews'),
            'description'   => esc_html__('Show page info text (Page x of y).','jnews'),
            'postvar'       => array( array(
                'redirect'  => 'author_tag',
                'refresh'   => false
            ) ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_author_content_pagination',
                    'operator' => 'in',
                    'value'    => array('nav_1', 'nav_2', 'nav_3'),
                )
            ),
            'output'     => array(
                array(
                    'method'        => 'remove-class',
                    'element'       => '.jeg_navigation.jeg_pagination ',
                    'property'      => 'no_pageinfo',
                )
            ),
        ));
    }

    public function set_attachment_field()
    {
        // sidebar section
        $this->customizer->add_field(array(
            'id'            => 'jnews_attachment_sidebar_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_author,
            'label'         => esc_html__('Attachment Sidebar','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_attachment_show_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_attachment,
            'label'         => esc_html__('Show Sidebar','jnews'),
            'description'   => esc_html__('Show sidebar for attachment page.','jnews'),
            'postvar'       => array( array(
                'redirect'  => 'attachment_tag',
                'refresh'   => true
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_attachment_sidebar',
            'transport'     => 'postMessage',
            'default'       => 'default-sidebar',
            'type'          => 'jnews-select',
            'section'       => $this->section_attachment,
            'label'         => esc_html__('Attachment Sidebar','jnews'),
            'description'   => wp_kses(__("Choose your attachment sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews'), wp_kses_allowed_html()),
            'multiple'      => 1,
            'choices'       => $this->all_sidebar,
            'postvar'       => array(
                array(
                    'redirect'  => 'attachment_tag',
                    'refresh'   => true
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_attachment_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_attachment_sticky_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_attachment,
            'label'         => esc_html__('Attachment Sticky Sidebar','jnews'),
            'description'   => esc_html__('Enable sticky sidebar on attachment page.','jnews'),
            'postvar'       => array(
                array(
                    'redirect'  => 'attachment_tag',
                    'refresh'   => true
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_attachment_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));
    }

    public function set_404_field()
    {
        // sidebar section
        $this->customizer->add_field(array(
            'id'            => 'jnews_404_sidebar_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_author,
            'label'         => esc_html__('404 Page Sidebar','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_404_show_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_404,
            'label'         => esc_html__('Show Sidebar','jnews'),
            'description'   => esc_html__('Show sidebar for 404 Page.','jnews'),
            'postvar'       => array( array(
                'redirect'  => '404_tag',
                'refresh'   => true
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_404_sidebar',
            'transport'     => 'postMessage',
            'default'       => 'default-sidebar',
            'type'          => 'jnews-select',
            'section'       => $this->section_404,
            'label'         => esc_html__('404 Page Sidebar','jnews'),
            'description'   => wp_kses(__("Choose your 404 page sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews'), wp_kses_allowed_html()),
            'multiple'      => 1,
            'choices'       => $this->all_sidebar,
            'postvar'       => array(
                array(
                    'redirect'  => '404_tag',
                    'refresh'   => true
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_404_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_404_sticky_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_404,
            'label'         => esc_html__('404 Page Sticky Sidebar','jnews'),
            'description'   => esc_html__('Enable sticky sidebar on archive page.','jnews'),
            'postvar'       => array(
                array(
                    'redirect'  => '404_tag',
                    'refresh'   => true
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_404_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
        ));

        // content type
        $this->customizer->add_field(array(
            'id'            => 'jnews_404_content_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_404,
            'label'         => esc_html__('404 Page Content','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_404_content',
            'transport'     => 'postMessage',
            'default'       => '3',
            'type'          => 'jnews-radio-image',
            'section'       => $this->section_404,
            'label'         => esc_html__('Not found Content Layout','jnews'),
            'description'   => esc_html__('Choose your Not found content layout.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                '3'  => '',
                '4'  => '',
                '5'  => '',
                '6'  => '',
                '7'  => '',
                '9'  => '',
                '10' => '',
                '11' => '',
                '12' => '',
                '14' => '',
                '15' => '',
                '18' => '',
                '22' => '',
                '23' => '',
                '25' => '',
                '26' => '',
                '27' => '',
            ),
            'partial_refresh' => array (
                'jnews_404_content' => array (
                    'selector'        => '.jnews_404_content_wrapper',
                    'render_callback' => function() {
                        $single = new NotFoundArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array( array(
                'redirect'  => '404_tag',
                'refresh'   => false
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_404_content_excerpt',
            'transport'     => 'postMessage',
            'default'       => 20,
            'type'          => 'jnews-number',
            'section'       => $this->section_404,
            'label'         => esc_html__('Excerpt Length', 'jnews'),
            'description'   => esc_html__('Set the word length of excerpt on post.', 'jnews'),
            'choices'     => array(
                'min'  => '0',
                'max'  => '200',
                'step' => '1',
            ),
            'partial_refresh' => array (
                'jnews_404_content_excerpt' => array (
                    'selector'        => '.jnews_404_content_wrapper',
                    'render_callback' => function() {
                        $single = new NotFoundArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array( array(
                'redirect'  => '404_tag',
                'refresh'   => false
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_404_content_date',
            'transport'     => 'postMessage',
            'default'       => 'default',
            'type'          => 'jnews-select',
            'section'       => $this->section_404,
            'label'         => esc_html__('Content Date Format','jnews'),
            'description'   => esc_html__('Choose which date format you want to use for author for content.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'ago' => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
                'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
                'custom' => esc_attr__( 'Custom Format', 'jnews' ),
            ),
            'partial_refresh' => array (
                'jnews_404_content_date' => array (
                    'selector'        => '.jnews_404_content_wrapper',
                    'render_callback' => function() {
                        $single = new NotFoundArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => '404_tag',
                    'refresh'   => false
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_404_content_date_custom',
            'transport'     => 'postMessage',
            'default'       => 'Y/m/d',
            'type'          => 'text',
            'section'       => $this->section_404,
            'label'         => esc_html__('Custom Date Format for Content','jnews'),
            'description'   => wp_kses(sprintf(__("Please set custom date format for post content. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews"), "https://developer.wordpress.org/reference/functions/current_time/"),
                wp_kses_allowed_html()),
            'postvar'       => array(
                array(
                    'redirect'  => '404_tag',
                    'refresh'   => false
                )
            ),
            'partial_refresh' => array (
                'jnews_404_content_date_custom' => array (
                    'selector'        => '.jnews_404_content_wrapper',
                    'render_callback' => function() {
                        $single = new NotFoundArchive();
                        echo jnews_sanitize_output($single->render_content());
                    },
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_404_content_date',
                    'operator' => '==',
                    'value'    => 'custom',
                )
            ),
        ));
    }

    public function set_woocommerce_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_woocommerce_archive_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_woocommerce,
            'label'         => esc_html__('WooCommerce Archive','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_woocommerce_archive_show_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_woocommerce,
            'label'         => esc_html__('Show Sidebar on WooCommerce Archive','jnews'),
            'description'   => esc_html__('Show sidebar on WooCommerce shop page, or category.','jnews'),
            'postvar'       => array(
                array(
                    'redirect'  => 'woo_archive_tag',
                    'refresh'   => true
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_woocommerce_archive_sidebar',
            'transport'     => 'postMessage',
            'default'       => 'default-sidebar',
            'type'          => 'jnews-select',
            'section'       => $this->section_woocommerce,
            'label'         => esc_html__('WooCommerce Archive Sidebar','jnews'),
            'description'   => wp_kses(__("Choose your WooCommerce Archive sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews'), wp_kses_allowed_html()),
            'multiple'      => 1,
            'choices'       => $this->all_sidebar,
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_woocommerce_archive_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'woo_archive_tag',
                    'refresh'   => true
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_woocommerce_sticky_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_woocommerce,
            'label'         => esc_html__('WooCommerce Archive Sticky Sidebar','jnews'),
            'description'   => esc_html__('Enable sticky sidebar on woocommerce archive page.','jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_woocommerce_archive_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'woo_archive_tag',
                    'refresh'   => true
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_woocommerce_single_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_woocommerce,
            'label'         => esc_html__('WooCommerce Single','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_woocommerce_single_show_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_woocommerce,
            'label'         => esc_html__('Show Sidebar on WooCommerce Single','jnews'),
            'description'   => esc_html__('Show sidebar on woocommerce shop page, or category.','jnews'),
            'postvar'       => array(
                array(
                    'redirect'  => 'woo_single_tag',
                    'refresh'   => true
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_woocommerce_single_sidebar',
            'transport'     => 'postMessage',
            'default'       => 'default-sidebar',
            'type'          => 'jnews-select',
            'section'       => $this->section_woocommerce,
            'label'         => esc_html__('Woocommerce Single Sidebar','jnews'),
            'description'   => wp_kses(__("Choose your WooCommerce single sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews'), wp_kses_allowed_html()),
            'multiple'      => 1,
            'choices'       => $this->all_sidebar,
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_woocommerce_single_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'woo_single_tag',
                    'refresh'   => true
                )
            )
        ));



        $this->customizer->add_field(array(
            'id'            => 'jnews_woocommerce_single_sticky_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_woocommerce,
            'label'         => esc_html__('Woocommerce Single Sticky Sidebar','jnews'),
            'description'   => esc_html__('Enable sticky sidebar on woocommerce single page.','jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_woocommerce_single_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'woo_single_tag',
                    'refresh'   => true
                )
            )
        ));
    }

    public function set_bbpress_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_bbpress_archive_section',
            'type'          => 'jnews-header',
            'section'       => $this->section_woocommerce,
            'label'         => esc_html__('BBPress Sidebar','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_bbpress_show_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_bbpress,
            'label'         => esc_html__('Show Sidebar on BBPress','jnews'),
            'description'   => esc_html__('Show sidebar on bbpress shop page, or category.','jnews'),
            'postvar'       => array(
                array(
                    'redirect'  => 'bbpress_tag',
                    'refresh'   => true
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_bbpress_sidebar',
            'transport'     => 'postMessage',
            'default'       => 'default-sidebar',
            'type'          => 'jnews-select',
            'section'       => $this->section_bbpress,
            'label'         => esc_html__('BBPress Sidebar','jnews'),
            'description'   => wp_kses(__("Choose your BBPress archive sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews'), wp_kses_allowed_html()),
            'multiple'      => 1,
            'choices'       => $this->all_sidebar,
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_bbpress_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'bbpress_tag',
                    'refresh'   => true
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_bbpress_sticky_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_bbpress,
            'label'         => esc_html__('BBPress Sidebar','jnews'),
            'description'   => esc_html__('Enable sticky sidebar on bbpress page.','jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_bbpress_show_sidebar',
                    'operator' => '==',
                    'value'    => true,
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'bbpress_tag',
                    'refresh'   => true
                )
            )
        ));
    }

}