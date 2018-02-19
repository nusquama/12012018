jQuery(function($){

    var hasSelectiveRefresh;
    var jnews = window.jnews;
    
    hasSelectiveRefresh = (
        'undefined' !== typeof wp &&
        wp.customize &&
        wp.customize.selectiveRefresh &&
        wp.customize.widgetsPreview &&
        wp.customize.widgetsPreview.WidgetPartial
    );

    function begin_with (needle, haystack){
        return (haystack.substr(0, needle.length) == needle);
    }

    if ( hasSelectiveRefresh ) {

        wp.customize.selectiveRefresh.bind( 'partial-content-moved', function( placement ) {
            "use strict";
            var parent = $(placement.container).parents('.jeg_sticky_sidebar');

            if(parent)
            {
                var sticky = $(parent).find('.theiaStickySidebar').html();
                if(sticky === '') {
                    $(parent).find('.theiaStickySidebar').remove();
                    $(parent).css('style', '').theiaStickySidebar({ additionalMarginTop: 20 });
                }
            }
        });

        wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
            "use strict";

            var refresh_id = placement.partial.id;

            if($(placement.container).hasClass('jeg_menu'))
            {
                jnews.menu.init($(placement.container).parent());
            }

            if($(placement.container).hasClass('jeg_mobile_menu'))
            {
                $(placement.container).superfish();
            }

            if (refresh_id.substring(0, 6) == "widget")
            {
                // check if element is valid
                var parent = $(placement.container).parent();

                if($(parent).hasClass('jeg_sticky_sidebar'))
                {
                    var theia = $(parent).find('.theiaStickySidebar');
                    $(placement.container).appendTo(theia);
                }
            }

            if($(placement.container).hasClass('widget'))
            {
                var element = $(placement.container);

                // widget tab
                $(element).find('.jeg_tabpost_widget').jtabs();

                // hook module
                $(element).find('.jeg_module_hook').jmodule();

                // hero module
                jnews.hero.init(element);

                // news ticker
                $(element).find(".jeg_news_ticker").jnewsticker();

                // carousel
                $(element).jnews_carousel();

                // block link
                $(element).find(".jeg_blocklink .jeg_videobg").jvideo_background();

                // slider
                $(element).jnews_slider();

                // video playlist
                $(element).find(".jeg_video_playlist").addClass('jeg_col_4').jvidplaylist();
            }

            if(refresh_id === 'jnews_header_style')
            {
                jnews.menu.init(placement.container);
                jnews.cart.init(placement.container);
                jnews.fragment.build_top_account();
                jnews.menu.sticky_menu(placement.container);
                if('undefined' !== typeof jnews.weather) jnews.weather.init();
            }


            if( refresh_id === 'jnews_header_topbar_show'           || refresh_id === 'jnews_header_topbar_social_position' || refresh_id === 'jnews_header_topbar_menu_position' ||
                refresh_id === 'jnews_header_topbar_date_position'  || refresh_id === 'jnews_header_topbar_cart_show'       || refresh_id === 'jnews_header_topbar_search_show' ||
                refresh_id === 'jnews_header_topbar_search_type'    || refresh_id === 'jnews_header_topbar_account_show'    || begin_with( 'jnews_hb', refresh_id ) )
            {
                    jnews.menu.init(placement.container);
                    jnews.cart.init(placement.container);
                    jnews.mobile.init();
                    if('undefined' !== typeof jnews.weather) jnews.weather.init();

                    window.jfla = ['desktop_login', 'mobile_login', 'login_form'];
                    jnews.first_load.init();
            }

            if( refresh_id === 'jnews_header_menu_show_search' || refresh_id === 'jnews_header_menu_cart_show' || refresh_id === 'jnews_header_menu_follow') {
                jnews.menu.init(placement.container);
                jnews.cart.init(placement.container);
                jnews.menu.sticky_menu(placement.container);
            }

            if( refresh_id === 'jnews_mobile_show_search' || refresh_id === 'jnews_mobile_menu_follow' ) {
                jnews.mobile.init();
            }

            if(
                   refresh_id === 'jnews_single_social_share_view_percentage_top'
                || refresh_id === 'jnews_single_social_share_view_percentage_bottom'
                || refresh_id === 'jnews_single_view_initial_value'
                || refresh_id === 'jnews_single_social_share_main_top'
                || refresh_id === 'jnews_single_social_share_main_float'
                || refresh_id === 'jnews_single_social_share_main_bottom'
                || refresh_id === 'jnews_single_social_share_secondary_top'
                || refresh_id === 'jnews_single_social_share_secondary_float'
                || refresh_id === 'jnews_single_social_share_secondary_bottom'
                || refresh_id === 'jnews_single_social_share_threshold'
                || refresh_id === 'jnews_single_share_position_top'
                || refresh_id === 'jnews_single_share_position_float'
                || refresh_id === 'jnews_single_share_position_bottom'
                || refresh_id === 'jnews_single_show_share_counter'
                || refresh_id === 'jnews_single_show_view_counter'
                || refresh_id === 'jnews_single_view_initial_value_top'
                || refresh_id === 'jnews_single_view_initial_value_bottom' )
            {
                jnews.share.init(placement.container);
            }

            if ( refresh_id === 'jnews_option[single_show_like]' || refresh_id === 'jnews_option[single_like_view_percentage]' ) {
                jnews.like.init();
            }

            if(refresh_id.indexOf('jnews_category_hero') > -1 || refresh_id.indexOf('jnews_author_hero') > -1) {
                jnews.hero.dispatch();
            }

            if(refresh_id.indexOf('jnews_category_content') > -1) {
                $(placement.container).find(".jeg_module_hook").jmodule();
            }

            if(refresh_id === 'jnews_single_show_post_related' ||
                refresh_id === 'jnews_single_show_post_related' || refresh_id === 'jnews_single_post_related_match' || refresh_id === 'jnews_single_post_pagination_related' ||
                refresh_id === 'jnews_single_number_post_related' || refresh_id === 'jnews_single_post_auto_load_related' || refresh_id === 'jnews_single_post_related_template' ||
                refresh_id === 'jnews_single_post_related_excerpt' || refresh_id === 'jnews_single_post_related_date' || refresh_id === 'jnews_single_post_related_date_custom') {
                $(placement.container).find(".jeg_module_hook").jmodule();
            }

            if( refresh_id === 'jnews_comment_type' || refresh_id === 'jnews_comment_disqus_shortname' || refresh_id === 'jnews_comment_facebook_appid' ) {
                jnews.comment.init();
            }

            if( refresh_id === 'jnews_single_show_popup_post' || refresh_id === 'jnews_single_number_popup_post' ) 
            {
                jnews.popuppost.init();
            }

            if (
                   refresh_id === 'jnews_option[top_bar_weather_position]' 
                || refresh_id === 'jnews_option[top_bar_weather_location]'
                || refresh_id === 'jnews_option[top_bar_weather_item]'
                || refresh_id === 'jnews_option[top_bar_weather_item_count]'
                || refresh_id === 'jnews_option[top_bar_weather_item_content]'
                || refresh_id === 'jnews_option[top_bar_weather_item_autoplay]'
                || refresh_id === 'jnews_option[top_bar_weather_item_autodelay]'
                || refresh_id === 'jnews_option[top_bar_weather_item_autohover]'
                || refresh_id === 'jnews_option[top_bar_weather_location_auto]'
                || refresh_id === 'jnews_option[weather_default_temperature]' ) 
            {
                if('undefined' !== typeof jnews.weather) jnews.weather.init();
            }

            if ( 
                   refresh_id === 'jnews_option[push_notification_post_enable]' 
                || refresh_id === 'jnews_option[push_notification_post_description]'
                || refresh_id === 'jnews_option[push_notification_post_btn_subscribe]'
                || refresh_id === 'jnews_option[push_notification_post_btn_unsubscribe]'
                || refresh_id === 'jnews_option[push_notification_post_btn_processing]'
                || refresh_id === 'jnews_option[push_notification_category_enable]'
                || refresh_id === 'jnews_option[push_notification_category_description]'
                || refresh_id === 'jnews_option[push_notification_category_btn_subscribe]'
                || refresh_id === 'jnews_option[push_notification_category_btn_unsubscribe]'
                || refresh_id === 'jnews_option[push_notification_category_btn_processing]' ) 
            {
                jnews.push_notification.init();
            }
        });
    }
});