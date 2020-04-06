<?php
class Model {
	public $db = [];
	public $modelData;
	public $req;
	public $data;
	public $query;
	public $pdo;
	public $err = [];
	
	function __construct () {
		//require_once(PUT_APP . '/Config.cnfg');
		//$this->connectDailywear();
		//print_r($this->pdo);exit;
		$this->pdo = $this->connectDb();
	}
	
	private function connectDb(){
		try{ $pdo = new PDO('mysql:host=localhost;dbname=baza;charset=utf8;','root','');}
		catch(EPDOException $er){
			echo print_r($er); echo __FUNCTION__ . ' : ' . __METHOD__ ;exit();
		}
		return $this->pdo = $pdo;
	}
	
	public function zapros($query,$pdo = []){
		$data = [];
		$zapros = $this->pdo->query($query);
		if (!$zapros){print_r($this->pdo->errorinfo());echo __FUNCTION__ . ' : ' . __METHOD__ ;exit();}
		while($result = $zapros->fetch(PDO::FETCH_ASSOC)){
			$data[] = $result;
		}
		return $data;
	}
	
	public function zaprosParam($query,$ar_param = []){
		$data = [];
        //print_r($ar_param);
		$zapros = $this->pdo->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$zapros->execute($ar_param);
		if (!$zapros){print_r($this->pdo->errorinfo());echo __FUNCTION__ . ' : ' . __METHOD__ ;exit();}
		//$result = $zapros->fetchALL();
		//print_r($result);exit;
		while($result = $zapros->fetch(PDO::FETCH_ASSOC)){
			$data[] = $result;
		}
		return $data;
	}
	
	public function createModelData() {
	}
	
	public function getMenuData () {
		$query = 'SELECT * FROM menu';
		return $this->zapros($query,$this->pdo);
	}
	
	public function createArMenu($ar = [],$parent = '', $filtr = False){
		$ar_menu=[];
		$ar_tmp=[];

		//Opredelenie korennogo menu
		foreach($ar as $row=>$val){
			$id=(string) $val['nom'];
			$parentId=(string) $val['parent'];
			$name=(string) $val['name'];
			if(!empty($parent)){
				if( $val['nom'] == $parent ){//Для создания подменю для любого пункта
					//$ar_menu[] = ['str' => 'id=' . $id, 'id' => $id,'name'=> '' . $name, 'select' => $name];
					$ar_menu[$val['nom']] = ['str' => $id, 'id' => $id,'name'=> '' . $name, 'select' => $name];//Добавил val['nom'] в ar_menu для формирования id_menu
				}
				elseif( $val['parent'] ) {
					$ar_tmp[$val['nom']]=['id'=>$id,'parentId'=>$parentId,'name'=>$name, 'select' => $name];//Добавил val['nom'] в ar_menu для формирования id_menu
				}
			}
			else{
				if(!$val['parent']){
					//$ar_menu[] = ['str' => 'id=' . $id, 'id' => $id,'name'=> '' . $name, 'select' => $name];
					$ar_menu[] = ['str' => $id, 'id' => $id,'name'=> '' . $name, 'select' => $name];
				}
				else {
					$ar_tmp[]=['id'=>$id,'parentId'=>$parentId,'name'=>$name, 'select' => $name];
				}
			}
		}

		$ii = 1;
		$iii = (count($ar_menu) == 0 ? 1 : count($ar_menu) ) * (count($ar_tmp) == 0 ? 1 : count($ar_tmp) );// Проверить меню без вложенных подменю
		//while ($ii > 0){
		while($iii > 0){
			$ii=0;
			foreach($ar_menu as $ar => $val_menu){
				foreach($ar_tmp as $tmp => &$val_tmp){
					if($val_menu['id'] == $val_tmp['parentId'] && $val_tmp['id'] > 0){
						$strId = $val_menu['str'] . ',' . $val_tmp['id'];
						$strName = $val_menu['name'] . ',' . $val_tmp['name'];
						$strSelect = $val_menu['select'] . '->' . $val_tmp['select'];
						//$val_tmp['id'] = $val_tmp['id'];
							$ar_menu[$val_tmp['id']] = ['str' => $strId,'id' => $val_tmp['id'], 'name' => $strName, 'select' => $strSelect];//Добавил $val_tmp['id'] в ar_menu для формирования id_menu
						$val_tmp['id'] = 0;
						$val_tmp['parentId'] = 0;
					}
					$ii = $ii + $val_tmp['id'];
				}
			}
			$iii = $iii - 1;
		}
		$ar_tmp=[];

		asort($ar_menu);
		if(!empty($filtr)){
			$ar2 = []; //Создать в новый массив в который поместить все подпункты $parent
			foreach($ar_menu as $row=>$data){
				$ar = explode(',', $data['str']);
				if(in_array($parent,$ar)){
					$parentYes = 0;
					foreach($ar as $ind=>$data2){
						if($data2 == $parent) $parentYes = 1;
						if($parentYes > 0 ) $ar2[$data2] = $data2;
					}
				}
			}
			return $ar2;
		}
		//print_r($ar_menu);exit;
		return $ar_menu;
	}
	
