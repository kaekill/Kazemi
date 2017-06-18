<?php 
/**
 * ThemesDepot Shortcodes Plugin Filter Extensions
 * this file handles the extensions of the tdp shortcodes manager plugin
 *
 * @package ThemesDepot Framework
 */

/*-----------------------------------------------------------------------------------*/
/*	Filter the options of the plugin
/*-----------------------------------------------------------------------------------*/

function tdp_add_new_shortcodes($additional) {
	
	$additional = array(
	   'double_call_to_action' => 'Double Call To Action Area (Fullwidth)',
	   'latest_vehicles' => 'Latest Vehicles Carousel (fullwidth)',
	   'featured_vehicles' => 'Featured Vehicles Carousel (fullwidth)',
	   'vehicle_brands' => 'Browse Vehicles By Brands Logo (fullwidth)',
	   'vehicle_tabs' => 'Tabbed Vehicles List (Featured + New)',
	   'vehicle_types' => 'Vehicle Types List By Icon',
	   'tabbed_search' => 'Tabbed Search',
	   'vehicle_search' => 'Vehicle Search Form',
	);
	return $additional;

}
add_filter('tdp_shortcodes_filter_options','tdp_add_new_shortcodes');


/*-----------------------------------------------------------------------------------*/
/*	Double Call To Action Area
/*-----------------------------------------------------------------------------------*/

function tdp_shortcode_dcall( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'left_heading' => '',
		'left_subheading' => '',
		'left_url' => '',
        'left_label' => '',
        'right_heading' => '',
		'right_subheading' => '',
		'right_url' => '',
        'right_label' => ''
	), $atts ) );

	return '	<div class="double-call-to-action">
					
					<div class="one_half">
						<div class="to-action">
							<div class="to-inner-action">
								<h2>'.$left_heading.'</h2>
								<p>'.$left_subheading.'</p>
								<a href="'.$left_url.'">'.$left_label.'</a>
							</div>
						</div>
					</div>

					<div class="one_half last">
						<div class="to-action">
							<div class="to-inner-action">
								<h2>'.$right_heading.'</h2>
								<p>'.$right_subheading.'</p>
								<a href="'.$right_url.'">'.$right_label.'</a>
							</div>
						</div>
					</div>

					<div class="clearboth"></div>

				</div>


			';
}
add_shortcode('dcall', 'tdp_shortcode_dcall');


/*-----------------------------------------------------------------------------------*/
/*	Latest Vehicles Shortcode
/*-----------------------------------------------------------------------------------*/

function tdp_shortcode_latest_vehicles( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'overlay' => '',
		'use_bg' => '',
		'center' => '',
		'backgroundcolor' => '',
		'backgroundimage' => '',
		'backgroundrepeat' => 'no-repeat',
		'backgroundposition' => 'top left',
		'backgroundattachment' => 'scroll',
		'bordersize' => '1px',
		'bordercolor' => '',
		'paddingtop' => '20px',
		'paddingbottom' => '20px',
		'lighttext' => '',
	), $atts ) );

    $css = '';
	if($backgroundrepeat == 'no-repeat') {
		$css .= '-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;';
	}

	$bg_attribute = null;
	if($use_bg == 'yes') {
		$bg_attribute = 'background-color:'.$backgroundcolor.';';
	}

	$html = '<div class="tdp_row_fullwidth center-'.$center.' light-'.$lighttext.' use-color-'.$use_bg.'" style="'.$bg_attribute.'background-image:url('.$backgroundimage.');background-repeat:'.$backgroundrepeat.';background-position:'.$backgroundposition.';background-attachment:'.$backgroundattachment.';border-top:'.$bordersize.' solid '.$bordercolor.';border-bottom:'.$bordersize.' solid '.$bordercolor.';padding-top:'.$paddingtop.';padding-bottom:'.$paddingbottom.';'.$css.'">';
	if($overlay == 'yes') {
		$html .= '<div class="section-overlay" style="background-color:'.$backgroundcolor.'; margin-top:-'.$paddingtop.'"></div>';
	}
	$html .= '<div class="tdp-row wrapper">';
	ob_start();  
    get_template_part( 'templates/vehicles/vehicle', 'carousel' );
	$html .= ob_get_contents();  
    ob_end_clean();  

	$html .= '</div>';
	$html .= '</div><div class="clearboth"></div>';

	return $html;

	
}
add_shortcode('latest_vehicles_carousel', 'tdp_shortcode_latest_vehicles');

