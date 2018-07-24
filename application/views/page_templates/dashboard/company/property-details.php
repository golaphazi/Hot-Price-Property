<?php 
$CI = & get_instance(); 

if ($property['PROPERTY_AUCTION'] == 'Yes' OR $property['HOT_PRICE_PROPERTY'] == 'yes') {
    $approvedAction = 'active_offer_property_by_id(' . $property['PROPERTY_ID'] . ')';
    $rejectdAction = 'reject_offer_property_by_id(' . $property['PROPERTY_ID'] . ')';
} else {
    $approvedAction = 'active_property_by_id(' . $property['PROPERTY_ID'] . ')';
    $rejectdAction = 'reject_property_by_id(' . $property['PROPERTY_ID'] . ')';
}
//echo '<pre>';print_r($property);
?>

<!-- property area -->
<div class="content-area single-property" style="background-color: #FCFCFC;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div id="massage" >
                </div>    
            </div> <!-- End of col-xs-12 -->
        </div> <!-- End of row-->
        <div class="row">
            
			 <?= $user_menu; ?>
			<div class="col-md-9 single-property-content ">
                <div class="row">
                    <div class="light-slide-item previewPage">            
                        <div class="clearfix">
                            <div class="favorite-and-print">
                                <a class="add-to-fav" href="#login-modal" data-toggle="modal">
                                    <i class="fa fa-star-o"></i>
                                </a>
                                
                            </div> 

                            <ul id="image-gallery" class="gallery list-unstyled cS-hidden ">
                                <?php
                                $userID = $this->session->userData('userID');
                                $logged_in = $this->session->userData('logged_in');

                                if (is_array($images_property) AND sizeof($images_property) > 0) {
                                    foreach ($images_property AS $image):
                                        ?>
                                        <li data-thumb="<?= SITE_URL ?><?= $image['IMAGE_LINK'] . $image['IMAGE_NAME']; ?>"> 
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

                <div class="single-property-wrapper">
                    <div class="single-property-header">                                          
                        <h1 class="property-title pull-left"><?= $property['PROPERTY_NAME']; ?></h1>  
                        <?php if ($property['HOT_PRICE_PROPERTY'] == 'No') { ?>
                            <span class="property-price pull-right">$ <?= number_format($property['PROPERTY_PRICE'], 2); ?></span>
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
                            <span class="property-price pull-left cross_price">$ <?= number_format($property['PROPERTY_PRICE'], 2); ?></span>
                            <span class="property-price pull-right">$ <?= number_format($offerPrice, 2); ?></span>
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

                                        $offr_bid = $this->db->query("SELECT OFFER_BID_PRICE FROM p_property_offers_bidding WHERE PROPERTY_ID = " . $property['PROPERTY_ID'] . " AND OFFER_P_ID = " . $offer_price_bid[0]['OFFER_P_ID'] . " AND OFFER_BID_STATUS = 'Active' ORDER BY OFFER_BID_ID DESC LIMIT 0,1");
                                        $offr_bid_val = $offr_bid->result_array();
                                        if (is_array($offr_bid_val) AND sizeof($offr_bid_val) > 0) {
                                            $BIDDING_PRICE = $offr_bid_val[0]['OFFER_BID_PRICE'];
                                        }
                                        ?>
                                        <ul class="additional-details-list clearfix">
                                            <input type="hidden" id="last_bid_price" value="<?= $BIDDING_PRICE; ?>">
                                            <li>
                                                <span class="col-xs-6 col-sm-4 col-md-4 add-d-title"> Last Bid Price</span>
                                                <span class="col-xs-6 col-sm-8 col-md-8 add-d-entry">$<b> <?= number_format($BIDDING_PRICE, 2); ?> </b></span>
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
                        }
                        ?>

                    <div class="property-meta entry-meta clearfix " style="">   
                        <h4 class="s-property-title">HPP Information</h4>
                            <?php
                            $type_name = $this->user->any_where(array('PROPERTY_TYPE_ID' => $property['PROPERTY_TYPE_ID']), 'mt_p_property_type', 'PROPERTY_TYPE_NAME');
                            ?>
                        Property type : <b><?= $type_name; ?> </b>
                        <br/>
      
                        <?php
                        $category_name = $this->user->any_where(array('PRO_CATEGORY_ID' => $property['PRO_CATEGORY_ID']), 'mt_p_property_category', 'PRO_CATEGORY_NAME');
                        ?>
                        Property for : <b><?= $category_name; ?> </b>
                        <?php
                        if ($property['HOT_PRICE_PROPERTY'] == 'Yes') {
                            echo ' - <b>Hot Price</b>';
                        }
                        ?>

                        <?php
                        if ($property['PROPERTY_AUCTION'] == 'Yes') {
                            echo ' - <b>Auction</b>';
                        }
                        ?>


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
                                    <div class="col-xs-4 col-sm-4 col-md-4 p-b-15">
                                        <span class="property-info icon-area preview_icon">
                                            <img src="<?= SITE_URL ?>icons/<?= $filed_info[0]['FILED_HTML']; ?>" title="<?= $filed_info[0]['FILED_NAME']; ?>" alt="<?= $filed_info[0]['FILED_NAME']; ?>"/>
                                        </span>
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

                    <div class="section property-features">      

                        <h4 class="s-property-title">Features</h4>                            
                        <?php
                        $feature = $this->db->query("SELECT * FROM p_property_basic WHERE PROPERTY_ID != " . $property['PROPERTY_ID'] . " AND (PROPERTY_NAME LIKE '%" . $property['PROPERTY_NAME'] . "%' OR PROPERTY_STREET_ADDRESS LIKE '%" . $property['PROPERTY_STREET_ADDRESS'] . "%' OR PROPERTY_CITY LIKE '%" . $property['PROPERTY_CITY'] . "%' OR PROPERTY_STATE LIKE '%" . $property['PROPERTY_STATE'] . "%' OR PROPERTY_COUNTRY = '" . $property['PROPERTY_COUNTRY'] . "') ORDER BY ENT_DATE,PROPERTY_ID ASC LIMIT 0,10");
                        ?>
                        <ul>
                        <?php
                        foreach ($feature->result_array() AS $data):
                            ?>
                                <li><a href="<?= SITE_URL; ?>preview?view=<?= $data['PROPERTY_URL'] ?>"><?= $data['PROPERTY_NAME'] ?></a></li>   

                        <?php endforeach; ?>
                        </ul>

                    </div>
                    <!-- End features area  -->

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
                    
                       
                </div>
            </div>

           
        </div>

    </div>
</div>
