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
$sessionhash = $param['cookie']->get( COOKIE_PREFIX.'sessionhash', '', 'string' );
if ( preg_match( "/^[a-z0-9]+$/", $sessionhash ) )
{
	$user_id = 0;
	$f->load( 'yplitgroupChangeDb', 'vbb' );
	$query = $db->query( "SELECT userid, idhash FROM " . TABLE_PREFIX . "session WHERE userid > 0 AND sessionhash ='" . $sessionhash . "'" );
	while ( list( $userid, $idhash ) = $db->sql_fetchrow( $query ) )
	{
		if ( $idhash == md5( USER_AGENT . fetch_substr_ip( IP ) ) )
		{
			$user_id = $userid;
		}
	}
	if ( $user_id == 0 )
	{
		( ( $param['cookie']->_isset( COOKIE_PREFIX.'userid' ) ) ? $param['cookie']->_unset( COOKIE_PREFIX.'userid' ) : false );
		( ( $param['cookie']->_isset( COOKIE_PREFIX.'password' ) ) ? $param['cookie']->_unset( COOKIE_PREFIX.'password' ) : false );
	//	( isset( $_COOKIE[COOKIE_PREFIX.'sessionhash'] ) ? $_COOKIE[COOKIE_PREFIX.'sessionhash'] = '' : false );
	}
	else
	{
		define( 'IS_USER', true );
		define( 'USERID', $user_id );
	}
}
?>