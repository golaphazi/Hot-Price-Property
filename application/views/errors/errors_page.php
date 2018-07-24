	<?php
	if(isset($heading) AND strlen($heading) > 0){
		$heading = $heading;
	}else{
		$heading = 'Unauthorized access this page';
	}
	
	if(isset($message) AND strlen($message) > 0){
		$message = $message;
	}else{
		$message = 'Sorry don\'t have permission for access this page';
	}
	?>
	
	<div class="page-head"> 
            <div class="container">
                <div class="row">
                    <div class="page-head-content">
                        <h1 class="page-title"><span class="orange strong"><?= $heading;?></span></h1>               
                    </div>
                </div>
            </div>
        </div>
		
		<div class="properties-area recent-property" style="">
            <div class="container">  
                <div class="row">
					<div class="col-md-12 clear"> 
						<center><h3><?= $message;?></h3></center>
					</div>
				</div>
			</div>
		</div>