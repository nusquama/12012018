<?php
get_header();
the_post();
?>

    <div class="jeg_main">
        <div class="jeg_container">
            <div class="jeg_content jeg_singlepage">

                <?php
                    $show_sidebar   = get_theme_mod('jnews_attachment_show_sidebar', true);
                    $sticky_sidebar = get_theme_mod('jnews_attachment_sticky_sidebar', true) ? 'jeg_sticky_sidebar' : '';
                    $sidebar        = get_theme_mod('jnews_attachment_sidebar', 'default-sidebar');
                    $sidebar_width  = $show_sidebar ? 8 : 12;
                ?>
                <div class="container">

                    <?php if(jnews_can_render_breadcrumb()) : ?>
                    <div class="jeg_breadcrumbs jeg_breadcrumb_container">
                        <?php echo jnews_render_breadcrumb(); ?>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="jeg_main_content jeg_column col-sm-<?php echo esc_attr($sidebar_width); ?>">
                            <div class="entry-header">
                                <h1 class="jeg_post_title"><?php the_title(); ?></h1>
                            </div>
                            <div class="jeg_featured featured_image">
                                <?php
                                    if ( wp_attachment_is_image( get_the_ID() ) ) {
                                        $image_size = $show_sidebar ? 'jnews-featured-750' : 'jnews-featured-1140';
                                        echo apply_filters('jnews_single_image_unwrap', get_the_ID(), $image_size);
                                    }
                                ?>
                            </div>
                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <?php if($show_sidebar) : ?>
                        <div class="jeg_sidebar <?php echo esc_attr( $sticky_sidebar ); ?> jeg_column col-sm-4">
                            <?php jnews_widget_area( $sidebar ); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php do_action('jnews_after_main'); ?>
        </div>
    </div>

<?php get_footer(); ?>