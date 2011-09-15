<?php



function ajax_create_dialog($options, $callback = "AC.appendToSelect")
{

	if(! isset($options['type'])) {
		throw new Exception('Type is required');
	}
	
	$type = $options['type'];
	if (has_permission($type . 's', 'create')) {
			
		$label = isset($options['label']) ? $options['label'] : "Create new $type";	
		if(isset($options['skipDescription'])) {
			$skipDescription = $options['skipDescription'];
		} else {
			$skipDescription = false;
		}
		
		$dataObj = new StdClass();
		$dataObj->type = $type;
		$dataObj->skipDesc = $skipDescription;
		if(isset($options['target'])) {
			$dataObj->target = $options['target'];
		} else {
			$dataObj->target = false;		
		}
		$dataObj->callback = $callback;	
		$dataObjStr = json_encode($dataObj);
		
		return "<p onclick='AC.openDialog($dataObjStr)' class='ajax-create-open-dialog add'>$label</p>";					
		
	}

}





?>
