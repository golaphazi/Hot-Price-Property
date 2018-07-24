<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle"><srtong>::</srtong> Manage HPP Users <srtong>::</srtong> </h4>
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
                </div> <!-- End of row-->

                <div class="hpp_wpapper_table">
                    <?php
                        $get_search = isset($_GET['search']) ? $_GET['search'] : 'all';
                       ?>
                        <ul>
                            <li class="<?php if($get_search == 'all'){$nae = ''; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_hpp_user/">All </a></li>
                            <li class="<?php if($get_search == 'Pending'){$nae = 'Pending'; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_hpp_user/?search=Pending">Pending </a></li>
                            <li class="<?php if($get_search == 'Active'){$nae = 'Active'; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_hpp_user/?search=Active">Active </a></li>
                            <li class="<?php if($get_search == 'DeActive'){$nae = 'DeActive'; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_hpp_user/?search=DeActive">De-Active </a></li>
                            <li class="<?php if($get_search == 'Verified'){$nae = 'Verified'; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_hpp_user/?search=Verified">Verified </a></li>
                            <li class="<?php if($get_search == 'Not_Verified'){$nae = 'Not Verified'; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_hpp_user/?search=Not_Verified">Not Verified </a></li>
                       </ul>
                    <table id="ManageUser" class="table table-striped table-bordered datatable manage-user">

                        <thead>
                            <tr>
                                <th class="center"> #SL </th>
                                <th class="center"> User Name </th>
                                <th class="center"> User Email </th>
                                <th class="center"> User Role </th>
                                <th class="center"> User Type </th>
                                <th class="center"> Status </th>
                                <th class="center"> Actions </th>
                            </tr>
                        </thead> 
                        <?php 
                            if( is_array( $select_hpp_user ) && sizeof( $select_hpp_user) ):
                                $i = 1;
                                foreach ($select_hpp_user as $user ): 
                        ?>
                                    <tr id="property_tr">
                                        <td class="center"><?= $i; ?></td>
                                        <td class=""><?= $user->USER_NAME; ?></td>
                                        <td class=""><?= $user->EMAIL_ADDRESS; ?></td>					 
                                        <td class=""><?= $user->ROLE_NAME; ?></td>					 
                                        <td class="center"><?= $user->TYPE_NAME; ?></td>					 
                                        <td class="center"><?= $user->USER_STATUS; ?></td>
                                        <td class="center action-col actionCol">
                                            <?php if($user->USER_STATUS == 'Active' AND $user->VERIFY_STATUS == 'Not Verified' AND strlen($user->DOCUMENT_UPLOAD) > 5) { ?>
												 <a href="<?= SITE_URL?>hpp/admin/varify_hpp_usser_by_id/<?= $user->USER_ID; ?>" title="Verify User" class="btn btn-danger glyphicon glyphicon-ok"></a>  
											<?php } ?>
											<?php if( $user->USER_STATUS == 'Pending' OR $user->USER_STATUS == 'DeActive' ) { ?>
												<a href="<?= SITE_URL?>hpp/admin/active_hpp_usser_by_id/<?= $user->USER_ID; ?>" title="Active User" class="btn btn-success glyphicon glyphicon-thumbs-up"></a>   
                                            
                                            <?php }else{ ?>
                                                <a href="<?= SITE_URL?>hpp/admin/deactive_hpp_usser_by_id/<?= $user->USER_ID; ?>" title="DeActive User" class="btn btn-success"><i class="glyphicon glyphicon-thumbs-down"></i></a>
                                           <?php } ?>
                                            <a data-toggle="modal" onclick="userProfileModal(<?= $user->USER_ID; ?>);" data-target="#userProfileModal" data-whatever="@userprofileModal" class=" btn btn-info" title="View User Profile"><i class="glyphicon glyphicon-eye-open"></i></a> 
                                            <a href="<?= SITE_URL?>hpp/admin/delete_hpp_usser_by_id/<?= $user->USER_ID; ?>" onclick="return confirmDeleteAction();" class="btn btn-danger" title="Delete User"><i class="glyphicon glyphicon-trash"></i></a>     
                                            <a href="<?= SITE_URL?>hpp/admin/email_inbox?search=compose&email=<?= $user->EMAIL_ADDRESS; ?>" class="btn btn-send" title="Send Mail"><i class="glyphicon glyphicon-send"></i></a>     
                                            
                                        </td>
                                    </tr>
                        <?php 
                                    $i++;
                                endforeach;
                            endif;
                        ?>
                    </table> 

                </div> <!-- End of hpp_wpapper_table --> 
            </div> <!-- End of properties-page --> 
        </div>  <!-- End of row -->            
    </div>
</div>


<!-- When view Hpp User Profile then Show This Modal --> 
<div class="modal fade" id="userProfileModal" role="submit Form Data" aria-labelledby="userprofileModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title hppModalTitle" id="AddPropertToHotPrice">Hpp User Details</h5>
            </div>
            <div id="userProfileModalBody">
                
            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 