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
if( defined( 'IS_USER' ) ) yplitgroupRedirectManager(); 
if( !$options['allow_register_page'] )
{
	eval( '$yplitgroupStatus = "' . $lang['register_is_disable'] .' "; ');
	$f->load('yplitgroupThemesHeader');
	require_once( DIR . '/skin/' . SKINDIR . '/register_sucessfully.php' );
	$f->load('yplitgroupThemesFooter');
	exit;
}
require_once( DIR . '/includes/get_register_info.php' );
$yplitgroupPageTitle = $lang['register_page_title'] . ' &middot; ' . $lang['header_title'];
$yplitgroupRightText = $lang['register_page_title'];

if( $_REQUEST['p'] == 'addmember' and $_POST )
{

	if( !$options['allowregistration'] )
	{
		exit( 'Register is deny!' );
	}

	$fiels = array();
	$fiels['submit']			= TYPE_STR;
	$fiels['username']			= TYPE_STR;
	$fiels['password']			= TYPE_STR;
	$fiels['passwordconfirm']	= TYPE_STR;
	$fiels['email']				= TYPE_STR;
	$fiels['emailconfirm']		= TYPE_STR;
	$fiels['humanverify']		= TYPE_STR;
	$fiels['day']				= TYPE_INT;
	$fiels['month']				= TYPE_INT;
	$fiels['year']				= TYPE_INT;
	$fiels['userfield']			= TYPE_ARRAY;
	
	foreach( $fiels as $fielnames => $value )
	{
		if( $value == TYPE_STR )
		{
			$$fielnames = trim( security_post( $fielnames ) );
		}
		elseif( $value == TYPE_INT )
		{
			$$fielnames = intval( security_post( $fielnames ) );
		}
		else
		{
			$$fielnames = $_POST[$fielnames];
		}
	}

	foreach( $userfield as $userfield_name => $userfield_value )
	{
		$userfield[$userfield_name] = security_post_string( $userfield_value );
	}

	$is_fill_all_custom_fiels = false;
	foreach( $list_require as $require )
	{
		if( empty( $userfield["field$require"] ) or !$userfield["field$require"] )
		{
			$yplitgroupRegisterError = $lang['please_require_all_custom_fiels'];
			yplitgroupViewFormRegister();
			exit;
		}
	}

	if( empty( $username )
		OR empty( $email )
		OR empty( $emailconfirm )
		OR empty( $password )
		OR empty( $passwordconfirm )
	)
	{
		$yplitgroupRegisterError = $lang['fieldmissing'];
		yplitgroupViewFormRegister();
		exit;
	}

	if( !isset( $_SESSION['yplitgroupHumanverify'] ) 
		or ( $_SESSION['yplitgroupHumanverify'] != $humanverify )
	)
	{
		$yplitgroupRegisterError = $lang['humanverifyfail'];
		yplitgroupViewFormRegister();
		exit;
	}

	if( $password != $passwordconfirm )
	{
		$yplitgroupRegisterError = $lang['passwordmismatch'];
		yplitgroupViewFormRegister();
		exit;
	}

	if( $email != $emailconfirm )
	{
		$yplitgroupRegisterError = $lang['emailmismatch'];
		yplitgroupViewFormRegister();
		exit;
	}

	if( strlen( $password ) < 3 or strlen( $password ) > 30 )
	{
		$yplitgroupRegisterError = ( strlen( $password ) < 3 ) ? $lang['length_password_too_short'] : $lang['length_password_too_long'];
		yplitgroupViewFormRegister();
		exit;
	}

	if( strlen( $username ) < 3 or strlen( $username ) > 30 )
	{
		$yplitgroupRegisterError = ( strlen( $username ) < 3 ) ? $lang['length_username_too_short'] : $lang['length_username_too_long'];
		yplitgroupViewFormRegister();
		exit;
	}

	if( $day < 1 or $day > 31 or $month < 1 or $month > 12 or $year < 1800 or $year > 2030 or ( $month == 2 and $day > 30 ) )
	{
		$yplitgroupRegisterError = $lang['day_of_birth_fail'];
		yplitgroupViewFormRegister();
		exit;
	}

	if( yplitgroupCheckEmail( $email ) === false )
	{
		$yplitgroupRegisterError = $lang['email_is_incorrect'];
		yplitgroupViewFormRegister();
		exit;
	}

	$q = "SELECT `userid` FROM `". TABLE_PREFIX ."user` WHERE `email` = " . $db->e( $email );
	$db->query( $q );
	if( $db->nums() != 0 )
	{
		$yplitgroupRegisterError = $lang['email_is_exist'];
		yplitgroupViewFormRegister();
		exit;
	}

	// Usergroup id
	if ( $options['moderatenewmembers'] )
	{
		$newusergroupid = 4;
	}
	else
	{
		$newusergroupid = 2;
	}
	
	//Usergroup name
	$db->query( "SELECT `title` FROM " . TABLE_PREFIX . "usergroup WHERE `usergroupid` = $newusergroupid" );
	$usertitle = $db->sql_fetch_assoc(  );

	$q = "SELECT `userid` FROM `". TABLE_PREFIX ."user` WHERE `username` = ". $db->e( $username );
	$db->query( $q );
	if( $db->nums() != 0 )
	{
		$yplitgroupRegisterError = $lang['username_is_exist'];
		yplitgroupViewFormRegister();
		exit;
	}

	$salt = yplitgroupFetchUserSalt( 15 );
	$q = "INSERT INTO `". TABLE_PREFIX ."user`( `usergroupid`, `username`, `password`, `email`, `joindate`, `lastvisit`, `salt`, `ipaddress`, `lastactivity`, `passworddate`, `birthday`, `showvbcode`, `usertitle` ) VALUE ( ". $newusergroupid .", ". $db->e( $username ) .", ". $db->e( md5( md5( $password ) . $salt ) ) .", ". $db->e( $email ) .", ". TIMENOW .", ". TIMENOW .", ". $db->e( addslashes( $salt ) ) .", ". $db->e( IP ) .", ". TIMENOW .", '". date( 'Y', TIMENOW ) . '-' . date( 'm', TIMENOW ) . '-' . date( 'd', TIMENOW ) ."', '". $day . '-' . $month . '-' . $year ."', 2, '$usertitle[title]' )";
	
	if( !$db->sql_query( $q ) )
	{
		echo 'Error! <hr />'; print_r($db->sql_error());exit;
		$yplitgroupStatus = $lang['register_error'] . '<br>' ;
		$f->load('yplitgroupThemesHeader');
		require_once( DIR . '/skin/' . SKINDIR . '/register_sucessfully.php' );
		$f->load('yplitgroupThemesFooter');
		exit;
	}
	else
	{
		$db->query( 'SELECT `userid` FROM `'. TABLE_PREFIX .'user` WHERE `username` = \''. $username .'\'' );
		$userid = $db->fetchrow();
		$userid = intval( $userid['userid'] );
		// Set User Fields
		$customfields = yplitgroupSetUserfields( $userfield, true, 'register');
		if ($newusergroupid == 2)
		{
			if ($options['welcomemail'])
			{
				$tmp = yplitgroupGetPhrase( 'welcomemail', 'emailbody');
				$tmp = str_replace( '$vboptions[bbtitle]', $options['bbtitle'], $tmp );
				eval( '$message = "'. $tmp . '";' );
				$tmp = yplitgroupGetPhrase('welcomemail', 'emailsubject');
				$tmp = str_replace( '$vboptions[bbtitle]', $options['bbtitle'], $tmp );
				eval( '$subject = "'. $tmp . '";' );
				yplitgroupMail($email, $subject, $message);
			}
		}
		$autousername = base64_encode( htmlspecialchars( $username ) );
		$autopassword = base64_encode( htmlspecialchars( $password ) );
		$return = urlencode( $param['return'] );
		eval( '$yplitgroupStatus = "' . $lang['register_successfull'] . '";'); // Set yplitgroupStatus from eval
		$f->load('yplitgroupThemesHeader');
		require_once( DIR . '/skin/' . SKINDIR . '/register_sucessfully.php' );
		$f->load('yplitgroupThemesFooter');
		exit;
	}
}
else
{
	$f->load( 'yplitgroupViewFormRegister' );
}

?>