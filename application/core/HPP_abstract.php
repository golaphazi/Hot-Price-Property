<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Abstract class HPP_abstract extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	abstract public function hhp_select();
	
	abstract public function hhp_query();
	
	abstract public function hhp_order();
	
	abstract public function hhp_limit();
	
	abstract public function hhp_table();
}

?>