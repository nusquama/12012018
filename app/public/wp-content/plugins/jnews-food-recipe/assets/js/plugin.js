(function($){
	
	"use strict";

	function do_print()
	{	
		$('.jeg_food_recipe_print').each(function()
		{
			var element = $(this);

			element.unbind('click').on('click', function(e)
			{
				e.preventDefault();

				$(this).parents('#jeg_food_recipe').printThis();
			});

		});
	}

	function do_active_list()
	{
		$('.jeg_food_recipe_ingredient').each(function()
		{
			var element = $(this);

			element.find('ul > li').unbind('click').on('click', function()
			{
				if ( $(this).hasClass('active') ) 
				{
					$(this).removeClass('active');
				} else {
					$(this).addClass('active');
				}
			});
		});
	}

	function dispatch()
	{
		do_print();
		do_active_list();
	}

	$(document).bind('ready jnews_after_split_content_ajax jnews-ajax-load', function(e, data)
	{
		dispatch();
	});

})(jQuery);