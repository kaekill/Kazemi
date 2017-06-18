<?php

/*-----------------------------------------------------------------------------------*/
/*	Default Options
/*-----------------------------------------------------------------------------------*/

// Number of posts array
function tdp_shortcodes_range ( $range, $all = true, $default = false, $range_start = 1 ) {
	if($all) {
		$number_of_posts['-1'] = 'All';
	}

	if($default) {
		$number_of_posts[''] = 'Default';
	}

	foreach(range($range_start, $range) as $number) {
		$number_of_posts[$number] = $number;
	}

	return $number_of_posts;
}

// Taxonomies
function tdp_shortcodes_categories ( $taxonomy, $empty_choice = false ) {
	if($empty_choice == true) {
		$post_categories[''] = 'Default';
	}

	$get_categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy);
	foreach ( $get_categories as $cat ) {
		$post_categories[$cat->slug] = $cat->name;
	}

	return $post_categories;
}

$choices = array('yes' => 'Yes', 'no' => 'No');
$reverse_choices = array('no' => 'No', 'yes' => 'Yes');

// Fontawesome icons list
$pattern = "/\.(icon-(?:\w+(?:-)?)+):before\s+{\s*content:\s*'(.+)';\s+}/";
$fontawesome_path = get_template_directory() . '/css/fontello.css';
if( file_exists( $fontawesome_path ) ) {
	@$subject = file_get_contents($fontawesome_path);
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	$icons[$match[1]] = $match[2];
}

$checklist_icons = array ( 'icon-check' => '\e97a', 'icon-star' => '\e807', 'icon-angle-right' => '\e895', 'icon-asterisk' => '\e8fe', 'icon-remove' => '\e81b', 'icon-plus' => '\e81e' );

$tdp_animations = array(
	'none' => 'None',
	'fade-in' => 'Fade in',
	'fade-from-left' => 'Fade from left',
	'fade-from-right' => 'Fade from right',
	'fade-from-bottom' => 'Fade from bottom',
	'move-up' => 'Move up',
	'grow' => 'Grow',
	'helix' => 'Helix',
	'flip' => 'Flip',
	'pop-up' => 'Pop up',
	'spin' => 'Spin',
	'flip-x' => 'Flip X',
	'flip-y' => 'Flip Y', 
);

/*-----------------------------------------------------------------------------------*/
/*	Choose a Shortcode Field
/*-----------------------------------------------------------------------------------*/

