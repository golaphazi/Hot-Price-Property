<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends HPP_Controller {

    public $adminID, $logged_admin, $adminName, $adminUser, $adminType;

    public function __construct() {
        parent::__construct();
        $this->load->model("Hpp_Admin_Model");
        $this->adminID = $this->session->userData('adminID');
        $this->adminName = $this->session->userData('adminName');
        $this->logged_admin = $this->session->userData('logged_admin');
        $this->adminUser = $this->session->userData('adminUser');
        $this->adminType = $this->session->userData('adminType');
        $this->Hpp_Admin_Model->hpp_login();
    }

    public function index() {
        $data = array();

        $page = isset($_GET['page']) ? $_GET['page'] : 'home_admin';
        $page = str_replace('$$', '&#', $page);
        $page = str_replace(';;', '&', $page);

        $data['MSG'] = '';
        $data['ACTION'] = $page;

        $data['title'] = 'Welcome ' . $this->adminName . ' | HPP';

        if (isset($_POST['user_login_admin'])) {
            $username = $this->input->post('login_email');
            $password = md5($this->input->post('login_password'));

            if (strlen($username) > 0 AND strlen($password) > 0) {
                $query = $this->db->query("SELECT * FROM admin_access as user WHERE (user.ADMIN_EMAIL = '" . addslashes($username) . "' OR user.ADMIN_USER = '" . addslashes($username) . "') AND user.ADMIN_PASS = '" . $password . "'");
                $count = $query->num_rows();
                if ($count == 1) {
                    $userData = $query->row();
                    if ($userData->ADMIN_STATUS == 'Active') {
                        if (isset($userData)) {
                            $newdata = array(
                                'adminID' => $userData->ADMIN_ID,
                                'adminUser' => $userData->ADMIN_USER,
                                'adminName' => $userData->ADMIN_NAME,
                                'adminType' => $userData->ADMIN_TYPE,
                                'logged_admin' => TRUE
                            );
                            
                            $this->session->set_userdata($newdata);
                        } else {
                            $data['MSG'] = '<span style="color:#fff;">System error</span>';
                        }
                    } else {
                        $data['MSG'] = '<span class="error">Your account under review HPP team</span>';
                    }
                } else {
                    $data['MSG'] = '<span class="error" >User name or password don\'t match</span>';
                }
            } else {
                $data['MSG'] = '<span class="error" >Enter user name and password</span>';
            }
        }


        $this->adminID = $this->session->userData('adminID');
        $this->logged_admin = $this->session->userData('logged_admin');

        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
            redirect(SITE_URL . 'hpp/admin/' . $page);
        } else {
            $data['main_content'] = $this->load->view('page_templates/userLogin/company/login_admin', $data, true);
        }
        $this->load->view('admin_master', $data);
    }

    public function home_admin() {
        $data = array();
        $data['title'] = 'Admin Panel - ' . $this->adminName . ' | HPP';

        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
            $data['select_page'] = 'home_admin';
            $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);

            $data['main_content'] = $this->load->view('page_templates/dashboard/company/home-admin', $data, true);
            $this->load->view('admin_master', $data);
        } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
    }
    
    /*
     * add_admin For create New Admin
     * Deloved On 13-02-2018
     */
    public function add_admin(){
        $data = array();
        $data['title'] = 'Admin Panel - Add Admin | HPP';

        if ($this->adminType == 'Super' && $this->logged_admin == TRUE) {
            $data['select_page'] = 'add_admin';
            $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            
            /*--- Start Add Admin User --*/
            $insertAdmin = array();
            if( isset($_POST['AddAdminUser'])){
                $relPassword = $this->input->post('rel_password');
                $conPasswprd = $this->input->post('con_password');
                $password = '';
                if( $relPassword == $conPasswprd ){
                    $password = $relPassword;
                }
                $insertAdmin['ADMIN_EMAIL']   = $this->input->post('admin_email_id');
                $insertAdmin['ADMIN_USER']    = $this->input->post('user_name');
                $insertAdmin['ADMIN_PASS']    = md5($password);
                $insertAdmin['ADMIN_TYPE']    = $this->input->post('admin_role');
                $insertAdmin['ADMIN_NAME']    = $this->input->post('admin_full_name');
                $insertAdmin['ADMIN_STATUS']  = 'Active';
                if ($this->db->insert('admin_access', $insertAdmin)) {
                    $session_data['message'] = "Admin User Created Succesfully..!!";
                    $this->session->set_userdata($session_data);
                }else{
                    redirect(SITE_URL . 'home_admin', 'refresh');
                }
            }/*--- End Add Admin User --*/
            
            $search = isset($_GET['search']) ? $_GET['search'] : 'all';
            $data['main_content']       = $this->load->view('page_templates/dashboard/company/add-admin', $data, true);
            $this->load->view('admin_master', $data);
        } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
    }
    /*
     * add_admin For create New Admin
     * Deloved On 13-02-2018
     */
    public function manage_admin(){
        $data = array();
        $data['title'] = 'Admin Panel - Manage User | HPP';

        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
            $data['select_page'] = 'manage_admin';
            $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            
            /*--- Start Update Admin ---*/
            $update = array();
            if(isset($_POST['updateAdminProfile'])):
                $adminID = $this->input->post('admin_id');
                $update['ADMIN_NAME']    = $this->input->post('admin_full_name');
                $update['ADMIN_USER']    = $this->input->post('admin_user_name');
                $update['ADMIN_EMAIL']   = $this->input->post('email_id');
                $update['ADMIN_TYPE']    = $this->input->post('admin_role');
                $update['ADMIN_STATUS']  = $this->input->post('admin_status');
//                echo '<pre>';print_r($update);exit;
                $sdada = array();
                if($this->db->update('admin_access',$update, array( 'ADMIN_ID' => $adminID ) )){
                    $sdada['message'] = 'User Information Updated Successfully..!';
                    $this->session->set_userdata($sdada);
                }else{
                    $sdada['message'] = 'User Information Dose\'t Updated ..!!';
                    $this->session->set_userdata($sdada);
                }
            endif; 
            /*--- End Update Admin ---*/
            
            $search = isset($_GET['search']) ? $_GET['search'] : 'all';
            $data['select_admin_user']  = $this->Hpp_Admin_Model->select_all_admin_user_by_type($search);
            $data['main_content']       = $this->load->view('page_templates/dashboard/company/manage-admin', $data, true);
            $this->load->view('admin_master', $data);
        } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
    }
    
    /*
     * manage_hpp_user()
     * Develop ON 27-03-2018
     */
    public function manage_hpp_user()
    {
        $data = array();
        $data['title'] = 'Manage HPP User | Hpp';
        if( $this->adminID > 0 AND $this->logged_admin == TRUE ){
            $data['select_page'] = 'manage_hpp_user';
            $data['user_menu']   = $this->load->view( 'page_templates/dashboard/company/user_menu', $data, true );
            
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $data['select_hpp_user']  = $this->Hpp_Admin_Model->select_all_hpp_user_by_type( $search );
            $data['main_content']     = $this->load->view( 'page_templates/dashboard/company/manage-hpp-user', $data, true );
            $this->load->view('admin_master', $data);
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
    }


    /*
 * verified_email
 * @param $emailid
 * on 13-03-2018
 */
    public function verified_email()
    {
        $emailID = $this->input->get('emailID');
        $query = $this->db->query("SELECT * FROM admin_access WHERE ADMIN_EMAIL = '$emailID'");
//        echo $this->db->last_query($query);
        $result = $query->row();
        if($result)
        {
           echo  '<div class="alert alert-danger">Alredy Registured..!!</div>';
        }
        else{
           echo '<div class="alert alert-success">Avilable</div>';
        }
    }
    
/*
 * active_usser_admin_by_id
 * on 13-03-2018
 */
    public function active_usser_admin_by_id($adminId)
    {
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            if($this->db->update('admin_access',array('ADMIN_STATUS' => 'Active'), array( 'ADMIN_ID' => $adminId) ) ){
                $sdata['message'] = 'User Successfully Actived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_admin','refresh');
            }else{
                $sdata['message'] = 'User don\'t Actived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_admin','refresh');
            }
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
    }
    
    /*
 * deactive_usser_admin_by_id
 * on 13-03-2018
 */
    public function deactive_usser_admin_by_id($adminId)
    {
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            if($this->db->update('admin_access',array('ADMIN_STATUS' => 'DeActive'), array( 'ADMIN_ID' => $adminId) ) ){
                $sdata['message'] = 'User Successfully Deactived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_admin','refresh');
            }else{
                $sdata['message'] = 'User Don\'t Deactived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_admin','refresh');
            } 
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
        
    }
    
    
   /*
    * active_hpp_usser_admin_by_id
    * on 27-03-2018
    */
    public function active_hpp_usser_by_id($userId)
    {
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            if($this->db->update('s_user_info',array('USER_STATUS' => 'Active'), array( 'USER_ID' => $userId ) ) ){
                $sdata['message'] = 'User Successfully Actived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_hpp_user','refresh');
            }else{
                $sdata['message'] = 'User don\'t Actived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_hpp_user','refresh');
            }
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
    }
    
	public function varify_hpp_usser_by_id($userId)
    {
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            if($this->db->update('s_user_info',array('VERIFY_STATUS' => 'Verified'), array( 'USER_ID' => $userId, 'USER_STATUS' => 'Active' ) ) ){
                $sdata['message'] = 'User Successfully Verify..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_hpp_user','refresh');
            }else{
                $sdata['message'] = 'User don\'t Verify..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_hpp_user','refresh');
            }
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
    }

  /*
   * deactive_hpp_usser_by_id
   * on 27-03-2018
   */
    public function deactive_hpp_usser_by_id($userId)
    {
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            if($this->db->update('s_user_info',array('USER_STATUS' => 'DeActive'), array( 'USER_ID' => $userId ) ) ){
                $sdata['message'] = 'User Successfully Deactived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_hpp_user','refresh');
            }else{
                $sdata['message'] = 'User Don\'t Deactived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_hpp_user','refresh');
            } 
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
        
    }
    
   /*
    * delete_hpp_usser_by_id
    * on 27-03-2018
    */
    public function delete_hpp_usser_by_id($userId)
    {
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            if($this->db->update('s_user_info',array('USER_STATUS' => 'Delete'), array( 'USER_ID' => $userId ) ) ){
                $sdata['message'] = 'User Successfully Deleted..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_hpp_user','refresh');
            }else{
                $sdata['message'] = 'User Don\'t Deleted..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_hpp_user','refresh');
            } 
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
        
    }
    /*
     * selectHppUserModalById
     */
    public function selectHppUserModalById(){
        $userID = $this->input->get('userID');
        $data = array();
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
        $modalBody = '';
        $data['contact']            = $this->any_where(array('CONTAC_TYPE_TYPE' => 'basic', 'CONTACT_TYPE_STATUS' => 'Active'), 'mt_c_contact_type');
        $data['contact_address']    = $this->any_where(array('CONTAC_TYPE_TYPE' => 'contact_address', 'CONTACT_TYPE_STATUS' => 'Active'), 'mt_c_contact_type');
        $data['social']             = $this->any_where(array('CONTAC_TYPE_TYPE' => 'Social', 'CONTACT_TYPE_STATUS' => 'Active'), 'mt_c_contact_type');
        $data['COUNTRYES']          = $this->Property_Model->select_country('', '');
        $data['user_profile'] = $this->user->select_user_profile_by_id( $userID );
        $modalBody = $this->load->view('page_templates/dashboard/company/modals/hpp-user-profile', $data, TRUE );
        echo $modalBody;
        exit;
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
    }



    /*
     * manage_property
     * Develop On 12-03-2018
     */
    public function manage_property(){
        $data = array();
        $data['title'] = 'Admin Panel - Manage Property | HPP';
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
           $data['select_page']     = 'manage_property';
           
           
           $search = isset($_GET['search']) ? $_GET['search'] : 'all';
           if($search == 'sell'){
              $data['select_page']     = 'manage_property?search=sell'; 
           }else if($search == 'hot'){
               $data['select_page']     = 'manage_property?search=hot'; 
           }else if($search == 'auction'){
               $data['select_page']     = 'manage_property?search=auction'; 
           }else if($search == 'rent'){
               $data['select_page']     = 'manage_property?search=rent'; 
           }
           $data['user_menu']       = $this->load->view('page_templates/dashboard/company/user_menu', $data, true); 
           $type = isset($_GET['type']) ? $_GET['type'] : 'pending';
           $data['select_property'] = $this->Hpp_Admin_Model->select_all_property_by_type($search, $type);
           $data['main_content']    = $this->load->view('page_templates/dashboard/company/manage-property', $data, TRUE );
           $this->load->view( 'admin_master', $data );
        }
        else{
            redirect(SITE_URL.'hpp/Admin','refresh');
        }
    }
    
	
	public function delete_property(){
        $id = $this->input->get( 'id' );
        $get_search  = $this->input->get( 'getSearch' );
        if($get_search == 'auction' OR $get_search == 'hot'){
            $this->db->delete( 'p_property_offers_bidding', array('PROPERTY_ID' => $id));
            if( $this->db->delete( 'p_property_offers', array('PROPERTY_ID' => $id))){
               if($get_search == 'hot'){
                    $this->db->update( 'p_property_basic', array( 'HOT_PRICE_PROPERTY' => 'No' ), array('PROPERTY_ID' => $id ) ) ;
               }  else{
                    $this->db->update( 'p_property_basic', array( 'PROPERTY_AUCTION' => 'No' ), array('PROPERTY_ID' => $id ) ) ;
               } 
               echo 1; exit;
            }else{
                echo 0; exit;
            }
        } else {
            if($this->db->update( 'p_property_basic', array( 'PROPERTY_STATUS' => 'Delete' ), array('PROPERTY_ID' => $id ) ) ){
                echo 1; exit;
            }else{
                echo 0; exit;
            }
        }
        
    }
	public function edit_data_by_admin(){
		$idcheck = $this->input->get( 'idcheck' );
        $filefCheck  = $this->input->get( 'filefCheck' );
        $table  = $this->input->get( 'table' );
        $filed  = $this->input->get( 'filed' );
        $value  = trim($this->input->get( 'value' ));
		if(strlen($value) > 5){
			if($this->db->update( $table, array( $filed => $value ), array($filefCheck => $idcheck ) ) ){
				echo 1; exit;
			}else{
				echo 0; exit;
			}
		}else{
			echo 0; exit;
		}
		
	}
	
	
    /*
     * aprovedPropertyByID()
     * Approved Property By ID this methoed are applied for Only Normal Property
     * Approved & Reject Both action are executed by methoed...
     */
    public function aprovedPropertyByID(){
        $propertyID = $this->input->get('pID');
        $status = $this->input->get('status');
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            if($this->db->update( 'p_property_basic', array( 'PROPERTY_STATUS' => $status ), array('PROPERTY_ID' => $propertyID ) ) ){
                echo 1; exit;
            }else{
                echo 0; exit;
            }
        }
    }
    
    /*
     * hpp_active_prodeuct_by_id()
     * Developed On 30-03-218
     */
    public function hpp_active_prodeuct_by_id($getPID){
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            $sdata = array();
            if($this->db->update( 'p_property_basic', array( 'PROPERTY_STATUS' => 'Active' ), array('PROPERTY_ID' => $getPID ) ) ){
                $sdata['message'] = 'Property Success Fully Activated...!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_property/?search=sell&type=active','refresh');
            }else{
                $sdata['message'] = 'Property Dose\'t Activated..!!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_property/?search=sell&type=pending','refresh');
            }
        }else {
            redirect(SITE_URL.'hpp/Admin','refresh');
        }
    }
    /*
     * hpp_reject_prodeuct_by_id()
     * Developed On 30-03-218
     */
    public function hpp_reject_prodeuct_by_id($getPID){
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            $sdata = array();
            if($this->db->update( 'p_property_basic', array( 'PROPERTY_STATUS' => 'Reject' ), array('PROPERTY_ID' => $getPID ) ) ){
                $sdata['message'] = 'Property Success Fully Rejected...!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_property/?search=sell&type=reject','refresh');
            }else{
                $sdata['message'] = 'Property Dose\'t Rejected..!!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_property/?search=sell&type=reject','refresh');
            }
        }else {
            redirect(SITE_URL.'hpp/Admin','refresh');
        }
    }


    /*
     * aprovedOfferPropertyByID()
     * Approved Property By ID this methoed are applied for Hot offer Property & Auction Offer Property
     * Approved & Reject Both action are executed by methoed...
     */
    public function aprovedOfferPropertyByID(){
        $propertyID = $this->input->get('pID');
        $status = $this->input->get('status');
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            if($this->db->update( 'p_property_offers', array( 'OFFER_STATUS' => $status ), array('PROPERTY_ID' => $propertyID ) ) ){
                echo 1; exit;
            }else{
                echo 0; exit;
            }
        }
    }
    
    public function selectAdminProfileModalById(){
        $adminID = $this->input->get('adminID');
        $data = array();
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
        $modalBody = '';
//        $data['user_details'] = $this->Hpp_Admin_Model->selectAdminDetailsById($adminID);
        $getUser = $this->db->query("SELECT * FROM admin_access WHERE ADMIN_ID = '$adminID'");
        $data['user_details'] = $getUser->result_array();
        $modalBody = $this->load->view('page_templates/dashboard/company/modals/admin-profile', $data, TRUE );
        echo $modalBody;
        exit;
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
    }
    
    public function selectAdminEditProfileById(){
        $adminID = $this->input->get('adminID');
        $data = array();
        $modalBody = '';
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
        $data['adminID'] = $adminID;
//        $data['select_user'] = $this->Hpp_Admin_Model->selectAdminDetailsById($adminID);
        $getUser = $this->db->query("SELECT * FROM admin_access WHERE ADMIN_ID = '$adminID'");
        $data['select_user'] = $getUser->result_array();
        $modalBody = $this->load->view('page_templates/dashboard/company/modals/edit-profile', $data, TRUE );
        echo $modalBody;
        exit;
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
    }

    

    public function approved() {
        $data = array();
        $data['MASG'] = '';
        $propertyD = array();
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
			
			$data['select_page']     = 'manage_property';
           
           $data['user_menu']       = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
			
            $get = $this->input->get('view', '');
            $propertyD['PROPERTY_URL'] = $get;
            $property = $this->Property_Model->property_basic($propertyD);
                if (is_array($property) AND sizeof($property) > 0) {
                    //$data['PROPERTY_URL']   = $get;
                    $data['title']              = $property[0]['PROPERTY_NAME'] . ' | HPP';
                    $data['property']           = $property[0];
                    $data['additional']         = $this->Property_Model->additional_property_filed($property[0]['PROPERTY_ID']);
                    $data['additional_other']   = $this->Property_Model->additional_property_filed($property[0]['PROPERTY_ID'], 'Dynamic');
                    $data['near_by']            = $this->Property_Model->property_near_by($property[0]['PROPERTY_ID']);
                    $data['images_property']    = $this->Property_Model->property_image(array('PROPERTY_ID' => $property[0]['PROPERTY_ID']));
                    $data['video_property']     = $this->Property_Model->property_video(array('PROPERTY_ID' => $property[0]['PROPERTY_ID']));
                    $data['offer_price_bid']    = $this->Property_Model->any_type_where(array('PROPERTY_ID' => $property[0]['PROPERTY_ID'], 'OFFER_TYPE' => 'Bid', 'OFFER_STATUS !=' => 'DeActive'), 'p_property_offers');

                    $BIDDING_PRICE = 0;
                    $WIN_BIDDING_PRICE = 0;
                    $lastDate = date("Y-m-d");
                    if (is_array($data['offer_price_bid']) AND sizeof($data['offer_price_bid']) > 0) {
                        $BIDDING_PRICE      = $data['offer_price_bid'][0]['OFFER_PRICE'];
                        $WIN_BIDDING_PRICE  = $data['offer_price_bid'][0]['BIDDING_WIN_PRICE'];
                        $lastDate           = $data['offer_price_bid'][0]['OFFER_END_DATE'];
                    }

                    $offr_bid = $this->db->query("SELECT OFFER_BID_PRICE FROM p_property_offers_bidding WHERE PROPERTY_ID = " . $property[0]['PROPERTY_ID'] . " AND OFFER_BID_STATUS = 'Active' ORDER BY OFFER_BID_ID DESC LIMIT 0,1");
                    $offr_bid_val = $offr_bid->result_array();
                    if (is_array($offr_bid_val) AND sizeof($offr_bid_val) > 0) {
                        $BIDDING_PRICE = $offr_bid_val[0]['OFFER_BID_PRICE'];
                    }
                    $data['contact_agent_type'] = array('Name' => 'name_contact', 'Email' => 'email_address', 'Phone' => 'phone_no', 'About me' => 'about_me', 'Request' => 'request', 'Message to' => 'message');
                    $data['MASG_BID'] = '';
                    $userID = $this->session->userData('userID');
                    $logged_in = $this->session->userData('logged_in');
                    $data['account_type'] = $this->session->userData('userType');
                    //print_r($data['images_property']);
                    $data['main_content'] = $this->load->view('page_templates/dashboard/company/property-details', $data, TRUE);

                } else {
                    $data['title'] = 'Invalid property url | HPP';
                }

            $this->load->view('admin_master', $data);
            
           } else{
                redirect(SITE_URL.'hpp/Admin','refresh');
           } 
    }
    
    public function bidding_summery() {
        $data = array();
        $session_data = array();
        $data['selectType'] = 'auction';
        $data['title'] = 'Admin Bidding Summery | HPP';

        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
            $data['select_page']    = 'bidding_summery';
            $data['user_menu']      = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);

            $data['select_auction_info'] = $this->Hpp_Admin_Model->select_auction_property_by_win();
            $data['main_content']        = $this->load->view('page_templates/dashboard/company/bidding-summery', $data, true);
        } else {
            $data['title'] = 'Don\'t have permission | HPP';
            $data['main_content'] = $this->load->view('errors/errors_page', $data, true);
        }

        $this->load->view('admin_master', $data);
    }
    
    public function selectAdminAuctionUserModalById(){
        $bodalBody = '';
        $getPID = $this->input->get('pid');
        $offerID = $this->input->get('offer');
        if( $this->adminID && $this->logged_admin ) {
            $property_count =  $this->any_where_count( array( 'PROPERTY_ID' => $getPID ), 'p_property_basic', 'PROPERTY_ID' );
             if($property_count == 1){
                 $bidding_user = $this->db->query("SELECT * FROM p_property_offers_bidding AS bidd WHERE bidd.PROPERTY_ID = '$getPID' AND bidd.OFFER_P_ID = '$offerID' ORDER BY bidd.OFFER_BID_ID DESC LIMIT 0,10");
                 $count = $bidding_user->num_rows();
                 //echo $count;
                 if($count > 0){
                     $data['auction_user'] =  $bidding_user->result_array();
                 }else{
                     $data['auction_user'] = 'Not Found bidder';
                 }
                $bodalBody = $this->load->view('page_templates/dashboard/company/modals/auction-user-details', $data, TRUE );
                echo $bodalBody;
                exit;
             }
        } else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
        
    }    

    
    
    public function email_inbox() {
        $data = array();
        $session_data = array();
        $data['title'] = 'Admin Email Inbox | HPP';
        $data['select_page'] = 'email_inbox';
        $data['composeMSG'] = ''; 
        $data['composeEmail'] = ''; 

        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
            $data['user_menu']      = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            $search = isset($_GET['search']) ? $_GET['search'] : 'inbox';
            $search_array = array();

            $GetEmailView = isset( $_GET['view-email'] ) ? $_GET['view-email'] : 'see';
            $Getscau = isset( $_GET['scau'] ) ? $_GET['scau'] : 0;
            $Getscaud = isset( $_GET['scaud'] ) ? $_GET['scaud'] : 0;
            $apply = isset( $_GET['apply'] ) ? $_GET['apply'] : '';


            /*Code for view email / replay / forward*/
            if( $GetEmailView == 'view' && $Getscau > 0){ 
                    $dataEdit = array( 'SEEN_TYPE' => 'view');
                    $this->db->update( 'sms_contact_agent_user', $dataEdit , array('CONTACT_AGENT_ID' => $Getscau, 'TO_USER' => $this->adminID, 'TO_TYPE' => 'Hpp' ));

                    if(isset($_POST['contact_replay_message'])){
                            $replay = trim($this->input->post('message_replay'));
                            if(strlen($replay) > 2){
                                $massageDetailsShow =  $this->any_where(array('CONTACT_AGENT_ID' => $Getscau), 'sms_contact_agent_user');
                                if(sizeof($massageDetailsShow) > 0){
                                    if($massageDetailsShow[0]['FROM_USER'] == $this->adminID AND $massageDetailsShow[0]['FROM_TYPE'] == 'Hpp'){
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
                                            if($to_user > 0 AND $to_user != $this->adminID){
                                                    $emailInfo = array(
                                                        'FROM_USER'         => $this->adminID,
                                                        'FROM_TYPE'         => 'Hpp',
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
                                                'FROM_USER'         => $this->adminID,
                                                'FROM_TYPE_D'         => 'Hpp',
                                                'TO_USER'           => $to_user,
                                                'TO_TYPE_D'           => $to_type,
                                                'MESSAGE_TITLE'     => substr(strip_tags($replay), 0, 30),
                                                'MESSAGE_DATA'      => htmlspecialchars($replay),
                                                'ENT_DATE'          => date('Y-m-d'),
                                                'ENT_DATE_TIME' 	=> date('Y-m-d h:i:s'),
                                                'SMS_DET_STATUS' 	=> 'Active'
                                        );
                                        if($this->db->insert( 'sms_contact_agent_user_details', $emailDetails )){
                                            $lastID = $this->db->insert_id();

                                            $this->MailerModel->sendEmail($composeEmail, substr(strip_tags($replay), 0, 30), $replay);

                                            $dataEditReplay = array( 'SEEN_TYPE' => 'show', 'ENT_DATE_TIME' => date("Y-m-d h:i:s") );
                                            $this->db->update( 'sms_contact_agent_user', $dataEditReplay , array('CONTACT_AGENT_ID' => $Getscau));

                                            redirect(SITE_URL . 'hpp/admin/email_inbox?search='.$search.'&view_email=view&scau='.$Getscau.'&scaud='.$lastID);
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
                    $search_array['TO_USER'] = $this->adminID;
                    $search_array['TO_TYPE'] = 'Hpp';
                    
                } else if ($search == 'sent') {
                    $search_array['FROM_USER'] = $this->adminID;
                    $search_array['FROM_TYPE'] = 'Hpp';
                } else if ($search == 'email') {
                    $search_array['TO_USER'] = $this->adminID;
                    $search_array['TO_TYPE'] = 'Hpp';
                    $search_array['SMS_TYPE'] = 'Email';
                } else if ($search == 'property') {
                    $search_array['TO_USER'] = $this->adminID;
                    $search_array['TO_TYPE'] = 'Hpp';
                    $search_array['PROPERTY_ID !='] = '0';
                    $search_array['SMS_TYPE'] = 'Property';
                }else{
                    $search_array['TO_USER'] = $this->adminID;
                    $search_array['TO_TYPE'] = 'Hpp';
                }
                $search_array['SMS_TYPE']   = 'Email';
                $search_array['SMS_STATUS'] = 'Send';

                $queryAllCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS all_cunt FROM sms_contact_agent_user WHERE (((TO_USER = '$this->adminID' AND TO_TYPE = 'Hpp') OR (FROM_USER = '$this->adminID' AND FROM_TYPE = 'Hpp')) OR ( TO_USER = '0' OR FROM_USER = '0' )) AND SMS_TYPE = 'Email' AND SMS_STATUS = 'Send' AND SEEN_TYPE = 'show'");
                $count_all= $queryAllCount->result();	
                $data['ALL_COUNT'] = $count_all[0]->all_cunt;

                $queryInboxCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS ALL_COUNT_INbox FROM sms_contact_agent_user WHERE TO_USER = '$this->adminID' AND TO_TYPE = 'Hpp' AND SMS_TYPE = 'Email' AND SMS_STATUS = 'Send' AND SEEN_TYPE = 'show'");
                $count_inbox= $queryInboxCount->result();	
                $data['ALL_COUNT_INbox'] = $count_inbox[0]->ALL_COUNT_INbox;

                $querySendCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS ALL_COUNT_SEND FROM sms_contact_agent_user WHERE FROM_USER = '$this->adminID' AND FROM_TYPE = 'Hpp' AND SMS_TYPE = 'Email' AND SMS_STATUS = 'Send' AND SEEN_TYPE = 'show'");
                $count_send= $querySendCount->result();	
                $data['ALL_COUNT_SEND'] = $count_send[0]->ALL_COUNT_SEND;
                //echo $data['ALL_COUNT_INbox'];

				$querySendCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS ALL_CONTA_SEND FROM sms_contact_agent_user WHERE SMS_STATUS = 'Send' AND SMS_TYPE = 'Email' AND SEEN_TYPE = 'show'");
                $count_send= $querySendCount->result();	
                $data['ALL_CONTACT_SEND'] = $count_send[0]->ALL_CONTA_SEND;
				
                if($search == 'all'){
                    $queryAll = $this->db->query("SELECT * FROM sms_contact_agent_user WHERE (((TO_USER = '$this->adminID' AND TO_TYPE = 'Hpp') OR (FROM_USER = '$this->adminID' AND FROM_TYPE = 'Hpp')) OR ( TO_USER = '0' OR FROM_USER = '0' )) AND SMS_STATUS = 'Send' AND SMS_TYPE = 'Email' ORDER BY ENT_DATE_TIME DESC");
                    $data['massage_list'] = $queryAll->result_array();
                }else if($search == 'contact'){
                    $queryAll = $this->db->query("SELECT * FROM sms_contact_agent_user WHERE SMS_STATUS = 'Send' AND SMS_TYPE = 'Email' ORDER BY ENT_DATE_TIME DESC");
                    $data['massage_list'] = $queryAll->result_array();
                }else{
                    $data['massage_list']   = $this->any_where($search_array, 'sms_contact_agent_user');
                }

                $composeAll = $this->db->query("SELECT distinct(FROM_USER), TO_USER FROM sms_contact_agent_user WHERE ((TO_USER = '$this->adminID' AND TO_TYPE = 'Hpp') OR (FROM_USER = '$this->adminID' AND  FROM_TYPE = 'Hpp')) AND SMS_STATUS = 'Send' AND SMS_TYPE = 'Email' AND FROM_USER > 0 ORDER BY ENT_DATE_TIME DESC");
                $data['compose_email_list'] = $composeAll->result_array();

                /*Code for compose email*/

                if($search == 'compose'){
                    $data['composeEmail'] = ''; $data['composeSubject'] = '';
                    if(isset($_POST['compose_form'])){
                    $composeEmail = trim($this->input->post('compose_email'));
                    $compose_subject = trim($this->input->post('compose_subject'));
                            if(strlen($composeEmail) > 5){
                                    if(strlen($compose_subject) > 0){
                                            $replay = trim($this->input->post('compose_data'));
                                            if(strlen(strip_tags($replay)) > 2)	{
                                                    $to_user = $this->user->select_user_mailBY_id($composeEmail);
                                                    if($to_user > 0){
                                                    $emailInfo = array(
                                                                'FROM_USER'         => $this->adminID,
                                                                'FROM_TYPE'         => 'Hpp',
                                                                'TO_USER'           => $to_user,
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
                                                                        'FROM_USER'         => $this->adminID,
                                                                        'FROM_TYPE_D'       => 'Hpp',
                                                                        'TO_USER'           => $to_user,
                                                                        'MESSAGE_TITLE'     => substr(strip_tags($replay), 0, 30),
                                                                        'MESSAGE_DATA'      => htmlspecialchars($replay),
                                                                        'ENT_DATE'          => date('Y-m-d'),
                                                                        'ENT_DATE_TIME'     => date('Y-m-d h:i:s'),
                                                                        'SMS_DET_STATUS'    => 'Active'
                                                                );
                                                                if($this->db->insert( 'sms_contact_agent_user_details', $emailDetails )){
                                                                        $lastID = $this->db->insert_id();

                                                                        redirect(SITE_URL . 'hpp/admin/email_inbox?search=sent&view-email=view&scau='.$lastIDM.'&scaud='.$lastID);
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
                $this->hpp_order 	= 'DESC';

                $data['main_content']   = $this->load->view('page_templates/dashboard/company/message/admin-email-board', $data, true);
//            } else {
//                $data['title'] = 'Don\'t have permission | HPP';
//                $data['main_content'] = $this->load->view('errors/errors_page', $data, true);
//             }
        } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        $this->load->view('admin_master', $data);
    }
    
    
    public function email_inbox_super() {
        $data = array();
        $session_data = array();
        $data['title'] = 'Admin Email Inbox | HPP';
        $data['select_page'] = 'email_inbox';
        $data['composeMSG'] = ''; 
        $data['composeEmail'] = ''; 

        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
            $data['user_menu']      = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            $search = isset($_GET['search']) ? $_GET['search'] : 'inbox';
            $search_array = array();

            $GetEmailView = isset( $_GET['view-email'] ) ? $_GET['view-email'] : 'see';
            $Getscau = isset( $_GET['scau'] ) ? $_GET['scau'] : 0;
            $Getscaud = isset( $_GET['scaud'] ) ? $_GET['scaud'] : 0;
            $apply = isset( $_GET['apply'] ) ? $_GET['apply'] : '';


            /*Code for view email / replay / forward*/
            if( $GetEmailView == 'view' && $Getscau > 0){ 
                    $dataEdit = array( 'SEEN_TYPE_HPP' => 'view');
                    $this->db->update( 'sms_contact_agent_user', $dataEdit , array('CONTACT_AGENT_ID' => $Getscau, 'TO_USER' => $this->adminID, 'TO_TYPE' => 'Hpp' ));

                    if(isset($_POST['contact_replay_message'])){
                            $replay = trim($this->input->post('message_replay'));
                            if(strlen($replay) > 2){
                                $massageDetailsShow =  $this->any_where(array('CONTACT_AGENT_ID' => $Getscau), 'sms_contact_agent_user');
                                if(sizeof($massageDetailsShow) > 0){
                                    if($massageDetailsShow[0]['FROM_USER'] == $this->adminID AND $massageDetailsShow[0]['FROM_TYPE'] == 'Hpp'){
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
                                            if($to_user > 0 AND $to_user != $this->adminID){
                                                    $emailInfo = array(
                                                        'FROM_USER'         => $this->adminID,
                                                        'FROM_TYPE'         => 'Hpp',
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
                                                'FROM_USER'         => $this->adminID,
                                                'FROM_TYPE_D'         => 'Hpp',
                                                'TO_USER'           => $to_user,
                                                'TO_TYPE_D'           => $to_type,
                                                'MESSAGE_TITLE'     => substr(strip_tags($replay), 0, 30),
                                                'MESSAGE_DATA'      => htmlspecialchars($replay),
                                                'ENT_DATE'          => date('Y-m-d'),
                                                'ENT_DATE_TIME' 	=> date('Y-m-d h:i:s'),
                                                'SMS_DET_STATUS' 	=> 'Active'
                                        );
                                        if($this->db->insert( 'sms_contact_agent_user_details', $emailDetails )){
                                            $lastID = $this->db->insert_id();

                                            $this->MailerModel->sendEmail($composeEmail, substr(strip_tags($replay), 0, 30), $replay);

                                            $dataEditReplay = array( 'SEEN_TYPE' => 'show', 'ENT_DATE_TIME' => date("Y-m-d h:i:s") );
                                            $this->db->update( 'sms_contact_agent_user', $dataEditReplay , array('CONTACT_AGENT_ID' => $Getscau));

                                            redirect(SITE_URL . 'hpp/admin/email_inbox?search='.$search.'&view_email=view&scau='.$Getscau.'&scaud='.$lastID);
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
                    $search_array['TO_USER'] = $this->adminID;
                    $search_array['TO_TYPE'] = 'Hpp';
                    
                } else if ($search == 'sent') {
                    $search_array['FROM_USER'] = $this->adminID;
                    $search_array['FROM_TYPE'] = 'Hpp';
                } else if ($search == 'email') {
                    $search_array['TO_USER'] = $this->adminID;
                    $search_array['TO_TYPE'] = 'Hpp';
                    $search_array['SMS_TYPE'] = 'Email';
                } else if ($search == 'property') {
                    $search_array['TO_USER'] = $this->adminID;
                    $search_array['TO_TYPE'] = 'Hpp';
                    $search_array['PROPERTY_ID !='] = '0';
                    $search_array['SMS_TYPE'] = 'Property';
                }else{
                    $search_array['TO_USER'] = $this->adminID;
                    $search_array['TO_TYPE'] = 'Hpp';
                }
                $search_array['SMS_TYPE']   = 'Email';
                $search_array['SMS_STATUS'] = 'Send';

                $queryAllCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS all_cunt FROM sms_contact_agent_user WHERE (((TO_USER = '$this->adminID' AND TO_TYPE = 'Hpp') OR (FROM_USER = '$this->adminID' AND FROM_TYPE = 'Hpp')) OR ( TO_USER = '0' OR FROM_USER = '0' )) AND SMS_TYPE = 'Email' AND SMS_STATUS = 'Send' AND SEEN_TYPE_HPP = 'show'");
                $count_all= $queryAllCount->result();	
                $data['ALL_COUNT'] = $count_all[0]->all_cunt;

                $queryInboxCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS ALL_COUNT_INbox FROM sms_contact_agent_user WHERE TO_USER = '$this->adminID' AND TO_TYPE = 'Hpp' AND SMS_TYPE = 'Email' AND SMS_STATUS = 'Send' AND SEEN_TYPE_HPP = 'show'");
                $count_inbox= $queryInboxCount->result();	
                $data['ALL_COUNT_INbox'] = $count_inbox[0]->ALL_COUNT_INbox;

                $querySendCount = $this->db->query("SELECT COUNT(CONTACT_AGENT_ID) AS ALL_COUNT_SEND FROM sms_contact_agent_user WHERE FROM_USER = '$this->adminID' AND FROM_TYPE = 'Hpp' AND SMS_TYPE = 'Email' AND SMS_STATUS = 'Send' AND SEEN_TYPE_HPP = 'show'");
                $count_send= $querySendCount->result();	
                $data['ALL_COUNT_SEND'] = $count_send[0]->ALL_COUNT_SEND;
                //echo $data['ALL_COUNT_INbox'];

                if($search == 'all'){
                    $queryAll = $this->db->query("SELECT * FROM sms_contact_agent_user WHERE (((TO_USER = '$this->adminID' AND TO_TYPE = 'Hpp') OR (FROM_USER = '$this->adminID' AND FROM_TYPE = 'Hpp')) OR ( TO_USER = '0' OR FROM_USER = '0' )) AND SMS_STATUS = 'Send' AND SMS_TYPE = 'Email' ORDER BY ENT_DATE_TIME DESC");
                    $data['massage_list'] = $queryAll->result_array();
//                    echo '<pre>'; print_r($data['massage_list']);
                }else{
                    $data['massage_list']   = $this->any_where($search_array, 'sms_contact_agent_user');
                }

                $composeAll = $this->db->query("SELECT distinct(FROM_USER), TO_USER FROM sms_contact_agent_user WHERE ((TO_USER = '$this->adminID' AND TO_TYPE = 'Hpp') OR (FROM_USER = '$this->adminID' AND  FROM_TYPE = 'Hpp')) AND SMS_STATUS = 'Send' AND SMS_TYPE = 'Email' AND FROM_USER > 0 ORDER BY ENT_DATE_TIME DESC");
                $data['compose_email_list'] = $composeAll->result_array();

                /*Code for compose email*/

                if($search == 'compose'){
                    $data['composeEmail'] = ''; $data['composeSubject'] = '';
                    if(isset($_POST['compose_form'])){
                    $composeEmail = trim($this->input->post('compose_email'));
                    $compose_subject = trim($this->input->post('compose_subject'));
                            if(strlen($composeEmail) > 5){
                                    if(strlen($compose_subject) > 0){
                                            $replay = trim($this->input->post('compose_data'));
                                            if(strlen(strip_tags($replay)) > 2)	{
                                                    $to_user = $this->user->select_user_mailBY_id($composeEmail);
                                                    if($to_user > 0  AND $to_user != $this->adminID){
                                                    $emailInfo = array(
                                                                'FROM_USER'         => $this->adminID,
                                                                'FROM_TYPE'         => 'Hpp',
                                                                'TO_USER'           => $to_user,
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
                                                                        'FROM_USER'         => $this->adminID,
                                                                        'FROM_TYPE_D'       => 'Hpp',
                                                                        'TO_USER'           => $to_user,
                                                                        'MESSAGE_TITLE'     => substr(strip_tags($replay), 0, 30),
                                                                        'MESSAGE_DATA'      => htmlspecialchars($replay),
                                                                        'ENT_DATE'          => date('Y-m-d'),
                                                                        'ENT_DATE_TIME'     => date('Y-m-d h:i:s'),
                                                                        'SMS_DET_STATUS'    => 'Active'
                                                                );
                                                                if($this->db->insert( 'sms_contact_agent_user_details', $emailDetails )){
                                                                        $lastID = $this->db->insert_id();

                                                                        redirect(SITE_URL . 'hpp/admin/email_inbox?search=sent&view-email=view&scau='.$lastIDM.'&scaud='.$lastID);
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
                $this->hpp_order 	= 'DESC';

                $data['main_content']   = $this->load->view('page_templates/dashboard/company/message/admin-email-board', $data, true);
//            } else {
//                $data['title'] = 'Don\'t have permission | HPP';
//                $data['main_content'] = $this->load->view('errors/errors_page', $data, true);
//             }
        } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        $this->load->view('admin_master', $data);
    }
    
    /*
     * add_news
     * Developed ON 16-03-2018
     */
    public function add_news()
    {
        $data = array();
        $data['title'] = 'Add News | HPP';
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            $data['select_page']  = 'add_news';
            $data['user_menu']    = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            
            /*------Start Save News Section-------*/
            if( isset( $_POST['AddNews'] ) ){
                $insertNews = array();
                $insertNews['NEWS_HEADDING']  = $this->input->post('news_title');
                $insertNews['NEWS_DETAILS']  = $this->input->post('news_description');
                /*-- Image Upload --*/
                $upload_path = 'images/news/' . $this->conpanyID . '/' . $this->adminID . '/' . date("Y") . '/' . date("m") . '/';
                if( !is_dir( $upload_path ) ){
                    mkdir($upload_path, 0777, TRUE );
                }
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'gif|jpg|png|tiff|tif|pdf';
                $config['max_size'] = '50000000000';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $error = '';
                $fdata = array();
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('news_image')) {
                    $error = $this->upload->display_errors();
                    echo $error;
                    exit();
                } else {
                    $fdata = $this->upload->data();
                    $insertNews['news_image'] = $config['upload_path'] . $fdata['file_name'];
                }
                
                $newsUrl = strtolower( substr( str_replace(' ', '-', $insertNews['NEWS_HEADDING'] ), 0, 50 ) );
                $insertNews['NEWS_URL']          = $newsUrl.time();;
                $insertNews['AUTHOR_NAME']       = $this->adminName;
                $insertNews['AUTHOR_SUB_TITLE']  = $this->adminType;
                $insertNews['ENT_USER']          = $this->adminID;
                $insertNews['COMPANY_ID']        = $this->conpanyID;
                $insertNews['ENT_DATE']          = date("Y-m-d H:i:s");
                $insertNews['NEWS_STATUS']       = 'Pending';
                $sdata = array();
                if($this->db->insert('blog_property_news', $insertNews )){
                    $sdata['message'] = 'News Information Save SuccessFully..!';
                    $this->session->set_userdata( $sdata );
                }  else {
                    $sdata['message'] = 'News Information Dose\'t Save ..!';
                    $this->session->set_userdata( $sdata );
                }
                
            }
            /*------End Save News Section-------*/

            $data['main_content'] = $this->load->view( 'page_templates/dashboard/company/add-news', $data, TRUE );
            $this->load->view( 'admin_master', $data );
        }else {
            redirect(SITE_URL.'hpp/Admin','refresh');
        }
    }
    
    /*
     * manage_news
     * Developed ON 16-03-2018
     */
    public function manage_news()
    {
        $data = array();
        $data['title'] = 'Manage News | HPP';
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            $data['select_page']    = 'manage_news';
            $data['user_menu']      = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);

            $search = isset($_GET['search']) ? $_GET['search'] : 'all';
            $data['select_news']    = $this->Hpp_Admin_Model->select_all_news();
            $data['main_content']   = $this->load->view( 'page_templates/dashboard/company/manage-news', $data, TRUE );
            $this->load->view( 'admin_master', $data );
        }else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
    }
    
    public function news_preview(){
        $data                   = array();
        $blog                   = isset($_GET['blog']) ? $_GET['blog'] : '';
        $data['title']          = 'Approve News | HPP';
        $single_blog            = $this->db->query( "SELECT * FROM blog_property_news WHERE NEWS_URL = '$blog' AND NEWS_STATUS != 'Delete'" );
        $data['single_blog']    = $single_blog->result();
        $data['main_content']   = $this->load->view( 'page_templates/dashboard/company/blog-details', $data, true );
        $this->load->view('admin_master', $data);
    } 
    
	
	  public function new_ads()
    {
        $data = array();
        $data['title'] = 'New Ads | HPP';
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            $data['select_page']  = 'new_ads';
            $data['user_menu']    = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            
            /*------Start Save News Section-------*/
            if( isset( $_POST['AddNews'] ) ){
                $insertNews = array();
                $insertNews['ADS_TITLE']  = $this->input->post('news_title');
                $insertNews['DESCRIPTION']  = $this->input->post('news_description');
                /*-- Image Upload --*/
                $upload_path = 'images/ads/' . $this->conpanyID . '/' . $this->adminID . '/' . date("Y") . '/' . date("m") . '/';
                if( !is_dir( $upload_path ) ){
                    mkdir($upload_path, 0777, TRUE );
                }
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'gif|jpg|png|tiff|tif|pdf';
                $config['max_size'] = '50000000000';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $error = '';
                $fdata = array();
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('news_image')) {
                    $error = $this->upload->display_errors();
                    echo $error;
                    exit();
                } else {
                    $fdata = $this->upload->data();
                    $insertNews['ADS_IMAGE'] = $config['upload_path'] . $fdata['file_name'];
                }
                
				
				$config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'gif|jpg|png|tiff|tif|pdf';
                $config['max_size'] = '50000000000';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $error = '';
                $fdata = array();
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('logo_image')) {
                    $error = $this->upload->display_errors();
                    echo $error;
                    exit();
                } else {
                    $fdata = $this->upload->data();
                    $insertNews['LOGO_IMAGE'] = $config['upload_path'] . $fdata['file_name'];
                }
				
                $insertNews['PHONE_NUM']          = $this->input->post('phone_no');
                $insertNews['WEB_URL']          = $this->input->post('web_url');
                $insertNews['DURATION']          = 10;
                $insertNews['LOCATION']          = $this->input->post('location');
                $insertNews['POSITION']          = $this->input->post('position');
                $insertNews['START_DATE']        = $this->input->post('start_date');
				
                $bidTime = $this->input->post( 'offer_end_date' );
				$dateType = $this->input->post( 'dateType' );
				
				$insertNews['END_DATE_ADS']        = $this->modify_date_time( $insertNews['START_DATE'], $bidTime, $dateType );
               
                $insertNews['ENT_DATE']          = date("Y-m-d H:i:s");
                $insertNews['STATUS']       = 'Active';
                $sdata = array();
                if($this->db->insert('ads_hpp', $insertNews )){
                    $sdata['message'] = 'New Ads Save SuccessFully..!';
                    $this->session->set_userdata( $sdata );
                }  else {
                    $sdata['message'] = 'New Ads  Dose\'t Save ..!';
                    $this->session->set_userdata( $sdata );
                }
                
            }
            /*------End Save News Section-------*/

			$queryData = $this->db->query("SELECT * FROM ads_hpp WHERE STATUS = 'Active' ORDER BY ADS_ID DESC");
			$data['ads_show'] = $queryData->result_array();
			//print_r($data['ads_show']);
			
            $data['main_content'] = $this->load->view( 'page_templates/dashboard/company/new_ads', $data, TRUE );
            $this->load->view( 'admin_master', $data );
        }else {
            redirect(SITE_URL.'hpp/Admin','refresh');
        }
    }
	
   public function active_news_by_id($nID)
    {
       if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            if($this->db->update( 'blog_property_news',array('NEWS_STATUS' => 'Active' ), array( 'NEWS_ID' => $nID ) ) ){
                $sdata['message'] = 'News Successfully Actived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_news','refresh');
            }else{
                $sdata['message'] = 'User don\'t Actived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_news','refresh');
            }
       } else {
           redirect(SITE_URL.'hpp/Admin', 'refresh');
       }
    }
    
   public function deactive_news_by_id($nID)
    {
       if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            if($this->db->update('blog_property_news',array( 'NEWS_STATUS' => 'Pending' ), array( 'NEWS_ID' => $nID ) ) ){
                $sdata['message'] = 'News Successfully DeActived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_news','refresh');
            }else{
                $sdata['message'] = 'User don\'t DeActived..!';
                $this->session->set_userdata($sdata);
                redirect('hpp/admin/manage_news','refresh');
            }
       } else {
           redirect(SITE_URL.'hpp/Admin', 'refresh');
       }
    }
    
   public function edit_news($nID)
    {
//       $nID = $this->input->get('nID');
       $data = array();
        $data['title'] = 'Edit News | HPP';
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            $data['select_page']    = 'manage_news';
            $data['user_menu']      = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            
            $data['single_news']    = $this->Hpp_Admin_Model->select_news_by_id($nID);
            /*---- Start Edit News  ---*/
            if( isset( $_POST['EditNews'] ) ){
                $insertNews = array();
                $insertNews['NEWS_HEADDING']  = $this->input->post('news_title');
                $insertNews['NEWS_DETAILS']  = $this->input->post('news_description');
                /*-- Image Upload --*/
                $upload_path = 'images/news/' . $this->conpanyID . '/' . $this->adminID . '/' . date("Y") . '/' . date("m") . '/';
                if( !is_dir( $upload_path ) ){
                    mkdir($upload_path, 0777, TRUE );
                }
                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'gif|jpg|png|tiff|tif|pdf';
                $config['max_size'] = '50000000000';
                $config['max_width'] = '';
                $config['max_height'] = '';
                $error = '';
                $fdata = array();
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('news_image')) {
                    $fdata = $this->upload->data();
                    $insertNews['news_image'] = $config['upload_path'] . $fdata['file_name'];
                } else {
                    $get_image = $this->Hpp_Admin_Model->select_news_by_id($nID);
                    $insertNews['news_image'] = $get_image->NEWS_IMAGE;
                }
                
                $newsUrl = strtolower( substr( str_replace(' ', '-', $insertNews['NEWS_HEADDING'] ), 0, 50 ) );
                $insertNews['NEWS_URL']          = $newsUrl.time();
                $insertNews['AUTHOR_NAME']       = $this->adminName;
                $insertNews['AUTHOR_SUB_TITLE']  = $this->adminType;
                $insertNews['ENT_USER']          = $this->adminID;
                $insertNews['COMPANY_ID']        = $this->conpanyID;
                $insertNews['ENT_DATE']          = date("Y-m-d H:i:s");
                $sdata = array();
                if($this->db->update('blog_property_news', $insertNews, array( 'NEWS_ID' => $nID ) )){
                    $sdata['message'] = 'News Information Update SuccessFully..!';
                    $this->session->set_userdata( $sdata );
                }  else {
                    $sdata['message'] = 'News Information Dose\'t Updated ..!';
                    $this->session->set_userdata( $sdata );
                }
                redirect( SITE_URL.'hpp/admin/manage_news','refresh' );
            }/*---- End Edit News  ---*/

            $search = isset($_GET['search']) ? $_GET['search'] : 'all';
            $data['main_content']   = $this->load->view( 'page_templates/dashboard/company/edit-news', $data, TRUE );
            $this->load->view( 'admin_master', $data );
        }else {
            redirect(SITE_URL.'hpp/Admin', 'refresh');
        }
       
    }
    
   public function delete_news_by_id($nID)
    {
       if( $this->adminID > 0 && $this->logged_admin ){
        if($this->db->update('blog_property_news', array( 'NEWS_STATUS' => 'Delete' ), array( 'NEWS_ID' => $nID ) ) ){
            $sdata['message'] = 'News Successfully Deleted..!';
            $this->session->set_userdata($sdata);
            redirect('hpp/admin/manage_news','refresh');
        }else{
            $sdata['message'] = 'User don\'t Deleted..!';
            $this->session->set_userdata($sdata);
            redirect('hpp/admin/manage_news','refresh');
        } 
       } else {
           redirect(SITE_URL.'hpp/Admin', 'refresh');
       }
    }
    
    /*
     * add_fqa 
     * Developed On 19-03-2018
     */
    public function add_fqa(){
        $data = array();
        $data['title'] = 'FQA | HPP';
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            $data['select_page']    = 'add_fqa';
            $data['user_menu']      = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            
            /*----Start Save FQA Content ---*/
            if( isset( $_POST['AddFQA'] ) ){
                $insertFqa = array(
                    'FQA_QUESTION'  => $this->input->post( 'fqa_question' ),
                    'FQA_ANWSER'    => htmlspecialchars($this->input->post( 'fqa_answer' )),
                    'COMPANY_ID'    => $this->conpanyID,
                    'ADMIN_ID'      => $this->adminID,
                    'END_DATE'      => date("Y-m-d H:i:s"),
                    'FQA_STATUS'    => 'Active',
                );
                
                if( $this->db->insert( 'fqa_content', $insertFqa )){
                    $sdata = array(
                        'message'   => 'Information Save SuccessFully..!',
                    );
                    $this->session->set_userdata($sdata);
                }else{
                    $sdata = array(
                        'message'   => 'Information Dose\'t Save..!!',
                    );
                    $this->session->set_userdata($sdata);
                }
//                redirect(SITE_URL . 'hpp/admin/add_fqa', 'refresh');
            }
            /*----End Save FQA Content ---*/
            
            /*--- Start FQA Action Section --*/
            $getAction = $this->input->get('action');
            $getFqaId = $this->input->get('fqaId');
            
            if( $getAction == 'active' ){
                if( $this->db->update( 'fqa_content', array( 'FQA_STATUS' => 'Active' ), array( 'FQA_ID' => $getFqaId ) ) ){
                   $sdata['message'] = 'FQA Information Activted Successfully..!'; 
                   $this->session->set_userdata($sdata);
                }else{
                   $sdata['message'] = 'FQA Information Dose\'t Activted..!'; 
                   $this->session->set_userdata($sdata);
                }
            }
            
            if( $getAction == 'deActive' ){
                if( $this->db->update( 'fqa_content', array( 'FQA_STATUS' => 'DeActive' ), array( 'FQA_ID' => $getFqaId ) ) ){
                   $sdata['message'] = 'FQA Information De-Actived Successfully..!'; 
                   $this->session->set_userdata($sdata);
                }else{
                   $sdata['message'] = 'FQA Information Dose\'t De-Actived..!'; 
                   $this->session->set_userdata($sdata);
                }
            }
            
            if( $getAction == 'Delete' ){
                if( $this->db->update( 'fqa_content', array( 'FQA_STATUS' => 'Delete' ), array( 'FQA_ID' => $getFqaId ) ) ){
                   $sdata['message'] = 'FQA Information Deleted Successfully..!'; 
                   $this->session->set_userdata($sdata);
                }else{
                   $sdata['message'] = 'FQA Information Dose\'t Deleted..!'; 
                   $this->session->set_userdata($sdata);
                }
            }
            /*--- End FQA Action Section --*/
            
            $fqa = $this->db->query("SELECT * FROM fqa_content WHERE FQA_STATUS != 'Delete'");
            $data['select_all_fqa'] = $fqa->result();
            $data['main_content']    = $this->load->view( 'page_templates/dashboard/company/add-fqa', $data, TRUE ); 
            $this->load->view( 'admin_master', $data );
        } else{
           redirect(SITE_URL.'hpp/Admin', 'refresh'); 
        }
        
   }
   
   
   /*
    * add_terms
    * Developed On 19-03-2018
    */
   public function add_terms()
    {
       $data = array();
       $data['title']    = 'TERMS | HPP';
       if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            $data['select_page']    = 'add_terms';
            $data['user_menu']      = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            
            /*----Start Save FQA Content ---*/
            if( isset( $_POST['AddTerms'] ) ){
                $insertTearm = array(
                    'TERMS_TITLE'   => $this->input->post( 'terms_title' ),
                    'TERMS_DETAILS' => htmlspecialchars($this->input->post( 'terms_details' )),
                    'COMPANY_ID'    => $this->conpanyID,
                    'ADMIN_ID'      => $this->adminID,
                    'END_DATE'      => date("Y-m-d H:i:s"),
                    'TERMS_STATUS'  => 'Active',
                );
                
                if( $this->db->insert( 'terms_content', $insertTearm )){
                    $sdata = array(
                        'message'   => 'Terms Information Save SuccessFully..!',
                    );
                    $this->session->set_userdata($sdata);
                }else{
                    $sdata = array(
                        'message'   => 'Terms Information Dose\'t Save..!!',
                    );
                    $this->session->set_userdata($sdata);
                }
//                redirect(SITE_URL . 'hpp/admin/add_fqa', 'refresh');
            }
            /*----End Save FQA Content ---*/
            
            /*--- Start FQA Action Section --*/
            $getAction = $this->input->get('action');
            $getTermId = $this->input->get('TId');
            
            if( $getAction == 'active' ){
                if( $this->db->update( 'terms_content', array( 'TERMS_STATUS' => 'Active' ), array( 'TERMS_ID' => $getTermId ) ) ){
                   $sdata['message'] = 'Terms Information Activted Successfully..!'; 
                   $this->session->set_userdata($sdata);
                }else{
                   $sdata['message'] = 'Terms Information Dose\'t Activted..!'; 
                   $this->session->set_userdata($sdata);
                }
            }
            
            if( $getAction == 'deActive' ){
                if( $this->db->update( 'terms_content', array( 'TERMS_STATUS' => 'DeActive' ), array( 'TERMS_ID' => $getTermId ) ) ){
                   $sdata['message'] = 'Terms Information De-Actived Successfully..!'; 
                   $this->session->set_userdata($sdata);
                }else{
                   $sdata['message'] = 'Terms Information Dose\'t De-Actived..!'; 
                   $this->session->set_userdata($sdata);
                }
            }
            
            if( $getAction == 'Delete' ){
                if( $this->db->update( 'terms_content', array( 'TERMS_STATUS' => 'Delete' ), array( 'TERMS_ID' => $getTermId) ) ){
                   $sdata['message'] = 'Terms Information Deleted Successfully..!'; 
                   $this->session->set_userdata($sdata);
                }else{
                   $sdata['message'] = 'Terms Information Dose\'t Deleted..!'; 
                   $this->session->set_userdata($sdata);
                }
            }
            /*--- End FQA Action Section --*/
            
            $terms = $this->db->query("SELECT * FROM terms_content WHERE TERMS_STATUS != 'Delete'");
            $data['select_all_terms'] = $terms->result();
            $data['main_content']    = $this->load->view( 'page_templates/dashboard/company/add-terms', $data, TRUE ); 
            $this->load->view( 'admin_master', $data );
        } else{
           redirect(SITE_URL.'hpp/Admin', 'refresh'); 
        }
    }
    

   /*
    * add_services
    * Developed On 19-03-2018
    */
   public function add_services()
    {
       $data = array();
       $data['title']    = 'SERVICES | HPP';
       if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            $data['select_page']    = 'add_services';
            $data['user_menu']      = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            
            /*----Start Save FQA Content ---*/
            if( isset( $_POST['AddService'] ) ){
                $insertTearm = array(
                    'SERVICE_TITLE'         => $this->input->post( 'service_title' ),
                    'SERVICE_SHORT_DESC'    => htmlspecialchars($this->input->post( 'service_short_desc' )),
                    'SERVICE_DETAILS'       => htmlspecialchars($this->input->post( 'service_details' )),
                    'COMPANY_ID'            => $this->conpanyID,
                    'ADMIN_ID'              => $this->adminID,
                    'END_DATE'              => date("Y-m-d H:i:s"),
                    'SERVICE_STATUS'        => 'Active',
                );
                
                if( $this->db->insert( 'service_content', $insertTearm )){
                    $sdata = array(
                        'message'   => 'Service Information Save SuccessFully..!',
                    );
                    $this->session->set_userdata($sdata);
                }else{
                    $sdata = array(
                        'message'   => 'Searvice Information Dose\'t Save..!!',
                    );
                    $this->session->set_userdata($sdata);
                }
//                redirect(SITE_URL . 'hpp/admin/add_fqa', 'refresh');
            }
            /*----End Save FQA Content ---*/
            
            /*--- Start FQA Action Section --*/
            $getAction = $this->input->get('action');
            $getServId = $this->input->get('SId');
            
            if( $getAction == 'active' ){
                if( $this->db->update( 'service_content', array( 'SERVICE_STATUS' => 'Active' ), array( 'SERVICE_ID' => $getServId ) ) ){
                   $sdata['message'] = 'Service Information Activted Successfully..!'; 
                   $this->session->set_userdata($sdata);
                }else{
                   $sdata['message'] = 'Service Information Dose\'t Activted..!'; 
                   $this->session->set_userdata($sdata);
                }
            }
            
            if( $getAction == 'deActive' ){
                if( $this->db->update( 'service_content', array( 'SERVICE_STATUS' => 'DeActive' ), array( 'SERVICE_ID' => $getServId ) ) ){
                   $sdata['message'] = 'Service Information De-Actived Successfully..!'; 
                   $this->session->set_userdata($sdata);
                }else{
                   $sdata['message'] = 'Service Information Dose\'t De-Actived..!'; 
                   $this->session->set_userdata($sdata);
                }
            }
            
            if( $getAction == 'Delete' ){
                if( $this->db->update( 'service_content', array( 'SERVICE_STATUS' => 'Delete' ), array( 'SERVICE_ID' => $getServId) ) ){
                   $sdata['message'] = 'Service Information Deleted Successfully..!'; 
                   $this->session->set_userdata($sdata);
                }else{
                   $sdata['message'] = 'Service Information Dose\'t Deleted..!'; 
                   $this->session->set_userdata($sdata);
                }
            }
            
            /*--- Edit Service --*/
            if( $getAction == 'Edit' ){
                $service = $this->db->query("SELECT * FROM service_content WHERE SERVICE_ID = '$getServId' AND SERVICE_STATUS != 'Delete'");
                $data['select_service'] = $service->row();
                
                if(isset($_POST['UpdateService'])){
                    $updateService = array(
                        'SERVICE_TITLE'         => $this->input->post( 'service_title' ),
                        'SERVICE_SHORT_DESC'    => htmlspecialchars($this->input->post( 'service_short_desc' )),
                        'SERVICE_DETAILS'       => htmlspecialchars($this->input->post( 'service_details' )),
                        'COMPANY_ID'            => $this->conpanyID,
                        'ADMIN_ID'              => $this->adminID,
                        'END_DATE'              => date("Y-m-d H:i:s"),
                        'SERVICE_STATUS'        => 'Active',
                    );
                    if ($this->db->update('service_content', $updateService, array( 'SERVICE_ID' => $getServId ) ) ) {
                        $sdata = array(
                            'message' => 'Service Information Updated SuccessFully..!',
                        );
                        $this->session->set_userdata($sdata);
                        redirect(SITE_URL.'hpp/Admin/add_services','refresh');
                    } else {
                        $sdata = array(
                            'message' => 'Searvice Information Dose\'t Updated..!!',
                        );
                        $this->session->set_userdata($sdata);
                    }
                }
            }
            /*--- End Edit Service --*/
            
            if( $getAction == 'Delete' ){
                if( $this->db->update( 'service_content', array( 'SERVICE_STATUS' => 'Delete' ), array( 'SERVICE_ID' => $getServId) ) ){
                   $sdata['message'] = 'Service Information Deleted Successfully..!'; 
                   $this->session->set_userdata($sdata);
                }else{
                   $sdata['message'] = 'Service Information Dose\'t Deleted..!'; 
                   $this->session->set_userdata($sdata);
                }
            }
            /*--- End FQA Action Section --*/
            
            $service = $this->db->query("SELECT * FROM service_content WHERE SERVICE_STATUS != 'Delete'");
            $data['select_all_service'] = $service->result();
            $data['main_content']       = $this->load->view( 'page_templates/dashboard/company/add-service', $data, TRUE ); 
            $this->load->view( 'admin_master', $data );
        } else{
           redirect(SITE_URL.'hpp/Admin', 'refresh'); 
        }
    }

	
	 public function file_uploader(){
        $data = array();
        $data['title'] = 'File Uploder | HPP';
        if( $this->adminID > 0 && $this->logged_admin == TRUE ){
            $data['select_page']    = 'add_fqa';
            $data['user_menu']      = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            $data['COUNTRYES'] 	   = $this->Property_Model->select_country('', '');
            /*----Start Save FQA Content ---*/
			$data['status'] = '';
			if(isset($_POST['save_file']))
			{ 
				require_once './DataUpload/PHPExcel.php';
				$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : '';
				
				if(strlen($country_id) > 1){
				
					$allowedExts = array("xls", "xlsx");
					$temp = explode('.', $_FILES['file_data']['name']);
					$extension = end($temp);
					/*
					if ((($extension == "xls")|| ($extension == "xlsx")) && in_array($extension, $allowedExts)) {
					  
						if ($_FILES["file_data"]["error"] > 0) {
							$data['status'] = 'Return Code: '. $_FILES["file_data"]["error"].'<br>';
						}else{
							 $data['status'] =  'Upload:  '.$_FILES["file_data"]["name"].' <br>
							 Type: '.$_FILES["file_data"]["type"].' <br>
							 Size:  '.($_FILES["file_data"]["size"] / 1024).'  kB<br>';
							 
							 $mass = 1;
							 
							move_uploaded_file($_FILES["file_data"]["tmp_name"], "upload_file/".$_FILES["file_data"]["name"]);
							$mass = 1;
							
						 }
					}else {
					  $data['status'] =  "Invalid file";
					  $mass =0;
					}
					*/
					
					if ((($extension == "xls")|| ($extension == "xlsx")) && in_array($extension, $allowedExts)) {
						
						$config = array();
						$config['upload_path'] = 'upload_file/';
						$config['allowed_types'] = 'xls|xlsx';
						$config['max_size'] = '500000000000';
						$config['max_width'] = '';
						$config['max_height'] = '';
						$error = '';
						$fdata = array();
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('file_data')) {
							$error = $this->upload->display_errors();
							echo $error;
							exit();
						} else {
							$fdata = $this->upload->data();
							$inputFileName = $config['upload_path'] . $fdata['file_name'];
							//echo $inputFileName;
							
							$inputFileName.PHP_EOL;
							$ext = substr($inputFileName, -4);
							///File type configuration
							if($extension=='xls')
								 $inputFileType = 'Excel5';
							if($extension== 'xlsx')
								 $inputFileType = 'Excel2007';
								
					  }
						
					  try{
						   ini_set('pcre.backtrack_limit', 10000);

							$objReader = PHPExcel_IOFactory::createReader($inputFileType);//
							$worksheetData = $objReader->listWorksheetInfo($inputFileName);//
							$objPHPExcel = $objReader->load($inputFileName);
							foreach ($worksheetData as $worksheet)
							{
								/**  Create a new Reader of the type defined in $inputFileType  **/
								$objReader = PHPExcel_IOFactory::createReader($inputFileType);
								/**  Advise the Reader of which WorkSheets we want to load  **/
								$objReader->setLoadSheetsOnly($worksheet['worksheetName']);
								/**  Load $inputFileName to a PHPExcel Object  **/
								$objPHPExcel = $objReader->load($inputFileName);

								$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
								$highestRow=$objPHPExcel->getActiveSheet()->getHighestRow('A');
								$highestcol=$objPHPExcel->getActiveSheet()->getHighestColumn(18);
								
								for($i=2; $i<=$highestRow; $i++)
								{
									
									//if((strcmp($sheetData[$i]['A'],''))&&(strcmp($sheetData[$i]['B'],''))!==0)
									if((strcmp($sheetData[$i]['A'],'')))
									{
										$org_name = '';
										for($j='A';$j<='A';$j++){                   
											$org_name = ($sheetData[$i][$j]); 					
										}
										
										$org_address = '';
										for($j='C';$j<='C';$j++){                   
											$org_address = ($sheetData[$i][$j]); 					
										}
										
										$org_location = '';
										for($j='D';$j<='D';$j++){                   
											$org_location = ($sheetData[$i][$j]); 					
										}
										
										$org_state = '';
										for($j='E';$j<='E';$j++){                   
											$org_state = ($sheetData[$i][$j]); 					
										}
										
										$org_post_code = '';
										for($j='F';$j<='F';$j++){                   
											$org_post_code = ($sheetData[$i][$j]); 					
										}
										
										
										$religion = '';
										for($j='K';$j<='K';$j++){                   
											$religion = ($sheetData[$i][$j]); 					
										}
										
										$phone = '';
										for($j='L';$j<='L';$j++){                   
											$phone = ($sheetData[$i][$j]); 					
										}
										
										$email = '';
										for($j='S';$j<='S';$j++){                   
											$email = ($sheetData[$i][$j]); 					
										}
										
										$website = '';
										for($j='AA';$j<='AA';$j++){                   
											$website = ($sheetData[$i][$j]); 					
										}
										
										$social = '';
										for($j='AB';$j<='AB';$j++){                   
											if(strlen($sheetData[$i][$j]) > 2){
												$social .= '<a href="'.$sheetData[$i][$j].'"> Twitter </a> &nbsp; &nbsp;';	
											}													
										}
										
										for($j='AC';$j<='AC';$j++){                   
											if(strlen($sheetData[$i][$j]) > 2){
												$social .= '<a href="'.$sheetData[$i][$j].'"> Facebook </a>  &nbsp; &nbsp; ';	
											}													
										}
										
										for($j='AD';$j<='AD';$j++){                   
											if(strlen($sheetData[$i][$j]) > 2){
												$social .= '<a href="'.$sheetData[$i][$j].'"> Google </a>  &nbsp; &nbsp; ';	
											}													
										}
										
										for($j='AE';$j<='AE';$j++){                   
											if(strlen($sheetData[$i][$j]) > 2){
												$social .= '<a href="'.$sheetData[$i][$j].'"> Linkedin </a>  &nbsp; &nbsp; ';	
											}													
										}
										
										$abn = '';
										for($j='AG';$j<='AG';$j++){                   
											$abn = ($sheetData[$i][$j]); 					
										}
										
										$details = '';
										for($j='AV';$j<='AV';$j++){                   
											$details = ($sheetData[$i][$j]); 					
										}
										
										$LATITUDE = '';
										for($j='BC';$j<='BC';$j++){                   
											$LATITUDE = ($sheetData[$i][$j]); 					
										}
										
										$LONGITUDE = '';
										for($j='BD';$j<='BD';$j++){                   
											$LONGITUDE = ($sheetData[$i][$j]); 					
										}
										
										$MAPLINK = '';
										for($j='BE';$j<='BE';$j++){                   
											$MAPLINK = ($sheetData[$i][$j]); 					
										}
										
										//echo $org_name.'<br/>';
										$checkOrg = $this->db->query('SELECT ORG_NAME FROM real_org_list WHERE ORG_NAME = "'.$org_name.'" AND COUNTRY = "'.$country_id.'"');
										$countOrg = $checkOrg->num_rows();
										if(strlen($org_name) > 3 AND $countOrg == 0){
											$insert = array();
											$insert['ORG_NAME'] = $org_name;
											$insert['ORG_ADDRESS'] = $org_address;
											$insert['ORG_LOCATION'] = $org_location;
											$insert['ORG_STATE'] = $org_state;
											$insert['ORG_POST_CODE'] = $org_post_code;
											$insert['RELIGION'] = $religion;
											$insert['COUNTRY'] = $country_id;
											$insert['PHONE'] = $phone;
											$insert['EMAIL'] = $email;
											$insert['WEBSITE'] = $website;
											$insert['SOCIAL_ADDRESS'] = $social;
											$insert['ABN_NUMBER'] = $abn;
											$insert['DETAILS'] = $details;
											$insert['ORG_STATUS'] = 'Active';
											$this->db->insert('real_org_list', $insert);
											
										}
									}
								}
							} /**end first foreach loop**/
							//exit;
							$data['status'] =  "Successfully uploaded";
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
						}
					}else{
						$data['status'] =  "Invalid file";
					}
				}else{
					$data['status'] =  "Please select country";
				}
			}
			
			
            $data['main_content']    = $this->load->view( 'page_templates/dashboard/company/file_uploader', $data, TRUE ); 
            $this->load->view( 'admin_master', $data );
        } else{
           redirect(SITE_URL.'hpp/Admin', 'refresh'); 
        }
        
   }
	
}/*--- End Admin --*/

?>