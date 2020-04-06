<?php
class ModelSearch extends Model {
	public $query;
	
	public static function Search () {
	}
	
	public function createModelData () {
		$query = $this->createQuery();// запрос при поиске товаров
		$zapros = $this->pdo->query($query);
		if ( !$zapros ){echo print_r($this->pdo->errorinfo());exit();}
		$str_id = '';
		while($tovar = $zapros->fetch(PDO::FETCH_ASSOC)){
			$data[$tovar['id']] = '';
			$data[$tovar['id']]['picture'] = '';//Установка параметра picture по умолчанию
			$str_id = $str_id . ',' . $tovar['id'];
		}
		$str_id = substr($str_id, 1);
		
		$query = $this->createQueryVendorName($str_id);//Получение Vendor,Name
		$zapros=$pdo->query($query);
		if ( !$zapros ){echo print_r($pdo->errorinfo());exit();}
		while($tovar = $zapros->fetch(PDO::FETCH_ASSOC)){
			if ( !isset($data[$tovar['id']]) ) {continue;}
			$data[$tovar['id']]['vendor'] = $tovar['vendor'];
			$data[$tovar['id']]['name'] = $tovar['name'];
		}
		
		$query = $this->createQueryPictire ($str_id);//Получение картинки для заполнения div
		$zapros=$pdo->query($query);
		if ( !$zapros ){echo print_r($pdo->errorinfo());exit();}
		while($tovar = $zapros->fetch(PDO::FETCH_ASSOC)){
			if ( !isset($data[$tovar['id']]) ) {continue;}
			$data[$tovar['id']]['picture'] = $tovar['param_value'];
		}
		
		$query = $this->createQueryOptions($str_id);// запрос товаров имеющих размеры
		$zapros=$pdo->query($query);
		if ( !$zapros ){echo print_r($pdo->errorinfo());exit();}
		while($tovar = $zapros->fetch(PDO::FETCH_ASSOC)){
			if ( !isset($data[$tovar['id']]) ) {continue;}
			$data[$tovar['id']]['options'][$tovar['param_value']] = $tovar['ostatok'];
		}
		
		$query = $this->createQueryPrice ($str_id);//получение цены товара
		$zapros=$pdo->query($query);
		if ( !$zapros ){echo print_r($pdo->errorinfo());exit();}
		while($tovar = $zapros->fetch(PDO::FETCH_ASSOC)){
			if ( !isset($data[$tovar['id']]) ) {continue;}
			$data[$tovar['id']]['price'] = $tovar['price'];
		}
	
		$query = $this->createQueryZakazOptions ($str_id);// получение размеров товара из заказов для обновление остатков размеров
		$zapros=$pdo->query($query);
		if ( !$zapros ){echo print_r($pdo->errorinfo());exit();}
		while($tovar = $zapros->fetch(PDO::FETCH_ASSOC)){
			if ( !isset($data[$tovar['id']]['options'][$tovar['param_value']]) ) { continue; }
			$data[$tovar['id']]['options'][$tovar['param_value']] = $data[$tovar['id']]['options'][$tovar['param_value']] - $tovar['kolvo'];
		}
		
		$str_id = '';//Получение строки товаров не имеющих размеры для получения остатков по полю quantity
		foreach( $data as $ar=>$id ){
			foreach( $id as $name ){
				if( !isset( $name['options'] ) ) { continue; }
				$str_id = $str_id . ',' . $ar;
				//echo $id; exit;
			}			
		}
		
		$query = $this->createQueryOther ($str_id = '0');
		$zapros=$pdo->query($query);
		if ( !$zapros ){echo print_r($pdo->errorinfo());exit();}
		while($tovar = $zapros->fetch(PDO::FETCH_ASSOC)){
			if ( !isset($data[$tovar['id']]) ) {continue;}
			$data[$tovar['id']]['quantity'] = $tovar['param_value'];		
		}		
		
		$query = $this->createQueryZakazOther ($str_id = '0');//Получение остатков из заказов товаров без размеров
		$zapros=$pdo->query($query);
		if ( !$zapros ){echo print_r($pdo->errorinfo());exit();}
		while($tovar = $zapros->fetch(PDO::FETCH_ASSOC)){
			if ( !isset($data[$tovar['id']]) ) {continue;}
			$data[$tovar['id']]['quantity'] = $data[$tovar['id']]['quantity'] - $tovar['param_value'];
		}
		
		$_SESSION['page'] = $this->createPage($data,$this->data['kol_div']);
		$_SESSION['data'] = $data;
		return TRUE;
	}
	
