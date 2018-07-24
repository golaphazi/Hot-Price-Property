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
        
        <link rel="stylesheet" href="<?= CSS_URL; ?>owl.transitions.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>owl.carousel.css">  
        <link rel="stylesheet" href="<?= CSS_URL; ?>owl.theme.css">
        
        <link rel="stylesheet" href="<?= CSS_URL; ?>wizard.css">
        <link rel="stylesheet" href="<?= CSS_URL; ?>lightslider.min.css"> 
        <link rel="stylesheet" href="<?= CSS_URL; ?>mailbox.css"> 
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
                                <span><i class="pe-7s-call"></i> <a href="tell:1800 552 163"> 1800 552 163</a></span>
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

        <?php
        $userID = $this->session->userData('userID');
        $logged_in = $this->session->userData('logged_in');

        if (isset($nav_page)) {
            $this->load->view($nav_page, isset($nav_content) ? $nav_content : array());
        } else {
            if ($userID > 0 AND $logged_in == TRUE) {
                $this->load->view('header/nav_user', isset($nav_content) ? $nav_content : array());
            } else {
                $this->load->view('header/nav', isset($nav_content) ? $nav_content : array());
            }
        }
        ?>
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

            <div class=" footer">
                <div class="container">
                    <div class="row">

                        <div class="col-md-3 col-sm-6 wow fadeInRight animated">
                            <div class="single-footer logo_hpp_footer">
                                <h4>About us </h4>
                                <div class="footer-title-line"></div>

                                <img src="<?= SITE_URL; ?>assets/img/logo.png" alt="" class="wow pulse" data-wow-delay="1s">
                                <p>Lorem ipsum dolor cum necessitatibus su quisquam molestias. Vel unde, blanditiis.</p>
                                <ul class="footer-adress">
                                    <li><i class="pe-7s-map-marker strong"> </i> 9089 your adress her</li>
                                    <li><i class="pe-7s-mail strong"> </i> <a href="mailto:sales@hotpriceproperty.com">sales@hotpriceproperty.com</a></li>
                                    <li><i class="pe-7s-call strong"> </i>  <a href="tell:1800 552 163"> 1800 552 163</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 wow fadeInRight animated">
                            <div class="single-footer">
                                <h4>Quick links </h4>
                                <div class="footer-title-line"></div>
                                <ul class="footer-menu">
                                    <li><a href="<?= SITE_URL; ?>buy/">Properties</a>  </li> 
                                     <li><a href="<?= SITE_URL; ?>service">Services</a>  </li>  
                                    <li><a href="<?= SITE_URL; ?>sell/">Submit property </a></li> 
                                    <li><a href="<?= SITE_URL; ?>contact/">Contact us</a></li> 
                                    <li><a href="<?= SITE_URL; ?>faq/">Frequently asked questions (FAQ)</a>  </li> 
                                    <li><a href="<?= SITE_URL; ?>terms/">Terms </a>  </li> 
                                    <li><a href="<?= SITE_URL; ?>property-news/">Property News </a>  </li> 
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 wow fadeInRight animated">
                            <div class="single-footer">
                                <h4>Last Property</h4>
                                <div class="footer-title-line"></div>
                                <ul class="footer-blog">
                                    <?php
                                            $buy_price = $this->db->query("SELECT * 
                                                                                    FROM 
                                                                                        p_property_basic AS basic
                                                                                    LEFT JOIN p_property_images AS images
                                                                                    ON basic.PROPERTY_ID = images.PROPERTY_ID
                                                              WHERE
                                                                    images.DEFAULT_IMAGE = 1
                                                                    AND basic.PROPERTY_STATUS = 'Active'														
                                                             GROUP BY basic.PROPERTY_ID
                                                             ORDER BY basic.ENT_DATE 
                                                             LIMIT 0,4
                                                            ");

                                            $lest_news = $buy_price->result_array(); 
                                            if(is_array($lest_news) AND sizeof($lest_news) > 0):
                                            foreach($lest_news AS $news):
                                                if(strlen($news['PROPERTY_NAME']) > 3):
                                                        if(strlen($news['IMAGE_LINK']) > 10){
                                                                $pro_image = SITE_URL.$news['IMAGE_LINK'].$news['IMAGE_NAME'];
                                                        }else{
                                                                $pro_image = SITE_URL.'assets/img/demo/property-3.jpg';
                                                        }
                                    ?>	
                                       <li>
                                        <div class="col-md-3 col-sm-4 col-xs-4 blg-thumb p0">
                                            <a href="<?= SITE_URL;?>preview?view=<?= $news['PROPERTY_URL']?>">
                                                <img src="<?= $pro_image;?>">
                                            </a>
                                            <span class="blg-date"><?= $news['ENT_DATE']?></span>

                                        </div>
                                        <div class="col-md-8  col-sm-8 col-xs-8  blg-entry">
                                            <h6> <a href="<?= SITE_URL;?>preview?view=<?= $news['PROPERTY_URL']?>"><?= substr($news['PROPERTY_NAME'], 0,20);?> </a></h6> 
                                            <p style="line-height: 17px; padding: 8px 2px;"><?= substr($news['PROPERTY_DESCRIPTION'], 0,30);?> ...</p>
                                        </div>
                                    </li> 
                                    <?php
                                    endif;
                                    endforeach;
                                    endif;
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 wow fadeInRight animated">
                            <div class="single-footer news-letter">
                                <h4>Stay in touch</h4>
                                <div class="footer-title-line"></div>
                                <p>Lorem ipsum dolor sit amet, nulla  suscipit similique quisquam molestias. Vel unde, blanditiis.</p>
                                <p id="newslatter_subscription"></p>

                                <?= form_open('',['id' => 'newslatter_subscription','name' =>'newslatter_subscription']);?>
                                    <div class="input-group">
                                        <input class="form-control" id="newslatter_email" name="newslatter_email" type="text" placeholder="E-mail ... ">
                                        <span class="input-group-btn">
                                            <button id="newsLatter" class="btn btn-primary subscribe" type="button"><i class="pe-7s-paper-plane pe-2x"></i></button>
                                        </span>
                                    </div>
                                    <!-- /input-group -->
                                <?= form_close(); ?>

                                <div class="social pull-right"> 
                                    <ul>
                                        <li><a class="wow fadeInUp animated" href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a class="wow fadeInUp animated" href="https://www.facebook.com/Hot-Price-Property-345707259271462/" target="_blank" data-wow-delay="0.2s"><i class="fa fa-facebook"></i></a></li>
                                        <li><a class="wow fadeInUp animated" href="#" data-wow-delay="0.3s"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a class="wow fadeInUp animated" href="#" data-wow-delay="0.4s"><i class="fa fa-instagram"></i></a></li>
                                        <li><a class="wow fadeInUp animated" href="#" data-wow-delay="0.6s"><i class="fa fa-dribbble"></i></a></li>
                                    </ul> 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="footer-copy text-center">
                <div class="container">
                    <div class="row">
                        <div class="pull-left">
                            <span> &copy; Copyright <a href="http://www.hotpriceproperty.com">Hot Price Property</a> , All rights reserved <?= date('Y')?>   </span> 
                        </div> 
                        <div class="bottom-menu pull-right"> 
                            <ul> 
                                <li><a class="wow fadeInUp animated" href="<?= SITE_URL; ?>" data-wow-delay="0.2s">Home</a></li>
                                <li><a class="wow fadeInUp animated" href="<?= SITE_URL; ?>" data-wow-delay="0.3s">Property</a></li>
                                <li><a class="wow fadeInUp animated" href="<?= SITE_URL; ?>blog/" data-wow-delay="0.3s">Blog</a></li>
                                <li><a class="wow fadeInUp animated" href="<?= SITE_URL; ?>faq/" data-wow-delay="0.4s">FAQ</a></li>
                                <li><a class="wow fadeInUp animated" href="<?= SITE_URL; ?>contact/" data-wow-delay="0.6s">Contact</a></li>
                            </ul> 
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="<?= JS_URL; ?>jquery-1.10.2.min.js"></script> 
        <script src="<?= SITE_URL; ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?= JS_URL; ?>bootstrap-select.min.js"></script>

        <script src="<?= JS_URL; ?>owl.carousel.min.js"></script>
        <script src="<?= JS_URL; ?>wow.js"></script>

        <script src="<?= JS_URL; ?>icheck.min.js"></script>
        <script src="<?= JS_URL; ?>price-range.js"></script>

        <script src="<?= JS_URL; ?>jquery.bootstrap.wizard.js" type="text/javascript"></script>
        <script src="<?= JS_URL; ?>jquery.validate.min.js"></script>
        <script src="<?= JS_URL; ?>wizard.js"></script>
        <script src="<?= JS_URL; ?>lightslider.min.js"></script>
        
        <script src="<?= JS_URL; ?>main.js"></script>
        <script src="<?= JS_URL; ?>validation/hpp_from_validate.js"></script>
        <script src="<?= JS_URL; ?>hpp/hpp.js"></script>
        <script src="<?= JS_URL; ?>moment-js.js"></script>
        <script src="<?= JS_URL?>datepicar-js.js"></script>
	<script src="<?= JS_URL; ?>tinyEditor/nextEditor.js"></script>

        <script>
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
            
            /**---For Home Page Ads Carousels-----*/
            var owl = $('.home-page-owl-carousel');
            owl.owlCarousel({
                items:1,
                loop:false,
                autoPlay:true,
                autoplaySpeed:500,
                autoplayTimeout: 500,
                slideSpeed: 500,
                paginationSpeed: 500,
                autoplayHoverPause:true,
                autoWidth:true
            });
            
            /**---For Details Page Ads Carousels-----*/
            var owl = $('.hpp-ads-carousel');
            owl.owlCarousel({
                items:4,
                loop:false,
                margin:10,
                autoPlay:true,
                autoplaySpeed:500,
                autoplayTimeout: 500,
                slideSpeed: 500,
                paginationSpeed: 500,
                autoplayHoverPause:true,
                autoWidth:true
            });
            
            /**------News latter subscription---*/
            $(document).ready(function(){
                    $("#newsLatter").click(function(){
                        // alert( 'Initialize The From..!' );
                        var email   = $( "#newslatter_email" ).val();
                        if( email == '' ){
                                alert( "Please Enter Email Address..." );
                        } else{
                            // AJAX Code To Submit Form.
                            $.ajax({
                                type: "POST",
                                url: "<?= SITE_URL; ?>WelcomeHpp/newslatter_suscription/?email="+email,
                                cache: false,
                                success: function(data){
                                    if(data == 1){
                                        $("#newslatter_subscription").html('Success Fully Subscribe..!');
                                    }else if(data == 0){
                                        $("#newslatter_subscription").html('Dose\'t Subscribe..!');
                                    }
                                }

                            }); //--End Ajax..
                            
                        } //-- End Else..
                        var email = null;

                }); //--End Click Function..

             }); //--End Ready Function.. 
            
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