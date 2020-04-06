<?php
class Korzina {
	
	
	
	
	
	
	
	
}
//session_start();
//echo $_SERVER['DOCUMENT_ROOT'];
print_r($_COOKIE);
if(!isset($_COOKIE['id'])){ echo 'Ваша корзина пока пуста';exit;}else{


$ar_id=explode('&',$_COOKIE['id']);
$str_korzina='';
$ar_korzina=[];
foreach($ar_id as $id){
 if($id){$ar_korzina[$id]['id']=$id;
   $str_razmeri=$_SERVER['DOCUMENT_ROOT'].'/_param/razmeri/razmeri'.$id.'.php';
   $ar_korzina[$id]['razmeri']='<div class="razmeri_div2">Размер не указан</div>';
  	 if(file_exists($str_razmeri)){$ar_korzina[$id]['razmeri']='<div class="razmeri_div2">'.file_get_contents($str_razmeri).'</div>';}

   $str_pic_poisk=$_SERVER['DOCUMENT_ROOT'].'/pic_div/'.$id.'.jpeg';
   $str_pic='pic_div/'.$id.'.jpeg';
   $ar_korzina[$id]['pic']='';
   $ar_korzina[$id]['pic']="<img src='$str_pic' class='pic_img' alt='Картинка не найдена'>";;
	   if(file_exists($str_pic_poisk)){$ar_korzina[$id]['pic']="<img src='$str_pic' class='pic_img' alt='Картинка товара'>";}
   $ar_korzina[$id]['pic']="<div class='pic_div' >".$ar_korzina[$id]['pic']."</div>";
	
   $cena=0;
   $str_cena=$_SERVER['DOCUMENT_ROOT'].'/_param/cena/cena'.$id.'.php';
   $ar_korzina[$id]['cena']="<div name='".$id."_cena_$cena' class='cena_div_no' >Цена не указана! Уточните у продавца!</div>";
  	 if(file_exists($str_cena)){$cena=file_get_contents($str_cena);
		 $ar_korzina[$id]['cena']="<div  name='".$id."_cena_".$cena."' class='cena_div_yes' >$cena </div>";}
	
	
   $str_kol_vo="<a href='##' name='kol_vo_$id' class='minus' onclick='minus(this.name);' >-</a>";
   $str_kol_vo=$str_kol_vo."<input type='text' name='kol_vo_$id"."_input' class='kol_vo' value='1' >";
   $str_kol_vo=$str_kol_vo."<a href='##' name='kol_vo_$id' class='plus' onclick='plus(this.name);' >+</a>";
   $ar_korzina[$id]['kol_vo']='<div class="kol_vo_div">'.$str_kol_vo.'</div>';
  }



}

/////////////////////////
$ar_id=explode('&',$_COOKIE['id']);
$str_korzina='';
$ar_korzina2=[];
$cena_itog=0;
$str_id='';
foreach($ar_id as $id){
	if($id>0){$str_id=$str_id.$id.',';}
 if($id){$ar_korzina2[$id]['id']=$id;
   $str_razmeri=$_SERVER['DOCUMENT_ROOT'].'/_param/razmeri/razmeri'.$id.'.php';
   $ar_korzina2[$id]['razmeri']='Размер не указан';
  	 if(file_exists($str_razmeri)){$ar_korzina2[$id]['razmeri']=file_get_contents($str_razmeri);}

   $str_pic_poisk=$_SERVER['DOCUMENT_ROOT'].'/pic_div/'.$id.'.jpeg';
   $str_pic='pic_div/'.$id.'.jpeg';
   $ar_korzina2[$id]['pic']='';
   $ar_korzina2[$id]['pic']="<img src='$str_pic' class='pic_img' alt='Картинка не найдена'>";;
	   if(file_exists($str_pic_poisk)){$ar_korzina2[$id]['pic']="<img src='$str_pic' class='pic_img' alt='Картинка товара'>";}
	
   $cena=0;
   $str_cena=$_SERVER['DOCUMENT_ROOT'].'/_param/cena/cena'.$id.'.php';
   $ar_korzina2[$id]['cena']='Цена не указана! Уточните у продавца!';
  	 if(file_exists($str_cena)){$cena=file_get_contents($str_cena);
		 $ar_korzina2[$id]['cena']="<span id='cena_tovara_$id' class='cena_tovara_yes' >".$cena."</span>";}
	
	 $str_kol_vo="<a href='##' name='kol_vo_$id' class='minus' onclick='minus(this.name);' >-</a>";
   $str_kol_vo=$str_kol_vo."<input type='text'  id='kol_vo_$id"."_input' class='kol_vo' value='1' >";//readonly
   $str_kol_vo=$str_kol_vo."<a href='##' name='kol_vo_$id' class='plus' onclick='plus(this.name);' >+</a>";
   $ar_korzina2[$id]['kol_vo']=$str_kol_vo;
   
//   $ar_korzina2[$id]['button_del']="<input type='button' class='button_del' onclick='korzina_del($id,$cena);' value='Убрать из корзины' >";
   $ar_korzina2[$id]['button_del']="<button type='button' class='btn btn-primary' onclick='korzina_del($id,$cena);'>";
   $ar_korzina2[$id]['button_del'] = $ar_korzina2[$id]['button_del'] . 'Убрать из корзины' . '</button>';
   
   //Определение общей цены
   if($cena>0){$cena_itog=$cena_itog+$cena;}
  }
}
   $ar_korzina2['cena_itog']['cena_itog']="<span id='cena_itog' class='cena_itog' >".'Идет расчёт стоимости товаров'."</span>";
//print_r($ar_korzina2);
}

	//Выборка количества остатков товаров
	$str_id=substr($str_id,0,-1);
