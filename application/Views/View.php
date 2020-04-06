<?php
class View {
	public $viewContent;
	public $viewOn = FAlSE;
	public $modelData;
	public $viewName;
	
	function __construct (){
		//if ($viewName) {
		//	$this->viewName = $viewName;
		//}

		}
	
	public function createViewContent() {
		ob_start();
		include(__DIR__ . $this->viewName);
		$this->viewContent = ob_get_contents();
		ob_end_clean();
	}
//traids
	
	
	
	
}