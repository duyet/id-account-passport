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

$remember = true;
$user_groupid_in_vbb = array( 
    2, 5, 6, 7 
);
require_once ( DIR . '/includes/connect/nukeviet/function.php' );
require_once ( DIR . '/includes/connect/nukeviet/crypt.class.php' );
$crypt = new nv_Crypt( $config['connect']['nukeviet']['sitekey'] ,'sha1' ); 
$password_crypt = $crypt->hash( $password );

if( $f->load( 'yplitgroupGetDbName' ) != 'vbb' )
{
	$f->load('yplitgroupChangeDb', array( 'vbb' ) );
}
$db->query( "SET NAMES 'latin1'" );
$user_info = $db->sql_fetchrow( $db->query( "SELECT * FROM `" . TABLE_PREFIX . "user` WHERE `username`=" . $db->e( $username ) . "" ) );

// Make data sign to nukeviet
if( $f->load( 'yplitgroupGetDbName' ) != 'nukeviet' )
{
	$f->load('yplitgroupChangeDb', array( 'nukeviet' ) );
}
		$user_info['active'] = 0;
		$usergroupid = intval( $user_info['usergroupid'] );
		if ( in_array( $usergroupid, $user_groupid_in_vbb ) )
		{
			$user_info['active'] = 1;
		}
		
		$birthday = 0;
		if ( $user_info['birthday'] != "" )
		{
			$arr_birthday = array_map( "intval", explode( "-", $user_info['birthday'] ) );
			if ( count( $arr_birthday ) == 3 )
			{
				$birthday = mktime( 0, 0, 0, $arr_birthday[0], $arr_birthday[1], $arr_birthday[2] );
			}
		}
		
		$user_info['userid'] = intval( $user_info['userid'] );
	//	$user_info['username'] = $user_info['username'];
	//	$user_info['email'] = $user_info['email'];
		$user_info['full_name'] = $user_info['username'];
		$user_info['birthday'] = $birthday;
		$user_info['regdate'] = intval( $user_info['joindate'] );
		
		$user_info['website'] = $user_info['homepage'];
		$user_info['location'] = "";
		$user_info['sig'] = "";
		$user_info['yim'] = $user_info['yahoo'];
		$user_info['view_mail'] = 0;
		
		$db->sql_query( "SET NAMES 'utf8'" );
		$sql = "SELECT * FROM `" . NV_USERS_GLOBALTABLE . "` WHERE `userid`=" . intval( $user_info['userid'] );
		$result = $db->sql_query( $sql );
		$numrows = $db->sql_numrows( $result );
		
		if ( $db->sql_numrows( $result ) > 0 )
		{
			$sql = "UPDATE `" . NV_USERS_GLOBALTABLE . "` SET " .
				//`username` = " . $db->dbescape( $user_info['username'] ) . ", 
				//`md5username` = " . $db->dbescape( md5( $user_info['username'] ) ) . ", 
				"`password` = " . $db->dbescape( $password_crypt ) . ", " .
				//`email` = " . $db->dbescape( $user_info['email'] ) . ", 
				"`full_name` = " . $db->dbescape( $user_info['full_name'] ) . ", 
				`birthday`=" . $user_info['birthday'] . ", 
				`sig`=" . $db->dbescape( $user_info['sig'] ) . ", 
				`regdate`=" . $user_info['regdate'] . ", 
				`website`=" . $db->dbescape( $user_info['website'] ) . ", 
				`location`=" . $db->dbescape( $user_info['location'] ) . ", 
				`yim`=" . $db->dbescape( $user_info['yim'] ) . ", 
				`view_mail`=" . $user_info['view_mail'] . ",
				`active`=" . $user_info['active'] . ",
				`last_login`=" . TIMENOW . ", 
				`last_ip`=" . $db->dbescape( $client_info['ip'] ) . ", 
				`last_agent`=" . $db->dbescape( $client_info['agent'] ) . "
				 WHERE `userid`=" . $user_info['userid'];
		}
		else
		{
			// Not exist this user
			$sql = "INSERT INTO `" . NV_USERS_GLOBALTABLE . "` 
				(`userid`, `username`, `md5username`, `password`, `email`, `full_name`, `gender`, `photo`, `birthday`, `sig`, 
				`regdate`, `website`, `location`, `yim`, `telephone`, `fax`, `mobile`, `question`, `answer`, `passlostkey`, 
				`view_mail`, `remember`, `in_groups`, `active`, `checknum`, `last_login`, `last_ip`, `last_agent`, `last_openid`) VALUES 
				(
				" . intval( $user_info['userid'] ) . ", 
				" . $db->dbescape( $user_info['username'] ) . ", 
				" . $db->dbescape( md5( $user_info['username'] ) ) . ", 
				" . $db->dbescape( $password_crypt ) . ", 
				" . $db->dbescape( $user_info['email'] ) . ", 
				" . $db->dbescape( $user_info['full_name'] ) . ", 
				'', 
				'', 
				" . $user_info['birthday'] . ", 
				" . $db->dbescape( $user_info['sig'] ) . ", 
				" . $user_info['regdate'] . ", 
				" . $db->dbescape( $user_info['website'] ) . ", 
				" . $db->dbescape( $user_info['location'] ) . ", 
				" . $db->dbescape( $user_info['yim'] ) . ", 
				'', '', '', '', '', '', 
				" . $user_info['view_mail'] . ", 0, '', 
				" . $user_info['active'] . ", '', 
				" . TIMENOW . ", 
				" . $db->dbescape( $client_info['ip'] ) . ", 
				" . $db->dbescape( $client_info['agent'] ) . ", 
				'' 
				)";
		}
		
		if ( $db->sql_query( $sql ) )
		{
			$error = "";
		}
		else
		{
			$error = $lang['error_update_users_info'];
		}
	
	if( empty( $error ) )
	{
		$sql = "SELECT * FROM `" . NV_USERS_GLOBALTABLE . "` WHERE md5username ='" . md5( $username ) . "'";
		$result = $db->sql_query( $sql );
		if ( $db->sql_numrows( $result ) == 1 )
		{
			$row = $db->sql_fetchrow( $result );
			if ( $row['username'] == $username and $crypt->validate( $password, $row['password'] ) )
			{
				nukevietValidUserLog( $row, 1, '' );
				define( 'IS_USER_NUKEVIET', true );
				define( 'USERID_NUKEVIET', $row['user_id'] );
			}
		}
	}
	
	unset( $userid );
?>