<?php 
class Reg extends Controller {
	public $viewName = '/Reg/Reg.phtml';
	public $viewOn = TRUE;
	public $modelName;

	
	public function actionIndex(){
        if(Sayt::isRegistered()) header("Location: /users/usersOborud");
		$this->render();
		//return self::$viewName;
		//echo 'Index - actionIndex!!!';
	}
}
