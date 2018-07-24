<div class="clear" style="padding-bottom: 35px;">
    <br>
    <hr>
    <div class="col-sm-11 col-sm-offset-1" >
        <?php 
            if( is_array( $user_details ) && sizeof( $user_details ) > 0 ) {
        ?>
            <div class="wrpCol">
                <div class="col-sm-4 colLable">Full name </div> <div class="col-sm-1">:</div>
                <div class="col-sm-6 colData"><?= $user_details[0]['ADMIN_NAME']; ?></div>
            </div><!--end of wrpCol -->
            <div class="wrpCol">
                <div class="col-sm-4 colLable">User name </div> <div class="col-sm-1">:</div>
                <div class="col-sm-6 colData"><?= $user_details[0]['ADMIN_USER']; ?></div>
            </div><!--end of wrpCol -->
            <div class="wrpCol">
                <div class="col-sm-4 colLable">Email ID </div> <div class="col-sm-1">:</div>
                <div class="col-sm-6 colData"><?= $user_details[0]['ADMIN_EMAIL']; ?></div>
            </div><!--end of wrpCol -->
            <div class="wrpCol">
                <div class="col-sm-4 colLable">Admin Type</div><div class="col-sm-1">:</div>
                <div class="col-sm-6 colData"><?= $user_details[0]['ADMIN_TYPE']; ?></div>
            </div><!--end of wrpCol -->
            
            <div class="wrpCol">
                <div class="col-sm-4 colLable">Activation Status</div><div class="col-sm-1">:</div>
                <div class="col-sm-6 colData"><?= $user_details[0]['ADMIN_STATUS']; ?></div>
            </div><!--end of wrpCol -->
        
       <?php }
        else{ 
            echo '<div class="wrpCol">No Recourd Found..!</div>';
        } ?>
        
    </div><!-- End of col-sm-10 -->  
</div>