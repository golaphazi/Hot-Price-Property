<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-7 col-md-offset-1  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle"><srtong>::</srtong> File Uploader <srtong>::</srtong> </h4>
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        if (strlen($status) > 2) {
                            ?> 
                            <div class="alert alert-success">
                                <?php echo $status; ?>
                            </div>
                            <?php
                            
                        }
                        ?>    
                    </div> <!-- End of col-xs-12 -->
                </div> <!-- End of row-->

                <div class="hpp_wpapper_table">
                    
                    <?= form_open_multipart('', ['id' => 'addNewsForm' , 'name' => 'addNews'] ); ?>
                    
					<div class="col-sm-9">
						<div class="form-group">
							<label for="file_data"><b>File : </b> <span id="image_size"> </span></label>
							<input name="file_data" id="file_data" type="file" class="form-control file-input" >
						</div>
                    </div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="lunchBegins"><b>Country: </b></label>
								  
								<select id="lunchBegins" name="country_id" class="selectpicker" data-live-search="true" data-live-search-style="begins" onchange="select_currency(this.value)" title="select country">
									<?php
									 $select_country = 0;
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
												<option value="<?= $valueP['countryName']; ?>" <?= $active; ?>><?= $valueP['countryName']; ?></option>
												<?php
											}

										endforeach;
									}
									?>
								</select>

						</div>
					</div>
					
					
                    <div class="col-md-12 marY-30">
                        <button type="submit" name="save_file" class="btn btn-default pull-right">Upload</button>
                    </div>
                    
                    <?= form_close(); ?>
                    
                </div> <!-- End of hpp_wpapper_table --> 
            </div> <!-- End of properties-page -->

						
        </div>  <!-- End of row -->            
    </div>
</div>
