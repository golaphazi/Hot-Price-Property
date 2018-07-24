/**sign up form validation start**/

function check_is_nan(value) {
        var val = parseFloat(value.replace(/,/g, ''));
        if (isNaN(val)) {
            return 0;
        } else {
            if (val == '') {
                return 0;
            } else {
                return parseFloat(val);
            }
        }
    }


jQuery.validator.addMethod('greaterThan', function (value, element, param) {
    var check = check_is_nan(jQuery(param).val());
	var value = check_is_nan(value);
	if(value === ''){
		return true;
	}else {
		if (value > check) {
			return true;
		} else {
			return false;
		}
	}
}, 'Must be greater than start');

jQuery.validator.addMethod('lessThan', function (value, element, param) {
    var check = check_is_nan(jQuery(param).val());
	var value = check_is_nan(value);
	if(value === ''){
		return true;
	}else {
		if (value < check) {
			return true;
		} else {
			return false;
		}
	}
}, 'Must be greater than start');

jQuery(document).ready(function () {

    /** validation for user sign up form**/
    $("#user_signup_form").validate({
        rules: {
            full_name: {
                required: true,
                minlength: 4
            },
            mobile_no: {
                required: true,
                minlength: 9
            },
            email_address: {
                required: true,
                email: true
            },
            rel_password: {
                required: true,
                minlength: 8
            },
            con_password: {
                required: true,
                minlength: 8,
                equalTo: "#rel_password"
            }


        },
        messages: {
            full_name: {
                required: "Please enter name",
                minlength: "Full name should be min 4 chars"
            },
            mobile_no: {
                required: "Please enter your mobile no",
                minlength: "Mobile no should be min 9 chars"
            },
            email_address: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            },
            rel_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
            con_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as above"
            }
        }
    });


    /** validation for user login form**/
    $("#user_login_form").validate({
        rules: {
            login_email: {
                required: true,
                email: true
            },
            login_password: {
                required: true,
                minlength: 8
            },
        },
        messages: {
            login_email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            },
            login_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            }
        }

    });
    
    /** validation for ForGot Password form**/
    $("#forgot_password_form").validate({
        rules: {
            login_email: {
                required: true,
                email: true
            },
        },
        messages: {
            login_email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address"
            },
        }

    });
    
    


    /** validation for add new property form**/
    $("#property_form").validate({
        rules: {
           state_name: {
                required: true
            },
			country_id: {
                required: true
				
            },
			property_wonership: {
                required: true
            },
            
            propertyprice: {
                required: true,
				number: true,
                minlength: 2
            },
			discrition: {
                required: true
            },
            'property_image[]': {
                required: true
            },
			
			
            offer_price:{
		required: true,
                lessThan: "#propertyprice"
            },
            hot_price_start_date: {
                required: true
            },
            hot_price_end_date: {
                required: true               
            },
			
			
            offer_start_price: {
                required: true,
                lessThan: "#propertyprice"
            },
            offer_win_price: {
                required: true,
                greaterThan: "#offerStartPrice"
            },
            offer_start_date: {
                required: true
            },
            offer_end_date: {
                required: true,
            },
            auctionPaumentTerms: {
                required: true,
            },
			
			
            terms: {
                required: true
            }
        },
        messages: {
			state_name: {
                required: "Please Enter state name",
				
            },
			country_id: {
                required: "Please select your country",
				
            },
			property_wonership: {
                required: "Please Select Property Wonership",
            },
            propertyprice: {
                required: "Please Enter property price",
				number: "Invalid property price",
                minlength: "Your price very lowest"
            },
			discrition: {
                required: "Enter your property description "
            },
            'property_image[]': {
                required: "Please select Property Image",
            },
            offer_price: {
                required: "Please Provide Property Hot Price",
                lessThan: "Property Hot Price must be less than Asking Price"
            },
			hot_price_start_date: {
                required: "Please Select Offer Start Date"
            },
            hot_price_end_date: {
                required: "Please enter dateline",
               
            },
			
		offer_start_price: {
                required: "Please Provide Offer Start Price",
                lessThan: "Property Offer Start Price must be less than Asking Price"
            },
            offer_win_price: {
                required: "Please Provide Offer Win/Close Price",
                greaterThan: "Offer Win/Close Price must be greater than offer start Price",
            },
            offer_start_date: {
                required: "Please Select Offer Start Date"
            },
            offer_end_date: {
                required: "Please enter dateline",
               
            },
            auctionPaumentTerms: {
                required: "You Must Check Terms & Conditions",              
            },  

			
            terms: {
                required: "You must check terms & conditions "
            }
        }

    });

 /**************************************
    * valedation For User Profile Info
    *
 *********************************/
    $("#user_account_info").validate({
        rules: {
            new_password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                minlength: 8,
                equalTo: "#new_password"
            }


        },
        messages: {
            new_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as above"
            }
        }
    });

	/**************************************
     * valedation For Property Preview - Contact to seller
     *
     *********************************/
    /** valedation For Property Preview - Contact to seller**/
	
	$("#contact_to_form").validate({
		rules: {
            name_contact: {
                required: true
            },
            email_address: {
                required: true,
                email: true
            },
            phone_no: {
                required: true
            },
            about_me: {
                required: true
            },
            captcha_code: {
                required: true, 
            }
        },
        messages: {
            name_contact: {
                required: "Please enter your name"
            },
            email_address: {
                required: "Please Enter your email address",
                email: "Invalid email address" 
            },
            phone_no: {
                required: "Please Enter your email address"
            },
            about_me: {
                required: "Please Select Once from about me"
            },
            captcha_code: {
                required: "Please enter captcha code", 
            }
        }
	});
   

});

 /**************************************
    * valedation For Contact From
    *
 *********************************/
    $("#contact_from").validate({
        rules: {
            f_name: {
                required: true,
            },
            l_name: {
                required: true,
            },
            contact_email: {
                required: true,
            },
            subject: {
                required: true,
            },
            contact_message: {
                required: true,
            }


        },
        messages: {
            f_name: {
                required: "Please enter your first name",
            },
            l_name: {
                required: "Please enter your last name",
            },
            contact_email: {
                required: "Please valid email address",
            },
            subject: {
                required: "Please enter subject",
            },
            contact_message: {
                required: "Please write your message",
            }
        }
    });




