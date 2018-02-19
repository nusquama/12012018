<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Customizer;

/**
 * Class Theme JNews Customizer
 */
Class FontOption extends CustomizerOptionAbstract
{

    /** @var string section */
    private $section_additional_font = 'jnews_additional_font_section';

    /** @var string section */
    private $section_global_font = 'jnews_global_font_section';

    /** @var string section */
    private $section_typekit_font = 'jnews_typekit_font_section';

    /**
     * Set Section
     */
    public function set_option()
    {
        $this->set_panel();
        $this->set_section();

        $this->set_global_font_field();
        $this->set_field_additional_font_field();
        $this->set_typekit_font_field();
    }

    public function set_panel()
    {
        /** panel */
        $this->customizer->add_panel(array(
            'id'            => 'jnews_font',
            'title'         => esc_html__( 'JNews : Font Option' ,'jnews' ),
            'description'   => esc_html__( 'JNews Font Management','jnews' ),
            'priority'      => $this->id
        ));
    }

    public function set_section()
    {
        /** global font setting */
        $this->customizer->add_section(array(
            'id'            => $this->section_global_font,
            'title'         => esc_html__('Global Font', 'jnews' ),
            'panel'         => 'jnews_font',
            'priority'      => 250,
        ));

        /** additional font setting */
        $this->customizer->add_section(array(
            'id'            => $this->section_additional_font,
            'title'         => esc_html__('Custom Font', 'jnews' ),
            'panel'         => 'jnews_font',
            'priority'      => 250,
        ));


        /** type kit font setting */
        $this->customizer->add_section(array(
            'id'            => $this->section_typekit_font,
            'title'         => esc_html__('Type Kit font', 'jnews' ),
            'panel'         => 'jnews_font',
            'priority'      => 250,
        ));
    }

    public function set_field_additional_font_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_additional_font',
            'transport'     => 'postMessage',
            'type'          => 'repeater',
            'section'       => $this->section_additional_font,
            'label'         => esc_html__('Upload Your Font', 'jnews' ),
            'description'   => wp_kses(sprintf(__("You can generate your font using
                                <a href='%s' target='_blank'>font squirrel generator</a>.
                                <br/>You will need to <strong>refresh your customizer</strong> to see your font on the font list.", "jnews"), "http://www.fontsquirrel.com/tools/webfont-generator"),
                wp_kses_allowed_html()),
            'default'       => array(),
            'row_label'     => array(
                'type' => 'text',
                'value' => esc_attr__( 'Custom font', 'jnews' ),
                'field' => false,
            ),
            'fields' => array(
                'font_name' => array(
                    'type'        => 'text',
                    'label'       => esc_attr__( 'Font Name', 'jnews' ),
                    'description' => esc_attr__( 'Please fill your font name. You can put same font name on font uploader in case you have several types of font (bold, italic or other).', 'jnews' ),
                    'default'     => '',
                ),
                'font_weight' => array(
                    'type'        => 'select',
                    'label'       => esc_attr__( 'Font Weight', 'jnews' ),
                    'description' => esc_attr__( 'Please choose this file\'s font weight.', 'jnews' ),
                    'choices'     => array(
                        '100'     => '100',
                        '200'     => '200',
                        '300'     => '300',
                        '400'     => '400',
                        '500'     => '500',
                        '600'     => '600',
                        '700'     => '700',
                        '800'     => '800',
                        '900'     => '900',
                    ),
                    'default'     => '400',
                ),
                'font_style' => array(
                    'type'        => 'select',
                    'label'       => esc_attr__( 'Font Style', 'jnews' ),
                    'description' => esc_attr__( 'Please fill this file\'s font style.', 'jnews' ),
                    'choices'     => array(
                        'italic'        => esc_attr__('Italic', 'jnews'),
                        'normal'       => esc_attr__('Regular', 'jnews'),
                    ),
                    'default'     => 'regular',
                ),
                'eot' => array(
                    'type'        => 'upload',
                    'label'       => esc_attr__( 'EOT File', 'jnews' ),
                    'default'     => '',
                    'mime_type'   => 'font',
                ),
                'woff' => array(
                    'type'        => 'upload',
                    'label'       => esc_attr__( 'WOFF File', 'jnews' ),
                    'default'     => '',
                    'mime_type'   => 'font',
                ),
                'ttf' => array(
                    'type'        => 'upload',
                    'label'       => esc_attr__( 'TTF File', 'jnews' ),
                    'default'     => '',
                    'mime_type'   => 'font',
                ),
                'svg' => array(
                    'type'        => 'upload',
                    'label'       => esc_attr__( 'SVG File', 'jnews' ),
                    'default'     => '',
                    'mime_type'   => 'font',
                ),
            )
        ));
    }

    public function set_global_font_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_body_font',
            'transport'     => 'postMessage',
            'type'          => 'jnews-typography',
             'section'       => $this->section_global_font,
            'label'         => esc_html__('Body Font', 'jnews' ),
            'description'   => esc_html__('Site global font.', 'jnews' ),
            'default'     => array (
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'subsets'        => array( ),
                'color'          => ''
            ),
            'output'     => array(
                array(
                    'method'        => 'typography',
                    'element'       => 'body,input,textarea,select,.chosen-container-single .chosen-single,.btn,.button'
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_header_font',
            'transport'     => 'postMessage',
            'type'          => 'jnews-typography',
            'section'       => $this->section_global_font,
            'label'         => esc_html__('Header Font', 'jnews' ),
            'description'   => esc_html__('Set font for your header', 'jnews' ),
            'default'     => array (
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'subsets'        => array( ),
                'color'          => ''
            ),
            'output'     => array(
                array(
                    'method'        => 'typography',
                    'element'       => '.jeg_header, .jeg_mobile_wrapper'
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_main_menu_font',
            'transport'     => 'postMessage',
            'type'          => 'jnews-typography',
            'section'       => $this->section_global_font,
            'label'         => esc_html__('Main Menu Font', 'jnews' ),
            'description'   => esc_html__('Set font for your main menu', 'jnews' ),
            'default'     => array (
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'subsets'        => array( ),
                'color'          => ''
            ),
            'output'     => array(
                array(
                    'method'        => 'typography',
                    'element'       => '.jeg_menu.jeg_main_menu, .jeg_mobile_menu'
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_h1_font',
            'transport'     => 'postMessage',
            'type'          => 'jnews-typography',
            'section'       => $this->section_global_font,
            'label'         => esc_html__('Post Title', 'jnews' ),
            'description'   => esc_html__('Set font for post title.', 'jnews' ),
            'default'     => array (
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'subsets'        => array( ),
                'color'          => ''
            ),
            'output'     => array(
                array(
                    'method'        => 'typography',
                    'element'       => '.jeg_post_title'
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_block_heading_font',
            'transport'     => 'postMessage',
            'type'          => 'jnews-typography',
            'section'       => $this->section_global_font,
            'label'         => esc_html__('Block Heading', 'jnews' ),
            'description'   => esc_html__('Block module and widget title.', 'jnews' ),
            'default'     => array (
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'subsets'        => array( ),
                'color'          => ''
            ),
            'output'     => array(
                array(
                    'method'        => 'typography',
                    'element'       => 'h3.jeg_block_title, .jeg_footer .jeg_footer_heading h3, .jeg_tabpost_nav li'
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_p_font',
            'transport'     => 'postMessage',
            'type'          => 'jnews-typography',
            'section'       => $this->section_global_font,
            'label'         => esc_html__('Paragraph Font', 'jnews' ),
            'description'   => esc_html__('Paragraph font.', 'jnews' ),
            'default'     => array (
                'font-family'    => '',
                'variant'        => '',
                'font-size'      => '',
                'line-height'    => '',
                'subsets'        => array( ),
                'color'          => ''
            ),
            'output'     => array(
                array(
                    'method'        => 'typography',
                    'element'       => '.jeg_post_excerpt p, .content-inner p'
                )
            )
        ));
    }

    public function set_typekit_font_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_type_kit_id',
            'transport'     => 'refresh',
            'default'       => '',
            'type'          => 'text',
            'section'       => $this->section_typekit_font,
            'label'         => esc_html__('Type Kit ID', 'jnews'),
            'description'   => esc_html__('Please input your type kit ID here.', 'jnews')
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_type_kit',
            'transport'     => 'postMessage',
            'type'          => 'repeater',
            'section'       => $this->section_typekit_font,
            'label'         => esc_html__('Name your type kit font', 'jnews' ),
            'description'   => esc_html__('Please provide your type kit name for your theme.', 'jnews'),
            'default'       => array(),
            'row_label'     => array(
                'type' => 'text',
                'value' => esc_attr__( 'Type kit font', 'jnews' ),
                'field' => false,
            ),
            'fields' => array(
                'font_name' => array(
                    'type'        => 'text',
                    'label'       => esc_attr__( 'Font Name', 'jnews' ),
                    'default'     => '',
                ),
            )
        ));
    }
}