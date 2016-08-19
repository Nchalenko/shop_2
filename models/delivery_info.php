<?php

class Delivery_info extends Model
{
	public function getInfo()
	{
		$sql = "select content 
				from static
				WHERE `page` = 'delivery'";

		return $this->db->query($sql);
	}

	public function editInfo($delivery)
	{
		$sql = "update static
		set content = '{$delivery}'
		WHERE page = 'delivery'";
		return $this->db->query($sql);
	}
}