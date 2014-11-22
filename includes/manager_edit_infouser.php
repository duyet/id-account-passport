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
if( !$_POST )
{
	require( DIR . '/includes/manager_get_infouser.php' );
	yplitgroupHeaderCp();
	require_once( DIR . '/skin/' . SKINDIR . '/manager_edit_infouser.php' );
	yplitgroupThemesFooter();
	exit;
}

$email = security_post( 'email' );
if( $email != $info_user['email'] )
{
	if( !yplitgroupCheckEmail( $email ) )
	{
		$yplitgroupStatus = $lang['editemail_newemail_fail'];
		require_once( DIR . '/skin/' . SKINDIR . '/alert_page.php' );
		exit;
	}
}
else
	$email = null; // Not change this

$showbirthday = intval( security_post( 'showbirthday' ) );

if( !in_array( $showbirthday, array( 0, 1, 2, 3 ) ) )
	$showbirthday = null; // Not change this

$homepage = security_post( 'homepage' );
if( $homepage == '' or $homepage == $info_user['homepage'] ) $homepage = null; // Not change this

$icq = security_post( 'icq' );
if( $icq == '' or $icq == $info_user['icq'] ) $icq = null; // Not change this

$aim = security_post( 'aim' );
if( $aim == '' or $aim == $info_user['aim'] ) $aim = null; // Not change this

$msn = security_post( 'msn' );
if( $msn == '' or $msn == $info_user['msn'] ) $msn = null; // Not change this

$yahoo = security_post( 'yahoo' );
if( $yahoo == '' or $yahoo == $info_user['yahoo'] ) $yahoo = null; // Not change this

$skype = security_post( 'skype' );
if( $skype == '' or $skype == $info_user['skype'] ) $skype = null; // Not change this

$userfield = $_POST['userfield'];
foreach( $userfield as $key => $value )
{
	if( is_string( $value ) )
		$userfield[$key] = security_post_string( $userfield[$key] );
}

$field = array( 'email', 'showbirthday', 'homepage', 'icq', 'aim', 'msn', 'yahoo', 'skype' );
$update = array();
foreach( $field as $value )
{
	if( $info_user[$value] != $$value and $$value != null )
		$update[] = '`'. $value .'` = '. $db->e( $$value );
}

require_once( DIR . '/includes/manager_get_customfields_id.php' );
// Get user customfields
$user_customfields_data = array();
$db->query( 'SELECT * FROM `'. TABLE_PREFIX .'userfield` WHERE `userid` = '. USERID );
if( $db->nums() > 0 )
	$user_customfields_data = $db->sql_fetch_assoc();
foreach( $id_customfields as $id )
{
	if( isset( $userfield['field'.$id] ) 
		and !empty( $userfield['field'.$id] ) 
		and $userfield['field'.$id] != $user_custom_data['field'.$id]
	)
	{
		$update_customfields[] = '`field'. $id .'` = '. 
			$db->e( (
				is_array( $userfield['field'.$id] ) ? 
					implode( ',', $userfield['field'.$id] ) :
						$userfield['field'.$id]
			) );
	}
}
print_r( $update_customfields );

?>