/* =Custom JS
-------------------------------------------------------------- */

jQuery(document).ready(function() {
		"use strict";
		
		/* 
		 * Login Form
		 */
		jQuery('.open-popup-link').magnificPopup({
		  type:'inline',
		  midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
		});

		/*----------------------------------------------------*/
		/*	Video
		/*----------------------------------------------------*/

		jQuery("#page-wrapper").fitVids();

		/*----------------------------------------------------*/
		/*	Navigation
		/*----------------------------------------------------*/

		jQuery('ul.sf-menu, .user-module, .share-menu').superfish({
			delay:       1000,                            // one second delay on mouseout
			animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
			speed:       'fast',                          // faster animation speed
			autoArrows:  false                            // disable generation of arrow mark-up
		}); 

		jQuery('#navigation-wrapper li.menu-item-has-children > a').append('<i class="icon-angle-down"></i>');

		jQuery('#mobile-menu nav').meanmenu({
			meanScreenWidth: "960"
		});

		jQuery(function(){
		jQuery("a.meanmenu-reveal").click(function(){

		    if(!jQuery('header').hasClass("push-me")) {
		        jQuery('header').addClass("push-me");
		    } else {
		        jQuery('header').removeClass("push-me");
		    }
		});
		});

		/*----------------------------------------------------*/
		/*	Hover Overlay
		/*----------------------------------------------------*/

			jQuery(".media, li.product, span.thumb").hover(function () {
				jQuery(this).find(".hovercover").stop().fadeTo(200, 1);
				jQuery(this).find(".on-hover").stop().fadeTo(200, 1, 'easeOutQuad');
				jQuery(this).find(".hovericon").stop().animate({'top' : '50%', 'opacity' : 1}, 250, 'easeOutBack');
			},function () {
				jQuery(this).find(".hovercover").stop().fadeTo(200, 0);
				jQuery(this).find(".on-hover").stop().fadeTo(200, 0, 'easeOutQuad');
				jQuery(this).find(".hovericon").stop().animate({'top' : '65%', 'opacity' : 0}, 150, 'easeOutSine');
			});

		/*----------------------------------------------------*/
		/*	Flexslider & Galleries
		/*----------------------------------------------------*/

		jQuery(window).load(function() {
		    jQuery('body.blog .flexslider, body.single-post .flexslider').flexslider({
		    	prevText: "",           //String: Set the text for the "previous" directionNav item
				nextText: "", 
		    });
		});

        jQuery('.gallery_thumbs, #slider2').each(function() { // the containers for all your galleries should have the class gallery
            jQuery(this).magnificPopup({
                delegate: 'a', // the container for each your gallery items
                type: 'image',
                gallery:{enabled:true},
                removalDelay: 500, //delay removal by X to allow out-animation
                closeOnContentClick: true
            });
        });

		  
        /*----------------------------------------------------*/
		/*	Vehicles Filter
		/*----------------------------------------------------*/

        jQuery('.filter-select, #role').fancySelect();

		/*----------------------------------------------------*/
		/*	Tooltips
		/*----------------------------------------------------*/
		
		jQuery('.tooltip, #view-filter a').tooltipster();

		/*----------------------------------------------------*/
		/*	scrollbar
		/*----------------------------------------------------*/

		jQuery('.location-finder .one_third').mCustomScrollbar({
            theme : "dark-thick"
        });

		/*----------------------------------------------------*/
		/*	js map filter
		/*----------------------------------------------------*/

        jQuery('.location-finder article').click(function() {
            var tag = jQuery(this).attr('rel');
            var title = jQuery(this).find('h3').text();
            var anchor = jQuery(this).find('a.pop-title').get();
            var html = '<strong><a href="'+anchor+'">'+title+'</a></strong>';
            jQuery('#map_canvas').gmap3({
                exec: {
                    tag : tag,
                    all:"true",
                    func: function(data){
                        // data.object is the google.maps.Marker object
                        //data.object.setIcon("img/black-marker.png");

                        var map = jQuery('#map_canvas').gmap3("get"),
                            infowindow = jQuery('#map_canvas').gmap3({get:{name:"infowindow"}});
                        if (infowindow){
                            infowindow.open(map, data.object);
                            infowindow.setContent(html);
                        } else {
                            jQuery('#map_canvas').gmap3({
                                infowindow:{
                                    anchor: data.object,
                                    options:{content: html}
                                }
                            });
                        }


                    }
                }
            });
        });
        jQuery('.location-finder article').hover(function() {
            var tag = jQuery(this).attr('rel');
            jQuery('#map_canvas').gmap3({
                exec: {
                    tag : tag,
                    all:"true",
                    func: function(data){
                        // data.object is the google.maps.Marker object
                        //data.object.setIcon("img/orange-marker.png")
                    }
                }
            });
        }, function() {
            var tag = jQuery(this).attr('rel');
            jQuery('#map_canvas').gmap3({
                exec: {
                    tag : tag,
                    all:"true",
                    func: function(data){
                        // data.object is the google.maps.Marker object
                        //data.object.setIcon("img/blue-marker.png")
                    }
                }
            });
        });

        /*----------------------------------------------------*/
		/*	info
		/*----------------------------------------------------*/

        jQuery("#vehicle-toggle li a").click(function() {
			if(jQuery(this).closest("li").hasClass("current-item")) {
				// same icon
				return false;
			}
			else {
				var visible_content = jQuery(this).closest("li").attr("id");
				var hidden_content = jQuery("#vehicle-toggle li.current-item").attr("id");
				jQuery("#vehicle-toggle li").removeClass("current-item");
				jQuery(this).closest("li").addClass("current-item");
				jQuery("."+hidden_content).hide();
				jQuery("."+visible_content).fadeIn("fast");
				
				if(visible_content == "vehicle-location") {
					initializeMaps("dealer");
				}
			}
			return false;
		});

		/*----------------------------------------------------*/
		/*	forms
		/*----------------------------------------------------*/

        jQuery('.menu').dropit();

        //jQuery('select#main_cat, select#tax_vehicle_model').attr("data-validetta", "required");

        jQuery('select#adv_main_cat, select#adv_tax_vehicle_model').attr("required","required");

        jQuery('#auto_title, #price, #auto_category, #featured_image').attr("required","required");

        jQuery('#wp-advanced-search input, #side-navigation input, #front-login input, #routeForm input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
          });

        jQuery('.widget_tdp_vehicle_search select').after('<i class="icon-angle-down select-icon"></i>');

        jQuery('#contact-form, #wp-advanced-search, #2submit-auto-form').validetta({
	        realTime : true,
	        errorClass      : 'form-error'
	    }); 

	    jQuery('#adv-vehicle-searc2h').validetta({
	        realTime : true,
	        errorClass      : 'form-error2',
	    }); 

		jQuery('#auto_title, #price, #auto_category, #featured_image').attr("data-msg-required", tdp_submission_error_message );

		// Add Error Container inside form page
		jQuery('body.page-template-templatestemplate-submit-php h3.form-title').after('<div class="error"></div>');

	    jQuery("#adv-vehicle-search, #submit-auto-form").validate({
	    	ignore: "",
	    	messages: {
				adv_tax_vehicle_model: '<span class="icon-attention animated bounce"></span>',
			},
			submitHandler: function(form) {
		    	form.submit();
		 	},
		 	invalidHandler: function(event, validator) {
			    // 'this' refers to the form
			    var errors = validator.numberOfInvalids();
			    if (errors) {
			      var message = tdp_submission_form_complete_validation;
			      
			      jQuery("div.error").html(message);
			      jQuery("div.error").show();
			    } else {
			      jQuery("div.error").hide();
			    }
			  }
		});

		jQuery('.fieldset-auto_title').addClass('one_half');
		jQuery('.fieldset-price').addClass('one_half last').after('<div class="clear"></div>');

		jQuery('#submission-form fieldset select').after('<i class="icon-angle-down select-icon"></i>');
		jQuery('#landing-form-wrapper select').after('<i class="icon-down-open"></i>');

		jQuery('.fieldset-auto_type, .fieldset-auto_category, .fieldset-auto_fuel_type, .fieldset-auto_status, .fieldset-auto_country_location, .fieldset-auto_gearbox, .fieldset-auto_interior, .fieldset-auto_exterior, .fieldset-auto_safety ').addClass('one_fourth');
		jQuery('.fieldset-auto_fuel_color, .fieldset-auto_years_old, .fieldset-auto_extra').addClass('one_fourth last').after('<div class="clear"></div>');

		jQuery('.fieldset-set_type, .fieldset-mileage, .fieldset-capacity, .fieldset-power_bhp, .fieldset-consumption_mpg, .fieldset-emission_class, .fieldset-doors, .fieldset-registration_year').addClass('one_fifth');

		jQuery('#location_input_front_map').addClass('one_half');
		jQuery('.location_dl').addClass('one_half last').after('<div class="clear"></div>');

    	jQuery('.fieldset-power_kw, .fieldset-discount').addClass('one_fifth last').after('<div class="clear"></div>');

		jQuery('#auto_category, #tax_vehicle_model').after('<img id="status_loader" src="'+ theme_images + '/images/ajax-loader.gif"/>');

		var child_height = jQuery('ul.auto_packages li').height();
      	jQuery('.package-price').attr('style', 'height: ' + (child_height - 30) + 'px;');

      	jQuery('form.checkout_coupon .form-row-last input[type=submit]').removeClass('button').addClass('btn large');

      	jQuery("a#fav-nonlogged").click(function() {
      		jQuery('#fav-logged-message').show("scale", 500);
    	});

    	/*-------------------------------------------------------------------------*/
		/*	Footer column
		/*-------------------------------------------------------------------------*/
		var footer_height = jQuery('footer').height();
		jQuery('.stats-column').height(footer_height);

		var slider_height = jQuery('#landing-search').height();
		jQuery('#homepage-right-side').height(slider_height);

		/*-------------------------------------------------------------------------*/
		/*	Woo
		/*-------------------------------------------------------------------------*/

		jQuery(".products li:nth-child(4n)").addClass("last");
		jQuery('.woocommerce-info, .woocommerce-message').addClass('alert-box info');

		/*-------------------------------------------------------------------------*/
		/*	homepage form
		/*-------------------------------------------------------------------------*/
    	
    	
		jQuery('#tabs-adv #wpas-main_cat, #tabs-adv #wpas-tax_vehicle_model, #tabs-adv #wpas-tax_vehicle_year, #tabs-adv #wpas-tax_vehicle_type, #tabs-adv #wpas-tax_vehicle_status, #tabs-adv #wpas-submit').addClass('one_half');
		jQuery('#tabs-adv #wpas-tax_vehicle_color').before('<div class="clearboth"></div>');
		jQuery('#tabs-adv #wpas-tax_vehicle_model, #tabs-adv #wpas-tax_vehicle_type, #tabs-adv #wpas-submit').addClass('last');
		jQuery('#tabs-adv #wpas-submit').after('<div class="clearboth"></div>');
		
		jQuery('.custom-search-form #wpas-main_cat, .custom-search-form #wpas-tax_vehicle_model, .custom-search-form #wpas-tax_vehicle_year, .custom-search-form #wpas-tax_vehicle_type, .custom-search-form #wpas-tax_vehicle_status, .custom-search-form #wpas-submit').addClass('one_half');
		jQuery('.custom-search-form #wpas-tax_vehicle_color').before('<div class="clearboth"></div>');
		jQuery('.custom-search-form #wpas-tax_vehicle_model, .custom-search-form #wpas-tax_vehicle_type, .custom-search-form #wpas-submit').addClass('last');
		jQuery('.custom-search-form #wpas-submit').after('<div class="clearboth"></div>');


		//change

		
		jQuery(function(){
			jQuery('#main_cat').change(function(){
				var opt=jQuery('#main_cat').val();

				if(opt == 'all') {
					jQuery('#tax_vehicle_model').removeAttr("data-validetta");
				}

			}
			);
		});	

		//rtl_required

		if(theme_is_rtl == 'yes') {
			var get_row_left = jQuery('.tdp_row_fullwidth').css("left");
			jQuery('.tdp_row_fullwidth').css('right',get_row_left);
		}


});	


