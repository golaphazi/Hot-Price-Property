<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Description of Hpp_Admin_Model
 *
 * @author Euitsols
 * Developed On 12-03-2018
 */

class Hpp_Admin_Model extends CI_Model {
    //put your code here
    
    /*
     * Select All Admin User By Type
     * Developed On 13-03-2018
     */
    public function hpp_login(){
        $adminID = $this->session->userData('adminID');
        if($adminID > 0){
            $this->db->update('admin_access' , array('LOG_STATUS' => 'Online', 'LOG_TIME' => date("Y-m-d h:i:s")), array('ADMIN_ID' => $adminID));
        }
    }
    
    public function select_all_admin_user_by_type( $search ){
        if( $search == 'Super' ){
           $query = "SELECT * FROM admin_access WHERE ADMIN_TYPE = 'Super' ORDER BY admin_access.ADMIN_ID"; 
        }else if( $search == 'Admin' ){
            $query = "SELECT * FROM admin_access WHERE ADMIN_TYPE = 'Admin' ORDER BY admin_access.ADMIN_ID"; 
        }else if( $search == 'Manager' ){
            $query = "SELECT * FROM admin_access WHERE ADMIN_TYPE = 'Manager' ORDER BY admin_access.ADMIN_ID"; 
        }
        else{
            $query = "SELECT * FROM admin_access ORDER BY admin_access.ADMIN_ID";
        }
        $result = $this->db->query( $query );
        return $result->result();
    }
    
    /*
     * select_all_hpp_user_by_type()
     * @param $searchType
     * Developed On 27-03-2018
     */
    public function select_all_hpp_user_by_type( $getSearchType )
    {
     if($getSearchType == 'Verified' ){
		 $where = "WHERE s_user_info.VERIFY_STATUS = '$getSearchType' AND s_user_info.USER_STATUS = 'Active'";
	 }else if($getSearchType == 'Not_Verified' ){
		 $where = "WHERE s_user_info.VERIFY_STATUS = 'Not Verified' AND s_user_info.USER_STATUS = 'Active'";
	 }else if(strlen($getSearchType)){
         $where = "WHERE s_user_info.USER_STATUS = '$getSearchType'";
     }else{
         $where = "WHERE s_user_info.USER_STATUS != 'Delete'";
     }   
        $query = "SELECT * FROM 
                     s_user_info 
                     LEFT JOIN s_user_details_info ON s_user_info.USER_ID = s_user_details_info.USER_ID
                     LEFT JOIN mt_s_user_role ON s_user_info.ROLE_ID = mt_s_user_role.ROLE_ID
                     LEFT JOIN mt_s_user_type ON s_user_info.USER_TYPE_ID = mt_s_user_type.USER_TYPE_ID
                     $where ORDER BY s_user_info.USER_ID
                 "; 
        
        $result = $this->db->query( $query );
        return $result->result();
    }
    
    /*
     * check_verified_email by $emailid
     * on 13-03-2018
     */
    public function check_verified_email($email_address){
        $query = "SELECT * FROM admin_access WHERE ADMIN_EMAIL = '$email_address'";
        $query = $this->db->query( $query );
        $result = $query->row();
        return $result;
    }
    
    /*
     * select admin details
     * @param $adminID
     * on 14-03-2018
     */
    public function selectAdminDetailsById($getID){
        $query = "SELECT * FROM admin_access WHERE ADMIN_EMAIL = '$getID'";
        $query = $this->db->query( $query );
        $result = $query->row();
        return $result;
    }
    
    /*
     * select_auction_property_by_win by $emailid
     * on 13-03-2018
     */
    public function select_auction_property_by_win(){
        $query = "SELECT * FROM p_property_basic
                                LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                LEFT JOIN p_property_offers ON p_property_basic.PROPERTY_ID = p_property_offers.PROPERTY_ID AND p_property_offers.OFFER_TYPE = 'Bid'
                                WHERE p_property_basic.PROPERTY_AUCTION = 'Yes' AND p_property_offers.OFFER_STATUS = 'Win' AND p_property_basic.PROPERTY_STATUS != 'Delete' AND p_property_images.DEFAULT_IMAGE = 1
                                ORDER BY p_property_offers.OFFER_END_DATE,p_property_offers.OFFER_P_ID DESC
                                ";
        $query = $this->db->query( $query );
        $result = $query->result();
        return $result;
    }

