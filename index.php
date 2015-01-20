<?php
/**
* @ Project: ID Account System 1.5.0
* @ Author: Yplitgroup (c)2012 (LvDuit 2014)
* @ Email: lvduit08@gmail.com
* @ Website: http://lvduit.com
* @ Phone: 0166.26.26.009
* @ Project ID: 876609683c4c7e392848e94d9f62e149
**/

define( 'IS_MAIN', true ); 
define( 'CONFIG_FILE', 'yplitgroup.php');  // File Config name
define('DIR', pathinfo( str_replace( '\\', '/', __file__ ), PATHINFO_DIRNAME ) );  // Root Path
define( 'TIMENOW', time()); // Real time

global $param; // This is $GLOBALS['param']

// Fix #18, don't ask me why :) ----------------------------------
$_SERVER['REQUEST_URI'] = urlencode( $_SERVER['REQUEST_URI'] );
$_SERVER['HTTP_REFERER'] = urlencode( $_SERVER['HTTP_REFERER'] );

$f = new ypfunction; // Function object, Update #14
$param['f'] = &$f;

if( file_exists( DIR . '/includes/' . CONFIG_FILE ) )
	require_once( DIR . '/includes/' . CONFIG_FILE );

$param['config'] = &$config; // Fix #15

$param['error'] = new error( $config ); // Update #20
$param['error']->setDirLog( DIR . '/tmp/logs' );

// And if not isset Config File
if( !isset( $config ) )
	{
		$param['error']->setSiteKey( md5(rand(99,999)) );
		$param['error']->show('<b>Error!</b><hr /> <i>Config error!!!</i>');
	}

// Include Constants, Functions --------------------------------------
require_once( DIR . '/includes/contants.php');
if( !defined( 'IS_INCLUDE_FUNCTIONS' ) )
	require_once( DIR . '/includes/functions.php' );

$browser = $f->load( 'yplitgroupParseIniFile', DIR . '/tmp/browser.ini' ); // Nukeviet
if( is_array( $browser ) )
{
	foreach( $browser as $name => $info )
	{
		if( preg_match( '#'. $info['rule'] .'#i', USER_AGENT ) )
			define( 'BROWSER', $name );
	}
}
if( !defined( 'BROWSER' ) ) define( 'BROWSER', 'Unknown' );

$param['do'] = 'login'; $param['return'] = '';
$param['session'] = new session( );  // Session

$cookie_config = array(
	'path' => '/',		// Cookie path 
	'domain' => COOKIE_DOMAIN,	// Cookie Domain
	'secure' => false, // secure cookie
	'httponly' => ( BROWSER == 'explorer' ? true : false ), // httptonly for IE, Fix #19
);
$param['cookie'] = new cookie( $cookie_config ); // Cookie

// Check connect -------------------------------------------------
$connect_accept = array( 'nukeviet', 'uc', 'xenforo' );
$param['connect_accept'] = array();
$param['connect'] = array();
if( count( $config['connect'] ) > 0 )
{
	foreach( $config['connect'] as $key => $_connect )
	{
		if( $key == 'vbb' ) continue;
		if( in_array( $key, $connect_accept ) and count( $_connect ) > 0 )
			{
				$param['connect'][$key] = $_connect;
				$param['connect_accept'][] = $key;
			}
	}
}

// Create Database Object --------------------------------------------
$db = new sql_db( $config['connect']['vbb'] );
$param['is_db'] = 'vbb';

$param['db'] = &$db;

// If Connect to MySQL Fail
if( !empty( $db->error ) )
	$param['error']->show( '<b>Error!</b><hr /><i>::VbbDb:: ' . $db->error['user_message'] . '</i>' );

// After Create Database Object, Check user's login --------------------------- 
require_once( DIR . '/includes/is_user.php' );
if( defined( 'YPLITGROUP_API_CONNECT' ) and count( $param['connect'] ) > 0 )
{
	foreach( $param['connect'] as $server => $server_param )
	if( file_exists( DIR . '/includes/connect/' . $server . '/is_user.php' ) )
	{
		require_once( DIR . '/includes/connect/' . $server . '/is_user.php' );
	}
}

if( !defined( 'IS_USER' ) )
{
	if( $param['session']->_get( 'session_hash' ) != '' )
		define( 'HASH', $f->load( 'fetch_sessionhash' ) ); 
	else
	{
		define( 'HASH', $f->load( 'fetch_sessionhash' ) ); // TMP Hash
		$param['session']->_set( 'session_hash', HASH );
	}
}
else
	define( 'HASH', md5( $param['cookie']->get( COOKIE_PREFIX . 'sessionhash' ) ) );

// Get All Options From Vbulletin ----------------------------------------------
//$options = new getOptions; $options = $options->_get();
$options = getOptions::_get(); // Fix #14

// If ID Account System is close by Administrator
if( !isset( $options['yplitgroup_passport_active'] ) ) 
	$param['error']->show('<b>Error!</b><hr /> <i>Please go to Admincp and import yplitgroupProduct.</i>');

