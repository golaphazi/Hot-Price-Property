<?php
/**
 * Description of Property Model
 *
 * @author HotPrice Property
 */


class Property_Model extends CI_Model {
    /*
     * This Method select all Sell properties
     * @param $type
     */
   public $filed_id = 0;
   public $filed_value = '';
   private $pagination = ''; 
	
   public function hpp_create_link(){
	  return $this->pagination;
   }	
   
   public function hpp_pagination(array $pagiData){
       $offset_name = 'page';
       $offset = 1;
       $limit = 0;
       $total_count = 0;
	   if(array_key_exists('offset_name', $pagiData)){
			$offset_name =   $pagiData['offset_name'];
	   }

	  if(array_key_exists('offset', $pagiData)){
		$offset =   $pagiData['offset'];
	  }  
	  
	  if(array_key_exists('limit', $pagiData)){
		$limit =   $pagiData['limit'];
	  } 
	  if(array_key_exists('total_count', $pagiData)){
		$total_count =   $pagiData['total_count'];
	  } 
	  
	  
	 $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : SITE_URL;   
	 if(array_key_exists('url', $pagiData)){
		$url =   $pagiData['url'];
	  }
	 $exp = explode('?', $url);
	 $expCount = sizeof($exp);
	 
	 if($expCount > 1){
		$setUrl = explode('?'.$offset_name.'=', $url);
		if(sizeof($setUrl) > 1){
			$athchUrl = $setUrl[0].'?'.$offset_name.'=';
		}else{
			$setUrl = explode('&'.$offset_name.'=', $url);
			$athchUrl = $setUrl[0].'&'.$offset_name.'=';
			
		}	
	 }else{
		$athchUrl = $url.'?'.$offset_name.'=';
	 }
		
	 $avg = ceil($total_count/$limit);	
	 
	 $pagination = '';
	 $pagination .= '<ul>';
		if($offset != 1){
			$pagination .= '<li><a href="'.$athchUrl.''.($offset-1).'">Prev</a></li>';
		}
		$fromRange = $offset - 10;
		$toRange = $offset + 10;
		for($m = 1; $m <= $avg; $m++){
			$active = '';
			if($offset == $m){
				$active = 'active';
			}
			
			if(in_array($m, range($fromRange, $toRange))){
				$pagination .= '<li class="'.$active.'"><a href="'.$athchUrl.''.$m.'">'.$m.'</a></li>';
			}
		}
		
		if($offset != $avg){
			$pagination .= '<li><a href="'.$athchUrl.''.($offset+1).'">Next</a></li>';
		}
		
	 $pagination .= '</ul>';
         if($total_count > 0){
             $this->pagination = $pagination;
         }else{
             $this->pagination = '';
         }
         
	 
	 $setOffset = ($offset -1) * $limit;
	 return $setOffset;
   }
   
	public function property_basic($query='', $join= array(), $orWhere = ''){
		$this->hpp_table = 'p_property_basic as pro';		
		if(is_array($query) AND sizeof($query) > 0){
			$query['pro.COMPANY_ID'] = $this->conpanyID;
			$this->hpp_query = $query;			
		}
		
		if (strlen($this->hpp_order_column) > 2){
            $this->db->order_by($this->hpp_order_column, $this->hpp_order);
        }
        if ($this->hpp_limit > 2){
            $this->db->limit($this->hpp_limit, $this->hpp_offset);
        }
		if(is_array($join) AND sizeof($join) > 2){
			$this->db->join($join[0], $join[1], $join[2]);
		}
		
		
		if(strlen($orWhere) > 0){
			$this->db->where($orWhere);
			//echo $orWhere;exit;
		}
		$this->db->where($this->hpp_query);
		
		$results = $this->db->get($this->hpp_table)->result_array();
		return $results;
		
	}
    
	
	
	public function select_country($query=''){
		$this->hpp_table = 'mt_countries';		
		if(is_array($query) AND sizeof($query) > 0){
			$this->hpp_query = $query;
			$this->db->where($this->hpp_query);			
		}
		
		$results = $this->db->get($this->hpp_table)->result_array();
		return $results;
	}
	
	public function property_image($query=''){
		$this->hpp_table = 'p_property_images';		
		
		$query['IMAGE_STATUS'] = 'Active';
		if(is_array($query) AND sizeof($query) > 0){
			$query['COMPANY_ID'] = $this->conpanyID;
			$this->hpp_query = $query;			
		}
		$this->db->where($this->hpp_query);
		$results = $this->db->get($this->hpp_table)->result_array();
		return $results;
	}
	
