<div class="widget-wrapper type-alert" data-field="<?php echo esc_attr($fieldkey) ?>" <?php echo !empty( $dependency ) ? 'data-dependency="' . esc_attr( json_encode( $dependency ) ) . '"' : ''; ?>>
    <div class="widget-alert alert-<?php echo esc_attr($default); ?>">
        <strong><?php echo esc_html($title); ?></strong>
        <div class="alert-description"><?php echo esc_html($desc); ?></div>
    </div>
</div>