$select_shortcode = array(
	'type' => 'select',
	'label' => __('Select a Shortcode', TDP_SHORTCODES_TEXTDOMAIN),
	'desc' => '',
	'options' => array(
		'select' => 'Choose a Shortcode',
		'alert' => 'Alert',
		'blog' => 'Blog',
		'button' => 'Button',
		'checklist' => 'Checklist',
		'clientslider' => 'Client Slider',
		'contentboxes' => 'Content Boxes',
		'counterscircle' => 'Counters Circle',
		'countersbox' => 'Counters Box',
		'dropcap' => 'Dropcap',
		'flexslider' => 'Flexslider',
		'fontawesome' => 'FontAwesome',
		'fullwidth' => 'Full Width Container',
		'googlemap' => 'Google Map',
		'highlight' => 'Highlight',
		'imageframe' => 'Image Frame',
		'imagecarousel' => 'Image Carousel',
		'lightbox' => 'Lightbox',
		'person' => 'Person',
		'pricingtable' => 'Pricing Table',
		'progressbar' => 'Progress Bar',
		'recentposts' => 'Recent Posts',
		'recentworks' => 'Recent Works',
		'separator' => 'Separator',
		'sharingbox' => 'Sharing Box',
		'slider' => 'Slider',
		'soundcloud' => 'SoundCloud',
		'sociallinks' => 'Social Links',
		'tabs' => 'Tabs',
		'table' => 'Table',
		'taglinebox' => 'Tagline Box',
		'testimonials' => 'Testimonials',
		'title' => 'Title',
		'toggles' => 'Toggles',
		'tooltip' => 'Tooltip',
		'vimeo' => 'Vimeo',
		'woofeatured' => 'Woocommerce Featured Products Slider',
		'wooproducts' => 'Woocommerce Products Slider',
		'youtube' => 'Youtube',
		'columns' => 'Columns'
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Selection Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['shortcode-generator'] = array(
	'no_preview' => true,
	'params' => array(),
	'shortcode' => '',
	'popup_title' => ''
);

/*-----------------------------------------------------------------------------------*/
/*	Heading Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['heading'] = array(
	'no_preview' => true,
	'params' => array(
		'type' => array(
				'type' => 'select',
				'label' => __('Heading Tag', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Select heading type', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => array(
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'line' => 'Heading With Line Separator',
					'big' => 'Big Title + Subtitle',
					'boxed' => 'Boxed With Icon',
				)
		),
		'title' => array(
			'std' => 'Heading Title',
			'type' => 'text',
			'label' => __('Heading Title', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Enter The Heading Title Here', TDP_SHORTCODES_TEXTDOMAIN),
		),
		'subtitle' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Enter Subtitle', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Enter the subtitle if you selected "big title + subtitle" as heading type.', TDP_SHORTCODES_TEXTDOMAIN),
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon (optional)', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Click an icon to select, click again to deselect', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => $icons
		),
	),
	'shortcode' => '[heading type="{{type}}" title="{{title}}" subtitle="{{subtitle}}" icon="{{icon}}"]',
	'popup_title' => __( 'Heading Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);


/*-----------------------------------------------------------------------------------*/
/*	Highlight Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['highlight'] = array(
	'no_preview' => true,
	'params' => array(

		'color' => array(
			'type' => 'colorpicker',
			'label' => __('Highlight Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Pick a highlight color', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content to Higlight', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Add your content to be highlighted', TDP_SHORTCODES_TEXTDOMAIN ),
		)

	),
	'shortcode' => '[highlight color="{{color}}"]{{content}}[/highlight]',
	'popup_title' => __( 'Highlight Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	Quote Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['quote'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Quote Content', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Add your content here', TDP_SHORTCODES_TEXTDOMAIN ),
		)

	),
	'shortcode' => '[quote]{{content}}[/quote]',
	'popup_title' => __( 'Quote Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);


/*-----------------------------------------------------------------------------------*/
/*	Toggles Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['toggles'] = array(
	'params' => array(

	),
	'no_preview' => true,
	'params' => array(
		'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Title (optional)', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => 'Enter the title of this element.',
		),
		'border' => array(
				'type' => 'select',
				'label' => __('Element Style', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Select the style', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => array(
					'1' => 'Fancy',
					'2' => 'Simple',
				)
		),

	),
	'shortcode' => '[tdp_accordion title="{{title}}" border="{{border}}"]{{child_shortcode}}[/tdp_accordion]',
	'popup_title' => __('Insert Toggles Shortcode', TDP_SHORTCODES_TEXTDOMAIN),

	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Title', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => 'Insert the toggle title',
			),
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __('Select Icon (optional)', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Click an icon to select, click again to deselect', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => $icons
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Toggle Content', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => 'Insert the toggle content'
			),
			'collapse' => array(
				'type' => 'select',
				'label' => __('Set As Open', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Select if you wish to set this item as open by default', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => array(
					'2' => 'Closed',
					'1' => 'Open',
				)
		),
		),
		'shortcode' => '[accordion_item title="{{title}}" icon="{{icon}}" collapse="{{collapse}}"]{{content}}[/accordion_item]',
		'clone_button' => __('Add Toggle', TDP_SHORTCODES_TEXTDOMAIN)
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Spacer Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['spacer'] = array(
	'no_preview' => true,
	'params' => array(
		'space' => array(
			'std' => '20px',
			'type' => 'text',
			'label' => __( 'Space Amount', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Select the amount of space you want to add.', TDP_SHORTCODES_TEXTDOMAIN ),
		)

	),
	'shortcode' => '[spacer space="{{space}}"]',
	'popup_title' => __( 'Space Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['button'] = array(
	'no_preview' => true,
	'params' => array(
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Add the button url ex: http://example.com', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'target' => array(
			'type' => 'select',
			'label' => __('Button Target', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('_self = open in same window <br />_blank = open in new window', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		),
		'size' => array(
			'type' => 'select',
			'label' => __('Button Size', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the size of the button', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => array(
				'mini' => 'mini',
				'small' => 'small',
				'normal' => 'normal',
				'large' => 'large',
				'huge' => 'huge',
			)
		),
		'color' => array(
			'type' => 'select',
			'label' => __('Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the color of the button', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => array(
				'default' => 'default',
				'black' => 'black',
				'white' => 'white',
				'gray' => 'gray',
				'red' => 'red',
				'orange' => 'orange',
				'yellow' => 'yellow',
				'green' => 'green',
				'cyan' => 'cyan',
				'dark-blue' => 'dark-blue',
				'blue' => 'blue',
				'light-blue' => 'light-blue',
				'magenta' => 'magenta',
				'pink' => 'pink',
			)
		),
		'content' => array(
			'std' => 'Button Title',
			'type' => 'text',
			'label' => __( 'Button Title', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Enter the title of the button', TDP_SHORTCODES_TEXTDOMAIN ),
		),	
	),
	'shortcode' => '[button url="{{url}}" color="{{color}}" size="{{size}}" target="{{target}}"]{{content}}[/button]',
	'popup_title' => __( 'Highlight Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	Audio Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['audio'] = array(
	'no_preview' => true,
	'params' => array(
		'color' => array(
			'type' => 'colorpicker',
			'label' => __('Player Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the color of the player', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('MP3 File URL', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Add the url ex: http://example.com/file.mp3', TDP_SHORTCODES_TEXTDOMAIN)
		),
	),
	'shortcode' => '[tdp_audio color="{{color}}" url="{{url}}"]',
	'popup_title' => __( 'Audio Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	Callout Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['callout'] = array(
	'no_preview' => true,
	'params' => array(
		'fullwidth' => array(
			'type' => 'select',
			'label' => __('Set As Fullwidth?', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('select an option', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => array(
				'1' => 'Yes',
				'0' => 'No'
			)
		),
		'controls' => array(
				'type' => 'select',
				'label' => __('Buttons Position', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Select the position of the callout buttons', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => array(
					'right' => 'right',
					'bottom' => 'bottom',
				)
		),
		'title' => array(
			'std' => 'Callout Title',
			'type' => 'text',
			'label' => __('Title', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Add the title', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'message' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Message', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Add the message', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'button1' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('First button name', TDP_SHORTCODES_TEXTDOMAIN),
		),
		'button2' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Second button name', TDP_SHORTCODES_TEXTDOMAIN),
		),
		'link1' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('First button url ex. http://example.com', TDP_SHORTCODES_TEXTDOMAIN),
		),
		'link2' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Second button url ex. http://example.com', TDP_SHORTCODES_TEXTDOMAIN),
		),
		'style1' => array(
			'type' => 'colorpicker',
			'label' => __('First Button Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the color', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'style2' => array(
			'type' => 'colorpicker',
			'label' => __('Second Button Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the color', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'color' => array(
			'type' => 'colorpicker',
			'label' => __('Callout BG Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the color', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'textcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Text Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the color', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'headingtextcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Heading Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the color', TDP_SHORTCODES_TEXTDOMAIN)
		),

	),
	'shortcode' => '[tdp_callout fullwidth="{{fullwidth}}" type="alternate" color="{{color}}" textcolor="{{textcolor}}" headingtextcolor="{{headingtextcolor}}" controls="{{controls}}" title="{{title}}" message="{{message}}" button1="{{button1}}" button2="{{button2}}" link1="{{link1}}" link2="{{link2}}" size1="" size2="" style1="{{style1}}" style2="{{style2}}"]',
	'popup_title' => __( 'Audio Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);


/*-----------------------------------------------------------------------------------*/
/*	contentbox Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['cbox'] = array(
	'no_preview' => true,
	'params' => array(
		'widgettitle' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Outside Title', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Add a title, will be displayed outside the box (optional)', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Add a title', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'cbox_style' => array(
				'type' => 'select',
				'label' => __('Style', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Select the style', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => array(
					'light' => 'light',
					'custom' => 'custom',
				)
		),
		'color' => array(
			'type' => 'colorpicker',
			'label' => __('Box Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the color', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon (optional)', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Click an icon to select, click again to deselect', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => $icons
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Content', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Enter the content', TDP_SHORTCODES_TEXTDOMAIN ),
		),
	),
	'shortcode' => '[tdp_contentbox title="{{title}}" cbox_style="{{cbox_style}}" color="{{color}}" icon="{{icon}}"]{{content}}[/tdp_contentbox]',
	'popup_title' => __( 'Audio Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	divider Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['divider'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
				'type' => 'select',
				'label' => __('Style', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Select the style', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => array(
					'style1' => 'Solid Line',
					'style2' => 'Dotted Line',
					'style4' => 'Line + Shadow',
					'style5' => 'Shadow',
					'style6' => 'Line + Top Text',
					'style7' => '5px Line + Color',
					'style8' => 'Centered 5px Line + Color',
					'style9' => 'Centered Solid Line',
					'style10' => 'Centered Dashed Line',
				)
		),
		'text' => array(
			'std' => 'To The Top',
			'type' => 'text',
			'label' => __( 'Top Text', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Enter the title', TDP_SHORTCODES_TEXTDOMAIN ),
		),
		'color' => array(
			'type' => 'colorpicker',
			'label' => __('Box Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the color', TDP_SHORTCODES_TEXTDOMAIN)
		),
	),
	'shortcode' => '[tdp_divider style="{{style}}" color="{{color}}" text="{{text}}"]',
	'popup_title' => __( 'Divider Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	gallery Config
/*-----------------------------------------------------------------------------------*/
$tdp_shortcodes['gallery'] = array(
	'no_preview' => true,
	'params' => array(
		'layout' => array(
				'type' => 'select',
				'label' => __('Style', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Select the style', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => array(
					'1' => 'Thumbnails with Lightbox',
					'3' => 'Image Slider With Pager',
				)
		),
		'images' => array(
			'type' => 'text',
			'label' => __('Images ID', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Insert the id number of each image that you want to add into the gallery, separate each id with a comma. Ex. 1,2'
		),
		'title' => array(
			'std' => 'Title',
			'type' => 'text',
			'label' => __( 'Title', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Enter the title', TDP_SHORTCODES_TEXTDOMAIN ),
		),
	),
	'shortcode' => '[tdp_gallery layout="{{layout}}" images="{{images}}" title="{{title}}"]',
	'popup_title' => __( 'Gallery Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);


/*-----------------------------------------------------------------------------------*/
/*	Google Map Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['googlemap'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __('Map Type', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select the type of google map to display', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => array(
				'roadmap' => 'Roadmap',
				'satellite' => 'Satellite',
				'hybrid' => 'Hybrid',
				'terrain' => 'Terrain'
			)
		),
		'width' => array(
			'std' => '100%',
			'type' => 'text',
			'label' => __('Map Width', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Map Width in Percentage or Pixels', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'height' => array(
			'std' => '300px',
			'type' => 'text',
			'label' => __('Map Height', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Map Height in Percentage or Pixels', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'zoom' => array(
			'std' => 14,
			'type' => 'select',
			'label' => __('Zoom Level', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Higher number will be more zoomed in.',
			'options' => tdp_shortcodes_range( 25, false )
		),
		'scrollwheel' => array(
			'type' => 'select',
			'label' => __('Scrollwheel on Map', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Enable zooming using a mouse\'s scroll wheel',
			'options' => $choices
		),
		'scale' => array(
			'type' => 'select',
			'label' => __('Show Scale Control on Map', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Display the map scale',
			'options' => $choices
		),
		'zoom_pancontrol' => array(
			'type' => 'select',
			'label' => __('Show Pan Control on Map', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Displays pan control button',
			'options' => $choices
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Address', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Add address to the location which will show up on map. For multiple addresses, separate addresses by using the | symbol. <br />ex: Address 1|Address 2|Address 3', TDP_SHORTCODES_TEXTDOMAIN ),
		)
	),
	'shortcode' => '[map address="{{content}}" type="{{type}}" width="{{width}}" height="{{height}}" zoom="{{zoom}}" scrollwheel="{{scrollwheel}}" scale="{{scale}}" zoom_pancontrol="{{zoom_pancontrol}}"][/map]',
	'popup_title' => __( 'Google Map Shortcode', TDP_SHORTCODES_TEXTDOMAIN ),
);

/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(

		'type' => array(
			'type' => 'select',
			'label' => __( 'Alert Type', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Select the type of alert message', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => array(
				'info' => 'General',
				'error' => 'Error',
				'success' => 'Success',
				'notice' => 'Notice',
			)
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Alert Content', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Insert the alert\'s content', TDP_SHORTCODES_TEXTDOMAIN ),
		),
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon (optional)', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Click an icon to select, click again to deselect', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => $icons
		),
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'Animation Type', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Select the type on animation to use on the shortcode', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => array(
				'none' => 'None',
				'bounce' => 'Bounce',
				'fade' => 'Fade',
				'flash' => 'Flash',
				'shake' => 'Shake',
				'slide' => 'Slide',
			)
		),
		'animation_direction' => array(
			'type' => 'select',
			'label' => __( 'Direction of Animation', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Select the incoming direction for the animation', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => array(
				'down' => 'Down',
				'left' => 'Left',
				'right' => 'Right',
				'up' => 'Up',
			)
		),
		'animation_speed' => array(
			'type' => 'text',
			'std' => '',
			'label' => __( 'Speed of Animation', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', TDP_SHORTCODES_TEXTDOMAIN ),
		),
		
	),
	'shortcode' => '[tdp_notification type="{{type}}" icon="{{icon}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}"]{{content}}[/tdp_notification]',
	'popup_title' => __( 'Alert Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	Pricing Table Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['pricingtable'] = array(
	'no_preview' => true,
	'params' => array(
		'columns' => array(
			'type' => 'select',
			'label' => __('Number of Columns', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Select how many columns to display',
			'options' => array(
				'&lt;br /&gt;
				[pricing-table col=&quot;4&quot;]
				[plan name=&quot;Starter Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;0€&quot; per=&quot;per year&quot; ]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>10GB</strong> Storage</li>
					<li><strong>100GB</strong> Bandwith</li>
					<li><strong>5</strong> Products</li>
					<li><strong>Basic</strong> Stats</li>
					<li><strong>Basic</strong> Customization</li>
				</ul>
				[/plan]

				[plan name=&quot;Gold Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;19$&quot; per=&quot;per month&quot;]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>20GB</strong> Storage</li>
					<li><strong>200GB</strong> Bandwith</li>
					<li><strong>25</strong> Products</li>
					<li><strong>Basic</strong> Stats</li>
					<li><strong>Basic</strong> Customization</li>
				</ul>
				[/plan]

				[plan name=&quot;Platinum Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;29$&quot; per=&quot;per month&quot; ]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>40GB</strong> Storage</li>
					<li><strong>500GB</strong> Bandwith</li>
					<li><strong>100</strong> Products</li>
					<li><strong>Complex</strong> Stats</li>
					<li><strong>Complex</strong> Customization</li>
				</ul>
				[/plan]

				[plan name=&quot;Diamond Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;49$&quot; per=&quot;month&quot;]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>100GB</strong> Storage</li>
					<li><strong>1000GB</strong> Bandwith</li>
					<li><strong>Unlimited</strong> Products</li>
					<li><strong>Complex</strong> Stats</li>
					<li><strong>Complex</strong> Customization</li>
				</ul>
				[/plan]
				[/pricing-table]
				&lt;br /&gt;' => '4 Columns',
				'&lt;br /&gt;
				[pricing-table col=&quot;5&quot;]
				[plan name=&quot;Starter Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;0€&quot; per=&quot;per year&quot; ]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>10GB</strong> Storage</li>
					<li><strong>100GB</strong> Bandwith</li>
					<li><strong>5</strong> Products</li>
					<li><strong>Basic</strong> Stats</li>
					<li><strong>Basic</strong> Customization</li>
				</ul>
				[/plan]

				[plan name=&quot;Gold Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;19$&quot; per=&quot;per month&quot;]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>20GB</strong> Storage</li>
					<li><strong>200GB</strong> Bandwith</li>
					<li><strong>25</strong> Products</li>
					<li><strong>Basic</strong> Stats</li>
					<li><strong>Basic</strong> Customization</li>
				</ul>
				[/plan]

				[plan name=&quot;Platinum Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;29$&quot; per=&quot;per month&quot;]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>40GB</strong> Storage</li>
					<li><strong>500GB</strong> Bandwith</li>
					<li><strong>100</strong> Products</li>
					<li><strong>Complex</strong> Stats</li>
					<li><strong>Complex</strong> Customization</li>
				</ul>
				[/plan]

				[plan name=&quot;Diamond Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;49$&quot; per=&quot;month&quot; ]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>100GB</strong> Storage</li>
					<li><strong>1000GB</strong> Bandwith</li>
					<li><strong>Unlimited</strong> Products</li>
					<li><strong>Complex</strong> Stats</li>
					<li><strong>Complex</strong> Customization</li>
				</ul>
				[/plan]

				[plan name=&quot;Ultra Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;49$&quot; per=&quot;month&quot;]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>100GB</strong> Storage</li>
					<li><strong>1000GB</strong> Bandwith</li>
					<li><strong>Unlimited</strong> Products</li>
					<li><strong>Complex</strong> Stats</li>
					<li><strong>Complex</strong> Customization</li>
				</ul>
				[/plan]
				[/pricing-table]
				&lt;br /&gt;' => '5 Columns',
				'&lt;br /&gt;
				[pricing-table col=&quot;3&quot;]

				[plan name=&quot;Starter Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;0€&quot; per=&quot;per year&quot;]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>10GB</strong> Storage</li>
					<li><strong>100GB</strong> Bandwith</li>
					<li><strong>5</strong> Products</li>
					<li><strong>Basic</strong> Stats</li>
					<li><strong>Basic</strong> Customization</li>
				</ul>
				[/plan]

				[plan name=&quot;Gold Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;19$&quot; per=&quot;per month&quot;]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>20GB</strong> Storage</li>
					<li><strong>200GB</strong> Bandwith</li>
					<li><strong>25</strong> Products</li>
					<li><strong>Basic</strong> Stats</li>
					<li><strong>Basic</strong> Customization</li>
				</ul>
				[/plan]

				[plan name=&quot;Platinum Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;29$&quot; per=&quot;per month&quot;]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>40GB</strong> Storage</li>
					<li><strong>500GB</strong> Bandwith</li>
					<li><strong>100</strong> Products</li>
					<li><strong>Complex</strong> Stats</li>
					<li><strong>Complex</strong> Customization</li>
				</ul>
				[/plan]
				[/pricing-table]
				&lt;br /&gt;' => '2 Columns',
				'&lt;br /&gt;
				[pricing-table col=&quot;2&quot;]
				[plan name=&quot;Starter Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;0€&quot; per=&quot;per year&quot; ]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>10GB</strong> Storage</li>
					<li><strong>100GB</strong> Bandwith</li>
					<li><strong>5</strong> Products</li>
					<li><strong>Basic</strong> Stats</li>
					<li><strong>Basic</strong> Customization</li>
				</ul>
				[/plan]

				[plan name=&quot;Gold Edition&quot; link=&quot;http://www.google.com&quot; linkname=&quot;Sign Up&quot; price=&quot;19$&quot; per=&quot;per month&quot;]
				<ul>
					<li><strong>Free</strong> Setup</li>
					<li><strong>20GB</strong> Storage</li>
					<li><strong>200GB</strong> Bandwith</li>
					<li><strong>25</strong> Products</li>
					<li><strong>Basic</strong> Stats</li>
					<li><strong>Basic</strong> Customization</li>
				</ul>
				[/plan]
				[/pricing-table]
				&lt;br /&gt;' => '4 Columns'
			)
		)
	),
	'shortcode' => '{{columns}}',
	'popup_title' => __( 'Pricing Table Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);


/*-----------------------------------------------------------------------------------*/
/*	Counters Circle Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['counterscircle'] = array(
	'params' => array(

	),
	'shortcode' => '[counters_circle]{{child_shortcode}}[/counters_circle]', // as there is no wrapper shortcode
	'popup_title' => __('Counters Circle Shortcode', TDP_SHORTCODES_TEXTDOMAIN),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'value' => array(
				'type' => 'select',
				'label' => __('Filled Area Percentage', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('From 1% to 100%', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => tdp_shortcodes_range(100, false)
			),
			'filledcolor' => array(
				'type' => 'colorpicker',
				'label' => __('Filled Color', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Color for filled in area', TDP_SHORTCODES_TEXTDOMAIN)
			),
			'unfilledcolor' => array(
				'type' => 'colorpicker',
				'label' => __('Unfilled Color', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Color for unfilled area', TDP_SHORTCODES_TEXTDOMAIN)
			),
			'icon' => array(
				'type' => 'iconpicker',
				'label' => __('Select Icon (optional)', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Click an icon to select, click again to deselect', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => $icons
			),
			'content' => array(
				'std' => 'Text',
				'type' => 'text',
				'label' => __( 'Counter Circle Text', TDP_SHORTCODES_TEXTDOMAIN ),
				'desc' => __( 'Insert text for counter circle box, keep it short', TDP_SHORTCODES_TEXTDOMAIN ),
			)
		),
		'shortcode' => '[counter_circle icon="{{icon}}" filledcolor="{{filledcolor}}" unfilledcolor="{{unfilledcolor}}" value="{{value}}"]{{content}}[/counter_circle]',
		'clone_button' => __('Add New Counter Circle', TDP_SHORTCODES_TEXTDOMAIN)
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Counters Box Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['countersbox'] = array(
	'params' => array(

	),
	'shortcode' => '[counters_box]{{child_shortcode}}[/counters_box]', // as there is no wrapper shortcode
	'popup_title' => __('Counters Box Shortcode', TDP_SHORTCODES_TEXTDOMAIN),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'value' => array(
				'type' => 'select',
				'label' => __('Filled Area Percentage', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('From 1% to 100%', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => tdp_shortcodes_range(100, false)
			),
			'color' => array(
				'type' => 'colorpicker',
				'label' => __('Color', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Color for background', TDP_SHORTCODES_TEXTDOMAIN)
			),
			'content' => array(
				'std' => 'Text',
				'type' => 'text',
				'label' => __( 'Counter Box Text', TDP_SHORTCODES_TEXTDOMAIN ),
				'desc' => __( 'Insert text for counter box', TDP_SHORTCODES_TEXTDOMAIN ),
			)
		),
		'shortcode' => '[counter_box value="{{value}}"]{{content}}[/counter_box]',
		'clone_button' => __('Add New Counter Box', TDP_SHORTCODES_TEXTDOMAIN)
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Progress Bar Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['progress'] = array(
	'params' => array(
		'percent' => array(
			'type' => 'select',
			'label' => __('Filled Area Percentage', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('From 1% to 100%', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => tdp_shortcodes_range(100, false)
		),
		'text' => array(
			'std' => 'Text',
			'type' => 'text',
			'label' => __( 'Progess Bar Text', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Text will show up on progess bar', TDP_SHORTCODES_TEXTDOMAIN ),
		),
		'icon' => array(
				'type' => 'iconpicker',
				'label' => __('Select Icon (optional)', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Click an icon to select, click again to deselect', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => $icons
		),
		'style' => array(
			'type' => 'select',
			'label' => __( 'Type', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Select the type', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => array(
				'style1' => 'Icon with Boxed Line | No Title',
				'style2' => 'Icon with Line + Title',
				'style3' => 'Icon with Boxed',
				'style4' => 'Icon with Boxed + Color Filled',
				'style5' => 'Icon with Boxed + Title',
			)
		),
		'color' => array(
				'type' => 'colorpicker',
				'label' => __('Color', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Color for bar', TDP_SHORTCODES_TEXTDOMAIN)
		),
	),
	'shortcode' => '[tdp_progress_bar percent="{{percent}}" text="{{text}}" icon="{{icon}}" style="{{style}}" color="{{color}}"]', // as there is no wrapper shortcode
	'popup_title' => __('Progress Bar Shortcode', TDP_SHORTCODES_TEXTDOMAIN),
	'no_preview' => true,
);


/*-----------------------------------------------------------------------------------*/
/*	Columns Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['columns'] = array(
	'params' => array(
		'select_shortcode' => $select_shortcode
	),
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns Shortcode', TDP_SHORTCODES_TEXTDOMAIN),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __('Column Type', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Select the width of the column', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => array(
					'one_third' => 'One Third',
					'two_third' => 'Two Thirds',
					'one_half' => 'One Half',
					'one_fourth' => 'One Fourth',
					'three_fourth' => 'Three Fourth',
				)
			),
			
			'last' => array(
				'type' => 'select',
				'label' => __('Last Column', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => 'Choose if the column is last in a set. This has to be set to "Yes" for the last column in a set',
				'options' => $reverse_choices
			),
			'animation_type' => array(
				'type' => 'select',
				'label' => __( 'Animation Type', TDP_SHORTCODES_TEXTDOMAIN ),
				'desc' => __( 'Select the type on animation to use on the shortcode', TDP_SHORTCODES_TEXTDOMAIN ),
				'options' => array(
					'none' => 'None',
					'bounce' => 'Bounce',
					'fade' => 'Fade',
					'flash' => 'Flash',
					'shake' => 'Shake',
					'slide' => 'Slide',
				)
			),
			'animation_direction' => array(
				'type' => 'select',
				'label' => __( 'Direction of Animation', TDP_SHORTCODES_TEXTDOMAIN ),
				'desc' => __( 'Select the incoming direction for the animation', TDP_SHORTCODES_TEXTDOMAIN ),
				'options' => array(
					'down' => 'Down',
					'left' => 'Left',
					'right' => 'Right',
					'up' => 'Up',
				)
			),
			'animation_speed' => array(
				'type' => 'text',
				'std' => '',
				'label' => __( 'Speed of Animation', TDP_SHORTCODES_TEXTDOMAIN ),
				'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', TDP_SHORTCODES_TEXTDOMAIN ),
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Column Content', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Insert the column content', TDP_SHORTCODES_TEXTDOMAIN),
			)
		),
		'shortcode' => '[{{column}} last="{{last}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}"]{{content}}[/{{column}}] ',
		'clone_button' => __('Add Column', TDP_SHORTCODES_TEXTDOMAIN)
	)
);

/*-----------------------------------------------------------------------------------*/
/*	IconBox Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['iconbox'] = array(
	'params' => array(
		'image' => array(
				'type' => 'iconpicker',
				'label' => __('Select Icon (optional)', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Click an icon to select, click again to deselect', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => $icons
		),
		'title' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Icon Box Title', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Insert the title', TDP_SHORTCODES_TEXTDOMAIN),
		),
		'type' => array(
			'type' => 'select',
			'label' => __( 'Type', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Select the type', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => array(
				'standard' => 'Standard',
				'standard-title' => 'Standard Title Icon',
				'left-icon' => 'Left Icon',
				'left-icon-alt' => 'Left Icon Type 2',
				//'boxed-one' => 'Boxed Icon Box',
				'boxed-two' => 'Boxed Icon Box',
				//'boxed-three' => 'Boxed Icon Box Type 3',
				'boxed-four' => 'Boxed Icon Box Type 2',
				'animated' => 'Animated',
			)
		),
		'animation_type' => array(
			'type' => 'select',
			'label' => __( 'Animation Type', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Select the type on animation to use on the shortcode', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => array(
				'none' => 'None',
				'bounce' => 'Bounce',
				'fade' => 'Fade',
				'flash' => 'Flash',
				'shake' => 'Shake',
				'slide' => 'Slide',
			)
		),
		'animation_direction' => array(
			'type' => 'select',
			'label' => __( 'Direction of Animation', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Select the incoming direction for the animation', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => array(
				'down' => 'Down',
				'left' => 'Left',
				'right' => 'Right',
				'up' => 'Up',
			)
		),
		'animation_speed' => array(
			'type' => 'text',
			'std' => '',
			'label' => __( 'Speed of Animation', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Type in speed of animation in seconds (0.1 - 1)', TDP_SHORTCODES_TEXTDOMAIN ),
		),
		'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Content', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Insert the content', TDP_SHORTCODES_TEXTDOMAIN),
		),
		'icon_color' => array(
				'type' => 'colorpicker',
				'label' => __('Icon Color', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Color for icon', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'boxed_color' => array(
				'type' => 'colorpicker',
				'label' => __('Boxed Type Color', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Set the background color for the boxed type or animated type. This option is not support by any other type of icon box.', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'text_color' => array(
				'type' => 'colorpicker',
				'label' => __('Boxed Type Color', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Set the background color for the boxed type or animated type. This option is not support by any other type of icon box.', TDP_SHORTCODES_TEXTDOMAIN)
		),
	),
	'shortcode' => '[tdp_iconbox image="{{image}}" title="{{title}}" type="{{type}}" animation_type="{{animation_type}}" animation_direction="{{animation_direction}}" animation_speed="{{animation_speed}}" icon_color="{{icon_color}}" boxed_color="{{boxed_color}}" text_color="{{text_color}}"]{{content}}[/tdp_iconbox]', // as there is no wrapper shortcode
	'popup_title' => __('Progress Bar Shortcode', TDP_SHORTCODES_TEXTDOMAIN),
	'no_preview' => true,
);

/*-----------------------------------------------------------------------------------*/
/*	Image Frame Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['imageframe'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __('Frame style type', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Selected the frame style type', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => array(
				'none' => 'None',
				'border' => 'Border',
				'glow' => 'Glow',
				'dropshadow' => 'Drop Shadow',
				'bottomshadow' => 'Bottom Shadow'
			)
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Border Color', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'For border style type only', TDP_SHORTCODES_TEXTDOMAIN ),
		),
		'bordersize' => array(
			'std' => 0,
			'type' => 'select',
			'label' => __( 'Border Size', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'In pixels, only for border style type', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => tdp_shortcodes_range( 10, false, false, 0 )
		),
		'stylecolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Style Color', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'For all style types except border', TDP_SHORTCODES_TEXTDOMAIN ),
		),
		'align' => array(
			'std' => 'left',
			'type' => 'select',
			'label' => __( 'Align', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => 'Choose how to align the image',
			'options' => array(
				'left' => 'Left',
				'right' => 'Right',
				'center' => 'Center'
			)
		),
		'lightbox' => array(
			'type' => 'select',
			'label' => __('Image lightbox', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Show image in Lightbox', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => $reverse_choices
		),
		'image' => array(
			'type' => 'uploader',
			'label' => __('Image', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Upload an image to display in the frame'
		),
		'alt' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Image Alt Text', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'The alt attribute provides alternative information if an image cannot be viewed'
		),
	),
	'shortcode' => '[imageframe lightbox="{{lightbox}}" style="{{style}}" bordercolor="{{bordercolor}}" bordersize="{{bordersize}}px" stylecolor="{{stylecolor}}" align="{{align}}"]&lt;img alt="{{alt}}" src="{{image}}" /&gt;[/imageframe]',
	'popup_title' => __( 'Image Frame Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	Checklist Config
/*-----------------------------------------------------------------------------------*/
$tdp_shortcodes['checklist'] = array(
	'params' => array(

		'icon' => array(
			'type' => 'iconpicker',
			'label' => __('Select Icon', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Click an icon to select, click again to deselect', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => $icons
		),
		'iconcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Icon Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Leave blank for default', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'circle' => array(
			'type' => 'select',
			'label' => __('Icon in Circle', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Choose to display the icon in a circle', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => $choices
		),
	),

	'shortcode' => '[checklist icon="{{icon}}" iconcolor="{{iconcolor}}" circle="{{circle}}"]&lt;ul&gt;{{child_shortcode}}&lt;/ul&gt;[/checklist]',
	'popup_title' => __('Checklist Shortcode', TDP_SHORTCODES_TEXTDOMAIN),
	'no_preview' => true,

	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'content' => array(
				'std' => 'Your Content Goes Here',
				'type' => 'textarea',
				'label' => __( 'List Item Content', TDP_SHORTCODES_TEXTDOMAIN ),
				'desc' => __( 'Add list item content', TDP_SHORTCODES_TEXTDOMAIN ),
			),
		),
		'shortcode' => '&lt;li&gt;{{content}}&lt;/li&gt;',
		'clone_button' => __('Add New List Item', TDP_SHORTCODES_TEXTDOMAIN)
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['tabs'] = array(
	'params' => array(

		'layout' => array(
			'type' => 'select',
			'label' => __('Layout', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Choose the layout of the shortcode',
			'options' => array(
				'horizontal' => 'Horizontal',
				'vertical' => 'Vertical'
			)
		),
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Leave blank for default'
		),
		'inactivecolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Inactive Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Leave blank for default'
		),
	),
	'no_preview' => true,
	'shortcode' => '[tdp_tabs layout="{{layout}}" backgroundcolor="{{backgroundcolor}}" inactivecolor="{{inactivecolor}}"]{{child_shortcode}}[/tdp_tabs]',
	'popup_title' => __('Insert Tab Shortcode', TDP_SHORTCODES_TEXTDOMAIN),

	'child_shortcode' => array(
		'params' => array(
			'title' => array(
				'std' => 'Title',
				'type' => 'text',
				'label' => __('Tab Title', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Title of the tab', TDP_SHORTCODES_TEXTDOMAIN),
			),
			'content' => array(
				'std' => 'Tab Content',
				'type' => 'textarea',
				'label' => __('Tab Content', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Add the tabs content', TDP_SHORTCODES_TEXTDOMAIN)
			)
		),
		'shortcode' => '[tdp_tab title="{{title}}"]{{content}}[/tdp_tab]',
		'clone_button' => __('Add Tab', TDP_SHORTCODES_TEXTDOMAIN)
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Person Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['person'] = array(
	'no_preview' => true,
	'params' => array(

		'img' => array(
			'type' => 'uploader',
			'label' => __('Picture', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Upload an image to display'
		),
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Name', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Insert the name of the person'
		),
		'role' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Title', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Insert the title of the person'
		),
		'mail' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Email Address', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Insert an email address to display the email icon'
		),
		'facebook' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Facebook Profile Link', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Insert a url to display the facebook icon'
		),
		'twitter' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Twitter Profile Link', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Insert a url to display the twitter icon'
		),
		'linkedin' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('LinkedIn Profile Link', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Insert a url to display the linkedin icon'
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Profile Description', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Enter the content to be displayed'
		),
	),
	'shortcode' => '[tdp_team img="{{img}}" name="{{name}}" role="{{role}}" mail="{{mail}}" facebook="{{facebook}}" twitter="{{twitter}}" linkedin="{{linkedin}}"]{{content}}[/tdp_team]',
	'popup_title' => __( 'Person Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	Testimonials Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['testimonials'] = array(
	'params' => array(

		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Background Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Leave blank for default'
		),
		'textcolor' => array(
			'type' => 'colorpicker',
			'std' => '',
			'label' => __('Text Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Leave blank for default'
		),
	),
	'no_preview' => true,
	'shortcode' => '[testimonials backgroundcolor="{{backgroundcolor}}" textcolor="{{textcolor}}"]{{child_shortcode}}[/testimonials]',
	'popup_title' => __('Insert Testimonials Shortcode', TDP_SHORTCODES_TEXTDOMAIN),

	'child_shortcode' => array(
		'params' => array(
			'name' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Name', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => 'Insert the name of the person',
			),
			'gender' => array(
				'type' => 'select',
				'label' => __('Gender', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => 'Choose male or female',
				'options' => array(
					'male' => 'Male',
					'female' => 'Female'
				)
			),
			'company' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Company', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => 'Insert the name of the company',
			),
			'link' => array(
				'std' => '',
				'type' => 'text',
				'label' => __('Link', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => 'Add the url the company name will link to'
			),
			'target' => array(
				'type' => 'select',
				'label' => __('Target', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('_self = open in same window <br />_blank = open in new window', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => array(
					'_self' => '_self',
					'_blank' => '_blank'
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Testimonial Content', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => 'Add the testimonial content'
			)
		),
		'shortcode' => '[testimonial name="{{name}}" gender="{{gender}}" company="{{company}}" link="{{link}}" target="{{target}}"]{{content}}[/testimonial]',
		'clone_button' => __('Add Testimonial', TDP_SHORTCODES_TEXTDOMAIN)
	)
);


/*-----------------------------------------------------------------------------------*/
/*	Video Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['video'] = array(
	'no_preview' => true,
	'params' => array(

		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Enter Title If Any', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => ''
		),
		'type' => array(
				'type' => 'select',
				'label' => __('Video Type', TDP_SHORTCODES_TEXTDOMAIN),
				'desc' => __('Select Video Type', TDP_SHORTCODES_TEXTDOMAIN),
				'options' => array(
					'url' => 'External Custom URL',
					'embed' => 'HTML5 Video Video'
				)
		),
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Enter Video Url', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => ''
		),
		'poster' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Poster IMG for uploaded video', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => ''
		),
		'embed' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Video Embed Code', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Enter the video embed code if you select html5 as video type option'
		),
		'color' => array(
			'type' => 'colorpicker',
			'label' => __('Player Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Pick a player color', TDP_SHORTCODES_TEXTDOMAIN)
		),
	),
	'shortcode' => '[tdp_video title="{{title}}" type="{{type}}" url="{{url}}" poster="{{}}" embed="{{embed}}" color="{{color}}"]',
	'popup_title' => __( 'Video Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	Fullwidth Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['fullwidth'] = array(
	'no_preview' => true,
	'params' => array(
		'backgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __('Background Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Leave blank for default', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'overlay' => array(
			'type' => 'select',
			'label' => __('Add Background Overlay?', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Select yes if you wish to add a transparent color overlay for the fullwidth section. The color of the overlay can be set through the background color option above here.',
			'options' => array(
				'no' => 'No Thanks',
				'yes' => 'Yes Please'
			)
		),
		'backgroundimage' => array(
			'type' => 'uploader',
			'label' => __('Backgrond Image', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => 'Upload an image to display in the background'
		),
		'backgroundrepeat' => array(
			'type' => 'select',
			'label' => __('Background Repeat', TDP_SHORTCODES_TEXTDOMAIN),
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
			'label' => __('Background Position', TDP_SHORTCODES_TEXTDOMAIN),
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
			'label' => __('Background Scroll', TDP_SHORTCODES_TEXTDOMAIN),
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
			'label' => __( 'Border Size', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'In pixels', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => tdp_shortcodes_range( 10, false )
		),
		'bordercolor' => array(
			'type' => 'colorpicker',
			'label' => __('Border Color', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Leave blank for default', TDP_SHORTCODES_TEXTDOMAIN)
		),
		'paddingtop' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Top', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'In pixels', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => tdp_shortcodes_range( 100, false )
		),
		'paddingbottom' => array(
			'std' => 20,
			'type' => 'select',
			'label' => __( 'Padding Bottom', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'In pixels', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => tdp_shortcodes_range( 100, false )
		),
		'center' => array(
			'type' => 'select',
			'label' => __('Centered?', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select if you wish to center the text in the middle', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => $reverse_choices
		),
		'lighttext' => array(
			'type' => 'select',
			'label' => __('Use light text colors?', TDP_SHORTCODES_TEXTDOMAIN),
			'desc' => __('Select if you wish to use light colors for specific text into the section, useful when the background is dark with text hard to read on top of it.', TDP_SHORTCODES_TEXTDOMAIN),
			'options' => $reverse_choices
		),
		'content' => array(
			'std' => 'Your Content Goes Here',
			'type' => 'textarea',
			'label' => __( 'Content', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Add content', TDP_SHORTCODES_TEXTDOMAIN ),
		),
	),
	'shortcode' => '[fullwidth backgroundcolor="{{backgroundcolor}}" overlay="{{overlay}}" backgroundimage="{{backgroundimage}}" backgroundrepeat="{{backgroundrepeat}}" backgroundposition="{{backgroundposition}}" backgroundattachment="{{backgroundattachment}}" bordersize="{{bordersize}}px" bordercolor="{{bordercolor}}" paddingTop="{{paddingtop}}px" paddingBottom="{{paddingbottom}}px" center="{{center}}" lighttext="{{lighttext}}"]{{content}}[/fullwidth]',
	'popup_title' => __( 'Fullwidth Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);

/*-----------------------------------------------------------------------------------*/
/*	latest posts Config
/*-----------------------------------------------------------------------------------*/

$tdp_shortcodes['latest_posts'] = array(
	'no_preview' => true,
	'params' => array(

		'amount' => array(
			'std' => 5,
			'type' => 'select',
			'label' => __( 'How Many Posts?', TDP_SHORTCODES_TEXTDOMAIN ),
			'desc' => __( 'Select the amount', TDP_SHORTCODES_TEXTDOMAIN ),
			'options' => tdp_shortcodes_range( 10, false )
		),
		
	),
	'shortcode' => '[latest_posts amount="{{amount}}"]',
	'popup_title' => __( 'Latest Posts Shortcode', TDP_SHORTCODES_TEXTDOMAIN )
);