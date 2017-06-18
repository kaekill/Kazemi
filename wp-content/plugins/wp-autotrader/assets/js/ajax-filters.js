jQuery(document).ready(function($) {

	var xhr;

	$( '.auto_listings' ).on( 'update_results', function( event, page, append ) {

		if (xhr) xhr.abort();

		var target   = $(this);
		var form     = target.find( '.auto_filters' );
		var showing  = target.find( '.showing_autos' );
		var results  = target.find( '.auto_listings' );
		var per_page = target.data('per_page');
		var orderby  = target.data('orderby');
		var order    = target.data('order');

		if ( append ) {
			$( '.load_more_autos', target ).addClass('loading');
		} else {
			$(results).addClass('loading');
			$('li.auto_listing', results).css('visibility', 'hidden');
		}

		if ( target.data('show_filters') ) {

			var filter_auto_type = new Array();

			$(':input[name="filter_auto_type[]"]:checked', form).each(function() {
				filter_auto_type.push( $(this).val() );
			});

			var categories = form.find(':input[name^=search_categories], :input[name^=search_categories]').map(function () { return $(this).val(); }).get();
			var keywords  = '';
			var location  = '';
			var $keywords = form.find(':input[name=search_keywords]');
			var $location = form.find(':input[name=search_location]');

			// Workaround placeholder scripts
			if ( $keywords.val() != $keywords.attr( 'placeholder' ) )
				keywords = $keywords.val();

			if ( $location.val() != $location.attr( 'placeholder' ) )
				location = $location.val();

			var data = {
				action: 			'auto_manager_get_listings',
				search_keywords: 	keywords,
				search_location: 	location,
				search_categories:  categories,
				filter_auto_type: 	filter_auto_type,
				per_page: 			per_page,
				orderby: 			orderby,
				order: 			    order,
				page:               page,
				form_data:          form.serialize()
			};

		} else {

			var data = {
				action: 			'auto_manager_get_listings',
				search_categories:  target.data('categories').split(','),
				per_page: 			per_page,
				orderby: 			orderby,
				order: 			    order,
				page:               page
			};

		}

		xhr = $.ajax( {
			type: 		'POST',
			url: 		auto_manager_ajax_filters.ajax_url,
			data: 		data,
			success: 	function( response ) {
				if ( response ) {
					try {

						// Get the valid JSON only from the returned string
						if ( response.indexOf("<!--WPJM-->") >= 0 )
							response = response.split("<!--WPJM-->")[1]; // Strip off before WPJM

						if ( response.indexOf("<!--WPJM_END-->") >= 0 )
							response = response.split("<!--WPJM_END-->")[0]; // Strip off anything after WPJM_END

						var result = $.parseJSON( response );

						if ( result.showing )
							$(showing).show().html('').append( '<span>' + result.showing + '</span>' + result.showing_links );
						else
							$(showing).hide();

						if ( result.html )
							if ( append )
								$(results).append( result.html );
							else
								$(results).html( result.html );

						if ( ! result.found_autos || result.max_num_pages == page )
							$( '.load_more_autos', target ).hide();
						else
							$( '.load_more_autos', target ).show().data('page', page);

						$(results).removeClass('loading');
						$( '.load_more_autos', target ).removeClass('loading');
						$('li.auto_listing', results).css('visibility', 'visible');

					} catch(err) {
						console.log(err);
					}
				}
			}
		} );
	} );

	$( '#search_keywords, #search_location, .auto_types input, #search_categories' ).change( function() {
		var target = $(this).closest( 'div.auto_listings' );

		target.trigger( 'update_results', [ 1, false ] );
	} ).change();

	$( '.auto_filters' ).on( 'click', '.reset', function() {
		var target  = $(this).closest( 'div.auto_listings' );
		var form    = $(this).closest( 'form' );

		form.find(':input[name=search_keywords]').val('');
		form.find(':input[name=search_location]').val('');
		form.find(':input[name^=search_categories]').val('');
		$(':input[name="filter_auto_type[]"]', form).attr('checked', 'checked');

		target.trigger( 'reset' );
		target.trigger( 'update_results', [ 1, false ] );

		return false;
	} );

	$( '.load_more_autos' ).click(function() {
		var target = $(this).closest( 'div.auto_listings' );
		var page   = $(this).data( 'page' );

		if ( ! page )
			page = 1;
		else
			page = parseInt( page );

		$(this).data( 'page', ( page + 1 ) );

		target.trigger( 'update_results', [ page + 1, true ] );

		return false;
	} ).show();

});