<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-6 col-md-offset-2  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle"><srtong>::</srtong> Add Admin User <srtong>::</srtong> </h4>
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
                    
                    <?= form_open('', ['id' => 'addAdminUserForm' , 'name' => 'addAdminUser'] ); ?>
                    
                    <div class="form-group">
                        <label for="adminfullname"><b> User Full Name : </b></label>
                        <input name="admin_full_name" id="adminfullname" type="text" class="form-control" placeholder="Enter Admin User Full Name ...">
                    </div>
                    <div class="form-group">
                        <label for="username"><b>User Type Name : </b></label>
                            <input name="user_name" id="username" type="text" class="form-control" placeholder="Editor ...">
                    </div>
                    <div class="form-group">
                        <label for="userrole"><b>Admin Role :</b> </label>
                        
                        <select name="admin_role" id="userrole" class="form-control" title="Please Select Admin User Role">
                            <option>Please Select...</option>
                            <option value="Admin">Admin</option>
                            <option value="Manager">Manager</option>
                            <option value="Manager">Editor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="emailid"><b>User Email ID : </b></label>
                            <input name="admin_email_id" id="emailid" type="email" onblur="checkVerifiedEmail(this.value);" class="form-control" placeholder="Enter Email Address ...">
                            <span id="res"></span>
                    </div>
                    <div class="form-group">
                        <label for="emailid"><b>Password : </b></label>
                        <input name="rel_password" id="relPassword" type="password" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="conPassword"><b>Confirm Password : </b></label>
                        <input name="con_password" id="conPassword" type="password" class="form-control" >
                    </div>
                    
                    <div class="col-md-12 marY-30">
                        <button type="submit" name="AddAdminUser" class="btn btn-default pull-right">Add User</button>
                    </div>
                    <?= form_close(); ?>
                    
                </div> <!-- End of hpp_wpapper_table --> 
            </div> <!-- End of properties-page --> 
        </div>  <!-- End of row -->            
    </div>
</div>