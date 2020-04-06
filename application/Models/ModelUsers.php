<?php
class ModelUsers extends Model {
	
	public function delItemMenu($args = []){
		if(empty($args['nomitem'] && $args['nameitem'])){
			header ('Location: /users/adminCreateMenu');
		}
		
	}
	
	public function createMUData($args = []) {

		$data['tablemenu'] = $this->getMenuData();
		$data['select'] = $this->createSelectEditParent($data['tablemenu']);
		$data['menu'] = ( $this->createUlMenu($this->createArMenu1($this->createArMenu($data['tablemenu'])) , True) );
		
		return $data;
	}
	
	public function createMUAddMenu($args = []){
		if (!empty($args['addmenu'])){
			$nomItem = empty($args['nomitem']) ? 1 : $args['nomitem'];
			$nomItem = 0 ? 1 : $nomItem;
			if( !$this->poiskSovp($args['addmenu'], $nomItem) ){
				$this->zapros("INSERT INTO menu (name,parent,sort) VALUES ('" . $args['addmenu'] . "', $nomItem, '0')",$this->pdo);
			}
		}
		header('Location: /users/adminCreateMenu');
	}
	
	public function poiskSovp($string, $ind = 1) {
		
		$string = trim($string);
		$query = "SELECT * FROM menu WHERE name = '$string' AND parent = $ind ";
		$zapros = $this->zapros($query,$this->pdo);
		if(!empty($zapros)) return True;
		//while($result = $zapros->fetch(PDO::FETCH_ASSOC)){
		//	return True;
		//}
		return False;
	}

	public function addMenu () {
		//echo 'addmenu';
		
		
	}
	
}