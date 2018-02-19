<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module\Element;

use JNews\Module\ModuleViewAbstract;

Class Element_Ads_View extends ModuleViewAbstract
{
    public function render_module($attr, $column_class)
    {
        $type = $attr['ads_type'];
        $ads_html = '';

        if($type === 'image')
        {
            $ads_tab = $attr['ads_image_new_tab'] ? '_blank' : '_self';
            $ads_link = $attr['ads_image_link'];
            $ads_text = $attr['ads_image_alt'];
            $ads_image = $attr['ads_image'];

            if( !empty($ads_image) )
            {
                $image_url = wp_get_attachment_image_src($ads_image, "full");
                $ads_html = "<a href='{$ads_link}' target='{$ads_tab}' class='adlink'><img src='{$image_url[0]}' alt='{$ads_text}' data-pin-no-hover=\"true\"></a>";
            }
        }

        if($type === 'code')
        {
            $ads_html = is_null($this->content) ? $attr['content'] : $this->content;
        }

        if($type === 'googleads')
        {
            $publisherid = $attr['google_publisher_id'];
            $slotid = $attr['google_slot_id'];


            if(!empty($publisherid) && !empty($slotid))
            {
                $column = $this->manager->get_current_width();

                if($column >= 8) {
                    $desktopsize_ad = array('728','90');
                    $tabsize_ad = array('468','60');
                    $phonesize_ad = array('320', '50');
                } else {
                    $desktopsize_ad = array('300','250');
                    $tabsize_ad = array('300','250');
                    $phonesize_ad = array('300','250');
                }

                $ad_style = '';

                $desktopsize    = $attr['google_desktop'];
                $tabsize        = $attr['google_tab'];
                $phonesize      = $attr['google_phone'];

                if($desktopsize !== 'auto') {
                    $desktopsize_ad = explode('x', $desktopsize);
                }
                if($tabsize !== 'auto') {
                    $tabsize_ad = explode('x', $tabsize);
                }
                if($phonesize !== 'auto') {
                    $phonesize_ad = explode('x', $phonesize);
                }

                $randomstring = $this->random_string();

                if($desktopsize !== 'hide' && is_array($desktopsize_ad) && isset($desktopsize_ad['0']) && isset($desktopsize_ad['1'])) {
                    $ad_style .= ".adsslot_{$randomstring}{ width:{$desktopsize_ad[0]}px !important; height:{$desktopsize_ad[1]}px !important; }\n";
                }

                if($tabsize !== 'hide' && is_array($tabsize_ad) && isset($tabsize_ad['0']) && isset($tabsize_ad['1'])) {
                    $ad_style .= "@media (max-width:1199px) { .adsslot_{$randomstring}{ width:{$tabsize_ad[0]}px !important; height:{$tabsize_ad[1]}px !important; } }\n";
                }

                if($phonesize !== 'hide' && is_array($phonesize_ad) && isset($phonesize_ad['0']) && isset($phonesize_ad['1'])) {
                    $ad_style .= "@media (max-width:767px) { .adsslot_{$randomstring}{ width:{$phonesize_ad[0]}px !important; height:{$phonesize_ad[1]}px !important; } }\n";
                }


                $ads_html .=
                    "<div class=\"\">
                            <style type='text/css' scoped>
                                {$ad_style}
                            </style>
                            <ins class=\"adsbygoogle adsslot_{$randomstring}\" style=\"display:inline-block;\" data-ad-client=\"{$publisherid}\" data-ad-slot=\"{$slotid}\"></ins>
                            <script async src='//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'></script>
                            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                        </div>";
            }
        }

        return "<div class='jeg_ad jeg_ad_module {$this->unique_id} {$this->get_vc_class_name()}'>" . $ads_html . "</div>";
    }

    /**
     * Random string helper
     *
     * @param int $length
     * @return string
     */
    public function random_string($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}