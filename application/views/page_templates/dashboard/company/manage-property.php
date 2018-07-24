<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container"> 
        
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 properties-page"> 
                 <?php
                    $get_search = isset($_GET['search']) ? $_GET['search'] : 'all';
                    $get_type = isset($_GET['type']) ? $_GET['type'] : 'pending';
                    $col = 5;
                    
                    /*---- Set Property Manage Action --*/
                    $approvedAction = '';
                    $rejectdAction  = '';
                   ?>
                <h4 class="center sectionTitle"><srtong>::</srtong>  Manage <?= ucfirst($get_search);?> Property <srtong>::</srtong> </h4>
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
                    <div class="col-xs-12">
                        <div id="massage" >
                        </div>    
                    </div> <!-- End of col-xs-12 -->
                </div> <!-- End of row-->

                <div class="hpp_wpapper_table">
                   
                        <ul>
                            <li class="<?php if($get_type == 'all'){$nae = ''; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_property/?search=<?= $get_search;?>&type=all">All </a></li>
                            <li class="<?php if($get_type == 'pending'){$nae = ''; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_property/?search=<?= $get_search;?>&type=pending">Pending </a></li>
                            <li class="<?php if($get_type == 'active'){$nae = ''; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_property/?search=<?= $get_search;?>&type=active">Approved </a></li>
                            <li class="<?php if($get_type == 'reject'){$nae = ''; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_property/?search=<?= $get_search;?>&type=reject">Reject </a></li>
                          
                            <?php if($get_search == 'sell'){  $col = 7; ?>
                            <li class="<?php if($get_type == 'buy'){$nae = 'Buy';  echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_property?search=<?= $get_search;?>&type=buy" >Buy </a></li>
                            <?php }else if($get_search == 'hot'){ $col = 7; ?>
                            <li class="<?php if($get_type == 'hot_sell'){$nae = 'Hot';  echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_property?search=<?= $get_search;?>&type=hot_sell" > Hot Sell </a></li>
                            <?php }else if($get_search == 'auction'){ $col = 7; ?>
                            <li class="<?php if($get_type == 'win'){$nae = 'Win';  echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_property?search=<?= $get_search;?>&type=win" >Win </a></li>
                            <?php }else if($get_search == 'rent'){ $col = 7; ?>
                            <li class="<?php if($get_type == 'rented'){$nae = 'Rented';  echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_property?search=<?= $get_search;?>&type=rented" >Rented </a></li>
                            <?php } ?>
                        </ul>
                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="center"> #SL </th>
                                <th class="left"> Property Name </th>
                                <th class="right">  Price </th>
                                <?php if($get_type == 'buy' OR $get_type == 'win' OR $get_type == 'hot_sell' OR $get_type == 'rented'){?>
                                 <th class="right"> <?= $nae;?> Price </th>
                                 <th class="center"> Buyer </th>
                                <?php }
                                    if( $get_search == 'auction' OR $get_search == 'hot' ){ 
                                        echo '<th class="center">Offer Period</th>';
                                    }else { 
                                        echo '<th class="center">Date</th>';
                                    }
                                ?>
                                <th class="center"> Status </th>
                                <th class="center"> Actions </th>
                            </tr>
                        </thead> 
                        <tbody> 
                        <?php 
                            if( is_array( $select_property ) && sizeof( $select_property) > 0){
                                $i = 1;
                                foreach ($select_property as $property ):
                                    $pImage = SITE_URL . $property->IMAGE_LINK . $property->IMAGE_NAME; 
                                    if ( $get_search == 'hot' OR $get_search == 'auction' ) {
                                        $approvedAction = 'active_offer_property_by_id(' . $property->PROPERTY_ID . ')';
                                        $rejectdAction  = 'reject_offer_property_by_id(' . $property->PROPERTY_ID . ')';
                                    } else {
                                        $approvedAction = 'active_property_by_id(' . $property->PROPERTY_ID . ')';
                                        $rejectdAction  = 'reject_property_by_id(' . $property->PROPERTY_ID . ')';
                                    }
                                    ?>
<!--                                    <tr>
                                        <td colspan="<?= $col; ?>" class="selectUser"> <?= $property->USER_NAME; ?> : </td>
                                    </tr>
                                    -->
                                    <tr id="property_tr__<?= $property->PROPERTY_ID; ?>">
                                        <td class="center"><?= $i; ?></td>
                                        <td class="">
                                            <a href="<?= SITE_URL ?>hpp/admin/approved?view=<?= $property->PROPERTY_URL; ?>" target="_blank"> 
                                                <img src="<?= $pImage; ?>" height="50" width="70" class="mar-l-10">
                                                <span><?= $CI->trim_text( $property->PROPERTY_NAME, 60 ); ?> </span>
                                            </a>
                                        </td>
                                        <td class="right" > 
                                            <?php                                             
                                            /*---- Set Property Price --*/
                                            if( $get_search == 'hot'){
                                                echo  number_format($property->OFFER_PRICE); 
                                            }else if( $get_search == 'auction'){
                                                echo  number_format($property->BIDDING_WIN_PRICE); 
                                            }else{
                                                echo  number_format($property->PROPERTY_PRICE); 
                                            }
                                                
                                            ?>
											<?= $property->CURRENCY_CODE;?>
                                        </td>
                                        <?php
                                            if($get_search == 'auction' OR $get_search == 'hot' ){
                                                $startDate = !empty( date("d M Y", strtotime($property->OFFER_START_DATE ) ) ) ? date("d M Y", strtotime($property->OFFER_START_DATE) ) : '';
                                                $endDate = !empty( date("d M Y", strtotime($property->OFFER_END_DATE ) ) ) ? date("d M Y", strtotime($property->OFFER_END_DATE) ) : '';
                                                echo '<td class="center">'.$startDate . ' to ' . $endDate .'</td>'; 
                                            }else {
                                                echo '<td class="center">'.date("d M Y",  strtotime($property->ENT_DATE)).'</td>';
                                            }
                                        ?>
                                        
                                        <?php 
                                        if($get_type == 'buy' OR $get_type == 'win'  OR $get_type == 'hot_sell'){
                                            $getUser = $CI->any_where( array( 'USER_ID' => $property->SELL_USER ), 's_user_info', 'USER_NAME' );
                                        ?>
                                       <td class="right" >$ <?= number_format($property->SELL_PRICE); ?></td>
                                       <td class="center">  <?= $getUser; ?></td>
                                       <?php }?>
                                        <td class="center"> 
                                       <?php 
                                         if($get_search == 'auction' OR $get_search == 'hot'){
                                            echo $property->OFFER_STATUS;
                                            $status = $property->OFFER_STATUS;
                                         } else {
                                             echo $property->PROPERTY_STATUS;
                                              $status = $property->PROPERTY_STATUS;
                                         } 
                                         ?>
                                      
                                        <td class="center action-col" style="min-width: 150px;">
                                            <?php if( $status == 'Pending' OR $status == 'Reject' OR $status == 'Delete' ) { ?>
                                                 <a  onclick="<?= $approvedAction; ?>" class="btn btn-success" title="Approved Property"><i class="glyphicon glyphicon-ok"></i></a>
                                                <?php  if($status == 'Pending'){?>
                                                <a  onclick="<?= $rejectdAction; ?>" class="btn btn-danger" title="Reject Property"><i class="glyphicon glyphicon-remove"></i></a>
                                                <?php }?>
                                             <?php }else if($status == 'Active' ){ ?>
                                                <a  onclick="<?= $rejectdAction; ?>" class="btn btn-danger" title="Reject Property"><i class="glyphicon glyphicon-remove"></i></a>
                                            <?php }?>
                                            <!--<a href="<?= SITE_URL ?>hpp/admin/approved?view=<?= $property->PROPERTY_URL; ?>" class="btn btn-info" title="View Property"><i class="glyphicon glyphicon-eye-open"></i></a> -->
                                            <?php 
                                            if($get_search == 'hot'){ ?>
                                            <a href="#" onclick="selectHotPriceModal(<?= $property->PROPERTY_ID; ?>,'admin')" data-toggle="modal" data-target="#hotPriceModal" data-whatever="@hotPriceModal"  class="view_data btn btn-default mar-r-3" title="View Hot Price Info" ><i class="glyphicon glyphicon-fire"></i></a>
                                           <?php }?>
                                            <?php 
                                            if($get_search == 'auction'){ ?>
                                            <a href="#" class="btn btn-primary mar-r-3" onclick="selectAuctionModal(<?= $property->PROPERTY_ID; ?>,'admin')" data-toggle="modal" data-target="#auctionModal" data-whatever="@auctionmodal" title="View Auction Info"><i class="glyphicon glyphicon-adjust"></i></a>
                                           <?php }?>
                                            <?php if( $status != 'Win' ) { ?>
                                            <a href="#" onclick="checkDeleteAdmin(<?= $property->PROPERTY_ID; ?>,'<?= $get_search; ?>');" class="btn btn-danger" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                                            <?php } ?>
                                         </td>
                                    </tr>
                                    
                                <?php $i++;
                                endforeach;
                            }else{
                                echo '<tr><td class="center" colspan="'.$col.'" style="color:red;">No Property Found..!</td></tr>';
                            }
                        ?>
                        </tbody> 
                    </table> 

                </div> <!-- End of hpp_wpapper_table --> 
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

