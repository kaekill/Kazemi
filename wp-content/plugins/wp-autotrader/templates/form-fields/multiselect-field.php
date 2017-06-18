<select multiple="multiple" name="<?php echo esc_attr( isset( $field['name'] ) ? $field['name'] : $key ); ?>[]" id="<?php echo esc_attr( $key ); ?>">
	<?php foreach ( $field['options'] as $key => $value ) : ?>
		<?php if( has_term( $key, $taxonomy , $_GET['auto_id'] ) ) {
			$is_selected = 'selected="true"';
		} else {
			$is_selected = null;
		} 
		?>
		<option value="<?php echo esc_attr( $key ); ?>" <?php echo $is_selected; ?> ><?php echo esc_html( $value ); ?></option>
	<?php endforeach; ?>
</select>
