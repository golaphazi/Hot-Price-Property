<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle"><srtong>::</srtong> Add & Manage FAQ <srtong>::</srtong> </h4>
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
                    
                    <?= form_open_multipart('', ['id' => 'addFqaForm' , 'name' => 'addFqa'] ); ?>
                    
                    <div class="form-group">
                        <label for="FqaQuestion"><b>Question : </b></label>
                        <input name="fqa_question" id="FqaQuestion" type="text" class="form-control" placeholder="Enter New Question Here ...">
                    </div>
                    <div class="form-group">
                        <label for="FqaAnswer"><b>Answer : </b></label>
                        <textarea name="fqa_answer" id="FqaAnswer" class="form-control" rows="5" cols="50"></textarea>
                        <?php $editor['id'] = 'FqaAnswer'; $this->load->view('Next_editor/editor', $editor);?>
                    </div>
                    
                    <div class="col-md-12 marY-30">
                        <button type="submit" name="AddFQA" class="btn btn-default pull-right">Add FQA</button>
                    </div>
                    
                    <?= form_close(); ?>
                    
                </div> <!-- End of hpp_wpapper_table --> 
            </div> <!-- End of properties-page --> 
            
            <!-- Start Manage FQA -->
            <div class="col-md-9 pull-right">
                <table class="table table-striped table-bordered datatable">

                        <thead>
                            <tr>
                                <th class="center"> #SL </th>
                                <th class="center"> Question </th>
                                <th class="center"> Status </th>
                                <th class="center"> Actions </th>
                            </tr>
                        </thead> 
                        <?php 
                            if( is_array( $select_all_fqa ) && sizeof( $select_all_fqa ) ){
                                $i = 1;
                                foreach ($select_all_fqa as $fqa ):
                                ?>
                                    
                                    <tr id="property_tr">
                                        <td class="center"><?= $i; ?></td>
                                        <td class="">
                                            <a href="<?= SITE_URL ?>faq/" target="_blank"> 
                                                <?= $fqa->FQA_QUESTION; ?> 
                                            </a>
                                        </td>					 
                                        <td class="center"><?= $fqa->FQA_STATUS; ?></td>
                                        <td class="center action-col">
                                            <?php if( $fqa->FQA_STATUS == 'DeActive' ) { ?>
                                            <a href="<?= SITE_URL;?>hpp/admin/add_fqa/?action=active&fqaId=<?= $fqa->FQA_ID;?>" class="btn btn-success" title="Active FQA"><i class="glyphicon glyphicon-thumbs-up"></i></a>
                                            <?php }else{ ?>
                                            <a href="<?= SITE_URL;?>hpp/admin/add_fqa/?action=deActive&fqaId=<?= $fqa->FQA_ID;?>" class="btn btn-success" title="DeActive FQA"><i class="glyphicon glyphicon-thumbs-down"></i></a>
                                            <?php } ?>
                                            <a href="<?= SITE_URL;?>hpp/admin/add_fqa/?action=Delete&fqaId=<?= $fqa->FQA_ID;?>" class="btn btn-danger" title="Delete FQA"><i class="glyphicon glyphicon-trash"></i></a>
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