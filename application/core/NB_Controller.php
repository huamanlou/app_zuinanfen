<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class NB_Controller extends CI_Controller {
	protected $_ret = 0;
	protected $_of;

	
	function __construct() {
		parent::__construct ();
		$this ->cookies = $this->input->cookie();

		$controller = $this->router->fetch_class();

		$this->sysData = array(
			'controller'  => $controller,
			'action'      => $this->router->fetch_method(),
		);

		$this->read_params();

    }
	
    protected function getId(){
    	$id = time().mt_rand(100000,999999);
    	return $id;
    }

	protected function setCookie($name, $value){
		$logonTime = $this->config->item('logonTime');
    	setcookie($name, $value, time()+$logonTime, '/', "", FALSE, TRUE);
    }

	
	protected function set_logout () {
		// @session_start();
		// unset($_SESSION[static::LOGON_SESSION_NAME]);
		$cookies = $this->input->cookie();
		if(!empty($cookies)){
			foreach ($cookies as $k => $v) {
				setcookie($k, '', time()-3600, '/', '', FALSE, TRUE);
			}
		}
	}
	private function read_params () {
		$of = $this->input->get_post('of');
		$tpl = $this->input->get_post('tpl');

		
		if (isset($of) && in_array($of, array('json', 'json-text', 'xml', 'html', 'excel'))) {

			$this->_of = strtolower(trim($of));

		} else {

			$this->_of = 'html';

		}
			
		if ($tpl)
			$this->_tpl = strtolower(trim($tpl));
		else
			$this->_tpl = load_class('Router')->fetch_class() . '/' . load_class('Router')->fetch_method();
	}
	protected function output_data ($data = array(), $view = '', $return = FALSE) {
		$output = null;
		if (!empty($view)) {
			$this->_tpl = $view;
		}
	
	
		$data['sysData']  = $this->sysData;


		#CDN地址
		if (!isset($data['_cdn_host'])) {
			$data['_cdn_host'] = $this->config->config['cdn_host'];
		}

		if ($this->_of == 'json' or $this->_of == 'json-text') {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'
					and strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ){
				//$data['_csrf'] = $this->security->get_csrf_hash();
			}
			if ($return)
				$output = json_encode($data);
			else if ($this->_of == 'json') {
				
				$this->output->set_content_type ('application/json')->set_output(json_encode($data));
			} else {
				$this->output->set_output(json_encode($data));
			}

		} else if ($this->_of == 'excel') {
			if (isset($data['fields']['oper'])) unset($data['fields']['oper']);
			$this->output_excel(isset($data['fields'])? $data['fields'] : array(), isset($data['data'])? $data['data'] : array(), $this->_tpl);
			
		} else {
			$output = $this->load->view($this->_tpl . '_' . $this->_of, $data, $return);
		}
		return $output;
	}
	
	protected function output_json ($data = array(), $return = FALSE) {
		$output = null;
	
		if (!isset($data['_ret'])) {
			$data['_ret'] = $this->_ret;
		}
	
		if (!isset($data['_time'])) {
			$data['_time'] = date('Y-m-d H:i:s');
		}
	
		// if (!isset($data['_log'])) {
		// 	$data['_log'] = $this->_log;
		// }
	
		// if (!isset($data['_debug'])) {
		// 	$data['_debug'] = $this->_debug;
		// }
		

		if ($return)
			$output = json_encode($data);
		else {
			$this->output->set_content_type ('application/json')->set_output(json_encode($data));
		}
		return $output;
	}
	protected function set_error ($ret, $log = '') {
		$this->_ret = $ret;
		$this->_log = $log;
		$this->_tpl = 'error';
	
		if (isset($this->err_log))
		$this->err_log->log(new Meta_Sys_Log(array(
				'oper_type'=> $_SERVER['REQUEST_METHOD'],
				'data' => 'sys|'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '|' .$log
		)));
	}
	
	protected function get($str, $type = 'normal', $default = null){
		$str = $this->input->get($str, TRUE);
		$str = $this->valid($str, $type);
		if(is_null($str) and !is_null($default)){
			$str = $default;
		}
		return $str;
	}
	
	protected function post($str, $type = 'normal', $default = null){
		$str = $this->input->post($str);
		$str = $this->valid($str, $type);
		if(is_null($str) and !is_null($default)){
			$str = $default;
		}
		return $str;
	}
	
	// protected function get_post($str, $type = 'normal', $default = null){
	// 	$str = $this->input->get_post($str);
	// 	$str = $this->valid($str, $type);
	// 	if(is_null($str) and !is_null($default)){
	// 		$str = $default;
	// 	}
	// 	return $str;
	// }
	
	protected function valid ($str, $type = 'normal') {
		if (is_array($str)) {
			foreach ($str as $k=>$v)

				if($type=='ip'){

					$ip_seg = explode(',',$v);

					if(count($ip_seg)<=0 ||count($ip_seg)>=3){

						$str[$k]=null;

					}elseif(count($ip_seg)==1){

						$str[$k] = $this->valid($ip_seg[0]);

					}elseif(count($ip_seg)==2){

						$flag = !is_null($this->valid($ip_seg[0])) && !is_null($this->valid($ip_seg[1])) && (ip2long($ip_seg[0]) <=ip2long($ip_seg[1]));

						$str[$k]= $flag ?$v:null;

					}

				}else{

					$str[$k] = $this->valid($v, $type);	

				}
				if(is_null($str[$k])){

					unset($str[$k]);

				}
				
			return $str;
		}
	
		$str = trim($str);
	
		switch ($type) {
			case 'alnum':
				return preg_match("/^[a-zA-Z0-9]+$/u",$str)? $str : NULL;
			case 'chinese':
				return preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$str)? $str : NULL;
			case 'integer':
				return preg_match("/^[0-9_]+$/u",$str)? $str : NULL;
			case 'number':
				return (is_numeric($str) && $str < PHP_INT_MAX)? $str : NULL;
			case 'money':
				$str = str_replace(',', '', $str);
				return (is_numeric($str) && $str < PHP_INT_MAX)? $str : NULL;
			case 'phone':
				return preg_match("/^[0-9-]+$/u",$str)? $str : NULL;
			case 'email':
				return filter_var($str, FILTER_VALIDATE_EMAIL)? $str : NULL;
			case 'float':
				return filter_var($str, FILTER_VALIDATE_FLOAT)? $str : NULL;
			case 'url':
				return filter_var($str, FILTER_VALIDATE_URL)? $str : NULL;
			case 'ip':
				return filter_var($str, FILTER_VALIDATE_IP)? $str : NULL;

			case 'richbox':

				return strtr($str, '\'"', '‘“');

				break;

			case 'date':

				return strtotime($str)? date('Y-m-d H:i:s', strtotime($str)) : NULL;

				break;
			case 'json':
				return preg_match("/^[^<>]+$/u",$str)? $str : NULL;
				break;
			case 'normal':
			default:
				return preg_match("/^[^'\"<>]+$/u",$str)? $str : NULL;
		}
	}
	
	public function debug($data, $level = self::DEBUG_NORMAL) {
		$this->_debug[] = array('data'=>$data, 'level'=>$level);
	}


}
