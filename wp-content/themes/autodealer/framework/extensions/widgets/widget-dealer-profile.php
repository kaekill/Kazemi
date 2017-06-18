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
class TDP_Dealer_Profile extends Empty_Widget_Abstract
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
		'name' => '[TDP] - Dealer Profile',
 
		// this description will display within the administrative widgets area
		// when a user is deciding which widget to use.
		'description' => 'Use the following widget to display the current listing dealer profile. Note this widget works only into the sidebar of the single vehicle page and only if the current user is either an administrator or a vehicle dealer.',
 
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
				'default' => 'Dealer Profile'
			),
			
			array(
				'name' => '',
				'desc' => '',
				'id' => 'is_location',
				'type' => 'checkbox',
				'options' => array( 
				    '1' => 'Display Dealer Address', 
				)
			),

			array(
				'name' => '',
				'desc' => '',
				'id' => 'is_website',
				'type' => 'checkbox',
				'options' => array( 
				    '1' => 'Display Dealer Website', 
				)
			),

			array(
				'name' => '',
				'desc' => '',
				'id' => 'is_number',
				'type' => 'checkbox',
				'options' => array( 
				    '1' => 'Display Dealer Phone Number', 
				)
			),

			array(
				'name' => '',
				'desc' => '',
				'id' => 'is_desc',
				'type' => 'checkbox',
				'options' => array( 
				    '1' => 'Display Dealer Business Description', 
				)
			),

			array(
				'name' => '',
				'desc' => '',
				'id' => 'is_more',
				'type' => 'checkbox',
				'options' => array( 
				    '1' => 'Display Dealer "View All Vehicles" button', 
				)
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

		$user_info = get_userdata(get_the_author_meta( 'ID' ));

		$current_user_role = implode(', ', $user_info->roles);

		if($current_user_role == 'administrator' || $current_user_role == 'tdp_dealer') { 

		?>
			
			<div class="inside-widget">

			<?php if($params['is_location'] || $params['is_website'] || $params['is_number']) { ?>

				<h5><?php _e('Contact Dealer Now:','framework');?></h5>

			<?php } ?>

			<?php if($params['is_number']) { ?>
			
				<h5 class="inline-detail"><i class="icon-phone"></i></h5><?php the_author_meta( 'business_phone_number' ); ?>
				<br/>
			<?php } ?>

			<?php if($params['is_location']) { ?>
			
				<h5 class="inline-detail"><i class="icon-location"></i></h5><?php the_author_meta( 'business_location' ); ?>
				
			<?php } ?>

			<?php if($params['is_desc']) { ?>
				<br/><br/>
				<h5><?php _e('More About: ','framework');?><?php the_author_meta( 'display_name' ); ?></h5>
				<?php the_author_meta( 'business_description' ); ?>
			
			<?php } ?>

			<?php if($params['is_more']) { ?>

				<a class="btn small " href="<?php the_field('dealer_profile_page','option');?>?dealer_profile=<?php the_author_meta( 'ID' ); ?>"><?php _e('All Vehicles From This Dealer','framework');?></a>

			<?php } ?>

			<?php if($params['is_website']) { ?>

				

				<a class="btn small " href="<?php the_author_meta( 'business_website' ); ?>"><?php _e('Visit Dealer Website','framework');?></a>
				<div class="clearboth"></div>

			<?php } ?>

			</div>

		<?php 
		}
		
	}
	
}

register_widget( 'TDP_Dealer_Profile' );