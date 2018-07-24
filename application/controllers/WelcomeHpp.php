<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WelcomeHpp extends HPP_Controller {

    public function __construct(){
		parent::__construct();		
	}
	
	
    public function index()
    {
        $property = array();
        $data = array();
        $data['page_title'] = 'Home';
        $data['title'] = 'Welcome hot price property';
        $type = isset($_GET['type']) ? $_GET['type'] : 'buy';
        /*Slider search parametter*/
        $data['PROPERTY_NAME_select'] = $data['PROPERTY_STATE_ID'] = $data['PROPERTY_STREET_NO_ID'] = $data['PROPERTY_STREET_ADDRESS_ID'] = $data['PROPERTY_CITY_ID'] = $data['PROPERTY_COUNTRY_ID'] = $data['type_select'] = '';

		$priceSearch = 'PROPERTY_PRICE !=';
		$priceSearchVal = '';
        if($type == 'buy'){
                $data['title_seach'] = 'Buy';
                $data['title_action'] = 'buy';
                $query['PRO_CATEGORY_NAME'] = 'Sell';			
        }else if($type == 'rent'){
                $data['title_seach'] = 'Rent';
                $data['title_action'] = 'rent';
                $query['PRO_CATEGORY_NAME'] = 'Rent';
        }else if($type == 'auction'){
                $data['title_seach'] = 'Auction';
                $data['title_action'] = 'auction';
                $query['PRO_CATEGORY_NAME'] = 'Sell';
                $property['PROPERTY_AUCTION'] = 'Yes';
				$priceSearch = 'PROPERTY_AUCTION = ';
				$priceSearchVal = 'Yes';
        }else if($type == 'hot_price'){
                $data['title_seach'] = 'Hot Price';
                $data['title_action'] = 'hot_price';
                $property['HOT_PRICE_PROPERTY'] = 'Yes';		
                $query['PRO_CATEGORY_NAME'] = 'Sell';		
				$priceSearch = 'HOT_PRICE_PROPERTY = ';
				$priceSearchVal = 'Yes';
        }
        $query['PRO_CATEGORY_STATUS'] = 'Active';
        $type_id = $this->any_where($query, 'mt_p_property_category', 'PRO_CATEGORY_ID');

        $data['property_type'] 	= $this->any_where(array('PROPERTY_TYPE_STATUS' => 'Active'), 'mt_p_property_type');
        $this->hpp_select 		= 'DISTINCT(PROPERTY_STATE)';
        $this->hpp_order_column         = 'ENT_DATE';
        $this->hpp_order 		= 'DESC';
        $data['location'] 		= $this->any_where(array('PROPERTY_STATE !=' => '', 'PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id), 'p_property_basic', '');

        $this->hpp_select 		= 'MIN(PROPERTY_PRICE) AS PROPERTY_PRICE';
        $data['price_min'] 		= $this->any_where(array('PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id, $priceSearch => $priceSearchVal), 'p_property_basic', 'PROPERTY_PRICE');
        $this->hpp_select 		= 'MAX(PROPERTY_PRICE) AS PROPERTY_PRICE';
        $data['price_max'] 		= $this->any_where(array('PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id, $priceSearch => $priceSearchVal), 'p_property_basic', 'PROPERTY_PRICE');

        $this->hpp_select 		= 'DISTINCT(PROPERTY_NAME)';
        $this->hpp_order_column = 'ENT_DATE';
        $this->hpp_order                = 'DESC';
        $data['PROPERTY_NAME_DATA'] 	= $this->any_where(array('PROPERTY_NAME !=' => '', 'PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id), 'p_property_basic', '');

        $this->hpp_select 		= 'DISTINCT(PROPERTY_STREET_NO)';
        $data['PROPERTY_STREET_NO'] 	= $this->any_where(array('PROPERTY_STREET_NO !=' => '', 'PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id), 'p_property_basic', '');

        $this->hpp_select 		 = 'DISTINCT(PROPERTY_STREET_ADDRESS)';
        $data['PROPERTY_STREET_ADDRESS'] = $this->any_where(array('PROPERTY_STREET_ADDRESS !=' => '', 'PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id), 'p_property_basic', '');

        $this->hpp_select       = 'DISTINCT(PROPERTY_CITY)';
        $data['PROPERTY_CITY'] 	= $this->any_where(array('PROPERTY_CITY !=' => '', 'PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id), 'p_property_basic', '');

        $this->hpp_select       = ''; $this->hpp_limit = 4; $this->hpp_offset = 0;
        $data['PROPERTY_NEWS'] 	= $this->any_where(array('NEWS_STATUS =' => 'Active'), 'blog_property_news', '');
        /*End Slider search parametter*/

        $this->hpp_order = $this->hpp_order_column = $this->hpp_select = $this->hpp_limit = $this->hpp_offset = '';

        $data['PROPERTY_COUNTRY'] 	   = $this->Property_Model->select_country('', '');

        $data['MENU_NAV'] = 'wrapper-nav';
        /*hot price property*/

        $hot_price = $this->db->query("SELECT * 
                                            FROM 
                                                p_property_basic AS basic
                                            LEFT JOIN p_property_offers AS offer
                                                            ON basic.PROPERTY_ID = offer.PROPERTY_ID
                                            LEFT JOIN p_property_images AS images
                                                            ON basic.PROPERTY_ID = images.PROPERTY_ID
                                            WHERE
                                                basic.HOT_PRICE_PROPERTY = 'Yes'
                                                AND images.DEFAULT_IMAGE = 1
                                                AND basic.PROPERTY_STATUS = 'Active'
                                                AND offer.OFFER_TYPE = 'Hot'
                                                AND offer.OFFER_STATUS  = 'Active'
                                                GROUP BY basic.PROPERTY_ID
                                                ORDER BY offer.ENT_DATE, basic.ENT_DATE 
                                                LIMIT 0,4
                                    ");

        $data['hot_property'] = $hot_price->result_array(); 


        /*Auction price property*/

        $Auction_price = $this->db->query("SELECT * 
                                                FROM 
                                                    p_property_basic AS basic
                                                LEFT JOIN p_property_offers AS offer
                                                                ON basic.PROPERTY_ID = offer.PROPERTY_ID
                                                LEFT JOIN p_property_images AS images
                                                                ON basic.PROPERTY_ID = images.PROPERTY_ID
                                            WHERE
                                                basic.PROPERTY_AUCTION = 'Yes'
                                                AND images.DEFAULT_IMAGE = 1
                                                AND basic.PROPERTY_STATUS = 'Active'
                                                AND offer.OFFER_TYPE 	= 'Bid'
                                                AND offer.OFFER_STATUS  = 'Active'
                                                GROUP BY basic.PROPERTY_ID
                                                ORDER BY offer.ENT_DATE, basic.ENT_DATE 
                                                LIMIT 0,4
                                       ");

        $data['Auction_property'] = $Auction_price->result_array(); 

        /*buy price property*/
        $buy_price = $this->db->query("SELECT * 
                                            FROM 
                                                p_property_basic AS basic
                                            LEFT JOIN p_property_images AS images
                                                            ON basic.PROPERTY_ID = images.PROPERTY_ID
                                        WHERE
                                            (basic.PROPERTY_AUCTION != 'Yes'
                                            OR basic.HOT_PRICE_PROPERTY != 'Yes')
                                            AND images.DEFAULT_IMAGE = 1
                                            AND basic.PROPERTY_STATUS = 'Active'														
                                            GROUP BY basic.PROPERTY_ID
                                            ORDER BY basic.ENT_DATE 
                                            LIMIT 0,4
                                    ");

        $data['buy_property'] = $buy_price->result_array(); 
        $data['type'] = $type;
        $data['main_content']	= $this->load->view('page_templates/home_content', $data, true);
        $this->load->view('master', $data);

    }
	
	
    /*---- Blog Page ----*/
    public function blogs()
    {

            $data = array();
            $data['title']			= 'Blog | HPP';
            $all_blog				= $this->db->query( "SELECT * FROM blog_property_news WHERE NEWS_STATUS = 'Active' ORDER BY NEWS_ID DESC LIMIT 0,10" );
            $data['select_blogs'] 	= $all_blog->result_array();
            $data['main_content'] 	= $this->load->view( 'page_templates/property/property_blog', $data, true );

            $this->load->view( 'master', $data );

    }

    public function property_news(){
            $data = array();
            $data['title']          = 'Property news page | HPP';
            $all_blog               = $this->db->query( "SELECT * FROM blog_property_news WHERE NEWS_STATUS = 'Active' ORDER BY NEWS_ID DESC LIMIT 0,10" );
            $data['select_blogs']   = $all_blog->result_array();
            $data['main_content']   = $this->load->view( 'page_templates/property/property_blog', $data, true );
            $this->load->view( 'master', $data );
    }
	
    public function property_news_details(){
            $data                   = array();
            $blog                   = isset($_GET['blog']) ? $_GET['blog'] : '';
            $data['title']          = 'Property news page | HPP';
            $single_blog            = $this->db->query( "SELECT * FROM blog_property_news WHERE NEWS_URL = '$blog' AND NEWS_STATUS = 'Active'" );
            $data['single_blog']    = $single_blog->result();
            $data['main_content']   = $this->load->view('page_templates/property/property_blog_details', $data, true);
            $this->load->view('master', $data);
    }
	
    /**contact us page**/
    public function contactUs()
    {
        $data = array();
        $data['title'] = 'Contact us | HPP';
        $mdata = array();
        if(isset($_POST['contactMessage'])){
            $mdata['from_address'] = 'sales@hotpriceproperty.com';
            //$mdata['to_address'] = 'golap.euitsols@gmail.com';
            $fname = $this->input->post('f_name', TRUE);
            $lname = $this->input->post('l_name', TRUE);
			$mdata['admin_full_name'] = $fname.' '.$lname;
            
            $mdata['contact_name'] = $fname . ' ' . $lname;
            $mdata['contact_email'] = $this->input->post('contact_email', TRUE);
            $mdata['subject'] = $this->input->post('contact_subject', TRUE);
            $mdata['contact_message'] = $this->input->post('contact_message', TRUE);
           // $body = 'dgdg';
			$body = $this->load->view('mailScripts/contact_mail', $mdata, true);
			$sent = $this->MailerModel->sendEmail($mdata['from_address'], $mdata['subject'], $body, $mdata['contact_email']);
			
			//$this->MailerModel->sendContactEmail($mdata, 'contact_mail');
            $sdata = array();
            if($sent){
                $sdata['message'] = "Your Email Send Successfully..!";
                $this->session->set_userdata($sdata);
            }else{
              $sdata['message'] = "Email Dose\'t Send..!";
              $this->session->set_userdata($sdata);  
            }
			
			
        }

        $data['main_content']	= $this->load->view('page_templates/contact_content', $data, true);
        $this->load->view('master', $data);		
    }
	
	
    /**fqa us page**/
    public function faqPage()
    {
        $data = array();
        $data['title'] = 'FAQ | HPP';
        $fqa = $this->db->query("SELECT * FROM fqa_content WHERE FQA_STATUS = 'Active'");
        $data['select_all_fqa'] = $fqa->result();
        $data['main_content']	= $this->load->view('page_templates/faq_content', $data, true);
        $this->load->view('master', $data);
    }
    
	
	public function advertise(){
		$data = array();
        $data['title'] = 'Advertise | HPP';
        $data['main_content']	= $this->load->view('page_templates/advertise-content', $data, true);
        $this->load->view('master', $data);
	}
	
	public function opt_out(){
		$data = array();
        $data['title'] = 'Opt Out | HPP';
        $data['main_content']	= $this->load->view('page_templates/opt-out-content', $data, true);
        $this->load->view('master', $data);
	}
	
	public function sitemap(){
		$data = array();
        $data['title'] = 'Site Map | HPP';
        $data['main_content']	= $this->load->view('page_templates/sitemap-content', $data, true);
        $this->load->view('master', $data);
	}
	
	public function careers(){
		$data = array();
        $data['title'] = 'Careers | HPP';
        $data['main_content']	= $this->load->view('page_templates/careers-content', $data, true);
        $this->load->view('master', $data);
	}
	
	public function about_us(){
		$data = array();
        $data['title'] = 'About Us | HPP';
        $data['main_content']	= $this->load->view('page_templates/about-content', $data, true);
        $this->load->view('master', $data);
	}
    /**terms us page**/
    public function termsPage()
    {
        $data = array();
        $data['title'] = 'TERMS | HPP';
        $terms = $this->db->query( "SELECT * FROM terms_content WHERE TERMS_STATUS = 'Active'" );
        $data['select_all_terms'] = $terms->result();
        $data['main_content']	  = $this->load->view('page_templates/terms-content', $data, true);
        $this->load->view('master', $data);
    }
    
	public function helpPage()
    {
        $data = array();
        $data['title'] = 'Help | HPP';
        
        $data['main_content']	  = $this->load->view('page_templates/help-content', $data, true);
        $this->load->view('master', $data);
    }
    
	public function find_agentPage()
    {
        $data = array();
		
        $getOffset = isset($_GET['page']) ? $_GET['page'] : 1;
		
		$data['title'] = 'Agent Finder | HPP';
        
		$termsCount = $this->db->query( "SELECT * FROM real_org_list WHERE ORG_STATUS = 'Active'" );
		$coutn = $termsCount->num_rows();
		
		$pagiData = array();
		$pagiData['total_count'] = $coutn;
		$pagiData['offset_name'] = 'page';
		$pagiData['offset'] = $getOffset;
		$pagiData['limit'] = 500; // Per page
		
		$startFrom = $this->Property_Model->hpp_pagination($pagiData);
		
		$terms = $this->db->query( "SELECT * FROM real_org_list WHERE ORG_STATUS = 'Active' LIMIT $startFrom, 500" );
        $data['select_all_terms'] = $terms->result();
        $data['main_content']	  = $this->load->view('page_templates/find-agent', $data, true);
        $this->load->view('master', $data);
    }
    
	public function property_listing_deails(){
		$getId = $this->input->get('pId');
		$terms = $this->db->query( "SELECT * FROM real_org_list WHERE ORG_ID = $getId AND ORG_STATUS = 'Active'" );
		$fetch = $terms->result();
		$view = '';
		$view .= '<div class="row">
					<div class="col-md-12">
					<center><h6>'.$fetch[0]->ORG_NAME.' </h6>
					
				';
		if(strlen($fetch[0]->PHONE) > 0){		
			$view .= '<p> <b>Phone : </b> '.$fetch[0]->PHONE.'';	
		}
		if(strlen($fetch[0]->EMAIL) > 0){		
			$view .= '<p> <b>Email : </b> '.$fetch[0]->EMAIL.'';	
		}
		if(strlen($fetch[0]->WEBSITE) > 0){		
			$view .= '<p> <b>Website : </b> '.$fetch[0]->WEBSITE.'';	
		}
		if(strlen($fetch[0]->SOCIAL_ADDRESS) > 0){		
			$view .= '<p> <b>Social Contact : </b> '.$fetch[0]->SOCIAL_ADDRESS.'';	
		}
		if(strlen($fetch[0]->ABN_NUMBER) > 0){		
			$view .= '<p> <b>ABN Number : </b> '.$fetch[0]->ABN_NUMBER.'';	
		}
		if(strlen($fetch[0]->DETAILS) > 0){		
			$view .= '<p> <b>Details : </b> '.$fetch[0]->DETAILS.'';	
		}
		$view .= '<p> <b>Address : </b>';	
			if(strlen($fetch[0]->ORG_ADDRESS) > 0){
				$view .= ''.$fetch[0]->ORG_ADDRESS.', ';
			}
			if(strlen($fetch[0]->ORG_LOCATION) > 0){
				$view .= ''.$fetch[0]->ORG_LOCATION.', ';
			}
			if(strlen($fetch[0]->ORG_STATE) > 0){
				$view .= ''.$fetch[0]->ORG_STATE.' ';
			}
			if(strlen($fetch[0]->ORG_POST_CODE) > 0){
				$view .= ' - '.$fetch[0]->ORG_POST_CODE.', ';
			}
			if(strlen($fetch[0]->RELIGION) > 0){
				$view .= ''.$fetch[0]->RELIGION.', ';
			}
			if(strlen($fetch[0]->COUNTRY) > 0){
				$view .= '<br/>'.$fetch[0]->COUNTRY.'. ';
			}			
					
		$view .= '	   </p>
					</center>
					
					</div>';
		$view .= '</div>';
		
		echo $view;
		exit;
	}
    /**service us page**/
    public function servicePage()
    {
        $data = array();
        $data['title'] = 'Services | HPP';
        $service = $this->db->query( "SELECT * FROM service_content WHERE SERVICE_STATUS = 'Active'" );
        $data['select_all_service'] = $service->result();
        $data['main_content']	    = $this->load->view('page_templates/service-content', $data, true);
        $this->load->view('master', $data);
    }
    
    public function service_details($getServId)
    {
        $data = array();
        $data['title'] = 'Service Details | HPP';
        $service = $this->db->query("SELECT * FROM service_content WHERE SERVICE_ID = '$getServId' AND SERVICE_STATUS != 'Delete'");
        $data['select_service'] = $service->row();
        $data['main_content']       = $this->load->view( 'page_templates/service-details', $data, TRUE ); 
        $this->load->view( 'admin_master', $data );
    }
    
    public function newslatter_suscription(){
        $email = $this->input->get('email');
        if ($this->db->insert('newslatter_subscription', array('SUBSCRIPTION_EMAIL' => $email, 'SUBSCRIPTION_STATUS' => 'Active' ))) {
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }
    
    public function recive_mail()
    {
        $mdata = array();
        $mdata['from_address'] = 'contact@hotpriceproperty.com';
        $mdata['admin_full_name'] = 'HOTPRICE PROPERTY';
        $mdata['to_address'] = 'info@hotpriceproperty.com';
        //$mdata['to_address'] = 'sazzad.euitsils@gmail.com.com';
        $fname = $this->input->post('f_name',TRUE);
        $lname = $this->input->post('l_name',TRUE);
        $mdata['contact_name'] = $fname . ' ' . $lname;
        $mdata['contact_email'] = $this->input->post('contact_email',TRUE);
        $mdata['subject'] = $this->input->post('contact_subject',TRUE);
        $mdata['contact_message'] = $this->input->post('contact_message',TRUE);
        $this->MailerModel->sendContactEmail($mdata, 'contact_mail');

        // End Activation Email--------
        $sdata['message'] = "Your Email Send Successfully..!";
        $this->session->set_userdata($sdata);
        redirect('WelcomeHpp/contact','refresh');
    }
    
	
	
	
	
}
