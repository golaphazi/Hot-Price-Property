<div class="col-md-3 p0 padding-top-40 profile_menu_right">
    <div class="blog-asside-right">
        <div class="panel panel-default sidebar-menu wow" >
            <div class="panel-heading">
                <h3 class="panel-title">Dashboard</h3>
            </div>
            <?php
            $userType = $this->session->userData('userType');
            $roleId = $this->session->userData('roleId');

            $other_user_type = $this->user->any_where(array('TYPE_STATUS' => 'Active', 'TYPE_VIEW' => 'Other'), 'mt_s_user_type');
            $otherTypeID = $other_user_type[0]['USER_TYPE_ID'];

            $other_role_type = $this->user->any_where(array('ROLE_STATUS' => 'Active', 'ROLE_TYPE' => 'Other'), 'mt_s_user_role');
            $otherRoleID = $other_role_type[0]['ROLE_ID'];
			
			
			$queryAllCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS all_cunt FROM sms_contact_agent_user WHERE TO_USER = '$this->userID' AND SMS_STATUS = 'Send' AND SEEN_TYPE = 'show'");
			$count_all= $queryAllCount->result();	
			$ALL_COUNT = $count_all[0]->all_cunt;
			
			$countMass = '';
			if($ALL_COUNT > 0){
				$countMass = '<span class="count_massage">'.$ALL_COUNT.'</span>';	
			}
			
            ?>
            <div class="panel-body search-widget profile_ul">
                <ul>
                    <?php
                        $checked = '';
                        if($select_page == 'dashboard' ){
                                $checked = 'active-page';
                            }
                    ?>
                    <li class="<?= $checked; ?> dashboard"><a href="<?= SITE_URL; ?>dashboard/"> Dashboard </a></li>
                    <?php
                    $pages = $this->user->user_pages($otherTypeID, $otherRoleID);
                    
                    if (is_array($pages) AND sizeof($pages) > 0) {
                        $Profile = 0;
                        $Property = 0;
                        $Massage = 0;
                        $Report = 0;
						foreach ($pages AS $info):
                            $checked = '';
                            if($select_page == $info->PAGE_URL){
                                $checked = 'active-page';
                            }
							
							if($Profile == 0 AND $info->SORTING_TYPE == 'Profile'){
								echo '<li class="manu_separate"> Profile </li>'; 
								$Profile++;
							}else if($Property == 0 AND $info->SORTING_TYPE == 'Property'){
								echo '<li class="manu_separate"> Property </li>'; 
								$Property++;
							}else if($Massage == 0 AND $info->SORTING_TYPE == 'Massage'){
								echo '<li class="manu_separate"> Massage  '.$countMass.'</li>'; 
								$Massage++;
							}else if($Report == 0 AND $info->SORTING_TYPE == 'Report'){
								echo '<li class="manu_separate"> Report </li>'; 
								$Report++;
							}
							
                            if (($info->PAGE_TYPE == 'Access' OR $info->PAGE_TYPE == 'All_S_B') AND $info->ROLE_ID == $roleId) {
                                ?>
                                <li class="<?=  $checked;?>"><a href="<?= SITE_URL; ?><?= $info->PAGE_URL; ?>"><?= $info->PAGE_NAME; ?> </a></li>
                                <?php
                            } else {
                                ?>
                                <li class="<?=  $checked;?>"><a href="<?= SITE_URL; ?><?= $info->PAGE_URL; ?>"><?= $info->PAGE_NAME; ?></a></li>
                                <?php
                            }
                        endforeach;
                    }
                    ?>
                        <li class="manu_separate"> <a  href="<?= SITE_URL; ?>logout/"><span class="Iconlogout glyphicon glyphicon-log-out" title="Logout"></span><span class="Userlogout"  title="Logout">LogOut</span></a></li>
                </ul>
            </div>
        </div>

    </div>
</div>