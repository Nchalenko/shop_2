<?php

class Cabina extends Model
{

	public function info($id){
		$sql = "select * from orders where user_id = {$id}";
		$info = $this->db->query($sql);
		return $info;
	}

}