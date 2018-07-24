<?php $CI = & get_instance(); ?>


<div class="properties-area recent-property" style="">
    <div class="container">  
        <div class="row">

            <?= $user_menu; ?>

            <div class="col-md-9  pr0 padding-top-25 properties-page"> 
                <div class="admin-logout text-right"><a href="<?= SITE_URL; ?>logout-admin">Logout<i class="fa fa-sign-out"></i></a></div>
                <div class="col-md-12 clear "> 
                    <h5>Welcome To Hot Price Property Dashboard..!</h5>
                </div>   
                <div class="col-md-12 clear"> 
                    
                </div>

            </div> <!-- End of properties-page --> 
        </div>  <!-- End of row -->            
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#from_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#to_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
