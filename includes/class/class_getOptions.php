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

class getOptions
{
	//global $db;
	function getOptions(){}
	
	public function _get()
	{
		global $db, $param;
		if( $param['f']->load( 'yplitgroupGetDbName' ) != 'vbb' )
		{
			$param['f']->load( 'yplitgroupChangeDb', array( 'vbb' ) );
		}
		$query = $db->sql_query( "SELECT `varname`, `value` FROM `". TABLE_PREFIX ."setting`" );
		$options = array();
		while( $row = $db->sql_fetchrow( $query ) )
		{
			$options[$row['varname']] = $row['value'];
		}
		return $options;
	}
}

?>