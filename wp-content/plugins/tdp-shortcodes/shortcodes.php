<?php

//////////////////////////////////////////////////////////////////
// Heading
//////////////////////////////////////////////////////////////////

add_shortcode('heading', 'tdp_heading');
function tdp_heading($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'type' => 'h1',
		'title' => '',
		'subtitle' => '',
		'icon' => ''
	), $atts));

	//add icon
	$add_icon = null;
	if($icon) {
		$add_icon = '<i class="icon-'.$icon.'"></i>';
	}

	if($type == 'line' ) {

		$html = '<h4 class="lined">' . $add_icon . $title . '</h4>';

	} else if($type == 'big') {

		$html = '<h1 class="heading-with-sub">' . $add_icon . $title . '</h1>';
		$html .= '<h4 class="heading-sub">' . $subtitle . '</h4>';

	} else if($type == 'boxed') {

		$html = '<div class="heading-boxed">
					<span class="heading-icon">'.$add_icon.'</span>
					<div class="heading-content">
						<h3>'. $title .'</h3>
						<p>'.$subtitle.'</p>
					</div>
				</div>';

	} else {

		$html = '<'.$type.'>' . $add_icon . $title . '</'.$type.'>';

	}

	return $html;

}

//////////////////////////////////////////////////////////////////
// Highlight shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('highlight', 'tdp_shortcode_highlight');
function tdp_shortcode_highlight($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'color' => 'yellow',
			), $atts);

			if($atts['color'] == 'black') {
				return '<span class="highlight2" style="background-color:'.$atts['color'].';">' .do_shortcode($content). '</span>';
			} else {
				return '<span class="highlight1" style="background-color:'.$atts['color'].';">' .do_shortcode($content). '</span>';
			}

}

//////////////////////////////////////////////////////////////////
// Quote shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('quote', 'tdp_shortcode_quote');
function tdp_shortcode_quote($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'' => '',
			), $atts);
			
		return '<blockquote>' .do_shortcode($content). '</blockquote>';
}

//////////////////////////////////////////////////////////////////
// Highlight shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('spacer', 'tdp_space_shortcode');
function tdp_space_shortcode($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'space' => '50px',
			), $atts);

		return '<div class="space" style="height:'.$atts['space'].';"></div>';
}

//////////////////////////////////////////////////////////////////
// Accordion shortcode
//////////////////////////////////////////////////////////////////
function tdp_accordion_section( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'title' => '',
		'animation' => '',
		'border' => '',
        'extra_class' => ''
	), $atts ) );

	$title = isset($title) && $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';

	return $title."<div class='tdp_element tt_accordion $animate_class $extra_class ".($border=='1' ? 'bordered' : '')."'>".do_shortcode($content)."</div>";
}
add_shortcode( 'tdp_accordion', 'tdp_accordion_section' );


function tdp_accordion_item( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'title' => 'Accordion Section',
		'icon' => '',
		'collapse' => ''
	), $atts ) );
	return '<div class="accordion_title '.($collapse=='1' ? 'current' : '').'">
				<a href="#" title="">'.($icon!='' ? "<i class='icon-$icon'></i>" : '').do_shortcode($title).'</a>
				<span class="accordion_arrows"><i class="icon-angle-down"></i><i class="icon-angle-up"></i></span>
			</div>
			<div class="accordion_content">'.do_shortcode($content).'</div>';
}
add_shortcode( 'accordion_item', 'tdp_accordion_item' );

//////////////////////////////////////////////////////////////////
// Button shortcode
//////////////////////////////////////////////////////////////////

add_shortcode('button', 'tdp_button_shortcode');
function tdp_button_shortcode($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'url' => '',
		'color' => '',
		'target' => '',
		'size' => ''
	), $atts));

	return '<a class="btn '.$color.' '.$size.'" href="'.$url.'" target="'.$target.'">'.do_shortcode($content)."</a>";

}


//////////////////////////////////////////////////////////////////
// Audio shortcode
//////////////////////////////////////////////////////////////////

function tdp_audio_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'type' => 'url',
                'url' => '',
                'embed' => '',
                'color' => '#3a87ad',
                'animation' => '',
                'extra_class' => ''
                    ), $atts));

    $uniqid = uniqid();

    $result = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';
    if ($type == 'url') {
        $result .= get_audio_player($url, $color, $extra_class, $uniqid);
        return $result;
    }
    else{
        return $result."<div class='tdp_element tdp_elem_audio audio_embed $extra_class'>".urldecode($embed)."</div>";
    }

    return $result;
}

add_shortcode('tdp_audio', 'tdp_audio_shortcode');

//////////////////////////////////////////////////////////////////
// Callout shortcode
//////////////////////////////////////////////////////////////////
function tdp_callout ($attributes, $content = null)
	{
		$attributes = shortcode_atts(
			array(
				'type' => 'grey',
				'controls' => 'right',
				'title' => 'ActionBox title',
				'title_size' => 'h2',
				'message' => '',
				'button1' => '',
				'link1' => '',
				'style1' => 'default',
				'size1' => '',
				'button2' => '',
				'link2' => '',
				'style2' => 'default',
				'size2' => '',
				'fullwidth' => 'no',
				'color' => '',
				'textcolor' => '',
				'headingtextcolor' => '',
				'animate' => '',
			), $attributes);


		$animate_class = ($attributes['animate'] != '')?' animate_'.$attributes['animate']:'';

		$controls_position_class = ($attributes['controls'] != 'bottom')?' at_right':'';
		$actionbox_controls_position_class = ($attributes['controls'] != 'bottom')?' controls_aside':'';

		if($attributes['fullwidth'] == '1') {

		$output = '<div class="tdp_row_fullwidth " style="background:'.$attributes['color'].'">';

		}

		$is_full = null;
		if($attributes['fullwidth'] == '1') {
			$is_full = 'inner-action';
		}

		$has_text = null;
		if ($attributes['message'] != '') {
			$has_text = 'has_subline';
		}


		$output .= 	'<div class="'.$is_full.' w-actionbox '.$actionbox_controls_position_class.$animate_class.'" style="background:'.$attributes['color'].';color:'.$attributes['textcolor'].'">'.
			'<div class="w-actionbox-h">'.
			'<div class="w-actionbox-text '.$has_text.'">';
		if ($attributes['title'] != '')
		{
			$output .= 			'<h3 style="color:'.$attributes['headingtextcolor'].'">'.html_entity_decode($attributes['title']).'</h3>';
		}
		if ($attributes['message'] != '')
		{
			$output .= 			'<p>'.html_entity_decode($attributes['message']).'</p>';
		}


		$output .=			'</div>'.
			'<div class="w-actionbox-controls'.$controls_position_class.'">';

		if ($attributes['button1'] != '' AND $attributes['link1'] != '')
		{
			$output .= 			'<a class="w-actionbox-button  '.$attributes['size1'].'" style="background:'.$attributes['style1'].';" href="'.$attributes['link1'].'"><span>'.$attributes['button1'].'</span></a>';
		}
		if ($attributes['button2'] != '' AND $attributes['link2'] != '')
		{
			$output .= 			'<a class="w-actionbox-button  '.$attributes['size2'].'" style="background:'.$attributes['style2'].';" href="'.$attributes['link2'].'"><span>'.$attributes['button2'].'</span></a>';
		}

		$output .=			'</div>'.
			'</div>'.
			'</div>
			';

		if($attributes['fullwidth'] == '1') {
			$output .= '</div>';
		}

		return $output;
	}

