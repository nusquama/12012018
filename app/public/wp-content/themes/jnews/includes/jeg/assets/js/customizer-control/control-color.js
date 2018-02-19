wp.customize.controlConstructor['jnews-color'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		'use strict';

		var control = this,
			section = jQuery(this.container).parents('.control-section').first();

		jQuery( section ).bind('jnews-open-section', function()
		{
			var picker  = control.container.find( '.jnews-color-control');

			// color picker initialize
			jQuery( picker ).wpColorPicker();

			// If we have defined any extra choices, make sure they are passed-on to Iris.
			if ( undefined !== control.params.choices ) {
				picker.wpColorPicker( control.params.choices );
			}

			var clear_button = jQuery(picker).siblings('.wp-picker-clear');

			clear_button.on('click', function(){
				setTimeout( function() {
					control.setting.set( picker.val() );
				}, 100 );
			});

			// Saves our settings to the WP API
			picker.wpColorPicker({
				change: function( event, ui ) {

					// Small hack: the picker needs a small delay
					setTimeout( function() {
						control.setting.set( picker.val() );
					}, 100 );

				}
			});
		});
	}
});