/***Bid Property**/

function check_max_price(vals,vall){
	//alert(vals);
	var vals = check_is_nan(vals);
	var vall = check_is_nan(vall);
	if(vals == 0){
		$("#bid_price").css({'border': '1px solid red'})
		return false;
	}
	if(vals <= vall){
		alert('Must grater than last bid price');
		return false;
	}
	return true;
}

/*Function for video upload*/
function video_upload(input){
	var id = input.id;

    var fileTypeArray = input.files[0].name;
    var fileType = fileTypeArray.split('.');
    
     var typeSelect = fileType[fileType.length - 1];
	 //alert(typeSelect);
	 if ($.inArray(typeSelect, ['mp4', 'mkv', 'MP4', 'MKV', 'FLV', 'flv', 'MOV', 'mov', 'WMV', 'wmv']) != '-1') {
		  /**image size check option start**/
        var maxsize = 5120;
		var imgsize = input.files[0].size;
		if(maxsize < imgsize){
			$('#' + id).val('');
			alert('Video should be max size 4MB');
			return false;
		}else{
			
		}
       
	 }else {
        $("#" + id).val('');
        alert('Invalid video format...');

    }
}

/**Function to show image before upload **/

function readURL(input) {
    var id = input.id;

    var fileTypeArray = input.files[0].name;
    var fileType = fileTypeArray.split('.');
    //alert(fileType[fileType.length - 1]);

    var typeSelect = fileType[fileType.length - 1];


    if ($.inArray(typeSelect, ['jpeg', 'jpg', 'JEPG', 'JPG', 'png', 'PNG', 'GIF', 'gif']) != '-1') {
        /**image size check option start**/
        var _URL = window.URL || window.webkitURL;
        var file = input.files[0];
        var img = new Image();

        var imgwidth = 0;
        var imgheight = 0;
        var maxwidth = 650;
        var maxheight = 400;

        img.src = _URL.createObjectURL(file);
        img.onload = function () {
            imgwidth = this.width;
            imgheight = this.height;

            if (maxwidth > imgwidth || maxheight > imgheight) {
                $('#show_' + id).removeClass('show_select_pic');
                $('#' + id).val('');
                alert('Image should be minimun (650 X 400) px');
                return false;
            } else { /**image size check option end**/
                /**image preview option start**/

                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    $('#show_' + id).addClass('show_select_pic');
                    reader.onload = function (e) {
                        $('#show_' + id).attr('src', e.target.result).fadeIn('slow');
                    }
                    reader.readAsDataURL(input.files[0]);
                } else {
                    $("#" + id).val('');
                    alert('Sorry system error...');

                }
                /**image preview option end**/
            }

        }

    } else {
        $("#" + id).val('');
        $('#show_' + id).removeClass('show_select_pic');
        alert('Invalid image format...');

    }

}



