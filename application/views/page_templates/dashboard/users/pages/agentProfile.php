		
<?php
$CI = & get_instance();
?>
	<?php
		if(strlen($userInfo->PROFILE_IMAGE) > 6){
			$profile_image = $userInfo->PROFILE_IMAGE;
		}else{
			$profile_image = 'assets/img/client-face1.png';
		}
		
		$role_search = $this->user->any_where(array('ROLE_ID' => $userInfo->ROLE_ID), 'mt_s_user_role', 'ROLE_NAME');
		$type_search = $this->user->any_where(array('USER_TYPE_ID' => $userInfo->USER_TYPE_ID), 'mt_s_user_type', 'TYPE_NAME');
	?>
	<div class="page-head agent-profie" id="home"> 
            <div class="container">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 profile_agent_div" >
					</div>
						<div class="col-xs-4 col-sm-2 dealer-face profile-image-agent">
							<img src="<?= SITE_URL; ?><?= $profile_image;?>" class="img-circle" alt="<?= $userInfo->USER_LOG_NAME;?>">
							
						</div>
						<div class="col-xs-12 col-sm-6 profile-name-agent">
							<h3 class="dealer-name agent-name">
								<?= $userInfo->FULL_NAME;?>
								<?php if(strlen($userInfo->SUB_NAME) > 0){?><span><?= $userInfo->SUB_NAME;?></span>  <?php } ?>      
							</h3>
						</div>
								   
                </div>
            </div>
        </div>
		<div class="container">
             <div class="row1">
				<div class="col-xs-12 col-sm-12 profile-manu-agent marY-30">
