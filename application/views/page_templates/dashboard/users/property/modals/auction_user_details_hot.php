<div class="modal-body">
       <div id="massage"></div>
	   <p style="font-weight:bold;"><small>Last 10 Counter information </small></p>
	   <table class="table table-striped table-bordered datatable">
		<thead>
			 <tr>
				 <th class="center"> #SL </th>
				 <th> Counter Info </th>
				 <th class="center">User Counter Price </th>
				 <th class="center">Seller Offer Price </th>
				 <th class="center">Counter Details </th>
				 <th class="center">Date </th>
				 <th class="center"> Select Counter </th> 
			 </tr>
		 </thead>
		 <tbody>
		   <?php
			if(is_array($auction_user) AND sizeof($auction_user) > 0){
				$i =1;
				foreach($auction_user AS $value):
					$userInfo = $this->user->select_user_profile_by_id($value['USER_ID']);
					$sattus = '<a href="javascript:win_auction_bidder('.$value['USER_ID'].','.$value['OFFER_P_ID'].','.$value['PROPERTY_ID'].','.$value['OFFER_BID_PRICE'].');"> Accept</a>';
					
				?>
					<tr>
						<td class="center"> <?= $i;?></td>
						<td class="center"> <?php echo '<a href="'.SITE_URL.'agent?id='.$userInfo->USER_LOG_NAME.'" target="_blank"> '.$userInfo->USER_NAME.' </a>';?></td>
						<td class="center"> <?= number_format($value['OFFER_BID_PRICE']);?></td>
						<td class="center"> <span id="seller__<?= $value['OFFER_BID_ID'] ?>"><?= number_format($value['SELLER_PRICE']);?> </span><br/><a href="javascript:counterReplaySeller(<?= $value['OFFER_BID_ID']; ?>,<?=  $value['PROPERTY_ID'];?>);"> Offer</a></td>
						<td class="center"> <?= $value['OFFER_BID_DETAILS'];?></td>
						<td class="center"> <?= date("d M Y", strtotime($value['ENT_DATE']));?></td>
						
						
						<td class="center"> <?= $sattus;?> </td>
					</tr>
				<?php	
				$i++;
				endforeach;
			}else{
				echo '<tr><td class="center" colspan="6">Not Found</td></tr>'; 
			}
		   ?>
		</tbody>
	   </table>
</div> <!-- end of modal-body -->
   
 <script> 

 </script>  
