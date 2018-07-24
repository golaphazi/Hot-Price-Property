
    <div class="page-head"> 
        <div class="container">
            <div class="row">
                <div class="page-head-content">
                    <h1 class="page-title">Welcome <span class="orange strong"><?= $userName;?></span></h1>               
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
                        <h4 class="center sectionTitle"><srtong>::</srtong> Property Manage Content <srtong>::</srtong> </h4>
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="actioMessage" >
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
                                </div>    
                            </div> <!-- End of col-xs-12 -->
                        </div> <!-- End of row-->

                        <div class="hpp_wpapper_table">
                            <?php
                            $get_search = isset($_GET['search']) ? $_GET['search'] : 'all';
                            ?>
                            <ul>
                                <li class="<?php if($get_search == 'all'){$nae = ''; echo 'active';}?>" ><a href="<?= SITE_URL ?>manage-property/">All </a></li>
                                <li class="<?php if($get_search == 'sell'){$nae = '';  echo 'active';}?>" ><a href="<?= SITE_URL ?>manage-property?search=sell" >Sell </a></li>
                                <li class="<?php if($get_search == 'rent'){$nae = 'Rent';  echo 'active';}?>" ><a href="<?= SITE_URL ?>manage-property?search=rent" >Rent </a></li>
                                <li class="<?php if($get_search == 'auction'){$nae = 'Auction';  echo 'active';}?>" ><a href="<?= SITE_URL ?>manage-property?search=auction" >Auction </a></li>
                                <li class="<?php if($get_search == 'hot'){$nae = 'Hot';  echo 'active';}?>" ><a href="<?= SITE_URL ?>manage-property?search=hot" >Hot </a></li>
                           </ul>
						   <div style="clear:both;"> </div>
                            <div class="table-responsive">
								<table class="table table-striped table-bordered datatable">

									 <thead>
										 <tr>
											 <th class="center"> #SL </th>
											 <th class="left"> <?= $nae; ?> Property Name </th>

											 <th class="right"> <?= $nae; ?>  Price </th>
											 <?php if($get_search == 'auction'){ ?>
												   <th class="right"> Bid  Price </th>
											<?php } ?>
											<?php if($get_search == 'hot'){ ?>
												   <th class="right"> Offer Price </th>
											<?php } ?>
											<?php       
												if( $get_search == 'auction' OR $get_search == 'hot' ){
													echo '<th class="center">Offer Period</th>';
												}else {
													echo '<th class="center">Date</th>';
												} ?>
											<th class="right"> Sell Price </th>

											 <th class="center"><?= $nae; ?> Status </th>
											 <th class="center"> Actions </th>
										 </tr>
									 </thead> 

									 <?php 
										 $i = 1;
										 if(is_array($select_property_by_user) AND sizeof($select_property_by_user) > 0){
											foreach ( $select_property_by_user as $uProperty ) {
											 $pImage = SITE_URL . $uProperty->IMAGE_LINK . $uProperty->IMAGE_NAME;
										 ?>
										 <tr id="property_tr__<?= $uProperty->PROPERTY_ID; ?>">
											 <td class="center"><?= $i; ?></td>
											 <td class="">
												 <a href="<?= SITE_URL ?>preview?view=<?= $uProperty->PROPERTY_URL; ?>" target="_blank"> 
													 <img src="<?= $pImage; ?>" height="50" width="70" class="mar-l-10"> 
													 <?= substr($uProperty->PROPERTY_NAME, 0, 20); ?>.. 
												 </a>
											 </td>
											 <td class="right"> <?= number_format( $uProperty->PROPERTY_PRICE ) . ' ' .$uProperty->CURRENCY_CODE; ?></td>
												<?php
													 if($get_search == 'auction' OR $get_search == 'hot'){
												?>
												 <td class="right"> <?= number_format( $uProperty->OFFER_PRICE ); ?> <?= $uProperty->CURRENCY_CODE;?></td>
												<?php } ?>
												 <?php 
													if($get_search == 'auction' OR $get_search == 'hot' ){
														$startDate = !empty( date("d M Y", strtotime($uProperty->OFFER_START_DATE ) ) ) ? date("d M Y", strtotime($uProperty->OFFER_START_DATE) ) : '';
														$endDate = !empty( date("d M Y", strtotime($uProperty->OFFER_END_DATE ) ) ) ? date("d M Y", strtotime($uProperty->OFFER_END_DATE) ) : '';
														echo '<td class="center">'.$startDate . ' to ' . $endDate .'</td>'; 
													}else {
														echo '<td class="center">'.date("d M Y",  strtotime($uProperty->ENT_DATE)).'</td>';
													}
												?>
												<td class="right"> <b> <?= number_format( $uProperty->SELL_PRICE ) . ' ' .$uProperty->CURRENCY_CODE; ?> </b></td>
												
											 <td class="center">
												 <?php 
												 if($get_search == 'auction' OR $get_search == 'hot'){
													echo $uProperty->OFFER_STATUS;
													$status = $uProperty->OFFER_STATUS;
												 } else {
													 echo $uProperty->PROPERTY_STATUS;
													  $status = $uProperty->PROPERTY_STATUS;
												 } 
												 ?>
											 </td>

											 <td class="center action-col" style="min-width: 150px;">

												 <?php 
													/*
													 * Controll Property Action..
													 */
													//$HAdisable = ( $uProperty->PROPERTY_STATUS == 'Pending' ) ? 'disabled style="color:#797373;"' : '';
													$HAdisable = '';
													$Edisable = 'href="'.SITE_URL . 'manage-property?edit=' .$uProperty->PROPERTY_ID.'"';
													 ?>
												 <a href="<?= SITE_URL ?>preview?view=<?= $uProperty->PROPERTY_URL; ?>" class="btn btn-info" target="_blank" title="View"><i class="glyphicon glyphicon-eye-open"></i></a>

													<?php if( $uProperty->PROPERTY_STATUS == 'Active' ){
															if( ($uProperty->HOT_PRICE_PROPERTY == 'Yes' OR $uProperty->HOT_PRICE_PROPERTY == 'No')  AND $uProperty->PROPERTY_AUCTION == 'No' ){ ?>
																 <a href="#" onclick="selectHotPriceModal(<?= $uProperty->PROPERTY_ID; ?>)" data-toggle="modal" data-target="#hotPriceModal" data-whatever="@hotPriceModal"  class="view_data btn btn-default mar-r-3" title="Add To Hot Price Property" ><i class="glyphicon glyphicon-fire"></i></a>                                                           
															<?php } 
																if( ($uProperty->PROPERTY_AUCTION == 'Yes' OR $uProperty->PROPERTY_AUCTION == 'No' ) AND $uProperty->HOT_PRICE_PROPERTY == 'No' ){
															?>     
															   <a href="#" class="btn btn-primary mar-r-3" onclick="selectAuctionModal(<?= $uProperty->PROPERTY_ID; ?>)" data-toggle="modal" data-target="#auctionModal" data-whatever="@auctionmodal" title="Add To Auction"><i class="glyphicon glyphicon-adjust"></i></a>
															<?php } ?>

													<?php } ?>
													<?php if($uProperty->PROPERTY_STATUS == 'Pending' OR $uProperty->PROPERTY_STATUS == 'Reject'){?>
													<a <?= $Edisable; ?> class="btn btn-info mar-r-3" title="Edit"><i class="glyphicon glyphicon-edit"></i></a>
													<?php } ?>
													 <?php if( $uProperty->PROPERTY_STATUS != 'Sell'){ ?>
													<a href="#" onclick="checkDelete(<?= $uProperty->PROPERTY_ID; ?>,'<?= $get_search; ?>');" class="btn btn-danger" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
													 <?php } ?>      
											</td>
										 </tr>
									 <?php $i++; }
										}else{
											   echo '<tr><td class="center" colspan="8">No Found Property</td></tr>'; 
										}
									   ?>
								 </table> 
                             </div> 

                         </div> <!-- End of hpp_wpapper_table -->

                    </div>                   
                </div> <!-- End of properties-page --> 
            </div>  <!-- End of row -->            
        </div>
    </div>


<!-- When a product call to add HOT PRICE SECTION then Show This Modal --> 
<div class="modal fade" id="hotPriceModal" role="submit Form Data" aria-labelledby="AddPropertToHotPrice" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToHotPrice">Hot Price Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalBody">
                
            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 



<!-- When a product call to add For Auction then Show This Modal --> 
<div class="modal fade" id="auctionModal" role="submit Form Data" aria-labelledby="AddPropertToAuction" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToAuction">Auction Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div id="AuctionModalBody">
                
            </div>
            
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 
