<?php



require_once(BASE_DIR . '/application/helpers/UserFunctions.php');

class AjaxCreate_CreateController extends Omeka_Controller_Action
{
	
	public $validTypes = array('ItemType', 'Collection', 'Tag');
	
	public function indexAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->returnObj = new StdClass();
		header('Content-type: application/javascript');
		$type = $_POST['type'];
		$name = $_POST['name'];
		$desc = $_POST['description'];



		if($this->_isValidType($type) && has_permission($type . 's', 'create') ) {
			if (method_exists("AjaxCreate_CreateController", "_" . $type ) ) {
				$method = "_" . $type;
				$this->$method();								
			} else {
				if(class_exists($type)) {
					try {
						$record = new $type();	
					} catch (Exception $e) {
						$this->returnObj->status = "Error";
						$this->returnObj->message = $e->message;
						echo json_encode($this->returnObj);
						exit;				
					}			
				} else {
					$this->returnObj->status = "Error";
					$this->returnObj->message = "That record type does not exist.";
					echo json_encode($this->returnObj);
					exit;							
				}
				
				
				$record->name = $name;
				$record->description = $desc;
				
				try {
					$record->save();
				} catch (Exception $e) {
					$this->returnObj->status = "Error";
					$this->returnObj->message = "Could not save $type! Maybe check the error logs?";
					echo json_encode($this->returnObj);
					exit;	
				}
				
				
				$this->returnObj->status = "OK";
				$this->returnObj->message = "";
				
				$this->returnObj->id = $record->id;
				$this->returnObj->name = $record->name;
				$this->returnObj->description = $record->description;
				$this->returnObj->type = $type;
				$this->returnObj->callback = $_POST['callback'];
				$this->returnObj->target = $_POST['target'];
				echo json_encode($this->returnObj);				
				exit;
			}	
		}
		
		$this->returnObj->status = "Error";
		$this->returnObj->message = "Invalid Type or you can't do that.";
		echo json_encode($this->returnObj);
	}
    
    private function _isValidType($type)
    {
		if(in_array($type, $this->validTypes) ) {
			return true;
		} else {
			$this->returnObj->status = "Error";
			$this->returnObj->message = "Creating that record type is not supported.";
			echo json_encode($this->returnObj);
			return false;
		} 	
    
    }
  
    
	private function _Element()
	{
		$this->_helper->viewRenderer->setNoRender();		
		$this->returnObj->callback = $_POST['callback'];
		$this->returnObj->target = $_POST['target'];
		$this->returnObj->status = "Error";
		$this->returnObj->message = "Elements cannot yet be created via this plugin.";		
		echo json_encode($this->returnObj);		
	}
	
	
	
	
}

?>
