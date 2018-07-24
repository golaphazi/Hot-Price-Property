<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AgentControll extends HPP_Controller {
    
    public $userID , $logged_in , $userName, $adminName;
    public function __construct() {
        parent::__construct();
        $this->userID     = $this->session->userData('userID');
        $this->logged_in  = $this->session->userData('logged_in');
        $this->userName   = $this->session->userData('userName');
        $this->adminName   = $this->session->userData('adminName');
    }
	
	public function agentIndex(){
		$data = array();
		
		$id = isset($_GET['id']) ? $_GET['id'] : $this->adminName;
	    //echo $id;
		$data['title']          = 'Welcome Dashboard | HPP';
		$data['select_page']    = 'dashboard';
		$data['progile_id']     = $id;
		$data['MASG']     		= '';
		
		$data['userInfo'] 		= $this->user->select_user_profile_by_login($id);
		if(is_object($data['userInfo'] ) AND sizeof($data['userInfo'] ) > 0){
			
			$search = isset($_GET['search']) ? $_GET['search'] : 'all';
			$data['select_property_by_user']    = $this->Property_Model->select_all_property_by_user($search,$data['userInfo']->USER_ID);
			
			$data['contact_agent_type']		 = array('Name' => 'name_contact', 'Email' => 'email_address', 'Phone' => 'phone_no', 'Type of enquiry' => 'about_me', 'Message to' => 'message');
			
			if(isset($_POST['contact_agent_message'])){
				 
				$userID = $this->session->userData('userID');
				$logged_in = $this->session->userData('logged_in');
				if ($userID > 0 AND $logged_in == TRUE) {
					 $sms_agent = array();
					 $sms_agent['FROM_USER'] 		= $userID;
					 $sms_agent['TO_USER'] 	 		= $data['userInfo']->USER_ID;
					 $sms_agent['PROPERTY_ID'] 	 	= 0;
					 $sms_agent['COMPANY_ID'] 	 	= $this->conpanyID;
					 $sms_agent['ENT_DATE'] 	 	= date('Y-m-d');
					 $sms_agent['ENT_DATE_TIME'] 	= date('Y-m-d h:i:s');
					 $sms_agent['SMS_TYPE'] 		= 'Normal';
					 $sms_agent['SMS_STATUS'] 		= 'Send';
					 
					 if($this->db->insert('sms_contact_agent_user', $sms_agent)){
						 $sms_id = $this->db->insert_id();
						 
						 foreach($data['contact_agent_type'] AS $key=>$contact_agent){
							 $sms_agent_d = array();
							 
							 $sms_agent_d['CONTACT_AGENT_ID'] 	= $sms_id;
							 $sms_agent_d['COMPANY_ID'] 		= $this->conpanyID;
							 $sms_agent_d['MESSAGE_TITLE'] 		= $key;
							 $dataAgent							= $this->input->post($contact_agent);
							if(is_array($dataAgent) AND sizeof($dataAgent) > 0){	
								$join_data = '';
								foreach($dataAgent AS $valueAgent):
									if(strlen($valueAgent) > 1){
										$join_data .= $valueAgent.' __ ';
									}
								endforeach;
								$sms_agent_d['MESSAGE_DATA'] 		= rtrim($join_data, ' __ ');
								if(strlen($join_data) > 2){
									$this->db->insert('sms_contact_agent_user_details', $sms_agent_d);
								}
							}else{
								if(strlen($dataAgent) > 1){
									$sms_agent_d['MESSAGE_DATA'] 		= $dataAgent;
									$this->db->insert('sms_contact_agent_user_details', $sms_agent_d);
								}
							}
							 
							 
						 }
						$data['MASG'] = 'Successfully message send to seller';
					 }
					 
					
				}else {
					redirect(SITE_URL . 'login?page=agent?id='.$id.'&#contact_seller');
				}
				
			 }
			
			$data['main_content']   = $this->load->view('page_templates/dashboard/users/pages/agentProfile', $data, true);
		}else{
			 $data['main_content'] = $this->load->view('errors/errors_page', $data, true);
		}
        $this->load->view('master', $data);
	}
}