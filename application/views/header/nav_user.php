<?php $CI =& get_instance(); ?>
<style>
.ymm-sw .dropdown-menu_click li {
	clear: both;
	height: 39px;
}
.dropdown-menu_click > li > a {
	display: block;
	padding: 6px 8px;
	clear: both;
	font-weight: 400;
	line-height: 2em;
	color: #333;
	white-space: nowrap;
}
.subMenu_drop:hover .dropdown-menu_click{
	display:block;
	margin-top: -24px;
}
.dropdown-menu_click > li > a:hover{
	color: #000 !important;
}
</style>
<nav class="navbar navbar-default <?= isset($MENU_NAV) ? $MENU_NAV : ''; ?>">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo_hpp" href="<?= SITE_URL; ?>"><img src="<?= SITE_URL; ?>assets/img/logo.png" alt=""></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse yamm" id="navigation">
            <div class="button navbar-right hpp-user-navbar">
                <?php
                $userType = $this->session->userData('userType');
                $navOther = $this->user->any_where(array('NAV_TYPE' => 'RightNav', 'USER_TYPE_ID' => $userType, 'NAV_STATUS' => 'Active'), 'mt_nav_access');
                if (is_array($navOther) AND sizeof($navOther) > 0) {
                    ?>

                    <a class="navbar-btn nav-button wow fadeInRight join" href="<?= SITE_URL; ?><?= $navOther[0]['NAV_URL'] ?>/" data-wow-delay="0.48s"><?= $navOther[0]['NAV_NAME'] ?></a>

                    <?php
                }
                $adminName = $this->session->userData('adminName');
                $userName = $this->session->userData('userName');
                $userId = $this->session->userData('userID');
                $user_profile = $CI->user->select_user_profile_by_id( $userId )
                ?>

                    <ul class="nav navbar-nav navbar-right userprofile_menu">
                        <li class="dropdown" style="position:relative;">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span>
                                <span class="glyphicon glyphicon-chevron-down"></span>
                            </a>
                            <ul class="dropdown-menu absolate">
                                <li class="">
                                    <div class="navbar-login">
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 col-lg-4">
                                                <p class="text-center" style="position:relative;">
                                                    <span class="userIcon"><img src="<?= SITE_URL . $user_profile->PROFILE_IMAGE;?>" ></span>
													<span class="verify_css"><?= $user_profile->VERIFY_STATUS;?> </span>
                                                </p>
                                            </div>
                                            <div class="col-xs-8 col-sm-8 col-lg-8">
                                                <p class="text-left"><strong><?= $userName; ?></strong> </p>
                                                <p class="text-left">
                                                    <a href="<?= SITE_URL; ?>profile/" class="">Your Profile</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="navbar-login navbar-login-session">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-lg-12">
                                                <p>
                                                    <a href="<?= SITE_URL; ?>logout/" class="btn btn-danger btn-block">Logout</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    

            </div>
            <ul class="main-nav nav navbar-nav navbar-right">
                <li class="dropdown ymm-sw " data-wow-delay="0.1s">
                    <a href="<?= SITE_URL; ?>" class="active1" data-delay="200">Home </a>
                </li>

                <?php
                $hppmainMenu = $this->db->query("SELECT * FROM mt_nav_access WHERE NAV_TYPE = 'Dynamic' AND USER_TYPE_ID = '$userType' AND NAV_STATUS = 'Active' ORDER BY SORTING ASC");
                //$navMain = $this->user->any_where(array('NAV_TYPE' => 'Dynamic', 'USER_TYPE_ID' => $userType, 'NAV_STATUS' => 'Active'), 'mt_nav_access');
                $navMain = $hppmainMenu->result_array();
                $i = 0.2;
                if (is_array($navMain) AND sizeof($navMain) > 0) {
                    foreach ($navMain AS $key => $value):
                        ?>
                        <li class="wow fadeInDown" data-wow-delay="<?= $i; ?>s"><a class="" href="<?= SITE_URL; ?><?= $value['NAV_URL'] ?>/"><?= $value['NAV_NAME'] ?></a></li>

                        <?php
                        $i+=0.1;
                    endforeach;
                }
                ?>
				<li class="dropdown ymm-sw subMenu_drop">
                    <a href="javascript:void();" class="dropdown-toggle" data-toggle="dropdown" >About us </a>
					<ul class="dropdown-menu dropdown-menu_click" >
						  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?= SITE_URL; ?>advertise/">Advertise with us</a></li>
						  <li role="presentation"><a role="menuitem" tabindex="-2" href="<?= SITE_URL; ?>find-agent/">Find an agent </a></li>
						  <li role="presentation"><a role="menuitem" tabindex="-2" href="<?= SITE_URL; ?>terms/">Legal </a></li>
						  <li role="presentation"><a role="menuitem" tabindex="-2" href="<?= SITE_URL; ?>careers/">Careers  </a></li>
						  <li role="presentation"><a role="menuitem" tabindex="-2" href="<?= SITE_URL; ?>contact/">Contact us  </a></li>
					</ul>
					 
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>