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
if( !defined( 'IS_MAIN' ) ) die(" Stop!!! ");
if( !defined( 'IS_USER' ) ) yplitgroupRedirectLogin( $_SERVER['REQUEST_URI'] );
$db->query( "SELECT * FROM " . TABLE_PREFIX . "user WHERE `userid` = " . USERID );
if( $db->sql_numrows() != 1 )
{
	die('<b>Error!</b><hr /> <i>Users error!!!</i>');
}
$user_info = $db->sql_fetch_assoc();
$groupID = array( 1,2,3,4,5,6,7 );
if( in_array( $user_info['usergroupid'], $groupID ) )
{
	$db->sql_query( "SELECT title FROM ". TABLE_PREFIX . "usergroup WHERE usergroupid=". $user_info['usergroupid'] );
	$group = $db->sql_fetch_assoc();
	$user_info['groupname'] = $group['title'];
}
$db->sql_query( "SELECT title FROM ". TABLE_PREFIX . "thread WHERE threadid=( SELECT threadid FROM ". TABLE_PREFIX ."post WHERE postid=". $user_info['lastpostid']  ." )" );
$lastpost = $db->sql_fetch_assoc();
$user_info['lastpost'] = $lastpost['title'];
$table = array(
	'username' 		=> 'left',
	'passworddate'	=> 'left',
	'email'			=> 'left',
	'homepage'		=> 'left',
	'yahoo'			=> 'left',
	'groupname'		=> 'left',
	'birthday'		=> 'right',
	'joindate'		=> 'right',
	'lastvisit'		=> 'right',
	'lastpost'		=> 'right',
	'posts'			=> 'right',
	'ipaddress'		=> 'right',
);

$data = array( 'left' => array(), 'right' => array() );
foreach( $user_info as $k => $v )
{
	if( isset( $table[$k] ) )
	{
		$data[$table[$k]][$k] = $v;
	}
}

$yplitgroupPageTitle = ucfirst( $user_info['username'] ) . ' &middot; ' . $lang['user_info'] . ' &middot; ' . $lang['page_title'];
$yplitgroupRightText = $lang['user_info'];
$f->load( 'yplitgroupHeaderCp' );
require( DIR . '/skin/' . SKINDIR . '/manager_infouser.php' );
$f->load( 'yplitgroupFooterCp' );
?>