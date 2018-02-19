<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Customizer;

/**
 * Class Theme JNews Customizer
 */
Class OtherOption extends CustomizerOptionAbstract
{
    /** section */
    private $section_global_loader = 'jnews_global_loader_section';


    public function __construct($customizer, $id)
    {
        parent::__construct($customizer, $id);
    }

    /**
     * Set Section
     */
    public function set_option()
    {
        $this->set_panel();
        $this->set_section();

        $this->set_global_loader_field();
    }

    public function set_panel()
    {
        /** panel */
        $this->customizer->add_panel(array(
            'id' => 'jnews_global_panel',
            'title' => esc_html__('JNews : Additional Option', 'jnews'),
            'description' => esc_html__('JNews Additional Option', 'jnews'),
            'priority' => $this->id
        ));
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id' => $this->section_global_loader,
            'title' => esc_html__('Loader Setting', 'jnews'),
            'panel' => 'jnews_global_panel',
            'priority' => 250,
        ));
    }

    public function set_global_loader_field()
    {
        $this->customizer->add_field(array(
            'id'            => 'jnews_module_loader',
            'transport'     => 'postMessage',
            'default'       => 'dot',
            'type'          => 'jnews-select',
            'section'       => 'jnews_global_loader_section',
            'label'         => esc_html__('Module Loader Style', 'jnews'),
            'description'   => esc_html__('Choose loader style for general module element.','jnews'),
            'choices'       => array(
                'dot'		    => esc_html__('Dot', 'jnews'),
                'circle'		=> esc_html__('Circle', 'jnews'),
                'square'		=> esc_html__('Square', 'jnews'),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.module-overlay  .preloader_type',
                    'property'      => array(
                        'dot'           => 'preloader_dot',
                        'circle'        => 'preloader_circle',
                        'square'        => 'preloader_square',
                    ),
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_loader_mega_menu',
            'transport'     => 'postMessage',
            'default'       => 'dot',
            'type'          => 'jnews-select',
            'section'       => $this->section_global_loader,
            'label'         => esc_html__('Mega Menu Loader Style', 'jnews'),
            'description'   => esc_html__('Choose loader style for mega menu.','jnews'),
            'choices'       => array(
                'dot'		    => esc_html__('Dot', 'jnews'),
                'circle'		=> esc_html__('Circle', 'jnews'),
                'square'		=> esc_html__('Square', 'jnews'),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.newsfeed_overlay .preloader_type',
                    'property'      => array(
                        'dot'           => 'preloader_dot',
                        'circle'        => 'preloader_circle',
                        'square'        => 'preloader_square',
                    ),
                ),
            )
        ));

        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_loader',
            'transport'     => 'postMessage',
            'default'       => 'dot',
            'type'          => 'jnews-select',
            'section'       => 'jnews_global_loader_section',
            'label'         => esc_html__('Sidefeed Loader Style', 'jnews'),
            'description'   => esc_html__('Choose loader style for sidefeed.','jnews'),
            'choices'       => array(
                'dot'		    => esc_html__('Dot', 'jnews'),
                'circle'		=> esc_html__('Circle', 'jnews'),
                'square'		=> esc_html__('Square', 'jnews'),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.jeg_sidefeed_overlay .preloader_type',
                    'property'      => array(
                        'dot'           => 'preloader_dot',
                        'circle'        => 'preloader_circle',
                        'square'        => 'preloader_square',
                    ),
                ),
            )
        ));


        $this->customizer->add_field(array(
            'id'            => 'jnews_sidefeed_ajax_loader',
            'transport'     => 'postMessage',
            'default'       => 'dot',
            'type'          => 'jnews-select',
            'section'       => 'jnews_global_loader_section',
            'label'         => esc_html__('Sidefeed Ajax Overlay Loader Style', 'jnews'),
            'description'   => esc_html__('Choose loader style for sidefeed ajax overlay.','jnews'),
            'choices'       => array(
                'dot'		    => esc_html__('Dot', 'jnews'),
                'circle'		=> esc_html__('Circle', 'jnews'),
                'square'		=> esc_html__('Square', 'jnews'),
            ),
            'output'     => array(
                array(
                    'method'        => 'class-masking',
                    'element'       => '.post-ajax-overlay .preloader_type',
                    'property'      => array(
                        'dot'           => 'preloader_dot',
                        'circle'        => 'preloader_circle',
                        'square'        => 'preloader_square',
                    ),
                ),
            )
        ));
    }
}