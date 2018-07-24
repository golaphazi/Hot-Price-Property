<?php 
$hot_price      = '';   
$offer_price    = '';   
$hot_start      = '';
$end_date       = '';
$offer_status   = 'default';
$buttonName     = 'addHotPriceProperty';
$buttonValue    = 'Add To Hot Price Info';
$CI =& get_instance();
    $result = $CI->any_where( array( 'PROPERTY_ID' => $prodectID ),'p_property_offers' );
    $count = sizeof($result);
    if($count > 0){
        $hot_price = number_format($result[0]['OFFER_PRICE'], 2);
        $hot_start = $result[0]['OFFER_START_DATE'];
        $end_date  = $result[0]['OFFER_END_DATE'];
        $offer_status = $result[0]['OFFER_STATUS'];
        $buttonName = 'addHotPriceProperty';
        $buttonValue = 'Update Hot Price Info';
    }
    
    //echo $id = $hpp_modal_property[0]['PROPERTY_COUNTRY'];
//    $query = $CI->any_where( array( 'countryID' => $id ),'mt_countries' );
    
    if( ($offer_status == 'default' OR $offer_status == 'Pending'  OR $offer_status == 'Reject')  AND $type_admin != 'admin' ){
?>

<?= form_open('manage-property?search=hot&hot=' . $prodectID, [ 'id' => 'PropertyAddHotPrice', 'name' => 'PropertyAddHotPrice', 'class' => '']); ?>
    <div class="modal-body hotpriceDefualtModal">
        <?php if($offer_status == 'default'){ ?>
        <h4 class="s-property-title"> Do you want to offer this property to hot price? Please Fill the bellow information. </h4>
        <?php } else if($offer_status == 'Pending'  OR $offer_status == 'Reject'){ ?>
            <h4 class="s-property-title"> You have given your property a hot price, now you can update the information you want. </h4>
       <?php } ?>
        <div class="form-group">
            <label for="recipient-name" class="form-control-label">Base Price :</label>
            <input onblur="number_format(this)" type="text" id="propertyprice" name="propertyprice" value="<?= number_format($hpp_modal_property[0]['PROPERTY_PRICE'], 2) . ' ' . $hpp_modal_property[0]['CURRENCY_CODE']; ?>" class="form-control currency" readonly="">
        </div>
            
        <label for="recipient-name" class="form-control-label">Property Hot Price:</label>    
        <div class="input-group">
            <span class="input-group-addon show-currency-code" id="show_currency_code"> <?= $hpp_modal_property[0]['CURRENCY_CODE']; ?> </span>
            <input onblur="number_format(this)" onkeyup="removeChar(this)"  type="text" name="offer_price" value="<?= $hot_price; ?>" class="form-control" id="offerPrice" >
        </div>
        <div class="form-group">
            <label for="start-date" class="form-control-label">Start Date: <small>(  Time should be 24 hours format  ) </small> </label>
            <input type="text" name="hot_price_start_date" id="hotPriceStartDate" class="form-control datepickerStartDate" value="<?= $hot_start; ?>">                           
        </div>
        <div class="form-group">
            <label for="end-date" class="form-control-label">Dateline:<small>(  How long will the offer from the start date  ) </small> </label>
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="hot_price_end_date" id="hotPriceEndDate__0" class="form-control datepickerEndDate_00" placeholder="Ex: 3"> 
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="dateType">
                        <option value="hours">Hours</option>
                        <option value="days" selected>Days</option>
                        <option value="months">Months</option>
                    </select>
                </div>
            </div>                         
        </div>
    </div> <!-- end of modal-body -->
    
    <?php 
    }
        if( ($offer_status == 'default' OR $offer_status == 'Pending' OR $offer_status == 'Reject')  AND $type_admin != 'admin' ){
            echo '<div class="modal-footer"><input  type="submit" name="'.$buttonName.'" value="'.$buttonValue.'" id="addHotPriceProperty" class="btn btn-primary"></div>';
        }
    ?>
    
