<?php if ( is_user_logged_in() ) : ?>

<?php else :

	$account_required     = auto_manager_user_requires_account();
	$registration_enabled = auto_manager_enable_registration();

	?>
	<fieldset class="form-warning">
		
		<div class="field account-sign-in">
			
			<div class="account-icon">

				<i class="icon-user-1"></i>

			</div>

			<div class="account-info">

				<h4><?php _e( 'Have an account?', 'auto_manager' ); ?> <a href="#login-box" id="open-login" class="login wpml-btn login-window"><?php _e( 'Sign in', 'auto_manager' ); ?> <i class="icon-login-1"></i> </a></h4>

				<?php if ( $registration_enabled ) : ?>

					<?php printf( __( 'If you don&lsquo;t have an account you can %screate one below by entering your email address. A password will be automatically emailed to you.', 'auto_manager' ), $account_required ? '' : __( 'optionally', 'auto_manager' ) . ' ' ); ?>

				<?php elseif ( $account_required ) : ?>

					<?php echo apply_filters( 'submit_auto_form_login_required_message',  __('You must sign in to create a new auto listing.', 'auto_manager' ) ); ?>

				<?php endif; ?>

			</div>

		</div>

	</fieldset>



<?php endif; ?>