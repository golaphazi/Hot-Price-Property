<div class="page-head"> 
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title">Recovery Password/ Sign in </h1>               
            </div>
        </div>
    </div>
</div>
<!-- End page header -->


<!-- register-area -->
<div class="register-area" style="background-color: rgb(249, 249, 249);">
    <div class="container">
        <div class="row">
            <div class="text-center"><?= $SMS; ?></div>
            <!-- Start For Got Password Section -->
            <div class="col-md-6 col-md-offset-3">
                <div class="box-for overflow">                         
                    <div class="col-md-12 col-xs-12 login-blocks">
                        <h2>Recovery Password</h2>						
                        <?= form_open('', ['id' => 'forgot_password_form', 'name' => 'user_forgot_password_form']); ?>
                        <div class="form-group">
                            <label for="login_email">Your Registered Email </label>
                            <input type="email" class="form-control" name="login_email" id="login_email" placeholder="Enter Your Valid Email">
                            <span class="emailErr"><?= $emailErr; ?></span>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="forGotPassword" class="btn btn-default">Submit</button>
                        </div>
                        <?= form_close(); ?>
                        <br/>

                        <div class="text-center createNewAccount">
                            <a href="<?= SITE_URL; ?>login" class="">Create New Account !</a>
                        </div>
                    </div>
                </div><!-- End of box-for -->
            </div><!-- End of col-md-offset-3 -->
            <!-- End For Got Password Section -->
        </div> <!--End of row -->
    </div> <!--End of container -->
</div><!--End of register-area -->   


