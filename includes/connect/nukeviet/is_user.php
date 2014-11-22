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
	$cookie_user = $param['cookie']->get( NV_COOKIE_PREFIX . '_nvloginhash', '' );
	if( !empty( $cookie_user ) )
	{
		require( DIR . '/includes/connect/nukeviet/function.php' );
		require( DIR . '/includes/connect/nukeviet/crypt.class.php' );
		$cookie_user = decodeCookie( $cookie_user );
		$user = unserialize( nv_base64_decode( $cookie_user ) );
		$strlen = 40; // 40: sha1, 32: md5
		if ( isset( $user['userid'] ) and is_numeric( $user['userid'] ) and $user['userid'] > 0 )
		{
			if ( isset( $user['checknum'] ) and preg_match( "/^[a-z0-9]{" . $strlen . "}$/", $user['checknum'] ) )
			{
				if( $f->load( 'yplitgroupGetDbName' ) != 'nukeviet' )
				{
					$f->load('yplitgroupChangeDb', array( 'nukeviet' ) );
				}
				$query = "SELECT `userid`, `username`, `email`, `full_name`, `gender`, `photo`, `birthday`, `regdate`, `website`, `location`, `yim`, `telephone`, `fax`, 
					`mobile`, `view_mail`, `remember`, `in_groups`, `checknum`, `last_agent` AS `current_agent`, `last_ip` AS `current_ip`, `last_login` AS `current_login`, 
					`last_openid` AS `current_openid`, `password`, `question`, `answer` 
					FROM `" . NV_USERS_GLOBALTABLE . "` WHERE `userid` = " . $user['userid'] . " AND `active`=1 LIMIT 1";
					$result = $db->query( $query );
					if ( $db->sql_numrows( $result ) == 1 )
					{
						$user_info = $db->sql_fetch_assoc( $result );
						$db->sql_freeresult( $result );
						if ( strcasecmp( $user['checknum'], $user_info['checknum'] ) == 0 and //checknum
							isset( $user['current_agent'] ) and ! empty( $user['current_agent'] ) and strcasecmp( $user['current_agent'], $user_info['current_agent'] ) == 0 and //user_agent
							isset( $user['current_ip'] ) and ! empty( $user['current_ip'] ) and strcasecmp( $user['current_ip'], $user_info['current_ip'] ) == 0 and //current IP
							isset( $user['current_login'] ) and ! empty( $user['current_login'] ) and strcasecmp( $user['current_login'], intval( $user_info['current_login'] ) ) == 0   //current login
						)
						{
							if ( empty( $user_info['full_name'] ) )
								$user_info['full_name'] = $user_info['username'];
							//$user_info['in_groups'] = nv_user_groups( $user_info['in_groups'] );
							$user_info['last_login'] = intval( $user['last_login'] );
							$user_info['last_agent'] = $user['last_agent'];
							$user_info['last_ip'] = $user['last_ip'];
							$user_info['last_openid'] = $user['last_openid'];
							$user_info['st_login'] = ! empty( $user_info['password'] ) ? true : false;
							$user_info['valid_question'] = ( ! empty( $user_info['question'] ) and ! empty( $user_info['answer'] ) ) ? true : false;
							$user_info['current_mode'] = ! empty( $user_info['current_openid'] ) ? 2 : 1;
							
							unset( $user_info['checknum'], $user_info['password'], $user_info['question'], $user_info['answer'] );
						}
					}
			}
		}
	}

	if( isset( $user_info ) )
	{
		define( 'IS_USER_NUKEVIET', true );
		
		// Optional
		define( 'IS_LOGIN_NUKEVIET_WITH_USERNAME', $user_info['username'] );
		
		/*--------------------------------------------* / 
		//Remove this comment to not allow user of nukeviet login to vbb if not account at forum
		if( $param['f']->load( 'yplitgroupGetDbName' ) != 'vbb' )
		{
			$param['f']->load( 'yplitgroupChangeDb', array( 'vbb' ) );
		}
		$query = "SELECT 1 FROM `". TABLE_PREFIX ."user` WHERE `username`= ". $db->e( $user_info['username'] ) ."";
		$result = $db->query( $query );
		if( $result )
		{
			if( $db->sql_numrows( $result ) == 1 )
			{
				// Show form with username Text
				define( 'IS_LOGIN_WITH_USERNAME', $user_info['username'] );
			}
			else
			{
				// Do not exists username, do nothing
			}
		}
		/*---------------------------------------*/
	}
	else
	{
		$param['cookie']->_unset( NV_COOKIE_PREFIX . '_nvloginhash' );
	}
	
	if( defined( 'IS_USER_NUKEVIET' ) and defined( 'IS_LOGIN_NUKEVIET_WITH_USERNAME' ) )
	{
		$_REQUEST['autousername'] = base64_encode( htmlspecialchars( IS_LOGIN_NUKEVIET_WITH_USERNAME ) ); // Nukeviet + Vbb Account
	}
}
