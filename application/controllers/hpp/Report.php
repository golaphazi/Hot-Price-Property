<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * AdminReportControll
 * To Contain Admin's All Report..
 */

class Report extends HPP_Controller {
    
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
    
    public function hpp_type_report($defult = 'all', $array = array('Hot Price' => 'hot_price', 'Auction' => 'auction', 'Sell' => 'sell', 'Rent' => 'rent')) {
        $seatch = '';
        if (is_array($array) AND sizeof($array) > 0) {
            $seatch .= '<select id="type_search" name="type_search" class="form-control" >
					<option class="bs-title-option" value="all">All</option>';
            foreach ($array AS $key => $value) {
                if ($defult == $value) {
                    $seatch .= '<option value="' . $value . '" selected>' . $key . '</option>';
                } else {
                    $seatch .= '<option value="' . $value . '">' . $key . '</option>';
                }
            }
            $seatch .= ' </select>';
        }
        return $seatch;
    }
    
    public function list_of_property() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
           
            $data['title'] = 'List of property Report | HPP';

            $data['select_page'] = 'list_of_property';
            $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);

              $data['select_all_seller'] = $this->Hpp_Admin_Model->select_all_seller_by_type(1);
              //print_r($data['select_all_seller']);
                
            if($pdfOption == 'Yes'){
                $data['fromdate'] = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                $data['todate'] = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                $type_search = isset($_GET['type_search']) ? $_GET['type_search'] : 'all';
                $data['user_type_id']   = isset($_GET['user_type']) ? $_GET['user_type'] : '0';
            }else{
                $data['fromdate'] = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                $data['todate'] = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                $type_search = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
                $data['user_type_id']   = isset($_POST['user_type']) ? $_POST['user_type'] : '0';
            }

            $data['search_type'] = $this->hpp_type_report($type_search);
            $where = '';
            if ($type_search == 'hot_price') {
                $data['type_search'] = 'Hot Price';
                $where = " AND HOT_PRICE_PROPERTY = 'Yes'";
            } else if ($type_search == 'auction') {
                $data['type_search'] = 'Auction';
                $where = " AND PROPERTY_AUCTION = 'Yes'";
            } else if ($type_search == 'sell') {
                $data['type_search'] = 'Sell';
                $where = " AND PRO_CATEGORY_ID = '1'";
            } else if ($type_search == 'rent') {
                $data['type_search'] = 'Rent';
                $where = " AND PRO_CATEGORY_ID = '2'";
            } else {
                $data['type_search'] = 'All';
                $where = '';
            }
            $user_search = ''; 
            if($data['user_type_id'] > 0){
                $user_search = 'AND USER_ID = "'.$data['user_type_id'].'"';
            }
            $data['company_info'] = $this->company_header();

            $fromDate = date("Y-m-d", strtotime($data['fromdate']));
            $toDate = date("Y-m-d", strtotime($data['todate']));

            $reportQuery = $this->db->query("SELECT *	
                                                    FROM 
                                                        view_property_list 
                                                    WHERE
                                                        (ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                        $where $user_search
                                                    ORDER BY ENT_DATE DESC
                                            ");
            $data['sellreport'] = $reportQuery->result_array();

			$reportQueryDis = $this->db->query("SELECT distinct(viewl.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            view_property_list AS viewl
                                                            INNER JOIN mt_countries AS count ON viewl.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            (viewl.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            $where $user_search
                                                        ORDER BY viewl.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
			
            if($pdfOption == 'Yes'){
                $html = $this->load->view('page_templates/dashboard/company/reports/admin_list_of_property', $data, true);
                $this->load->helper('dompdf');
                $file_name = pdf_create($html,'all_property_list'.time("H:i:s"),true);
            } else{
                $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_list_of_property', $data, true);
            }

        } else {
        redirect(SITE_URL . 'hpp/admin/?page=home_admin');
    }
    
    if($pdfOption == 'No'){
       $this->load->view('admin_master', $data);
    }
}


    public function reject_property_list() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
            
            $data['title'] = 'List of property Report | HPP';

            $data['select_page'] = 'reject_property_list';
            $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            $data['select_all_seller'] = $this->Hpp_Admin_Model->select_all_seller_by_type(1);


            if($pdfOption == 'Yes'){
                $data['fromdate'] = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                $data['todate'] = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                $type_search = isset($_GET['type_search']) ? $_GET['type_search'] : 'all';
                $data['user_type_id'] = isset($_GET['user_type']) ? $_GET['user_type'] : '0';
            }else{
                $data['fromdate']       = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                $data['todate']         = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                $type_search            = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
                $data['user_type_id']   = isset($_POST['user_type']) ? $_POST['user_type'] : '0';
            }

            $data['search_type'] = $this->hpp_type_report($type_search);
            $where = '';
             if($type_search == 'hot_price'){
                $data['type_search'] = 'Hot Price';
                $where = " AND basic.HOT_PRICE_PROPERTY = 'Yes' AND offer.OFFER_STATUS = 'Reject'";
            }else if($type_search == 'auction'){
                $data['type_search'] = 'Auction';
                $where = " AND basic.PROPERTY_AUCTION = 'Yes' AND offer.OFFER_STATUS = 'Reject'";
            }else if($type_search == 'sell'){
                $data['type_search'] = 'Sell';
                $where = " AND basic.PRO_CATEGORY_ID = '1' AND basic.PROPERTY_STATUS = 'Reject'";
            }else if($type_search == 'rent'){
                $data['type_search'] = 'Rent';
                $where = " AND basic.PRO_CATEGORY_ID = '2' AND basic.PROPERTY_STATUS = 'Reject'";
            }else{
                $data['type_search'] = 'All';
                $where = "AND basic.PROPERTY_STATUS = 'Reject'";
            }

            $data['company_info'] = $this->company_header();

            $fromDate = date("Y-m-d", strtotime($data['fromdate']));
            $toDate = date("Y-m-d", strtotime($data['todate']));
            $user_search = '';
            if($data['user_type_id'] > 0){
                $user_search = 'AND basic.USER_ID = "'.$data['user_type_id'].'"';
            }

            $reportQuery = $this->db->query("SELECT 
                                                    basic.PROPERTY_ID,	
                                                    basic.PROPERTY_NAME,	
                                                    basic.PRO_CATEGORY_ID,	
                                                    basic.PROPERTY_TYPE_ID,	
                                                    basic.PROPERTY_STREET_NO,	
                                                    basic.PROPERTY_STREET_ADDRESS,	
                                                    basic.PROPERTY_CITY,	
                                                    basic.PROPERTY_STATE,	
                                                    basic.PROPERTY_COUNTRY,	
                                                    basic.PROPERTY_WONERSHIP,	
                                                    basic.PROPERTY_PRICE,	
                                                    basic.PROPERTY_AUCTION,	
                                                    basic.HOT_PRICE_PROPERTY,	
                                                    basic.USER_ID,	
                                                    basic.SELL_USER,	
                                                    basic.SELL_PRICE,	
                                                    basic.SELL_DATE,	
                                                    basic.ENT_DATE,	
                                                    basic.PROPERTY_STATUS,
                                                    basic.CURRENCY_SAMPLE,

                                                    offer.OFFER_PRICE,
                                                    offer.BIDDING_WIN_PRICE,
                                                    offer.OFFER_TYPE,
                                                    offer.OFFER_START_DATE,
                                                    offer.OFFER_END_DATE,
                                                    offer.ENT_DATE AS OFFER_ENT_DATE,
                                                    offer.OFFER_STATUS,
                                                    
                                                    ptype.PROPERTY_TYPE_NAME
                                                    
                                                FROM 
                                                    p_property_basic as basic
                                                LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
                                                LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID  
                                                WHERE
                                                    (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                    $where $user_search
                                                ORDER BY basic.ENT_DATE DESC
                                            ");
                $data['sellreport'] = $reportQuery->result_array();
                
				$reportQueryDis = $this->db->query("SELECT distinct(basic.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            p_property_basic as basic
                                                            LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
															LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID                                                  
															INNER JOIN mt_countries AS count ON basic.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            $where $user_search
                                                        ORDER BY basic.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
                if($pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_reject_property_list', $data, true);
                    $this->load->helper('dompdf');
                    $file_name = pdf_create($html,'reject_property_list'.time("H:i:s"),true);
                    //echo $file_name;
                } else {
                    $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_reject_property_list', $data, true);
                }
            } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('admin_master', $data);
        }
    }
    
    public function delete_property_list() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
           
                $data['title'] = 'Reject Property Report | HPP';

                $data['select_page'] = 'delete_property_list';
                $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
                $data['select_all_seller'] = $this->Hpp_Admin_Model->select_all_seller_by_type(1);
                
                if( $pdfOption == 'Yes' ){
                    $data['fromdate']       = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                    $data['todate']         = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                    $type_search            = isset($_GET['type_search']) ? $_GET['type_search'] : 'all';
                    $data['user_type_id']   = isset($_GET['user_type']) ? $_GET['user_type'] : '0';
                } else {
                    $data['fromdate']       = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                    $data['todate']         = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                    $type_search            = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
                    $data['user_type_id']   = isset($_POST['user_type']) ? $_POST['user_type'] : '0';
                }
                
                $data['search_type'] = $this->hpp_type_report($type_search);
                $where = '';
                 if($type_search == 'hot_price'){
                    $data['type_search'] = 'Hot Price';
                    $where = " AND basic.HOT_PRICE_PROPERTY = 'Yes' AND offer.OFFER_STATUS = 'Delete'";
                }else if($type_search == 'auction'){
                    $data['type_search'] = 'Auction';
                    $where = " AND basic.PROPERTY_AUCTION = 'Yes' AND offer.OFFER_STATUS = 'Delete'";
                }else if($type_search == 'sell'){
                    $data['type_search'] = 'Sell';
                    $where = " AND basic.PRO_CATEGORY_ID = '1' AND basic.PROPERTY_STATUS = 'Delete'";
                }else if($type_search == 'rent'){
                    $data['type_search'] = 'Rent';
                    $where = " AND basic.PRO_CATEGORY_ID = '2' AND basic.PROPERTY_STATUS = 'Delete'";
                }else{
                    $data['type_search'] = 'All';
                    $where = "AND basic.PROPERTY_STATUS = 'Delete'";
                }

                $data['company_info'] = $this->company_header();

                $fromDate = date("Y-m-d", strtotime($data['fromdate']));
                $toDate = date("Y-m-d", strtotime($data['todate']));
                $user_search = '';
                if($data['user_type_id'] > 0){
                    $user_search = 'AND basic.USER_ID = "'.$data['user_type_id'].'"';
                }

                $reportQuery = $this->db->query("SELECT 
                                                        basic.PROPERTY_ID,	
                                                        basic.PROPERTY_NAME,	
                                                        basic.PRO_CATEGORY_ID,	
                                                        basic.PROPERTY_TYPE_ID,	
                                                        basic.PROPERTY_STREET_NO,	
                                                        basic.PROPERTY_STREET_ADDRESS,	
                                                        basic.PROPERTY_CITY,	
                                                        basic.PROPERTY_STATE,	
                                                        basic.PROPERTY_COUNTRY,	
                                                        basic.PROPERTY_WONERSHIP,	
                                                        basic.PROPERTY_PRICE,	
                                                        basic.PROPERTY_AUCTION,	
                                                        basic.HOT_PRICE_PROPERTY,	
                                                        basic.USER_ID,	
                                                        basic.SELL_USER,	
                                                        basic.SELL_PRICE,	
                                                        basic.SELL_DATE,	
                                                        basic.ENT_DATE,	
                                                        basic.PROPERTY_STATUS,
                                                        basic.CURRENCY_SAMPLE,
                                                        
                                                        offer.OFFER_PRICE,
                                                        offer.BIDDING_WIN_PRICE,
                                                        offer.OFFER_TYPE,
                                                        offer.OFFER_START_DATE,
                                                        offer.OFFER_END_DATE,
                                                        offer.ENT_DATE AS OFFER_ENT_DATE,
                                                        offer.OFFER_STATUS,
                                                        
                                                        ptype.PROPERTY_TYPE_NAME
                                                    FROM 
                                                        p_property_basic as basic
                                                    LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
                                                    LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID
                                                    WHERE
                                                        (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                        $where $user_search
                                                    ORDER BY basic.ENT_DATE DESC
                                                ");
                $data['sellreport'] = $reportQuery->result_array();
				
				
				$reportQueryDis = $this->db->query("SELECT distinct(basic.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            p_property_basic as basic
                                                            LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
															LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID                                                  
															INNER JOIN mt_countries AS count ON basic.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            $where $user_search
                                                        ORDER BY basic.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_delete_property_list', $data, true);
                    $this->load->helper('dompdf');
                    $create_file = pdf_create($html,'delete-property-list'.time("H:i:s"),TRUE);
                }else{
                    $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_delete_property_list', $data, true);
                }
            } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('admin_master', $data);
        }
    }
    
    
    public function sold_out_property_list() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
           
            $data['title'] = 'Sold Out Property Report | HPP';

            $data['select_page'] = 'sold_out_property_list';
            $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            $data['select_all_seller'] = $this->Hpp_Admin_Model->select_all_seller_by_type(1);

            if( $pdfOption == 'Yes' ){
                $data['fromdate']       = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                $data['todate']         = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                $type_search            = isset($_GET['type_search']) ? $_GET['type_search'] : 'all';
                $data['user_type_id']   = isset($_POST['user_type']) ? $_POST['user_type'] : '0';
            } else {
                $data['fromdate']       = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                $data['todate']         = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                $type_search            = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
                $data['user_type_id']   = isset($_POST['user_type']) ? $_POST['user_type'] : '0';
            }

            $data['search_type'] = $this->hpp_type_report($type_search);
            $where = '';
             if($type_search == 'hot_price'){
                $data['type_search'] = 'Hot Price';
                $where = " AND basic.HOT_PRICE_PROPERTY = 'Yes' AND offer.OFFER_STATUS = 'Win'";
            }else if($type_search == 'auction'){
                $data['type_search'] = 'Auction';
                $where = " AND basic.PROPERTY_AUCTION = 'Yes' AND offer.OFFER_STATUS = 'Win'";
            }else if($type_search == 'sell'){
                $data['type_search'] = 'Sell';
                $where = " AND basic.PRO_CATEGORY_ID = '1' AND basic.PROPERTY_STATUS = 'Sell'";
            }else if($type_search == 'rent'){
                $data['type_search'] = 'Rent';
                $where = " AND basic.PRO_CATEGORY_ID = '2' AND basic.PROPERTY_STATUS = 'Sell'";
            }else{
                $data['type_search'] = 'All';
                $where = "AND basic.PROPERTY_STATUS = 'Sell'";
            }

            $data['company_info'] = $this->company_header();

            $fromDate = date("Y-m-d", strtotime($data['fromdate']));
            $toDate = date("Y-m-d", strtotime($data['todate']));
            $user_search = '';
            if($data['user_type_id'] > 0 ){
                $user_search = 'AND basic.USER_ID = "'.$data['user_type_id'].'"';
            }

            $reportQuery = $this->db->query("SELECT 
                                                    basic.PROPERTY_ID,	
                                                    basic.PROPERTY_NAME,	
                                                    basic.PRO_CATEGORY_ID,	
                                                    basic.PROPERTY_TYPE_ID,	
                                                    basic.PROPERTY_STREET_NO,	
                                                    basic.PROPERTY_STREET_ADDRESS,	
                                                    basic.PROPERTY_CITY,	
                                                    basic.PROPERTY_STATE,	
                                                    basic.PROPERTY_COUNTRY,	
                                                    basic.PROPERTY_WONERSHIP,	
                                                    basic.PROPERTY_PRICE,	
                                                    basic.PROPERTY_AUCTION,	
                                                    basic.HOT_PRICE_PROPERTY,	
                                                    basic.USER_ID,	
                                                    basic.SELL_USER,	
                                                    basic.SELL_PRICE,	
                                                    basic.SELL_DATE,	
                                                    basic.ENT_DATE,	
                                                    basic.PROPERTY_STATUS,
                                                    basic.CURRENCY_SAMPLE,

                                                    offer.OFFER_PRICE,
                                                    offer.BIDDING_WIN_PRICE,
                                                    offer.OFFER_TYPE,
                                                    offer.OFFER_START_DATE,
                                                    offer.OFFER_END_DATE,
                                                    offer.ENT_DATE AS OFFER_ENT_DATE,
                                                    offer.OFFER_STATUS,
                                                    
                                                    ptype.PROPERTY_TYPE_NAME
                                                FROM 
                                                    p_property_basic as basic
                                                LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID
                                                LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID
                                                WHERE
                                                    (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                    $where $user_search
                                                ORDER BY basic.ENT_DATE DESC
                                            ");
                $data['sellreport'] = $reportQuery->result_array();
				
				$reportQueryDis = $this->db->query("SELECT distinct(basic.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            p_property_basic as basic
                                                            LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
															LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID                                                  
															INNER JOIN mt_countries AS count ON basic.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            $where $user_search
                                                        ORDER BY basic.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_sold_out_property_list', $data, true);
                    $this->load->helper('dompdf');
                    $create_file = pdf_create($html,'sold-out-property'.time("H:i:s"),TRUE);
                } else {
                    $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_sold_out_property_list', $data, true);
                }
            } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        if($pdfOption == 'No' ){
        $this->load->view('admin_master', $data);
        }
    }
    
    
    public function active_property_list() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
           
                $data['title'] = 'Active Property Report | HPP';

                $data['select_page'] = 'active_property_list';
                $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
                $data['select_all_seller'] = $this->Hpp_Admin_Model->select_all_seller_by_type(1);

                if( $pdfOption == 'Yes' ){
                    $data['fromdate']       = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                    $data['todate']         = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                    $type_search            = isset($_GET['type_search']) ? $_GET['type_search'] : 'all'; 
                    $data['user_type_id']   = isset($_GET['user_type']) ? $_GET['user_type'] : '0';
                } else {
                    $data['fromdate']       = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                    $data['todate']         = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                    $type_search            = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
                    $data['user_type_id']   = isset($_POST['user_type']) ? $_POST['user_type'] : '0';
                }
                
                $data['search_type'] = $this->hpp_type_report($type_search);
                $where = '';
                 if($type_search == 'hot_price'){
                    $data['type_search'] = 'Hot Price';
                    $where = " AND basic.HOT_PRICE_PROPERTY = 'Yes' AND offer.OFFER_STATUS = 'Active'";
                }else if($type_search == 'auction'){
                    $data['type_search'] = 'Auction';
                    $where = " AND basic.PROPERTY_AUCTION = 'Yes' AND offer.OFFER_STATUS = 'Active'";
                }else if($type_search == 'sell'){
                    $data['type_search'] = 'Sell';
                    $where = " AND basic.PRO_CATEGORY_ID = '1' AND basic.PROPERTY_STATUS = 'Active'";
                }else if($type_search == 'rent'){
                    $data['type_search'] = 'Rent';
                    $where = " AND basic.PRO_CATEGORY_ID = '2' AND basic.PROPERTY_STATUS = 'Active'";
                }else{
                    $data['type_search'] = 'All';
                    $where = "AND basic.PROPERTY_STATUS = 'Active'";
                }
                
                $data['company_info'] = $this->company_header();
                $fromDate = date("Y-m-d", strtotime($data['fromdate']));
                $toDate = date("Y-m-d", strtotime($data['todate']));
                $user_search = ''; 
                if($data['user_type_id'] > 0){
                    $user_search = 'AND basic.USER_ID = "'.$data['user_type_id'].'"';
                }

                $reportQuery = $this->db->query("SELECT 
                                                        basic.PROPERTY_ID,	
                                                        basic.PROPERTY_NAME,	
                                                        basic.PRO_CATEGORY_ID,	
                                                        basic.PROPERTY_TYPE_ID,	
                                                        basic.PROPERTY_STREET_NO,	
                                                        basic.PROPERTY_STREET_ADDRESS,	
                                                        basic.PROPERTY_CITY,	
                                                        basic.PROPERTY_STATE,	
                                                        basic.PROPERTY_COUNTRY,	
                                                        basic.PROPERTY_WONERSHIP,	
                                                        basic.PROPERTY_PRICE,	
                                                        basic.PROPERTY_AUCTION,	
                                                        basic.HOT_PRICE_PROPERTY,	
                                                        basic.USER_ID,	
                                                        basic.SELL_USER,	
                                                        basic.SELL_PRICE,	
                                                        basic.SELL_DATE,	
                                                        basic.ENT_DATE,	
                                                        basic.PROPERTY_STATUS,
                                                        basic.CURRENCY_SAMPLE,
                                                        
                                                        offer.OFFER_PRICE,
                                                        offer.BIDDING_WIN_PRICE,
                                                        offer.OFFER_TYPE,
                                                        offer.OFFER_START_DATE,
                                                        offer.OFFER_END_DATE,
                                                        offer.ENT_DATE AS OFFER_ENT_DATE,
                                                        offer.OFFER_STATUS,
                                                        
                                                        ptype.PROPERTY_TYPE_NAME
                                                    FROM 
                                                        p_property_basic as basic
                                                    LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID   
                                                    LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID   
                                                    WHERE
                                                        (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                        $where $user_search
                                                    ORDER BY basic.ENT_DATE DESC
                                                ");
                $data['sellreport'] = $reportQuery->result_array();
				
				$reportQueryDis = $this->db->query("SELECT distinct(basic.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            p_property_basic as basic
                                                            LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
															LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID                                                  
															INNER JOIN mt_countries AS count ON basic.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            $where $user_search
                                                        ORDER BY basic.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_active_property_list', $data, true);
                    $this->load->helper('dompdf');
                    $create_file = pdf_create($html,'active-property-list'.  time("H:i:s"),TRUE);
                } else {
                    $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_active_property_list', $data, true);
                }
                
            } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('admin_master', $data);
        }
    }
    
    public function auction_win_property_list() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
           
        $data['title'] = 'Active Property Report | HPP';

        $data['select_page'] = 'auction_win_property_list';
        $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
        $data['select_all_seller'] = $this->Hpp_Admin_Model->select_all_seller_by_type(1);

        if($pdfOption == 'Yes' ){
            $data['fromdate']       = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
            $data['todate']         = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
            $data['user_type_id']   = isset($_GET['user_type']) ? $_GET['user_type'] : '0';
        } else {
            $data['fromdate']       = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
            $data['todate']         = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
            $data['user_type_id']   = isset($_POST['user_type']) ? $_POST['user_type'] : '0';
        }

        $where = '';
        $where = " AND basic.PROPERTY_AUCTION = 'Yes' AND offer.OFFER_STATUS = 'Win'";

        $data['company_info'] = $this->company_header();

        $fromDate = date("Y-m-d", strtotime($data['fromdate']));
        $toDate = date("Y-m-d", strtotime($data['todate']));
        $user_search = '';
        if($data['user_type_id'] > 0 ){
            $user_search = ' AND basic.USER_ID = "'.$data['user_type_id'].'"';
        }

        $reportQuery = $this->db->query("SELECT 
                                                basic.PROPERTY_ID,	
                                                basic.PROPERTY_NAME,	
                                                basic.PRO_CATEGORY_ID,	
                                                basic.PROPERTY_TYPE_ID,	
                                                basic.PROPERTY_STREET_NO,	
                                                basic.PROPERTY_STREET_ADDRESS,	
                                                basic.PROPERTY_CITY,	
                                                basic.PROPERTY_STATE,	
                                                basic.PROPERTY_COUNTRY,	
                                                basic.PROPERTY_WONERSHIP,	
                                                basic.PROPERTY_PRICE,	
                                                basic.PROPERTY_AUCTION,	
                                                basic.HOT_PRICE_PROPERTY,	
                                                basic.USER_ID,	
                                                basic.SELL_USER,	
                                                basic.SELL_PRICE,	
                                                basic.SELL_DATE,	
                                                basic.ENT_DATE,	
                                                basic.PROPERTY_STATUS,
                                                basic.CURRENCY_SAMPLE,

                                                offer.OFFER_PRICE,
                                                offer.BIDDING_WIN_PRICE,
                                                offer.OFFER_TYPE,
                                                offer.OFFER_START_DATE,
                                                offer.OFFER_END_DATE,
                                                offer.ENT_DATE AS OFFER_ENT_DATE,
                                                offer.OFFER_STATUS,
                                                
                                                ptype.PROPERTY_TYPE_NAME
                                            FROM 
                                                p_property_basic as basic
                                            LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID   
                                            LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID 
                                            WHERE
                                                (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                $where $user_search
                                            ORDER BY basic.ENT_DATE DESC
                                        ");
                $data['sellreport'] = $reportQuery->result_array();
				
				$reportQueryDis = $this->db->query("SELECT distinct(basic.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            p_property_basic as basic
                                                            LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
															LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID                                                  
															INNER JOIN mt_countries AS count ON basic.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            $where $user_search
                                                        ORDER BY basic.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_auction_win_property_list', $data, true);
                    $this->load->helper('dompdf');
                    $create_file = pdf_create($html,'auction-win-property-list'.time("H:i:s"),TRUE);
                }else {
                    $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_auction_win_property_list', $data, true);
                }
            } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('admin_master', $data);
        }
    }
    
    
    public function date_over_property_list() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
           
            $data['title'] = 'Date Over Property Report | HPP';

            $data['select_page'] = 'date_over_property_list';
            $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
            $data['select_all_seller'] = $this->Hpp_Admin_Model->select_all_seller_by_type(1);

            if( $pdfOption == 'Yes' ){
                $data['fromdate']       = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                $data['todate']         = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                $type_search            = isset($_GET['type_search']) ? $_GET['type_search'] : 'all';
                $data['user_type_id']   = isset($_GET['user_type']) ? $_GET['user_type'] : '0';
            } else {
                $data['fromdate']       = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                $data['todate']         = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                $type_search            = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
                $data['user_type_id']   = isset($_POST['user_type']) ? $_POST['user_type'] : '0';
            }

            $to_date = date("Y-m-d H:i:s");
            $data['search_type'] = $this->hpp_type_report('',$array = array('Hot Price' => 'hot_price', 'Auction' => 'auction'));
            $where = '';

             if($type_search == 'hot_price'){
                $data['type_search'] = 'Hot Price';
                $where = " AND basic.HOT_PRICE_PROPERTY = 'Yes' AND offer.OFFER_STATUS = 'Active'";
            }else if($type_search == 'auction'){
                $data['type_search'] = 'Auction';
                $where = " AND basic.PROPERTY_AUCTION = 'Yes' AND offer.OFFER_STATUS = 'Active'";
            }else{
                $data['type_search'] = 'All';
                $where = "AND basic.PROPERTY_STATUS = 'Active'";
            }

            $data['company_info'] = $this->company_header();

            $fromDate = date("Y-m-d", strtotime($data['fromdate']));
            $toDate = date("Y-m-d", strtotime($data['todate']));
            $user_search = '';
            if( $data['user_type_id'] > 0 ){
                $user_search = 'AND basic.USER_ID = "'.$data['user_type_id'].'"';
            }

            $reportQuery = $this->db->query("SELECT 
                                                    basic.PROPERTY_ID,	
                                                    basic.PROPERTY_NAME,	
                                                    basic.PRO_CATEGORY_ID,	
                                                    basic.PROPERTY_TYPE_ID,	
                                                    basic.PROPERTY_STREET_NO,	
                                                    basic.PROPERTY_STREET_ADDRESS,	
                                                    basic.PROPERTY_CITY,	
                                                    basic.PROPERTY_STATE,	
                                                    basic.PROPERTY_COUNTRY,	
                                                    basic.PROPERTY_WONERSHIP,	
                                                    basic.PROPERTY_PRICE,	
                                                    basic.PROPERTY_AUCTION,	
                                                    basic.HOT_PRICE_PROPERTY,	
                                                    basic.USER_ID,	
                                                    basic.SELL_USER,	
                                                    basic.SELL_PRICE,	
                                                    basic.SELL_DATE,	
                                                    basic.ENT_DATE,	
                                                    basic.PROPERTY_STATUS,
                                                    basic.CURRENCY_SAMPLE,

                                                    offer.OFFER_PRICE,
                                                    offer.BIDDING_WIN_PRICE,
                                                    offer.OFFER_TYPE,
                                                    offer.OFFER_START_DATE,
                                                    offer.OFFER_END_DATE,
                                                    offer.ENT_DATE AS OFFER_ENT_DATE,
                                                    offer.OFFER_STATUS,
                                                    
                                                    ptype.PROPERTY_TYPE_NAME
                                                FROM 
                                                    p_property_basic as basic
                                                LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
                                                LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID
                                                WHERE
                                                    (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                    AND offer.OFFER_END_DATE < '$to_date' AND offer.OFFER_STATUS = 'Active'     
                                                    $where $user_search
                                                ORDER BY basic.ENT_DATE DESC
                                            ");
                $data['sellreport'] = $reportQuery->result_array();
				
				$reportQueryDis = $this->db->query("SELECT distinct(basic.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            p_property_basic as basic
                                                            LEFT JOIN p_property_offers AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
															LEFT JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID                                                  
															INNER JOIN mt_countries AS count ON basic.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
															AND offer.OFFER_END_DATE < '$to_date' AND offer.OFFER_STATUS = 'Active'                                                        
                                                            $where $user_search
                                                        ORDER BY basic.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_date_over_offer_property_list', $data, true);
                    $this->load->helper('dompdf');
                    $create_file = pdf_create($html,'date-over-offer-property'.time("H:i:s"),TRUE);
                } else {
                   $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_date_over_offer_property_list', $data, true); 
                }
            } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        if( $pdfOption == 'No' ){
        $this->load->view('admin_master', $data);
        }
    }
    
    
    public function re_auction_property_list() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
           
        $data['title'] = 'Re-Auction Property Report | HPP';

        $data['select_page'] = 're_auction_property_list';
        $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
        $data['select_all_seller'] = $this->Hpp_Admin_Model->select_all_seller_by_type(1);

        if($pdfOption == 'Yes' ){
            $data['fromdate']       = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
            $data['todate']         = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
            $data['user_type_id']   = isset($_GET['user_type']) ? $_GET['user_type'] : '0';
        } else {
            $data['fromdate']       = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
            $data['todate']         = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
            $data['user_type_id']   = isset($_POST['user_type']) ? $_POST['user_type'] : '0';
        }

        $where = '';
        $where = " AND basic.PROPERTY_AUCTION = 'Yes' AND offer.OFFER_STATUS != 'Delete'";

        $data['company_info'] = $this->company_header();

        $fromDate = date("Y-m-d", strtotime($data['fromdate']));
        $toDate = date("Y-m-d", strtotime($data['todate']));
        $user_search = '';
        if($data['user_type_id'] > 0 ){
            $user_search = ' AND basic.USER_ID = "'.$data['user_type_id'].'"';
        }

        $reportQuery = $this->db->query("SELECT 
                                                basic.PROPERTY_ID,	
                                                basic.PROPERTY_NAME,	
                                                basic.PRO_CATEGORY_ID,	
                                                basic.PROPERTY_TYPE_ID,	
                                                basic.PROPERTY_STREET_NO,	
                                                basic.PROPERTY_STREET_ADDRESS,	
                                                basic.PROPERTY_CITY,	
                                                basic.PROPERTY_STATE,	
                                                basic.PROPERTY_COUNTRY,	
                                                basic.PROPERTY_WONERSHIP,	
                                                basic.PROPERTY_PRICE,	
                                                basic.PROPERTY_AUCTION,	
                                                basic.HOT_PRICE_PROPERTY,	
                                                basic.USER_ID,	
                                                basic.SELL_USER,	
                                                basic.SELL_PRICE,	
                                                basic.SELL_DATE,	
                                                basic.ENT_DATE,	
                                                basic.PROPERTY_STATUS,
                                                basic.CURRENCY_SAMPLE,

                                                offer.OFFER_PRICE,
                                                offer.BIDDING_WIN_PRICE,
                                                offer.OFFER_TYPE,
                                                offer.OFFER_START_DATE,
                                                offer.OFFER_END_DATE,
                                                offer.ENT_DATE AS OFFER_ENT_DATE,
                                                offer.OFFER_STATUS,
                                                
                                                ptype.PROPERTY_TYPE_NAME
                                            FROM 
                                                p_property_basic as basic
                                            INNER JOIN re_offers_property AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
                                            INNER JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID
                                            WHERE
                                                (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                $where $user_search
                                            ORDER BY basic.ENT_DATE DESC
                                        ");
                $data['sellreport'] = $reportQuery->result_array();
				
				$reportQueryDis = $this->db->query("SELECT distinct(basic.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            p_property_basic as basic
                                                             INNER JOIN re_offers_property AS offer ON basic.PROPERTY_ID = offer.PROPERTY_ID  
															 INNER JOIN mt_p_property_type AS ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID                                                  
															 INNER JOIN mt_countries AS count ON basic.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            (basic.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
															$where $user_search
                                                        ORDER BY basic.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_re_auction_property_list', $data, true);
                    $this->load->helper('dompdf');
                    $create_file = pdf_create($html,'re-auction-property-list'.time("H:i:s"),TRUE);
                }else {
                    $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_re_auction_property_list', $data, true);
                }
            } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('admin_master', $data);
        }
    }
    
    public function ledger_report() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
           
                $data['title'] = 'Ledger Report | HPP';

                $data['select_page'] = 'ledger_report';
                $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);

                if( $pdfOption == 'Yes' ){
                    $data['fromdate']   = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                    $data['todate']     = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                }else{
                    $data['fromdate']   = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                    $data['todate']     = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d"); 
                }

                $data['company_info'] = $this->company_header();

                $fromDate = date("Y-m-d", strtotime($data['fromdate']));
                $toDate = date("Y-m-d", strtotime($data['todate']));

                $reportQuery = $this->db->query("SELECT *	
                                                        FROM 
                                                            view_property_sell 
                                                        WHERE 
                                                            (SELL_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                        ORDER BY SELL_DATE DESC
                                                ");;
                $data['ledger_report'] = $reportQuery->result_array();
                
                if($pdfOption == 'Yes' ){
                    
                }else{
                    $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/admin_ledger_report', $data, true);
                }
                
            } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        if($pdfOption == 'No' ){
        $this->load->view('admin_master', $data);
        }
    }
    
    
    public function list_of_seller() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
           
            $data['title'] = 'Seller List Report | HPP';

            $data['select_page'] = 'list_of_seller';
            $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);

            if( $pdfOption == 'Yes' ){
                $data['fromdate'] = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                $data['todate'] = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
            }else {
                $data['fromdate'] = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                $data['todate'] = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
            }

            $data['company_info'] = $this->company_header();

            $fromDate = date("Y-m-d", strtotime($data['fromdate']));
            $toDate = date("Y-m-d", strtotime($data['todate']));

            $reportQuery = $this->db->query("SELECT 
                                                    ui.USER_NAME,	
                                                    ui.USER_LOG_NAME,	
                                                    ui.EMAIL_ADDRESS,	
                                                    ui.USER_TYPE_ID,	
                                                    ui.ENT_USER,	
                                                    ui.ENT_DATE,	
                                                    ui.USER_STATUS,	

                                                    udi.FULL_NAME,
                                                    udi.SUB_NAME,
                                                    udi.GENTER,
                                                    udi.ADDRESS,
                                                    udi.PROFILE_IMAGE,
                                                    udi.ENT_DATE AS UDI_ENT_DATE,
                                                    udi.DETAILS_STATUS

                                                FROM 
                                                    s_user_info as ui
                                                LEFT JOIN s_user_details_info AS udi ON ui.USER_ID = udi.USER_ID   
                                                WHERE
                                                    (ui.ENT_DATE BETWEEN '$fromDate' AND '$toDate')
                                                     AND ui.USER_TYPE_ID = '1'    
                                                ORDER BY ui.ENT_DATE DESC
                                            ");
                $data['select_seller'] = $reportQuery->result_array();
                
                if( $pdfOption == 'Yes' ){
                  $html = $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/list_of_seller', $data, true);  
                  $this->load->helper('dompdf');
                  $create_view = pdf_create($html,'seller-list'.time("H:i:s"),TRUE);
                } else {
                    $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/list_of_seller', $data, true);
                }
                
            } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('admin_master', $data);
        }
    }
    
    public function list_of_buyer() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->adminID > 0 && $this->logged_admin == TRUE) {
           
                $data['title'] = 'Buyer List Report | HPP';

                $data['select_page'] = 'list_of_buyer';
                $data['user_menu']   = $this->load->view('page_templates/dashboard/company/user_menu', $data, true);
                
                if( $pdfOption == 'Yes' ){
                    $data['fromdate'] = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                    $data['todate'] = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                } else {
                    $data['fromdate'] = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                    $data['todate'] = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");  
                }

                $data['company_info'] = $this->company_header();

                $fromDate = date("Y-m-d", strtotime($data['fromdate']));
                $toDate = date("Y-m-d", strtotime($data['todate']));

                $reportQuery = $this->db->query("SELECT 
                                                        ui.USER_NAME,	
                                                        ui.USER_LOG_NAME,	
                                                        ui.EMAIL_ADDRESS,	
                                                        ui.USER_TYPE_ID,	
                                                        ui.ENT_USER,	
                                                        ui.ENT_DATE,	
                                                        ui.USER_STATUS,	
                                                        
                                                        udi.FULL_NAME,
                                                        udi.SUB_NAME,
                                                        udi.GENTER,
                                                        udi.ADDRESS,
                                                        udi.PROFILE_IMAGE,
                                                        udi.ENT_DATE AS UDI_ENT_DATE,
                                                        udi.DETAILS_STATUS
                                                        
                                                    FROM 
                                                        s_user_info as ui
                                                    LEFT JOIN s_user_details_info AS udi ON ui.USER_ID = udi.USER_ID   
                                                    WHERE
                                                        (ui.ENT_DATE BETWEEN '$fromDate' AND '$toDate')
                                                         AND ui.USER_TYPE_ID = '2'    
                                                    ORDER BY ui.ENT_DATE DESC
                                                ");
                $data['select_seller'] = $reportQuery->result_array();
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/list_of_buyer', $data, true);
                    $this->load->helper('dompdf');
                    $create_fiew = pdf_create($html,'buyer-list'.time("H:i:s"),TRUE);
                } else {
                    $data['main_content'] = $this->load->view('page_templates/dashboard/company/reports/list_of_buyer', $data, true);
                }
            } else {
            redirect(SITE_URL . 'hpp/admin/?page=home_admin');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('admin_master', $data);
        }
    }

    
    
}
