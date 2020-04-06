<?php
class Search extends Controller {
	public $viewOn = TRUE;
	public $viewName = '/Search/Search.phtml';
	public $modelName = 'ModelSearch';
	public $ar_kol_div;
	public $ar_sort;
	
	
	public function actionIndex () {
		$this->ar_kol_div['50'] = 50;
		$this->ar_kol_div['60'] = 60;
		$this->ar_kol_div['100'] = 100;
		
		$this->ar_sort['1'] = ' order by 1 ';
		$this->ar_sort['2'] = ' order by 2 ';
		$this->ar_sort['3'] = ' order by 3 ';
		
		if (!$this->isAjax()) {
			$this->viewOn = FALSE;
		}
		
		//print_r($this->req);exit;
		
		$this->createData();
		if ( $this->searchInSession() ) {//Нужно добавить проверку срока запроса для сброса сессии
			//$this->modelData = $_SESSION['select_page'][$this->data['page']];
			$modelName = FALSE;
			$_SESSION['select_page'] = $this->data['page'];
		} else {
			$_SESSION['zapros'] = $this->zapros;
			$_SESSION['select_page'] = '';
			
		}
		$this->render();
		//print_r($this->req);
	}
	
	public function createData () {
		$this->data['search'] = isset($this->req['search']) ? $this->req['search'] : '';
		$this->data['page'] = isset($this->req['page']) ? $this->req['page'] : '';
		$this->data['kol_div'] = ( isset($this->req['kol_div']) && array_key_exists($this->req['kol_div'], $this->ar_kol_div) ) ? $this->ar_kol_div[$this->req['kol_div']] : $this->ar_kol_div['50'];
		$this->data['sort'] = ( isset($this->req['sort']) && array_key_exists($this->req['sort'], $this->ar_sort) ) ? $this->ar_sort[$this->req['sort']] : $this->ar_sort['1'];
		
		$this->data['price'][] = isset($this->req['min']) ? $this->req['min'] : '0';
		$this->data['price'][] = isset($this->req['max']) ? $this->req['max'] : '0';
		
		$this->data['id_menu'] = [];
		$this->data['id_param'] = [];
		
		if( isset($this->req['id_menu2']) ) {
			$this->data['id_menu'] = explode( ',', $this->req['id_menu2'] );
		} elseif ( isset($this->req['id_menu']) ) {
			$this->data['id_menu'] = explode( ',', $this->req['id_menu'] );
		}
		if ( isset($this->req['id_param']) ) {
			$this->data['id_param'] = explode( ';', $this->req['id_param'] );		
		}
		//print_r($this->data['id_menu']);
		//exit;
		
		//$this->data['id_menu'] = ( ) &&  )


		
		//$this->data['id_menu']
		
		
	}

	
	public function newSearch () {
		
	}
	
	public function searchInSession () {
		//(isset($_SESSION['poisk_text']) && isset($this->data['poisk_text']) && $_SESSION['poisk_text'] === $this->data['poisk_text'])
		//if ( $_SESSION['poisk_text']) && $_SESSION['poisk_text'] !== $this->data['poisk_text'] ) {
		//	return FALSE;
		//} elseif ( isset($_SESSION['page']) && !array_key_exists($this->data['page'],$_SESSION['page']) ) {
		//	return FALSE;
		//} elseif ( isset($_SESSION['kol_div']) && $_SESSION['kol_div'] != $this->data['kol_div'] ) {
		//	return false;
		//} elseif (  )
		
		//if (strlen($this->zapros) === 0) return FALSE;

		if ( isset($_SESSION['zapros']) && ($this->zapros == $_SESSION['zapros']) ) {
			return TRUE;
		} elseif ( isset($_SESSION['zapros']) && ($this->zapros == $_SESSION['zapros']) ) { //нужно преобразовать его с помощью функции
			return TRUE;
		} elseif ( isset($_SESSION['zapros']) && stripos($this->zapros, $_SESSION['zapros']) ) {
			return TRUE;
		} else {
			return FALSE;
		}		
	}
	
	
	
	
	
	public function actionKross_man (){
		$this->viewName = '/SearchKrossMan/Index.phtml';
		if (!$this->isAjax()) {
			$this->viewOn = FALSE;
		}
	}
	
	
	
	
	
	
	
}
