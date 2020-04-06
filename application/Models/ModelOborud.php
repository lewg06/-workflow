<?php
class ModelOborud extends Model {
	public $db = [];
	public $modelData;
	public $req;
	private $args;
	public $data;
	public $query;
	public $pdo;
	
	private function getPriborDataAll(){
		return $this->zapros("SELECT nom,name FROM tip ORDER BY nom", $this->pdo);
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
	
	public function editOborud($args = []){
		$this->args = $args;
		$userId = Sayt::getUserId();
		$ar_keyArgs = ($this->createKeyAgrs('addparam', strlen('addparam'), $args));
		if(!empty($ar_keyArgs['str']) && !empty($args['addoborud']) && !empty($args['selectmenu']) && !empty($args['selecttip']) && $this->isNumeric($args['selectmenu']) && $this->isNumeric($args['selecttip']) ){
			$ar_paramOborud = $this->getPriborTipParam($args['selecttip'], $ar_keyArgs['str']);
			$ar_proverkaData = $this->proverkaData($ar_paramOborud, $ar_keyArgs['ar'], $args);
			if(empty($ar_proverkaData['err']['yes_param_value']) && !empty($ar_proverkaData['ar']) ){
				$this->insertData($ar_proverkaData['ar'],$args['selectmenu'], $args['selecttip'], $userId);
			}
			else {
				$this->err['proverkadata'] = $ar_proverkaData['err'];
			}
		}

		return $this->createData($args);
	}
	
	private function insertData($ar, $menu, $tip, $userId){//Вставляет новую запись в оборудование и получает идентификатор, который вставляют в oborud_param
		$proverka = md5(serialize([$ar, $menu, $tip, $userId, date('d.m.Y h:i:s a', time())]));
		$str_insert = "INSERT INTO oborud ( kod_tip, id_menu, user, proverka ) VALUES ( $tip, $menu, $userId, '$proverka' )";
		//$str2 = "SELECT MAX(nom) as nom FROM oborud WHERE user= $userId ";
		
		$insert = $this->zapros($str_insert, $this->pdo);
		$str2 = "SELECT MAX(nom) as nom FROM oborud WHERE proverka = '$proverka' ";
		$result = $this->zapros($str2, $this->pdo);
		//print_r($result);
		if(empty($result[0]['nom'])){
			echo 'Ошибка загрузки данных об оборудовании';
			return False;
		}
		else {
			$nom_oborud = $result[0]['nom'];
		}
		return $this->insertParamValue($ar, $menu, $tip, $userId, $proverka, $nom_oborud);
	}
	
	public function insertParamValue($ar, $menu, $tip, $userId, $proverka, $nom_oborud) {
		$str_field = '';
		$str_value = '';
		foreach($ar['param'] as $ind=>$data){	
			//echo '<br>' . $ar['field_oborud'][$ind];
			if( $ar['field_oborud'][$ind] === 'value_date'){
				$dd = $this->createDataToMSQL($ar['param'][$ind]) ;
			}
			else{
				$dd = $ar['param'][$ind];
			}
			//Добавить на проверку пустого значения и в update тоже
			//if($dd === 0 || $dd === '0' || !empty($dd)){}
			//else {continue;}
			$str_insert2 = 'INSERT INTO oborud_param ( kod_oborud, kod_param, proverka ,  ' . $ar['field_oborud'][$ind] . ' ) VALUES( ' . $nom_oborud . ',' . $ind . ', "' . $proverka . '" , ' . $ar['kov'][$ind] . $dd . $ar['kov'][$ind] . ' )';
			$insert2 = $this->zapros($str_insert2, $this->pdo);
		}
		//if(empty($str_value)) return False;
		//$str_field = substr($str_field,1);
		//$str_value = substr($str_value,1);

		if(empty($insert2)){
            //Нужно ли удалять все данные по оборудованию, если произошла ошибка вставки данных.
			return False;
		}
		else{
			return True;
		}
	}
	
	public function updateParamValue($ar, $menu, $tip, $userId, $nom_oborud){
		$str_field = '';
		$str_value = '';
		foreach($ar['param'] as $ind=>$data){	
			//echo '<br>' . $ar['field_oborud'][$ind];
			//echo '<br>' .$nom_oborud;
			//echo '<br>' .$ind;
			$paramVal = $this->zapros("SELECT * FROM oborud_param WHERE kod_oborud = $nom_oborud AND kod_param = $ind");

			if(empty($paramVal[0]['nom'])) return False;
			
			if( $ar['field_oborud'][$ind] === 'value_date'){
				$dd = $this->createDataToMSQL($ar['param'][$ind]) ;
			}
			else{
				$dd = $ar['param'][$ind];
			}
			
			//echo '<br>'.$dd.' = '. $paramVal[0][$ar['field_oborud'][$ind]];
			if ($paramVal[0][$ar['field_oborud'][$ind]] === $dd){
                //echo '------------------';
            }else{
				$str_dd = is_null($dd) ? 'NULL' : $ar['kov'][$ind] . $dd . $ar['kov'][$ind];
				//$str_update = "UPDATE oborud_param SET kod_oborud = $nom_oborud , kod_param = $ind, " . $ar['field_oborud'][$ind] . ' =  ' . $ar['kov'][$ind] . $dd . $ar['kov'][$ind] . "  WHERE kod_oborud = $nom_oborud AND kod_param = $ind";
				$str_update = "UPDATE oborud_param SET " . $ar['field_oborud'][$ind] . " =   $str_dd   WHERE kod_oborud = $nom_oborud AND kod_param = $ind";
				//echo '<br>'.$str_update;
				$update = $this->zapros($str_update);
			}
		}
		//if(empty($str_value)) return False;
		//$str_field = substr($str_field,1);
		//$str_value = substr($str_value,1);

		if(empty($update)){
			return False;
		}
		else{
			return True;
		}
	}

	private function createData($args = []){
		$menu = (!empty($args['selectmenu'])) ? $args['selectmenu'] : 'a';
		//$menu = (!empty($args['selectmenu']) && $args['selectmenu'] > 0) ? $args['selectmenu'] : 1;
		$tip = (!empty($args['selecttip']) && $args['selecttip'] > 0) ? $args['selecttip'] : 0;
		$order = !empty($this->args['order']) ? $this->args['order'] : 'data';
		
		$data['err'] = $this->err;
		$data['selectmenu'] =  $this->getSelectMenu($menu);
		$data['selecttip'] = $this->getSelectTip($tip);
		$data['selectmenu2'] = $this->getSelectMenu2(3);
		$data['selectmenu3'] = $this->createArMenu($this->getMenuData(), 3, True);
		$data['armenuall'] = $this->createArSelectMenu($this->createArMenu($this->getMenuData(),1));
		$data['artipall'] = $this->createArray('SELECT * FROM tip');
		//$data['arparamall'] = $this->createArray2($this->getParamDataAll());
		$data['selectparam'] = $this->getSelectParamOborud($tip);
		$data['filtroborud'] = $this->newFiltr();//$data['filtroborud'] = $this->getFiltrOborud();
		$data['browseoborud'] = $this->browseOborud($menu, $tip, $order);
		
		return $data;
	}
	
	public function browseOborud($menu, $tip, $order = 'menu',$kod_oborud = ''){
		
		$order = 'data';
		
		$ar_order['menu']['ar'] = $this->createArray('SELECT * FROM menu');
		$ar_order['menu']['str'] = ' o.id_menu ';
		$ar_order['tipp']['ar'] = $this->createArray('SELECT * FROM tip');
		$ar_order['tipp']['str'] = ' o.kod_tip ';
		$ar_order['para']['ar'] = $this->createArray('SELECT * FROM param');
		$ar_order['para']['str'] = ' ob.kod_param ';
		
		$key = substr($order,0,4);
		$val = substr($order, 4, strlen($order));
		$order = (array_key_exists($key, $ar_order)) && array_key_exists($val, $ar_order[$key]['ar']) ? 
		' ORDER BY ' . $ar_order[$key]['str'] . $val . ' ' : ' ORDER BY o.data DESC ';
		
		$menu = $this->isNumeric($menu) ? " AND o.id_menu = $menu " : ' AND o.id_menu > 0 ';
		$tip = ($tip == 0) ? " AND o.kod_tip > 0 " : " AND o.kod_tip = $tip ";
		$kod_oborud = $this->isNumeric($kod_oborud) ? " AND op.kod_oborud = $kod_oborud " : ' ';
		
		$ar_param = $this->createStrSelectParam();
        
        $str_param = !empty($ar_param['str']) ? ' AND op.nom > 0 ' . implode(' ', $ar_param['str']) . ' ' : '';
		
		$query = "SELECT p.name AS param_name, o.id_menu, o.kod_tip, t.name AS tip_name, p.type, tf.field_oborud, tf.nom AS field_type, op.kod_oborud, op.kod_param, op.value_int, op.value_date, op.value_text, op.value_fail, op.value_folder, op.value_bool  
				FROM oborud_param op, param p, tip t, tip_field tf, oborud o  
				WHERE o.kod_tip = t.nom AND op.kod_param = p.nom AND o.nom = op.kod_oborud AND tf.nom = p.type 
				$menu $tip $str_param $order ";
		//echo '<br>';
        //echo $query;
		//echo '<br>';
        

		$result['data'] = !empty($ar_param['ar']) ? $this->zaprosParam($query, $ar_param['ar']) : $this->zapros($query);
		
		$query = "SELECT p.name, p.nom, COUNT(p.nom) AS count_nom FROM oborud_param op, param p, tip t, tip_field tf, oborud o  
				WHERE o.kod_tip = t.nom AND op.kod_param = p.nom AND o.nom = op.kod_oborud AND tf.nom = p.type 
				$menu $tip $str_param GROUP BY p.nom ";
		//$query = "SELECT p.name, p.nom, COUNT(op.nom) AS count_nom FROM param p 
		//		LEFT JOIN oborud_param op 
		//		ON op.kod_param = p.nom 
		//		LEFT JOIN oborud o 
		//		ON o.nom = op.kod_oborud 
		//		LEFT JOIN tip t 
		//		ON o.kod_tip = t.nom 
		//		LEFT JOIN tip_field tf 
		//		ON tf.nom = p.type 
		//		WHERE p.nom > 0  $menu $tip $str_param GROUP BY p.nom ";
		
		
		$result['field'] = !empty($ar_param['ar']) ? $this->zaprosParam($query, $ar_param['ar']) : $this->zapros($query);
		
		//print_r($result['field']); //exit;
		
		return $result;
				//ORDER BY op.data, op.kod_oborud, op.kod_param, op.value_int, op.value_text, op.value_bool, op.value_date, op.value_fail, op.value_folder',$this->pdo);
	}

	private function createStrSelectParam(){
		$ar_it = [];
		$ar_null = $this->createKeyAgrs('selectnullparam', strlen('selectnullparam'),$this->args);
		$ar_sele = $this->createKeyAgrs('selectparam', strlen('selectparam'),$this->args);
		$ar_div = $this->createKeyAgrs('selectdivparam', strlen('selectdivparam'),$this->args)['ar'];
		if (empty($ar_sele['ar']) && empty($ar_null['ar'])) return $ar_it;

        if (!empty($ar_sele['ar']) && empty($ar_null['ar'])) $str3 = $ar_sele['str'];
        if (empty($ar_sele['ar']) && !empty($ar_null['ar'])) $str3 = $ar_null['str'];
        if (!empty($ar_sele['ar']) && !empty($ar_null['ar'])) $str3 = $ar_sele['str'] . ',' . $ar_null['str'];
        
		$ar_sele2 = $this->createArray('SELECT p.nom, p.type, tf.field_oborud FROM param p, tip_field tf 
										WHERE p.type = tf.nom AND p.nom IN (' . $str3 . ') ');     
        foreach($ar_sele2 as $ind => $row){// data???
        //echo '<br>' . $this->args['selectnullparam' . $ind];
			if(!empty($this->args['selectnullparam' . $ind])){
                $null2 = '';
                $null3 = '';
                if($row['field_oborud'] === 'value_text') $null2 = ' AND ' . $row['field_oborud'] . " <> '' ";
                if($row['field_oborud'] === 'value_int') $null2 = ' AND ' . $row['field_oborud'] . ' <> 0 ';

                $querynull = "SELECT o.nom FROM oborud o , tip_param tp WHERE tp.tip=o.kod_tip AND tp.param = $ind AND o.nom NOT IN(SELECT kod_oborud FROM oborud_param WHERE kod_param= $ind AND NOT ISNULL(" . $row['field_oborud'] . " ) $null2 )";
                $null3 = empty($this->createKeyAgrs('', strlen(''),$this->createArray3($querynull))['ar']) ? ' 0 ' : $this->createKeyAgrs('', strlen(''),$this->createArray3($querynull))['str'];
				$ar_it['str'][$ind] = " AND op.kod_oborud IN(  $null3 ) ";
                continue;
			}
			if ($row['type'] == 2){
				$data_select_true = !empty($this->args['selectparam' . $ind]) ? $this->isData($this->args['selectparam' . $ind]) : false;
				$data_select_div_true = !empty($this->args['selectdivparam' . $ind]) ? $this->isData($this->args['selectdivparam' . $ind]) : false;
				$this->args['selectparam' . $ind] = $this->createDataToMSQL($this->args['selectparam' . $ind]);
				$this->args['selectdivparam' . $ind] = $this->createDataToMSQL($this->args['selectdivparam' . $ind]);
				
				if (empty($this->args['checkdivparam' . $ind]) && $data_select_true ){//checkdivparam selectdiapazon
					//$ar_it[$ind] = " op.kod_param = $ind AND op." . $row['field_oborud'] . ' = ' . $this->args['selectparam' . $ind];
					$ar_it['str'][$ind] = " AND op.kod_oborud IN ( SELECT kod_oborud FROM oborud_param op WHERE op.kod_param = $ind AND op." . $row['field_oborud'] . ' =  :val' . $ind . ' ) ';
					$ar_it['ar'][':val' . $ind] = $this->args['selectparam' . $ind];
                    continue;
				}
				if (!$data_select_true && !$data_select_div_true ) continue;
				if ($data_select_true && $data_select_div_true){
					//$ar_it[$ind] = " op.kod_param = $ind AND op." . $row['field_oborud'] . ' >= ' . $this->args['selectparam' . $ind] . ' 
					//AND op.' . $row['field_oborud'] . ' <= ' . $this->args['selectdivparam' . $ind] . ' ';
					$ar_it['str'][$ind] = " AND op.kod_oborud IN ( SELECT kod_oborud FROM oborud_param op WHERE op.kod_param = $ind AND op." . $row['field_oborud'] . ' >= :val' . $ind . ' 
					 AND op.' . $row['field_oborud'] . ' <= :vall' . $ind . ') ';
					$ar_it['ar'][':val' . $ind] = $this->args['selectparam' . $ind];
					$ar_it['ar'][':vall' . $ind] = $this->args['selectdivparam' . $ind];
					continue;
				}
				if ( $data_select_true ){
					//$ar_it[$ind] = " op.kod_param = $ind AND op." . $row['field_oborud'] . ' >= ' . $this->args['selectparam' . $ind] . ' ';
					$ar_it['str'][$ind] = " AND op.kod_oborud IN ( SELECT kod_oborud FROM oborud_param op WHERE op.kod_param = $ind AND op." . $row['field_oborud'] . ' >= :val' . $ind . ') ';
					$ar_it['ar'][':val' . $ind] = $this->args['selectparam' . $ind];
					continue;
				}
				if ( $data_select_div_true ){
					//$ar_it[$ind] = " op.kod_param = $ind AND op." . $row['field_oborud'] . ' <= ' . $this->args['selectdivparam' . $ind];
					$ar_it['str'][$ind] = " AND op.kod_oborud IN ( SELECT kod_oborud FROM oborud_param op WHERE op.kod_param = $ind AND op." . $row['field_oborud'] . ' <= :vall' . $ind . ') ';
					$ar_it['ar'][':vall' . $ind] = $this->args['selectdivparam' . $ind];
					continue;
				}
			}
			if ($row['type'] == 4){
				$num_select_true = !empty($this->args['selectparam' . $ind]) ? $this->isNumeric($this->args['selectparam' . $ind], 1) : false;
				$num_select_div_true = !empty($this->args['selectdivparam' . $ind]) ? $this->isNumeric($this->args['selectdivparam' . $ind], 1) : false;
				
                if (empty($this->args['checkdivparam' . $ind]) && $num_select_true ){
					//$ar_it[$ind] = " AND op.kod_param = $ind AND op." . $row['field_oborud'] . ' = ' . $this->args['selectparam' . $ind];
					$ar_it['str'][$ind] = " AND op.kod_oborud IN ( SELECT kod_oborud FROM oborud_param op WHERE  op.kod_param = $ind AND op." . $row['field_oborud'] . ' = :val' . $ind . ') ';
					$ar_it['ar'][':val' . $ind] = $this->args['selectparam' . $ind];
					continue;
				}
				if ( !$num_select_true && !$num_select_div_true ) continue;
				if( $num_select_true && $num_select_div_true ){
					//$ar_it[$ind] = " AND op.kod_param = $ind AND op." . $row['field_oborud'] . ' >= ' . $this->args['selectparam' . $ind] . ' 
					//AND op.' . $row['field_oborud'] . ' <= ' . $this->args['selectdivparam' . $ind] . ' ';
					$ar_it['str'][$ind] = " AND op.kod_oborud IN ( SELECT kod_oborud FROM oborud_param op WHERE op.kod_param = $ind AND op." . $row['field_oborud'] . ' >= :val' . $ind . ' 
					AND op.' . $row['field_oborud'] . ' <= :vall' . $ind . ') ';
					$ar_it['ar'][':val' . $ind] = $this->args['selectparam' . $ind];
					$ar_it['ar'][':vall' . $ind] = $this->args['selectdivparam' . $ind];
					continue;
				}
				if( $num_select_true ){
					//$ar_it[$ind] = " AND op.kod_param = $ind AND op." . $row['field_oborud'] . ' >= ' . $this->args['selectparam' . $ind] . ' ';
					$ar_it['str'][$ind] =  " AND op.kod_oborud IN ( SELECT kod_oborud FROM oborud_param op WHERE op.kod_param = $ind AND op." . $row['field_oborud'] . ' >= :val' . $ind . ') ';
					$ar_it['ar'][':val' . $ind] = $this->args['selectparam' . $ind];
					continue;
				}
				if( $data_select_div_true ){
					//$ar_it[$ind] = " AND op.kod_param = $ind AND op." . $row['field_oborud'] . ' <= ' . $this->args['selectdivparam' . $ind];
					$ar_it['str'][$ind]=  " AND op.kod_oborud IN ( SELECT kod_oborud FROM oborud_param op WHERE op.kod_param = $ind AND op." . $row['field_oborud'] . ' <= :vall' . $ind . ') ';
					$ar_it['ar'][':vall' . $ind] =  $this->args['selectdivparam' . $ind];
					continue;
				}
			}
			if($row['type'] == 1 && ($this->args['selectparam' . $ind] != '') ){
				//$ar_it[$ind] = " AND op.kod_param = $ind AND op." . $row['field_oborud'] . ' LIKE ("%' . $this->args['selectparam' . $ind] . '%") ';
				$ar_it['str'][$ind] = " AND op.kod_oborud IN ( SELECT kod_oborud FROM oborud_param op WHERE op.kod_param = $ind AND op." . $row['field_oborud'] . ' LIKE :val' . $ind . ') ';
				$ar_it['ar'][':val' . $ind] = '%' . trim($this->args['selectparam' . $ind]) . '%';
				continue;
			}
		}
		return $ar_it;
	}
	
