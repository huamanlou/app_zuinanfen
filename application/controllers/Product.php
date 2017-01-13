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
		$pic = $this->post('pic');
		if(empty($pic)){

		}
		// var_dump(urldecode($pic));die;
		$obj->pic = $pic;
		$this->product_mdl->set($obj);
		$this->output_json();
	}
	public function getlist(){
		$page = $this->get('page');
		if(empty($page)){
			$page=1;
		}

		$res = $this->product_mdl->list_by_status($page);

		foreach ($res as $k => $v) {
			unset($res[$k]['userId']);
			unset($res[$k]['mtime']);
			$picArr = json_decode(urldecode($res[$k]['pic']),true);
			$res[$k]['pic'] = array();
			foreach ($picArr as $key => $value) {
				array_push($res[$k]['pic'], $this->config->item('cdn_host').$value);
			}
			$res[$k]['desc'] = htmlspecialchars(urldecode($res[$k]['desc']),ENT_QUOTES);
		}

		$this->output_json($res);
	}
	public function show(){
		$id = $this->get('id');
		if(empty($page)){

		}
		$detail = $this->product_mdl->get($id);
		$picArr = json_decode(urldecode($detail['pic']),true);
		$detail['pic'] = array();
		foreach ($picArr as $key => $value) {
			array_push($detail['pic'], $this->config->item('cdn_host').$value);
		}
		$this->output_json($detail);
	}
}
