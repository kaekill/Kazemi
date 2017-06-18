<?php
/**
 * Auto Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;

global $auto_manager;

$registration_enabled = auto_manager_enable_registration();
$account_required     = auto_manager_user_requires_account();

?>

<script type="text/javascript">
		jQuery(function(){

			jQuery('#auto_type').change(function(){
				var jQuerymainCat=jQuery('#auto_type').val();
				jQuery('#status_loader').show();
				// call ajax
				jQuery("#auto_category").empty();
					jQuery.ajax({
						url:"<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",	   
						type:'POST',
						data:'action=tdp_search_ajax_call&main_catid=' + jQuerymainCat,
						success:function(results) {
						//  alert(results);
						jQuery('#status_loader').hide();
						jQuery("#auto_category").removeAttr("disabled");		
								jQuery("#auto_category").append(results);
								jQuery("#auto_category option[value='']").remove();
						}
					});
				}
			);
		});	
</script>


<?php if(isset($_POST['auto_category'])) : ?>

<script type="text/javascript">
		jQuery(function(){
				var jQuerymainCat="<?php echo $_POST['auto_type']; ?>";
				var autocategory = "<?php echo $_POST['auto_category']; ?>";
				jQuery('#status_loader').show();
				// call ajax
				jQuery("#auto_category").empty();
					jQuery.ajax({
						url:"<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",	   
						type:'POST',
						data:'action=tdp_search_ajax_call_submitted&auto_category='+ autocategory +'&main_catid=' + jQuerymainCat,
						success:function(results) {
						//  alert(results);
						jQuery('#status_loader').hide();
						jQuery("#auto_category").removeAttr("disabled");		
								jQuery("#auto_category").append(results);
						}
					});
		});	
</script>

<?php endif; ?>

<form action="<?php echo $action; ?>" method="post" id="submit-auto-form" class="auto-manager-form" enctype="multipart/form-data">

	<?php if ( apply_filters( 'submit_auto_form_show_signin', true ) ) : ?>

		<?php get_auto_manager_template( 'account-signin.php' ); ?>

	<?php endif; ?>

	<div id="step-wrapper">

		<ul>

			<li class="active-step">
				<div class="step-number">1</div>
				<div class="step-title"><span><?php _e('Vehicle Details','auto_manager');?></span> <br/><?php _e('Fill In All The Required Details Here.','auto_manager');?></div>
			</li>
			<li>
				<div class="step-number">2</div>
				<div class="step-title"><span><?php _e('Review Details','auto_manager');?></span> <br/><?php _e('Review The Submitted Details Here.','auto_manager');?></div>
			</li>
			<li>
				<div class="step-number">3</div>
				<div class="step-title"><span><?php _e('Submit Vehicle','auto_manager');?></span> <br/><?php _e('Vehicle Has Been Successfully Submitted.','auto_manager');?></div>
			</li>

		</ul>	
		<div class="clear"></div>
	</div>

	<div class="clear"></div>

	<?php if(is_user_logged_in()) { ?>

			<div class="alert-box info" id="account-info-message">
				<?php $user = wp_get_current_user();?>
				<div class="alert-content"><?php printf( __( 'You are currently signed in as <strong>%s</strong>.', 'auto_manager' ), $user->user_login ); ?> <a class="button" href="<?php echo apply_filters( 'submit_auto_form_logout_url', wp_logout_url( get_permalink() ) ); ?>"><?php _e( 'Sign out', 'auto_manager' ); ?> <i class="icon-off"></i></a></div>
			</div>

	<?php } else { echo '<br/>'; } ?>

	<?php if ( auto_manager_user_can_post_auto() ) : ?>	

	<div id="submission-form">

		<!-- Auto Information Fields -->
		<h3 class="form-title"><i class="icon-gauge-1"></i> <?php _e( 'Vehicle details', 'auto_manager' ); ?></h3>

		<div id="tabs-listing" class="additional-fields-details">
				  
			<ul>
				<li><a href="#tabs-1"><i class="icon-list-1"></i> <?php _e('Vehicle Details','auto_manager');?></a></li>
				<li><a href="#tabs-2"><i class="icon-list-1"></i> <?php _e('Additional Details','auto_manager');?></a></li>
				<li><a href="#tabs-3"><i class="icon-picture-1"></i> <?php _e('Images','auto_manager');?></a></li>
				<li><a href="#tabs-4"  class="add-border"><i class="icon-location"></i> <?php _e('Vehicle Address','auto_manager');?></a></li>
			</ul>

			<div id="tabs-1" class="tab-cont">
				<?php do_action( 'submit_auto_form_auto_fields_start' ); ?>

				<?php if ( $registration_enabled && !is_user_logged_in() ) : ?>
					<fieldset>
						<label><?php _e( 'Your email', 'auto_manager' ); ?> <?php if ( ! $account_required ) echo '<small>' . __( '(optional)', 'auto_manager' ) . '</small>'; ?></label>
						<div class="field">
							<input type="email" class="input-text" name="create_account_email" id="account_email" placeholder="you@yourdomain.com" value="<?php if ( ! empty( $_POST['create_account_email'] ) ) echo sanitize_text_field( stripslashes( $_POST['create_account_email'] ) ); ?>" />
						</div>
					</fieldset>
				<?php endif; ?>

				<?php foreach ( $auto_fields as $key => $field ) : ?>
					<fieldset class="fieldset-<?php esc_attr_e( $key ); ?>">
						<label for="<?php esc_attr_e( $key ); ?>"><?php echo $field['label'] . ( $field['required'] ? '' : ' <small>' . __( '(optional)', 'auto_manager' ) . '</small>' ); ?></label>
						<div class="field">
							<?php get_auto_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field, 'taxonomy' => $field['taxonomy']  ) ); ?>
						</div>
					</fieldset>
				<?php endforeach; ?>

				<?php do_action( 'submit_auto_form_auto_fields_end' ); ?>

				<?php do_action( 'submit_auto_form_additional_fields_start' ); ?>
			</div>

			<div id="tabs-2" class="tab-cont">
				<?php foreach ( $additional_fields as $key => $field ) : ?>
					<fieldset class="fieldset-<?php esc_attr_e( $key ); ?>">
						<label for="<?php esc_attr_e( $key ); ?>"><?php echo $field['label'] . ( $field['required'] ? '' : ' <small>' . __( '(optional)', 'auto_manager' ) . '</small>' ); ?></label>
						<div class="field">
							<?php get_auto_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
						</div>
					</fieldset>
				<?php endforeach; ?>
			</div>

			<div id="tabs-3" class="tab-cont">
				<?php foreach ( $media_fields as $key => $field ) : ?>
					<fieldset class="fieldset-<?php esc_attr_e( $key ); ?>">
						<label for="<?php esc_attr_e( $key ); ?>"><?php echo $field['label'] . ( $field['required'] ? '' : ' <small>' . __( '(optional)', 'auto_manager' ) . '</small>' ); ?></label>
						<div class="field">
							<?php get_auto_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
						</div>
					</fieldset>
				<?php endforeach; ?>
			</div>

			<div id="tabs-4" class="tab-cont">
				<?php foreach ( $other_fields as $key => $field ) : ?>
					<fieldset class="fieldset-<?php esc_attr_e( $key ); ?>">
						<label for="<?php esc_attr_e( $key ); ?>"><?php echo $field['label'] . ( $field['required'] ? '' : ' <small>' . __( '(optional)', 'auto_manager' ) . '</small>' ); ?></label>
						<div class="field">
							<?php get_auto_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
						</div>
					</fieldset>
				<?php endforeach; ?>
			</div>

			<div class="clear"></div>

		</div>
		<script type="text/javascript">
			jQuery(function() {
		        jQuery( "#tabs-listing" ).tabs({
		        	fx: { opacity: 'toggle', duration: 1000 },
					activate: function (event, ui) {
						displayMap();
					}
		        });  
		    });
		</script>
		<?php do_action( 'submit_auto_form_additional_fields_end' ); ?>

		<p>
			<?php wp_nonce_field( 'submit_form_posted' ); ?>
			<input type="hidden" name="auto_manager_form" value="<?php echo $form; ?>" />
			<input type="hidden" name="auto_id" value="<?php echo esc_attr( $auto_id ); ?>" />
			<input type="submit" name="submit_auto" class="button" value="<?php _e('Proceed With Submission &raquo;','auto_manager');?>" />
		</p>

	</div>

	<?php else : ?>

		<?php do_action( 'submit_auto_form_disabled' ); ?>

	<?php endif; ?>
</form>