/***Add filed option***/
function addMilestone(id) {

    var valArray = $("input[name='headding[]']");
    var total = valArray.size();

    var lastId = valArray[total - 1].id;
    var id_last = lastId.split('__');
    var row = id_last[1];
    row++;
    //alert(total);
    if (total < 5) {
        var check = $("#headding__" + id).val();
        var price = $("#value__" + id).val();
        if (check.length > 3) {
            if (price.length > 0) {
                var filed = '';
                filed += '<div class="form-group" id="table__' + row + '"> <div class="form-row"> <div class="col-md-4">';
                filed += '<label for="exampleInputName"><strong>Field Headding Name - ' + row + ' : </strong></label>';
                filed += '<input class="form-control" id="headding__' + row + '" name="headding[]" type="text" value=""  placeholder="Enter Aditional Field - ' + row + ' name here...">';
                filed += '</div> <div class="col-md-6" id="value_remove__' + row + '"> <label for="exampleInputName"> <strong>Field Value - ' + row + ' : </strong></label><input class="form-control" id="value__' + row + '" name="value[]" type="text" aria-describedby="nameHelp" value="" placeholder="Enter Additioanl Field- ' + row + ' value here..."></div>';
                filed += '<div class="col-md-1" id="button_remove__' + row + '"> <span class="fa fa-plus class_add" onclick="addMilestone(' + row + ')"></span> </div>';
                filed += '</div> </div>';
                var remove = '<span class="fa fa-close class_add class_remove" onclick="removeMilestone(' + id + ')"></span>';
                $("#button_remove__" + id).html(remove);
                $("#main_div").append(filed);
                $("#headding__" + row).focus();
            } else {
                $("#value__" + id).focus();
            }
        } else {
            $("#headding__" + id).focus();
        }
    } else {
        alert("Maximum 5 additional information allowed");
    }
}


function removeMilestone(id) {
    $("#table__" + id).html('');
}

/***Add filed option end***/




/***Multiple upload for property***/
//var i = 1;
function add_more_image() {
    var valArray = $("input[name='property_image[]']");
    var total = valArray.size();

    var lastId = valArray[total - 1].id;
    var id_last = lastId.split('__');
    var i = id_last[1];
    i++;
    ///alert(i);
    if (total > 4) {

        $("#add_more_div").html('');
        alert("Maximum 5 images is allowed");
    } else {
        var n = i - 1;
        var images_name = $("#property_images__" + n).val();
        if (images_name.length > 2) {
            $("#show_image__" + n).removeClass("alert_image");
            var html = '';
            html += '<p><span class="glyphicon glyphicon-file shadow_image" id="show_image__' + i + '"></span><img src="" class="picture-src_property" id="show_property_images__' + i + '" alt="" title=""/><span class="glyphicon glyphicon-remove remove_icon" onclick="remove_image(' + i + ')"></span><input class="form-control select_image" name="property_image[]" type="file" id="property_images__' + i + '" onchange="readURL(this)"></p>';
            $("#append_image").append(html);
            //i++;
        } else {
            $("#show_image__" + n).addClass("alert_image");
        }
    }
}

/**remove image**/
function remove_image(imag) {
    $('#show_property_images__' + imag).removeClass('show_select_pic');
    $('#property_images__' + imag).val('');
}


