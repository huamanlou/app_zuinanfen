<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'third_party/Snoopy.class.php';

class Call extends CI_Controller {
    function __construct() {
        $this->ci = & get_instance();
       
    }
    public function post($url,$data=array(),$cookies=array()){
        $snoopy = new Snoopy;   
        $snoopy->cookies = $cookies; //伪装sessionid   
        // $snoopy->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)"; //伪装浏览器   
        // $snoopy->referer = http://www.php100.com; //伪装来源页地址 http_referer   
        // $snoopy->rawheaders["Pragma"] = "no-cache"; //cache 的http头信息   
        // $snoopy->rawheaders["X_FORWARDED_FOR"] = "127.0.0.101"; //伪装ip   
        $snoopy->submit($url,$data);   
        return $snoopy->results;   
    }

}
