<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Carousel;

Class Carousel_1_View extends CarouselViewAbstract
{
    public function content($results)
    {
        $content = '';
        foreach($results as $key => $post)
        {
            $image = $this->get_thumbnail($post->ID, 'jnews-350x250');
            $content .=
                "<article " . jnews_post_class("jeg_post", $post->ID) . ">
                    <div class=\"jeg_thumb\">
                        " . jnews_edit_post( $post->ID ) . "
                        <a href=\"" . get_the_permalink($post) . "\">$image</a>
                    </div>
                    <div class=\"jeg_postblock_content\">
                        <h3 class=\"jeg_post_title\"><a href=\"" . get_the_permalink($post) . "\">" . get_the_title($post) . "</a></h3>
                        <div class=\"jeg_post_meta\">
                            <div class=\"jeg_meta_date\"><i class=\"fa fa-clock-o\"></i> " . $this->format_date($post) . "</div>
                        </div>
                    </div>
                </article>";
        }

        return $content;
    }

    public function render_element($result, $attr)
    {
        if(!empty($result))
        {
            $content = $this->content($result);
            $width = $this->manager->get_current_width();
            $output =
                "<div class=\"jeg_postblock_carousel_1 jeg_postblock jeg_col_{$width} {$this->unique_id} {$this->get_vc_class_name()} {$this->color_scheme()}\">
                    <div class=\"jeg_carousel_post owl-carousel\" data-nav='{$attr['show_nav']}' data-autoplay='{$attr['enable_autoplay']}' data-delay='{$attr['autoplay_delay']}' data-items='{$attr['number_item']}' data-margin='{$attr['margin']}'>
                        {$content}
                    </div>
                </div>";

            return $output;
        } else {
            return $this->empty_content();
        }
    }
}
