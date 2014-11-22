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
if( !defined('IS_MAIN') ) die("Stop!!!");

// ################## CONFIG ####################
define( 'FORUM_DOMAIN', 'http://lemon9x.com' ); // Vbb
define( 'FORUM_PATH', '/vbb' ); // Vbb
define( 'COOKIE_DOMAIN', '.lemon9x.com' ); // Main domain

define( 'YPLITGROUP_API_CONNECT', true ); // Accept to connect order server 

// Config file
define( 'YPLITGROUP_VBB_CONFIG_FILE', 'db/vbb_config.php' );
define( 'YPLITGROUP_NUKEVIET_CONFIG_FILE', 'db/nukeviet_config.php' );
define( 'YPLITGROUP_XENFORO_CONFIG_FILE', 'db/xenforo_config.php' ); // Go to http://lemon9x.com/forum for support connection to xenforo
define( 'YPLITGROUP_UC_CONFIG_FILE', 'db/uc_config.php' );

// Login type
define( 'YPLITGROUP_USE_ACC_VBB', true ); // Default
define( 'YPLITGROUP_USE_ACC_NUKEVIET', true ); // Use account nukeviet to login if login by vbb fail, please set YPLITGROUP_USE_ACC_UC = false
define( 'YPLITGROUP_USE_ACC_UC', false ); // Use account Ucenter to login if login by vbb fail, please set YPLITGROUP_USE_ACC_NUKEVIET = false

// Admin Email, for Contact Page
$config['admin_email'] = array( 'yplitgroup@gmail.com' );

// Skin 
$config['my_skin'] = 'nova'; // Support: goolge, nova

// ################### FORUM CONFIG ######################
if( !file_exists( pathinfo( __FILE__, PATHINFO_DIRNAME ) . '/' . YPLITGROUP_VBB_CONFIG_FILE ) )
	die('<b>Error!</b><hr /> <i>Do not exist '. YPLITGROUP_VBB_CONFIG_FILE .' file!!!</i>');

$config['connect'] = array( );
$config['connect']['vbb'] = array();

require( pathinfo( __FILE__, PATHINFO_DIRNAME ) . '/' . YPLITGROUP_VBB_CONFIG_FILE );

	$config['connect']['vbb']['host']           = $config['MasterServer']['servername'];
	$config['connect']['vbb']['user']           = $config['MasterServer']['username'];
	$config['connect']['vbb']['pass']           = $config['MasterServer']['password'];
	$config['connect']['vbb']['dbname']         = $config['Database']['dbname'];
	$config['connect']['vbb']['tableprefix']    = $config['Database']['tableprefix'];
	$config['cookie_forum_prefix']              = $config['Misc']['cookieprefix'];

// Nukeviet Config
if( defined( 'YPLITGROUP_API_CONNECT' ) and file_exists( pathinfo( __FILE__, PATHINFO_DIRNAME ) . '/' . YPLITGROUP_NUKEVIET_CONFIG_FILE ) )
{
	define( 'NV_MAINFILE', true );
	require_once( pathinfo( __FILE__, PATHINFO_DIRNAME ) . '/' . YPLITGROUP_NUKEVIET_CONFIG_FILE );
	if( $db_config )
	{
		$config['connect']['nukeviet'] = array();
		$config['connect']['nukeviet']['dbhost']        = $db_config['dbhost'];
		$config['connect']['nukeviet']['dbport']        = $db_config['dbport'];
		$config['connect']['nukeviet']['dbname']        = $db_config['dbname'];
		$config['connect']['nukeviet']['dbuname']       = $db_config['dbuname'];
		$config['connect']['nukeviet']['dbpass']        = $db_config['dbpass'];
		$config['connect']['nukeviet']['prefix']        = $db_config['prefix'];
		$config['connect']['nukeviet']['sitekey']       = $global_config['sitekey'];
		$config['connect']['nukeviet']['cookie_prefix'] = $global_config['cookie_prefix'];
	}
}

// UCenter Config
if( defined( 'YPLITGROUP_API_CONNECT' ) and file_exists( DIR . '/includes/' . YPLITGROUP_UC_CONFIG_FILE ) )
{
	require( DIR . '/includes/' . YPLITGROUP_UC_CONFIG_FILE );
	if( isset( $_SC ) and count( $_SC ) > 0 )
	{
		$config['connect']['uc'] = $_SC;
		$config['connect']['uc']['dbuname'] = $_SC['dbuser'];
		$config['connect']['uc']['dbpass']  = $_SC['dbpw'];
		$config['connect']['uc']['cookie_prefix'] = $_SC['cookiepre'];
	}
}