$put_connect=$_SERVER['DOCUMENT_ROOT'].'/php2/connect.php';
require_once($put_connect);
$pdo=connect_dailywear();
$query="select id,param,param_value,razmer,ostatok from tovar where (param='quantity' or razmer>0) and tovar.id in($str_id)";
//echo $query;
$zapros=$pdo->query($query);


if (!$zapros){echo print_r($pdo->errorinfo());exit();}
while($tovar=$zapros->fetch(PDO::FETCH_ASSOC)){
//	$class='ostatok_no';

if($tovar['param']==='options'){
	$class='ostatok_options';$ostatok2=0;
	$ar_korzina2[$tovar['id']]['ostatok']=$class; $ar_korzina2[$tovar['id']]['ostatok2']=$ostatok2;
	}
else{
	$class='ostatok_quantity';$ostatok2=$tovar['param_value'];
	$ar_korzina2[$tovar['id']]['ostatok']=$class;$ar_korzina2[$tovar['id']]['ostatok2']=$ostatok2;
	}

//$ar_korzina2[$tovar['id']]['ostatok']='';

//if(!$ar_korzina2[$tovar['id']]['ostatok']){$ar_korzina2[$tovar['id']]['ostatok']=$class; $ar_korzina2[$tovar['id']]['ostatok2']=$ostatok2;}
//if($ar_korzina2[$tovar['id']]['ostatok']==='ostatok_quantity'){$ar_korzina2[$tovar['id']]['ostatok']=$class;$ar_korzina2[$tovar['id']]['ostatok2']=$ostatok2;}
//if($ar_korzina2[$tovar['id']]['ostatok']==='ostatok_no'){$ar_korzina2[$tovar['id']]['ostatok']=$class;$ar_korzina2[$tovar['id']]['ostatok2']=$ostatok2;}

}
//print_r($ar_korzina2);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Необходимые Мета-теги всегда на первом месте -->  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

	<link rel="stylesheet" href="bootstrap/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">

      <script src="js/script.js"></script>
      <script src="js/script_korzina.js"></script>
  	  <script src="js/jquery-3.2.1.js"></script>
		<link href="css/menu_main.css" rel="stylesheet"></link>
  	    <link rel="stylesheet" href="css/filtr.css" ></link>
		<link rel="stylesheet" href="css/next_page.css">
		<link rel="stylesheet" href="css/floor.css">
  	    <link rel="stylesheet" href="css/system.css">
	  	<link rel="stylesheet" href="css/korzina.css">
		<link rel="stylesheet" href="css/fonts.css">
		<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
	
</head>

<body background='img/background.jpg'>
<div class="container" >
<?php require_once('shapka/shapka.php'); ?>

<br></br>
</div>

<?php
//echo '<div class="banner" ></div>';

//foreach($ar_korzina as $ar=>$id){echo '<div class="v11" >'; 		$ind=$id['id'];
//echo $id['pic'];echo $id['razmeri'];echo $id['cena'];echo $id['kol_vo'];
//echo "<div class='button_div'><input type='button' name='button_$ind' class='button' value='Оплатить' ></div>";
//echo'</div>';echo '<br>';}

echo '<div class="container" >';
echo '<table class="table" >';

foreach($ar_korzina2 as $ar=>$id){

	if($ar=='cena_itog' ){continue;}
	if($ar==0){continue;}

	$ind=$id['id'];
		//echo $id['ostatok'];
		if(!$id['ostatok']){$id['ostatok']='ostatok_no';$id['ostatok2']='no';}
		//if(!$id['ostatok2']){$id['ostatok2']='no';}
		
echo "<tr id='korzina_$ind' class='tovar_na_oplatu'>"; 

echo '<td class="stolbec" >'.$id['pic'].'</td>';
echo '<td class="stolbec" >'.$id['razmeri'].'</td>';
echo '<td class="stolbec" ><span id="ostatok_'.$id['id'].'" class="'.$id['ostatok'].'" >'. $id['ostatok2'] .'</span></td>';

echo '<td class="stolbec" >'.$id['cena'].'</td>';
echo '<td class="stolbec" >'.$id['kol_vo'].'</td>';

echo '<td class="stolbec" >'.$id['button_del'].'</td>';

echo '</tr>';
}
//echo "<tr id='stroka_itog' ><td class='stolbec'></td><td class='stolbec' ></td><td class='stolbec' ></td><td class='stolbec' ></td><td class='stolbec' >Всего к оплате:</td><td class='stolbec' >".$id['cena_itog']."</td></tr>";
echo "<tr id='stroka_itog' ><td>Итого к оплате: " . $id['cena_itog'] . "</td></tr>";
echo '</table>';

echo '</div>';

 ?>


<button type='button' class='btn btn-primary' onclick="oformlenie_zakaza();">
  Перейти к оформлению заказа
</button>

<!-- Модальное окно -->  
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<h4 class="modal-title" id="myModalLabel">Modal title</h4>
		</div>
	<div class="modal-body">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Ваше ФИО" aria-describedby="basic-addon1">
		</div>
		<br>
		<div class="input-group">
			<input type="text" class="form-control" placeholder="E-MAIL" aria-describedby="basic-addon1">
		</div>
		<br>
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Почтовый индекс" aria-describedby="basic-addon1">
		</div>
		<br>
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Ваш адрес" aria-describedby="basic-addon1">
		</div>
		<br>
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Ваш контактный телефон" aria-describedby="basic-addon1">
		</div>
		
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        <button type="button" class="btn btn-primary" >Перейти к оплате товара</button>
      </div>
    </div>
  </div>
<!-- Модальное окно --> 



  
    <script src="bootstrap/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="bootstrap/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="bootstrap/bootstrap.min.js" integrity="VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>

</body>
</html>



