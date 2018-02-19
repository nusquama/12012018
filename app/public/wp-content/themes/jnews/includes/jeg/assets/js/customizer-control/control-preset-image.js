wp.customize.controlConstructor['jnews-preset-image'] = wp.customize.Control.extend({

    ready: function() {

        'use strict';

        var $select,
            selectize,
            value,
            container;

        // Change the value
        var setting = jQuery(this.container).find('.image').data('link');

        jQuery(this.container).find('label').bind('click', function(){
            value = jQuery(this).data('id');

            // find the container
            container = jQuery( wp.customize.control( setting ).container.find( 'select' ) );

            // Need to change content of selectize dropdown
            $select = container.selectize();
            selectize = $select[0].selectize;
            selectize.setValue( value, true );

            // Update the value in the customizer object
            wp.customize.instance( setting ).set( value );

            // now trigger change
            jQuery(container).change();
        });
    }

});
