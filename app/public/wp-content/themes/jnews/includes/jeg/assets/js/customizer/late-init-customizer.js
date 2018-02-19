( function($) {
    "use strict";

    wp.customize.Section = wp.customize.Section.extend({

        expand : function(params)
        {
            var section = this.container[1];

            if(!$(section).hasClass('jnews-section-loaded'))
            {
                $(section).addClass('jnews-section-loaded').trigger('jnews-open-section');
            }

            return this._toggleExpanded( true, params );
        }

    });

    wp.customize.Panel = wp.customize.Panel.extend({
        expand : function(params) {
            var panel = this.container[1];

            if(panel.id === 'sub-accordion-panel-jnews_header')
            {
                $('body').trigger('jnews-open-header-builder');
            }

            return this._toggleExpanded( true, params );
        }
    });

})( jQuery );
