<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Archive;

use JNews\Module\Block\BlockViewAbstract;
use JNews\Module\Hero\HeroViewAbstract;

/**
 * Class Theme ArchiveAbstract
 */
abstract Class ArchiveAbstract
{
    /**
     * @var HeroViewAbstract
     */
    protected $hero_instance;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var  BlockViewAbstract
     */
    protected $content_instance;

    /**
     * todo : should choose which breadcrumb we need to use
     *
     * @return string
     */
    public function render_breadcrumb()
    {
        return jnews_render_breadcrumb();
    }

    public function get_content_width()
    {
        if($this->get_content_show_sidebar())
        {
            return 8;
        } else {
            return 12;
        }
    }

    // content
    abstract public function get_content_type();
    abstract public function get_content_excerpt();
    abstract public function get_content_date();
    abstract public function get_content_date_custom();
    abstract public function get_content_pagination();
    abstract public function get_content_pagination_limit();
    abstract public function get_content_pagination_align();
    abstract public function get_content_pagination_navtext();
    abstract public function get_content_pagination_pageinfo();
    abstract public function get_content_show_sidebar();
    abstract public function get_content_sidebar();
}