	public function createArSelectMenu($ar_menu = []){
		return $ar_menu;
	}
	
	public function createArMenu1 ($ar_menu = []){
		$ar_menu1 = [];
		$ar_menu2 = [];
		$max_count = 0;
		//Убираем id= в str и разбираем её на массив, вычисляя макс длину массива и количество подменю
		foreach($ar_menu as $ar=>&$p){
			//$p['str']=substr($p['str'],3);
			$p['str'] = explode(',',$p['str']);
			$p['name'] = explode(',',$p['name']);
			$p['count'] = count($p['str']) - 1; //Для того чтобы проще было обходить массив ar_menu
			if( $max_count < count($p['str']) ){$max_count=count($p['str']);}
		}

		$str_menu = '';
		$ar_roditel = [];
		$ar_potomok = [];

		$ar_menu1 = [];
		function create_str_put($kol,$ar){$str=''; foreach($ar as $a=>$ell){if($kol < 0){break;} $str=$str.$ell.',';$kol=$kol-1;} if($str==''){$str='menu';} return ($str);}
		function create_str_roditel($kol,$ar){$str=''; foreach($ar as $a=>$ell){if($kol < 0){break;} $str=$str.$ell.',';$kol=$kol-1;} if($str==''){$str='menu';} return ($str);}

		for($i = $max_count; $i >= 1; $i = $i - 1){
			$ar_tmp = [];
			foreach($ar_menu as $are => $el){
				if(($el['count']) == $i){
					$str_put=create_str_put($i-1,$el['str']);
					$str_roditel=create_str_roditel($i-1,$el['name']);

					if ( empty($ar_tmp[$str_put]) ) {$ar_tmp[$str_put]['ar'] = [];}
					if(!in_array($el['name'][$i], $ar_tmp[$str_put]['ar'])){
		//	echo '<br>'.$el['str'][$i];    Без добавления ID в качестве номера в массиве      $ar_tmp[$str_put]['ar'][]=$el['name'][$i];
						$ar_tmp[$str_put]['ar'][$el['str'][$i]]=$el['name'][$i];
						$ar_tmp[$str_put]['roditel']=$str_roditel;
						$ar_tmp[$str_put]['roditel_id'] = $el['str'][$i - 1];
						//$ar_tmp[$str_put]['id'] = $el['str'][$i];
						$ar_tmp[$str_put]['uroven'] = $i;
						$ar_tmp[$str_put]['name'] = $el['name'][$i - 1];
					}
				}
				elseif( $i == 0 ){break;}
			}
			$ar_menu1[]=$ar_tmp;
		}
		//print_r($ar_menu1);exit;
		return $ar_menu1;
	}
	
	public function createUlMenu ($ar_menu1 = [], $nomItem = '') {
		$ar_roditel = [];
		$ar_poisk=[];
		$str_menu = 'Меню не создано!!!';

		for($i=0;$i<count($ar_menu1);$i=$i+1){
			$nom = $ar_menu1[$i];
			foreach($nom as $potomok=>$el){
				$roditel_id = $el['roditel_id'];
				$str_podmenu='';
				$uroven='uroven'.$el['uroven'];
				$str_menu='';
				foreach($el['ar'] as $rr=>$li){
					if(empty($ar_poisk[$roditel_id]['li'])) $ar_poisk[$roditel_id]['li'] = '';
					$a = "<a href='/users?$rr'>$li</a>";
					$nomItem = empty($nomItem) ? '' : " - $rr";
					$select = ''; //$select = $this->createSelectEditParent($this->getMenuData(),$roditel_id,$rr);
					$buttonDelItem = ''; //$buttonDelItem = $this->createButtonDelItem($rr,$li);
					
					if(!empty($ar_poisk[$rr]['li'])){
						$ar_poisk[$roditel_id]['li'] = $ar_poisk[$roditel_id]['li'] . "<li name='$rr'>$a $nomItem $select $buttonDelItem <ul name='$uroven' class='qsubmenu'>" . $ar_poisk[$rr]['li'] . '</ul></li>';
					}
					else {
						$ar_poisk[$roditel_id]['li'] = $ar_poisk[$roditel_id]['li'] . "<li name='$rr'>$a $nomItem $select $buttonDelItem </li>";
					}
				}
			$str_menu = $ar_poisk[$roditel_id]['li'];
			}
		}
		//print_r($ar_poisk);
		return $str_menu;
	}
	