/***add near by start**/
//var m = 1;
function add_more_location() {
    var valArray = $("input[name='distance[]']");
    var total = valArray.size();

    var lastId = valArray[total - 1].id;
    var id_last = lastId.split('_');

    //alert(valArray[total-1].id);

    var selecc = $("#location_0").html();
    var m = id_last[1];
    m++;
    if (total > 4) {
        //$("#add_location_div").html('');
        alert("Maximum 5 organizations is allowed");
    } else {
        var l = m - 1;
        if ($("#org_name_" + l).val().length > 2) {
            if ($("#distance_" + l).val().length > 0) {
                //if ($("#location_" + l).val().length > 0) {

                    $("#org_name_" + l).after('<input class="form-control mtX_15" value="" placeholder="Enter School/College/Shoping Center" id="org_name_' + m + '" name="org_name[]" type="text">');
                    $("#distance_" + l).after('<input class="form-control mtX_15" value="" placeholder="1km" onkeyup="removeChar(this);" id ="distance_' + m + '" name="distance[]" type="text">');

                    var selec = '';
                    selec += '<span style="position:relative;"><select class="form-control mtX_15" name="location[]" id="location_' + m + '">';
                    selec += selecc;
                    selec += '</select>';
                    $("#location_" + l).after(selec + '<span class="glyphicon glyphicon-remove remove_location" id="remove_button_' + m + '" onclick="remove_location(' + m + ')"></span></span>');
                    //m++;
                //} else {
                   // $("#location_" + l).focus();
                //}
            } else {
                $("#distance_" + l).focus();
            }
        } else {
            $("#org_name_" + l).focus();
        }

    }
}


/**remove loaction**/

function remove_location(loc) {
    $('#org_name_' + loc + ', #distance_' + loc + ', #location_' + loc).val('').attr({name: 'undifind', id: 'undifind'}).addClass('dis_none');
    $('#remove_button_' + loc).addClass('dis_none');

}




//Function to show image before upload
function readURLProfile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview1').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}



function checkDelete(id,getSearch) {
    $("#actioMessage").removeAttr('class');
    //alert(getSearch);
    if ( confirm( 'Are You Sure To Delete This....?') ) {
        $.ajax({
            type: "POST",
            url: site_url+"profileController/user/ProfileControll/delete_property?id="+id+"&getSearch="+getSearch,
            success: function (msg){
                if(msg == 1){
                    var sms = 'Property Deleted Successfully...!';
                    $("#property_tr__"+id).hide();
                    $("#actioMessage").attr('class', 'alert alert-success').html(sms);
                }else{
                    alert('Property Dose Not Deleted..!');
                }
            }
        });
    } else {
        return false;
    }
}




function checkDeleteAdmin(id,getSearch) {
    $("#actioMessage").removeAttr('class');
    //alert(getSearch);
    if ( confirm( 'Are You Sure To Delete This....?') ) {
        $.ajax({
            type: "POST",
            url: site_url+"hpp/admin/delete_property?id="+id+"&getSearch="+getSearch,
            success: function (msg){
                if(msg == 1){
                    var sms = 'Property Deleted Successfully...!';
                    $("#property_tr__"+id).hide();
                    $("#massage").attr('class', 'alert alert-success').html(sms);
                }else{
                    alert('Property Dose Not Deleted..!');
                }
            }
        });
    } else {
        return false;
    }
}

function editFiledDataAdminAuction(idfiled,value){
	if(idfiled.length > 0 && value.length > 0){
		editFiledDataAdmin(idfiled,'p_property_offers','OFFER_PRICE', value);
	}
}


function editFiledDataAdmin(idfiled,table,filed,value){
	if(idfiled.length > 0 && table.length > 0 && filed.length > 0){
		$("#"+idfiled).removeAttr('ondblclick');
		var htmlInner = '';
		//var func = 'editSubmitDataAdmin('+idfiled+', '+table+', '+filed+', '+value+')';
		htmlInner += '<input type="text" id="'+idfiled+'___'+table+'___'+filed+'" value="'+value+'" class="datepickerStartDate" onblur="editSubmitDataAdmin(this)">';
		$("#"+idfiled).html(htmlInner);
	}
}


function editSubmitDataAdmin(idfiled){
	var id = idfiled.id;
	var val = idfiled.value;
	var idSp = id.split('___');
	var idTble = idSp[1];
	var filedTble = idSp[2];
	
	$.ajax({
		type: "POST",
		url: site_url+"hpp/admin/edit_data_by_admin?idcheck="+idTble+"&filefCheck="+filedTble+"&table="+idSp[3]+"&filed="+idSp[4]+"&value="+val,
		success: function (msg){
			//alert(msg);
			if(msg == 1){
				$("#"+idSp[0]+"___"+idSp[1]+"___"+idSp[2]).html(''+val);				
				$("#"+idSp[0]+"___"+idSp[1]+"___"+idSp[2]).attr('ondblclick', 'editFiledDataAdminAuction(this.id,"'+val+'")');				
			}else{
				alert('Do not update..!');
			}
		}
	});
	
}
/*
 * remove HotPrice Property 
 * @param {type} pid
 * @returns {Boolean}
 */
