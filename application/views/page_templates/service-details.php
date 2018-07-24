<?php $CI = & get_instance(); ?>

<div class="page-head"> 
    <div class="container">
        <div class="row">
            <div class="page-head-content">
                <h1 class="page-title">Our Services</h1>               
            </div>
        </div>
    </div>
</div>
<!-- End page header -->
<div class="content-area home-area-1 recent-property mar-t-20" style="background-color: #fff; padding-bottom: 30px;">
    <div class="container">
        <div class="row blog_section blog_property">
            <div class="cx-section-heading">
            <div class="col-sm-8">
                <?php 
                if(is_object( $select_service) && sizeof( $select_service ) > 0 ){
                ?>
                        <div class="cx-service-box">
                            <div class="service-single-2 clearfix">
                                <div class="media-wrapper">
                                    <h2 class="post-title" itemprop="headline">
                                        <span itemprop="name"> <?= $select_service->SERVICE_TITLE; ?> </span>
                                    </h2>
                                    <div class="entry-content" itemprop="text">
                                        <p> <?= htmlspecialchars_decode($select_service->SERVICE_DETAILS ); ?> </p>
                                    </div>
                                </div><!-- end of media-wrapper -->
                            </div><!-- end of service-single-2 -->
                        </div><!-- end of cx-service-box -->    
                <?php
                } 
                ?>
            </div><!-- End of col-md-8 -->
            

            <div class="col-md-4 padd-l-30 ">
                <div class="ad-single-img ">
                    <a href="#"><img src="<?= SITE_URL; ?>assets/img/ads.jpg" class="image-responsive" alt="Ad Image"></a>
                </div>
            </div><!-- End of col-md-3 -->

        </div> <!-- End of row -->
    </div> <!-- End of container -->
</div> <!-- End of content-area -->


