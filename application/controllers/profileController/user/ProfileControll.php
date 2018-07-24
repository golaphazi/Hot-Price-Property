<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileControll extends HPP_Controller {
    
    public $userID , $logged_in , $userName;
    public function __construct() {
        parent::__construct();
        $this->userID     = $this->session->userData('userID');
        $this->logged_in  = $this->session->userData('logged_in');
        $this->userName   = $this->session->userData('userName');
    }

    public function profileIndex($id = '') {
        $data = array();

        $data['title'] = 'Welcome ' . $this->userName . ' | HPP';
        if ($this->userID > 0 && $this->logged_in == TRUE ) {

            $data['userName']   = $this->userName;
            $data['userID']     = $this->userID;

            $data['contact']            = $this->any_where(array('CONTAC_TYPE_TYPE' => 'basic', 'CONTACT_TYPE_STATUS' => 'Active'), 'mt_c_contact_type');
            $data['contact_address']    = $this->any_where(array('CONTAC_TYPE_TYPE' => 'contact_address', 'CONTACT_TYPE_STATUS' => 'Active'), 'mt_c_contact_type');
            $data['social']             = $this->any_where(array('CONTAC_TYPE_TYPE' => 'Social', 'CONTACT_TYPE_STATUS' => 'Active'), 'mt_c_contact_type');
            $data['COUNTRYES']          = $this->Property_Model->select_country('', '');
            //print_r($data['contact']);
            
            /*
             * Upadte User Personal Information  
             */
            
              if( isset( $_POST['personalSubmit'] ) ){ 
                /*
                 * For BASIC INFO
                 */
				$userName = $this->input->post( 'user_name' );	
                if(strlen($userName) > 0){
					$name  = array( 'USER_NAME' => $this->input->post( 'user_name' ) );
					$this->user->update_user_by_id( 's_user_info', $name );
                }
                $sdata = array();
                $profile_img  = $_FILES['profile_picture']['name'];
                if( strlen( $profile_img ) > 4 ) {
                    
                    $upload_path = 'images/profile/' . $this->conpanyID . '/' . $this->userID . '/' . date("Y") . '/' . date("m") . '/';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }
                    /*------Start Image Upload------*/
                    $config['upload_path']      = $upload_path;
                    $config['allowed_types']    = 'jpg|png';
                    $config['max_size']         = '0';
                    $config['max_width']        = '0';
                    $config['max_height']       = '0';
                    $error = '';
                    $fdata = array();
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('profile_picture')) {
                        $error = $this->upload->display_errors();
                        echo $error;
                        exit();
                    } else {
                        $fdata = $this->upload->data();
                        $sdata['PROFILE_IMAGE'] = $config['upload_path'] . $fdata['file_name'];
                    }
                    /*------End Start Image Upload------*/
                }
                
                $sdata['GENTER'] = $this->input->post( 'gender' );
                $sdata['OVERVIEW'] = $this->input->post( 'objective' );
//                print_r($sdata); exit();
                
                $this->user->update_user_by_id( 's_user_details_info', $sdata );
                
                $session_data = array();
                $session_data['message'] = "Information updated successfully..!";
                $this->session->set_userdata($session_data);
                redirect('profile', 'refresh' );
                
              }
			  
			     /*
                 * For Liancse INFO
                 */ 
			  
			   if( isset( $_POST['licnseSubmit'] ) ){ 
             
                
                $sdata = array();
                $profile_img  = $_FILES['profile_picture']['name'];
                if( strlen( $profile_img ) > 4 ) {
                    
                    $upload_path = 'images/document/' . $this->conpanyID . '/' . $this->userID . '/' . date("Y") . '/' . date("m") . '/';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }
                    /*------Start Image Upload------*/
                    $config['upload_path']      = $upload_path;
                    $config['allowed_types']    = 'jpg|png|pdf';
                    $config['max_size']         = '0';
                    $config['max_width']        = '0';
                    $config['max_height']       = '0';
                    $error = '';
                    $fdata = array();
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('profile_picture')) {
                        $error = $this->upload->display_errors();
                        echo $error;
                        exit();
                    } else {
                        $fdata = $this->upload->data();
                        $sdata['DOCUMENT_UPLOAD'] = $config['upload_path'] . $fdata['file_name'];
                    }
                    /*------End Start Image Upload------*/
					 $this->user->update_user_by_id( 's_user_details_info', $sdata );
                }
                
               
                
                $session_data = array();
                $session_data['message'] = "Uploaded successfully..!";
                $this->session->set_userdata($session_data);
                redirect('profile', 'refresh' );
                
              }
			  
              /*
               * FOR CONTACT INFO
               */
                if (isset($_POST['contactSubmit'])) {
                    if (is_array( $data['contact'] ) AND sizeof($data['contact']) > 0):
                        foreach ($data['contact'] AS $conType):
                            $contactID  = $conType['CONTACT_TYPE_ID'];
                             $getData   = array( 'CONTACT_NAME' => $this->input->post( 'user_contact_name__'.$contactID ) );
                             $checkType = $this->any_where_count( array( 'USER_ID' => $this->userID, 'CONTACT_TYPE_ID' => $contactID ), 'c_contact_info', 'CONTACT_TYPE_ID' );
                             if( $checkType > 0 ){
                               $this->db->update( 'c_contact_info', $getData , array('USER_ID' => $this->userID, 'CONTACT_TYPE_ID' => $contactID ) );  
                             }else{
                                  $inset = array();
                                  $inset['CONTACT_NAME']    = $this->input->post( 'user_contact_name__'.$contactID );
                                  $inset['CONTACT_TYPE_ID'] = $contactID;
                                  $inset['USER_ID']         = $this->userID;
                                  $inset['COMPANY_ID']      = $this->conpanyID;
                                  $inset['ENT_DATE']        = date("Y-m-d");
                                  $inset['CONTACT_STATUS']  = 'Active';
                                 $this->db->insert( 'c_contact_info',  $inset); 
                             }
                             
                        endforeach;
                    endif;
                    $session_data = array();
                    $session_data['message'] = "Contact information updated Successfully..!";
                    $this->session->set_userdata($session_data);
                    redirect('profile?#contact_info', 'refresh');
                }
                
                 /*
               * FOR Mailing CONTACT INFO
               */
                if (isset($_POST['contactMailSubmit'])) {
                    if (is_array( $data['contact_address'] ) AND sizeof($data['contact_address']) > 0):
                        foreach ($data['contact_address'] AS $conType):
                             $contactID  = $conType['CONTACT_TYPE_ID'];
                             $getData   = array( 'CONTACT_NAME' => $this->input->post( 'user_contact_name__'.$contactID ) );
                             $checkType = $this->any_where_count( array( 'USER_ID' => $this->userID, 'CONTACT_TYPE_ID' => $contactID ), 'c_contact_info', 'CONTACT_TYPE_ID' );
                             if( $checkType > 0 ){
                               $this->db->update( 'c_contact_info', $getData , array('USER_ID' => $this->userID, 'CONTACT_TYPE_ID' => $contactID ) );  
                             }else{
                                  $inset = array();
                                  $inset['CONTACT_NAME']    = $this->input->post( 'user_contact_name__'.$contactID );
                                  $inset['CONTACT_TYPE_ID'] = $contactID;
                                  $inset['USER_ID']         = $this->userID;
                                  $inset['COMPANY_ID']      = $this->conpanyID;
                                  $inset['ENT_DATE']        = date("Y-m-d");
                                  $inset['CONTACT_STATUS']  = 'Active';
                                 $this->db->insert( 'c_contact_info',  $inset); 
                             }
                             
                        endforeach;
                    endif;
                    $session_data = array();
                    $session_data['message'] = "Contact Mailing information updated Successfully..!";
                    $this->session->set_userdata($session_data);
                    redirect('profile?#mail_address', 'refresh');
                }
                
              /*
               * FOR SOCIAL INFO
               */
                if (isset($_POST['socialSubmit'])) {
                    if (is_array( $data['social'] ) AND sizeof($data['social']) > 0):
                        foreach ($data['social'] AS $conType):
                            $socialTypeId   = $conType['CONTACT_TYPE_ID'];
                             $getData       = array( 'CONTACT_NAME' => $this->input->post( 'social_profile__'.$socialTypeId ) );
                             $checkType     = $this->any_where_count( array( 'USER_ID' => $this->userID, 'CONTACT_TYPE_ID' => $socialTypeId ), 'c_contact_info', 'CONTACT_TYPE_ID' );
                             if( $checkType > 0 ){
                               $this->db->update( 'c_contact_info', $getData , array('USER_ID' => $this->userID, 'CONTACT_TYPE_ID' => $socialTypeId ) );  
                             }else{
                                  $inset = array();
                                  $inset['CONTACT_NAME']    = $this->input->post( 'social_profile__'.$socialTypeId );
                                  $inset['CONTACT_TYPE_ID'] = $socialTypeId;
                                  $inset['USER_ID']         = $this->userID;
                                  $inset['COMPANY_ID']      = $this->conpanyID;
                                  $inset['ENT_DATE']        = date("Y-m-d");
                                  $inset['CONTACT_STATUS']  = 'Active';
                                 $this->db->insert( 'c_contact_info',  $inset ); 
                             }
                             
                        endforeach;
                    endif;
                    $session_data = array();
                    $session_data['message'] = "Social profile information updated successfully..!";
                    $this->session->set_userdata($session_data);
                    redirect('profile?#social_info', 'refresh');
                }
                
                /*
                 * For Update User Password
                 */
                if( isset( $_POST['passwordSubmit'] ) ){
                    $oldPassword        = md5( $this->input->post( 'old_password' ) );
                    $newPassword        = $this->input->post( 'new_password' );
                    $confirmPassword    = $this->input->post( 'confirm_password' );
                    $query = $this->db->query( "SELECT * FROM s_user_info WHERE PASS_USER = '" . $oldPassword . "' AND USER_ID = $this->userID" );
                    if( $query->num_rows() == 1 ){
                        if( $newPassword == $confirmPassword ){
                             $password = array( 'PASS_USER' => md5( $confirmPassword ) );
                             $this->db->update( 's_user_info', $password , array( 'USER_ID' => $this->userID ) );
                             $session_data  = array();
                             $session_data['message']   = "Password updated successfully...!";
                             $this->session->set_userdata( $session_data );
                        }else{
                            $session_data = array();
                            $session_data['message'] = "Sorry password dose not match ...!";
                            $this->session->set_userdata( $session_data );
                        }
                    }else{
                        $session_data = array();
                        $session_data['message'] = "Sorry invalid old password...!";
                        $this->session->set_userdata($session_data);
                    }
                    
                    redirect( 'profile?#password_info' );
                }
            /*
             * End Upadte Personal Information  
             */
			 
			 /*
                 * For Update User Password
                 */
                if( isset( $_POST['bank_info_Submit'] ) ){
                    $bank = array();
					$bank['BANK_NAME']          = trim($this->input->post( 'bank_name' ));
					$bank['BANK_NUMBER']        = trim($this->input->post( 'account_no' ));
					$bank['BANK_DETAILS']        = trim($this->input->post( 'account_details' ));
                     
					 if( strlen($bank['BANK_NAME']) > 1 AND  strlen($bank['BANK_NUMBER']) > 1){
                         $this->db->update( 's_user_details_info', $bank , array( 'USER_ID' => $this->userID ) );
						 $session_data  = array();
						 $session_data['message']   = "Bank information updated successfully...!";
						 $this->session->set_userdata( $session_data );
				
                    }else{
                        $session_data = array();
                        $session_data['message'] = "Sorry!!! Enter your bank information...";
                        $this->session->set_userdata($session_data);
                    }
                    
                    redirect( 'profile?#bank_info' );
                }
            /*
             * End Upadte Personal Information  
             */
            
            $data['user_profile'] = $this->user->select_user_profile_by_id( $this->userID );
            $data['select_page'] = 'profile';
            $data['user_menu'] = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
            $data['main_content'] = $this->load->view('page_templates/dashboard/users/profile/profile_info', $data, true);
        } else {
            redirect(SITE_URL . 'login?page=profile');
        }

        $this->load->view('master', $data);
    }
    
	
	
	public function addSubUser(){
		 $data = array();
        if ($this->userID > 0 && $this->logged_in == TRUE) {
			if ($this->hpp_url_check('add_user', 'page') > 0) { 
				$data['title']          = 'Add Sub User | HPP';
				
				$data['select_page'] = 'add_user';
				$data['user_menu'] = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
				
				$data['main_content'] = $this->load->view('page_templates/dashboard/users/profile/add_sub_user', $data, true);
				
			} else {
                $data['title'] = 'Don\'t have permission | HPP';
				$data['main_content'] = $this->load->view( 'errors/errors_page', $data, true );
            }
		} else {
            $data['main_content']   = $this->load->view('page_templates/userLogin/users/login', $data, true);
        }
        $this->load->view('master', $data);
	}
    
    /*
     * managePropery()
     * To view user properies for manage information
     */
    public function dashboard() {
        $data = array();
        if ($this->userID > 0 && $this->logged_in == TRUE) {

            $data['userName']   = $this->userName;
            $data['userID']     = $this->userID;

            $data['title']          = 'Welcome Dashboard | HPP';
            $data['select_page']    = 'dashboard';
            $data['user_menu']      = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
            $data['main_content']   = $this->load->view('page_templates/dashboard/users/pages/dashboard', $data, true);
        } else {
            $data['main_content']   = $this->load->view('page_templates/userLogin/users/login', $data, true);
        }
        $this->load->view('master', $data);
    }

    /*
     * managePropery()
     * To view user properies for manage information
     */
    public function manageProperty(){
       $data = array();
       $session_data = array();
       if ($this->userID > 0 && $this->logged_in == TRUE) {
           if ($this->hpp_url_check('manage-property', 'page') > 0) { 
             $propertyID = $this->input->get( 'edit' );
             $data['propertyID'] = $propertyID;
             $data['userName']   = $this->userName;
             $data['userID']     = $this->userID;

             $data['title']                      = ( ($propertyID > 0) ? 'Edit Property' : 'Manage Property' ) . ' | HPP';
             $data['select_page']                = 'manage-property';
             $data['user_menu']                  = $this->load->view( 'page_templates/dashboard/users/user_menu', $data, true );
             
            $search = isset($_GET['search']) ? $_GET['search'] : 'all';
            $data['select_property_by_user']    = $this->Property_Model->select_all_property_by_user($search);
             
             /*-- Start Add property to hot price section --*/
                if( isset( $_POST['addHotPriceProperty'] )){
                    $pid                            = $this->input->get( 'hot' );
                    $insert = array();
                    $insert['OFFER_PRICE']          = str_replace(',', '', $this->input->post( 'offer_price' ));
                    $insert['OFFER_TYPE']           = 'Hot';
                    $insert['OFFER_START_DATE']     = $this->input->post( 'hot_price_start_date' );
                    
                    $date_limit                     = $this->input->post( 'hot_price_end_date' );
                    $dateType                       = $this->input->post( 'dateType' );
                    
                   $insert['OFFER_END_DATE']       =  $this->modify_date_time($insert['OFFER_START_DATE'], $date_limit, $dateType);
                   
                    //$insert['OFFER_END_DATE']       = $this->input->post( 'hot_price_end_date' );
                    $insert['PROPERTY_ID']          = $pid;
                    $insert['COMPANY_ID']           = $this->conpanyID;
                    $insert['USER_ID']              = $this->userID;
                    $insert['ENT_DATE']             = date('Y-m-d');
                    $insert['OFFER_STATUS']         = 'Pending';
                   
                   $check_hot  =  $this->any_where_count( array( 'PROPERTY_ID' => $pid, 'OFFER_TYPE' => 'Hot' ), 'p_property_offers', 'PROPERTY_ID' );
                   
                    if( $this->db->update( 'p_property_basic', array( 'HOT_PRICE_PROPERTY' => 'Yes' ), array( 'PROPERTY_ID' => $pid,'USER_ID' => $this->userID ) ) ){
                        if( $check_hot > 0){
                            if( $this->db->update( 'p_property_offers' , $insert, array( 'PROPERTY_ID' => $pid,'USER_ID' => $this->userID ) ) ){
                                $session_data['message'] = "Property succesfully added into hot price section..!";
                                $this->session->set_userdata($session_data);
                                 redirect( SITE_URL . 'manage-property?search=hot', 'refresh' );
                            }else {
                                $this->db->update( 'p_property_basic', array( 'HOT_PRICE_PROPERTY' => 'No' ), array( 'PROPERTY_ID' => $pid,'USER_ID' => $this->userID ) ); 
                                $session_data['message'] = "Property does not added into hot price section..!";
                                $this->session->set_userdata($session_data);
                            }   
                        }else{
                            if( $this->db->insert( 'p_property_offers' , $insert ) ){
                                $session_data['message'] = "Property succesfully added into hot price section..!";
                                $this->session->set_userdata($session_data);
                                redirect( SITE_URL . 'manage-property?search=hot', 'refresh' );
                            }else {
                                $this->db->update( 'p_property_basic', array( 'HOT_PRICE_PROPERTY' => 'No' ), array( 'PROPERTY_ID' => $pid,'USER_ID' => $this->userID ) ); 
                                $session_data['message'] = "Property does not added into hot price section..!";
                                $this->session->set_userdata($session_data);
                            }   
                        }
                    } else {
                          $session_data['message'] = "Property does not added into hot price section..!";
                          $this->session->set_userdata($session_data);
                    }
                   
                }
              /*-- Add to hot price end --*/
              
              /*-- Start Add property to Auction section --*/  
                if( isset( $_POST['addAuctionProperty'] ) ){
                    $bidPropertyID = $this->input->get( 'bid' );
                    $bidStartDate = $this->input->post( 'offer_start_date' ); 
                    $bidTime = $this->input->post( 'offer_end_date' );
                    $dateType = $this->input->post( 'dateType' );
                    $bidding = array(
                        'OFFER_PRICE'           => str_replace( ',', '', $this->input->post( 'offer_start_price' )),
                        'BIDDING_WIN_PRICE'     => str_replace( ',', '', $this->input->post( 'offer_win_price' )),
                        'OFFER_TYPE'            => 'Bid',
                        'OFFER_START_DATE'      => $bidStartDate,
                        'OFFER_END_DATE'        => $this->modify_date_time( $bidStartDate, $bidTime, $dateType ),
                        'PROPERTY_ID'           => $bidPropertyID,
                        'COMPANY_ID'            => $this->conpanyID,
                        'USER_ID'               => $this->userID,
                        'ENT_DATE'              => date('Y-m-d'),
                        'OFFER_STATUS'          => 'Pending',
                    );
                    
                    $checkBid = $this->any_where_count( array( 'PROPERTY_ID' => $bidPropertyID, 'OFFER_TYPE' => 'Bid' ), 'p_property_offers', 'PROPERTY_ID' );
                    if( $this->db->update( 'p_property_basic', array( 'PROPERTY_AUCTION' => 'Yes' ), array( 'PROPERTY_ID' => $bidPropertyID, 'USER_ID' => $this->userID ) ) ){
                        
                        if( $checkBid > 0 ){
                            
                            if( $this->db->update( 'p_property_offers', $bidding, array( 'PROPERTY_ID' => $bidPropertyID, 'USER_ID' => $this->userID ) ) ){
                                $session_data['message'] = "Your property has been successfully set up in Bidding/Auction..!";
                                $this->session->set_userdata( $session_data );
                            }else{
                                $this->db->update( 'p_property_basic', array( 'PROPERTY_AUCTION' => 'No' ), array( 'PROPERTY_ID' => $pid,'USER_ID' => $this->userID ) ); 
                                $session_data['message'] = "Your property is not set to Bidding/Auction..!";
                                $this->session->set_userdata( $session_data ); 
                            }
                            
                        }else{
                            
                            if( $this->db->insert( 'p_property_offers', $bidding ) ){
                                $session_data['message'] = "Your property has been successfully set up in Bidding/Auction..!";
                                $this->session->set_userdata( $session_data );
                                redirect( SITE_URL . 'payment-auction?bidPropertyID='.$bidPropertyID, 'refresh' );
                            }else{
                                $this->db->update( 'p_property_basic', array( 'PROPERTY_AUCTION' => 'No' ), array( 'PROPERTY_ID' => $pid,'USER_ID' => $this->userID ) ); 
                                $session_data['message'] = "Your property is not set to Bidding/Auction..!";
                                $this->session->set_userdata( $session_data ); 
                            }
                            
                        }
                        
                    }else{
                       $session_data['message'] = 'Your property is not set to Bidding/Auction..!';
                       $this->session->set_userdata( $session_data );
                    }
//                    redirect( SITE_URL . 'manage-property', 'refresh' );
                }
              /*-- End Add to Auction Property --*/   
            
            
            
             if( $propertyID > 0 ){
                 $select_property   = $this->Property_Model->select_property_by_id_and_user( $propertyID );
                 //print_r($select_property);
                 if( $select_property && sizeof( $select_property ) > 0 ){
                      $data['select_property'] = $select_property;
                 /*
                  * Start Update Product Basic Information..
                  */
                    if( isset( $_POST['updateBasic'] ) ){
                        $PBdata = array(
                            'PROPERTY_NAME'             => $this->input->post( 'property_name' ),
                            'PROPERTY_STREET_NO'        => $this->input->post( 'property_street_no' ),
                            'PROPERTY_STREET_ADDRESS'   => $this->input->post( 'property_street_address' ),
                            'PROPERTY_CITY'             => $this->input->post( 'property_city' ),
                            'PROPERTY_STATE'            => $this->input->post( 'property_state' ),
                            'PROPERTY_COUNTRY'          => $this->input->post( 'property_country' ),
                            'PROPERTY_WONERSHIP'        => $this->input->post( 'property_ownership' ),
                            'PROPERTY_PRICE'            => str_replace(',', '', $this->input->post( 'propertyprice' ) ),
                            'PROPERTY_DESCRIPTION'      => htmlspecialchars($this->input->post( 'property_description' )),
                        );
                        if( $this->db->update( 'p_property_basic', $PBdata, array( 'PROPERTY_ID' => $propertyID, 'USER_ID' => $this->userID ) ) ){
                           
                           $session_data['message'] = "Property basic information updated successfully...!";
                           $this->session->set_userdata($session_data); 
						   redirect('manage-property?edit='.$propertyID.'&#basicInfo', 'refresh');
                        }
                        
                    }
                 /*
                  * End Update Product Basic Information ..
                  */
                    
                    
                  /*----Start Image Update --*/
                    $data['select_images_by_property_id'] = $this->user->any_where( array( 'PROPERTY_ID' => $propertyID, 'USER_ID' => $this->userID ), 'p_property_images' );
                    if( isset( $_POST['updateImages'] ) ){
                        echo 'Ongoing Update Images...';
                    }
                 /*----End Image Update --*/
                    
                    
                /*----Start Update Aditional Information  --*/
                    $data['select_additional_info'] = $this->Property_Model->select_additional_info_by_property( $propertyID );
                    if( isset( $_POST['updateAdditionalInfo'] ) ){
                        if ( sizeof( $data['select_additional_info'])  > 0 ){
                            foreach ( $data['select_additional_info'] as $additionalField ){
                                $AddFieldPid = $additionalField->ADD_FILED_P_ID;
                                $addition = array();
                                $addition['FILED_DATA'] 	= $this->input->post($additionalField->FILED_ID_NAME);
                                if($additionalField->FILED_TYPE == 'text_select'){
                                    $addition['FILED_OTHERS'] 	= $this->input->post($additionalField->FILED_ID_NAME.'__select');
                                }
                               
                                if( $this->db->update( 'p_property_additional', $addition, array( 'ADD_FILED_P_ID' => $AddFieldPid, 'PROPERTY_ID' => $propertyID ) ) ){
                                    $session_data['message'] = "Property additional information updated successfully...!";
                                    $this->session->set_userdata( $session_data );
                                    
                                }else{
                                    $session_data['message'] = "Dose not updated property additional information...!";
                                    $this->session->set_userdata( $session_data );
                                }
                            }
                            redirect('manage-property?edit='.$propertyID.'&#additionalInfo', 'refresh');
                        }
                    }
                /*----End Update Aditional Information --*/
                
                /*----Start Update Others Information  --*/
                    $data['select_info'] = $this->Property_Model->select_others_info_by_property( $propertyID );
                    if( isset( $_POST['updateOthersInfo'] ) ){
                        $value = $this->input->post('value');
                            if (sizeof($value) > 0) {
                                $val = 0;
                                foreach ($value as $headData) {
                                    $fieldPID = $data['select_info'][$val]->ADD_FILED_P_ID;
                                    if (strlen($headData) > 1) {
                                        $addition_more = array();
                                        $addition_more['FILED_DATA'] 	= $headData;
                                        if($this->db->update('p_property_additional', $addition_more, array( 'PROPERTY_ID' => $propertyID, 'ADD_FILED_P_ID' => $fieldPID ) )){
                                            $session_data['message'] = "Property others information updated successfully...!";
                                            $this->session->set_userdata( $session_data ); 
                                            
                                        }else{
                                            $session_data['message'] = "Dose not updated property others information...!";
                                            $this->session->set_userdata( $session_data );
                                        }
                                    }
                                    $val++;
                                }
                                redirect('manage-property?edit='.$propertyID.'&#otherInfo', 'refresh');
                            }
                    }
                /*----End Update Others Information --*/   
                    
                /*----Start Update near By Information  --*/
                    $data['select_nearby_info'] = $this->Property_Model->select_nearby_info_by_property( $propertyID );
                    $data['location_near']      = $this->any_where(array('STATUS_LOCATION' => 'Active'), 'mt_p_nearby_location');
                    if( isset( $_POST['updateNearByInfo'] ) ){
                        
                        foreach ( $data['select_nearby_info'] as $nearbyinfo ){
                            $nearby = array();
                            $nearby['NEAR_ORG_NAME']     = $this->input->post( 'org_name_'.$nearbyinfo->NEAR_BY_ID );
                            $nearby['NEAR_ORG_DISTANCE'] = $this->input->post( 'distance_'.$nearbyinfo->NEAR_BY_ID );
                            $nearby['LOCATION_ID']       = $this->input->post( 'location_'.$nearbyinfo->NEAR_BY_ID );
                            if( $this->db->update( 'p_property_nearby', $nearby, array( 'PROPERTY_ID' => $propertyID, 'NEAR_BY_ID' => $nearbyinfo->NEAR_BY_ID ) ) ){
                               $session_data['message'] = "Property nearBy information updated successfully...!";
                               $this->session->set_userdata( $session_data ); 
                            }else{
                               $session_data['message'] = "Dose not updated property nearBy information...!";
                               $this->session->set_userdata( $session_data ); 
                            }
                        }
                        redirect( 'manage-property?edit='.$propertyID.'&#nearby','refresh');
                    }
                /*----End Update near By Information --*/  
                    
                /*----Start Update near By Information  --*/
                    $data['select_video_info']  = $this->Property_Model->select_video_info_by_property( $propertyID );
                    $data['select_video_type']  = $this->any_where(array('TYPE_STATUS' => 'Active'), 'mt_p_video_type');;
                    if( isset( $_POST['updateVideoInfo'] ) ){
                        
                        $vedio = array();
                        $vedio['VIDEOS_LINK']       = $this->input->post( 'property_video' );
                        $vedio['VIDEO_TYPE_ID']     = $this->input->post( 'video_type' );

                        if( $this->db->update( 'p_property_videos', $vedio, array( 'PROPERTY_ID' => $propertyID ) ) ){
                           $session_data['message'] = "Property video information updated successfully...!";
                           $this->session->set_userdata( $session_data ); 
                        }else{
                           $session_data['message'] = "Dose not updated property video information...!";
                           $this->session->set_userdata( $session_data ); 
                        }
                        redirect( 'manage-property?edit='.$propertyID.'&#vedioInfo','refresh');
                    }
                /*----End Update near By Information --*/ 
                   
                    
                    $data['property_type']     = $this->user->any_where( array( 'PROPERTY_TYPE_STATUS' => 'Active' ), 'mt_p_property_type' );
                    $data['property_owner']    = $this->user->any_where( array( 'OWNER_STATUS' => 'Active' ), 'mt_p_property_owner' );
                    $data['countries']         = $this->Property_Model->select_all_countries();
                    $data['main_content']      = $this->load->view( 'page_templates/dashboard/users/property/edit_property', $data, true );
                } else {
                    $data['main_content']       = $this->load->view( 'page_templates/dashboard/users/property/manage_property', $data, true );
                }
             } else{
                $data['main_content']       = $this->load->view( 'page_templates/dashboard/users/property/manage_property', $data, true ); 
             }
             
           } else {
                $data['title'] = 'Don\'t have permission | HPP';
				$data['main_content'] = $this->load->view( 'errors/errors_page', $data, true );
            }
        } else {
           redirect( SITE_URL . 'login?page=manage-property' );
        }
        $this->load->view( 'master', $data );
    }
    
	/*Profile information*/
	public function massage_board(){
       $data = array();
       $session_data = array();
	   $data['title']                      = 'Massage Board | HPP';
	   $data['select_page']    				= 'massage-board';
       
       if ($this->userID > 0 && $this->logged_in == TRUE) {
           if ($this->hpp_url_check('massage-board', 'page') > 0) {
			   $data['user_menu']      = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
			   $search = isset($_GET['search']) ? $_GET['search'] : 'all';
			   $search_array = array();
			   
			   if($search == 'inbox'){
				   $search_array['TO_USER'] = $this->userID;
			   }else if($search == 'sent'){
				   $search_array['FROM_USER'] = $this->userID;
			   }else if($search == 'email'){
				   $search_array['TO_USER'] = $this->userID;
				   $search_array['SMS_TYPE'] = 'Email';
			   }else if($search == 'Property'){
				   $search_array['TO_USER'] = $this->userID;
				   $search_array['PROPERTY_ID !='] = '';
				   $search_array['SMS_TYPE'] = 'Property';
			   }
			   $search_array['SMS_STATUS'] = 'Send';
			   
			   $data['massage_list'] = $this->any_where($search_array, 'sms_contact_agent_user');
			   
			   
			   $data['main_content']       = $this->load->view( 'page_templates/dashboard/users/massage/massage_board', $data, true ); 
			} else {
                $data['title'] = 'Don\'t have permission | HPP';
				$data['main_content'] = $this->load->view( 'errors/errors_page', $data, true );
            }
        } else {
           redirect( SITE_URL . 'login?page=massage-board' );
        }
       $this->load->view( 'master', $data );   
			   
	}
    
	
	public function email_inbox() {
		$data = array();
		$session_data = array();
		$data['title'] = 'Email inbox | HPP';
		$data['select_page'] = 'email-inbox';
		$data['composeMSG'] = ''; 
		$data['composeEmail'] = ''; 
		$hpp_user = $this->user->admin_login_id();
                
		if ($this->userID > 0 && $this->logged_in == TRUE) {
			if ($this->hpp_url_check('email-inbox', 'page') > 0) {
				$data['user_menu'] = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
				$search = isset($_GET['search']) ? $_GET['search'] : 'inbox';
				$search_array = array();
				
				$GetEmailView = isset( $_GET['view-email'] ) ? $_GET['view-email'] : 'see';
				$Getscau = isset( $_GET['scau'] ) ? $_GET['scau'] : 0;
				$Getscaud = isset( $_GET['scaud'] ) ? $_GET['scaud'] : 0;
				$apply = isset( $_GET['apply'] ) ? $_GET['apply'] : '';
				
				
				/*Code for view email / replay / forward*/
				if( $GetEmailView == 'view' && $Getscau > 0){ 
					$dataEdit = array( 'SEEN_TYPE' => 'view' );
					$this->db->update( 'sms_contact_agent_user', $dataEdit , array('CONTACT_AGENT_ID' => $Getscau, 'TO_USER' => $this->userID, 'TO_TYPE' => 'User' ));
					
					if(isset($_POST['contact_replay_message'])){
						$replay = trim($this->input->post('message_replay'));
						if(strlen($replay) > 2){
							$massageDetailsShow =  $this->any_where(array('CONTACT_AGENT_ID' => $Getscau), 'sms_contact_agent_user');
							if(sizeof($massageDetailsShow) > 0){
								if($massageDetailsShow[0]['FROM_USER'] == $this->userID AND $massageDetailsShow[0]['FROM_TYPE'] == 'User'){
									$to_user = $massageDetailsShow[0]['TO_USER'];
									$to_type = $massageDetailsShow[0]['TO_TYPE'];
								}else{
									$to_user = $massageDetailsShow[0]['FROM_USER'];
                                                                        $to_type = $massageDetailsShow[0]['FROM_TYPE'];
								}
								$send = 1;
								$composeEmail = $this->user->select_user_mail($to_user);
								if($apply == 'forward' AND strlen($composeEmail) > 2){
									$composeEmail = trim($this->input->post('compose_email'));
									$data['composeEmail'] = $composeEmail; 
									$to_user = $this->user->select_user_mailBY_id($composeEmail);
									if($to_user > 0 AND $to_user != $this->userID){
										$emailInfo = array(
											'FROM_USER'         => $this->userID,
											'TO_USER'           => $to_user,
                                                                                        'TO_TYPE'           => $to_type,
											'PROPERTY_ID'       => 0,
											'CONTACT_SUBJECT'   => $massageDetailsShow[0]['CONTACT_SUBJECT'],
											'COMPANY_ID'        => $this->conpanyID,
											'ENT_DATE'          => date('Y-m-d'),
											'ENT_DATE_TIME'     => date('Y-m-d H:i:s'),
											'SMS_TYPE'          => 'Email',
										);
										$this->db->insert( 'sms_contact_agent_user', $emailInfo );
										$Getscau = $this->db->insert_id();
										$search = 'sent';
									}else{
										$send = 0;
										$data['composeMSG'] = '<div class="alert alert-info">Sorry! wrong contact email..</div>';
									}
								}else{
                                                                    if($apply == 'forward'){
                                                                            $send = 0;
                                                                            $data['composeMSG'] = '<div class="alert alert-danger">Please enter to user email</div>';
                                                                    }
									
								}
								if($send == 1){
									$emailDetails = array(
										'CONTACT_AGENT_ID'  => $Getscau,
										'COMPANY_ID'        => $this->conpanyID,
										'FROM_USER'         => $this->userID,
										'TO_USER'           => $to_user,
                                                                                'TO_TYPE_D'           => $to_type,
										'MESSAGE_TITLE'     => substr(strip_tags($replay), 0, 30),
										'MESSAGE_DATA'      => htmlspecialchars($replay),
										'ENT_DATE'	 		=> date('Y-m-d'),
										'ENT_DATE_TIME' 	=> date('Y-m-d h:i:s'),
										'SMS_DET_STATUS' 	=> 'Active'
									);
									if($this->db->insert( 'sms_contact_agent_user_details', $emailDetails )){
										$lastID = $this->db->insert_id();
										
										$this->MailerModel->sendEmail($composeEmail, substr(strip_tags($replay), 0, 30), $replay);
											
										$dataEditReplay = array( 'SEEN_TYPE' => 'show', 'ENT_DATE_TIME' => date("Y-m-d h:i:s"), 'SEEN_TYPE_HPP' => 'show' );
										$this->db->update( 'sms_contact_agent_user', $dataEditReplay , array('CONTACT_AGENT_ID' => $Getscau));
										
										redirect(SITE_URL . 'email-inbox?search='.$search.'&view-email=view&scau='.$Getscau.'&scaud='.$lastID);
									}
								}
							}
						}else{
							$data['composeMSG'] = '<div class="alert alert-danger">Please enter your message</div>';
						}
						
					}
					
				}
				
				/*Code for email search*/
				$this->hpp_order_column = 'ENT_DATE_TIME,ENT_DATE';
				$this->hpp_order 	= 'DESC';
				
				if ($search == 'inbox') {
					$search_array['TO_USER'] = $this->userID;
                                        $search_array['TO_TYPE'] = 'User';
				} else if ($search == 'sent') {
					$search_array['FROM_USER'] = $this->userID;
					$search_array['FROM_TYPE'] = 'User';
				} else if ($search == 'email') {
					$search_array['TO_USER'] = $this->userID;
                                        $search_array['TO_TYPE'] = 'User';
					$search_array['SMS_TYPE'] = 'Email';
				} else if ($search == 'property') {
					$search_array['TO_USER'] = $this->userID;
                                        $search_array['TO_TYPE'] = 'User';
					$search_array['PROPERTY_ID !='] = '0';
					$search_array['SMS_TYPE'] = 'Property';
				}else{
					$search_array['TO_USER'] = $this->userID;
                                        $search_array['TO_TYPE'] = 'User';
				}
				$search_array['SMS_TYPE'] = 'Email';
				$search_array['SMS_STATUS'] = 'Send';
				
				$queryAllCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS all_cunt FROM sms_contact_agent_user WHERE ((TO_USER = '$this->userID' AND TO_TYPE = 'User') OR (FROM_USER = '$this->userID' AND FROM_TYPE = 'User')) AND SMS_TYPE = 'Email' AND SMS_STATUS = 'Send' AND SEEN_TYPE = 'show'");
				$count_all= $queryAllCount->result();	
				$data['ALL_COUNT'] = $count_all[0]->all_cunt;
				
				$queryInboxCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS ALL_COUNT_INbox FROM sms_contact_agent_user WHERE TO_USER = '$this->userID' AND TO_TYPE = 'User' AND SMS_TYPE = 'Email' AND SMS_STATUS = 'Send' AND SEEN_TYPE = 'show'");
				$count_inbox= $queryInboxCount->result();	
				$data['ALL_COUNT_INbox'] = $count_inbox[0]->ALL_COUNT_INbox;
				
				$querySendCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS ALL_COUNT_SEND FROM sms_contact_agent_user WHERE FROM_USER = '$this->userID' AND FROM_TYPE = 'User' AND SMS_TYPE = 'Email' AND SMS_STATUS = 'Send' AND SEEN_TYPE = 'show'");
				$count_send= $querySendCount->result();	
				$data['ALL_COUNT_SEND'] = $count_send[0]->ALL_COUNT_SEND;
				//echo $data['ALL_COUNT_INbox'];
				
				if($search == 'all'){
					$queryAll = $this->db->query("SELECT * FROM sms_contact_agent_user WHERE ((TO_USER = '$this->userID' AND TO_TYPE = 'User') OR (FROM_USER = '$this->userID' AND FROM_TYPE = 'User')) AND SMS_STATUS = 'Send' AND SMS_TYPE = 'Email' ORDER BY ENT_DATE_TIME DESC");
					$data['massage_list'] = $queryAll->result_array();
					//echo '<pre>'; print_r($data['massage_list']);
				}else{
					$data['massage_list']   = $this->any_where($search_array, 'sms_contact_agent_user');
				}
				
				$composeAll = $this->db->query("SELECT distinct(FROM_USER), TO_USER FROM sms_contact_agent_user WHERE ((TO_USER = '$this->userID' AND TO_TYPE = 'User') OR (FROM_USER = '$this->userID' AND FROM_TYPE = 'User')) AND SMS_STATUS = 'Send' AND SMS_TYPE = 'Email' AND FROM_USER > 0 ORDER BY ENT_DATE_TIME DESC");
				$data['compose_email_list'] = $composeAll->result_array();
				
				/*Code for compose email*/
				
				if($search == 'compose'){
                                    $get_support = isset($_GET['get']) ? $_GET['get'] : '';
                                    $hpp_email = '';
                                    if($get_support == 'support'){
                                        $this->hpp_order_column = '';
                                        $this->hpp_order 	= ''; 
                                        $hpp_email = $this->any_where(array('ADMIN_ID' => $hpp_user), 'admin_access', 'ADMIN_EMAIL');
                                       
                                    }
                                    $data['composeEmail'] = $hpp_email; $data['composeSubject'] = '';
					if(isset($_POST['compose_form'])){
                                            if($get_support == 'support'){
                                                $composeEmail = trim($hpp_email);
                                                $to_type = 'Hpp';
                                            }else{
                                                $composeEmail = trim($this->input->post('compose_email'));
                                                $to_type = 'User';
                                            }
                                            
						$compose_subject = trim($this->input->post('compose_subject'));
							if(strlen($composeEmail) > 5){
								if(strlen($compose_subject) > 0){
									$replay = trim($this->input->post('compose_data'));
									if(strlen(strip_tags($replay)) > 2)	{
                                                                            if($get_support == 'support'){
                                                                                $to_user = $hpp_user;
                                                                            }else{
                                                                                $to_user = $this->user->select_user_mailBY_id($composeEmail); 
                                                                            }	

										if($to_user > 0  AND $to_user != $this->userID){
										$emailInfo = array(
												'FROM_USER'         => $this->userID,
												'TO_USER'           => $to_user,
												'TO_TYPE'           => $to_type,
												'PROPERTY_ID'       => 0,
												'CONTACT_SUBJECT'   => $compose_subject,
												'COMPANY_ID'        => $this->conpanyID,
												'ENT_DATE'          => date('Y-m-d'),
												'ENT_DATE_TIME'     => date('Y-m-d H:i:s'),
												'SMS_TYPE'          => 'Email',
											);
											if($this->db->insert( 'sms_contact_agent_user', $emailInfo )){
												$lastIDM = $this->db->insert_id();
												
												$this->MailerModel->sendEmail($composeEmail, $compose_subject, $replay);
												
												$emailDetails = array(
													'CONTACT_AGENT_ID'  => $lastIDM,
													'COMPANY_ID'        => $this->conpanyID,
													'FROM_USER'         => $this->userID,
													'TO_USER'           => $to_user,
													'TO_TYPE_D'           => $to_type,
													'MESSAGE_TITLE'     => substr(strip_tags($replay), 0, 30),
													'MESSAGE_DATA'      => htmlspecialchars($replay),
													'ENT_DATE'	 		=> date('Y-m-d'),
													'ENT_DATE_TIME' 	=> date('Y-m-d h:i:s'),
													'SMS_DET_STATUS' 	=> 'Active'
												);
												if($this->db->insert( 'sms_contact_agent_user_details', $emailDetails )){
													$lastID = $this->db->insert_id();
													
													redirect(SITE_URL . 'email-inbox?search=sent&view-email=view&scau='.$lastIDM.'&scaud='.$lastID);
												}
											}
										}else{
											$data['composeSubject'] = $compose_subject;
											$data['composeMSG'] = '<div class="alert alert-info"> Sorry! wrong contact email..</div>';
										}
									}else{
										$data['composeEmail'] = $composeEmail;
										$data['composeSubject'] = $compose_subject;
										$data['composeMSG'] = '<div class="alert alert-danger">Please enter your message</div>';
									}
								}else{
									$data['composeEmail'] = $composeEmail;
									$data['composeMSG'] = '<div class="alert alert-danger">Please enter subject</div>';
								}
							}else{
								$data['composeMSG'] = '<div class="alert alert-danger">Please enter to user email</div>';
							}
							
						}
				}
				/*Code for compose email end*/
				
				$this->hpp_order_column = 'CONTACT_AGENT_DETAILS_ID';
				$this->hpp_order 		= 'DESC';
				
				$data['main_content']   = $this->load->view('page_templates/dashboard/users/massage/massage_email_board', $data, true);
			} else {
				$data['title'] = 'Don\'t have permission | HPP';
				$data['main_content'] = $this->load->view('errors/errors_page', $data, true);
			}
		} else {
			redirect(SITE_URL . 'login?page=email-inbox');
		}
		$this->load->view('master', $data);
	}

	
	public function bidding_summery() {
		$data = array();
		$session_data = array();
		$data['title'] = 'Bidding Summery | HPP';
		$data['select_page'] = 'bidding-summery';
		$data['selectType'] = 'auction';

		if ($this->userID > 0 && $this->logged_in == TRUE) {
			$data['account_type'] = $this->session->userData('userType');
			if ($data['account_type'] == 2) {
				$search = $data['selectType'] = 'bidder';
			} else if ($data['account_type'] == 1) {
				$search = $data['selectType'] = 'auction';
			}
			if ($this->hpp_url_check('bidding-summery', 'page') > 0) {
				$data['user_menu'] = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
				//$search = isset($_GET['search']) ? $_GET['search'] : $data['selectType'];
				$search_array = array();

				if ($search == 'auction') {
					$data['select_property_by_user'] = $this->Property_Model->select_all_property_by_user('auction', $this->userID);
				} else if ($search == 'bidder') {
					$data['select_property_by_user'] = $this->Property_Model->select_all_property_by_user('auction_offer', $this->userID);
				}
				
				/*---------------- Start Re-Auction Session---------------*/
				if( isset($_POST['addReAuctionProperty']) ){
					$bidPropertyID = $this->input->get( 'bpid' );
					
					$sql = "INSERT INTO
										re_offers_property 
										(
											OFFER_PRICE,
											BIDDING_WIN_PRICE,
											OFFER_DETAILS,
											OFFER_TYPE,
											OFFER_START_DATE,
											OFFER_END_DATE,
											PROPERTY_ID,
											COMPANY_ID,
											USER_ID,
											ENT_DATE,
											OFFER_STATUS
										)
										SELECT 
												OFFER_PRICE,
												BIDDING_WIN_PRICE,
												OFFER_DETAILS,
												OFFER_TYPE,
												OFFER_START_DATE,
												OFFER_END_DATE,
												PROPERTY_ID,
												COMPANY_ID,
												USER_ID,
												ENT_DATE,
												OFFER_STATUS
										FROM
												p_property_offers
										WHERE 
												PROPERTY_ID = '$bidPropertyID'
												AND OFFER_TYPE = 'Bid' 
												AND USER_ID = '$this->userID'
							 
							";
					
					if($this->db->query($sql)){
					
						$bidStartDate   = $this->input->post('offer_start_date');
						$bidTime        = $this->input->post('offer_end_date');
						$dateType       = $this->input->post( 'dateType' );
						$reauction = array(
								'OFFER_PRICE'           => str_replace( ',', '', $this->input->post( 'offer_start_price' )),
								'BIDDING_WIN_PRICE'     => str_replace( ',', '', $this->input->post( 'offer_win_price' )),
								'OFFER_TYPE'            => 'Bid',
								'OFFER_START_DATE'      => $bidStartDate,
								'OFFER_END_DATE'        => $this->modify_date_time( $bidStartDate, $bidTime, $dateType ),
								'PROPERTY_ID'           => $bidPropertyID,
								'COMPANY_ID'            => $this->conpanyID,
								'USER_ID'               => $this->userID,
								'ENT_DATE'              => date('Y-m-d'),
								'OFFER_STATUS'          => 'Pending',
							);
						$sdata = array();
						  if($this->db->update('p_property_offers', $reauction, array('PROPERTY_ID' => $bidPropertyID, 'USER_ID' => $this->userID))){
							  $sdata['message'] = 'Your property has been successfully selected for the auction again..!';
							  $this->session->set_userdata($sdata);
						  }else{
							  $sdata['message'] = 'Your property has been successfully selected for the auction again..!';
							  $this->session->set_userdata($sdata);
						  }
					} 
				}
				
				/*------------------End Re-Auction Session --------------*/

				/* ----- Insert Solicitors Details Into Resuested Table --- */
				$solicitor = array();
				$propertyID = $this->input->get('pId');
				$offerID = $this->input->get('offerId');
				$type = $this->input->get('type');

				if (isset($_POST['addSolicitors'])) {
					$solicitor['SOLICIRORS_NAME'] = $this->input->post('solicitor_name');
					$solicitor['SOLICIRORS_AGENCY_NAME'] = $this->input->post('settlement_agent_name');
					$solicitor['SOLICIRORS_LICENSED_NO'] = $this->input->post('solicitors_licensed_no');
					$solicitor['SOLICIRORS_PHONE'] = $this->input->post('solicitors_phone');
					$solicitor['SOLICIRORS_FAX'] = $this->input->post('solicitors_fax');
					$solicitor['SOLICIRORS_MOBILE'] = $this->input->post('solicitors_mobile');
					$solicitor['SOLICIRORS_EMAIL'] = $this->input->post('solicitors_email');
					if ($type == 'down') {
						$solicitor['OFFER_P_ID'] = $offerID;
						$solicitor['PROPERTY_ID'] = $propertyID;
						$solicitor['COMPANY_ID'] = $this->conpanyID;
						$solicitor['USER_ID'] = $this->userID;
						$solicitor['END_DATE'] = date('Y-m-d H:i:s');
						$solicitor['SOLICITORS_STATUS'] = 'Active';
					}
					$propertyInfo = $this->Property_Model->property_basic(array('PROPERTY_ID' => $propertyID));
					if (is_array($propertyInfo) AND sizeof($propertyInfo) > 0) {
						$to_user = $propertyInfo[0]['USER_ID'];
					}
					$sdata = array();
					$massSub = 0;
					if ($type == 'down') {
						if ($this->db->insert('solicitors_details', $solicitor)) {
							$sdata['message'] = 'Add Solicitors Information SuccessFully..!';
							$this->session->set_userdata($sdata);
							$massSub = 1;
						} else {
							$sdata['message'] = 'Dose Not Add Solicitors Information..!';
							$this->session->set_userdata($sdata);
							redirect(SITE_URL . 'bidding-summery', 'refresh');
						}
					} else {
						if ($this->db->update('solicitors_details', $solicitor, array('USER_ID' => $this->userID, 'PROPERTY_ID' => $propertyID, 'OFFER_P_ID' => $offerID))) {
							$sdata['message'] = 'Update Solicitors Information SuccessFully..!';
							$this->session->set_userdata($sdata);
							$massSub = 1;
						} else {
							$sdata['message'] = 'Dose Not Update Solicitors Information..!';
							$this->session->set_userdata($sdata);
							redirect(SITE_URL . 'bidding-summery', 'refresh');
						}
					}
					$messageBody = '';
					if ($massSub == 1 AND $to_user != 0) {

						$subjectName = 'Solicitors Information for - ' . $propertyInfo[0]['PROPERTY_NAME'] . '';

						$messageBody .= '<h4><b>Property Name: </b> <a href="' . SITE_URL . 'preview?view=' . $propertyInfo[0]['PROPERTY_URL'] . '">' . $propertyInfo[0]['PROPERTY_NAME'] . ' </a></h4>';
						$messageBody .= '<p><b>Solicitor Name : </b> ' . $solicitor['SOLICIRORS_NAME'] . '</p>';
						$messageBody .= '<p><b>Settlement Agent Name/Solicitors Business Name : </b> ' . $solicitor['SOLICIRORS_AGENCY_NAME'] . '</p>';
						$messageBody .= '<p><b>Licensed No.: </b> ' . $solicitor['SOLICIRORS_LICENSED_NO'] . '</p>';
						$messageBody .= '<p><b>Phone: </b> ' . $solicitor['SOLICIRORS_PHONE'] . '</p>';
						$messageBody .= '<p><b>Fax: </b> ' . $solicitor['SOLICIRORS_FAX'] . '</p>';
						$messageBody .= '<p><b>Mobile: </b> ' . $solicitor['SOLICIRORS_MOBILE'] . '</p>';
						$messageBody .= '<p><b>Email: </b> ' . $solicitor['SOLICIRORS_EMAIL'] . '</p>';
						$massage_title = 'Solicitors/Settlement Agent Information';

						$emailInfo = array(
							'FROM_USER' => $this->userID,
							'TO_USER' => $to_user,
							'PROPERTY_ID' => $propertyID,
							'CONTACT_SUBJECT' => $subjectName,
							'COMPANY_ID' => $this->conpanyID,
							'ENT_DATE' => date('Y-m-d'),
							'ENT_DATE_TIME' => date('Y-m-d H:i:s'),
							'SMS_TYPE' => 'Email',
						);
						if ($this->db->insert('sms_contact_agent_user', $emailInfo)) {
							$lastID = $this->db->insert_id();
							$emailDetails = array(
								'CONTACT_AGENT_ID' => $lastID,
								'COMPANY_ID' => $this->conpanyID,
								'FROM_USER' => $this->userID,
								'TO_USER' => $to_user,
								'MESSAGE_TITLE' => $massage_title,
								'MESSAGE_DATA' => htmlspecialchars($messageBody),
								'ENT_DATE' => date('Y-m-d'),
								'ENT_DATE_TIME' => date('Y-m-d h:i:s'),
								'SMS_DET_STATUS' => 'Active'
							);
							$this->db->insert('sms_contact_agent_user_details', $emailDetails);

							$userEmail = $this->user->select_user_mail($to_user);
							$this->MailerModel->sendEmail($userEmail, $subjectName, $messageBody);
						}
					}
					redirect(SITE_URL . 'bidding-summery', 'refresh');
				}
				/* --- End Solicitors Details -- */

				$data['main_content'] = $this->load->view('page_templates/dashboard/users/property/bidding_summery', $data, true);
			} else {
					$data['title'] = 'Don\'t have permission | HPP';
					$data['main_content'] = $this->load->view('errors/errors_page', $data, true);
				}
			}else {
				redirect(SITE_URL . 'login?page=bidding-summery');
			}
		  $this->load->view('master', $data);
    }

	public function offer_summery() {
		$data = array();
		$session_data = array();
		$data['title'] = 'Offer Summery | HPP';
		$data['select_page'] = 'offer-summery';
		$data['selectType'] = 'offer';

		if ($this->userID > 0 && $this->logged_in == TRUE) {
			$data['account_type'] = $this->session->userData('userType');
			if ($data['account_type'] == 2) {
				$search = $data['selectType'] = 'bidder';
			} else if ($data['account_type'] == 1) {
				$search = $data['selectType'] = 'offer';
			}
			if ($this->hpp_url_check('offer-summery', 'page') > 0) {
				$data['user_menu'] = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
				//$search = isset($_GET['search']) ? $_GET['search'] : $data['selectType'];
				$search_array = array();

				if ($search == 'offer') {
					$data['select_property_by_user'] = $this->Property_Model->select_all_property_by_user('hot', $this->userID);
				} else if ($search == 'bidder') {
					$data['select_property_by_user'] = $this->Property_Model->select_all_property_by_user('hot_offer', $this->userID);
				}
				
				/*---------------- Start Re-Auction Session---------------*/
				if( isset($_POST['addReAuctionProperty']) ){
					$bidPropertyID = $this->input->get( 'bpid' );
					
					$sql = "INSERT INTO
										re_offers_property 
										(
											OFFER_PRICE,
											BIDDING_WIN_PRICE,
											OFFER_DETAILS,
											OFFER_TYPE,
											OFFER_START_DATE,
											OFFER_END_DATE,
											PROPERTY_ID,
											COMPANY_ID,
											USER_ID,
											ENT_DATE,
											OFFER_STATUS
										)
										SELECT 
												OFFER_PRICE,
												BIDDING_WIN_PRICE,
												OFFER_DETAILS,
												OFFER_TYPE,
												OFFER_START_DATE,
												OFFER_END_DATE,
												PROPERTY_ID,
												COMPANY_ID,
												USER_ID,
												ENT_DATE,
												OFFER_STATUS
										FROM
												p_property_offers
										WHERE 
												PROPERTY_ID = '$bidPropertyID'
												AND OFFER_TYPE = 'Hot' 
												AND USER_ID = '$this->userID'
							 
							";
					
					if($this->db->query($sql)){
					
						$bidStartDate   = $this->input->post('offer_start_date');
						$bidTime        = $this->input->post('offer_end_date');
						$dateType       = $this->input->post( 'dateType' );
						$reauction = array(
								'OFFER_PRICE'           => str_replace( ',', '', $this->input->post( 'offer_start_price' )),
								'BIDDING_WIN_PRICE'     => 0,
								'OFFER_TYPE'            => 'Hot',
								'OFFER_START_DATE'      => $bidStartDate,
								'OFFER_END_DATE'        => $this->modify_date_time( $bidStartDate, $bidTime, $dateType ),
								'PROPERTY_ID'           => $bidPropertyID,
								'COMPANY_ID'            => $this->conpanyID,
								'USER_ID'               => $this->userID,
								'ENT_DATE'              => date('Y-m-d'),
								'OFFER_STATUS'          => 'Pending',
							);
						$sdata = array();
						  if($this->db->update('p_property_offers', $reauction, array('PROPERTY_ID' => $bidPropertyID, 'USER_ID' => $this->userID))){
							  $sdata['message'] = 'Your property has been successfully selected for the offer again..!';
							  $this->session->set_userdata($sdata);
						  }else{
							  $sdata['message'] = 'Your property has been successfully selected for the offer again..!';
							  $this->session->set_userdata($sdata);
						  }
					} 
				}
				
				/*------------------End Re-Auction Session --------------*/

				/* ----- Insert Solicitors Details Into Resuested Table --- */
				$solicitor = array();
				$propertyID = $this->input->get('pId');
				$offerID = $this->input->get('offerId');
				$type = $this->input->get('type');

				if (isset($_POST['addSolicitors'])) {
					$solicitor['SOLICIRORS_NAME'] = $this->input->post('solicitor_name');
					$solicitor['SOLICIRORS_AGENCY_NAME'] = $this->input->post('settlement_agent_name');
					$solicitor['SOLICIRORS_LICENSED_NO'] = $this->input->post('solicitors_licensed_no');
					$solicitor['SOLICIRORS_PHONE'] = $this->input->post('solicitors_phone');
					$solicitor['SOLICIRORS_FAX'] = $this->input->post('solicitors_fax');
					$solicitor['SOLICIRORS_MOBILE'] = $this->input->post('solicitors_mobile');
					$solicitor['SOLICIRORS_EMAIL'] = $this->input->post('solicitors_email');
					if ($type == 'down') {
						$solicitor['OFFER_P_ID'] = $offerID;
						$solicitor['PROPERTY_ID'] = $propertyID;
						$solicitor['COMPANY_ID'] = $this->conpanyID;
						$solicitor['USER_ID'] = $this->userID;
						$solicitor['END_DATE'] = date('Y-m-d H:i:s');
						$solicitor['SOLICITORS_STATUS'] = 'Active';
					}
					$propertyInfo = $this->Property_Model->property_basic(array('PROPERTY_ID' => $propertyID));
					if (is_array($propertyInfo) AND sizeof($propertyInfo) > 0) {
						$to_user = $propertyInfo[0]['USER_ID'];
					}
					$sdata = array();
					$massSub = 0;
					if ($type == 'down') {
						if ($this->db->insert('solicitors_details', $solicitor)) {
							$sdata['message'] = 'Add Solicitors Information SuccessFully..!';
							$this->session->set_userdata($sdata);
							$massSub = 1;
						} else {
							$sdata['message'] = 'Dose Not Add Solicitors Information..!';
							$this->session->set_userdata($sdata);
							redirect(SITE_URL . 'offer-summery', 'refresh');
						}
					} else {
						if ($this->db->update('solicitors_details', $solicitor, array('USER_ID' => $this->userID, 'PROPERTY_ID' => $propertyID, 'OFFER_P_ID' => $offerID))) {
							$sdata['message'] = 'Update Solicitors Information SuccessFully..!';
							$this->session->set_userdata($sdata);
							$massSub = 1;
						} else {
							$sdata['message'] = 'Dose Not Update Solicitors Information..!';
							$this->session->set_userdata($sdata);
							redirect(SITE_URL . 'offer-summery', 'refresh');
						}
					}
					$messageBody = '';
					if ($massSub == 1 AND $to_user != 0) {

						$subjectName = 'Solicitors Information for - ' . $propertyInfo[0]['PROPERTY_NAME'] . '';

						$messageBody .= '<h4><b>Property Name: </b> <a href="' . SITE_URL . 'preview?view=' . $propertyInfo[0]['PROPERTY_URL'] . '">' . $propertyInfo[0]['PROPERTY_NAME'] . ' </a></h4>';
						$messageBody .= '<p><b>Solicitor Name : </b> ' . $solicitor['SOLICIRORS_NAME'] . '</p>';
						$messageBody .= '<p><b>Settlement Agent Name/Solicitors Business Name : </b> ' . $solicitor['SOLICIRORS_AGENCY_NAME'] . '</p>';
						$messageBody .= '<p><b>Licensed No.: </b> ' . $solicitor['SOLICIRORS_LICENSED_NO'] . '</p>';
						$messageBody .= '<p><b>Phone: </b> ' . $solicitor['SOLICIRORS_PHONE'] . '</p>';
						$messageBody .= '<p><b>Fax: </b> ' . $solicitor['SOLICIRORS_FAX'] . '</p>';
						$messageBody .= '<p><b>Mobile: </b> ' . $solicitor['SOLICIRORS_MOBILE'] . '</p>';
						$messageBody .= '<p><b>Email: </b> ' . $solicitor['SOLICIRORS_EMAIL'] . '</p>';
						$massage_title = 'Solicitors/Settlement Agent Information';

						$emailInfo = array(
							'FROM_USER' => $this->userID,
							'TO_USER' => $to_user,
							'PROPERTY_ID' => $propertyID,
							'CONTACT_SUBJECT' => $subjectName,
							'COMPANY_ID' => $this->conpanyID,
							'ENT_DATE' => date('Y-m-d'),
							'ENT_DATE_TIME' => date('Y-m-d H:i:s'),
							'SMS_TYPE' => 'Email',
						);
						if ($this->db->insert('sms_contact_agent_user', $emailInfo)) {
							$lastID = $this->db->insert_id();
							$emailDetails = array(
								'CONTACT_AGENT_ID' => $lastID,
								'COMPANY_ID' => $this->conpanyID,
								'FROM_USER' => $this->userID,
								'TO_USER' => $to_user,
								'MESSAGE_TITLE' => $massage_title,
								'MESSAGE_DATA' => htmlspecialchars($messageBody),
								'ENT_DATE' => date('Y-m-d'),
								'ENT_DATE_TIME' => date('Y-m-d h:i:s'),
								'SMS_DET_STATUS' => 'Active'
							);
							$this->db->insert('sms_contact_agent_user_details', $emailDetails);

							$userEmail = $this->user->select_user_mail($to_user);
							$this->MailerModel->sendEmail($userEmail, $subjectName, $messageBody);
						}
					}
					redirect(SITE_URL . 'offer-summery', 'refresh');
				}
				/* --- End Solicitors Details -- */

				if( isset($_POST['addCounterValue']) ){
					$sdata = array();
					$propertyID  	= $this->input->get( 'pId' );
					$offerID 		= $this->input->get( 'offerId' );
					$auction_user 	= $this->Property_Model->any_type_where(array('PROPERTY_ID' => $propertyID, 'USER_ID' => $this->userID, 'OFFER_P_ID' => $offerID, 'OFFER_BID_STATUS' => 'Active'), 'p_property_offers_bidding');
					if(is_array($auction_user) AND sizeof($auction_user) > 0){
						$i =1;
						$lastBid = 0;
						$COUNTER_INFO = '';
						$counterInformation = '';
						foreach($auction_user AS $value):
							$counterInformation .= number_format($value['OFFER_BID_PRICE']).' __' .$value['SELLER_PRICE'].'__ '.$value['OFFER_BID_DETAILS'].' __ '.date("d M Y", strtotime($value['ENT_DATE']));
							$lastBid = $value['OFFER_BID_PRICE'];
							$COUNTER_INFO = $value['COUNTER_INFO'];
						endforeach;
						
						$counterArray = array();
						$counter_price = $this->input->post('counter_price');
						$counter_details = $this->input->post('counter_details');
						if($counter_price > $lastBid){
							
							$counterArray['OFFER_BID_PRICE'] = $counter_price;
							$counterArray['OFFER_BID_DETAILS'] = $counter_details;
							$counterArray['COUNTER_INFO'] = $counterInformation.'___'.$COUNTER_INFO ;
							
							if ($this->db->update('p_property_offers_bidding', $counterArray, array('USER_ID' => $this->userID, 'PROPERTY_ID' => $propertyID, 'OFFER_P_ID' => $offerID))) {
									$sdata['message'] = 'Counter SuccessFully..!';
									$this->session->set_userdata($sdata);
									
								} else {
									$sdata['message'] = 'Counter filed..!';
									$this->session->set_userdata($sdata);
									
								}
						}else{
							$sdata['message'] = 'Counter price must be greater than this <b>'.number_format($lastBid).' </b>..!';
							$this->session->set_userdata($sdata);
						}
						
						redirect(SITE_URL . 'offer-summery', 'refresh');
					}
				}
				
				
				$data['main_content'] = $this->load->view('page_templates/dashboard/users/property/offer_summery', $data, true);
			} else {
					$data['title'] = 'Don\'t have permission | HPP';
					$data['main_content'] = $this->load->view('errors/errors_page', $data, true);
				}
			}else {
				redirect(SITE_URL . 'login?page=offer-summery');
			}
		  $this->load->view('master', $data);
    }

	
    public function delete_property(){
        $id = $this->input->get( 'id' );
        $get_search  = $this->input->get( 'getSearch' );
        if($get_search == 'auction' OR $get_search == 'hot'){
            $this->db->delete( 'p_property_offers_bidding', array('PROPERTY_ID' => $id));
            if( $this->db->delete( 'p_property_offers', array('PROPERTY_ID' => $id, 'USER_ID' => $this->userID ))){
               if($get_search == 'hot'){
                    $this->db->update( 'p_property_basic', array( 'HOT_PRICE_PROPERTY' => 'No' ), array('PROPERTY_ID' => $id, 'USER_ID' => $this->userID ) ) ;
               }  else{
                    $this->db->update( 'p_property_basic', array( 'PROPERTY_AUCTION' => 'No' ), array('PROPERTY_ID' => $id, 'USER_ID' => $this->userID ) ) ;
               } 
               echo 1; exit;
            }else{
                echo 0; exit;
            }
        } else {
            if($this->db->update( 'p_property_basic', array( 'PROPERTY_STATUS' => 'Delete' ), array('PROPERTY_ID' => $id, 'USER_ID' => $this->userID ) ) ){
                echo 1; exit;
            }else{
                echo 0; exit;
            }
        }
        
    }
    
   
    public function remove_hot_price_property(){
        $pid        = $this->input->get( 'pid' );
        if( $this->db->update( 'p_property_offers', array( 'OFFER_STATUS' => 'DeActive' ), array( 'PROPERTY_ID' => $pid, 'USER_ID' => $this->userID, 'OFFER_TYPE' => 'Hot' ) )){
            $this->db->update( 'p_property_basic', array( 'HOT_PRICE_PROPERTY' => 'No' ), array( 'PROPERTY_ID' => $pid, 'USER_ID' => $this->userID ) ) ;
            echo 1; exit;
        } else {
            echo 0; exit;
        }
    }
    
    public function selectHotPriceModalById(){
        $bodalBody = '';
        $getPID = $this->input->get('pid');
        $type_admin = $this->input->get('type');
        if($type_admin == 'admin' ){
          $data = array(
            'prodectID'                 => $getPID,
            'type_admin'                 => $type_admin,
            'hpp_modal_property'    => $this->any_where( array( 'PROPERTY_ID' => $getPID ),'p_property_basic' )
        );  
        }else{
            $data = array(
            'prodectID'                 => $getPID,
            'type_admin'                 => 'user',
            'hpp_modal_property'    => $this->any_where( array( 'PROPERTY_ID' => $getPID, 'USER_ID' => $this->userID ),'p_property_basic' )
        );
        }
        $bodalBody = $this->load->view('page_templates/dashboard/users/property/modals/hot_price_modal', $data, TRUE );
        echo $bodalBody;
        exit;
    }
    
	
	
    public function selectAuctionModalById(){
        $bodalBody = '';
        $getPID = $this->input->get('pid');
        $type_admin = $this->input->get('type');
        if($type_admin == 'admin' ){
          $data = array(
            'prodectID'                 => $getPID,
            'type_admin'                 => $type_admin,
            'auction_modal_property'    => $this->any_where( array( 'PROPERTY_ID' => $getPID ),'p_property_basic' )
        );  
        }else{
            $data = array(
            'prodectID'                 => $getPID,
            'type_admin'                 => 'user',
            'auction_modal_property'    => $this->any_where( array( 'PROPERTY_ID' => $getPID, 'USER_ID' => $this->userID ),'p_property_basic' )
        );
        }
        
        $bodalBody = $this->load->view('page_templates/dashboard/users/property/modals/auction_modal', $data, TRUE );
        echo $bodalBody;
        exit;
    }
    
    /*----Select Re-Auction Modal---*/
    public function selectReAuctionUserModalById(){
        $bodalBody = '';
        $getPID     = $this->input->get('pid');
        $type_admin = $this->input->get('type');
        if($type_admin == 'admin' ){
          $data = array(
            'prodectID'                 => $getPID,
            'type_admin'                => $type_admin,
            'auction_modal_property'    => $this->any_where( array( 'PROPERTY_ID' => $getPID ),'p_property_basic' )
        );  
        }else{
            $data = array(
            'prodectID'                 => $getPID,
            'type_admin'                 => 'user',
            'auction_modal_property'    => $this->any_where( array( 'PROPERTY_ID' => $getPID, 'USER_ID' => $this->userID ),'p_property_basic' )
        );
        }
        
        $bodalBody = $this->load->view('page_templates/dashboard/users/property/modals/re_auction_modal', $data, TRUE );
        echo $bodalBody;
        exit;
    }
    
	public function selectAuctionUserModalById(){
        $bodalBody = '';
        $getPID = $this->input->get('pid');
        $offerID = $this->input->get('offer');
        $type = $this->input->get('type');
		
		
		
       $property_count =  $this->any_where_count( array( 'PROPERTY_ID' => $getPID, 'USER_ID' => $this->userID ), 'p_property_basic', 'PROPERTY_ID' );
		 if($property_count == 1){
			 $bidding_user = $this->db->query("SELECT * FROM p_property_offers_bidding AS bidd WHERE bidd.PROPERTY_ID = '$getPID' AND bidd.OFFER_P_ID = '$offerID' ORDER BY bidd.OFFER_BID_PRICE DESC LIMIT 0,10");
			 $count = $bidding_user->num_rows();
			 //echo $count;
			 if($count > 0){
				$data['auction_user'] =  $bidding_user->result_array();
			 }else{
				$data['auction_user'] = 'Not Found bidder';
			 }
			if($type == 1){
				$bodalBody = $this->load->view('page_templates/dashboard/users/property/modals/auction_user_details_hot', $data, TRUE );
			}else{
				$bodalBody = $this->load->view('page_templates/dashboard/users/property/modals/auction_user_details', $data, TRUE );
			}
			echo $bodalBody;
			exit;
		 }
    }
	
	public function selectAuctionUserById(){
        $user = $this->input->get('user');
        $offerID = $this->input->get('offer');
        $pid = $this->input->get('pid');
        $price = $this->input->get('price');
		$mss = 1;
        $property_count =  $this->any_where_count( array( 'OFFER_P_ID' => $offerID, 'USER_ID' => $this->userID, 'WIN_USER' => '0' ), 'p_property_offers', 'OFFER_P_ID' );
		if($property_count == 1){
			$bidding_user = $this->db->query("SELECT * FROM p_property_offers_bidding AS bidd WHERE bidd.PROPERTY_ID = '$pid' AND bidd.USER_ID = '$user' AND bidd.OFFER_P_ID = '$offerID' AND bidd.OFFER_BID_PRICE = '$price'");
			$count = $bidding_user->num_rows();
			if($count == 1){
				if( $this->db->update( 'p_property_offers', array( 'OFFER_STATUS' => 'Win', 'WIN_USER' => $user ), array( 'PROPERTY_ID' => $pid, 'USER_ID' => $this->userID, ) )){
					$this->db->update( 'p_property_basic', array( 'SELL_USER' => $user, 'SELL_PRICE' => $price, 'SELL_DATE' => date("Y-m-d"), 'PROPERTY_STATUS' => 'Sell' ), array( 'PROPERTY_ID' => $pid, 'USER_ID' => $this->userID ) ) ;
					
					$bidderInfo = $this->db->query("SELECT * FROM p_property_offers_bidding WHERE PROPERTY_ID = $pid AND OFFER_BID_STATUS = 'Active' GROUP BY(USER_ID)");
					$bidderArray = $bidderInfo->result_array();
						
						$propertyData['PROPERTY_ID'] = $pid;
						$property = $this->Property_Model->property_basic( $propertyData );
						
						 $offer_price_bid 		 = $this->Property_Model->any_type_where(array('PROPERTY_ID' => $property[0]['PROPERTY_ID'], 'OFFER_STATUS !=' => 'DeActive'), 'p_property_offers');
						 $startDate = date("Y-m-d h:i:s");
						 $lastDate = date("Y-m-d h:i:s");
						 if(is_array($offer_price_bid) AND sizeof($offer_price_bid) > 0){
								 $startDate 	= $offer_price_bid[0]['OFFER_START_DATE'];
								 $lastDate 		= $offer_price_bid[0]['OFFER_END_DATE'];
								 $offerType 	= $offer_price_bid[0]['OFFER_TYPE'];
						 }
						 /*--- Start Insert Email Info into DB --*/
						 if($offerType == 'Hot'){
							 $nameOf = 'Offer';
							 $nameOf2 = 'Offer';
						 }else{
							 $nameOf = 'Bid';
							 $nameOf2 = 'Auction';
						 }
						 
						$address ='';
						if(strlen($property[0]['PROPERTY_STREET_NO']) > 0){
							$address .= $property[0]['PROPERTY_STREET_NO'].', ';
						}
						if(strlen($property[0]['PROPERTY_STREET_ADDRESS']) > 0){
							$address .= $property[0]['PROPERTY_STREET_ADDRESS'].', <br/>';
						}
						if(strlen($property[0]['PROPERTY_CITY']) > 0){
							$address .= $property[0]['PROPERTY_CITY'].', ';
						}
						if(strlen($property[0]['PROPERTY_STATE']) > 0){
							$address .= $property[0]['PROPERTY_STATE'].', <br/>';
						}
						
						if(strlen($property[0]['PROPERTY_COUNTRY']) > 0){
							$cuntryName = $this->Property_Model->select_country(array('countryID' => $property[0]['PROPERTY_COUNTRY']), 'mt_countries');
						
							$address .= $cuntryName[0]['countryName'].' .';
						}
						
						$messageBody = '';
						$massege['name'] = $property[0]['PROPERTY_NAME'];
						$massege['bid'] = $price;
						$massege['name_type'] = $nameOf2;
						//$massege['bid_date'] = date('Y-m-d H:i:s');
						$massege['bid_date'] = $startDate;
						$massege['address'] = $address;
						$massege['url_property'] = $property[0]['PROPERTY_URL'];
						$massege['last_bid_date'] = $lastDate;
						$massege['company_info'] = $this->company_header();
						
							foreach($bidderArray AS $bidder){
								if($user == $bidder['USER_ID']){
									$messageBodyS = $this->load->view('mailScripts/auction_short_summery_close', $massege, TRUE);
									$subjectCloase = 'HPP '.$nameOf.' Win Information - '.$property[0]['PROPERTY_NAME'];
									$massage_title = ''.$nameOf.' Win Info - '.$price.'';
									$fromUser = $this->userID;
									$form_type = 'User';
								}else{
									$messageBodyS = $this->load->view('mailScripts/auction_short_summery_close_all', $massege, TRUE);
									$subjectCloase = ''.$nameOf.' Close - '.$property[0]['PROPERTY_NAME'];
									$massage_title = ''.$nameOf.' close Info - '.$price.'';
									$fromUser = $this->user->admin_login_id();
									$form_type = 'Hpp';
								}
								$emailInfo = array(
											'FROM_USER'         => $fromUser,
											'FROM_TYPE'         => $form_type,
											'TO_USER'           => $bidder['USER_ID'],
											'PROPERTY_ID'       => $pid,
											'CONTACT_SUBJECT'   => $subjectCloase,
											'COMPANY_ID'        => $this->conpanyID,
											'ENT_DATE'          => date('Y-m-d'),
											'ENT_DATE_TIME'     => date('Y-m-d H:i:s'),
											'SMS_TYPE'          => 'Email',
										);
								if($this->db->insert( 'sms_contact_agent_user', $emailInfo )){
									$lastIDS = $this->db->insert_id();
									$emailDetails = array(
															'CONTACT_AGENT_ID'  => $lastIDS,
															'COMPANY_ID'        => $this->conpanyID,
															'FROM_USER'         => $fromUser,
															'FROM_TYPE_D'       => $form_type,
															'TO_USER'           => $this->userID,
															'MESSAGE_TITLE'     => $massage_title,
															'MESSAGE_DATA'      => htmlspecialchars($messageBodyS),
															'ENT_DATE'	 		=> date('Y-m-d'),
															'ENT_DATE_TIME' 	=> date('Y-m-d h:i:s'),
															'SMS_DET_STATUS' 	=> 'Active'
														);
									$this->db->insert( 'sms_contact_agent_user_details', $emailDetails );
									$mss = 1;
									$userEmailS = $this->user->select_user_mail($bidder['USER_ID']);
									$this->MailerModel->sendEmail($userEmailS, $subjectCloase, $messageBodyS);
								}
							
						}
						
					
					$mss = 1;
				} else {
					$mss = 0;
				}
			}else{
				$mss = 2;
			}
		 }else{
			 $mss = 3;
		 }
		 
		 echo $mss; exit;
    }
	

	
	
	  
