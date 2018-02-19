<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Customizer;

/**
 * Class Theme JNews Customizer
 */
Class ImageOption extends CustomizerOptionAbstract
{
    private $section_global_image = 'jnews_global_image_section';
    private $section_popup = 'jnews_single_popup_section';
    private $section_gif = 'jnews_global_gif_section';

    public function set_option()
    {
        $this->set_panel();
        $this->set_section();

        $this->set_global_image_field();
        $this->set_popup_field();
        $this->set_gif_image_field();
    }

    public function set_panel()
    {
        $this->customizer->add_panel(array(
            'id' => 'jnews_image_panel',
            'title' => esc_html__('JNews : Image & Gallery Option', 'jnews'),
            'description' => esc_html__('JNews Image Option', 'jnews'),
            'priority' => $this->id
        ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id' => $this->section_global_image,
            'title' => esc_html__('Image Load & Generator Setting', 'jnews'),
            'panel' => 'jnews_image_panel',
            'priority' => 250,
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_popup,
            'title'         => esc_html__('Image Popup', 'jnews'),
            'panel'         => 'jnews_image_panel',
            'priority'      => 250
        ));

        $this->customizer->add_section(array(
            'id'            => $this->section_gif,
            'title'         => esc_html__('GIF Image', 'jnews'),
            'panel'         => 'jnews_image_panel',
            'priority'      => 250
        ));
    }


    public function set_popup_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_single_popup_script',
            'transport'     => 'postMessage',
            'default'       => 'magnific',
            'type'          => 'jnews-select',
            'section'       => $this->section_popup,
            'label'         => esc_html__('Image Popup Script','jnews'),
            'description'   => wp_kses(__("This option will enable your image popup on Gallery Thumbnail, Single image, and WordPress default gallery.
            <ol>
                <li><strong>Photoswipe :</strong> Zoomable, ability to go fullscreen, button for share on social network.</li>
                <li><strong>Magnific :</strong> Simple Option, option to turn all single image into one gallery.</li>
            </ol>",'jnews'), wp_kses_allowed_html()),
            'choices'       => array(
                'disable'       => esc_attr__( 'Disabled', 'jnews' ),
                'photoswipe'    => esc_attr__( 'Photoswipe', 'jnews' ),
                'magnific'      => esc_attr__( 'Magnific Popup', 'jnews' ),
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'single_post_tag',
                    'refresh'   => true
                )
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_single_as_gallery',
            'transport'     => 'postMessage',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_popup,
            'label'         => esc_html__('Set Images as Gallery','jnews'),
            'description'   => esc_html__('Set images on a single post as one instance of gallery.','jnews'),
            'active_callback'  => array(
                array(
                    'setting'  => 'jnews_single_popup_script',
                    'operator' => '==',
                    'value'    => 'magnific',
                )
            ),
            'postvar'       => array(
                array(
                    'redirect'  => 'single_post_tag',
                    'refresh'   => true
                )
            )
        ));
    }

    public function set_global_image_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_image_load_alert',
            'type'          => 'jnews-alert',
            'default'       => 'info',
            'section'       => $this->section_global_image,
            'label'         => esc_html__('How Image Loaded','jnews' ),
            'description'   => wp_kses(__(
                '<ul>
                    <li><strong>Normal Load Image :</strong> Support retina, largest size at first load, good for SEO.</li>
                    <li><strong>Lazy Load :</strong> Less number of image on first load, support for retina, best browsing experience, good for SEO.</li>
                    <li><strong>Background :</strong> Support GIF image as featured thumbnail, bad for SEO.</li>
                </ul>',
                'jnews'), wp_kses_allowed_html()),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_image_load',
            'transport'     => 'refresh',
            'default'       => 'lazyload',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_image,
            'label'         => esc_html__('Image Load Mechanism', 'jnews'),
            'description'   => esc_html__('Choose image load mechanism method.', 'jnews'),
            'choices'       => array(
                'normal'        => 'Normal image load',
                'lazyload'		=> 'Lazy load image',
                'background'    => 'Background Image',
            ),
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_image_generator_alert',
            'type'          => 'jnews-alert',
            'default'       => 'info',
            'section'       => $this->section_global_image,
            'label'         => esc_html__('How Image Generated','jnews' ),
            'description'   => wp_kses(__(
                '<ul>
                    <li><strong>Normal Image Generator :</strong> Fastest load time, but require more space. About 12 images will be generated for single image uploaded. If you switch to this option, please regenerate image again.</li>
                    <li><strong>Dynamic Image Generator :</strong> Slower load time only when image created for the first time. Image generated only when needed.</li>                    
                </ul>',
                'jnews'), wp_kses_allowed_html()),
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_image_generator',
            'transport'     => 'refresh',
            'default'       => 'normal',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_image,
            'label'         => esc_html__('Image Generator', 'jnews'),
            'description'   => esc_html__('Choose image generated method.', 'jnews'),
            'choices'       => array(
                'normal'        => 'Normal Image Generator',
                'dynamic'		=> 'Dynamic Image Generator',
            ),
        ));
    }

    public function set_gif_image_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_transform_gif',
            'transport'     => 'refresh',
            'default'       => false,
            'type'          => 'jnews-toggle',
            'section'       => $this->section_gif,
            'label'         => esc_html__('Use JNews GIF image','jnews'),
            'description'   => esc_html__('Enable stop / pause GIF image','jnews'),
        ));
    }

}