<?php 
$offer_start_price  = '';   
$offer_win_price    = '';   
$offer_start_date   = '';
$offer_end_date     = '';
$offer_price        = '';
$offer_status       = 'default';
$checkbox           = '';
$buttonValue        = 'Add To Auction';
$CI =& get_instance();
    $result = $CI->any_where( array( 'PROPERTY_ID' => $prodectID ),'p_property_offers' );
    $count = sizeof($result);
    if($count > 0){
        $offer_start_price = number_format($result[0]['OFFER_PRICE'], 2);
        $offer_win_price   = number_format($result[0]['BIDDING_WIN_PRICE'], 2);
        $offer_start_date  = $result[0]['OFFER_START_DATE'];
        $offer_end_date    = $result[0]['OFFER_END_DATE'];
        $offer_price       = $result[0]['OFFER_PRICE'];
        $offer_status      = $result[0]['OFFER_STATUS'];
        $checkbox          = 'checked';
        $buttonName        = 'addHotPriceProperty';
        $buttonValue       = 'Update Auction Info';
    }
    
    // For Courrecy Code..
    $countryID = $auction_modal_property[0]['PROPERTY_COUNTRY'];
//    $courrency = $CI->any_where( array('countryID' => $countryID), 'mt_countries' );
    //$currency_code = $currency->row();
