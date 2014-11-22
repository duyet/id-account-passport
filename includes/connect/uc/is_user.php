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
if( !defined( 'IS_USER' ) )
{
	$cookie_user = $param['cookie']->get( UC_COOKIE_PREFIX . 'auth', '' );
	if( !empty( $cookie_user ) )
	{
		require( DIR . '/includes/connect/uc/function.php' );
		$uc = new uc( $param );
		@list($password, $uid) = explode("\t", $uc->authcode( $cookie_user, 'DECODE' ) );
		if( $password and $uid)
		{
			if( $f->load( 'yplitgroupGetDbName' ) != 'uc' )
				$f->load( 'yplitgroupChangeDb', 'uc' );
			$query = $db->query( "SELECT * FROM ". UC_TABLE_PREFIX . 'session' . " WHERE uid = $uid" );
			if( $db->sql_numrows( $query ) == 1 )
			{
				$member = $db->sql_fetch_assoc( $query );
				if( $member['password'] == $password )
				{
					define( 'IS_USER_UC', true );
					define( 'USERID_UC', $member['uid'] );
					define( 'IS_LOGIN_UC_WITH_USERNAME', $member['username'] );
				}
				else
				{
					$param['cookie']->_unset( UC_COOKIE_PREFIX . 'auth' );
				}
			}
			else
			{
				// die( "SELECT * FROM ". UC_TABLE_PREFIX . 'member' ." WHERE uid = $uid ");
				$query = $db->query( "SELECT * FROM ". UC_DBTABLEPRE . 'members' ." WHERE uid = $uid ");
				if( $db->sql_numrows( $query ) == 1 )
				{
					$member = $db->sql_fetch_assoc( $query );
					if($member['password'] == $password)
					{
						$mtime = explode(' ', microtime());
						$timestamp = $mtime[1];
						$setarr = array(
							'uid' => $member['uid'],
							'username' => addslashes($member['username']),
							'password' => $password );
						$ip = getonlineip(1);
						$setarr['lastactivity'] = $timestamp;
						$setarr['ip'] = $ip;
						$uc->inserttable('session', $setarr, 0, true, 1);
					}
				}
			}
		}
	}
	if( defined( 'IS_USER_UC' ) and defined( 'IS_LOGIN_UC_WITH_USERNAME' ) )
	{
		$_REQUEST['autousername'] = base64_encode( htmlspecialchars( IS_LOGIN_UC_WITH_USERNAME ) ); // UC + Vbb Account
	}
}

?>