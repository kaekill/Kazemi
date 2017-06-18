<?php

	/**
	 * Our core class.
	 *
	 * This contains all the cool jazz that makes this plugin work.
	 *
	 * @version 2.0.5.2
	 * @since 1.0
	 */
	class Tdp_frontend_WP_Modal_Login {

		// Set the version number
		public $plugin_version = '2.0.6';


		/**
		 * Loads all of our required hooks and filters and other cool doodads.
		 *
		 * @version 1.2
		 * @since 1.0
		 */
		public function __construct() {
			global $wpml_settings;

			// Register our source code with the wp_footer().
			add_action( 'wp_footer', array( $this, 'login_form' ) );

			// Add our JavaScript and Stylesheets to the front-end.
			add_action( 'wp_enqueue_scripts', array( $this, 'print_resources' ) );

			// Add the users custom CSS if they wish to add any.
			if ( isset( $wpml_settings['custom-css'] ) )
				add_action( 'wp_head', array( $this, 'print_custom_css' ) );

			// Add our lost password field.
			add_action( 'after_wpml_form', array( $this, 'additional_options' ) );

			// Add our shortcode action.
			add_shortcode( 'wp-modal-login', array( $this, 'modal_login_btn_shortcode' ) );

			// Register our widget but only if the user has allowed the widget option.
			if ( isset( $wpml_settings['display-widget'] ) )
				add_action( 'widgets_init', create_function( '', 'register_widget( "Tdp_frontend_WP_Modal_Login_Widget" );' ) );

			// Allow us to run Ajax on the login.
			add_action( 'wp_ajax_nopriv_ajaxlogin', array( $this, 'ajax_login' ) );
		}


		/**
		 * Add all of our scripts and styles with WordPress.
		 * @return void
		 *
		 * @version 2.1
		 * @since 1.0
		 */
		public function print_resources() {
			global $wpml_settings;

			$theme = $wpml_settings['modal-theme'];

			wp_enqueue_script( 'wpml-script', get_template_directory_uri() . '/js/wp-modal-login.js', array( 'jquery' ), false, true);

			// Only run our ajax stuff when the user isn't logged in.
			if ( ! is_user_logged_in() ) {
				wp_localize_script( 'wpml-script', 'wpml_script', array(
					'ajax' 		     => admin_url( 'admin-ajax.php' ),
					'redirecturl' 	  => apply_filters( 'wpml_redirect_to', $_SERVER['REQUEST_URI'] ),
					'loadingmessage' => __( 'Checking Credentials...', 'tdp-fec' ),
				) );
			}
		}


		/**
		 * Display any custom CSS that may be entered into the admin area
		 * @return String
		 *
		 * @version 1.0.1
		 * @since 2.0
		 */
		public function print_custom_css() {
			global $wpml_settings;

			echo '<style text="text/css">' . sanitize_text_field( $wpml_settings['custom-css'] ) . "</style>\n";
		}


		/**
		 * The main function behind a large section of the Ajax-y goodness.
		 * @return void
		 *
		 * @version 1.1.2
		 * @since 2.0
		 */
		public function ajax_login() {

			// Check our nonce and make sure it's correct.
			check_ajax_referer( 'ajax-form-nonce', 'security' );

			// Get our form data.
			$data = array();

			// Check that we are submitting the login form
			if ( isset( $_REQUEST['login'] ) )  {
				$data['user_login'] 	  = sanitize_user( $_REQUEST['username'] );
				$data['user_password'] = sanitize_text_field( $_REQUEST['password'] );
				$data['rememberme'] 	  = sanitize_text_field( $_REQUEST['rememberme'] );
				$user_login 			  = wp_signon( $data, false );

				// Check the results of our login and provide the needed feedback
				if ( is_wp_error( $user_login ) ) {
					echo json_encode( array(
						'loggedin' => false,
						'message'  => __( 'Wrong Username or Password!', 'tdp-fec' ),
					) );
				} else {
					echo json_encode( array(
						'loggedin' => true,
						'message'  => __( 'Login Successful!', 'tdp-fec' ),
					) );
				}
			}

			// Check if we are submitting the register form
			elseif ( isset( $_REQUEST['register'] ) ) {
				$user_data = array(
					'user_login' => sanitize_user( $_REQUEST['username'] ),
					'user_email' => sanitize_email( $_REQUEST['email'] ),
					'user_test' => esc_attr( $_REQUEST['math'] ),
					'role' => $_REQUEST['role']
				);

				if($user_data['user_test'] == 7 ) {

					$user_register = $this->register_new_user( $user_data['user_login'], $user_data['user_email'], $user_data['role'] );

					// Check if there were any issues with creating the new user
					if ( is_wp_error( $user_register ) ) {
						echo json_encode( array(
							'registerd' => false,
							'message'   => $user_register->get_error_message(),
						) );
					} else {
						echo json_encode( array(
							'registerd' => true,
							'message'	=> __( 'Registration complete. Please check your e-mail.', 'tdp-fec' ),
						) );
					}

				} else {

					echo json_encode( array(
							'registerd' => false,
							'message'	=> __( 'Captcha validation failed.', 'tdp-fec' ),
					) );

				}


			}

			// Check if we are submitting the forgotten pwd form
			elseif ( isset( $_REQUEST['forgotten'] ) ) {

				// Check if we are sending an email or username and sanitize it appropriately
				if ( is_email( $_REQUEST['username'] ) ) {
					$username = sanitize_email( $_REQUEST['username'] );
				} else {
					$username = sanitize_user( $_REQUEST['username'] );
				}

				// Send our information
				$user_forgotten = $this->retrieve_password( $username );

				// Check if there were any errors when requesting a new password
				if ( is_wp_error( $user_forgotten ) ) {
					echo json_encode( array(
						'reset' 	 => false,
						'message' => $user_forgotten->get_error_message(),
					) );
				} else {
					echo json_encode( array(
						'reset'   => true,
						'message' => __( 'Password Reset. Please check your email.', 'tdp-fec' ),
					) );
				}
			}

			die();
		}


		/**
		 * When users register an account we want to sanitize the information and generate a new password, add to the database and email both the site admin and the new user account with an auto-generated password.
		 * @param  String $user_login The username to be set to the new user account
		 * @param  String $user_email The email to be set to the new user account
		 * @return String
		 *
		 * @version 1.1
		 * @since 2.0
		 */
		function register_new_user( $user_login, $user_email, $role) {
			$errors = new WP_Error();
			$sanitized_user_login = sanitize_user( $user_login );
			$user_email = apply_filters( 'user_registration_email', $user_email );

			// Check the username was sanitized
			if ( $sanitized_user_login == '' ) {
				$errors->add( 'empty_username', __( 'Please enter a username.', 'tdp-fec' ) );
			} elseif ( ! validate_username( $user_login ) ) {
				$errors->add( 'invalid_username', __( 'This username is invalid because it uses illegal characters. Please enter a valid username.', 'tdp-fec' ) );
				$sanitized_user_login = '';
			} elseif ( username_exists( $sanitized_user_login ) ) {
				$errors->add( 'username_exists', __( 'This username is already registered. Please choose another one.', 'tdp-fec' ) );
			}

			// Check the e-mail address
			if ( $user_email == '' ) {
				$errors->add( 'empty_email', __( 'Please type your e-mail address.', 'tdp-fec' ) );
			} elseif ( ! is_email( $user_email ) ) {
				$errors->add( 'invalid_email', __( 'The email address isn\'t correct.', 'tdp-fec' ) );
				$user_email = '';
			} elseif ( email_exists( $user_email ) ) {
				$errors->add( 'email_exists', __( 'This email is already registered, please choose another one.', 'tdp-fec' ) );
			}

			// Check User Role
			if ($role == 'administrator' || $role == 'super_admin' || $role == 'superadmin') {
				$errors->add( 'empty_role', __( 'Something was wrong with your select role.', 'tdp-fec' ) );
			}

			$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email, $user_registration_role );

			if ( $errors->get_error_code() )
				return $errors;

			$user_pass = wp_generate_password( 12, false );
			$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );

			if ( ! $user_id ) {
				$errors->add( 'registerfail', __( 'Couldn\'t register you... please contact the site administrator', 'tdp-fec' ) );

				return $errors;
			}

			update_user_option( $user_id, 'default_password_nag', true, true ); // Set up the Password change nag.

			update_user_meta($user_id, 'twitter', $role );

			wp_update_user( array ( 'ID' => $user_id, 'role' => $role ) );

			autodealer_new_user_notification( $user_id, $user_pass );

			return $user_id;
		}

		function retrieve_password( $user_data ) {
			global $wpdb, $wp_hasher;

			$errors = new WP_Error();

			if ( empty( $user_data ) ) {
				$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.','tdp-fec'));
			} else if ( strpos( $user_data, '@' ) ) {
				$user_data = get_user_by( 'email', trim( $user_data ) );
				if ( empty( $user_data ) )
					$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.','tdp-fec'));
			} else {
				$login = trim($user_data);
				$user_data = get_user_by('login', $login);
			}

			/**
			 * Fires before errors are returned from a password reset request.
			 *
			 * @since 2.1.0
			 */
			do_action( 'lostpassword_post' );

			if ( $errors->get_error_code() )
				return $errors;

			if ( !$user_data ) {
				$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.','tdp-fec'));
				return $errors;
			}

			// redefining user_login ensures we return the right case in the email
			$user_login = $user_data->user_login;
			$user_email = $user_data->user_email;

			/**
			 * Fires before a new password is retrieved.
			 *
			 * @since 1.5.0
			 * @deprecated 1.5.1 Misspelled. Use 'retrieve_password' hook instead.
			 *
			 * @param string $user_login The user login name.
			 */
			do_action( 'retreive_password', $user_login );
			/**
			 * Fires before a new password is retrieved.
			 *
			 * @since 1.5.1
			 *
			 * @param string $user_login The user login name.
			 */
			do_action( 'retrieve_password', $user_login );

			/**
			 * Filter whether to allow a password to be reset.
			 *
			 * @since 2.7.0
			 *
			 * @param bool true           Whether to allow the password to be reset. Default true.
			 * @param int  $user_data->ID The ID of the user attempting to reset a password.
			 */
			$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

			if ( ! $allow )
				return new WP_Error('no_password_reset', __('Password reset is not allowed for this user','tdp-fec'));
			else if ( is_wp_error($allow) )
				return $allow;

			// Generate something random for a password reset key.
			$key = wp_generate_password( 20, false );

			/**
			 * Fires when a password reset key is generated.
			 *
			 * @since 2.5.0
			 *
			 * @param string $user_login The username for the user.
			 * @param string $key        The generated password reset key.
			 */
			do_action( 'retrieve_password_key', $user_login, $key );

			// Now insert the key, hashed, into the DB.
			if ( empty( $wp_hasher ) ) {
				require_once ABSPATH . 'wp-includes/class-phpass.php';
				$wp_hasher = new PasswordHash( 8, true );
			}
			$hashed = $wp_hasher->HashPassword( $key );
			$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

			$message = __('Someone requested that the password be reset for the following account:','tdp-fec') . "\r\n\r\n";
			$message .= network_home_url( '/' ) . "\r\n\r\n";
			$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
			$message .= __('If this was a mistake, just ignore this email and nothing will happen.','tdp-fec') . "\r\n\r\n";
			$message .= __('To reset your password, visit the following address:','tdp-fec') . "\r\n\r\n";
			$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

			if ( is_multisite() )
				$blogname = $GLOBALS['current_site']->site_name;
			else
				// The blogname option is escaped with esc_html on the way into the database in sanitize_option
				// we want to reverse this for the plain text arena of emails.
				$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

			$title = sprintf( __('[%s] Password Reset','tdp-fec'), $blogname );

			/**
			 * Filter the subject of the password reset email.
			 *
			 * @since 2.8.0
			 *
			 * @param string $title Default email title.
			 */
			$title = apply_filters( 'retrieve_password_title', $title );
			/**
			 * Filter the message body of the password reset mail.
			 *
			 * @since 2.8.0
			 *
			 * @param string $message Default mail message.
			 * @param string $key     The activation key.
			 */
			$message = apply_filters( 'retrieve_password_message', $message, $key );

			if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
				wp_die( __('The e-mail could not be sent.','tdp-fec') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.','tdp-fec') );

			return true;
		}


		/**
		 * The source code for our login form. Version 2 supports ajaxable Login, Registration and Forgotten Password forms.
		 * @return html
		 * @actions before_wpml_title				Add items before the modal window title.
		 *          before_wpml_form				Add items before the form itself, or after the title.
		 *          inside_wpml_form_first		Add items before any of the form items but inside the form wrapper.
		 *          login_form 						Default WP action for custom login forms.
		 *          inside_wpml_form_submit		Add items in the submit wrapper.
		 *          inside_wpml_form_last		Add items at the end of the form wrapper after the submit button.
		 *          after_wpml_form				Add items after the form iteself.
		 *
		 * @version 2.0.1
		 * @since 1.0
		 */
		public function login_form() {
			global $user_ID, $user_identity, $wpml_settings;
			get_currentuserinfo();
			$multisite_reg = get_site_option( 'registration' ); ?>

			<div id="login-box" class="login-popup">

				<a href="#" class="close-btn"><span class="icon-cancel"></span></a>

				<?php do_action( 'before_wpml_title' ); ?>

				<?php if( ! $user_ID ) : ?>
					<div class="section-container">

						<?php // Login Form ?>
						<div id="login" class="wpml-content same-form">

							<h2><?php _e( 'Existing User?', 'tdp-fec' ); ?></h2>

							<?php do_action( 'before_wpml_login' ); ?>

							<form action="login" method="post" id="form" class="group" name="loginform">

								<?php do_action( 'inside_wpml_login_first' ); ?>

								<p class="field-set">
									<label class="field-titles" for="login_user"><?php _e( 'Username', 'tdp-fec' ); ?></label>
									<span class="inputimg icon-user-1"></span>
									<input type="text" name="log" id="login_user" class="input" value="<?php if ( isset( $user_login ) ) echo esc_attr( $user_login ); ?>" size="20" />
								</p>

								<p class="field-set">
									<label class="field-titles" for="login_pass"><?php _e( 'Password', 'tdp-fec' ); ?></label>
									<span class="inputimg icon-key-1"></span>
									<input type="password" name="pwd" id="login_pass" class="input" value="" size="20" />
								</p>

								<?php do_action( 'login_form' ); ?>

								<p id="forgetmenot">
									<label class="forgetmenot-label" for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember Me', 'tdp-fec' ); ?></label>
								</p>

								<div class="submit">

									<?php do_action( 'inside_wpml_login_submit' ); ?>

									<input type="submit" name="wp-sumbit" id="wp-submit" class="btn green huge" value="<?php _e( 'Sign In Now &raquo;', 'tdp-fec' ); ?>" />
									<input type="hidden" name="login" value="true" />
									<?php wp_nonce_field( 'ajax-form-nonce', 'security' ); ?>

								</div><!--[END .submit]-->

								<?php do_action( 'inside_wpml_login_last' ); ?>

							</form><!--[END #loginform]-->
						</div><!--[END #login]-->

						<?php // Registration form ?>
						<?php if ( ! isset( $wpml_settings['remove-reg'] ) ) {
							if ( ( get_option( 'users_can_register' ) && ! is_multisite() ) || ( $multisite_reg == 'all' || $multisite_reg == 'blog' || $multisite_reg == 'user' ) ) : ?>
								<div id="register" class="wpml-content same-form" style="display:none;">

									<h2><?php _e( 'Register', 'tdp-fec' ); ?></h2>

									<?php do_action( 'before_wpml_register' ); ?>

									<form action="register" method="post" id="form" class="group" name="loginform">

										<?php do_action( 'inside_wpml_register_first' ); ?>

										<p class="field-set">
											<label class="field-titles" for="reg_user"><?php _e( 'Username', 'tdp-fec' ); ?></label>
											<span class="inputimg icon-user-1"></span>
											<input type="text" name="user_login" id="reg_user" class="input" value="<?php if ( isset( $user_login ) ) echo esc_attr( stripslashes( $user_login ) ); ?>" size="20" />
										</p>

										<p class="field-set">
											<label class="field-titles" for="reg_email"><?php _e( 'Email', 'tdp-fec' ); ?></label>
											<span class="inputimg icon-mail-alt"></span>
											<input type="text" name="user_email" id="reg_email" class="input" value="<?php if ( isset( $user_email ) ) echo esc_attr( stripslashes( $user_email ) ); ?>" size="20" />
										</p>

										<p class="field-set">
											<label class="field-titles" for="reg_test"><?php _e( 'How much is 2 + 5?', 'tdp-fec' ); ?></label>
											<span class="inputimg icon-info-circled"></span>
											<input type="text" name="user_test" id="reg_test" class="input" value="" size="20" />
										</p>

										<p class="field-set">
											<label class="field-titles" for="role"><?php _e( 'Register As', 'tdp-fec' ); ?></label>
											<select id="role" name="role">
												<option value="subscriber" selected="selected"><?php _e('Private','tdp-fec');?></option>
												<option value="tdp_dealer"><?php _e('Dealer','tdp-fec');?></option>
											</select>
											<div class="clearboth"></div>
										</p>

										<?php do_action( 'register_form' ); ?>

										<div class="submit">

											<?php do_action( 'inside_wpml_register_submit' ); ?>

											<input type="submit" name="user-sumbit" id="user-submit" class="btn huge green" value="<?php esc_attr_e( 'Sign Up', 'tdp-fec' ); ?>" />
											<input type="hidden" name="register" value="true" />
											<?php wp_nonce_field( 'ajax-form-nonce', 'security' ); ?>

										</div><!--[END .submit]-->

										<?php do_action( 'inside_wpml_register_last' ); ?>

									</form>

								</div><!--[END #register]-->
							<?php endif;
						} ?>

						<?php // Forgotten Password ?>
						<div id="forgotten" class="wpml-content same-form" style="display:none;">

							<h2><?php _e( 'Forgotten Password?', 'tdp-fec' ); ?></h2>

							<?php do_action( 'before_wpml_forgotten' ); ?>

							<form action="forgotten" method="post" id="form" class="group" name="loginform">

								<?php do_action( 'inside_wpml_forgotton_first' ); ?>

								<p class="field-set">
									<label class="field-titles" for="forgot_login"><?php _e( 'Username or Email', 'tdp-fec' ); ?></label>
									<span class="inputimg icon-mail-alt"></span>
									<input type="text" name="forgot_login" id="forgot_login" class="input" value="<?php if ( isset( $user_login ) ) echo esc_attr( stripslashes( $user_login ) ); ?>" size="20" />
								</p>

								<?php do_action( 'login_form', 'resetpass' ); ?>

								<div class="submit">

									<?php do_action( 'inside_wpml_forgotten_submit' ); ?>

									<input type="submit" name="user-submit" id="user-submit" class="btn huge green" value="<?php esc_attr_e( 'Reset Password', 'tdp-fec' ); ?>">
									<input type="hidden" name="forgotten" value="true" />
									<?php wp_nonce_field( 'ajax-form-nonce', 'security' ); ?>

								</div>

								<?php do_action( 'inside_wpml_forgotten_last' ); ?>

							</form>

						</div><!--[END #forgotten]-->
					</div><!--[END .section-container]-->
				<?php endif; ?>

				<?php do_action( 'after_wpml_form' ); ?>
			</div><!--[END #login-box]-->
		<?php }


		/**
		 * Adds some additional fields to the login_form(). Hooked through 'after_wpml_form'.
		 * @return void
		 *
		 * @version 1.1
		 * @since 2.0
		 */
		public function additional_options() {
			global $wpml_settings;

			$multisite_reg = get_site_option( 'registration' );

			echo '<div id="additional-settings">';

			// Check if we have disabled this via the admin options first.
			if ( ! isset( $wpml_settings['remove-reg'] ) ) {
				if ( ( get_option( 'users_can_register' ) && ! is_multisite() ) || ( $multisite_reg == 'all' || $multisite_reg == 'blog' || $multisite_reg == 'user' ) )
					echo '<a href="#register" class="wpml-nav">' . __( 'Register', 'tdp-fec' ) . '</a> | ';
			}

			echo '<a href="#forgotten" class="wpml-nav">' . __( 'Lost your password?', 'tdp-fec' ) . '</a>';

			echo '<div class="hide-login"> | <a href="#login" class="wpml-nav">' . __( 'Back to Login', 'tdp-fec' ) . '</a></div>';

			echo '</div>';
		}


		/**
		 * Sets a "back to login form" button when the user is viewing any other form besides the login.
		 * @return String
		 *
		 * @version 1.0
		 * @since 2.0
		 */
		public function back_to_login() {
			echo '<a href="#login" class="wpml-nav">' . __( 'Login', 'tdp-fec' ) . '</a>';
		}


		/**
		 * Outputs the HTML for our login link.
		 * @param String $login_text  The text for the login link. Default 'Login'.
		 * @param String $logout_text The text for the logout link. Default 'Logout'.
		 * @param String $logout_url  The url to redirect to when users logout. Empty by default.
		 * @param Bool   $show_admin  The setting to display the link to the admin area when logged in.
		 * @return HTML
		 *
		 * @version 1.1
		 * @since 1.0
		 */
		public function modal_login_btn( $login_text = 'Login', $logout_text = 'Logout', $logout_url = '', $show_admin = 1 ) {
			// Check if we have an over riding logout redirection set. Other wise, default to the home page.
			if ( isset( $logout_url ) && $logout_url == '' )
				$logout_url = home_url();

			// Is the user logged in? If so, serve them the logout button, else we'll show the login button.
			if ( is_user_logged_in() ) {
				$link = '<a href="' . wp_logout_url( esc_url( $logout_url ) ) . '" class="logout wpml-btn">' . sprintf( _x( '%s', 'Logout Text', 'tdp-fec' ), sanitize_text_field( $logout_text ) ) . '</a>';
				if ( $show_admin )
					$link .= ' | <a href="' . esc_url( admin_url() ) . '">' . __( 'View Admin', 'tdp-fec' ) . '</a>';
			} else {
				$link = '<a href="#login-box" class="login wpml-btn login-window">' . sprintf( _x( '%s', 'Login Text', 'tdp-fec' ), sanitize_text_field( $login_text ) ) . '</a></li>';
			}

			return $link;
		}


	}
