<?php
$CI = & get_instance();
if($pdfOption == 'No'){
?>
	
<div class="page-head"> 
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title">Purchase History</h1>               
            </div>
        </div>
    </div>
</div>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-40 properties-page">                    
                <div class="col-md-12 clear report_bottom"> 
                    <?= form_open('', [ 'id' => 'purchase_report', 'name' => 'purchase_report']); ?>   
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="from_date"><b>From Date</b></label>
                            <input type="date" class="form-control" value="<?= $fromdate; ?>" name="from_date" id="from_date" placeholder="MM/DD/YYYY" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])/(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])/(?:30))|(?:(?:0[13578]|1[02])-31))" title="Enter a date in this format MM/DD/YYYY" >
                        </div>
                    </div>  
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="to_date"><b>To Date</b></label>
                            <input type="date" class="form-control" value="<?= $todate; ?>" name="to_date" id="to_date" placeholder="MM/DD/YYYY" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])/(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])/(?:30))|(?:(?:0[13578]|1[02])-31))" title="Enter a date in this format MM/DD/YYYY" >
                        </div>
                    </div> 
                    <div class="col-sm-4" style="padding-top:26px;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" value="Go" name="submit" id="submit">Go</button>
                        </div>	
                    </div> 
                    <?= form_close(); ?>	
                </div>   
                <div class="col-md-12 clear padding-top-40"> 
                    <div class="company_header">
                        <div class="export-pdf text-right">
                            <a href="<?= SITE_URL; ?>purchase-report/?pdf=Yes&from_date=<?= $fromdate;?>&to_date=<?= $todate;?>" target="_blank"> <i class="fa fa-file-pdf-o"></i></a>
                            <a class="print-list-of-property" onclick="PrintDiv();" target="_blank" title="Print Report"> <i class="fa fa-print"></i></a>
                        </div>
                   </div>
                </div>
             <?php } else { ?>
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
                                <h5><strong>Report Title : Purchase History</strong></h5>
                                <h6>Reporting Period : <b><?= date("d M Y", strtotime($fromdate)); ?> </b> to <b><?= date("d M Y", strtotime($todate)); ?></b><h6>
                                <h6>Address : <?= $user_address; ?></h6>
                            </div>
                        </div>
                    </div>
                <div class="col-md-12 clear padding-top-40"> 
                    <?php
                    if (is_array($purchase_report) AND sizeof($purchase_report) > 0) {
                        ?>
						<div style="clear:both;"> </div>
							<div class="table-responsive">
                        <table class="table table-striped table-bordered datatable">

                            <thead>
                                <tr>
                                    <th class="center"> #SL </th>
                                    <th class="left"> Property Name </th>
                                    <th class="center"> Street No. </th>
                                    <th class="center"> Sunburn/City </th>
                                    <th class="center"> Date </th>
                                    <th class="right"> Purchase Price </th>

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
										foreach ($purchase_report AS $report):
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
												<td class="center"> <?= date("d M Y", strtotime($report['SELL_DATE'])); ?></td>
												<td class="right"> <?= number_format($report['SELL_PRICE']); ?> <sup><?= $report['CURRENCY_SAMPLE']; ?></sup></td>
											</tr>
											<?php
											$m++;
											//$totalPrice += $report['PROPERTY_PRICE'];
											$totalSellPrice += $report['SELL_PRICE'];
										}
									endforeach;
									 ?>
										
										<tr>
											<td colspan="2" class="right"><b> Total: </b></td>
											<td class="right" colspan="4" > <b><?= number_format($totalSellPrice); ?></b> <sup><b><?= $country['currency_symbol']; ?></b></sup></td>

										</tr>	
									 <?php
								  }
								?>
                            </tbody> 
                            <tfoot> 
                               
                            </tfoot> 
                        </table>
                        </div>
                        <?php
                    }else {
                        echo 'No record found..!';
                    }
                    ?>
                </div><!-- End of col-md-12 -->
                    <div class="col-xs-12">
                        <?= $footer_user;?>
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


<?php } else{ ?>
            </div>
        </div>
    </body>
</html>
<?php } ?>
