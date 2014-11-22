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
if( !isset( $_GET['hash'] ) ) die(" Stop!!! ");
if ( $_REQUEST['do'] == 'verifyusername' and !empty( $_REQUEST['username'] ) )
{
	$username = security_post( 'username' ); 
	$q = "SELECT `userid` FROM `". TABLE_PREFIX ."user` WHERE `username` = " . $db->e( $username );
	$db->query( $q );
	if( $db->nums() != 0 )
	{
		$status = "username_is_exist";
	}
	else
	{
		$status = "username_is_not_exist";
	}
	exit( $status );
}
else
{
	exit();
}
?>