function removeHotPrice(pid) {
    $("#actioMessage").removeAttr('class');
    if( confirm( 'Would you like to Remove your property to the Hot Price section?' )){
        $.ajax({
            type: "POST",
            url: site_url+"profileController/user/ProfileControll/remove_hot_price_property?pid="+pid,
            
            success: function(msg){
                if( msg == 1 ){
                    var sms = "Remove Property Succesfully into hot priice section..!";
                    $("#actioMessage").attr('class', 'alert alert-success').html(sms); 
                }else{
                    alert('Property Dose Not Remove Hot Price Section..!');
                }
            }
        });
    } else{
        return false;
    }
    
}






/*------------------------------------------------
     * validation OF Add Hot Price Property Form
     *
------------------------------------------------*/

/*-- custom code for greater than --*/



/*
 * datepickerr
 */
$(document).ready(function() {
    $('.datepickerStartDate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
    });
    
    $('.datepickerEndDate').datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
    });
});



/*-----------------------------------
 * View auction user details 
 -----------------------------------*/
function selectAuctionDetailsUserModal(pID, offerID, typ){
   //alert(offerID);
    $.ajax({
        url: site_url+"profileController/user/ProfileControll/selectAuctionUserModalById?pid="+pID+"&offer="+offerID+"&type="+typ,
        method:'POST',
        data:{PROPERTY_ID:pID},
        success:function(res){
            $('#modalBody').html(res);
        }
        
    });
}

function win_auction_bidder(user, offer, pid, price){
	if(confirm('Are you sure to select your bidder ')){
		$("#massage").html('');
		$.ajax({
			url: site_url+"profileController/user/ProfileControll/selectAuctionUserById?user="+user+"&offer="+offer+"&pid="+pid+"&price="+price,
			method:'POST',
			data:{PROPERTY_ID:pid},
			success:function(res){
				//$('#modalBody').html(res);
				if(res == 0){
					$("#massage").html('<div class="alert alert-warning">System error...</div>');
				}else if(res == 2){
					$("#massage").html('<div class="alert alert-info">Sorry!!! invalid selected bidder...</div>');
				}else if(res == 3){
					$("#massage").html('<div class="alert alert-danger">Sorry!!! Already select bidder...</div>');
				}else{
					$("#massage").html('<div class="alert alert-success">Successfully selected bidder...</div>');
				} 
			}
			
		});
	}
	
	
} 

/*-----------------------------------
 * Select Property By PROPERTY_ID
 * For Show Hot Price Modal
 -----------------------------------*/
function selectHotPriceModal(pID,admin){
//    alert(pID);
    $.ajax({
        url: site_url+"profileController/user/ProfileControll/selectHotPriceModalById?pid="+pID+"&type="+admin,
        method:'POST',
        data:{PROPERTY_ID:pID},
        success:function(res){
            $('#modalBody').html(res);
        }
        
    });
}

function selectReAuctionModal(pID,type){
    //alert(type);
    $.ajax({
        url: site_url+"profileController/user/ProfileControll/selectReAuctionUserModalById?pid="+pID+"&type="+type,
        method:'POST',
        data:{PROPERTY_ID:pID},
        success:function(res){
            $('#reAuctionModalBody').html(res);
        }
        
    });
}


/*-----------------------------------
 * Select Property By PROPERTY_ID
 * For Show Auction/Bidding Modal
 -----------------------------------*/
function selectAuctionModal(pID,admin){
//    alert(pID);
    $.ajax({
        url: site_url+"profileController/user/ProfileControll/selectAuctionModalById?pid="+pID+"&type="+admin,
        method:'POST',
        data:{PROPERTY_ID:pID},
        success:function(res){
            $('#AuctionModalBody').html(res);
        }
        
    });
}





/*--------------------------------------------------
    Show/Hide Add To Hot Price And Add To Auction
    Develop On : 12-02-2018
---------------------------------------------*/


