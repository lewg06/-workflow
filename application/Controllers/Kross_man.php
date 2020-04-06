<?php
class Kross_man extends Controller {
	public $viewOn = TRUE;
	//public $viewName = '/Search/Index.phtml';
	//public $modelName = 'ModelSearch';
	public $ar_kol_div;
	public $ar_sort;
	
	
	public function actionIndex () {
		header("Location: /search?id_menu=1,3&id_param=56,72") ;
	}
	
	
	
	
	
	public function actionKross_man (){
		$this->viewName = '/SearchKrossMan/Index.phtml';
		if (!$this->isAjax()) {
			$this->viewOn = FALSE;
		}
	}
	
	
	
	
	
	
	
}
