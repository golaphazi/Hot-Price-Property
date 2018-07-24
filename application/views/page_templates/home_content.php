
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
                        <form action="<?= $title_action; ?>" class="form-inline" method="GET" id="home_search_form">
                            <!-- Start Tab -->
                            <div class="panel with-nav-tabs panel-default">
                                <div class="panel-heading">
                                    <ul class="nav nav-tabs">
                                        <li <?php if ($title_action == 'buy') {
                                            echo 'class="active"';
                                        } ?> ><a href="<?= SITE_URL; ?>?type=buy" >Buy</a></li>
                                              <li <?php if ($title_action == 'rent') {
                                            echo 'class="active"';
                                        } ?> ><a href="<?= SITE_URL; ?>?type=rent" >Rent</a></li>
                                              <li <?php if ($title_action == 'auction') {
                                            echo 'class="active"';
                                        } ?> ><a href="<?= SITE_URL; ?>?type=auction" >Auction</a></li>
                                              <li <?php if ($title_action == 'hot_price') {
                                            echo 'class="active"';
                                        } ?> ><a href="<?= SITE_URL; ?>?type=hot_price" >Hot Price</a></li>
                                    </ul>
                                </div>
                                <div class="panel-body">

                                    <button class="btn toggle-btn smartSearch" type="button">Advance</button>

                                    <div class="form-group">
                                        <input type="text" name="keyword" list="keyword" class="form-control" placeholder="street/address/sunburn/state">
                                        <datalist id="keyword">
                                            <?php
                                            foreach ($PROPERTY_NAME_DATA AS $list) {
                                                echo '<option value="' . $list['PROPERTY_NAME'] . '"> ' . $list['PROPERTY_NAME'] . '</option>';
                                            }
                                            ?>
                                        </datalist>
                                    </div>
                                    <div class="form-group width-200 countryDropoDown">                                   
                                        <select id="lunchBegins" name="country" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Country" >
                                            <option value="">Please Select</option>
                                            <?php
                                            if (is_array($PROPERTY_COUNTRY) AND sizeof($PROPERTY_COUNTRY) > 0) {
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
                                                        <option value="<?= $city['countryID']; ?>" <?= $active; ?>><?= $city['countryName']; ?></option>
                                                        <?php
                                                    }

                                                endforeach;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group width-200 countryDropoDown">                                     
                                        <select id="type_select" name="type_select"  class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Property type" >
                                            <option value=""> Please Select </option>
                                            <?php
                                            if (is_array($property_type) AND sizeof($property_type) > 0) {
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
                                                            <?= $icon; ?> <?= $value['PROPERTY_TYPE_NAME']; ?>																	
                                                        </option>
                                                        <?php
                                                    }
                                                endforeach;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button class="btn search-btn" type="submit"><i class="fa fa-search"></i>  <span class="sarch_text"> Search </span></button>

                                    <div style="display: none;" class="search-toggle">
                                        <div class="search-row col-md-6">  

                                            <select id="lunchBegins" name="street_no"  class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Street No">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (is_array($PROPERTY_STREET_NO) AND sizeof($PROPERTY_STREET_NO) > 0) {
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
                                                            <option value="<?= $street['PROPERTY_STREET_NO']; ?>" <?= $active; ?>><?= $street['PROPERTY_STREET_NO']; ?></option>
                                                            <?php
                                                        }

                                                    endforeach;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="search-row col-md-6">
                                            <select id="street_address" name="street_address"  class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Street Address">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (is_array($PROPERTY_STREET_ADDRESS) AND sizeof($PROPERTY_STREET_ADDRESS) > 0) {
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
                                                            <option value="<?= $address['PROPERTY_STREET_ADDRESS']; ?>" <?= $active; ?>><?= $address['PROPERTY_STREET_ADDRESS']; ?></option>
                                                            <?php
                                                        }

                                                    endforeach;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="search-row col-md-6">
                                            <select id="city" name="city"  class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Sunburn / City">
                                                <option value="">Please Select</option>
                                                <?php
                                                if (is_array($PROPERTY_CITY) AND sizeof($PROPERTY_CITY) > 0) {
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
                                                            <option value="<?= $city['PROPERTY_CITY']; ?>" <?= $active; ?>><?= $city['PROPERTY_CITY']; ?></option>
                                                            <?php
                                                        }

                                                    endforeach;
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="search-row col-md-6">
                                            <select id="lunchBegins" name="location_name"  class="selectpicker" data-live-search="true" data-live-search-style="begins" title="State">
                                                <option value="">Please Select</option>

                                                <?php
                                                if (is_array($location) AND sizeof($location) > 0) {
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
                                                            <option value="<?= $valueP['PROPERTY_STATE']; ?>" <?= $active; ?>><?= $valueP['PROPERTY_STATE']; ?></option>
                                                            <?php
                                                        }

                                                    endforeach;
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="search-row col-md-12">   
                                            <div class="form-groups">
                                                <label for="price-range" class="price-range">Price range:</label>
                                                <input type="text" class="span2" value="" data-slider-min="<?= $price_min ?>" data-slider-max="<?= $price_max; ?>" data-slider-step="<?php $avr = ceil(($price_max / 100) * 1);
                                                    echo $avr; ?>" data-slider-value="[<?= $price_min ?>,<?= $price_max ?>]" name="price_range" id="price-range" ><br />
                                                <b class="pull-left color"><?= number_format($price_min, 2) ?></b> 
                                                <b class="pull-right color"><?= number_format($price_max, 2) ?></b>
                                            </div>

                                        </div>
                                        <button class="btn search-btn prop-btm-sheaerch" type="submit"> <i class="fa fa-search"></i></button>  
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
    
    <!-- Start Home Ads Content -->
    <section id="home-ad-area">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 ">