function chancge_add_other(dta){
//	alert(dta);
	$(".add_auction_hot").removeClass('add_auction_hot_show');
	if(dta != 'normal'){
            $("#display__"+dta).addClass('add_auction_hot_show');
	}else{
            $(".add_auction_hot").removeClass('add_auction_hot_show');
	}
}




/*-----------------------------------
 * Add Solicitiors Details 
 * On 07-03-0218
 -----------------------------------*/
function AddSolicitorsDetailsModal(pID, offerID, type){
   //alert(pID);
    $.ajax({
        url: site_url+"profileController/user/ProfileControll/AddSolicitorsDetailsById?pId="+pID+"&offerId="+offerID+"&type="+type,
        method:'POST',
        data:{PROPERTY_ID:pID},
        success:function(res){
            $('#modalBodySolicitor').html(res);
        }
        
    });
}

function AddSolicitorsDetailsModalView(pID, offerID, type){
   //alert(pID);
    $.ajax({
        url: site_url+"profileController/user/ProfileControll/AddSolicitorsDetailsByIdView?pId="+pID+"&offerId="+offerID+"&type="+type,
        method:'POST',
        data:{PROPERTY_ID:pID},
        success:function(res){
            $('#modalBodySolicitorView').html(res);
        }
        
    });
}

function AddOffrCounterModal(pID, offerID, type){
   //alert(pID);
    $.ajax({
        url: site_url+"profileController/user/ProfileControll/AddCounterDetailsByIdView?pId="+pID+"&offerId="+offerID+"&type="+type,
        method:'POST',
        data:{PROPERTY_ID:pID},
        success:function(res){
           //alert(data);
		   $('#modalBodyCounter').html(res);
        }
        
    });
}

function counterReplaySeller(offerID, pID){
	var value = prompt('Enter offer price');
	if(value.length > 0){
		 $.ajax({
			url: site_url+"profileController/user/ProfileControll/replayOfferCounterSeller?pId="+pID+"&offerId="+offerID+"&value="+value,
			method:'POST',
			data:{PROPERTY_ID:pID},
			success:function(res){
			  if(res == 1){
				  $("#seller__"+offerID).html(value);
			  }else{

			  }
			  
			}
			
		});
	}
	
}

/*-----------------------------------------------------
 * Approve property by id
 * Developed On 12-03-2018
-----------------------------------------------------*/
function active_property_by_id(pID){
    if(confirm('Are You Sure To Approve The Property..!')){
        $("#massage").html('');
        $.ajax({
            url: site_url+"hpp/admin/aprovedPropertyByID?pID="+pID+"&status=Active",
            method:'POST',
            data:{PROPERTY_ID:pID},
            success:function(res){
                if(res == 1){
                    $("#property_tr__"+pID).hide();
                    $("#massage").html('<div class="alert alert-success">Property Success Fully Activated...!</div>');
                }else if(res == 0){
                    $("#massage").html('<div class="alert alert-warning">Property Dose\'t Activated..!!</div>');
                }
            }
        });
    } else{
        return false;
    }
}

/*-----------------------------------------------------
 * active_offer_property_by_id()
 * Approve Offer Property by id
 * Developed On 23-03-2018
-----------------------------------------------------*/
function active_offer_property_by_id(pID){
    if(confirm('Are You Sure To Approve The Offer For This Property..!')){
        $("#massage").html('');
        $.ajax({
            url: site_url+"hpp/admin/aprovedOfferPropertyByID?pID="+pID+"&status=Active",
            method:'POST',
            data:{PROPERTY_ID:pID},
            success:function(res){
                if(res == 1){
                    $("#property_tr__"+pID).hide();
                    $("#massage").html('<div class="alert alert-success">Property Offer Success Fully Activated...!</div>');
                }else if(res == 0){
                    $("#massage").html('<div class="alert alert-warning">Property Offer Dose\'t Activated..!!</div>');
                }
            }
        });
    } else{
        return false;
    }
}

/*-----------------------------------------------------
 * Reject property by id
 * Developed On 20-03-2018
-----------------------------------------------------*/
function reject_property_by_id(pID){
    if(confirm('Are You Sure To Reject The Property ..!!')){
        $("#massage").html('');
        $.ajax({
            url: site_url+"hpp/admin/aprovedPropertyByID?pID="+pID+"&status=Reject",
            method:'POST',
            data:{PROPERTY_ID:pID},
            success:function(res){
                if(res == 1){
                    $("#property_tr__"+pID).hide();
                    $("#massage").html('<div class="alert alert-success">Property Success Fully Rejected...!</div>');
                }else if(res == 0){
                    $("#massage").html('<div class="alert alert-warning">Property Dose\'t Rejected..!!</div>');
                }
            }
        });
    } else {
        return fale;
    }
}