	public function createButtonDelItem ($nomItem = '', $nameItem = ''){
		$button = '';
		if(!empty(trim($nomItem)) && !empty(trim($nameItem))){
			$button = "<form action='users/adminDeleteItem?nomItem=$nomItem&nameItem=$nameItem' method='get'>'<button type='submit' >Удалить запись</button></form>";		}
		return $button;
	}

	public function createSelectEditParent ($ar = [], $disabled = '', $selected = ''){
		$select = '';
		if (!empty($ar)){
			//$select = '<form action="/users/adminEditParent" method="get"><select name="nomitem">';
			$select = '<select name="nomitem">';
			foreach($ar as $row){
				//$select = $select . "<option " . $disabled = $row['nom'] ? " 'disabled' " : " '' " . $selceted = $row['parent'] ? " 'selected' " : " value='" . $row['nom'] . " '>" . $row['name'] . "</option>";
				//$select = $select . "<option " . $disabled = $row['nom'] ? " 'disabled' " : " '' " . " value='" . $row['nom'] . " '>" . $row['name'] . "</option>";
				$select = $select . "<option value='" . $row['nom'] . " '>" . $row['name'] . " - " . $row['nom'] . "</option>";
			}
			//$select = $select . "</select><button type='submit' >Ok</button></form>";
			$select = $select . '</select>';
		}
		return $select;
	}
	
	public function createKeyAgrs($text, $len, $args){
		$str = '';
		$arStr = [];
		foreach($args as $ar=>$text2){
			if( $text === substr($ar,0,$len) && $this->isNumeric(substr($ar,$len)) ){
				$str = $str . ',' . substr($ar,$len);
				$arStr[] = substr($ar,$len);
			}
		}
		if(!empty($str)) {
			$str = substr($str,1);
		}
		return ['str' => $str, 'ar' => $arStr];
	}
	
	public function createStrFromAr($ar = []){
		$str = '';
		if(!empty($ar)) $str = substr(implode(',',$ar),1);
		return $str;
	}
	
	public function getPriborTipParam($id = 0, $str = ''){
		$str = empty($str) ? ' ' : ' AND p.nom IN (' . $str . ') ';
		if(!$id){return $this->getPriborParam();}
		$query = "SELECT p.nom as nom, p.name, p.type, tp.param as checked, tf.proverka, tf.name as name_tip, tf.field_oborud, tf.kov, tp.sort FROM param AS p 
		RIGHT JOIN tip_param AS tp 
		ON p.nom = tp.param 
		RIGHT JOIN tip_field AS tf 
		ON p.type = tf.nom 
		WHERE tip = $id $str 
		ORDER BY tp.sort, tp.tip, p.nom";
		return $this->zapros($query, $this->pdo);
	}
	
	public function proverkaData($ar_param, $ar_key, $args, $text = '',$update = ''){
		$text = empty($text) ? 'addparam' : $text;
		$ar = [];
		foreach($ar_param as $row=>$data){
			if(in_array($data['nom'], $ar_key) && $this->proverkaTipa($args[$text . $data['nom']] , $data['type'], $update) ){
				$ar['ar']['param'][$data['nom']] = $args[$text . $data['nom']];
				$ar['ar']['field_oborud'][$data['nom']] = $data['field_oborud'];
				$ar['ar']['kov'][$data['nom']] = $data['kov'];
				//$ar['ar']['kov'][$data['nom']] = $ar_param['type'] === 'n' ? '' . '"';
			}
			elseif(!empty($args[$text . $data['nom']]) && !$this->proverkaTipa($args[$text . $data['nom']] , $data['type'])){
				$ar['err']['yes_param_value'][$data['nom']] = $args[$text . $data['nom']];
			}
			else{
				$ar['err']['no_param_value'][] = $data['nom'];
			}
		}
		//echo date('L'); exit;
		
		//print_r($ar_param);exit;
		// print_r($ar);//exit;
		return $ar;
	}
	
	public function createArray($query){
		$ar_it = [];
		foreach($this->zapros($query, $this->pdo) as $ind => $row){
			$ar_it[$row['nom']] = $row;
		}
		return $ar_it;
	}
	
	public function createArray2($ar = []){
		$ar_it = [];
		foreach($ar as $ind => $row){
			$ar_it[$row['nom']] = $row;
		}
		return $ar_it;
	}
    
    public function createArray3($query){
		$ar_it = [];
		foreach($this->zapros($query, $this->pdo) as $ind => $row){
			$ar_it[$row['nom']] = $row['nom'];
		}
		return $ar_it;
	}
		
	public function isNumeric($num, $nul = 0){
		if($num === 0 && $nul === 1 ){return True;}		
		if(is_numeric($num) && !empty($num) ){return True;}
		
		return False;
	}
	
