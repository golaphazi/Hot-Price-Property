function select_type(id){
	$(".lavel_type").attr("style","border-color:#ccc;");
	$("#lavel_type__"+id).attr("style","border-color:#fd9c00;background: #fdc503;color:#fff;");
	$("input[id='account_type__"+id+"']:checked");
	
	validateFirstStep_hpp(id);
	
}


function select_for(id){
	$(".lavel").attr("style","border-color:#ccc;");
	$("#lavel__"+id).attr("style","border-color:#fd9c00;background: #fdc503;color:#fff;");
	$("input[id='account_for__"+id+"']:checked");
	
	validateSecondStep_hpp(id);
	
}


/*new js - 10-02-2018*/
function validateFirstStep_hpp(id) {
	//var id = $("input[name='account_type']:checked").val();
	if(id == 2){
		$('#step2_user_skip').css({'display':'none'});
		$('#skip_massage').html('You should skip this step, Please click Next..!');
		validateSecondStep_hpp(3);
	}else{
		$('#step2_user_skip').css({'display':'block'});
		$('#skip_massage').html('Plese Select User Role');
		var id2 = $("input[name='account_for']:checked").val();
		validateSecondStep_hpp(id2);
	}
	
   // alert(id);
}

function validateSecondStep_hpp(id) {
	//var id = $("input[name='account_for']:checked").val();
    if(id == 4){
		$("#name_for_company").html('<b>Agent Name</b>');
		$("#gender_show").css({"display":"none"});
		$("#agent_license_no, #agent_abn_number").css({"display":"block"});
	}else{
		$("#name_for_company").html('<b>Full Name</b>');
		$("#gender_show").css({"display":"block"});
		$("#agent_license_no, #agent_abn_number").css({"display":"none"});
	}
	
   
}

function home_page_search(data){
	//alert(data);
	$("#home_search_form").attr('action', data);
}
/*new js - 10-02-2018*/




$(function(){
	var leb = $("input[name='account_type']:checked").val();
	select_type(leb);
	var for_user = $("input[name='account_for']:checked").val();
	select_for(for_user);
	
})

function removeChar(item)
	{ 
		//alert();
		var val = item.value;
		val = val.replace(/[^0-9,.]/g, "");  
		if (val == ' '){val = ''};   
		item.value=val;
	}
function removeDate(item)
	{ 
		//alert();
		var val = item.value;
		val = val.replace(/[^0-9-]/g, "");  
		if (val == ' '){val = ''};   
		item.value=val;
	}
function removeNumber(item)
	{ 
		//alert('hi therer');
		var val = item.value;
		val = val.replace(/[^A-Za-z.: ]/g, "");
		if (val == ' '){val = ''};   
		item.value=val;
		//alert();
	}

function setChar_int(item)
	{ 
		var val = item.value;
		val = val.replace(/[^A-Za-z0-9 ]/g, "");
		if (val == ' '){val = ''};   
		item.value=val;
		//alert();
	}

function removeSpcial(item)
	{ 
		var val = item.value;
		val = val.replace(/[^A-Za-z0-9@._-]/g, "");
		if (val == ' '){val = ''};   
		item.value=val;
		//alert();
	}
function removeSpace(item)
	{ 
		var val = item.value;
		val = val.replace(/[^A-Za-z0-9@_.-=>%^*()<!&#$]/g, "");
		if (val == ' '){val = ''};   
		item.value=val;
		//alert();
	}
	
function number_format(item){
	var valD = item.value;
	valD = valD.replace(/\,/g,"");  
	var id = item.id;
	var vlaue = valD.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
	$("#"+id).val(vlaue);
}

function select_video(tye){
	//alert(tye);
	if(tye == 4){
		$("#property_video").attr({type: 'file', class: 'form-control property_video_file', onchange: 'video_upload(this)'});
	}else{
		$("#property_video").attr({type: 'text', class: 'form-control'}).removeAttr('onchange');
	}
}
