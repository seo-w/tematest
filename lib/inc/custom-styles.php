<?php
/* Custom Styles
============================== */
function tt_custom_styles() {
	
	global $realty_theme_option;
	$color_accent = $realty_theme_option['color-accent'];
	$color_header = $realty_theme_option['color-header'];
	$map_custom_height = $realty_theme_option['map-height-custom-home-search'];
	$property_image_custom_height = $realty_theme_option['property-image-custom-height'];
	$site_max_width = $realty_theme_option['site-max-width'];
	$property_image_location = $realty_theme_option['property-image-location'];
	$property_video_location = $realty_theme_option['property-video-location'];
	echo "\n<style>\n";

	// Theme Option: Site Layout "Boxed"
	if ( $realty_theme_option['site-layout'] == "boxed" && ! is_page_template( 'template-map-vertical.php' ) ) {
		echo "body { margin: 0 auto; max-width: $site_max_width"."px; }\n";
		echo "#boxed-layout { background-color: #fff; box-shadow: 0 0 5px rgba(0, 0, 0, 0.3); }\n";
		echo "#boxed-layout > .container, #boxed-layout .navbar > .container, #boxed-layout #footer .container { padding: 0 30px; }\n";
		echo "#boxed-layout .section-title span { background-color: #fff; }\n";
		echo "#boxed-layout .content-box { padding: 0; }\n";
		echo ".container { max-width: $site_max_width"."px; }\n";
	}
	
	if ( $realty_theme_option['map-height-type-home-search'] == "custom" && $map_custom_height ) {
		echo "body.page-template-template-home-properties-map-php .google-map, body.page-template-template-property-search-php .google-map { height: $map_custom_height"."px; }\n";
	}
	
	if ( $realty_theme_option['property-image-height'] == "custom" && $property_image_custom_height ) {
		echo ".property-image-container, .property-image-container .owl-item, .property-image-container .spinner { height: $property_image_custom_height"."px; }\n";
	}
	
	if ( $realty_theme_option['property-featured-listing-layout'] != 'featured-title-view' || $realty_theme_option['property-listing-status-tag'] ) {
		echo ".property-item .property-tag { background: $color_accent; }\n";
	}
	if ( $realty_theme_option['property-show-centered-title'] ) {
		echo ".property-item figcaption { text-align: center; }\n";
		echo ".property-item .property-title{ text-align: center; }\n";
	}
	if ( $realty_theme_option['property-listing-title-position'] == 'title-below-image' ) {
		echo ".property-item figcaption { position: static; }\n";
		echo ".property-item .property-title { background: #e9e9e9; }\n";
	}
	
	echo "a, #map-marker-container .content .title, div[id^=google-map] .title, body.single-property #property-features li i.fa-check, #sidebar .widget .widget-content table a { color: $color_accent; }\n";
	
	echo "header.navbar, header.navbar a { color: $color_header }\n";
	echo "header.navbar #login-bar-header a { color: $color_header }\n";
	
	echo ".btn-primary, .btn-primary:focus, input[type='submit'], .acf-button.blue, .primary-tooltips .tooltip-inner, .sub-menu li.current-menu-item, .sub-menu li:hover, .property-item .property-excerpt::after, .property-item.featured .property-title::after, #page-banner .banner-title:after, #pagination .page-numbers li .current, #pagination .page-numbers li .current:hover, .map-wrapper .map-controls .control.active, .map-wrapper .map-controls .control:hover, .datepicker table tr td.active.active, .datepicker table tr td.active:hover.active, .noUi-connect, body.single-property #property-status-update span, .more-link, .nav-tabs > li > a:hover, .nav-bottom .owl-nav div, .widget .owl-nav div, .entry-header .header-content, .property-header .status-update, #template-slideshow.slideshow-type-custom .title:after { background-color: $color_accent }\n";

	echo "input:focus, .form-control:focus, input:active, .form-control:active, ul#sidebar li.widget .wpcf7 textarea:focus, #footer li.widget .wpcf7 textarea:focus, ul#sidebar li.widget .wpcf7 input:not([type='submit']):focus, #footer li.widget .wpcf7 input:not([type='submit']):focus, .chosen-container.chosen-container-active .chosen-single, .chosen-container .chosen-drop { border-color: $color_accent }\n";
	
	echo ".primary-tooltips .tooltip.top .tooltip-arrow, .arrow-down, .sticky .entry-header { border-top-color: $color_accent }\n";
	echo ".primary-tooltips .tooltip.right .tooltip-arrow, .arrow-left { border-right-color: $color_accent }\n";
	echo ".primary-tooltips .tooltip.bottom .tooltip-arrow, .arrow-up { border-bottom-color: $color_accent }\n";
	echo ".primary-tooltips .tooltip.left .tooltip-arrow, .arrow-right, #property-slideshow .description .arrow-right { border-left-color: $color_accent }\n";
	echo "#template-slideshow .title { background-color: $color_accent }\n";
	echo "#template-slideshow .description .arrow-right { border-left-color: $color_accent }\n";	
	echo "#template-slideshow .description .arrow-left { border-right-color: $color_accent }\n";	
	echo ".input--filled label::before, .form-control:focus + label::before { border-color: $color_accent !important }\n";
	echo "body.rtl #property-slideshow .description .arrow-right { border-right-color: $color_accent; border-left-color: transparent !important; }\n";
	
	$color_body_background = $realty_theme_option['color-body-background'];
	$color_body_background = $color_body_background['background-color'];
	echo ".spinner { background-color: $color_body_background; }\n";
	//echo ".fit-img .property-image { background-size: contain;}";
	// Theme Options: Custom Styles
	echo $realty_theme_option['custom-styles']."\n";
	
	if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) {
	echo ".owl-fearured-properties { direction: ltr; }";
	echo ".owl-latest-properties { direction: ltr; }";
	}
	
	echo "</style>\n";

}
add_action( 'wp_head', 'tt_custom_styles', 15 ); // Fire after Redux