<?php
session_start();
//wp-test
//xH(iVDgW2a5Jh5uhnb
header('Content-type: text/html; charset=utf-8');

//echo get_include_path();

define('PUT_APP',realpath($_SERVER['DOCUMENT_ROOT'] . '../application'));
define('PUT_LIB',realpath($_SERVER['DOCUMENT_ROOT'] . '../library'));
//echo PUT_LIB;

require_once(PUT_APP . '/Bootstrap.php');

writeLog();
lang();

//$_SESSION=[];
//print_r($_SESSION);echo '------';
//echo $_SERVER['REQUEST_URI'];

$uri = strtolower($_SERVER['REQUEST_URI']);
$url = $uri;
$zapros = '';
if (strpos($uri, '?')){
	$url = substr($uri,0,strpos($uri, '?'));
	$zapros = substr($uri, strpos($uri, '?'));
}

if (!Sayt::isRegistered()){
	echo 'NoREG';
	$_SERVER['REQUEST_URI'] = '/reg';
}
else {
	//echo 'YesReg';
    if (Sayt::isAdmin()){
		if( substr($url,0,12) !== '/users/admin' ){
			//echo '__a__';
			//header("Location: /users/admin");
			//header("Location: /users/admin?user=admin");
		}
	}
	else {
		if( substr($url,0,12) !== '/users/users' ){
			echo '__u__';
			header("Location: /users/Oborud");
			//header("Location: /users/user?user=" . $_SESSION['auth']);
		}
	}
}
	
route();

function writeLog(){
}
function lang(){
	if (isset($_COOKIE['lang'])) {$lang = $_COOKIE['lang'];} else {$lang = 'ru';}
	//print_r($_COOKIE);
}



function route(){
	$uri = strtolower($_SERVER['REQUEST_URI']);
	$zapros = '';
	if (strpos($uri, '?')){
		$zapros = substr($uri, strpos($uri, '?') + 1);
		$uri = substr($uri, 0, strpos($uri, '?'));
	}
	$_REQUEST['MY_ZAPROS'] = $zapros;
	$_REQUEST['MY_URI'] = $uri;
	
	if (substr($uri,-5) == '.html' || substr($uri,-6) == '.phtml' || substr($uri,-4) == '.php') {
		if (file_exists($uri)) {
			exit();
		} else {
			header("Location: /err/404.html");
			exit();
		}
	} else {
		//echo $uri;
		//echo substr($uri,1);
		$arrUri = explode('/', substr($uri,1));
		//echo print_r($arrUri);
		if (count($arrUri) == 0 || (count($arrUri) == 1 && !$arrUri[0]) || (count($arrUri) == 2 && !$arrUri[0] && !$arrUri[1])) {
			$controller = 'Index';
			$action = 'actionIndex';
		} elseif (count($arrUri) == 1 && $arrUri[0]) {
			$controller = ucfirst($arrUri[0]);
			$action = 'actionIndex';
		} elseif (count($arrUri) == 2 && $arrUri[0] && $arrUri[1]) {
			$controller = ucfirst($arrUri[0]);
			$action = 'action' . ucfirst($arrUri[1]);
		} else {
			header("Location: /err/404.html");
			//echo 'ERROR';
		}

		if (file_exists(PUT_APP . '/Controllers/' . $controller . '.php')) {
			$controller = new $controller;
			$controller->zapros = $zapros;
			if (method_exists($controller, $action)) {
				$action = $controller->$action();
				
				//if ($controller->viewOn) {
					
					print_r($controller->viewContent);
					exit();
					//print_r( $controller->req);
					
				//} else {
				//	print_r($controller->modelData);
					//header ("Location: /");
				//	exit();
				//}
			} else {echo 'no action!!!';exit();}
			
		}
		else { echo 'no controller!!!';exit();}
		
		//echo $controller . ' - ' . $action;
		//print_r($arrUri);
	}

//header("Location: /err/404.html");	
exit();

}

