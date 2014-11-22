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
if( $f->load( 'yplitgroupGetDbName' ) != 'vbb' )
	$f->load( 'yplitgroupChangeDb', 'vbb' );

$error_content = '';
if( 
	isset( $_POST['submit'] ) and 
	isset( $_POST['currentpassword'] ) and 
	isset( $_POST['newemail'] ) and 
	isset( $_POST['newemailconfirm'] ) and 
	!empty( $_POST['newemail'] ) and
	!empty( $_POST['newemailconfirm'] )
)
{
	$password = security_post( 'currentpassword' );
	$newemail = security_post( 'newemail' );
	$newemailconfirm = security_post( 'newemailconfirm' );

	if( yplitgroupHashPassword( $_POST['currentpassword'], $user_info['salt'] ) != $user_info['password'] )
	{
		$error_content = $lang['editemail_current_password_fail'];
		$f->load( 'yplitgroupHeaderCp' );
		require_once( DIR . '/skin/' . SKINDIR . '/manager_editemail.php' );
		$f->load( 'yplitgroupThemesFooter' );
		exit;
	}

	if( $newemail != $newemailconfirm )
	{
		$error_content = $lang['editemail_newemail_not_sample'];
		$f->load( 'yplitgroupHeaderCp' );
		require_once( DIR . '/skin/' . SKINDIR . '/manager_editemail.php' );
		$f->load( 'yplitgroupThemesFooter' );
		exit;
	}

	if( !yplitgroupCheckEmail( $newemail ) )
	{
		$error_content = $lang['editemail_newemail_fail'];
		$f->load( 'yplitgroupHeaderCp' );
		require_once( DIR . '/skin/' . SKINDIR . '/manager_editemail.php' );
		$f->load( 'yplitgroupThemesFooter' );
		exit;
	}

	$q = 'SELECT 1 FROM `'. TABLE_PREFIX .'user` WHERE `email` = '. $db->e( $newemail );
	if( $f->load( 'yplitgroupGetDbName' ) != 'vbb' )
		$f->load( 'yplitgroupChangeDb', 'vbb' );
	$result = $db->query( $q );
	if( $db->nums( $result ) > 0 )
	{
		$error_content = $lang['editemail_newemail_is_exists'];
		$f->load( 'yplitgroupHeaderCp' );
		require_once( DIR . '/skin/' . SKINDIR . '/manager_editemail.php' );
		$f->load( 'yplitgroupThemesFooter' );
		exit;
	}

	if( $f->load( 'yplitgroupGetDbName' ) != 'vbb' )
		$f->load( 'yplitgroupChangeDb', 'vbb' );
	$q = 'UPDATE `'. TABLE_PREFIX .'user` SET `email` = '. $db->e( $newemail ) . ' WHERE `userid` = '. $user_info['userid'];
	if( $db->query( $q ) )
	{
		@header( 'Location: ' . $config['id_url'] . '/index.php'
				. '?do=' . $param['do'] 
				. ( !empty( $param['return'] ) ? '&return=' . $param['return'] : '' )
				. ( !empty( $param['page'] ) ? '&page=' . $param['page'] : '' )
				. '&hl=vi' );
	}
	else
	{
		$yplitgroupStatus = $lang['system_error'];
		$f->load( 'yplitgroupHeaderCp' );
		require_once( DIR . '/skin/' . SKINDIR . '/alert_page.php' );
		$f->load( 'yplitgroupThemesFooter' );
		exit;
	}
}
else
{
	$f->load( 'yplitgroupHeaderCp' );
	require_once( DIR . '/skin/' . SKINDIR . '/manager_editemail.php' );
	$f->load( 'yplitgroupThemesFooter' );
	exit;
}