// Xenforo Config ---------------------------------------------------------
/* --------------- Please go to http://lemon9x.com/forum for support ---------------- * /
if( defined( 'YPLITGROUP_API_CONNECT' ) and file_exists( DIR . '/includes/' . YPLITGROUP_XENFORO_CONFIG_FILE  ) )
{
	require( DIR . '/includes/' . YPLITGROUP_XENFORO_CONFIG_FILE );
	if( $config['db'] )
	{
		$config['connect']['xenforo'] = $config['db'];
		$config['db'] = array();
		$config['connect']['xenforo']['dbhost'] = $config['connect']['xenforo']['host'];
		$config['connect']['xenforo']['dbport'] = $config['connect']['xenforo']['port'];
		$config['connect']['xenforo']['dbuname'] = $config['connect']['xenforo']['username'];
		$config['connect']['nukeviet']['dbpass'] = $config['connect']['xenforo']['password'];
		$config['connect']['nukeviet']['cookie_prefix']
		
		$config['connect']['xenforo']['host'] = '';
	}
}
/* --------------- Please go to http://lemon9x.com/forum for support ---------------- */

// #################################################################
$base_siteurl = pathinfo( $_SERVER['PHP_SELT'], PATHINFO_DIRNAME );

$server_protocol = $f->load( 'yplitgroupGetEnv', 'SERVER_PROTOCOL' );
$server_protocol = strtolower( preg_replace( '/^([^\/]+)\/*(.*)$/', '\\1', $server_protocol ) ) . ( ( $f->load( 'yplitgroupGetEnv', "HTTPS" ) == "on" ) ? "s" : "" );

$server_port = ( $_SERVER['SERVER_PORT'] == "80" ) ? "" : ( ":" . $_SERVER['SERVER_PORT'] );

define( 'DOMAIN', $_SERVER['SERVER_NAME'] ); 
define( 'PATH_SERVER', $_SERVER['DOCUMENT_ROOT'] );

$path = dirname( $_SERVER['PHP_SELF'] );
$path = str_replace( '\\', '/', $path );

if( strlen( $path ) > 1 ) define( 'PATH_SCRIPT', $path . '/' );
else define( 'PATH_SCRIPT', $path );

// For Vbb4. Please comment this if uses for Vbb3
$config['cookie_forum_prefix'] .= '_';
$config['sitekey'] = md5( 'ID-PASSPORT_SYSTEM' . $config['id_host'] . $config['forum_host'] );

// ####################################################
$config['id_host'] = DOMAIN; // vd: http://lemon9x.com
$config['id_path'] = PATH_SCRIPT; 				// vd: /id
$config['forum_host'] = FORUM_DOMAIN;
$config['forum_path'] = FORUM_PATH;  // Khong co dau / o cuoi
$config['cookie_forum_domain'] = COOKIE_DOMAIN; // vd: .lemon9x.com


// Contanst ---------------------------------------------
	define( 'USER_AGENT', !empty( $_SERVER['HTTP_USER_AGENT'] ) ? trim( $_SERVER['HTTP_USER_AGENT'] ) : '' ); 	// User Agent
	define( 'IP', $f->load( 'getonlineip') ); // IP User
	define( 'URL_SCRIPT', $server_protocol . '://'. DOMAIN . $server_port . PATH_SCRIPT ); // URL
	define( 'COOKIE_PREFIX', $config['cookie_forum_prefix'] ); // Forum Cookie Prefix
	define( 'COOKIE_DOMAIN', $config['cookie_forum_domain'] ); // Domain Cookie
	define( 'SITEKEY', $config['sitekey'] ); // Site key md5
	
	// Nukeviet
	if( isset( $config['connect']['nukeviet']['cookie_prefix'] ) )
		define( 'NV_COOKIE_PREFIX', $config['connect']['nukeviet']['cookie_prefix'] );
	if( isset( $config['connect']['nukeviet']['prefix'] ) )
	{
		define( 'NV_TABLE_PREFIX', $config['connect']['nukeviet']['prefix'] );
		define( 'NV_USERS_GLOBALTABLE', $config['connect']['nukeviet']['prefix'] . '_users' );
	}
	
	// Uc 
	if( isset( $config['connect']['uc']['tablepre'] ) )
		define( 'UC_TABLE_PREFIX', $config['connect']['uc']['tablepre'] );
	if( isset( $config['connect']['uc']['cookie_prefix'] ) )
		define( 'UC_COOKIE_PREFIX', $config['connect']['uc']['cookie_prefix'] );

$config['id_url'] = URL_SCRIPT; // vd: http://lemon9x.com/id
$config['forum_url'] = $config['forum_host'] . $config['forum_path'];
$config['id_url'] = preg_replace( '/[\/]+$/', '', $config['id_url'] );
$config['cookie_forum_path'] = '/'; // Default, you can change this

?>