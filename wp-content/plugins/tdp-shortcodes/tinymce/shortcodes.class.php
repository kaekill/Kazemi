<?php

// load wordpress
require_once('get_wp.php');

class tdp_shortcodes
{
	var	$conf;
	var	$popup;
	var	$params;
	var	$shortcode;
	var $cparams;
	var $cshortcode;
	var $popup_title;
	var $no_preview;
	var $has_child;
	var	$output;
	var	$errors;

	// --------------------------------------------------------------------------

	function __construct( $popup )
	{
		if( file_exists( dirname(__FILE__) . '/config.php' ) )
		{
			$this->conf = dirname(__FILE__) . '/config.php';
			
			//extend plugin functionalities
			if( file_exists( get_template_directory() . '/framework/extensions/tdp-shortcodes-config.php' ) ) {
				$this->conf_extended = get_template_directory() . '/framework/extensions/tdp-shortcodes-config.php';
			}
			
			$this->popup = $popup;

			$this->formate_shortcode();
		}
		else
		{
			$this->append_error('Config file does not exist');
		}
	}

	// --------------------------------------------------------------------------

	function formate_shortcode()
	{
		// get config file
		require_once( $this->conf );
		//extend configuration file
		if( file_exists( get_template_directory() . '/framework/extensions/tdp-shortcodes-config.php' ) ) {
			require_once( $this->conf_extended );
		}

		unset($tdp_shortcodes['shortcode-generator']['params']['select_shortcode']);
		//unset(apply_filters( 'tdp_filter_config', $tdp_shortcodes['shortcode-generator']['params']['select_shortcode']));
		if( isset( $tdp_shortcodes[$this->popup]['child_shortcode'] ) )
			$this->has_child = true;

		if( isset( $tdp_shortcodes ) && is_array( $tdp_shortcodes ) )
		{
			// get shortcode config stuff
			$this->params = $tdp_shortcodes[$this->popup]['params'];
			$this->shortcode = $tdp_shortcodes[$this->popup]['shortcode'];
			$this->popup_title = $tdp_shortcodes[$this->popup]['popup_title'];

			// adds stuff for js use
			$this->append_output( "\n" . '<div id="_tdp_shortcode" class="hidden">' . $this->shortcode . '</div>' );
			$this->append_output( "\n" . '<div id="_tdp_popup" class="hidden">' . $this->popup . '</div>' );

			if( isset( $tdp_shortcodes[$this->popup]['no_preview'] ) && $tdp_shortcodes[$this->popup]['no_preview'] )
			{
				//$this->append_output( "\n" . '<div id="_tdp_preview" class="hidden">false</div>' );
				$this->no_preview = true;
			}

			// filters and excutes params
			foreach( $this->params as $pkey => $param )
			{
				// prefix the fields names and ids with tdp_
				$pkey = 'tdp_' . $pkey;

				// popup form row start
				$row_start  = '<tbody>' . "\n";
				$row_start .= '<tr class="form-row" class="' . $pkey . '">' . "\n";
				if($param['type'] != 'info') {
					$row_start .= '<td class="label">';
					$row_start .= '<span class="tdp-form-label-title">' . $param['label'] . '</span>' . "\n";
					$row_start .= '<span class="tdp-form-desc">' . $param['desc'] . '</span>' . "\n";
					$row_start .= '</td>' . "\n";
				}
				$row_start .= '<td class="field">' . "\n";

				// popup form row end
				$row_end   = '</td>' . "\n";
				$row_end   .= '</tr>' . "\n";
				$row_end   .= '</tbody>' . "\n";

				switch( $param['type'] )
				{
					case 'text' :

						// prepare
						$output  = $row_start;
						$output .= '<input type="text" class="tdp-form-text tdp-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;

					case 'textarea' :

						// prepare
						$output  = $row_start;

						// Turn on the output buffer
						ob_start();

						// Echo the editor to the buffer
						wp_editor( $param['std'], $pkey, array( 'editor_class' => 'tdp_tinymce', 'media_buttons' => true ) );

						// Store the contents of the buffer in a variable
						$editor_contents = ob_get_clean();

						//$output .= $editor_contents;
						$output .= '<textarea rows="10" cols="30" name="' . $pkey . '" id="' . $pkey . '" class="tdp-form-textarea tdp-input">' . $param['std'] . '</textarea>' . "\n";
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;

					case 'select' :

						// prepare
						$output  = $row_start;
						$output .= '<div class="tdp-form-select-field">';
						$output .= '<div class="arrow"><i class="icon-down-dir"></i></div>';
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="tdp-form-select tdp-input">' . "\n";
						$output .= '</div>';

						foreach( $param['options'] as $value => $option )
						{
							$selected = ($param['std'] == $value) ? 'selected="selected"' : '';
							$output .= '<option value="' . $value . '"' . $selected . '>' . $option . '</option>' . "\n";
						}

						$output .= '</select>' . "\n";
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;

					case 'multiple_select' :

						// prepare
						$output  = $row_start;
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" multiple="multiple" class="tdp-form-multiple-select tdp-input">' . "\n";

						foreach( $param['options'] as $value => $option )
						{
							$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
						}

						$output .= '</select>' . "\n";
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;

					case 'checkbox' :

						// prepare
						$output  = $row_start;
						$output .= '<label for="' . $pkey . '" class="tdp-form-checkbox">' . "\n";
						$output .= '<input type="checkbox" class="tdp-input" name="' . $pkey . '" id="' . $pkey . '" ' . ( $param['std'] ? 'checked' : '' ) . ' />' . "\n";
						$output .= ' ' . $param['checkbox_text'] . '</label>' . "\n";
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;

					case 'uploader' :

						// prepare
						$output  = $row_start;
						$output .= '<div class="tdp-upload-container">';
						$output .= '<img src="" alt="Image" class="uploaded-image" />';
						$output .= '<input type="hidden" class="tdp-form-text tdp-form-upload tdp-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output .= '<a href="' . $pkey . '" class="tdp-upload-button" data-upid="1">Upload</a>';
						$output .= '</div>';
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;

					case 'gallery' :

						// prepare
						$output  = $row_start;
						$output .= '<a href="' . $cpkey . '" class="tdp-gallery-button tdp-shortcodes-button">Attach Images to Gallery</a>';
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;

					case 'iconpicker' :

						// prepare
						$output  = $row_start;

						$output .= '<div class="iconpicker">';
						foreach( $param['options'] as $value => $option ) {
							$output .= '<i class="' . $value . '" data-name="' . $value . '"></i>';
						}
						$output .= '</div>';

						$output .= '<input type="hidden" class="tdp-form-text tdp-input" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;

					case 'colorpicker' :

						// prepare
						$output  = $row_start;
						$output .= '<input type="text" class="tdp-form-text tdp-input wp-color-picker-field" name="' . $pkey . '" id="' . $pkey . '" value="' . $param['std'] . '" />' . "\n";
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;

					case 'info' :

						// prepare
						$output  = $row_start;
						$output .= '<p>' . $param['std'] . "</p>\n";
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;

					case 'size' :

						// prepare
						$output  = $row_start;
						$output .= '<div class="tdp-form-group">' . "\n";
						$output .= '<label>Width</label>' . "\n";
						$output .= '<input type="text" class="tdp-form-text tdp-input" name="' . $pkey . '_width" id="' . $pkey . '_width" value="' . $param['std'] . '" />' . "\n";
						$output  .= '</div>' . "\n";
						$output .= '<div class="tdp-form-group last">' . "\n";
						$output .= '<label>Height</label>' . "\n";
						$output .= '<input type="text" class="tdp-form-text tdp-input" name="' . $pkey . '_height" id="' . $pkey . '_height" value="' . $param['std'] . '" />' . "\n";
						$output .= '</div>' . "\n";
						$output .= $row_end;

						// append
						$this->append_output( $output );

						break;
				}
			}

			// checks if has a child shortcode
			if( isset( $tdp_shortcodes[$this->popup]['child_shortcode'] ) )
			{
				// set child shortcode
				$this->cparams = $tdp_shortcodes[$this->popup]['child_shortcode']['params'];
				$this->cshortcode = $tdp_shortcodes[$this->popup]['child_shortcode']['shortcode'];

				// popup parent form row start
				$prow_start  = '<tbody>' . "\n";
				$prow_start .= '<tr class="form-row has-child">' . "\n";
				$prow_start .= '<td>' . "\n";
				$prow_start .= '<div class="child-clone-rows">' . "\n";

				// for js use
				$prow_start .= '<div id="_tdp_cshortcode" class="hidden">' . $this->cshortcode . '</div>' . "\n";

				// start the default row
				$prow_start .= '<div class="child-clone-row">' . "\n";
				$prow_start .= '<ul class="child-clone-row-form">' . "\n";

				// add $prow_start to output
				$this->append_output( $prow_start );

				foreach( $this->cparams as $cpkey => $cparam )
				{

					// prefix the fields names and ids with tdp_
					$cpkey = 'tdp_' . $cpkey;

					// popup form row start
					$crow_start  = '<li class="child-clone-row-form-row clearfix">' . "\n";
					$crow_start .= '<div class="child-clone-row-label-desc">' . "\n";
					$crow_start .= '<div class="child-clone-row-label">' . "\n";
					$crow_start .= '<label>' . $cparam['label'] . '</label>' . "\n";
					$crow_start .= '</div>' . "\n";
					$crow_start	.= '<span class="child-clone-row-desc">' . $cparam['desc'] . '</span>' . "\n";
					$crow_start .= '</div>' . "\n";
					$crow_start .= '<div class="child-clone-row-field">' . "\n";

					// popup form row end
					$crow_end    = '</div>' . "\n";
					$crow_end   .= '</li>' . "\n";

					switch( $cparam['type'] )
					{
						case 'text' :

							// prepare
							$coutput  = $crow_start;
							$coutput .= '<input type="text" class="tdp-form-text tdp-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= $crow_end;

							// append
							$this->append_output( $coutput );

							break;

						case 'textarea' :

							// prepare
							$coutput  = $crow_start;
							$coutput .= '<textarea rows="10" cols="30" name="' . $cpkey . '" id="' . $cpkey . '" class="tdp-form-textarea tdp-cinput">' . $cparam['std'] . '</textarea>' . "\n";
							$coutput .= $crow_end;

							// append
							$this->append_output( $coutput );

							break;

						case 'select' :

							// prepare
							$coutput  = $crow_start;
							$coutput .= '<div class="tdp-form-select-field">';
							$coutput .= '<div class="arrow"><i class="icon-down-dir"></i></div>';
							$coutput .= '<select name="' . $cpkey . '" id="' . $cpkey . '" class="tdp-form-select tdp-cinput">' . "\n";
							$coutput .= '</div>';

							foreach( $cparam['options'] as $value => $option )
							{
								$coutput .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
							}

							$coutput .= '</select>' . "\n";
							$coutput .= $crow_end;

							// append
							$this->append_output( $coutput );

							break;

						case 'checkbox' :

							// prepare
							$coutput  = $crow_start;
							$coutput .= '<label for="' . $cpkey . '" class="tdp-form-checkbox">' . "\n";
							$coutput .= '<input type="checkbox" class="tdp-cinput" name="' . $cpkey . '" id="' . $cpkey . '" ' . ( $cparam['std'] ? 'checked' : '' ) . ' />' . "\n";
							$coutput .= ' ' . $cparam['checkbox_text'] . '</label>' . "\n";
							$coutput .= $crow_end;

							// append
							$this->append_output( $coutput );

							break;

						case 'uploader' :

							// prepare
							$coutput  = $crow_start;
							$coutput .= '<div class="tdp-upload-container">';
							$coutput .= '<img src="" alt="Image" class="uploaded-image" />';
							$coutput .= '<input type="hidden" class="tdp-form-text tdp-form-upload tdp-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= '<a href="' . $cpkey . '" class="tdp-upload-button" data-upid="1">Upload</a>';
							$coutput .= '</div>';
							$coutput .= $crow_end;

							// append
							$this->append_output( $coutput );

							break;

						case 'colorpicker' :

							// prepare
							$coutput  = $crow_start;
							$coutput .= '<input type="text" class="tdp-form-text tdp-cinput wp-color-picker-field" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= $crow_end;

							// append
							$this->append_output( $coutput );

							break;

						case 'iconpicker' :

							// prepare
							$coutput  = $crow_start;

							$coutput .= '<div class="iconpicker">';
							foreach( $cparam['options'] as $value => $option ) {
								$coutput .= '<i class="' . $value . '" data-name="' . $value . '"></i>';
							}
							$coutput .= '</div>';

							$coutput .= '<input type="hidden" class="tdp-form-text tdp-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= $crow_end;

							// append
							$this->append_output( $coutput );

							break;

						case 'size' :

							// prepare
							$coutput  = $crow_start;
							$coutput .= '<div class="tdp-form-group">' . "\n";
							$coutput .= '<label>Width</label>' . "\n";
							$coutput .= '<input type="text" class="tdp-form-text tdp-cinput" name="' . $cpkey . '_width" id="' . $cpkey . '_width" value="' . $cparam['std'] . '" />' . "\n";
							$coutput  .= '</div>' . "\n";
							$coutput .= '<div class="tdp-form-group last">' . "\n";
							$coutput .= '<label>Height</label>' . "\n";
							$coutput .= '<input type="text" class="tdp-form-text tdp-cinput" name="' . $cpkey . '_height" id="' . $cpkey . '_height" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= '</div>' . "\n";
							$coutput .= $crow_end;

							// append
							$this->append_output( $coutput );

							break;
					}
				}

				// popup parent form row end
				$prow_end    = '</ul>' . "\n";		// end .child-clone-row-form
				$prow_end   .= '<a href="#" class="child-clone-row-remove tdp-shortcodes-button">Remove</a>' . "\n";
				$prow_end   .= '</div>' . "\n";		// end .child-clone-row


				$prow_end   .= '</div>' . "\n";		// end .child-clone-rows
				$prow_end	.= '<a href="#" id="form-child-add">' . $tdp_shortcodes[$this->popup]['child_shortcode']['clone_button'] . '</a>' . "\n";
				$prow_end   .= '</td>' . "\n";
				$prow_end   .= '</tr>' . "\n";
				$prow_end   .= '</tbody>' . "\n";

				// add $prow_end to output
				$this->append_output( $prow_end );
			}
		}
	}

	// --------------------------------------------------------------------------

	function append_output( $output )
	{
		$this->output = $this->output . "\n" . $output;
	}

	// --------------------------------------------------------------------------

	function reset_output( $output )
	{
		$this->output = '';
	}

	// --------------------------------------------------------------------------

	function append_error( $error )
	{
		$this->errors = $this->errors . "\n" . $error;
	}
}

?>