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
if( $f->load( 'yplitgroupGetDbName' ) != 'uc' )
	$f->load( 'yplitgroupChangeDb', 'uc' );

$db->query( "DELETE FROM ". UC_TABLE_PREFIX . 'session' ." WHERE uid = ". USERID_UC ."");
$db->query( "DELETE FROM ". UC_TABLE_PREFIX . 'adminsession' ." WHERE uid = ". USERID_UC ."");

$param['cookie']->_unset( UC_COOKIE_PREFIX . 'auth' );
$param['cookie']->_unset( UC_COOKIE_PREFIX . 'loginuser' );
$param['cookie']->set( UC_COOKIE_PREFIX . '_refer', '' );

?>