        public function select_all_property_by_type( $search, $type ){
        //echo $search;
        if($type == 'pending'){
            $searchType = 'Pending';
        }else if($type == 'active'){
            $searchType = 'Active';
        } else if($type == 'buy' OR $type == 'win' OR $type == 'hot_sell' OR $type == 'rented'){
             $searchType = 'Sell';
        }else if($type == 'reject'){
            $searchType = 'Reject';
        }
         if($search == 'sell'){
            if($type == 'all'){
                 $query = "SELECT * FROM p_property_basic
                                    LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                    LEFT JOIN s_user_info ON p_property_basic.USER_ID = s_user_info.USER_ID
                                    WHERE p_property_basic.PRO_CATEGORY_ID = 1 AND p_property_images.DEFAULT_IMAGE = 1 AND p_property_basic.PROPERTY_STATUS != 'Delete'
                                    ORDER BY p_property_basic.PROPERTY_ID DESC
                            ";
            }else{
               $query = "SELECT * FROM p_property_basic
                                    LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                    LEFT JOIN s_user_info ON p_property_basic.USER_ID = s_user_info.USER_ID
                                    WHERE p_property_basic.PRO_CATEGORY_ID = 1 AND p_property_basic.PROPERTY_STATUS =  '$searchType' AND p_property_images.DEFAULT_IMAGE = 1
                                    ORDER BY p_property_basic.PROPERTY_ID DESC
                            ";
            }
           
        }else if($search == 'rent'){
            if($type == 'all'){
                     $query = "SELECT * FROM p_property_basic
                                        LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                        LEFT JOIN s_user_info ON p_property_basic.USER_ID = s_user_info.USER_ID
                                        WHERE p_property_basic.PRO_CATEGORY_ID = 2 AND p_property_images.DEFAULT_IMAGE = 1
                                        ORDER BY p_property_basic.PROPERTY_ID DESC
                                ";
            } else{ 
                $query = "SELECT * FROM p_property_basic
                                    LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                    LEFT JOIN s_user_info ON p_property_basic.USER_ID = s_user_info.USER_ID
                                    WHERE p_property_basic.PRO_CATEGORY_ID = 2 AND p_property_basic.PROPERTY_STATUS = '$searchType' AND p_property_images.DEFAULT_IMAGE = 1
                                    ORDER BY p_property_basic.PROPERTY_ID DESC
                            ";
            }
        }else if($search == 'auction'){
            if( $type == 'all' ){
                $query = "SELECT * FROM p_property_basic
                                    LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                    LEFT JOIN p_property_offers ON p_property_basic.PROPERTY_ID = p_property_offers.PROPERTY_ID 
                                    LEFT JOIN s_user_info ON p_property_basic.USER_ID = s_user_info.USER_ID
                                    WHERE p_property_basic.PROPERTY_AUCTION = 'Yes' AND p_property_basic.PROPERTY_STATUS IN ('Active', 'Sell')  AND p_property_images.DEFAULT_IMAGE = 1 AND p_property_offers.OFFER_TYPE = 'Bid'
                                    GROUP BY (p_property_offers.PROPERTY_ID)
									ORDER BY p_property_offers.OFFER_P_ID,p_property_offers.OFFER_END_DATE DESC
                            ";
            } else{
                $query = "SELECT * FROM p_property_basic
                                    LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                    LEFT JOIN p_property_offers ON p_property_basic.PROPERTY_ID = p_property_offers.PROPERTY_ID 
                                    LEFT JOIN s_user_info ON p_property_basic.USER_ID = s_user_info.USER_ID
                                    WHERE p_property_basic.PROPERTY_AUCTION = 'Yes' AND p_property_basic.PROPERTY_STATUS IN ('Active', 'Sell')  AND p_property_images.DEFAULT_IMAGE = 1 AND p_property_offers.OFFER_TYPE = 'Bid'  AND p_property_offers.OFFER_STATUS = '$searchType'
                                    GROUP BY (p_property_offers.PROPERTY_ID)
									ORDER BY p_property_offers.OFFER_P_ID,p_property_offers.OFFER_END_DATE DESC
                            ";
            }

        }else if($search == 'hot'){
            if( $type == 'all' ){
                $query = "SELECT * FROM p_property_basic
                                    LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                    LEFT JOIN p_property_offers ON p_property_basic.PROPERTY_ID = p_property_offers.PROPERTY_ID 
                                    LEFT JOIN s_user_info ON p_property_basic.USER_ID = s_user_info.USER_ID
                                    WHERE p_property_basic.HOT_PRICE_PROPERTY = 'Yes' AND p_property_basic.PROPERTY_STATUS IN ('Active', 'Sell')  AND p_property_images.DEFAULT_IMAGE = 1 AND p_property_offers.OFFER_TYPE = 'Hot' 
                                    ORDER BY p_property_offers.OFFER_P_ID,p_property_offers.OFFER_END_DATE DESC
                            ";
            } else {
                $query = "SELECT * FROM p_property_basic
                                    LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                    LEFT JOIN p_property_offers ON p_property_basic.PROPERTY_ID = p_property_offers.PROPERTY_ID 
                                    LEFT JOIN s_user_info ON p_property_basic.USER_ID = s_user_info.USER_ID
                                    WHERE p_property_basic.HOT_PRICE_PROPERTY = 'Yes' AND p_property_basic.PROPERTY_STATUS IN ('Active', 'Sell')  AND p_property_images.DEFAULT_IMAGE = 1 AND p_property_offers.OFFER_TYPE = 'Hot' AND p_property_offers.OFFER_STATUS = '$searchType'
                                    ORDER BY p_property_offers.OFFER_P_ID,p_property_offers.OFFER_END_DATE DESC
                            ";
            }

        }else if( $search == 'approved' ){
            $query = "SELECT * FROM p_property_basic
                                    LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                    LEFT JOIN s_user_info ON p_property_basic.USER_ID = s_user_info.USER_ID
                                    WHERE p_property_basic.PROPERTY_STATUS = '$searchType' AND p_property_images.DEFAULT_IMAGE = 1
                                    ORDER BY p_property_basic.PROPERTY_ID DESC
                            ";
        }
        else{
            $query = "SELECT * FROM p_property_basic
                                LEFT JOIN p_property_images ON p_property_basic.PROPERTY_ID = p_property_images.PROPERTY_ID
                                LEFT JOIN s_user_info ON p_property_basic.USER_ID = s_user_info.USER_ID
                                WHERE p_property_basic.PROPERTY_STATUS = 'Pending' AND p_property_images.DEFAULT_IMAGE = 1
                                ORDER BY p_property_basic.PROPERTY_ID DESC
                        ";
        }
        $result = $this->db->query( $query );
        return $result->result();
    }
    
    /*
     * 
     */
    public function select_all_news(){
        $query = "SELECT * FROM blog_property_news WHERE NEWS_STATUS != 'Delete' ORDER BY blog_property_news.NEWS_ID DESC";
        $result = $this->db->query( $query );
        return $result->result();
    }
    
    public function select_news_by_id($nID){
        $query = "SELECT * FROM blog_property_news WHERE NEWS_ID = '$nID'";
        $result = $this->db->query( $query );
        return $result->row();
    }
    
    public function select_all_seller_by_type($type = '1'){
        $query = "SELECT 
                        user.USER_ID,
                        user.USER_NAME,
                        user.USER_LOG_NAME,
                        udetails.FULL_NAME
                        FROM s_user_info AS user
                        LEFT JOIN s_user_details_info AS udetails ON user.USER_ID = udetails.USER_ID
                        WHERE user.USER_TYPE_ID = '$type' AND user.USER_STATUS != 'Delete'
                    ";
        $result = $this->db->query($query);
        return $result->result();
    }
    
}
