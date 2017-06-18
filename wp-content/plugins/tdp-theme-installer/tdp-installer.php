<?php
/*
Plugin Name: TDP - Themes Installer
Plugin URI: http://themesdepot.org
Description: Install themes purchased from ThemesDepot.org with a single click. 
Version: 1.0
Author: ThemesDepot
Author URI: http://themesdepot.org
*/

define( 'TDP_INSTALLER_VERSION', '1.0.0' );
define( 'TDP_INSTALLER_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'TDP_INSTALLER_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

function tdp_installer_init() {

	/**
	 * Display warning telling the user they a
	 * compatible theme in order to use this plugin
	 *
	 * @since 1.0.0
	 */
	function tdp_installer_warning() {
		global $current_user;
		// DEBUG: delete_user_meta( $current_user->ID, 'tdp_no_installer' )
		if( ! get_user_meta( $current_user->ID, 'tdp_no_installer' ) ){
			echo '<div class="updated">';
			echo '<p>'.__( 'You currently have the "TDP - Themes Installer" plugin activated, however you are not using a theme that supports it, and so this plugin will not do anything.', 'tdp_installer' ).'</p>';
			echo '<p><a href="'.tdp_installer_warning_disable_url('tdp_no_installer').'">'.__('Dismiss this notice', 'tdp_installer').'</a> | <a href="http://themesdepot.org" target="_blank">'.__('Visit ThemesDepot.org', 'tdp_installer').'</a></p>';
			echo '</div>';
		}
	}

	/**
	 * Dismiss an admin notice.
	 *
	 * @since 1.0.6
	 */
	function tdp_installer_warning_nag() {
		global $current_user;
	    if ( isset( $_GET['tdp_nag_ignore'] ) )
	         add_user_meta( $current_user->ID, $_GET['tdp_nag_ignore'], 'true', true );
	}

	/**
	 * Disable admin notice URL.
	 *
	 * @since 1.1.0
	 */
	function tdp_installer_warning_disable_url( $id ) {

		global $pagenow;

		$url = admin_url( $pagenow );

		if( ! empty( $_SERVER['QUERY_STRING'] ) )
			$url .= sprintf( '?%s&tdp_nag_ignore=%s', $_SERVER['QUERY_STRING'], $id );
		else
			$url .= sprintf( '?tdp_nag_ignore=%s', $id );

		return $url;
	}

	// Display message if installer is not supported
	if( !current_theme_supports( 'tdp_installer' )) {
		add_action( 'admin_notices', 'tdp_installer_warning' );
		add_action( 'admin_init', 'tdp_installer_warning_nag' );
		return;
	}

	// If theme supports plugin load everything's needed
	if( current_theme_supports( 'tdp_installer' )) {

		/**
		 * Add page menu to dashboard
		 */
		function tdp_installer_add_menu() {
			add_theme_page('Theme Installer', 'Theme Installer', 'manage_options', 'tdp-theme-installer', 'tdp_theme_installer_page');
		}
		add_action('admin_menu', 'tdp_installer_add_menu');

		/**
		 * Add page menu to admin bar
		 */
		function tdp_installer_admin_bar() {
			
			global $wp_admin_bar;

		    $wp_admin_bar->add_menu(array(
		       "id" => "tdp-installer-link",
		       "title" => __( 'Theme Installer Tool', 'tdp_installer' ),
		       "parent" => 'top-secondary',
		       "href" => admin_url( 'themes.php?page=tdp-theme-installer' ),
		    ));

		}
		add_action("admin_bar_menu", "tdp_installer_admin_bar");

		/**
		 * Add css to dashboard
		 */
		function tdp_installer_css() {
			wp_register_style( 'tdp_installer_css', TDP_INSTALLER_PLUGIN_URL . '/css/tdp-installer-interface.css', false, '1.0.0' );
			wp_enqueue_style( 'tdp_installer_css' );
		}
		add_action( 'admin_enqueue_scripts', 'tdp_installer_css' );

		/**
		 * Function To Process Demo Import
		 */
		if(!function_exists('us_dataImport'))
		{
			function us_dataImport()
			{
				if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

				require_once(get_template_directory().'/framework/wordpress-importer/wordpress-importer.php');

				if(!is_file(get_template_directory().'/framework/data/demo_data.xml'))
				{

					echo "Automatic import failed. Please use the wordpress importer and import the XML file manually.";
				}
				else
				{
					$wp_import = new WP_Import();
					$wp_import->fetch_attachments = true;
					$wp_import->import(get_template_directory().'/framework/data/demo_data.xml');

					//action required by themes to configure the setup steps
					do_action( 'tdp_installer_start_setup' );

				}


				die();
			}

			add_action('wp_ajax_us_dataImport', 'us_dataImport');
		}

	}

}

/**
 * Available widgets
 *
 * Gather site's widgets into array with ID base, name, etc.
 * Used by export and import functions.
 *
 * @since 0.4
 * @global array $wp_registered_widget_updates
 * @return array Widget information
 */
function tdp_available_widgets() {

	global $wp_registered_widget_controls;

	$widget_controls = $wp_registered_widget_controls;

	$available_widgets = array();

	foreach ( $widget_controls as $widget ) {

		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
			$available_widgets[$widget['id_base']]['name'] = $widget['name'];

		}
		
	}

	return apply_filters( 'tdp_available_widgets', $available_widgets );

}

