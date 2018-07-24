
<div class="slider-area hpp-slide-area">
	<div class="slider">
            
		<div id="bg-slider" class="owl-carousel owl-theme">
			<div class="item"><img src="<?= SITE_URL; ?>assets/img/slide1/slide1.jpg" alt="GTA V"></div>
			<div class="item"><img src="<?= SITE_URL; ?>assets/img/slide1/slide2.jpg" alt="GTA V"></div>
			<!--<div class="item"><img src="<?= SITE_URL; ?>assets/img/slide1/slider-image-1.jpg" alt="GTA V"></div>-->
			<!--<div class="item"><img src="<?= SITE_URL; ?>assets/img/slide1/slider-image-2.jpg" alt="The Last of us"></div>-->
			<div class="item"><img src="<?= SITE_URL; ?>assets/img/slide1/slide3.jpg" alt="GTA V"></div>
		</div>
           
	</div> <!-- end of slider -->

	<div class="SliderOverlay"></div>

	<div class="slider-content hpp-search-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-12">
					<div class="search-form wow pulse" data-wow-delay="0.8s">
                                            <h5 class="searchTitle">property Searching Just Got So Easy</h5>
                                            <form action="<?= $title_action;?>" class="form-inline" method="GET" id="home_search_form">
                                                    <!-- Start Tab -->
                                                <div class="panel with-nav-tabs panel-default">
                                                    <div class="panel-heading">
                                                        <ul class="nav nav-tabs">
                                                            <li <?php if($title_action == 'buy'){ echo 'class="active"';}?> ><a href="<?= SITE_URL;?>?type=buy" >Buy</a></li>
                                                            <li <?php if($title_action == 'rent'){ echo 'class="active"';}?> ><a href="<?= SITE_URL;?>?type=rent" >Rent</a></li>
                                                            <li <?php if($title_action == 'auction'){ echo 'class="active"';}?> ><a href="<?= SITE_URL;?>?type=auction" >Auction</a></li>
                                                            <li <?php if($title_action == 'hot_price'){ echo 'class="active"';}?> ><a href="<?= SITE_URL;?>?type=hot_price" >Hot Price</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="panel-body">

                                                        <button class="btn toggle-btn smartSearch" type="button">Advance</button>

                                                        <div class="form-group">
                                                            <input type="text" name="keyword" list="keyword" class="form-control" placeholder="<?= $title_seach;?> Key word">
                                                            <datalist id="keyword">
                                                                <?php
                                                                foreach($PROPERTY_NAME_DATA AS $list){
                                                                        echo '<option value="'.$list['PROPERTY_NAME'].'"> '.$list['PROPERTY_NAME'].'</option>';
                                                                }
                                                                ?>
                                                            </datalist>
                                                        </div>
                                                        <div class="form-group width-200 countryDropoDown">                                   
                                                            <select id="lunchBegins" name="country" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Country" >
                                                              <option value="">Please Select</option>
                                                                    <?php
                                                                    if (is_array($PROPERTY_COUNTRY) AND sizeof($PROPERTY_COUNTRY) > 0 ) {
                                                                        foreach ($PROPERTY_COUNTRY AS $city):
                                                                            if (strlen($city['countryName']) > 0) {
                                                                                $icon = $active = '';
                                                                                ?>
                                                                                <?php 
                                                                                if ($PROPERTY_COUNTRY_ID == $city['countryID']) {
                                                                                        $active = 'selected';
                                                                                        $icon = '<span class="glyphicon glyphicon-ok"></span>';
                                                                                }																	
                                                                                ?> 
                                                                                <option value="<?= $city['countryID'];?>" <?= $active; ?>><?= $city['countryName']; ?></option>
                                                                                <?php		
                                                                            }

                                                                        endforeach;
                                                                    }
                                                                    ?>
                                                                </select>
                                                        </div>
                                                        <div class="form-group width-200 countryDropoDown">                                     
                                                            <select id="type_select" name="type_select"  class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Property type" >
                                                                    <option> </option>
                                                                    <?php
                                                                    if (is_array($property_type) AND sizeof($property_type) > 0 ) {
                                                                        foreach ($property_type AS $value):
                                                                            if (strlen($value['PROPERTY_TYPE_ID']) > 0) {
                                                                                $icon = $active = '';
                                                                                ?>
                                                                                <?php 
                                                                                if ($type == $value['PROPERTY_TYPE_ID']) {
                                                                                        $active = 'selected';
                                                                                        $icon = '<span class="glyphicon glyphicon-ok"></span>';
                                                                                }																	
                                                                                ?> 
                                                                                <option value="<?= $value['PROPERTY_TYPE_ID']; ?>" <?= $active; ?>>  
                                                                                        <?= $icon;?> <?= $value['PROPERTY_TYPE_NAME']; ?>																	
                                                                                </option>
                                                                                <?php
                                                                            }
                                                                        endforeach;
                                                                    }
                                                                    ?>
                                                            </select>
                                                        </div>
                                                            <button class="btn search-btn" type="submit"><i class="fa fa-search"></i></button>

                                                            <div style="display: none;" class="search-toggle">
                                                                    <div class="search-row col-md-6">  

                                                                            <select id="lunchBegins" name="street_no"  class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Street No">
                                                                                    <option></option>
                                                                                    <?php
                                                                                    if (is_array($PROPERTY_STREET_NO) AND sizeof($PROPERTY_STREET_NO) > 0 ) {
                                                                                            foreach ($PROPERTY_STREET_NO AS $street):
                                                                                                    if (strlen($street['PROPERTY_STREET_NO']) > 0) {
                                                                                                            $icon = $active = '';
                                                                                                            ?>
                                                                                                            <?php 
                                                                                                            if ($PROPERTY_STREET_NO_ID == $street['PROPERTY_STREET_NO']) {
                                                                                                                    $active = 'selected';
                                                                                                                    $icon = '<span class="glyphicon glyphicon-ok"></span>';
                                                                                                            }																	
                                                                                                            ?> 
                                                                                                            <option value="<?= $street['PROPERTY_STREET_NO'];?>" <?= $active; ?>><?= $street['PROPERTY_STREET_NO']; ?></option>
                                                                                                            <?php		
                                                                                                    }

                                                                                            endforeach;
                                                                                    }
                                                                                    ?>
                                                                            </select>
                                                                    </div>
                                                                    <div class="search-row col-md-6">
                                                                            <select id="street_address" name="street_address"  class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Street Address">
                                                                                    <option></option>
                                                                                    <?php
                                                                                    if (is_array($PROPERTY_STREET_ADDRESS) AND sizeof($PROPERTY_STREET_ADDRESS) > 0 ) {
                                                                                            foreach ($PROPERTY_STREET_ADDRESS AS $address):
                                                                                                    if (strlen($address['PROPERTY_STREET_ADDRESS']) > 0) {
                                                                                                            $icon = $active = '';
                                                                                                            ?>
                                                                                                            <?php 
                                                                                                            if ($PROPERTY_STREET_ADDRESS_ID == $address['PROPERTY_STREET_ADDRESS']) {
                                                                                                                    $active = 'selected';
                                                                                                                    $icon = '<span class="glyphicon glyphicon-ok"></span>';
                                                                                                            }																	
                                                                                                            ?> 
                                                                                                            <option value="<?= $address['PROPERTY_STREET_ADDRESS'];?>" <?= $active; ?>><?= $address['PROPERTY_STREET_ADDRESS']; ?></option>
                                                                                                            <?php		
                                                                                                    }

                                                                                            endforeach;
                                                                                    }
                                                                                    ?>
                                                                            </select>
                                                                    </div>
                                                                    <div class="search-row col-md-6">
                                                                            <select id="city" name="city"  class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Sunburn / City">
                                                                                    <option></option>
                                                                                    <?php
                                                                                    if (is_array($PROPERTY_CITY) AND sizeof($PROPERTY_CITY) > 0 ) {
                                                                                            foreach ($PROPERTY_CITY AS $city):
                                                                                                    if (strlen($city['PROPERTY_CITY']) > 0) {
                                                                                                            $icon = $active = '';
                                                                                                            ?>
                                                                                                            <?php 
                                                                                                            if ($PROPERTY_CITY_ID == $city['PROPERTY_CITY']) {
                                                                                                                    $active = 'selected';
                                                                                                                    $icon = '<span class="glyphicon glyphicon-ok"></span>';
                                                                                                            }																	
                                                                                                            ?> 
                                                                                                            <option value="<?= $city['PROPERTY_CITY'];?>" <?= $active; ?>><?= $city['PROPERTY_CITY']; ?></option>
                                                                                                            <?php		
                                                                                                    }

                                                                                            endforeach;
                                                                                    }
                                                                                    ?>
                                                                            </select>
                                                                    </div>
                                                                    <div class="search-row col-md-6">
                                                                            <select id="lunchBegins" name="location_name"  class="selectpicker" data-live-search="true" data-live-search-style="begins" title="State">
                                                                                    <option></option>

                                                                                    <?php
                                                                                    if (is_array($location) AND sizeof($location) > 0 ) {
                                                                                            foreach ($location AS $valueP):
                                                                                                    if (strlen($valueP['PROPERTY_STATE']) > 0) {
                                                                                                            $icon = $active = '';
                                                                                                            ?>
                                                                                                            <?php 
                                                                                                            if ($PROPERTY_STATE_ID == $valueP['PROPERTY_STATE']) {
                                                                                                                    $active = 'selected';
                                                                                                                    $icon = '<span class="glyphicon glyphicon-ok"></span>';
                                                                                                            }																	
                                                                                                            ?> 
                                                                                                            <option value="<?= $valueP['PROPERTY_STATE'];?>" <?= $active; ?>><?= $valueP['PROPERTY_STATE']; ?></option>
                                                                                                            <?php		
                                                                                                    }

                                                                                            endforeach;
                                                                                    }
                                                                                    ?>
                                                                            </select>
                                                                    </div>

                                                                    <div class="search-row col-md-12">   
                                                                            <div class="form-groups">
                                                                                    <label for="price-range" class="price-range">Price range ($):</label>
                                                                                    <input type="text" class="span2" value="" data-slider-min="<?= $price_min?>" data-slider-max="<?= $price_max;?>" data-slider-step="<?php $avr = ceil(($price_max / 100) * 1); echo $avr;?>" data-slider-value="[<?= $price_min?>,<?= $price_max?>]" id="price-range" ><br />
                                                                                    <b class="pull-left color">$ <?= number_format($price_min, 2)?></b> 
                                                                                    <b class="pull-right color">$ <?= number_format($price_max, 2)?></b>
                                                                            </div>

                                                                    </div>
                                                                    <button class="btn search-btn prop-btm-sheaerch" type="submit"><i class="fa fa-search"></i></button>  
                                                            </div> 


                                                    </div> <!-- End of panel Body -->
                                                </div>
                                            </form>
					</div>
					<!-- End Tab -->	

				</div> <!-- End of search-form -->
			</div>
		</div>
	</div><!-- End of container -->
