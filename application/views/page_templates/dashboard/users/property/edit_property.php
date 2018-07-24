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
                        <div class="col-md-12 clear padd-bottom-70">
                            <h4 class="center sectionTitle"><srtong>::</srtong> Edit Property Content <srtong>::</srtong> </h4>
                            <div class="row">
                                <div class="col-xs-12">
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
                                </div> <!-- End of col-xs-12 -->
                            </div> <!-- End of row-->
                               
                            <div class="hpp_wpapper_content" id="basicInfo">
                                <h4 class="contentTitle"> Property Basic Information : </h4>
                                
                                <?= form_open( 'manage-property?edit='. $propertyID , [ 'id' => 'property_basic_info', 'class' => 'form-horizontal', 'name' => 'property_basic_info' ] ); ?>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label> Property Name &nbsp;&nbsp; : </label> 
                                    </div>
                                    <div class="col-xs-8">
                                        <input class="form-control" type="text" name="property_name" value="<?= $select_property->PROPERTY_NAME; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label> Property Type Name &nbsp;&nbsp; : </label> 
                                    </div>
                                    <div class="col-xs-8">
                                        <input class="form-control" type="text" name="property_type_name" value="<?= $select_property->PROPERTY_TYPE_NAME; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label> Property Street No &nbsp;&nbsp; : </label> 
                                    </div>
                                    <div class="col-xs-8">
                                        <input class="form-control" type="text" name="property_street_no" value="<?= $select_property->PROPERTY_STREET_NO; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label> Property Street Address &nbsp;&nbsp; : </label> 
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="text" name="property_street_address" value="<?= $select_property->PROPERTY_STREET_ADDRESS; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label> Property City &nbsp;&nbsp; : </label> 
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="text" name="property_city" value="<?= $select_property->PROPERTY_CITY; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label> Property State &nbsp;&nbsp; : </label> 
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="text" name="property_state" value="<?= $select_property->PROPERTY_STATE; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label> Property Country &nbsp;&nbsp; : </label> 
                                    </div>
                                    <div class="col-xs-8">
                                        <select name="property_country" class="form-control">
                                            <?php 
                                                foreach ( $countries as $country ){ ?>
                                                   <option <?php if( $select_property->PROPERTY_COUNTRY == $country->countryID ){ echo 'selected'; } ?>  value="<?= $country->countryID; ?>"> <?= $country->countryName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label> Property Ownership &nbsp;&nbsp; : </label> 
                                    </div>
                                    <div class="col-xs-8">
                                        <select name="property_ownership" class="form-control">
                                            <?php 
                                                foreach ( $property_owner as $pOwner ){ ?>
                                                   <option <?php if( $select_property->PROPERTY_WONERSHIP == $pOwner['OWNER_ID'] ){ echo 'selected'; } ?>  value="<?= $pOwner['OWNER_ID']; ?>"> <?= $pOwner['OWNER_NAME']; ?></option>
                                               <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <label> Property Price &nbsp;&nbsp; : </label> 
                                    </div>
                                    <div class="col-xs-8">
                                        <input onblur="number_format(this)" onkeyup="removeChar(this);" type="text" id="propertyprice" name="propertyprice" value="<?= number_format( $select_property->PROPERTY_PRICE, 2 ); ?>" class="form-control currency">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-3">
                                        <label> Property Description &nbsp;&nbsp; : </label> 
                                    </div>
                                    <div class="col-xs-9">
                                        <textarea name="property_description" id="property_description" style="display:none;" rows="4" class="form-control"><?= $select_property->PROPERTY_DESCRIPTION; ?></textarea>
										<?php $editor['id'] = 'property_description';
										$this->load->view('Next_editor/editor', $editor); ?>
									</div>
                                </div>
                                
                                <div class="col-xs-2 pull-right">
                                    <input type="submit" name="updateBasic" value="Update" class="btn btn-primary">
                                </div>
                                
                                <?= form_close(); ?>
                                
                            </div> <!-- End of hpp_wpapper_content -->
                            
                            <div class="divider"></div>
                            
                            <!-- Start Property Images Update -->
<!--                            <div class="hpp_wpapper_content clear">
                                <h4 class="contentTitle"> Property Images : </h4>
                                
                                <?= form_open( 'manage-property?edit='. $propertyID , [ 'id' => 'property_image_info', 'class' => 'form-horizontal', 'name' => 'property_image_info' ] ); ?>
                                <div class="form-group step3_property">
                                    <div class="col-sm-9" id="append_image">
                                        
                                        <?php 
                                            foreach ( $select_images_by_property_id as $image ){
                                                if( $image['DEFAULT_IMAGE'] == 1 ){
                                        ?>
                                                <p>
                                                    <span class="glyphicon glyphicon-file shadow_image" id="show_image__<?= $image['IMAGE_ID']; ?>"></span>
                                                    <img src="<?= SITE_URL.$image['IMAGE_LINK'].$image['IMAGE_NAME']; ?>" class="picture-src_property hide_select_pic" id="show_property_images__<?= $image['IMAGE_ID']; ?>" title=""/>
                                                    <input class="form-control select_image" value="defualt" name="property_image[]" type="file" id="property_images__<?= $image['IMAGE_ID']; ?>" onchange="readeditURL(this)">
                                                </p>
                                        <?php }else{ ?>
                                                <p>
                                                    <span class="glyphicon glyphicon-file shadow_image" id="show_image__<?= $image['IMAGE_ID']; ?>"></span>
                                                    <span class="glyphicon glyphicon-remove remove_icon" onclick="remove_edit_image(<?= $image['IMAGE_ID']; ?>)"></span>
                                                    <img src="<?= SITE_URL.$image['IMAGE_LINK'].$image['IMAGE_NAME']; ?>" class="picture-src_property hide_select_pic" id="show_property_images__<?= $image['IMAGE_ID']; ?>" title=""/>
                                                    <input class="form-control select_image" name="property_image[]" type="file" id="property_images__<?= $image['IMAGE_ID']; ?>" onchange="readeditURL(this)">
                                                </p>
                                        <?php } } ?>
                                        
                                    </div>	
                                </div>  end of form-group 
                                
                                <div class="col-xs-2 pull-right">
                                    <input type="submit" name="updateImages" value="Update" class="btn btn-primary">
                                </div>
                                
                                <?= form_close(); ?>
                                
                            </div> End of hpp_wpapper_content -->
                            
                            
                            <div class="divider"></div> 
                            
                            <!-- Start Additional Information -->
                            <div class="hpp_wpapper_content" id="additionalInfo">
                                <h4 class="contentTitle"> Property Additional Information : </h4>
                                <div class="row"> 
                                <?= form_open('manage-property?edit=' . $propertyID, [ 'id' => 'property_additional_info', 'class' => 'form-horizontal', 'name' => 'property_additional_info']); ?>
                                 <?php 
                                 $output = '';
                                          
                                 foreach ( $select_additional_info as $additionalInfo ){
                                       $getValue = $additionalInfo->FILED_DATA;
                                       if($additionalInfo->FILED_TYPE == 'text_select'){
                                           $this->Property_Model->filed_value = $additionalInfo->FILED_OTHERS;
                                       }else{
                                           $this->Property_Model->filed_value = $additionalInfo->FILED_DATA;
                                       }
                                       $this->Property_Model->filed_id = $additionalInfo->ADD_FILED_ID;
                                       $output .=' <div class="col-sm-6"><div class="form-group paddX-15">'
                                               . '<label for="property-images">'. $additionalInfo->FILED_NAME.' :</label>'
                                               .$this->Property_Model->create_filed( $additionalInfo->FILED_TYPE, $additionalInfo->FILED_ID_NAME, $additionalInfo->FILED_NAME, $getValue ).
                                               '</div></div>';
                                       
                                 } 
                                 echo $output;
                                 ?>
                                    <div class="col-xs-2 pull-right">
                                        <input type="submit" name="updateAdditionalInfo" value="Update" class="btn btn-primary">
                                    </div>
                                </div>
                                <?= form_close(); ?>

                            </div>  <!-- End of hpp_wpapper_content -->
                            <!-- End Additional Information -->
                            
                            <!-- Start Others Information -->
                            <?php if( is_array( $select_info ) && sizeof( $select_info ) > 0 ) {  ?>
                                <div class="divider"></div> 
                                <div class="hpp_wpapper_content" id="otherInfo">
                                    <h4 class="contentTitle"> Property Others Information : </h4>
                                    <div class="row"> 
                                    <?= form_open('manage-property?edit=' . $propertyID, [ 'id' => 'property_others_info', 'class' => 'form-horizontal', 'name' => 'property_others_info']); ?>
                                     <?php 
                                        $output = '';        
                                        foreach ( $select_info as $otherInfo ){
                                              $getValue = $otherInfo->FILED_DATA;
                                             $output .=' <div class="col-sm-6"><div class="form-group paddX-15">'
                                                      . '<label for="property-images">'. $otherInfo->FILED_OTHERS.' :</label>'
                                                      .$this->Property_Model->create_filed( 'TEXT', 'value[]','', $getValue ).
                                                      '</div></div>';

                                        } 
                                        echo $output;

                                     ?>
                                        <div class="col-xs-2 pull-right">
                                            <input type="submit" name="updateOthersInfo" value="Update" class="btn btn-primary">
                                        </div>
                                    </div>
                                    <?= form_close(); ?>

                                </div>  <!-- End of hpp_wpapper_content -->
                            <?php } ?>
                            <!-- End Others Information -->
                            
                            <!-- Start Near By Information -->
                            <?php if( is_array( $select_nearby_info ) && sizeof( $select_nearby_info ) > 0 ) { ?>
                                <div class="divider"></div>
                                
                                <div class="hpp_wpapper_content" id="nearby">
                                    <h4 class="contentTitle"> Property Near By Information : </h4>
                                    <div class="row"> 
                                    <?= form_open('manage-property?edit=' . $propertyID, [ 'id' => 'property_nearby_info', 'class' => 'form-horizontal', 'name' => 'property_nearby_info']); ?>
                                        <div class="col-md-6"><label for="property-video">School/College/Shoping Center:</label></div>
                                        <div class="col-md-3"><label for="property-video">Distance(km) :</label></div>
                                        <div class="col-md-3"><label for="property-video">Location:</label></div>
                                        <?php 
                                            foreach ($select_nearby_info as $nearBy ){
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group paddX-15">
                                                <input class="form-control" value="<?= $nearBy->NEAR_ORG_NAME; ?>" id="org_name_<?= $nearBy->NEAR_BY_ID;?>" name="org_name_<?= $nearBy->NEAR_BY_ID;?>" type="text">
                                            </div> 
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group paddX-15">
                                                <input class="form-control" value="<?= $nearBy->NEAR_ORG_DISTANCE; ?>" onkeyup="removeChar(this);" id ="distance_<?= $nearBy->NEAR_BY_ID;?>" name="distance_<?= $nearBy->NEAR_BY_ID;?>" type="text">
                                            </div> 
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="form-control" name="location_<?= $nearBy->NEAR_BY_ID;?>" id="location_<?= $nearBy->NEAR_BY_ID;?>">
                                                    <option value="">Select once</option>
                                                    <?php
                                                    foreach ( $location_near as $location ) {
                                                        $select = '';
                                                        if( $nearBy->LOCATION_ID == $location['LOCATION_ID'] ){ $select = 'selected'; }
                                                        echo '<option '.$select.' value="' . $location['LOCATION_ID'] . '">' . $location['LOCATION_NAME'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="col-xs-2 pull-right">
                                            <input type="submit" name="updateNearByInfo" value="Update" class="btn btn-primary">
                                        </div>
                                    </div>
                                    <?= form_close(); ?>

                                </div>  <!-- End of hpp_wpapper_content -->
                            <?php } ?>
                           <!-- End Near By Information -->
                           
                           <!-- Start Video Information -->
                            <?php if( is_array( $select_video_info ) && sizeof( $select_video_info ) > 0 ) { ?>
                                <div class="divider"></div>
                                
                                <div class="hpp_wpapper_content" id="vedioInfo">
                                    <h4 class="contentTitle"> Property Video Information : </h4>
                                    <div class="row"> 
                                    <?= form_open('manage-property?edit=' . $propertyID, [ 'id' => 'property_vodeo_info', 'class' => 'form-horizontal', 'name' => 'property_video_info']); ?>
                                        
                                        <?php 
                                            foreach ($select_video_info as $video ){ 
                                        ?>
                                                <div class="col-md-4">
                                                    <div class="form-group paddX-15">
                                                        <label for="property-video">Video type:</label>
                                                        <select class="form-control" name="video_type" id="video_type_0" onchange="select_video(this.value)">
                                                            <?php
                                                            foreach ($select_video_type as $vType) {
                                                                $select = ''; if( $video->VIDEO_TYPE_ID == $vType['VIDEO_TYPE_ID']){ $select = 'selected'; }
                                                                echo '<option '. $select .' value="' . $vType['VIDEO_TYPE_ID'] . '">' . $vType['TYPE_NAME'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group paddX-15">
                                                        <label for="property-video">Property video :</label>
                                                        <input class="form-control" id="property_video" value="<?= $video->VIDEOS_LINK; ?>" name="property_video" type="text">
                                                    </div> 
                                                </div>
                                        
                                        <?php } ?>
                                        <div class="col-xs-2 pull-right">
                                            <input type="submit" name="updateVideoInfo" value="Update" class="btn btn-primary">
                                        </div>
                                    </div>
                                    <?= form_close(); ?>

                                </div>  <!-- End of hpp_wpapper_content -->
                            <?php } ?>
                           <!-- End Video Information -->
                            

                        </div>                   
                    </div> <!-- End of properties-page --> 
                </div>  <!-- End of row -->            
            </div>
        </div>
  