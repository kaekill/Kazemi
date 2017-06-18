<div class="options_group show_if_auto_package">

	<?php woocommerce_wp_text_input( array( 'id' => '_auto_listing_limit', 'label' => __( 'Vehicle listing limit', auto_manager ), 'description' => __( 'The number of vehicles listings a user can post with this package. If more than 1, registration will be forced on checkout.', auto_manager ), 'value' => max( get_post_meta( $post_id, '_auto_listing_limit', true ), 1 ), 'placeholder' => 1, 'type' => 'number', 'desc_tip' => true, 'custom_attributes' => array(
		'min'   => '',
		'step' 	=> '1'
	) ) ); ?>

	<?php woocommerce_wp_text_input( array( 'id' => '_auto_listing_duration', 'label' => __( 'Vehicle listing duration', auto_manager ), 'description' => __( 'The number of days that the vehicle listing will be active.', auto_manager ), 'value' => get_post_meta( $post_id, '_auto_listing_duration', true ), 'placeholder' => get_option( 'auto_manager_submission_duration' ), 'desc_tip' => true, 'type' => 'number', 'custom_attributes' => array(
		'min'   => '',
		'step' 	=> '1'
	) ) ); ?>

	<?php woocommerce_wp_checkbox( array( 'id' => '_auto_listing_featured', 'label' => __( 'Feature auto listings?', auto_manager ), 'description' => __( 'Feature this vehicle listing - it will be styled differently and sticky.', auto_manager ), 'value' => get_post_meta( $post_id, '_auto_listing_featured', true ) ) ); ?>

	<script type="text/javascript">
		jQuery('.pricing').addClass( 'show_if_auto_package' );
	</script>

</div>