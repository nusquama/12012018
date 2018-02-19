( function($) {
    "use strict";

    var api = wp.customize;

    /**
     * Search
     */
    $(window).bind('load', function()
    {
        var build_element = function($header, $control)
        {
            $header.append(
                "<div class='customizer-search-wrapper'>" +
                    "<a href='#' class='customizer-search-toggle'>" +
                        "<i class='fa fa-search'></i>" +
                    "</a>" +
                    "<form class='customizer-form-search'>" +
                        "<input type='text' name='customizer-form-input'/>" +
                    "</form>" +
                "</div>" +
                "<div class='customizer-search-result'>" +
                    "<ul>" +
                    "</ul>" +
                "</div>"
            );

            $control.append("<div class='customizer-search-overlay'></div>");
        };

        var search_string = function(query)
        {
            query = query.trim();

            if(query.length >= 3)
            {
                var querywords = query.split(',');
                var results = new Array();

                for(var i = 0; i < querywords.length; i++)
                {
                    var regex = new RegExp( '(?=.*' + querywords[i].split(' ').join(')(?=.*') + ')', 'i' );

                    for ( var j = 0; j < searchcustomizer.length; j++ )
                    {
                        if ( regex.test( searchcustomizer[j].search) )
                        {
                            results.push( searchcustomizer[j] );
                        }
                    }
                }

                var resultstring = '';

                for(var k = 0; k < results.length; k++)
                {
                    resultstring = resultstring + "<li data-control='" + results[k]['id'] + "'><span>" + results[k]['path'] + "</span><h3>" + results[k]['title'] + "</h3><em>" + results[k]['description'] + "</em></li>";
                }
            }

            return resultstring;
        };

        var hook_input = function($searchinput, $searchresult)
        {
            var timeout = null;
            $searchinput.on('input', function(e)
            {
                var value = $(this).val();
                clearTimeout(timeout);
                timeout = setTimeout(function()
                {
                    var result = search_string(value);
                    $searchresult.find('ul').html(result);
                }, 500);
            });
        };

        var move_to_control = function(settingId)
        {
            api.control(settingId).focus();
        };

        var resize_search_result = function($searchresult, $control)
        {
            var resize_search_container = function(){
                var wh = $control.height();
                $searchresult.height(wh - 90);
            };

            resize_search_container();
            $(window).bind('resize', resize_search_container);
        };

        var dispatch = function()
        {
            var showsearch = false;
            var $header = $("#customize-header-actions");
            var $control = $("#customize-controls");

            build_element($header, $control);

            var $searchinput = $header.find("input[type='text']");
            var $searchwrapper = $header.find('.customizer-search-wrapper');
            var $togglebutton = $header.find('.customizer-search-toggle');
            var $toggleicon = $header.find('.customizer-search-toggle i');
            var $searchresult = $header.find('.customizer-search-result');
            var $overlay = $control.find('.customizer-search-overlay');

            resize_search_result($searchresult, $control);

            var open_search = function()
            {
                $toggleicon.removeClass('fa-search').addClass('fa-times');
                $searchwrapper.addClass('active');
                $searchresult.addClass('active');
                $overlay.addClass('active');
                $searchinput.focus();
                showsearch = true;
            };

            var close_search = function()
            {
                $toggleicon.removeClass('fa-times').addClass('fa-search');
                $searchwrapper.removeClass('active');
                $searchresult.removeClass('active');
                $overlay.removeClass('active');
                showsearch = false;
            };

            $togglebutton.bind('click', function(e)
            {
                e.preventDefault();

                if(!showsearch) {
                    open_search();
                } else {
                    close_search();
                }
            });

            hook_input($searchinput, $searchresult);

            $searchresult.on('click', 'li', function()
            {
                close_search();
                var settingId = $(this).data('control');
                setTimeout(function(){
                    move_to_control(settingId);
                }, 500);

            });
        };

        dispatch();
    });


    /**
     * Accordion Header
     */
    $(document).bind('ready', function()
    {
        $(".customize-control-jnews-header").bind('click', function(){

            var collapsedClass = 'customizer-collapsed';
            var flag = true;

            var recursive_control = function(element, flag)
            {
                var $next = $(element).next();

                if( $next.length === 0 ) return;

                if(!$next.hasClass('customize-control-jnews-header'))
                {
                    if(flag) {
                        $next.addClass(collapsedClass);
                    } else {
                        $next.removeClass(collapsedClass);
                    }

                    recursive_control($next, flag)
                }
            };

            if($(this).hasClass('collapsed'))
            {
                $(this).removeClass('collapsed');
                flag = false;
            } else {
                $(this).addClass('collapsed');
                flag = true;
            }

            recursive_control(this, flag);

        });
    });


    /**
     * Drag & Drop Customizer

    $(document).bind('ready', function()
    {
        var wh = $(window).height(),
            hh = $("#customize-header-actions").height(),
            fh = $("#customize-footer-actions").height();
        var top    = 50,
            left   = 100,
            height = 500;

        var $customizewrapper = $(".wp-full-overlay");
        var $control = $("#customize-controls");
        var $header  = $("#customize-header-actions");

        $header.append("<div class='jeg-btn-attach'><i class='fa fa-arrows-alt'></i></div>");

        $(".jeg-btn-attach").bind('click', function()
        {
            if ( !$customizewrapper.hasClass("attached") )
            {
                start_attach();
                $(this).find("i").removeClass("fa-arrows-alt").addClass("fa-compress");
            } else {
                end_attach();
                $(this).find("i").removeClass("fa-compress").addClass("fa-arrows-alt");
            }
        });

        var start_attach = function()
        {
            $customizewrapper.addClass("attached");
            set_position(top, left);
            set_height($control, height);
            set_height($('.open > ul:first'), height - (fh+hh));
            set_height($(".customizer-search-result"), height - 90);

            $control.draggable({
                handle : '#customize-header-actions',
                disabled: false,
                cursor: "-webkit-grab",
                containment: "body",
                stop: function( event, ui )
                {
                    top  = parseInt($control.css("top"), 10);
                    left = parseInt($control.css("left"), 10);
                },
            });

            $control.resizable({
                maxHeight: wh-50,
                minHeight: 250,
                stop: function( event, ui )
                {
                    setTimeout( function()
                    {
                        height = $control.height();
                        set_height($(".customizer-search-result"), height - 90);
                        set_height($('.open > ul:first'), $("#customize-controls").height() - (fh+hh));
                    }, 200);
                }
            });
        };

        var end_attach = function()
        {
            $customizewrapper.removeClass("attached");
            set_position(0, 0);
            set_height($control, wh);
            set_height($('.open > ul:first'), wh - (fh+hh));
            set_height($(".customizer-search-result"), wh - 90);
            
            $control.draggable({
                disabled: true
            });

            $control.resizable( "destroy" );
        };

        var set_position = function(top, left)
        {
            $control.css({
                "top"  : top + "px",
                "left" : left + "px",
            });
        };

        var set_height = function($el, numb)
        {
            $el.css({
                "height" : numb + "px",
            });
        };
    });
     */
})( jQuery );