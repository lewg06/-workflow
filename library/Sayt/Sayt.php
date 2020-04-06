<?php

class Sayt {
	
	static function isRegistered(){
		if ( isset($_SESSION['auth']) && !empty($_SESSION['auth']) ){
//			&& $_SESSION['auth'] === Sayt::getReqUser() ){
			return true;}
		elseif (isset($_REQUEST['user']) && isset($_REQUEST['pass']) && Sayt::userRegistered($_REQUEST['user'],$_REQUEST['pass'])){
			return True;
		}
		else {
			//Sayt::clearUser();
			return False;
		}
	}
	
	static function userRegistered($user,$pass){
		$pdo = Sayt::connectDb();
		if($pdo){
			$query = 'SELECT * FROM USER WHERE NAME ="' . $user . '"';
			$zapros=$pdo->query($query);
			if (!$zapros){print_r($pdo->errorinfo());}
			if (empty($zapros->fetch(PDO::FETCH_ASSOC))){echo 'Такой пользователь не найден!';}
			else {
				$query = 'SELECT * FROM USER WHERE NAME ="' . $user . '" AND password ="'. $pass . '"';
				$zapros = $pdo->query($query);
				if (!$zapros){ print_r($pdo->errorinfo());}
				if (empty($nameUser = $zapros->fetch(PDO::FETCH_ASSOC))){
					echo 'Вы ввели неверный пароль, повторите еще раз!';
					return False;
				}
				else {
					//echo 'func userRegistered' . $user;
					$_SESSION['auth'] = 'admin' ? $nameUser['name'] : 'user';
					$_SESSION['id'] = $nameUser['nom'];
					//$_SESSION['fio'] = $nameUser['fio'];
					return True;
				}
			}
		}
		else {echo 'Не возможно подключтиться к базе данных!';}
		$_SESSION=[];
	}
	
	static function isAdmin(){
		if(Sayt::isRegistered() && Sayt::getUser() === 'admin')  return true;
		return false;
	}
	
	static function getUser(){
		if(Sayt::isRegistered()) return $_SESSION['auth'];
		return false;
	}
	
	static function getUserId(){
		if(Sayt::isRegistered()) return $_SESSION['id'];
		return false;
	}
	
	static function getReqUser(){
		if (!empty($_REQUEST['user'])){
			return $_REQUEST['user'];
		}
		return False;
	}
	
	static function clearUser(){
		$_SESSION['auth'] = '';
		$_SESSION['id'] = '';
		$_SESSION = [];
		header("Location: /reg");
	}
	
	static function createToGeneral($href = '',$text = ''){
		if(empty($href)) {
			return '';
		}
		$str = '';
		//foreach ($ar as $href=>$text) {
			$str = $str . '<a href="' . $href . '" >' . $text . '</a>';
		//}
		return $str;
	}
	
	static function connectDb(){
		try{ $pdo= new PDO('mysql:host=localhost;dbname=baza;charset=utf8;','root','');}
		catch(EPDOException $er){echo print_r($er);}
		return $pdo;
	}
}
