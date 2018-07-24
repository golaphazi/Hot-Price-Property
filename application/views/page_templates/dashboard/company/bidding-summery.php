<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle"><srtong>::</srtong> Bidding Summery - Win<srtong>::</srtong> </h4>
                <div class="row">
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
                </div>  <!-- End of row -->

                <div class="hpp_wpapper_table">
                    
                    <table id="ManageAdmin" class="table table-striped table-bordered datatable">

                        <thead>
                            <tr>
                                <th class="center"> #SL </th>
                                <th class="center"> Property Name </th>
                                <th class="center"> Bid Start Price </th>
                                <th class="center"> Bid Win Price </th>
                                <th class="center"> Last Bid Price </th>
                                <th class="center"> Total Bidder </th>
                                <th class="center"> Status </th>
                                <th class="center"> Auction </th>
                            </tr>
                        </thead> 
                        <?php 
                            if( is_array( $select_auction_info ) && sizeof( $select_auction_info ) ){
                                $i = 1;
                                foreach ( $select_auction_info as $auction ): 
                                    $pImage = SITE_URL . $auction->IMAGE_LINK . $auction->IMAGE_NAME;
                                
                                    $totalBidder = 0;
                                    $BIDDING_PRICE = $auction->OFFER_PRICE;
                                    $offr_bid = $this->db->query("SELECT OFFER_BID_PRICE FROM p_property_offers_bidding WHERE PROPERTY_ID = " . $auction->PROPERTY_ID . " AND OFFER_P_ID = " . $auction->OFFER_P_ID . " AND OFFER_BID_STATUS = 'Active' ORDER BY OFFER_BID_ID DESC LIMIT 0,1");
                                    $offr_bid_val = $offr_bid->result_array();
                                    if (is_array($offr_bid_val) AND sizeof($offr_bid_val) > 0) {
                                        $BIDDING_PRICE = $offr_bid_val[0]['OFFER_BID_PRICE'];
                                    }
                                    $totalBidder = $this->Property_Model->any_type_where(array('PROPERTY_ID' => $auction->PROPERTY_ID, 'OFFER_P_ID' => $auction->OFFER_P_ID, 'OFFER_BID_STATUS' => 'Active'), 'p_property_offers_bidding', 'COUNT', 'OFFER_BID_ID');
                                    /* ---- For Win User Action --- */
                                    $btnLink = '';
                                    //echo $auction->WIN_USER;
                                    $userInfo = $this->user->select_user_profile_by_id($auction->WIN_USER);
                                   // print_r($userInfo);
                                    if(is_object($userInfo) AND sizeof($userInfo) > 0 ){
                                        $status = 'Win by <a href="'.SITE_URL.'agent?id='.$userInfo->USER_LOG_NAME.'" target="_blank"> '.$userInfo->USER_NAME.' </a> ';
                                    }else{
                                       $status = ''; 
                                    }
                                ?>
                                    <tr id="property_tr">
                                        <td class="center"><?php echo $i; ?></td>
                                        <td class="">
                                            <a href="<?= SITE_URL ?>preview?view=<?= $auction->PROPERTY_URL; ?>" target="_blank"> 
                                                <img src="<?= $pImage; ?>" height="30" width="50" class="mar-l-10"> 
                                                <?= $CI->trim_text($auction->PROPERTY_NAME, 12); ?> 
                                            </a></td>
                                        <td class="center"><?php echo number_format($auction->OFFER_PRICE); ?> <?= $auction->CURRENCY_CODE;?></td>					 
                                        <td class="center"><?= number_format( $auction->BIDDING_WIN_PRICE ); ?> <?= $auction->CURRENCY_CODE;?></td>					 
                                        <td class="center"> <?= number_format( $BIDDING_PRICE ); ?> <?= $auction->CURRENCY_CODE;?></td>					 
                                        <td class="center"><?= number_format($totalBidder); ?></td>
                                        <td class="center"><?php echo $status; ?></td>
                                        <td class="center action-col">    
                                            <a href="#" data-toggle="modal" onclick="adminAuctionDetailsUserModal(<?= $auction->PROPERTY_ID;?>,<?= $auction->OFFER_P_ID;?>);" data-target="#adminAuctionModal" data-whatever="@adminAuctionModal" class="view_data btn btn-default mar-r-3" title="View Bidding Info" ><b> <i class="fa fa-eye"></i> </b></a>
                                        </td>
                                    </tr>
                        <?php 
                                endforeach;
                            }else{
                                echo '<tr><td class="center" colspan="8">Not Found Bidder Property..!</td></tr>'; 
                            }
                        ?>
                    </table> 

                </div>  <!-- End of hpp_wpapper_table --> 
            </div>  <!-- End of properties-page --> 
        </div>   <!--End of row -->           
    </div>
</div>


<!-- When a product call to add HOT PRICE SECTION then Show This Modal --> 
<div class="modal fade" id="adminAuctionModal" role="submit Form Data" aria-labelledby="adminauctionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToHotPrice">Bidder information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="adminAuctionModalBody">
                
            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 
	


