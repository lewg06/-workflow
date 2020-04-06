<?php
class ModelAjaxEditOborud extends Model {
	public $db = [];
	public $modelData;
	public $req;
	private $args;
	public $data;
	public $query;
	public $pdo;
	
	public function ajaxEditOborud($args = []){
		$this->args = $args;
		$userId = Sayt::getUserId();
		if(empty($this->args['editparamoborudkodoborud']) || empty($this->args['editparamoborudidmenu']) || !$this->isNumeric($this->args['editparamoborudkodoborud'])  || !$this->isNumeric($this->args['editparamoborudidmenu']) ){
			return False;
		}
		$kod_oborud = $this->args['editparamoborudkodoborud'];
		
		
		
		$tipmenu =$this->zapros("SELECT kod_tip,id_menu FROM oborud WHERE nom = $kod_oborud");
		if(empty($tipmenu) || empty($tipmenu[0]) || $tipmenu[0]['kod_tip'] == 0 || $tipmenu[0]['id_menu'] == 0 ) return False;
		$tip = $tipmenu[0]['kod_tip'];
		$id_menu = $tipmenu[0]['id_menu'];
		
		$ar_keyArgs = ($this->createKeyAgrs('editparamoborud', strlen('editparamoborud'), $this->args));
		$ar_paramOborud = $this->getPriborTipParam($tip);
		
		$ar_estNoParamOborud = $this->estNoParamOborud($ar_paramOborud, $this->createArray("SELECT kod_param as nom FROM oborud_param WHERE kod_oborud = $kod_oborud"));
		
		if(empty($ar_estNoParamOborud['est']) || empty($ar_estNoParamOborud['no']) ) {}//return False;
		$ar_estParamOborud = $ar_estNoParamOborud['est'];
		$ar_noParamOborud = $ar_estNoParamOborud['no'];

		//Вставка новых значений параметров
		$ar_proverkaData = $this->proverkaData($ar_paramOborud, $ar_noParamOborud, $args,'editparamoborud');
		//print_r($ar_proverkaData);
		if(empty($ar_proverkaData['err']['yes_param_value']) && !empty($ar_proverkaData['ar']) ){

			(new ModelOborud)->insertParamValue($ar_proverkaData['ar'],$id_menu, $tip, $userId, '', $kod_oborud);
		}
		else {
			$this->err['proverkadata'] = $ar_proverkaData['err'];

		}
		//Проверка значений и обновление значений существующих параметров
		$ar_proverkaData = $this->proverkaData($ar_paramOborud, $ar_estParamOborud, $args,'editparamoborud', $update = 1);
		//print_r($ar_proverkaData);
		if(empty($ar_proverkaData['err']['yes_param_value']) && !empty($ar_proverkaData['ar']) ){
			echo '!!!!!!!!!!!!!';
			(new ModelOborud)->updateParamValue($ar_proverkaData['ar'],$id_menu, $tip, $userId, $kod_oborud);
		}
		else {
			$this->err['proverkadata'] = $ar_proverkaData['err'];
		}

		return $this->createData($kod_oborud);
	}
	
	private function estNoParamOborud($arAll, $ar2){
		$ar_it = [];
		if(empty($ar_it['no'])) $ar_it['no'] = [];
		if(empty($ar_it['est'])) $ar_it['est'] = [];
		
		foreach($arAll as $ind=>$data){
			$nom = $data['nom'];
			if(array_key_exists($nom, $ar2)){
				$ar_it['est'][$nom] = $nom;
			}
			else{
				$ar_it['no'][$nom] = $nom;
			}
		}
		return $ar_it;
	}

	private function createData($kod_oborud){
		$data['paramoborud'] ='';
		
		return $data;
	}
	

}