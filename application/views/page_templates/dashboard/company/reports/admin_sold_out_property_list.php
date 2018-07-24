<?php
$CI = & get_instance();
if($pdfOption == 'No'){
?>	
<div class="page-head"> 
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title">Reject History</h1>               
            </div>
        </div>
    </div>
</div>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 padd-bottom-70 properties-page">                    
                <div class="col-md-12 report_bottom"> 
                    <?= form_open('', [ 'id' => 'sold_out_report', 'name' => 'sold_out_report']); ?>   
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="from_date"><b>From Date</b></label>
                            <input type="date" class="form-control" value="<?= $fromdate; ?>" name="from_date" id="from_date" placeholder="MM/DD/YYYY" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])/(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])/(?:30))|(?:(?:0[13578]|1[02])-31))" title="Enter a date in this format MM/DD/YYYY" >
                        </div>
                    </div>  
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="to_date"><b>To Date</b></label>
                            <input type="date" class="form-control" value="<?= $todate; ?>" name="to_date" id="to_date" placeholder="MM/DD/YYYY" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])/(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])/(?:30))|(?:(?:0[13578]|1[02])-31))" title="Enter a date in this format MM/DD/YYYY" >
                        </div>
                    </div> 
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="to_date"><b>Type</b></label>
                            <?= $search_type; ?>
                        </div>
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="seller_type"><b>User Name</b></label>
                            <select id="seller_type" name="user_type" class="selectpicker countryDropoDownSearch form-control" data-live-search="true" data-live-search-style="begins" title="Seller Name">
                            <option></option>
                            <?php 
                            $select_seller = '';
                            $seller_address = '';
                            $user_email = '';
                                if(is_array($select_all_seller) AND sizeof($select_all_seller) > 0 ){
                                    foreach ( $select_all_seller as $seller ){
                                       if($user_type_id == $seller->USER_ID){
                                           $select_seller = $seller->USER_NAME.' ( <small>'.$seller->USER_LOG_NAME.'</small> )';
                                           echo '<option value="'.$seller->USER_ID.'" selected>'.$seller->USER_NAME.' ( '.$seller->USER_LOG_NAME.' )'.'</option>';
                                       }else{
                                        echo '<option value="'.$seller->USER_ID.'">'.$seller->USER_NAME.' ( '.$seller->USER_LOG_NAME.' )'.'</option>';
                                       }
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div> 
                    <div class="col-sm-1" style="padding-top:26px;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" value="Go" name="submit" id="submit">Go</button>
                        </div>	
                    </div>
                    <?= form_close(); ?>	
                </div>   
                <div class="col-md-12 clear padding-top-40"> 
                    <div class="company_header">
                        <div class="export-pdf text-right">
                            <a href="<?= SITE_URL; ?>hpp/report/sold_out_property_list?pdf=Yes&from_date=<?= $fromdate;?>&to_date=<?= $todate;?>&type_search=<?= $type_search; ?>&user_type=<?= $user_type_id;?>" target="_blank"> <i class="fa fa-file-pdf-o"></i></a>
                            <a class="print-list-of-property" onclick="PrintDiv();" target="_blank" title="Print Report"> <i class="fa fa-print"></i></a>
                        </div>
                   </div>
               </div>
        <?php } else { 
                $query = $CI->any_where(array('USER_ID' => $user_type_id),'s_user_info');
                if(is_array($query) AND sizeof($query) > 0 ){
                        $select_seller = $query[0]['USER_NAME'].'( <small>'.$query[0]['USER_LOG_NAME'].' </small>)';
                    }
            ?>
            <html>
                <head>
                    <link rel="stylesheet" href="<?= SITE_URL; ?>bootstrap/css/bootstrap.min.css">
                    <link rel="stylesheet" href="<?= CSS_URL; ?>style.css">
                    <link rel="stylesheet" href="<?= CSS_URL; ?>sass_style.css">
                    <link rel="stylesheet" href="<?= CSS_URL; ?>report_style.css">
                </head>
                <body>
                    <div class="container">  
                        <div class="row">
         <?php } ?>
                <div id="print_start" class="row page">
                    <div class="col-md-12 clear report_bottom"> 
                        <div class="company_header" style="position: relative;overflow: hidden;">
                            <div class="report-logo pull-left" style="display: inline-block;position: absolute;left: 0;top: 15px;">
                                <img src="<?= SITE_URL; ?>assets/img/logo.png">
                            </div>
                            <div class="header-info">
                                <h5><strong>Report Title : Sold out property list</strong></h5>
                                <h6>Report Type : <?= $type_search; ?></h6>
                                <?php
                                    if($user_type_id > 0){
                                        echo '<h6>Seller Name : '.$select_seller.'</h6>';
                                    }   
                                ?>
                                <h6>Reporting Period : <b><?= date("d M Y", strtotime($fromdate)); ?> </b> to <b><?= date("d M Y", strtotime($todate)); ?></b></h6>
                                <!--<h6>Address : Suite 2, 13 Blackburn St, Maddington WA 6109</h6>-->
                            </div>
                        </div>
                    </div>
		<div class="col-md-12 clear padding-top-40"> 
                    <?php
                    if (is_array($sellreport) AND sizeof($sellreport) > 0) {
                        ?>
                        <table class="table table-striped table-bordered datatable">

                            <thead>
                                <tr>
                                    <th class="center"> #SL </th>
                                    <th class="left"> Property Name </th>
                                    <th class="center"> Street No. </th>
                                    <th class="center"> Sunburn/City </th>
                                    <th class="center"> Type </th>
                                    <th class="right"> Price </th>
                                    <th class="center"> Sell Date </th>
                                    <th class="right"> Sell Price </th>
                                </tr>
                            </thead> 
                            <tbody> 
							<?php
								foreach($sellreportDis AS $country){
									
									$countryId = $country['PROPERTY_COUNTRY'];
									?>
									  <tr>
										  <td colspan="8"> <center> <b><?= $country['countryName']; ?> (<?= $country['currency_code']; ?>)</b> </center> </td>
										</tr>
										<?php
										$m = 1;
										$totalPrice = 0;
										$totalSellPrice = 0;
										foreach ($sellreport AS $report):
											if($countryId == $report['PROPERTY_COUNTRY']) {
												$streetNo       = $report['PROPERTY_STREET_NO'] ? $report['PROPERTY_STREET_NO'].' ' : 'N/A';
												$streetAddress  = $report['PROPERTY_STREET_ADDRESS'] ? $report['PROPERTY_STREET_ADDRESS'] : '';
												$city           = $report['PROPERTY_CITY'] ? $report['PROPERTY_CITY'] : 'N/A';
											?>
											<tr>
												<td> <center> <?= $m; ?> </center> </td>
												<td> <?= $report['PROPERTY_NAME']; ?></td>
												<td class="center"> <?= $streetNo; ?></td>
												<td class="center"> <?= $city; ?></td>
												<td class="center"> <?= $report['PROPERTY_TYPE_NAME']; ?></td>
												<td class="right"> <?= number_format($report['PROPERTY_PRICE']); ?> <sup><?= $report['CURRENCY_SAMPLE']; ?></sup></td>
												<td class="center"> <?= date("d M Y", strtotime($report['ENT_DATE'])); ?></td>
												<td class="right"> <?= number_format($report['SELL_PRICE']); ?> <sup><?= $report['CURRENCY_SAMPLE']; ?></sup></td>
											</tr>
											<?php
											$m++;
											$totalPrice += $report['PROPERTY_PRICE'];
											$totalSellPrice += $report['SELL_PRICE'];
											}
										endforeach;
										 ?>
									
										<tr>
											<td colspan="2" class="right"><b> Total: </b></td>
											<td class="right" colspan="4"> <b><?= number_format($totalPrice); ?></b> <sup><b><?= $country['currency_symbol']; ?></b></sup></td>
											<td class="right" colspan="2"> <b><?= number_format($totalSellPrice); ?></b> <sup><b><?= $country['currency_symbol']; ?></b></sup></td>
											
										</tr>	
									 <?php
								  }
							?>
                            </tbody> 
                            <tfoot> 
                               
                            </tfoot> 
                        </table>
                        <?php
                    }else {
                        echo 'No record found..!';
                    }
                    ?>
                </div><!-- End of col-md-12 -->
                    <div class="col-xs-12">
                        <?= $company_info;?>
                    </div>
                </div>
        <?php
            if($pdfOption == 'No'){
         ?>                     
            </div> <!-- End of properties-page --> 
        </div>  <!-- End of row -->            
    </div>
</div>


<script>
    jQuery(document).ready(function () {
        jQuery('#from_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        jQuery('#to_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>

<?php } else{ ?>
            </div>
        </div>
    </body>
</html>
<?php } ?>
