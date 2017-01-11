<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends NB_Controller {
	function __construct () {
		parent::__construct();
		// $this->load->library('Call');
	}
	public function logon(){
		// $res = $this->call->post('http://shop.zuinanfen.com/index.php/api/cardlist');
		// var_dump($res);
		$code = $this->get('code');
		var_dump($code);
	}
}
