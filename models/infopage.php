<?php

class InfoPage extends Model
{
	public function getInfo()
	{
		$sql = "select content 
				from static
				WHERE `page` = 'info'";

		return $this->db->query($sql);
	}

	public function editInfo($info)
	{
		$sql = "update static
set content = '{$info}'
WHERE page = 'info'";
		return $this->db->query($sql);
	}
}