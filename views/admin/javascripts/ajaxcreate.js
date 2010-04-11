var AC = {

	openDialog: function(data) {

		var setup = {
			modal: true,
			buttons: {"Add" : function() {
				data.name = jQuery('#ajax-create-dialog-name').val();
				data.description = jQuery('#ajax-create-dialog-description').val();
				
				jQuery.post(
					'http://localhost/workspace/omeka/ajax-create/create',
					data,
					AC.processResponse
				);
				} 
			} , 
			autoOpen: false,
			title: "Create A New " + data.type,
			width: "400px"
			};
		jQuery('#dialog').dialog(setup);
		jQuery('#dialog').dialog('open');
	
	},

	processResponse: function(data) {
		if(typeof data ==  'string') {
			data = eval('(' + data + ')' );
		}
		if(data.status == 'error') {
			alert(data.message);
		}
		var cb = eval(data.callback);
		cb(data);
	},

	cb: function(data) {
		alert(data.id);
	},

	appendToSelect: function(data) {
//		var sel = jQuery('#' + data.target);
		alert(data.target);
	}

}