add_shortcode('tdp_callout', 'tdp_callout');


//////////////////////////////////////////////////////////////////
// contentbox shortcode
//////////////////////////////////////////////////////////////////
function tdp_contentbox( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'widget_title' => '',
		'title' => '',
		'color' => 'transparent',
		'cbox_style' => '',
		'icon' => '',
		'animation' => '',
		'extra_class' => ''
	), $atts ) );

	$widget_title = $widget_title!='' ? "<h3 class='element_title'>$widget_title</h3>" : '';

	return "$widget_title
			<div class='tdp_element tdp_elem_content_box $style ".($cbox_style=='custom' ? $color : '')." $extra_class' style='".($cbox_style=='custom' ? "background-color: $color; color: #FFF;" : '')."'>
				<h3 style='".($cbox_style=='custom' ? "background-color: $color; color: #FFF;" : '')."'><i class='icon-$icon'></i> $title</h3>
				<div class='tdp_elem_content_box_content'>
					".do_shortcode($content)."
				</div>
			</div>";
}
add_shortcode( 'tdp_contentbox', 'tdp_contentbox' );

//////////////////////////////////////////////////////////////////
// divider shortcode
//////////////////////////////////////////////////////////////////
function tdp_divider($atts, $content = null) {
    extract(shortcode_atts(array(
                'text' => 'Top',
                'style' => 'style1',
                'color' => '#00b4cc',
                'height' => '5',
                'extra_class' => ''
                    ), $atts));
    $height_style = "style='height:$height" . "px'";
    $custom_style = "style='height:$height" . "px;background-color:$color'";
    
    if ($style == 'style1')
        return "<div class='tdp_element tdp_elem_divider style1 $extra_class'></div>";
    elseif ($style == 'style2')
        return "<div class='tdp_element tdp_elem_divider style2 $extra_class'></div>";
    elseif ($style == 'style3')
        return "<div class='tdp_element tdp_elem_divider style3 $extra_class'></div>";
    elseif ($style == 'style4')
        return "<div class='tdp_element tdp_elem_divider style4 $extra_class'></div>";
    elseif ($style == 'style5')
        return "<div class='tdp_element tdp_elem_divider style5 $extra_class'></div>";
    elseif ($style == 'style6')
        return "<div class='tdp_element tdp_elem_divider style6 $extra_class'><span class='gototop'>$text <i class='icon-arrow-up'></i></div>";
    elseif ($style == 'style7')
        return "<div class='tdp_element tdp_elem_divider style7 $extra_class' $custom_style></div>";
    elseif ($style == 'style8')
        return "<div class='tdp_element tdp_elem_divider style8 $extra_class' $custom_style></div>";
    elseif ($style == 'style9')
        return "<div class='tdp_element tdp_elem_divider style9 $extra_class'></div>";
    elseif ($style == 'style11')
        return "<div $height_style></div>";
    else
        return "<div class='tdp_element tdp_elem_divider style10 $extra_class'></div>";
}
add_shortcode('tdp_divider', 'tdp_divider');

//////////////////////////////////////////////////////////////////
// gallery
//////////////////////////////////////////////////////////////////

add_action('wp_ajax_get_tdp_element_galleryimg', 'tdp_ajax_gallery_hook');
add_action('wp_ajax_nopriv_get_tdp_element_galleryimg', 'tdp_ajax_gallery_hook');
function tdp_ajax_gallery_hook() {
    try {
		if( isset($_POST['images']) && $_POST['images']!='' ){
			$arr = explode(',', trim($_POST['images']));
			$counter = 0;
			$images = '';
			foreach ($arr as $value) {
				if( $value!='' ){
					$images .= ($counter==0 ? '' : '^').wp_get_attachment_url($value);
					$counter++;
				}
			}
			echo $images;
		}
		else{
			echo "-1";
		}
    }
    catch (Exception $e) {
    	echo "-1";
    }
    exit;
}



function tdp_gallery( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'title' => '',
		'images' => '',
		'layout' => '1',
		'animation' => '',
		'extra_class' => ''
	), $atts ) );
	
	$title = isset($title) && $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';

	$uid = uniqid();
	
	if( $images!='' ){
		$img_array = explode(',', $images);
		$html = '';

		if( $layout=='2' ){
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = aq_resize($attach_url, 150, 150, true);
				$prev = aq_resize($attach_url, 600, 320, true);
				
				$html .= '<a href="'.$attach_url.'" data-preview="'.$prev.'">
							<span class="thumb">
								<img src="'.$img.'" />
								<div class="hovercover">
						            <div class="hovericon"><i class="icon-eye"></i></div>
						         </div>
							</span>
						</a>';			
			}
			return $title.'<div class="tdp_element tdp_gallery gallery_layout'.$layout.' '.$extra_class.' '.$animate_class.'">
						<span class="gallery_preview"><span class="preview_panel"></span></span>
						<span class="gallery_thumbs">'.$html.'</span>
					</div>';
		}
		else if( $layout=='3' ){
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = aq_resize($attach_url, 800, 430, true);
				
				$html .= '<img src="'.$img.'" />';
			}
			return $title.'<div class="tdp_element tdp_gallery gallery_layout_slider '.$extra_class.' '.$animate_class.'">
						<span class="gallery_preview">'.$html.'</span>
						<span class="gallery_pager"></span>
					</div>';
		}
		else if( $layout=='4' ){
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = aq_resize($attach_url, 800, 450, true);
				
				$html .= '<div style="background-image:url('.$img.');"></div>';
			}
			return $title.'<div class="tdp_element tdp_gallery gallery_imac '.$animate_class.'">
						<div class="device-mockup imac">
			                <div class="device">
			                    <div class="screen">
			                        <div class="gallery_viewport">'.$html.'</div>
			                    </div>
			                </div>
			            </div>
			            <a href="javascript:;" class="gallery_prev"><i class="icon-chevron-left"></i></a>
			            <a href="javascript:;" class="gallery_next"><i class="icon-chevron-right"></i></a>
		            </div>';
		}
		else if( $layout=='5' ){
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = aq_resize($attach_url, 800, 500, true);
				
				$html .= '<div style="background-image:url('.$img.');"></div>';
			}
			return $title.'<div class="tdp_element tdp_gallery gallery_laptop '.$animate_class.'">
						<div class="device-mockup macbook">
			                <div class="device">
			                    <div class="screen">
			                        <div class="gallery_viewport">'.$html.'</div>
			                    </div>
			                </div>
			            </div>
			            <a href="javascript:;" class="gallery_prev"><i class="icon-chevron-left"></i></a>
			            <a href="javascript:;" class="gallery_next"><i class="icon-chevron-right"></i></a>
		            </div>';
		}
		else if( $layout=='6' ){
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = aq_resize($attach_url, 640, 1130, true);
				
				$html .= '<div style="background-image:url('.$img.');"></div>';
			}
			return $title.'<div class="tdp_element tdp_gallery gallery_iphone '.$animate_class.'">
						<div class="device-mockup iphone5 portrait white">
			                <div class="device">
			                    <div class="screen">
			                        <div class="gallery_viewport">'.$html.'</div>
			                    </div>
			                    <div class="button"></div>
			                </div>
			            </div>
			            <a href="javascript:;" class="gallery_prev"><i class="icon-chevron-left"></i></a>
			            <a href="javascript:;" class="gallery_next"><i class="icon-chevron-right"></i></a>
		            </div>';
		}
		else{
            // Layout 1
			foreach ($img_array as $img_id) {
				$attach_url = wp_get_attachment_url($img_id);
				$img = aq_resize($attach_url, 150, 150, true);
				$prev = '';
				
				$html .= '<a href="'.$attach_url.'" data-preview="'.$prev.'">
							<span class="thumb">
								<img src="'.$img.'" />
								<div class="hovercover">
						            <div class="hovericon"><i class="icon-eye"></i></div>
						         </div>
							</span>
						</a>';			
			}
			return $title.'<div class="tdp_element tdp_gallery gallery_layout tdp-gallery'.$layout.' '.$extra_class.' '.$animate_class.'">
						<span class="gallery_preview"><span class="preview_panel"></span></span>
						<span class="gallery_thumbs">'.$html.'</span>
					</div>';
		}
	}
	
	return '';
}
add_shortcode( 'tdp_gallery', 'tdp_gallery' );


