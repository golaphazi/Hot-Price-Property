<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle"><srtong>::</srtong> Add & Manage TERMS <srtong>::</srtong> </h4>
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
                    
                    <?= form_open_multipart('', ['id' => 'addTerms' , 'name' => 'addTerm'] ); ?>
                    
                    <div class="form-group">
                        <label for="termsTitle"><b>Terms Title : </b></label>
                        <input name="terms_title" id="termsTitle" type="text" class="form-control" placeholder="Enter Terms Title Here ...">
                    </div>
                    <div class="form-group">
                        <label for="TermDetails"><b>Terms Description : </b></label>
                        <textarea name="terms_details" id="TermDetails" class="form-control" rows="5" cols="50"></textarea>
                        <?php $editor['id'] = 'TermDetails'; $this->load->view('Next_editor/editor', $editor);?>
                    </div>
                    
                    <div class="col-md-12 marY-30">
                        <button type="submit" name="AddTerms" class="btn btn-default pull-right">Add Terms</button>
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
                                <th class="center"> Service Title </th>
                                <th class="center"> Status </th>
                                <th class="center"> Actions </th>
                            </tr>
                        </thead> 
                        <?php 
                            if( is_array( $select_all_terms ) && sizeof( $select_all_terms ) ){
                                $i = 1;
                                foreach ( $select_all_terms as $term ):
                                ?>
                                    
                                    <tr id="property_tr">
                                        <td class="center"><?= $i; ?></td>
                                        <td class="">
                                            <a href="<?= SITE_URL ?>terms/" target="_blank"> 
                                                <?= $term->TERMS_TITLE; ?> 
                                            </a>
                                        </td>					 
                                        <td class="center"><?= $term->TERMS_STATUS; ?></td>
                                        <td class="center action-col">
                                            <?php if( $term->TERMS_STATUS == 'DeActive' ) { ?>
                                            <a href="<?= SITE_URL;?>hpp/admin/add_terms/?action=active&TId=<?= $term->TERMS_ID;?>" class="btn btn-success" title="Active TERMS"><i class="glyphicon glyphicon-thumbs-up"></i></a>
                                            <?php }else{ ?>
                                            <a href="<?= SITE_URL;?>hpp/admin/add_terms/?action=deActive&TId=<?= $term->TERMS_ID;?>" class="btn btn-success" title="DeActive TERMS"><i class="glyphicon glyphicon-thumbs-down"></i></a>
                                            <?php } ?>
                                            <a href="<?= SITE_URL;?>hpp/admin/add_terms/?action=Delete&TId=<?= $term->TERMS_ID;?>" class="btn btn-danger" title="Delete TERMS"><i class="glyphicon glyphicon-trash"></i></a>
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