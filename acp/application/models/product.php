<?php
class Product extends CI_Model {
	
	public function __construct() {
		$this->load->database ();
	}
	
	function get_list() {
		$sql = "SELECT * FROM `shop_product` WHERE `if_show`=1 ";
		$result = $this->db->query ( $sql );
		return ($result != null && $result->num_rows () > 0) ? $result->result_array () : array ();
	
	}
	
	function inner_product($productId){
		
		$sql  = "INSERT INTO `shop_product_car`(`pro_id`) VALUES ( $productId)";
		$result = $this->db->query ( $sql );
		$res = 1;
        return $res;
	}
	
	function get_promes($productId){
		
		$sql = "SELECT * FROM `shop_product` WHERE `id`=".$productId." AND `if_show`=1 ";
		$result = $this->db->query ( $sql );
		return ($result != null && $result->num_rows () > 0) ? $result->result_array () : array ();
		
	}
	
	function get_shopcar(){
		
		$sql = "SELECT `pro_id` FROM `shop_product_car` WHERE `if_show`=1 AND `dealed`=0 ";
		$result = $this->db->query ( $sql );
		return ($result != null && $result->num_rows () > 0) ? $result->result_array () : array ();
		
	}
	
	function get_user($user_name){
		
		$sql = "SELECT * FROM `shop_user` WHERE `name`='".$user_name."' AND `if_show`=1 ";
		$result = $this->db->query ( $sql );
		return ($result != null && $result->num_rows () > 0) ? $result->result_array () : array ();
		
		
	}
	
	function inner_user($user_name,$user_pass,$user_email,$ctime){
		
		$sql  = "INSERT INTO `shop_user`(`name`, `password`, `email`, `ctime`) VALUES ('".$user_name."','".$user_pass."','".$user_email."','".$ctime."')";
		$result = $this->db->query ( $sql );
		
		$res = 1;
        return $res;		
	}
	function get_user_mes($user_name,$user_pass){
		
		$sql = "SELECT * FROM `shop_user` WHERE `name`='".$user_name."' AND `password`= $user_pass AND `if_show`=1 ";
		$result = $this->db->query ( $sql );
		return ($result != null && $result->num_rows () > 0) ? $result->result_array () : array ();		
	}
}