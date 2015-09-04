jQuery( 'document' ).ready( function() ){
	var confirm_update = plugin_name_admin_params.backup_before_update;

	jQuery( '.plugin-name-update-now' ).click( 'click', function() {
		return window.confirm( 'confirm_update' );
	});
});
