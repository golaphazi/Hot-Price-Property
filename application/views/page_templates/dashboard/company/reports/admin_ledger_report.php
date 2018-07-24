<?php 
    $CI = & get_instance(); 
    if($pdfOption == 'No' ) {
?>	
<div class="page-head"> 
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title">Ledger History</h1>               
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
                    <?= form_open('', [ 'id' => 'ledger_report', 'name' => 'ledger_report']); ?>   
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
                <div class="col-md-12 clear padding-top-40 padd-bottom-70"> 
                    <div class="company_header">
                        <div class="export-pdf text-right">
                            <a href="<?= SITE_URL; ?>hpp/report/ledger_report/?pdf=Yes&from_date=<?= $fromdate;?>&to_date=<?= $todate;?>" target="_blank"> <i class="fa fa-file-pdf-o"></i></a>
                            <a class="print-list-of-property" onclick="PrintDiv();" target="_blank" title="Print Report"> <i class="fa fa-print"></i></a>
                        </div>
                    </div>
                </div>
        <?php } else {
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
                        <div class="company_header pull-center">
                            <h5><strong>Report Title : Ledger history</strong></h5>
                            <h5>Reporting Period : <b><?= date("d M Y", strtotime($fromdate)); ?> </b> to <b><?= date("d M Y", strtotime($todate)); ?></b><h5>
                            <h5>Address : Suite 2, 13 Blackburn St, Maddington WA 6109</h5>
                        </div>
                    </div>
                        <div class="col-md-12 clear padding-top-40"> 
                            <?php
                            if (is_array($ledger_report) AND sizeof($ledger_report) > 0) {
                                ?>
                                <table class="table table-striped table-bordered datatable">

                                    <thead>
                                        <tr>
                                            <th class="center"> #SL </th>
                                            <th class="left"> Property Name </th>
                                            <th class="center"> Street No.  </th>
                                            <th class="right"> Price </th>
                                            <th class="center"> Date </th>
                                            <th class="center"> Type </th>
                                            <th class="right"> Net Price </th>

                                        </tr>
                                    </thead> 
                                    <tbody> 
                                        <?php
                                        $m = 1;
                                        $totalPrice = 0;
                                        $totalSellPrice = 0;
                                        foreach ($ledger_report AS $report):
                                            $streetNo = $report['PROPERTY_STREET_NO'] ? $report['PROPERTY_STREET_NO'] . ' ' : 'N/A';
                                            $streetAddress = $report['PROPERTY_STREET_ADDRESS'] ? $report['PROPERTY_STREET_ADDRESS'] : '';
                                            $city = $report['PROPERTY_CITY'] ? $report['PROPERTY_CITY'] : 'N/A';
                                            ?>
                                            <tr>
                                                <td> <center> <?= $m; ?> </center> </td>
                                                <td> <?= $report['PROPERTY_NAME']; ?></td>
                                                <td class="center"> <?= $streetNo; ?></td>
                                                <td class="right"> <?= number_format($report['PROPERTY_PRICE']); ?></td>
                                                <td class="center"> <?= date("d M Y", strtotime($report['SELL_DATE'])); ?></td>
                                                <td class="center"> <?php
//                                                    if ($report['USER_ID'] == $this->userID) {
//                                                        echo 'Sell';
//                                                    } else if ($report['SELL_USER'] == $this->userID) {
//                                                        echo 'Purchase';
//                                                    }
                                                    ?>
                                                </td>
                                                <td class="right"> <?= number_format($report['SELL_PRICE']); ?></td>
                                            </tr>
                                        <?php
                                        $m++;
                                        $totalPrice += $report['PROPERTY_PRICE'];
                                        $totalSellPrice += $report['SELL_PRICE'];
                                    endforeach;
                                    ?>
                                    </tbody> 
                                    <tfoot> 
                                        <tr>
                                            <td colspan="2" class="right"><b> Total: </b></td>
                                            <td colspan="2" class="right"> <b><?= number_format($totalPrice); ?></b></td>
                                            <td class="right" colspan="3" > <b> <?= number_format($totalSellPrice); ?></b></td>
                                        </tr>
                                    </tfoot> 
                                </table>
                                <?php
                            } else {
                                echo 'No record found..!';
                            }
                            ?>
                        </div>
                    <div class="col-xs-12">
                        <?= $company_info; ?>
                    </div>
                    </div>
                    <?php 
            if($pdfOption == 'No' ){
            ?>    
            </div> <!-- End of properties-page --> 
        </div>  <!-- End of row -->            
    </div>
</div>

<?php } else { ?>
            </div>
        </div>
    </body>
</html>
<?php }?>