// Get return Page if not login ----------------------------------------------
$return_page = $param['session']->get( 'return' );
if( !empty( $return_page) )
{
	$param['return'] = $return_page;
}
if( isset( $_REQUEST['return'] ) AND !empty( $_REQUEST['return'] ) )
{
	if( strtolower( $_REQUEST['return'] ) == 'lastpage' )
	{
		if( !empty( $_SERVER['HTTP_REFERER'] ) )
			$param['return'] = $_SERVER['HTTP_REFERER'];
		else
			$param['return'] = 'index.php?do=manager';
	}
	else
		$param['return'] = urldecode( trim( $_REQUEST['return'] ) );
	if( !empty( $param['return'] ) )
	{
		$param['session']->set( 'return', $param['return'] );
	}
}

$param['manager'] = array();
$param['manager']['page'] = 'infouser';
// Get User info -----------------------------------------------
if( defined( 'IS_USER' ) )
{
	$db->query( "SELECT * FROM `". TABLE_PREFIX ."user` WHERE `userid` = ". USERID );
	$user_info = $db->sql_fetch_assoc();
	$param['manager']['username'] = $user_info['username'];
}

// Return new URL ----------------------------------------------
if( ( $_GET['return'] == 'lastpage' ) and !defined( 'IS_USER' ) and !$_POST )
	@header( 'Location: ' . str_replace( 'return=lastpage', 'return='. $param['return'], urldecode( urldecode( $_SERVER['REQUEST_URI'] ) . ( strpos( urldecode( $_SERVER['REQUEST_URI'] ), '?') ? '&' : '?' ) . ( strpos( urldecode( $_SERVER['REQUEST_URI'] ), 'do=' ) ? '' : 'do=' . $param['do']  ). '&hash=' . HASH ) ) );

// All param "do" ----------------------------------------------
$do = array( 'login', 'logout', 'manager', 'privacy', 'api', 'lostpass', 'register', 'humanverify', 'verifyusername', 'apps', 'contact' );
$_GET['do'] = strtolower( trim( $_GET['do'] ) );
if( isset( $_GET['do'] ) and !empty( $_GET['do'] ) and in_array( $_GET['do'], $do ) )
	$param['do'] = $_GET['do'];

// Manager page -------------------------------------------------
$page = array( 'infouser', 'editpass', 'apps', 'editemail', 'edit_infouser' );
if( $param['do'] == 'manager' and isset( $_GET['page'] ) and in_array( $_GET['page'], $page ) )
	$param['manager']['page'] = $_GET['page'];

// View user info by one ----------------------------------------
if( isset( $_GET['uid'] ) and intval( $_GET['uid'] ) > 0 )
{
	$uid = intval( $_GET['uid'] );
	$query = $db->query( 'SELECT * FROM `'. TABLE_PREFIX .'user` WHERE `userid` = '. $uid );
	if( $query and $db->sql_numrows( $query ) == 1 )
	{
		$user_info = $db->sql_fetch_assoc();
		if( count( $user_info ) > 0 and !isset( $_GET['do'] ) )
		{
			$param['do'] = 'view_user_info';
		}
	}
}

// --------------------------------------------------------------
if( !isset( $_POST ) and ( ( $_GET['return'] == 'lastpage' ) or
	( !isset( $_GET['do'] ) ) or 
	( $param['do'] == 'login' and !defined( 'IS_USER' ) and !isset( $_GET['return'] ) ) or 
	( $param['do'] == 'manager' and ( !isset( $_GET['hl'] ) or !isset( $_GET['page'] ) ) ) or
	( !isset( $_GET['do'] ) and !defined( 'IS_USER' ) and $_GET['return'] == 'lastpage' )
	)
)
	@header( 'Location: ' . $config['id_url'] . '/index.php'
		. '?do=' . $param['do'] 
		. ( !empty( $param['return'] ) ? '&return=' . $param['return'] : '' )
		. ( !empty( $param['page'] ) ? '&page=' . $param['page'] : '' )
		. '&hl=vi'
		. '&hash=' . HASH );

// Language --------------------------------------
$param['language'] = 'vi'; // By default. Support: vi
// Change language by url ?hl=<language>
if( !empty( $_REQUEST['hl'] ) and preg_match( '/^[A-z]+$/', $_REQUEST['hl'] ) and file_exists( DIR . '/includes/language/' . $_REQUEST['hl'] . '.php' ) )
	$param['language'] = $_REQUEST['hl'];
require_once( DIR . '/includes/language/' . $param['language'] . '.php' );

// My Skin -----------------------------------------------------------------
$param['skin'] = $config['my_skin'];  // Support: google, nova
$skin = $param['session']->_get( 'yplitgroupSkin' );
if( !empty( $skin ) and file_exists( DIR . '/skin/' . $skin . '/themes.php' ) )
	$param['skin'] = $skin;

