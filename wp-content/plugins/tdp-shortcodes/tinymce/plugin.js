tinymce.PluginManager.add('tdp_button', function(ed, url) {
    ed.addCommand("tdpPopup", function ( a, params )
    {
        var popup = 'shortcode-generator';
 
        if(typeof params != 'undefined' && params.identifier) {
            popup = params.identifier;
        }
        
        jQuery('#TB_window').hide();
 
        // load thickbox
        tb_show("Shortcodes", ajaxurl + "?action=tdp_shortcodes_popup&popup=" + popup + "&width=" + 800);
    });
 
    // Add a button that opens a window
    ed.addButton('tdp_button', {
        text: '',
        icon: true,
        image: TdpShortcodes.plugin_folder + '/tinymce/images/icon.png',
        cmd: 'tdpPopup'
    });
});