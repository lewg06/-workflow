<?php
class ModelPribor extends Model {
	public $db = [];
	public $modelData;
	public $req;
	public $data;
	public $query;
	public $pdo;
	//public $err = [];
	
	private function getPriborDataAll(){
		return $this->zapros("SELECT nom,name FROM tip ORDER BY nom", $this->pdo);
	}
	
	private function getPriborParamTip($id = 0){
		$query = "SELECT p.nom as nom, p.type, p.name, tp.param as checked, tp.sort FROM param AS p 
		RIGHT JOIN tip_param AS tp 
		ON p.nom = tp.param 
		WHERE tip = $id 
		ORDER BY tp.tip, tp.sort, p.nom";
		return $this->zapros($query, $this->pdo);
	}
	
	private function getPriborParam(){
		$query = "SELECT p.nom as nom, p.name, p.type , 0 as checked, p.sort FROM param AS p 
		ORDER BY p.sort, p.name";
		return $this->zapros($query, $this->pdo);
	}
	
	private function getPriborName ($id = 0){
		$name = $this->zapros("SELECT name FROM tip WHERE nom=$id",$this->pdo);
		//print_r($name);exit();
		$name = empty($name) ? '' : $name[0]['name'];
		
		return $name;
	}
	
	private function getPriborNoTipParam ($tip, $not = ''){
		$not = empty($not) ? '' : ' NOT ';
		return $this->zapros('SELECT * FROM param WHERE nom ' . $not . ' IN 
									(SELECT param FROM tip_param WHERE 
									tip=' . $tip . ')',$this->pdo);
	}
	
	public function editPribor($args = []){
		if (!empty($args['addpribor']) ) {
			//renameParamOrType($args['oldparam'], $args['newparam'], $args['oldtype'], $args['newtype']);
		}
		if(!empty($args['addpribor']) ){
			if(!$this->poiskSovpPribor($args['addpribor'])){
				$this->zapros("INSERT INTO tip (name,user) VALUES ('" . $args['addpribor'] . "', '0')",$this->pdo);
			}
		}
		elseif( !empty($args['addpribortip']) && $this->isNumeric($args['addpribortip']) ){
			// && $this->proverkaParam($this->createKeyAgrs('checkboxpriborparam', 19,$args))
			$ar_key = $this->createKeyAgrs('checkboxpriborparam', 19, $args);
			if( empty($this->getPriborTipParam($args['addpribortip'])) ){
				foreach($ar_key['ar'] as $ar=>$ind){
					$this->zapros('INSERT INTO tip_param (tip, param, sort) VALUES (' . $args['addpribortip'] . ',' . $ind . ', 0)', $this->pdo);
				}
			}
			else{
				foreach($this->getPriborNoTipParam($args['addpribortip']) as $row=>$param){
					$ar_paramtip[] = $param['nom'];
				}
				foreach($ar_key['ar'] as $ar=>$ind){
					if(!in_array($ind, $ar_paramtip)){
						$this->zapros('INSERT INTO tip_param (tip, param, sort) VALUES (' . $args['addpribortip']. ',' . $ind . ', 0)', $this->pdo);
					}
				}
				foreach($ar_paramtip as $ar=>$ind){
					if(!in_array($ind, $ar_key['ar'])){
						//proverka na nepustoe znach
						//i udalenie param
						$poiskNOTNULL = $this->zapros('SELECT op.*,p.name as name2 FROM oborud_param op, param p WHERE 
														op.kod_param = p.nom AND 
														op.kod_param = ' . $ind . ' AND 
														(op.value_int !=0 OR op.value_text != "" OR op.value_date 
														!= NULL OR op.value_folder !="") 
														AND op.kod_oborud IN 
														(SELECT kod_oborud FROM oborud WHERE 
														kod_tip = ' . $args['addpribortip'] . ')',$this->pdo);
						if(empty($poiskNOTNULL) ){
							$this->zapros('DELETE FROM tip_param WHERE tip = ' . $args['addpribortip'] . ' AND param = ' . $ind , $this->pdo);
						}
						else{
							echo 'IMEYUTSYA NEPUSTIE POLYA';
							foreach($poiskNOTNULL as $row=>$data){
								$this->err['ar'][] = $data['kod_param'];
								$this->err['name'][] = $data['name2'];
								$this->err['addpribortip'] = $args['addpribortip'];
							}
						}
						
					}
				}
			}
		}
		return $this->createData($args);
	}
	
	private function proverkaParam ($ar){
		if (empty($ar['ar'])){return false;}
		$result = $this->getPriborParam();
		$arr = [];
		foreach($result as $row=>$search){
			$arr[] = $search['nom'];
		}
		foreach($ar['ar'] as $r=>$s){
			if(!in_array($s,$arr)) return False;
		}
		return True;
	}
	
	private function createData($args = []){
		$data['err'] = $this->err;
		$data['pribor'] = $this->getPriborDataAll();
		if((!empty($args['pribortip']) || !empty($args['addpribortip']) ) ){
			$pribor = !empty($args['pribortip']) ? $args['pribortip'] : $args['addpribortip'];
			if(!$this->isNumeric($pribor)) return $data;
			$data['pribortip'] = $pribor;
			$data['priborname'] = $this->getPriborName($pribor);
			if(empty($this->getPriborParamTip($pribor)) ){
				$data['priborparam'] = $this->getPriborParam();
				$data['priborparam2']= [];
			}
			else {
				$data['priborparam'] = $this->getPriborParamTip($pribor);
				$data['priborparam2'] = $this->getPriborNoTipParam($pribor, ' not ');
			}
		}

		return $data;
	}
	
	private function poiskSovpPribor($string, $ind = '') {
		$string = trim($string);
		$query = "SELECT * FROM tip WHERE name = '$string' ";
		$zapros = $this->zapros($query,$this->pdo);
		if(!empty($zapros)){
			return True;
		}
		return False;
	}
	
	
	private function renamePribor ($oldParam = '', $newParam = '', $oldTypa = '', $newType = '') {
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