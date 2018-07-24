<?php
if($pdfOption == 'No'){
?>
<?php $CI = & get_instance(); ?>	
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
                    <?= form_open('', [ 'id' => 'list_of_buyer', 'name' => 'list_of_buyer']); ?>   
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
                    <div class="col-sm-2" style="padding-top:26px;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" value="Go" name="submit" id="submit">Go</button>
                        </div>	
                    </div> 
                    <?= form_close(); ?>	
                </div>   
                <div class="col-md-12 clear padding-top-40"> 
                    <div class="company_header">
                        <div class="export-pdf text-right">
                            <a href="<?= SITE_URL; ?>hpp/report/list_of_buyer/?pdf=Yes&from_date=<?= $fromdate;?>&to_date=<?= $todate;?>" target="_blank"> <i class="fa fa-file-pdf-o"></i></a>
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
                        <div class="company_header pull-center">
                            <h5><strong>Report Title : List of Seller </strong></h5>
                            <h6>Reporting Period : <b><?= date("d M Y", strtotime($fromdate)); ?> </b> to <b><?= date("d M Y", strtotime($todate)); ?></b><h6>
                        </div>
                    </div>
		<div class="col-md-12 clear padding-top-40"> 
                    <?php
                    if (is_array($select_seller) AND sizeof($select_seller) > 0) {
                        ?>
                        <table class="table table-striped table-bordered datatable">

                            <thead>
                                <tr>
                                    <th class="center"> #SL </th>
                                    <th class="left"> Buyer Name </th>
                                    <th class="center"> Email ID </th>
                                    <th class="center"> Gender </th>


                                </tr>
                            </thead> 
                            <tbody> 
                                <?php
                                $m = 0;
                                $totalSeller = '';
                                foreach ($select_seller AS $report):
                                    $m++;
                                ?>
                                <tr>
                                    <td> <center> <?= $m; ?> </center> </td>
                                    <td> <?= $report['USER_NAME']; ?></td>
                                    <td class="center"> <?= $report['EMAIL_ADDRESS']; ?></td>
                                    <td class="center"> <?= $report['GENTER']; ?></td>
                                </tr>
                                <?php
                                //$totalSeller += $m;
                            endforeach;
                            ?>
                            </tbody> 
                            <tfoot> 
                                <tr>
                                    <td colspan="2" class="right"><b>  </b></td>
                                    <td class="right" colspan="4"> <b><?php // number_format($totalSeller); ?></b></td>
                                </tr>
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