//////////////////////////////////////////////////////////////////
// Google Map
//////////////////////////////////////////////////////////////////
add_shortcode('map', 'shortcode_google_map');
function shortcode_google_map($atts, $content = null) {
	wp_enqueue_script( 'gmaps.api' );
	wp_enqueue_script( 'jquery.ui.map' );

	extract(shortcode_atts(array(
		'address' => '',
		'type' => 'satellite',
		'width' => '100%',
		'height' => '300px',
		'zoom' => '14',
		'scrollwheel' => 'true',
		'scale' => 'true',
		'zoom_pancontrol' => 'true',
	), $atts));

	static $avada_map_counter = 1;

	if($scrollwheel == 'yes') {
		$scrollwheel = 'true';
	} elseif($scrollwheel == 'no') {
		$scrollwheel = 'false';
	}

	if($scale == 'yes') {
		$scale = 'true';
	} elseif($scale == 'no') {
		$scale = 'false';
	}

	if($zoom_pancontrol == 'yes') {
		$zoom_pancontrol = 'true';
	} elseif($zoom_pancontrol == 'no') {
		$zoom_pancontrol = 'false';
	}

	$addresses = explode('|', $address);

	$markers = '';
	foreach($addresses as $address_string) {
		$markers .= "{
			address: '{$address_string}',
			html: {
				content: '{$address_string}',
				popup: true
			}
		},";
	}

	if(!$data['status_gmap']) {
		$html = "<script type='text/javascript'>
		jQuery(document).ready(function($) {
			jQuery('#gmap-{$avada_map_counter}').goMap({
				address: '{$addresses[0]}',
				zoom: {$zoom},
				scrollwheel: {$scrollwheel},
				scaleControl: {$scale},
				navigationControl: {$zoom_pancontrol},
				maptype: '{$type}',
				markers: [{$markers}]
			});
		});
		</script>";
	}

	$html .= '<div class="shortcode-map" id="gmap-'.$avada_map_counter.'" style="width:'.$width.';height:'.$height.';">';
	$html .= '</div>';

	$avada_map_counter++;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Notifications
//////////////////////////////////////////////////////////////////

function tdp_notification( $atts, $content=null ) {
	extract( shortcode_atts( array(
		'icon' => '',
		'type' => '',
        'animation' => '',
        'extra_class' => '',
        'animation_type' => '',
		'animation_direction' => 'left',
		'animation_speed' => ''
	), $atts));

	$direction_suffix = '';
	$animation_class = '';
	$animation_attribues = '';
	if($animation_type !== 'none') {
		$animation_class = ' animated';
		if($animation_type != 'flash' && $animation_type != 'shake') {
			$direction_suffix = 'In'.ucfirst($animation_direction);
			$animation_type .= $direction_suffix;
		}
		$animation_attribues = ' animation_type="'.$animation_type.'"';

		if($animation_speed) {
			$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
		}
	}

	$set_icon = null;
	if($icon) {
		$set_icon = '<i class="icon-'.$icon.'"></i>';
	}

	return '<div class="alert-box '.$type.$animation_class.'"'.$animation_attribues.'">
		<a href="#" class="icon-cancel close" data-dismiss="alert"></a>
		<div class="alert-content">'.$set_icon.do_shortcode($content).'</div>
	</div>';
}
add_shortcode( 'tdp_notification', 'tdp_notification' );

/*-----------------------------------------------------------------------------------*/
/* Pricing Table */
/*-----------------------------------------------------------------------------------*/

function hangar_plan( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'name'      => 'Premium',
		'link'      => 'http://www.google.com',
		'linkname'      => 'Sign Up',
		'price'      => '39.00$',
		'per'      => false,
		'color'    => false, // grey, green, red, blue
		'featured' => ''
    ), $atts));
    
    if($featured != '') {
    	$return = "<div class='featured' style='background-color:".$color.";'>".$featured."</div>";
    }
    else{
	    $return = "";
    }

    if($per != false) {
    	$return3 = "".$per."";
    }
    else{
    	$return3 = "";
    }
    $return5 = "";
    if($color != false) {
    	if($featured == true){
    		$return5 = "style='color:".$color.";' ";
    	}
    	$return4 = "style='color:".$color.";' ";
    }
    else{
    	$return4 = "";
    }
	
	$out = "
		<div class='plan'>	
			".$return."
			<div class='plan-head'><h3 ".$return4.">".$name."</h3>
			<div class='price' ".$return4.">".$price." <span>".$return3."</span></div></div>
			<ul>" .do_shortcode($content). "</ul><div class='signup'><a class='button' href='".$link."'>".$linkname."<span></span></a></div>
		</div>";
    return $out;
}

/*-----------------------------------------------------------------------------------*/

function hangar_pricing( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'col'      => '3'
    ), $atts));
	
	$out = "<div class='pricing-table col-".$col."'>" .do_shortcode($content). "</div><div class='clear'></div>";
    return $out;
}

add_shortcode('plan', 'hangar_plan');
add_shortcode('pricing-table', 'hangar_pricing');