// Change Skin by URL ( ?skin=<skin_dir> ) ----------------------------------
if( isset( $_GET['skin'] ) and !empty( $_GET['skin'] ) and file_exists( DIR . '/skin/' . $_GET['skin'] . '/themes.php' ) )
{
	$param['skin'] = $_GET['skin'];
	$param['session']->_set( 'skin', $param['skin'] );
}
if( !empty( $param['skin'] ) and file_exists( DIR . '/skin/' . $param['skin'] . '/themes.php' ) )
	define( 'SKINDIR', $param['skin'] );
else // Not detect skin
	$param['error']->show('<b>Error!</b><hr /> <i>Skin error!!!</i>');

$yplitgroupPageTitle = $lang['page_title'];
$yplitgroupHeaderTitle = $lang['header_title'];

// Humanverify Images Page -------------------------------------------------
if( $param['do'] == 'humanverify' )
{  
	require_once( DIR . '/includes/humanverify_images.php' );	exit;
}
// Ajax Check Username -----------------------------------------------------
elseif( $param['do'] == 'verifyusername' )
{
	require_once( DIR . '/includes/verifyusername.php' );	exit;
}

// Turn ID Passport on/off -------------------------------------------------
if( !$options['yplitgroup_passport_active'] )
	exit( '<b><center>ID Account System is closed!</center></b>' );

// ----------------------- MAIN --------------------------------//
switch( $param['do'] )
{
	case 'login':
		// Begin Login -----------------------------------------------------
		if( defined( 'IS_USER' ) )
		$f->load('yplitgroupRedirectManager');

		if( isset( $_POST['login'] ) )
		{
			$username = security_post( 'username' );
			$password = security_post( 'password' );
			$remember = ( security_post('remember') == 'yes' ? true : false ); 
			require_once( DIR . '/includes/login.php' );
			if( empty( $error ) )
			{
				if( !empty( $param['return'] ) )
					$f->load('yplitgroupRedirectSite');
				else
					$f->load('yplitgroupRedirectManager');
			}
			else
			{
				$f->load( 'yplitgroupLoginForm', array( $error ) );	exit;
			}
		}
		else
		{
			$f->load('yplitgroupLoginForm');	exit;
		}
		// End Login 
		break;

	case 'logout':
		// Begin Logout -------------------------------------
		require_once( DIR . '/includes/logout.php' );
		$f->load( 'yplitgroupRedirectLogin', array( $param['return'] ) );
		// End Logout
		break;

	case 'register':
		// Begin Register ------------------------------------
		if( defined( 'IS_USER' ) )
		{
			$f->load('yplitgroupRedirectManager'); exit;
		}
		else
		{
			require_once( DIR . '/includes/register.php' ); exit;
		}
		// End Register
		break;

	case 'manager':
		// Begin Manager --------------------------------------
		if( !defined( 'IS_USER' ) )
			$f->load( 'yplitgroupRedirectLogin', $_SERVER['REQUEST_URI'] );
		else
			require_once( DIR . '/includes/manager.php' );
		// End Manager
		break;

	case 'lostpass':
		// Begin Lost Password ----------------------------------
		if( isset( $_GET['k'] ) and !empty( $_GET['k'] ) and preg_match( '/^[A-z0-9]+$/', $_GET['k'] ) )
		{
			require_once( DIR . '/includes/lostpass_enter.php' );
			exit;
		}
		elseif( isset( $_POST['submit'] ) 
				and ( isset( $_POST['email'] ) or isset( $_POST['username'] ) )
				and ( !empty( $_POST['email'] ) or !empty( $_POST['username'] ) )
				and isset( $_POST['humanverify'] )
				and !empty( $_POST['humanverify'] )
		)
		{
			require_once( DIR . '/includes/lostpass_submit.php' );
			exit;
		}
		else
		{
			require_once( DIR . '/includes/lostpass.php' );
			exit;
		}
		// End Lost Password
		break;

	case 'contact':
		// Begin Contact Page -----------------------------------
		require_once( DIR . '/includes/contact.php' );
		// End Contact Page
		break;

	case 'privacy': // Chinh sach bao mat --------------------------
		$error->show('Dang cap nhat!');
		break;

	case 'apps': case 'app': //---------------------------------------
		// Begin Application list 
		if( defined( 'IS_USER' ) )
			$f->load('yplitgroupHeaderCp');
		else
			$f->load('yplitgroupThemesHeader');
		require_once( DIR . '/skin/' . SKINDIR . '/apps.php' );
		
		if( defined( 'IS_USER' ) )
			$f->load('yplitgroupFooterCp');
		else
			$f->load('yplitgroupThemesFooter');
		exit;
		// End Application list 
		break;

	case 'api': // Api connection, you can buy this? -----------------------
		$error->show('Vui long lien he <b>yplitgroup@gmail.com</b>');
		break;

	case 'login': default: // --------------------------------------------
		if( defined( 'IS_USER' ) )
			$f->load('yplitgroupRedirectManager');
		else
			$f->load('yplitgroupLoginForm');
		break;
}

function __autoload( $class_name )
{
	if( file_exists( DIR . '/includes/class/class_'. $class_name . '.php' ) )
		require_once( DIR . '/includes/class/class_'. $class_name . '.php' );
}

?>
