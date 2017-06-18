<?php if($taxonomy) {

	$field_type = esc_attr( $key );

	$term_list = wp_get_post_terms($_GET['auto_id'], 'vehicle_model', array("fields" => "ids"));
	$vehicle_main_model = $term_list[1];
	$vehicle_child_model = $term_list[0];

	$compare_with = null;
	if($field_type == 'auto_type') {
		$compare_with = $vehicle_main_model;
	} elseif($field_type == 'auto_category') {
		$compare_with = $vehicle_child_model;
	}

}?>
<select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>">
	<?php foreach ( $field['options'] as $key => $value ) : ?>
		<option value="<?php echo esc_attr( $key ); ?>" <?php if ( isset( $field['value'] ) ) selected( $field['value'], $key ); ?> <?php if($compare_with == $key) { echo 'selected="true"'; } ?>><?php echo esc_html( $value ); ?></option>
	<?php endforeach; ?>
</select>

