<?php $CI =& get_instance(); ?>

<div class="page-head"> 
		<div class="container">
			<div class="row">
				<div class="page-head-content">
					<h1 class="page-title">Property News</h1>               
				</div>
			</div>
		</div>
	</div>
	<!-- End page header -->
<div class="content-area home-area-1 recent-property mar-t-20" style="background-color: #fff; padding-bottom: 30px;">
    <div class="container">
        <div class="row blog_section blog_property">
            <h2 class="rea-news-section-heading">Our Latest Property News</h2>
            <div class="col-md-8 paddX-0">
                
                <div class="single-divider left"></div>
                <?php 
                    if( is_array( $select_blogs ) && sizeof( $select_blogs ) > 0 ) : 
                        foreach ( $select_blogs as $blog ) : ?>
                            <div class="post-wrapper ">
                                <a href="<?= SITE_URL;?>news_preview?blog=<?= $blog['NEWS_URL'];?>">
                                    <figure class="item-img-wrap">
                                        <img src="<?= SITE_URL . $blog['NEWS_IMAGE']; ?>" width="800" height="354" class="img-responsive" alt="News Image">
                                        <div class="item-img-overlay">
                                            <span></span>
                                        </div>
                                    </figure>                       
                                </a>
                                <ul class="list-inline post-detail">
                                    <li>
                                        <i class="fa fa-pencil"></i> 
                                        <span class="post-author vcard">
                                        <a href="<?= SITE_URL;?>news_preview?blog=<?= $blog['NEWS_URL'];?>" itemprop="url" rel="author">
                                            <span class="mar-r-3" itemprop="name">By <?= $blog['AUTHOR_NAME']; ?> </span>
                                        </a>
                                        </span>
                                    </li>
                                    <li>
                                        <i class="fa fa-calendar"></i> 
                                        <?php 
                                            $getDate = strtotime($blog['ENT_DATE']); 
                                            echo date('F m, Y', $getDate ); 
                                        ?>
                                    </li>
                                </ul>
                                <h2 class="post-title" itemprop="headline">
                                    <a href="<?= SITE_URL;?>news_preview?blog=<?= $blog['NEWS_URL'];?>" rel="bookmark" itemprop="url">
                                        <span itemprop="name"> <?= $blog['NEWS_HEADDING']; ?> </span>
                                    </a>
                                </h2>
                                <div class="entry-content" itemprop="text"><p> <?= $CI->trim_text( $blog['NEWS_DETAILS'], 300 ); ?> </p>
                                    <p class="blog-more"><a class="cx-btn" href="<?= SITE_URL;?>news_preview?blog=<?= $blog['NEWS_URL'];?>">Read More</a></p>
                                </div><!-- .entry-content -->                
                            </div>
                <?php
                        endforeach;
                    endif;
                ?>

            </div><!-- End of col-md-9 -->

            <div class="col-md-4 padd-l-30 paddX-0">
                 <?php
						$date = date("Y-m-d H:i:s");
						$queryData = $this->db->query("SELECT * FROM ads_hpp WHERE LOCATION = 'property_blog' AND POSITION = 'Right' AND STATUS = 'Active' AND (START_DATE <= '".$date."' AND END_DATE_ADS >= '".$date."') ORDER BY ADS_ID DESC LIMIT 0,1");
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
						<div class="ad-single-img ">
							<a href="#"><img src="<?= SITE_URL;?>assets/img/ads.jpg" class="image-responsive" alt="Ad Image"></a>
						</div>
						<?php
						}
						?>
				
				
            </div><!-- End of col-md-3 -->

        </div> <!-- End of row -->
    </div> <!-- End of container -->
</div> <!-- End of content-area -->