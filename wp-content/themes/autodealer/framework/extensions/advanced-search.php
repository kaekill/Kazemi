<?php
/**
 * ThemesDepot Framework advanced search fields
 * this is the file that handles the advanced search form.
 *
 * @package ThemesDepot Framework
 */

/* 
 * Ajax Detect Selected Vechicle And Show Child
 */
function tdp_adv_implement_ajax() {
  
  if(isset($_POST['adv_main_catid'])) {

    $args = array( 
        'taxonomy' => 'vehicle_model',
        'child_of' => $_POST['adv_main_catid'],
        'hide_empty' => 1
        );
    
    $categories = get_categories($args); 
    
      foreach ($categories as $cat) {
        

        $option .= '<option value="'.$cat->slug.'">';
        $option .= $cat->cat_name;
        $option .= ' ('.$cat->category_count.')';
        $option .= '</option>';

      }
      echo '<option value="" selected="selected">'.__('Select A Model','framework').'</option>'.$option;

      die();

    } // end if
}
add_action('wp_ajax_tdp_adv_search_ajax_call', 'tdp_adv_implement_ajax');
add_action('wp_ajax_nopriv_tdp_adv_search_ajax_call', 'tdp_adv_implement_ajax');//for users that are not logged in.

/* 
 * Ajax JS Detect Selected Vechicle And Show Child
 */
function tdp_adv_search_ajax() { ?>
  
  <script type="text/javascript">

    jQuery(document).ready(function() {

      jQuery( "#display-advanced-form" ).click(function() {

        jQuery("#adv-form").slideToggle( function() {
            jQuery("#adv_range_1, #adv_range_2").ionRangeSlider("update");
        });

      });

      /* 
       * Reset submitted form on search results page
       */
      jQuery("#adv_main_cat option:selected").prop("selected", false);

      jQuery("#adv_range_1").val("<?php the_field('minimum_value','option');?>;<?php the_field('maximum_value','option');?>");
      jQuery("#adv_range_2").val("<?php the_field('mileage_minimum_value','option');?>;<?php the_field('mileage_maximum_value','option');?>");

      /* 
       * Price Filter
       */ 
      jQuery("#adv_range_1").ionRangeSlider({
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
                var prices = jQuery("#adv_range_1").val().split(";");
                var maxprice = prices[1];
                var minprice = prices[0];
                jQuery("input[name=adv_price_min]").val(minprice);
                jQuery("input[name=adv_price_max]").val(maxprice);
            }
      });

      /* 
       * Mileage Filter
       */ 
      jQuery("#adv_range_2").ionRangeSlider({
              min: <?php the_field('mileage_minimum_value','option');?>,
              max: <?php the_field('mileage_maximum_value','option');?>,
              from: <?php the_field('mileage_minimum_value','option');?>,
              to: <?php the_field('mileage_maximum_value','option');?>,
              type: 'double',
              step: <?php the_field('mileage_step_value','option');?>,
              prefix: "<?php the_field('mileage_symbol','option');?> ",
              prettify: true,
              hasGrid: true,
              onChange: function (obj) {        // callback, is called on every change
                var mileage = jQuery("#adv_range_2").val().split(";");
                var mil_max = mileage[1];
                var mil_min = mileage[0];
                jQuery("input[name=adv_mil_min]").val(mil_min).currency({hidePrefix: true,hidePostfix: true});
                jQuery("input[name=adv_mil_max]").val(mil_max).currency({hidePrefix: true,hidePostfix: true});
            }
      });

    });

    /* 
    * Ajax Request to get vehicles
    */
    jQuery(function(){
      jQuery('#adv_main_cat').change(function(){
        var jQueryadvmainCat=jQuery('#adv_main_cat').val();
        // call ajax
        jQuery("#adv_tax_vehicle_model").empty();
          jQuery.ajax({
            url:"<?php echo site_url(); ?>/wp-admin/admin-ajax.php",     
            type:'POST',
            data:'action=tdp_adv_search_ajax_call&adv_main_catid=' + jQueryadvmainCat,
            success:function(results) {
            //  alert(results);

            jQuery('#adv_tax_vehicle_model')
                .find('option')
                .remove()
                .end()
            ;

            jQuery("#adv_tax_vehicle_model").removeAttr("disabled");    
                jQuery("#adv_tax_vehicle_model").append(results);
            }
          });
        }
      );
    });                     
  </script>

<?php }

/* 
 * Register Advanced Search form fields
 */
