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

		
		try {
			$record = new $type();	
		} catch (Exception $e) {


			echo json_encode($returnObj);
			exit;				
		}
		
		
		$record->name = $name;
		$record->description = $desc;
		
		try {
			$record->save();
		} catch (Exception $e) {
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
