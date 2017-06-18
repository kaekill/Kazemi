<?php
/**
 * ThemesDepot Framework search fields
 *
 * @package ThemesDepot Framework
 */

/*
 * Ajax Detect Selected Vechicle And Show Child
 */
function tdp_implement_ajax() {

	if(isset($_POST['main_catid'])) {

		$args = array(
				'taxonomy' => 'vehicle_model',
				'child_of' => $_POST['main_catid'],
				'hide_empty' => 0
		);

		$categories = get_categories($args);

			foreach ($categories as $cat) {

				//check if is edit vehicle page
				if(isset($_POST['auto_id'])) {

					if ( is_object_in_term( $_POST['auto_id'], 'vehicle_model', $cat->slug ) ) :
						echo $is_selected = 'selected="true"';
					else :
						echo $is_selected = null;
					endif;

				}

				$option .= '<option value="'.$cat->slug.'" '.$is_selected.'>';
				$option .= $cat->cat_name;
				$option .= ' ('.$cat->category_count.')';
				$option .= '</option>';

			}
			echo '<option value="" selected="selected">'.__('All Models','framework').'</option>'.$option;

			die();

		} // end if
}
add_action('wp_ajax_tdp_search_ajax_call', 'tdp_implement_ajax');
add_action('wp_ajax_nopriv_tdp_search_ajax_call', 'tdp_implement_ajax');//for users that are not logged in.

/*
 * Ajax Detect Selected Vechicle And Show Child
 */
function tdp_implement_ajax_submitted() {

	if(isset($_POST['main_catid'])) {

		$args = array(
				'taxonomy' => 'vehicle_model',
				'child_of' => $_POST['main_catid'],
				'hide_empty' => 0
		);

		$categories = get_categories($args);

			foreach ($categories as $cat) {

				//check if is edit vehicle page
				if(isset($_POST['auto_category'])) {

					if ( $cat->slug == $_POST['auto_category'] ) :
						echo $is_selected = 'selected="true"';
					else :
						echo $is_selected = null;
					endif;

				}

				$option .= '<option value="'.$cat->slug.'" '.$is_selected.'>';
				$option .= $cat->cat_name;
				$option .= ' ('.$cat->category_count.')';
				$option .= '</option>';

			}
			echo $option;

			die();

		} // end if
}
add_action('wp_ajax_tdp_search_ajax_call_submitted', 'tdp_implement_ajax_submitted');
add_action('wp_ajax_nopriv_tdp_search_ajax_call_submitted', 'tdp_implement_ajax_submitted');//for users that are not logged in.

/*
 * Ajax JS Detect Selected Vechicle And Show Child
 */
function tdp_search_ajax() { ?>

	<script type="text/javascript">

		jQuery(document).ready(function() {

			/*
			 * Reset submitted form on search results page
			 */
			jQuery("#main_cat option:selected").prop("selected", false);
			jQuery("#range_1").val("<?php the_field('minimum_value','option');?>;<?php the_field('maximum_value','option');?>");

			/*
			 * Price Filter
			 */
			jQuery("#range_1").ionRangeSlider({
	            min: <?php the_field('minimum_value','option');?>,
	            max: <?php the_field('maximum_value','option');?>,
	            from: <?php the_field('minimum_value','option');?>,
	            to: <?php the_field('maximum_value','option');?>,
	            type: 'double',
	            step: <?php the_field('step_value','option');?>,
	            prefix: "<?php the_field('currency_symbol','option');?>",
	            prettify: true,
	            hasGrid: true,
	            onChange: function (obj) {        // callback, is called on every change
		            var prices = jQuery("#range_1").val().split(";");
		            var maxprice = prices[1];
		            var minprice = prices[0];
		            jQuery("input[name=price_min]").val(minprice);
		            jQuery("input[name=price_max]").val(maxprice);
		        }
	        });

		});

		/*
		* Ajax Request to get vehicles
		*/
		jQuery(function(){
			jQuery('#main_cat').change(function(){
				jQuery('#status_loader').show();
				var jQuerymainCat=jQuery('#main_cat').val();
				// call ajax
				jQuery("#tax_vehicle_model").empty();
					jQuery.ajax({
						url:"<?php echo site_url(); ?>/wp-admin/admin-ajax.php",
						type:'POST',
						data:'action=tdp_search_ajax_call&main_catid=' + jQuerymainCat,
						success:function(results) {
						//  alert(results);
						jQuery('#status_loader').hide();

						jQuery('#tax_vehicle_model')
						    .find('option')
						    .remove()
						    .end()
						;

							jQuery("#tax_vehicle_model").removeAttr("disabled");
							jQuery("#tax_vehicle_model").append(results);
							if(jQuerymainCat == 'all') {
								jQuery("#tax_vehicle_model").attr('disabled', 'disabled');
								jQuery('#wp-advanced-search').off();
							}

						}
					});
				}
			);
		});
	</script>

<?php }

/*
 * Register search form fields
 */
