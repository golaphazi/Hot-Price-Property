<div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">Agent Finder Page</h1>               
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
                        <h2> Agent Finder </h2>
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
                            <div class="col-md-3">
								<div class=" list-property-box" data-toggle="modal" onclick="property_information(<?= $term->ORG_ID; ?>);" data-target="#counterModal" data-whatever="@countermodal">
									<h6><?= $term->ORG_NAME; ?> </h6>
									<p><?= $term->ORG_ADDRESS; ?><?php if(strlen($term->ORG_ADDRESS) > 0){?>, <?php }?><?= $term->COUNTRY; ?> </p>
									
								</div>
                            </div>
                             <?php
								if(($i % 4) == 0){
							 ?>  
								<div class="clear_both"></div>
							<?php }?>
							
                            <?php 
                            $i++;
                            } 
                        
                         }?>
                           
                             
                    </div>
					<div class="col-md-12"> 
                    <div class="pull-right">
                        <div class="pagination">
                           
                            <?php
                            echo $this->Property_Model->hpp_create_link();
                            ?>

                        </div> 


                    </div>                
                </div>
                </div>
                
            </div>
        </div>
		<!-- When a product call to add HOT PRICE SECTION then Show This Modal --> 
<div class="modal fade" id="counterModal" role="submit Form Data" aria-labelledby="AddSolicitors" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content brr-0">
            <div class="modal-header">
                <h5 class="modal-title hppModalTitle" id="AddPropertToHotPriceSoli"> Agent Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalBodyCounter">

            </div>
        </div> <!-- End of modal-content -->
    </div> <!-- End of modal-dialog -->
</div> <!-- End hotPriceModal -->  