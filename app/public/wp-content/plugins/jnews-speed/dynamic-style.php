<?php
	$body_color = get_theme_mod( 'jnews_body_color', '#53585c' );
	$accent_color = get_theme_mod( 'jnews_accent_color', '#f70d28' );
	$alt_color = get_theme_mod( 'jnews_alt_color', '#f70d28' );
	$heading_color = get_theme_mod( 'jnews_heading_color', '#212121' );
?>

/* Body */
body, .newsfeed_carousel.owl-carousel .owl-nav div, .jeg_filter_button, .owl-carousel .owl-nav div, .jeg_readmore, .jeg_hero_style_7 .jeg_post_meta a, .widget_calendar thead th, .widget_calendar tfoot a, .jeg_socialcounter a, .entry-header .jeg_meta_like a, .entry-header .jeg_meta_comment a, .entry-content th, #breadcrumbs a, .jeg_cartcontent, .woocommerce .woocommerce-breadcrumb a {
	color: <?php echo esc_attr($body_color) ?>;
}

/* Accent */
a, .jeg_side_tabs li.active, .jeg_block_heading_5 strong, .jeg_block_heading_6 strong, .jeg_block_heading_7 strong, .jeg_pl_lg_7 .jeg_thumb .jeg_post_category a, .jeg_pl_xs_2:before, .jeg_pl_xs_4 .jeg_postblock_content:before, .jeg_meta_author a, .widget_rss cite, .widget_categories li.current-cat > a, .jeg_share_count .counts, .commentlist .bypostauthor > .comment-body > .comment-author > .fn, span.required, .jeg_review_title, .bestprice .price, .jeg_vertical_playlist .jeg_video_playlist_play_icon, .jeg_vertical_playlist .jeg_video_playlist_item.active .jeg_video_playlist_thumbnail:before, .jeg_horizontal_playlist .jeg_video_playlist_play, .woocommerce li.product .pricegroup .button, .widget_display_topics li:before, .widget_display_replies li:before, .widget_display_views li:before {
	color: <?php echo esc_attr($accent_color) ?>;
}

.jeg_menu_style_1 > li > a:before, .jeg_menu_style_2 > li > a:before, .jeg_menu_style_3 > li > a:before, .jeg_side_toggle, .jeg_slide_caption .jeg_post_category a, .jeg_slider_type_1 .owl-nav .owl-next, .jeg_block_heading_1 .jeg_block_title span, .jeg_block_heading_2 .jeg_block_title span, .jeg_block_heading_3, .jeg_block_heading_4 .jeg_block_title span, .jeg_block_heading_6:after, .jeg_pl_lg_box .jeg_post_category a, .jeg_pl_md_box .jeg_post_category a, .jeg_thumb .jeg_post_category a, .jeg_postblock_carousel_2 .jeg_post_category a, .jeg_heroblock .jeg_post_category a, .jeg_pagenav_1 .page_number.active, input[type="submit"], .btn, .button, .jeg_splitpost_4 .page_nav, .jeg_splitpost_5 .page_nav, .comment-reply-title small a:before, .comment-reply-title small a:after, .jeg_storelist .productlink, .authorlink li.active a:before, .jeg_breakingnews_title, .jeg_overlay_slider_bottom.owl-carousel .owl-nav div, .jeg_vertical_playlist .jeg_video_playlist_current, .woocommerce span.onsale, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .jeg_popup_post .caption {
	background-color: <?php echo esc_attr($accent_color) ?>;
}

.jeg_block_heading_7 .jeg_block_title span, .jeg_pagenav_1 .page_number.active, .jeg_overlay_slider .jeg_post_category, .jeg_sidefeed .jeg_post.active, .jeg_vertical_playlist.jeg_vertical_playlist .jeg_video_playlist_item.active .jeg_video_playlist_thumbnail img, .jeg_horizontal_playlist .jeg_video_playlist_item.active {
	border-color: <?php echo esc_attr($accent_color) ?>;
}

.jeg_tabpost_nav li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active {
	border-bottom-color: <?php echo esc_attr($accent_color) ?>;
}

/* Alt */
.jeg_post_meta .fa, .entry-header .jeg_post_meta .fa, .jeg_review_stars, .jeg_price_review_list {
	color: <?php echo esc_attr($alt_color) ?>;
}

.jeg_share_button.share-float.share-monocrhome a {
	background-color: <?php echo esc_attr($alt_color) ?>;
}

/* Heading */
h1,h2,h3,h4,h5,h6,.jeg_post_title a,.entry-header .jeg_post_title,.jeg_hero_style_7 .jeg_post_title a,.jeg_block_title,.jeg_splitpost_bar .current_title,.jeg_video_playlist_title,.gallery-caption {
	color: <?php echo esc_attr($heading_color) ?>;
}