if(!function_exists('tdp_advanced_search_fields')) {
    function tdp_advanced_search_fields() {

      /* 
       * Generate Array of all main vehicle models
       */
      $args = array(
        'type'          => 'vehicles',
        'child_of'      => 0,
        'parent'        => 0,
        'orderby'       => 'name',
        'order'         => 'ASC',
        'hide_empty'    => 1,
        'hierarchical'  => 1,
        'exclude'       => '',
        'include'       => '',
        'number'        => '',
        'taxonomy'      => 'vehicle_model',
        'pad_counts'    => false 
      );

      $default_option = array('-1' => __('Select a Manufacturer &raquo;','framework'));

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
      $args['form'] = array(
        'action' => get_field('search_results_page','option'),
        'id' => 'adv-vehicle-search',
        'name' => 'adv-vehicle-search',
        'class' => 'adv-vehicle-search'
      );
        
      $args['wp_query'] = array(
        'post_type' => 'vehicles',
        'posts_per_page' => get_field('results_per_page','option'),
        'order' => 'DESC',
        'orderby' => 'date'
      );

      // this will tell the query on the search results page to switch itself and display advanced query
      $args['fields'][] = array(
        'type' => 'generic',
        'id' => 'advanced_form',
        'format' => 'hidden',
        'default' => 'yes',
        'values' => array('yes' => 'yes'),
      );

      $args['fields'][] = array(
        'type' => 'html',
        'value' => tdp_adv_search_ajax()
      );


      $args['fields'][] = array(
        'type' => 'generic',
        'id' => 'adv_main_cat',
        'label' => __('Select A Manufacturer:','framework') . '<i class="icon-help-circled-1 tooltip" title="'.__('Select A Manufacturer And Then Select A Model','framework').'"></i>',
        'format' => 'select',
        'default' => '',
        'values' => $all_vehicles,
      );


      $args['fields'][] = array(
        'type' => 'generic',
        'id' => 'adv_tax_vehicle_model',
        'label' => __('Select Model:','framework') . '<i class="icon-help-circled-1 tooltip hide-on-change" title="'.__('Select A Manufacturer First','framework').'"></i>',
        'format' => 'select',
        'default' => '',
        'values' => array('' => __('Select A Manufacturer First','framework')),
      );

      $args['fields'][] = array(
        'type' => 'taxonomy', 
        'format' => 'select',
        'label' => __('How Many Years Old:','framework'),
        'taxonomy' => 'vehicle_year',
        'operator' => 'IN',
      );

      $args['fields'][] = array(
        'type' => 'taxonomy', 
        'format' => 'select',
        'label' => __('Vehicle Type:','framework'),
        'operator' => 'IN',
        'taxonomy' => 'vehicle_type'
      );

      $args['fields'][] = array(
        'type' => 'taxonomy', 
        'format' => 'select',
        'label' => __('Vehicle Status:','framework'),
        'operator' => 'IN',
        'taxonomy' => 'vehicle_status'
      );

      $args['fields'][] = array(
        'type' => 'taxonomy', 
        'format' => 'select',
        'label' => __('Vehicle Color:','framework'),
        'operator' => 'IN',
        'taxonomy' => 'vehicle_color'
      );

      $args['fields'][] = array(
        'type' => 'taxonomy', 
        'format' => 'select',
        'label' => __('Fuel Type:','framework'),
        'operator' => 'IN',
        'taxonomy' => 'vehicle_fuel_type'
      );

      $args['fields'][] = array(
        'type' => 'taxonomy', 
        'format' => 'select',
        'label' => __('Gear Type:','framework'),
        'operator' => 'IN',
        'taxonomy' => 'vehicle_gearbox'
      );

      $args['fields'][] = array(
        'type' => 'taxonomy', 
        'format' => 'select',
        'label' => __('Vehicle Location:','framework'),
        'operator' => 'IN',
        'taxonomy' => 'vehicle_location'
      );


      $args['fields'][] = array(
        'type' => 'generic',
        'label' => __('Price Filter','framework') . '<i class="icon-help-circled-1 tooltip hide-on-change" title="'.__('Display Vehicles Between The Selected Range','framework').'"></i>',
        'id' => 'adv_range_1',
        'format' => 'text',
      );

      $args['fields'][] = array(
        'type' => 'generic',
        'id' => 'adv_price_min',
        'format' => 'hidden',
      );

      $args['fields'][] = array(
        'type' => 'generic',
        'id' => 'adv_price_max',
        'format' => 'hidden',
      );

      $args['fields'][] = array(
        'type' => 'generic',
        'label' => __('Mileage Filter','framework') . '<i class="icon-help-circled-1 tooltip hide-on-change" title="'.__('Display Vehicles Between The Selected Range','framework').'"></i>',
        'id' => 'adv_range_2',
        'format' => 'text',
      );

      $args['fields'][] = array(
        'type' => 'generic',
        'id' => 'adv_mil_min',
        'format' => 'hidden',
      );

      $args['fields'][] = array(
        'type' => 'generic',
        'id' => 'adv_mil_max',
        'format' => 'hidden',
      );

      $args['fields'][] = array(
        'type' => 'html',
        'value' => '<div class="clear"></div>'
      );



      $args['fields'][] = array(
            'type' => 'submit',
            'value' => __('Filter Vehicles &raquo;','framework')
      );

      return $args;


    }
}