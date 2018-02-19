<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_head', $head_info); ?>

<div class='vp-multitermhierarchy-wrapper'>
	<?php
        $data = array();
       
        foreach( $items as $item ) {
            $data[] = array(
                'value' => $item->value,
                'text'  => is_array($item->label) ? $item->label[0] : $item->label,
                'class' => is_array($item->label) ? 'indent_' . $item->label[1] : 'indent_0',
            );
        }
            
        $data = json_encode($data);
    ?>
	<input type="text" name="<?php echo esc_attr($name); ?>" class="vp-input input-large input-sortable widefat code" value="<?php echo esc_attr($value); ?>" />
		
	<div class="data-option" style="display: none;">
        <?php echo esc_html($data); ?>
    </div>
</div>

<?php if(!$is_compact) echo VP_View::instance()->load('control/template_control_foot', $head_info); ?>