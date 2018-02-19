<?php
    get_header();
    $search = new \JNews\Archive\SearchArchive();
?>

<div class="jeg_main">
    <div class="jeg_container">
        <div class="jeg_content">

            <div class="jeg_section">
                <div class="container">
                    <div class="jeg_cat_content row">

                        <div class="jeg_main_content jeg_column col-sm-<?php echo esc_attr($search->get_content_width()); ?>">

                            <div class="jeg_archive_header">

                                <?php if(jnews_can_render_breadcrumb()) : ?>
                                <div class="jeg_breadcrumbs jeg_breadcrumb_container">
                                    <?php echo jnews_sanitize_output($search->render_breadcrumb()); ?>
                                </div>
                                <?php endif; ?>

                                <h1 class="jeg_archive_title"><?php printf(jnews_return_translation('Search Result for \'%s\'', 'jnews', 'search_result_for_s'), get_search_query()); ?></h1>

                                <div class="jeg_archive_search">
                                    <?php get_search_form(true); ?>
                                </div>
                            </div>
                            <!-- search end -->

                            <div class="jnews_search_content_wrapper">
                                <?php echo jnews_sanitize_output($search->render_content()); ?>
                            </div>

                            <?php echo jnews_sanitize_output($search->render_navigation()); ?>
                        </div>

                        <?php if($search->get_content_show_sidebar()) : ?>
                            <div class="jeg_sidebar <?php echo esc_attr( $search->get_sticky_sidebar() ); ?> jeg_column col-sm-4">
                                <?php jnews_widget_area( $search->get_content_sidebar() ); ?>
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