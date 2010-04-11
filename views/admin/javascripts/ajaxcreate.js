var AC = {

	openDialog: function(data) {
		jQuery('#ajax-create-dialog-name').val('');
		jQuery('#ajax-create-dialog-description').val('');
		jQuery('.ajax-create-dialog-type-name').text(data.type);
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
		if(data.status == 'Error') {
			alert(data.message);
			jQuery('#dialog').dialog('close');			
			return;
		}
		var cb = eval(data.callback);
		cb(data);
		jQuery('#dialog').dialog('close');
	},

	appendToSelect: function(data) {
		var sel = jQuery('#' + data.target);
		var newOption = document.createElement('option');
		jQuery(newOption).attr('label', data.name);
		jQuery(newOption).attr('value', data.id);
		jQuery(newOption).text(data.name);
		jQuery(sel).append(newOption);
		jQuery(sel).val(data.id);
	}

}