<!--                    <div class="home-top-add home-page-owl-carousel">
                        <div class="ad-single-img"> <a href="#"> <img src="<?= SITE_URL; ?>assets/img/ad/970x250.jpg" alt="Add Image" class="rounded img-responsive"></a> </div>
                        <div class="ad-single-img"> <a href="#"> <img src="<?= SITE_URL; ?>assets/img/add-970x250-1.jpg" alt="Add Image" class="rounded img-responsive"></a> </div>
                    </div>-->
					<ul class="nav nav-tabs fade-carousel" role="tablist">
					<?php
					$date = date("Y-m-d H:i:s");
					$queryData = $this->db->query("SELECT * FROM ads_hpp WHERE LOCATION = 'home' AND POSITION = 'Bottom' AND STATUS = 'Active' AND (START_DATE <= '".$date."' AND END_DATE_ADS >= '".$date."') ORDER BY ADS_ID DESC");
					$adsArray = $queryData->result_array();
					if(is_array($adsArray) AND sizeof($adsArray) > 0){
						foreach($adsArray AS $ads){
					?>
						<li role="presentation" class="fade-item">
                            <a href="<?= $ads['WEB_URL']; ?>" target="_blank">
                                <div class="rle_banner_tabslist_info">
                                    <img src="<?= SITE_URL;?><?= $ads['ADS_IMAGE']; ?>" alt="ad-image" />
                                </div>
                            </a>
                        </li>
					<?php
						}
					}else{
					?>
						<li role="presentation" class="fade-item">
                            <a href="#" aria-controls="01" role="tab" data-toggle="tab">
                                <div class="rle_banner_tabslist_info">
                                    <img src="<?= SITE_URL;?>assets/img/ad/ad1.jpg" alt="ad-image" />
                                </div>
                            </a>
                        </li>
                        <li role="presentation" class="fade-item">
                            <a href="#" aria-controls="03" role="tab" data-toggle="tab">
                                <div class="rle_banner_tabslist_info">
                                    <img src="<?= SITE_URL;?>assets/img/ad/ad2.jpg" alt="ad-image" />
                                </div>
                            </a>
                        </li>
                        <li role="presentation" class="fade-item">
                            <a href="#" aria-controls="02" role="tab" data-toggle="tab">
                                <div class="rle_banner_tabslist_info">
                                    <img src="<?= SITE_URL;?>assets/img/ad/ad3.jpg" alt="ad-image" />
                                </div>
                            </a>
                        </li>
                         <li role="presentation" class="fade-item">
                            <a href="#" aria-controls="02" role="tab" data-toggle="tab">
                                <div class="rle_banner_tabslist_info">
                                    <img src="<?= SITE_URL;?>assets/img/ad/ad1.jpg" alt="ad-image" />
                                </div>
                            </a>
                        </li>
                         <li role="presentation" class="fade-item">
                            <a href="#" aria-controls="02" role="tab" data-toggle="tab">
                                <div class="rle_banner_tabslist_info">
                                    <img src="<?= SITE_URL;?>assets/img/ad/ad3.jpg" alt="ad-image" />
                                </div>
                            </a>
                        </li>
						<?php } ?>
                    </ul>


                </div><!-- End of col-xs-12 -->
            </div> <!-- End of row -->
        </div> <!-- End of row -->
    </section> <!-- End of row -->
    <!-- End Home Ads Content -->
    
    
    
</div> <!-- End of hpp-slide-caption-wrapper --> 

