<?php
class ModelAjaxGetParam extends Model {
	public $db = [];
	public $modelData;
	public $req;
	private $args;
	public $data;
	public $query;
	public $pdo;
	
	public function ajaxGetParam($args = []){
		$this->args = $args;
		$userId = Sayt::getUserId();
		if(empty($this->args['tip']) || !$this->isNumeric($this->args['tip']) || empty( (new ModelOborud)->getSelectTip($this->args['tip']) ) ){
			echo 'Данный тип не доступен!!!';
            return False;
		}
		$str_tip = (new ModelOborud)->getSelectParamOborud($this->args['tip']);

		return $this->createData($str_tip);
	}
	
    private function createData($str_tip){
		$data['ajaxgetparam'] = $str_tip;
		
		return $data;
	}
	

}