<?php
/**
 * @author : Jegtheme
 */
namespace JNews\Module;

abstract Class ModuleViewAbstract
{
    /**
     * @var array
     */
    protected static $instance;

    /**
     * Option Field
     *
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $unique_id;

    /**
     * Array of attribute
     *
     * @var array
     */
    protected $attribute;

    /**
     * @var ModuleManager
     */
    protected $manager;

    /**
     * @var string
     */
    protected $class_name;

    /**
     * @var ModuleOptionAbstract
     */
    protected $option_class;

    /**
     * @var String
     */
    protected $content;

    /**
     * @return ModuleViewAbstract
     * @var $manager
     */
    public static function getInstance()
    {
        $class = get_called_class();

        if (!isset(self::$instance[$class]))
        {
            self::$instance[$class] = new $class();
        }

        return self::$instance[$class];
    }

    /**
     * ModuleViewAbstract constructor.
     */
    protected function __construct()
    {
        $this->class_name = jnews_get_shortcode_name_from_view(get_class($this));
        $this->manager = ModuleManager::getInstance();

        // set option class
        $class_option = str_replace('_View', '_Option', get_class($this));
        $this->option_class = call_user_func(array($class_option, 'getInstance'));

        $this->set_options();
    }

    private function set_options()
    {
        $options = $this->option_class->get_options();

        foreach($options as $option)
        {
            $this->options[$option['param_name']] = isset($option['std']) ? $option['std'] : '';
        }
    }

    private function compatible_column()
    {
        return $this->option_class->compatible_column();
    }

    public function color_scheme()
    {
        return $this->attribute['scheme'];
    }

    public function get_vc_class_name()
    {
        $class_name = null;

        if(isset($this->attribute['css']))
        {
            $css_exploded = explode('{', $this->attribute['css']);
            $class = $css_exploded[0];
            $class_name = substr($class, 1);
        }

        return $class_name;
    }

    public function is_compatible_widget()
    {
        $column = $this->compatible_column();

        if(in_array(4, $column))
        {
            return true;
        }

        return false;
    }

    /**
     * @param $attr
     * @return string
     */
    public function get_module_column_class($attr)
    {
        if(isset($attr['column_width']) && $attr['column_width'] !== 'auto')
        {
            switch($attr['column_width']) {
                case 4 :
                    $class_name = 'jeg_col_1o3';
                    break;
                case 8 :
                    $class_name = 'jeg_col_2o3';
                    break;
                case 12 :
                    $class_name = 'jeg_col_3o3';
                    break;
                default :
                    $class_name = 'jeg_col_3o3';
            }

            return $class_name;
        } else {
            return $this->manager->get_column_class();
        }
    }

    /**
     * Call from VC to build Module
     *
     * @param $attr
     * @param $content
     * @return string
     */
    public function build_module($attr, $content = null)
    {
        $this->content = $content;
        $this->generate_unique_id();
        $attr = $this->get_attribute($attr);

        $column_class = $this->get_module_column_class($attr);
        $output = $this->render_module($attr, $column_class);

        if(!$this->is_column_compatible() && ( current_user_can('editor') || current_user_can('administrator') ))
        {
            $output = $output . $this->render_uncompatible();
        }

        do_action($this->class_name);
        return $output;
    }

    /**
     * Render if module is not compatible
     *
     * @return string
     */
    public function render_uncompatible()
    {
        $compatible = $this->compatible_column();
        $column = $this->manager->get_current_width();
        $text = wp_kses(sprintf(__('This module works best for column <strong>%s</strong> ( current column width <strong>%s</strong> ). This warning will only show if you login as Admin.', 'jnews'), implode(', ', $compatible), $column), wp_kses_allowed_html());
        $element =
            "<div class=\"alert alert-error alert-compatibility\">
                <strong>" . jnews_return_translation('Optimal Column','jnews', 'optimal_column') . "</strong> {$text}
            </div>";

        return $element;
    }

    /**
     * Check if column is not compatible
     *
     * @return bool
     */
    public function is_column_compatible()
    {
        $compatible = $this->compatible_column();
        $column = $this->manager->get_current_width();

        if($column === null) return true;
        return in_array($column, $compatible);
    }

    /**
     * @return int
     */
    public function get_post_id()
    {
        global $wp_query;
        if(isset($wp_query->post)) {
            return $wp_query->post->ID ;
        }
        return null;
    }

    /**
     * Generate Unique ID For Module
     */
    public function generate_unique_id()
    {
        $this->unique_id = 'jnews_module_' . $this->get_post_id() . '_' . $this->manager->get_module_count() . '_' . uniqid();
        // need to increase module count
        $this->manager->increase_module_count();
    }

    /**
     * Render Widget
     *
     * @param $instance
     */
    public function render_widget($instance)
    {
        if($this->is_compatible_widget())
        {
            echo jnews_sanitize_output($this->build_module($instance));
        }
    }

    /**
     * Render VC shortcode
     *
     * @param $attr
     * @param $content
     * @return mixed
     */
    public function render_shortcode($attr, $content)
    {
        return $this->build_module($attr, $content);
    }

    /**
     * get thumbnail
     * @param $post_id
     * @param $size
     * @return mixed|string
     */
    public function get_thumbnail($post_id, $size)
    {
        return apply_filters('jnews_image_thumbnail', $post_id, $size);
    }

    /**
     * Render primary category
     *
     * @param $post_id
     * @return mixed|string
     */
    public function get_primary_category($post_id)
    {
        $cat_id = jnews_get_primary_category($post_id);
        $category = '';

        if($cat_id) {
            $category = get_category($cat_id);
            $class = 'class="category-'. $category->slug .'"';
            $category = "<a href=\"" . get_category_link($cat_id) . "\" {$class}>" . $category->name . "</a>";
        }

        return $category;
    }

    public function except_more()
    {
        return isset($this->attribute['excerpt_ellipsis']) ? $this->attribute['excerpt_ellipsis'] : ' ...';
    }

    public function excerpt_length()
    {
        if(isset($this->attribute['excerpt_length']))
        {
            return $this->attribute['excerpt_length'];
        } else {
            return 20;
        }
    }

    public function format_date($post)
    {
        if(isset($this->attribute['date_format']))
        {
            $date_format = $this->attribute['date_format'];

            if($date_format === 'ago') {
                return jnews_ago_time ( human_time_diff( get_the_time('U', $post), current_time('timestamp') ) );
            } else if ($date_format === 'custom') {
                return get_the_date($this->attribute['date_format_custom'], $post);
            } else if ($date_format) {
                return get_the_date(null, $post);
            }
        }

        return get_the_date(null, $post);
    }

    protected function get_excerpt($post)
    {
        $excerpt = $post->post_excerpt;

        if(empty($excerpt))
        {
            $excerpt = $post->post_content;
        }

        $excerpt = wp_trim_words($excerpt, $this->excerpt_length(), $this->except_more());
        $excerpt = preg_replace( '/\[[^\]]+\]/', '', $excerpt );

        return apply_filters('jnews_module_excerpt', $excerpt, $post->ID, $this->excerpt_length(), $this->except_more());
    }

    protected function collect_post_id($content)
    {
        $post_ids = array();
        foreach($content['result'] as $result) {
            $post_ids[] = $result->ID;
        }
        return $post_ids;
    }

    /**
     * build query
     *
     * @param $attr
     * @return array
     */
    protected function build_query($attr)
    {
        if(isset($attr['unique_content']) && $attr['unique_content'] !== 'disable')
        {
            if(!empty($attr['exclude_post'])) {
                $exclude_post = explode(',', $attr['exclude_post']);
            } else {
                $exclude_post = array();
            }

            $exclude_post = array_merge($this->manager->get_unique_article($attr['unique_content']), $exclude_post);
            $attr['exclude_post'] = implode(',', $exclude_post);

            // we need to alter attribute here...
            $this->set_attribute($attr);
        }

        $result = ModuleQuery::do_query($attr);

        if(isset($attr['unique_content']) && $attr['unique_content'] !== 'disable')
        {
            $this->manager->add_unique_article($attr['unique_content'], $this->collect_post_id($result));
        }

        if(isset($result['result']))
        {
            foreach($result['result'] as $post)
            {
                do_action('jnews_json_archive_push', $post->ID);
            }
        }

        return $result;
    }

    /**
     * Post meta type 1
     *
     * @param $post
     * @return string
     */
    public function post_meta_1($post)
    {
        $output = '';
        $comment            = jnews_get_comments_number($post->ID);

        // author detail
        $author             = $post->post_author;
        $author_url         = get_author_posts_url($author);
        $author_name        = get_the_author_meta('display_name', $author);

        if( jnews_is_review($post->ID) )
        {
            $rating = jnews_generate_rating($post->ID, 'jeg_landing_review');
            $output .=
                "<div class=\"jeg_post_meta\">
                    {$rating}
                    <div class=\"jeg_meta_author\"><span class=\"by\">" . jnews_return_translation('by', 'jnews', 'by') . "</span> <a href=\"{$author_url}\">{$author_name}</a></div>
                </div>";
        } else {
            $output .=
                "<div class=\"jeg_post_meta\">
                    <div class=\"jeg_meta_author\"><span class=\"by\">" . jnews_return_translation('by', 'jnews', 'by') . "</span> <a href=\"{$author_url}\">{$author_name}</a></div>
                    <div class=\"jeg_meta_date\"><a href=\"" . get_the_permalink($post) . "\"><i class=\"fa fa-clock-o\"></i> " . $this->format_date($post) . "</a></div>
                    <div class=\"jeg_meta_comment\"><a href=\"" . jnews_get_respond_link($post->ID) . "\" ><i class=\"fa fa-comment-o\"></i> {$comment}</a></div>
                </div>";
        }

        return apply_filters('jnews_module_post_meta_1', $output, $post, self::getInstance());
    }

    /**
     * Post Meta Type 2
     *
     * @param $post
     * @return string
     */
    public function post_meta_2($post)
    {
        $output = '';
        if( jnews_is_review($post->ID) )
        {
            $output = jnews_generate_rating($post->ID, 'jeg_landing_review');
        } else {

            $output .=
                "<div class=\"jeg_post_meta\">
                    <div class=\"jeg_meta_date\"><a href=\"" . get_the_permalink($post) . "\" ><i class=\"fa fa-clock-o\"></i> " . $this->format_date($post) . "</a></div>
                </div>";
        }


        return apply_filters('jnews_module_post_meta_2', $output, $post, self::getInstance());
    }

    /**
     * Post meta type 3
     *
     * @param $post
     * @return string
     */
    public function post_meta_3($post)
    {
        $output = '';

        if(jnews_is_review($post->ID))
        {
            $rating = jnews_generate_rating($post->ID, 'jeg_landing_review');

            $output =
                "<div class=\"jeg_post_meta\">
                    {$rating}
                    <div class=\"jeg_meta_date\"><a href=\"" . get_the_permalink($post) . "\"><i class=\"fa fa-clock-o\"></i> " . $this->format_date($post) . "</a></div>                    
                </div>";
        } else {

            // author detail
            $author             = $post->post_author;
            $author_url         = get_author_posts_url($author);
            $author_name        = get_the_author_meta('display_name', $author);

            $output .=
                "<div class=\"jeg_post_meta\">
                    <div class=\"jeg_meta_author\"><span class=\"by\">" . jnews_return_translation('by', 'jnews', 'by') . "</span> <a href=\"{$author_url}\">{$author_name}</a></div>
                    <div class=\"jeg_meta_date\"><a href=\"" . get_the_permalink($post) . "\"><i class=\"fa fa-clock-o\"></i> " . $this->format_date($post) . "</a></div>
                </div>";

        }

        return apply_filters('jnews_module_post_meta_3', $output, $post, self::getInstance());
    }

    /**
     * Get attribute
     *
     * @param $attr
     * @return array
     */
    public function get_attribute($attr)
    {
        $this->attribute = wp_parse_args( $attr , $this->options);
        return $this->attribute;
    }

    public function set_attribute($attr)
    {
        $this->attribute = $attr;
    }

    /**
     * Empty Content
     *
     * @return string
     */
    public function empty_content()
    {
        $no_content = "<div class='jeg_empty_module'>" . jnews_return_translation('No Content Available','jnews', 'no_content_available') . "</div>";
        return apply_filters('jnews_module_no_content', $no_content);
    }

    abstract public function render_module($attr, $column_class);
}
