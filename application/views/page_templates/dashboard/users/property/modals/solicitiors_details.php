<?php 
    $propertyID = $this->input->get('pId');
    $offerID    = $this->input->get('offerId');
	$type    = $this->input->get('type');
	 if($type == 1){
		 $submit = 'bidding-summery';
	 }else{
		 $submit = 'offer-summery';
	 }
    $solicitorview = $this->Property_Model->any_type_where(array('PROPERTY_ID' => $propertyID, 'USER_ID' => $this->userID, 'OFFER_P_ID' => $offerID, 'SOLICITORS_STATUS' => 'Active'), 'solicitors_details');
	
	$name = '';
	$agency = '';
	$licensed = '';
	$phone = '';
	$fax = '';
	$mobile = '';
	$email = '';
	$edit = 'down';
	if(is_array($solicitorview) AND sizeof($solicitorview) > 0){
		$name = $solicitorview[0]['SOLICIRORS_NAME'];
		$agency = $solicitorview[0]['SOLICIRORS_AGENCY_NAME'];
		$licensed = $solicitorview[0]['SOLICIRORS_LICENSED_NO'];
		$phone = $solicitorview[0]['SOLICIRORS_PHONE'];
		$fax = $solicitorview[0]['SOLICIRORS_FAX'];
		$mobile = $solicitorview[0]['SOLICIRORS_MOBILE'];
		$email = $solicitorview[0]['SOLICIRORS_EMAIL'];
		$edit = 'up';
	}
?>
<?= form_open($submit.'?pId='.$propertyID.'&offerId='.$offerID.'&type='.$edit, [ 'id' => 'SolicitorsDetails', 'name' => 'SolicitorsDetails', 'class' => '']); ?>

    <div class="modal-body">
        <div class="form-group">
            <label for="solicitorName" class="form-control-label">Solicitor Name :</label>
            <input type="text" id="solicitorName" value="<?= $name;?>" name="solicitor_name" class="form-control" placeholder="Ex: David Heaford">
        </div>
        <div class="form-group">
            <label for="solicitorAgentName" class="form-control-label">Settlement Agent Name/Solicitors Business Name :</label>
            <input type="text" id="solicitorAgentName"  value="<?= $agency;?>" name="settlement_agent_name" class="form-control" placeholder="Ex: David Heaford Settlements Pty Ltd">
        </div>
        <div class="form-group">
            <label for="solicitorsLicensed" class="form-control-label">Licensed No.:</label>
            <input type="text" name="solicitors_licensed_no" value="<?= $licensed;?>"  class="form-control" id="solicitorsLicensed" placeholder="Ex: L-010-22-SOL">
        </div>
        <div class="form-group">
            <label for="solicitorsPhone" class="form-control-label">Phone : </label>
            <input type="text" name="solicitors_phone" id="solicitorsPhone" value="<?= $phone;?>"  class="form-control" placeholder="Ex: 08 9444 4112">                           
        </div>
        <div class="form-group">
            <label for="solicitorsFax" class="form-control-label">Fax  : </label>
            <input type="text" name="solicitors_fax" id="solicitorsFax" value="<?= $fax;?>"  class="form-control" placeholder="Ex: 08 9444 4113">                           
        </div>
        <div class="form-group">
            <label for="solicitorsMobile" class="form-control-label">Mobile : </label>
            <input type="text" name="solicitors_mobile" id="solicitorsMobile" value="<?= $mobile;?>" class="form-control" placeholder="Ex: 0447 506 657">                           
        </div>
        <div class="form-group">
            <label for="solicitorsEmail" class="form-control-label">Email : </label>
            <input type="email" name="solicitors_email" id="solicitorsEmail" value="<?= $email;?>" class="form-control" placeholder="Ex: toby@davidheaford.com.au">                           
        </div>
        
    </div> <!-- end of modal-body -->
    <div class="modal-footer">
        <input  type="submit" name="addSolicitors" value="Submit" id="addSolicitors" class="btn btn-primary">
    </div>

<?= form_close(); ?>

    
<script type="text/javascript">
/*--------------------------------------------------
     * validation OF Add Solicitiors Deatils Form
     * ON 07-03-2018
--------------------------------------------------*/
jQuery(document).ready(function(){
    $("#SolicitorsDetails").validate({
        rules: {
            solicitor_name: {
                required: true,
            },
            business_name: {
                required: true,
            },
            solicitors_licensed_no: {
                required: true
            },
            solicitors_phone: {
                required: true,
            },
            solicitors_fax: {
                required: true,
            },
            solicitors_mobile: {
                required: true,
            },
            solicitors_email: {
                required: true,
            }

        },
        
        messages: {
            solicitor_name: {
                required: "Please Enter Solicitors Name",
            },
            business_name: {
                required: "Please Enter Settlement Agent/Solicitors Business Name",
            },
            solicitors_licensed_no: {
                required: "Please Provide License No."
            },
            solicitors_phone: {
                required: "Please Provide Phone Number",
            },
            solicitors_fax: {
                required: "Please Provide Fax Number",
            },
            solicitors_mobile: {
                required: "Please Provide Mobile Number",
            },
            solicitors_email: {
                required: "Please Provide Valid Email ID",
            }
        },
        
    });
});
</script>     