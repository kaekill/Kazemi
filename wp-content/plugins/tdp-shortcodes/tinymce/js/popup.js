// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {

    jQuery('#TB_ajaxContent').css('background-color', '#fff');
    window.avada_tb_height = (92 / 100) * jQuery(window).height();
    window.avada_tdp_shortcodes_height = (71 / 100) * jQuery(window).height();
    if(window.avada_tdp_shortcodes_height > 550) {
        window.avada_tdp_shortcodes_height = (74 / 100) * jQuery(window).height();
    }

    jQuery(window).resize(function() {
        window.avada_tb_height = (92 / 100) * jQuery(window).height();
        window.avada_tdp_shortcodes_height = (71 / 100) * jQuery(window).height();

        if(window.avada_tdp_shortcodes_height > 550) {
            window.avada_tdp_shortcodes_height = (74 / 100) * jQuery(window).height();
        }
    });

    themetdp_shortcodes = {
    	loadVals: function()
    	{
    		var shortcode = $('#_tdp_shortcode').text(),
    			uShortcode = shortcode;
    		
    		// fill in the gaps eg {{param}}
    		$('.tdp-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('tdp_', ''),		// gets rid of the tdp_ prefix
    				re = new RegExp("{{"+id+"}}","g");
                    var value = input.val();
                    if(value == null) {
                      value = '';
                    }
    			uShortcode = uShortcode.replace(re, value);
    		});

    		// adds the filled-in shortcode as hidden input
    		$('#_tdp_ushortcode').remove();
    		$('#tdp-sc-form-table').prepend('<div id="_tdp_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	cLoadVals: function()
    	{
    		var shortcode = $('#_tdp_cshortcode').text(),
    			pShortcode = '';

    			if(shortcode.indexOf("<li>") < 0) {
    				shortcodes = '<br />';
    			} else {
    				shortcodes = '';
    			}

    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;
    			
                if($(this).find('#tdp_slider_type').length >= 1) {
                    if($(this).find('#tdp_slider_type').val() == 'image') {
                        rShortcode = '[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]';
                    } else if($(this).find('#tdp_slider_type').val() == 'video') {
                        rShortcode = '[slide type="{{slider_type}}"]{{video_content}}[/slide]';
                    }
                }
    			$('.tdp-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('tdp_', '')		// gets rid of the tdp_ prefix
    					re = new RegExp("{{"+id+"}}","g");
                        var value = input.val();
                        if(value == null) {
                          value = '';
                        }
    				rShortcode = rShortcode.replace(re, input.val());
    			});

    			if(shortcode.indexOf("<li>") < 0) {
    				shortcodes = shortcodes + rShortcode + '<br />';
    			} else {
    				shortcodes = shortcodes + rShortcode;
    			}
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_tdp_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_tdp_cshortcodes" class="hidden">' + shortcodes + '</div>');
    		
    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_tdp_ushortcode').html().replace('{{child_shortcode}}', shortcodes);
            
    		// add updated parent shortcode
    		$('#_tdp_ushortcode').remove();
    		$('#tdp-sc-form-table').prepend('<div id="_tdp_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false,
                onAdd: function(row) {
                    // Get Upload ID
                    var prev_upload_id = jQuery(row).prev().find('.tdp-upload-button').data('upid');
                    var new_upload_id = prev_upload_id + 1;
                    jQuery(row).find('.tdp-upload-button').attr('data-upid', new_upload_id);

                    // activate chosen
                    jQuery('.tdp-form-multiple-select').chosen({
                        width: '100%',
                        placeholder_text_multiple: 'Select Options or Leave Blank for All'
                    });

                    // activate color picker
                    jQuery('.wp-color-picker-field').wpColorPicker({
                        change: function(event, ui) {
                            themetdp_shortcodes.loadVals();
                            themetdp_shortcodes.cLoadVals();
                        }
                    });

                    // changing slide type
                    var type = $(row).find('#tdp_slider_type').val();

                    if(type == 'video') {
                        $(row).find('#tdp_image_content, #tdp_image_url, #tdp_image_target, #tdp_image_lightbox').closest('li').hide();
                        $(row).find('#tdp_video_content').closest('li').show();

                        $(row).find('#_tdp_cshortcode').text('[slide type="{{slider_type}}"]{{video_content}}[/slide]');
                    }

                    if(type == 'image') {
                        $(row).find('#tdp_image_content, #tdp_image_url, #tdp_image_target, #tdp_image_lightbox').closest('li').show();
                        $(row).find('#tdp_video_content').closest('li').hide();

                        $(row).find('#_tdp_cshortcode').text('[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]');   
                    }

                    themetdp_shortcodes.loadVals();
                    themetdp_shortcodes.cLoadVals();
                }
    		});
    		
    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();
    			
    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}
    			
    			return false;
    		});
    		
    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row',
                cancel: 'div.iconpicker, input, select, textarea, a'
			});
    	},
    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				tdpPopup = $('#tdp-popup');

            tbWindow.css({
                height: window.avada_tb_height,
                width: tdpPopup.outerWidth(),
                marginLeft: -(tdpPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: window.avada_tb_height,
				overflow: 'auto', // IMPORTANT
				width: tdpPopup.outerWidth()
			});

            tbWindow.show();

			$('#tdp-popup').addClass('no_preview');
            $('#tdp-sc-form-wrap #tdp-sc-form').height(window.avada_tdp_shortcodes_height);
    	},
    	load: function()
    	{
    		var	tdp = this,
    			popup = $('#tdp-popup'),
    			form = $('#tdp-sc-form', popup),
    			shortcode = $('#_tdp_shortcode', form).text(),
    			popupType = $('#_tdp_popup', form).text(),
    			uShortcode = '';
    		
            // if its the shortcode selection popup
            if($('#_tdp_popup').text() == 'shortcode-generator') {
                $('.tdp-sc-form-button').hide();
            }

    		// resize TB
    		themetdp_shortcodes.resizeTB();
    		$(window).resize(function() { themetdp_shortcodes.resizeTB() });
    		
    		// initialise
            themetdp_shortcodes.loadVals();
    		themetdp_shortcodes.children();
    		themetdp_shortcodes.cLoadVals();
    		
    		// update on children value change
    		$('.tdp-cinput', form).live('change', function() {
    			themetdp_shortcodes.cLoadVals();
    		});
    		
    		// update on value change
    		$('.tdp-input', form).live('change', function() {
    			themetdp_shortcodes.loadVals();
    		});

            // change shortcode when a user selects a shortcode from choose a dropdown field
            $('#tdp_select_shortcode').change(function() {
                var name = $(this).val();
                var label = $(this).text();
                
                if(name != 'select') {
                    tinyMCE.activeEditor.execCommand("tdpPopup", false, {
                        title: label,
                        identifier: name
                    });

                    $('#TB_window').hide();
                }
            });

            // activate chosen
            $('.tdp-form-multiple-select').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Options'
            });

            // update upload button ID
            jQuery('.tdp-upload-button:not(:first)').each(function() {
                var prev_upload_id = jQuery(this).data('upid');
                var new_upload_id = prev_upload_id + 1;
                jQuery(this).attr('data-upid', new_upload_id);
            });
    	}
	}
    
    // run
    $('#tdp-popup').livequery(function() {
        themetdp_shortcodes.load();

        $('#tdp-popup').closest('#TB_window').addClass('tdp-shortcodes-popup').css('background-color', '#fff');;



        $('#tdp_video_content').closest('li').hide();

            // activate color picker
            $('.wp-color-picker-field').wpColorPicker({
                change: function(event, ui) {
                    setTimeout(function() {
                        themetdp_shortcodes.loadVals();
                        themetdp_shortcodes.cLoadVals();
                    },
                    1);
                }
            });
    });

    // when insert is clicked
    $('.tdp-insert').live('click', function() {                        
        if(window.tinyMCE)
        {
            window.tinyMCE.activeEditor.execCommand('mceInsertContent', false, $('#_tdp_ushortcode').html());
            tb_remove();
        }
    });

    //tinymce.init(tinyMCEPreInit.mceInit['tdp_content']);
    //tinymce.execCommand('mceAddControl', true, 'tdp_content');
    //quicktags({id: 'tdp_content'});

    // activate upload button
    $('.tdp-upload-button').live('click', function(e) {
	    e.preventDefault();

        upid = $(this).attr('data-upid');

        if($(this).hasClass('remove-image')) {
            $('.tdp-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', '').hide();
            $('.tdp-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', '');
            $('.tdp-upload-button[data-upid="' + upid + '"]').text('Upload').removeClass('remove-image');

            return;
        }

        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Select Image',
            },
	        frame: 'post',
            multiple: false  // Set to true to allow multiple files to be selected
        });

	    file_frame.open();

        file_frame.on( 'select', function() {
            var selection = file_frame.state().get('selection');
                selection.map( function( attachment ) {
                attachment = attachment.toJSON();

                $('.tdp-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', attachment.url).show();
                $('.tdp-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', attachment.url);

                themetdp_shortcodes.loadVals();
                themetdp_shortcodes.cLoadVals();
            });

            $('.tdp-upload-button[data-upid="' + upid + '"]').text('Remove').addClass('remove-image');
            $('.media-modal-close').trigger('click');
        });

	    file_frame.on( 'insert', function() {
		    var selection = file_frame.state().get('selection');
		    var size = jQuery('.attachment-display-settings .size').val();

		    selection.map( function( attachment ) {
			    attachment = attachment.toJSON();

			    if(!size) {
				    attachment.url = attachment.url;
			    } else {
				    attachment.url = attachment.sizes[size].url;
			    }

			    $('.tdp-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', attachment.url).show();
			    $('.tdp-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', attachment.url);

			    themetdp_shortcodes.loadVals();
			    themetdp_shortcodes.cLoadVals();
		    });

		    $('.tdp-upload-button[data-upid="' + upid + '"]').text('Remove').addClass('remove-image');
		    $('.media-modal-close').trigger('click');
	    });
    });

    // activate iconpicker
    $('.iconpicker i').live('click', function(e) {
        e.preventDefault();

        var iconWithPrefix = $(this).attr('class');
        var fontName = $(this).attr('data-name').replace('icon-', '');

        if($(this).hasClass('active')) {
            $(this).parent().find('.active').removeClass('active');

            $(this).parent().parent().find('input').attr('value', '');
        } else {
            $(this).parent().find('.active').removeClass('active');
            $(this).addClass('active');

            $(this).parent().parent().find('input').attr('value', fontName);
        }

        themetdp_shortcodes.loadVals();
        themetdp_shortcodes.cLoadVals();
    });

    // table shortcode
    $('#tdp-sc-form-table .tdp-insert').live('click', function(e) {
        e.stopPropagation();

        var shortcodeType = $('#tdp_select_shortcode').val();

        if(shortcodeType == 'table') {
            var type = $('#tdp-sc-form-table #tdp_type').val();
            var columns = $('#tdp-sc-form-table #tdp_columns').val();

            var text = '<div class="table-' + type + '"><table width="100%"><thead><tr>';

            for(var i=0;i<columns;i++) {
                text += '<th>Column ' + (i + 1) + '</th>';
            }

            text += '</tr></thead><tbody>';

            for(var i=0;i<columns;i++) {
                text += '<tr>';
                if(columns >= 1) {
                    text += '<td>Item #' + (i + 1) + '</td>';
                }
                if(columns >= 2) {
                    text += '<td>Description</td>';
                }
                if(columns >= 3) {
                    text += '<td>Discount:</td>';
                }
                if(columns >= 4) {
                    text += '<td>$' + (i + 1) + '.00</td>';
                }
                text += '</tr>';
            }

            text += '<tr>';
            
            if(columns >= 1) {
                text += '<td><strong>All Items</strong></td>';
            }
            if(columns >= 2) {
                text += '<td><strong>Description</strong></td>';
            }
            if(columns >= 3) {
                text += '<td><strong>Your Total:</strong></td>';
            }
            if(columns >= 4) {
                text += '<td><strong>$10.00</strong></td>';
            }
            text += '</tr>';
            text += '</tbody></table></div>';

            if(window.tinyMCE)
            {
                window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, text);
                tb_remove();
            }
        }
    });

    // slider shortcode
    $('#tdp_slider_type').live('change', function(e) {
        e.preventDefault();

        var type = $(this).val();
        if(type == 'video') {
            $(this).parents('ul').find('#tdp_image_content, #tdp_image_url, #tdp_image_target, #tdp_image_lightbox').closest('li').hide();
            $(this).parents('ul').find('#tdp_video_content').closest('li').show();

            $('#_tdp_cshortcode').text('[slide type="{{slider_type}}"]{{video_content}}[/slide]');
        }

        if(type == 'image') {
            $(this).parents('ul').find('#tdp_image_content, #tdp_image_url, #tdp_image_target, #tdp_image_lightbox').closest('li').show();
            $(this).parents('ul').find('#tdp_video_content').closest('li').hide();

            $('#_tdp_cshortcode').text('[slide type="{{slider_type}}" link="{{image_url}}" linktarget="{{image_target}}" lightbox="{{image_lightbox}}"]{{image_content}}[/slide]');   
        }
    });

    $('.tdp-add-video-shortcode').live('click', function(e) {
        e.preventDefault();

        var shortcode = $(this).attr('href');
        var content = $(this).parents('ul').find('#tdp_video_content');
        
        content.val(content.val() + shortcode);
    });

    $('#tdp-popup textarea').live('focus', function() {
        var text = $(this).val();

        if(text == 'Your Content Goes Here') {
            $(this).val('');
        }
    });

    $('.tdp-gallery-button').live('click', function(e) {
	    var gallery_file_frame;

        e.preventDefault();

	    alert('To add images to this post or page for attachments layout, navigate to "Upload Files" tab in media manager and upload new images.');

        gallery_file_frame = wp.media.frames.gallery_file_frame = wp.media({
            title: 'Attach Images to Post/Page',
            button: {
                text: 'Go Back to Shortcode',
            },
            frame: 'post',
            multiple: true  // Set to true to allow multiple files to be selected
        });

	    gallery_file_frame.open();

        $('.media-menu-item:contains("Upload Files")').trigger('click');

        gallery_file_frame.on( 'select', function() {
            $('.media-modal-close').trigger('click');

            themetdp_shortcodes.loadVals();
            themetdp_shortcodes.cLoadVals();
        });
    });
});