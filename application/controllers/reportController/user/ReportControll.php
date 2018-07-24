<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ReportControll extends HPP_Controller {
    
    public $userID , $logged_in , $userName;
    public function __construct() {
        parent::__construct();
        $this->userID     = $this->session->userData('userID');
        $this->logged_in  = $this->session->userData('logged_in');
        $this->userName   = $this->session->userData('userName');
        
    }
	
public function hpp_type_report($defult='all', $array = array('Hot Price' => 'hot_price', 'Auction' => 'auction', 'Sell' => 'sell', 'Rent' => 'rent')){
        $seatch = '';
        if(is_array($array) AND sizeof($array) > 0){
                $seatch .= '<select id="type_search" name="type_search" class="form-control" >
                                <option class="bs-title-option" value="all">All</option>';
                foreach($array AS $key=> $value){
                        if($defult == $value){
                                $seatch .= '<option value="'.$value.'" selected>'.$key.'</option>';
                        }else{
                                $seatch .= '<option value="'.$value.'">'.$key.'</option>';
                        }

                }
                $seatch .= ' </select>';
        }
        return $seatch;
}
        
       
public function purchaseReport() {
        $data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] =$pdfOption;
        
        if ($this->userID > 0 && $this->logged_in == TRUE) {
            if ($this->hpp_url_check('purchase-report', 'page') > 0) {
                $data['title'] = 'Purchase Report | HPP';

                $data['select_page'] = 'purchase-report';
                $data['user_menu'] = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
                
                if( $pdfOption == 'Yes' ){
                    $data['fromdate']   = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                    $data['todate']     = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                    //$type_search        = isset($_GET['type_search']) ? $_GET['type_search'] : 'all';
                }else{
                    $data['fromdate']   = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                    $data['todate']     = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                    //$type_search        = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
                }
                
                //$data['search_type']    = $this->hpp_type_report($type_search);
                
                $data['footer_user'] = $this->user->footer_user_info( $this->userID );
                $data['user_address'] = $this->user->user_mailing_address( $this->userID );
                $data['company_info'] = $this->company_header();

                $fromDate = date("Y-m-d", strtotime($data['fromdate']));
                $toDate = date("Y-m-d", strtotime($data['todate']));

                $reportQuery = $this->db->query("SELECT *	
                                                        FROM 
                                                            view_property_sell 
                                                        WHERE 
                                                            SELL_USER = $this->userID
                                                            AND (SELL_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                        ORDER BY SELL_DATE DESC
                                                 ");
                $data['purchase_report'] = $reportQuery->result_array();
                
				$reportQueryDis = $this->db->query("SELECT distinct(viewl.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            view_property_sell AS viewl
                                                            INNER JOIN mt_countries AS count ON viewl.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            viewl.SELL_USER = $this->userID
                                                            AND (viewl.SELL_DATE BETWEEN '$fromDate' AND '$toDate')                                                            
                                                        ORDER BY viewl.SELL_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/purchase_report', $data, true);
                    $this->load->helper('dompdf');
                    $cereate_view = pdf_create($html,'purchase-report'.time("H:i:s"));
                } else {
                    $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/purchase_report', $data, true);
                }
                
            } else {
                $data['title'] = 'Don\'t have permission | HPP';
                $data['main_content'] = $this->load->view('errors/errors_page', $data, true);
            }
        } else {
            redirect(SITE_URL . 'login?page=purchase-report');
        }
         if( $pdfOption == 'No' ){
            $this->load->view('master', $data);
         }
    }

    
public function ledgerReport(){
	$data = array();
        
        $pdfOption = isset($_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] =$pdfOption;
        
        if ($this->userID > 0 && $this->logged_in == TRUE) {
            if ($this->hpp_url_check('ledger-report', 'page') > 0) { 
                $data['title']  = 'Ledger Report | HPP';

                $data['select_page'] = 'ledger-report';
                $data['user_menu'] = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
                if($pdfOption == 'Yes' ){
                    $data['fromdate'] = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                    $data['todate']   = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                }else{
                    $data['fromdate'] = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                    $data['todate']   = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                }
                
                $data['footer_user'] = $this->user->footer_user_info( $this->userID );
                $data['user_address'] = $this->user->user_mailing_address( $this->userID );
                $data['company_info'] = $this->company_header();

                $fromDate = date("Y-m-d", strtotime($data['fromdate']));
                $toDate = date("Y-m-d", strtotime($data['todate']));

                $reportQuery = $this->db->query("SELECT *	
                                                        FROM 
                                                            view_property_sell 
                                                        WHERE 
                                                            (USER_ID = $this->userID OR SELL_USER = $this->userID)
                                                            AND (SELL_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                        ORDER BY SELL_DATE DESC
                                                ");


                $data['ledger_report'] = $reportQuery->result_array();
                
				$reportQueryDis = $this->db->query("SELECT distinct(viewl.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            view_property_sell AS viewl
                                                            INNER JOIN mt_countries AS count ON viewl.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            (viewl.USER_ID = $this->userID OR viewl.SELL_USER = $this->userID)
                                                            AND (viewl.SELL_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            
                                                        ORDER BY viewl.SELL_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/ledger_report', $data, true);
                    $this->load->helper('dompdf');
                    $create_view = pdf_create($html,'ledger-report'.time("H:i:s"));
                    echo $create_view;
                }else {
                    $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/ledger_report', $data, true);
                }

            } else {
                $data['title'] = 'Don\'t have permission | HPP';
		$data['main_content'] = $this->load->view( 'errors/errors_page', $data, true );
            }
		} else {
            redirect(SITE_URL . 'login?page=ledger-report');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('master', $data);
        }
    }
	
public function sold_out_property_list(){
    $data = array();
    
    $pdfOption = isset( $_GET['pdf'] ) ? $_GET['pdf'] : 'No';
    $data['pdfOption'] = $pdfOption;
    
    if ($this->userID > 0 && $this->logged_in == TRUE) {
        if ($this->hpp_url_check('sold-out-property-list', 'page') > 0) { 
            $data['title']          = 'Sold out Report | HPP';

            $data['select_page'] = 'sold-out-property-list';
            $data['user_menu'] = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);

            if( $pdfOption == 'Yes' ){
                $data['fromdate'] 	= isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                $data['todate']   	= isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                $type_search            = isset($_GET['type_search']) ? $_GET['type_search'] : 'all'; 
            } else{
                $data['fromdate'] 	= isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                $data['todate']   	= isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                $type_search            = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
            }

            $data['search_type']    = $this->hpp_type_report($type_search);
            $where = '';
            if($type_search == 'hot_price'){
                    $data['type_search'] = 'Hot Price';
                    $where = " AND HOT_PRICE_PROPERTY = 'Yes'";
            }else if($type_search == 'auction'){
                    $data['type_search'] = 'Auction';
                    $where = " AND PROPERTY_AUCTION = 'Yes'";
            }else if($type_search == 'sell'){
                    $data['type_search'] = 'Sell';
                    $where = " AND PRO_CATEGORY_ID = '1'";
            }else if($type_search == 'rent'){
                    $data['type_search'] = 'Rent';
                    $where = " AND PRO_CATEGORY_ID = '2'";
            }else{
                    $data['type_search'] = 'All';
                    $where = '';
            }

            $data['footer_user'] = $this->user->footer_user_info( $this->userID );
            $data['user_address'] = $this->user->user_mailing_address( $this->userID );
            $data['company_info'] = $this->company_header();

            $fromDate = date("Y-m-d", strtotime($data['fromdate']));
            $toDate = date("Y-m-d", strtotime($data['todate']));

            $reportQuery = $this->db->query("SELECT *	
                                                    FROM 
                                                        view_property_sell 
                                                    WHERE 
                                                        USER_ID = $this->userID
                                                        AND (SELL_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                        $where
                                                    ORDER BY SELL_DATE DESC
                                                    ");
            $data['sellreport'] = $reportQuery->result_array();
            
			 $reportQueryDis = $this->db->query("SELECT distinct(viewl.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            view_property_sell AS viewl
                                                            INNER JOIN mt_countries AS count ON viewl.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            viewl.USER_ID = $this->userID
                                                            AND (viewl.SELL_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            $where
                                                        ORDER BY viewl.SELL_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
			
            if( $pdfOption == 'Yes' ){
               $html = $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/sold_out_property_list', $data, true);
               $this->load->helper('dompdf');
               $creare_view = pdf_create($html,'sold-out-property'.time("H:i:s") );
            }else {
               $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/sold_out_property_list', $data, true); 
            }

        } else {
            $data['title'] = 'Don\'t have permission | HPP';
            $data['main_content'] = $this->load->view( 'errors/errors_page', $data, true );
        }
            } else {
        redirect(SITE_URL . 'login?page=sold-out-property-list');
    }
    if( $pdfOption == 'No' ){
        $this->load->view('master', $data);
    }
}
    

public function list_of_property(){
        $data = array();
        
        $pdfOption = isset( $_GET['pdf']) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->userID > 0 && $this->logged_in == TRUE) {
            if ($this->hpp_url_check('list-of-property', 'page') > 0) { 
                $data['title']          = 'List of property Report | HPP';
                
              
                
                $data['select_page'] = 'list-of-property';
                $data['user_menu'] = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);

                if( $pdfOption == 'Yes' ){
                    $data['fromdate'] 	= isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                    $data['todate']   	= isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                    $type_search	= isset($_GET['type_search']) ? $_GET['type_search'] : 'all';  
                }else{
                    $data['fromdate'] 	= isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                    $data['todate']   	= isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                    $type_search	= isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
                }

                $data['search_type']   = $this->hpp_type_report($type_search);
                $where = '';
                if($type_search == 'hot_price'){
                    $data['type_search'] = 'Hot Price';
                    $where = " AND HOT_PRICE_PROPERTY = 'Yes'";
                }else if($type_search == 'auction'){
                    $data['type_search'] = 'Auction';
                    $where = " AND PROPERTY_AUCTION = 'Yes'";
                }else if($type_search == 'sell'){
                    $data['type_search'] = 'Sell';
                    $where = " AND PRO_CATEGORY_ID = '1'";
                }else if($type_search == 'rent'){
                    $data['type_search'] = 'Rent';
                    $where = " AND PRO_CATEGORY_ID = '2'";
                }else{
                    $data['type_search'] = 'All';
                    $where = '';
                }
                
                
                $data['footer_user'] = $this->user->footer_user_info( $this->userID );
                $data['user_address'] = $this->user->user_mailing_address( $this->userID );
                $data['company_info'] = $this->company_header('fill');

                $fromDate = date("Y-m-d", strtotime($data['fromdate']));
                $toDate = date("Y-m-d", strtotime($data['todate']));

                $reportQuery = $this->db->query("SELECT *	
                                                        FROM 
                                                            view_property_list 
                                                        WHERE 
                                                            USER_ID = $this->userID
                                                            AND (ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            $where
                                                        ORDER BY ENT_DATE DESC
                                                        ");
                $data['sellreport'] = $reportQuery->result_array();
                
                $reportQueryDis = $this->db->query("SELECT distinct(viewl.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            view_property_list AS viewl
                                                            INNER JOIN mt_countries AS count ON viewl.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            viewl.USER_ID = $this->userID
                                                            AND (viewl.ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            $where
                                                        ORDER BY viewl.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
                //print_r($data['sellreportDis']);
                
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/list_of_property', $data, true);
                    $this->load->helper('dompdf');
                    $create_view = pdf_create($html,'list-of-property'.time("H:i:s"));
                }else{
                    $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/list_of_property', $data, true);
                }

            } else {
                $data['title'] = 'Don\'t have permission | HPP';
                $data['main_content'] = $this->load->view( 'errors/errors_page', $data, true );
            }
                } else {
            redirect(SITE_URL . 'login?page=list-of-property');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('master', $data);
        }
    }
	
	
	
public function ongoing_property_list(){
    $data = array();

    $pdfOption = isset( $_GET['pdf']) ? $_GET['pdf'] : 'No';
    $data['pdfOption'] = $pdfOption;

    if ($this->userID > 0 && $this->logged_in == TRUE) {
        if ($this->hpp_url_check('ongoing-property-list', 'page') > 0) { 
            $data['title']          = 'Ongoing property Report | HPP';

            $data['select_page'] = 'ongoing-property-list';
            $data['user_menu'] = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);

            if( $pdfOption == 'Yes' ){
                $data['fromdate'] 	= isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                $data['todate']   	= isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                $type_search            = isset($_GET['type_search']) ? $_GET['type_search'] : 'all'; 
            }else{
                $data['fromdate'] 	= isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                $data['todate']   	= isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                $type_search            = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
            }

            $data['search_type']   = $this->hpp_type_report($type_search);
            $where = '';
            if($type_search == 'hot_price'){
                $data['type_search'] = 'Hot Price';
                $where = " AND HOT_PRICE_PROPERTY = 'Yes'";
            }else if($type_search == 'auction'){
                $data['type_search'] = 'Auction';
                $where = " AND PROPERTY_AUCTION = 'Yes'";
            }else if($type_search == 'sell'){
                $data['type_search'] = 'Sell';
                $where = " AND PRO_CATEGORY_ID = '1'";
            }else if($type_search == 'rent'){
                $data['type_search'] = 'Rent';
                $where = " AND PRO_CATEGORY_ID = '2'";
            }else{
                $data['type_search'] = 'All';
                $where = '';
            }

            $data['footer_user'] = $this->user->footer_user_info( $this->userID );
            $data['user_address'] = $this->user->user_mailing_address( $this->userID );
            $data['company_info'] = $this->company_header();

            $fromDate = date("Y-m-d", strtotime($data['fromdate']));
            $toDate = date("Y-m-d", strtotime($data['todate']));

            $reportQuery = $this->db->query("SELECT *	
                                                    FROM 
                                                        view_property_list 
                                                    WHERE 
                                                        USER_ID = $this->userID
                                                        AND (ENT_DATE BETWEEN '$fromDate' AND '$toDate')
                                                        AND PROPERTY_STATUS = 'Active'	
                                                        $where
                                                    ORDER BY ENT_DATE DESC
                                                    ");
            $data['sellreport'] = $reportQuery->result_array();
			
			$reportQueryDis = $this->db->query("SELECT distinct(viewl.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            view_property_list AS viewl
                                                            INNER JOIN mt_countries AS count ON viewl.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            viewl.USER_ID = $this->userID
                                                            AND (viewl.ENT_DATE BETWEEN '$fromDate' AND '$toDate')
															AND viewl.PROPERTY_STATUS = 'Active'	
                                                            $where
                                                        ORDER BY viewl.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();

            if( $pdfOption == 'Yes' ){
                $html = $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/ongoing_property_list', $data, true);
                $this->load->helper('dompdf');
                $create_view = pdf_create($html,'active-property-list'.time("H:i:s"));
            }else {
                $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/ongoing_property_list', $data, true);
            }

        } else {
            $data['title'] = 'Don\'t have permission | HPP';
            $data['main_content'] = $this->load->view( 'errors/errors_page', $data, true );
        }
    } else {
        redirect(SITE_URL . 'login?page=ongoing-property-list');
    }
    if( $pdfOption == 'No' ){
        $this->load->view('master', $data);
    }
}
        
public function reject_property_list(){
        $data = array();
        
        $pdfOption = isset( $_GET['pdf'] ) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->userID > 0 && $this->logged_in == TRUE) {
            if ($this->hpp_url_check('ongoing-property-list', 'page') > 0) { 
                $data['title']       = 'Reject property Report | HPP';

                $data['select_page'] = 'reject-property-list';
                $data['user_menu']   = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);

                if( $pdfOption == 'Yes' ){
                    $data['fromdate'] 	= isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                    $data['todate']   	= isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                    $type_search        = isset($_GET['type_search']) ? $_GET['type_search'] : 'all';
                }else{
                    $data['fromdate'] 	= isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                    $data['todate']   	= isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                    $type_search        = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
                } 

                $data['search_type']   = $this->hpp_type_report($type_search);
                $where = '';
                if($type_search == 'hot_price'){
                    $data['type_search'] = 'Hot Price';
                    $where = " AND vpl.HOT_PRICE_PROPERTY = 'Yes' AND vol.OFFER_STATUS = 'Reject'";
                }else if($type_search == 'auction'){
                    $data['type_search'] = 'Auction';
                    $where = " AND vpl.PROPERTY_AUCTION = 'Yes' AND vol.OFFER_STATUS = 'Reject'";
                }else if($type_search == 'sell'){
                    $data['type_search'] = 'Sell';
                    $where = " AND vpl.PRO_CATEGORY_ID = '1' AND vpl.PROPERTY_STATUS = 'Reject'";
                }else if($type_search == 'rent'){
                    $data['type_search'] = 'Rent';
                    $where = " AND vpl.PRO_CATEGORY_ID = '2' AND vpl.PROPERTY_STATUS = 'Reject'";
                }else{
                    $data['type_search'] = 'All';
                    $where = "AND (vpl.PROPERTY_STATUS = 'Reject' OR vol.OFFER_STATUS = 'Reject')";
                }
                
                $data['footer_user'] = $this->user->footer_user_info( $this->userID );
                $data['user_address'] = $this->user->user_mailing_address( $this->userID );
                $data['company_info'] = $this->company_header();

                $fromDate = date("Y-m-d", strtotime($data['fromdate']));
                $toDate = date("Y-m-d", strtotime($data['todate']));

                $reportQuery = $this->db->query("SELECT 
                                                        vpl.PROPERTY_ID,
                                                        vpl.PROPERTY_NAME,
                                                        vpl.PROPERTY_STREET_NO,
                                                        vpl.PROPERTY_STREET_ADDRESS,
                                                        vpl.PROPERTY_CITY,
                                                        vpl.PROPERTY_COUNTRY,
                                                        vpl.PROPERTY_AUCTION,
                                                        vpl.HOT_PRICE_PROPERTY,
                                                        vpl.ENT_DATE,
                                                        vpl.PROPERTY_PRICE,
                                                        vpl.SELL_PRICE,
                                                        vpl.PROPERTY_STATUS,
                                                        vpl.PROPERTY_TYPE_NAME,
                                                        vol.ENT_DATE_OFFER,
                                                        vol.OFFER_STATUS
                                                        FROM view_property_list as vpl 
                                                        LEFT JOIN view_offer_list as vol ON vpl.PROPERTY_ID = vol.PROPERTY_ID
                                                        WHERE 
                                                            vpl.USER_ID = $this->userID
                                                            AND (vpl.ENT_DATE BETWEEN '$fromDate' AND '$toDate')    
                                                            $where
                                                            ORDER BY vpl.ENT_DATE DESC
                                                ");
               //echo $this->db->last_query();
                $data['sellreport']    = $reportQuery->result_array();
				
				$reportQueryDis = $this->db->query("SELECT distinct(vpl.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS currency_code
                                                        FROM 
                                                            view_property_list AS vpl
                                                            INNER JOIN mt_countries AS count ON vpl.PROPERTY_COUNTRY = count.countryID
                                                        LEFT JOIN view_offer_list as vol ON vpl.PROPERTY_ID = vol.PROPERTY_ID
                                                        
														WHERE 
                                                            vpl.USER_ID = $this->userID
                                                            AND (vpl.ENT_DATE BETWEEN '$fromDate' AND '$toDate')
															$where
                                                        ORDER BY vpl.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
               // print_r( $data['sellreport']);
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content']  = $this->load->view('page_templates/dashboard/users/reports/reject_property_list', $data, true);
                    $this->load->helper('dompdf');
                    $create_view = pdf_create($html,'reject-property-list'.time("H:i:s"));
                }else{
                    $data['main_content']  = $this->load->view('page_templates/dashboard/users/reports/reject_property_list', $data, true);
                }

            } else {
                $data['title'] = 'Don\'t have permission | HPP';
                $data['main_content'] = $this->load->view( 'errors/errors_page', $data, true );
            }
        } else {
            redirect(SITE_URL . 'login?page=ongoing-property-list');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('master', $data);
        }
    }


public function date_over_property_list(){
        $data = array();
        
        $pdfOption = isset( $_GET['pdf'] ) ? $_GET['pdf'] : 'No';
        $data['pdfOption'] = $pdfOption;
        
        if ($this->userID > 0 && $this->logged_in == TRUE) {
            if ($this->hpp_url_check('date-over-property-list', 'page') > 0) { 
                $data['title']       = 'Date Over property Report | HPP';

                $data['select_page'] = 'date-over-property-list';
                $data['user_menu']   = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);

                if( $pdfOption == 'Yes' ){
                    $data['fromdate'] 	= isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                    $data['todate']   	= isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                    $type_search        = isset($_GET['type_search']) ? $_GET['type_search'] : 'all';
                }else{
                    $data['fromdate'] 	= isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                    $data['todate']   	= isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                    $type_search        = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
                }

                $data['search_type']   = $this->hpp_type_report($type_search, array('Hot Price' => 'hot_price', 'Auction' => 'auction' ) );
                $where = '';
                $to_date = date("Y-m-d H:i:s");
                if($type_search == 'hot_price'){
                    $data['type_search'] = 'Hot Price';
                    $where = " AND HOT_PRICE_PROPERTY = 'Yes'";
                }else if($type_search == 'auction'){
                    $data['type_search'] = 'Auction';
                    $where = " AND PROPERTY_AUCTION = 'Yes'";
                }else{
                    $data['type_search'] = 'All';
                    $where = '';
                }

                $data['footer_user'] = $this->user->footer_user_info( $this->userID );
                $data['user_address'] = $this->user->user_mailing_address( $this->userID );
                $data['company_info'] = $this->company_header();
                
                $fromDate = date("Y-m-d", strtotime($data['fromdate']));
                $toDate = date("Y-m-d", strtotime($data['todate']));

                $reportQuery = $this->db->query("SELECT *	
                                                        FROM 
                                                            view_offer_list
                                                        WHERE 
                                                            USER_ID = $this->userID
                                                            AND (ENT_DATE_OFFER BETWEEN '$fromDate' AND '$toDate')
                                                            AND OFFER_END_DATE < '$to_date' AND OFFER_STATUS = 'Active'	
                                                            $where
                                                        ORDER BY ENT_DATE_OFFER DESC
                                                        ");
                $data['sellreport'] = $reportQuery->result_array();
                
				$reportQueryDis = $this->db->query("SELECT distinct(viewl.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            view_offer_list AS viewl
                                                            INNER JOIN mt_countries AS count ON viewl.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            viewl.USER_ID = $this->userID
                                                            AND (viewl.ENT_DATE_OFFER BETWEEN '$fromDate' AND '$toDate')
															AND viewl.OFFER_END_DATE < '$to_date' AND viewl.OFFER_STATUS = 'Active'	
                                                            	
                                                            $where
                                                        ORDER BY viewl.ENT_DATE_OFFER DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
                if( $pdfOption == 'Yes' ){
                    $html = $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/date_over_property_list', $data, true);
                    $this->load->helper('dompdf');
                    $create_view = pdf_create($html,'date-over-property'.time("H:i:s"));
                }else{
                    $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/date_over_property_list', $data, true);
                }

            } else {
                $data['title'] = 'Don\'t have permission | HPP';
                $data['main_content'] = $this->load->view( 'errors/errors_page', $data, true );
            }
        } else {
            redirect(SITE_URL . 'login?page=ongoing-property-list');
        }
        if( $pdfOption == 'No' ){
            $this->load->view('master', $data);
        }
    }  
    
    
public function rent_property_list(){
    $data = array();
    
    $pdfOptiom = isset( $_GET['pdf'] ) ? $_GET['pdf'] : 'No';
    $data['pdfOption'] = $pdfOptiom;
    
    if ($this->userID > 0 && $this->logged_in == TRUE) {
        if ($this->hpp_url_check('rent-property-list', 'page') > 0) {
            $data['title'] = 'Rent Report | HPP';

            $data['select_page'] = 'rent-property-list';
            $data['user_menu']   = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
            if( $pdfOptiom == 'Yes' ){
                $data['fromdate']    = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                $data['todate']      = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
                $type_search         = isset($_GET['type_search']) ? $_GET['type_search'] : 'all';
            }else {
                $data['fromdate']    = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                $data['todate']      = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
                $type_search         = isset($_POST['type_search']) ? $_POST['type_search'] : 'all';
            }

                $data['search_type']   = $this->hpp_type_report($type_search, array('Hot Price' => 'hot_price', 'Auction' => 'auction' ) );
                $where = '';
                $to_date = date("Y-m-d H:i:s");
                if($type_search == 'hot_price'){
                    $data['type_search'] = 'Hot Price';
                    $where = " AND HOT_PRICE_PROPERTY = 'Yes'";
                }else if($type_search == 'auction'){
                    $data['type_search'] = 'Auction';
                    $where = " AND PROPERTY_AUCTION = 'Yes'";
                }else{
                    $data['type_search'] = 'All';
                    $where = '';
                }
            
			$data['footer_user'] = $this->user->footer_user_info( $this->userID );
			$data['user_address'] = $this->user->user_mailing_address( $this->userID );
			$data['company_info'] = $this->company_header();

            $fromDate = date("Y-m-d", strtotime($data['fromdate']));
            $toDate = date("Y-m-d", strtotime($data['todate']));

            $reportQuery = $this->db->query("SELECT *	
                                                        FROM 
                                                            view_property_sell 
                                                        WHERE 
                                                            SELL_USER = $this->userID
                                                            AND (SELL_DATE BETWEEN '$fromDate' AND '$toDate')
                                                            AND  PRO_CATEGORY_ID = '2'
                                                            $where
                                                        ORDER BY SELL_DATE DESC
                                                        ");
            $data['rent_report'] = $reportQuery->result_array();
            
			$reportQueryDis = $this->db->query("SELECT distinct(viewl.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            view_property_sell AS viewl
                                                            INNER JOIN mt_countries AS count ON viewl.PROPERTY_COUNTRY = count.countryID
                                                        WHERE 
                                                            viewl.SELL_USER = $this->userID
                                                            AND (viewl.SELL_DATE BETWEEN '$fromDate' AND '$toDate') 
                                                            $where
                                                        ORDER BY viewl.SELL_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
				
            if( $pdfOptiom == 'Yes' ){
                $html = $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/rent_property_list', $data, true);
                $this->load->helper('dompdf');
                $create_view = pdf_create($html,'rent-property-list'.time("H:i:s"));
            }else{
                $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/rent_property_list', $data, true);
            }
        } else {
            $data['title'] = 'Don\'t have permission | HPP';
            $data['main_content'] = $this->load->view('errors/errors_page', $data, true);
        }
    } else {
        redirect(SITE_URL . 'login?page=purchase-report');
    }
    if( $pdfOptiom == 'No' ){
        $this->load->view('master', $data);
    }
}

public function failed_auction_list(){
    $data = array();
    
    $pdfOption = isset( $_GET['pdf'] ) ? $_GET['pdf'] : 'No';
    $data['pdfOption'] = $pdfOption;
    
    if ($this->userID > 0 && $this->logged_in == TRUE) {
        if ($this->hpp_url_check('failed-auction-property-list', 'page') > 0) {
            $data['title'] = 'Failed Auction Report | HPP';

            $data['select_page'] = 'failed-auction-property-list';
            $data['user_menu']   = $this->load->view('page_templates/dashboard/users/user_menu', $data, true);
            
            if( $pdfOption == 'Yes' ){
                $data['fromdate']    = isset($_GET['from_date']) ? $_GET['from_date'] : date("Y-m-d");
                $data['todate']      = isset($_GET['to_date']) ? $_GET['to_date'] : date("Y-m-d");
            }else{
                $data['fromdate']    = isset($_POST['from_date']) ? $_POST['from_date'] : date("Y-m-d");
                $data['todate']      = isset($_POST['to_date']) ? $_POST['to_date'] : date("Y-m-d");
            }
            
            $to_date = date("Y-m-d H:i:s");

            $data['footer_user'] = $this->user->footer_user_info( $this->userID );
            $data['user_address'] = $this->user->user_mailing_address( $this->userID );
            $data['company_info'] = $this->company_header();

            $fromDate = date("Y-m-d", strtotime($data['fromdate']));
            $toDate = date("Y-m-d", strtotime($data['todate']));

            $Query = $this->db->query("SELECT *	
                                                    FROM 
                                                        p_property_offers_bidding
                                                    WHERE 
                                                        USER_ID = $this->userID AND OFFER_BID_STATUS = 'Active'
														AND (ENT_DATE BETWEEN '$fromDate' AND '$toDate') 
														ORDER BY ENT_DATE DESC
                                            ");		
            $data['select_property'] = $Query->result_array();
            
			$reportQueryDis = $this->db->query("SELECT distinct(viewl.PROPERTY_COUNTRY) AS PROPERTY_COUNTRY, count.countryName AS countryName, count.currency_symbol AS currency_symbol, count.currency_code AS	currency_code
                                                        FROM 
                                                            view_property_sell AS viewl
                                                            INNER JOIN mt_countries AS count ON viewl.PROPERTY_COUNTRY = count.countryID
                                                            INNER JOIN p_property_offers_bidding AS offer ON viewl.PROPERTY_ID = offer.PROPERTY_ID
                                                        
														WHERE 
                                                            offer.USER_ID = $this->userID AND offer.OFFER_BID_STATUS = 'Active'
															AND (offer.ENT_DATE BETWEEN '$fromDate' AND '$toDate')
                                                            
                                                        ORDER BY offer.ENT_DATE DESC
                                                        ");
                $data['sellreportDis'] = $reportQueryDis->result_array();
			
            if( $pdfOption == 'Yes' ){
                $html = $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/failed_auction_list', $data, true);
                $this->load->helper('dompdf');
                $create_view = pdf_create($html,'failed-auction-list'.time("H:i:s"));
            }else{
                $data['main_content'] = $this->load->view('page_templates/dashboard/users/reports/failed_auction_list', $data, true);
            }
        } else {
            $data['title'] = 'Don\'t have permission | HPP';
            $data['main_content'] = $this->load->view('errors/errors_page', $data, true);
        }
    } else {
        redirect(SITE_URL . 'login?page=purchase-report');
    }
    if( $pdfOption == 'No' ){
        $this->load->view('master', $data);
    }
}


}
?>