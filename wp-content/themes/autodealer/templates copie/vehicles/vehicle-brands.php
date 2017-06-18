<?php
/**
 * The Template for displaying brands carousel
 *
 * @package ThemesDepot Framework
 */


?>


<div class="brand_list wrapper">
    
    <h3><?php _e('Our Popular Brands','framework');?> <a class="btn small white pullright" href="<?php the_field('all_brands_page','option');?>"><?php _e('Browse Vehicles By Brands','framework');?></a></h3>
        
        <?php 

            $terms = get_terms("vehicle_model",'hide_empty=0&parent=0&number=10');
             $count = count($terms);
             if ( $count > 0 ){
                 echo "<ul>";
                 foreach ( $terms as $term ) {

                    if(get_field('add_brand_image', 'vehicle_model_' . $term->term_id ) ) {

                    echo '<li><a href="'. get_term_link( $term ) . '"><img src="'.get_field('add_brand_image', 'vehicle_model_' . $term->term_id ) .'"/></a></li>';    

                    }

                 }
                 echo "</ul>";
             }
        ?>

</div>