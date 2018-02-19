</div>

<?php if(jnews_can_render_woo_widget() && is_active_sidebar(jnews_get_woo_widget()) ) : ?>
<div id="wc-sidebar" class="jeg_sidebar <?php echo esc_attr( jnews_get_woo_sticky_sidebar() ); ?> col-md-4">
    <div class="wc-sidebar-wrapper">
        <?php dynamic_sidebar(jnews_get_woo_widget()); ?>
    </div>
</div>
<?php endif; ?>