<?php
/**
 * Actions and Filters
 *
 * Register any and all actions here. Nothing should actually be called
 * directly, the entire system will be based on these actions and hooks.
 */
 
/**
 * This is the class that you'll be working with. Duplicate this class as many times as you want. Make sure
 * to include an add_action call to each class, like the line above.
 *
 * @author tdp
 *
 */
class TDP_Listings_Profile extends Empty_Widget_Abstract
{
	/**
	 * Widget settings
	 *
	 * Simply use the following field examples to create the WordPress Widget options that
	 * will display to administrators. These options can then be found in the $params
	 * variable within the widget method.
	 *
	 *
	 */
	protected $widget = array(
		// you can give it a name here, otherwise it will default
		// to the classes name. BTW, you should change the class
		// name each time you create a new widget. Just use find
		// and replace!
		'name' => '[TDP] - User Profile',
 
		// this description will display within the administrative widgets area
		// when a user is deciding which widget to use.
		'description' => 'Use the following widget to display a login form and profile information on the frontend.',
 
		// determines whether or not to use the sidebar _before and _after html
		'do_wrapper' => true,
 
		// determines whether or not to display the widgets title on the frontend
		'do_title'	=> true,
 
		// string : if you set a filename here, it will be loaded as the view
		// when using a file the following array will be given to the file :
		// array('widget'=>array(),'params'=>array(),'sidebar'=>array(),
		// alternatively, you can return an html string here that will be used
		'view' => false,
	
		// If you desire to change the size of the widget administrative options
		// area
		'width'	=> 350,
		'height' => 350,
	
		// Shortcode button row
		'buttonrow' => 4,
	
		// The image to use as a representation of your widget.
		// Whatever you place here will be used as the img src
		// so we have opted to use a basencoded image.
		'thumbnail' => '',
	
		/* The field options that you have available to you. Please
		 * contribute additional field options if you create any.
		 *
		 */
		'fields' => array(
			// You should always offer a widget title
			array(
				'name' => 'Title',
				'desc' => '',
				'id' => 'title',
				'type' => 'text',
				'default' => 'Your Profile'
			),
			
		)
	);
 
	/**
	 * Widget HTML
	 *
	 * If you want to have an all inclusive single widget file, you can do so by
	 * dumping your css styles with base_encoded images along with all of your
	 * html string, right into this method.
	 *
	 * @param array $widget
	 * @param array $params
	 * @param array $sidebar
	 */
	function html($widget = array(), $params = array(), $sidebar = array())
	{

		global $current_user;

		if(!is_user_logged_in()) {

		?>

		<div class="<?php echo $widget_class; ?>">
			
				<?php 

						 echo '<div class="wrap-links">';

						 _e('Hey visitor, looks like you are not logged in/registered yet! Click the button below if you wish to login or register.','hangar');
						 
						 echo '<br/> <br/><a href="#login-box" id="open-login" class="login wpml-btn login-window btn small">'.__('Login Or Sign Up','hangar').'</a>';

						 /**
						 * Check if facebook plugin is active
						 **/
							if ( in_array( 'nextend-facebook-connect/nextend-facebook-connect.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
						    
								echo '<a href="'.wp_login_url().'?loginFacebook=1&redirect='.home_url().'"class="button small black">'.__('Login or Register With Facebook','hangar').'</a>';

							}

						 echo '</div>';
						 
				?>

		</div>

		<?php }
	}
	
}


register_widget('TDP_Listings_Profile' );