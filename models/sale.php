<?php

class Sale extends Model
{
	public function getInfo()
	{
		$sql = "select content 
				from static
				WHERE `page` = 'sales'";

		return $this->db->query($sql);
	}

	public function editInfo($sales)
	{
		$sql = "update static
		set content = '{$sales}'
		WHERE page = 'sales'";
		return $this->db->query($sql);
	}
}
