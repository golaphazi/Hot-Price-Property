<div class="page-head property-details-head"> 
    <div class="container">
        <div class="row">
            <div class="owl-carousels hpp-ads-carousel">
                 <?php
					$date = date("Y-m-d H:i:s");
					$queryData = $this->db->query("SELECT * FROM ads_hpp WHERE LOCATION = 'add_property' AND POSITION = 'Top' AND STATUS = 'Active' AND (START_DATE <= '".$date."' AND END_DATE_ADS >= '".$date."') ORDER BY ADS_ID DESC");
					$adsArray = $queryData->result_array();
					if(is_array($adsArray) AND sizeof($adsArray) > 0){
						foreach($adsArray AS $ads){
					?>
						<div class="ad-single-img"> <a href="<?= $ads['WEB_URL']; ?>" target="_blank" ><img src="<?= SITE_URL; ?><?= $ads['ADS_IMAGE']; ?>" class="ad-image" alt="Ads Image"></a> </div>
					
					<?php
						}
					}else{
					?>
						<div class="ad-single-img"> <a href="#"><img src="<?= SITE_URL; ?>assets/img/ad/300x150.jpg" class="image-responsive" alt="Ad Image"></a> </div>
						<div class="ad-single-img"> <a href="#"><img src="<?= SITE_URL; ?>assets/img/ad/300x150-3.jpg" class="image-responsive" alt="Ad Image"></a> </div>
						<div class="ad-single-img"> <a href="#"><img src="<?= SITE_URL; ?>assets/img/ad/300x150-4.jpg" class="image-responsive" alt="Ad Image"></a> </div>
						<div class="ad-single-img"> <a href="#"><img src="<?= SITE_URL; ?>assets/img/ad/300x150.jpg" class="image-responsive" alt="Ad Image"></a> </div>
						<div class="ad-single-img"> <a href="#"><img src="<?= SITE_URL; ?>assets/img/ad/300x150-3.jpg" class="image-responsive" alt="Ad Image"></a> </div>
					<?php
					}
					?>
            </div> <!-- End of hpp-ads-carousel -->
        </div> <!-- End of row -->
    </div> <!-- End of container -->
</div>
<!-- End page header -->