/*-----------------------------------------------------------------------------------*/
/*	Featured Vehicles Shortcode
/*-----------------------------------------------------------------------------------*/

function tdp_shortcode_featured_vehicles( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'overlay' => '',
		'use_bg' => '',
		'center' => '',
		'backgroundcolor' => '',
		'backgroundimage' => '',
		'backgroundrepeat' => 'no-repeat',
		'backgroundposition' => 'top left',
		'backgroundattachment' => 'scroll',
		'bordersize' => '1px',
		'bordercolor' => '',
		'paddingtop' => '20px',
		'paddingbottom' => '20px',
		'lighttext' => '',
	), $atts ) );

    $css = '';
	if($backgroundrepeat == 'no-repeat') {
		$css .= '-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;';
	}

	$bg_attribute = null;
	if($use_bg == 'yes') {
		$bg_attribute = 'background-color:'.$backgroundcolor.';';
	}

	$html = '<div class="tdp_row_fullwidth center-'.$center.' light-'.$lighttext.' use-color-'.$use_bg.'" style="'.$bg_attribute.'background-image:url('.$backgroundimage.');background-repeat:'.$backgroundrepeat.';background-position:'.$backgroundposition.';background-attachment:'.$backgroundattachment.';border-top:'.$bordersize.' solid '.$bordercolor.';border-bottom:'.$bordersize.' solid '.$bordercolor.';padding-top:'.$paddingtop.';padding-bottom:'.$paddingbottom.';'.$css.'">';
	if($overlay == 'yes') {
		$html .= '<div class="section-overlay" style="background-color:'.$backgroundcolor.'; margin-top:-'.$paddingtop.'"></div>';
	}
	$html .= '<div class="tdp-row wrapper">';
	ob_start();  
    get_template_part( 'templates/vehicles/vehicle', 'featuredcarousel' );
	$html .= ob_get_contents();  
    ob_end_clean();  

	$html .= '</div>';
	$html .= '</div><div class="clearboth"></div>';

	return $html;

	
}
add_shortcode('featured_vehicles_carousel', 'tdp_shortcode_featured_vehicles');


/*-----------------------------------------------------------------------------------*/
/*	Vehicles Brands Shortcode
/*-----------------------------------------------------------------------------------*/

		
function tdp_shortcode_vehicles_brands( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'none' => '',
	), $atts ) );

	ob_start();  
    get_template_part( 'templates/vehicles/vehicle', 'brands' );
	$html = ob_get_contents();  
    ob_end_clean();  

	return $html;

	
}
add_shortcode('vehicle_brands', 'tdp_shortcode_vehicles_brands');


