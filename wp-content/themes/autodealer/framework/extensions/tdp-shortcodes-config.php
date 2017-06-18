<?php
/**
 * ThemesDepot Shortcodes Plugin Configuration Extensions
 * this file handles the extensions of the configuration for the shortcode manager
 *
 * @package ThemesDepot Framework
 */


/*-----------------------------------------------------------------------------------*/
/*	Double Call To Action Area
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['double_call_to_action'] = array(
	'no_preview' => true,
	'params' => array(

		'left_heading' => array(
			'std' => 'Heading Title',
			'type' => 'text',
			'label' => __( 'Left Call To Action Heading Title', 'framework' ),
			'desc' => __( 'Add your heading title for the left call to action.', 'framework' ),
		),
		'left_subheading' => array(
			'std' => 'Sub Heading Title',
			'type' => 'text',
			'label' => __( 'Left Call To Action Sub Heading Title', 'framework' ),
			'desc' => __( 'Add your sub heading title for the left call to action.', 'framework' ),
		),
		'left_url' => array(
			'std' => 'http://',
			'type' => 'text',
			'label' => __( 'Left Call To Action Button URL', 'framework' ),
			'desc' => __( 'Enter the url.', 'framework' ),
		),
		'left_label' => array(
			'std' => 'Button Label',
			'type' => 'text',
			'label' => __( 'Left Call To Action Button Label', 'framework' ),
			'desc' => __( 'Enter the label.', 'framework' ),
		),

		'right_heading' => array(
			'std' => 'Heading Title',
			'type' => 'text',
			'label' => __( 'Left Call To Action Heading Title', 'framework' ),
			'desc' => __( 'Add your heading title for the right call to action.', 'framework' ),
		),
		'right_subheading' => array(
			'std' => 'Sub Heading Title',
			'type' => 'text',
			'label' => __( 'Left Call To Action Sub Heading Title', 'framework' ),
			'desc' => __( 'Add your sub heading title for the right call to action.', 'framework' ),
		),
		'right_url' => array(
			'std' => 'http://',
			'type' => 'text',
			'label' => __( 'Left Call To Action Button URL', 'framework' ),
			'desc' => __( 'Enter the url.', 'framework' ),
		),
		'right_label' => array(
			'std' => 'Button Label',
			'type' => 'text',
			'label' => __( 'Left Call To Action Button Label', 'framework' ),
			'desc' => __( 'Enter the label.', 'framework' ),
		),


	),
	'shortcode' => '[dcall left_heading="{{left_heading}}" left_subheading="{{left_subheading}}" left_url="{{left_url}}" left_label="{{left_label}}" right_heading="{{right_heading}}" right_subheading="{{right_subheading}}" right_url="{{right_url}}" right_label="{{right_label}}"]',
	'popup_title' => __( 'Double Call To Action Shortcode', 'framework' )
);


/*-----------------------------------------------------------------------------------*/
/*	Latest Vehicles Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['latest_vehicles'] = array(
	'no_preview' => true,
	'params' => array(

		'use_bg' => array(
			'type' => 'select',
			'label' => __('Add Background Color?', 'framework'),
			'desc' => 'Select if you wish to use a background color or not.',
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No, use light shaded background'
			)
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Background Color', 'framework'),
			'desc' => __('Leave blank for default', 'framework')
		),
		'overlay' => array(
			'type' => 'select',
			'label' => __('Add Background Overlay?', 'framework'),
			'desc' => 'Select yes if you wish to add a transparent color overlay for the fullwidth section. The color of the overlay can be set through the background color option above here.',
			'options' => array(
				'no' => 'No Thanks',
				'yes' => 'Yes Please'
			)
		),
		'backgroundimage' => array(
			'type' => 'uploader',
			'label' => __('Backgrond Image', 'framework'),
			'desc' => 'Upload an image to display in the background'
		),
		'backgroundrepeat' => array(
			'type' => 'select',
			'label' => __('Background Repeat', 'framework'),
			'desc' => 'Choose how the background image repeats.',
			'options' => array(
				'no-repeat' => 'No Repeat',
				'repeat' => 'Repeat Vertically and Horizontally',
				'repeat-x' => 'Repeat Horizontally',
				'repeat-y' => 'Repeat Vertically'
			)
		),
		'backgroundposition' => array(
			'type' => 'select',
			'label' => __('Background Position', 'framework'),
			'desc' => 'Choose the postion of the background image',
			'options' => array(
				'left top' => 'Left Top',
				'left center' => 'Left Center',
				'left bottom' => 'Left Bottom',
				'right top' => 'Right Top',
				'right center' => 'Right Center',
				'right bottom' => 'Right Bottom',
				'center top' => 'Center Top',
				'center center' => 'Center Center',
				'center bottom' => 'Center Bottom'
			)
		),
		'backgroundattachment' => array(
			'type' => 'select',
			'label' => __('Background Scroll', 'framework'),
			'desc' => 'Choose how the background image scrolls',
			'options' => array(
				'scroll' => 'Scroll: background scrolls along with the element',
				'fixed' => 'Fixed: background is fixed giving a parallax effect',
				'local' => 'Local: background scrolls along with the element\'s contents'
			)
		),
		'bordersize' => array(
			'std' => 1,
			'type' => 'select',
			'label' => __( 'Border Size', 'framework' ),
			'desc' => __( 'In pixels', 'framework' ),
			'options' => tdp_shortcodes_range( 10, false )
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'label' => __('Border Color', 'framework'),
			'desc' => __('Leave blank for default', 'framework')
		),
		'paddingtop' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Top', 'framework' ),
			'desc' => __( 'In pixels', 'framework' ),
			'options' => tdp_shortcodes_range( 100, false )
		),
		'paddingbottom' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Bottom', 'framework' ),
			'desc' => __( 'In pixels', 'framework' ),
			'options' => tdp_shortcodes_range( 100, false )
		),
		'lighttext' => array(
			'type' => 'select',
			'label' => __('Use light text colors?', 'framework'),
			'desc' => __('Select if you wish to use light colors for specific text into the section, useful when the background is dark with text hard to read on top of it.', 'framework'),
			'options' => $reverse_choices
		),

	),
	'shortcode' => '[latest_vehicles_carousel use_bg="{{use_bg}}" backgroundcolor="{{backgroundcolor}}" overlay="{{overlay}}" backgroundimage="{{backgroundimage}}" backgroundrepeat="{{backgroundrepeat}}" backgroundposition="{{backgroundposition}}" backgroundattachment="{{backgroundattachment}}" bordersize="{{bordersize}}px" bordercolor="{{bordercolor}}" paddingTop="{{paddingtop}}px" paddingBottom="{{paddingbottom}}px" lighttext="{{lighttext}}"]',
	'popup_title' => __( 'Latest Vehicles Carousel', 'framework' )
);

/*-----------------------------------------------------------------------------------*/
/*	Featured Vehicles Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['featured_vehicles'] = array(
	'no_preview' => true,
	'params' => array(

		'use_bg' => array(
			'type' => 'select',
			'label' => __('Add Background Color?', 'framework'),
			'desc' => 'Select if you wish to use a background color or not.',
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No, use light shaded background'
			)
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Background Color', 'framework'),
			'desc' => __('Leave blank for default', 'framework')
		),
		'overlay' => array(
			'type' => 'select',
			'label' => __('Add Background Overlay?', 'framework'),
			'desc' => 'Select yes if you wish to add a transparent color overlay for the fullwidth section. The color of the overlay can be set through the background color option above here.',
			'options' => array(
				'no' => 'No Thanks',
				'yes' => 'Yes Please'
			)
		),
		'backgroundimage' => array(
			'type' => 'uploader',
			'label' => __('Backgrond Image', 'framework'),
			'desc' => 'Upload an image to display in the background'
		),
		'backgroundrepeat' => array(
			'type' => 'select',
			'label' => __('Background Repeat', 'framework'),
			'desc' => 'Choose how the background image repeats.',
			'options' => array(
				'no-repeat' => 'No Repeat',
				'repeat' => 'Repeat Vertically and Horizontally',
				'repeat-x' => 'Repeat Horizontally',
				'repeat-y' => 'Repeat Vertically'
			)
		),
		'backgroundposition' => array(
			'type' => 'select',
			'label' => __('Background Position', 'framework'),
			'desc' => 'Choose the postion of the background image',
			'options' => array(
				'left top' => 'Left Top',
				'left center' => 'Left Center',
				'left bottom' => 'Left Bottom',
				'right top' => 'Right Top',
				'right center' => 'Right Center',
				'right bottom' => 'Right Bottom',
				'center top' => 'Center Top',
				'center center' => 'Center Center',
				'center bottom' => 'Center Bottom'
			)
		),
		'backgroundattachment' => array(
			'type' => 'select',
			'label' => __('Background Scroll', 'framework'),
			'desc' => 'Choose how the background image scrolls',
			'options' => array(
				'scroll' => 'Scroll: background scrolls along with the element',
				'fixed' => 'Fixed: background is fixed giving a parallax effect',
				'local' => 'Local: background scrolls along with the element\'s contents'
			)
		),
		'bordersize' => array(
			'std' => 1,
			'type' => 'select',
			'label' => __( 'Border Size', 'framework' ),
			'desc' => __( 'In pixels', 'framework' ),
			'options' => tdp_shortcodes_range( 10, false )
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'label' => __('Border Color', 'framework'),
			'desc' => __('Leave blank for default', 'framework')
		),
		'paddingtop' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Top', 'framework' ),
			'desc' => __( 'In pixels', 'framework' ),
			'options' => tdp_shortcodes_range( 100, false )
		),
		'paddingbottom' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Bottom', 'framework' ),
			'desc' => __( 'In pixels', 'framework' ),
			'options' => tdp_shortcodes_range( 100, false )
		),
		'lighttext' => array(
			'type' => 'select',
			'label' => __('Use light text colors?', 'framework'),
			'desc' => __('Select if you wish to use light colors for specific text into the section, useful when the background is dark with text hard to read on top of it.', 'framework'),
			'options' => $reverse_choices
		),

	),
	'shortcode' => '[featured_vehicles_carousel use_bg="{{use_bg}}" backgroundcolor="{{backgroundcolor}}" overlay="{{overlay}}" backgroundimage="{{backgroundimage}}" backgroundrepeat="{{backgroundrepeat}}" backgroundposition="{{backgroundposition}}" backgroundattachment="{{backgroundattachment}}" bordersize="{{bordersize}}px" bordercolor="{{bordercolor}}" paddingTop="{{paddingtop}}px" paddingBottom="{{paddingbottom}}px" lighttext="{{lighttext}}"]',
	'popup_title' => __( 'Latest Vehicles Carousel', 'framework' )
);

/*-----------------------------------------------------------------------------------*/
/*	Brands Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['vehicle_brands'] = array(
	'no_preview' => true,
	'params' => array(
		'info' => array(
			'std' => 'This shortcode does not have any parameter, just click the "insert shortcode" button.',
			'type' => 'info',
			'label' => __( 'Content', 'framework' ),
			'desc' => '',
		)

	),
	'shortcode' => '[vehicle_brands]',
	'popup_title' => __( 'Vehicle Brands Shortcode', 'framework' )
);

/*-----------------------------------------------------------------------------------*/
/*	Vehicle Tabs Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['vehicle_tabs'] = array(
	'no_preview' => true,
	'params' => array(
		'amount' => array(
			'std' => '2',
			'type' => 'text',
			'label' => __( 'How Many Vehicles?', 'framework' ),
			'desc' => __( 'Enter the amount of vehicles you wish to display.', 'framework' ),
		),

	),
	'shortcode' => '[vehicle_tabs amount="{{amount}}"]',
	'popup_title' => __( 'Vehicle Tabs Shortcode', 'framework' )
);

/*-----------------------------------------------------------------------------------*/
/*	Vehicle Types Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['vehicle_types'] = array(
	'no_preview' => true,
	'params' => array(
		
		'info' => array(
			'std' => 'This shortcode requires that each vehicle type has an icon or an image. You can upload an image for the vehicly type by going in "Vehicles -> Type" and fill the "Vehicle Type Icon" field that appear just below the "description" textarea.',
			'type' => 'info',
			'label' => __( 'Info', 'framework' ),
		),
		'use_bg' => array(
			'type' => 'select',
			'label' => __('Add Background Color?', 'framework'),
			'desc' => 'Select if you wish to use a background color or not.',
			'options' => array(
				'yes' => 'Yes',
				'no' => 'No, use light shaded background'
			)
		),

	),
	'shortcode' => '[vehicle_types use_bg="{{use_bg}}"]',
	'popup_title' => __( 'Vehicle Tabs Shortcode', 'framework' )
);

/*-----------------------------------------------------------------------------------*/
/*	Vehicle Tabbed search Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['tabbed_search'] = array(
	'no_preview' => true,
	'params' => array(
		'tab1' => array(
			'std' => 'Search By Type',
			'type' => 'text',
			'label' => __( 'First Tab Title', 'framework' ),
			'desc' => __( 'Enter the tab title', 'framework' ),
		),
		'tab2' => array(
			'std' => 'Advanced Search',
			'type' => 'text',
			'label' => __( 'Second Tab Title', 'framework' ),
			'desc' => __( 'Enter the tab title', 'framework' ),
		),
	),
	'shortcode' => '[tabbed_search tab1="{{tab1}}" tab2="{{tab2}}"]',
	'popup_title' => __( 'Vehicle Tabbed search Shortcode', 'framework' )
);

/*-----------------------------------------------------------------------------------*/
/*	Vehicle search Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['vehicle_search'] = array(
	'no_preview' => true,
	'params' => array(
		'info' => array(
			'std' => 'This shortcode does not have any parameter, just click the "insert shortcode" button.',
			'type' => 'info',
			'label' => __( 'Content', 'framework' ),
		)
	),
	'shortcode' => '[vehicle_search]',
	'popup_title' => __( 'Vehicle Tabbed search Shortcode', 'framework' )
);