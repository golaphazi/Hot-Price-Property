 <div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">Admin login</h1>               
                    </div>
                </div>
            </div>
        </div>
        <!-- End page header -->
 

        <!-- register-area -->
        <div class="register-area" style="background-color: rgb(249, 249, 249);">
            <div class="container">

                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="box-for overflow">                         
                        <div class="col-md-12 col-xs-12 login-blocks">
                            <h2>Login  </h2>
							 <p><?= $MSG;?>	</p>						
                            <?= form_open('hpp/admin/index/?page='.$ACTION.'', ['id' => 'user_login_form', 'name' => 'user_login_form']);?>
                                <div class="form-group">
                                    <label for="login_email">Email</label>
                                    <input type="text" class="form-control" name="login_email" id="login_email">
                                </div>
                                <div class="form-group">
                                    <label for="login_password">Password</label>
                                    <input type="password" class="form-control" id="login_password" name="login_password">
                                </div>
								
                                <div class="text-center">
                                    <button type="submit" name="user_login_admin" class="btn btn-default"> Log in</button>
                                </div>
                            <?= form_close();?>
                            <br/>
                           
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>   
		
		
		