/*-----------------------
 * Add Solicitors Details
 * On 07-03-2018
 */ 
    function AddSolicitorsDetailsById(){
        $modalBody = '';
        $modalBody = $this->load->view('page_templates/dashboard/users/property/modals/solicitiors_details', '', TRUE);
        echo $modalBody;
        exit;
    }
	
	function AddSolicitorsDetailsByIdView(){
        $modalBody = '';
													
        $modalBody = $this->load->view('page_templates/dashboard/users/property/modals/solicitiors_details', '', TRUE);
        echo $modalBody;
        exit;
    }
	
	function AddCounterDetailsByIdView(){
        $modalBody = '';
													
        $modalBody = $this->load->view('page_templates/dashboard/users/property/modals/offer_counter_hot', '', TRUE);
        echo $modalBody;
        exit;
    }
	
	public function replayOfferCounterSeller(){
		  $pId     = $this->input->get('pId');
		  $offerId     = $this->input->get('offerId');
		  $value     = $this->input->get('value');
		  
		  if($value > 0){
			  $update = array();
			  $update['SELLER_PRICE'] = $value;
			  if($this->db->update('p_property_offers_bidding', $update, array('OFFER_BID_ID' => $offerId, 'PROPERTY_ID' => $pId))){
				  echo '1';
			  }else{
				    echo '0';
			  }
		  }else{
			  echo '0';
		  }
		  
		 exit;
	}
}

?>