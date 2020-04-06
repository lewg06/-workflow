<?php
class ModelAjaxOborud extends Model {
	public $db = [];
	public $modelData;
	public $req;
	private $args;
	public $data;
	public $query;
	public $pdo;
	
	public function ajaxOborud($args = []){
		$this->args = $args;

		$kod_oborud = !empty($this->args['kod_oborud']) ? $this->args['kod_oborud'] : 0;

		if (!$this->isNumeric($kod_oborud,1)){ echo 'Нет кода оборудования!!!'; return;}
		return $this->createData($kod_oborud);
	}
	


	private function createData($kod_oborud){
		$data['paramoborud'] = $this->createArray("SELECT op.kod_param AS nom, o.id_menu, t.name AS name_tip, op.kod_oborud, op.value_date, op.value_int, op.value_text, op.value_fail, op.value_folder, op.value_bool, tf.field_oborud, o.kod_tip, o.id_menu 
											FROM oborud o, oborud_param op, tip_field tf, tip_param tp, tip t, param p  
											WHERE o.nom = op.kod_oborud AND op.kod_param = p.nom AND p.type = tf.nom AND tp.param = p.nom AND t.nom = tp.tip AND op.kod_oborud = $kod_oborud ");
		$data['allparam'] = [];
		if(empty(reset($data['paramoborud'])['kod_tip'])) return;
		$tip = reset($data['paramoborud'])['kod_tip'];

		$data['allparam'] = $this->createArray("SELECT p.nom, p.name, tf.field_oborud, tf.nom AS kod_tip_field FROM param p, tip_param tp, tip_field tf WHERE p.nom = tp.param AND p.type = tf.nom AND tp.tip = $tip ORDER BY tp.sort");
		$data['nametip'] = reset($data['paramoborud'])['name_tip'];
		
		$data['selectmenutip'] = (new ModelOborud)->getSelectMenu(reset($data['paramoborud'])['id_menu'],'editparamoborudidmenu');
		
		return $data;
	}
	

}