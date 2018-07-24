<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class HPP_Subclass extends HPP_abstract{
	
	public $hpp_select = '*';
    public $hpp_table = '';
    public $hpp_order = '';
    public $hpp_limit = '';
    public $hpp_query = array();
	
	public function __construct(){
		parent::__construct();
	}
	
	
}
?>