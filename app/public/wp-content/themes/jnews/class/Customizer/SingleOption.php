<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Customizer;

use JNews\Single\SinglePost;

/**
 * Class Theme JNews Customizer
 */
Class SingleOption extends CustomizerOptionAbstract
{
    private $section_global = 'jnews_single_global_section';
    private $section_related = 'jnews_single_related_section';
	private $section_global_comment = 'jnews_global_comment_section';
    private $section_global_breadcrumb = 'jnews_global_breadcrumb_section';

    public function set_option()
    {
        $this->set_panel();
        $this->set_section();

        $this->set_global_breadcrumb_field();
        $this->set_single_field();
        $this->set_related_field();
	    $this->set_global_comment_field();
    }

    public function single_post_tag()
    {
        return array(
            'redirect'  => 'single_post_tag',
            'refresh'   => false
        );
    }

    public function set_panel()
    {
        $this->customizer->add_panel(array(
            'id' => 'jnews_single_post_panel',
            'title' => esc_html__('JNews : Single Post Option', 'jnews'),
            'description' => esc_html__('JNews Single Post Option', 'jnews'),
            'priority' => $this->id
        ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id'            => $this->section_global_breadcrumb,
            'title'         => esc_html__('Breadcrumb Setting', 'jnews'),
            'panel'         => 'jnews_single_post_panel',
            'priority'      => 250,
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_global,
            'title'         => esc_html__('Single Post Option', 'jnews'),
            'panel'         => 'jnews_single_post_panel',
            'priority'      => 250
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_related,
            'title'         => esc_html__('Related Post Option', 'jnews'),
            'panel'         => 'jnews_single_post_panel',
            'priority'      => 250
        ));

	    $this->customizer->add_section(array(
		    'id'            => $this->section_global_comment,
		    'title'         => esc_html__('Comment Setting', 'jnews'),
		    'panel'         => 'jnews_single_post_panel',
		    'priority'      => 250,
	    ));
    }

    public function set_global_breadcrumb_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_breadcrumb',
            'transport'     => 'postMessage',
            'default'       => 'native',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_breadcrumb,
            'label'         => esc_html__('Website Breadcrumb','jnews'),
            'description'   => wp_kses(__('Choose which breadcrumb script you want to use, or you want to hide completely. <br/> Each breadcrumb script will need you to install its respective plugin.','jnews'), wp_kses_allowed_html()),
            'multiple'      => 1,
            'partial_refresh' => array (
                'jnews_breadcrumb_single' => array (
                    'selector'        => '.jeg_breadcrumb_container',
                    'render_callback' => function() {
                        echo jnews_render_breadcrumb();
                    },
                ),
            ),
            'choices'       => array(
                'hide'          => esc_attr__( 'Hide Breadcrumb', 'jnews' ),
                'native'        => esc_attr__( 'JNews Native Breadcrumb', 'jnews' ),
                'navxt'         => esc_attr__( 'Navxt Breadcrumb', 'jnews' ),
                'yoast'         => esc_attr__( 'Yoast Breadcrumb', 'jnews' ),
            ),
            'postvar'       => array( array(
                'redirect'  => 'breadcrumb_tag',
                'refresh'   => false
            ) )
        ));

        $show_breadcrumb = array(
            'setting'  => 'jnews_breadcrumb',
            'operator' => '!=',
            'value'    => 'hide',
        );

        $this->customizer->add_field(array(
            'id'            => 'jnews_breadcrumb_show_post',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_breadcrumb,
            'label'         => esc_html__('Show Breadcrumb on Single Post', 'jnews'),
            'description'   => esc_html__('Turn this option off to hide breadcrumb on single post.', 'jnews'),
            'partial_refresh' => array (
                'jnews_breadcrumb_show_post' => array (
                    'selector'        => '.jeg_breadcrumb_container',
                    'render_callback' => function() {
                        echo jnews_render_breadcrumb();
                    },
                ),
            ),
            'active_callback'  => array(
                $show_breadcrumb
            ),
            'postvar'       => array( array(
                'redirect'  => 'single_post_tag',
                'refresh'   => false
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_breadcrumb_show_category',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_breadcrumb,
            'label'         => esc_html__('Show Breadcrumb on Category Page', 'jnews'),
            'description'   => esc_html__('Turn this option off to hide breadcrumb on category page.', 'jnews'),
            'partial_refresh' => array (
                'jnews_breadcrumb_show_category' => array (
                    'selector'        => '.jeg_breadcrumb_container',
                    'render_callback' => function() {
                        echo jnews_render_breadcrumb();
                    },
                ),
            ),
            'active_callback'  => array(
                $show_breadcrumb
            ),
            'postvar'       => array( array(
                'redirect'  => 'category_tag',
                'refresh'   => false
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_breadcrumb_show_search',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_breadcrumb,
            'label'         => esc_html__('Show Breadcrumb on Search Result Page', 'jnews'),
            'description'   => esc_html__('Turn this option off to hide breadcrumb on search result page.', 'jnews'),
            'partial_refresh' => array (
                'jnews_breadcrumb_show_search' => array (
                    'selector'        => '.jeg_breadcrumb_container',
                    'render_callback' => function() {
                        echo jnews_render_breadcrumb();
                    },
                ),
            ),
            'active_callback'  => array(
                $show_breadcrumb
            ),
            'postvar'       => array( array(
                'redirect'  => 'search_tag',
                'refresh'   => false
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_breadcrumb_show_author',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_breadcrumb,
            'label'         => esc_html__('Show Breadcrumb on Author Page', 'jnews'),
            'description'   => esc_html__('Turn this option off to hide breadcrumb on author page.', 'jnews'),
            'partial_refresh' => array (
                'jnews_breadcrumb_show_author' => array (
                    'selector'        => '.jeg_breadcrumb_container',
                    'render_callback' => function() {
                        echo jnews_render_breadcrumb();
                    },
                ),
            ),
            'active_callback'  => array(
                $show_breadcrumb
            ),
            'postvar'       => array( array(
                'redirect'  => 'author_tag',
                'refresh'   => false
            ) )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_breadcrumb_show_archive',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global_breadcrumb,
            'label'         => esc_html__('Show Breadcrumb on Archive Page', 'jnews'),
            'description'   => esc_html__('Turn this option off to hide breadcrumb on archive page.', 'jnews'),
            'partial_refresh' => array (
                'jnews_breadcrumb_show_archive' => array (
                    'selector'        => '.jeg_breadcrumb_container',
                    'render_callback' => function() {
                        echo jnews_render_breadcrumb();
                    },
                ),
            ),
            'active_callback'  => array(
                $show_breadcrumb
            ),
            'postvar'       => array( array(
                'redirect'  => 'archive_tag',
                'refresh'   => false
            ) )
        ));
    }

	public function set_global_comment_field()
	{
		$this->customizer->add_field(array(
			'id'            => 'jnews_comment_type',
			'transport'     => 'postMessage',
			'default'       => 'wordpress',
			'type'          => 'jnews-select',
			'section'       => $this->section_global_comment,
			'label'         => esc_html__('Comment Type', 'jnews'),
			'description'   => esc_html__('Choose which comment platform to use.', 'jnews'),
			'choices'       => array(
				'wordpress'     => esc_html__('WordPress Comment', 'jnews'),
				'facebook'      => esc_html__('Facebook Comment', 'jnews'),
				'disqus'        => esc_html__('Disqus Comment', 'jnews'),
			),
			'postvar'       => array(
				array(
					'redirect'  => 'single_post_tag',
					'refresh'   => false
				)
			),
			'partial_refresh' => array (
				'jnews_comment_type' => array (
					'selector'        => '.jnews_comment_container',
					'render_callback' => function() {
						$single = SinglePost::getInstance();
						$single->post_comment();
					},
				),
			),
		));

		$this->customizer->add_field(array(
			'id'            => 'jnews_comment_disqus_shortname',
			'transport'     => 'refresh',
			'default'       => '',
			'type'          => 'text',
			'section'       => $this->section_global_comment,
			'label'         => esc_html__('Disqus Shortname', 'jnews'),
			'description'   => wp_kses(sprintf(__("Please register your website first and get shortname for your website <a href='%s' target='_blank'>here</a>.", "jnews"), "https://disqus.com/admin/create/"), wp_kses_allowed_html()),
			'postvar'       => array(
				array(
					'redirect'  => 'single_post_tag',
					'refresh'   => true
				)
			),
			'active_callback' => array(
				array(
					'setting'  => 'jnews_comment_type',
					'operator' => '==',
					'value'    => 'disqus',
				)
			),
		));

        $this->customizer->add_field(array(
            'id'            => 'jnews_comment_disqus_api_key',
            'transport'     => 'refresh',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_global_comment,
            'label'         => esc_html__('Disqus API Key', 'jnews'),
            'description'   => wp_kses(sprintf(__("Insert your Disqus API Key. You can create an application and get Disqus API Key <a href='%s' target='_blank'>here</a>.", "jnews"), "http://disqus.com/api/applications/register/"), wp_kses_allowed_html()),
            'postvar'       => array(
                array(
                    'redirect'  => 'single_post_tag',
                    'refresh'   => true
                )
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_comment_type',
                    'operator' => '==',
                    'value'    => 'disqus',
                )
            ),
        ));

		$this->customizer->add_field(array(
			'id'            => 'jnews_comment_facebook_appid',
			'transport'     => 'refresh',
			'default'       => '',
			'type'          => 'text',
			'section'       => $this->section_global_comment,
			'label'         => esc_html__('Facebook App ID', 'jnews'),
			'description'   => wp_kses(sprintf(__("The unique ID that lets Facebook know the identity of your site. You can create your Facebook App ID <a href='%s' target='_blank'>here</a>.", "jnews"), "https://developers.facebook.com/docs/apps/register"), wp_kses_allowed_html()),
			'postvar'       => array(
				array(
					'redirect'  => 'single_post_tag',
					'refresh'   => true
				)
			),
			'active_callback' => array(
				array(
					'setting'  => 'jnews_comment_type',
					'operator' => '==',
					'value'    => 'facebook',
				)
			),
		));

        $this->customizer->add_field(array(
            'id'            => 'jnews_comment_cache_expired',
            'transport'     => 'postMessage',
            'default'       => '1',
            'type'          => 'jnews-slider',
            'section'       => $this->section_global_comment,
            'label'         => esc_html__('Comment Cache Lifetime', 'jnews'),
            'description'   => esc_html__('Set the lifetime of comment cache in hours.', 'jnews'),
            'choices'       => array(
                'min'  => '1',
                'max'  => '24',
                'step' => '1',
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'single_post_tag',
                    'refresh'   => true
                )
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_comment_type',
                    'operator' => '!=',
                    'value'    => 'wordpress',
                )
            ),
        ));
	}

    public function set_related_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_single_blog_post_related_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_related,
            'label'         => esc_html__('Single Related Post','jnews' ),
        ));

        $post_related_partial_refresh = array (
            'selector'        => '.jnews_related_post_container',
            'render_callback' => function() {
                $single = SinglePost::getInstance();
                $single->related_post();
            },
        );

        $related_active_callback = array(
            'setting'  => 'jnews_single_show_post_related',
            'operator' => '==',
            'value'    => true,
        );

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_post_related',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_related,
            'label'         => esc_html__('Show Post Related','jnews'),
            'description'   => esc_html__('Enable this option to show post related (below article).','jnews'),
            'partial_refresh' => array (
                'jnews_single_show_post_related' => $post_related_partial_refresh
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_post_related_match',
            'transport'     => 'postMessage',
            'default'       => 'category',
            'type'          => 'jnews-select',
            'section'       => $this->section_related,
            'label'         => esc_html__('Related Post Filter','jnews'),
            'description'   => esc_html__('Select how related post will filter article.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'category'          => esc_attr__( 'Category', 'jnews' ),
                'tag'               => esc_attr__( 'Tag', 'jnews' ),
            ),
            'partial_refresh' => array (
                'jnews_single_post_related_match' => $post_related_partial_refresh
            ),
            'active_callback'  => array( $related_active_callback ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_post_related_header',
            'transport'     => 'refresh',
            'default'       => 'heading_6',
            'type'          => 'jnews-radio-image',
            'section'       => $this->section_related,
            'label'         => esc_html__('Related Post Module Header Style', 'jnews'),
            'description'   => esc_html__('Choose header style for your related search.', 'jnews'),
            'choices'       => array(
                'heading_1'  => '',
                'heading_2'  => '',
                'heading_3'  => '',
                'heading_4'  => '',
                'heading_5'  => '',
                'heading_6'  => '',
                'heading_7'  => '',
                'heading_8'  => '',
                'heading_9'  => '',
            ),
            'partial_refresh' => array (
                'jnews_single_post_related_header' => $post_related_partial_refresh
            ),
            'active_callback'  => array( $related_active_callback ),
            'postvar'       => array( $this->single_post_tag() )
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_single_post_pagination_related',
            'transport'     => 'postMessage',
            'default'       => 'nextprev',
            'type'          => 'jnews-select',
            'section'       => $this->section_related,
            'label'         => esc_html__('Related Pagination Style','jnews'),
            'description'   => esc_html__('Adjust how related post will shown.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'disable'       => esc_html__('No Pagination', 'jnews'),
                'nextprev'      => esc_html__('Next Prev', 'jnews'),
                'loadmore'      => esc_html__('Load More', 'jnews'),
                'scrollload'    => esc_html__('Auto Load on Scroll', 'jnews'),
            ),
            'partial_refresh' => array (
                'jnews_single_post_pagination_related' => $post_related_partial_refresh
            ),
            'active_callback'  => array( $related_active_callback ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_number_post_related',
            'transport'     => 'postMessage',
            'default'       => 5,
            'type'          => 'jnews-slider',
            'section'       => $this->section_related,
            'label'         => esc_html__('Number of Post', 'jnews'),
            'description'   => esc_html__('Set the number of post each related post load.', 'jnews'),
            'choices'     => array(
                'min'  => '2',
                'max'  => '10',
                'step' => '1',
            ),
            'partial_refresh' => array (
                'jnews_single_number_post_related' => $post_related_partial_refresh
            ),
            'active_callback'  => array( $related_active_callback ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_post_auto_load_related',
            'transport'     => 'postMessage',
            'default'       => 3,
            'type'          => 'jnews-number',
            'section'       => $this->section_related,
            'label'         => esc_html__('Auto Load Limit', 'jnews'),
            'description'   => esc_html__('Limit of auto load when scrolling, set to zero to always load until end of content.', 'jnews'),
            'choices'     => array(
                'min'  => '0',
                'max'  => '500',
                'step' => '1',
            ),
            'partial_refresh' => array (
                'jnews_single_post_auto_load_related' => $post_related_partial_refresh
            ),
            'active_callback'  => array(
                $related_active_callback,
                array(
                    'setting'  => 'jnews_single_post_pagination_related',
                    'operator' => '!=',
                    'value'    => 'disable',
                )
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_single_post_related_template',
            'transport'     => 'postMessage',
            'default'       => '9',
            'type'          => 'jnews-radio-image',
            'section'       => $this->section_related,
            'label'         => esc_html__('Related PostTemplate','jnews'),
            'description'   => esc_html__('Choose your related post template.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                '1'  => '',
                '2'  => '',
                '3'  => '',
                '4'  => '',
                '5'  => '',
                '6'  => '',
                '7'  => '',
                '8'  => '',
                '9'  => '',
                '10' => '',
                '11' => '',
                '12' => '',
                '13' => '',
                '14' => '',
                '15' => '',
                '16' => '',
                '17' => '',
                '18' => '',
                '19' => '',
                '20' => '',
                '21' => '',
                '22' => '',
                '23' => '',
                '24' => '',
                '25' => '',
                '26' => '',
                '27' => '',
            ),
            'partial_refresh' => array (
                'jnews_single_post_related_template' => $post_related_partial_refresh
            ),
            'active_callback'  => array( $related_active_callback ),
            'postvar'       => array( $this->single_post_tag() )
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_single_post_related_excerpt',
            'transport'     => 'postMessage',
            'default'       => 20,
            'type'          => 'jnews-number',
            'section'       => $this->section_related,
            'label'         => esc_html__('Excerpt Length', 'jnews'),
            'description'   => esc_html__('Set word length of excerpt on related post.', 'jnews'),
            'choices'     => array(
                'min'  => '0',
                'max'  => '200',
                'step' => '1',
            ),
            'partial_refresh' => array (
                'jnews_single_post_related_archive' => $post_related_partial_refresh
            ),
            'active_callback'  => array( $related_active_callback ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_post_related_date',
            'transport'     => 'postMessage',
            'default'       => 'default',
            'type'          => 'jnews-select',
            'section'       => $this->section_related,
            'label'         => esc_html__('Related Post Date Format','jnews'),
            'description'   => esc_html__('Choose which date format you want to use for archive content.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'ago' => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews' ),
                'default' => esc_attr__( 'WordPress Default Format', 'jnews' ),
                'custom' => esc_attr__( 'Custom Format', 'jnews' ),
            ),
            'partial_refresh' => array (
                'jnews_single_post_related_date' => $post_related_partial_refresh
            ),
            'active_callback'  => array( $related_active_callback ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_post_related_date_custom',
            'transport'     => 'postMessage',
            'default'       => 'Y/m/d',
            'type'          => 'text',
            'section'       => $this->section_related,
            'label'         => esc_html__('Custom Date Format for Related Post','jnews'),
            'description'   => wp_kses(sprintf(__("Please set your date format for related post content, for more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.", "jnews"), "https://developer.wordpress.org/reference/functions/current_time/"),
                wp_kses_allowed_html()),
            'partial_refresh' => array (
                'jnews_single_post_related_date_custom' => $post_related_partial_refresh
            ),
            'active_callback'  => array( $related_active_callback ),
            'postvar'       => array( $this->single_post_tag() )
        ));
    }


    public function set_single_field()
    {
        $postmeta_refresh = array (
            'selector'        => '.jeg_meta_container',
            'render_callback' => function() {
                $single = SinglePost::getInstance();
                $single->render_post_meta();
            },
        );

        $top_share = array (
            'selector'        => '.jeg_share_top_container',
            'render_callback' => function() {
                do_action('jnews_share_top_bar', get_the_ID());
            },
        );

        $float_share = array (
            'selector'        => '.jeg_share_float_container',
            'render_callback' => function() {
                do_action('jnews_share_float_bar', get_the_ID());
            },
        );

        $bottom_share = array(
            'selector'        => '.jeg_share_bottom_container',
            'render_callback' => function() {
                do_action('jnews_share_bottom_bar', get_the_ID());
            },
        );

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_blog_style_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_global,
            'label'         => esc_html__('Single Blog Post Template','jnews' ),
        ));

        if(class_exists('JNews_Auto_Load_Post_Option'))
        {
            $this->customizer->add_field(array(
                'id'            => 'jnews_autoload_single_alert',
                'type'          => 'jnews-alert',
                'default'       => 'warning',
                'section'       => $this->section_global,
                'label'         => esc_html__('Attention','jnews' ),
                'description'   => wp_kses(__('<ul>
                    <li>Single Post template overrided by Auto Load Post Option, Please use option on Auto Load Post Instead </li>                    
                </ul>','jnews'), wp_kses_allowed_html()),
            ));
        }

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_blog_template',
            'transport'     => 'postMessage',
            'default'       => '1',
            'type'          => 'jnews-radio-image',
            'section'       => $this->section_global,
            'label'         => esc_html__('Single Blog Post Template','jnews' ),
            'description'   => esc_html__('Choose your single blog post template.','jnews' ),
            'choices'       => array(
                '1' => '',
                '2' => '',
                '3' => '',
                '4' => '',
                '5' => '',
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
            'id'            => 'jnews_single_blog_layout',
            'transport'     => 'postMessage',
            'default'       => 'right-sidebar',
            'type'          => 'jnews-radio-image',
            'section'       => $this->section_global,
            'label'         => esc_html__('Single Blog Post Layout','jnews' ),
            'description'   => esc_html__('Choose your single blog post layout.','jnews' ),
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


        $this->customizer->add_field(array(
            'id'            => 'jnews_single_blog_enable_parallax',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Parallax Effect','jnews'),
            'description'   => esc_html__('Turn this option on if you want your featured image to have parallax effect.','jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_single_blog_template',
                    'operator' => 'contains',
                    'value'    => array('4', '5'),
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
            'id'            => 'jnews_single_blog_enable_fullscreen',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Fullscreen Featured Image','jnews'),
            'description'   => esc_html__('Turn this option on if you want your post header to have fullscreen image featured.','jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_single_blog_template',
                    'operator' => 'contains',
                    'value'    => array('4', '5'),
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


        $all_sidebar = apply_filters('jnews_get_sidebar_widget', null);

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_sidebar',
            'transport'     => 'postMessage',
            'default'       => 'default-sidebar',
            'type'          => 'jnews-select',
            'section'       => $this->section_global,
            'label'         => esc_html__('Single Post Sidebar','jnews'),
            'description'   => wp_kses(__("Choose your single post sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.", 'jnews'), wp_kses_allowed_html()),
            'multiple'      => 1,
            'choices'       => $all_sidebar,
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_single_blog_layout',
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
            'id'            => 'jnews_single_sticky_sidebar',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Single Post Sticky Sidebar','jnews'),
            'description'   => esc_html__('Enable sticky sidebar on single post page.','jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_single_blog_layout',
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
            'id'            => 'jnews_single_blog_element_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_global,
            'label'         => esc_html__('Single Post Element','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_featured',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Featured Image/Video','jnews'),
            'description'   => esc_html__('Show featured image, gallery or video on single post.','jnews'),
            'postvar'       => array( $this->single_post_tag() ),
        ));

        $postmeta_callback = array(
            'setting'  => 'jnews_single_show_post_meta',
            'operator' => '==',
            'value'    => true,
        );

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_post_meta',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Post Meta','jnews'),
            'description'   => esc_html__('Show post meta on post header.','jnews'),
            'partial_refresh' => array (
                'jnews_single_show_post_meta' => $postmeta_refresh
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_post_author',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Post Author','jnews'),
            'description'   => esc_html__('Show post author on post meta container.','jnews'),
            'partial_refresh' => array (
                'jnews_single_show_post_author' => $postmeta_refresh
            ),
            'active_callback'  => array( $postmeta_callback ),
            'postvar'       => array( $this->single_post_tag() ),
            'wrapper_class' => array('first_child')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_post_author_image',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Post Author Image','jnews'),
            'description'   => esc_html__('Show post author image on post meta container.','jnews'),
            'partial_refresh' => array (
                'jnews_single_show_post_author_image_1' => $postmeta_refresh,
            ),
            'active_callback'  => array( $postmeta_callback,
                array(
                    'setting'  => 'jnews_single_show_post_author',
                    'operator' => '==',
                    'value'    => true,
                )),
            'postvar'       => array( $this->single_post_tag() ),
            'wrapper_class' => array('first_child')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_post_date',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Post Date','jnews'),
            'description'   => esc_html__('Show post date on post meta container.','jnews'),
            'partial_refresh' => array (
                'jnews_single_show_post_date' => $postmeta_refresh
            ),
            'active_callback'  => array( $postmeta_callback ),
            'postvar'       => array( $this->single_post_tag() ),
            'wrapper_class' => array('first_child')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_category',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Category','jnews'),
            'description'   => esc_html__('Show post category on post meta container.','jnews'),
            'partial_refresh' => array (
                'jnews_single_show_category' => $postmeta_refresh
            ),
            'active_callback'  => array( $postmeta_callback ),
            'postvar'       => array( $this->single_post_tag() ),
            'wrapper_class' => array('first_child')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_comment',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Comment Button','jnews'),
            'description'   => esc_html__('Show comment button on post meta container.','jnews'),
            'partial_refresh' => array (
                'jnews_single_comment' => $postmeta_refresh
            ),
            'active_callback'  => array( $postmeta_callback ),
            'postvar'       => array( $this->single_post_tag() ),
            'wrapper_class' => array('first_child')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_share_position',
            'transport'     => 'postMessage',
            'default'       => 'top',
            'type'          => 'jnews-select',
            'section'       => $this->section_global,
            'label'         => esc_html__('Share Position','jnews'),
            'description'   => esc_html__('Choose your share position.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'top'           => esc_attr__( 'Only Top', 'jnews' ),
                'float'         => esc_attr__( 'Only Float', 'jnews' ),
                'bottom'        => esc_attr__( 'Only Bottom', 'jnews' ),
                'topbottom'     => esc_attr__( 'Top + Bottom', 'jnews' ),
                'floatbottom'   => esc_attr__( 'Float + Bottom', 'jnews' ),
                'hide'          => esc_attr__( 'Hide All', 'jnews' ),
            ),
            'partial_refresh' => array (
                'jnews_single_share_position_top' => $top_share,
                'jnews_single_share_position_float' => $float_share,
                'jnews_single_share_position_bottom' => $bottom_share,
            ),
            'output'        => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.entry-content',
                    'property'      => array(
                        'top'               => 'no-share',
                        'float'             => 'with-share',
                        'bottom'            => 'no-share',
                        'topbottom'         => 'no-share',
                        'floatbottom'       => 'with-share',
                        'hide'              => 'no-share',
                    ),
                ),
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_share_float_style',
            'transport'     => 'postMessage',
            'default'       => 'share-monocrhome',
            'type'          => 'jnews-select',
            'section'       => $this->section_global,
            'label'         => esc_html__('Float Share Style','jnews'),
            'description'   => esc_html__('Choose your float share style.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'share-normal'        => esc_attr__( 'Color', 'jnews' ),
                'share-monocrhome'    => esc_attr__( 'Monochrome', 'jnews' ),
            ),
            'output'        => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_share_button',
                    'property'      => array(
                        'share-normal'               => 'share-normal',
                        'share-monocrhome'           => 'share-monocrhome',
                    ),
                ),
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_single_share_position',
                    'operator' => 'in',
                    'value'    => array('float', 'floatbottom'),
                ),
            ),
            'postvar'       => array( $this->single_post_tag() ),
            'wrapper_class' => array('first_child')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_share_counter',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Share Counter','jnews'),
            'description'   => wp_kses(__('Show or hide share counter, share counter may be hidden depending on your setup on <strong>Share Position</strong> option above.','jnews'), wp_kses_allowed_html()),
            'partial_refresh' => array (
                'jnews_single_show_share_counter' => $top_share
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_single_share_position',
                    'operator' => 'in',
                    'value'    => array('top', 'topbottom'),
                ),
            ),
            'postvar'       => array( $this->single_post_tag() ),
            'wrapper_class' => array('first_child')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_view_counter',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show View Counter','jnews'),
            'description'   => wp_kses(__('Show or hide view counter, view counter may be hidden depending on your setup on <strong>Share Position</strong> option above.','jnews'), wp_kses_allowed_html()),
            'partial_refresh' => array (
                'jnews_single_show_view_counter' => $top_share
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_single_share_position',
                    'operator' => 'in',
                    'value'    => array('top', 'topbottom'),
                ),
            ),
            'postvar'       => array( $this->single_post_tag() ),
            'wrapper_class' => array('first_child')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_tag',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Post Tag','jnews'),
            'description'   => esc_html__('Show single post tag (below article).','jnews'),
            'partial_refresh' => array (
                'jnews_single_show_tag' => array (
                    'selector'        => '.jeg_post_tags',
                    'render_callback' => function() {
                        $single = SinglePost::getInstance();
                        $single->post_tag_render();
                    },
                )
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_prev_next_post',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Prev / Next Post','jnews'),
            'description'   => esc_html__('Show previous or next post navigation (below article).','jnews'),
            'partial_refresh' => array (
                'jnews_single_show_prev_next_post' => array (
                    'selector'        => '.jnews_prev_next_container',
                    'render_callback' => function() {
                        $single = SinglePost::getInstance();
                        $single->prev_next_post();
                    },
                )
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_popup_post',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Popup Post','jnews'),
            'description'   => esc_html__('Show bottom right popup post widget.','jnews'),
            'partial_refresh' => array (
                'jnews_single_show_popup_post' => array (
                    'selector'        => '.jnews_popup_post_container',
                    'render_callback' => function() {
                        $single = SinglePost::getInstance();
                        $single->popup_post();
                    },
                )
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_number_popup_post',
            'transport'     => 'postMessage',
            'default'       => 1,
            'type'          => 'jnews-slider',
            'section'       => $this->section_global,
            'label'         => esc_html__('Number of Popup Post','jnews'),
            'description'   => esc_html__('Set the number of post to show when popup post appear.','jnews'),
            'choices'       => array(
                'min'  => '1',
                'max'  => '5',
                'step' => '1',
            ),
            'partial_refresh' => array (
                'jnews_single_number_popup_post' => array (
                    'selector'        => '.jnews_popup_post_container',
                    'render_callback' => function() {
                        $single = SinglePost::getInstance();
                        $single->popup_post();
                    },
                )
            ),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_single_show_popup_post',
                    'operator' => '==',
                    'value'    => true,
                ),
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_show_author_box',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_global,
            'label'         => esc_html__('Show Author Box','jnews'),
            'description'   => esc_html__('Show author box (below article).','jnews'),
            'partial_refresh' => array (
                'jnews_single_show_author_box' => array (
                    'selector'        => '.jnews_author_box_container',
                    'render_callback' => function() {
                        $single = SinglePost::getInstance();
                        $single->author_box();
                    },
                )
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_blog_post_thumbnail_header',
            'type'          => 'jnews-header',
            'section'       => $this->section_global,
            'label'         => esc_html__('Single Thumbnail Setting','jnews' ),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_post_thumbnail_size',
            'transport'     => 'refresh',
            'default'       => 'crop-500',
            'type'          => 'jnews-select',
            'section'       => $this->section_global,
            'label'         => esc_html__('Post Thumbnail Size','jnews'),
            'description'   => esc_html__('Choose your post\'s single image thumbnail size. You can also override this behaviour on your single post editor.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'no-crop'           => esc_attr__( 'No Crop', 'jnews' ),
                'crop-500'          => esc_attr__( 'Crop 1/2 Dimension', 'jnews' ),
                'crop-715'          => esc_attr__( 'Crop Default Dimension', 'jnews' ),
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_post_gallery_size',
            'transport'     => 'refresh',
            'default'       => 'crop-500',
            'type'          => 'jnews-select',
            'section'       => $this->section_global,
            'label'         => esc_html__('Post Gallery Thumbnail Size','jnews'),
            'description'   => esc_html__('Choose your gallery image thumbnail size. You can also override this behaviour on your single post editor.','jnews'),
            'multiple'      => 1,
            'choices'       => array(
                'crop-500'          => esc_attr__( 'Crop 1/2 Dimension', 'jnews' ),
                'crop-715'          => esc_attr__( 'Crop Default Dimension', 'jnews' ),
            ),
            'postvar'       => array( $this->single_post_tag() )
        ));


    }
}