	private function newFiltr($menu = 0, $tip = 0, $str_param = '', $order = ''){
		
		$menu = empty($menu) ? " o.id_menu >= $menu " : "o.id.menu = $menu ";
		$tip = empty($tip) ? " o.kod_tip >= $tip " : "o.kod_tip = $tip ";
		$str_param = empty($str_param) ? "" : " AND ( $str_param ) ";
		$order = " ";
		//$order = empty($order) ? " " : " ORDER BY  ";
		
		$query = "SELECT p.nom, p.name, p.type, tf.field_oborud, tf.nom AS field_type FROM param p 
		LEFT JOIN oborud_param op 
		ON p.nom = op.kod_param 
		LEFT JOIN oborud o 
		ON o.nom = op.kod_oborud 
		LEFT JOIN tip_field tf 
		ON tf.nom = p.type 
		WHERE $menu AND $tip $str_param GROUP BY p.nom ";

		$ar_param_all = $this->zapros($query, $this->pdo);
		
		foreach($ar_param_all as $ar => $row){
			$ar_param_all2[$row['nom']]['field_oborud'] = $row['field_oborud'];
			$ar_param_all2[$row['nom']]['name'] = $row['name'];
			$ar_param_all2[$row['nom']]['field_type'] = $row['field_type'];
			$ar_param_all2[$row['nom']]['type'] = $row['type'];
		}
		
		$query = "SELECT op.kod_param, 
			value_bool, COUNT(value_bool) AS count_value_bool, 
			value_date, COUNT(value_date) AS count_value_date, 
			value_int, COUNT(value_int) AS count_value_int, 
			value_text, COUNT(value_int) AS count_value_text 
			FROM oborud_param op, oborud o
			WHERE o.nom = op.kod_oborud AND $menu AND $tip $str_param GROUP BY op.kod_param, value_bool, value_date, value_int, value_text ";

		//value_fail, COUNT(value_fail) AS count_value_fail, value_folder, COUNT(value_folder) AS count_value_folder, ... value_fail, value_folder, 
		
		$ar_param_value = $this->zapros($query, $this->pdo);
		
		$ar_it = [];
		foreach($ar_param_value as $ar => $row){
			$ind = $row['kod_param'];
			if($ar_param_all2[$ind]['type'] == 2){
				$ar_it[$ind]['ar'][$this->createDataFromMYSQL($row[$ar_param_all2[$ind]['field_oborud']])] = $row['count_' . $ar_param_all2[$ind]['field_oborud']];
			}
			else {
				$ar_it[$ind]['ar'][$row[$ar_param_all2[$ind]['field_oborud']]] = $row['count_' . $ar_param_all2[$ind]['field_oborud']];
			}

			$ar_it[$ind]['count_all'] = empty($ar_it[$ind]['count_all']) ? 0 : $ar_it[$ind]['count_all'];
			$ar_it[$ind]['count_all'] = empty($ar_param_all2[$ind]['field_oborud']) ? $ar_it[$ind]['count_all'] : $ar_it[$ind]['count_all'] + $row['count_' . $ar_param_all2[$ind]['field_oborud']];
			$ar_it[$ind]['name'] = $ar_param_all2[$ind]['name'];
			$ar_it[$ind]['type'] = $ar_param_all2[$ind]['type'];
		}
		
		return $ar_it;
	}

	
	private function selectError(){
		$query = 'SELECT * FROM oborud_param WHERE kod_oborud < 1 OR kod_param < 1 OR kod_oborud IN (SELECT nom FROM oborud WHERE id_menu < 1 OR kod_tip < 1 ) ';
		return $this->zapros($query, $this->pdo);
	}
	
