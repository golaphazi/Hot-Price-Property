	<?php $CI =& get_instance(); ?>	
	<div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">Welcome <span class="orange strong"></span></h1>               
                    </div>
                </div>
            </div>
        </div>
        <div class="properties-area recent-property" style="">
            <div class="container">  
                <div class="row">
                     
                    <?= $user_menu; ?>

                    <div class="col-md-9  pr0 padding-top-40 properties-page">                    
                        <div class="col-md-12 clear"> 
                            <h4 class="center sectionTitle"><srtong>::</srtong> Offer Summery <srtong>::</srtong> </h4>
                            <div class="col-xs-12">
                                    <?php
                                    $message = $this->session->userdata('message');
                                    if ($message) {
                                        ?> 
                                        <div class="alert alert-success">
                                                <?php echo $message; ?>
                                        </div>
                                        <?php
                                        $this->session->unset_userdata('message');
                                    }
                                    ?>
                            </div> <!-- End of col-xs-12 -->
                            <div class="hpp_wpapper_table">
                                     <?php
                                     $get_search = $selectType;
                                     $nae = '';

                                     ?>
                                     <ul>
                                        <?php if($account_type == 1){?><li class="<?php if($get_search == 'offer'){$nae = 'Offer Start Price ';  echo 'active';}?>" ><a href="<?= SITE_URL ?>bidding-summery?search=offer" >Offer Property </a></li> <?php }?>
                                        <?php if($account_type == 2){?><li class="<?php if($get_search == 'bidder'){$nae = 'Your Counter Price';  echo 'active';}?>" ><a href="<?= SITE_URL ?>bidding-summery?search=bidder" >Counter</a></li> <?php }?>

                                    </ul>
									<div style="clear:both;"> </div>
										<div class="table-responsive">
										 <table class="table table-striped table-bordered datatable">

											 <thead>
												 <tr>
													 <th class="center"> #SL </th>
													 <th> Property Name </th>
													 
													 <th class="center"> Offer Price </th>
													 <th class="center"> <?= $nae;?> </th>
													 <th class="center"> Last Counter Price </th>
													 <th class="center"> Total <?php if($get_search == 'offer'){ ?> Counter <?php } else{ ?> Bidder<?php } ?> </th>
													 
													 <th class="center"> Status </th>
													 <th class="center"> Action </th>
												 </tr>
											 </thead> 

											 <?php 
												 $i = 1;
												 if(is_array($select_property_by_user) AND sizeof($select_property_by_user) > 0){
												 foreach ( $select_property_by_user as $uProperty ) {
													$pImage = SITE_URL . $uProperty->IMAGE_LINK . $uProperty->IMAGE_NAME; 
													$totalBidder = 0;
												   $BIDDING_PRICE =  $uProperty->OFFER_PRICE;
												   $offr_bid = $this->db->query("SELECT OFFER_BID_PRICE FROM p_property_offers_bidding WHERE PROPERTY_ID = ".$uProperty->PROPERTY_ID." AND OFFER_P_ID = ".$uProperty->OFFER_P_ID." AND OFFER_BID_STATUS = 'Active' ORDER BY OFFER_BID_ID DESC LIMIT 0,1");
												   $offr_bid_val = $offr_bid->result_array();
												   if(is_array($offr_bid_val) AND sizeof($offr_bid_val) > 0){
														   $BIDDING_PRICE = $offr_bid_val[0]['OFFER_BID_PRICE'];
												   }

												   $available = $uProperty->OFFER_END_DATE;
												   $totalBidder = $this->Property_Model->any_type_where(array('PROPERTY_ID' => $uProperty->PROPERTY_ID, 'OFFER_P_ID' => $uProperty->OFFER_P_ID, 'OFFER_BID_STATUS' => 'Active'), 'p_property_offers_bidding', 'COUNT', 'OFFER_BID_ID');
												   $time = time();
												   $checkDate = strtotime($available);
												   
												   if($uProperty->OFFER_STATUS == 'Active'){
													   if($checkDate >= $time){
															$status = 'Running'; 
													   }   else{
															if($get_search == 'offer'){
																//$status = 'Date Over <br/> <a href="#" class=" mar-r-3" onclick="selectReAuctionModal('.$uProperty->PROPERTY_ID.','.$uProperty->OFFER_P_ID.')" data-toggle="modal" data-target="#reAuctionModal" data-whatever="@auctionmodal" title="Add Re-Offer">Re-Offer</a>';
																$status = 'Date Over';
															}else{
																$status = 'Date Over ';
															}
													   } 
													   
												   }else if($uProperty->OFFER_STATUS == 'Pending'){
														   $status = 'Under Review';
												   }else{
														   if($uProperty->OFFER_STATUS == 'Win' AND $uProperty->WIN_USER > 0){
																   if($uProperty->WIN_USER == $this->userID){
																		   $status = 'Offer close by you';
																   }else{
																		$userInfo = $this->user->select_user_profile_by_id($uProperty->WIN_USER);
																		if(is_object($userInfo) AND sizeof($userInfo) > 0 ){
																		   $status = 'Offer close by <a href="'.SITE_URL.'agent?id='.$userInfo->USER_LOG_NAME.'" target="_blank"> '.$userInfo->USER_NAME.' </a> '; 
																		}else{
																			$status = '';
																		}
																		
																   }
														   }else{
																if($get_search == 'offer'){
																	//$status = 'Date Over <br/> <a href="#" class=" mar-r-3" onclick="selectReAuctionModal('.$uProperty->PROPERTY_ID.','.$uProperty->OFFER_P_ID.')" data-toggle="modal" data-target="#reAuctionModal" data-whatever="@auctionmodal" title="Add Re-Offer">Re-Offer</a>';
																	$status = 'Date Over';
																}else{
																	$status = 'Date Over ';
																}
														   }

												   }

												   if($get_search == 'offer'){
														$bidPri = $uProperty->BIDDING_WIN_PRICE;
														$typ = 1;
												   }else{
													   $bidPri = $uProperty->OFFER_BID_PRICE;
													   $typ = 0;
												   }


												   /*---- For Win User Action ---*/
												   $btnLink = '';
												   if ($uProperty->OFFER_STATUS == 'Win' && $uProperty->WIN_USER > 0) {
														   if ($uProperty->WIN_USER == $this->userID) {
																   $biddingCount = $CI->any_where_count(array('PROPERTY_ID' => $uProperty->PROPERTY_ID, 'USER_ID' => $uProperty->USER_ID, 'SOLICITORS_STATUS' => 'Active'), 'solicitors_details', 'SOLICITORS_DETAILS_ID');
																   if($biddingCount == 0){
																		$btnLink = '<a href="'.SITE_URL.'payment-now?id='.$this->Property_Model->encode_str($uProperty->PROPERTY_ID).'" class="btn btn-default mar-b-5" title="" >Pay Now</a><a href="#" data-toggle="modal" onclick="AddSolicitorsDetailsModal(' . $uProperty->PROPERTY_ID . ',' . $uProperty->OFFER_P_ID . ', 2)" data-target="#solicitorsModal" data-whatever="@solicitorsmodal" class="btn btn-default" title="" >Add Solicitors</a>';
																   }else{
																	   $btnLink = '<a href="'.SITE_URL.'payment-now?id='.$this->Property_Model->encode_str($uProperty->PROPERTY_ID).'" class="btn btn-default mar-b-5" title="" >Pay Now</a> <a href="#" data-toggle="modal" onclick="AddSolicitorsDetailsModalView(' . $uProperty->PROPERTY_ID . ',' . $uProperty->OFFER_P_ID . ', 2)" data-target="#solicitorsModalView" data-whatever="@solicitorsmodalView" class="btn btn-default" title="" >Solicitors</a>';
																   }

														   } else {
																 $btnLink = '==<br/>==';
														   }
												   } else {
														   $btnLink = '<a href="#" data-toggle="modal" onclick="AddOffrCounterModal(' . $uProperty->PROPERTY_ID . ',' . $uProperty->OFFER_P_ID . ', 2)" data-target="#counterModal" data-whatever="@countermodal" class="btn btn-default" title="" >Counter</a>';
												   }
											 ?>
											 <tr id="property_tr__<?= $uProperty->PROPERTY_ID; ?>">
												 <td class="center"><?= $i; ?></td>
												 <td class="">
													 <a href="<?= SITE_URL ?>preview?view=<?= $uProperty->PROPERTY_URL; ?>" target="_blank"> 
														 <img src="<?= $pImage; ?>" height="50" width="70" class="mar-l-10"> 
														 <?= substr($uProperty->PROPERTY_NAME, 0, 20); ?>.. 
													 </a>
												 </td>
												 <td class="center">  <?= number_format( $uProperty->OFFER_PRICE ) . ' ' . $uProperty->CURRENCY_CODE; ?></td>
												 <td class="center"> <?= number_format( $bidPri ) . ' ' . $uProperty->CURRENCY_CODE; ?></td>
												 <td class="center"> <?= number_format( $BIDDING_PRICE  ) . ' ' . $uProperty->CURRENCY_CODE; ?></td>
												 
												<?php if($get_search == 'offer'){ ?> <td class="center"> <!--<a href="<?= SITE_URL ?>bidding-summery?search=auction&id=<?= $uProperty->PROPERTY_ID;?>&auction=<?= $uProperty->OFFER_P_ID;?>"><b> <?= number_format($totalBidder); ?> </b> </a> -->
													   <a href="#" data-toggle="modal" onclick="selectAuctionDetailsUserModal(<?= $uProperty->PROPERTY_ID;?>,<?= $uProperty->OFFER_P_ID;?>,<?= $typ;?>);" data-target="#hotPriceModal" data-whatever="@hotPriceModal" class="bidder_a" title="View Auction Info" ><b> <?= number_format($totalBidder); ?> </b></a>
												</td> <?php }?>
												<?php if($get_search == 'bidder'){ ?> <td class="center"> <b> <?= number_format($totalBidder); ?> </b></td> <?php }?>
												 
												 <td class="center"><?= $status; ?></td>
												<?php if($get_search == 'offer'){ ?> 
												 <td class="center"> <a href="#" data-toggle="modal" onclick="selectAuctionDetailsUserModal(<?= $uProperty->PROPERTY_ID;?>,<?= $uProperty->OFFER_P_ID;?>,<?= $typ;?>);" data-target="#hotPriceModal" data-whatever="@hotPriceModal" class="view_data btn btn-default mar-r-3" title="View Bidding Info" ><b> <i class="fa fa-eye"></i> </b></a></td> <?php }?>
													<?php if ($get_search == 'bidder') { ?> <td class="center bidder-action"><?= $btnLink; ?></td> <?php } ?>
											</tr>
											<?php $i++; }
													 }else{
															echo '<tr><td class="center" colspan="8">Not Found '.ucfirst($get_search).' Property..!</td></tr>'; 
													 }
													?>
											 </tbody> 
									</table>		
							</div>		
                    </div>		
                </div> <!-- End of col-md-12 clear -->                 
            </div> <!-- End of properties-page --> 
        </div>  <!-- End of row -->            
    </div>