<?= form_close(); ?>

    <?php if( ($offer_status == 'Active' OR $offer_status == 'Win') OR ($type_admin == 'admin') ){ ?> 
    <div class="modal-body">
        <div class="section additional-details mar-l-20 hotViewPriceModal">
            <h4 class="s-property-title">Your property is offered at Hot Price Offer, which is given below : </h4>
            <ul class="additional-details-list clearfix">
                <li>
                    <span class="col-xs-6 col-sm-4 col-md-4 add-d-title">Base Price</span>
                    <span class="col-xs-6 col-sm-8 col-md-8 add-d-entry"><?= number_format($hpp_modal_property[0]['PROPERTY_PRICE'], 2) . ' ' . $hpp_modal_property[0]['CURRENCY_CODE']; ?></span>
                </li>

                <li>
                    <span class="col-xs-6 col-sm-4 col-md-4 add-d-title" <?php if($type_admin == 'admin'){?> ondblclick="editFiledDataAdmin('start_offer_id___<?= $result[0]['OFFER_P_ID']; ?>___OFFER_P_ID', 'p_property_offers', 'OFFER_PRICE', '<?= $result[0]['OFFER_PRICE']; ?>');" <?php }?>>Hot Price</span>
                    <span class="col-xs-6 col-sm-8 col-md-8 add-d-entry" <?php if($type_admin == 'admin'){?> id="start_offer_id___<?= $result[0]['OFFER_P_ID']; ?>___OFFER_P_ID" ondblclick="editFiledDataAdmin(this.id, 'p_property_offers', 'OFFER_PRICE', '<?= $result[0]['OFFER_PRICE']; ?>');" <?php }?>> <?= $hot_price . ' ' . $hpp_modal_property[0]['CURRENCY_CODE'] ; ?> <?php if($type_admin == 'admin'){?><i class="fa fa-edit" style="float:right; margin-top:3px;"></i><?php }?></span>
                </li>
                <li>
                    <span class="col-xs-6 col-sm-4 col-md-4 add-d-title">Offer Start Date</span>
                    <span class="col-xs-6 col-sm-8 col-md-8 add-d-entry" <?php if($type_admin == 'admin'){?>id="win_stat_date___<?= $result[0]['OFFER_P_ID']; ?>___OFFER_P_ID" ondblclick="editFiledDataAdmin(this.id, 'p_property_offers', 'OFFER_START_DATE',  '<?= $hot_start; ?>');" <?php }?>>
                        <?php 
                            $getDate = strtotime( $hot_start ); 
                            $newDate = date( 'd M Y H:i:s', $getDate );
                            echo $newDate;
                        ?>
			<?php if($type_admin == 'admin'){?><i class="fa fa-edit" style="float:right; margin-top:3px;"></i><?php }?>
                    </span>
                </li>

                <li>
                    <span class="col-xs-6 col-sm-4 col-md-4 add-d-title">Offer End Date</span>
                    <span class="col-xs-6 col-sm-8 col-md-8 add-d-entry" <?php if($type_admin == 'admin'){?>id="win_end_date___<?= $result[0]['OFFER_P_ID']; ?>___OFFER_P_ID" ondblclick="editFiledDataAdmin(this.id, 'p_property_offers', 'OFFER_END_DATE',  '<?= $end_date; ?>');" <?php }?>>
                        <?php 
                            $getDate = strtotime( $end_date ); 
                            $newDate = date( 'd M Y H:i:s', $getDate );
                            echo $newDate;
                        ?>
			<?php if($type_admin == 'admin'){?><i class="fa fa-edit" style="float:right; margin-top:3px;"></i><?php }?>
                    </span>
                </li>
            </ul>
        </div>
    </div> <!-- end of modal-body -->
    <?php } ?>
    
<script type="text/javascript">
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

/*------------------------------------------------
     * validation OF Add Hot Price Property Form
     *
------------------------------------------------*/

/*-- custom code for greater than --*/

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

jQuery(document).ready(function(){
    $("#PropertyAddHotPrice").validate({
        rules: {
            offer_price: {
                required: true,
            },
            hot_price_start_date: {
                required: true
            },
            hot_price_end_date: {
                required: true,
                //greaterThan: "#hotPriceStartDate"
            }


        },
        messages: {
            offer_price: {
                required: "Please Provide Property Hot Price",
            },
            hot_price_start_date: {
                required: "Please Select Offer Start Date"
            },
            hot_price_end_date: {
                required: "Please enter dateline",
               // greaterThan: "End date Must be Greater Than Start Date"
            }
        },
       /* submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: site_url+"profileController/user/ProfileControll/add_hot_price_property?pid="+pid,
                data: $("form#PropertyAddHotPrice").serialize(),
                cache: false,
                success: function(msg){
                   alert(mas);
                    if( msg == 1 ){
                       var sms = "Property Succesfully added into hot price section..!";
                        $("#actioMessage").attr('class', 'alert alert-success').html(sms); 
                    }else{
                        alert('Property Dose Not Add Hot Price Section..!');
                    }
                }
            })
        }*/
        
    });
});
</script>     