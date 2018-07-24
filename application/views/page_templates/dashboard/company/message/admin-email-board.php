<?php $CI =& get_instance(); ?>
<div class="page-head"> 
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title">Welcome <span class="orange strong">Email Board</span></h1>
            </div>
        </div>
    </div>
</div>
<div class="properties-area recent-property" style="">
    <div class="container container_composeData">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 properties-page">                    
                <div class="col-md-12 clear"> 
                    <h4 class="center sectionTitle"><srtong>::</srtong> Email Board <srtong>::</srtong> </h4>
                    <div class="hpp_wpapper_table">
                        <?php
                        $get_search = isset($_GET['search']) ? $_GET['search'] : 'inbox';
                        $setUrl = $get_search;
                        if ($get_search == 'compose') {
                            $setUrl = 'all';
                        }
                        ?>
                        <ul class="hpp-mailbox">
                            <li class="<?php if($setUrl == 'all'){$nae = ''; echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/email_inbox?search=all">All <span class="count_massage"><?= $ALL_COUNT;?></span></a></li>
                            <li class="<?php if($setUrl == 'inbox'){$nae = 'Inbox';  echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/email_inbox?search=inbox" >Inbox <span class="count_massage"><?= $ALL_COUNT_INbox;?></span></a></li>
                            <li class="<?php if($setUrl == 'sent'){$nae = 'Sent';  echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/email_inbox?search=sent" >Sent <span class="count_massage"><?= $ALL_COUNT_SEND;?></span></a></li>
                            <li class="<?php if($setUrl == 'contact'){$nae = 'Contact';  echo 'active';}?>" ><a href="<?= SITE_URL ?>hpp/admin/email_inbox?search=contact" >Contact <span class="count_massage"><?= $ALL_CONTACT_SEND;?></span></a></li> 
                            <li class="compose" onclick="composeEmail();"> <a href="<?= SITE_URL ?>hpp/admin/email_inbox?search=compose" >Compose </a></li>
                        </ul>
                        <!--<ul class="unstyled inbox-pagination">
                            <li><span>1-50 of 234</span></li>
                            <li>
                                <a class="np-btn" href="#"><i class="fa fa-angle-left  pagination-left"></i></a>
                            </li>
                            <li>
                                <a class="np-btn" href="#"><i class="fa fa-angle-right pagination-right"></i></a>
                            </li>
                        </ul>-->
                        <div class="clear"></div>

                        <div class="inbox-body">


                            <!-- End Email Details View -->
                             <?php

                                $GetEmailView = isset( $_GET['view-email'] ) ? $_GET['view-email'] : 'see';
                                $Getscau = isset( $_GET['scau'] ) ? $_GET['scau'] : 0;
                                $Getscaud = isset( $_GET['scaud'] ) ? $_GET['scaud'] : 0;

                                $apply = isset( $_GET['apply'] ) ? $_GET['apply'] : '';

                            ?>    
                            <table class="table table-inbox table-striped">
                                <tbody>
                                    <?php 
                                        if( is_array( $massage_list ) && sizeof( $massage_list ) > 0 ) {

                                            foreach ( $massage_list as $email ) : 
                                                $shoertTitle = '';
                                                $shoertDetails = '';
                                                $contactSub = 0;
                                                $endDate = $email['ENT_DATE'];
                                                $datetime = $email['ENT_DATE_TIME'];
                                                $searchDetails = array();
                                                $searchDetails['CONTACT_AGENT_ID'] = $email['CONTACT_AGENT_ID'];
                                                $searchDetails['SMS_DET_STATUS'] = 'Active';

                                                /*if($Getscaud > 0){
                                                    $searchDetails['CONTACT_AGENT_DETAILS_ID'] = $Getscaud;
                                                }*/

                                                $massageDetails =  $CI->any_where($searchDetails, 'sms_contact_agent_user_details');
                                                $cunt = sizeof($massageDetails);
                                                $TO_USER = 0;
                                                $TO_TYPE = 'Hpp';
                                                if(is_array($massageDetails) AND sizeof($massageDetails) > 0){
                                                $shoertTitle 	= $massageDetails[0]['MESSAGE_TITLE'];
                                                $shoertDetails 	= $massageDetails[0]['MESSAGE_DATA'];
                                                $contactSub 	= $massageDetails[0]['CONTACT_AGENT_DETAILS_ID'];
                                                $endDate 	= $massageDetails[0]['ENT_DATE'];
                                                $datetime 	= $massageDetails[0]['ENT_DATE_TIME'];
                                                $TO_USER 	= $massageDetails[0]['TO_USER'];
                                                }
                                                if($datetime == '0000-00-00 00:00:00'){
                                                    $datetime = $email['ENT_DATE_TIME'];
                                                }
                                                if($endDate == '0000-00-00'){
                                                    $endDate = $email['ENT_DATE'];
                                                }
                                                $unread = ''; 
                                                if($email['SEEN_TYPE'] == 'show'){
                                                    $unread = 'unread';  
                                                    $unreadT = '<span class="label label-danger pull-right">New</span>';  
                                                }else{
                                                    $unread = 'read';
                                                    $unreadT ='';
                                                }

                                                if($TO_USER == $this->adminID){
                                                    $inbox = '<span class="label label-success pull-right">Inbox</span>'; 
                                                }else{
                                                    $inbox = '<span class="label label-info pull-right">Send</span>'; 
                                                }
                                        ?>

                                     <?php  
                                        if( $GetEmailView != 'view' && $Getscau == 0 ){ 
                                     ?>        
                                        <tr class="<?= $unread;?>">
                                            <td class="inbox-small-cells" style="width:40px;">
                                                <input type="checkbox" class="mail-checkbox">
                                            </td>
                                           <!-- <td class="inbox-small-cells"><i class="fa fa-star"></i></td>-->
                                            <td class="view-message  dont-show message-link">
                                                <?php if($cunt > 1){?>
                                                    <span> (<?= $cunt;?>)</span>
                                                    <?php }?>
                                                    <?= $unreadT;?>
                                                    <a href="<?= SITE_URL; ?>hpp/admin/email_inbox?search=<?= $setUrl;?>&view-email=view&scau=<?= $email['CONTACT_AGENT_ID'];?>&scaud=<?= $contactSub;?>"> 
                                                    <?= substr(strip_tags($email['CONTACT_SUBJECT']), 0, 35); ?><?php if(strlen(strip_tags($email['CONTACT_SUBJECT'])) > 35) {echo '..';}?>
                                                    </a>
                                            </td>
                                            <td class="view-message message-link"> 
                                                <?= $inbox;?>
                                                <a href="<?= SITE_URL; ?>hpp/admin/email_inbox?search=<?= $setUrl;?>&view-email=view&scau=<?= $email['CONTACT_AGENT_ID'];?>&scaud=<?= $contactSub;?>"> 
                                                    <?= substr(strip_tags($shoertTitle), 0, 25); ?><?php if(strlen(strip_tags($shoertTitle)) > 25) {echo '..';}?>
                                                </a>
                                            </td>
                                            <td class="view-message text-right">
                                                <?php

                                                    $dateCount = $this->Property_Model->date_diff_count($datetime, '');
                                                    echo $dateCount;
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php  
                                    if( $GetEmailView = 'view' && $Getscau == $email['CONTACT_AGENT_ID'] ){
                                        $CI->hpp_order 		= 'ASC';
                                        $searchDetailsShow = array();
                                        $searchDetailsShow['CONTACT_AGENT_ID'] = $email['CONTACT_AGENT_ID'];
                                        $searchDetailsShow['SMS_DET_STATUS'] = 'Active';
                                        $massageDetailsShow =  $CI->any_where($searchDetailsShow, 'sms_contact_agent_user_details');
                                        $SHOW_TIME =  '';     
                                        if(is_array($massageDetailsShow) AND sizeof($massageDetailsShow) > 0){
                                     ?>
                                        <tr>
                                           <td colspan="4">
                                                <div class="row marX-0"> 
                                                    <div class="col-md-12 email-head text-left">
                                                        <h2 class="email-header-title"><?= $email['CONTACT_SUBJECT']; ?></h2> <span><?= ucfirst($get_search);?></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        foreach($massageDetailsShow AS $detailsShow){
                                                $endDate  = $detailsShow['ENT_DATE'];
                                                $datetime = $detailsShow['ENT_DATE_TIME'];
                                                if($datetime == '0000-00-00 00:00:00'){
                                                   $datetime = date('Y-m-d h:i:s');
                                                }
                                                $SHOW_TIME = $this->Property_Model->date_diff_count($datetime, '');
                                                if($detailsShow['CONTACT_AGENT_DETAILS_ID'] == $Getscaud AND $detailsShow['CONTACT_AGENT_ID'] == $Getscau){
                                                 $shoertDetails = $detailsShow['MESSAGE_DATA'];
                                        ?>
                                           <tr>
                                               <td colspan="4">
                                                    <div class="row marX-0"> 
                                                        <div class="col-md-8 pull-left hpp-email-body">
                                                            <?php

                                                                 if ($detailsShow['FROM_USER'] == $this->adminID AND $detailsShow['FROM_TYPE_D'] == 'Hpp') {
                                                                        $profileId = $detailsShow['TO_USER'];
                                                                        $profile_type = $detailsShow['TO_TYPE_D'];
                                                                    } else {
                                                                        $profileId = $detailsShow['FROM_USER'];
                                                                        $profile_type = $detailsShow['FROM_TYPE_D'];
                                                                    }
                                                                    if ($profile_type == 'Hpp') {
                                                                        if ($profileId == 0) {
                                                                            $hpp_anme = 'Hot Price Property';
                                                                        } else {
                                                                            $CI->hpp_select = '';
                                                                            $CI->hpp_order_column = '';
                                                                            $CI->hpp_limit = '';
                                                                            $hpp_anme = $CI->any_where(array('ADMIN_ID' => $profileId), 'admin_access', 'ADMIN_USER') . ' - <b>HPP </b>';
                                                                        }
                                                                        echo '<span class="user-image"><img src="' . SITE_URL . 'assets/img/logo.png"></span> 
                                                                                                                                    <span class="user-name">' . $hpp_anme . '</span> ';
                                                                    } else {	
                                                                    $getUser = $this->user->select_user_profile_by_id($profileId);
                                                                     //print_r($getUser);
                                                                     if(is_object($getUser) AND sizeof($getUser) > 0 ){
                                                                        if(strlen($getUser->PROFILE_IMAGE) > 6 ){
                                                                                $profile_image = $getUser->PROFILE_IMAGE;
                                                                        }else{
                                                                                $profile_image = 'assets/img/client-face1.png';
                                                                        }
                                                                        echo '<span class="user-image"><img src="'.SITE_URL.$profile_image.'" height="50" width="50"></span> 
                                                                        <a href="'.SITE_URL.'agent?id='.$getUser->USER_LOG_NAME.'" target="_blank"><span class="user-name">'.$getUser->USER_NAME.'</span> </a>';
                                                                     }
                                                                 } 
                                                            ?>
                                                        </div>
                                                        <div class="col-md-4 email-action pull-right text-right">
                                                            <span class="email-date-time "> <?= $SHOW_TIME;?> </span>
                                                            <!--<span class="btn btn-neutral"><i class="fa fa-reply "></i></span>
                                                            <span class="btn btn-neutral"><i class="fa fa-sort-desc"></i></span>-->
                                                        </div>
                                                        <div class="col-md-12 pad-10">
                                                            <?= htmlspecialchars_decode($shoertDetails); ?>
                                                        </div>


                                                   </div><!-- End of hpp-email-body -->

                                                   <div class="row" style="margin:1px;">
                                                        <div class="col-md-12 email-footer">
                                                                <div class="footer-reply">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                         Click here to <a href="<?= SITE_URL; ?>hpp/admin/email_inbox?search=<?= $setUrl;?>&view-email=view&scau=<?= $email['CONTACT_AGENT_ID'];?>&scaud=<?= $detailsShow['CONTACT_AGENT_DETAILS_ID'];?>&apply=replay"> Reply</a><!--, <a href="#"> Reply to all </a>--> or <a href="<?= SITE_URL; ?>hpp/admin/email_inbox?search=<?= $setUrl;?>&view-email=view&scau=<?= $email['CONTACT_AGENT_ID'];?>&scaud=<?= $detailsShow['CONTACT_AGENT_DETAILS_ID'];?>&apply=forward">Forward</a>
                                                                    </div>
                                                                    <div class="form-group">
                                                                       <?= $composeMSG; ?>
                                                                    </div>
                                                                </div>
                                                                     <?php
                                                                     if($apply == 'replay'){
                                                                        $urlAgent = SITE_URL.'hpp/admin/email_inbox?search='.$setUrl.'&view-email=view&scau='.$email['CONTACT_AGENT_ID'].'&scaud='.$detailsShow['CONTACT_AGENT_DETAILS_ID'].'&apply=replay';
                                                                        ?>
                                                                        <?= form_open($urlAgent, ['id' => 'replay_form', 'name' => 'replay_form']); ?>
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <textarea id="NEXT_Editor" name="message_replay"  style="display:none"></textarea>
                                                                                <?php $editor['id'] = 'NEXT_Editor'; $this->load->view('Next_editor/editor', $editor);?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                               <button type="submit" name="contact_replay_message" class="btn btn-primary">Replay</button>
                                                                            </div>
                                                                        </div>
                                                                        <?=  form_close();?>
                                                                    <?php
                                                                     }else if($apply == 'forward'){
                                                                        $urlAgent = SITE_URL.'hpp/admin/email_inbox?search='.$setUrl.'&view-email=view&scau='.$email['CONTACT_AGENT_ID'].'&scaud='.$detailsShow['CONTACT_AGENT_DETAILS_ID'].'&apply=forward';
                                                                     ?>
                                                                     <?= form_open($urlAgent, ['id' => 'replay_form', 'name' => 'replay_form']); ?>
                                                                    <div class="col-md-12">
                                                                       <div class="form-group">
                                                                           <div class="input-group">
                                                                               <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                                               <input list="compose_email_list1" type="email" class="form-control" name="compose_email" required="" placeholder="Email" value="<?= $composeEmail;?>">
                                                                               <datalist id="compose_email_list1">
                                                                               <?php
                                                                               foreach($compose_email_list AS $list){
                                                                                   $searchUser = $list['FROM_USER'];
                                                                                   if($list['FROM_USER'] == $this->adminID){
                                                                                       $searchUser = $list['TO_USER'];
                                                                                   }
                                                                                   $userEmail = $this->user->select_user_mail($searchUser);
                                                                                   if(strlen($userEmail) > 0 AND $list['FROM_USER'] != $this->adminID){
                                                                                       echo '<option value="'.$userEmail.'"> '.$userEmail.'</option>';
                                                                                   }
                                                                               }
                                                                               ?>
                                                                               </datalist>
                                                                                </div>
                                                                             </div>

                                                                            <div class="form-group">
                                                                               <textarea id="NEXT_Editor" name="message_replay"  style="display:none"><?= $shoertDetails;?></textarea>
                                                                               <?php $editor['id'] = 'NEXT_Editor'; $this->load->view('Next_editor/editor', $editor);?>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                       <div class="form-group">
                                                                          <button type="submit" name="contact_replay_message" class="btn btn-primary">Forward</button>
                                                                       </div>
                                                                    </div>
                                                                    <?=  form_close();?>
                                                            <?php	
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                   </div>
                                               </td>
                                           </tr>
                                            <?php
                                                }else{
                                                    $TO_USER = $detailsShow['TO_USER'];
                                                    if($TO_USER == $this->adminID){
                                                        $inboxMas = '<span class="label label-success pull-right">Inbox</span>'; 
                                                    }else{
                                                        $inboxMas = '<span class="label label-info pull-right">Send</span>'; 
                                                    }
                                                ?>
                                                 <tr>
                                                    <td colspan="3" class="view-message  dont-show message-link"> <a href="<?= SITE_URL; ?>hpp/admin/email_inbox?search=<?= $setUrl;?>&view-email=view&scau=<?= $email['CONTACT_AGENT_ID'];?>&scaud=<?= $detailsShow['CONTACT_AGENT_DETAILS_ID'];?>"> <?= $detailsShow['MESSAGE_TITLE'];?> </a> <?= $inboxMas;?></td>
                                                    <td class="view-message  text-right"> <?= $SHOW_TIME;?> </td>
                                                </tr>
                                            <?php														

                                            }
                                            ?>

                                            <?php
                                                    }
                                                }													
                                            }
                                        endforeach;
                                    }else{
                                        echo '<tr><td colspan="4"> Not email found..!<td></tr>';
                                    }
                                ?>
                            </tbody>
                        </table>

                   </div>	

                </div> <!-- End of col-md-12 clear -->                 
            </div> <!-- End of properties-page --> 
        </div>  <!-- End of row -->   
        <?php if($get_search == 'compose'){ 
            $composeEmail = $this->input->get('email');
            ?>
        <div class="composeData">
            <?= form_open('hpp/admin/email_inbox?search=compose', ['id' => 'compose_form', 'name' => 'compose_form']); ?>
                    <div class="col-md-12 compose_sent">
                        <div class="form-group">
                            <span onclick="toggleBox();" >New Message</span>
                            <span class="pull-right"> <i class="fa fa-minus" onclick="toggleBox();" style="margin-right:10px;"></i> <i class="fa fa-close" onclick="hideBox();"></i></span>
                        </div>
                    </div>
                    <div class="col-md-12" id="box_id">
                        <div class="form-group">
                            <?= $composeMSG;?>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input list="compose_email_list1" type="email" required="" class="form-control" name="compose_email" placeholder="To email ..." value="<?= $composeEmail;?>">
                                <datalist id="compose_email_list1">
                                <?php
                                foreach($compose_email_list AS $list){
                                    $searchUser = $list['FROM_USER'];
                                    if($list['FROM_USER'] == $this->adminID){
                                        $searchUser = $list['TO_USER'];
                                    }
                                    $userEmail = $this->user->select_user_mail($searchUser);
                                    if(strlen($userEmail) > 0 AND $list['FROM_USER'] != $this->adminID){
                                        echo '<option value="'.$userEmail.'"> '.$userEmail.'</option>';
                                    }
                                }
                                ?>
                                </datalist>
                             </div>
                         </div>
                        <div class="form-group">
                           <div class="input-group">
                                <span class="input-group-addon" style="border-right: 1px solid #ccc;"><i class="fa fa-font"></i></span>
                                <input id="compose_subject" type="text" required="" class="form-control" name="compose_subject" placeholder="Enter subject" value="<?= $composeSubject;?>">
                            </div>
                        </div>

                    <div class="form-group">
                        <textarea id="ComposeId" name="compose_data" style="display:none"></textarea>
                        <?php $editor['id'] = 'ComposeId'; $this->load->view('Next_editor/editor', $editor);?>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="compose_form" class="btn btn-primary">Send</button>
                    </div>
                </div>

            <?=  form_close();?>
        </div>
        <?php } ?>
    </div>
</div>
		
<script>
function toggleBox(){
   $("#box_id").toggle();
}

function hideBox(){
   $(".composeData").hide();
}
</script>
  