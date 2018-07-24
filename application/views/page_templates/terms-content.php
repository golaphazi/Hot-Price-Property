<div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">FAQ PAge</h1>               
                    </div>
                </div>
            </div>
        </div>
        <!-- End page header -->
        

        <!-- property area -->
        <div class="content-area recent-property" style="background-color: #FCFCFC; padding-bottom: 55px;">
            <div class="container">    

                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title">
                        <!-- /.feature title -->
                        <h2> OUR TERMS </h2>
                        <br>
                    </div>
                </div>

                <div class="row row-feat"> 
                    <div class="col-md-12">
                       
                        <?php 
                        if( is_array( $select_all_terms ) && sizeof( $select_all_terms ) ){
                            $i = 1;
                            foreach ( $select_all_terms as $term ){
                            ?>
                            
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                             <h4 class="panel-title fqa-title" data-toggle="collapse" data-target="#fqa<?= $i; ?>" >
                                                 <b><?= $i; ?>. &nbsp; </b> <?= $term->TERMS_TITLE; ?>
                                             </h4> 
                                        </div>
                                        <div id="fqa<?= $i; ?>" class="panel-collapse collapse fqa-body">
                                            <div class="panel-body">
                                                <?= htmlspecialchars_decode( $term->TERMS_DETAILS ); ?> 
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                
                            <?php 
                            $i++;
                            } 
                        
                         }?>
                           
                             
                    </div>
                </div>
                
            </div>
        </div>