<!--					<ul>
						<li> <a href="<?= SITE_URL ?>agent?id=<?= $progile_id;?>">Home </a> </li>
						<li> <a href="<?= SITE_URL ?>agent?id=<?= $progile_id;?>&#about">About </a> </li>
						<li> <a href="<?= SITE_URL ?>agent?id=<?= $progile_id;?>&#contact_seller">Contact </a> </li>
					</ul>-->
				</div>
			</div>
			<div class="clearfix ">
				
				<div class="col-md-4 p0 ">
					<aside class="sidebar sidebar-property blog-asside-right">
						<div class="dealer-widget agent-dealer-widget">
							<div class="dealer-content">
								<div class="inner-wrapper">
									<div class="clear">
										<div class="col-xs-12 col-sm-12 profile-name-agent role_agent">
											<h3 class="dealer-name agent-name">
												   <?= $role_search;?>
												   <?php if(strlen($type_search) > 0){?><span><?= $type_search;?></span>  <?php } ?> 
											</h3>
										</div>
										<div class="col-xs-12 col-sm-12 ">
											
											<p class="overview"><?= $userInfo->OVERVIEW;?></p>
											
											<div class="dealer-social-media">
												<h3 class="social-profile"> Social Account</h3>
												<?php
												$socialInfo = $this->Property_Model->any_type_where(array('CONTAC_TYPE_TYPE' => 'Social', 'CONTACT_TYPE_STATUS' => 'Active'), 'mt_c_contact_type');
												$num = '';
												$class = array('twitter', 'facebook', 'gplus', 'linkedin', 'instagram');
												$i =0;
												foreach($socialInfo AS $numBer){
													$numBer1 = $this->Property_Model->any_type_where(array('CONTACT_TYPE_ID' => $numBer['CONTACT_TYPE_ID'], 'USER_ID' => $userInfo->USER_ID), 'c_contact_info');
													if(sizeof($numBer1) > 0){
														if(strlen($numBer1[0]['CONTACT_NAME']) > 0){
														?>
														<a class="<?= $class[$i];?>" target="_blank" href="<?= $numBer1[0]['CONTACT_NAME'];?>">
															<i class="<?= $numBer['CONTACT_TYPE_ICON']?>"></i>
														</a>
														<?php
														}
													}
													$i++;
												}
												?>
												
											</div>

										</div>
									</div>

									<div class="clear">
										<div class="col-xs-12 col-sm-12 ">
											<div class="dealer-social-media">
												<h3 class="social-profile"> Contact Information</h3>
												<ul class="dealer-contacts">                                       
													<?php
													$contactInfo = $this->Property_Model->any_type_where(array('CONTAC_TYPE_TYPE' => 'Basic', 'CONTACT_TYPE_STATUS' => 'Active'), 'mt_c_contact_type');
													$num = '';
													foreach($contactInfo AS $numBer){
														$numBer2 = $this->Property_Model->any_type_where(array('CONTACT_TYPE_ID' => $numBer['CONTACT_TYPE_ID'], 'USER_ID' => $userInfo->USER_ID), 'c_contact_info');
														if(sizeof($numBer2) > 0){
															if(strlen($numBer2[0]['CONTACT_NAME']) > 0){
																echo ' <li><i class="'.$numBer['CONTACT_TYPE_ICON'].'"> </i> '.$numBer2[0]['CONTACT_NAME'].'</li>';
															}
														}
													}
													?>
													
												</ul>
											
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>

					</aside>
				</div>
				<div class="col-md-8 single-property-content hpp_wpapper_table">
					 <?php
					 $get_search = isset($_GET['search']) ? $_GET['search'] : 'all';
					 ?>
					 <div class="col-md-5">
					 <ul>
						<li class="<?php if($get_search == 'all'){$nae = ''; echo 'active';}?>" ><a href="<?= SITE_URL ?>agent?id=<?= $progile_id;?>">All </a></li>
						<li class="<?php if($get_search == 'hot'){$nae = 'Hot';  echo 'active';}?>" ><a href="<?= SITE_URL ?>agent?id=<?= $progile_id;?>&search=hot" >Hot Price</a></li>
                                                <li class="<?php if($get_search == 'auction'){$nae = 'Auction';  echo 'active';}?>" ><a href="<?= SITE_URL ?>agent?id=<?= $progile_id;?>&search=auction" >Auction </a></li>
                                                <li class="<?php if($get_search == 'sell'){$nae = 'Sell';  echo 'active';}?>" ><a href="<?= SITE_URL ?>agent?id=<?= $progile_id;?>&search=sell" >Sell </a></li>
						<li class="<?php if($get_search == 'rent'){$nae = 'Rent';  echo 'active';}?>" ><a href="<?= SITE_URL ?>agent?id=<?= $progile_id;?>&search=rent" >Rent </a></li>
						
						
					</ul>
					</div>
					<div class="col-md-7 col-xs-4 col-sm-2 layout-switcher">
						<a class="layout-list" href="javascript:void(0);"> <i class="fa fa-th-list"></i>  </a>
						<a class="layout-grid active" href="javascript:void(0);"> <i class="fa fa-th"></i> </a>                          
					</div><!--/ .layout-switcher-->
					
					<div class="col-md-12 clear properties-page"> 
						
						<div id="list-type" class="proerty-th">															
							<?php
							if(is_array($select_property_by_user)  AND sizeof($select_property_by_user) > 0){
								foreach($select_property_by_user AS $property){
									if(strlen($property->PROPERTY_NAME) > 3  AND $property->PROPERTY_STATUS == 'Active'){
										$propertyId = $property->PROPERTY_ID;
										$primaryImage = $this->Property_Model->property_image(array('PROPERTY_ID' => $propertyId, 'DEFAULT_IMAGE' => 1));
										
										if(is_array($primaryImage) > 0){
											$pro_image = SITE_URL.$primaryImage[0]['IMAGE_LINK'].$primaryImage[0]['IMAGE_NAME'];
										}else{
											$pro_image = SITE_URL.'assets/img/demo/property-3.jpg';
										}
										$additional_sear 	 		 = $this->Property_Model->additional_property_filed($property->PROPERTY_ID);
							?>
								<!--Property Information show-->
									<div class="col-sm-6 col-md-4 p0">
										<div class="box-two proerty-item">
											<div class="item-thumb">
												<a href="<?= SITE_URL;?>preview?view=<?= $property->PROPERTY_URL?>" ><img src="<?= $pro_image;?>" alt="<?= $pro_image;?>" ></a>
												<?php if(sizeof($additional_sear) > 0){?>
												<div class="hot_price listItem">
													<ul>
														<?php
														foreach($additional_sear AS $filed):
														$filed_info = $this->Property_Model->any_type_where(array('ADD_FILED_ID' => $filed->ADD_FILED_ID, 'FILED_TYPE =' => 'number'), 'mt_p_property_additional_filed');
														if(is_array($filed_info) AND sizeof($filed_info) > 0){
														?>
															<li><img src="<?= SITE_URL ?>icons/<?= $filed_info[0]['FILED_HTML'];?>" title="<?= $filed_info[0]['FILED_NAME'];?>"/> <span class="property-info-value"> <?= $filed->FILED_DATA; ?> </span></li>
														<?php } endforeach;?>
													</ul>
												</div>
												<?php } ?>
											</div>
											
											<div class="item-entry overflow">
												<h5><a href="<?= SITE_URL;?>preview/<?= $property->PROPERTY_URL?>/"> <?= substr($property->PROPERTY_NAME, 0,12);?> </a></h5>
												<div class="dot-hr"></div>
												<!--<span class="pull-left"><b> Area :</b> 120m </span>-->
												<span class="pull-left"><b> <?= substr($property->PROPERTY_STATE, 0,15);?> </span>
												<span class="proerty-price pull-right"> <?= number_format($property->PROPERTY_PRICE);?> <?= $property->CURRENCY_CODE;?>(<?= $property->CURRENCY_SAMPLE;?>)</span>
												<p style="display: none;"> <?= $CI->trim_text(strip_tags(preg_replace('/style[^>]*/', '', htmlspecialchars_decode($property->PROPERTY_DESCRIPTION))), 120); ?></p>
												
											</div>


										</div>
									</div> 

									<!--Property Information show end-->
								
						<?php
								} /*end if after foreach*/
							} /*end foreach*/
						}else{
							echo '<div class="alert alert-warning"> Sorry!!! could`t found property</div>'; 
						}
						?>
							</div>
						</div>
					
				</div>
			</div>
		</div>