//    if(is_array($currency_code) && sizeof($currency_code) > 0 ){
//       $code = $currency_code->currency_code . ' ( ' .$currency_code->currency_symbol. ' )';
//    }
    

    if( ($offer_status == 'default' OR $offer_status == 'Pending' OR $offer_status == 'Reject')  AND $type_admin != 'admin'){
?>

<?= form_open('manage-property?search=auction&bid=' . $prodectID, [ 'id' => 'PropertyAddAuction', 'name' => 'PropertyAddAuction', 'class' => '']); ?>
    <div class="modal-body hotpriceDefualtModal">
        <?php if($offer_status == 'default'){ ?>
            <h4 class="s-property-title"> Do you want to offer this property to Auction? Please Fill the bellow information. </h4>
        <?php } else if($offer_status == 'Pending' OR $offer_status == 'Reject'){ ?>
            <h4 class="s-property-title"> You have given your property an Auction, now you can update the information you want. </h4>
       <?php } ?>
        <div class="form-group">
            <label for="base-price" class="form-control-label">Base Price :</label>
            <input onblur="number_format(this)" type="text" id="propertyprice" name="propertyprice" value="<?= number_format( $auction_modal_property[0]['PROPERTY_PRICE'] , 2) . ' ' . $auction_modal_property[0]['CURRENCY_CODE']; ?>" class="form-control currency" readonly="">
        </div>
        
        <label for="offerStartPrice" class="form-control-label">Offer Start Price:</label>
        <div class="input-group">
            <span class="input-group-addon show-currency-code" id="show_currency_code"> <?= $auction_modal_property[0]['CURRENCY_CODE']; ?> </span>
            <input onblur="number_format(this)" onkeyup="removeChar(this)"  type="text" name="offer_start_price" value="<?= $offer_start_price; ?>" class="form-control" id="offerStartPrice" placeholder="00,000.00">
        </div>
        
        <label for="offerWinPrice" class="form-control-label">Offer Win/Reserve Price:</label>
        <div class="input-group">            
            <span class="input-group-addon show-currency-code" id="show_currency_code"> <?= $auction_modal_property[0]['CURRENCY_CODE']; ?> </span>
            <input onblur="number_format(this)" onkeyup="removeChar(this)"  type="text" name="offer_win_price" value="<?= $offer_win_price; ?>" class="form-control" id="offerWinPrice" placeholder="00,000.00">
        </div>
        <div class="form-group">
            <label for="start-date" class="form-control-label">Offer Start Date: <small>(  Time should be 24 hours format  ) </small>  </label>
            <input type="text" name="offer_start_date" id="hotPriceStartDate" value="<?= $offer_start_date; ?>" class="form-control datepickerStartDate" placeholder="Ex: YYYY-mm-dd H:m">                           
        </div>
        <div class="form-group">
            <label for="end-date" class="form-control-label">Dateline:<small>(  How long will the offer from the start date  ) </small> </label>
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="offer_end_date" id="hotPriceEndDate__0" class="form-control datepickerEndDate_00" placeholder="Ex: 3"> 
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

        <div class="form-group padding-bottom-40">
            <p>
                <label for="auctionPaumentTerms"><strong>Terms and Conditions</strong></label>
                You must submit the 5% price of the <b>Offer Start Price</b> to the HPP joint vencher account for Property Auction.
            </p>

            <div class="TermsCheckBox">
                <input type="checkbox" name="auctionPaumentTerms" <?= $checkbox;?> value="Agree" id="auctionPaumentTerms"/>
                <label for="auctionPaumentTerms"><strong>Accept termes and conditions.</strong></label>
            </div> 
        </div>

    </div> <!-- end of modal-body -->
    <div class="modal-footer">
        <input  type="submit" name="addAuctionProperty" value="<?= $buttonValue; ?>" id="addAuctionProperty" class="btn btn-primary">
    </div>

    <?= form_close(); ?>
   <?php } 
   if( ($offer_status == 'Active' OR $offer_status == 'Win') OR ($type_admin == 'admin')){ ?> 
    <div class="modal-body">
        <div class="section additional-details mar-l-20 hotViewPriceModal">
            <h4 class="s-property-title">Your property is offered at Auction, which is given below : </h4>
			<?php
			if($type_admin == 'admin'){
				echo '<p> If you want update auction data.. Then you Double Click up Editable Data. </p>';
			}
			?>
            <ul class="additional-details-list clearfix">
                <li>
                    <span class="col-xs-6 col-sm-6 col-md-6 add-d-title">Base Price</span>
                    <span class="col-xs-6 col-sm-6 col-md-6 add-d-entry"><?= number_format( $auction_modal_property[0]['PROPERTY_PRICE'] , 2) . ' ' .$auction_modal_property[0]['CURRENCY_CODE']; ?></span>
                </li>
                <li>
                    <span class="col-xs-6 col-sm-6 col-md-6 add-d-title" <?php if($type_admin == 'admin'){?> ondblclick="editFiledDataAdmin('start_offer_id___<?= $result[0]['OFFER_P_ID']; ?>___OFFER_P_ID', 'p_property_offers', 'OFFER_PRICE', '<?= $offer_price; ?>');" <?php }?>>Auction Start Price <?php if($type_admin == 'admin'){?><i class="fa fa-edit" style="float:right; margin-top:3px;"></i> <?php }?></span>
                    <span class="col-xs-6 col-sm-6 col-md-6 add-d-entry" <?php if($type_admin == 'admin'){?> id="start_offer_id___<?= $result[0]['OFFER_P_ID']; ?>___OFFER_P_ID" ondblclick="editFiledDataAdmin(this.id, 'p_property_offers', 'OFFER_PRICE', '<?= $offer_price; ?>');" <?php }?>> <?= $offer_start_price . ' ' .$auction_modal_property[0]['CURRENCY_CODE']; ?> </span>
					
                </li>
                <li>
                    <span class="col-xs-6 col-sm-6 col-md-6 add-d-title" <?php if($type_admin == 'admin'){?> ondblclick="editFiledDataAdmin('win_offer_id___<?= $result[0]['OFFER_P_ID']; ?>__OFFER_P_ID', 'p_property_offers', 'BIDDING_WIN_PRICE',  '<?= $result[0]['BIDDING_WIN_PRICE']; ?>');" <?php }?>>Auction Win/Reserve Price <?php if($type_admin == 'admin'){?><i class="fa fa-edit" style="float:right; margin-top:3px;"></i><?php }?></span>
                    <span class="col-xs-6 col-sm-6 col-md-6 add-d-entry" <?php if($type_admin == 'admin'){?>id="win_offer_id___<?= $result[0]['OFFER_P_ID']; ?>___OFFER_P_ID" ondblclick="editFiledDataAdmin(this.id, 'p_property_offers', 'BIDDING_WIN_PRICE',  '<?= $result[0]['BIDDING_WIN_PRICE']; ?>');" <?php }?>><?= $offer_win_price . ' ' .$auction_modal_property[0]['CURRENCY_CODE']; ?> </span>
                </li>
                <li>
                    <span class="col-xs-6 col-sm-6 col-md-6 add-d-title">Auction Start Date <?php if($type_admin == 'admin'){?><i class="fa fa-edit" style="float:right; margin-top:3px;"></i><?php }?></span>
                    <span class="col-xs-6 col-sm-6 col-md-6 add-d-entry" <?php if($type_admin == 'admin'){?>id="win_stat_date___<?= $result[0]['OFFER_P_ID']; ?>___OFFER_P_ID" ondblclick="editFiledDataAdmin(this.id, 'p_property_offers', 'OFFER_START_DATE',  '<?= $offer_start_date; ?>');" <?php }?>>
                        <?php 
                            $getDate = strtotime( $offer_start_date ); 
                            $newDate = date( 'd M Y H:i:s', $getDate );
                            echo $newDate;
                        ?>
                    </span>
                </li>
                <li>
                    <span class="col-xs-6 col-sm-6 col-md-6 add-d-title">Auction End Date <?php if($type_admin == 'admin'){?><i class="fa fa-edit" style="float:right; margin-top:3px;"></i> <?php }?></span>
                    <span class="col-xs-6 col-sm-6 col-md-6 add-d-entry" <?php if($type_admin == 'admin'){?>id="win_end_date___<?= $result[0]['OFFER_P_ID']; ?>___OFFER_P_ID" ondblclick="editFiledDataAdmin(this.id, 'p_property_offers', 'OFFER_END_DATE',  '<?= $offer_end_date; ?>');" <?php }?>>
                        <?php 
                            $getDate = strtotime( $offer_end_date ); 
                            $newDate = date( 'd M Y H:i:s', $getDate );
                            echo $newDate;
                        ?>			
                    </span>
                </li>
            </ul>
        </div>
    </div> <!-- end of modal-body -->
    <?php } ?>
    
    
<script type="text/javascript">
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

jQuery(document).ready(function(){
    $("#PropertyAddAuction").validate({
        rules: {
            offer_start_price: {
                required: true,
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
            }


        },
        messages: {
            offer_start_price: {
                required: "Please Provide Offer Start Price",
            },
            offer_win_price: {
                required: "Please Provide Offer Win/Close Price",
                greaterThan: "Offer Win/Close Price Must be Gether Than offer start Price",
            },
            offer_start_date: {
                required: "Please Select Offer Start Date"
            },
            offer_end_date: {
                required: "Please enter dateline",
               // greaterThan: "End date Must be Greater Than Start Date"
            },
            auctionPaumentTerms: {
                required: "You Must Check Terms & Conditions",
               // greaterThan: "End date Must be Greater Than Start Date"
            }
        },
        
    });
});

</script>     