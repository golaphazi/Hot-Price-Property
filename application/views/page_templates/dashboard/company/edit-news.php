<?php $CI =& get_instance(); ?>
<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-7 col-md-offset-1  pr0 padding-top-40 properties-page"> 
                <h4 class="center sectionTitle"><srtong>::</srtong> Edit News <srtong>::</srtong> </h4>
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        $message = $this->session->userdata('message');
                        if ($message) {
                            ?> 
                            <div class="alert alert-success">
                                <?php echo $message; ?>
                            </div>
                            <?php
                            $this->session->unset_userdata('message');
                        }
                        ?>    
                    </div> <!-- End of col-xs-12 -->
                </div> <!-- End of row-->

                <div class="hpp_wpapper_table">
                    <?php 
//                        if( is_array( $single_news) && sizeof( $single_news ) > 0 ) :
//                            print_r($single_news);
                    ?>
                        <?= form_open_multipart('', ['id' => 'editNewsForm' , 'name' => 'editNews'] ); ?>

                        <div class="form-group">
                            <label for="headline"><b> Title: </b></label>
                            <input name="news_title" id="headline" type="text" value="<?= $single_news->NEWS_HEADDING; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="newsDesc"><b>Description : </b></label>
                            <textarea name="news_description" id="newsDesc" class="form-control" rows="8" cols="50" style="display:none;"><?= $single_news->NEWS_DETAILS; ?></textarea>
                            <?php $editor['id'] = 'newsDesc'; $this->load->view('Next_editor/editor', $editor);?>
                        </div>
                        <div class="form-group">
                            <label for="newsImage"><b>Image : </b></label>
                            <input name="news_image" id="newsImage" type="file" class="form-control" >
                            <span style="margin-top: 5px;display: inline-block">
                                <img src="<?= SITE_URL.$single_news->NEWS_IMAGE; ?>" width="60" height="60" alt="news Image" />
                            </span>
                        </div>

                        <div class="col-md-12 marY-30">
                            <button type="submit" name="EditNews" class="btn btn-default pull-right">Update News</button>
                        </div>

                        <?= form_close(); ?>
                    <?php //endif; ?>
                </div> <!-- End of hpp_wpapper_table --> 
            </div> <!-- End of properties-page --> 
        </div>  <!-- End of row -->            
    </div>
</div>