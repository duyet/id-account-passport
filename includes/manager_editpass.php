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

if( $f->load( 'yplitgroupGetDbNane' ) != 'vbb' )
{
	$f->load( 'yplitgroupChangeDb', 'vbb' );
}

if( 
	isset( $_POST['submit'] ) and 
	isset( $_POST['currentpassword'] ) and 
	isset( $_POST['newpassword'] ) and 
	isset( $_POST['newpasswordconfirm'] ) and 
	!empty( $_POST['currentpassword'] ) and
	!empty( $_POST['newpassword'] ) and
	!empty( $_POST['newpasswordconfirm'] )
)
{
	$yplitgroupCurrentPassword = security_post( 'currentpassword' );
	$yplitgroupNewPassword = security_post( 'newpassword' ); 
	$yplitgroupNewPasswordCofirm = security_post( 'newpasswordconfirm' );
	if( $yplitgroupNewPassword != $yplitgroupNewPasswordCofirm )
	{
		yplitgroupHeaderCp();
		$error_content = $lang['newpassword_must_sample_newpasswordconfirm'];
		require( DIR . '/skin/' . SKINDIR . '/manager_editpass.php' );
		yplitgroupThemesFooter();
		exit;
	}
	elseif( $yplitgroupCurrentPassword == $yplitgroupNewPassword )
	{
		yplitgroupHeaderCp();
		$error_content = $lang['newpassword_must_differnt_currentpassword'];
		require( DIR . '/skin/' . SKINDIR . '/manager_editpass.php' );
		yplitgroupThemesFooter();
		exit;
	}
	elseif( strlen( $yplitgroupNewPassword ) < 3 or strlen( $yplitgroupNewPassword ) > 50 )
	{
		yplitgroupHeaderCp();
		$error_content = $lang['strlen_newpassword_incorrect'];
		require( DIR . '/skin/' . SKINDIR . '/manager_editpass.php' );
		yplitgroupThemesFooter();
		exit;
	}
	elseif(  $user_info['password'] != md5( md5( $yplitgroupCurrentPassword ) . $user_info['salt'] ) )
	{
		yplitgroupHeaderCp();
		$error_content = $lang['current_password_incorrect'];
		require( DIR . '/skin/' . SKINDIR . '/manager_editpass.php' );
		yplitgroupThemesFooter();
		exit;
	}
	else
	{
		if( yplitgroupCheckPasswordHistory( yplitgroupHashPassword( $yplitgroupNewPassword, $info_user['salt'] ), 0 ) )
		{
			yplitgroupHeaderCp();
			$error_content = $lang['error_password_history'];
			require( DIR . '/skin/' . SKINDIR . '/manager_editpass.php' );
			yplitgroupThemesFooter();
			exit;
		}
		else
		{
			$q = "UPDATE `" . TABLE_PREFIX . "user` SET `password` = " . $db->e( md5( md5( $yplitgroupNewPassword ) . $user_info['salt'] ) ) . " WHERE `userid` = " . USERID;
			if( $db->query( $q ) )
			{
				if( isset( $_COOKIE[COOKIE_PREFIX.'userid'] ) and isset( $_COOKIE[COOKIE_PREFIX.'password'] ) )
				{
					setcookie( COOKIE_PREFIX.'userid', USERID, COOKIE_LIVE_TIME, '/', COOKIE_DOMAIN );
					setcookie( COOKIE_PREFIX.'password', md5( md5( $yplitgroupNewPassword ) . $user_info['salt'] ), COOKIE_LIVE_TIME, '/', COOKIE_DOMAIN );
				}
				@header( 'Location: ' . $config['id_url'] . '/index.php'
					. '?do=' . $param['do'] 
					. ( !empty( $param['return'] ) ? '&return=' . $param['return'] : '' )
					. ( !empty( $param['page'] ) ? '&page=' . $param['page'] : '' )
					. '&hl=vi' );
			}
		}
	}
}
else
{
	yplitgroupHeaderCp();
	require_once( DIR . '/skin/' . SKINDIR . '/manager_editpass.php' );
	yplitgroupThemesFooter();
	exit;
}