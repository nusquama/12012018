<?php
    $single = JNews\Single\SinglePost::getInstance();
?>
<div class="jeg_sidebar <?php echo esc_attr( $single->get_sticky_sidebar() ); ?> col-md-4">
    <?php jnews_widget_area( $single->get_sidebar() ); ?>
</div>