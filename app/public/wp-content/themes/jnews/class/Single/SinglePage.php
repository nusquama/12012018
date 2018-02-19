<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Single;

/**
 * Class Theme SinglePage
 */
Class SinglePage
{
    /**
     * @var \WP_Post
     */
    private $post_id;

    public function __construct($post_id = null)
    {
        $this->post_id = ($post_id === null ) ? get_the_ID() : $post_id;
    }

    public function render_breadcrumb()
    {
        echo jnews_render_breadcrumb();
    }

    public function can_render_post_meta()
    {
        return vp_metabox('jnews_single_page.show_post_meta');
    }

    public function get_featured_image_src($size)
    {
        $post_thumbnail_id  = get_post_thumbnail_id( $this->post_id );
        $image              = wp_get_attachment_image_src($post_thumbnail_id, $size);

        return $image[0];
    }

    public function render_featured_post()
    {
        if($this->have_sidebar())
        {
            $image_size = 'jnews-featured-750';
        } else {
            $image_size = 'jnews-featured-1140';
        }

        $output = "<div class=\"jeg_featured featured_image\">";

        $popup              = get_theme_mod('jnews_single_popup_script', 'magnific');
        $image_src          = $this->get_featured_image_src('full');

        if(has_post_thumbnail())
        {
            $output .= ( $popup !== 'disable' ) ? "<a href=\"{$image_src}\">" : "";
            $output .= apply_filters('jnews_image_thumbnail_unwrap', $this->post_id, $image_size);
            $output .= ( $popup !== 'disable' ) ? "</a>" : "";
        }

        $output .= "</div>";
        return apply_filters('jnews_featured_image', $output, $this->post_id);
    }

    public function share_float_additional_class()
    {
        $share_position = vp_metabox('jnews_single_page.share_position', 'top');

        if($share_position === 'float' || $share_position === 'floatbottom')
        {
            echo "with-share";
        }
    }

    public function is_share_float()
    {
        $share_position = vp_metabox('jnews_single_page.share_position', 'top');

        if($share_position === 'float' || $share_position === 'floatbottom')
        {
            return true;
        }
        return false;
    }

    public function get_sidebar()
    {
        return vp_metabox('jnews_single_page.sidebar');
    }

    public function get_sticky_sidebar()
    {
        if ( vp_metabox('jnews_single_page.sticky_sidebar') )
        {
            return 'jeg_sticky_sidebar';
        }
        
        return false;
    }

    public function column_width()
    {
        if($this->have_sidebar()) {
            return 8;
        } else {
            return 12;
        }
    }

    public function have_sidebar()
    {
        $layout = vp_metabox('jnews_single_page.layout', 'no-sidebar');

        if($layout === 'right-sidebar' || $layout === 'left-sidebar') {
            return true;
        } else {
            return false;
        }
    }

    public function main_class()
    {
        $layout = vp_metabox('jnews_single_page.layout', 'no-sidebar');

        if($layout === 'left-sidebar')
        {
            echo "jeg_sidebar_left";
        } else if ($layout === 'no-sidebar') 
        {
            echo "jeg_sidebar_none";
        }
    }

}