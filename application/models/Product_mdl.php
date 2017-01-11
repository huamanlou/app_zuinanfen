<?php	
class Product_mdl extends NB_Model {
	
	const T_NAME = 'product';

	public function list_by_status($page=1,$status=null) {
		
		$this->db->from(self::T_NAME);
		if (!empty($status)){
			$this->db->where_in('status',$status);
		}

		$this->db->order_by('ctime', 'desc');
		$perPage = $this->config->item('perPage');

		$startNum = ($page-1)*$perPage;

		$this->db->limit($perPage,$startNum);
		$query = $this->db->get();
		$res = $query->result_array();
		if(empty($res)){
			return array();
		} 
		return $res;
	}

}
