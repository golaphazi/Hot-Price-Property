<?php $CI =& get_instance(); ?>	
<div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">Welcome <span class="orange strong"><?= $userName;?></span></h1>               
                    </div>
                </div>
            </div>
        </div>
        <div class="properties-area recent-property" style="">
            <div class="container">  
                <div class="row">
                     
                    <?= $user_menu; ?>

                    <div class="col-md-9  pr0 padding-top-40 properties-page">                    
                        <div class="col-md-12 clear"> 
                               
                            <div class="user-profiel hpp-user_profile padd-bottom-70"> 
                                <div class="profiel-container">

                                        <div class="profiel-header text-center">
                                            <h3>
                                                <b>BUILD</b> YOUR PROFILE <br>
                                                <small>This information will let us know more about you.</small>
                                            </h3>
                                            <hr>
                                        </div>

                                    <?php 
                                        $userID     = $this->session->userData('userID');   
                                        $getEdit    = $this->input->get('edit'); 
                                    ?>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <?php
                                                $message = $this->session->userdata( 'message' );
                                                if ( $message ) {
                                                    ?> 
                                                    <div class="alert alert-success">
                                                        <?php echo $message; ?>
                                                    </div>
                                                    <?php
                                                    $this->session->unset_userdata( 'message' );
                                                }
                                                ?>
                                            </div> <!-- End of col-xs-12 -->
                                        </div> <!-- End of row-->

                                        <div class="clear">
                                            <?= form_open_multipart( '', [ 'id' => 'personal_info', 'name' => 'profile_personal_info' ] ); ?>
                                                <div class="personal-info-area paddX-30">
                                                    <div class="col-md-11  profile-title"><h4>Personal Information : <small>File (JPG, PNG)</small> </h4></div>
                                                    <span class="profile-edit"> <a href="<?= SITE_URL; ?>profile/?edit=personal"> <i class="glyphicon glyphicon-pencil"></i> Edit </a></span>

                                                    <div class="col-sm-4">
                                                        <div class="picture-container">
                                                            <?php
                                                                $content = '';
                                                                if( $getEdit == 'personal' ){
                                                                    $content .= '<div class="picture"><img src="'. SITE_URL .$user_profile->PROFILE_IMAGE .'" class="picture-src" id="wizardPicturePreview1" title=""/>';
                                                                    $content .= '<input type="file" name="profile_picture" onchange="readURLProfile(this)">';
                                                                    $content .= '</div>';
                                                                    $content .= '<h6>Choose Picture</h6>';
                                                                }else{
                                                                    $content .= '<div class="picture">';
                                                                    $content .= '<img src="'. SITE_URL .$user_profile->PROFILE_IMAGE .'" class="picture-src" id="wizardPicturePreview1" title=""/>';
                                                                    $content .= '</div>';
                                                                }

                                                                echo $content;
                                                            ?>

                                                        </div>
                                                    </div> <!-- End of col-sm-4 -->

                                                    <div class="col-sm-8 padding-top-15">

                                                        <div class="wrapper-col">
                                                            <span class="profile-lable">Name </span> <b> : </b>
                                                            <?php
                                                                if( $getEdit == 'personal' ) {
                                                                    echo '<input name="user_name" type="text" class="form-control hpp-profile-input-field" placeholder="Enter Your Name..." value="'.$user_profile->USER_NAME.'">';
                                                                }else {
                                                                    echo '<span class="hpp-user-name">'. $user_profile->USER_NAME .'</span>';
                                                                }
                                                            ?>                                
                                                        </div>

                                                        <div class="wrapper-col">
                                                            <span class="profile-lable">Email </span> <b> : </b>
                                                            <span class="hpp-user-name"><?= $user_profile->EMAIL_ADDRESS;?></span>
                                                        </div>
                                                        <?php
                                                        if($user_profile->ROLE_ID == 3){
                                                        ?>
                                                        <div class="wrapper-col">
                                                            <label class="profile-lable" for="ugender"> Gender </label> <b> : </b>
                                                            <?php 
                                                                if( $getEdit == 'personal' ) { ?>
																<span class="hpp-user-name profile-text"> 
                                                                    <input <?php if( $user_profile->GENTER == 'Male' ){ echo 'checked';} ?> name="gender" id="ugender" value="Male" type="radio"  > Male
                                                                    <input <?php if( $user_profile->GENTER == 'FeMale' ){ echo 'checked';} ?> name="gender" id="ugender" value="FeMale" type="radio"  > Female
																</span>
															<?php } else { ?>
                                                                    <span class="hpp-user-name profile-text"> <?= $user_profile->GENTER; ?> </span>
                                                                    <!--<input <?php if( $user_profile->GENTER == 'FeMale' ){ echo 'checked';} ?> name="gender" id="ugender" value="" type="radio" > Female-->
                                                            <?php } ?>
                                                        </div>
                                                        <?php }?>
                                                        <div class="wrapper-col">
                                                            <span class="profile-lable">Objective </span> <b> : </b>
                                                            <?php
                                                                if( $getEdit == 'personal' ) {
                                                                    echo '<textarea name="objective" id="objective"  class="form-control" rows="3" >'. $user_profile->OVERVIEW .'</textarea>';
                                                                }else {
                                                                    echo '<span class="hpp-user-name profile-text">'. $user_profile->OVERVIEW .'</span>';
                                                                }
                                                            ?>
                                                        </div>
                                                    <?php if( $getEdit == 'personal' ) { ?>    
                                                        <div class="profile-submit">
                                                            <input type='submit' class='btn btn-finish btn-primary pull-right' name='personalSubmit' value='Submit' />
                                                        </div>
                                                    <?php } ?>
                                                    </div> <!-- End of col-sm-8 -->              

                                                </div> <!-- End of personal-info-area -->
                                            <?= form_close(); ?>
                                        </div> <!-- End of clear -->

										 
										<div class="clear">
											<br>
                                            <hr>
                                            <br>
											<?php
											if($user_profile->ROLE_ID == 3){
												$typeRole = 'Driver License / NID ';
											}else{
												$typeRole = 'Agent License';
											}
											//echo $user_profile->VERIFY_STATUS;
											?>
                                           <?= form_open_multipart( '', [ 'id' => 'personal_info', 'name' => 'profile_personal_info' ] ); ?>
                                                <div class="account-setting-area paddX-30" id="License_info"> 
                                                    <div class="col-md-11 profile-title"><h4> Upload <?= $typeRole;?> : </h4></div>
                                                    <?php if($user_profile->VERIFY_STATUS == 'Not Verified') { ?>
														<span class="profile-edit"> <a href="<?= SITE_URL; ?>profile/?edit=license#License_info"> <i class="glyphicon glyphicon-pencil"></i> Edit </a></span>
                                                    <?php } ?>
													<div class="col-sm-12">
                                                        <?php
                                                         if( $getEdit == 'license' AND $user_profile->VERIFY_STATUS == 'Not Verified') { ?>
														   
															<div class="wrapper-col">
																<span class="profile-lable" for="password"><?= $typeRole;?> <small>File (JPEG, PNG, PDF)</small></span> <b> : </b>
																<input name="profile_picture" type="file" class="form-control hpp-profile-input-field" >                                    
															</div>
                                                         <?php }else { ?>
																 
															<div class="wrapper-col">
																<span class="profile-lable" for="password"><?= $typeRole;?> File</span> <b> : </b>
																<span class="hpp-user-name"> <?php if(strlen($user_profile->DOCUMENT_UPLOAD) > 0){$img = explode("/", $user_profile->DOCUMENT_UPLOAD); echo $img[sizeof($img) - 1]; }?> </span>                                    
															</div>	
                                                       <?php  } ?>

                                                        <?php if( $getEdit == 'license' AND $user_profile->VERIFY_STATUS == 'Not Verified') { ?>
															<div class="profile_submit">
                                                                <input type='submit' class='btn btn-finish btn-primary pull-right' name='licnseSubmit' value='Update' />
                                                            </div>
															
                                                        <?php } ?>

                                                    </div>
                                                </div> <!-- End of account-setting-area-->
                                            <?= form_close();?>
                                        </div> <!-- End of clear -->
                                        <!-- End Password Settings -->

										 <!-- Password Settings -->
                                        <div class="clear">

                                            <br>
                                            <hr>
                                            <br>
                                            <?= form_open( '', [ 'id' => 'user_account_info', 'name' => 'profile_account_info' ]); ?>
                                                <div class="account-setting-area paddX-30" id="bank_info"> 
                                                    <div class="col-md-11 profile-title"><h4> Bank Account: </h4></div>
                                                    <span class="profile-edit"> <a href="<?= SITE_URL; ?>profile/?edit=bank#bank_info"> <i class="glyphicon glyphicon-pencil"></i> Edit </a></span>
                                                    <div class="col-sm-12">
                                                        <?php
                                                         if( $getEdit == 'bank' ) { ?>
                                                        <div class="wrapper-col">
                                                            <span class="profile-lable" for="password">Bank Name </span> <b> : </b>
                                                            <input name="bank_name" type="text" id="bank_name" class="form-control hpp-profile-input-field" value="<?= $user_profile->BANK_NAME;?>" placeholder="Enter Your Bank Name">
                                                        </div>

                                                        <div class="wrapper-col">
                                                            <span class="profile-lable" for="password">Account No. </span> <b> : </b>
                                                            <input name="account_no" type="text" id="account_no" class="form-control hpp-profile-input-field" value="<?= $user_profile->BANK_NUMBER;?>"  placeholder="Enter Account Number">
                                                        </div>

                                                        <div class="wrapper-col">
                                                            <span class="profile-lable" for="password">Details </span> <b> : </b>
                                                           <textarea name="account_details" id="account_details"  class="form-control" rows="3" ><?= $user_profile->BANK_DETAILS;?></textarea>                                    
                                                        </div>
                                                         <?php }else { ?>
                                                             <div class="wrapper-col">
                                                                <span class="profile-lable" for="password"> Account No</span> <b> : </b>
                                                                <span class="hpp-user-name"><?= $user_profile->BANK_NUMBER;?></span>                                    
                                                            </div>
                                                       <?php  } ?>

                                                        <?php if( $getEdit == 'bank' ) { ?>    
                                                            <div class="profile-submit">
                                                                <input type='submit' class='btn btn-finish btn-primary pull-right' name='bank_info_Submit' value='Update' />
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div> <!-- End of account-setting-area-->
                                            <?= form_close();?>
                                        </div> <!-- End of clear -->
                                        <!-- Account Settings -->
                                        <div class="clear">

                                            <br>
                                            <hr>
                                            <br>

                                            <div class="account-setting-area paddX-30"> 
                                                <div class="col-md-11 profile-title"><h4> Account Information : </h4></div>
                                                <div class="col-sm-12">

                                                    <div class="wrapper-col">
                                                        <span class="profile-lable" for="busniess_type">Business Type </span> <b> : </b>
                                                        <span class="hpp-user-name"><?= $user_profile->ROLE_NAME; ?></span>
                                                    </div>

                                                    <div class="wrapper-col">
                                                        <span class="profile-lable">User Type </span> <b> : </b>
                                                        <span class="hpp-user-name"><?= $user_profile->TYPE_NAME; ?></span>
                                                    </div>

                                                    <div class="wrapper-col">
                                                        <span class="profile-lable" for="logName">User ID </span> <b> : </b>
                                                        <span class="hpp-user-name"><?= $user_profile->USER_LOG_NAME; ?></span>
                                                    </div>
													
													<?php
														if($user_profile->ROLE_ID == 4){
														?>
														<div class="wrapper-col">
															<span class="profile-lable" for="logName">Agent License</span> <b> : </b>
															<span class="hpp-user-name"><?= $user_profile->AGENT_LICENSE; ?></span>
														</div>
														<div class="wrapper-col">
															<span class="profile-lable" for="logName">Agent ABN Number</span> <b> : </b>
															<span class="hpp-user-name"><?= $user_profile->AGENT_ABN_NUMBER; ?></span>
														</div>
													<?php														
														}
														?>
													
                                                </div>
                                            </div> <!-- End of account-setting-area-->

                                        </div> <!-- End of clear -->
                                        <!-- End Account Settings -->

                                        <!-- Contact Information -->
                                        <div class="clear">

                                            <br>
                                            <hr>
                                            <br>
                                            <?= form_open( '' , [ 'id' => 'contact_info', 'name' => 'profile_contact_info' ] ); ?>
                                                <div class="contact-info-area paddX-30" id="contact_info"> 
                                                    <div class="col-md-11 profile-title"><h4> Contact Information : </h4></div>
                                                    <span class="profile-edit"> <a href="<?= SITE_URL; ?>profile/?edit=contact#contact_info"> <i class="glyphicon glyphicon-pencil"></i> Edit </a></span>
                                                    <div class="col-sm-12">
                                                        <?php
                                                        if( is_array( $contact ) AND sizeof( $contact ) > 0):
                                                            foreach($contact AS $conType):
                                                                $contactID = $conType['CONTACT_TYPE_ID'];
                                                                $contactInfo = $this->user->any_where(array( 'CONTACT_TYPE_ID' => $contactID, 'USER_ID' => $userID), 'c_contact_info' );
                                                                if(is_array($contactInfo) AND sizeof($contactInfo) > 0){
                                                                    $display_name = $contactInfo[0]['CONTACT_NAME'];
                                                                }else{
                                                                    $display_name = '';
                                                                }
                                                        ?>
                                                        <div class="wrapper-col">
                                                            <span class="profile-lable"> <?= $conType['CONTACT_NAME'];?> </span> <b> : </b>
                                                                <?php
                                                                if ($getEdit == 'contact') {
                                                                    if ( $conType['CONTACT_NAME'] == 'Address') {
                                                                        echo '<textarea name="user_contact_name__'.$contactID.'" id="userAddress"  class="form-control" rows="3" >' . $display_name . '</textarea>';
                                                                    } else {
                                                                        echo '<input name="user_contact_name__'.$contactID.'" type="text" id="contactName" class="form-control hpp-profile-input-field" placeholder="Enter Conatct Name..." value="' . $display_name . '">';
                                                                    }
                                                                } else {
                                                                    echo '<span class="hpp-user-name">' . $display_name . '</span>';
                                                                }
                                                                ?>
                                                        </div>
                                                        <?php   
                                                            endforeach;
                                                        endif;
                                                        ?>

                                                        <?php if( $getEdit == 'contact' ) { ?>    
                                                            <div class="profile-submit">
                                                                <input type='submit' class='btn btn-finish btn-primary pull-right' name='contactSubmit' value='Update' />
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div> <!-- End of account-setting-area-->
                                            <?= form_close(); ?>
                                        </div> <!-- End of clear -->
                                        <!-- End Contact Information -->


                                        <!-- Mailing Address Information -->
                                        <div class="clear">

                                            <br>
                                            <hr>
                                            <br>
                                            <?= form_open( '' , [ 'id' => 'mailing_address', 'name' => 'mailing_address_info' ] ); ?>
                                                <div class="contact-info-area paddX-30" id="mail_address"> 
                                                    <div class="col-md-11 profile-title"><h4> Mailing Address : </h4></div>
                                                    <span class="profile-edit"> <a href="<?= SITE_URL; ?>profile/?edit=mail_address#mail_address"> <i class="glyphicon glyphicon-pencil"></i> Edit </a></span>
                                                    <div class="col-sm-12">
                                                        <?php
                                                        if( is_array( $contact_address ) AND sizeof( $contact_address ) > 0):
                                                            foreach( $contact_address AS $address ):
                                                                $contactID_mail = $address['CONTACT_TYPE_ID'];
                                                                $contactInfo_mail = $this->user->any_where(array( 'CONTACT_TYPE_ID' => $contactID_mail, 'USER_ID' => $userID), 'c_contact_info' );
                                                                if(is_array($contactInfo_mail) AND sizeof($contactInfo_mail) > 0){
                                                                    $display_name = $contactInfo_mail[0]['CONTACT_NAME'];
                                                                }else{
                                                                    $display_name = '';
                                                                }
                                                        ?>
                                                        <div class="wrapper-col">
                                                            <span class="profile-lable"> <?= $address['CONTACT_NAME'];?> </span> <b> : </b>
                                                                <?php
                                                                if ($getEdit == 'mail_address') {
                                                                    if ( $address['CONTACT_NAME'] == 'Country' ) {
                                                                        echo '<select name="user_contact_name__'.$contactID_mail.'" id="lunchBegins"  class=" hpp-profile-input-field" data-live-search="true" data-live-search-style="begins" title="select country">';
                                                                                $loca_cuntry = '';
                                                                                    if (is_array($COUNTRYES) AND sizeof($COUNTRYES) > 0) {
                                                                                       echo ' <option></option>';
                                                                                        foreach ($COUNTRYES AS $valueP):
                                                                                            if (strlen($valueP['countryName']) > 0) :
                                                                                                $icon = $active = ''; 
                                                                                                if ($display_name == $valueP['countryID']) {
                                                                                                    $active = 'selected';
                                                                                                    $icon = '<span class="glyphicon glyphicon-ok"></span>';
                                                                                                } ?> 
                                                                                                <option value="<?= $valueP['countryID']; ?>" <?= $active; ?>><?= $valueP['countryName']; ?></option>
                                                                                        <?php
                                                                                            endif;
                                                                                        endforeach;
                                                                                    }
                                                                       echo '</select>';
                                                                    } else {
                                                                        echo '<input name="user_contact_name__'.$contactID_mail.'" type="text" id="contactName" class="form-control hpp-profile-input-field" placeholder="Enter Conatct Name..." value="' . $display_name . '">';
                                                                    }
                                                                } else {
                                                                    if( $address['CONTACT_NAME'] == 'Country' ){
                                                                       if($display_name > 0){
                                                                            $country = $this->Property_Model->select_country(array('countryID' => $display_name));
                                                                            echo '<span class="hpp-user-name">'.$country[0]['countryName'].'</span>';
                                                                       }else{
                                                                           echo '<span class="hpp-user-name">' . $display_name . '</span>'; 
                                                                        }
                                                                    }else{
                                                                        echo '<span class="hpp-user-name">' . $display_name . '</span>';
                                                                    }
                                                                }
                                                                ?>
                                                        </div>
                                                        <?php   
                                                            endforeach;
                                                        endif;
                                                        ?>

                                                        <?php if( $getEdit == 'mail_address' ) { ?>    
                                                            <div class="profile-submit">
                                                                <input type='submit' class='btn btn-finish btn-primary pull-right' name='contactMailSubmit' value='Update' />
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div> <!-- End of account-setting-area-->
                                            <?= form_close(); ?>
                                        </div> <!-- End of clear -->
                                        <!-- End Mailing Address -->

                                        <!-- Social Media Information -->
                                        <div class="clear">

                                            <br>
                                            <hr>
                                            <br>
                                            <?= form_open( '', [ 'id' => 'social_profile', 'name' => 'profile_social_info' ] ); ?>
                                                <div class="contact-info-area paddX-30" id="social_info"> 
                                                    <div class="col-md-11 profile-title">
                                                        <h4> Social Media Profile : </h4> 
                                                    </div>
                                                    <span class="profile-edit"> <a href="<?= SITE_URL; ?>profile/?edit=social#social_info"> <i class="glyphicon glyphicon-pencil"></i> Edit </a></span> 
                                                    <div class="col-sm-12">
                                                        <?php
                                                            if(is_array( $social ) && sizeof( $social ) > 0 ) :
                                                                foreach ( $social as $socialItem ):
                                                                $socialTypeId = $socialItem['CONTACT_TYPE_ID'];
                                                                $socialInfo = $this->user->any_where( array( 'CONTACT_TYPE_ID' => $socialTypeId, 'USER_ID' => $userID, 'c_contact_info' ) );
                            //                                    echo '<pre>';
                            //                                    print_r($contactInfo);
                                                                if(is_array( $socialInfo ) && sizeof( $socialInfo ) ){
                                                                    $display_socialItem = $socialInfo[0]['CONTACT_NAME'];
                                                                }else {
                                                                   $display_socialItem = ''; 
                                                                }
                                                        ?>
                                                            <div class="wrapper-col">
                                                                <span class="profile-lable"> <?= $socialItem['CONTACT_NAME']; ?> </span> <b> : </b>
                                                                <?php
                                                                    if( $getEdit == 'social' ) {
                                                                        echo '<input name="social_profile__'.$socialTypeId.'" type="url" id="fb" class="form-control hpp-profile-input-field" value="'. $display_socialItem. '" placeholder="https://www.facebook.com/">';
                                                                    }else {
                                                                        echo '<span class="hpp-user-name">'. $display_socialItem .'</span>';
                                                                    }
                                                                ?>
                                                            </div>

                                                        <?php 
                                                                endforeach;
                                                            endif; 
                                                        ?>


                                                        <?php if( $getEdit == 'social' ) { ?>    
                                                            <div class="profile-submit">
                                                                <input type='submit' class='btn btn-finish btn-primary pull-right' name='socialSubmit' value='Update' />
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div> <!-- End of account-setting-area-->
                                            <?= form_close(); ?>
                                        </div> <!-- End of clear -->
                                        <!-- End Social Media Information -->

                                         <!-- Password Settings -->
                                        <div class="clear">

                                            <br>
                                            <hr>
                                            <br>
                                            <?= form_open( '', [ 'id' => 'user_account_info', 'name' => 'profile_account_info' ]); ?>
                                                <div class="password-setting-area paddX-30" id="password_info"> 
                                                    <div class="col-md-11 profile-title"><h4> Password Setting : </h4></div>
                                                    <span class="profile-edit"> <a href="<?= SITE_URL; ?>profile/?edit=password#password_info"> <i class="glyphicon glyphicon-pencil"></i> Change Password </a></span>
                                                    <div class="col-sm-12">
                                                        <?php
                                                         if( $getEdit == 'password' ) { ?>
                                                        <div class="wrapper-col">
                                                            <span class="profile-lable" for="password">Old Password </span> <b> : </b>
                                                            <input name="old_password" type="password" id="old_password" class="form-control hpp-profile-input-field" placeholder="Enter Your Old Password">
                                                        </div>

                                                        <div class="wrapper-col">
                                                            <span class="profile-lable" for="password">New Password </span> <b> : </b>
                                                            <input name="new_password" type="password" id="new_password" class="form-control hpp-profile-input-field" placeholder="Enter New Password">
                                                        </div>

                                                        <div class="wrapper-col">
                                                            <span class="profile-lable" for="password">Confirm Password </span> <b> : </b>
                                                            <input name="confirm_password" type="password" id="confirm_password" class="form-control hpp-profile-input-field" placeholder="Enter Confirm Password">                                    
                                                        </div>
                                                         <?php }else { ?>
                                                             <div class="wrapper-col">
                                                                <span class="profile-lable" for="password"> Password </span> <b> : </b>
                                                                <span class="hpp-user-name">**********</span>                                    
                                                            </div>
                                                       <?php  } ?>

                                                        <?php if( $getEdit == 'password' ) { ?>    
                                                            <div class="profile-submit">
                                                                <input type='submit' class='btn btn-finish btn-primary pull-right' name='passwordSubmit' value='Update' />
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div> <!-- End of account-setting-area-->
                                            <?= form_close();?>
                                        </div> <!-- End of clear -->
                                        <!-- End Password Settings -->

                                </div> <!-- End of profile-container-->
                            </div> <!-- End of hpp-user-profile -->

                        </div>                   
                    </div> <!-- End of properties-page --> 
                    
                </div>  <!-- End of row -->            
            </div>
        </div>
  