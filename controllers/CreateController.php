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

//redirect to special handling based on $type
		if(method_exists("AjaxCreate_CreateController", "_" . $type)) {
			$method = "_" . $type;
			$this->$method();
			exit;
		}

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
			$returnObj->message = "Could not save $type! Maybe check the error logs?";
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
    
	private function _Element()
	{
		$this->_helper->viewRenderer->setNoRender();
		$returnObj = new StdClass();
		$returnObj->callback = $_POST['callback'];
		$returnObj->target = $_POST['target'];
		$returnObj->status = "Error";
		$returnObj->message = "Elements cannot yet be created via this plugin.";		
		echo json_encode($returnObj);
		
	}
	
	
	
	
}

?>
