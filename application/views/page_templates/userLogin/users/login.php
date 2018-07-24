<div class="page-head"> 
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title">Home New account / Sign in </h1>               
            </div>
        </div>
    </div>
</div>
<!-- End page header -->


<!-- register-area -->
<div class="register-area" style="background-color: rgb(249, 249, 249);">
    <div class="container">
        
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
        
        <div class="col-md-6">
            <div class="box-for overflow">
                <div class="col-md-12 col-xs-12 register-blocks">
                    <h2>Register  </h2>
                    <div class="wizard-container padd_top_0"> 

                        <div class="wizard-card ct-wizard-orange sign_up_wizard-card padd_top_0" id="wizardProperty">
                            <?= form_open('login/', ['id' => 'user_signup_form', 'name' => 'user_signup']); ?>
                            <ul>
                                <li><a href="#step1" data-toggle="tab">Step 1 </a></li>
                                <li><a href="#step2" data-toggle="tab">Step 2 </a></li>
                                <li><a href="#step3" data-toggle="tab">Step 3 </a></li>
                                <li><a href="#step4" data-toggle="tab">Finished </a></li>
                            </ul>

                            <div class="tab-content">
                                <center><?= $massege; ?></center>
                                
                                <div class="tab-pane" id="step1">
                                    <div class="row p-b-15 hpp-user-role">
                                        <h4 class="info-text"> Please Select User Type </h4>

                                        <div class="col-sm-12 hpp-sign-up">
                                            <div class="form-group col-md-12 text-center hppUserType">
                                                <?php
                                                if (is_array($user_type) AND sizeof($user_type) > 0):
                                                    $i = 1;
                                                    foreach ($user_type AS $value):
                                                        //echo $value['ROLE_NAME'];
                                                        $icon = 'glyphicon glyphicon-scale';
                                                        if ($i % 2 == 0) {
                                                            $icon = 'glyphicon glyphicon-xbt';
                                                        }
                                                 ?>

                                                <input class="selectUserType" name="account_type" id="account_type__<?= $value['USER_TYPE_ID'];?>" value="<?= $value['USER_TYPE_ID'];?>" <?php if($account_type == $value['USER_TYPE_ID']){echo 'checked="checked"';}?> type="radio">  
                                                <label for="account_type__<?= $value['USER_TYPE_ID']; ?>"><div class="lavel_type hpplavelType"  id="lavel_type__<?= $value['USER_TYPE_ID']; ?>" onclick="select_type(<?= $value['USER_TYPE_ID']; ?>);" <?php if ($account_type == $value['USER_TYPE_ID']) { echo 'style="border-color:#FDC600;"';} ?>>
                                                <div class="image_sex"><span class="<?= $icon; ?>"></span></div><div class="sex_name"> <?= $value['TYPE_NAME']; ?></div></div> </label> &nbsp;								   

                                                <?php
                                                        $i++;
                                                    endforeach;
                                                endif;
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div><!--end of step 1-->
                                
                                <div class="tab-pane" id="step2">
                                    <div class="row p-b-15 ">
                                        <h4 class="info-text" id="skip_massage"> Plese Select User Role </h4>

                                        <div class="col-sm-12 hpp-sign-up">
                                            <div class="form-group col-md-12 text-center" id="step2_user_skip">
                                                <?php
                                                if (is_array($role) AND sizeof($role) > 0):
                                                    $i = 1;
                                                    foreach ($role AS $value):
                                                        //echo $value['ROLE_NAME'];
                                                        $icon = 'glyphicon glyphicon-user';
                                                        if ($i % 2 == 0) {
                                                            $icon = 'glyphicon glyphicon-home';
                                                        }
                                                 ?>

                                                <input name="account_for" id="account_for__<?= $value['ROLE_ID']; ?>" class="category_account" value="<?= $value['ROLE_ID']; ?>" style="display:none !important;" <?php if ($account_for == $value['ROLE_ID']) {
                                                    echo 'checked="checked" ';
                                                } ?> type="radio"> 
                                                <label for="account_for__<?= $value['ROLE_ID']; ?>"><div class="lavel"  id="lavel__<?= $value['ROLE_ID']; ?>" onclick="select_for(<?= $value['ROLE_ID']; ?>);" <?php if ($account_for == $value['ROLE_ID']) {
                                                    echo 'style="border-color:#FDC600;"';
                                                } ?>>
                                                <div class="image_sex"><span class="<?= $icon; ?>"></span></div><div class="sex_name"> <?= $value['ROLE_NAME']; ?></div></div> </label> &nbsp;								   

                                                <?php
                                                        $i++;
                                                    endforeach;
                                                endif;
                                                ?>

                                            </div>
											
                                        </div>
                                    </div>
                                </div><!--end of step 2 -->
                                
                                <div class="tab-pane" id="step3">
                                    <div class="row p-b-15  ">
                                        <h4 class="info-text"> Please enter account information</h4>
                                        <div class="col-sm-12">
                                            
                                            <div class="form-group">
                                                <label for="full_name" id="name_for_company"><b>Full Name</b></label>
                                                <input type="text" class="form-control" value="<?= $full_name; ?>" name="full_name" id="full_name">
                                            </div>
                                            
                                            <div class="form-group" id="agent_license_no">
                                                <label for="agent_license"><b>Agent License No.</b></label>
                                                <input type="text" class="form-control" value="" name="agent_license" id="agent_license">
                                            </div>
                                            
                                            <div class="form-group" id="agent_abn_number">
                                                <label for="agent_abn_number" id="agent_abn_number"><b>Agent ABN Number.</b></label>
                                                <input type="text" class="form-control" value="" name="agent_abn_number" id="agent_abn_number">
                                            </div>

                                            <div class="form-group">
                                                <label for="mobile_no"><b>Mobile No</b></label>
                                                <input type="tel" class="form-control" onkeyup="removeDate(this);" value="<?= $mobile_no; ?>"  id="mobile_no" name="mobile_no">
                                            </div>

                                        </div>
                                        <div class="row" id="gender_show">
                                            <div class="form-group col-md-12 padX-30">
                                                <label for="sex"><b>Gender : </b>&nbsp;</label>

                                                <input name="gender" id="gender" class="" value="Male" style=";" <?php if ($gender == 'Male') {
                                                    echo 'checked="checked"';
                                                } ?> type="radio"> 
                                                <label for="gender">Male &nbsp; </label>
                                                <input name="gender" id="gender1" value="FeMale" class="" style="" <?php if ($gender == 'FeMale') {
                                                    echo 'checked="checked"';
                                                } ?>  type="radio"> 
                                                <label for="gender1">Female </label>
                                            </div>
                                        </div>

                                    </div>
                                </div><!--end of step 3 -->

                                <div class="tab-pane" id="step4">
                                    <div class="row p-b-15  ">
                                        <h4 class="info-text"> Please set email and password</h4>

                                        <div class="col-sm-12">

                                            <div class="form-group">
                                                <label for="email_address"><b>Email</b></label>
                                                <input type="email" class="form-control" onkeyup="removeSpace(this)" name="email_address" id="email_address" value="<?= $email_address; ?>" >
                                            </div>
                                            <div class="form-group">
                                                <label for="rel_password"><b>Password</b></label>
                                                <input type="password" class="form-control" name="rel_password" id="rel_password" value="<?= $rel_password; ?>" >
                                            </div>
                                            <div class="form-group">
                                                <label for="con_password"><b>Confim Password</b></label>
                                                <input type="password" class="form-control" name="con_password" id="con_password" value="<?= $con_password; ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end of step 4 -->
									
                            </div>

                            <div class="wizard-footer">
                                <div class="pull-right">
                                    <input type='button' class='btn btn-next btn-primary' name='next' value='Next' />
                                    <input type='submit' class='btn btn-finish btn-primary ' name='user_signup' value='Finish' />
                                </div>

                                <div class="pull-left">
                                    <input type='button' class='btn btn-previous btn-default' name='previous' value='Previous' />
                                </div>
                                <div class="clearfix"></div> 
								<div>
									<div class="privacy-policy">
										<div class="privacy-statement">Please view our <span onclick="togglePolicyContainer()">Personal Information Collection Statement</span></div> 
										<div class="privacy-container" id="hidden_id" style="display: none;">
											<div class="rui-disclaimer">We will collect and use your personal information (which may include cookies we collect through your use of hotpriceproperty.com and our other websites) to give you a personalised user experience (eg. recommending properties you may be interested in or receiving saved searches by email) and to promote the services of hotpriceproperty.com and third parties. Our <a target="_blank" href="http://hotpriceproperty.com/terms/">Privacy Policy</a> further explains how we collect, use and disclose personal information and how to access, correct or complain about the handling of personal information.
											</div>
										</div>
									</div>
								</div>	
                            </div><!--end of wizard footer-->

                            <?= form_close(); ?><!--end of sign up form-->
                        </div>
                    </div> <!--end of wizard-container-->
                </div>
            </div>
        </div> <!--end of col-md-6-->

        <!-- Start User Login Section -->
        <div class="col-md-6">
            <div class="box-for overflow">                         
                <div class="col-md-12 col-xs-12 login-blocks ForgotPassword">
                    <h2>Login  </h2>
                    <p><?= $MSG; ?>	</p>						
                    <?= form_open('login?page=' . $ACTION . '', ['id' => 'user_login_form', 'name' => 'user_login_form']); ?>
                    <div class="form-group">
                        <label for="login_email">Email</label>
                        <input type="text" class="form-control" name="login_email" id="login_email">
                    </div>
                    <div class="form-group">
                        <label for="login_password">Password</label>
                        <input type="password" class="form-control" id="login_password" name="login_password">
                    </div>
                   
                    <div class="text-center">
                        <button type="submit" name="user_login" class="btn btn-default"> Log in</button>
                    </div>
                    <?= form_close(); ?>
                    <br/>
                    
                    <div class="pull-left">
                        <!--<a href="<?= SITE_URL; ?>forgot-password/" class="">Forgot Password..!</a>-->
                        <a href="<?= SITE_URL;?>forgot-password" class="">Forgot Password..!</a>
                    </div>
                    <div class="pull-right">
                        <a href="<?= SITE_URL;?>hpp/admin" target="_blank" class="">Admin Login</a>
                    </div>
                    
                </div>

            </div>
        </div>

    </div>
</div>   

<script>
function togglePolicyContainer(){
	//alert();
	$("#hidden_id").toggle();
}
</script>
