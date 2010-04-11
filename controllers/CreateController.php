<?php





class AjaxCreate_CreateController extends Omeka_Controller_Action
{
	public function indexAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$returnObj = new StdClass();
		header('Content-type: application/javascript');
		$type = $_POST['type'];
		$name = $_POST['name'];
		$desc = $_POST['description'];


		if(class_exists($type)) {
			try {
				$record = new $type();	
			} catch (Exception $e) {
				$returnObj->status = "Error";
				$returnObj->message = $e->message;
				echo json_encode($returnObj);
				exit;				
			}			
		} else {
			$returnObj->status = "Error";
			$returnObj->message = "That record type does not exist.";
			echo json_encode($returnObj);
			exit;							
		}
		

		
		
		$record->name = $name;
		$record->description = $desc;
		
		try {
			$record->save();
		} catch (Exception $e) {
			$returnObj->status = "Error";
			$returnObj->message = $e->message;
			echo json_encode($returnObj);
			exit;	
		}
		
		
		$returnObj->status = "OK";
		$returnObj->message = "";
		
		$returnObj->id = $record->id;
		$returnObj->name = $record->name;
		$returnObj->description = $record->description;
		$returnObj->type = $type;
		$returnObj->callback = $_POST['callback'];
		$returnObj->target = $_POST['target'];
		echo json_encode($returnObj);
	}
    

	
	
	
	
}

?>