</div> <!-- End of hpp-slide-caption-wrapper --> 

<div class="content-area home-area-1 recent-property mar-t-20" style="background-color: #fff; padding-bottom: 0px;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="home-top-add home-page-owl-carousel">
                    <div class="ad-single-img"> <a href="#"> <img src="<?= SITE_URL; ?>assets/img/ad/970x250.jpg" alt="Add Image" class="rounded img-responsive"></a> </div>
                    <div class="ad-single-img"> <a href="#"> <img src="<?= SITE_URL; ?>assets/img/add-970x250-1.jpg" alt="Add Image" class="rounded img-responsive"></a> </div>
                   
                </div><!-- End of home-top-add -->
            </div><!-- End of col-xs-12 -->
        </div> <!-- End of row -->
    </div> <!-- End of row -->
</div> <!-- End of row -->

<!-- Home Top Add area -->
<div class="content-area home-area-1 recent-property mar-t-20" style="background-color: #f7f8f9; padding-bottom: 55px;">
    <div class="container">

        <div class="row mar-t-55 text-center">
            <div class="col-md-4 single-service">
                <div class="service-icon"><img class="rea-product-image" src="assets/img/home_icon1.png" alt="" width="80" height="80"></div>
                <h3 class="content-title"><a href="">Research suburbs</a></h3>
                <!--<div class="single-divider"></div> -->
                <p class="rea-product-blurb">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <p class="rea-product-call-to-action">RESEARCH NOW</p>
                <a class="rea-product-link" href="" title="RESEARCH NOW">RESEARCH NOW</a>
            </div><!-- End of single-service -->

            <div class="col-md-4 single-service">
                <div class="service-icon"><img class="rea-product-image" src="assets/img/home_icon2.png" alt="" width="80" height="80"></div>
                <h3 class="content-title"><a href="">We do home loans</a></h3>
                <!--<div class="single-divider"></div> -->
                <p class="rea-product-blurb">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <p class="rea-product-call-to-action">learn more</p>
                <a class="rea-product-link" href="" title="LEARN MORE">learn more</a>
            </div><!-- End of single-service -->

            <div class="col-md-4 single-service">
                <div class="service-icon"><div class="service-icon"><img class="rea-product-image" src="assets/img/home_icon3.png" alt="" width="80" height="80"></div></div>
                <h3 class="content-title"><a href="">Sell or stay?</a></h3>
                <!--<div class="single-divider"></div> -->
                <p class="rea-product-blurb">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <p class="rea-product-call-to-action">Explore options</p>
                <a class="rea-product-link" href="" title="EXPLORE OPTIONS">Explore options</a>
            </div><!-- End of single-service -->


        </div>

    </div> <!-- End of container -->