/**
 * Process import file
 *
 * This parses a file and triggers importation of its widgets.
 *
 * @since 0.3
 * @param string $file Path to .tdp file uploaded
 * @global string $tdp_import_results
 */
function tdp_process_import_file( $file ) {

	// Get file contents and decode
	$data = file_get_contents( $file );
	$data = json_decode( $data );

	// Import the widget data
	// Make results available for display on import/export page
	tdp_import_data( $data );

}

/**
 * Import widget JSON data
 * 
 * @since 0.4
 * @global array $wp_registered_sidebars
 * @param object $data JSON widget data from .tdp file
 * @return array Results array
 */
function tdp_import_data( $data ) {

	global $wp_registered_sidebars;

	// Have valid data?
	// If no data or could not decode
	if ( empty( $data ) || ! is_object( $data ) ) {
		wp_die(
			__( 'Import data could not be read. Please try a different file.', 'widget-importer-exporter' ),
			'',
			array( 'back_link' => true )
		);
	}

	// Hook before import
	do_action( 'tdp_before_import' );

	// Get all available widgets site supports
	$available_widgets = tdp_available_widgets();

	// Get all existing widget instances
	$widget_instances = array();
	foreach ( $available_widgets as $widget_data ) {
		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	}

	// Begin results
	$results = array();

	// Loop import data's sidebars
	foreach ( $data as $sidebar_id => $widgets ) {

		// Skip inactive widgets
		// (should not be in export file)
		if ( 'wp_inactive_widgets' == $sidebar_id ) {
			continue;
		}

		// Check if sidebar is available on this site
		// Otherwise add widgets to inactive, and say so
		if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
			$sidebar_available = true;
			$use_sidebar_id = $sidebar_id;
			$sidebar_message_type = 'success';
			$sidebar_message = '';
		} else {
			$sidebar_available = false;
			$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
			$sidebar_message_type = 'error';
			$sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', 'widget-importer-exporter' );
		}

		// Result for sidebar
		$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
		$results[$sidebar_id]['message'] = $sidebar_message;
		$results[$sidebar_id]['widgets'] = array();

		// Loop widgets
		foreach ( $widgets as $widget_instance_id => $widget ) {

			$fail = false;

			// Get id_base (remove -# from end) and instance ID number
			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

			// Does site support this widget?
			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
				$fail = true;
				$widget_message_type = 'error';
				$widget_message = __( 'Site does not support widget', 'widget-importer-exporter' ); // explain why widget not imported
			}

			// Filter to modify settings before import
			// Do before identical check because changes may make it identical to end result (such as URL replacements)
			$widget = apply_filters( 'tdp_widget_settings', $widget );

			// Does widget with identical settings already exist in same sidebar?
			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

				// Get existing widgets in this sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' );
				$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

				// Loop widgets with ID base
				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
				foreach ( $single_widget_instances as $check_id => $check_widget ) {

					// Is widget in same sidebar and has identical settings?
					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

						$fail = true;
						$widget_message_type = 'warning';
						$widget_message = __( 'Widget already exists', 'widget-importer-exporter' ); // explain why widget not imported

						break;

					}
	
				}

			}

			// No failure
			if ( ! $fail ) {

				// Add widget instance
				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
				$single_widget_instances[] = (array) $widget; // add it

					// Get the key it was given
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );

					// If key is 0, make it 1
					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number = 1;
						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}

					// Move _multiwidget to end of array for uniformity
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}

					// Update option with new widget
					update_option( 'widget_' . $id_base, $single_widget_instances );

				// Assign widget instance to sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

				// Success message
				if ( $sidebar_available ) {
					$widget_message_type = 'success';
					$widget_message = __( 'Imported', 'widget-importer-exporter' );
				} else {
					$widget_message_type = 'warning';
					$widget_message = __( 'Imported to Inactive', 'widget-importer-exporter' );
				}

			}

			// Result for widget instance
			$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
			$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = $widget->title ? $widget->title : __( 'No Title', 'widget-importer-exporter' ); // show "No Title" if widget instance is untitled
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

		}

	}

	// Hook after import
	do_action( 'tdp_after_import' );

	// Return results
	return apply_filters( 'tdp_import_results', $results );

}

/**
 * Creates The Dashboard
 */
