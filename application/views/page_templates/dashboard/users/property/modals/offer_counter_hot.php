<?php
    $propertyID = $this->input->get('pId');
    $offerID    = $this->input->get('offerId');
    $type    = $this->input->get('type');
    $auction_user = $this->Property_Model->any_type_where(array('PROPERTY_ID' => $propertyID, 'USER_ID' => $this->userID, 'OFFER_P_ID' => $offerID, 'OFFER_BID_STATUS' => 'Active'), 'p_property_offers_bidding');
	
?>
<?= form_open('offer-summery?pId='.$propertyID.'&offerId='.$offerID, [ 'id' => 'offer_counter', 'name' => 'offer_counter', 'class' => '']); ?>

<div class="modal-body">
       <div id="massage"></div>
	   <p style="font-weight:bold;"><small>Your <?php if($type == '1'){?>Auction <?php }else{?> Counter<?php }?> information </small></p>
	   <table class="table table-striped table-bordered datatable">
		<thead>
			 <tr>
				 <th class="center"> #SL </th>
				 <th class="center">Counter Price </th>
				 <?php if($type == '2'){?><th class="center">Seller Price </th> <?php }?>
				 <th class="center">Counter Details </th>
				 <th class="center">Date </th>				
			 </tr>
		 </thead>
		 <tbody>
		   <?php
			if(is_array($auction_user) AND sizeof($auction_user) > 0){
				$i =1;
				$detial = '';
				foreach($auction_user AS $value):
					$detial = $value['COUNTER_INFO'];
				?>
					<tr>
						<td class="center"> <?= $i;?></td>
						<td class="center"> <?= number_format($value['OFFER_BID_PRICE']);?></td>
						 <?php if($type == '2'){?><td class="center"> <?= number_format($value['SELLER_PRICE']);?></td><?php }?>
						<td class="center"> <?= $value['OFFER_BID_DETAILS'];?></td>
						<td class="center"> <?= date("d M Y", strtotime($value['ENT_DATE']));?></td>
						
					</tr>
				<?php	
				$i++;
				endforeach;
				//echo $detial.'00';
				if($type == '2'){
					$exp = explode("___", $detial);
					
					if(is_array($exp) AND sizeof($exp) > 0 AND strlen($detial) > 5){
						
						$m = 2;						
						foreach($exp AS $dataValue){
							$expe = explode("__", $dataValue);
							//print_r($expe)
							if(is_array($expe) AND sizeof($expe) > 2){
								
								?>
									<tr>
										<td class="center"> <?= $m;?></td>
										<td class="center"> <?= $expe[0];?></td>
										<td class="center"> <?= $expe[1];?></td>
										<td class="center"> <?= $expe[2];?></td>
										<td class="center"> <?= $expe[3];?></td>
										
									</tr>
								<?php
								$m++;
							}
						}
					}
					
				}
			}else{
				echo '<tr><td class="center" colspan="6">Not Found</td></tr>'; 
			}
		   ?>
		</tbody>
		<?php
			if($type == 2){
		?>
		<tfoot>
			<tr>
				<td colspan="5">
				 <div class="form-group">
					<label for="solicitorName" class="form-control-label">Counter Price</label>
					<input type="text" id="counter_price" value="" name="counter_price" class="form-control" placeholder="Ex: 0.00">
				</div>
				<div class="form-group">
					<label for="solicitorName" class="form-control-label">Details</label>
					<input type="text" id="counter_details" value="" name="counter_details" class="form-control" placeholder="Details counter">
				</div>
				</td>
			</tr>
		</tfoot>
			<?php }?>	
	   </table>
</div> <!-- end of modal-body -->
	<?php
		if($type == 2){
		?>
			<div class="modal-footer">
				<input type="submit" name="addCounterValue" value="Add Counter Price" id="addCounterValue" class="btn btn-primary">
			</div>
	<?php }?>	
   <?= form_close(); ?>
 <script> 

 </script>  