/*-----------------------------------------------------------------------------------*/
/*	Tabbed Vehicles Shortcode
/*-----------------------------------------------------------------------------------*/

		
function tdp_shortcode_vehicles_tabs( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'amount' => '',
	), $atts ) );

	$html = '<div class="tabbed-vehicles-section">';

		$html .= '<script type="text/javascript">
					jQuery(function() {
				        jQuery( "#tabs-listing" ).tabs();
				    });

				</script>';

		$html .= '<div id="tabs-listing">';

			$html .= '<ul>';	
				  		$html .= '<li><a href="#tabs-1"><i class="icon-star"></i>'.__('Featured Vehicles','framework').'</a></li>';
				  		$html .= '<li><a href="#tabs-2"><i class="icon-list-1"></i>'.__('Latest Vehicles On Sale','framework').'</a></li>';
			$html .= '</ul>';

			$html .= '<div id="tabs-1" class="tab-cont">';
				  		
				ob_start();
					
					$args = array( 
    				'post_type' => 'vehicles', 
    				'posts_per_page' => $amount,
    				'post_status' => 'publish',
                    'meta_key' => 'set_vehicle_as_featured',
                    'meta_query' => array(
                           array(
                               'key' => 'set_vehicle_as_featured',
                               'value' => array(1),
                               'compare' => 'IN',
                           )
                       )
    				);

				    $query = new WP_Query( $args );

				  	if ( $query->have_posts() ) { ?>
			        
			            <?php while ( $query->have_posts() ) : $query->the_post(); 

			            $thumb = get_post_thumbnail_id();
               		 	$img_url = wp_get_attachment_url( $thumb,'full' );

			            ?>
			            	
			            	<div class="vehicle-post">
			            	<div class="one_fourth">
			            		<a href="<?php the_permalink();?>"><img src="<?php echo fImg::resize( $img_url, 300, 200, true ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/></a>
			            	</div>
			            	<div class="three_fourth last">
			            		<span class="vehicle-detail"><?php the_title();?></span> <a href="<?php the_permalink();?>" class="btn mini pull-right"><?php _e('Read More','framework');?></a>
			            		<ul class="grid-details">
									<?php if(get_field('mileage') && get_field('display_mileage_in_taxonomy_list','option')) { ?>
										<li class="tooltip" title="<?php _e('Vehicle Mileage','framework');?>"><i class="icon-gauge-1"></i> <?php the_field('mileage');?> <?php the_field('mileage_symbol','option');?></li>
									<?php } ?>
									<?php if(get_field('registration_year') && get_field('display_registration_year_in_taxonomy_list','option')) { ?>
										<li class="tooltip" title="<?php _e('Vehicle Registration Date','framework');?>"><i class="icon-calendar-1"></i> <?php the_field('registration_year');?> </li>
									<?php } ?>
									<li><span class="vehicle-detail"><?php tdp_vehicle_price(); ?></span></li>
								</ul>
			                </div>
			                <div class="clearboth"></div>
			                </div>

			            <?php endwhile;
			            wp_reset_postdata(); ?>
			    
			    	<?php }

			    	$html .= ob_get_clean();

			$html .= '</div>';

			$html .= '<div id="tabs-2" class="tab-cont">';

				ob_start();
					
					$args2 = array( 
    				'post_type' => 'vehicles', 
    				'posts_per_page' => $amount,
    				'post_status' => 'publish',
    				);

				    $query = new WP_Query( $args2 );

				  	if ( $query->have_posts() ) { ?>
			        
			            <?php while ( $query->have_posts() ) : $query->the_post(); 

			            $thumb = get_post_thumbnail_id();
               		 	$img_url = wp_get_attachment_url( $thumb,'full' );
			            
			            ?>
			            	
			            	<div class="vehicle-post">
			            	<div class="one_fourth">
			            		<a href="<?php the_permalink();?>"><img src="<?php echo fImg::resize( $img_url, 300, 200, true ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/></a>
			            	</div>
			            	<div class="three_fourth last">
			            		<span class="vehicle-detail"><?php the_title();?></span> <a href="<?php the_permalink();?>" class="btn mini pull-right"><?php _e('Read More','framework');?></a>
			            		<ul class="grid-details">
									<?php if(get_field('mileage') && get_field('display_mileage_in_taxonomy_list','option')) { ?>
										<li class="tooltip" title="<?php _e('Vehicle Mileage','framework');?>"><i class="icon-gauge-1"></i> <?php the_field('mileage');?> <?php the_field('mileage_symbol','option');?></li>
									<?php } ?>
									<?php if(get_field('registration_year') && get_field('display_registration_year_in_taxonomy_list','option')) { ?>
										<li class="tooltip" title="<?php _e('Vehicle Registration Date','framework');?>"><i class="icon-calendar-1"></i> <?php the_field('registration_year');?> </li>
									<?php } ?>
									<li><span class="vehicle-detail"><?php tdp_vehicle_price(); ?></span></li>
								</ul>
			                </div>
			                <div class="clearboth"></div>
			                </div>

			            <?php endwhile;
			            wp_reset_postdata(); ?>
			    
			    	<?php }

			    	$html .= ob_get_clean();
				  		
			$html .= '</div>';

		$html .= '</div>';

	$html .= '</div>';

	return $html;

	
}
add_shortcode('vehicle_tabs', 'tdp_shortcode_vehicles_tabs');

