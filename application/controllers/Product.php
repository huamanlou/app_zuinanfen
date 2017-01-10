<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends NB_Controller {
	function __construct () {
		parent::__construct();
		$this->load->model('product_mdl');
	}
	public function index(){
		$this->output_data();
	}

	public function publish(){
		$obj = $this->product_mdl->gen_new();

		$obj->id = $this->getId();

		$title = $this->post('title');
		if(empty($title)){

		}
		$obj->title = $title;
		$abstract = $this->post('abstract');
		if(empty($abstract)){

		}
		$obj->abstract = $abstract;
		$desc = $this->post('desc');
		if(empty($desc)){

		}
		$obj->desc = $desc;
		// var_dump($obj);die;
		$this->product_mdl->set($obj);
		$this->output_json();
	}
}
