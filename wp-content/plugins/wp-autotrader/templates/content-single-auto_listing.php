<?php global $auto_manager; ?>

<table class="sf-table striped_bordered">
	<tbody>
		<tr>
			<th><?php _e('Vehicle Title','auto_manager');?></th>
			<th><?php _e('Vehicle Price','auto_manager');?></th>
			<th><?php _e('Vehicle Type','auto_manager');?></th>
			<th><?php _e('Fuel Type','auto_manager');?></th>
			<th><?php _e('Transmission','auto_manager');?></th>
			<th><?php _e('Color','auto_manager');?></th>
			<th><?php _e('Status','auto_manager');?></th>
		</tr>
		<tr>
			<td><?php the_title();?></td>
			<td><?php the_field('price');?></td>
			<td><?php $terms = get_the_terms( $post->ID , 'vehicle_type' ); foreach( $terms as $term ) {  print $term->name;  unset($term); }?></td>
			<td><?php $terms = get_the_terms( $post->ID , 'vehicle_fuel_type' ); foreach( $terms as $term ) {  print $term->name;  unset($term); }?></td>
			<td><?php $terms = get_the_terms( $post->ID , 'vehicle_gearbox' ); foreach( $terms as $term ) {  print $term->name;  unset($term); }?></td>
			<td><?php $terms = get_the_terms( $post->ID , 'vehicle_color' ); foreach( $terms as $term ) {  print $term->name;  unset($term); }?></td>
			<td><?php $terms = get_the_terms( $post->ID , 'vehicle_status' ); foreach( $terms as $term ) {  print $term->name;  unset($term); }?></td>
		</tr>
	</tbody>
</table>

<h2 class="prev-title">
	<i class="icon-info-circled-1"></i> <?php _e( 'Vehicle Description', 'auto_manager' ); ?>
</h2>

<?php the_content();?>