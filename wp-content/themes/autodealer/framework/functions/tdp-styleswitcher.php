<?php
	/**
	 * Required: TDP Style Switcher
	 */

	if(get_field('enable_front_end_demo_style_switcher','option')) {
		add_action('wp_footer', 'tdp_style_switcher');
		add_action('wp_enqueue_scripts', 'tdp_style_switcher_scripts');
	}

	function tdp_style_switcher_scripts() {
		wp_enqueue_style('tdp-demo-preview-css', get_template_directory_uri() . '/css/preview.css' );
		wp_enqueue_script( 'tdp-demo-colorpicker', get_template_directory_uri() . '/js/preview.js', false, false, true);
	}


	function tdp_style_switcher() {
		
		$styleswitcher_path = get_template_directory_uri() . '/framework/functions/tdp-styleswitcher/';
	
	?>
		
		<div class="style-switcher">
			
			<h4>Style Switcher<a class="switch-button"><i class="icon-cog-alt"></i></a></h4>
			
			<div class="switch-cont">
				
				<p>Please note that these are only sample options. The actual theme options panel has 50 options to modify every single color of the theme.</p>
				
				<h5>Primary Colors</h5>
				<ul class="options color-select">
					<li><a href="#" data-color="00bff3" style="background-color: #00bff3;"></a></li>
					<li><a href="#" data-color="ff7534" style="background-color: #ff7534;"></a></li>
					<li><a href="#" data-color="7c4d9f" style="background-color: #7c4d9f;"></a></li>
					<li><a href="#" data-color="37ba85" style="background-color: #37ba85;"></a></li>
					<li><a href="#" data-color="fe504f" style="background-color: #fe504f;"></a></li>
					<li><a href="#" data-color="ffd56c" style="background-color: #ffd56c;"></a></li>
					<li><a href="#" data-color="fff" style="background-color: #fff;"></a></li>
				</ul>

				<h5>Secondary Colors</h5>
				<ul class="options color-select2">
					<li><a href="#" data-color="00bff3" style="background-color: #00bff3;"></a></li>
					<li><a href="#" data-color="ff7534" style="background-color: #ff7534;"></a></li>
					<li><a href="#" data-color="7c4d9f" style="background-color: #7c4d9f;"></a></li>
					<li><a href="#" data-color="37ba85" style="background-color: #37ba85;"></a></li>
					<li><a href="#" data-color="fe504f" style="background-color: #fe504f;"></a></li>
					<li><a href="#" data-color="ffd56c" style="background-color: #ffd56c;"></a></li>
					<li><a href="#" data-color="fff" style="background-color: #fff;"></a></li>
				</ul>
				
				<h5>Header Basic Colors</h5>
				<div id="colorselector1" class="color-select-pick"><div style="background-color: #16181A;"></div></div>

				<ul class="options">
				</ul>

				<a class="many-more" href="http://demo.themesdepot.org/autodealer/features">View all options &rarr;</a>

			</div>

		</div>
		
		<script>
			var onLoad = {
			    init: function(){
			    
				    "use strict";
							
					jQuery('.style-switcher').on('click', 'a.switch-button', function(e) {
						e.preventDefault();
						var $style_switcher = jQuery('.style-switcher');
						if ($style_switcher.css('left') === '0px') {
							$style_switcher.animate({
								left: '-240'
							});
						} else {
							$style_switcher.animate({
								left: '0'
							});
						}
					});
				
					
					jQuery('.color-select li').on('click', 'a', function(e) {
						e.preventDefault();
						
						var selectedColor = '#' + jQuery(this).data('color');
						
						jQuery('a,.primary-color,.user-menu-link:hover i,.user-menu-link:hover span,.post-title a:hover,.finder-vehicle .price,.finder-vehicle .vehicle-mileage,.vehicle-features li i,.to-inner-action a:hover,.single-desc h3 a,.vehicle-price,.vehicle-position,.vehicle-details span,ul.grid-details').css('color', selectedColor);
						jQuery('.primary-bg,.white-popup h3.popup-title,.post-link,#to-top:hover,#to-top.dark:hover,.new-badge,.irs-diapason,.form-intro-title,.to-inner-action a,.sf-menu li ul li a:hover, .sf-menu li ul li.sfHover > a,#page-top,.badge-format,.user-module li ul li a:hover,div.fancy-select ul.options li.selected,.share-menu li ul li a:hover,.irs-diapason, .irs-from, .irs-to, .irs-single,.active-step .step-number,.widget_tdp_dealer_profile .widget-title').css('background-color', selectedColor);
						jQuery('.irs-from:after, .irs-to:after, .irs-single:after,#profile-socials li a,.to-inner-action a:hover').css('border-color', selectedColor);

					});

					jQuery('.color-select2 li').on('click', 'a', function(e) {
						e.preventDefault();
						
						var selectedColor2 = '#' + jQuery(this).data('color');
						
						jQuery('.secondary-bg,.internal .big-button,.user-module .avatar,.sf-menu > li a:after, #navigation-wrapper .sfHover > a:after,.footer-border').css('background',selectedColor2);
						jQuery('#top-bar a i, li.current-menu-item a, footer a, footer a:hover, .internal .big-button:hover').css('color',selectedColor2);
						jQuery('footer .widget-title span,.internal .big-button:hover').css('border-color',selectedColor2);


					});

					jQuery('#colorselector1').ColorPicker({
				        color: '#EFEFEF',
				        onShow: function (colpkr) {
				            jQuery(colpkr).fadeIn(500);
				            return false;
				        },
				        onHide: function (colpkr) {
				            jQuery(colpkr).fadeOut(500);
				            return false;
				        },
				        onChange: function (hsb, hex, rgb) {

				            jQuery('header').css('background', '#' + hex);
				        }
				    });

			    },
			   
			};
			
			jQuery(document).ready(onLoad.init);
		</script>
	
	<?php }
	
?>