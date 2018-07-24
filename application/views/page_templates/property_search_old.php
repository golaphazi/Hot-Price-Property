	
<?php
//    echo '<pre>';
//    print_r($select_all_sell_property);
?>
<div class="page-head"> 
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title"><?= $type; ?> Property</h1>               
            </div>
        </div>
    </div>
</div>
<!-- End page header -->

<!-- property area -->
<div class="properties-area recent-property" style="background-color: #FFF;">
    <div class="container">  
        <div class="row">

            <div class="col-md-3 p0 padding-top-40">
                <div class="blog-asside-right pr0">
                    <div class="panel panel-default sidebar-menu wow" >
                        <div class="panel-heading">
                            <h3 class="panel-title">Smart search</h3>
                        </div>
                        <div class="panel-body search-widget">
                            <form action="" class=" form-inline" method="GET"> 


                                <fieldset>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <input type="text" name="keyword" list="keyword" value="<?= $PROPERTY_NAME_select; ?>" class="form-control" placeholder="Key word">
                                            <datalist id="keyword">
                                                <?php
                                                foreach ($PROPERTY_NAME_DATA AS $list) {
                                                    echo '<option value="' . $list['PROPERTY_NAME'] . '"> ' . $list['PROPERTY_NAME'] . '</option>';
                                                }
                                                ?>
                                            </datalist>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset >
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <select id="type_select" name="type_select" class="selectpicker countryDropoDownSearch" data-live-search="true" data-live-search-style="begins" title="Property type">
                                                <option></option>
                                                <?php
                                                if (is_array($property_type) AND sizeof($property_type) > 0) {
                                                    foreach ($property_type AS $value):
                                                        if (strlen($value['PROPERTY_TYPE_ID']) > 0) {
                                                            $icon = $active = '';
                                                            ?>
                                                            <?php
                                                            if ($type_select == $value['PROPERTY_TYPE_ID']) {
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
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="row">
                                        <div class="col-xs-6">

                                            <select id="lunchBegins" name="street_no"  class="selectpicker countryDropoDownSearch" data-live-search="true" data-live-search-style="begins" title="Street No">
                                                <option></option>
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
                                        <div class="col-xs-6">

                                            <select id="street_address" name="street_address"  class="selectpicker countryDropoDownSearch" data-live-search="true" data-live-search-style="begins" title="Street Address">
                                                <option></option>
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

                                    </div>
                                </fieldset>
                                <fieldset >
                                    <div class="row">
                                        <div class="col-xs-6">

                                            <select id="city" name="city"  class="selectpicker countryDropoDownSearch" data-live-search="true" data-live-search-style="begins" title="Sunburn / City">
                                                <option></option>
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
                                        <div class="col-xs-6">
                                            <select id="lunchBegins" name="location_name"  class="selectpicker countryDropoDownSearch" data-live-search="true" data-live-search-style="begins" title="State">
                                                <option></option>

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
                                    </div>
                                </fieldset>
                                <fieldset >
                                    <div class="row">
                                        <div class="col-xs-12">

                                            <select id="country" name="country"  class="selectpicker countryDropoDownSearch" data-live-search="true" data-live-search-style="begins" title="Country">
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

                                    </div>
                                </fieldset>

                                <fieldset class="padding-5">
                                    <div class="row">
                                        <div class="col-xs-12 range-main-div padding-5">
                                            <label for="price-range">Price range ($):</label>
                                            <input type="text" name="price_range" class="span2" value="" data-slider-min="<?= $price_min ?>" data-slider-max="<?= $price_max; ?>" data-slider-step="<?php $avr = ceil(($price_max / 100) * 1);
                                                echo $avr; ?>" data-slider-value="[<?= $price_min_val ?>,<?= $price_max_val ?>]" id="price-range" ><br />
                                            <b class="pull-left color">$ <?= number_format($price_min, 2) ?></b> 
                                            <b class="pull-right color">$ <?= number_format($price_max, 2) ?></b>
                                        </div>	
                                    </div>
                                </fieldset>                                


                                <button class="btn search-btn search_button" type="submit"><i class="fa fa-search"></i> Search </button> 

                            </form>
                        </div>
                    </div>


                </div>
            </div>

            <div class="col-md-9  pr0 padding-top-40 properties-page">
                <div class="col-md-12 clear"> 
                    <div class="col-xs-10 page-subheader sorting pl0">
                        <ul class="sort-by-list">
                            <li class="active">
                                <a href="javascript:void(0);" class="order_by_date" data-orderby="property_date" data-order="ASC">
                                    Property Date <i class="fa fa-sort-amount-asc"></i>					
                                </a>
                            </li>
                            <li class="">
                                <a href="javascript:void(0);" class="order_by_price" data-orderby="property_price" data-order="DESC">
                                    Property Price <i class="fa fa-sort-numeric-desc"></i>						
                                </a>
                            </li>
                        </ul><!--/ .sort-by-list-->

                        <div class="items-per-page">
                            <label for="items_per_page"><b>Property per page :</b></label>
                            <div class="sel">
                                <select id="items_per_page" name="per_page">
                                    <option value="3">3</option>
                                    <option value="6">6</option>
                                    <option value="9">9</option>
                                    <option selected="selected" value="12">12</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                    <option value="45">45</option>
                                    <option value="60">60</option>
                                </select>
                            </div><!--/ .sel-->
                        </div><!--/ .items-per-page-->
                    </div>

                    <div class="col-xs-2 layout-switcher">
                        <a class="layout-list" href="javascript:void(0);"> <i class="fa fa-th-list"></i>  </a>
                        <a class="layout-grid active" href="javascript:void(0);"> <i class="fa fa-th"></i> </a>                          
                    </div><!--/ .layout-switcher-->
                </div>
                <div class="col-md-12 clear"> 
                    <div id="list-type" class="proerty-th">															
                        <?php
                        if (is_array($select_all_sell_property) AND sizeof($select_all_sell_property) > 0) {
                            foreach ($select_all_sell_property AS $property) {
                                if (strlen($property['PROPERTY_NAME']) > 3) {
                                    $propertyId = $property['PROPERTY_ID'];
                                    $primaryImage = $this->Property_Model->property_image(array('PROPERTY_ID' => $propertyId, 'DEFAULT_IMAGE' => 1));

                                    if (is_array($primaryImage) > 0) {
                                        $pro_image = SITE_URL . $primaryImage[0]['IMAGE_LINK'] . $primaryImage[0]['IMAGE_NAME'];
                                    } else {
                                        $pro_image = SITE_URL . 'assets/img/demo/property-3.jpg';
                                    }
                                    $additional_sear = $this->Property_Model->additional_property_filed($property['PROPERTY_ID']);
                                    ?>
                                    <!--Property Information show-->
                                    <div class="col-sm-6 col-md-4 p0">
                                        <div class="box-two proerty-item">
                                            <div class="item-thumb">
                                                <a href="<?= SITE_URL; ?>preview?view=<?= $property['PROPERTY_URL'] ?>" ><img src="<?= $pro_image; ?>" alt="<?= $pro_image; ?>" ></a>
                                                   <?php if (sizeof($additional_sear) > 0) { ?>
                                                    <div class="hot_price">
                                                        <ul>
                                                            <?php
                                                            foreach ($additional_sear AS $filed):
                                                                $filed_info = $this->Property_Model->any_type_where(array('ADD_FILED_ID' => $filed->ADD_FILED_ID, 'FILED_TYPE =' => 'number'), 'mt_p_property_additional_filed');
                                                                if (is_array($filed_info) AND sizeof($filed_info) > 0) {
                                                                    ?>
                                                                    <li><img src="<?= SITE_URL ?>icons/<?= $filed_info[0]['FILED_HTML']; ?>" title="<?= $filed_info[0]['FILED_NAME']; ?>"/> <span class="property-info-value"> <?= $filed->FILED_DATA; ?> </span></li>
                                                            <?php } endforeach; ?>
                                                        </ul>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <div class="item-entry overflow">
                                                <h5><a href="<?= SITE_URL; ?>preview?view=<?= $property['PROPERTY_URL'] ?>"> <?= substr($property['PROPERTY_NAME'], 0, 22); ?> </a></h5>
                                                <div class="dot-hr"></div>
                                                <!--<span class="pull-left"><b> Area :</b> 120m </span>-->
                                                <span class="pull-left"><b> <?= substr($property['PROPERTY_STATE'], 0, 18); ?> </span>
                                                <span class="proerty-price pull-right"> $ <?= number_format($property['PROPERTY_PRICE'], 2); ?></span>
                                                <p style="display: none;"> <?= substr(strip_tags(preg_replace('/style[^>]*/', '', htmlspecialchars_decode($property['PROPERTY_DESCRIPTION']))),0, 120); ?></p>

                                            </div>


                                        </div>
                                    </div> 

                                    <!--Property Information show end-->

                                    <?php
                                } /* end if after foreach */
                            } /* end foreach */
                        } else {
                            echo '<div class="alert alert-warning"> Sorry!!! could`t found property</div>';
                        }
                        ?>
                    </div>
                </div>

                <div class="col-md-12"> 
                    <div class="pull-right">
                        <div class="pagination">
                            <?php
                            echo $this->Property_Model->hpp_create_link();
                            ?>
                        </div> 

                    </div>                
                </div>

            </div>  
        </div>              
    </div>
</div>


<script>
    function change_range(data) {
        var valueD = data.value;
        var id = data.id;
        $("#" + id).attr('title', valueD);
    }
</script>
