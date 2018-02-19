( function($) {
    "use strict";

    var api = wp.customize;
    var dialog_open = false;
    var dirty_lock = false;

    $(window).bind('load', function(){
        setTimeout(function(){
            dirty_lock = true;
        }, 1000);
    });

    var redirect_preview = function(url)
    {
        var customizerpreview = new wp.customize.Preview({
            url: url,
            channel: wp.customize.settings.channel
        });

        customizerpreview.send( 'scroll', 0 );
        customizerpreview.send( 'url', url );
    };

    var do_refresh_self = function(refresh, flag)
    {
        if( refresh && flag )
        {
            parent.wp.customize.previewer.refresh();
        }
    };

    var customizer_redirect = function(tag, refresh)
    {
        if(dirty_lock)
        {
            var redirect = jnews_redirect[tag];

            if( ! redirect.flag )
            {
                if(!dialog_open)
                {
                    dialog_open = true;
                    vex.dialog.confirm({
                        message: jnews_redirect.setting.change_notice,
                        showCloseButton : false,
                        callback: function(value)
                        {
                            if(value) {
                                redirect_preview(redirect.url);
                            } else {
                                dialog_open = false;
                                do_refresh_self(refresh, redirect.flag);
                            }
                        }
                    });
                }
            } else {
                do_refresh_self(refresh, redirect.flag);
            }
        }
    };

    _.each( postvar, function( jsVars, setting )
    {
        api( setting, function( value )
        {
            value.bind( function( newval )
            {
                if ( undefined !== jsVars && 0 < jsVars.length )
                {
                    _.each( jsVars, function( jsVar )
                    {
                        if (jsVar.redirect !== undefined)
                        {
                            customizer_redirect(jsVar.redirect, jsVar.refresh);
                        }
                    });
                }
            });
        });
    });

})( jQuery );