function tdp_theme_installer_page() { ?>
	
	<script>
	jQuery(window).load(function() {
		var import_running = false;
		jQuery('#import_demo_data').click(function() {
			if ( ! import_running) {
				if (confirm('Are you sure, you want to import Demo Data now?')) {
					import_running = true;
					
					jQuery('#import_demo_data').attr('disabled', 'disabled');
					
					jQuery('.hide-message').css('display', 'none');
					jQuery('.loading-message').show();

					jQuery.ajax({
						type: 'POST',
						url: "<?php echo admin_url('admin-ajax.php');?>",
						data: {
							action: 'us_dataImport'
						},
						success: function(data, textStatus, XMLHttpRequest){
							import_running = false;
							jQuery('#import_demo_data').hide();

							jQuery('.loading-message').hide();

							jQuery('.success-message').show();


							
						},
						error: function(XMLHttpRequest, textStatus, errorThrown){
							alert('Something Went Wrong!');
						}
					});
				}
			}


			return false;
		});
	});
	</script>

	<div class="wrap about-wrap">

		<div class="icon32" id="icon-index"><br></div>

		<h2>
			<?php _e('TDP - Theme Installer', 'tdp_installer'); ?>
			<span class="add-new-h2"><?php _e('Version ','tdp_installer');?> <strong><?php echo TDP_INSTALLER_VERSION; ?></strong></span>
			<span class="add-new-h2"><?php _e('Current Theme: ','tdp_installer');?> <strong><?php echo wp_get_theme( );?></strong></span>
		</h2>

		<?php  
            if( isset( $_GET[ 'tab' ] ) ) {  
                $active_tab = $_GET[ 'tab' ];  
            } // end if  
        ?>
		
		<h2 class="nav-tab-wrapper">  
            <a href="?page=tdp-theme-installer&tab=theme_setup_steps" class="nav-tab <?php if($active_tab == '' || $active_tab == 'theme_setup_steps') { echo 'nav-tab-active'; } ?>"><i class="icon-tools"></i> <?php _e('Theme Setup Check','tdp_installer');?></a>  
            <a href="?page=tdp-theme-installer&tab=theme_demo" class="nav-tab <?php echo $active_tab == 'theme_demo' ? 'nav-tab-active' : ''; ?>"><i class="icon-download-1"></i> <?php _e('1 Click Demo Setup','tdp_installer');?></a>    
        </h2> 

        <?php if($active_tab == '' || $active_tab == 'theme_setup_steps') { ?>

        <div id="dashboard_steps" class="postbox ">
			
			<h3 class="hndle">
				<span><i class="icon-tools"></i> <?php _e('Theme Setup Steps Check', 'tdp_installer'); ?></span>
			</h3>
			
			<div class="inside">
				
				<p class="about-auto-update blue-check"><i class="icon-info-circled-1"></i>
					<?php _e('Check that your theme has been correctly installed and that all the steps required to make it work as it should have been performed.','tdp_installer');?>
				</p>

			</div>

			
			<?php do_action('tdp_installer_theme_steps'); ?>


		</div>

		<?php } else if($active_tab == 'theme_demo') { ?>

			<div id="dashboard_steps" class="postbox ">
			
				<h3 class="hndle">
					<span><i class="icon-download-1"></i><?php _e('1 Click Demo Setup','tdp_installer');?></span>
				</h3>
				
				<div class="inside">
					
					<p class="about-auto-update blue-check hide-message">
						<?php _e('If you are new to wordpress or have problems creating posts or pages that look like the theme preview you can import dummy demo data posts and pages here that will definitely help to understand how those tasks are done.
<br/><br/>
You must also install and activate all the plugins required by the theme to ensure that everything will work as it should.','tdp_installer');?>
					</p>

					<p class="about-auto-update red-check hide-message"><i class="icon-info-circled-1"></i> 
						<?php _e('Please note: this process only works on clean WordPress setups, if you have existing content you must delete it before proceeding with the import.','tdp_installer');?>
					</p>

					<div class="loading-message animated fadeInDown">

						<div class="one_third align-center">
							<i class="icon-spinner animate-spin"></i>
						</div>

						<div class="two_third last">
							<h2><strong><?php _e('Please wait!','tdp_installer');?></strong></h2>

							<p><strong><?php _e('This process might take a while please do not re-load the page and do not close this page.','tdp_installer');?></strong></p>
						</div>

						<div class="clearboth"></div>

					</div>

					<div class="success-message animated fadeInDown">

						<div class="one_third align-center">
							<i class="icon-ok-circled"></i>
						</div>

						<div class="two_third last">
							<h2><strong><?php _e('Import Successfully completed! ','tdp_installer');?></strong></h2>
							<p><?php _e('Demo content has been successfully imported.','tdp_installer');?> <strong><?php _e('Make sure that all the steps into the "Theme Setup Check" tab are marked as done','tdp_installer');?></strong>, <?php _e('this will ensure that the theme will correctly work','tdp_installer');?>.</p>
						</div>

						<div class="clearboth"></div>

					</div>

					<?php do_action('tdp_installer_before_import_button');?>

					<a href="#" class="install-data button button-primary button-hero" id="import_demo_data"><i class="icon-download-1"></i> <?php _e( 'Click Here To Install Demo Data', 'tdp_installer' ); ?></a>
					<br/><br/>

				</div>

			</div>

        <?php } ?>

	</div>

<?php }

add_action('after_setup_theme', 'tdp_installer_init');

?>