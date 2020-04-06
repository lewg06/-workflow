<?php
class ModelParam extends Model {
	public $db = [];
	public $modelData;
	public $req;
	public $data;
	public $query;
	public $pdo;
	
	public function editParam($args = []){
		if (!empty($args['newparam']) && !empty($args['newtype']) && !empty($args['oldparam']) && !empty($args['oldtype']) ) {
			renameParamOrType($args['oldparam'], $args['newparam'], $args['oldtype'], $args['newtype']);
		}
		if(!empty($args['addparam']) && !empty($args['paramtype']) && $this->isNumeric($args['paramtype']) && !empty($this->zapros('SELECT * FROM tip_field WHERE nom=' . $args['paramtype'] ,$this->pdo)) ){
			if(!$this->poiskSovpParam($args['addparam'],$args['paramtype'])){
				$this->zapros("INSERT INTO param (name,type,user) VALUES ('" . $args['addparam'] . "', " . $args['paramtype'] . ", '0')",$this->pdo);
			}
		}
		return $this->createData();
	}
	
	private function createData(){
		$data['param'] = $this->getParamDataAll();
		$data['selectparamtype'] = $this->createTipField($this->zapros('SELECT * FROM tip_field ORDER BY sort',$this->pdo), 'paramtype');
		$data['selectchangeparamtype'] = $this->createTipField($this->zapros('SELECT * FROM tip_field ORDER BY sort',$this->pdo), 'selectchangeparamtype');;
		return $data;
	}
	
	private function poiskSovpParam($string, $ind = '') {
		
		$string = trim($string);
		$query = "SELECT * FROM param WHERE name = '$string' ";
		$zapros = $this->zapros($query,$this->pdo);
		if(!empty($zapros)){
			return True;
		}
		return False;
	}
	
	public function createTipField($ar = [], $select_name = ''){
		$str= '';
		foreach($ar as $row=>$data){
			$str = $str . '<option value="' . $data['nom'] . '">' . $data['name'] . '</option>';
		}
		if(!empty($str)) $str = "<select name='$select_name' >" . $str . '</select>';
		return $str;
	}
	
	private function renameParamOrType ($oldParam = '', $newParam = '', $oldTypa = '', $newType = '') {
		if( ($oldParam != $newParam || $newType != $oldType) && !$this->poiskSovpParam($newParam) ) {
			if( $this->useType() ){}
			if( $this->useParam() ){}
			//$zapros = "UPDATE param SET name = $newParam, type = $newType WHERE name = $oldParam";
		}
	}

	private function useParam($nameParam) {
		return True;
	}
	
	private function useType($typeParam) {
		return True;
	}
}