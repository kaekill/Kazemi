<?php
/**
 * Vehicle Map Display
 */

/**
 * Load vehicle filter
 */
get_template_part( 'templates/vehicles/vehicle', 'filter' );
$clear_row = null;

?>

<script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery('#map_canvas').gmap3({
                            map:{
                            	address: "<?php the_field('map_center_point','option');?>",
                                options:{
                                    zoom: 10
                                }
                            },
                            marker:{
                                values:[
//                                    {latLng:[48.8620722, 2.352047], data:"Paris !"},
									<?php while ( have_posts() ) : the_post(); $clear_row_end++; $address = get_field('vehicle_position'); if($address) { 

                                        if(get_field('set_vehicle_as_featured')) {
                                            $marker = get_field('featured_vehicle_marker','option');
                                        } else {
                                            $marker = get_field('marker_custom_image','option');
                                        }

                                    ?>
										{address:"<?php echo $address['address'];?>", data:"<?php the_title();?> <a class='pop-title hide-me' href='<?php the_permalink();?>'><?php _e('View Details &raquo;','framework');?></a>", options:{ icon: '<?php echo $marker;?>' }, tag : "<?php echo $clear_row_end;?>"},
									<?php } endwhile; ?>
                                ],
                                options:{
                                    draggable: false
                                },
                                events:{
                                    mouseover: function(marker, event, context){
                                        var map = jQuery(this).gmap3("get"),
                                                infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
                                        //marker.setIcon("img/orange-marker.png");
                                        if (infowindow){
                                            infowindow.open(map, marker);
                                            infowindow.setContent(context.data);
                                        } else {
                                            jQuery(this).gmap3({
                                                infowindow:{
                                                    anchor:marker,
                                                    options:{content: context.data}
                                                }
                                            });
                                        }
                                    },
                                    mouseout: function(marker){
                                        var infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
                                        //marker.setIcon("img/blue-marker.png");
                                        if (infowindow){
                                            infowindow.close();
                                        }
                                    }
                                }
                            }
                },
                "autofit" );
            });
</script>

<div class="location-finder">

	<div class="one_third">

		<?php while ( have_posts() ) : the_post(); $clear_row++; $address = get_field('vehicle_position'); if($address) { ?>
			
			<article class="finder-vehicle <?php if(get_field('set_vehicle_as_featured')) { ?>featured-bg<?php } ?>" rel="<?php echo $clear_row;?>">
            	
            	<figure>
                	<?php 
					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
					$image = aq_resize( $img_url, 300, 300, false ); //resize & crop the image
					?>
					<img src="<?php echo $image ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="entry-image media-wrapper">                   
           		</figure>
            	
	            <div class="text">
		            <h3><?php the_title();?></h3>
	            </div>
	            <div class="clear"></div>
	            <span class="price"><?php tdp_vehicle_price(); ?></span>

	            <?php if(get_field('mileage') && get_field('display_mileage_in_taxonomy_list','option')) { ?>

				<span class="vehicle-mileage tooltip" title="<?php _e('Vehicle Mileage','framework');?>"><i class="icon-gauge-1"></i> <?php the_field('mileage');?> <?php the_field('mileage_symbol','option');?></span>

				<?php } ?>
				<div class="clear"></div>
				<a class='btn white mini pop-title' href='<?php the_permalink();?>'><?php _e('View Details &raquo;','framework');?></a>

            </article>

		<?php } endwhile; ?>

	</div><!-- end left side -->

	<div class="two_third last">
        <div id="map_canvas"></div>
    </div>

</div><!-- end location finder -->

