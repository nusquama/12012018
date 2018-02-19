<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class JNews_SEO_Option
 */
Class JNews_JSONLD_Option
{

    /**
     * @var JNews_JSONLD_Option
     */
    private static $instance;

    /**
     * @var JNews_Customizer
     */
    private $customizer;
    private $section_schema_setting = 'jnews_schema_setting';
    private $section_main_schema = 'jnews_main_schema';
    private $section_article_schema = 'jnews_article_schema';

    /**
     * @return JNews_JSONLD_Option
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function __construct()
    {
        if(class_exists('Jeg\Customizer'))
        {
            $this->customizer = Jeg\Customizer::getInstance();

            $this->set_panel();
            $this->set_section();

            $this->set_setting_json_ld();
            $this->set_main_json_ld();
            $this->set_article_json_ld();
        }
    }

    public function set_panel()
    {
        $this->customizer->add_panel(array(
            'id' => 'jnews_global_seo',
            'title' => esc_html__('JNews : JSON LD Schema Setting', 'jnews-jsonld'),
            'description' => esc_html__('JSON LD Schema setting.', 'jnews-jsonld'),
            'priority' => 196
        ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id' => $this->section_schema_setting,
            'title' => esc_html__('Schema Setting', 'jnews-jsonld'),
            'panel' => 'jnews_global_seo',
            'priority' => 250,
        ));

        $this->customizer->add_section(array(
            'id' => $this->section_main_schema,
            'title' => esc_html__('Home Page Schema', 'jnews-jsonld'),
            'panel' => 'jnews_global_seo',
            'priority' => 250,
        ));

        $this->customizer->add_section(array(
            'id' => $this->section_article_schema,
            'title' => esc_html__('Post Schema', 'jnews-jsonld'),
            'panel' => 'jnews_global_seo',
            'priority' => 250,
        ));
    }

    public function set_setting_json_ld()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_option[enable_schema]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => true,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_schema_setting,
            'label'         => esc_html__('Enable json ld schema', 'jnews-jsonld'),
            'description'   => esc_html__('Turn this option on to enable jnews generate JSON LD Schema for your website.', 'jnews-jsonld'),
        ));
    }

    public function set_main_json_ld()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_option[main_schema_type]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'organization',
            'type'          => 'jnews-select',
            'section'       => $this->section_main_schema,
            'label'         => esc_html__('Home Page Schema Type','jnews-jsonld'),
            'description'   => esc_html__('Choose which schema you want to use for your home page.','jnews-jsonld'),
            'choices'       => array(
                'person'        => esc_attr__( 'Person', 'jnews-jsonld' ),
                'organization'  => esc_attr__( 'Organization', 'jnews-jsonld' ),
            ),
        ));



        $this->customizer->add_field(array(
            'id'            => 'jnews_option[main_schema_type_header_person]',
            'option_type'   => 'option',
            'type'          => 'jnews-header',
            'section'       => $this->section_main_schema,
            'label'         => esc_html__('Person Schema','jnews-jsonld' ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[main_schema_type]',
                    'operator' => '==',
                    'value'    => 'person',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[main_schema_person_name]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_main_schema,
            'label'         => esc_html__('Name','jnews-jsonld'),
            'description'   => esc_html__('Insert person name.','jnews-jsonld'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[main_schema_type]',
                    'operator' => '==',
                    'value'    => 'person',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[main_scheme_person_address]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_main_schema,
            'label'         => esc_html__('Address','jnews-jsonld'),
            'description'   => esc_html__('Insert country address.','jnews-jsonld'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[main_schema_type]',
                    'operator' => '==',
                    'value'    => 'person',
                )
            )
        ));



        $this->customizer->add_field(array(
            'id'            => 'jnews_option[main_schema_type_header_organization]',
            'type'          => 'jnews-header',
            'section'       => $this->section_main_schema,
            'label'         => esc_html__('Organization Schema','jnews-jsonld' ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[main_schema_type]',
                    'operator' => '==',
                    'value'    => 'organization',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[main_schema_organization_name]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_main_schema,
            'label'         => esc_html__('Organization Name','jnews-jsonld'),
            'description'   => esc_html__('Insert organization or company name.','jnews-jsonld'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[main_schema_type]',
                    'operator' => '==',
                    'value'    => 'organization',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[main_schema_logo]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'image',
            'section'       => $this->section_main_schema,
            'label'         => esc_html__('Logo','jnews-jsonld' ),
            'description'   => esc_html__('Upload organization or company logo.','jnews-jsonld' ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[main_schema_type]',
                    'operator' => '==',
                    'value'    => 'organization',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[main_scheme_telp]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_main_schema,
            'label'         => esc_html__('Telephone','jnews-jsonld'),
            'description'   => esc_html__('e.g. : +1-880-555-1212','jnews-jsonld'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[main_schema_type]',
                    'operator' => '==',
                    'value'    => 'organization',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[main_scheme_contact_type]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'customer_service',
            'type'          => 'jnews-select',
            'section'       => $this->section_main_schema,
            'label'         => esc_html__('Contact Type','jnews-jsonld'),
            'description'   => esc_html__('Choose company contact type.','jnews-jsonld'),
            'choices'       => array(
                'customer service' => esc_attr__( 'Customer service', 'jnews-jsonld' ),
                'technical support' => esc_attr__( 'Technical support', 'jnews-jsonld' ),
                'billing support' => esc_attr__( 'Billing support', 'jnews-jsonld' ),
                'bill payment' => esc_attr__( 'Bill payment', 'jnews-jsonld' ),
                'sales' => esc_attr__( 'Sales', 'jnews-jsonld' ),
                'reservations' => esc_attr__( 'Reservations', 'jnews-jsonld' ),
                'credit card_support' => esc_attr__( 'Credit card support', 'jnews-jsonld' ),
                'emergency' => esc_attr__( 'Emergency', 'jnews-jsonld' ),
                'baggage tracking' => esc_attr__( 'Baggage tracking', 'jnews-jsonld' ),
                'roadside assistance' => esc_attr__( 'Roadside assistance', 'jnews-jsonld' ),
                'package tracking' => esc_attr__( 'Package tracking', 'jnews-jsonld' ),
            ),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[main_schema_type]',
                    'operator' => '==',
                    'value'    => 'organization',
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_option[main_scheme_area]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_main_schema,
            'label'         => esc_html__('Area Served','jnews-jsonld'),
            'description'   => esc_html__('eg : US , or US,CA','jnews-jsonld'),
            'active_callback' => array(
                array(
                    'setting'  => 'jnews_option[main_schema_type]',
                    'operator' => '==',
                    'value'    => 'organization',
                )
            )
        ));
    }

    public function set_article_json_ld()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_option[article_schema_type]',
            'option_type'   => 'option',
            'transport'     => 'postMessage',
            'default'       => 'article',
            'type'          => 'jnews-select',
            'section'       => $this->section_article_schema,
            'label'         => esc_html__('Blog Page Schema Type','jnews-jsonld'),
            'description'   => esc_html__('Choose which schema you want to use for your blog post.','jnews-jsonld'),
            'choices'       => array(
                'Article'           => esc_attr__( 'Article', 'jnews-jsonld' ),
                'BlogPosting'       => esc_attr__( 'Blog Posting', 'jnews-jsonld' ),
                'NewsArticle'       => esc_attr__( 'News Article', 'jnews-jsonld' ),
                'TechArticle'       => esc_attr__( 'Tech Article ', 'jnews-jsonld' ),
            ),
        ));
    }
}