	public function getSelectMenu($select = 'a',$nameselectmenu = ''){
		$nameselectmenu = empty($nameselectmenu) ? 'selectmenu' : $nameselectmenu;
		$str = '';
		foreach($this->createArSelectMenu($this->createArMenu($this->getMenuData())) as $ar=>$row){
			$select2 = ($select == $row['id']) ? ' selected ' : '';
			$str = $str . '<option value="' . $row['id'] . '" ' . $select2 . '>' . $row['select'] . '</option>';
		}
		if(!empty($str)){
			$str = "<select name='$nameselectmenu'>" . $str . '</select>';
		}
		return $str;
	}
	
	public function getSelectMenu2($parent){
		$str = '';
		foreach($this->createArSelectMenu($this->createArMenu($this->getMenuData(),$parent)) as $ar=>$row){
			$str = $str . '<option value="' . $row['id'] . '">' . $row['select'] . '</option>';
		}
		if(!empty($str)){
			$str = '<select name="selectmenu2">' . $str . '</select>';
		}
		return $str;
	}
	
	public function getSelectParamOborud($tip = 0){
		$str = '';
		foreach($this->zapros("SELECT p.*, tf.shablon FROM param p, tip_field tf WHERE p.type = tf.nom AND p.nom IN (SELECT param FROM tip_param WHERE tip = $tip )",$this->pdo) as $ar=>$row){
			$shablon = !(empty($row['shablon'])) ? ' pattern ="' . $row['shablon'] . '" ' : '';
			$str = $str . '<tr><td>' . $row['name'] . '</td><td><input type="text" name="addparam' . $row['nom'] . '" ' . $shablon . ' ></td></tr>';
		}
        if (!empty($str)) $str = '<table name="table_addparam">' . $str . '</table>';
		return $str;
	}
	
	public function getSelectTip($select = 0){
		$str = '';
		foreach($this->zapros('SELECT * FROM tip',$this->pdo) as $ar=>$row){
			$select2 = ($select == $row['nom']) ? ' selected ' : '';
			$str = $str . '<option value="' . $row['nom'] . '" ' . $select2 . ' >' . $row['name'] . '</option>';
		}
		if(!empty($str)){
			$str = '<select name="selecttip"> <option >Выберите оборудование для отображения параметров</option>' . $str . '</select>';
		}
		return $str;
		
	}
	
	private function createKeyArgs($text, $args){
		$str = '';
		$arStr = [];
		foreach($args as $ar=>$text2){
			if( $text === substr($ar,0,19) && $this->isNumeric(substr($ar,19)) ){
				$str = $str . ',' . substr($ar,19);
				$arStr[] = substr($ar,19);
			}
		}
		if(!empty($str)) {
			$str = substr($str,1);
		}
		return ['str' => $str, 'ar' => $arStr];
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