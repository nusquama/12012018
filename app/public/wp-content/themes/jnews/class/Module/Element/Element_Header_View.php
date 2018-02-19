<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Element;

use JNews\Module\ModuleViewAbstract;

Class Element_Header_View extends ModuleViewAbstract
{
    public function render_module($attr, $column_class)
    {
        // Heading
        $subtitle       = ! empty($attr['second_title']) ? "<strong>{$attr['second_title']}</strong>"  : "";
        $header_class   = "jeg_block_{$attr['header_type']}";
        $heading_title  = $attr['first_title'] . $subtitle;

        if(!empty($heading_title))
        {
            $heading_icon   = empty($attr['header_icon']) ? "" : "<i class='{$attr['header_icon']}'></i>";
            $heading_title  = "<span>{$heading_icon}{$attr['first_title']}{$subtitle}</span>";
            $heading_title  = ! empty($attr['url']) ? "<a href='{$attr['url']}'>{$heading_title}</a>" : $heading_title;
            $heading_title  = "<h3 class=\"jeg_block_title\">{$heading_title}</h3>";
        }

        $style_output   = jnews_header_styling($attr, $this->unique_id);
        $style          = !empty($style_output) ? "<style>{$style_output}</style>" : "";

        // Now Render Output
        if(empty($heading_title)) {
            $output = '';
        } else {
            $output =
                "<div class=\"jeg_block_heading {$header_class} jeg_align{$attr['header_align']} {$this->unique_id} {$this->get_vc_class_name()} {$this->color_scheme()}\">
                    {$heading_title}
                    {$style}
                </div>";
        }

        return $output;
    }

}
