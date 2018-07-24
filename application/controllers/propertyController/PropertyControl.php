<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PropertyControl extends HPP_Controller {
 public $userID , $logged_in , $userName, $userTypeID;
    function __construct() {
        parent::__construct();
//        $this->load->helper( 'form' );
        $this->load->helper('directory');
        $this->load->library( 'upload' );
		
        $this->userID       = $this->session->userData('userID');
        $this->logged_in    = $this->session->userData('logged_in');
        $this->userName     = $this->session->userData('userName');
        $this->userTypeID   = $this->session->userData('userType');
    }

    public function index() {

        $data = array();
        $data['title'] = 'Welcome hot price property';

        $userID = $this->session->userData('userID');
        $logged_in = $this->session->userData('logged_in');
        if ($userID > 0 AND $logged_in == TRUE) {
            
        }
        $data['main_content'] = $this->load->view('page_templates/home_content', $data, true);
        $this->load->view('master', $data);
    }

    /** Add new property* */

	public function sell_property(){
		$query = array();
		$query['PRO_CATEGORY_NAME'] = 'Sell';
		$query['PRO_CATEGORY_STATUS'] = 'Active';
		$type_id = $this->any_where($query, 'mt_p_property_category', 'PRO_CATEGORY_ID');
		if($type_id > 0){
			$this->add_property('sell', $type_id);
		}
	}
	
	public function rent_property(){
		$query = array();
		$query['PRO_CATEGORY_NAME'] = 'Rent';
		$query['PRO_CATEGORY_STATUS'] = 'Active';
		$type_id = $this->any_where($query, 'mt_p_property_category', 'PRO_CATEGORY_ID');
		if($type_id > 0){
			$this->add_property('post_rent', $type_id);
		}
	}
	
    public function add_property($category='sell', $categoryId = 1) {
        $data = array();
        $data['title'] = 'Add property | HPP';
        $userID = $this->session->userData('userID');
        $logged_in = $this->session->userData('logged_in');
        if ($userID > 0 AND $logged_in == TRUE) {
            $data['select_country'] = '230';
            $data['select_country_code'] = 'USD ($)';
            $query_country = $this->db->query("SELECT country.countryID, country.currency_code, country.currency_symbol FROM c_contact_info as contact INNER JOIN mt_countries AS country ON contact.CONTACT_NAME = country.countryID WHERE contact.USER_ID = $this->userID AND contact.CONTACT_TYPE_ID = '13' AND contact.CONTACT_STATUS = 'Active'");
            $result_country = $query_country->row();
            
            if(is_object($result_country) && sizeof($result_country) > 0 ){
                
                $data['select_country'] = $result_country->countryID;
                $data['select_country_code'] = $result_country->currency_code. ' ('.$result_country->currency_symbol.')';
            }
            if ($this->hpp_url_check($category, 'nav') > 0) {
                $data['property_type'] = $this->any_where(array('PROPERTY_TYPE_STATUS' => 'Active'), 'mt_p_property_type');
                $data['property_OWNER'] = $this->any_where(array('OWNER_STATUS' => 'Active'), 'mt_p_property_owner');
                $type = isset($_GET['type']) ? $_GET['type'] : 'sell';
                $data['type'] = $type;
                $data['category'] = $category;
				
                $checkType = $this->any_where_count(array('PROPERTY_TYPE_STATUS' => 'Active', 'PROPERTY_TYPE_ID' => $type), 'mt_p_property_type', 'PROPERTY_TYPE_ID');
                if ($checkType > 0) {
                    $data['type'] = $type;
                    $data['dynamic_filed'] = $this->Property_Model->property_fileld($data['type']);
                    /**start submit form**/
                    if (isset($_POST['new_property_form'])) {
			/** basic information upload **/
                        $currency_code = 'USD'; 
                        $currency_sample = '$';
                         $country_id = $this->input->post('country_id');
                        if($country_id > 0){
                            $query = $this->db->query("SELECT * FROM mt_countries WHERE countryID = $country_id");
                            $currency = $query->row();
                            $currency_code = $currency->currency_code;
                            $currency_sample = $currency->currency_symbol;
                        }
            
            
                        $sateNumber = $this->input->post('state_name');
						$countProperty = $this->db->query("SELECT PROPERTY_ID FROM p_property_basic WHERE POSTAL_CODE = '".trim($this->input->post('post_name'))."' AND PROPERTY_CITY = '".trim($this->input->post('city_name'))."' AND PROPERTY_STATE = '".trim($sateNumber)."' AND PROPERTY_COUNTRY = ".$this->input->post('country_id')." AND USER_ID = ".$userID." AND (PROPERTY_STATUS = 'Active' OR PROPERTY_STATUS = 'Pending')");
						$checkCount = $countProperty->num_rows();
						
						if($checkCount == 0){
						
							$basic = array();
							$basic['PROPERTY_NAME'] 		= $this->input->post('propertyname');
							if(strlen($basic['PROPERTY_NAME']) <= 4){
								$basic['PROPERTY_NAME'] = trim($this->input->post('street_no')). ' '. trim($this->input->post('city_name')). ' '.trim($this->input->post('state_name')); 
							}
							/*Dynamic url create for property*/
							$url_sort = strtolower(str_replace(" ", "-", trim($basic['PROPERTY_NAME'])));
							$checkUrl = $this->any_where_count(array('PROPERTY_URL' => $url_sort), 'p_property_basic', 'PROPERTY_URL');
							if($checkUrl == 0){
									$basic['PROPERTY_URL'] 		= str_replace(" ", "-", $url_sort);
							}else{
									$basic['PROPERTY_URL'] 		= str_replace(" ", "-", $url_sort.'-'.time());
							}
							/*Dynamic url create for property end*/

							/*Search Property Id*/

							$basic['PRO_CATEGORY_ID'] 		= $categoryId; // property category "sell"
							$basic['PROPERTY_TYPE_ID'] 		= $data['type']; // property type "by post"
							$basic['PROPERTY_STREET_NO']            = trim($this->input->post('street_no'));
							$basic['PROPERTY_STREET_ADDRESS']       = trim($this->input->post('street_address'));
							$basic['POSTAL_CODE']       	= trim($this->input->post('post_name'));
							$basic['PROPERTY_CITY'] 		= trim($this->input->post('city_name'));
							$basic['PROPERTY_STATE']		= trim($this->input->post('state_name'));
							$basic['PROPERTY_COUNTRY'] 		= $this->input->post('country_id');
							$basic['CURRENCY_CODE'] 		= $currency_code;
							$basic['CURRENCY_SAMPLE'] 		= $currency_sample;
							$basic['PROPERTY_WONERSHIP']            = $this->input->post('property_wonership');
							$basic['PROPERTY_AUCTION'] 		= isset($_POST['online_offer']) ? $_POST['online_offer'] : 'No';
							$basic['PROPERTY_PRICE'] 		= trim(str_replace(',', '', $this->input->post('propertyprice')));
							$basic['PROPERTY_DESCRIPTION']          = htmlspecialchars($this->input->post('discrition'));
							$basic['COMPANY_ID'] 			= $this->conpanyID;
							$basic['USER_ID'] 			= $userID;
							$basic['ENT_DATE'] 			= date("Y-m-d");
							$basic['PROPERTY_STATUS'] 		= 'Active';
							
							if ($this->db->insert('p_property_basic', $basic)) {
								$propertyId = $this->db->insert_id();

								/* start dynamic filed upload */
								if (sizeof($data['dynamic_filed']) > 0) {
									foreach ($data['dynamic_filed'] AS $filed) {
										$dataFiled = $this->input->post($filed->FILED_ID_NAME);
										if (strlen($dataFiled) > 0) {
											$addition = array();
											$addition['ADD_FILED_ID'] 	= $filed->ADD_FILED_ID;
											$addition['PROPERTY_ID'] 	= $propertyId;
											$addition['FILED_DATA'] 	= $dataFiled;
											if($filed->FILED_TYPE == 'text_select'){
												$addition['FILED_OTHERS'] 	= $this->input->post($filed->FILED_ID_NAME.'__select');
											}
											$addition['FILED_TYPE'] 	= 'Fixed';
											$addition['COMPANY_ID'] 	= $this->conpanyID;
											$addition['USER_ID'] 		= $userID;
											$addition['ENT_DATE'] 		= date("Y-m-d");
											$addition['FILED_STATUS'] 	= 'Active';
											$this->db->insert('p_property_additional', $addition);
										}
									}/* end foreach additional filed */
								}/* end size of dynamic additional filed */

								/* start addition more filed */
								$headding = $this->input->post('headding');
								$value = $this->input->post('value');
								if (sizeof($headding) > 0) {
									$val = 0;
									foreach ($headding as $headData) {
										if (strlen($headData) > 1) {
											$addition_more = array();
											$addition_more['PROPERTY_ID'] 	= $propertyId;
											$addition_more['FILED_DATA'] 	= $value[$val];
											$addition_more['FILED_OTHERS'] 	= $headData;
											$addition_more['FILED_TYPE'] 	= 'Dynamic';
											$addition_more['COMPANY_ID'] 	= $this->conpanyID;
											$addition_more['USER_ID'] 		= $userID;
											$addition_more['ENT_DATE'] 		= date("Y-m-d");
											$addition_more['FILED_STATUS'] 	= 'Active';
											$this->db->insert('p_property_additional', $addition_more);
											$val++;
										}
									}
								}
								/* end addition more filed */

								/**multiple image upload start*/
								if( count( $_FILES['property_image']['name']) > 0 ){
								   $number_of_files = count( $_FILES['property_image']['name'] );
								   $files = $_FILES;
								   $upload_path = 'images/'.$category.'/' . $this->conpanyID . '/' . $userID . '/' . date("Y") . '/' . date("m") . '/';
									if( !is_dir( $upload_path ) ){
										mkdir($upload_path, 0777, TRUE );
									}
									for( $i = 0; $i < $number_of_files; $i++ ){
										
										$file = $files['property_image']['name'][$i];
										$file_exp = explode('.', $file);
										$file_count = count($file_exp);
										$extion = $file_exp[$file_count-1];
										$file_full = $file_exp[0].time().'.'.$extion;

										$_FILES['property_image']['name']       = $file_full;
										$_FILES['property_image']['type']       = $files['property_image']['type'][$i];
										$_FILES['property_image']['tmp_name']   = $files['property_image']['tmp_name'][$i];
										$_FILES['property_image']['error']      = $files['property_image']['error'][$i];
										$_FILES['property_image']['size']       = $files['property_image']['size'][$i];
										
										$config['upload_path']      = $upload_path;
										$config['allowed_types']    = 'jpg|jpeg|png|gif';
										$config['max_size']         = '0';
										$config['max_width']        = '0';
										$config['max_height']       = '0';
										$config['overwrite']        = TRUE;
										$config['remove_space']     = TRUE;  
								
										$this->upload->initialize( $config );									
										if( !$this->upload->do_upload( 'property_image' ) ){
                                                                                    $error = array( 'error' => $this->upload->display_error() );
										} else {
										   $uploadData =  $this->upload->data();
										   $sdata = array();
										   $sdata['IMAGE_NAME'] 	= $uploadData['file_name'];
										   //$sdata['IMAGE_LINK'] 	= $uploadData['path'];
										   $sdata['IMAGE_LINK'] 	= $upload_path;
										   $sdata['PROPERTY_ID'] 	= $propertyId;
										   $sdata['COMPANY_ID'] 	= $this->conpanyID;
										   $sdata['USER_ID'] 		= $userID;
										   if( $i == 0 ){
                                                                                        $sdata['DEFAULT_IMAGE'] = 1;
										   }else {
											$sdata['DEFAULT_IMAGE'] = 0;
										   }
										   $sdata['ENT_DATE'] = date("Y-m-d");
										   $sdata['IMAGE_STATUS'] = 'Active';
										   
										   $this->db->insert( 'p_property_images', $sdata ); 
										}
										
									} /* --- End for() ..*/
									
								
								} /*--End IF(count( $_FILES['property_image']))---*/

								/* End Image Upload......  */

								/* start video section */
								$video_type = $this->input->post('video_type');
								$videoAdd = array();
								if($video_type == 4){
										$nameVideo = $_FILES['property_video']['name'];
										$file_exp = explode('.', $nameVideo);
										$file_count = count($file_exp);
										$extion = $file_exp[$file_count-1];
										$file_full = $file_exp[0].time().'.'.$extion;

										$upload_path = 'images/'.$category.'/' . $this->conpanyID . '/' . $userID . '/' . date("Y") . '/' . date("m") . '/';
										if( !is_dir( $upload_path ) ){
												mkdir($upload_path, 0777, TRUE );
										}

										$_FILES['property_video']['name']       = $file_full;
										$_FILES['property_video']['type']       = $files['property_video']['type'];
										$_FILES['property_video']['tmp_name']   = $files['property_video']['tmp_name'];
										$_FILES['property_video']['error']      = $files['property_video']['error'];
										$_FILES['property_video']['size']       = $files['property_video']['size'];

										$config['upload_path']      = $upload_path;
										$config['allowed_types']    = 'mp4|MP4|MKV|mkv|FLV|flv|MOV|mov|WMV|wmv';
										$config['max_size']         = '5120';
										$config['max_width']        = '0';
										$config['max_height']       = '0';
										$config['overwrite']        = TRUE;
										$config['remove_space']     = TRUE;
										$this->upload->initialize( $config );									
										if( !$this->upload->do_upload( 'property_video' ) ){
												$error = array( 'error' => $this->upload->display_error() );
										} else {
												$uploadData =  $this->upload->data();
												$videoAdd['VIDEOS_NAME'] = $file_full;
												$videoAdd['VIDEOS_LINK'] = $upload_path;
												$videoAdd['PROPERTY_ID'] = $propertyId;
												$videoAdd['VIDEO_TYPE_ID'] = $video_type;
												$videoAdd['VIDEOS_DESCRIPTION'] = 'Upload';
												$videoAdd['COMPANY_ID'] = $this->conpanyID;
												$videoAdd['USER_ID'] = $userID;
												$videoAdd['ENT_DATE'] = date("Y-m-d");
												$videoAdd['VIDEOS_STATUS'] = 'Active';
												$this->db->insert('p_property_videos', $videoAdd);
										}

								}else{
										$property_video = $this->input->post('property_video');

										if (strlen($property_video) > 15) {
												$videoAdd['VIDEOS_LINK'] = $property_video;
												$videoAdd['PROPERTY_ID'] = $propertyId;
												$videoAdd['VIDEO_TYPE_ID'] = $video_type;
												$videoAdd['VIDEOS_DESCRIPTION'] = '';
												$videoAdd['COMPANY_ID'] = $this->conpanyID;
												$videoAdd['USER_ID'] = $userID;
												$videoAdd['ENT_DATE'] = date("Y-m-d");
												$videoAdd['VIDEOS_STATUS'] = 'Active';
												$this->db->insert('p_property_videos', $videoAdd);
										}
								}
								/* end video section */

								/* start section for near by */
								$org_name = $this->input->post('org_name');
								$distance = $this->input->post('distance');
								$location = $this->input->post('location');
								if (sizeof($org_name) > 0) {
									$org = 0;
									foreach ($org_name AS $org_data) {
										if (strlen($org_data) > 1) {
											$org_info = array();
											$org_info['PROPERTY_ID'] = $propertyId;
											$org_info['NEAR_ORG_NAME'] = $org_data;
											$org_info['NEAR_ORG_DISTANCE'] = $distance[$org];
											$org_info['LOCATION_ID'] = $location[$org];
											$org_info['NEAR_STATUS'] = 'Active';
											$this->db->insert('p_property_nearby', $org_info);
											$org++;
										}
									}
								}
								/* end section for near by */
								
								/*Start Property add Hot price and auction*/

								$auction_type 		= $this->input->post('add_property_other_option', true);

								if($auction_type == 'hot'){
									if($this->db->update( 'p_property_basic', array( 'HOT_PRICE_PROPERTY' => 'Yes', 'PROPERTY_STATUS' => 'Active' ), array( 'PROPERTY_ID' => $propertyId, 'USER_ID' => $userID ) ) ){
											$hot_insert = array();
											$hot_insert['OFFER_PRICE']          = str_replace(',', '', $this->input->post( 'offer_price' ));
											$hot_insert['OFFER_TYPE']           = 'Hot';
											$hot_insert['OFFER_START_DATE']     = $this->input->post( 'hot_price_start_date' );
											$date_limit                         = $this->input->post( 'hot_price_end_date' );
											$dateType                           = $this->input->post( 'dateType' );
											$hot_insert['OFFER_END_DATE']       = $this->modify_date_time($hot_insert['OFFER_START_DATE'], $date_limit, $dateType);
											$hot_insert['PROPERTY_ID']          = $propertyId;
											$hot_insert['COMPANY_ID']           = $this->conpanyID;
											$hot_insert['USER_ID']              = $userID;
											$hot_insert['ENT_DATE']             = date('Y-m-d');
											$hot_insert['OFFER_STATUS']         = 'Active';
											//$hot_insert['OFFER_STATUS']         = 'Pending';
											$this->db->insert( 'p_property_offers' , $hot_insert );
									}
								}else if($auction_type == 'auction'){

									if($this->db->update( 'p_property_basic', array( 'PROPERTY_AUCTION' => 'Yes', 'PROPERTY_STATUS' => 'Active' ), array( 'PROPERTY_ID' => $propertyId, 'USER_ID' => $userID ) ) ){
											$bidStartDate = $this->input->post( 'offer_start_date' );
											$bidTime = $this->input->post( 'offer_end_date' );
											$dateType = $this->input->post( 'dateType' );
											$bidding = array(
													'OFFER_PRICE'           => str_replace( ',', '', $this->input->post( 'offer_start_price' )),
													'BIDDING_WIN_PRICE'     => str_replace( ',', '', $this->input->post( 'offer_win_price' )),
													'OFFER_TYPE'            => 'Bid',
													'OFFER_START_DATE'      => $bidStartDate,
													'OFFER_END_DATE'        => $this->modify_date_time( $bidStartDate, $bidTime, $dateType ),
													'PROPERTY_ID'           => $propertyId,
													'COMPANY_ID'            => $this->conpanyID,
													'USER_ID'               => $userID,
													'ENT_DATE'              => date('Y-m-d'),
													'OFFER_STATUS'          => 'Active',
													//'OFFER_STATUS'          => 'Pending',
											);
										if($this->db->insert( 'p_property_offers', $bidding ) ){
											 redirect( SITE_URL . 'payment-auction?bidPropertyID='.$propertyId, 'refresh' );
										}
									}
								}


								/*end Property add Hot price and auction*/
								
							}
							$session_data = array();
							$session_data['message'] = "Add Property Information Successfully!";
							$this->session->set_userdata($session_data);
							redirect( $category.'?type=0', 'refresh' );
						}else{
							$session_data = array();
							$session_data['message'] = "Sorry, You have a property in this Street No..!!";
							$this->session->set_userdata($session_data);
						}
                    }
                    /** end submit form* */
                } else {
                   // $data['type'] = 'sell';
                    $data['dynamic_filed'] = array();
                }
				$this->hpp_order = $this->hpp_order_column = $this->hpp_select = $this->hpp_order = '';	
                //select video url..
                $data['select_video_type'] = $this->any_where(array('TYPE_STATUS' => 'Active'), 'mt_p_video_type');
                $data['location_near'] = $this->any_where(array('STATUS_LOCATION' => 'Active'), 'mt_p_nearby_location');
                $data['COUNTRYES'] 	   = $this->Property_Model->select_country('', '');
                
                $this->hpp_select 		= 'DISTINCT(PROPERTY_STATE)';
                $this->hpp_order_column = 'ENT_DATE';
                $this->hpp_order 		= 'DESC';
                $data['PROPERTY_STATE_DATA'] 		= $this->any_where(array('PROPERTY_STATE !=' => ''), 'p_property_basic', '');
                $this->hpp_select 		= 'DISTINCT(PROPERTY_CITY)';
                $data['PROPERTY_CITY_DATA'] 		= $this->any_where(array('PROPERTY_CITY !=' => ''), 'p_property_basic', '');
                $this->hpp_select 		= 'DISTINCT(PROPERTY_STREET_ADDRESS)';
                $data['PROPERTY_ADDRSS_DATA'] 		= $this->any_where(array('PROPERTY_STREET_ADDRESS !=' => ''), 'p_property_basic', '');
                $this->hpp_select 		= 'DISTINCT(PROPERTY_STREET_NO)';
                $data['PROPERTY_STRETT_DATA'] 		= $this->any_where(array('PROPERTY_STREET_NO !=' => ''), 'p_property_basic', '');
				
                $data['main_content'] = $this->load->view('page_templates/property/add_property', $data, true);
            } else {
                $data['main_content'] = $this->load->view('errors/errors_page', $data, true);
            }
        } else {
            redirect(SITE_URL . 'login?page='.$category.'');
        }


        $this->load->view('master', $data);
    }

    /** property search by type* */

    public function searchProperty($type = 'buy') {
        $data = array();
        $query = array();
        $property = array();
		$join = array();	
		
		if($type == 'buy'){
			$title = 'Buy';
			$query['PRO_CATEGORY_NAME'] = 'Sell';
			//$property['pro.HOT_PRICE_PROPERTY'] = 'No';
            //$property['pro.PROPERTY_AUCTION'] = 'No';
		}else if($type == 'rent'){
			$title = 'Rent';
			$query['PRO_CATEGORY_NAME'] = 'Rent';
            //$property['pro.HOT_PRICE_PROPERTY'] = 'No';
            //$property['pro.PROPERTY_AUCTION'] = 'No';
		}else if($type == 'auction'){
			$title = 'Auction';
			$query['PRO_CATEGORY_NAME'] = 'Sell';
			$property['pro.PROPERTY_AUCTION'] = 'Yes';
			$property['pro.HOT_PRICE_PROPERTY'] = 'No';
			$join = array('p_property_offers AS offer', 'pro.PROPERTY_ID = offer.PROPERTY_ID', 'inner');
		}else if($type == 'hot_price'){
			$title = 'Hot Price';
			$property['pro.HOT_PRICE_PROPERTY'] = 'Yes';
            $property['pro.PROPERTY_AUCTION'] = 'No';
			$query['PRO_CATEGORY_NAME'] = 'Sell';
            $join = array('p_property_offers AS offer', 'pro.PROPERTY_ID = offer.PROPERTY_ID', 'inner');
        }else {
            $title = 'Buy';
			$query['PRO_CATEGORY_NAME'] = 'Sell';	
        }
		$query['PRO_CATEGORY_STATUS'] = 'Active';
                
		$type_id = $this->any_where($query, 'mt_p_property_category', 'PRO_CATEGORY_ID');
		
        $data['PROPERTY_NAME_select'] = $data['PROPERTY_STATE_ID'] = $data['PROPERTY_STREET_NO_ID'] = $data['PROPERTY_STREET_ADDRESS_ID'] = $data['PROPERTY_CITY_ID'] = $data['PROPERTY_COUNTRY_ID'] = $data['type_select'] = '';
		
		$data['property_type'] 	= $this->any_where(array('PROPERTY_TYPE_STATUS' => 'Active'), 'mt_p_property_type');
		$this->hpp_select 	 = 'DISTINCT(PROPERTY_STATE)';
		$this->hpp_order_column  = 'ENT_DATE';
		$this->hpp_order 		= 'DESC';
		$data['location'] 		= $this->any_where(array('PROPERTY_STATE !=' => '', 'PROPERTY_STATUS' => 'Active',  'PRO_CATEGORY_ID' => $type_id), 'p_property_basic', '');
		
		$this->hpp_select 		= 'MIN(PROPERTY_PRICE) AS PROPERTY_PRICE';
		$data['price_min'] 		= $this->any_where(array('PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id), 'p_property_basic', 'PROPERTY_PRICE');
		$this->hpp_select 		= 'MAX(PROPERTY_PRICE) AS PROPERTY_PRICE';
		$data['price_max'] 		= $this->any_where(array('PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id), 'p_property_basic', 'PROPERTY_PRICE');
		 //$data['price_max'] = 200;
		$data['price_min_val'] = $data['price_min'];	
		$data['price_max_val'] = $data['price_max'];
		
		$this->hpp_select 		= 'DISTINCT(PROPERTY_NAME)';
		$data['PROPERTY_NAME_DATA'] 	= $this->any_where(array('PROPERTY_NAME !=' => '', 'PRO_CATEGORY_ID' => $type_id, 'PROPERTY_STATUS' => 'Active'), 'p_property_basic', '');
		
		$this->hpp_select 		= 'DISTINCT(PROPERTY_STREET_NO)';
		$data['PROPERTY_STREET_NO'] 		= $this->any_where(array('PROPERTY_STREET_NO !=' => '', 'PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id), 'p_property_basic', '');
		
		$this->hpp_select 		= 'DISTINCT(PROPERTY_STREET_ADDRESS)';
		$data['PROPERTY_STREET_ADDRESS'] 	= $this->any_where(array('PROPERTY_STREET_ADDRESS !=' => '', 'PROPERTY_STATUS' => 'Active', 'PRO_CATEGORY_ID' => $type_id), 'p_property_basic', '');
		
		$this->hpp_select 		= 'DISTINCT(PROPERTY_CITY)';
		$data['PROPERTY_CITY'] 	= $this->any_where(array('PROPERTY_CITY !=' => '', 'PROPERTY_STATUS' => 'Active','PRO_CATEGORY_ID' => $type_id), 'p_property_basic', '');
		
		$this->hpp_order = $this->hpp_order_column = $this->hpp_select = $this->hpp_limit = $this->hpp_offset = '';
		
		$data['PROPERTY_COUNTRY'] 	   = $this->Property_Model->select_country('', '');
		
		
		
		$data['dynamic_filed'] = $this->Property_Model->property_fileld();
		//print_r($data['dynamic_filed']);
		
		$data['title'] = 'Property search by ' . $title . ' | HPP';
        $data['type'] = $title;
		
        $property1 = array();
		$sub_query = '';
		if($type_id > 0){
			$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : ''; 
			if(strlen($keyword) > 0){
				$sub_query .= "(LOWER(pro.PROPERTY_NAME) LIKE '%".strtolower($keyword)."%' OR LOWER(pro.PROPERTY_STREET_NO) LIKE '%".strtolower($keyword)."%' OR LOWER(pro.PROPERTY_STREET_ADDRESS) LIKE '%".strtolower($keyword)."%' OR LOWER(pro.PROPERTY_STATE) LIKE '%".strtolower($keyword)."%' OR LOWER(pro.PROPERTY_CITY) LIKE '%".strtolower($keyword)."%' OR LOWER(pro.PROPERTY_PRICE) LIKE '%".strtolower($keyword)."%' OR LOWER(pro.POSTAL_CODE) LIKE '%".strtolower($keyword)."%')";
				$data['PROPERTY_NAME_select'] = $keyword;				
			}
			
			$type_select = isset($_GET['type_select']) ? trim($_GET['type_select']) : ''; 
			if(strlen($type_select) > 0){
				$property['pro.PROPERTY_TYPE_ID'] = $type_select;
				$data['type_select'] = $type_select;	
			}
			
			$street_no = isset($_GET['street_no']) ? trim($_GET['street_no']) : ''; 
			if(strlen($street_no) > 0){
				$property['LOWER(pro.PROPERTY_STREET_NO) LIKE'] = '%'.strtolower($street_no).'%';
				$data['PROPERTY_STREET_NO_ID'] = $street_no;	
			}
			
			$street_no_address = isset($_GET['street_address']) ? $_GET['street_address'] : ''; 
			if(strlen($street_no_address) > 0){
				$property['LOWER(pro.PROPERTY_STREET_ADDRESS) LIKE'] = '%'.strtolower($street_no_address).'%';
				$data['PROPERTY_STREET_ADDRESS_ID'] = $street_no_address;	
			}
			
			$city = isset($_GET['city']) ? $_GET['city'] : ''; 
			if(strlen($city) > 0){
				$property['LOWER(pro.PROPERTY_CITY) LIKE'] = '%'.$city.'%';
				$data['PROPERTY_CITY_ID'] = $city;	
			}
			
			$location_name = isset($_GET['location_name']) ? $_GET['location_name'] : ''; 
			if(strlen($location_name) > 0){
				$property['LOWER(pro.PROPERTY_STATE) LIKE'] = '%'.strtolower($location_name).'%';
				$data['PROPERTY_STATE_ID'] = $location_name;	
			}
			
			$country = isset($_GET['country']) ? $_GET['country'] : ''; 
			if(strlen($country) > 0){
				$property['pro.PROPERTY_COUNTRY'] = $country;
				$data['PROPERTY_COUNTRY_ID'] = $country;	
			}
			
			$price_range = isset($_GET['price_range']) ? $_GET['price_range'] : ''; 
			if(strlen($price_range) > 0){
				$price_exp = explode(',', $price_range);
				$min_price = $price_exp[0];
				$max_price = $price_exp[1];
				$property['pro.PROPERTY_PRICE >='] = $min_price;
				$property['pro.PROPERTY_PRICE <='] = $max_price;
				$data['price_min_val'] = $min_price;	
				$data['price_max_val'] = $max_price;	
				
			}
			
			 if(is_array($join) AND sizeof($join) > 2){
				 $property['offer.OFFER_START_DATE <='] = date("Y-m-d H:i:s");
				 $property['offer.OFFER_END_DATE >='] = date("Y-m-d H:i:s");
				 $property['offer.OFFER_STATUS'] = 'Active';
				 
				 $this->hpp_order_column  = 'offer.OFFER_START_DATE';
				 $this->hpp_order 	 = 'ASC';
			}else{
				$this->hpp_order_column  = 'pro.PROPERTY_ID';
				$this->hpp_order 	 = 'DESC';
			}
			$property['pro.PRO_CATEGORY_ID'] = $type_id;
			$property['pro.PROPERTY_STATUS'] = 'Active';
			
			/*---pageination--*/
			//print($sub_query);
			$totalCount = $this->Property_Model->property_basic( $property , $join, $sub_query);
			$coutn =  sizeof($totalCount);
			$getOffset = isset($_GET['page']) ? $_GET['page'] : 1;
			
			$pagiData = array();
			$pagiData['total_count'] = $coutn;
			$pagiData['offset_name'] = 'page';
			$pagiData['offset'] = $getOffset;
			$pagiData['limit'] = 9; // Per page
			
			$startFrom = $this->Property_Model->hpp_pagination($pagiData);
			 
			$this->hpp_limit = $pagiData['limit'];
			$this->hpp_offset = $startFrom;
                        
			$data['select_all_sell_property'] = $this->Property_Model->property_basic( $property , $join, $sub_query); //Sell ID=1  
			//echo $this->db->last_query();
		}
		
        $data['main_content'] = $this->load->view('page_templates/property/property_search', $data, true);

        $this->load->view('master', $data);
    }

	
	
    public function property_details(){
            $data = array();
            $data['MASG'] = '';
            $propertyD = array();
		
        $get = $this->input->get('view', '');

        $propertyD['PROPERTY_URL'] = $get;
        $property = $this->Property_Model->property_basic( $propertyD );
        if(is_array($property) AND sizeof($property) > 0){
                 //$data['PROPERTY_URL']   = $get;
                 $data['title']          		 = $property[0]['PROPERTY_NAME'].' | HPP';
                 $data['property'] 		 	 = $property[0];	
                 $data['additional'] 	 		 = $this->Property_Model->additional_property_filed($property[0]['PROPERTY_ID']);
                 $data['additional_other'] 	 	 = $this->Property_Model->additional_property_filed($property[0]['PROPERTY_ID'], 'Dynamic');
                 $data['near_by'] 	 	 	 = $this->Property_Model->property_near_by($property[0]['PROPERTY_ID']);
                 $data['images_property'] 	 	 = $this->Property_Model->property_image(array('PROPERTY_ID' => $property[0]['PROPERTY_ID']));
                 $data['video_property'] 	 	 = $this->Property_Model->property_video(array('PROPERTY_ID' => $property[0]['PROPERTY_ID']));
                 $data['offer_price_bid'] 		 = $this->Property_Model->any_type_where(array('PROPERTY_ID' => $property[0]['PROPERTY_ID'], 'OFFER_TYPE' => 'Bid', 'OFFER_STATUS !=' => 'DeActive'), 'p_property_offers');
                 $data['offer_price_hot'] 		 = $this->Property_Model->any_type_where(array('PROPERTY_ID' => $property[0]['PROPERTY_ID'], 'OFFER_TYPE' => 'Hot', 'OFFER_STATUS !=' => 'DeActive'), 'p_property_offers');

                 $BIDDING_PRICE = 0;
                 $WIN_BIDDING_PRICE = 0;
                 $startDate = date("Y-m-d h:i:s");
                 $lastDate = date("Y-m-d h:i:s");
                 if(is_array($data['offer_price_bid']) AND sizeof($data['offer_price_bid']) > 0){
                         $BIDDING_PRICE 		= $data['offer_price_bid'][0]['OFFER_PRICE'];
                         $WIN_BIDDING_PRICE 	= $data['offer_price_bid'][0]['BIDDING_WIN_PRICE'];
                         $startDate 			= $data['offer_price_bid'][0]['OFFER_START_DATE'];
                         $lastDate 				= $data['offer_price_bid'][0]['OFFER_END_DATE'];
                 }

                 $offr_bid = $this->db->query("SELECT OFFER_BID_PRICE FROM p_property_offers_bidding WHERE PROPERTY_ID = ".$property[0]['PROPERTY_ID']." AND OFFER_BID_STATUS = 'Active' ORDER BY OFFER_BID_PRICE DESC LIMIT 0,1");
                 $offr_bid_val = $offr_bid->result_array();
                if(is_array($offr_bid_val) AND sizeof($offr_bid_val) > 0){
                        $BIDDING_PRICE = $offr_bid_val[0]['OFFER_BID_PRICE'];
                }												
                $data['contact_agent_type']	= array('Name' => 'name_contact', 'Email' => 'email_address', 'Phone' => 'phone_no', 'About me' => 'about_me', 'Request' => 'request', 'Message to' => 'message');
                $data['MASG_BID'] = '';
                $userID = $this->session->userData('userID');
                $logged_in = $this->session->userData('logged_in');
                $data['account_type'] = $this->session->userData('userType');
                 if(isset($_POST['contact_agent_message'])){

                        if ($userID > 0 AND $logged_in == TRUE AND $property[0]['USER_ID'] != $userID AND $data['account_type'] == 2) {
                                 $sms_agent = array();
                                 $sms_agent['FROM_USER'] 	= $userID;
                                 $sms_agent['TO_USER'] 	 	= $property[0]['USER_ID'];
                                 $sms_agent['PROPERTY_ID'] 	= $property[0]['PROPERTY_ID'];
                                 $sms_agent['CONTACT_SUBJECT'] 	= 'Contact Property - '.$property[0]['PROPERTY_NAME'].'';
                                 $sms_agent['COMPANY_ID'] 	= $this->conpanyID;
                                 $sms_agent['ENT_DATE'] 	= date('Y-m-d');
                                 $sms_agent['ENT_DATE_TIME'] 	= date('Y-m-d h:i:s');
                                 $sms_agent['SMS_TYPE'] 	= 'Email';
                                 $sms_agent['SMS_STATUS'] 	= 'Send';
                                 
                                 if($this->db->insert('sms_contact_agent_user', $sms_agent)){
                                         $sms_id = $this->db->insert_id();

                                         $sms_agent_d = array();							 
                                         $sms_agent_d['CONTACT_AGENT_ID'] 	= $sms_id;
                                         $sms_agent_d['COMPANY_ID'] 		= $this->conpanyID;
                                         $sms_agent_d['FROM_USER'] 			= $userID;
                                         $sms_agent_d['TO_USER'] 			= $property[0]['USER_ID'];
                                         $sms_agent_d['MESSAGE_TITLE'] 		= 'Contact Info - '.$property[0]['PROPERTY_NAME'].'';
                                         $sms_agent_d['ENT_DATE'] 	 		= date('Y-m-d');
                                         $sms_agent_d['ENT_DATE_TIME'] 		= date('Y-m-d h:i:s');
                                         $sms_agent_d['SMS_DET_STATUS'] 	= 'Active';

                                         $mailBody = '';
                                         foreach($data['contact_agent_type'] AS $key=>$contact_agent){
                                            $dataAgent = $this->input->post($contact_agent);

                                            if(is_array($dataAgent) AND sizeof($dataAgent) > 0){	
                                                $join_data = '';
                                                foreach($dataAgent AS $valueAgent):
                                                    if(strlen($valueAgent) > 1){
                                                        $join_data .= $valueAgent.' - ';
                                                    }
                                                endforeach;
                                                $mailBody .= '<p> <b>'.$key.'</b> : '.rtrim($join_data, ' - ').'</p>';

                                            }else{
                                                if(strlen($dataAgent) > 1){
                                                    $mailBody .= '<p> <b>'.$key.'</b> : '.$dataAgent.'</p>';
                                                }
                                            }


                                         }
                                         $sms_agent_d['MESSAGE_DATA'] = htmlspecialchars($mailBody);


                                         $this->db->insert('sms_contact_agent_user_details', $sms_agent_d);

                                         $userEmail = $this->user->select_user_mail($property[0]['USER_ID']);

                                        if($this->MailerModel->sendEmail($userEmail, $sms_agent['CONTACT_SUBJECT'], $mailBody)){
                                            $data['MASG'] = 'Successfully message send to seller';
                                        }


                                 }

                        }else {
                            redirect(SITE_URL . 'login?page=preview?view='.$property[0]['PROPERTY_URL'].'$$contact_seller');
                        }

                 }

                  /**Start bidding price**/
                 $hpp_user = $this->user->admin_login_id();
                 //$hpp_user = $property[0]['USER_ID'];
                        $data['MASG_BID'] = '';
                        $getBid = isset($_GET['bid']) ? $_GET['bid'] : 'close';
                        if(isset($_POST['bidding_post'])){
                                if ($userID > 0 AND $logged_in == TRUE) { 
                                         $biding_post = array();
                                         $biding_post['OFFER_BID_PRICE'] = trim(str_replace(',', '', $this->input->post('bid_price', true)));
                                         $biding_post['OFFER_BID_DETAILS'] = $this->input->post('bid_price_details', true);
                                         $biding_post['PROPERTY_ID'] = $property[0]['PROPERTY_ID'];
                                         $biding_post['OFFER_P_ID'] = isset($_GET['datatype']) ? $_GET['datatype'] : '0';
                                         $biding_post['COMPANY_ID'] = $this->conpanyID;
                                         $biding_post['USER_ID'] = $userID;
                                         $biding_post['ENT_DATE'] = date("Y-m-d");
                                         $biding_post['OFFER_BID_STATUS'] = 'Active';

                                         $checkData = $this->any_where_count(array('PROPERTY_ID' => $property[0]['PROPERTY_ID'], 'USER_ID' => $userID, 'OFFER_BID_STATUS' => 'Active'), 'p_property_offers_bidding', 'OFFER_BID_ID');
                                         //if($checkData == 0){
											if($biding_post['OFFER_BID_PRICE'] > $BIDDING_PRICE){
												 if($this->db->insert('p_property_offers_bidding', $biding_post)){
														 $data['MASG_BID'] = '<div class="alert alert-success"> Successfully bidding</div>';

														 /*--- Start Insert Email Info into DB --*/
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
														$massege['bid'] = $biding_post['OFFER_BID_PRICE'];
														$massege['last_bid'] = $BIDDING_PRICE;
													   // $massege['bid_date'] = date('Y-m-d H:i:s');
														$massege['bid_date'] = $startDate;
														$massege['address'] = $address;
														$massege['url_property'] = $property[0]['PROPERTY_URL'];
														$massege['last_bid_date'] = $lastDate;
														$massege['company_info'] = $this->company_header();

														/*Bidding close for avobe price*/
														if($WIN_BIDDING_PRICE <= $biding_post['OFFER_BID_PRICE']){
														   // $massageSentData = array('win');
															$massageSentData = array('info');
															$winMass = '';
														}else{
															$massageSentData = array('info');											
														}

														$propertyID = $property[0]['PROPERTY_ID'];
														$OFFER_P_ID = $biding_post['OFFER_P_ID'];

														foreach($massageSentData AS $sentType):

																if($sentType == 'win'){
																		//$fromUser = 0;
																		$fromUser = $property[0]['USER_ID'];


																		$messageBody = $this->load->view('mailScripts/auction_short_summery_close', $massege, TRUE);
																		$subjectName = 'HPP Bid Win Information - '.$property[0]['PROPERTY_NAME'];
																		$massage_title = 'Bid Win Info - '.$biding_post['OFFER_BID_PRICE'].'';

																		$changeProperty = $this->db->update('p_property_offers', array('WIN_USER' => $this->userID, 'OFFER_STATUS' => 'Win'), array('PROPERTY_ID' => $propertyID, 'OFFER_TYPE' => 'Bid', 'OFFER_P_ID' => $OFFER_P_ID));

																		$changeProperty = $this->db->update('p_property_basic', array('SELL_USER' => $this->userID, 'SELL_PRICE' => $biding_post['OFFER_BID_PRICE'], 'SELL_DATE' => date("Y-m-d"), 'PROPERTY_STATUS' => 'Sell'), array('PROPERTY_ID' => $propertyID));

																		$bidderInfo = $this->db->query("SELECT * FROM p_property_offers_bidding WHERE PROPERTY_ID = $propertyID AND OFFER_BID_STATUS = 'Active' AND USER_ID != $this->userID");
																		$bidderArray = $bidderInfo->result_array();
																		foreach($bidderArray AS $bidder){
																			$subjectCloase = 'Bid Close - '.$property[0]['PROPERTY_NAME'];

																			$messageBodyS = $this->load->view('mailScripts/auction_short_summery_close_all', $massege, TRUE);
																			$emailInfo = array(
																									'FROM_USER'         => $hpp_user,
																									'FROM_TYPE'         => 'Hpp',
																									'TO_USER'           => $bidder['USER_ID'],
																									'PROPERTY_ID'       => $propertyID,
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
																										'FROM_USER'         => $hpp_user,
																										'FROM_TYPE_D'         => 'Hpp',
																										'TO_USER'           => $this->userID,
																										'MESSAGE_TITLE'     => $massage_title,
																										'MESSAGE_DATA'      => htmlspecialchars($messageBodyS),
																										'ENT_DATE'	 		=> date('Y-m-d'),
																										'ENT_DATE_TIME' 	=> date('Y-m-d h:i:s'),
																										'SMS_DET_STATUS' 	=> 'Active'
																								);
																					$this->db->insert( 'sms_contact_agent_user_details', $emailDetails );
																					$userEmailS = $this->user->select_user_mail($bidder['USER_ID']);
																					$this->MailerModel->sendEmail($userEmailS, $subjectCloase, $messageBodyS);

																			}
																		}

																}else{
																	$messageBody = $this->load->view('mailScripts/auction_short_summery', $massege, TRUE);
																	$subjectName = 'HPP Bidding Information - '.$property[0]['PROPERTY_NAME'];
																	$massage_title = 'Bidding Info - '.$biding_post['OFFER_BID_PRICE'].'';
																	$fromUser = $property[0]['USER_ID'];
																	//$hpp_user = $property[0]['USER_ID'];
																}
																if($fromUser == 0){
																	$fromUser = $hpp_user;
																	$form_type = 'Hpp';
																}else{
																	$form_type = 'User';
																}
																$emailInfo = array(
																				'FROM_USER'         => $fromUser,
																				'FROM_TYPE'         => $form_type,
																				'TO_USER'           => $this->userID,
																				'PROPERTY_ID'       => $propertyID,
																				'CONTACT_SUBJECT'   => $subjectName,
																				'COMPANY_ID'        => $this->conpanyID,
																				'ENT_DATE'          => date('Y-m-d'),
																				'ENT_DATE_TIME'     => date('Y-m-d H:i:s'),
																				'SMS_TYPE'          => 'Email',
																		);
																if($this->db->insert( 'sms_contact_agent_user', $emailInfo )){
																		$lastID = $this->db->insert_id();
																		$emailDetails = array(
																							'CONTACT_AGENT_ID'  => $lastID,
																							'COMPANY_ID'        => $this->conpanyID,
																							'FROM_USER'         => $fromUser,
																							'FROM_TYPE_D'       => $form_type,
																							'TO_USER'           => $this->userID,
																							'MESSAGE_TITLE'     => $massage_title,
																							'MESSAGE_DATA'      => htmlspecialchars($messageBody),
																							'ENT_DATE'	 		=> date('Y-m-d'),
																							'ENT_DATE_TIME' 	=> date('Y-m-d h:i:s'),
																							'SMS_DET_STATUS' 	=> 'Active'
																					);
																		$this->db->insert( 'sms_contact_agent_user_details', $emailDetails );

																/*--- End Insert Email Info into DB --*/

																 /*MAIL DATA*/
																		$userEmail = $this->user->select_user_mail();

																		if($this->MailerModel->sendEmail($userEmail, $subjectName, $messageBody)){
																			$data['MASG_BID'] = '<div class="alert alert-success">Successfully '.$subjectName.' ... Please check your email.</div>';
																		}


																 /*END MAIL DATA*/
																}

														endforeach;

												 }
										 }else{
												$data['MASG_BID'] = '<div class="alert alert-info"> Sorry!!! your bidding price must be grather then last bid price</div>'; 
										 }
								 /*}else{
									$data['MASG_BID'] = '<div class="alert alert-danger"> Sorry!!! already bidding this property</div>'; 
								 }*/

							/**Start bidding price end**/
                         }else {
                            redirect(SITE_URL . 'login?page=preview?view='.$property[0]['PROPERTY_URL'].'$$bidding');
                        }
                    }

					if(isset($_POST['hot_offer_post'])){
						if ($userID > 0 AND $logged_in == TRUE) { 
								 $biding_post = array();
								 $biding_post['OFFER_BID_PRICE'] = trim(str_replace(',', '', $this->input->post('bid_price', true)));
								 $biding_post['OFFER_BID_DETAILS'] = $this->input->post('bid_price_details', true);
								 $biding_post['PROPERTY_ID'] = $property[0]['PROPERTY_ID'];
								 $biding_post['OFFER_P_ID'] = isset($_GET['datatype']) ? $_GET['datatype'] : '0';
								 $biding_post['COMPANY_ID'] = $this->conpanyID;
								 $biding_post['USER_ID'] = $userID;
								 $biding_post['ENT_DATE'] = date("Y-m-d");
								 $biding_post['OFFER_BID_STATUS'] = 'Active';

								 $checkData = $this->any_where_count(array('PROPERTY_ID' => $property[0]['PROPERTY_ID'], 'USER_ID' => $userID, 'OFFER_BID_STATUS' => 'Active'), 'p_property_offers_bidding', 'OFFER_BID_ID');
								if($checkData == 0){
								 if($biding_post['OFFER_BID_PRICE'] > $BIDDING_PRICE){
									 if($this->db->insert('p_property_offers_bidding', $biding_post)){
											$data['MASG_BID'] = '<div class="alert alert-success"> Successfully Counter</div>';

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
											$massege['bid'] = $biding_post['OFFER_BID_PRICE'];
											$massege['last_bid'] = $BIDDING_PRICE;
										   // $massege['bid_date'] = date('Y-m-d H:i:s');
											$massege['bid_date'] = $startDate;
											$massege['address'] = $address;
											$massege['url_property'] = $property[0]['PROPERTY_URL'];
											$massege['last_bid_date'] = $lastDate;
											$massege['company_info'] = $this->company_header();

											
											if($WIN_BIDDING_PRICE <= $biding_post['OFFER_BID_PRICE']){
											   // $massageSentData = array('win');
												$massageSentData = array('info');
												$winMass = '';
											}else{
												$massageSentData = array('info');											
											}

											$propertyID = $property[0]['PROPERTY_ID'];
											$OFFER_P_ID = $biding_post['OFFER_P_ID'];

											foreach($massageSentData AS $sentType):

													if($sentType == 'win'){
															//$fromUser = 0;
															$fromUser = $property[0]['USER_ID'];

															$messageBody = $this->load->view('mailScripts/auction_short_summery_close', $massege, TRUE);
															$subjectName = 'HPP Bid Win Information - '.$property[0]['PROPERTY_NAME'];
															$massage_title = 'Bid Win Info - '.$biding_post['OFFER_BID_PRICE'].'';

															$changeProperty = $this->db->update('p_property_offers', array('WIN_USER' => $this->userID, 'OFFER_STATUS' => 'Win'), array('PROPERTY_ID' => $propertyID, 'OFFER_TYPE' => 'Bid', 'OFFER_P_ID' => $OFFER_P_ID));

															$changeProperty = $this->db->update('p_property_basic', array('SELL_USER' => $this->userID, 'SELL_PRICE' => $biding_post['OFFER_BID_PRICE'], 'SELL_DATE' => date("Y-m-d"), 'PROPERTY_STATUS' => 'Sell'), array('PROPERTY_ID' => $propertyID));

															$bidderInfo = $this->db->query("SELECT * FROM p_property_offers_bidding WHERE PROPERTY_ID = $propertyID AND OFFER_BID_STATUS = 'Active' AND USER_ID != $this->userID");
															$bidderArray = $bidderInfo->result_array();
																foreach($bidderArray AS $bidder){
																$subjectCloase = 'Offer Close - '.$property[0]['PROPERTY_NAME'];

																$messageBodyS = $this->load->view('mailScripts/auction_short_summery_close_all', $massege, TRUE);
																$emailInfo = array(
																						'FROM_USER'         => $hpp_user,
																						'FROM_TYPE'         => 'Hpp',
																						'TO_USER'           => $bidder['USER_ID'],
																						'PROPERTY_ID'       => $propertyID,
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
																							'FROM_USER'         => $hpp_user,
																							'FROM_TYPE_D'         => 'Hpp',
																							'TO_USER'           => $this->userID,
																							'MESSAGE_TITLE'     => $massage_title,
																							'MESSAGE_DATA'      => htmlspecialchars($messageBodyS),
																							'ENT_DATE'	 		=> date('Y-m-d'),
																							'ENT_DATE_TIME' 	=> date('Y-m-d h:i:s'),
																							'SMS_DET_STATUS' 	=> 'Active'
																					);
																		$this->db->insert( 'sms_contact_agent_user_details', $emailDetails );
																		$userEmailS = $this->user->select_user_mail($bidder['USER_ID']);
																		$this->MailerModel->sendEmail($userEmailS, $subjectCloase, $messageBodyS);

																}
															}

													}else{
														$messageBody = $this->load->view('mailScripts/auction_short_summery_hot', $massege, TRUE);
														$subjectName = 'HPP Offer Information - '.$property[0]['PROPERTY_NAME'];
														$massage_title = 'Offer Info - '.$biding_post['OFFER_BID_PRICE'].'';
														$fromUser = $property[0]['USER_ID'];
														//$hpp_user = $property[0]['USER_ID'];
													}
													if($fromUser == 0){
														$fromUser = $hpp_user;
														$form_type = 'Hpp';
													}else{
														$form_type = 'User';
													}
													$emailInfo = array(
																	'FROM_USER'         => $fromUser,
																	'FROM_TYPE'         => $form_type,
																	'TO_USER'           => $this->userID,
																	'PROPERTY_ID'       => $propertyID,
																	'CONTACT_SUBJECT'   => $subjectName,
																	'COMPANY_ID'        => $this->conpanyID,
																	'ENT_DATE'          => date('Y-m-d'),
																	'ENT_DATE_TIME'     => date('Y-m-d H:i:s'),
																	'SMS_TYPE'          => 'Email',
															);
													if($this->db->insert( 'sms_contact_agent_user', $emailInfo )){
															$lastID = $this->db->insert_id();
															$emailDetails = array(
																				'CONTACT_AGENT_ID'  => $lastID,
																				'COMPANY_ID'        => $this->conpanyID,
																				'FROM_USER'         => $fromUser,
																				'FROM_TYPE_D'       => $form_type,
																				'TO_USER'           => $this->userID,
																				'MESSAGE_TITLE'     => $massage_title,
																				'MESSAGE_DATA'      => htmlspecialchars($messageBody),
																				'ENT_DATE'	 		=> date('Y-m-d'),
																				'ENT_DATE_TIME' 	=> date('Y-m-d h:i:s'),
																				'SMS_DET_STATUS' 	=> 'Active'
																		);
															$this->db->insert( 'sms_contact_agent_user_details', $emailDetails );

													
															$userEmail = $this->user->select_user_mail();

															if($this->MailerModel->sendEmail($userEmail, $subjectName, $messageBody)){
																$data['MASG_BID'] = '<div class="alert alert-success">Successfully '.$subjectName.' ... Please check your email.</div>';
															}


													 
													}

											endforeach;
											
										 }
								 }else{
										$data['MASG_BID'] = '<div class="alert alert-info"> Sorry!!! your bidding price must be grather then last bid price</div>'; 
								 }
								}else{
								$data['MASG_BID'] = '<div class="alert alert-danger"> Sorry!!! already counter this property</div>'; 
							 }

							/**Start bidding price end**/
                         }else {
                            redirect(SITE_URL . 'login?page=preview?view='.$property[0]['PROPERTY_URL'].'$$bidding');
                        }
                    }

                $data['main_content']   = $this->load->view( 'page_templates/property/property_details', $data , TRUE );
            }else{
                $data['title']          = 'Invalid property url | HPP';
            }
		
        $this->load->view( 'master', $data );
    }
    
    public function selectCurrencyCodeByID(){
        $country_id = $this->input->get('cuntryID');
        $query = $this->db->query("SELECT * FROM mt_countries WHERE countryID = $country_id");
        $currency_code = $query->row();
        if($currency_code){
            echo $currency_code->currency_code . ' ( '. $currency_code->currency_symbol .' ) '; exit;
        }else{
            echo 0; exit;
        }
    }

    public function email_tep(){
            $massege['name'] = 'Mipur property';
            $massege['bid'] = 10000;
            $massege['last_bid'] = 8000;
            $massege['bid_date'] = date('Y-m-d');
            $massege['last_bid_date'] = date('Y-m-d');
            $massege['address'] = 'Mipur 10 - Dhaka -, Bangladesh';
            $massege['url_property'] = 'pre';
            $massege['company_info'] = $this->company_header();
            $data['main_content'] = $this->load->view('mailScripts/auction_short_summery_close_all',$massege, TRUE);

             $this->load->view( 'master', $data );
	}
	
}
