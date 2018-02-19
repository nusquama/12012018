(function($){
	
	'use strict';

	window.jnews.push_notification = window.jnews.push_notification || {};

	window.jnews.push_notification = 
	{
		init: function( $container )
        {
        	var base = this;

            if ( $container === undefined )
            {
                base.element = $('body');
            } else {
            	base.element = $container;
            }

            setTimeout(function() 
            {
                $(window).bind('load', base.doSubscribe());
            }, 500);
        },

        doSubscribe: function()
        {
        	var base = this;

        	if ( base.element.find('.jeg_push_notification').length ) 
            {
            	base.element.find('.jeg_push_notification').each(function()
            	{
            		base.container = $(this);
            		base.doSubscribeAction(base.container);
            		base.doSubscribeSubmit(base.container);
            	});
            }
        },

        doSubscribeAction: function(content)
        {
        	var base = this;

            base.doSubscribeToggle(content, 'register');

        	OneSignal.getUserId(function(userId)
			{
				if ( userId !== null ) 
				{
					OneSignal.getTags(function(tags) 
					{
					    if ( Object.keys(tags).length > 0 ) 
					    {
					    	base.doSubscribeToggle(content, 'unsubscribe');

					    	if ( content.find('.button').attr('data-type') === 'category' ) 
					    	{
					    		var category = content.find('input[name="post-category"]').val(),
					    			arr		 = category.split(',');

					    		for ( var i = 0; i < arr.length; i++ ) 
								{
									if ( !tags.hasOwnProperty(arr[i]) ) 
									{
										base.doSubscribeToggle(content, 'subscribe');
									}
								}
					    	}
						} else {
							if ( content.find('.button').attr('data-type') === 'category' ) 
					    	{
					    		base.doSubscribeToggle(content, 'subscribe');
					    	}
						}
					});
				}

				content.removeClass('loading');
			});
        },

        doSubscribeSubmit: function(content)
        {
        	var base = this;

        	content.find('.button').bind('click', function(event)
        	{
        		event.preventDefault();

        		content.addClass('processing');

        		var button 	= $(this),
        			type 	= button.attr('data-type'),
        			action 	= button.attr('data-action');

        		if ( type === 'general' ) 
        		{
        			if ( action === 'register' ) 
        			{

        				OneSignal.push(["registerForPushNotifications"]);
						OneSignal.on('subscriptionChange', function (isSubscribed) 
						{
							OneSignal.sendTag('all', 'all');
        					base.doSubscribeToggle(content, 'unsubscribe');
						});

        			} else if ( action === 'subscribe' ) {

        				OneSignal.sendTag('all', 'all');
        				base.doSubscribeToggle(content, 'unsubscribe');

        			} else if ( action === 'unsubscribe' ) {

        				OneSignal.getTags(function(tags) 
						{
							var keys = [];
							for(var k in tags) keys.push(k);

							OneSignal.deleteTags(keys);
							base.doSubscribeToggle(content, 'subscribe');
						});

        			}
        		}

        		if ( type === 'category' ) 
        		{
        			var category = content.find('input[name="post-category"]').val(),
						arr		 = category.split(','),
					    obj		 = {};

					for ( var i = 0; i < arr.length; i++ ) 
					{
						obj[arr[i]] = arr[i];
					}

        			if ( action === 'register' ) 
        			{

        				OneSignal.push(["registerForPushNotifications"]);
						OneSignal.on('subscriptionChange', function (isSubscribed) 
						{
							OneSignal.deleteTags(['all']);
							OneSignal.sendTags(obj);
        					base.doSubscribeToggle(content, 'unsubscribe');
						});

        			} else if ( action === 'subscribe' ) {

						OneSignal.deleteTags(['all']);
						OneSignal.sendTags(obj);
						base.doSubscribeToggle(content, 'unsubscribe');

        			} else if ( action === 'unsubscribe' ) {

        				OneSignal.deleteTags(arr);
        				base.doSubscribeToggle(content, 'subscribe');

        			}
        		}

        		setTimeout(function() 
        		{
        			content.removeClass('processing');
        		}, 600);
        	});
        },

        doSubscribeToggle: function(content, action)
        {
        	var button			= content.find('.button'),
                processingText  = content.find('input[name="button-processing"]').val(),
        		subscribeText   = content.find('input[name="button-subscribe"]').val(),
        		unsubscribeText = content.find('input[name="button-unsubscribe"]').val();

        	if ( action === 'subscribe' ) 
			{
                button.html( '<i class="fa fa-refresh fa-spin"></i>' + processingText );

                setTimeout(function() 
                {
                    button.attr('data-action', 'subscribe');
                    button.html( '<i class="fa fa-bell-o"></i>' + subscribeText );
                }, 500);
			} else if ( action === 'register' ) {
                button.html( '<i class="fa fa-refresh fa-spin"></i>' + processingText );

                setTimeout(function() 
                {
                    button.attr('data-action', 'register');
                    button.html( '<i class="fa fa-bell-o"></i>' + subscribeText );
                }, 500);
            } else {

                button.html( '<i class="fa fa-refresh fa-spin"></i>' + processingText );

                setTimeout(function() 
                {
                    button.attr('data-action', 'unsubscribe');
                    button.html( '<i class="fa fa-bell-slash-o"></i>' + unsubscribeText );
                }, 500);
			}
        }
	};

	$(document).ready(function()
	{
		jnews.push_notification.init();
	});

})(jQuery);