/*-------------------------------------------------------------------------*/
/*	Scroll to top
/*-------------------------------------------------------------------------*/	

		var jQueryscrollTop = jQuery(window).scrollTop();

		//starting bind
		if( jQuery('#to-top').length > 0 && jQuery(window).width() > 1020) {
			
			if(jQueryscrollTop > 350){
				jQuery(window).bind('scroll',hideToTop);
			}
			else {
				jQuery(window).bind('scroll',showToTop);
			}
		}


		function showToTop(){
			
			if( jQueryscrollTop > 350 ){

				jQuery('#to-top').stop(true,true).animate({
					'bottom' : '17px'
				},350,'easeInOutCubic');	
				
				jQuery(window).unbind('scroll',showToTop);
				jQuery(window).bind('scroll',hideToTop);
			}

		}

		function hideToTop(){
			
			if( jQueryscrollTop < 350 ){

				jQuery('#to-top').stop(true,true).animate({
					'bottom' : '-30px'
				},350,'easeInOutCubic');	
				
				jQuery(window).unbind('scroll',hideToTop);
				jQuery(window).bind('scroll',showToTop);	
				
			}
		}

		//to top color
		if( jQuery('#to-top').length > 0 ) {
			
			var jQuerywindowHeight, jQuerypageHeight, jQueryfooterHeight, jQueryctaHeight;
			
			function calcToTopColor(){
				jQueryscrollTop = jQuery(window).scrollTop();
				jQuerywindowHeight = jQuery(window).height();
				jQuerypageHeight = jQuery('body').height();
				jQueryfooterHeight = jQuery('#footer-outer').height();
				jQueryctaHeight = (jQuery('#call-to-action').length > 0) ? jQuery('#call-to-action').height() : 0;
				
				if( (jQueryscrollTop-35 + jQuerywindowHeight) >= (jQuerypageHeight - jQueryfooterHeight) && jQuery('#boxed').length == 0){
					jQuery('#to-top').addClass('dark');
				}
				
				else {
					jQuery('#to-top').removeClass('dark');
				}
			}
			
			//calc on scroll
			jQuery(window).scroll(calcToTopColor);
			
			//calc on resize
			jQuery(window).resize(calcToTopColor);

		}

		//scroll up event
		jQuery('#to-top, .gototop').click(function(){
			jQuery('body,html').stop().animate({
				scrollTop:0
			},800,'easeOutCubic')
			return false;
		});