</div> <!-- End of content-area --> 


<div class="content-area home-area-1 recent-property mar-t-20" style="background-color: #fff; padding-bottom: 30px;">
    <div class="container">
        <div class="row blog_section">
            <div class="col-md-9">
                <h2 class="rea-news-section-heading">Latest Property News</h2>
                <div class="single-divider left"></div>
                <?php
                if (is_array($PROPERTY_NEWS) AND sizeof($PROPERTY_NEWS) > 0):
                    foreach ($PROPERTY_NEWS AS $news_data):
                        ?>
                        <article class="rea-news-article rui-clearfix primary">
                            <div class="col-md-4 col-sm-4 rea-news-image paddX-0">
                                <img src="<?= SITE_URL; ?><?= $news_data['NEWS_IMAGE']; ?>" alt="<?= $news_data['NEWS_HEADDING']; ?>" >
                            </div>
                            <div class="col-md-8 col-sm-8 rea-news-content">
                                <h3 class="rea-news-heading"><?= $news_data['NEWS_HEADDING']; ?></h3>
                                <span class="rea-news-byline">by <span class="rea-news-author"><?= $news_data['AUTHOR_NAME']; ?></span> </span> 
                                <p class="rea-news-excerpt"><?= substr($news_data['NEWS_DETAILS'], 0, 150); ?>...</p>
                            </div>
                            <a class="rea-news-link" href="<?= SITE_URL; ?>news_preview?blog=<?= $news_data['NEWS_URL']; ?>">Details</a> 
                        </article>
                        <?php
                    endforeach;
                endif;
                ?>
            </div><!-- End of col-xs-12 -->
            <div class="col-md-3 home_content_add_back">
                <div class="ad-single-img ">
                    <a href="#"><img src="<?= SITE_URL; ?>assets/img/ad/360x600.jpg" class="image-responsive" alt="Ad Image"></a>
                    <a href="#"><img src="<?= SITE_URL; ?>assets/img/add-360x600.jpg" class="image-responsive" alt="Ad Image"></a>
                    <a href="#"><img src="<?= SITE_URL; ?>assets/img/ad/360x400.jpg" class="image-responsive" alt="Ad Image"></a>
                </div>
            </div><!-- End of col-xs-12 -->
        </div> <!-- End of row -->
    </div> <!-- End of row -->