if(!function_exists('tdp_search_fields')) {
    function tdp_search_fields() {

    	/*
		 * Generate Array of all main vehicle models
		 */
    	$args = array(
			'type'                     => 'vehicles',
			'child_of'                 => 0,
			'parent'                   => 0,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'exclude'                  => '',
			'include'                  => '',
			'number'                   => '',
			'taxonomy'                 => 'vehicle_model',
			'pad_counts'               => false

		);

		$default_option = array('any' => __('Any Manufacturer','framework'));

    	$output_categories = array();
		$categories=get_categories($args);
		  foreach($categories as $category) {
		     $output_categories[$category->cat_ID] = $category->name ;
		}

		$all_vehicles = $default_option + $output_categories;

    	/*
		 * Generate Fields For The Search Form
		 */
    	$args = array();

    	$args['form'] = array('action' => get_field('search_results_page','option'));

        $args['wp_query'] = array(
            'post_type' => 'vehicles',
            'posts_per_page' => get_field('results_per_page','option'),
            'order' => 'DESC',
            'orderby' => 'date'
        );

		$args['fields'][] = array(
            'type' => 'html',
            'value' => tdp_search_ajax()
        );

        $args['fields'][] = array(
              'type' => 'generic',
              'id' => 'main_cat',
              'label' => __('Constructeur:','framework') . '<i class="icon-help-circled-1 tooltip" title="'.__('Select A Manufacturer And Then Select A Model Below','framework').'"></i>',
              'format' => 'select',
              'default' => '',
              'values' => $all_vehicles,
        );

		$args['fields'][] = array(
              'type' => 'generic',
              'id' => 'tax_vehicle_model',
              'label' => __('Model:','framework') . '<i class="icon-help-circled-1 tooltip hide-on-change" title="'.__('Select A Manufacturer From Above First','framework').'"></i>',
              'format' => 'select',
              'default' => '',
              'values' => array('' => __('Constructeur','framework')),
        );

		//verify the field is enabled
        if(get_field('display_price_filter','option')) {

	        $args['fields'][] = array(
	            'type' => 'generic',
	            'label' => __('Filtre des prix','framework') . '<i class="icon-help-circled-1 tooltip hide-on-change" title="'.__('Display Vehicles Between The Selected Range','framework').'"></i>',
	            'id' => 'range_1',
	            'format' => 'text',
	        );

    	}

        $args['fields'][] = array(
        	'type' => 'taxonomy',
        	'format' => 'select',
        	'label' => __('Type:','framework'),
        	'operator' => 'IN',
        	'taxonomy' => 'vehicle_type',
        	"allow_null" => __('Any','framework')
        );

        $args['fields'][] = array(
        	'type' => 'taxonomy',
        	'format' => 'select',
        	'label' => __('Statut','framework'),
        	'operator' => 'IN',
        	'taxonomy' => 'vehicle_status',
        	"allow_null" => __('Any','framework')
        );

		//verify the field is enabled
        if(get_field('display_price_filter','option')) {

	        $args['fields'][] = array(
	             'type' => 'generic',
	             'id' => 'price_min',
	             'format' => 'hidden',
	        );

	        $args['fields'][] = array(
	             'type' => 'generic',
	             'id' => 'price_max',
	             'format' => 'hidden',
	        );

    	}

        $args['fields'][] = array(
            'type' => 'submit',
            'value' => __('Filtre Vehicules &raquo;','framework')
        );

        return $args;

    }
}

/*
 * Register homepage search form fields
 */
if(!function_exists('tdp_homepage_search_fields')) {
    function tdp_homepage_search_fields() {

    	/*
		 * Generate Array of all main vehicle models
		 */
    	$args = array(
			'type'                     => 'vehicles',
			'child_of'                 => 0,
			'parent'                   => 0,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'exclude'                  => '',
			'include'                  => '',
			'number'                   => '',
			'taxonomy'                 => 'vehicle_model',
			'pad_counts'               => false

		);

		$default_option = array('-1' => __('Select a Maker &raquo;','framework'));

    	$output_categories = array();
		$categories=get_categories($args);
		  foreach($categories as $category) {
		     $output_categories[$category->cat_ID] = $category->name ;
		}

		$all_vehicles = $default_option + $output_categories;

    	/*
		 * Generate Fields For The Search Form
		 */
    	$args = array();
        $args['form'] = array('action' => get_field('search_results_page','option'));

        $args['wp_query'] = array(
            'post_type' => 'vehicles',
            'posts_per_page' => get_field('results_per_page','option'),
            'order' => 'DESC',
            'orderby' => 'date'
        );

		$args['fields'][] = array(
            'type' => 'html',
            'value' => tdp_search_ajax()
        );

        $args['fields'][] = array(
              'type' => 'generic',
              'id' => 'main_cat',
              'label' => __('Select A Maker:','framework') . '<i class="icon-help-circled-1 tooltip" title="'.__('Select A Brand And Then Select A Model Below','framework').'"></i>',
              'format' => 'select',
              'default' => '',
              'values' => $all_vehicles,
        );

		$args['fields'][] = array(
              'type' => 'generic',
              'id' => 'tax_vehicle_model',
              'label' => __('Selectionner un model:','framework') . '<i class="icon-help-circled-1 tooltip hide-on-change" title="'.__('Select A Brand From Above First','framework').'"></i>',
              'format' => 'select',
              'default' => '',
              'values' => array('' => __('Select A Maker First','framework')),
        );


	        $args['fields'][] = array(
	            'type' => 'generic',
	            'label' => __('Price Filter','framework') . '<i class="icon-help-circled-1 tooltip hide-on-change" title="'.__('Display Vehicles Between The Selected Range','framework').'"></i>',
	            'id' => 'range_1',
	            'format' => 'text',
	        );


		//verify the field is enabled
        if(get_field('display_price_filter','option')) {

	        $args['fields'][] = array(
	             'type' => 'generic',
	             'id' => 'price_min',
	             'format' => 'hidden',
	        );

	        $args['fields'][] = array(
	             'type' => 'generic',
	             'id' => 'price_max',
	             'format' => 'hidden',
	        );

    	}

        $args['fields'][] = array(
            'type' => 'submit',
            'value' => __('Recherche Avancée &raquo;','framework')
        );

        return $args;

    }
}
