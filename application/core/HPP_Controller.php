<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class HPP_Controller extends CI_Controller {
    var $CI;
    public $hpp_select = '*';
    public $hpp_table = '';
    public $hpp_order_column = '';
    public $hpp_order = '';
    public $hpp_limit = '';
    public $hpp_offset = '';
    public $hpp_query = array();
	
    public $conpanyID = '0';
    public $account_for = '0';
    public $account_type = '0';
    
	public function __construct() {
       parent::__construct();
	   $newdata = array('companyID' => 1, 'account_for' => 3, 'account_type' => 1);
	   $this->session->set_userdata($newdata);
	   
	   $this->conpanyID = $this->session->userData('companyID');
	   $this->account_for = $this->session->userData('account_for');
	   $this->account_type = $this->session->userData('account_type');
           date_default_timezone_set('Etc/GMT' . '-6');
	   $this->hpp_query = $this->hpp_select = $this->hpp_table = $this->hpp_order_column = $this->hpp_limit = $this->hpp_offset = $this->hpp_order = $this->hpp_order_column = '';
    }

	public function company_info(){
            $this->hpp_select = '';
            return $this->any_where(array('COMPANY_ID' => $this->conpanyID), 'company', '');
	}
	
	public function company_header($type = NULL){
            $comInfo =  $this->company_info();
            $info = '';
            if(is_array($comInfo) AND sizeof($comInfo) > 0){
                if($type == 'fill'){
                    $info .= '<div class="col-xs-12 report-footer marY-30" style="font-style:normal;text-align:left;"> <span> <strong>'.$comInfo[0]['COMPANY_NAME'].', </strong> <br/></span>';
                    $info .= '<small><span><strong>Address :</strong> '.$comInfo[0]['COMPANY_ADDRESS'].'  </span> <br/>';
                    $info .= '<span><strong>Email : </strong>'.$comInfo[0]['COMPANY_EMAIL'].' </span>, ';
                    $info .= '<span><strong>Phone :</strong> '.$comInfo[0]['COMPNAY_PHONE'].' </span><br/>';
                    $info .= '<span><strong>Date :</strong> '.date("d M Y h:i A").' </span></small>';
                    $info .= '</div>';
                }else {
                    $info .= '<div style="font-style:normal;float:left;text-align:left;"> <span> <strong>'.$comInfo[0]['COMPANY_NAME'].', </strong> <br/></span>';
                    $info .= '<small><span><strong>Address :</strong> '.$comInfo[0]['COMPANY_ADDRESS'].'  </span> <br/>';
                    $info .= '<span><strong>Email : </strong>'.$comInfo[0]['COMPANY_EMAIL'].' </span>, ';
                    $info .= '<span><strong>Phone :</strong> '.$comInfo[0]['COMPNAY_PHONE'].' </span><br/>';
                    $info .= '<span><strong>Date :</strong> '.date("d M Y h:i A").' </span></small>';
                    $info .= '</div>';
                }
            }
            return $info;
	}

        public function hpp_role($query=array()){		
            $this->db->select($this->hpp_select);
            if(is_array($query) AND sizeof($query) > 0){
                $query['COMPANY_ID'] = $this->conpanyID;
                $this->hpp_query = $query;									
            }
            $this->hpp_table = 'mt_s_user_role';
            $this->db->where($this->hpp_query);
            if (strlen($this->hpp_order_column) > 2){
                $this->db->order_by($this->hpp_order_column, $this->hpp_order);
            }
        if ($this->hpp_limit > 0){
           $this->db->limit($this->hpp_limit, $this->hpp_offset);
        }
            $results = $this->db->get($this->hpp_table);
            $result = $results->result_array();
            return $result;
	}
	
	public function hpp_user_type($query=array()){
		
        $this->db->select($this->hpp_select);
        if(is_array($query) AND sizeof($query) > 0){
            $query['COMPANY_ID'] = $this->conpanyID;
            $this->hpp_query = $query;			
        }
        $this->hpp_table = 'mt_s_user_type';
        $this->db->where($this->hpp_query);
        if (strlen($this->hpp_order_column) > 2){
            $this->db->order_by($this->hpp_order_column, $this->hpp_order);
        }
    if ($this->hpp_limit > 0){
        $this->db->limit($this->hpp_limit, $this->hpp_offset);
    }
        $results = $this->db->get($this->hpp_table);
        $result = $results->result_array();
        return $result;
    }
	
    public function any_where($query=array(), $table='', $filed=''){
            if(strlen($table) > 2){
                    $this->hpp_table = $table;
            }

            if(strlen($this->hpp_select) > 2){
                    $this->db->select($this->hpp_select);
            }
            if(is_array($query) AND sizeof($query) > 0){
                    $query['COMPANY_ID'] = $this->conpanyID;
                    $this->hpp_query = $query;			
            }

            if (strlen($this->hpp_order_column) > 2){
        $this->db->order_by($this->hpp_order_column, $this->hpp_order);
    }

            if ($this->hpp_limit > 0){
        $this->db->limit($this->hpp_limit, $this->hpp_offset);
    }
            if(is_array($query) AND sizeof($query) > 0){
                    $this->db->where($this->hpp_query);
            }
            $results = $this->db->get($this->hpp_table)->result_array();
            if(strlen($filed) > 2){
                if(is_array($results) AND sizeof($results) > 0){
                    return $results[0][$filed];
                }else{
                    return '';
                }

            }else{
                    return $results;
            }
		
	}
	
	public function any_where_count($query=array(), $table='', $count=''){
		
            if(strlen($count) > 2){
                    $this->hpp_select = 'COUNT('.$count.') AS result';
                    $this->db->select($this->hpp_select);
            }
            if(strlen($table) > 2){
                    $this->hpp_table = $table;
            }
            if(is_array($query) AND sizeof($query) > 0){
                    $query['COMPANY_ID'] = $this->conpanyID;
                    $this->hpp_query = $query;			
            }
            $this->db->where($this->hpp_query);
            $results = $this->db->get($this->hpp_table)->result_array();
            return $results[0]['result'];
	}
	
	public function hpp_gender(){
            return array('Male' => 'Male', 'FeMale' => 'Female', 'Other' => 'Other');
	}
	
	public function hpp_url_check($page = '', $type = 'page') {

        $userType = $this->session->userData('userType');
        $roleId = $this->session->userData('roleId');
        $userID = $this->session->userData('userID');
        $access = $this->session->userData('access');
        $logged_in = $this->session->userData('logged_in');
        $search = '';
        if (strlen($page) > 0 AND $userID > 0 AND $logged_in == TRUE) {
            if ($type == 'nav') {
                $search = "SELECT * 
                                    FROM
                                        mt_nav_access AS page									
                                    INNER JOIN 
                                            mt_s_user_type AS type									
                                    ON 	page.USER_TYPE_ID = type.USER_TYPE_ID
                                    WHERE 	
                                        page.USER_TYPE_ID = " . $userType . "
                                        AND page.NAV_URL = '" . $page . "'
                                        AND page.NAV_STATUS = 'Active'
                                        AND page.COMPANY_ID = " . $this->conpanyID . "
                            ";
            } else {
                if ($access == 'Parent') {
                    $other_user_type = $this->user->any_where(array('TYPE_STATUS' => 'Active', 'TYPE_VIEW' => 'Other'), 'mt_s_user_type');
                    $otherTypeID = $other_user_type[0]['USER_TYPE_ID'];

                    $other_role_type = $this->user->any_where(array('ROLE_STATUS' => 'Active', 'ROLE_TYPE' => 'Other'), 'mt_s_user_role');
                    $otherRoleID = $other_role_type[0]['ROLE_ID'];
                    $search = "SELECT * 
                                        FROM
                                                        mt_pg_page_name AS page									
                                        INNER JOIN 
                                                        mt_s_user_type AS type									
                                        ON 		page.USER_TYPE_ID = type.USER_TYPE_ID
                                        INNER JOIN 
                                                        mt_s_user_role AS role									
                                        ON 		page.ROLE_ID = role.ROLE_ID
                                        WHERE 	
                                            (page.USER_TYPE_ID = " . $userType . "
                                            OR page.USER_TYPE_ID = " . $otherTypeID . ")
                                            AND (page.ROLE_ID = " . $roleId . "
                                            OR page.ROLE_ID = " . $otherRoleID . ")
                                            AND page.PAGE_URL = '" . $page . "'
                                            AND page.PAGE_STATUS = 'Active'
                                            AND page.COMPANY_ID = " . $this->conpanyID . "
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
                                        AND page.PAGE_URL = '" . $page . "'
                                        AND page.PAGE_STATUS = 'Active'
                                        AND access.ACCESS_STATUS = 'Active'
                                        AND access.USER_ID = " . $userID . "
                                ";
                }
            }

            $query = $this->db->query($search);
            $count = $query->num_rows();
            return $count;
        }
    }

    /*date convert method  -- for additional date*/
    public function modify_date_time($date, $days='0', $type='days'){
      $date = date_create($date);
            date_modify($date,"+$days $type");
            return date_format($date,"Y-m-d H:m");
    }

    public function modify_date($date, $days='0', $type='days'){
      $date = date_create($date);
            date_modify($date,"+$days $type");
            return date_format($date,"Y-m-d");
    }

/*--- 
    Trim Text
    Date : 23-02-2018
 --*/
    public function trim_text( $text , $limt = 200 )
    {
           $getText = strip_tags( $text). " ";
           $newText = substr( $getText, 0, $limt );
           $newText = substr( $getText, 0, strrpos( $newText, ' ' ) );
           return $newText . '...';
    }
     
     
        
         
}

?>