//////////////////////////////////////////////////////////////////
// Counters (Circle)
//////////////////////////////////////////////////////////////////
add_shortcode('counters_circle', 'shortcode_counters_circle');
function shortcode_counters_circle($atts, $content = null) {
	$html = '<div class="counters-circle clearfix">';
	$html .= do_shortcode($content);
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Counter (Circle)
//////////////////////////////////////////////////////////////////
add_shortcode('counter_circle', 'shortcode_counter_circle');
function shortcode_counter_circle($atts, $content = null) {
	global $data;

	wp_enqueue_script( 'jquery.waypoint' );
	wp_enqueue_script( 'jquery.gauge' );

	extract(shortcode_atts(array(
		'filledcolor' => '',
		'unfilledcolor' => '',
		'value' => '70',
		'icon' => ''
	), $atts));

	if(!$filledcolor) {
		$filledcolor = $data['counter_filled_color'];
	}

	if(!$unfilledcolor) {
		$unfilledcolor = $data['counter_unfilled_color'];
	}

	static $avada_counter_circle = 1;

	if(!$data['status_gauge']) {
		$html = "<script type='text/javascript'>
		jQuery(document).ready(function() {
			var opts = {
			  lines: 12, // The number of lines to draw
			  angle: 0.5, // The length of each line
			  lineWidth: 0.05, // The line thickness
			  colorStart: '{$filledcolor}',   // Colors
			  colorStop: '{$filledcolor}',    // just experiment with them
			  strokeColor: '{$unfilledcolor}',   // to see which ones work best for you
			  generateGradient: false
			};
			var gauge_{$avada_counter_circle} = new Donut(document.getElementById('counter-circle-{$avada_counter_circle}')).setOptions(opts); // create sexy gauge!
			gauge_{$avada_counter_circle}.maxValue = 100; // set max gauge value
			gauge_{$avada_counter_circle}.animationSpeed = 128; // set animation speed (32 is default value)
			gauge_{$avada_counter_circle}.set({$value}); // set actual value
		});
		</script>";
	}

	$html .= '<div class="counter-circle-wrapper">';
	$html .= '<canvas width="220" height="220" class="counter-circle" id="counter-circle-'.$avada_counter_circle.'">';
	$html .= '</canvas>';
	$html .= '<div class="counter-circle-content">';
	if($icon) {
		$html .= '<i class="icon-'.$icon.'"></i>';
	} else {
		$html .= do_shortcode($content);
	}
	$html .= '</div>';
	$html .= '</div>';

	$avada_counter_circle++;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Counters Box
//////////////////////////////////////////////////////////////////
add_shortcode('counters_box', 'shortcode_counters_box');
function shortcode_counters_box($atts, $content = null) {
	$html = '<div class="counters-box">';
	$html .= do_shortcode($content);
	$html .= '</div>';

	return $html;
}

//////////////////////////////////////////////////////////////////
// Counter Box
//////////////////////////////////////////////////////////////////
add_shortcode('counter_box', 'shortcode_counter_box');
function shortcode_counter_box($atts, $content = null) {
	extract(shortcode_atts(array(
		'value' => '70',
		'color' => ''
	), $atts));

	$html = '';
	if($color) {
		$html .= '<div class="counter-box-wrapper counter-box-color" style="background:'.$color.'; color:white">';
	} else {
		$html .= '<div class="counter-box-wrapper">';
	}
	$html .= '<div class="content-box-percentage">';
	$html .= '<span class="display-percentage" data-percentage="'.$value.'">0</span><span class="percent">%</span>';
	$html .= '</div>';
	$html .= '<div class="counter-box-content">';
	$html .= do_shortcode($content);
	$html .= '</div>';
	$html .= '</div>';

	return $html;
}


//////////////////////////////////////////////////////////////////
// Progress Bar
//////////////////////////////////////////////////////////////////

function tdp_progress_bar($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'text' => 'Progress Bar',
                'percent' => '60',
                'icon' => 'icon-smile',
                'style' => 'style1',
                'color' => '#000',
                'extra_class' => ''
                    ), $atts));

    $result = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';

    if ($style == 'style1') {
        $result .= "<div class='tdp_element tdp_elem_progress $style $extra_class' style='color:$color;'>
                            <div class='tdp_progress_bar'>
                                    <div class='tdp_progress_line_container' style='width: $percent%;'>
                                            <div class='tdp_progress_line' style='background-color:$color; box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);'></div>
                                    </div>
                            </div>
                            <span class='tdp_progress_icon'><i class='icon-$icon'></i></span>
                            <span class='tdp_progress_label'>$percent%</span>
                    </div>";
    } else if ($style == 'style2') {
        $result .= "<div class='tdp_element tdp_elem_progress $style $extra_class' style='color:$color;'>
                            <span class='tdp_progress_title'><i class='icon-$icon'></i> $text</span>
                            <span class='tdp_progress_label'>$percent%</span>
                            <div class='tdp_progress_bar' style='border-color:$color;'>
                                    <div class='tdp_progress_line_container' style='width: $percent%;'>
                                            <div class='tdp_progress_line' style='background-color:$color;'></div>
                                    </div>
                            </div>
                    </div>";
    } else if ($style == 'style3') {
        $result .= "<div class='tdp_element tdp_elem_progress $style $extra_class' style='color:$color;'>
                            <div class='tdp_progress_line_container' style='width: $percent%;'>
                                    <div class='tdp_progress_line' style='background-color:$color;'>
                                            <span class='tdp_progress_icon'><i class='icon-$icon'></i></span>
                                            <span class='tdp_progress_label'>$percent%</span>
                                    </div>
                            </div>
                    </div>";
    } else if ($style == 'style4') {
        $result .= "<div class='tdp_element tdp_elem_progress $style $extra_class' style='color:$color;background-color:$color;'>
                            <div class='tdp_progress_line_container' style='width: $percent%;'>
                                    <div class='tdp_progress_line'>
                                            <span class='tdp_progress_icon'><i class='icon-$icon'></i></span>
                                            <span class='tdp_progress_label'>$percent%</span>
                                    </div>
                            </div>
                    </div>";
    } else if ($style == 'style5') {
        $result .= "<div class='tdp_element tdp_elem_progress $style $extra_class' style='color:$color;'>
                            <div class='tdp_progress_title'>$text</div>
                            <div class='tdp_progress_line_container' style='width: $percent%;'>
                                    <div class='tdp_progress_line' style='background-color:$color;'>
                                            <span class='tdp_progress_icon'><i class='icon-$icon'></i></span>
                                            <span class='tdp_progress_label'>$percent%</span>
                                    </div>
                            </div>
                    </div>";
    } else if ($style == 'style6') {
        $result .= "<div class='tdp_element tdp_elem_progress $style $extra_class'>
                            <div class='tdp_progress_bar'>
                                    <div class='tdp_progress_vline_container' style='height: $percent%;'>
                                            <div class='tdp_progress_vline'><span style='background-color: $color;'></span></div>
                                    </div>
                            </div>
                            <span class='tdp_progress_percent'>$percent%</span>
                            <span class='tdp_progress_title'>$text</span>
                    </div>";
    } else if ($style == 'style7') {
        $result .= "<div class='tdp_element tdp_elem_progress $style $extra_class' style='color:$color;'>
                            <div class='tdp_progress_bar'>
                                    <div class='tdp_progress_vline_container' style='height: $percent%;'>
                                            <div class='tdp_progress_vline' style='background-color:$color;'><span></span></div>
                                    </div>
                            </div>
                            <span class='tdp_progress_percent'>$percent%</span>
                            <span class='tdp_progress_title'>$text</span>
                    </div>";
    } else if ($style == 'style8') {
        $result .= "<div class='tdp_element tdp_elem_progress $style $extra_class'>
                            <span class='tdp_progress_percent'>$percent%</span>
                            <span class='tdp_progress_title'>$text</span>
                            <div class='tdp_progress_bar'>
                                    <div class='tdp_progress_vline_container' style='height: $percent%; top: 0px;'>
                                            <div class='tdp_progress_vline'><span style='background-color: $color;'></span></div>
                                    </div>
                            </div>
                    </div>";
    } else if ($style == 'style9') {
        $result .= "<div class='tdp_element tdp_elem_progress $style $extra_class' style='color:$color;'>
                            <span class='tdp_progress_percent'>$percent%</span>
                            <span class='tdp_progress_title'>$text</span>
                            <div class='tdp_progress_bar'>
                                    <div class='tdp_progress_vline_container' style='height: $percent%; top: 0px;'>
                                            <div class='tdp_progress_vline' style='background-color:$color;'><span></span></div>
                                    </div>
                            </div>
                    </div>";
    } else {
        $result .= "<div class='tdp_element tdp_elem_progress $style $extra_class' style='color:$color;'>
                            <div class='tdp_progress_bar'>
                                    <div class='tdp_progress_line' style='width: $percent%; background-color:$color;'>&nbsp;</div>
                            </div>
                            <span class='tdp_progress_icon'><i class='icon-$icon'></i></span>
                            <span class='tdp_progress_label'>$percent%</span>
                    </div>";
    }

    return $result;
}

