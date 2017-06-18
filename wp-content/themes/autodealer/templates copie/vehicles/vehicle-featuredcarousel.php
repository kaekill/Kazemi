<?php
/**
 * The Template for displaying vehicle featured carousel
 *
 * @package ThemesDepot Framework
 */

$has_overlay = get_field("set_background_image_overlay_color","option");

?>

<div class="latest_offers">

    <?php if($has_overlay) { ?>

        <div class="overlay"></div>

    <?php } ?>
    
    <div class="wrapper">
        <h3><?php _e('Featured Vehicles On Sale','framework');?></h3>

        <?php if(get_field('display_signup_message','option')) { ?>

        	<span class="signup-message">
        		<a href="<?php echo get_field('submit_page','option'); ?>" class="btn white small"><?php _e('Sign Up Now And Submit Your Car &raquo;','framework');?></a>
        	</span>

        <?php } ?>

    </div>
    <div class="clear"></div>

    <div class="caroufredsel_wrapper carousel-wrapper">

    	<div id="latest_offers2">

    		<?php 

    			$args = array( 
    				'post_type' => 'vehicles', 
    				'posts_per_page' => get_field('limit_items_in_carousel','option'),
                    'meta_key' => 'set_vehicle_as_featured',
                    'post_status' => 'publish',
                    'meta_query' => array(
                           array(
                               'key' => 'set_vehicle_as_featured',
                               'value' => array(1),
                               'compare' => 'IN',
                           )
                       )
    				);
				
				$latest_vehicles_loop = new WP_Query( $args );
				
				while ( $latest_vehicles_loop->have_posts() ) : $latest_vehicles_loop->the_post(); 

                $thumb = get_post_thumbnail_id();
                $img_url = wp_get_attachment_url( $thumb,'full' );

			?>
                    
            <div class="latest_item post-img">
                <a href="<?php the_permalink();?>" hidefocus="true" ><img src="<?php echo fImg::resize( $img_url, 565, 355, true ); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"></a>
                <a href="<?php the_permalink();?>" hidefocus="true" ><?php the_title();?></a>
                <div class="latest-info">
                	<span class="item-date"><?php echo get_the_date('j F Y'); ?> /</span>
                	<span class="item-views"><a href="<?php the_permalink();?>"><?php _e('Read More','framework');?></a></span>
                </div>

            </div>

            <?php endwhile; ?>

        </div>

    </div><!-- /#latest_offers -->

    <a class="prev" id="latest_offers_prev2" class="latest_offers_prev" href="#" hidefocus="true"><i class="icon-left-open-big"></i></a>
    <a class="next" id="latest_offers_next2" class="latest_offers_next" href="#" hidefocus="true"><i class="icon-right-open-big"></i></a>
    <script>
        jQuery(document).ready(function() {
            var screenRes = jQuery('#theme-wrapper').width();
            function carosel_start(){
                jQuery('#latest_offers2').carouFredSel({
                    prev : "#latest_offers_prev2",
                    next : "#latest_offers_next2",
                    infinite: false,
                    circular: true,
                    auto: false,
                    width: '100%',
                    scroll: {
                        items : 1,
                        onBefore: function (data) {
                            if (screenRes > 900) {
                                if(data.scroll.direction == "prev"){
                                    data.items.visible.eq(0).animate({opacity: 0.15},0);
                                    data.items.visible.eq(-1).animate({opacity: 0.15},300);
                                    data.items.old.eq(0).animate({opacity: 1},100);
                                }else{
                                    data.items.visible.eq(-1).animate({opacity: 0.15},0);
                                    data.items.visible.eq(0).animate({opacity: 0.15},300);
                                    data.items.old.eq(-1).animate({opacity: 1},100);
                                }
                            }
                        }
                    }
                });
                if (screenRes > 900) {
                    var vis_items = jQuery("#latest_offers2").triggerHandler("currentVisible");
                    vis_items.eq(-1).animate({opacity: 0.15},100);
                    vis_items.eq(0).animate({opacity: 0.15},100);
                }
            }
            carosel_start();
            jQuery(window).resize(function() {
                carosel_start();
            });
        });
    </script>
</div>