</div>
		
		
		
<!-- When a product call to add HOT PRICE SECTION then Show This Modal --> 
<div class="modal fade" id="hotPriceModal" role="submit Form Data" aria-labelledby="AddPropertToHotPrice" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToHotPrice"><?php if($get_search == 'offer'){ ?> Offer <?php } else{?>Bidder <?php }?> information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalBody">
                
            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 




<!-- When a product call to add HOT PRICE SECTION then Show This Modal --> 
<div class="modal fade" id="solicitorsModal" role="submit Form Data" aria-labelledby="AddSolicitors" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToHotPriceSoli"> Enter Solicitors/Settlement Agent Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalBodySolicitor">

            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 


<!-- When a product call to add HOT PRICE SECTION then Show This Modal --> 
<div class="modal fade" id="solicitorsModalView" role="submit Form Data" aria-labelledby="AddSolicitors" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToHotPriceView"> View Solicitors/Settlement Agent Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalBodySolicitorView">

            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 


<!-- When Re-Auction then Show This Modal --> 
<div class="modal fade" id="reAuctionModal" role="submit Form Data" aria-labelledby="AddPropertToAuction" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToAuction">Re-Auction Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div id="reAuctionModalBody">
                
            </div>
            
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 
  

<!-- When a product call to add HOT PRICE SECTION then Show This Modal --> 
<div class="modal fade" id="counterModal" role="submit Form Data" aria-labelledby="AddSolicitors" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToHotPriceSoli"> Counter Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalBodyCounter">

            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 

  