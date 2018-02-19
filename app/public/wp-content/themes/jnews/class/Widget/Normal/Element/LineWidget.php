<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Widget\Normal\Element;

use JNews\Widget\Normal\NormalWidgetInterface;

Class LineWidget implements NormalWidgetInterface
{
    /**
     * Register widget with WordPress.
     */
    public function get_options()
    {
        return array (
            'color'   => array(
                'title'     => esc_html__('HR Color', 'jnews'),
                'desc'      => esc_html__('Color of line element.', 'jnews'),
                'type'      => 'color',
                'default'   => 'rgba(255,255,255,0.2)'
            ),
            'margintop'   => array(
                'title'     => esc_html__('Margin Top', 'jnews'),
                'desc'      => esc_html__('Set margin top in px.', 'jnews'),
                'type'      => 'slider',
                'options'    => array(
                    'min'  => '0',
                    'max'  => '200',
                    'step' => '1',
                ),
                'default'   => 0,
            ),
            'marginbottom'   => array(
                'title'     => esc_html__('Margin Bottom', 'jnews'),
                'desc'      => esc_html__('Set margin bottom in px.', 'jnews'),
                'type'      => 'slider',
                'options'    => array(
                    'min'  => '0',
                    'max'  => '200',
                    'step' => '1',
                ),
                'default'   => 0,
            ),
        );
    }

    public function render_widget($instance)
    {
        $style = '';
        if(isset($color)) $style .= 'border-color : ' . $color . ';';
        if(isset($margintop)) $style .= 'margin-top: ' . $margintop . 'px;';
        if(isset($marginbottom)) $style .= 'margin-bottom: ' . $marginbottom . 'px;';
        ?>
        <hr class="clearfix" style="<?php echo esc_attr($style); ?>">
        <?php
    }
}