/*-----------------------------------------------------------------------------------*/
/*	Vehicles Type list Shortcode
/*-----------------------------------------------------------------------------------*/

function tdp_shortcode_vehicles_type( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'bg' => '',
	), $atts ) );

	ob_start(); ?>

	<div class="brand_list wrapper type_list">
    
	    <h3><?php _e('Browse Vehicles By Type','framework');?></h3>
	        
	        <?php 

	            $terms = get_terms("vehicle_type",'hide_empty=0&parent=0&number=10');
	             $count = count($terms);
	             if ( $count > 0 ){
	                 echo "<ul>";
	                 foreach ( $terms as $term ) {

	                    if(get_field('vehicle_type_icon', 'vehicle_type_' . $term->term_id ) ) {

	                    echo '<li><a href="'. get_term_link( $term ) . '"><img class="tooltip" title="'.$term->name.'" src="'.get_field('vehicle_type_icon', 'vehicle_type_' . $term->term_id ) .'"/></a></li>';    

	                    }

	                 }
	                 echo "</ul>";
	             }
	        ?>

	</div>

	<?php $html .= ob_get_clean();

	return $html;

	
}
add_shortcode('vehicle_types', 'tdp_shortcode_vehicles_type');

/*-----------------------------------------------------------------------------------*/
/*	Tabbed Search Shortcode
/*-----------------------------------------------------------------------------------*/

		
function tdp_shortcode_tabbed_search( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'tab1' => '',
		'tab2' => '',
	), $atts ) );

		$html = '<div class="tabbed-vehicles-search">';

			$html .= '<script type="text/javascript">
						jQuery(function() {
					        jQuery( ".tabs-listing" ).tabs();
					    });

					</script>';

			$html .= '<div class="tabs-listing">';

				$html .= '<ul>';	
					  		$html .= '<li><a href="#tabs-adv"><i class="icon-search"></i> '.$tab1.'</a></li>';
					  		$html .= '<li><a href="#tabs-type"><i class="icon-tags"></i> '.$tab2.'</a></li>';
				$html .= '</ul>';

				$html .= '<div id="tabs-type" class="tab-cont">';

					ob_start(); ?>

					<div class="brand_list type_list">
				    
					        
					        <?php 

					            $terms = get_terms("vehicle_type",'hide_empty=0&parent=0&number=10');
					             $count = count($terms);
					             if ( $count > 0 ){
					                 echo "<ul>";
					                 foreach ( $terms as $term ) {

					                    if(get_field('vehicle_type_icon', 'vehicle_type_' . $term->term_id ) ) {

					                    echo '<li><a href="'. get_term_link( $term ) . '"><img class="tooltip" title="'.$term->name.'" src="'.get_field('vehicle_type_icon', 'vehicle_type_' . $term->term_id ) .'"/></a></li>';    

					                    }

					                 }
					                 echo "</ul>";
					             }
					        ?>

					        <div class="clearboth"></div>

					</div>

					<?php $html .= ob_get_clean();

				$html .= '</div>';

				$html .= '<div id="tabs-adv" class="tab-cont">';

					ob_start();
					the_widget( 'TDP_Vehicle_Search', 'title=' );
					$html .= ob_get_clean();
							
				$html .= '</div>';
			
			$html .= '</div>';

		$html .= '</div>';

	return $html;

	
}
add_shortcode('tabbed_search', 'tdp_shortcode_tabbed_search');


/*-----------------------------------------------------------------------------------*/
/*	Vehicles search Shortcode
/*-----------------------------------------------------------------------------------*/

		
function tdp_shortcode_vehicles_search( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'' => '',
	), $atts ) );

	ob_start();
	echo '<div class="custom-search-form">';  
	the_widget( 'TDP_Vehicle_Search', 'title=' );
	echo "</div>";
	$html .= ob_get_contents();  
    ob_end_clean();  
	return $html;

	
}
add_shortcode('vehicle_search', 'tdp_shortcode_vehicles_search');