	private function createQuery () {
		$ar_select = [];
		$nom = 0;
		
		if (!$ar_menu2 = $this->createArMenu2()) {return FALSE;}
		//print_r($ar_menu2);
		//exit;	
		
		$ar_select[$nom]['on'] = '';
		$ar_select[$nom]['where'] = '';
		foreach($this->data['id_menu'] as $ind=>$param) {
			if(!$param || !$ar_menu2[$param]){ continue;}
			$str_id = '';
			foreach($ar_menu2[$param]['ar'] as $ind=>$id){if(!$id){continue;} $str_id = $str_id . ',' . $id;}
			$ar_select[$nom]['where'] =  $ar_select[$nom]['where'] . " OR t$nom.id in (" . substr($str_id, 1) . ") ";
		}
		$ar_select[$nom]['where'] = empty($ar_select[$nom]['where']) ? " WHERE t0.id > 0 " : 'WHERE (' . substr($ar_select[$nom]['where'],4) . ')'; //удаляем первый or и добавляем общие скобки
		
		unset($ar_menu2);
		
		foreach($this->data['id_param'] as $ind=>$param){
			$ravnoEst = strpos($param, '=');
			if( !$ravnoEst || $ravnoEst == 0 ) {continue;}
			
			$nom = $nom + 1;
			$ar_param = explode(',', substr($param, $ravnoEst +1));
			$ar_select[$nom]['where'] = '';
			foreach( $ar_param as $ind=>$param ){
				if ( !$param ) {continue;}
				$ar_select[$nom]['on'] = " JOIN TOVAR t$nom ON to.id = t$nom.id ";
				$ar_select[$nom]['where'] = $ar_select[$nom]['where'] . ', "' . $param . '" ';
			}
			$ar_select[$nom]['where'] = " t$nom.id in (" . substr($ar_select[$nom]['where'],1) . ') ';
		}
		
		//search
		if($this->data['search']){
			$nom = $nom + 1;
			$ar_select[$nom]['on'] = "";
			$ar_select[$nom]['where'] =  ' "' . $this->data['search'] . '" = t0.param_value ';
		}
		
		$nom = $nom + 1;
		sort($this->data['price'],1);
		if ( $this->data['price'][0] >0 && $this->data['price'][1] > 0 ) {
			$ar_select[$nom]['on'] = "";
			$ar_select[$nom]['where'] =  ' ( t0.price BETWEEN ' . $this->data['price'][0] . ' AND ' . $this->data['price'][1] . ') ';
		} elseif ( $this->data['price'][0] >0 ) {
			$ar_select[$nom]['on'] = "";
			$ar_select[$nom]['where'] =  ' t0.price >= ' . $this->data['price'][0] . ' ';
		} elseif ( $this->data['price'][1] > 0 ) {
			$ar_select[$nom]['on'] = "";
			$ar_select[$nom]['where'] =  ' t0.price <= ' . $this->data['price'][1] . ' ';	
		}
		
		$query='select t0.id from tovar t0 ';
		foreach($ar_select as $ar=>$val){$query=$query . $val['on'];}
		foreach($ar_select as $ar=>$val){$query=$query . $val['where'] . ' AND ';}

		$query=substr($query,0,strlen($query)-6) . ' group by t0.id';
		
		//echo $query;
		return $query;
	}
	
	private function createQueryOptions ($str_id = '0') {
		$query = 'SELECT id, param_value, ostatok FROM tovar WHERE id in(' . $str_id . ') AND param = "options" ORDER BY id, param_value';
		return $query;
	}
	
	private function createQueryPrice ($str_id = '0') {
		$query = 'SELECT id, price FROM tovar WHERE id in(' . $str_id . ') AND price > 0 ORDER BY id';
		return $query;
	}
	
	private function createQueryPictire ($str_id = '0') {
		$query = 'SELECT id, param_value FROM tovar WHERE id in(' . $str_id . ') AND param ="picture" AND param_value <> "" ORDER BY id';
		return $query;
	}
	
	private function createQueryZakazOptions ($str_id = '0') {
		$query = 'SELECT id, param, param_value ,SUM(kolvo) AS kolvo FROM zakaz WHERE id in(' . $str_id . ') AND param = "options" GROUP BY id, options, param_value ';
		return $query;
	}
	
	private function createQueryOther ($str_id = '0') {
		$query = 'SELECT id, param, param_value FROM tovar WHERE id in(' . $str_id . ') AND param = "quantity" ORder BY id ';
		return $query;
	}
	
	private function createQueryZakazOther ($str_id = '0') {
		$query = 'SELECT id, param, param_value FROM zakaz WHERE id in(' . $str_id . ') AND param = "quantity" ORder BY id ';
		return $query;
	}
	
	private function createQueryVendorName ($str_id = '0') {
		$query = 'SELECT t0.id,to.param_value as vendor, t1.param_value as name FROM tovar t0 INNER JOIN tovar t1 ON t0.id = t1.id WHERE to.param = "vendor" and t1.param = "name" ';
		return $query;
	}
	
}