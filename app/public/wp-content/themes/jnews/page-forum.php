<?php
get_header();
the_post();
$sticky_sidebar = get_theme_mod('jnews_bbpress_sticky_sidebar', true) ? 'jeg_sticky_sidebar' : '';
?>

    <div class="jeg_main">
        <div class="jeg_container">
            <div class="jeg_content jeg_bbpress">

                <div class="container">
                    <div class="jeg_archive_header">
                        <h1 class="jeg_archive_title"><?php the_title(); ?></h1>
                    </div>

                    <div class="row">

                        <div class="jeg_main_content col-md-<?php echo esc_attr(get_theme_mod('jnews_bbpress_show_sidebar', true) ? 8 : 12); ?>">
                            <?php the_content(); ?>
                            <?php wp_link_pages(); ?>
                        </div>

                        <?php if(get_theme_mod('jnews_bbpress_show_sidebar', true)) : ?>
                        <div class="jeg_sidebar <?php echo esc_attr( $sticky_sidebar ); ?> col-md-4">
                            <?php jnews_widget_area( get_theme_mod('jnews_bbpress_sidebar', 'default-sidebar') ); ?>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <?php do_action('jnews_after_main'); ?>
        </div>
    </div>

<?php get_footer();