var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
var windowHeight = jQuery(window).height();
var windowWidth = jQuery(window).width(); 
var initialNavHeight = jQuery('header.navbar').height();
var loginBarHeight = jQuery('#login-bar-header').height();
var heightFullscreen;
function video_and_social_share(){jQuery(".property-video-popup").magnificPopup({type:"iframe"}),jQuery(".property-price").on("click",".share-property",function(){jQuery(this).prev(".share-unit").toggle()})}
jQuery(document).ready(function() {
	
	/* Navigation
	-------------------------*/
	jQuery('.navbar-toggle').click(function() {
		jQuery('body').toggleClass('show-nav');
	});	
	/* Smooth Ccroll Menu Links
	-------------------------*/
	jQuery('#up i, .property-header a').on('click', function(e) {
    e.preventDefault();
    jQuery('html,body').animate({scrollTop:jQuery(this.hash).offset().top-15}, 800); 
  });
    
  /* Scroll To The Top - Button
	-------------------------*/
	jQuery('#up').click(function(e) {
		e.preventDefault();
		jQuery('html, body').animate({scrollTop: 0}, 800);
	});
		
	/* Bootstrap Datepicker
	// http://eternicode.github.io/bootstrap-datepicker/
	-------------------------*/
	/*jQuery('.datepicker').datepicker({
    language: 	'en',
    autoclose: 	true,
    format: "yyyymmdd"
	});*/
		
	/* FitVids v1.0 - Fluid Width Video Embeds
	https://github.com/davatron5000/FitVids.js/
	-------------------------*/
	jQuery('#main-content, article, #intro-wrapper').fitVids();
	jQuery('.fluid-width-video-wrapper').css('padding-top','56.25%'); // Always display videos 16:9 (100/16*9=56.25)
	
	/* Property Search Results
	-------------------------*/
	jQuery('.search-results-view i').click(function() {
		jQuery('.search-results-view i').removeClass('active');
		jQuery(this).toggleClass('active');
		
		jQuery('#property-items').fadeTo( 300 , 0, function() {
    	jQuery(this).fadeTo( 300, 1 );
		});
		
		setTimeout(function() {
			jQuery('#property-search-results').attr( 'data-view', jQuery('.search-results-view i.active').attr('data-view') );
		}, 300);
		
	});
	jQuery('.toggle-property-search-more').click(function(e) {
		e.preventDefault();
		jQuery(this).find('span').toggleClass('hide');
		jQuery('.property-search-more').toggleClass('show');
	});
	
	jQuery('#orderby').on('change', function() {

		var orderValue = jQuery(this).val();
		var OrderKey = 'order-by';	
		var windowLocationHref = window.location.href;
		
		// http://stackoverflow.com/questions/5999118/add-or-update-query-string-parameter
		function updateQueryStringParameter(uri, key, value) {
		  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
		  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
		  if (uri.match(re)) {
		    return uri.replace(re, '$1' + key + "=" + value + '$2');
		  }
		  else {
		    return uri + separator + key + "=" + value;
		  }
		}
		
		// Load new-built URI (Refresh With Orderby Update)
		document.location = updateQueryStringParameter( windowLocationHref, OrderKey, orderValue );
		
	});
	
	jQuery('.search-results-header .fa-repeat').click(function() {
		location.reload();
	});
		
	/* Map - Button
	-------------------------*/
	jQuery('.map-controls a').click(function(e) {
		e.preventDefault();
	});	
	
	/* Template - Intro
	-------------------------*/	
	jQuery('#intro-wrapper .toggle').click(function(e) {
		e.preventDefault();
		jQuery('.intro-search, .intro-map').toggleClass('transform');
		var introMapHeight = jQuery('.intro-map').height();
		jQuery('#intro-wrapper .intro-right').css( 'height', introMapHeight );
	});
	
	
	jQuery('#toggle-intro-wrapper').click(function(e) {
		e.preventDefault();
		jQuery('#intro-wrapper').find('.inner').fadeToggle();
		jQuery(this).find('i').toggleClass('fa-expand, fa-compress');
	});
		
	/* Forms
	-------------------------*/
	if( jQuery().validate && jQuery().ajaxSubmit ) {

		// Contact Form - Single Property
		var contactForm = {
			target: 'form-submitted'
		};
		
		jQuery('#contact-form').validate({
			//errorLabelContainer: jQuery('#form-errors'),
	    submitHandler: function(form) {
							         jQuery(form).ajaxSubmit(contactForm); 
							         jQuery('#form-success').removeClass('hide');
								     },
			rules: {
		    email: {
		      required: true,
		      email: true
		    },
		    message: {
		      required: true
		    }
		  }
		});
		
		// User Registration
		jQuery('#registerform').validate({
	    submitHandler:  jQuery(this).ajaxSubmit(),
			rules: {
		    user_login: {
		      required: true
		    },
		    user_email: {
		      required: true,
		      email: true
		    },
		    user_terms: {
		      required: true
		    }
		  }
		});
		
		// User Login	
		jQuery('#loginform').validate({
	    submitHandler:  jQuery(this).ajaxSubmit(),
			rules: {
		    log: {
		      required: true
		    },
		    pwd: {
		      required: true
		    }
		  }
		});
	
	}
		
	/* Property Pagination
	-------------------------*/
	jQuery('#property-items').fadeTo(0, 0);
	jQuery('#property-items').fadeTo(400, 1);
	
	jQuery('#pagination a').click(function() {
		jQuery('#property-items').fadeTo(400, 0);
	});
		
	/* Window Scroll
	-------------------------*/
	jQuery(window).scroll(function() {
		// Scroll To Top Button
		if ( jQuery(this).scrollTop() > initialNavHeight ) {
			jQuery('#fixed-controls').addClass('show');
			// Fixed Header 
			if ( !isMobile && jQuery('body').hasClass('fixed-header') ) {
				// Consider Admin Bar
				if ( jQuery('body').hasClass('admin-bar') ) {
					jQuery('header.navbar').addClass('mini');
					var loginBarHeightAdmin = loginBarHeight - 32; // 32 = admin bar height in px
					jQuery('header.navbar').css( 'top', '-'+loginBarHeightAdmin+'px' );
				}
				else {
					jQuery('header.navbar').addClass('mini');
					jQuery('header.navbar').css( 'top', '-'+loginBarHeight+'px' );
				}
			}
		}
		else {
			jQuery('#fixed-controls').removeClass('show');
			// Fixed Header 
			if ( !isMobile && jQuery('body').hasClass('fixed-header') ) {
				// Consider Admin Bar
				if ( jQuery('body').hasClass('admin-bar') ) {
					jQuery('header.navbar').removeClass('mini');
					jQuery('header.navbar').css( 'top', '32px' );
				}
				else {
					jQuery('header.navbar').removeClass('mini');
					jQuery('header.navbar').css( 'top', 0 );
				}
			}
		}	
	});
	
	/* Bootstrap Plugins
	-------------------------*/	
	jQuery('[data-toggle="tooltip"]').tooltip();
		
});


