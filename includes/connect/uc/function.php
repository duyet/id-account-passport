<?php
/**
* @ Project: ID Account System 1.5.0
* @ Author: Yplitgroup (c)2012
* @ Email: yplitgroup@gmail.com
* @ Website: http://lemon9x.com 
* @ Phone: 0166.26.26.009
* @ Project ID: 876609683c4c7e392848e94d9f62e149
**/
 
// ############### CHECK ##############
if( !defined('IS_MAIN') ) die(" Stop!!! ");
class uc
{
	public $db;
	public $param;
	public $config;
	
	function __construct( &$param )
	{
		$this->db = $param['db'];
		$this->param = $param;
		$this->config = $param['config'];
	}

	public function get_user_by_uid($uid)
	{
		$query = "SELECT * FROM ".UC_DBTABLEPRE."members WHERE uid='$uid'";
		return $this->db->sql_fetch_assoc( $this->db->query( $query ) );
	}

	public function get_user_by_username($username)
	{
		$query = "SELECT * FROM ".UC_DBTABLEPRE."members WHERE username='$username'";
		return $this->db->sql_fetch_assoc( $this->db->query( $query ) );
	}

	function add_user($username, $password, $email, $uid = 0, $questionid = '', $answer = '')
	{
		if( $this->param['f']->load( 'yplitgroupGetDbName' ) != 'uc' )
			$this->param['f']->load( 'yplitgroupChangeDb', 'uc' );

		$salt = substr(uniqid(rand()), -6);
		$password = md5(md5($password).$salt);
		$this->db->query("
		INSERT INTO ".UC_DBTABLEPRE."members 
				(  `username`,  `password`,    `email`,    `regip`,   `regdate`,      `salt`
			VALUE( '$username',  '$password',   '$email',   '".IP."',  '".TIMENOW."',  '$salt')
			");
		
		$uid = $this->db->insert_id();
		$this->db->query("INSERT INTO ".UC_DBTABLEPRE."memberfields SET uid='$uid'");
		return $uid;
	}

	function quescrypt($questionid, $answer)
	{
		return $questionid > 0 && $answer != '' ? substr(md5($answer.md5($questionid)), 16, 8) : '';
	}

	function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0)
	{
		global $_SGLOBAL;

		$insertkeysql = $insertvaluesql = $comma = '';
		foreach ($insertsqlarr as $insert_key => $insert_value) {
			$insertkeysql .= $comma.'`'.$insert_key.'`';
			$insertvaluesql .= $comma.'\''.$insert_value.'\'';
			$comma = ', ';
		}
		$method = $replace?'REPLACE':'INSERT';
		$this->db->query($method.' INTO '. UC_TABLE_PREFIX . $tablename.' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')', $silent?'SILENT':'');
		if($returnid && !$replace)
		{
			return $this->db->insert_id();
		}
	}

	function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
	{
		$ckey_length = 4;

		$key = md5($key ? $key : UC_KEY);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		$rndkey = array();
		for($i = 0; $i <= 255; $i++)
		{
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		for($j = $i = 0; $i < 256; $i++)
		{
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		for($a = $j = $i = 0; $i < $string_length; $i++)
		{
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE')
		{
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16))
			{
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	}
}