</div> <!-- End of row -->


<!--- Auction Property Area -->
<!--
<section id="hpp_auction">
<div class="container hpp-position-relative">
<div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title">
                
                <h2 class="hpp-section-title"> Auction Properties </h2>
                <div class="cx-divider"></div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt . </p>
        </div>
</div>

<div class="row">
        <div class="proerty-th">
<?php
if (is_array($Auction_property) AND sizeof($Auction_property) > 0) {
    foreach ($Auction_property AS $auction):
        if (strlen($auction['PROPERTY_NAME']) > 3) {
            if (strlen($auction['IMAGE_LINK']) > 10) {
                $pro_image = SITE_URL . $auction['IMAGE_LINK'] . $auction['IMAGE_NAME'];
            } else {
                $pro_image = SITE_URL . 'assets/img/demo/property-3.jpg';
            }
            $additional_auc = $this->Property_Model->additional_property_filed($auction['PROPERTY_ID']);
            ?>

                                                    <div class="col-sm-6 col-md-3 p0">
                                                            <div class="box-two proerty-item pad-10">
                                                                    <div class="item-thumb">
                                                                            <a href="<?= SITE_URL; ?>preview?view=<?= $auction['PROPERTY_URL'] ?>" ><img src="<?= $pro_image; ?>" alt="<?= $pro_image; ?>"> </a>
            <?php if (sizeof($additional_auc) > 0) { ?>
                                                                                <div class="hot_price">
                                                                                        <ul>
                <?php
                foreach ($additional_auc AS $filed):
                    $filed_info = $this->Property_Model->any_type_where(array('ADD_FILED_ID' => $filed->ADD_FILED_ID, 'FILED_TYPE =' => 'number'), 'mt_p_property_additional_filed');
                    if (is_array($filed_info) AND sizeof($filed_info) > 0) {
                        ?>
                                                                                                                        <li><img src="<?= SITE_URL ?>icons/<?= $filed_info[0]['FILED_HTML']; ?>" title="<?= $filed_info[0]['FILED_NAME']; ?>"/> <span class="property-info-value"> <?= $filed->FILED_DATA; ?> </span></li>
                    <?php } endforeach; ?>
                                                                                                        </ul>
                                                                                                </div>
            <?php } ?>
                                                                                    </div>
                                                                                    <div class="item-entry hpp-property-name overflow">
                                                                                            <h5><a href="<?= SITE_URL; ?>preview?view=<?= $auction['PROPERTY_URL'] ?>"> <?= substr($auction['PROPERTY_NAME'], 0, 20); ?> </a></h5>
                                                                                            <div class="dot-hr"></div>
                                                                                            <span class="pull-left">Base Price <br/><b>$ <?= number_format($auction['PROPERTY_PRICE'], 2); ?></b> </span>
                                                                                            <span class="proerty-price pull-right bidding_price">Last Bid Price <br/><b>$ <?= number_format($auction['OFFER_PRICE'], 2); ?></b></span>
                                                                                    </div>
                                                                            </div>
                                                                    </div>
            <?php
        }
    endforeach;
}
?>


                        </div> 
                </div> 
        </div> 
