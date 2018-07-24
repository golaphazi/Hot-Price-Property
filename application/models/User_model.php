<?php

Class User_model Extends CI_model {

    var $CI;
    
    public $userID;

    public function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        $this->userID = $this->session->userData( 'userID' );
    }

    public function valitation($valid = array()) {
        if (is_array($valid) AND sizeof($valid)) {
            $mas = 0;
            $res = '';
            foreach ($valid as $key => $arry) {

                $then = 0;
                if (is_array($arry) AND sizeof($arry) > 0) {
                    if ($key == 'text') {
                        if (array_key_exists('data', $arry)) {
                            if (array_key_exists('then', $arry)) {
                                $then = $arry['then'];
                            }
                            if (strlen($arry['data']) > $then) {
                                $mas = 1;
                            } else {
                                if (array_key_exists('massage', $arry)) {
                                    $res = $arry['massage'];
                                }$mas = 0;
                            }
                        } else {
                            $res = 'Check invalid for ';
                            $mas = 0;
                        }
                        break;
                    } // end text
                    else if ($key == 'email') {
                        if (array_key_exists('data', $arry)) {
                            if (filter_var($arry['data'], FILTER_VALIDATE_EMAIL)) {
                                $mas = 1;
                            } else {
                                if (array_key_exists('massage', $arry)) {
                                    $res = $arry['massage'];
                                }$mas = 0;
                            }
                        } else {
                            $res = 'Check invalid for ';
                            $mas = 0;
                        }
                        break;
                    } //end email
                    else if ($key == 'size') {
                        if (array_key_exists('data', $arry)) {
                            if (array_key_exists('then', $arry)) {
                                $then = $arry['then'];
                            }
                            if (sizeof($arry['data']) > $then) {
                                $mas = 1;
                            } else {
                                if (array_key_exists('massage', $arry)) {
                                    $res = $arry['massage'];
                                }$mas = 0;
                            }
                        } else {
                            $res = 'Check invalid for ';
                            $mas = 0;
                        }
                        break;
                    } //end size

                    if ($mas == 1) {
                        return 11;
                    } else {
                        return $res;
                    }
                }
            }
        }
    }

    /*     * nav bar dynamic* */

    public function admin_login_id(){
        $admin = 1;
        $admin_select = $this->db->query("SELECT ADMIN_ID FROM admin_access WHERE LOG_STATUS = 'Online' ORDER BY LOG_TIME DESC LIMIT 0,1");
        if($admin_select->num_rows() > 0){
            $admin_fet = $admin_select->row();
            $admin = $admin_fet->ADMIN_ID;
        }
        return  $admin;
    }
    
    public function any_where($query = array(), $table = '', $filed = '') {
        if (strlen($table) > 0) {
            $this->hpp_table = $table;
        }
        if (is_array($query) AND sizeof($query) > 0) {
            $query['COMPANY_ID'] = $this->conpanyID;
            $this->hpp_query = $query;
        }
        $this->db->where($this->hpp_query);
        $results = $this->db->get($this->hpp_table)->result_array();

        if (strlen($filed) > 0) {
            return $results[0][$filed];
        } else {
            return $results;
        }
    }

    public function user_pages($otherTypeID, $otherRoleID) {
        $userType = $this->session->userData('userType');
        $roleId = $this->session->userData('roleId');
        $userID = $this->session->userData('userID');
        $access = $this->session->userData('access');

        if ($access == 'Parent') {
            $search = "SELECT * 
                                FROM
                                    mt_pg_page_name AS page									
                                INNER JOIN 
                                        mt_s_user_type AS type									
                                ON 	page.USER_TYPE_ID = type.USER_TYPE_ID
                                INNER JOIN 
                                        mt_s_user_role AS role									
                                ON 	page.ROLE_ID = role.ROLE_ID
                                WHERE 	
                                        (page.USER_TYPE_ID = " . $userType . "
                                        OR page.USER_TYPE_ID = " . $otherTypeID . ")
                                        AND (page.ROLE_ID = " . $roleId . "
                                        OR page.ROLE_ID = " . $otherRoleID . ")
                                        AND page.PAGE_STATUS = 'Active'
                                        AND page.COMPANY_ID = " . $this->conpanyID . "
								ORDER BY page.SORTING_TYPE, page.SORTING
                        ";
        } else {

            $search = "SELECT * 
                                FROM
                                    mt_pg_page_name AS page									
                                INNER JOIN 
                                          mt_pg_page_access AS access									
									ON page.PAGE_ID = access.PAGE_ID
                                WHERE
                                    page.COMPANY_ID = " . $this->conpanyID . "
                                    AND page.PAGE_STATUS = 'Active'
                                    AND access.ACCESS_STATUS = 'Active'
									AND access.USER_ID = " . $userID . "
								ORDER BY page.SORTING_TYPE, page.SORTING
                    ";
        }
        $query = $this->db->query($search);
        $count = $query->num_rows();
        if ($count > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

	 public function user_pages_admin() {
        $this->adminType 	= $this->session->userData('adminType');
		
		$search = "SELECT * 
							FROM
								admin_pages AS page									
							
							WHERE
								page.COMPANY_ID = " . $this->conpanyID . "
								AND page.PAGE_STATUS = 'Active'
								AND (page.PAGE_TYPE = 'All'								
								OR page.PAGE_TYPE = '$this->adminType')								
							ORDER BY page.SORTING_TYPE, page.SORTING
				";        
        $query = $this->db->query($search);
        $count = $query->num_rows();
        if ($count > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    /** start select* */
    public function create_select($data = array(), $value = '', $print = '', $check = '0') {
        if (sizeof($data) > 0) {
            $res = '';
            foreach ($data as $val) {
                if ($val[$value] == $check) {
                    $res .= '<option value="' . $val[$value] . '" selected> ' . $val[$print] . ' </option>';
                } else {
                    $res .= '<option value="' . $val[$value] . '"> ' . $val[$print] . ' </option>';
                }
            }
            return $res;
        }
    }

    /*
     * 
     * Select User all Information by userID
     * @param $userID
     * 
     */

    public function select_user_profile_by_id( $getUserID ) {
        $query = "SELECT * FROM s_user_info as unfo
                    LEFT JOIN s_user_details_info as udetail ON unfo.USER_ID = udetail.USER_ID
                    LEFT JOIN mt_s_user_type as utype ON unfo.USER_TYPE_ID = utype.USER_TYPE_ID
                    LEFT JOIN mt_s_user_role as urole ON unfo.ROLE_ID = urole.ROLE_ID
                    WHERE unfo.USER_ID = " . $getUserID . "
                ";

        $query = $this->db->query($query);
        $result = $query->row();
        return $result;
    }
	
    public function select_user_profile_by_login( $getUserID ) {
        $query = "SELECT * FROM s_user_info as unfo
                    LEFT JOIN s_user_details_info as udetail ON unfo.USER_ID = udetail.USER_ID
                    WHERE unfo.USER_LOG_NAME = '" . $getUserID . "'
                ";

        $query = $this->db->query($query);
        $result = $query->row();
        return $result;
    }
    
    /*
     * 
     * Update User Information by userID
     * @param $userID , $array
     * 
     */
    public function update_user_by_id( $getTable, $getData ){
        $this->db->where( 'USER_ID', $this->userID );
        $this->db->update( $getTable, $getData );
    }
    
    
    /*
     * Select All Property By User ID
     */
    public function select_all_property_by_user(){
        $query = "SELECT * FROM p_property_basic
                    LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                    WHERE p_property_basic.USER_ID = $this->userID AND p_property_basic.PROPERTY_STATUS != 'Delete' AND p_property_images.DEFAULT_IMAGE = 1
                ";
        $result = $this->db->query( $query );
        return $result->result();
    }
    /*-----------------------------
     * select_user_mail().
     * @param $userID
     * Developed On 26-02-2018
     ---------------------------*/
  public function select_user_mail( $userId = '0' )
  {
      if( $userId > 0 ){
          $this->userID = $userId;   
      }
      $query = $this->db->query("SELECT * FROM c_contact_info WHERE CONTACT_TYPE_ID = 9 AND USER_ID = '$this->userID'");
      $count = $query->num_rows();
      if($count > 0){
          $mailID = $query->result();
		  if(sizeof($mailID) > 0){
			return $mailID[0]->CONTACT_NAME;
		  }else{
			 return '';
		 }
      }else{
         $query = "SELECT * FROM s_user_info WHERE USER_ID = '$this->userID'";
         $result = $this->db->query($query);
         $mailID = $result->result(); 
         if(sizeof($mailID) > 0){
			return $mailID[0]->EMAIL_ADDRESS;
		 }else{
			 return '';
		 }
      }    
      
  }
  
  public function select_user_mailBY_id( $email = '0' )
  {
     
      $query = $this->db->query("SELECT * FROM c_contact_info WHERE CONTACT_TYPE_ID = 9 AND CONTACT_NAME = '$email'");
      $count = $query->num_rows();
      if($count > 0){
          $mailID = $query->result();
		  if(sizeof($mailID) > 0){
			return $mailID[0]->USER_ID;
		  }else{
			 return '0';
		 }
      }else{
         $query = "SELECT * FROM s_user_info WHERE EMAIL_ADDRESS = '$email'";
         $result = $this->db->query($query);
         $mailID = $result->result(); 
         if(sizeof($mailID) > 0){
			return $mailID[0]->USER_ID;
		 }else{
			 return '0';
		 }
      }    
      
  }
  
  
   
    public function user_mailing_address($userID){
        $address_ff = '';
        $queryCon = $this->db->query("SELECT * FROM mt_c_contact_type WHERE CONTAC_TYPE_TYPE = 'contact_address' AND CONTACT_TYPE_STATUS = 'Active' ORDER BY CONTACT_TYPE_ID ASC");
        foreach($queryCon->result() AS $type){
            if( $type->CONTACT_NAME != 'Country' ){
               $query = "SELECT * FROM c_contact_info WHERE USER_ID = '$userID' AND CONTACT_TYPE_ID = $type->CONTACT_TYPE_ID AND CONTACT_STATUS = 'Active' ";
               $result = $this->db->query( $query );

               foreach ($result->result() as $address ){
                   $address_ff .= $address->CONTACT_NAME.', '; 
               }

            }   
        }
       $address_ff = rtrim($address_ff, ', ').'.';
       return $address_ff;
    }
  
  
    public function footer_user_info($userID) {
        $user_info = $this->user->select_user_profile_by_id($userID);
        $user_email = $this->user->select_user_mail($userID);

        $footer = '<div class="pull-right print-marginT-10" style="font-style:normal;color:#333;">
						<small style="float:right;">Thanking You,<br/> <br/>
						' . str_repeat('. ', (strlen($user_email) + 10)) . ' <br/>
						' . $user_info->USER_NAME . ' <br/>
						' . $user_email . ' <br/>
						</small>
					</div>
					';

        return $footer;
    }

}

?>