	public function validateDate($date, $format = 'd.m.Y'){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	public function isData($data){
		if($this->validateDate($data)) return True;
		return False;
	}
	
	public function proverkaTipa($data, $tip, $update = ''){
		//echo '<br>'.$tip . ' - ' . $data;
		if( !empty($update) && $data === '' ){return True;}
		
		if( $tip == 1 && $data === '' ){return False;}
		elseif($tip == 1 && is_string($data) ){return True;}
		elseif($tip == 2 && $this->isData($data) ){return True;}
		elseif($tip == 5 && is_bool($data) ){return True;}
		elseif($tip == 3 && is_string($data) ){return True;}
		elseif($tip == 4 && $this->isNumeric($data, 1) ){return True;}
		
		return False;
	}
	
	public function createDataToMSQL($d){
		$d = empty($d) ? NULL : substr($d,-4) . '-' . substr($d,3,2) . '-' . substr($d,0,2);
		return $d;
	}
	
	public function createDataFromMYSQL($d){
		$d = empty($d) ? '' : substr($d,-2) . '.' . substr($d,5,2) . '.' . substr($d,0,4);
		return $d;
	}
	
	public function createTable($ar){
		
		
		
		
	}
	
	public function getParamDataAll(){
		return$this->zapros("SELECT nom,name,type FROM param ORDER BY nom", $this->pdo);
	}
	
	///////////////////////////////////////////////
		private function getFiltrOborud (){
		//SELECT p.name, o.kod_oborud, o.kod_param FROM param p, oborud o WHERE p.nom = o.kod_param GROUP BY kod_oborud, kod_param
		$query = 'SELECT p.name AS param_name, o.id_menu, o.kod_tip, t.name AS tip_name, p.type, tf.field_oborud, tf.nom AS field_type, op.kod_oborud, op.kod_param, op.value_int, op.value_date, op.value_text, op.value_fail, op.value_folder, op.value_bool  
				FROM oborud_param op, param p, tip t, tip_field tf, oborud o  
				WHERE o.kod_tip = t.nom AND op.kod_param = p.nom AND o.nom = op.kod_oborud AND tf.nom = p.type   
				GROUP BY op.kod_oborud, op.kod_param, op.value_int, op.value_text, op.value_bool, op.value_date, op.value_fail, op.value_folder';
		
		$result = $this->zapros($query, $this->pdo);
		//print_r($result);exit;
		$ar_result = [];
		foreach($result as $row=>$data){
			//echo '<br>-'.$data[$data['field_oborud']].'-';
			if(is_null($data[$data['field_oborud']]) || $data[$data['field_oborud']] == '' ) continue;
			//$data2 = ;
			if(empty($ar_result[$data['kod_tip']][$data['kod_param']][$data[$data['field_oborud']]]['count'])){
				$ar_result[$data['kod_tip']][$data['kod_param']][$data[$data['field_oborud']]]['count'] = 0;
			}
			$ar_result[$data['kod_tip']][$data['kod_param']][$data[$data['field_oborud']]]['count'] = $ar_result[$data['kod_tip']][$data['kod_param']][$data[$data['field_oborud']]]['count'] + 1;
			$ar_result[$data['kod_tip']][$data['kod_param']][$data[$data['field_oborud']]]['field_type'] = $data['type'];
			$ar_result[$data['kod_tip']][$data['kod_param']][$data[$data['field_oborud']]]['field_name'] = $data['param_name'];
			$ar_result[$data['kod_tip']][$data['kod_param']][$data[$data['field_oborud']]]['field_value'] = $data[$data['field_oborud']];
			$ar_result[$data['kod_tip']][$data['kod_param']][$data[$data['field_oborud']]]['menu'] = $data['id_menu'];
		}
		
		//print_r($ar_result);//exit;
		
		return $this->createFiltr($ar_result);
	}
	
	private function createFiltr($ar){
		$ar_sort = [];
		$ar_it = [];
		foreach($ar as $arr=>$kod_param){
			foreach($kod_param as $kod_param=>$arrr){
				//echo $kod_param;
				//$ar_sort[] = $kod_param[$name]['count'];
				$ar_it[$kod_param]['count_all'] = empty($ar_it[$kod_param]['count_all']) ? 0 : $ar_it[$kod_param]['count_all'];
				foreach($arrr as $name=>$data){
					$ar_it[$kod_param]['count_all'] = $ar_it[$kod_param]['count_all'] + $data['count'];
					$ar_it[$kod_param][$data['field_name']][$data['field_value']] = $data['count'];
					$ar_it[$kod_param]['field_type'] = $data['field_type'];
				}
				
			}
		}
		//arsort($ar_sort);

		return $ar_it;
	}
	//////////////////////////////////////
	
}