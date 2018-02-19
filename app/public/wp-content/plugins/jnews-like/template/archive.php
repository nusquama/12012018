<?php
    get_header();
    $like = JNews_Like::getInstance();
?>

<div class="jeg_main">
    <div class="jeg_container">
        <div class="jeg_content">
            <div class="jeg_section">
                <div class="container">

                    <div class="jeg_archive_header">
                        <h1 class='jeg_archive_title'><?php $like->get_archive_title(); ?></h1>
                    </div>

                    <div class="jeg_cat_content row">

                        <div class="jeg_main_content jeg_column col-sm-<?php echo esc_attr(is_active_sidebar('default-sidebar') ? '8' : '12'); ?>">

                            <div class="jeg_postblock_3 jeg_postblock">
                                <div class="jeg_posts jeg_block_container">
                                    <div class="jeg_posts">

                                        <?php
                                            
                                            $posts = array_reverse( $like->get_posts() );

                                            if ( empty( $posts ) ) 
                                            {
                                                $like->empty_content();
                                            } else {
                                                $currentpage = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

                                                $args = array(
                                                    'post_type'           => 'post',
                                                    'post__in'            => $posts,
                                                    'orderby'             => 'date',
                                                    'order'               => 'desc',
                                                    'paged'               => $currentpage,
                                                    'ignore_sticky_posts' => 1,
                                                );

                                                $posts = new WP_Query( $args );

                                                if ( $posts->have_posts() )
                                                {

                                                    add_filter('excerpt_more', 'jnews_excerpt_more');
                                                    add_filter('excerpt_length', 'jnews_excerpt_length');

                                                    while ( $posts->have_posts() ) :
                                                        $posts->the_post();
                                                        do_action('jnews_json_archive_push', get_the_ID());
                                                    ?>
                                                        <div id="post-<?php the_ID(); ?>" <?php post_class('jeg_post jeg_pl_md_2'); ?>>
                                                            <div class="jeg_thumb">
                                                                <?php echo jnews_edit_post( get_the_ID() ); ?>
                                                                <a href="<?php the_permalink(); ?>"><?php echo apply_filters('jnews_image_thumbnail', get_the_ID(), "jnews-350x250");?></a>
                                                            </div>
                                                            <div class="jeg_postblock_content">
                                                                <h2 class="jeg_post_title">
                                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                                </h2>
                                                                <div class="jeg_post_meta">
                                                                    <div class="jeg_meta_author"><?php jnews_print_translation('by', 'jnews-like', 'by'); ?> <?php jnews_the_author_link(); ?></div>
                                                                    <div class="jeg_meta_date"><a href="<?php the_permalink(); ?>"><i class="fa fa-clock-o"></i> <?php echo esc_html( get_the_date() ); ?></a></div>
                                                                    <div class="jeg_meta_comment"><a href="<?php echo jnews_get_respond_link() ?>"><i class="fa fa-comment-o"></i> <?php echo esc_html(jnews_get_comments_number()); ?></a></div>
                                                                </div>
                                                                <div class="jeg_post_excerpt">
                                                                    <?php the_excerpt(); ?>
                                                                    <a href="<?php the_permalink(); ?>" class="jeg_readmore"><?php jnews_print_translation('Read more','jnews-like', 'read_more'); ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    endwhile;

                                                    // pagination
                                                    echo jnews_paging_navigation(
                                                        array(
                                                            'pagination_mode'      => 'nav_1',
                                                            'pagination_align'     => 'center',
                                                            'pagination_navtext'   => false,
                                                            'pagination_pageinfo'  => false,
                                                            'total'                => $posts->max_num_pages
                                                        )
                                                    );

                                                    remove_filter('excerpt_more', 'jnews_excerpt_more');
                                                    remove_filter('excerpt_length', 'jnews_excerpt_length');

                                                } else {
                                                    $like->empty_content();
                                                }

                                                wp_reset_postdata();
                                            }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ( is_active_sidebar('default-sidebar') ) : ?>
                            <div class="jeg_sidebar jeg_sticky_sidebar jeg_column col-sm-4">
                                <?php
                                    do_action('jnews_module_set_width', 4);
                                    dynamic_sidebar( 'default-sidebar' );
                                ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <?php do_action('jnews_after_main'); ?>
    </div>
</div>

<?php get_footer(); ?>