/*-----------------------------------------------------
 * reject_offer_property_by_id()
 * Reject Offer property by id
 * Developed On 23-03-2018
-----------------------------------------------------*/
function reject_offer_property_by_id(pID){
    if(confirm('Are You Sure To Reject The Offer For This Property ..!!')){
        $("#massage").html('');
        $.ajax({
            url: site_url+"hpp/admin/aprovedOfferPropertyByID?pID="+pID+"&status=Reject",
            method:'POST',
            data:{PROPERTY_ID:pID},
            success:function(res){
                if(res == 1){
                    $("#property_tr__"+pID).hide();
                    $("#massage").html('<div class="alert alert-success">Property Offer Success Fully Rejected...!</div>');
                }else if(res == 0){
                    $("#massage").html('<div class="alert alert-warning">Property Offer Dose\'t Rejected..!!</div>');
                }
            }
        });
    } else {
        return fale;
    }
}

/*-----------------------------------------------------
 * verified_email
 * Developed On 13-03-2018
-----------------------------------------------------*/
function checkVerifiedEmail(email){
//    $('#res').html('');
    $.ajax({
            url: site_url+"hpp/admin/verified_email?emailID="+email,
            method:'POST',
            data:{ADMIN_EMAIL:email},
            success:function(res){
              $("#res").html(res);
            }

    });
}

/**************************************
     * valedation For Admin User Registration
     *
*********************************/
$.validator.addMethod("valueNotEquals", function(value, element, arg){
    // I use element.value instead value here, value parameter was always null
    return arg != element.value; 
}, "Value must not equal arg.");

    $("#addAdminUserForm").validate({
        rules: {
            admin_full_name: {
                required: true,
                minlength: 8
            },
            user_name: {
                required: true,
            },
            admin_role: {
                min: 1,
                required: true,
            },
            admin_email_id: {
                required: true,
                email: true,
            },
            rel_password: {
                required: true,
                minlength: 8
            },
            con_password: {
                required: true,
                minlength: 8,
                equalTo: "#relPassword"
            }


        },
        messages: {
            admin_full_name: {
                required: "Please Enter Admin User Full Name",
            },
            user_name: {
                required: "Please Enter Admin User Name",
            },
            admin_role: {
                required: "Please Select User Role",
            },
            admin_email_id: {
                required: "Please Email Address",
                email: "Plase Enter valid Email Address",
            },
            rel_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long",
            },
            con_password: {
                required: "Please provide Confirm password",
                minlength: "Your password must be at least 8 characters long",
                equalTo: "Please enter the same password as above",
            }
        }
    });
    

/**************************************
   * valedation For Add news Form
   *
*********************************/
    $("#addNewsForm").validate({
        rules: {
            news_title: {
                required: true,
            },
            news_description: {
                required: true,
            },
            news_image: {
                required: true,
            },
        },
        messages: {
            news_title: {
                required: "Please News Title",
            },
            news_description: {
                required: "Please Enter Description",
            },
            news_image: {
                required: "Please Select Image",
            },
        }
    });
    
function check_confirm_delete(){
    var chk = confirm('Are You Sure To Delete This....?');
    if (chk) {
        return true;
    } else {
        return false;
    }
}    
    
    
/*
 * Active User Admin
 * On 13-03-2018
 **/
function activeUserAdminById(uID){
    $("#massage").html('');
    $.ajax({
            url: site_url+"hpp/admin/active_usser_admin_by_id?uID="+uID,
//            method:'POST',
//            data:{ADMIN_ID:uID},
            success:function(res){
                if(res == 1){
                    $("#massage").html('<div class="alert alert-success">User Successfully Activated...!</div>');
//                    $("#ManageAdmin").refresh();
                }else if(res == 0){
                    $("#massage").html('<div class="alert alert-warning">user Dose\'t Activated..!!</div>');
//                    $("#ManageAdmin").refresh();
                }
            }

    });
}

