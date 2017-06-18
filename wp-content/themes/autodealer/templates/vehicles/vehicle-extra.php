<?php
/**
 * The Template for displaying vehicle features
 *
 * @package ThemesDepot Framework
 */

?>

<div class="one_half">

	<h4><?php _e('Safety Features','framework');?></h4>

	<ul class="vehicle-features">
	<?php 
		$terms = get_the_terms( $post->ID , 'vehicle_safety_feature' ); 
		if($terms) {
			foreach( $terms as $term ) {  
				print '<li><i class="icon-ok"></i> ' . $term->name . '</li>';  
				unset($term); 
			}
		}
	?>
	</ul>

</div>

<div class="one_half last">

	<h4><?php _e('Extra Features','framework');?></h4>

	<ul class="vehicle-features">
	<?php 
		$terms = get_the_terms( $post->ID , 'vehicle_extra' ); 
		if($terms) {
			foreach( $terms as $term ) {  
					print '<li><i class="icon-ok"></i> ' . $term->name . '</li>';
					unset($term); 
			}
		}
	?>
	</ul>

</div>