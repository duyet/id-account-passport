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
$tableprefix = TABLE_PREFIX;
$sessionhash = $param['cookie']->get( COOKIE_PREFIX.'sessionhash', '', 'string' );
if ( preg_match( "/^[a-z0-9]+$/", $sessionhash ) )
{
	$db->query( "DELETE FROM " . $tableprefix . "session WHERE sessionhash = " . $db->e( $sessionhash ) . "" );
}

$param['cookie']->_unset( COOKIE_PREFIX.'bbuserid' );
$param['cookie']->_unset( COOKIE_PREFIX.'bbpassword' );
$param['cookie']->_unset( COOKIE_PREFIX.'sessionhash' );

// Logout connect
if( count( $param['connect'] ) > 0 )
{
	foreach( $param['connect'] as $server => $server_param )
	{
		if( file_exists( DIR . '/includes/connect/' . $server . '/logout.php' ) )
			require DIR . '/includes/connect/' . $server . '/logout.php';
	}
}

?>