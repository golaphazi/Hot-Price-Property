<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $title; ?></title>
        <meta name="description" content="GARO is a real-estate template">
        <meta name="author" content="">
        <meta name="keyword" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="icon" type="image/png" sizes="32x32" href="<?= SITE_URL; ?>assets/img/favicon-32x32.png">

        <link rel="stylesheet" href="<?= CSS_URL; ?>normalize.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>font-awesome.min.css">

        <link rel="stylesheet" href="<?= CSS_URL; ?>fontello.css">

        <link href="<?= FONTS_URL; ?>icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet">
        <link href="<?= FONTS_URL; ?>icon-7-stroke/css/helper.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Imprima&amp;subset=latin-ext" rel="stylesheet"> 
        <link href="<?= CSS_URL; ?>animate.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="<?= CSS_URL; ?>bootstrap-select.min.css"> 
        <link rel="stylesheet" href="<?= SITE_URL; ?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>icheck.min_all.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>price-range.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>owl.carousel.css">  
        <link rel="stylesheet" href="<?= CSS_URL; ?>owl.theme.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>owl.transitions.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>wizard.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>lightslider.min.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>owl.carousel.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>owl.theme.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>datatables/dataTables.bootstrap4.css"> 
        
        <link rel="stylesheet" href="<?= CSS_URL; ?>style.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>sass_style.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>responsive.css">
	<link rel="stylesheet" href="<?= CSS_URL; ?>bootstrap-date-picker.css" />
        
        <script type="text/javascript">
            var site_url = "<?= SITE_URL;?>";
        </script>
    </head>
    <body>

        <!--<div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
-->
        <!-- Body content -->

        <div class="header-connect">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-8  col-xs-12">
                        <div class="header-half header-call">
                            <p>
                                <span><i class="pe-7s-call"></i> <a href="tell:+1800 552 163"> 1800 552 163</a></span>
                                <span><i class="pe-7s-mail"></i><a href="mailto:sales@hotpriceproperty.com">sales@hotpriceproperty.com</a></span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2 col-md-offset-5  col-sm-3 col-sm-offset-1  col-xs-12">
                        <div class="header-half header-social">
                            <ul class="list-inline">
                                <li><a href="https://www.facebook.com/Hot-Price-Property-345707259271462/" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-vine"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <!--End top header -->

        <!-- Start Main nav bar -->
        <div class="navbar navbar-default">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="" href="<?= SITE_URL;?>"><img src="<?= SITE_URL;?>assets/img/logo.png" alt=""></a>
                </div>
            </div><!-- /.container-fluid -->
     </div>
        <!-- End of nav bar -->


        <!--Main content area start-->

        <?php
        if (isset($main_content)) {
            echo $main_content;
        } else {
            echo 'You may load invalid content...';
        }
        ?>
        <!--Main content area end-->


        <!-- Footer area-->
        <div class="footer-area">

           

            <div class="footer-copy text-center">
                <div class="container">
                    <div class="row">
                        <div class="text-center">
                            <span> &copy; Copyright <a href="http://www.hotpriceproperty.com">Hot Price Property</a> , All rights reserved <?= date('Y')?>   </span> 
                        </div> 
                    </div>
                </div>
            </div>

        </div>


        <script src="<?= JS_URL; ?>jquery-1.10.2.min.js"></script> 
        <script src="<?= SITE_URL; ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?= JS_URL; ?>bootstrap-select.min.js"></script>
        
        <script src="<?= JS_URL; ?>datatables/jquery.dataTables.js"></script>
        <script src="<?= JS_URL; ?>datatables/dataTables.bootstrap4.js"></script>
        
        <script src="<?= JS_URL; ?>owl.carousel.min.js"></script>
        <script src="<?= JS_URL; ?>wow.js"></script>

        <script src="<?= JS_URL; ?>icheck.min.js"></script>
        <script src="<?= JS_URL; ?>price-range.js"></script>

        <script src="<?= JS_URL; ?>jquery.bootstrap.wizard.js" type="text/javascript"></script>
        <script src="<?= JS_URL; ?>jquery.validate.min.js"></script>
        <script src="<?= JS_URL; ?>wizard.js"></script>
        <script src="<?= JS_URL; ?>lightslider.min.js"></script>
        
        <script src="<?= JS_URL; ?>owl.carousel.min.js"></script>
        
        <script src="<?= JS_URL; ?>main.js"></script>
        <script src="<?= JS_URL; ?>validation/hpp_from_validate.js"></script>
        <script src="<?= JS_URL; ?>hpp/hpp.js"></script>
        <script src="<?= JS_URL; ?>moment-js.js"></script>
        <script src="<?= JS_URL?>datepicar-js.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#image-gallery').lightSlider({
                    gallery: true,
                    item: 1,
                    thumbItem: 9,
                    slideMargin: 0,
                    speed: 500,
                    auto: true,
                    loop: true,
                    onSliderLoad: function () {
                        $('#image-gallery').removeClass('cS-hidden');
                    }
                });
            });
            $(document).ready(function(){$("#dataTable").DataTable()});
            
            //Print Report and preview....
            function PrintDiv() {
                var divToPrint = document.getElementById('print_start');
                var popupWin = window.open('', '_blank', 'width=auto,height=auto,');
                popupWin.document.open();
                popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="<?= SITE_URL; ?>bootstrap/css/bootstrap.min.css"/><link rel="stylesheet" type="text/css" href="<?= CSS_URL; ?>style.css"/><link rel="stylesheet" type="text/css" media="all" href="<?= CSS_URL; ?>sass_style.css"/><link rel="stylesheet" type="text/css" media="all" href="<?= CSS_URL; ?>print.css"/></head><body onload="window.print();window.close();"><center>' + divToPrint.innerHTML + '<center></html>');
                popupWin.document.close();
            }
        </script>
    
    </body>
</html>