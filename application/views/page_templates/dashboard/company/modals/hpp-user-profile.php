<?php $CI = & get_instance(); ?>	


<div class="user-profiel hpp-user_profile padd-bottom-70"> 

    <div class="clear">
        <div class="personal-info-area paddX-30">
            <div class="col-md-11  profile-title"><h4>Personal Information : </h4></div>

            <div class="col-sm-4">
                <div class="picture-container">
                    <?php
                    $userID = $user_profile->USER_ID;
                    $content = '';
                    $content .= '<div class="picture">';
                    $content .= '<img src="' . SITE_URL . $user_profile->PROFILE_IMAGE . '" class="picture-src" id="wizardPicturePreview1" title=""/>';
                    $content .= '</div>';
                    echo $content;
                    ?>
                </div>
            </div> <!-- End of col-sm-4 -->

            <div class="col-sm-8 padding-top-15">

                <div class="wrapper-col">
                    <span class="profile-lable">Name </span> <b> : </b>
                    <?php
                    echo '<span class="hpp-user-name">' . $user_profile->USER_NAME . '</span>';
                    ?>                                
                </div>

                <div class="wrapper-col">
                    <span class="profile-lable">Email </span> <b> : </b>
                    <span class="hpp-user-name"><?= $user_profile->EMAIL_ADDRESS; ?></span>
                </div>
                <div class="wrapper-col">
                    <span class="profile-lable">Gender </span> <b> : </b>
                    <?php
                    echo '<span class="hpp-user-name profile-text">' . ucfirst($user_profile->GENTER) . '</span>';
                    ?>
                </div>
                <div class="wrapper-col">
                    <span class="profile-lable">Objective </span> <b> : </b>
                    
                    <span class="hpp-user-name profile-text"><?= $CI->trim_text($user_profile->OVERVIEW,345); ?></span>
                    
                </div>
            </div> <!-- End of col-sm-8 -->              

        </div> <!-- End of personal-info-area -->
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
	  <div class="account-setting-area paddX-30" id="License_info"> 
				<div class="col-md-11 profile-title"><h4> Upload <?= $typeRole;?> : </h4></div>
				
				<div class="col-sm-12">
						 
					<div class="wrapper-col">
						<span class="profile-lable" for="password"><?= $typeRole;?> File</span> <b> : </b>
						<span class="hpp-user-name"> <?php if(strlen($user_profile->DOCUMENT_UPLOAD) > 0){ $img = explode("/", $user_profile->DOCUMENT_UPLOAD); ?> <a href="<?= SITE_URL.$user_profile->DOCUMENT_UPLOAD;?>" target="_blank"> <?= $img[sizeof($img) - 1];?> </a><?php }?> </span>                                    
					</div>	
				  
				</div>
			</div> <!-- End of account-setting-area-->
		
	</div> <!-- End of clear -->
	
	<div class="clear">
		<br>
		<hr>
		<br>
		
	  <div class="account-setting-area paddX-30" id="License_info"> 
				<div class="col-md-11 profile-title"><h4> Bank Account:  </h4></div>
				
				<div class="col-sm-12">
					<div class="wrapper-col">
						<span class="profile-lable" for="password">Bank Name </span> <b> : </b>
						<span class="hpp-user-name"> <?= $user_profile->BANK_NAME;?> </span>
					</div>
					<div class="wrapper-col">
						<span class="profile-lable" for="password">Account No. </span> <b> : </b>
						<span class="hpp-user-name"> <?= $user_profile->BANK_NUMBER;?> </span>
					</div>
					<div class="wrapper-col">
						<span class="profile-lable" for="password">Details. </span> <b> : </b>
						<span class="hpp-user-name"> <?= $user_profile->BANK_DETAILS;?> </span>
					</div>
				</div>
			</div> <!-- End of account-setting-area-->
		
	</div> <!-- End of clear -->
	<!-- End Password Settings -->
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

        <div class="contact-info-area paddX-30" id="contact_info"> 
            <div class="col-md-11 profile-title"><h4> Contact Information : </h4></div>

            <div class="col-sm-12">
                <?php
                if (is_array($contact) AND sizeof($contact) > 0):
                    foreach ($contact AS $conType):
                        $contactID = $conType['CONTACT_TYPE_ID'];
                        $contactInfo = $this->user->any_where(array('CONTACT_TYPE_ID' => $contactID, 'USER_ID' => $userID), 'c_contact_info');
                        if (is_array($contactInfo) AND sizeof($contactInfo) > 0) {
                            $display_name = $contactInfo[0]['CONTACT_NAME'];
                        } else {
                            $display_name = '';
                        }
                        ?>
                        <div class="wrapper-col">
                            <span class="profile-lable"> <?= $conType['CONTACT_NAME']; ?> </span> <b> : </b>
                            <?php
                            echo '<span class="hpp-user-name">' . $display_name . '</span>';
                            ?>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div> <!-- End of account-setting-area-->
    </div> <!-- End of clear -->
    <!-- End Contact Information -->


    <!-- Mailing Address Information -->
    <div class="clear">

        <br>
        <hr>
        <br>
        <div class="contact-info-area paddX-30" id="mail_address"> 
            <div class="col-md-11 profile-title"><h4> Mailing Address : </h4></div>

            <div class="col-sm-12">
                <?php
                if (is_array($contact_address) AND sizeof($contact_address) > 0):
                    foreach ($contact_address AS $address):
                        $contactID_mail = $address['CONTACT_TYPE_ID'];
                        $contactInfo_mail = $this->user->any_where(array('CONTACT_TYPE_ID' => $contactID_mail, 'USER_ID' => $userID), 'c_contact_info');
                        if (is_array($contactInfo_mail) AND sizeof($contactInfo_mail) > 0) {
                            $display_name = $contactInfo_mail[0]['CONTACT_NAME'];
                        } else {
                            $display_name = '';
                        }
                        ?>
                        <div class="wrapper-col">
                            <span class="profile-lable"> <?= $address['CONTACT_NAME']; ?> </span> <b> : </b>
                            <?php
                            if ($address['CONTACT_NAME'] == 'Country') {
                                if ($display_name > 0) {
                                    $country = $this->Property_Model->select_country(array('countryID' => $display_name));
                                    echo '<span class="hpp-user-name">' . $country[0]['countryName'] . '</span>';
                                } else {
                                    echo '<span class="hpp-user-name">' . $display_name . '</span>';
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
            </div>
        </div> <!-- End of account-setting-area-->
    </div> <!-- End of clear -->
    <!-- End Mailing Address -->

    <!-- Social Media Information -->
    <div class="clear">

        <br>
        <hr>
        <br>
        <div class="contact-info-area paddX-30" id="social_info"> 
            <div class="col-md-11 profile-title">
                <h4> Social Media Profile : </h4> 
            </div>

            <div class="col-sm-12">
                <?php
                if (is_array($social) && sizeof($social) > 0) :
                    foreach ($social as $socialItem):
                        $socialTypeId = $socialItem['CONTACT_TYPE_ID'];
                        $socialInfo = $this->user->any_where(array('CONTACT_TYPE_ID' => $socialTypeId, 'USER_ID' => $userID, 'c_contact_info'));
                        //                                    echo '<pre>';
                        //                                    print_r($contactInfo);
                        if (is_array($socialInfo) && sizeof($socialInfo)) {
                            $display_socialItem = $socialInfo[0]['CONTACT_NAME'];
                        } else {
                            $display_socialItem = '';
                        }
                        ?>
                        <div class="wrapper-col">
                            <span class="profile-lable"> <?= $socialItem['CONTACT_NAME']; ?> </span> <b> : </b>
                        <?php
                        echo '<span class="hpp-user-name">' . $display_socialItem . '</span>';
                        ?>
                        </div>

                            <?php
                        endforeach;
                    endif;
                    ?>
            </div>
        </div> <!-- End of account-setting-area-->
    </div> <!-- End of clear -->
    <!-- End Social Media Information -->

    <!-- Password Settings -->
    <div class="clear">

    </div>
</div> <!-- End of account-setting-area-->