	public function property_video($query=''){
		$this->hpp_table = 'p_property_videos';		
		
		$query['VIDEOS_STATUS'] = 'Active';
		if(is_array($query) AND sizeof($query) > 0){
			$query['COMPANY_ID'] = $this->conpanyID;
			$this->hpp_query = $query;			
		}
		$this->db->where($this->hpp_query);
		$results = $this->db->get($this->hpp_table)->result_array();
		return $results;
	}
	
	public function any_type_where($query=array(), $table='', $type='COUNT', $count=''){
		
		if(strlen($count) > 2){
			$this->hpp_select = $type.'('.$count.') AS result';
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
		if(strlen($count) > 2){
			return $results[0]['result'];
		}else{
			return $results;
		}
	}
	
	
	public function property_fileld($typeid = '0') {
        if ($typeid > 0) {
            $search = "SELECT * 
                                FROM 
                                    mt_p_pro_add_fixed_filed_set AS filed
                                INNER JOIN
                                          mt_p_property_additional_filed AS addi
                                ON filed.ADD_FILED_ID = addi.ADD_FILED_ID AND filed.COMPANY_ID = addi.COMPANY_ID
                                WHERE
                                    filed.PROPERTY_TYPE_ID = " . $typeid . "
                                    AND filed.COMPANY_ID = " . $this->conpanyID . "
                                    AND addi.COMPANY_ID = " . $this->conpanyID . "
                                    AND filed.ACCESS_STATUS = 'Active'
                    ";
            $query = $this->db->query($search);
            return $query->result();
        }else{
			 $search = "SELECT * 
                                FROM 
                                    mt_p_property_additional_filed AS filed
                                WHERE
                                    filed.COMPANY_ID = " . $this->conpanyID . "
                                    AND filed.FILED_STATUS = 'Active'
                    ";
            $query = $this->db->query($search);
            return $query->result();
		}
    }
	
	public function additional_property_filed($id=0, $type ='Fixed'){
		if($id > 0){
			$search = "SELECT *
								FROM
										p_property_additional									
								WHERE 
										FILED_TYPE = '".$type."'
										AND FILED_STATUS = 'Active'
										AND PROPERTY_ID = $id
										AND COMPANY_ID = " . $this->conpanyID . "
							";
			$query = $this->db->query($search);
			return $query->result();
		}
	}
	
	public function property_near_by($id=''){
		if($id > 0){
			$search = "SELECT *
								FROM
										p_property_nearby AS near
								INNER JOIN mt_p_nearby_location AS loc
									ON near.LOCATION_ID = loc.LOCATION_ID
								WHERE 
										NEAR_STATUS = 'Active'
										AND near.PROPERTY_ID = $id
										
							";
			$query = $this->db->query($search);
			return $query->result();
		}
	}

    public function create_filed($type = 'TEXT', $id = "filed", $name = 'No name', $value = '', $extra = '') {
        if ($type == 'textarea') {
            return ' <textarea name="' . $id . '" id="' . $id . '" class="form-control" ' . $extra . '> ' . $value . ' </textarea>';
        } else if ($type == 'radio' OR $type == 'checkbox') {
            return ' <input name="' . $id . '" id="' . $id . '" type="' . $type . '" class="form-control" value="' . $value . '" ' . $extra . '> ' . $name . ' ';
        } else if ($type == 'number') {
            return ' <input name="' . $id . '" id="' . $id . '" type="number" class="form-control" placeholder="" min="1" step="1" value="' . $value . '" onkeyup="removeChar(this);" ' . $extra . ' >';
        } else if ($type == 'select') {
            $selct = '';
			$search = $this->any_type_where(array('ADD_FILED_ID' => $this->filed_id, 'SUB_FILED_STATUS' => 'Active'), 'mt_p_property_additional_filed_sub');
			$selct .= '<select class="form-control" name="' . $id . '" id="' . $id . '">';
			 $selct .= '<option value=""> Select once </option>';
			foreach($search AS $data){
				  $slected ='';
				  if($this->filed_value == $data['SUB_FILED_VALUE']){
					  $slected = 'selected';
				  }
				  $selct .= '<option value="'.$data['SUB_FILED_VALUE'].'" '.$slected.'> '.$data['SUB_FILED_VALUE'].'';
				  $selct .= '</option>';
			}
		    $selct .= '</select>';
			return $selct;
        } else if ($type == 'text_select') {
            $selct = '';
            $selct .= '<input name="' . $id . '" id="' . $id . '" type="' . $type . '" class="form-control super_text" placeholder="'.$name.'" value="' . $value . '" ' . $extra . '>';
			$search = $this->any_type_where(array('ADD_FILED_ID' => $this->filed_id, 'SUB_FILED_STATUS' => 'Active'), 'mt_p_property_additional_filed_sub');
			$selct .= '<select class="form-control super_select" name="' . $id . '__select" id="' . $id . '__select">';
			 //$selct .= '<option value=""> Select once </option>';
			foreach($search AS $data){
				  $slected ='';
				  if($this->filed_value == $data['SUB_FILED_VALUE']){
					  $slected = 'selected';
				  }
				  $selct .= '<option value="'.$data['SUB_FILED_VALUE'].'" '.$slected.'> '.$data['SUB_FILED_VALUE'].'';
				  $selct .= '</option>';
			}
		    $selct .= '</select>';
			return $selct;
        } else {
            return ' <input name="' . $id . '" id="' . $id . '" type="' . $type . '" class="form-control" placeholder="'.$name.'" value="' . $value . '" ' . $extra . '>';
        }
    }
	
    /*
     * Select All Property By User ID
     */
    public function select_all_property_by_user($search='all', $userid = '0'){
        if($userid > 0){
            $this->userID = $userid;
	}
        if($search == 'sell'){
                $query = "SELECT * FROM p_property_basic
                                        LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                        WHERE p_property_basic.USER_ID = $this->userID AND p_property_basic.PRO_CATEGORY_ID = 1 AND p_property_basic.PROPERTY_STATUS != 'Delete' AND p_property_images.DEFAULT_IMAGE = 1
                                        ORDER BY p_property_basic.PROPERTY_ID DESC
                                ";
        }else if($search == 'rent'){
                $query = "SELECT * FROM p_property_basic
                                        LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                        WHERE p_property_basic.USER_ID = $this->userID AND p_property_basic.PRO_CATEGORY_ID = 2 AND p_property_basic.PROPERTY_STATUS != 'Delete' AND p_property_images.DEFAULT_IMAGE = 1
                                        ORDER BY p_property_basic.PROPERTY_ID DESC
                                ";

        }else if($search == 'auction'){
                $query = "SELECT * FROM p_property_basic
                                        LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                        INNER JOIN p_property_offers ON p_property_basic.PROPERTY_ID = p_property_offers.PROPERTY_ID 
                                        WHERE p_property_basic.USER_ID = $this->userID AND p_property_basic.PROPERTY_AUCTION = 'Yes' AND p_property_basic.PROPERTY_STATUS IN ('Active', 'Sell') AND p_property_images.DEFAULT_IMAGE = 1 AND p_property_offers.OFFER_TYPE = 'Bid'
                                        GROUP BY (p_property_offers.PROPERTY_ID)
										ORDER BY p_property_offers.OFFER_END_DATE,p_property_offers.OFFER_P_ID DESC
                                ";
//echo 'golap'; exit;
        }else if($search == 'auction_offer'){
                $query = "SELECT * FROM p_property_basic
                                        LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                        INNER JOIN p_property_offers ON p_property_basic.PROPERTY_ID = p_property_offers.PROPERTY_ID 
                                        LEFT JOIN p_property_offers_bidding ON p_property_basic.PROPERTY_ID = p_property_offers_bidding.PROPERTY_ID  AND p_property_offers.OFFER_P_ID = p_property_offers_bidding.OFFER_P_ID
                                        WHERE p_property_offers_bidding.USER_ID = $this->userID AND p_property_basic.PROPERTY_AUCTION = 'Yes' AND p_property_basic.PROPERTY_STATUS IN ('Active', 'Sell') AND p_property_images.DEFAULT_IMAGE = 1 AND p_property_offers.OFFER_TYPE = 'Bid'
                                        GROUP BY (p_property_offers_bidding.PROPERTY_ID)
										ORDER BY p_property_offers.OFFER_END_DATE,p_property_offers.OFFER_P_ID DESC
                                ";

        }
        else if($search == 'hot'){
                $query = "SELECT * FROM p_property_basic
                                        LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                        INNER JOIN p_property_offers ON p_property_basic.PROPERTY_ID = p_property_offers.PROPERTY_ID
                                        WHERE p_property_basic.USER_ID = $this->userID AND p_property_basic.HOT_PRICE_PROPERTY = 'Yes' AND p_property_basic.PROPERTY_STATUS IN ('Active', 'Sell')  AND p_property_images.DEFAULT_IMAGE = 1  AND p_property_offers.OFFER_TYPE = 'Hot'
                                        GROUP BY (p_property_offers.PROPERTY_ID)
										ORDER BY p_property_offers.OFFER_END_DATE,p_property_offers.OFFER_P_ID DESC
                                ";

        }else if($search == 'hot_offer'){
                $query = "SELECT * FROM p_property_basic
                                        LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                        INNER JOIN p_property_offers ON p_property_basic.PROPERTY_ID = p_property_offers.PROPERTY_ID 
                                        LEFT JOIN p_property_offers_bidding ON p_property_basic.PROPERTY_ID = p_property_offers_bidding.PROPERTY_ID  AND p_property_offers.OFFER_P_ID = p_property_offers_bidding.OFFER_P_ID
                                        WHERE p_property_offers_bidding.USER_ID = $this->userID AND p_property_basic.HOT_PRICE_PROPERTY = 'Yes' AND p_property_basic.PROPERTY_STATUS IN ('Active', 'Sell') AND p_property_images.DEFAULT_IMAGE = 1 AND p_property_offers.OFFER_TYPE = 'Hot'
                                        GROUP BY (p_property_offers_bidding.PROPERTY_ID)
										ORDER BY p_property_offers.OFFER_END_DATE,p_property_offers.OFFER_P_ID DESC
                                ";

        }else{
                $query = "SELECT * FROM p_property_basic
                                        LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                        WHERE p_property_basic.USER_ID = $this->userID AND p_property_basic.PROPERTY_STATUS != 'Delete' AND p_property_images.DEFAULT_IMAGE = 1
                                        ORDER BY p_property_basic.PROPERTY_ID DESC
                                ";
        }
        $result = $this->db->query( $query );
        return $result->result();
    }
    
    /*
     * Select all Countries
     */
    public function select_all_countries(){
        $sql = "SELECT * FROM mt_countries";
        $result = $this->db->query( $sql );
        return $result->result();
    }
    
    /*
     * Select all Property By PROPERTY_IS AND USER_ID
     * Where Publication Status != Active
     * @param $userID
     * @param $propertyID
     * 
     */
    public function select_property_by_id_and_user( $getID ){
        $sql = "SELECT * FROM `p_property_basic` as basic 
                        LEFT JOIN mt_p_property_type as ptype ON basic.PROPERTY_TYPE_ID = ptype.PROPERTY_TYPE_ID 
                        WHERE (basic.PROPERTY_STATUS = 'Pending' OR basic.PROPERTY_STATUS = 'Reject') AND basic.PROPERTY_ID = $getID AND basic.USER_ID = $this->userID";
        $result = $this->db->query( $sql );
        return $result->row();
    }
    
   /*
     * Select property Additional Information By PROPERTY_ID AND USER_ID
     * Where FILED_STATUS = Active
     * @param $userID
     * @param $propertyID
     * develop on 07-02-20185
     */
    public function select_additional_info_by_property( $getID ){
        $sql = "SELECT 
                      padditional.ADD_FILED_P_ID, 
                      padditional.FILED_DATA, 
                      padditional.ADD_FILED_ID, 
                      padditional.FILED_OTHERS,
                      mtadditional.FILED_NAME, 
                      mtadditional.FILED_ID_NAME, 
                      mtadditional.FILED_TYPE
                        FROM `p_property_additional` as padditional 
                        LEFT JOIN mt_p_property_additional_filed as mtadditional ON padditional.ADD_FILED_ID = mtadditional.ADD_FILED_ID 
                        WHERE padditional.FILED_STATUS = 'Active' AND padditional.PROPERTY_ID = $getID AND padditional.USER_ID = $this->userID AND padditional.FILED_TYPE ='Fixed'";
        $result = $this->db->query( $sql );
        return $result->result();
    }
    
    /*
     * Select property Others Information By PROPERTY_ID AND USER_ID
     * Where FILED_STATUS = Active
     * @param $userID
     * @param $propertyID
     * develop on 07-02-20185
     * 
     */
    public function select_others_info_by_property( $getID ){
        $sql = "SELECT 
                      padditional.ADD_FILED_P_ID, 
                      padditional.FILED_DATA, 
                      padditional.ADD_FILED_ID, 
                      padditional.FILED_OTHERS,
                      mtadditional.FILED_NAME, 
                      mtadditional.FILED_ID_NAME, 
                      mtadditional.FILED_TYPE
                        FROM `p_property_additional` as padditional 
                        LEFT JOIN mt_p_property_additional_filed as mtadditional ON padditional.ADD_FILED_ID = mtadditional.ADD_FILED_ID 
                        WHERE padditional.FILED_STATUS = 'Active' AND padditional.PROPERTY_ID = $getID AND padditional.USER_ID = $this->userID AND padditional.FILED_TYPE ='Dynamic'";
        $result = $this->db->query( $sql );
        return $result->result();
    }
    
    /*
     * Select property near BY Information By PROPERTY_ID AND USER_ID
     * Where FILED_STATUS = Active
     * @param $userID
     * @param $propertyID
     * develop on 07-02-20185
     * 
     */
    public function select_nearby_info_by_property( $getID ){
        $sql = "SELECT *
                        FROM p_property_nearby
                        WHERE NEAR_STATUS = 'Active' AND PROPERTY_ID = $getID";
        $result = $this->db->query( $sql );
        return $result->result();
    }
    
    /*
     * Select property near BY Information By PROPERTY_ID AND USER_ID
     * Where FILED_STATUS = Active
     * @param $userID
     * @param $propertyID
     * develop on 07-02-20185
     * 
     */
    public function select_video_info_by_property( $getID ){
        $sql = "SELECT *
                        FROM p_property_videos
                        WHERE VIDEOS_STATUS = 'Active' AND PROPERTY_ID = $getID";
        $result = $this->db->query( $sql );
        return $result->result();
    }
	
	
	public function date_diff_count($fromDate, $todate='0'){
		$year = 0;
		$month = 0;
		$days = 0;
		$hours = 0;
		$minute = 0;
		$seceond = 0;
		$returnDate = '';
		if($todate == 0){
                    $todate = date("Y-m-d h:i:s");
		}
		if($fromDate == ''){
			$fromDate = date("Y-m-d h:i:s");
		}
		$date1 = new DateTime($todate);
		$date2 = new DateTime($fromDate);
		$interval = $date1->diff($date2);
		$year = $interval->y;
		$month = $interval->m;
		$days = $interval->d;
		$hours = $interval->h;
		$minute = $interval->i;
		$seceond = $interval->s;
		
		if($year > 0){
			$returnDate .= $year.' <small>yrs </small>';
			if($month > 0){
				$returnDate .= $month.' <small>mons</small> ';
			}
			if($days > 0){
				$returnDate .= $days.' <small>days</small> ';
			}
			$returnDate .'ago';
		}else{
			if($month > 0){
				$returnDate .= $month.' <small>mons</small> ';
				if($days > 0){
					$returnDate .= $days.' <small>days</small> ';
				}
				if($hours > 0){
					$returnDate .= $hours.' <small>hrs</small> ';
				}
				$returnDate .'ago';
			}else{
				if($days > 0){
					$returnDate .= $days.' <small>days</small> ';
					if($hours > 0){
						$returnDate .= $hours.' <small>hrs</small> ';
					}
					if($minute > 0){
						$returnDate .= $minute.' <small>mins</small> ';
					}
					$returnDate .'ago';
				}else{
					if($hours > 0){
						$returnDate .= $hours.' <small>hrs</small>  ';
					}
					if($minute > 0){
						$returnDate .= $minute.' <small>mins</small>  ';
					}
					if($seceond >= 0){
						$returnDate .= $seceond.' <small>sec</small> ago ';
					}
				
				}
				
			}
			
		}
			
		
		return $returnDate;
	}
    
    public function encode_str($string){
		$hex='';
		for ($i=0; $i < strlen($string); $i++){
			$hex .= dechex(ord($string[$i]));
		}
		return $hex;
	}
	
	public function decode_str($hex){
		$string='';
		for ($i=0; $i < strlen($hex)-1; $i+=2){
			$string .= chr(hexdec($hex[$i].$hex[$i+1]));
		}
		return $string;
	}
	
    
} /*-- End of Property_Model --*/