add_shortcode('tdp_progress_bar', 'tdp_progress_bar');

//////////////////////////////////////////////////////////////////
// Column one_half shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_half', 'shortcode_one_half');
	function shortcode_one_half($atts, $content = null) {
		extract($atts = shortcode_atts(
			array(
				'last' => 'no',
				'animation_type' => '',
				'animation_direction' => 'left',
				'animation_speed' => '',
			), $atts));

			$direction_suffix = '';
			$animation_class = '';
			$animation_attribues = '';
			if($animation_type !== 'none') {
				$animation_class = ' animated';
				if($animation_type != 'flash' && $animation_type != 'shake') {
					$direction_suffix = 'In'.ucfirst($animation_direction);
					$animation_type .= $direction_suffix;
				}
				$animation_attribues = ' animation_type="'.$animation_type.'"';

				if($animation_speed) {
					$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
				}
			}

			if($atts['last'] == 'yes') {
				return '<div class="one_half last '.$animation_class.'"'.$animation_attribues.'>' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="one_half'.$animation_class.'"'.$animation_attribues.'>' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column one_third shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_third', 'shortcode_one_third');
	function shortcode_one_third($atts, $content = null) {
		extract($atts = shortcode_atts(
			array(
				'last' => 'no',
				'animation_type' => '',
				'animation_direction' => 'left',
				'animation_speed' => ''
			), $atts));

			$direction_suffix = '';
			$animation_class = '';
			$animation_attribues = '';
			if($animation_type !== 'none') {
				$animation_class = ' animated';
				if($animation_type != 'flash' && $animation_type != 'shake') {
					$direction_suffix = 'In'.ucfirst($animation_direction);
					$animation_type .= $direction_suffix;
				}
				$animation_attribues = ' animation_type="'.$animation_type.'"';

				if($animation_speed) {
					$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
				}
			}

			if($atts['last'] == 'yes') {
				return '<div class="one_third last'.$animation_class.'"'.$animation_attribues.'>' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="one_third'.$animation_class.'"'.$animation_attribues.'>' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column two_third shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('two_third', 'shortcode_two_third');
	function shortcode_two_third($atts, $content = null) {
		extract($atts = shortcode_atts(
			array(
				'last' => 'no',
				'animation_type' => '',
				'animation_direction' => 'left',
				'animation_speed' => ''
			), $atts));

			$direction_suffix = '';
			$animation_class = '';
			$animation_attribues = '';
			if($animation_type !== 'none') {
				$animation_class = ' animated';
				if($animation_type != 'flash' && $animation_type != 'shake') {
					$direction_suffix = 'In'.ucfirst($animation_direction);
					$animation_type .= $direction_suffix;
				}
				$animation_attribues = ' animation_type="'.$animation_type.'"';

				if($animation_speed) {
					$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
				}
			}

			if($atts['last'] == 'yes') {
				return '<div class="two_third last'.$animation_class.'"'.$animation_attribues.'>' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="two_third'.$animation_class.'"'.$animation_attribues.'>' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column one_fourth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('one_fourth', 'shortcode_one_fourth');
	function shortcode_one_fourth($atts, $content = null) {
		extract($atts = shortcode_atts(
			array(
				'last' => 'no',
				'animation_type' => '',
				'animation_direction' => 'left',
				'animation_speed' => ''
			), $atts));

			$direction_suffix = '';
			$animation_class = '';
			$animation_attribues = '';
			if($animation_type !== 'none') {
				$animation_class = ' animated';
				if($animation_type != 'flash' && $animation_type != 'shake') {
					$direction_suffix = 'In'.ucfirst($animation_direction);
					$animation_type .= $direction_suffix;
				}
				$animation_attribues = ' animation_type="'.$animation_type.'"';

				if($animation_speed) {
					$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
				}
			}

			if($atts['last'] == 'yes') {
				return '<div class="one_fourth last'.$animation_class.'"'.$animation_attribues.'>' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="one_fourth'.$animation_class.'"'.$animation_attribues.'>' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Column three_fourth shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('three_fourth', 'shortcode_three_fourth');
	function shortcode_three_fourth($atts, $content = null) {
		extract($atts = shortcode_atts(
			array(
				'last' => 'no',
				'animation_type' => '',
				'animation_direction' => 'left',
				'animation_speed' => ''
			), $atts));

			$direction_suffix = '';
			$animation_class = '';
			$animation_attribues = '';
			if($animation_type !== 'none') {
				$animation_class = ' animated';
				if($animation_type != 'flash' && $animation_type != 'shake') {
					$direction_suffix = 'In'.ucfirst($animation_direction);
					$animation_type .= $direction_suffix;
				}
				$animation_attribues = ' animation_type="'.$animation_type.'"';

				if($animation_speed) {
					$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
				}
			}

			if($atts['last'] == 'yes') {
				return '<div class="three_fourth last'.$animation_class.'"'.$animation_attribues.'>' .do_shortcode($content). '</div><div class="clearboth"></div>';
			} else {
				return '<div class="three_fourth'.$animation_class.'"'.$animation_attribues.'>' .do_shortcode($content). '</div>';
			}

	}

//////////////////////////////////////////////////////////////////
// Icon Shortcode
//////////////////////////////////////////////////////////////////
		
function tdp_icon($atts, $content = null) {
	extract(shortcode_atts(array(
		"size"			=> "",
		"image"			=> "",
		"character"		=> "",
		"cont" 			=> "",
		"float" 		=> "",
		'color'			=> '',
	), $atts));
	
	if (strlen($character) > 1) {
		$character = substr($character, 0, 1);
	}
	
	if ($cont == "yes") {
		if ($character != "") {
			return '<div style="color:'.$color.';border-color:'.$color.'" class="sf-icon-cont cont-'.$size.' sf-icon-float-'.$float.'"><span class="sf-icon-character sf-icon sf-icon-'.$size.'">'.$character.'</span></div>';
		} else {
			return '<div style="color:'.$color.';border-color:'.$color.'" class="sf-icon-cont cont-'.$size.' sf-icon-float-'.$float.'"><i class="icon-'.$image.' sf-icon sf-icon-'.$size.'"></i></div>';
		}
	} else {
		if ($character != "") {
			return '<span style="color:'.$color.';border-color:'.$color.'" class="sf-icon-character sf-icon sf-icon-float-'.$float.' sf-icon-'.$size.'">'.$character.'</span>';
		} else {
			return '<i style="color:'.$color.';border-color:'.$color.'" class="icon-'.$image.' sf-icon sf-icon-float-'.$float.' sf-icon-'.$size.'"></i>';	
		}
	}		
}
add_shortcode('icon', 'tdp_icon');
	
//////////////////////////////////////////////////////////////////
// Icon Box Shortocde
//////////////////////////////////////////////////////////////////
	
function tdp_iconbox($atts, $content = null) {
	extract(shortcode_atts(array(
		"type"			=> "",
		"image"			=> "",
		"character"		=> "",
		"title" 		=> "",
		'animation'		=> '',
		'animation_type' => '',
		'animation_direction' => 'left',
		'animation_speed' => '',
		'icon_color' => '',
		'boxed_color' => '',
		'text_color' => ''
	), $atts));
	
	$icon_box = "";
	$direction_suffix = '';
	$animation_class = '';
	$animation_attribues = '';
	if($animation_type !== 'none') {
		$animation_class = ' animated';
		if($animation_type != 'flash' && $animation_type != 'shake') {
			$direction_suffix = 'In'.ucfirst($animation_direction);
			$animation_type .= $direction_suffix;
		}
		$animation_attribues = ' animation_type="'.$animation_type.'"';

		if($animation_speed) {
			$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
		}
	}

	$set_boxed_bg = null;
	$set_boxed_heading = null;
	if($type == 'boxed-two' || $type == 'boxed-four') {
		$set_boxed_bg = 'style="background:'.$boxed_color.'; color:'.$text_color.' !important;"';
		$set_boxed_heading = 'style="color:'.$text_color.'"';
		$icon_color = $text_color;
	}
	
	if ($animation != "" && $type != "animated") {
	$icon_box .= '<div class="sf-icon-box sf-icon-box-'.$type.' '.$atts['type'].$animation_class.'"'.$animation_attribues.'>';
	} else {
	$icon_box .= '<div class="sf-icon-box sf-icon-box-'.$type.$animation_class.'"'.$animation_attribues.'>';		
	}
			
	if ($type == "animated") {
	$icon_box .= '<div class="inner">';
	$icon_box .= '<div class="front">';
	$icon_box .= do_shortcode('[icon color="'.$icon_color.'" size="large" image="'.$image.'" character="'.$character.'" float="none" cont="no"]');
	}
	
	if ($type == "left-icon-alt") {
	$icon_box .= do_shortcode('[icon color="'.$icon_color.'" size="medium" image="'.$image.'" character="'.$character.'" float="none" cont="no"]');		
	} else if ($type != "boxed-two" && $type != "boxed-four" && $type != "standard-title" && $type != "animated") {
	$icon_box .= do_shortcode('[icon color="'.$icon_color.'" size="small" image="'.$image.'" character="'.$character.'" float="none" cont="yes"]');
	}
	$icon_box .= '<div '.$set_boxed_bg.' class="sf-icon-box-content-wrap clearfix">';
	
	if ($type == "boxed-two") {
	$icon_box .= do_shortcode('[icon color="'.$icon_color.'" size="medium" image="'.$image.'" character="'.$character.'" float="none" cont="no"]');
	}
	
	if ($type == "boxed-four" || $type == "standard-title") {
		if ($character != "") {
			$icon_box .= '<h3><span class="sf-icon-character">'.$character.'</span> '.$title.'</h3>';	
		} else {
			$icon_box .= '<h3 '.$set_boxed_heading.'><i class="icon-'.$image.'"></i>'.$title.'</h3>';	
		}
	} else {
	$icon_box .= '<h3 '.$set_boxed_heading.'>'.$title.'</h3>';	
	}
	
	if ($type == "standard") {
	$icon_box .= '<div class="sf-icon-box-hr"></div>';
	}
	if ($type != "animated") {
	$icon_box .= '<div class="sf-icon-box-content">'.do_shortcode($content).'</div>';
	}
	
	$icon_box .= '</div>';
	
	if ($type == "animated") {
	$icon_box .= '</div>';
	$icon_box .= '<div class="back"><table>';
	$icon_box .= '<tbody><tr>';
	$icon_box .= '<td>';
	$icon_box .= '<h3>'.$title.'</h3>';	
	$icon_box .= '<div class="sf-icon-box-content">'.do_shortcode($content).'</div>';
	$icon_box .= '</td>';
	$icon_box .= '</tr>';
	$icon_box .= '</tbody></table></div>';
	$icon_box .= '</div>';
	}
	
	$icon_box .= '</div>';	
		
	return $icon_box;
	
}
add_shortcode('tdp_iconbox', 'tdp_iconbox');

//////////////////////////////////////////////////////////////////
// Image Frame
//////////////////////////////////////////////////////////////////
add_shortcode('imageframe', 'shortcode_imageframe');
function shortcode_imageframe($atts, $content = null) {
	global $data;

	extract(shortcode_atts(array(
		'style' => 'none',
		'bordercolor' => '',
		'bordersize' => '0',
		'stylecolor' => '',
		'align' => '',
		'lightbox' => 'no',
		'animation_type' => '',
		'animation_direction' => 'left',
		'animation_speed' => ''
	), $atts));

	$direction_suffix = '';
	$animation_class = '';
	$animation_attribues = '';
	if($animation_type !== 'none') {
		$animation_class = ' animated';
		if($animation_type != 'flash' && $animation_type != 'shake') {
			$direction_suffix = 'In'.ucfirst($animation_direction);
			$animation_type .= $direction_suffix;
		}
		$animation_attribues = ' animation_type="'.$animation_type.'"';

		if($animation_speed) {
			$animation_attribues .= ' animation_duration="'.$animation_speed.'"';
		}
	}

	static $avada_imageframe_id = 1;

	if(!$bordercolor) {
		$bordercolor = $data['imgframe_border_color'];
	}


	if(!$stylecolor) {
		$stylecolor = $data['imgframe_style_color'];
	}

	$getRgb = $stylecolor;

	$html = "<style type='text/css'>
	#imageframe-{$avada_imageframe_id}.imageframe img{border:{$bordersize} solid {$bordercolor};}
	#imageframe-{$avada_imageframe_id}.imageframe-glow img{
		-moz-box-shadow: 0 0 3px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* outer glow */
		-webkit-box-shadow: 0 0 3px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* outer glow */
		box-shadow: 0 0 3px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* outer glow */
	}
	#imageframe-{$avada_imageframe_id}.imageframe-dropshadow img{
		-moz-box-shadow: 2px 3px 7px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* drop shadow */
		-webkit-box-shadow: 2px 3px 7px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* drop shadow */
		box-shadow: 2px 3px 7px rgba({$getRgb[0]},{$getRgb[1]},{$getRgb[2]},.3); /* drop shadow */
	}
	</style>
	";

	$html .= '<span id="imageframe-'.$avada_imageframe_id.'" class="imageframe imageframe-'.$style.$animation_class.'"'.$animation_attribues.'>';
	if($lightbox == "yes") {
		preg_match('/(src=["\'](.*?)["\'])/', $content, $src);
		$link = preg_split('/["\']/', $src[0]);
		$html .= '<div class="gallery_thumbs"><a href="'.$link[1].'">';
	}
	$html .= do_shortcode($content);
	if($lightbox == "yes") {
	$html .= '</a></div>';
	}
	if($style == 'bottomshadow') {
	$html .= '<span class="imageframe-shadow-left"></span><span class="imageframe-shadow-right"></span>';
	}
	$html .= '</span>';

	$avada_imageframe_id++;

	return $html;
}

//////////////////////////////////////////////////////////////////
// Images
//////////////////////////////////////////////////////////////////
add_shortcode('images', 'shortcode_avada_images');
function shortcode_avada_images($atts, $content = null) {
	wp_enqueue_script( 'jquery.carouFredSel' );

	extract(shortcode_atts(array(
		'lightbox' => 'no',
		'picture_size' => 'fixed'
	), $atts));

	$class = '';

	if($lightbox == 'yes') {
		$class = 'lightbox-enabled';
	}

	$css_class = "related-posts";
	$carousel_class = "clients-carousel";
	if($picture_size != 'fixed') {
		$css_class = "";
		$carousel_class = "";
	}

	$picture_size = 'fixed';

	$html = '<div class="images-carousel-container '.$css_class.' related-projects '.$class.'"><div id="carousel" class="'.$carousel_class.' es-carousel-wrapper"><div class="es-carousel"><ul>';
	$html .= do_shortcode($content);
	$html .= '</ul><div class="es-nav"><span class="es-nav-prev">Previous</span><span class="es-nav-next">Next</span></div></div></div></div>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Image
//////////////////////////////////////////////////////////////////
add_shortcode('image', 'shortcode_avada_image');
function shortcode_avada_image($atts, $content = null) {
	$html = '<li>';
	$html .= '<a href="'.$atts['link'].'" target="'.$atts['linktarget'].'"><img src="'.$atts['image'].'" alt="'.$atts['alt'].'" /></a>';
	$html .= '</li>';
	return $html;
}

//////////////////////////////////////////////////////////////////
// Tabs shortcode
//////////////////////////////////////////////////////////////////
add_shortcode('tabs', 'shortcode_tabs');
	function shortcode_tabs( $atts, $content = null ) {
	global $data;

	extract(shortcode_atts(array(
		'layout' => 'horizontal',
	), $atts));

	static $avada_tabs_counter = 1;

	$out .= '<div id="tabs-'.$avada_tabs_counter.'" class="tab-holder shortcode-tabs clearfix tabs-'.$layout.'">';

	$out .= '<div class="tab-hold tabs-wrapper">';

	$out .= '<ul id="tabs" class="tabset tabs">';
	foreach ($atts as $key => $tab) {
		if($key != 'layout' && $key != 'backgroundcolor' && $key != 'inactivecolor') {
			$out .= '<li><a href="#' . $key . '">' . $tab . '</a></li>';
		}
	}
	$out .= '</ul>';

	$out .= '<div class="tab-box tabs-container">';

	$out .= do_shortcode($content) .'</div></div></div>';

	$avada_tabs_counter++;

	return $out;
}

add_shortcode('tab', 'shortcode_tab');
	function shortcode_tab( $atts, $content = null ) {
	extract(shortcode_atts(array(
	), $atts));

	$out = '';
	$out .= '<div id="tab' . $atts['id'] . '" class="tab tab_content">' . do_shortcode($content) .'</div>';

	return $out;
}

add_shortcode('tdp_tabs', 'shortcode_tdp_tabs');
	function shortcode_tdp_tabs( $atts, $content = null ) {
		$content = preg_replace('/tab\][^\[]*/','tab]', $content);
		$content = preg_replace('/^[^\[]*\[/','[', $content);

		$preg_match_all = preg_match_all( '/tdp_tab title="([^\"]+)"/i', $content, $matches );

		if($matches[1]) {
			foreach($matches[1] as $key => $title) {
				$sanitized_title = sanitize_title_with_dashes($title);
				$sanitized_title = str_replace('-', '_', $sanitized_title);
				$tabs .= 'tab' . $sanitized_title . '="' . $title . '" ';
			}
		}

		$shortcode_wrapper = '[tabs ' . $tabs . ' layout="' . $atts['layout'] . '" backgroundcolor="' . $atts['backgroundcolor'] . '" inactivecolor="' . $atts['inactivecolor'] . '"]';
		$shortcode_wrapper .= $content;
		$shortcode_wrapper .= '[/tabs]';

		return do_shortcode($shortcode_wrapper);
	}

add_shortcode('tdp_tab', 'shortcode_tdp_tab');
	function shortcode_tdp_tab( $atts, $content = null ) {
		$sanitized_title = sanitize_title_with_dashes($atts['title']);
		$sanitized_title = str_replace('-', '_', $sanitized_title);
		$shortcode_wrapper = '[tab id="' . $sanitized_title . '"]' . do_shortcode($content) . '[/tab]';

		return do_shortcode($shortcode_wrapper);
	}

//////////////////////////////////////////////////////////////////
// Team
//////////////////////////////////////////////////////////////////

/*-----------------------------------------------------------------------------------*/
/*	Member
/*-----------------------------------------------------------------------------------*/

function hangar_member( $atts, $content = null) {
extract( shortcode_atts( array(
      'img' 	=> '',
      'name' 	=> '',
      'url'		=> '',
      'role'	=> '',
      'twitter' => '',
      'facebook' => '',
      'skype' => '',
      'google' => '',
      'linkedin' => '',
      'mail' => '',
      ), $atts ) );
      
      if($url != '') {
    	$returnurl = "<a href='".$url."'>";
    	$returnurl2 = "</a>";
      } else {
    	$returnurl = "";
    	$returnurl2 = "";
      }
      
      if($img == '') {
    	$return = "";
      } else{
    	$return = "<div class='member-img'>".$returnurl."<img src='".$img."' />".$returnurl2."</div>";
      }
      
      
      
      if( $twitter != '' || $facebook != '' || $skype != '' || $google != '' || $linkedin != '' || $mail != '' ){
	      $return8 = '<div class="member-social"><ul>';
	      $return9 = '</ul></div>';
	      
	      if($twitter != '') {
	    	$return2 = '<li class=""><a href="' .$twitter. '" target="_blank" title="Twitter"><span class="icon-twitter"></span></a></li>';
	      } else{
		     $return2 = ''; 
	      }
	      
	      if($facebook != '') {
	    	$return3 = '<li class=""><a href="' .$facebook. '" target="_blank" title="Facebook"><span class="icon-facebook"></span></a></li>';
	      } else{
		      $return3 = ''; 
	      }
	      
	      if($skype != '') {
	    	$return4 = '<li class=""><a href="' .$skype. '" target="_blank" title="Skype"><span class="icon-skype"></span></a></li>';
	      } else{
		      $return4 = ''; 
	      }
	      
	      if($google != '') {
	    	$return5 = '<li class=""><a href="' .$google. '" target="_blank" title="Google+"><span class="icon-gplus"></span></a></li>';
	      } else{
		      $return5 = ''; 
	      }
	      
	      
	      if($linkedin != '') {
	    	$return6 = '<li class=""><a href="' .$linkedin. '" target="_blank" title="LinkedIn"><span class="icon-linkedin"></span></a></li>';
	      }
	      else{
		      $return6 = ''; 
	      }
	      
	      if($mail != '') {
	    	$return7 = '<li class=""><a href="mailto:' .$mail. '" title="Mail"><span class="icon-mail"></span></a></li>';
	      }
	      else{
		      $return7 = ''; 
	      }
      }  else {
	      $return2 = '';
	      $return3 = ''; 
	      $return4 = ''; 
	      $return5 = ''; 
	      $return6 = ''; 
	      $return7 = '';
	      $return8 = ''; 
	      $return9 = ''; 
      }   
      return '<div class="member">' .$return. '
      	<h4>' .$name. '</h4>
      	<div class="member-role">' .$role. '</div>' . do_shortcode($content) . '' .$return8. '' .$return2. '' .$return3. '' .$return4. '' .$return5. '' .$return6. '' .$return7. '' .$return9. '</div>';
}

add_shortcode('tdp_team', 'hangar_member');


//////////////////////////////////////////////////////////////////
// Testimonials
//////////////////////////////////////////////////////////////////
add_shortcode('testimonials', 'shortcode_testimonials');
	function shortcode_testimonials($atts, $content = null) {
		global $data;

		wp_enqueue_script( 'jquery.cycle' );

		extract(shortcode_atts(array(
			'backgroundcolor' => '',
			'textcolor' => ''
		), $atts));

		static $avada_testimonials_id = 1;

		if(!$backgroundcolor) {
			$backgroundcolor = $data['testimonial_bg_color'];
		}


		if(!$textcolor) {
			$textcolor = $data['testimonial_text_color'];
		}

		$getRgb = $stylecolor;

		$str = "<style type='text/css'>
		#testimonials-{$avada_testimonials_id} q{background-color:{$backgroundcolor} !important;color:{$textcolor} !important;}
		#testimonials-{$avada_testimonials_id} .review blockquote div:after{border-top-color:{$backgroundcolor} !important;}
		</style>
		";

		$str .= '<div id="testimonials-'.$avada_testimonials_id.'" class="reviews clearfix">';
		$str .= do_shortcode($content);
		$str .= '</div>';

		$avada_testimonials_id++;

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Testimonial
//////////////////////////////////////////////////////////////////
add_shortcode('testimonial', 'shortcode_testimonial');
	function shortcode_testimonial($atts, $content = null) {
		if(!isset($atts['gender'])) {
			$atts['gender'] = 'male';
		}
		$str = '';
		$str .= '<div class="review '.$atts['gender'].'">';
		$str .= '<blockquote>';
		$str .= '<q>';
		$str .= do_shortcode($content);
		$str .= '</q>';
		if($atts['name']):
			$str .= '<div class="clearfix"><span class="company-name">';
			$str .= '<strong><i class="icon-user-1"></i> '.$atts['name'].'</strong>';
			if($atts['company']):
				if(!empty($atts['link']) && $atts['link']):
				$str .= '<a href="'.$atts['link'].'" target="'.$atts['target'].'">';
				endif;
				$str .= ',<span> '.$atts['company'].'</span>';
				if(!empty($atts['link']) && $atts['link']):
				$str .= '</a>';
				endif;
			endif;
			$str .= '</span></div>';
		endif;
		$str .= '</blockquote>';
		$str .= '</div><div class="clearfix"></div>';

		return $str;
	}

//////////////////////////////////////////////////////////////////
// Video
//////////////////////////////////////////////////////////////////

function tdp_video($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                'type' => 'url',
                'url' => '',
                'poster' => '',
                'embed' => '',
                'color' => '#3a87ad',
                'extra_class' => ''
                    ), $atts));

    $result = $title != '' ? '<h3 class="element_title">' . $title . '</h3>' : '';
    
    if( $type == 'url' ){
        if ($url != '' && wp_oembed_get($url) !== false) {
            // Embed convertion
            $result .= wp_oembed_get($url);
        } else {
            $result .= get_video_player($url, $color, $extra_class, $poster);
        }

        return $result;
    }
    else{
        return $result."<div class='tdp_element tdp_elem_video video_embed $extra_class'>".urldecode($embed)."</div>";
    }
    
    return $result;
}

add_shortcode('tdp_video', 'tdp_video');

//////////////////////////////////////////////////////////////////
// Full Width
//////////////////////////////////////////////////////////////////
add_shortcode('fullwidth', 'shortcode_fullwidth');
function shortcode_fullwidth($atts, $content = null) {
	extract(shortcode_atts(array(
		'overlay' => '',
		'center' => '',
		'backgroundcolor' => '',
		'backgroundimage' => '',
		'backgroundrepeat' => 'no-repeat',
		'backgroundposition' => 'top left',
		'backgroundattachment' => 'scroll',
		'bordersize' => '1px',
		'bordercolor' => '',
		'paddingtop' => '20px',
		'paddingbottom' => '20px',
		'lighttext' => '',
	), $atts));

	$css = '';
	if($backgroundrepeat == 'no-repeat') {
		$css .= '-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;';
	}

	$html = '<div class="tdp_row_fullwidth center-'.$center.' light-'.$lighttext.'" style="background-color:'.$backgroundcolor.';background-image:url('.$backgroundimage.');background-repeat:'.$backgroundrepeat.';background-position:'.$backgroundposition.';background-attachment:'.$backgroundattachment.';border-top:'.$bordersize.' solid '.$bordercolor.';border-bottom:'.$bordersize.' solid '.$bordercolor.';padding-top:'.$paddingtop.';padding-bottom:'.$paddingbottom.';'.$css.'">';
	if($overlay == 'yes') {
		$html .= '<div class="section-overlay" style="background-color:'.$backgroundcolor.'; margin-top:-'.$paddingtop.'"></div>';
	}
	$html .= '<div class="tdp-row wrapper">';
	$html .= do_shortcode($content);
	$html .= '</div>';
	$html .= '</div><div class="clearboth"></div>';

	return $html;
}


//////////////////////////////////////////////////////////////////
// Latest Posts
//////////////////////////////////////////////////////////////////
add_shortcode('latest_posts', 'tdp_latest_posts');
function tdp_latest_posts($atts, $content = null) {
	extract(shortcode_atts(array(
		'amount' => '',
	), $atts));

	ob_start();
					
		$args = array( 
		    'posts_per_page' => $amount,
	    );

	    $query = new WP_Query( $args );

			if ( $query->have_posts() ) { ?>
			    
			    <div class="latest-posts-wrapper">

				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					
					<div class="single-post-wrapper">

					<section id="post-data" class="one_sixth">
						<span class="top-day"><?php the_time('d'); ?></span>
						<span class="bottom-date"><?php the_time('M Y'); ?></span>
					</section>

					<section id="post-content" class="five_sixth last">
						<h3 class="post-title">
							<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
						</h3>

						<div class="post-content">
						<?php $text_desc = get_the_content(); $trimmed_desc = wp_trim_words( $text_desc, $num_words = 20, $more = null ); echo stripslashes($trimmed_desc); ?>
						</div>
					</section>

					<div class="clearboth"></div>

					</div>

				<?php endwhile;

				wp_reset_postdata(); ?>

				</div>
			    
		<?php }

		$html .= ob_get_contents();  
    	ob_end_clean(); 

	return $html;
}