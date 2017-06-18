<div id="step-wrapper">

		<ul>

			<li>
				<div class="step-number">1</div>
				<div class="step-title"><span><?php _e('Vehicle Details','auto_manager');?></span> <br/><?php _e('Fill In All The Required Details Here.','auto_manager');?></div>
			</li>
			<li>
				<div class="step-number">2</div>
				<div class="step-title"><span><?php _e('Review Details','auto_manager');?></span> <br/><?php _e('Review The Submitted Details Here.','auto_manager');?></div>
			</li>
			<li class="active-step">
				<div class="step-number">3</div>
				<div class="step-title"><span><?php _e('Submit Vehicle','auto_manager');?></span> <br/><?php _e('Vehicle Has Been Successfully Submitted.','auto_manager');?></div>
			</li>

		</ul>	
		<div class="clear"></div>
</div>

<div class="clear"></div>

<div class="success-wrapper">

	<i class="icon-check-1"></i>

	<div class="message-wrapper">
		<?php
		switch ( $auto->post_status ) :
			case 'publish' :
				printf( __( 'Vehicle Successfully Submitted. To View Your Listing <a href="%s">Click Here &raquo;</a>.', 'auto_manager' ), get_permalink( $auto->ID ) );
			break;
			case 'pending' :
				printf( __( 'Vehicle Successfully Submitted. Your Listing Will Be Visible Once Approved.', 'auto_manager' ), get_permalink( $auto->ID ) );
			break;
			default :
				do_action( 'auto_manager_auto_submitted_content_' . str_replace( '-', '_', sanitize_title( $auto->post_status ) ), $auto );
			break;
		endswitch;
		?>
	</div>

</div>