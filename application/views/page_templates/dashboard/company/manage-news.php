<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle"><srtong>::</srtong> Manage News <srtong>::</srtong> </h4>
                <div class="row">
                    <div id="massage" class="col-xs-12">
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
                    <table id="ManageAdmin" class="table table-striped table-bordered datatable">
                        
                        <thead>
                            <tr>
                                <th class="center"> #SL </th>
                                <th class="center"> News Title </th>
                                <th class="center"> Status </th>
                                <th class="center"> Actions </th>
                            </tr>
                        </thead> 
                        <?php 
                            if( is_array( $select_news ) && sizeof( $select_news ) ):
                                $i = 1;
                                foreach ( $select_news as $news ): 
                                    $newsImage = SITE_URL.$news->NEWS_IMAGE;
                        ?>
                                    <tr id="property_tr">
                                        <td class="center"><?= $i; ?></td>
                                        <td class="">
                                            <a href="<?= SITE_URL ?>hpp/admin/news_preview?blog=<?= $news->NEWS_URL; ?>" > 
                                                <img src="<?= $newsImage; ?>" height="50" width="70" class="mar-l-10">
                                                <span> <?= $CI->trim_text( $news->NEWS_HEADDING, 80 ); ?> </span>
                                            </a>
                                        </td>					 
                                        <td class="center"><?= $news->NEWS_STATUS; ?></td>
                                        <td class="center action-col actionCol">
                                            <?php if( $news->NEWS_STATUS == 'Pending' ) { ?>
                                            <a href="<?= SITE_URL?>hpp/admin/active_news_by_id/<?= $news->NEWS_ID; ?>" title="Active News" class="btn btn-success glyphicon glyphicon-thumbs-up"></a>
                                            <?php }else{ ?>
                                                <a href="<?= SITE_URL?>hpp/admin/deactive_news_by_id/<?= $news->NEWS_ID; ?>" title="DeActive User" class="btn btn-success"><i class="glyphicon glyphicon-thumbs-down"></i></a>
                                           <?php } ?>
                                                <a href="<?= SITE_URL ?>news_preview?blog=<?= $news->NEWS_URL; ?>" class="view_data btn btn-default" title="View News Details" target="_blank"><i class="glyphicon glyphicon-eye-open"></i></a>     
                                                <a href="<?= SITE_URL ?>hpp/admin/edit_news/<?= $news->NEWS_ID; ?>" class="btn btn-info" title="Edit News"><i class="glyphicon glyphicon-edit"></i></a>     
                                                <a href="<?= SITE_URL ?>hpp/admin/delete_news_by_id/<?= $news->NEWS_ID; ?>" onclick="return check_confirm_delete();" class="btn btn-danger" title="Delete News"><i class="glyphicon glyphicon-trash"></i></a>     
                                            
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