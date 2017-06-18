<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new tdp_shortcodes( $popup );

// function to get a list of elements available it can be filtered through a plugin/theme
function tdp_shortcodes_get_options( $additional = '' ) {

	$defaults = array();

	$defaults = array(
		'select' => 'Choose a Shortcode',
		'toggles' => 'Accordion & Toggles',
		'alert' => 'Alert Notifications',
		'audio' => 'Audio Player',
		'quote' => 'Blockquote',
		'button' => 'Buttons',
		'callout' => 'Callouts',
		'columns' => 'Columns',
		'cbox' => 'Content Boxes',
		'counterscircle' => 'Counters Circle',
		'countersbox' => 'Counters Box',
		'fullwidth' => 'Full Width Container',
		'gallery' => 'Gallery',
		'googlemap' => 'Google Map',
		'heading' => 'Heading',
		'highlight' => 'Highlight',
		'iconbox' => 'Icon Box',
		'imageframe' => 'Image Frames',
		'latest_posts' => 'Latest Posts',
		'pricingtable' => 'Pricing Table',
		'progress' => 'Progress Bar',
		'person' => 'Person',
		'spacer' => 'Spacer',
		'tabs' => 'Tabs',
		'table' => 'Table',
		'testimonials' => 'Testimonials',
		'video' => 'Video'
	);

	$defaults = array_merge( $defaults, apply_filters( 'tdp_shortcodes_filter_options', $defaults) );

	return $defaults; 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="tdp-popup">

	<div id="tdp-shortcode-wrap">
		
		<div id="tdp-sc-form-wrap">

			<?php $select_shortcode = tdp_shortcodes_get_options(); ?>

			<table id="tdp-sc-form-table" class="tdp-shortcode-selector">
				<tbody>
					<tr class="form-row">
						<td class="label">Choose Shortcode</td>
						<td class="field">
							<div class="tdp-form-select-field">
							<div class="arrow"><i class="icon-down-dir"></i></div>
								<select name="tdp_select_shortcode" id="tdp_select_shortcode" class="tdp-form-select tdp-input">
									<?php foreach($select_shortcode as $shortcode_key => $shortcode_value): ?>
									<?php if($shortcode_key == $popup): $selected = 'selected="selected"'; else: $selected = ''; endif; ?>
									<option value="<?php echo $shortcode_key; ?>" <?php echo $selected; ?>><?php echo $shortcode_value; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<form method="post" id="tdp-sc-form">
			
				<table id="tdp-sc-form-table">
				
					<?php echo $shortcode->output; ?>
					
					<tbody class="tdp-sc-form-button">
						<tr class="form-row">
							<td class="field"><a href="#" class="tdp-insert button-primary">Insert Shortcode</a></td>							
						</tr>
					</tbody>
				
				</table>
				<!-- /#tdp-sc-form-table -->
				
			</form>
			<!-- /#tdp-sc-form -->
		
		</div>
		<!-- /#tdp-sc-form-wrap -->
		
		<div class="clear"></div>
		
	</div>
	<!-- /#tdp-shortcode-wrap -->

</div>
<!-- /#tdp-popup -->

</body>
</html>