/*
 * DeActive User Admin
 * On 13-03-2018
 **/
function DeActiveUserAdminById(uID){
//    alert(uID);
    $("#massage").html('');
    $.ajax({
            url: site_url+"hpp/admin/deactive_usser_admin_by_id?uID="+uID,
//            method:'POST',
//            data:{ADMIN_ID:uID},
            success:function(res){
//                $("#massage").html(res);
                if(res == 1){
                    $("#massage").html('<div class="alert alert-success">User Successfully Deactived ...!</div>');
//                    $("#ManageAdmin").refresh(); 
                }else if(res == 0){
                    $("#massage").html('<div class="alert alert-warning">User Dose\'t De activated..!!</div>');
//                    $("#ManageAdmin").refresh();
                }
            }

    });
}


/*
 * DeActive User Admin
 * On 13-03-2018
 **/
/*-----------------------------------
 * View auction user details 
 -----------------------------------*/
function adminAuctionDetailsUserModal(pID, offerID){
//   alert(pID);
    $.ajax({
        url: site_url+"hpp/admin/selectAdminAuctionUserModalById?pid="+pID+"&offer="+offerID,
        method:'POST',
        data:{PROPERTY_ID:pID},
        success:function(res){
            $('#adminAuctionModalBody').html(res);
        }
        
    });
}


/*
 * Admin profile Modal
 * On 14-03-2018
 **/
/*-----------------------------------
 * View Admin user details 
 -----------------------------------*/
function adminProfileModal(adminID){
//   alert(adminID);
    $.ajax({
        url: site_url+"hpp/admin/selectAdminProfileModalById?adminID="+adminID,
        method:'POST',
        data:{ADMIN_ID:adminID},
        success:function(res){
            $('#adminProfileModalBody').html(res);
        }
        
    });
}

function adminEditProfileModal(adminID){
//   alert(adminID);
    $.ajax({
        url: site_url+"hpp/admin/selectAdminEditProfileById?adminID="+adminID,
        method:'POST',
        data:{ADMIN_ID:adminID},
        success:function(res){
            $('#adminEditProfileModalBody').html(res);
        }
        
    });
}


/*
 * userProfileModal
 * On 27-03-2018
 **/
/*-----------------------------------
 * View Hpp user details 
 -----------------------------------*/
function userProfileModal(userID){
//   alert(userID);
    $.ajax({
        url: site_url+"hpp/admin/selectHppUserModalById?userID="+userID,
        method:'POST',
        data:{USER_ID:userID},
        success:function(res){
            $('#userProfileModalBody').html(res);
        }
        
    });
}

/*
 * Selecet Courrency Code by country id
 */
function select_currency(id){
    $("#show_currency_code, #show_currency_code1 , #show_currency_code2, #show_currency_code3").html('');
    $.ajax({
        url: site_url+"propertyController/PropertyControl/selectCurrencyCodeByID?cuntryID="+id,
        method:'POST',
        data:{countryID:id},
        success:function(res){
            $("#show_currency_code, #show_currency_code1 , #show_currency_code2, #show_currency_code3").html(res);
        }
    });
}





/*
 * confirmDeleteAction()
 * Developed On 27-03-2018
 */
function confirmDeleteAction()
{
    if(confirm("Are You Sure To Delete This..!")){
        return true;
    }else{
        return false;
    }
}

/*
 * confirmApproveAction()
 * Developed On 30-03-2018
 */
function confirmApproveAction()
{
    if(confirm("Are You Sure To Approve The Property ..!!")){
        return true;
    }else{
        return false;
    }
}
/*
 * confirmRejectAction()
 * Developed On 30-03-2018
 */
function confirmRejectAction()
{
    if(confirm("Are You Sure To Reject The Property ..!!")){
        return true;
    }else{
        return false;
    }
}


function refresh_captcha(){
   return document.getElementById("captcha_code").value = "", document.getElementById("captcha_code").focus(), document.images['captchaimg'].src = document.images['captchaimg'].src.substring(0, document.images['captchaimg'].src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
}

function property_information(pID){
   //alert(pID);
    $.ajax({
        url: site_url+"WelcomeHpp/property_listing_deails?pId="+pID,
        method:'POST',
        data:{PROPERTY_ID:pID},
        success:function(res){
           //alert(data);
		   $('#modalBodyCounter').html(res);
        }
        
    });
}
