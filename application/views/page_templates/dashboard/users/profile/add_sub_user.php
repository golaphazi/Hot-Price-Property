<?php $CI =& get_instance(); ?>	
<div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">Welcome <span class="orange strong">Add New User</span></h1>               
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
                              <div class="col-sm-12">
												
									<div class="form-group">
										<label for="full_name" id="name_for_company"><b>Full Name</b></label>
										<input type="text" class="form-control" value="" name="full_name" id="full_name">
									</div>
									
									<div class="form-group">
										<label for="email_address"><b>Email</b></label>
										<input type="email" class="form-control" onkeyup="removeSpace(this)" name="email_address" id="email_address" value="" >
									</div>
									<div class="form-group">
										<label for="rel_password"><b>Password</b></label>
										<input type="password" class="form-control" name="rel_password" id="rel_password" value="" >
									</div>
									
									<div class="form-group">
										<label for="con_password"><b>Confim Password</b></label>
										<input type="password" class="form-control" name="con_password" id="con_password" value="" >
									</div>
									<div class="form-group">
										<label for="mobile_no"><b>Mobile No</b></label>
										<input type="tel" class="form-control" onkeyup="removeDate(this);" value=""  id="mobile_no" name="mobile_no">
									</div>
									

							</div>     
                        </div>                   
                    </div> <!-- End of properties-page --> 
                </div>  <!-- End of row -->            
            </div>
        </div>
  