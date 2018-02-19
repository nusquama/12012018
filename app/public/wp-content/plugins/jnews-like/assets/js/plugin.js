(function($){
	
	'use strict';

	window.jnews.like = window.jnews.like || {};

	window.jnews.like = 
	{
		init: function($container)
        {
            var base = this;

            if ( $container === undefined )
            {
                base.container = $('body');
            } else {
                base.container = $container;
            }

            base.container.find('.jeg_meta_like > a').unbind('click').bind('click', function(e)
            {
                e.preventDefault();

                if ( $(this).hasClass('clicked') ) return;

                base.element = $(this);
                base.parent  = base.element.parent();
                base.like    = base.parent.find('.like');
                base.dislike = base.parent.find('.dislike');

                base.ajax_request();
            });
        },

        ajax_request: function()
        {
            var base = this;

            base.parent.addClass('clicked').find('.fa').addClass('fa-pulse');

            $.ajax({
                url : jnews_ajax_url,
                type: 'post',
                dataType: "json",
                data: {
                    'post_id' : base.element.attr('data-id'),
                    'type'    : base.element.attr('data-type'),
                    'action'  : 'like_handler'
                },
            }).done(function(data) 
            {
                if ( data.response === -1 ) 
                {
                    $('#jeg_loginform form').find('h3').html(data.message);
                    $('.jeg_popuplink').trigger('click');           
                } else 
                {
                    if ( data.value === 1 ) 
                    {
                        base.like.html("<i class='fa fa-thumbs-up'></i> <span>" + data.like + "</span>");
                        base.dislike.html("<i class='fa fa-thumbs-o-down fa-flip-horizontal'></i> <span>" + data.dislike + "</span>");
                    }

                    if ( data.value === -1 ) 
                    {
                        base.like.html("<i class='fa fa-thumbs-o-up'></i> <span>" + data.like + "</span>");
                        base.dislike.html("<i class='fa fa-thumbs-down fa-flip-horizontal'></i> <span>" + data.dislike + "</span>");
                    }

                    if ( data.value === 0 ) 
                    {
                        base.like.html("<i class='fa fa-thumbs-o-up'></i> <span>" + data.like + "</span>");
                        base.dislike.html("<i class='fa fa-thumbs-o-down fa-flip-horizontal'></i> <span>" + data.dislike + "</span>");
                    }
                }
            }).fail(function(data, textStatus, errorThrown) 
            {
                if(textStatus === 'error')
                {
                    alert(errorThrown.toString());
                } else if (textStatus === 'timeout')
                {
                    alert('Execution Timeout');
                }
            }).always(function(data, textStatus, errorThrown) 
            {
                base.element.attr('data-message', data.message);
                base.parent.removeClass('clicked').find('.fa').removeClass('fa-pulse');;
            });
        }
	};

    $(document).bind('ready jnews-ajax-load', function(e, data)
    {
        jnews.like.init();
    });

})(jQuery);