</section>-->


<!--- Auction Property Area -->
<!--
<section id="hpp_buy" class="padd-bottom-70">
        <div class="container hpp-position-relative">
                <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title">
                                
                                <h2 class="hpp-section-title"> Buy Properties </h2>
                                <div class="cx-divider"></div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt . </p>
                        </div>
                </div>

                <div class="row">
                        <div class="proerty-th">
<?php
if (is_array($buy_property) AND sizeof($buy_property) > 0) {
    foreach ($buy_property AS $buy):
        if (strlen($buy['PROPERTY_NAME']) > 3) {
            if (strlen($buy['IMAGE_LINK']) > 10) {
                $pro_image = SITE_URL . $buy['IMAGE_LINK'] . $buy['IMAGE_NAME'];
            } else {
                $pro_image = SITE_URL . 'assets/img/demo/property-3.jpg';
            }
            $additional_buy = $this->Property_Model->additional_property_filed($buy['PROPERTY_ID']);
            ?>

                                                                    <div class="col-sm-6 col-md-3 p0">
                                                                            <div class="box-two proerty-item pad-10">
                                                                                    <div class="item-thumb">
                                                                                            <a href="<?= SITE_URL; ?>preview?view=<?= $buy['PROPERTY_URL'] ?>" ><img src="<?= $pro_image; ?>" alt="<?= $pro_image; ?>"> </a>
            <?php if (sizeof($additional_buy) > 0) { ?>
                                                                                                <div class="hot_price">
                                                                                                        <ul>
                <?php
                foreach ($additional_buy AS $filed):
                    $filed_info = $this->Property_Model->any_type_where(array('ADD_FILED_ID' => $filed->ADD_FILED_ID, 'FILED_TYPE =' => 'number'), 'mt_p_property_additional_filed');
                    if (is_array($filed_info) AND sizeof($filed_info) > 0) {
                        ?>
                                                                                                                                        <li><img src="<?= SITE_URL ?>icons/<?= $filed_info[0]['FILED_HTML']; ?>" title="<?= $filed_info[0]['FILED_NAME']; ?>"/> <span class="property-info-value"> <?= $filed->FILED_DATA; ?> </span></li>
                    <?php } endforeach; ?>
                                                                                                                        </ul>
                                                                                                                </div>
            <?php } ?>
                                                                                                    </div>
                                                                                                    <div class="item-entry hpp-property-name overflow">
                                                                                                            <h5><a href="<?= SITE_URL; ?>preview?view=<?= $buy['PROPERTY_URL'] ?>"> <?= substr($buy['PROPERTY_NAME'], 0, 20); ?> </a></h5>
                                                                                                            <div class="dot-hr"></div>
                                                                                                            <span class="pull-left"><b><?= substr($buy['PROPERTY_STATE'], 0, 15); ?></b> </span>
                                                                                                            <span class="proerty-price pull-right"><b>$ <?= number_format($buy['PROPERTY_PRICE'], 2); ?></b></span>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
            <?php
        }
    endforeach;
}
?>


                        </div> 
                </div> 
        </div> 
