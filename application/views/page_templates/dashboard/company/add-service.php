<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle">
                    <srtong>::</srtong>
                        <?php 
                        $action = $this->input->get('action');
                            if($action == 'Edit'){ echo 'Edit Service Content'; }else{ echo 'Add & Manage Service'; } 
                        ?>
                    <srtong>::</srtong> </h4>
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
                    $action = $this->input->get('action');
                    $SID = $this->input->get('SId');
                    if( $action == 'Edit' ) { ?>
                    
                    <?= form_open_multipart('hpp/admin/add_services/?action=Edit&SId='.$SID, ['id' => 'EditSrvice' , 'name' => 'editService'] ); ?>
                    
                    <div class="form-group">
                        <label for="serviceTitle"><b>Service Title : </b></label>
                        <input name="service_title" id="serviceTitle" type="text" class="form-control" value="<?= $select_service->SERVICE_TITLE;?>">
                    </div>
                    <div class="form-group">
                        <label for="serviceShortDesc"><b>Service Description : </b></label>
                        <textarea name="service_short_desc" id="serviceShortDesc" class="form-control" rows="5" cols="50"><?= $select_service->SERVICE_SHORT_DESC;?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="serviceDetails"><b>Service Description : </b></label>
                        <textarea name="service_details" id="serviceDetails" class="form-control" rows="5" cols="50"><?= $select_service->SERVICE_DETAILS;?></textarea>
                        <?php $editor['id'] = 'serviceDetails'; $this->load->view('Next_editor/editor', $editor);?>
                    </div>
                    
                    <div class="col-md-12 marY-30">
                        <button type="submit" name="UpdateService" class="btn btn-default pull-right">Update Service</button>
                    </div>
                    
                    <?= form_close(); ?>
                    
                    <?php } else{ ?>
                        <?= form_open_multipart('', ['id' => 'addSrvice' , 'name' => 'addService'] ); ?>
                    
                    <div class="form-group">
                        <label for="serviceTitle"><b> Service Title : </b></label>
                        <input name="service_title" id="serviceTitle" type="text" class="form-control" placeholder="Enter Terms Title Here ...">
                    </div>
                    <div class="form-group">
                        <label for="serviceShortDesc"><b>Service Description : </b></label>
                        <textarea name="service_short_desc" id="serviceShortDesc" class="form-control" rows="5" cols="50"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="serviceDetails"><b>Service Description : </b></label>
                        <textarea name="service_details" id="serviceDetails" class="form-control" rows="5" cols="50"></textarea>
                        <?php $editor['id'] = 'serviceDetails'; $this->load->view('Next_editor/editor', $editor);?>
                    </div>
                    
                    <div class="col-md-12 marY-30">
                        <button type="submit" name="AddService" class="btn btn-default pull-right">Add Service</button>
                    </div>
                    
                    <?= form_close(); ?>
                  <?php  } ?>
                    
                </div> <!-- End of hpp_wpapper_table --> 
                
            </div> <!-- End of properties-page --> 
            
            <!-- Start Manage FQA -->
            <div class="col-md-9 pull-right">
                <table class="table table-striped table-bordered datatable">

                        <thead>
                            <tr>
                                <th class="center"> #SL </th>
                                <th class="center"> Service Title </th>
                                <th class="center"> Service Short Desc </th>
                                <th class="center"> Status </th>
                                <th class="center"> Actions </th>
                            </tr>
                        </thead> 
                        <?php 
                            if( is_array( $select_all_service ) && sizeof( $select_all_service ) ){
                                $i = 1;
                                foreach ( $select_all_service as $service ):
                                ?>
                                    
                                    <tr id="property_tr">
                                        <td class="center"><?= $i; ?></td>
                                        <td class="">
                                            <a href="<?= SITE_URL ?>service/" target="_blank"> 
                                                <?= $service->SERVICE_TITLE; ?> 
                                            </a>
                                        </td>					 
                                        <td class="center"><?= $CI->trim_text( $service->SERVICE_SHORT_DESC, 30 ); ?></td>
                                        <td class="center"><?= $service->SERVICE_STATUS; ?></td>
                                        <td class="center action-col">
                                            <?php if( $service->SERVICE_STATUS == 'DeActive' ) { ?>
                                            <a href="<?= SITE_URL;?>hpp/admin/add_services/?action=active&SId=<?= $service->SERVICE_ID;?>" class="btn btn-success" title="Active Service"><i class="glyphicon glyphicon-thumbs-up"></i></a>
                                            <?php }else{ ?>
                                            <a href="<?= SITE_URL;?>hpp/admin/add_services/?action=deActive&SId=<?= $service->SERVICE_ID;?>" class="btn btn-success" title="DeActive Service"><i class="glyphicon glyphicon-thumbs-down"></i></a>
                                            <?php } ?>
                                            <a href="<?= SITE_URL;?>hpp/admin/add_services/?action=Edit&SId=<?= $service->SERVICE_ID;?>" class="btn btn-info" title="Edit Service"><i class="glyphicon glyphicon-edit"></i></a>
                                            <a href="<?= SITE_URL;?>hpp/admin/add_services/?action=Delete&SId=<?= $service->SERVICE_ID;?>" class="btn btn-danger" title="Delete Service"><i class="glyphicon glyphicon-trash"></i></a>
                                        </td>
                                    </tr>
                                    
                                <?php $i++;
                                endforeach;
                            }else {
                                echo '<tr id="property_tr"><td class="center" colspan="4"><span style="color:red;">No Recourds Found..!</span> </td></tr>';
                            }
                        ?>
                    </table>
            </div>
        </div>  <!-- End of row -->            
    </div>
</div>