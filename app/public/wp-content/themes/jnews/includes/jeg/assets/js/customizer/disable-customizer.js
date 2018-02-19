( function( api, $ ) {

    function show_disable_panel()
    {
        if($('.jnews-customizer-disable').length === 0)
        {
            var panel = "";

            for(var i = 0; i < disablecustomizer['panel'].length; i++) {
                var checked = disablecustomizer['panel'][i]['disabled'] ? 'checked' : '';
                panel +=
                    "<div class='jnews-customizer-checkbox'>" +
                        "<input " + checked + " type='checkbox' id='" + disablecustomizer['panel'][i]['id'] + "' name='" + disablecustomizer['panel'][i]['id'] + "'>" +
                        "<label for='" + disablecustomizer['panel'][i]['id'] + "'>" + disablecustomizer['panel'][i]['title'] + "</label>" +
                    "</div>";
            }


            var html =
                "<div class='jnews-customizer-disable'>" +
                    "<div class='jnews-customizer-overlay'></div>" +
                    "<div class='jnews-customizer-disable-content'>" +
                        "<h2 class='jnews-customizer-disable-header'>" + disablecustomizer.header + "</h2>" +
                        "<form>" +
                            "<div class='jnews-customizer-container'>" + panel + "</div>" +
                            "<div class='jnews-customizer-button-wrapper'>" +
                                "<input type='submit' class='jnews-customizer-button jnews-customizer-ok' value='" + disablecustomizer.button + "'/>" +
                                "<input type='button' class='jnews-customizer-button jnews-customizer-cancel' value='" + disablecustomizer.cancel + "'/>" +
                            "</div>" +
                        "</form>" +
                        "<div class='jnews-customizer-content-overlay'><i class='fa fa-cog fa-spin fa-3x fa-fw'></i></div>" +
                    "</div>" +
                "</div>";

            $('body').append(html);
            $(".jnews-customizer-disable").fadeIn();

            // Hook Event
            $(".jnews-customizer-cancel").bind('click', function(){
                $(".jnews-customizer-disable").fadeOut('fast');
            });

            $(".jnews-customizer-ok").bind('click', function(e){
                e.preventDefault();

                $(".jnews-customizer-content-overlay").show();

                $.ajax({
                    url : ajaxurl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'form' : $(".jnews-customizer-disable").find('form').serializeArray(),
                        'action'  : 'jnews_customizer_disable_panel'
                    },
                    success: function(result) {
                        location.reload();
                    }
                });
            });
        } else {
            $(".jnews-customizer-disable").fadeIn('fast');
        }
    }

    wp.customize.bind( 'ready', function ()
    {
        var panel = $("#accordion-panel-jnews_disable_panel").find('> h3');
        $(panel).unbind('click').bind('click', function(e){
            e.preventDefault();
            show_disable_panel();
        });

    });

} )( wp.customize, jQuery );