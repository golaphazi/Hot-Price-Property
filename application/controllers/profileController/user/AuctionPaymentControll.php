<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of AuctionPaymentControll
 *
 * @author HPP
 */
class AuctionPaymentControll extends HPP_Controller{
    //put your code here
    
	public function paymentIndex(){ 
       $data = array();
       $data['title'] = 'Auction Payment';
       $data['main_content'] = $this->load->view('page_templates/dashboard/users/property/auction_payment_process', $data, TRUE );
       $this->load->view( 'master', $data );
       
    }
    
    public function paymentNowIndex(){ 
       $data = array();
	   $data['MSG'] = '';
	   $data['fetch'] = 0;
       $id = isset($_GET['id']) ? $_GET['id'] : 0;
	   $idPro = $this->Property_Model->decode_str($id);
	   if($idPro > 0){
			$query = $this->db->query("SELECT * FROM view_property_sell WHERE PROPERTY_ID = '".$idPro."' AND SELL_PRICE > 0");
			if($query->num_rows()  == 1){
				$fetch = $query->row();
				//print_r($fetch);
				$data['fetch'] = $fetch;
				
			}else{
				$data['MSG'] = 'Invalid Payment ...';
			}
	   }else{
		   $data['MSG'] = 'Invalid Payment ... ';
	   }
	   $data['title'] = 'Payment Now';
       
	   $data['main_content'] = $this->load->view('page_templates/dashboard/users/property/paypal_payment_process', $data, TRUE );
       $this->load->view( 'master', $data );
       
    }
    
}
