<div class="page-head"> 
		<div class="container">
			<div class="row">
				<div class="page-head-content">
					<h1 class="page-title">Property News Details</h1>               
				</div>
			</div>
		</div>
	</div>

<div class="content-area home-area-1 recent-property mar-t-20" style="background-color: #fff; padding-bottom: 30px;">
    <div class="container">
        <div class="row blog_section blog_property">
             <?php 
                if( is_array($single_blog) && sizeof($single_blog) > 0 ) : 
            ?>
            <h2 class="post-title" itemprop="headline">
                    <a>
                        <span itemprop="name"> <?= $single_blog[0]->NEWS_HEADDING; ?> </span>
                    </a>
            </h2>
            <div class="col-md-8 paddX-0">
                <div class="post-wrapper">
                    <a>
                        <figure class="item-img-wrap">
                            <img src="<?= SITE_URL . $single_blog[0]->NEWS_IMAGE; ?>" width="800" height="354" class="img-responsive" alt="News Image">
                            <div class="item-img-overlay">
                                <span></span>
                            </div>
                        </figure>                       
                    </a>
                    <ul class="list-inline post-detail">
                        <li>
                            <i class="fa fa-pencil"></i> 
                            <span class="post-author vcard">
                                <a href="#" itemprop="url" rel="author">
                                    <span class="mar-r-3" itemprop="name">By <?= $single_blog[0]->AUTHOR_NAME; ?> </span>
                                </a>
                            </span>
                        </li>
                        <li>
                            <i class="fa fa-calendar"></i> 
                            <?php
                            $getDate = strtotime($single_blog[0]->ENT_DATE);
                            echo date('F m, Y', $getDate);
                            ?>
                        </li>
                    </ul>
                    <div class="entry-content" itemprop="text"><p> <?= $single_blog[0]->NEWS_DETAILS; ?> </p></div>    
                    
                </div> <!-- End of post-wrapper-->
                
                <?php
                    endif;
                ?>

            </div><!-- End of col-md-9 -->

            <div class="col-md-4 padd-l-30 paddX-0">
                
			 <?php
					$date = date("Y-m-d H:i:s");
					$queryData = $this->db->query("SELECT * FROM ads_hpp WHERE LOCATION = 'property_blog_preview' AND POSITION = 'Right' AND STATUS = 'Active' AND (START_DATE <= '".$date."' AND END_DATE_ADS >= '".$date."') ORDER BY ADS_ID DESC LIMIT 0,1");
					$adsArray = $queryData->result_array();
					if(is_array($adsArray) AND sizeof($adsArray) > 0){
						foreach($adsArray AS $ads){
					?>
						<div class="ad-single-img ">
							<a href="<?= $ads['WEB_URL']; ?>" target="_blank"><img src="<?= SITE_URL;?><?= $ads['ADS_IMAGE']; ?>" class="image-responsive" alt="<?= $ads['ADS_TITLE']; ?>"></a>
						</div>
					<?php
						}
					}else{
					?>
					<div class="ad-single-img">
						<a href="#"><img src="<?= SITE_URL; ?>assets/img/add-360x600.jpg" class="image-responsive" alt="Ad Image"></a>
						<a href="#"><img src="<?= SITE_URL; ?>assets/img/add-360x400.jpg" class="image-responsive" alt="Ad Image"></a>
					</div>
					<?php
					}
					?>
            </div><!-- End of col-md-3 -->

        </div> <!-- End of row -->
    </div> <!-- End of container -->
</div> <!-- End of content-area -->
