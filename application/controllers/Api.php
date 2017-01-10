<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends NB_Controller {
	function __construct () {
		parent::__construct();
	}
	public function upload_pic(){
		header("Content-Type:text/html;charset=utf-8");
	    // error_reporting( E_ERROR | E_WARNING );
	    // date_default_timezone_set("Asia/chongqing");
	    //上传配置
	    $conf = array(
	    	'fileField'  => 'upfile',
	    	'config'  => array(
				"savePath" => "/upload/" ,             //存储文件夹
	        	"maxSize" => 1000 ,                   //允许的文件最大尺寸，单位KB
	        	"allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" )  //允许的文件格式
	    	),
	        
	    );
	    $this->load->library('Uploader',$conf);
	    // $up = new Uploader( "upfile" , $config );
	    $type = $this->get('type');
	    $callback = $this->get('callback');

	    $info = $this->uploader->getFileInfo();
	    /**
	     * 返回数据
	     */
	    if($callback) {
	        echo '<script>'.$callback.'('.json_encode($info).')</script>';
	    } else {
	        echo json_encode($info);
	    }
	}

	
}
