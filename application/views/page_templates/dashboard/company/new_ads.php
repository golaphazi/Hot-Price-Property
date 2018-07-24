<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-7 col-md-offset-1  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle"><srtong>::</srtong> New Ads <srtong>::</srtong> </h4>
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
                    
                    <?= form_open_multipart('', ['id' => 'addNewsForm' , 'name' => 'addNews'] ); ?>
                    
					<div class="form-group">
                        <label for="headline"><b>Page Location : </b></label>
                        <?php
						$array = array('home' => 'Home', 'property_details' => 'Property Details', 'add_property' => 'Add Property', 'property_search' => 'Property Search', 'property_blog' => 'Property Blog', 'property_blog_preview' => 'Property News Preview');
						foreach($array AS $key=>$value){
							echo '<input name="location" id="'.$key.'" type="radio" value="'.$key.'" class="form-control" onclick="check_ads_page(this);"> <label for="'.$key.'">'.$value.' </label>';
						}
						?>
                    </div>
					<div class="form-group">
                        <label for="headline"><b>Page Position : </b></label>
                        <?php
						/*$array = array('Top', 'Bottom', 'Left', 'Right');
						foreach($array AS $value){
							echo '<input name="position" onclick="check_ads_position(this);" id="'.$value.'" type="radio" value="'.$value.'" class="form-control" checked> <label for="'.$value.'">'.$value.' </label>';
						}*/
						?>
						<span  id="id_position"> </span>
                    </div>
					
                    <div class="form-group">
                        <label for="headline"><b> Title: </b></label>
                        <input name="news_title" id="headline" type="text" class="form-control" placeholder="Enter New Headline/Title Here ...">
                    </div>
                    <div class="form-group">
                        <label for="newsDesc"><b>Description : </b></label>
                        <textarea name="news_description" id="newsDesc" class="form-control" rows="5" cols="50" style="display:none;"></textarea>
                        <?php $editor['id'] = 'newsDesc'; $this->load->view('Next_editor/editor', $editor);?>
                    </div>
                    <div class="form-group">
                        <label for="newsImage"><b>Ads Image : </b> <span id="image_size"> </span></label>
                        <input name="news_image" id="news_image" type="file" class="form-control file-input" >
                    </div>
					
					<div class="form-group">
                        <label for="newsImage"><b>Logo Image : </b> (80x80) px</label>
                        <input name="logo_image" id="logo_image" type="file" class="form-control file-input" >
                    </div>
					
					 <div class="form-group">
                        <label for="headline"><b> Phone No: </b></label>
                        <input name="phone_no" id="phone_no" type="text" class="form-control" placeholder="Enter number  ...">
                    </div>
                    
					 <div class="form-group">
                        <label for="headline"><b> Website URL: </b></label>
                        <input name="web_url" id="web_url" type="text" class="form-control" placeholder="Enter number  ...">
                    </div>
					
					
					
                     <div class="form-group">
						<label for="start-date" class="form-control-label">Ads Start Date: <small>(  Time should be 24 hours format  ) </small>  </label>
						<input type="text" name="start_date" id="start_date" value="" class="form-control datepickerStartDate" placeholder="Ex: YYYY-mm-dd H:m">                           
					</div>
					<div class="form-group">
						<label for="end-date" class="form-control-label">Dateline:<small>(  How long will the Ads from the start date  ) </small> </label>
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
					
                    <div class="col-md-12 marY-30">
                        <button type="submit" name="AddNews" class="btn btn-default pull-right">Post Ads</button>
                    </div>
                    
                    <?= form_close(); ?>
                    
                </div> <!-- End of hpp_wpapper_table --> 
            </div> <!-- End of properties-page -->

			<div class="col-md-9 pull-right">
                <table class="table table-striped table-bordered datatable">

                        <thead>
                            <tr>
                                <th class="center"> #SL </th>
                                <th class="center"> Ttile </th>
                                <th class="center"> Phone </th>
                                <th class="center"> Web Url </th>
                                <th class="center"> Page </th>
                                <th class="center"> End Date </th>
                            </tr>
                        </thead> 
                        <?php 
                            if( is_array( $ads_show ) && sizeof( $ads_show ) ){
                                $i = 1;
                                foreach ($ads_show as $ads ):
                                ?>
                                    
                                    <tr id="property_tr">
                                        <td class="center"><?= $i; ?></td>
                                        <td class="center"><?= $ads['ADS_TITLE']; ?></td>
                                        <td class="center"><?= $ads['PHONE_NUM']; ?></td>
                                        <td class="center"><?= $ads['WEB_URL']; ?></td>
                                        <td class="center"><?= $ads['LOCATION']; ?></td>
                                        <td class="center"><?= $ads['END_DATE_ADS']; ?></td>
                                        
                                    </tr>
                                    
                                <?php $i++;
                                endforeach;
                            }else {
                                echo '<tr id="property_tr"><td class="center" colspan="4"><span style="color:red;">No Recourds Found..!</span> </td></tr>';
                            }
                        ?>
                    </table>
            </div>			
        </div>  <!-- End of row -->            
    </div>
</div>

<script>

function check_ads_position(position){
	var htmlShow = document.getElementById('image_size');
	htmlShow.innerHTML = '';
	var keyy = position.value;
	//alert(keyy);
	var title = new Array();
	title['Bottom'] = 'Ads image size (380 x 150) px ';
	title['Top'] = '(300 x 150) px ';
	title['Right'] = '(450 x 800) px ';
	htmlShow.innerHTML = title[keyy];
}

function check_ads_page(type){
	document.getElementById('image_size').innerHTML = '';
	var keyy = type.value;
	var arr = new Array();
	arr['home'] = ['Bottom'];
	arr['property_details'] = ['Top', 'Right'];
	arr['add_property'] = ['Top'];
	arr['property_search'] = ['Top'];
	arr['property_blog'] = ['Right'];
	arr['property_blog_preview'] = ['Right'];
	
	var arrVal = arr[keyy];
	var exp = arrVal.length;
	
	var currentDiv = document.getElementById('id_position');
	currentDiv.innerHTML = '';
	for(var m = 0; m < exp; m++){
		//alert(arrVal[m]);
		var crEle = document.createElement('input');
		crEle.value = arrVal[m];
		crEle.type = 'radio';
		crEle.name = 'position';
		crEle.id = arrVal[m];
		crEle.setAttribute('onclick', 'check_ads_position(this)');
		crEle.setAttribute('class', 'form-control');
		
		var lebel = document.createElement('label');
		lebel.setAttribute('for', arrVal[m]);
		lebel.style = 'padding-left: 4px;';
		lebel.innerHTML = ' '+arrVal[m]+' ';
		
		currentDiv.appendChild(crEle);
		currentDiv.appendChild(lebel);
	}

}
</script>