<?php 
class Users extends Controller {
	public $viewName = '/Users/Users/Users.phtml';
	public $viewOn = TRUE;
	public $modelName;
	
	public function actionIndex(){
		//if(Sayt::isRegistered() && $_SESSION['auth'] == 'admin'){
		//	$this->viewName = '/Users/Admin/Admin.phtml';

		//}
        
		$this->render();
		//return self::$viewName;
		//echo 'Index - actionIndex!!!';
	}
	
	public function actionExit(){
		Sayt::clearUser();
	}
	
	public function actionAdmin(){
		//echo 'UsersactionAdmin';
		$this->viewName = '/Users/Admin/Admin.phtml';
		$this->adminPrava();
		$this->actionIndex();
	}
		public function actionUser(){
		$this->viewName = '/Users/Users/Users.phtml';
		$this->actionIndex();
	}
	
	public function actionAdminCreateMenu(){
		$this->viewName = '/Users/Admin/CreateMenu/CreateMenu.phtml';
		$this->modelName = 'ModelUsers';
		$this->metod = 'createMUData';
		$this->args = $this->req;
		$this->adminPrava();
		$this->render();
	}
	
	public function actionAdminEditMenu(){
		$this->viewName = '/Users/Admin/CreateMenu/CreateMenu.phtml';
		$this->modelName = 'ModelUsers';
		$this->metod = 'createMUAddMenu';
		$this->args = $this->req;
		$this->adminPrava();
		$this->render();
	}
	public function actionAdminDeleteItem(){
		$this->viewName = '/Users/Admin/CreateMenu/CreateMenu.phtml';
		$this->modelName = 'ModelUsers';
		$this->metod = 'delItemMenu';
		$this->args = $this->req;
		$this->adminPrava();
		$this->render();
	}
	
	public function actionAdminEditParam(){
		$this->viewName = '/Users/Admin/EditParam/EditParam.phtml';
		$this->modelName = 'ModelParam';
		$this->metod = 'editParam';
		$this->args = $this->req;
		$this->adminPrava();
		$this->render();
	}
	
	public function actionAdminEditPribor(){
		$this->viewName = '/Users/Admin/EditPribor/EditPribor.phtml';
		$this->modelName = 'ModelPribor';
		$this->metod = 'editPribor';
		$this->args = $this->req;
		$this->adminPrava();
		$this->render();
	}
	
	public function actionUsersOborud (){
		$this->viewName = '/Oborud/Oborud.phtml';
		$this->modelName = 'ModelOborud';
		$this->metod = 'editOborud';
		$this->args = $this->req;
		$this->render();
	}
	
	public function actionUsersAjaxOborud (){
		//$this->viewOn = False;
		$this->viewName = '/OborudAjax/OborudAjax.phtml';
		$this->modelName = 'ModelAjaxOborud';
		$this->metod = 'ajaxOborud';
		$this->args = $this->req;
		$this->render();
	}
	
	public function actionUsersAjaxEditOborud (){
		//$this->viewOn = False;
		$this->viewName = '/OborudAjaxEdit/OborudAjaxEdit.phtml';
		$this->modelName = 'ModelAjaxEditOborud';
		$this->metod = 'ajaxEditOborud';
		$this->args = $this->req;
		$this->render();
	}
    
    public function actionUsersAjaxGetParam (){
		//$this->viewOn = False;
		$this->viewName = '/OborudAjaxGetParam/OborudAjaxGetParam.phtml';
		$this->modelName = 'ModelAjaxGetParam';
		$this->metod = 'ajaxGetParam';
		$this->args = $this->req;
		$this->render();
	}
	
}
