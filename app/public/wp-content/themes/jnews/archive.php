<?php
    get_header();
    $archive = new \JNews\Archive\SingleArchive();
?>

<div class="jeg_main">
    <div class="jeg_container">
        <div class="jeg_content">
            <div class="jeg_section">
                <div class="container">

                    <div class="jeg_archive_header">
                        <?php if ( is_tag() && jnews_can_render_breadcrumb() ): ?>
                            <div class="jeg_breadcrumbs jeg_breadcrumb_container">
                                <?php echo jnews_sanitize_output( $archive->render_breadcrumb() ); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php the_archive_title( '<h1 class="jeg_archive_title">', '</h1>' ); ?>
                    </div>

                    <div class="jeg_cat_content row">

                        <div class="jeg_main_content jeg_column col-sm-<?php echo esc_attr($archive->get_content_width()); ?>">
                            <div class="jnews_archive_content_wrapper">
                                <?php echo jnews_sanitize_output( $archive->render_content() ); ?>
                            </div>

                            <?php echo jnews_sanitize_output( $archive->render_navigation() ); ?>
                        </div>

                        <?php if($archive->get_content_show_sidebar()) : ?>
                            <div class="jeg_sidebar <?php echo esc_attr( $archive->get_sticky_sidebar() ); ?> jeg_column col-sm-4">
                                <?php jnews_widget_area($archive->get_content_sidebar()); ?>
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