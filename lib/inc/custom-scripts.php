<?php
/* LOAD ADMIN SCRIPT
============================== */
function tt_admin_scripts( $hook ) {	

	wp_enqueue_style('tinymce', get_template_directory_uri() . '/lib/tinymce/tinymce-style.css', null, null );
	
	// Absolute Template Path
  $tt_abs_path = array( 'template_url' => get_template_directory_uri() );
  wp_localize_script( 'jquery', 'abspath', $tt_abs_path );
  
  // Enqueue Only For Posts
	if ( 'post.php' != $hook ) {
  	return;
  }
	
	wp_enqueue_script('tt-admin-script', get_template_directory_uri() . '/assets/js/admin.js' );
	wp_enqueue_media();	
  
}
add_action('admin_enqueue_scripts', 'tt_admin_scripts');

/* Theme Scripts
============================== */
if ( ! function_exists( 'tt_scripts' ) ) { 
function tt_scripts() {
global $realty_theme_option;
?>
<script>
jQuery(document).ready(function($) {
	
// Social Sharing and video pop up
 video_and_social_share();
//

jQuery('.search-results-view i').on('click',function() {
  jQuery('.search-results-view i').removeClass('active');
  jQuery(this).toggleClass('active');
  jQuery('#property-items').fadeTo( 300 , 0, function() {
  jQuery(this).fadeTo( 300, 1 );
});

setTimeout(function() {
  jQuery('#property-items').attr( 'data-view', jQuery('.search-results-view i.active').attr('data-view') );
}, 300);

});
<?php 
// Login Welcome Message
if ( is_user_logged_in() ) {
	if ( isset( $_GET['sign-user'] ) ) {
  	if( $_GET['sign-user'] == 'successful') { ?>
      jQuery.notifyBar({ cssClass: "alert-success", html: "<?php echo __( 'Login successful', 'tt' ); ?>" } );
<?php 
		} 
	}
}

if ( isset( $_GET['user-register'] ) ) { 
	if( $_GET['user-register'] == 'registered') { ?>
    jQuery.notifyBar({ cssClass: "alert-success", html: "<?php echo __( 'Your account has been created. Please check your email inbox.', 'tt' ); ?>" });
<?php 
	} 
}

// Single Property Title Toggle
?>
jQuery('.property-header-container').on('click','.hide-title, .show-title',function(e) {
  e.preventDefault();
  jQuery('.property-header').slideToggle('slow');
  jQuery('.show-title').slideToggle('slow');
});

}); // END document.ready
jQuery(window).load(function() {

<?php 
// Map Height On Property Map & Search Results Page Template
if ( $realty_theme_option['map-height-type-home-search'] == "fullscreen" && ( is_page_template( 'template-home-properties-map.php' ) || is_page_template( 'template-property-search.php' ) ) ) { ?>
  jQuery('body.page-template-template-home-properties-map-php .google-map, body.page-template-template-property-search-php .google-map').css( 'height', heightFullscreen );
<?php 
}
// Property Image Height - Fullscreen
if ( $realty_theme_option['property-image-height'] == "fullscreen" ) { ?>

if ( isMobile ) {
	var heightFullscreenBoxed = heightFullscreen - 15; // margin-top to header
}
else {
	var heightFullscreenBoxed = heightFullscreen - 50; // margin-top to header
}

if ( jQuery('#property-layout-boxed .property-image-container').hasClass('cut') ) {
	jQuery('#property-layout-boxed .property-image').css( 'height', heightFullscreenBoxed );
}
else {
	jQuery('#property-layout-boxed .property-image').css( 'height', heightFullscreenBoxed );
}

if ( jQuery('#property-layout-full-width .property-image-container').hasClass('cut') ) {
	jQuery('#property-layout-full-width .property-image').css( 'height', heightFullscreen );
}

else {
	jQuery('#property-layout-full-width .property-image').css( 'height', heightFullscreen );
}
<?php 
}
if ( $realty_theme_option['property-image-width'] == "full" ) { ?>
	jQuery('#property-slideshow ul.slides li').css( 'width', windowWidth+'px' );
<?php }
	
// Property Image Height - Custom
if ( $realty_theme_option['property-image-height'] == "custom" ) { ?>
if ( jQuery('.property-image-container').hasClass('cut') ) {
	jQuery('.property-image-container .property-image, .property-image-container iframe').css( 'height', <?php echo $realty_theme_option['property-image-custom-height']; ?> );
}
<?php }

// Property - Lightbox
if ( $realty_theme_option['property-lightbox'] == "magnific-popup" ) { ?>
jQuery('body.single-property .property-image').magnificPopup({ 
	type: 		'image',
	gallery: 	{
		enabled: 	true,
		tPrev: 		'',
		tNext: 		'',
		tCounter: '%curr% | %total%'
	}
});
<?php
}
else if ( $realty_theme_option['property-lightbox'] == "intense-images" ) {
?>
jQuery('body.single-property .property-image').each(function() {
	Intense( jQuery(this) );
});
<?php } ?>

// Datepicker
<?php
$datepicker_language = $realty_theme_option['datepicker-language'];
if( function_exists( 'icl_object_id' ) ) {
	if(ICL_LANGUAGE_CODE){
 	$datepicker_language = ICL_LANGUAGE_CODE;
	}
}
$price_thousands_separator = $realty_theme_option['price-thousands-separator'];
if ( isset( $datepicker_language ) && !is_page_template( 'template-property-submit.php' )) { ?>
		jQuery('.datepicker').datepicker({
		language: '<?php echo $datepicker_language; ?>',
		autoclose: true,
		isRTL: <?php if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ){ echo "true"; } else { echo "false"; } ?>,
		format: "yyyymmdd",
		});
<?php } ?>
// Price Range
if ( jQuery('.price-range-slider').length ) {
	
var priceFormat;
var priceSlider = document.getElementById('price-range-slider');
noUiSlider.create(priceSlider, {
	
	start: [ <?php if ( isset( $_GET['price_range_min'] ) ) { echo $_GET['price_range_min']; } else if ( $realty_theme_option['property-search-price-range-min'] ) { echo $realty_theme_option['property-search-price-range-min']; } else { echo "0"; } ?>, <?php if ( isset( $_GET['price_range_max'] ) ) { echo $_GET['price_range_max']; } else if ( $realty_theme_option['property-search-price-range-max'] ) { echo $realty_theme_option['property-search-price-range-max']; } else { echo "0"; } ?> ],
	step: <?php if ( $realty_theme_option['property-search-price-range-step'] ) { echo $realty_theme_option['property-search-price-range-step']; } else {
		echo "0"; } ?>,
	range: {
		'min': [  <?php if ( $realty_theme_option['property-search-price-range-min']) { echo $realty_theme_option['property-search-price-range-min']; } else { echo "0"; } ?> ],
		'max': [  <?php if ( $realty_theme_option['property-search-price-range-max']) { echo $realty_theme_option['property-search-price-range-max']; } else { echo "0"; } ?> ]
	},
	format: wNumb({
		decimals: 0,
		encoder: function( a ){
                return Math.round(a*100)/100;
        },
		<?php 
		if ( $price_thousands_separator ){
			if ( $price_thousands_separator=="'" ) { echo "thousand: \"" . $price_thousands_separator . "\","; } else { if ( $price_thousands_separator ) { echo "thousand: '" . $price_thousands_separator . "',"; } }
		}
		if ( $realty_theme_option['currency-sign-position'] == 'left' ) { echo "prefix: '"; } else { echo "postfix: '"; } echo $realty_theme_option['currency-sign'] . "',"; 
		?>
	}),
	
	connect: true,
	animate: true,
	<?php if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) { ?>
	direction: 'rtl'
	<?php } ?>
	
	
});

priceFormat = wNumb({
	decimals: 0,
	<?php 
	if ( $price_thousands_separator ){
		if ( $price_thousands_separator=="'" ) { echo "thousand: \"" . $price_thousands_separator . "\","; } else { if ( $price_thousands_separator ) { echo "thousand: '" . $price_thousands_separator . "',"; } }
	}
	if ( $realty_theme_option['currency-sign-position'] == 'left' ) { echo "prefix: '"; } else { echo "postfix: '"; } echo $realty_theme_option['currency-sign'] . "',"; 
	?>
});

var priceValues = [
	document.getElementById('price-range-min'),
	document.getElementById('price-range-max')
];

var inputValues = [
	document.getElementById('price-range-min'),
	document.getElementById('price-range-max')
];

priceSlider.noUiSlider.on('update', function( values, handle ) {
	
	priceValues[handle].innerHTML = values[handle];
	//tt_ajax_search_results();
	var min_price = priceFormat.from( values[0] );
	var max_price = priceFormat.from( values[1] );
	jQuery('.property-search-price-range-min').val(min_price);
	jQuery('.property-search-price-range-max').val(max_price);
	
});

priceSlider.noUiSlider.on('change', function( values, handle ) {
	
	jQuery('#property-items').html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
	
	priceValues[handle].innerHTML = values[handle];
	//tt_ajax_search_results();
	var min_price = priceFormat.from( values[0] );
	var max_price = priceFormat.from( values[1] );
	jQuery('.property-search-price-range-min').val(min_price);
	jQuery('.property-search-price-range-max').val(max_price);
	
	tt_ajax_search_results();
	removeMarkers();

	
});

<?php if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) { ?>
jQuery('select').addClass('chosen-rtl');
<?php } ?>


}

// AJAX
function tt_ajax_search_results() {	
	"use strict";
	if ( jQuery('.property-search-feature') ) {	
		var feature = [];
		jQuery('.property-search-feature:checked').each(function() {
		  feature.push( jQuery(this).val() );
		});
	}
	var ajaxData = jQuery('.property-search-form').first().serialize() + "&action=tt_ajax_search&base=" + window.location.pathname;
	jQuery.ajax({
	  
	  type: 'GET',
	  url: ajaxURL,
	  data: ajaxData,
	  success: function (response) {
		  jQuery('.spinner').fadeOut();
	    jQuery('#property-items').html(response);
		video_and_social_share();
	  },
	  error: function () {
	  	console.log( 'failed' );
	  }
	  
	});

}

// Remove Map Markers & Marker Cluster
function removeMarkers() {
	// http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/examples/speed_test.js
  if(typeof newMarkers != 'undefined'){
    for( i = 0; i < newMarkers.length; i++ ) {
	  newMarkers[i].setMap(null);
		// Close Infoboxes
	  if ( newMarkers[i].infobox.getVisible() ) {
		newMarkers[i].infobox.hide();
	  }
    }
    if ( markerCluster ) { 
	  markerCluster.clearMarkers();
    }
    markers = [];
    newMarkers = [];	
    bounds = [];
  }
  
}
	
// Fire Search Results Ajax On Search Field Change (Exclude Datepicker)
jQuery('.property-search-form select, .property-search-form input').not('.datepicker').on('change',function() {	
	jQuery('#property-items').html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
	tt_ajax_search_results();
	if ( jQuery('.google-map').length > 0 ) {
		removeMarkers();	
	}	
});

// Fire Search Results Ajax On Search Field "Datepicker" Change
jQuery('.property-search-form input.datepicker').on('changeDate', function() {	
	jQuery('#property-items').html('<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
	tt_ajax_search_results();	
	if ( jQuery('.google-map').length > 0 ) {
		removeMarkers();	
	}	
});

  /* ajax script for pagination-------------------------*/
	
	jQuery(function($) {
	$('.pagination-ajax a').live('click',function(e){
		e.preventDefault();
	
		var link_page = $(this).attr('href');
		var page_number =  $(this).text();
		if($(this).hasClass( "next" )){
			
			var next_from = parseInt($('.pagination-ajax li span').text());
			page_number = next_from + 1;
			
		}
		if($(this).hasClass( "prev" )){
			
			var prev_from = parseInt($('.pagination-ajax li span').text());
			page_number = prev_from - 1;
		}
		$('#property-items').fadeOut(500);
		removeMarkers();	
		
		var ajaxData = jQuery('.property-search-form').first().serialize() + "&action=tt_ajax_search&base=" + window.location.pathname + "&pagenumber=" + page_number;
		//console.log(ajaxData);
		$.ajax({
			type: 'GET',
			url: ajaxURL,//ajaxURL,
			data: ajaxData,		
			success: function (response) {
	
				$("#property-items").html(response);
				$("#property-items").fadeIn(500);
				window.history.pushState("#property-items", "Properties",link_page );
				
				
			},
			error: function () {
			console.log( 'failed' );
			}	
	
		});
	});
});
	
				 
				 
	// end pagination script

}); // END window.load

<?php if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) { ?>
jQuery('.fa-angle-right').addClass('right-one').removeClass('fa-angle-right');
jQuery('.fa-angle-left').addClass('left-one').removeClass('fa-angle-left');
jQuery('.right-one').addClass('fa-angle-left').removeClass('right-one')
jQuery('.left-one').addClass('fa-angle-right').removeClass('left-one')
<?php 
}
// Navigation
if( ! $realty_theme_option['show-sub-menu-by-default-on-mobile'] ) { ?> 
jQuery('.menu-item-has-children, .menu-item-language').click(function() {
  if ( jQuery('body').hasClass('show-nav') ) {
    jQuery(this).find('.sub-menu').toggleClass('show');
  }
});
<?php } else { ?>
jQuery('.navbar-toggle').click(function() {
  jQuery('.sub-menu').toggleClass('show');
});

jQuery('.menu-item-has-children, .menu-item-language').click(function() {
  jQuery(this).find('.sub-menu').toggleClass('show');
});
<?php }
	
// Theme Options: Custom Scripts
echo $realty_theme_option['custom-scripts']."\n";
?>
</script>	
<?php
}
}
add_action( 'wp_footer', 'tt_scripts', 20 );