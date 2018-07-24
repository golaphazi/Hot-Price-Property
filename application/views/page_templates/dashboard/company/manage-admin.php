<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle"><srtong>::</srtong> Manage Admin User <srtong>::</srtong> </h4>
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
                            <li class="<?php if($get_search == 'all'){$nae = ''; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_admin/">All </a></li>
                            <li class="<?php if($get_search == 'Super'){$nae = 'Super'; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_admin/?search=Super">Super </a></li>
                            <li class="<?php if($get_search == 'Admin'){$nae = 'Admin'; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_admin/?search=Admin">Admin </a></li>
                            <li class="<?php if($get_search == 'Manager'){$nae = 'Manager'; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/manage_admin/?search=Manager">Manager </a></li>
                       </ul>
                    <table id="ManageAdmin" class="table table-striped table-bordered datatable">

                        <thead>
                            <tr>
                                <th class="center"> #SL </th>
                                <th class="center"> Admin Name </th>
                                <th class="center">  Admin Email </th>
                                <th class="center">  User Name </th>
                                <th class="center">  Admin Role </th>
                                <th class="center"> Status </th>
                                <th class="center"> Actions </th>
                            </tr>
                        </thead> 
                        <?php 
                            if( is_array( $select_admin_user ) && sizeof( $select_admin_user) ):
                                $i = 1;
                                foreach ($select_admin_user as $user ): 
                        ?>
                                    <tr id="property_tr">
                                        <td class="center"><?= $i; ?></td>
                                        <td class="center"><?= $user->ADMIN_NAME; ?></td>
                                        <td class="center"><?= $user->ADMIN_EMAIL; ?></td>					 
                                        <td class="center"><?= $user->ADMIN_USER; ?></td>					 
                                        <td class="center"><?= $user->ADMIN_TYPE; ?></td>					 
                                        <td class="center"><?= $user->ADMIN_STATUS; ?></td>
                                        <td class="center action-col actionCol">
                                          <?php  if($user->ADMIN_TYPE != 'Super'){ ?>
                                            <?php if( $user->ADMIN_STATUS == 'DeActive' ) { ?>
                                                    <a href="<?= SITE_URL?>hpp/admin/active_usser_admin_by_id/<?= $user->ADMIN_ID; ?>" title="Active User" class="btn btn-success glyphicon glyphicon-thumbs-up"></a>
                                                
                                            <?php }else{ ?>
                                                <a href="<?= SITE_URL?>hpp/admin/deactive_usser_admin_by_id/<?= $user->ADMIN_ID; ?>" title="DeActive User" class="btn btn-success"><i class="glyphicon glyphicon-thumbs-down"></i></a>
                                          <?php } }?>
                                                <a data-toggle="modal" onclick="adminProfileModal(<?= $user->ADMIN_ID; ?>);" data-target="#adminProfileModal" data-whatever="@adminprofileModal" class="view_data btn btn-default" title="View User Profile"><i class="glyphicon glyphicon-eye-open"></i></a>     
                                                <a data-toggle="modal" onclick="adminEditProfileModal(<?= $user->ADMIN_ID; ?>);" data-target="#adminEditProfileModal" data-whatever="@adminEditprofileModal" class="btn btn-info" title="Edit Profile"><i class="glyphicon glyphicon-edit"></i></a>     
                                            
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


<!-- When view Admin User Profile then Show This Modal --> 
<div class="modal fade" id="adminProfileModal" role="submit Form Data" aria-labelledby="adminprofileModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToHotPrice">User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="adminProfileModalBody">
                
            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 

<!-- When Edit Admin User Profile then Show This Modal --> 
<div class="modal fade" id="adminEditProfileModal" role="submit Form Data" aria-labelledby="adminEditprofileModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToHotPrice">Edit User Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="adminEditProfileModalBody">
                
            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal --> 