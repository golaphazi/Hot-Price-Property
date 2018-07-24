<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LoginControll extends HPP_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $data = array();
        $data['title'] = 'Login | HPP';
        $data['massege'] = '';
        $data['account_for'] = $this->account_for;
        $data['account_type'] = $this->account_type; 
        $data['full_name'] = '';
        $data['mobile_no'] = '';
        $data['gender'] = 'Male';
        $data['email_address'] = '';
        $data['rel_password'] = '';
        $data['con_password'] = '';

        $data['role'] = $this->hpp_role(['ROLE_TYPE' => 'User', 'ROLE_STATUS =' => 'Active']);
        $data['user_type'] = $this->hpp_user_type(['TYPE_STATUS =' => 'Active', 'TYPE_VIEW =' => 'Show']);

        if (isset($_POST['user_signup'])) {

            $insert = array();
            $insert_de = array();
            $insert_con = array();

            $insert['USER_NAME'] = $this->input->post('full_name');
            $insert['USER_LOG_NAME'] = substr( str_replace(" ", "_", $insert['USER_NAME']), 0,10).substr(time(), 4, 6);
            //$insert['USER_LOG_NAME'] = time();
            $insert['EMAIL_ADDRESS'] = $this->input->post('email_address');
            $insert['PASS_USER'] = md5($this->input->post('rel_password'));
            $insert['COMPANY_ID'] = $this->conpanyID;
            $insert['ROLE_ID'] = $this->input->post('account_for');
            $insert['USER_TYPE_ID'] = $this->input->post('account_type');
            $insert['ACCESS_TYPE'] = 'Parent';
            $insert['ENT_DATE'] = date("Y-m-d");
            $insert['USER_STATUS'] = 'Active';
           // $insert['USER_STATUS'] = 'Pending';

            //$login_check = $this->any_where_count(array('EMAIL_ADDRESS' => $this->input->post('email_address'), 'USER_TYPE_ID' => $this->input->post('account_type')), 's_user_info', 'EMAIL_ADDRESS');
            $login_check = $this->any_where_count(array('EMAIL_ADDRESS' => $this->input->post('email_address')), 's_user_info', 'EMAIL_ADDRESS');
            if ($login_check == 0) {
                if ($this->db->insert('s_user_info', $insert)) {
                    $userID_ge = $this->db->insert_id();
                    $this->hpp_select = '*';
					
                    $contactEmail = $this->any_where(array('CONTACT_NAME' => 'Contact Email', 'CONTAC_TYPE_TYPE' => 'Basic'), 'mt_c_contact_type');
                    if (is_array($contactEmail) AND sizeof($contactEmail) > 0) {
                        $insert_con_email['CONTACT_NAME'] 	= $this->input->post('email_address');
                        $insert_con_email['CONTACT_TYPE_ID'] 	= $contactEmail[0]['CONTACT_TYPE_ID'];
                        $insert_con_email['USER_ID'] 		= $userID_ge;
                        $insert_con_email['COMPANY_ID'] 	= $this->conpanyID;
                        $insert_con_email['ENT_DATE'] 		= date("Y-m-d");
                        $insert_con_email['CONTACT_STATUS'] 	= 'Active';
                        $this->db->insert('c_contact_info', $insert_con_email);
                    }
					
                    $contact = $this->any_where(array('CONTACT_NAME' => 'Mobile', 'CONTAC_TYPE_TYPE' => 'Basic'), 'mt_c_contact_type');
                    if (is_array($contact) AND sizeof($contact) > 0) {
                        $insert_con['CONTACT_NAME'] 	= $this->input->post('mobile_no');
                        $insert_con['CONTACT_TYPE_ID'] 	= $contact[0]['CONTACT_TYPE_ID'];
                        $insert_con['USER_ID'] 			= $userID_ge;
                        $insert_con['COMPANY_ID'] 		= $this->conpanyID;
                        $insert_con['ENT_DATE'] 		= date("Y-m-d");
                        $insert_con['CONTACT_STATUS'] 	= 'Active';
                        $this->db->insert('c_contact_info', $insert_con);
                    }

                    $insert_de['FULL_NAME'] 	= $this->input->post('full_name');
                        if( $insert['ROLE_ID'] == 4 ){
                            $insert_de['AGENT_LICENSE']    = $this->input->post( 'agent_license' );
                            $insert_de['AGENT_ABN_NUMBER'] = $this->input->post( 'agent_abn_number' );
                        }
                    $insert_de['GENTER']    = $this->input->post('gender');
                    if($insert_de['GENTER'] == 'Male'){
                    $insert_de['PROFILE_IMAGE'] 	= 'images/blank_male.jpg';
                    }else{
                        $insert_de['PROFILE_IMAGE'] 	= 'images/blank_female.jpg';
                    }
                    $insert_de['USER_ID'] 			= $userID_ge;
                    $insert_de['COMPANY_ID'] 		= $this->conpanyID;
                    $insert_de['ENT_DATE'] 			= date("Y-m-d");
                    $insert_de['DETAILS_STATUS'] 	= 'Active';
                    if ($this->db->insert('s_user_details_info', $insert_de)) {
                        $data['massege'] = '<span class="success">Successfully create your account</span>';
                        $newdata = array(
                                    'userID' => $userID_ge,
                                    'adminName' => $insert['USER_LOG_NAME'],
                                    'userName' => $insert['USER_NAME'],
                                    'userType' => $insert['USER_TYPE_ID'],
                                    'roleId' => $insert['ROLE_ID'],
                                    'access' => $insert['ACCESS_TYPE'],
                                    'logged_in' => TRUE
                                );
                    $this->session->set_userdata($newdata);
                    redirect(SITE_URL . 'profile');
                    } else {
                        $data['massege'] = '<span class="error">System Error</span>';
                    }
                }
            } else {
                $data['massege'] = '<span class="error">Sorry! already have a account</span>';
            }

            $data['account_for'] = $insert['ROLE_ID'];
            $data['account_type'] = $insert['USER_TYPE_ID'];
            $data['full_name'] = $insert['USER_NAME'];
            $data['mobile_no'] = $this->input->post('mobile_no');
            $data['gender'] = $this->input->post('gender');
            $data['email_address'] = $insert['EMAIL_ADDRESS'];
            $data['rel_password'] = $this->input->post('rel_password');
            $data['con_password'] = $this->input->post('con_password');
        }
        $page = isset($_GET['page']) ? $_GET['page'] : 'profile';
        $page = str_replace('$$', '&#', $page);
		$page = str_replace(';;', '&', $page);
		
        $data['MSG'] = '';
        $data['ACTION'] = $page;
        if (isset($_POST['user_login'])) {
            $username = $this->input->post('login_email');
            $password = md5($this->input->post('login_password'));
            //$account_login = $this->input->post('account_login');

            if (strlen($username) > 0 AND strlen($password) > 0) {
                $query = $this->db->query("SELECT * FROM s_user_info as user LEFT JOIN s_user_details_info as per ON user.USER_ID = per.USER_ID WHERE (user.USER_LOG_NAME = '" . addslashes($username) . "' OR user.EMAIL_ADDRESS = '" . addslashes($username) . "') AND user.PASS_USER = '" . $password . "'");
                //$query = $this->db->query("SELECT * FROM s_user_info as user LEFT JOIN s_user_details_info as per ON user.USER_ID = per.USER_ID WHERE (user.USER_LOG_NAME = '" . addslashes($username) . "' OR user.EMAIL_ADDRESS = '" . addslashes($username) . "') AND user.PASS_USER = '" . $password . "' AND user.USER_TYPE_ID = $account_login");
                $count = $query->num_rows();
                if ($count == 1) {
                    $userData = $query->row();
                    if ($userData->USER_STATUS == 'Active') {
                        if (isset($userData)) {
                            $newdata = array(
                                'userID' => $userData->USER_ID,
                                'adminName' => $userData->USER_LOG_NAME,
                                'userName' => $userData->USER_NAME,
                                'userType' => $userData->USER_TYPE_ID,
                                'roleId' => $userData->ROLE_ID,
                                'access' => $userData->ACCESS_TYPE,
                                'logged_in' => TRUE
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


        $userID = $this->session->userData('userID');
        $logged_in = $this->session->userData('logged_in');

        if ($userID > 0 AND $logged_in == TRUE) {
            
            redirect(SITE_URL . $page);

            $data['main_content'] = $this->load->view('page_templates/dashboard/users/user_home', $data, true);
        } else {
            $data['main_content'] = $this->load->view('page_templates/userLogin/users/login', $data, true);
        }

        /** Query for account type* */



        $this->load->view('master', $data);
    }

    /* user regiatration logout */

    public function logoutIndex() {
        $this->session->sess_destroy();
        redirect(SITE_URL . '');
    }

     public function adminIndex(){
            $adminID = $this->session->userData('adminID');
            if($adminID > 0){
                $this->db->update('admin_access' , array('LOG_STATUS' => 'Offline'), array('ADMIN_ID' => $adminID));
            }
            $this->session->sess_destroy();

            redirect(SITE_URL.'hpp/admin');			
	}
    /* user regiatration method */
       
        
    /*
     * forgot_password()
     * This methodes Recovery Password user password by user valid email id
     * Developed On 23-03-2018
     */
    public function forgot_password()
    {
        $data = array();
        $data['title'] = 'Recovery Password | HPP';
        $data['emailErr'] = '';
        $data['SMS'] = '';
        
        /*--Start For Got password --*/
        if( isset( $_POST['forGotPassword'] ) ){
            $getEmail = $this->input->post('login_email');
            if (!filter_var( $getEmail, FILTER_VALIDATE_EMAIL ) ) {
                $data['emailErr'] = "Invalid email address..!";
            }else {
                $query = $this->db->query( "SELECT * FROM s_user_info WHERE EMAIL_ADDRESS = '$getEmail' AND USER_STATUS = 'Active'" );
                $count = $query->num_rows();
                if( $count == 1 ){
                    $getUser    = $query->row();
                    $userID     = $getUser->USER_ID;
                    $userName   = $getUser->USER_NAME;
                    $newText = strtoupper( substr($getEmail, 0, 4 ) );
                    $random_string = chr(rand(60,90)) . chr(rand(50,60)) . chr(rand(65,70)) . chr(rand(70,100)) . chr(rand(85, 95));
                    $password = $newText.$random_string;
                    $newpassword = md5($password);
                    $update = array(
                        'PASS_USER' => $newpassword,
                        'ENT_DATE'  => date("Y-m-d H:i:s"),
                    );
                    if( $this->db->update( 's_user_info', $update, array( 'USER_ID' => $userID ) ) ){
                        $to = $getEmail;
                        $from     = 'support@hotpriceproperty.com';
                       
                        $subject = 'Password Recovery';
                        $message = 'Your User Name is : '.$userName.' and New Password is: <b>'.$password.'</b> , Please Click the following link : '. SITE_URL.'login' .' for Login..';
                        //$sendmail = mail( $to, $subject, $message, $headers );
                        
                        $sdata = array();
                        if($this->MailerModel->sendEmail($to, $subject, $message, $from)){
                            $sdata['message'] = 'Your password has been successfully recovered, Please Check Your Email for login details..!';
                            $this->session->set_userdata($sdata);
                            redirect(SITE_URL.'login');
                        }else{
                            $sdata['message'] = 'Email Dose\t Send , Please try again your valid email or create a new account..!';
                            $this->session->set_userdata($sdata);
                            redirect(SITE_URL.'forgot-password');  
                        }
                    }else{
                       $data['SMS'] = '<span style="color:red;">This Email Address Dose\'t Exist..!</span>'; 
                    }
                }else{
                    $data['SMS'] = '<span style="color:red;">This Email Address Dose\'t Exist..!</span>';
                }
            }
        }
        /*--End For Got password --*/
        
        $data['main_content'] = $this->load->view('page_templates/userLogin/users/forgot-password',$data,TRUE);
        $this->load->view('master',$data);
    }

        
}
