jQuery(document).ready(function($) {

	$('.auto-dashboard-action-delete').click(function() {
		var answer = confirm( auto_manager_auto_dashboard.i18n_confirm_delete );

		if (answer)
			return true;

		return false;
	});

});