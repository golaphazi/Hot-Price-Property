<?php $CI = & get_instance(); ?>

<div class="page-head property-details-head"> 
    <div class="container">
        <div class="row">
            <div class="owl-carousels hpp-ads-carousel">
                <?php
					$date = date("Y-m-d H:i:s");
					$queryData = $this->db->query("SELECT * FROM ads_hpp WHERE LOCATION = 'property_details' AND POSITION = 'Top' AND STATUS = 'Active' AND (START_DATE <= '".$date."' AND END_DATE_ADS >= '".$date."') ORDER BY ADS_ID DESC");
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
<div class="content-area single-property" style="background-color: #FCFCFC;">
    <div class="container">

        <div class="clearfix padding-top-40">
            <div class="row col-md-8 single-property-content ">
                <div class="row">
                    <div class="light-slide-item">            
                        <div class="clearfix">
                            <div class="favorite-and-print_1">
<!--                                <a class="add-to-fav" href="#login-modal" data-toggle="modal">
                                    <i class="fa fa-star-o"></i>
                                </a>-->
                                <?php 
                              $type_name = $this->user->any_where(array('PROPERTY_TYPE_ID' => $property['PROPERTY_TYPE_ID']), 'mt_p_property_type', 'PROPERTY_TYPE_NAME');
                              //echo $type_name;
                            ?>
                            </div> 

                            <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                                <?php
                                $userID = $this->session->userData('userID');
                                $logged_in = $this->session->userData('logged_in');

                                if (is_array($images_property) AND sizeof($images_property) > 0) {
                                    foreach ($images_property AS $image):
                                        
										?>
                                        <li data-thumb="<?= SITE_URL ?><?= $image['IMAGE_LINK'] . $image['IMAGE_NAME']; ?>"> 
                                            <span class="image_wather"> <img src="<?= SITE_URL ;?>assets/img/logo.png" alt="Logo"/> </span>
											<img src="<?= SITE_URL ?><?= $image['IMAGE_LINK'] . $image['IMAGE_NAME']; ?>" alt="<?= $image['IMAGE_NAME']; ?>"/>
                                        </li>
                                        <?php
                                    endforeach;
                                }else {
                                    ?>
                                    <li data-thumb="<?= SITE_URL ?>assets/img/property-1/property1.jpg"> 
                                        <img src="<?= SITE_URL ?>assets/img/property-1/property1.jpg" />
                                    </li>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="single-property-wrapper" style="">
                    <div class="single-property-header">                                          
                        <h1 class="property-title pull-left"><?= $property['PROPERTY_NAME']; ?></h1>  
                        <?php if ($property['HOT_PRICE_PROPERTY'] == 'No') {
								$line_css = '';
								if ($property['PROPERTY_AUCTION'] == 'Yes') {
									$line_css = 'line-through';
								}
						?>
                            <span class="property-price pull-right <?= $line_css;?>"> <?= number_format($property['PROPERTY_PRICE']) . ' ' . $property['CURRENCY_CODE']; ?>(<?= $property['CURRENCY_SAMPLE'];?>)</span>
                        <?php } ?>	
                    </div>
                    <?php
                    if ($property['HOT_PRICE_PROPERTY'] == 'Yes') {
                        $offer_price = $this->Property_Model->any_type_where(array('PROPERTY_ID' => $property['PROPERTY_ID'], 'OFFER_TYPE' => 'Hot'), 'p_property_offers');
                        $offerPrice = '0';
                        if (is_array($offer_price) AND sizeof($offer_price) > 0) {
                            $offerPrice = $offer_price[0]['OFFER_PRICE'];
                        }
                        ?>
                        <div class="single-property-header">                                          
                            <span class="property-price pull-left cross_price"> <?= number_format($property['PROPERTY_PRICE']) . ' ' . $property['CURRENCY_CODE']; ?>(<?= $property['CURRENCY_SAMPLE'];?>)</span>
                            <span class="property-price pull-right"> <?= number_format($offerPrice); ?> <?= $property['CURRENCY_CODE'];?>(<?= $property['CURRENCY_SAMPLE'];?>)</span>
                        </div>
                    <?php } ?>	

                    <?php if ($property['PROPERTY_AUCTION'] == 'Yes') { ?>
                        <div class="row col-md-12 section property-auction" id="bidding"> 
                            <h4 class="s-property-title">Auction Information</h4> 
                            <?php
                            $offerPrice = '0';
                            $BIDDING_PRICE = '0';
                            $year = 0;
                            $month = 0;
                            $days = 0;
                            $hours = 0;
                            $minute = 0;
                            $seceond = 0;
                            if (is_array($offer_price_bid) AND sizeof($offer_price_bid) > 0) {
                                $offerPrice = $offer_price_bid[0]['BIDDING_WIN_PRICE'];
                                $BIDDING_PRICE = $offer_price_bid[0]['OFFER_PRICE'];
                                $available = $offer_price_bid[0]['OFFER_END_DATE'];

                                if ($offer_price_bid[0]['OFFER_STATUS'] == 'Active') {

                                    $time = time();
                                    $checkDate = strtotime($available);
                                    //echo $checkDate;

                                    if ($checkDate >= $time) {

                                        $date1 = new DateTime(date("Y-m-d h:i:s"));
                                        $date2 = new DateTime($available);
                                        $interval = $date1->diff($date2);
                                        $year = $interval->y;
                                        $month = $interval->m;
                                        $days = $interval->d;
                                        $hours = $interval->h;
                                        $minute = $interval->i;
                                        $seceond = $interval->s;

                                        $offr_bid = $this->db->query("SELECT OFFER_BID_PRICE FROM p_property_offers_bidding WHERE PROPERTY_ID = " . $property['PROPERTY_ID'] . " AND OFFER_P_ID = " . $offer_price_bid[0]['OFFER_P_ID'] . " AND OFFER_BID_STATUS = 'Active' ORDER BY OFFER_BID_ID DESC");
                                        $offr_bid_val = $offr_bid->result_array();
                                        if (is_array($offr_bid_val) AND sizeof($offr_bid_val) > 0) {
                                            $BIDDING_PRICE = $offr_bid_val[0]['OFFER_BID_PRICE'];
                                        }
                                        ?>
                                        <ul class="additional-details-list clearfix">
                                            <input type="hidden" id="last_bid_price" value="<?= $BIDDING_PRICE; ?>">
                                            <li>
                                                <span class="col-xs-6 col-sm-4 col-md-4 add-d-title"> Last Bid Price</span>
                                                <span class="col-xs-6 col-sm-8 col-md-8 add-d-entry"><b> <?= number_format($BIDDING_PRICE); ?> <?= $property['CURRENCY_CODE'];?>(<?= $property['CURRENCY_SAMPLE'];?>) </b></span>
                                            </li>
											<li>
                                                <span class="col-xs-6 col-sm-4 col-md-4 add-d-title"> Total Bidder</span>
                                                <span class="col-xs-6 col-sm-8 col-md-8 add-d-entry"><b> <?= sizeof($offr_bid_val); ?> </b> Bid</span>
                                            </li>
                                            <li>
                                                <span class="col-xs-6 col-sm-4 col-md-4 add-d-title"> Bid end date</span>
                                                <span class="col-xs-6 col-sm-8 col-md-8 add-d-entry"> <?= date("d M Y - h:i:s", $checkDate); ?></span>
                                            </li>
                                            <li>
                                                <span class="col-xs-6 col-sm-4 col-md-4 add-d-title"> Bidding Available time</span>
                                                <span class="col-xs-6 col-sm-8 col-md-8 add-d-entry">
                                        <?php
                                        if ($month > 0) {
                                            echo $month . ' <b>Months</b> - ';
                                        }
                                        if ($days > 0) {
                                            echo $days . ' <b>Days</b> - ';
                                        }
                                        ?>
                                                    <?= $hours . ' : ' . $minute . ' : ' . $seceond; ?></span>
                                            </li>
                                        </ul>
                                                    <?php
                                                    if ($property['PROPERTY_STATUS'] == 'Active' AND $property['USER_ID'] != $userID) {
                                                        if ($userID > 0 AND $logged_in == TRUE AND $account_type == 2) {
                                                            $getBid = isset($_GET['bid']) ? $_GET['bid'] : 'close';
                                                            if ($getBid == 'open') {
                                                                $urlAgent = 'preview?view=' . $property['PROPERTY_URL'] . '&bid=open&datatype=' . $offer_price_bid[0]['OFFER_P_ID'] . '&#bidding';
                                                                ?>
																<div class="col-md-12" style="padding:10px 0px 0px 0px;"> <?php if (strlen($MASG_BID) > 2) { ?><?= $MASG_BID; ?> <?php } ?></div>
																<div class="col-md-4" style="padding:10px 0px 0px 0px;"> </div>
																<div class="col-md-6" style="padding:10px 0px 0px 0px;"> 

																<?= form_open($urlAgent, ['id' => 'bidding_post_auction', 'name' => 'bidding_post_auction', 'onsubmit' => 'return check_max_price(bid_price.value,last_bid_price.value);']); ?>
																	<div class="form-group">
																		<label for="bid_price"><b>Bid price </b><small class="red">*</small></label>
																		<input name="bid_price" id="bid_price" type="text" onkeyup="removeChar(this);" onblur="number_format(this), check_max_price(this.value, last_bid_price.value)"  class="form-control" placeholder="Enter bid price for property ...">
																	</div>
																	<div class="form-group">
																		<label for="bid_price_details"><b>Details </b><small class="red">(Optional)</small></label>
																		<textarea name="bid_price_details" id="bid_price_details" class="form-control" required placeholder="Enter details for property ..."> </textarea>
																	</div>
																	<div class="form-group">
																		<button type="submit" name="bidding_post" class="btn btn-primary left" >Bid</button>
																		<a href="<?= SITE_URL . 'preview?view=' . $property['PROPERTY_URL'] . '&bid=close&#bidding'; ?>" name="bidding_post" class="btn btn-errors right" >Close</a>
																	</div>

																<?= form_close(); ?>
																</div>
                                                        <?php
                                                    } else {
                                                        ?>
                                                    <div class="col-md-12 center" style="padding:10px 0px 0px 0px;"> 
                                                    <?php if (strlen($MASG_BID) > 2) { ?><?= $MASG_BID; ?> <?php } ?>
                                                        <div class="form-group">
                                                            <p class="blog-more"><a class="cx-btn" href="<?= SITE_URL . 'preview?view=' . $property['PROPERTY_URL'] . '&bid=open&#bidding'; ?>">Bidding Now</a></p>
                                                        </div>
                                                    </div>
											<?php
												}
											} else {
												if ($account_type != 1) {
													?>
															<div class="col-md-12 center" style="padding:10px 0px 0px 0px;"> 
																<div class="form-group">
																	<p class="blog-more"><a class="cx-btn" href="<?= SITE_URL . 'login?page=preview?view=' . $property['PROPERTY_URL'] . ';;bid=open$$bidding'; ?>">Login for Bid</a></p>
																</div>
															</div>
													<?php
												}
											}
										}
										?>
                                        <?php
                                    } else {
                                        echo '<div class="alert alert-danger"> Bidding date over</div>';
                                    }
                                } else if ($offer_price_bid[0]['OFFER_STATUS'] == 'Win') {
                                    echo '<div class="alert alert-success"> Auction closed</div>';
                                }
                            }
                            ?>

                        </div>
                        <?php
                        }else if ($property['HOT_PRICE_PROPERTY'] == 'Yes') {
                        ?>						
							<div class="row col-md-12 section property-auction" id="bidding"> 
								<h4 class="s-property-title">Offer Information</h4> 
							
							<?php
								$offerPrice = '0';
								$BIDDING_PRICE = '0';
								$year = 0;
								$month = 0;
								$days = 0;
								$hours = 0;
								$minute = 0;
								$seceond = 0;
								if (is_array($offer_price_hot) AND sizeof($offer_price_hot) > 0) {
									$BIDDING_PRICE = $offer_price_hot[0]['BIDDING_WIN_PRICE'];
									//$BIDDING_PRICE = $offer_price_hot[0]['OFFER_PRICE'];
									$available = $offer_price_hot[0]['OFFER_END_DATE'];

									if ($offer_price_hot[0]['OFFER_STATUS'] == 'Active') {

										$time = time();
										$checkDate = strtotime($available);
										//echo $checkDate;

										if ($checkDate >= $time) {

											$date1 = new DateTime(date("Y-m-d h:i:s"));
											$date2 = new DateTime($available);
											$interval = $date1->diff($date2);
											$year = $interval->y;
											$month = $interval->m;
											$days = $interval->d;
											$hours = $interval->h;
											$minute = $interval->i;
											$seceond = $interval->s;

											$offr_bid = $this->db->query("SELECT OFFER_BID_PRICE FROM p_property_offers_bidding WHERE PROPERTY_ID = " . $property['PROPERTY_ID'] . " AND OFFER_P_ID = " . $offer_price_hot[0]['OFFER_P_ID'] . " AND OFFER_BID_STATUS = 'Active' ORDER BY OFFER_BID_ID DESC");
											$offr_bid_val = $offr_bid->result_array();
											//print_r($offr_bid_val);
											if (is_array($offr_bid_val) AND sizeof($offr_bid_val) > 0) {
												$BIDDING_PRICE = $offr_bid_val[0]['OFFER_BID_PRICE'];
											}
											?>
											<ul class="additional-details-list clearfix">
												<input type="hidden" id="last_bid_price" value="<?= $BIDDING_PRICE; ?>">
												<li>
													<span class="col-xs-6 col-sm-4 col-md-4 add-d-title"> Last Offer Price</span>
													<span class="col-xs-6 col-sm-8 col-md-8 add-d-entry"><b> <?= number_format($BIDDING_PRICE); ?> <?= $property['CURRENCY_CODE'];?>(<?= $property['CURRENCY_SAMPLE'];?>) </b></span>
												</li>
												<li>
													<span class="col-xs-6 col-sm-4 col-md-4 add-d-title"> Offer end date</span>
													<span class="col-xs-6 col-sm-8 col-md-8 add-d-entry"> <?= date("d M Y - h:i:s", $checkDate); ?></span>
												</li>
												<li>
													<span class="col-xs-6 col-sm-4 col-md-4 add-d-title"> Offer Available time</span>
													<span class="col-xs-6 col-sm-8 col-md-8 add-d-entry">
													<?php
													if ($month > 0) {
														echo $month . ' <b>Months</b> - ';
													}
													if ($days > 0) {
														echo $days . ' <b>Days</b> - ';
													}
													?>
													<?= $hours . ' : ' . $minute . ' : ' . $seceond; ?></span>
												</li>
											</ul>
													<?php
													if ($property['PROPERTY_STATUS'] == 'Active' AND $property['USER_ID'] != $userID) {
														if ($userID > 0 AND $logged_in == TRUE AND $account_type == 2) {
															$getBid = isset($_GET['bid']) ? $_GET['bid'] : 'close';
															if ($getBid == 'open') {
																$urlAgent = 'preview?view=' . $property['PROPERTY_URL'] . '&bid=open&datatype=' . $offer_price_hot[0]['OFFER_P_ID'] . '&#bidding';
																?>
																<div class="col-md-12" style="padding:10px 0px 0px 0px;"> <?php if (strlen($MASG_BID) > 2) { ?><?= $MASG_BID; ?> <?php } ?></div>
																<div class="col-md-4" style="padding:10px 0px 0px 0px;"> </div>
																<div class="col-md-6" style="padding:10px 0px 0px 0px;"> 

																<?= form_open($urlAgent, ['id' => 'bidding_post_auction', 'name' => 'bidding_post_auction', 'onsubmit' => 'return check_max_price(bid_price.value,last_bid_price.value);']); ?>
																	<div class="form-group">
																		<label for="bid_price"><b>Counter price </b><small class="red">*</small></label>
																		<input name="bid_price" id="bid_price" type="text" onkeyup="removeChar(this);" onblur="number_format(this), check_max_price(this.value, last_bid_price.value)"  class="form-control" placeholder="Enter bid price for property ...">
																	</div>
																	<div class="form-group">
																		<label for="bid_price_details"><b>Details </b><small class="red">(Optional)</small></label>
																		<textarea name="bid_price_details" id="bid_price_details" class="form-control" required placeholder="Enter details for property ..."> </textarea>
																	</div>
																	<div class="form-group">
																		<button type="submit" name="hot_offer_post" class="btn btn-primary left" >Counter</button>
																		<a href="<?= SITE_URL . 'preview?view=' . $property['PROPERTY_URL'] . '&bid=close&#bidding'; ?>" name="bidding_post" class="btn btn-errors right" >Close</a>
																	</div>

																<?= form_close(); ?>
																</div>
															<?php
														} else {
														?>
													<div class="col-md-12 center" style="padding:10px 0px 0px 0px;"> 
													<?php if (strlen($MASG_BID) > 2) { ?><?= $MASG_BID; ?> <?php } ?>
														<div class="form-group">
															<p class="blog-more"><a class="cx-btn" href="<?= SITE_URL . 'preview?view=' . $property['PROPERTY_URL'] . '&bid=open&#bidding'; ?>">Counter Offer</a></p>
														</div>
													</div>
											<?php
												}
											} else {
												if ($account_type != 1) {
													?>
																<div class="col-md-12 center" style="padding:10px 0px 0px 0px;"> 
																	<div class="form-group">
																		<p class="blog-more"><a class="cx-btn" href="<?= SITE_URL . 'login?page=preview?view=' . $property['PROPERTY_URL'] . ';;bid=open$$bidding'; ?>">Login for Counter Offer</a></p>
																	</div>
																</div>
														<?php
													}
												}
											}
											?>
											<?php
										} else {
											echo '<div class="alert alert-danger"> Offer date over</div>';
										}
									} else if ($offer_price_hot[0]['OFFER_STATUS'] == 'Win') {
										echo '<div class="alert alert-success"> Offer closed</div>';
									}
							}
							echo '</div>';
						}
                        ?>
						
                    <div class="property-meta entry-meta clearfix " style="">   
                        <h4 class="s-property-title">HPP Information</h4>
							Property type : 
                        <ul>
                    <?php
                        $pt_active_sell = $pt_active_hot = $pt_active_auction = $pt_active_rent = '';
                        $category_name = $this->user->any_where(array('PRO_CATEGORY_ID' => $property['PRO_CATEGORY_ID']), 'mt_p_property_category', 'PRO_CATEGORY_NAME');
                       
                        if ($property['HOT_PRICE_PROPERTY'] == 'Yes') {
                           $pt_active_hot = 'pt_active';
                        }else if($property['PROPERTY_AUCTION'] == 'Yes'){
                            $pt_active_auction = 'pt_active';
                        }else if($property['HOT_PRICE_PROPERTY'] == 'No' AND $category_name == 'Sell'){
                            $pt_active_sell = 'pt_active';
                        }else if($property['PROPERTY_AUCTION'] == 'No' AND $category_name == 'Rent'){
                            $pt_active_rent = 'pt_active';
                        }
                        ?>
                                <li class="<?= $pt_active_hot;?>"> Hot /</li>
                                <li class="<?= $pt_active_auction;?>"> Auction /</li>
                                <li class="<?= $pt_active_sell;?>"> Standard /</li>
                                <li class="<?= $pt_active_rent;?>"> Rent /</li>
                         </ul>
                    </div>

					
                    <div class="section">
                        <!-- <h4 class="s-property-title">Address</h4> -->
                        <div class="s-property-content">
                            <p><span class="fa fa-map-marker"> </span> 
                                <span class="font-14 address_bar"><?php $map = '';
                        if (strlen($property['PROPERTY_STREET_NO']) > 0) {
                            echo $property['PROPERTY_STREET_NO'] . ', ';
                        } ?>
                                    <?php if (strlen($property['PROPERTY_STREET_ADDRESS']) > 0) {
                                        echo $property['PROPERTY_STREET_ADDRESS'] . ', ';
                                        $map .= preg_replace("^[\\\\/:\*\?\"#%<>\|]^", " ", $property['PROPERTY_STREET_ADDRESS']) . ',';
                                    } ?>
                                    <?php if (strlen($property['PROPERTY_CITY']) > 0) {
                                        echo $property['PROPERTY_CITY'] . ', ';
                                        $map .= $property['PROPERTY_CITY'] . ',';
                                    } ?> 
                        <?php if (strlen($property['PROPERTY_STATE']) > 0) {
                            echo $property['PROPERTY_STATE'] . ', ';
                            $map .= $property['PROPERTY_STATE'] . ',';
                        } ?> 
                        <?php
                        $cuntryName = $this->Property_Model->select_country(array('countryID' => $property['PROPERTY_COUNTRY']), 'mt_countries');
                        echo $cuntryName[0]['countryName'] . '.';
                        $map .= $cuntryName[0]['countryName'];
                        ?> </p>
                        </div>
                    </div>  


                    <div class="property-meta entry-meta clearfix ">   
                        <h4 class="s-property-title">Basic Information</h4>
                    <?php
                    if (is_array($additional) AND sizeof($additional) > 0) {
                        foreach ($additional AS $filed) {
                            $filed_info = $this->Property_Model->any_type_where(array('ADD_FILED_ID' => $filed->ADD_FILED_ID), 'mt_p_property_additional_filed');
                            //print_r($filed_info[0]); exit;
                            if (is_array($filed_info[0]) AND sizeof($filed_info[0]) > 0) {
                                ?>
                                    <div class="col-xs-6 col-sm-4 col-md-4 p-b-15 text-center">
                                        <span class="property-info icon-area preview_icon">
                                            <img src="<?= SITE_URL ?>icons/<?= $filed_info[0]['FILED_HTML']; ?>" title="<?= $filed_info[0]['FILED_NAME']; ?>" alt="<?= $filed_info[0]['FILED_NAME']; ?>"/>
                                        </span><br/>
                                        <span class="property-info-entry preview_icon">
                                                <!--<span class="property-info-label"> <?= $filed_info[0]['FILED_NAME']; ?></span> -->
                                            <span class="property-info-value"> <?= $filed->FILED_DATA; ?> <b class="property-info-unit"> <?= $filed->FILED_OTHERS; ?> </b></span>
                                        </span>
                                    </div>
                                <?php
                            }
                        }
                    }
                    ?>

                    </div>
                    <!-- .property-meta -->


                    <div class="section">
                        <h4 class="s-property-title">Description</h4>
                        <div class="s-property-content">
                            <p> <?= htmlspecialchars_decode($property['PROPERTY_DESCRIPTION']); ?></p>
                        </div>
                    </div>
                    <!-- End description area  -->

                    <?php if (is_array($additional_other) AND sizeof($additional_other) > 0) { ?>
                        <div class="section additional-details">
                            <h4 class="s-property-title">Additional Details</h4>
                            <ul class="additional-details-list clearfix">
                            <?php foreach ($additional_other AS $other): ?>
                                    <li>
                                        <span class="col-xs-6 col-sm-4 col-md-4 add-d-title"><?= $other->FILED_OTHERS; ?></span>
                                        <span class="col-xs-6 col-sm-8 col-md-8 add-d-entry"><?= $other->FILED_DATA; ?></span>
                                    </li>
                            <?php endforeach; ?>
                            </ul>
                        </div> 
                            <?php } ?>	
                    <!-- End additional-details area  -->

                    <!-- Start Near By  -->
                    <?php if (is_array($near_by) AND sizeof($near_by) > 0) { ?>
                        <div class="section property-features">      
                            <h4 class="s-property-title">Near By</h4>                            
                            <table class="table table-striped  table-bordered singleborder" >
                                <tr>
                                    <th>School/College/Shoping Center</th>
                                    <th><center>Distance (km)</center></th>
                                <th>Direction</th>
                                </tr>
                            <?php foreach ($near_by AS $near): ?>
                                    <tr>
                                        <td><?= $near->NEAR_ORG_NAME; ?></td>
                                        <td><center><?= $near->NEAR_ORG_DISTANCE; ?></center></td>
                                    <td><?= $near->LOCATION_NAME; ?></td>

                                    </tr>
                            <?php endforeach; ?>
                            </table>
                        </div>
                        <?php } ?>
                    <!-- End Near By  -->
                        <?php if (is_array($video_property) AND sizeof($video_property) > 0) { ?>
                        <div class="section property-video"> 
                            <h4 class="s-property-title">Property Video</h4> 
                            <?php
                            foreach ($video_property AS $video):
                                if ($video['VIDEOS_DESCRIPTION'] == 'Upload') {
                                    ?>

                                    <?php
                                } else {
                                    $videoType = $this->Property_Model->any_type_where(array('VIDEO_TYPE_ID' => $video['VIDEO_TYPE_ID']), 'mt_p_video_type');
                                    $videoLink = $video['VIDEOS_LINK'];
                                    if ($videoType[0]['TYPE_NAME'] == 'Youtube') {
                                        $cxp = explode('v=', $videoLink);
                                        $id_video = $cxp[count($cxp) - 1];
                                    } else {
                                        $cxp = explode('/', $videoLink);
                                        $id_video = $cxp[count($cxp) - 1];
                                    }
                                    ?>
                                    <div class="video-thumb">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" src="<?= $videoType[0]['EMBED_URL'] ?><?= $id_video; ?>"></iframe>
                                        </div>
                                    </div>
                            <?php } endforeach; ?>
                        </div>
                    <?php } ?>
                    <!-- End video area  -->
                    <!-- Start Google  map  -->
                        <?php if (strlen($map) > 10) {
                            $map = str_replace(' ', '+', $map); ?>
                        <div class="section property-video"> 
                            <h4 class="s-property-title">Property Location</h4> 
                            <iframe frameborder="0" height="300" style="border:0px; width:100%; " src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBlxGdYL9gxyiHesq8ft2MdEMnoP35BZzs&q=<?= $map; ?>" allowfullscreen> </iframe>
                        </div>

                    <?php } ?>

					 <?php if ($property['PROPERTY_AUCTION'] == 'No' AND $property['HOT_PRICE_PROPERTY'] == 'No') { ?>
						<div class="col-md-12">
							<button type="submit" name="buy_now_property" class="btn btn-primary">Buy Now</button>
						</div>
					<?php } ?>

                <?php 
                    if( $this->userTypeID == 2 ) {
                ?>
                    <div class="row col-md-12  section property-video" id="contact_seller"> 
                        <h4 class="s-property-title">Contact with Seller</h4>
                        <?php if (strlen($MASG) > 2) { ?><div class="alert alert-success"> <?= $MASG; ?> </div> <?php } ?>
                        <?php $urlAgent = 'preview?view=' . $property['PROPERTY_URL'] . '&#contact_seller'; ?>
                        <?= form_open($urlAgent, ['id' => 'contact_to_form', 'name' => 'contact_to_form']); ?>
                            <div class="col-md-12 clear"> 
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="<?= $contact_agent_type['Name']; ?>">Name <small class="red">*</small></label>
                                            <input name="<?= $contact_agent_type['Name']; ?>" id="<?= $contact_agent_type['Name']; ?>" type="text" class="form-control" required placeholder="Enter name ...">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="<?= $contact_agent_type['Email']; ?>">Email <small class="red">*</small></label>
                                            <input name="<?= $contact_agent_type['Email']; ?>" id="<?= $contact_agent_type['Email']; ?>"  onkeyup="removeSpace(this)" type="email" required class="form-control" placeholder="Enter email address ...">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="<?= $contact_agent_type['Phone']; ?>">Phone <small class="red">*</small></label>
                                            <input name="<?= $contact_agent_type['Phone']; ?>" id="<?= $contact_agent_type['Phone']; ?>" type="tel"  onkeyup="removeDate(this);" class="form-control" required placeholder="Enter phone ...">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="<?= $contact_agent_type['About me']; ?>">About me <small class="red">*</small></label>
                                            <select name="<?= $contact_agent_type['About me']; ?>" class="form-control"  title="">
                                                <option value="" > Select once</option>            
                                                <option value="I own my own home" > I own my own home</option>            
                                                <option value="I am renting" > I am renting</option>            
                                                <option value="I am renting" > I have recently sold</option>            
                                                <option value="I am renting" > I am a first home buyer</option>            
                                                <option value="I am renting" > I am looking to invest</option>            
                                                <option value="I am renting" > I am monitoring the market</option>            
                                            </select>					
                                        </div>
                                    </div><!-- End of col-md-12 -->
                                    
                                    <!--Add Chaptch-->
                                    <div class="col-md-12">
                                        <div class=" captchaimg">
                                            <img src="<?= SITE_URL; ?>captcha.php?rand=<?php echo rand(); ?>" id="captchaimg" height="50" width="350">
                                        </div>
                                        <div class="">
                                            <input placeholder="Captcha" class="form-control" type="text" tabindex="2" name="captcha_code" value="" id="captcha_code">
                                            <span class="err captcha-err"></span>
                                        </div>
                                        <div class=" chaptch-refresh">
                                            Can't read the above code? <a class="ccc" href="javascript:void(0);" onClick="refresh_captcha();">Refresh</a>
                                        </div>
                                    </div><!--End Add Chaptch-->
                                    
                                </div> <!-- End of col-md-6 -->
                                
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group resuest_checkbox" >
                                            <label>Request <small class="red">*</small></label> <br/>
                                            <input name="<?= $contact_agent_type['Request']; ?>[]" id="request1" type="checkbox" class="form-control" value="Indication of price"> <label for="request1"> Indication of price </label> <br/>
                                            <input name="<?= $contact_agent_type['Request']; ?>[]" id="request2" type="checkbox" class="form-control" value="Contract of sale"> <label for="request2"> Contract of sale </label> <br/>
                                            <input name="<?= $contact_agent_type['Request']; ?>[]" id="request3" type="checkbox" class="form-control" value="Inspection"> <label for="request3"> Inspection </label> <br/>
                                            <input name="<?= $contact_agent_type['Request']; ?>[]" id="request4" type="checkbox" class="form-control" value="Similar properties">  <label for="request4"> Similar properties </label> <br/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="<?= $contact_agent_type['Message to']; ?>">Message to Seller  <small class="red"><small>(Optional)</small></small></label>
                                            <textarea id="<?= $contact_agent_type['Message to']; ?>" name="<?= $contact_agent_type['Message to']; ?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" name="contact_agent_message" class="btn btn-primary">Send</button>
                                    </div>
                                </div>
                            </div> 
                        <?= form_close(); ?>
                    </div><!-- End of property video -->
                <?php } ?>
                    
                    <!-- Start Related property section -->
                    <div class="row">
                        <div class="col-xs-12 clear section property-features mar-t-20">      
                            <h4 class="s-property-title">Related Property</h4>                            
                            <?php
                            $feature = $this->db->query("SELECT * FROM p_property_basic WHERE PROPERTY_ID != " . $property['PROPERTY_ID'] . " AND (PROPERTY_NAME LIKE '%" . $property['PROPERTY_NAME'] . "%' OR PROPERTY_STREET_ADDRESS LIKE '%" . $property['PROPERTY_STREET_ADDRESS'] . "%' OR PROPERTY_CITY LIKE '%" . $property['PROPERTY_CITY'] . "%' OR PROPERTY_STATE LIKE '%" . $property['PROPERTY_STATE'] . "%' OR PROPERTY_COUNTRY = '" . $property['PROPERTY_COUNTRY'] . "') AND PROPERTY_STATUS = 'Active' ORDER BY ENT_DATE,PROPERTY_ID ASC LIMIT 0,10");
                       
                            foreach ($feature->result_array() AS $dataS): 
                                $imageF = $this->Property_Model->property_image(array('PROPERTY_ID' => $dataS['PROPERTY_ID'])); ?>
                                <div class="single-item">
                                    <div class="img-thubm">
                                        <a href="<?= SITE_URL; ?>preview?view=<?= $dataS['PROPERTY_URL'] ?>">
                                            <img src="<?= SITE_URL ?><?= $imageF['0']['IMAGE_LINK'] . $imageF['0']['IMAGE_NAME']; ?>" alt="<?= $imageF['0']['IMAGE_NAME']; ?>" >
                                        </a>
                                    </div>
                                    <div class="retated-info">
                                        <h6> <a href="<?= SITE_URL; ?>preview?view=<?= $dataS['PROPERTY_URL'] ?>"><?= $dataS['PROPERTY_NAME'] ?></a></h6>
                                        <span class="property-price"><?= number_format($dataS['PROPERTY_PRICE']) . ' ' . $dataS['CURRENCY_CODE']; ?></span>
                                    </div> 
                                </div><!-- End of property-features  -->
                            <?php endforeach; ?>
                        </div><!-- End of single-item -->
                    </div> <!-- End of row -->
                    
                    
                </div><!-- End of single-property-wrapper -->
            </div><!-- End of single-property-content -->

            <div class="col-md-4 p0">
                <aside class="sidebar sidebar-property blog-asside-right">
                    <div class="dealer-widget">
                        <div class="dealer-content">
                            <div class="inner-wrapper">
                                <?php
                                $userInfo = $this->user->select_user_profile_by_id($property['USER_ID']);
                                if (strlen($userInfo->PROFILE_IMAGE) > 6) {
                                    $profile_image = $userInfo->PROFILE_IMAGE;
                                } else {
                                    $profile_image = 'assets/img/client-face1.png';
                                }
                                ?>
                                <div class="clear">
                                    <div class="col-xs-4 col-sm-4 dealer-face">
                                        <a href="">
                                            <img src="<?= SITE_URL ?><?= $profile_image; ?>" class="img-circle" alt="<?= $userInfo->USER_LOG_NAME; ?>">
                                        </a>
                                    </div>
                                    <div class="col-xs-8 col-sm-8 ">

                                        <h3 class="dealer-name sider-agent-name">
                                            <a href="<?= SITE_URL ?>agent?id=<?= $userInfo->USER_LOG_NAME; ?>"><?= $userInfo->FULL_NAME; ?></a><br/>
                                            <span><?= $userInfo->SUB_NAME; ?></span>        
                                        </h3>
                                        <div class="dealer-social-media">
                                        <?php
                                        $socialInfo = $this->Property_Model->any_type_where(array('CONTAC_TYPE_TYPE' => 'Social', 'CONTACT_TYPE_STATUS' => 'Active'), 'mt_c_contact_type');
                                        $num = '';
                                        $class = array('twitter', 'facebook', 'gplus', 'linkedin', 'instagram');
                                        $i = 0;
                                        foreach ($socialInfo AS $numBer) {
                                            $numBer1 = $this->Property_Model->any_type_where(array('CONTACT_TYPE_ID' => $numBer['CONTACT_TYPE_ID'], 'USER_ID' => $property['USER_ID']), 'c_contact_info');
                                            if (sizeof($numBer1) > 0) {
                                                if (strlen($numBer1[0]['CONTACT_NAME']) > 0) {
                                                    ?>
                                                    <a class="<?= $class[$i]; ?>" target="_blank" href="<?= $numBer1[0]['CONTACT_NAME']; ?>">
                                                        <i class="<?= $numBer['CONTACT_TYPE_ICON'] ?>"></i>
                                                    </a>
                                                    <?php
                                                }
                                            }
                                            $i++;
                                        }
                                        ?>

                                        </div>
                                        <div class="view_profile sidebar-profile">
                                            <a href="<?= SITE_URL ?>agent?id=<?= $userInfo->USER_LOG_NAME; ?>"> View Profile </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="clear sidebar-contacts">
                                    <ul class="dealer-contacts">                                       
                                        <?php
                                        $contactInfo = $this->Property_Model->any_type_where(array('CONTAC_TYPE_TYPE' => 'Basic', 'CONTACT_TYPE_STATUS' => 'Active'), 'mt_c_contact_type');
                                        $num = '';
                                        foreach ($contactInfo AS $numBer) {
                                            $numBer2 = $this->Property_Model->any_type_where(array('CONTACT_TYPE_ID' => $numBer['CONTACT_TYPE_ID'], 'USER_ID' => $property['USER_ID']), 'c_contact_info');
                                            if (sizeof($numBer2) > 0) {
                                                if (strlen($numBer2[0]['CONTACT_NAME']) > 0) {
                                                    $alink = '';
                                                    if ($numBer['CONTACT_TYPE_ICON'] == 'pe-7s-mail strong') {
                                                        $alink = 'href="mailto:' . $numBer2[0]['CONTACT_NAME'] . '"';
                                                    } else if ($numBer['CONTACT_TYPE_ICON'] == 'fa fa-phone') {
                                                        $alink = 'href="tel:' . $numBer2[0]['CONTACT_NAME'] . '"';
                                                    } else if ($numBer['CONTACT_TYPE_ICON'] == 'fa fa-mobile') {
                                                        $alink = 'href="callto:' . $numBer2[0]['CONTACT_NAME'] . '"';
                                                    }
                                                    echo ' <li><a ' . $alink . 'target="_top" style="font-weight:normal;"><i class="' . $numBer['CONTACT_TYPE_ICON'] . '"> </i> ' . $numBer2[0]['CONTACT_NAME'] . ' </a></li>';
                                                }
                                            }
                                        }
                                        ?>

                                    </ul>
                                    <p><?= substr($userInfo->OVERVIEW, 0, 150) . '...'; ?></p>
                                </div>
                                <div class="button_for_contact">
                                    <a href="preview?view=<?= $property['PROPERTY_URL']; ?>&#contact_seller" class="btn btn-primary btn-sidebar"> Contact agent</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default sidebar-menu similar-property-wdg wow fadeInRight animated">
                        <div class="panel-heading">
                            <h3 class="panel-title">Similar Properties</h3>
                        </div>
                        <div class="panel-body recent-property-widget">
                            <?php
                            $featureSl = $this->db->query("SELECT * FROM p_property_basic WHERE PROPERTY_ID != " . $property['PROPERTY_ID'] . " AND (PROPERTY_NAME LIKE '%" . $property['PROPERTY_NAME'] . "%' OR PROPERTY_STREET_ADDRESS LIKE '%" . $property['PROPERTY_STREET_ADDRESS'] . "%' OR PROPERTY_CITY LIKE '%" . $property['PROPERTY_CITY'] . "%' OR PROPERTY_STATE LIKE '%" . $property['PROPERTY_STATE'] . "%' OR PROPERTY_COUNTRY = '" . $property['PROPERTY_COUNTRY'] . "') AND PROPERTY_STATUS = 'Active' ORDER BY ENT_DATE,PROPERTY_ID DESC LIMIT 0,5");
                            ?>
                            <ul>
                            <?php
                            foreach ($featureSl->result_array() AS $dataSl):
                                $imageSl = $this->Property_Model->property_image(array('PROPERTY_ID' => $dataSl['PROPERTY_ID']));
                                ?>
                                    <li>
                                        <div class="col-md-3 col-sm-3 col-xs-3 blg-thumb p0">
                                            <a href="<?= SITE_URL; ?>preview?view=<?= $dataSl['PROPERTY_URL'] ?>">
                                                <img src="<?= SITE_URL ?><?= $imageSl['0']['IMAGE_LINK'] . $imageSl['0']['IMAGE_NAME']; ?>" alt="<?= $imageSl['0']['IMAGE_NAME']; ?>">
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-sm-8 col-xs-8 blg-entry">
                                            <h6> <a href="<?= SITE_URL; ?>preview?view=<?= $dataSl['PROPERTY_URL'] ?>"><?= $dataSl['PROPERTY_NAME'] ?></a></h6>
                                            <span class="property-price"> <?= number_format($dataSl['PROPERTY_PRICE']) . ' ' . $dataSl['CURRENCY_CODE']; ?></span>
                                        </div>
                                    </li>
                            <?php endforeach; ?>
                                    
                            </ul>
                        </div>
                    </div>



                    <div class="panel panel-default sidebar-menu wow fadeInRight animated">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ads Here  </h3>
                        </div>
                        <?php
						$date = date("Y-m-d H:i:s");
						$queryData = $this->db->query("SELECT * FROM ads_hpp WHERE LOCATION = 'property_details' AND POSITION = 'Right' AND STATUS = 'Active' AND (START_DATE <= '".$date."' AND END_DATE_ADS >= '".$date."') ORDER BY ADS_ID DESC LIMIT 0,3");
						$adsArray = $queryData->result_array();
						if(is_array($adsArray) AND sizeof($adsArray) > 0){
							foreach($adsArray AS $ads){
						?>
							<div class="panel-body recent-property-widget">
								 <a href="<?= $ads['WEB_URL']; ?>" target="_blank" ><img src="<?= SITE_URL ?><?= $ads['ADS_IMAGE']; ?>"> </a>
							</div>
						<?php
							}
						}else{
						?>
						<div class="panel-body recent-property-widget">
                             <a href="#" target="_blank" ><img src="<?= SITE_URL ?>assets/img/ad/450x800.jpg"> </a>
                        </div>
                       
                        <div class="panel-body recent-property-widget">
                            <img src="<?= SITE_URL ?>assets/img/ad/450x800-1.jpg">
                        </div>
						<?php
						}
						?>
                    </div>


                </aside>
            </div>
        </div>

    </div>
</div>
