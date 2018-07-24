<div class="page-head"> 
        <div class="container">
            <div class="row">
                <div class="page-head-content">
                    <h1 class="page-title">Welcome <span class="orange strong"> Paypal Payment</span></h1>               
                </div>
            </div>
        </div>
    </div>


<div class="container" style="padding: 70px 0;">
    <div class="row">
        <?php if(strlen($MSG)> 2){?>
		<div class="col-xs-12">
            <div id="actioMessage">
                <div class="alert alert-success">
                    <?php echo $MSG; ?>
                </div>   
            </div>    
        </div> <!-- End of col-xs-12 --><br/>
		<?php } ?>
        <div class="col-xs-12">
			<?php 
			if(is_object($fetch) AND sizeof($fetch) > 0){
			 echo '<h3>'.$fetch->PROPERTY_NAME.'</h3>
					<h4>'.$fetch->PROPERTY_STREET_NO.', '.$fetch->PROPERTY_STREET_ADDRESS.', '.$fetch->PROPERTY_CITY.'.</h4>
					<h5>Sell Price: '.number_format($fetch->SELL_PRICE).' '.$fetch->CURRENCY_CODE.' ( '.$fetch->CURRENCY_SAMPLE.' )</h5>
					';
				$userInfo = $this->user->select_user_profile_by_id($fetch->SELL_USER);
				//print_r($userInfo);
				$massage = isset($_GET['status']) ? $_GET['status'] : '';	
				if($massage == 'notify' OR $massage == 'save'){
					//if($massage == 'save'){
						echo '<div class="col-xs-12">
								<div id="actioMessage">
									<div class="alert alert-success">
										Payment Successfull. 
									</div>   
								</div>    
							</div>';
					//}
					
				}else{
			?>
	
			<br/>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				  <input type="hidden" name="cmd" value="_xclick"> 
				  
				  <input type="hidden" name="business" value="mahimasud-facilitator@gmail.com">
				  <input type="hidden" name="item_name" value="<?= $fetch->PROPERTY_NAME;?>">
				  <input type="hidden" name="amount" value="<?= $fetch->SELL_PRICE;?>">
				  <input type="hidden" name="quantity" value="1">
				  
				  <input TYPE="hidden" name="notify_url" value="<?= SITE_URL;?>payment-now?id=<?= $this->Property_Model->encode_str($fetch->PROPERTY_ID);?>&status=notify">
				  <input TYPE="hidden" name="return" value="<?= SITE_URL;?>payment-now?id=<?= $this->Property_Model->encode_str($fetch->PROPERTY_ID);?>&status=save">
				  
				  <input type="hidden" name="first_name" value="<?= $userInfo->FULL_NAME; ?>">
				  <input type="hidden" name="address" value="<?= $userInfo->ADDRESS; ?>">		
				  <input type="hidden" name="country" value="<?= $fetch->CURRENCY_CODE;?>">
				  <input type="hidden" name="lc" value="US">
				  <input type="hidden" name="currency_code" value="<?= $fetch->CURRENCY_CODE;?>">				  
				  <input TYPE="hidden" name="cancel_return" value="<?= SITE_URL;?>payment-now?id=<?= $this->Property_Model->encode_str($fetch->PROPERTY_ID);?>&status=cancel">
				  
				  
				  <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="Buy Now">
			</form>
			<br/>
			<img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/cc-badges-ppmcvdam.png" alt="Credit Card Badges">
			
			
			<?php
				}
			}
			?>
		</div>
    </div> <!-- End of row-->
</div>