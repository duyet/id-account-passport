<?php

class yplitgroup
{
	// Yplitgroup Project Class 
	// Class version: $1.4.8$
	// Revision: 52

	public $yplitgroup_info = array();
	public $project_id = 0;
	public $project_name = '';
	public $project_info = array();
	public $yplitgroup_key = '';

	public function __contruct()
	{
		$this->_load();
	}

	private function _load()
	{
		// Yplitgroup Project Class
		$this->yplitgroup_info = array(
			'author' => 'Yplitgroup, Ltd',
			'group' => 'Yplitgroup',
			'email' => 'yplitgroup@gmail.com',
			'member' => array(
				// Private
			),
			'group_date' => '01-01-2012',
			'id' => '2449fecbd14d71f78f9d5faa01fcb570', // <yplitgroupProject.lemon9x.com/yplitgroupKey.php>
		);

		$this->yplitgroup_key = '2449fecbd14d71f78f9d5faa01fcb570';

		$this->project_id = 15; // Project store at <yplitgroupProject.lemon9x.com>

		$this->project_name = 'id_account_system_150';

		$this->project_info = array(
			'project_id_name' => $this->project_name,
			'project_id' => $this->project_id,
			'project_name' => '[Yplitgroup] ID Account System 1.5.0',
			'key' => '876609683c4c7e392848e94d9f62e149',
			'date' => '01:49:27 05/06/2012',
			'time' => 1338875367,
		);
	}

	public function get_project_id()
	{
		return $this->project_id;
	}

	public function get_project_info()
	{
		return $this->project_info;
	}

	public function get_yplitgroup_info()
	{
		return $this->yplitgroup_info;
	}

	private function _genpass($length = 8)
	{
		$pass = chr(mt_rand(65, 90));
		for ($k = 0; $k < $length - 1; ++$k)
		{
			$probab = mt_rand(1, 10);
			$pass .= ($probab <= 8) ? chr(mt_rand(97, 122)) : chr(mt_rand(48, 57));
		}
	return $pass;
	}

	private function _ping()
	{
	}

	private function _allow()
	{
	}

}