</section> -->




<!--Welcome area -->
<div class="Welcome-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 Welcome-entry  col-sm-12">
                <div class="col-md-5 col-md-offset-2 col-sm-6 col-xs-12">
                    <div class="welcome_text wow fadeInLeft" data-wow-delay="0.3s" data-wow-offset="100">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title">
                                <!-- /.feature title -->
                                <h2>Rent Properties </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-6 col-xs-12">
                    <div  class="welcome_services wow fadeInRight" data-wow-delay="0.3s" data-wow-offset="100">
                        <div class="row">
                            <?php
                            if (is_array($property_type) AND sizeof($property_type) > 0) {
                                $icon = array('pe-7s-home pe-4x', 'pe-7s-users pe-4x', 'pe-7s-notebook pe-4x', 'pe-7s-help2 pe-4x');
                                $ml = 0;
                                foreach ($property_type AS $value):
                                    if (strlen($value['PROPERTY_TYPE_ID']) > 0) {
                                        ?>

                                        <div class="col-xs-6 m-padding">
                                            <div class="welcome-estate">
                                                <div class="welcome-icon">
                                                    <a href="rent?keyword=&country=&type_select=<?= $value['PROPERTY_TYPE_ID']; ?>&street_no=&street_address=&city=&location_name="><i class="<?= $icon[$ml]; ?>"></i> </a>
                                                </div>
                                                <a href="rent?keyword=&country=&type_select=<?= $value['PROPERTY_TYPE_ID']; ?>&street_no=&street_address=&city=&location_name="><h3><?= $value['PROPERTY_TYPE_NAME']; ?> </h3></a>
                                            </div>
                                        </div>
                                        <?php
                                        $ml++;
                                    }
                                endforeach;
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!--TESTIMONIALS -->
<div class="testimonial-area recent-property" style="background-color: #FCFCFC; padding-bottom: 70px;">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title">
                <!-- /.feature title -->
                <h2>Our Customers Said  </h2> 
            </div>
        </div>

        <div class="row">
            <div class="row testimonial">
                <div class="col-md-12">
                    <div id="testimonial-slider">
                        <div class="item">
                            <div class="client-text">                                
                                <p>Nulla quis dapibus nisl. Suspendisse llam sed arcu ultried arcu ultricies !</p>
                                <h4><strong>Ohidul Islam, </strong><i>Web Designer</i></h4>
                            </div>
                            <div class="client-face wow fadeInRight" data-wow-delay=".9s"> 
                                <img src="<?= SITE_URL; ?>assets/img/client-face1.png" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="client-text">                                
                                <p>Nulla quis dapibus nisl. Suspendisse llam sed arcu ultried arcu ultricies !</p>
                                <h4><strong>Ohidul Islam, </strong><i>Web Designer</i></h4>
                            </div>
                            <div class="client-face">
                                <img src="<?= SITE_URL; ?>assets/img/client-face2.png" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="client-text">                                
                                <p>Nulla quis dapibus nisl. Suspendisse llam sed arcu ultried arcu ultricies !</p>
                                <h4><strong>Ohidul Islam, </strong><i>Web Designer</i></h4>
                            </div>
                            <div class="client-face">
                                <img src="<?= SITE_URL; ?>assets/img/client-face1.png" alt="">
                            </div>
                        </div>
                        <div class="item">
                            <div class="client-text">                                
                                <p>Nulla quis dapibus nisl. Suspendisse llam sed arcu ultried arcu ultricies !</p>
                                <h4><strong>Ohidul Islam, </strong><i>Web Designer</i></h4>
                            </div>
                            <div class="client-face">
                                <img src="<?= SITE_URL; ?>assets/img/client-face2.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

