window.onload = function(){
	//alert('START');
	el = document.getElementsByName('selecttip')[0];
	el.onchange = function(){
		if(!el.selectedIndex == 0){
			//alert(this.name);
			//alert(el.selectedIndex);
			//alert(el.form.action);
			//browParam(el.form);
			//el.form.submit();
			//browParam(document.getElementsByName('formusersOborud')[0]);
			//document.getElementsByName('formusersOborud')[0].submit();
            ajaxGetParam(el.selectedIndex);
		}
	}
	//if(document.getElementsByName('table_addparam')[0]){
    //    add = document.getElementById('collapseExample1').className = 'collapse show';
    //}
	
	//alert(str);

	//alert('END');
	$('#myModal').on('show.bs.modal', function (e) {
		//$('.modal-ajax-response').html('');
	});
	
	//$('#myModal').on('shown.bs.modal', function (e) {
	//	alert('Modal is successfully shown!');
	//});
		

var t = 10;
	test(t).t1();
	test(t).t2();




};
////////
function test(t){
	//console.log(t);
	let t2 = 400;
	return {t1 : function (){console.log(t)},
		t2 : function () {console.log(t2)} };
};


///
function ajaxGetParam(tip){
	strparam = 'tip=' + tip;
	text = $.ajax({
		url: '/users/usersAjaxGetParam',
		async: false,
		type: 'GET',
		data: strparam ,
		success: function(data){
            $("[name='getparam']").html(data);
		}
	});
}
///
function ajaxEditParam(){
	//kod_oborud = $("[name='editparamoborudkodoborud']").val();
	//id_menu = $("[name='editparamoborudidmenu']").val();
	//$('.modal-ajax-response').html('');
	param = $("[name^='editparamoborud']");
	strparam = getstrparam(param);
	
	text = $.ajax({
		url: '/users/usersAjaxEditOborud',
		async: false,
		type: 'GET',
		data: strparam ,
		success: function(data){
		$('.modal-ajax-response').html(data);
		}
	});
	
	if (text == 'Данные сохранены!'){
		$("#myModal").modal('hide');
	}
	
}

function getstrparam(el) {
	str = '';
	if(el.length && el.length > 0) {
		for(i =0; i < el.length; i = i + 1){
			//alert(i);
			//str = str + '&' + '=' + el[i].value;
			str = str + '&' + el[i].name + '=' + el[i].value;
		}
	}
	if (str.length > 0) {
		str = str.substr(1, str.length);
	}
	return str;
}

function checkdiv(el, kod = 0){
    el2 = $('#selectdivparam' + kod);
    if(el.checked){
        el2.val('');
        el2.attr('class','block');
    } else {
        el2.val('');
        el2.attr('class','hidden');
    }
}

function checknull(el, kod){
    el2 = $('#selectdivparam' + kod);
    el3 = $('#selectparam' + kod);
    el4 = $('#checkdivparam' + kod);
    if(el.checked){
        if(el2){
            el2.prop('disabled', true);
        }
        if(el3){
            el3.prop('disabled', true);
        }
        if(el4){
            el4.prop('disabled', true);
        }
        
    }else{
        if(el2){
            el2.prop('disabled', false);
        }
        if(el3){
            el3.prop('disabled', false);
        }
        if(el4){
            el4.prop('disabled', false);
        }
    }
}

function getTextTd(el){

	//$('#exampleModal').dblclick('shown.bs.modal', function () {
	//$('#myInput').trigger('focus');
	//});
	//alert(el.getAttribute('kod_oborud'));
	$('.modal-ajax-response').html('');
	text = $.ajax({
		url: '/users/usersAjaxOborud',
		async: false,
		type: 'GET',
		data: 'kod_oborud=' + el.getAttribute('kod_oborud') ,
		success: function(data){
		$('.modal-body').html(data);
		}
	});
	//error: function(){  alert('error DATA!!!');  },
	
	
	$("#myModal").modal('show');

	
	//str = '';
	//if (!el.innerHTML) {alert(str); return;}
	//el = el.innerHTML;
	//alert(el.getAttribute('kod_oborud'));
	//el = el.getAttribute('name');

	
	
	
	
	
	//for(e in el ){	str = str + el[e];	}	alert( str);
}

function browParam(el){
	str = '';
	for(e in el ){
	str = str + e + '=' + el[e] + '\n';
	}
	alert( str);
}