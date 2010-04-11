<?php



function ajax_create_dialog($options, $callback = "AC.appendToSelect" , $label = false)
{

	if(! isset($options['type'])) {
		throw new Exception('Type is required');
	}
	$type = $options['type'];
	$label = $label ? $label : "Create new $type";	
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
	
	echo "<p onclick='AC.openDialog($dataObjStr)' class='ajax-create-open-dialog'>$label</p>";
}





?>
