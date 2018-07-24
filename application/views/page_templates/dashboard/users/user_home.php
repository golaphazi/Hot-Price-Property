	<div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title">Welcome <span class="orange strong"><?= $userName;?></span></h1>               
                    </div>
                </div>
            </div>
        </div>
        <div class="properties-area recent-property" style="">
            <div class="container">  
                <div class="row">
                     
                    <?= $main_menu ?>

                    <div class="col-md-9  pr0 padding-top-40 properties-page">                    
                        <div class="col-md-12 clear"> 
                                <?php
                                    if(strlen($page) > 0){
                                            $page = $page;
                                    }else{
                                            $page = 'pages/dashboard';
                                    }
                                    $this->load->view('page_templates/dashboard/users/'.$page, '');
                                ?>
                        </div>                   
                    </div> <!-- End of properties-page --> 
                </div>  <!-- End of row -->            
            </div>
        </div>
  