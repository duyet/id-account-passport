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
$error = ''; 
if( $f->load( 'yplitgroupGetDbName' ) != 'vbb' )
{
	$f->load('yplitgroupChangeDb', array( 'vbb' ) );
}
$db->sql_query( "SET NAMES 'latin1'" );
$result = $db->query( "SELECT * FROM `" . TABLE_PREFIX . "user` WHERE `username`=" . $db->e( $username ) . "" ); 
if( $db->sql_numrows( $result ) > 0 )
{
	$infoUser = $db->sql_fetchrow( $result );
	
	if( intval( $infoUser['userid'] ) > 0 and $infoUser['password'] == md5( md5( $password ) . $infoUser['salt'] ) )
	{
		if ( $remember )
		{
			$param['cookie']->set( COOKIE_PREFIX.'userid', $infoUser['userid'], COOKIE_LIVE_TIME, '/', COOKIE_DOMAIN );
			$param['cookie']->set( COOKIE_PREFIX.'password', md5( $user_info['password'] ), COOKIE_LIVE_TIME, '/', COOKIE_DOMAIN );
		}

		$query = build_query_array( $infoUser['userid'], $remember );
		$db->query( "INSERT IGNORE INTO " . TABLE_PREFIX. "session (" . implode( ', ', array_keys( $query ) ) . ") VALUES (" . implode( ', ', $query ) . ")" );
		define( 'IS_USER', true );
		define( 'USERID', $infoUser['userid'] );

		// Connect to orther system
		if( count( $param['connect'] ) > 0 )
		{
			foreach( $param['connect'] as $server => $server_param )
			{
				if( file_exists( DIR . '/includes/connect/' . $server . '/login.php' ) )
					require_once( DIR . '/includes/connect/' . $server . '/login.php' );
			}
		}
	}
	else
	{
		$error = $lang['login_incorrect'];
	}
}
else
{
	if( YPLITGROUP_USE_ACC_NUKEVIET and YPLITGROUP_API_CONNECT )
	{
		require_once( DIR . '/includes/connect/nukeviet/function.php' );
		require_once( DIR . '/includes/connect/nukeviet/crypt.class.php' );
		$crypt = new nv_Crypt( $config['connect']['nukeviet']['sitekey'] ,'sha1' ); 
		// Try login by account nukeviet
		if( $f->load( 'yplitgroupGetDbName' ) != 'nukeviet' )
		{
			$f->load('yplitgroupChangeDb', array( 'nukeviet' ) );
		}
		$sql = "SELECT * FROM `" . NV_USERS_GLOBALTABLE . "` WHERE md5username ='" . md5( $username ) . "'";
		$result = $db->query( $sql );
		if ( $db->sql_numrows( $result ) == 1 )
		{
			$row = $db->sql_fetchrow( $result );
			if ( $row['username'] == $username and $crypt->validate( $password, $row['password'] ) )
			{
				if ( !$row['active'] )
				{
					// Not Active, so can't login
					$error = $lang['login_not_active'];
				}
				else
				{
					$error = "";
					// Insert username to Vbb with account Nukeviet
					if( $f->load( 'yplitgroupGetDbName' ) != 'vbb' )
					{
						$f->load('yplitgroupChangeDb', array( 'vbb' ) );
					}
					
					// Check email 
					$query = "SELECT 1 FROM `". TABLE_PREFIX ."user` WHERE `email` = ". $db->e( $row['email'] );
					$result = $db->query( $query );
					if( $db->sql_numrows( $result ) == 0 )
					{
						$salt = $f->load( 'yplitgroupFetchUserSalt', 15 );
						$q = "INSERT INTO `". TABLE_PREFIX ."user`( 
							`usergroupid`, 
							`username`, 
							`password`, 
							`email`, 
							`joindate`, 
							`lastvisit`, 
							`salt`, 
							`ipaddress`, 
							`lastactivity`, 
							`passworddate`, 
							`birthday`, 
							`showvbcode`, 
							`usertitle` 
						) VALUE ( 
							". 2 .", 
							". $db->e( $username ) .", 
							". $db->e( md5( md5( $password ) . $salt ) ) .", 
							". $db->e( $row['email'] ) .", 
							". TIMENOW .", 
							". TIMENOW .", 
							". $db->e( addslashes( $salt ) ) .", 
							". $db->e( IP ) .", 
							". TIMENOW .", 
							'". date( 'Y', TIMENOW ) . '-' . date( 'm', TIMENOW ) . '-' . date( 'd', TIMENOW ) ."', 
							'". date( 'd', $row['birthday'] ) . '-' . date( 'm', $row['birthday'] ) . '-' . date( 'Y', $row['birthday'] ) ."', 
							2, 
							". $db->e( $row['full_name'] ) ."
						)";
						if( $db->query( $q ) )
						{
							$infoUser = $db->query( "SELECT * FROM `". TABLE_PREFIX ."user` WHERE `username` = ". $db->e( $username ) );
							$infoUser = $db->sql_fetchrow( $infoUser );

							
							if ( $remember )
							{
								$param['cookie']->set( COOKIE_PREFIX.'userid', $infoUser['userid'], COOKIE_LIVE_TIME, '/', COOKIE_DOMAIN );
								$param['cookie']->set( COOKIE_PREFIX.'password', md5( $user_info['password'] ), COOKIE_LIVE_TIME, '/', COOKIE_DOMAIN );
							}
							$query = build_query_array( $infoUser['userid'], $remember );
							if( $f->load( 'yplitgroupGetDbName' ) != 'vbb' )
							{
								$f->load('yplitgroupChangeDb', array( 'vbb' ) );
							}
							$db->query( "INSERT IGNORE INTO " . TABLE_PREFIX . "session (" . implode( ', ', array_keys( $query ) ) . ") VALUES (" . implode( ', ', $query ) . ")" );
							define( 'IS_USER', true );
							define( 'USERID', $infoUser['userid'] );
						}
						else
						{
							// Query Fail, Error return
							$error = 'Register to Forum Fail ';
						}
					}
					nukevietValidUserLog( $row, 1, '' ); // Login to nukeviet
				}
			}
		}
		else
		{
			// Can't login :(
			$error = $lang['login_incorrect'];
		}
	}
	
	elseif( YPLITGROUP_USE_ACC_UC and YPLITGROUP_API_CONNECT )
	{
		require_once( DIR . '/includes/connect/uc/function.php' );
		$uc = new uc( $param );
		if( $f->load( 'yplitgroupGetDbName' ) != 'uc' )
			$f->load( 'yplitgroupChangeDb', 'uc' );

		$result = $db->query( 'SELECT * FROM '. UC_DBTABLEPRE .'members WHERE `username` = ' . $db->e( $username ) );
		if( $db->sql_numrows( $result ) == 1 )
		{
			$row = $db->sql_fetch_assoc( $result );
			if( $row['password'] == md5( md5( $password ) . $row['salt'] ) )
			{
				// It's Uc member
				
				$f->load( 'yplitgroupChangeDb', 'vbb' );
				// Check mail forum
				if( !empty( $row['email'] ) )
				{
					$result = $db->query( 'SELECT 1 FROM `'. TABLE_PREFIX .'user` WHERE `email` = '. $db->e( $row['email'] ) );
					if( $db->sql_numrows( $result ) == 0 )
					{
						$salt = $f->load( 'yplitgroupFetchUserSalt', 15 );
						$q = "INSERT INTO `". TABLE_PREFIX ."user`( 
							`usergroupid`, 
							`username`, 
							`password`, 
							`email`, 
							`joindate`, 
							`lastvisit`, 
							`salt`, 
							`ipaddress`, 
							`lastactivity`, 
							`passworddate`, 
							`birthday`, 
							`showvbcode`, 
							`usertitle` 
						) VALUE ( 
							". 2 .", 
							". $db->e( $username ) .", 
							". $db->e( md5( md5( $password ) . $salt ) ) .", 
							". $db->e( $row['email'] ) .", 
							". TIMENOW .", 
							". TIMENOW .", 
							". $db->e( addslashes( $salt ) ) .", 
							". $db->e( IP ) .", 
							". TIMENOW .", 
							'". date( 'Y', TIMENOW ) . '-' . date( 'm', TIMENOW ) . '-' . date( 'd', TIMENOW ) ."', 
							'00-00-0000', 
							2, 
							''
						)";
						if( $db->query( $q ) )
						{
							$infoUser = $db->query( "SELECT * FROM `". TABLE_PREFIX ."user` WHERE `username` = ". $db->e( $username ) );
							$infoUser = $db->sql_fetchrow( $infoUser );

							
							if ( $remember )
							{
								$param['cookie']->set( COOKIE_PREFIX.'userid', $infoUser['userid'], COOKIE_LIVE_TIME, '/', COOKIE_DOMAIN );
								$param['cookie']->set( COOKIE_PREFIX.'password', md5( $user_info['password'] ), COOKIE_LIVE_TIME, '/', COOKIE_DOMAIN );
							}
							$query = build_query_array( $infoUser['userid'], $remember );
							$f->load('yplitgroupChangeDb', array( 'vbb' ) );
							$db->query( "INSERT IGNORE INTO " . TABLE_PREFIX . "session (" . implode( ', ', array_keys( $query ) ) . ") VALUES (" . implode( ', ', $query ) . ")" );
							define( 'IS_USER', true );
							define( 'USERID', $infoUser['userid'] );
							
							// Uc login
							define( 'IS_USER_UC', true );
							define( 'USERID_UC', $row['uid'] );
							$mtime = explode(' ', microtime());
							$timestamp = $mtime[1];
							$setarr = array(
								'uid' => $row['uid'],
								'username' => addslashes($username),
								'password' => md5("$row[uid]|$timestamp") );
							$ip = getonlineip(1);
							$setarr['lastactivity'] = intval( $timestamp );
							$setarr['ip'] = $ip;
							
							//$uc->inserttable('session', $setarr, 0, true, 1);
							$f->load('yplitgroupChangeDb', array( 'uc' ) );
							$db->query( 'INSERT INTO `'. UC_TABLE_PREFIX .'session` 
								 ( uid,                       username,                    password,                 lastactivity,     ip,       maggichidden)
							VALUE( "'. $setarr['uid'] .'","'. $setarr['username'] .'", "'. $setarr['password'] .'", '. $setarr['lastactivity'] .', "'. $setarr['ip'] .'", 0
							' );
							
							$param['cookie']->set( UC_COOKIE_PREFIX . 'auth', $uc->authcode("$setarr[password]\t$setarr[uid]", 'ENCODE'), COOKIE_LIVE_TIME );
							$param['cookie']->set( UC_COOKIE_PREFIX . 'loginuser', $passport['username'], COOKIE_LIVE_TIME );
							$param['cookie']->set( UC_COOKIE_PREFIX . '_refer', '' );
						}
						else
						{
							// Query Fail, Error return
							$error = 'Register to Forum Fail ';
						}
					}
					else
					{
						$error = $lang['login_incorrect'];
					}
				}
				else
				{
					$error = $lang['login_incorrect'];
				}
			}
			else
			{
				$error = $lang['login_incorrect'];
			}
		}
		else
		{
			$error = $lang['login_incorrect'];
		}
	}
	
	else
	{
		// Oop, Can't login
		$error = $lang['login_incorrect'];
	}
}
?>