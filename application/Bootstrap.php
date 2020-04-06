<?php
function PutModels ($class){
	if (file_exists(PUT_APP . '/Models/' . $class . '.php')){
		include(PUT_APP . '/Models/' . $class . '.php');
	}
//	if (file_exists($_SERVER['DOCUMENT_ROOT'] . '../application/Models/' . $class . '.php')){
//		include($_SERVER['DOCUMENT_ROOT'] . '../application/Models/' . $class . '.php');
//	}
}

function PutControllers ($class){
	if (file_exists(PUT_APP . '/Controllers/' . $class . '.php')){
		include(PUT_APP . '/Controllers/' . $class . '.php');
	}
}

function PutViews ($class){
	if (file_exists(PUT_APP . '/Views/' . $class . '.php')){
		include(PUT_APP . '/Views/' . $class . '.php');
	}
}

function PutSayt ($class){
	//echo 'phtml';
	if (file_exists(PUT_LIB . '/Sayt/' . $class . '.php')){
		include(PUT_LIB . '/Sayt/' . $class . '.php');
	}
}

spl_autoload_register('PutSayt');
spl_autoload_register('PutControllers');
spl_autoload_register('PutModels');
spl_autoload_register('PutViews');
//include('Config.cnfg');
