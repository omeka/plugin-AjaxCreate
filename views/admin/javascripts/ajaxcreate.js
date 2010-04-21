var AC = {

	openDialog: function(data) {
	
		jQuery('#ajax-create-dialog-name').val('');		
		jQuery('#ajax-create-dialog-description').val('');
		if(data.skipDesc) {
			jQuery('.ajax-create-dialog-description').hide();
		} else {
			jQuery('.ajax-create-dialog-description').show();
		}
		var setup = {
			modal: true,
			buttons: {"Add" : function() {
				data.name = jQuery('#ajax-create-dialog-name').val();
				if(!data.skipDesc) { 
					data.description = jQuery('#ajax-create-dialog-description').val();
				}
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
		jQuery('#ajax-create-dialog').dialog(setup);
		jQuery('#ajax-create-dialog').dialog('option', setup);
		jQuery('#ajax-create-dialog').dialog('open');
	
	},

	processResponse: function(data) {
		if(typeof data ==  'string') {
			data = eval('(' + data + ')' );
		}
		if(data.status == 'Error') {
			alert(data.message);
			jQuery('#ajax-create-dialog').dialog('close');			
			return;
		}
		var cb = eval(data.callback);
		cb(data);
		jQuery('#ajax-create-dialog').dialog('close');
	},

	appendToSelect: function(data) {
		var sel = jQuery(data.target);
		var newOption = document.createElement('option');
		jQuery(newOption).attr('label', data.name);
		jQuery(newOption).attr('value', data.id);
		jQuery(newOption).text(data.name);
		jQuery(sel).append(newOption);		
	}

}