<div class="marY-30"></div>
		<!--
		 <div class="properties-area recent-property" style="" id="contact_seller">
            <div class="container">  
                <div class="row">
                    <div class="col-md-12  pr0 padding-top-40 " style="margin-bottom:20px;">                    
                        <div class="col-md-12 clear headding"> 
                               
							<h4>Contact with <?= $role_search;?></h4>      

						</div> 
						<?php 
						$urlAgent =  'agent?id='.$progile_id.'&#contact_seller';
						?>
						 <?= form_open($urlAgent, ['id' => 'contact_to_form', 'name' => 'contact_to_form']); ?>
						<div class="col-md-12 clear body_content"> 
							<?php if(strlen($MASG) > 2){?><div class="alert alert-success"> <?= $MASG;?> </div> <?php }?>
							<div class="col-md-5">
								<div class="col-md-12">
									<div class="form-group">
										<label>Type of enquiry <small class="red"></small></label>
										<select name="<?= $contact_agent_type['Type of enquiry'];?>" class="form-control"  title="">
												<option value="" > Select once</option>            
												<option value="Property appraisal" > Property appraisal</option>            
												<option value="Selling a property" > Selling a property</option>            
												<option value="Property management" > Property management</option>            
												<option value="General enquiry" > General enquiry</option>            
												<option value="I'd like more information" > I'd like more information</option>            
												<option value="Other" > Other</option>            
										</select>					
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Message to  <?php if(strlen($type_search) > 0){?><span><?= $type_search;?></span>  <?php } ?>  <small class="red">*</small></label>
										<textarea id="<?= $contact_agent_type['Message to'];?>" name="<?= $contact_agent_type['Message to'];?>" placeholder="Explain the details of your enquiry..."></textarea>
									</div>
								</div>
								
							</div>
							<div class="col-md-5">
								<div class="col-md-12">
									<div class="form-group">
										<label for="name_contact">Name <small class="red">*</small></label>
										<input name="<?= $contact_agent_type['Name'];?>" id="<?= $contact_agent_type['Name'];?>" type="text" class="form-control" required placeholder="Enter name ...">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Email <small class="red">*</small></label>
										<input name="<?= $contact_agent_type['Email'];?>" id="<?= $contact_agent_type['Email'];?>"  onkeyup="removeSpace(this)" type="email" required class="form-control" placeholder="Enter email address ...">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Phone <small class="red">*</small></label>
										<input name="<?= $contact_agent_type['Phone'];?>" id="<?= $contact_agent_type['Phone'];?>" type="tel"  onkeyup="removeDate(this);" class="form-control" required placeholder="Enter phone ...">
									</div>
								</div>
								<div class="col-md-12">
									<button type="submit" name="contact_agent_message" class="btn btn-primary">Send</button>
								</div>
							</div>
						</div> 
					<?=  form_close();?>
                    </div> 
					
                </div>           
            </div>
        </div> -->
  