jQuery(window).load(function() {
	
	/* Logo Retina
	-------------------------*/
	logoHeight = jQuery('.navbar-brand img').height();
	logoHeightFinal = logoHeight / 2;
	if ( logoHeightFinal ) {
		jQuery('.navbar-brand img').height(logoHeightFinal);
	}

	/* Logo FadeIn
	-------------------------*/
	jQuery('.navbar-brand img').fadeTo(400, 1);
	
	navHeight = jQuery('header.navbar').height();
	heightFullscreen = windowHeight - navHeight;
	
	/* Theme Option: Fixed Header - Set Body Offset
	-------------------------*/
	var navHeightAfterLogoResize = jQuery('header.navbar').height();
	
	if ( jQuery('.container').hasClass('header-margin') ) {
		var bodyOffsetFixedHeader = navHeightAfterLogoResize + 50; // 50 = Static header margin-bottom
	}
	else {
		var bodyOffsetFixedHeader = navHeightAfterLogoResize;
	}
	
	/* Fixed Header
	-------------------------*/
	if ( !isMobile && jQuery('body').hasClass('fixed-header') ) {
		// 0 Offset For Certain Page Templates
		if ( jQuery('body').hasClass('page-template-template-home-properties-map-php') || jQuery('body').hasClass('page-template-template-property-search-php') ) {
			jQuery('body').css('margin-top', navHeightAfterLogoResize+'px');
		}
		// 50px offset For All Other Pages
		else {
			jQuery('body').css('margin-top', bodyOffsetFixedHeader+'px');
		}
	}
	
	/* Chosen.js - Custom Select Boxes
	http://harvesthq.github.io/chosen/options.html
	-------------------------*/
	jQuery('#dsidx select').chosen({ 
		width: "auto"
	});
	jQuery('select').not('.acf-hidden').chosen({  
		width: "100%",
		search_contains: true,
		disable_search_threshold: 5
	});
	jQuery('.search-results-order select').chosen({
		disable_search: true,
		width: "100%"
	});
  
  /* Latest Tweets Widget Plugin
  https://wordpress.org/plugins/latest-tweets-widget/
	============================== */
	var latestTweets = jQuery('.latest-tweets')
	var latestTweetsItems = jQuery(latestTweets).find('ul').children('li');
	
	if ( latestTweetsItems.length > 1 ) {
  	jQuery(latestTweets).find('ul').addClass('owl-carousel-1');
  }
  
  /* Owl Carousel
  https://github.com/smashingboxes/OwlCarousel2
	============================== */
  
  // Property thumbnails
	setTimeout(function() {
		jQuery('#property-thumbnails').fadeTo(400, 1);
		// Center dots
		var owlDotsWidth = jQuery('.owl-dots').outerWidth();
		jQuery('.owl-dots').css( 'margin-left', '-' + owlDotsWidth/2 + 'px' );
	}, 300);
	
	jQuery('#property-thumbnails .owl-item').removeClass('active');
	jQuery('#property-thumbnails .owl-item').first().addClass('active');
	
	jQuery('#property-thumbnails .owl-item').click(function() {
		jQuery('#property-thumbnails .owl-item').removeClass('active');
		jQuery(this).addClass('active');
	});
  
  var rtlResult = false;
  
  if ( jQuery('body').hasClass('rtl') ) {
	  rtlResult = true;
  }
  
  // Carousel: 1 Column
  jQuery('.owl-carousel-1').owlCarousel({
	  rtl:            rtlResult,
	  items: 					1,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						false,
	  dots: 					true,
	  autoHeight: 		true,
	  responsiveBaseElement: '.owl-carousel-1', 
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
  });
  
  jQuery('.owl-carousel-1-nav').owlCarousel({
	  rtl:            rtlResult,
	  items: 					1,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  responsiveBaseElement: '.owl-carousel-1-nav', 
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
  }); 
 
  // Carousel: 2 Columns
  jQuery('.owl-carousel-2').owlCarousel({
	  rtl:            rtlResult,
	  items: 					2,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						false,
	  dots: 					true,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 2
							        }
							    }
  });
  
  jQuery('.owl-carousel-2-nav').owlCarousel({
	  rtl:            rtlResult,
	  items: 					2,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 2
							        }
							    }
  });
  
  // Carousel: 3 Columns
  jQuery('.owl-carousel-3').owlCarousel({
	  rtl:            rtlResult,
	  items: 					3,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						false,
	  dots: 					true,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 3
							        }
							    }
  });
  
  jQuery('.owl-carousel-3-nav').owlCarousel({
	  rtl:            rtlResult,
	  items: 					3,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	 //responsiveBaseElement: '.owl-carousel-3-nav', 
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	 responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true,
										lazyLoad: true,
										autoHeight: true
							        },
							        992: {
							            items: 3
							        }
							    }
  });
  
  // Carousel: 4 Columns
  jQuery('.owl-carousel-4').owlCarousel({
	  rtl:            rtlResult,
	  items: 					4,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						false,
	  dots: 					true,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 4
							        }
							    }
  });
  
  jQuery('.owl-carousel-4-nav').owlCarousel({
	  rtl:            rtlResult,
	  items: 					4,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 4
							        }
							    }
  });
  
  // Carousel: 5 Columns
  jQuery('.owl-carousel-5').owlCarousel({
	  rtl:            rtlResult,
	  items: 					5,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						false,
	  dots: 					true,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 5
							        }
							    }
  });
  
  jQuery('.owl-carousel-5-nav').owlCarousel({
	  rtl:            rtlResult,
	  items: 					5,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 5
							        }
							    }
  });
  
  // Carousel: 6 Columns
  jQuery('.owl-carousel-6').owlCarousel({
	  rtl:            rtlResult,
	  items: 					6,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						false,
	  dots: 					true,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 6
							        }
							    	}
  });
  
  jQuery('.owl-carousel-6-nav').owlCarousel({
	  rtl:            rtlResult,
	  items: 					6,
	  margin: 				30,
	  loop: 					false,
	  navSpeed: 			600,
	  dragEndSpeed: 	600,
	  nav: 						true,
	  dots: 					false,
	  autoHeight: 		true,
	  navText: 				['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	  responsiveClass:true,
    responsive: 		{
							        0: {
							            items: 1,
							            nav: true
							        },
							        992: {
							            items: 6
							        }
							    	}
  }); 

  /* Print Button
	-------------------------*/	
	jQuery('#print').click(function(e) {
		e.preventDefault();
		javascript:window.print();
	});
		
	/* Show Login Modal
	-------------------------*/	
	if ( window.location.search.indexOf('login') > -1 ) {
		jQuery('#login-modal').modal();
	}
	
	jQuery('.slideshow-search').addClass('show');

});