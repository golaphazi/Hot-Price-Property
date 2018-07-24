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
                    
                        <?php
                        if ( $single_blog[0]->NEWS_STATUS == 'Pending' ):
                            ?>
                            <div class="col-md-12 paddX-0">
                                <a href="" onclick="active_news_by_id(<?php echo $single_blog[0]->NEWS_ID; ?>);" class="btn btn-success">Approved</a>
                            </div>
                            <?php
                        endif;
                        ?>
                </div> <!-- End of post-wrapper-->
                
                <?php
                    endif;
                ?>

            </div><!-- End of col-md-9 -->

            <div class="col-md-4 padd-l-30 ">
                <div class="ad-single-img">
                    <a href="#"><img src="<?= SITE_URL; ?>assets/img/add-360x600.jpg" class="image-responsive" alt="Ad Image"></a>
                    <a href="#"><img src="<?= SITE_URL; ?>assets/img/add-360x400.jpg" class="image-responsive" alt="Ad Image"></a>
                </div>
            </div><!-- End of col-md-3 -->

        </div> <!-- End of row -->
    </div> <!-- End of container -->
</div> <!-- End of content-area -->