<!-- property area -->
<div class="content-area submit-property" style="background-color: #FCFCFC;">&nbsp;
    <div class="container">
        <div class="clearfix" > 
            <div class="wizard-container"> 
                <?php
                //echo $type;
                if($type == 'sell'){
                    ?>
                    <div class="Add_property">
                        <a class="btn primary-btn add_property" href="<?= SITE_URL; ?><?= $category?>?type=0" type="submit"> Add Property </a> 
                        <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>

                    </div>                   
                    <?php
                }else{
                    ?>
                    <h4 class="property_heading_add_property">Property type :</h4>
                    <div class="type_of_property">
                        <ol class="type_pro">
                            <?php
                            if (isset($property_type) AND is_array($property_type)) {
                            //echo $this->user->create_select($property_type, 'PROPERTY_TYPE_ID', 'PROPERTY_TYPE_NAME', '0');
                                foreach ($property_type AS $value):
                                    if ($value['PROPERTY_TYPE_ID'] > 0) {
                                        $active = '';
                                        ?>
                                        <li> 
                                            <?php 
                                            if ($type == $value['PROPERTY_TYPE_ID']) {
                                                $active = 'active_property'; 
                                                ?> 
                                                <span class="glyphicon glyphicon-ok"></span> <?php } ?>
                                                <a href="<?= SITE_URL; ?><?= $category?>?type=<?= $value['PROPERTY_TYPE_ID']; ?>" class="<?= $active; ?>"> <?= $value['PROPERTY_TYPE_NAME']; ?></a>
                                            </li>
                                            <?php
                                        }
                                    endforeach;
                                }
                                ?>
                            </ol>
                        </div>

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

                        <?php
                    }
                    if ($type != 0 AND $type != 'sell') {
			$roleId     = $this->session->userData('roleId');
                     ?>


                     <div class="wizard-card ct-wizard-orange" id="wizardProperty">
                        <?= form_open_multipart($category.'?type=' . $type . '', ['id' => 'property_form', 'name' => 'new_property_form']); ?>
                        <ul>
                            <li><a href="#step1" data-toggle="tab">Step 1 </a></li>
                            <li><a href="#step2" data-toggle="tab">Step 2 </a></li>
                            <li><a href="#step3" data-toggle="tab">Step 3 </a></li>
                            <li><a href="#step4" data-toggle="tab">Step 4 </a></li>
                            <li><a href="#step5" data-toggle="tab">Finished </a></li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane" id="step1">
                                <div class="row p-b-15">
                                    <h4 class="info-text"> Let's start with the basic information (with validation)</h4>
                                    <div class="col-sm-1 col-sm-offset-1">
                                            <!-- <div class="picture-container">
                                                 <div class="picture">
                                                     <img src="<?= SITE_URL; ?>assets/img/default-property.jpg" class="picture-src" id="wizardPicturePreview" title=""/>
                                                     <input type="file" id="wizard-picture">
                                                 </div> 
                                             </div>-->
                                         </div>
                                         <div class="col-sm-8">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Property name <small>(optional)</small></label>
                                                    <input name="propertyname" id="propertyname" type="text" class="form-control" placeholder="Enter name of property ...">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>Street No.</label>
                                                        <input name="street_no" list="street_no_data" id="street_no" type="text" class="form-control" placeholder="S Number ...">
                                                        <datalist id="street_no_data">
                                                            <?php
                                                            foreach ($PROPERTY_STRETT_DATA AS $list) {
                                                                echo '<option value="' . $list['PROPERTY_STREET_NO'] . '"> ' . $list['PROPERTY_STREET_NO'] . '</option>';
                                                            }
                                                            ?>
                                                        </datalist>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Street Address</label>
                                                        <input name="street_address" list="street_address_data" id="street_address" type="text" class="form-control" placeholder="Address ...">
                                                        <datalist id="street_address_data">
                                                            <?php
                                                            foreach ($PROPERTY_ADDRSS_DATA AS $list) {
                                                                echo '<option value="' . $list['PROPERTY_STREET_ADDRESS'] . '"> ' . $list['PROPERTY_STREET_ADDRESS'] . '</option>';
                                                            }
                                                            ?>
                                                        </datalist>
                                                    </div> 
                                                </div>
												<div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Postal Code</label>
                                                        <input name="post_name" list="post_name_data" id="post_name" type="text" class="form-control" placeholder="Postal / Zip Code ...">
                                                        <datalist id="post_name_data">
                                                            <?php
                                                            foreach ($PROPERTY_CITY_DATA AS $list) {
                                                                echo '<option value="' . $list['PROPERTY_CITY'] . '"> ' . $list['PROPERTY_CITY'] . '</option>';
                                                            }
                                                            ?>
                                                        </datalist>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Sunburn / City</label>
                                                        <input name="city_name" list="city_name_data" id="city_name" type="text" class="form-control" placeholder="City name ...">
                                                        <datalist id="city_name_data">
                                                            <?php
                                                            foreach ($PROPERTY_CITY_DATA AS $list) {
                                                                echo '<option value="' . $list['PROPERTY_CITY'] . '"> ' . $list['PROPERTY_CITY'] . '</option>';
                                                            }
                                                            ?>
                                                        </datalist>
                                                    </div>
                                                </div>
												<div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>State</label>

                                                        <input name="state_name" list="state_name_data" id="state_name" type="text" class="form-control" placeholder="S Number ...">
                                                        <datalist id="state_name_data">
                                                            <?php
                                                            foreach ($PROPERTY_STATE_DATA AS $list) {
                                                                echo '<option value="' . $list['PROPERTY_STATE'] . '"> ' . $list['PROPERTY_STATE'] . '</option>';
                                                            }
                                                            ?>
                                                        </datalist>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                              
                                                        <select id="lunchBegins" name="country_id" class="selectpicker" data-live-search="true" data-live-search-style="begins" onchange="select_currency(this.value)" title="select country">
                                                            <?php
                                                             
                                                            if (is_array($COUNTRYES) AND sizeof($COUNTRYES) > 0) {
                                                                foreach ($COUNTRYES AS $valueP):
                                                                    if (strlen($valueP['countryName']) > 0) {
                                                                        $icon = $active = '';
                                                                        ?>
                                                                        <?php
                                                                        if ($select_country == $valueP['countryID']) {
                                                                            $active = 'selected';
                                                                            $icon = '<span class="glyphicon glyphicon-ok"></span>';
                                                                        }
                                                                        ?> 
                                                                        <option value="<?= $valueP['countryID']; ?>" <?= $active; ?>><?= $valueP['countryName']; ?></option>
                                                                        <?php
                                                                    }

                                                                endforeach;
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">											
                                                <div class="form-group">
                                                   Property Ownership <small>(required)</small>
                                                    <?php						
                                                        if($roleId == 4){
                                                                $onwerId = 3;
                                                        }else{
                                                                $onwerId = 4;
                                                        }
                                                        //echo $onwer;
                                                        if (is_array($property_OWNER) AND sizeof($property_OWNER) > 0) {
                                                            foreach ($property_OWNER AS $onwer):
                                                                if($onwer['OWNER_ID'] == $onwerId){
                                                                $check = 'checked';

                                                        ?>
                                                            <input name="property_wonership" id="propertywonership__<?= $onwer['OWNER_ID']; ?>" value="<?= $onwer['OWNER_ID']; ?>" <?= $check;?> type="radio" class="form-control">  <label for="propertywonership__<?= $onwer['OWNER_ID']; ?>"> <?= $onwer['OWNER_NAME']; ?> </label>&nbsp;&nbsp; 

                                                        <?php                                                                }
                                                            endforeach;
                                                        }
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                    <label for="propertyprice">Property Asking Price <small>(required)</small></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon show-currency-code" id="show_currency_code"> <?= $select_country_code;?> </span>
                                                        <input name="propertyprice" id="propertyprice"  onkeyup="removeChar(this);" onblur="number_format(this)" type="text" class="form-control" aria-describedby="basic-addon3" placeholder="Property price ...">
                                                     </div>
                                                </div> 

                                        </div> <!-- end of col-md-6-->
                                    </div> <!--end of row p-b-15 -->
                                </div> <!--  End step 1 -->

                                <div class="tab-pane" id="step2">
                                    <h4 class="info-text"> Tell us someone about your property. </h4>
                                    <div class="row">

                                        <div class="col-sm-12"> 
                                            <div class="col-sm-12"> 
                                                <div class="form-group">
                                                    <label>Property Details Description :</label>
                                                    <textarea id="discrition" name="discrition"  style="display:none"></textarea>
                                                        <?php $editor['id'] = 'discrition';
                                                        $this->load->view('Next_editor/editor', $editor); ?>
                                                </div> 
                                            </div> 
                                        </div>

                                        <div class="col-sm-12">
                                            <?php
                                            if (sizeof($dynamic_filed) > 0) {
                                                foreach ($dynamic_filed AS $value) {
                                                    $this->Property_Model->filed_id = $value->ADD_FILED_ID;
                                                    $col = 3;
                                                    if ($value->FILED_TYPE == 'text_select') {
                                                            //$col = 4;
                                                    }
                                                    ?>
                                                    <div class="col-sm-<?= $col; ?>">
                                                        <div class="form-group">
                                                            <label><?= $value->FILED_NAME; ?> :</label>
                                                            <?= $this->Property_Model->create_filed($value->FILED_TYPE, $value->FILED_ID_NAME, $value->FILED_NAME) ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-12 padding-top-15">  
                                            <h4 class="info-text"> 
                                                Add More information ? <br />
                                                <small>( If you want, you can arrange more additional fields as bellow )</small>
                                            </h4>
                                            <div id="main_div">
                                                <div class="form-group" id="table__1">
                                                    <div class="form-row">
                                                        <div class="col-md-4">
                                                            <label for="exampleInputName"> <strong> Field Headding Name - 1 : </strong></label>
                                                            <input class="form-control" id="headding__1" name="headding[]" type="text" value="" placeholder="Enter Aditional Field-1 name here..">

                                                        </div>
                                                        <div class="col-md-6" id="value_remove__1"> <label for="exampleInputName"> <strong>Field Value - 1 : </strong></label>
                                                            <input class="form-control" id="value__1" name="value[]" type="text" value="" placeholder="Enter Additioanl Field-1 value here..">
                                                        </div>
                                                        <div class="col-md-1" id="button_remove__1"> <span class="fa fa-plus class_add" onclick="addMilestone(1)"></span> </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br/>
                                    </div>
                                </div>
                                <!-- End step 2 -->

                                <div class="tab-pane" id="step3">                                        
                                    <h4 class="info-text">Give us somme images and videos ? </h4>
                                    <div class="row">  
                                        <div class="col-sm-6">

                                            <div class="form-group step3_property">
                                                <div class="col-sm-9" id="append_image">
                                                    <label>Chose Images <small>( Select multiple images for your property )</small></label>
                                                    <p>
                                                        <span class="glyphicon glyphicon-file shadow_image" id="show_image__0"></span>
                                                        <img src="<?= SITE_URL; ?>assets/img/default-property.jpg" class="picture-src_property" id="show_property_images__0" title=""/>
                                                        <input class="form-control select_image" name="property_image[]" type="file" id="property_images__0" onchange="readURL(this)">

                                                    </p>
                                                </div>
                                                <div class="col-sm-3" id="add_more_div">
                                                    <label>Add More</label>
                                                    <p><span class="glyphicon glyphicon-plus add_more_button" id="add_more_button" onClick="add_more_image()"></span></p>
                                                </div>	
                                            </div>

                                        </div>
                                        <div class="col-sm-6"> 
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="property-video">Video type:</label>
                                                        <select class="form-control" name="video_type" id="video_type_0" onchange="select_video(this.value)">
                                                            <?php
                                                            foreach ($select_video_type as $vType) {
                                                                echo '<option value="' . $vType['VIDEO_TYPE_ID'] . '">' . $vType['TYPE_NAME'] . '</option>';
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="property-video">Property video :</label>
                                                        <input class="form-control" id="property_video" value="" placeholder="http://www.youtube.com, http://vimeo.com" name="property_video" type="text">
                                                    </div> 
                                                </div>
                                            </div> <!--end of row -->  


                                            <div class="row"> 
                                                <div class="col-md-12"><label><h5 class="info-text">Give the information of nearest School/College/Shoping Center..</h5></label></div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="property-video">School/College/Shoping Center:</label>
                                                        <input class="form-control" value="" placeholder="Enter School/College/Shoping Center" id="org_name_0" name="org_name[]" type="text">
                                                    </div> 
                                                </div>
                                                <div class="col-md-3 paddL-0">
                                                    <div class="form-group">
                                                        <label for="property-video">Distance(km) :</label>
                                                        <input class="form-control" value="" placeholder="1km" onkeyup="removeChar(this);" id ="distance_0" name="distance[]" type="text">
                                                    </div> 
                                                </div>

                                                <div class="col-md-3 paddL-0">
                                                    <div class="form-group">
                                                        <label for="property-video">Location(Optional):</label>

                                                        <select class="form-control" name="location[]" id="location_0">
                                                            <option value="">Select once</option>
                                                            <?php
                                                            foreach ($location_near as $location) {
                                                                echo '<option value="' . $location['LOCATION_ID'] . '">' . $location['LOCATION_NAME'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12" id="add_location_div">
                                                    <p><span class="glyphicon glyphicon-plus add_more_button  pull-right" id="add_location_button" onClick="add_more_location()"></span></p>
                                                </div>
                                            </div> <!--end of row -->  

                                        </div> <!--end of col-md-6 -->
                                    </div>
                                </div>
                                <!--  End step 3 -->

                                <!-- Start Step - 4 -->    
                                <div class="tab-pane" id="step4">                                        
                                    <h4 class="info-text">If you want your property to be <strong>"HOT PRICE"</strong> or <strong>"AUCTION"</strong>, then choose one of the options below. Otherwise Press Skip/Next. ? </h4>
                                    <div class="row">  
                                        <div class="col-md-12 select_type_radio">
                                            <div class="form-group paddX-15 HotPriceLink">
                                                <p class="text-left"><input type="radio" name="add_property_other_option" value="normal" checked="checked" id="add_property__normal" onchange="chancge_add_other(this.value);" >  <label for="add_property__normal" onclick="chancge_add_other(add_property__normal.value);" > &nbsp;&nbsp; Normal Property ? </label></p>
                                                
                                            </div>
						<div class="form-group  paddX-15 HotPriceLink">
                                                <p><input type="radio" name="add_property_other_option" value="hot" id="add_property__hot" onchange="chancge_add_other(this.value);"> <label for="add_property__hot" onclick="chancge_add_other(add_property__hot.value);" >&nbsp;&nbsp;  Do you want to add your property to the Hot Price ?</label> </p>
                                                
                                            </div>
						<div class="form-group  paddX-15 AuctionLink">
                                                <p> <input type="radio" name="add_property_other_option" value="auction" id="add_property__auction" onchange="chancge_add_other(this.value);"> <label for="add_property__auction" onclick="chancge_add_other(add_property__auction.value);" >&nbsp;&nbsp; Do you want to add your property to the Auction ? </label> </p>
                                                
                                            </div>
                                        </div>
                                      
                                        <div class="col-md-6 add_auction_hot" id="display__hot">
                                            <div class="add_hot_price_form_wrapper paddX-15">
						<h4 class="info-text">Property Hot Price Information </h4>
                                                <label for="recipient-name" class="form-control-label">Property Hot Price:</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon show-currency-code" id="show_currency_code1"><?= $select_country_code;?> </span>
                                                    <input onblur="number_format(this)" onkeyup="removeChar(this)"  type="text" name="offer_price" class="form-control" id="offerPrice" placeholder="00,000.00">
                                                </div>
                                                <div class="form-group">
                                                    <label for="start-date" class="form-control-label padd-T-15">Start Date: <small>(  Time should be 24 hours format  ) </small> </label>
                                                    <input type="text" name="hot_price_start_date" id="hotPriceStartDate" class="form-control datepickerStartDate" placeholder="Ex: YYYY-mm-dd H:m"> 
                                                </div>
                                                <div class="form-group">
                                                    <label for="end-date" class="form-control-label">Dateline:<small>(  How long will the offer from the start date  ) </small> </label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <input type="text" name="hot_price_end_date" id="hotPriceEndDate__0" class="form-control datepickerEndDate_00" placeholder="Ex: 3"> 
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select class="form-control" name="dateType">
                                                                <option value="hours">Hours</option>
                                                                <option value="days" selected>Days</option>
                                                                <option value="months">Months</option>
                                                            </select>
                                                        </div>
                                                    </div>                         
                                                </div> <!-- End of form-group -->
                                            </div> <!-- End of add_hot_price_form_wrapper -->

                                        </div><!-- End of add_hotprice-->

                                        <div class="col-md-6 add_auction_hot" id="display__auction">
                                            <div class="add_auction_form_wrapper paddX-15">
                                                <h4 class="info-text">Property Auction Information </h4>
                                                <label for="offerStartPrice" class="form-control-label">Offer Start Price:</label>
						<div class="input-group">
                                                    <span class="input-group-addon show-currency-code" id="show_currency_code2"><?= $select_country_code;?> </span>
                                                    <input onblur="number_format(this)" onkeyup="removeChar(this)"  type="text" name="offer_start_price" class="form-control" id="offerStartPrice" placeholder="00,000.00">
                                                </div>
                                                
                                                <label for="offerWinPrice" class="form-control-label padd-T-15">Offer Win/Reserve Price:</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon show-currency-code" id="show_currency_code3"><?= $select_country_code;?> </span>
                                                    <input onblur="number_format(this)" onkeyup="removeChar(this)"  type="text" name="offer_win_price" class="form-control" id="offerWinPrice" placeholder="00,000.00">
                                                </div>
                                                <div class="form-group">
                                                    <label for="start-date" class="form-control-label padd-T-15">Offer Start Date: <small>(  Time should be 24 hours format  ) </small> </label>
                                                    <input type="text" name="offer_start_date" id="auctionStartDate" class="form-control datepickerStartDate" placeholder="Ex: YYYY-mm-dd H:m">                           
                                                </div>
                                                <div class="form-group">
                                                    <label for="end-date" class="form-control-label">Dateline:<small>(  How long will the offer from the start date  ) </small> </label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <input type="text" name="offer_end_date" id="hotPriceEndDate__0" class="form-control datepickerEndDate_00" placeholder="Ex: 3"> 
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select class="form-control" name="dateType">
                                                                <option value="hours">Hours</option>
                                                                <option value="days" selected>Days</option>
                                                                <option value="months">Months</option>
                                                            </select>
                                                        </div>
                                                    </div>                         
                                                </div>

                                                <div class="form-group padding-bottom-40">
                                                    <p>
                                                        <label ><strong>Terms and Conditions</strong></label>
                                                        You must submit the 5% price of the <b>Offer Start Price</b> to the HPP joint vencher account for Property Auction.Which is refundable after close/complete/reject Auction.
                                                    </p>

                                                    <div class="TermsCheckBox" style="width:100%;">
                                                        <input type="checkbox" for="auctionPaumentTerms" name="auctionPaumentTerms" value="Agree" id="auctionPaumentTerms"/>
							<label for="auctionPaumentTerms" class="errorLabel"> <strong>Accept termes and conditions.</strong></label>
                                                    </div> 
                                                </div> <!-- end of form-group -->
                                            </div> <!-- End of add_auction_form_wrapper -->

                                        </div><!-- End of add_auction -->


                                    </div><!-- row-->
                                </div><!-- End of tab-pane-->
                                <!--  End step 4 -->


                                <div class="tab-pane" id="step5">                                        
                                    <h4 class="info-text"> Finished and submit </h4>
                                    <div class="row">  

                                        <div class="col-sm-12">
                                            <div class="">
                                                <p>
                                                    <label><strong>Terms and Conditions</strong></label>
                                                    By accessing or using  GARO ESTATE services, such as 
                                                    posting your property advertisement with your personal 
                                                    information on our website you agree to the
                                                    collection, use and disclosure of your personal information 
                                                    in the legal proper manner
                                                </p>

                                                <p>
                                                    <input type="checkbox" name="terms" id="terms"/> <label for="terms" class="terms_lebel"><strong>Accept terms and condition.</strong>
                                                    </label>
                                                </p> 

                                            </div> 
                                        </div><!-- end of col-md-12 -->
                                    </div> <!-- End of row -->
                                </div> <!--  End step 4 -->

                            </div> <!-- of tab-content -->

                            <div class="wizard-footer">
                                <div class="pull-right">
                                    <input type='button' class='btn btn-next btn-primary' name='next' value='Next' />
                                    <input type='submit' class='btn btn-finish btn-primary' name='new_property_form' value='Finish' />
                                </div>

                                <div class="pull-left">
                                    <input type='button' class='btn btn-previous btn-default' name='previous' value='Previous' />
                                </div>
                                <div class="clearfix"></div>                                            
                            </div>	
                            <?= form_close(); ?>
                        </div>

                        <?php } ?>

                        <!-- End submit form -->
                    </div> 
                </div>
            </div>
        </div>

