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
			document.getElementsByName('formusersOborud')[0].submit();
		}
	}
	
	

	//alert(str);

	//alert('END');
	$('#myModal').on('show.bs.modal', function (e) {
		browParam(e);
	});
	
	//$('#myModal').on('shown.bs.modal', function (e) {
	//	alert('Modal is successfully shown!');
	//});
		

		
};


function getTextTd(el){

	//$('#exampleModal').dblclick('shown.bs.modal', function () {
	//$('#myInput').trigger('focus');
	//});
	
	
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

	
	str = '';
	//if (!el.innerHTML) {alert(str); return;}
	//el = el.innerHTML;
	alert(el.getAttribute('kod_oborud'));
	el = el.getAttribute('name');

	
	
	
	
	
	for(e in el ){
	str = str + el[e];
	}
	alert( str);
}

function browParam(el){
	str = '';
	for(e in el ){
	str = str + e + '=' + el[e] + '\n';
	}
	alert( str);
}