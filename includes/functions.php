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
	
// ############### MAIN ###############
define('IS_INCLUDE_FUNCTIONS', true);
	
$remember = true;
$user_groupid_in_vbb = array( 
	2, 5, 6, 7 
);
	
function yplitgroupCheckPasswordHistory( $password, $historylength )
{
	global $db, $config, $user_info, $param;
	// delete old password history
	if( $param['f']->load( 'yplitgroupGetDbNane' ) != 'vbb' )
		$param['f']->load( 'yplitgroupChangeDb', 'vbb' );

	$db->query("
		DELETE FROM " . TABLE_PREFIX . "passwordhistory
		WHERE userid = " . USERID . "
		AND passworddate <= FROM_UNIXTIME(" . ( TIMENOW - $historylength * 86400 ) . ")
	");
		// check to see if the password is invalid due to previous use
	if ($historylength AND $historycheck = $db->query("
		SELECT UNIX_TIMESTAMP(passworddate) AS passworddate
		FROM " . TABLE_PREFIX . "passwordhistory
		WHERE userid = " . USERID . "
		AND password = '" . $db->e( $password ) . "'"))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function fetch_substr_ip($ip, $length = null)
{
	if ($length === null OR $length > 3)
	{
		$length = 1;
	}
	return implode('.', array_slice(explode('.', $ip), 0, 4 - $length));
}

function build_query_array ( $userid, $permanent )
{
	global $db, $param;
	
	$return = array();
	
	$db_fields = array( 
		'sessionhash' => TYPE_STR, 'userid' => TYPE_INT, 'host' => TYPE_STR, 'idhash' => TYPE_STR, 'lastactivity' => TYPE_INT, 'location' => TYPE_STR, 'styleid' => TYPE_INT, 'languageid' => TYPE_INT, 'loggedin' => TYPE_INT, 'inforum' => TYPE_INT, 'inthread' => TYPE_INT, 'incalendar' => TYPE_INT, 'badlocation' => TYPE_INT, 'useragent' => TYPE_STR, 'bypass' => TYPE_INT, 'profileupdate' => TYPE_INT 
	);
	
	$sessionhash = fetch_sessionhash();
	$param['cookie']->set( COOKIE_PREFIX.'lastactivity', 0, COOKIE_LIVE_TIME, '/', COOKIE_DOMAIN ); 
	$param['cookie']->set( COOKIE_PREFIX.'lastvisit', TIMENOW, COOKIE_LIVE_TIME, '/', COOKIE_DOMAIN );
	if ( $permanent )
	{
		$expire = COOKIE_LIVE_TIME;
	}
	else
	{
		$expire = 0;
	}
	$param['cookie']->set( COOKIE_PREFIX.'sessionhash', $sessionhash, $expire, '/', COOKIE_DOMAIN );
	$thisvars = array( 
		'sessionhash' => $sessionhash, 'dbsessionhash' => $sessionhash, 'userid' => intval( $userid ), 'host' => IP, 'idhash' => md5( USER_AGENT . fetch_substr_ip( IP ) ), 'lastactivity' => TIMENOW, 'location' => '', 'styleid' => 0, 'languageid' => 0, 'loggedin' => intval( $userid ) ? 1 : 0, 'inforum' => 0, 'inthread' => 0, 'incalendar' => 0, 'badlocation' => 0, 'profileupdate' => 0, 'useragent' => USER_AGENT, 'bypass' => 0 
	);
	
	foreach ( $db_fields as $fieldname => $cleantype )
	{
		switch ( $cleantype )
		{
			case TYPE_INT:
				$cleaned = intval( $thisvars["$fieldname"] );
				break;
			case TYPE_STR:
			default:
				$cleaned = "'" . $thisvars["$fieldname"] . "'";
		}
		$return["$fieldname"] = $cleaned;
	}
	
	return $return;
}

function yplitgroupRedirectManager()
{
	global $config, $param;
		@header( 'Location: ' . $config['id_url'] . '/index.php'
		. '?do=manager'
//		. ( !empty( $param['return'] ) ? '&return=' . $param['return'] : '' )
		. ( !empty( $param['manager']['page'] ) ? '&page=' . $param['manager']['page'] : '' )
		. '&hl=vi'
		. '&hash=' . HASH );
	exit;
}


function yplitgroupRedirectSite()
{
	global $param;
	$param['session']->_unset( 'return' );
	echo '<meta http-equiv="refresh" content="0; url='. urldecode( $param['return'] ) .'">';
	echo '<script>window.location='. urldecode( $param['return'] ) .'</script>';
	echo 'Loading, Please waiting...<br />';
//	echo '<script></script>';
	exit;
}

function yplitgroupRedirectLogin( $return = '' )
{
	global $config, $param;
	@header( "Location: " . $config['id_url'] . '/index.php?do=login' . ( !empty( $return ) ? '&return=' . urlencode( $return ) : '' ) . ( !empty( $param['hl'] ) ? '&hl=' . $param['hl'] : '' ) . ( !empty( $param['skin'] ) ? '&skin=' . $param['skin'] : '' ) . '&is_redirect=true&hash=' . HASH );
	exit;
}

function security_post( $key )
{
	if( !isset( $key ) OR empty( $key ) )
	{
		return false;
	}
	if( !isset( $_POST[ $key ] ) )
	{
		return false;
	}
	$return = str_replace(
		array(
			"'", '"', '<', '>' 
		),
		array(
			"&#039;", "&quot;", "&lt;", "&gt;"
		),
		trim( $_POST[ $key ] )
	);
	$return = str_replace(
		array(
			"[:", ":]", "{:", ":}" 
		),
		array(
			'"', '"', "<", '>' 
		),
		$return
	);
	return $return;
}

function security_post_string( $string )
{
	if( !isset( $string ) OR empty( $string ) )
	{
		return false;
	}
	
	if( is_string( $string ) )
	{
		$return = str_replace(
			array(
				"'", '"', '<', '>' 
			),
			array(
				"&#039;", "&quot;", "&lt;", "&gt;"
			),
			trim( $string )
		);
		$return = str_replace(
			array(
				"[:", ":]", "{:", ":}" 
			),
			array(
				'"', '"', "<", '>' 
			),
			$return
		);
	}
	If( is_array( $string ) )
	{
		foreach( $string as $k => $value )
		{
			$string[$k] = security_post_string( $value );
		}
	}

	return $return;
}

function iif($expression, $returntrue, $returnfalse = '')
{
	return ($expression ? $returntrue : $returnfalse);
}

function yplitgroupThemesHeader( )
{
	global $yplitgroupPageTitle, $yplitgroupHeaderTitle, $yplitgroupRightText, $lang, $config;
	require_once( DIR . '/skin/'. SKINDIR .'/header.php' );
}

function yplitgroupThemesFooter(  )
{
	global $lang;
	require_once( DIR . '/skin/'. SKINDIR .'/footer.php' );
}

function yplitgroupLoginForm( $error = '' )
{
	global $yplitgroupError, $lang, $yplitgroupPageTitle, $param;
	$yplitgroupPageTitle = $lang['login'] . ' &middot; ' . $lang['page_title'];
	$yplitgroupError = $error;
	yplitgroupThemesHeader( );
	require_once( DIR . '/skin/' . SKINDIR . '/loginform.php' );
	yplitgroupThemesFooter();
}

function yplitgroupHeaderCp()
{
	global $lang, $param, $config;
	global $yplitgroupPageTitle, $yplitgroupInfomation, $yplitgroupHeaderTitle, $yplitgroupRightText ;
	require_once( DIR . '/skin/' . SKINDIR . '/header_cp.php' );
}

function yplitgroupFooterCp()
{
	global $lang;
	require_once( DIR . '/skin/'. SKINDIR .'/footer_cp.php' );
}

function getonlineip($format=0)
{
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$return = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
	if($format) {
		$ips = explode('.', $return);
		for($i=0;$i<3;$i++) {
			$ips[$i] = intval($ips[$i]);
		}
		return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
	} else {
		return $return;
	}
}

function fetch_sessionhash()
{
	return md5(uniqid(microtime(), true));
}

function yplitgroupHashPassword( $password, $salt )
{
	return md5( md5( $password ) . $salt);
}

function yplitgroupGetPhrase( $text = '', $fieldname = '')
{
	global $db;
	if( empty( $text ) ) return '';
	$db->query( 'SELECT `text` FROM `'. TABLE_PREFIX .'phrase` WHERE `varname` = \'' . $text . '\' and `fieldname` = \''. $fieldname . '\'' );
	if( $db->nums() == 0 ) return '';
	$return = $db->sql_fetchrow();
	return $return['text'];
}

// ( This function I copy from vbulletin. Thank vbulletin very much )
function htmlspecialchars_uni($text, $entities = true)
{
	if ($entities)
	{
		$text = preg_replace_callback(
			'/&((#([0-9]+)|[a-z]+);)?/si',
			'htmlspecialchars_uni_callback',
			$text
		);
	}
	else
	{
		$text = preg_replace(
			// translates all non-unicode entities
			'/&(?!(#[0-9]+|[a-z]+);)/si',
			'&amp;',
			$text
		);
	}

	return str_replace(
		// replace special html characters
		array('<', '>', '"'),
		array('&lt;', '&gt;', '&quot;'),
			$text
	);
}

function htmlspecialchars_uni_callback($matches)
{
 	if (count($matches) == 1)
 	{
 		return '&amp;';
 	}

	if (strpos($matches[2], '#') === false)
	{
		// &gt; like
		if ($matches[2] == 'shy')
		{
			return '&shy;';
		}
		else
		{
			return "&amp;$matches[2];";
		}
	}
	else
	{
		// Only convert chars that are in ISO-8859-1
		if (($matches[3] >= 32 AND $matches[3] <= 126)
			OR
			($matches[3] >= 160 AND $matches[3] <= 255))
		{
			return "&amp;#$matches[3];";
		}
		else
		{
			return "&#$matches[3];";
		}
	}
}

function yplitgroupFetchUserSalt( $length = 30 )
{
	$salt = '';
	for ($i = 0; $i < $length; $i++)
	{
		$salt .= chr(rand(33, 126));
	}
	return $salt;
}

function yplitgroupViewFormRegister()
{
	global $lang, $param, $options;
	global $profile_variable, $yplitgroupRegisterError, $yplitgroupRightText, $js_require;
	yplitgroupThemesHeader();
	require_once( DIR . '/skin/' . SKINDIR . '/register_form.php' );
	yplitgroupThemesFooter();
	exit;
}

function yplitgroupCheckEmail( $email )
{
	if( empty( $email ) ) return false;
	$email_preg = '/(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))/'; // Power by Nukeviet :)
	if( !preg_match( $email_preg, $email ) ) return false;
	return true;
}

function yplitgroupMailFetchFirstLine($text)
{
	$text = preg_replace("/(\r\n|\r|\n)/s", "\r\n", trim($text));
	$pos = strpos($text, "\r\n");
	if ($pos !== false)
	{
		return substr($text, 0, $pos);
	}
	return $text;
}

// ( This function I copy from vbulletin. Thank vbulletin very much )
function to_utf8($in, $charset = false, $strip = true)
{
	if ('' === $in OR false === $in OR is_null($in))
	{
		return $in;
	}

	// Fallback to UTF-8
	if (!$charset)
	{
		$charset = 'UTF-8';
	}

	// Try iconv
	if (function_exists('iconv'))
	{
		return @iconv($charset, 'UTF-8//IGNORE', $in);
	}

	// Try mbstring
	if (function_exists('mb_convert_encoding'))
	{
		return @mb_convert_encoding($in, 'UTF-8', $charset);
	}

	if (!$strip)
	{
		return $in;
	}

	// Strip non valid UTF-8
	// TODO: Do we really want to do this?
	$utf8 = '#([\x09\x0A\x0D\x20-\x7E]' .			# ASCII
			'|[\xC2-\xDF][\x80-\xBF]' .				# non-overlong 2-byte
			'|\xE0[\xA0-\xBF][\x80-\xBF]' .			# excluding overlongs
			'|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}' .	# straight 3-byte
			'|\xED[\x80-\x9F][\x80-\xBF]' .			# excluding surrogates
			'|\xF0[\x90-\xBF][\x80-\xBF]{2}' .		# planes 1-3
			'|[\xF1-\xF3][\x80-\xBF]{3}' .			# planes 4-15
			'|\xF4[\x80-\x8F][\x80-\xBF]{2})#S';	# plane 16

	$out = '';
	$matches = array();
	while (preg_match($utf8, $in, $matches))
	{
		$out .= $matches[0];
		$in = substr($in, strlen($matches[0]));
	}

	return $out;
}

// ( This function I copy from vbulletin. Thank vbulletin very much )
function encode_email_header($text, $charset = 'utf-8', $force_encode = false, $quoted_string = true)
{
	$text = trim($text);
	if (!$charset)
	{
		// don't know how to encode, so we can't
		return $text;
	}
	if ($force_encode == true)
	{
		$qp_encode = true;
	}
	else
	{
		$qp_encode = false;
		for ($i = 0; $i < strlen($text); $i++)
		{
			if (ord($text{$i}) > 127)
			{
				// we have a non ascii character
				$qp_encode = true;
				break;
			}
		}
	}

	if ($qp_encode == true)
	{
		// see rfc 2047; not including _ as allowed here, as I'm encoding spaces with it
		$outtext = preg_replace('#([^a-zA-Z0-9!*+\-/ ])#e', "'=' . strtoupper(dechex(ord(str_replace('\\\"', '\"', '\\1'))))", $text);
		$outtext = str_replace(' ', '_', $outtext);
		$outtext = "=?$charset?q?$outtext?=";
		return $outtext;
	}
	else
	{
		if ($quoted_string)
		{
			$text = str_replace(array('"', '(', ')'), array('\"', '\(', '\)'), $text);
			return "\"$text\"";
		}
		else
		{
			return preg_replace('#(\r\n|\n|\r)+#', ' ', $text);
		}
	}
}

// ( This function I copy from vbulletin. Thank vbulletin very much )
function construct_phrase_from_array($phrase_array)
{
	$numargs = sizeof($phrase_array);

	// if we have only one argument then its a phrase
	// with no variables, so just return it
	if ($numargs < 2)
	{
		return $phrase_array[0];
	}

	// call sprintf() on the first argument of this function
	$phrase = @call_user_func_array('sprintf', $phrase_array);
	if ($phrase !== false)
	{
		return $phrase;
	}
	else
	{
		// if that failed, add some extra arguments for debugging
		for ($i = $numargs; $i < 10; $i++)
		{
			$phrase_array["$i"] = "[ARG:$i UNDEFINED]";
		}
		if ($phrase = @call_user_func_array('sprintf', $phrase_array))
		{
			return $phrase;
		}
		// if it still doesn't work, just return the un-parsed text
		else
		{
			return $phrase_array[0];
		}
	}
}

// ( This function I copy from vbulletin. Thank vbulletin very much )
function construct_phrase()
{
	$args = func_get_args(); 
	$numargs = sizeof($args);
	if ($numargs == 1 AND is_array($args[0]))
	{
		return construct_phrase_from_array($args[0]); 
	}
	else if ($numargs == 2 AND is_string($args[0]) AND is_array($args[1]))
	{
		array_unshift($args[1], $args[0]); 
		return construct_phrase_from_array($args[1]);
	}

	// otherwise just package arguments up as an array
	// and call the array version of this func
	else
	{
		return construct_phrase_from_array($args);
	}
}

// ( This function I copy from vbulletin. Thank vbulletin very much )
function unhtmlspecialchars($text, $doUniCode = false)
{
	if ($doUniCode)
	{
		$text = preg_replace('/&#([0-9]+);/esiU', "convert_int_to_utf8('\\1')", $text);
	}

	return str_replace(array('&lt;', '&gt;', '&quot;', '&amp;'), array('<', '>', '"', '&'), $text);
}

// ( This function is copyright by Nukeviet )

function yplitgroupSendmail( $to, $subject, $message, $from = '', $files = '')
{
	global $param, $config;

	$sendmail_from = ini_get('sendmail_from');
	require_once( DIR . '/includes/phpmailer/class.phpmailer.php');
	try
	{
		$mail = new PHPMailer(true);
		$mail->CharSet = 'utf-8';
		$mailer_mode = strtolower($global_config['mailer_mode']);

		$disable_functions = ini_get( "disable_functions" );
		if( $disable_functions != false ) 
		{
			array_map( 'trim', preg_split( "/[\s,]+/", $disable_functions ) );
		}
		else
		{
			$disable_functions = array();
		}
		
		if (!in_array('mail', $disable_functions))
		{
			$mail->IsMail();
		}
		else
		{
			$mail->IsSendmail();
			//return false;
		}

		//$message = nv_change_buffer($message);
		$message = unhtmlspecialchars($message);
		$subject = unhtmlspecialchars($subject);

		$mail->From = $from['email'];
		$mail->FromName = $from['name'];
		$mail->AddReplyTo($from['email']);
		
		if (empty($to))
			return false;

		if (!is_array($to))
			$to = array($to);

		foreach ($to as $_to)
		{
			$mail->AddAddress($_to);
		}

		$mail->Subject = $subject;
		$mail->WordWrap = 120;
		$mail->MsgHTML($message);
		$mail->IsHTML(true);
		if (!empty($files))
		{
			$files = array_map("trim", explode(",", $files));
			foreach ($files as $file)
			{
				$mail->AddAttachment($file);
			}
		}
		$send = $mail->Send();
		if (!$send)
		{
			$param['error']->show( 'Can\'t send mail!!!' );
			return false;
		}
		return $send;
	}
	catch ( phpmailerException $e )
	{
		$param['error']->show( 'Can\'t send mail!!!' );
		return false;
	}
}
// ( This function I copy from vbulletin. Thank vbulletin very much )
function yplitgroupMail( $toemail, $subject, $message, $from = '', $uheaders = '', $username = '' )
{
	if (empty($toemail))
	{
		return false;
	}
	global $options, $config;
	$toemail = yplitgroupMailFetchFirstLine($toemail);
	if (empty($toemail))
	{
		return false;
	}
	$delimiter = "\r\n";
	$toemail = unhtmlspecialchars($toemail);
	$subject = yplitgroupMailFetchFirstLine($subject);
	$message = preg_replace("#(\r\n|\r|\n)#s", $delimiter, trim($message));

	$message = utf8_encode( $message );
	$subject = utf8_encode( $subject );
	$username = utf8_encode( $username );
	$encoding = 'utf-8';
	$unicode_decode = true;

	// theses lines may need to call convert_int_to_utf8 directly
	$message = unhtmlspecialchars( $message, $unicode_decode );
	$subject = encode_email_header( unhtmlspecialchars( $subject, $unicode_decode), $encoding, false, false);
	$from = yplitgroupMailFetchFirstLine( $from );
	if( empty( $from ) )
	{
		$x_mailer = yplitgroupGetPhrase( 'x_mailer', 'global' );
		if ( $x_mailer )
		{
			$mailfromname = construct_phrase( yplitgroupGetPhrase( $x_mailer ), $options['bbtitle'] );
		}
		else
		{
			$mailfromname = $options['bbtitle'];
		}
			if ($unicode_decode == true)
		{
			$mailfromname = utf8_encode($mailfromname);
		}
		$mailfromname = encode_email_header(unhtmlspecialchars($mailfromname, $unicode_decode), $encoding);
		$headers .= "From: $mailfromname <" . $options['webmasteremail'] . '>' . $delimiter;
		$headers .= 'Auto-Submitted: auto-generated' . $delimiter;
		// Exchange (Oh Microsoft) doesn't respect auto-generated: http://www.vbulletin.com/forum/project.php?issueid=27687
		if ($options['usebulkheader'])
		{
			$headers .= 'Precedence: bulk' . $delimiter;
		}
	}
	else
	{
		if ($username)
		{
			$mailfromname = "$username @ " . $options['bbtitle'];
		}
		else
		{
			$mailfromname = $from;
		}
		if ($unicode_decode == true)
		{
			$mailfromname = utf8_encode($mailfromname);
		}
		$mailfromname = encode_email_header(unhtmlspecialchars($mailfromname, $unicode_decode), $encoding);
		$headers .= "From: $mailfromname <$from>" . $delimiter;
		$headers .= "Sender: " . $options['webmasteremail'] . $delimiter;
	}
	$fromemail = empty( $options['bounceemail'] ) ? $options['webmasteremail'] : $options['bounceemail'];
	$headers .= 'Return-Path: ' . $fromemail . $delimiter;
	$url = @parse_url( $config['forum_url'] ); //
	$http_host = $url['host'];
	if (!$http_host)
	{
		$http_host = substr(md5($message), 12, 18) . '.vb_unknown.unknown';
	}
	$msgid = '<' . gmdate('YmdHis') . '.' . substr(md5($message . microtime()), 0, 12) . '@' . $http_host . '>';
	$headers .= 'Message-ID: ' . $msgid . $delimiter;
	$headers .= preg_replace("#(\r\n|\r|\n)#s", $delimiter, $uheaders);
	unset($uheaders);
	$headers .= 'MIME-Version: 1.0' . $delimiter;
	$headers .= 'Content-Type: text/plain' . iif($encoding, "; charset=\"$encoding\"") . $delimiter;
	$headers .= 'Content-Transfer-Encoding: 8bit' . $delimiter;
	$headers .= 'X-Priority: 3' . $delimiter;
	$headers .= 'X-Mailer: Yplitgroup Mail via PHP ( http://lemon9x.com )' . $delimiter;
	// Send
	ini_set('sendmail_from', $fromemail ); //
	define('SAFEMODE', (@ini_get('safe_mode') == 1 OR strtolower(@ini_get('safe_mode')) == 'on') ? true : false);
	if (!SAFEMODE AND $options['needfromemail'])
	{
		$result =  @mail( $toemail, $subject, $message, trim( $headers ), '-f ' . $fromemail ); //
	}
	else
	{
		$result = @mail( $toemail, $subject, $message, trim( $headers ) ); //
	}
	yplitgroupLogEmail($result);
	return $result;
}



	function yplitgroupLogEmail($status = true, $errfile = false)
	{
		global $options, $toemail, $subject, $headers, $message ;
		$delimiter = "\r\n";
		// log file is passed or taken from options
		$errfile = $errfile ? $errfile : $options['errorlogemail'];

		// no log file specified
		if (!$errfile)
		{
			return;
		}

		// trim .log from logfile
		$errfile = (substr($errfile, -4) == '.log') ? substr($errfile, 0, -4) : $errfile;

		if ($options['errorlogmaxsize'] != 0 AND $filesize = @filesize("$errfile.log") AND $filesize >= $options['errorlogmaxsize'])
		{
			@copy("$errfile.log", $errfile . TIMENOW . '.log');
			@unlink("$errfile.log");
		}

		$timenow = date('r', TIMENOW);

		$fp = @fopen("$errfile.log", 'a+b');

		if ($fp)
		{
			if ($status === true)
			{
				$output = "SUCCESS\r\n";
			}
			else
			{
				$output = "FAILED";
				if ($status !== false)
				{
					$output .= ": $status";
				}
				$output .= "\r\n";
			}
			if ($delimiter == "\n")
			{
				$append = "$timenow\r\nTo: " . $toemail . "\r\nSubject: " . $subject . "\r\n" . $headers . "\r\n\r\n" . $message . "\r\n=====================================================\r\n\r\n";
				@fwrite($fp, $output . $append);
			}
			else
			{
				$append = preg_replace("#(\r\n|\r|\n)#s", "\r\n", "$timenow\r\nTo: " . $toemail . "\r\nSubject: " . $subject . "\r\n" . $headers . "\r\n\r\n" . $message . "\r\n=====================================================\r\n\r\n");

				@fwrite($fp, $output . $append);
			}
			fclose($fp);
		}
	}

function yplitgroupStrlen($string, $unhtmlspecialchars = false)
{
	$string = preg_replace('#&\#([0-9]+);#', '_', $string);
	if ($unhtmlspecialchars)
	{
		// don't try to translate unicode entities ever, as we want them to count as 1 (above)
		$string = unhtmlspecialchars($string, false);
	}

	if (function_exists('mb_strlen') AND $length = @mb_strlen($string, 'UTF-8'))
	{
		return $length;
	}
	else
	{
		return strlen($string);
	}
}

function convert_int_to_utf8($intval)
{
	$intval = intval($intval);
	switch ($intval)
	{
		// 1 byte, 7 bits
		case 0:
			return chr(0);
		case ($intval & 0x7F):
			return chr($intval);

		// 2 bytes, 11 bits
		case ($intval & 0x7FF):
			return chr(0xC0 | (($intval >> 6) & 0x1F)) .
				chr(0x80 | ($intval & 0x3F));

		// 3 bytes, 16 bits
		case ($intval & 0xFFFF):
			return chr(0xE0 | (($intval >> 12) & 0x0F)) .
				chr(0x80 | (($intval >> 6) & 0x3F)) .
				chr (0x80 | ($intval & 0x3F));

		// 4 bytes, 21 bits
		case ($intval & 0x1FFFFF):
			return chr(0xF0 | ($intval >> 18)) .
				chr(0x80 | (($intval >> 12) & 0x3F)) .
				chr(0x80 | (($intval >> 6) & 0x3F)) .
				chr(0x80 | ($intval & 0x3F));
	}
}

function strip_blank_ascii($text, $replace)
{
	global $options;
	static $blanks = null;

	if ($blanks === null AND trim($options['blankasciistrip']) != '')
	{
		$blanks = array();

	$charset = 'UTF-8';

		$charset_unicode = (strtolower($charset) == 'utf-8');

		$raw_blanks = preg_split('#\s+#', $options['blankasciistrip'], -1, PREG_SPLIT_NO_EMPTY);
		foreach ($raw_blanks AS $code_point)
		{
			if ($code_point[0] == 'u')
			{
				// this is a unicode character to remove
				$code_point = intval(substr($code_point, 1));
				$force_unicode = true;
			}
			else
			{
				$code_point = intval($code_point);
				$force_unicode = false;
			}

			if ($code_point > 255 OR $force_unicode OR $charset_unicode)
			{
				// outside ASCII range or forced Unicode, so the chr function wouldn't work anyway
				$blanks[] = '&#' . $code_point . ';';
				$blanks[] = convert_int_to_utf8($code_point);
			}
			else
			{
				$blanks[] = chr($code_point);
			}
		}
	}

	if ($blanks)
	{
		$text = str_replace($blanks, $replace, $text);
	}

	return $text;
}

function fetch_censored_text($text)
{
	global $options;
	static $censorwords;

	if (!$text)
	{
		// return $text rather than nothing, since this could be '' or 0
		return $text;
	}

	if( $options['enablecensor'] AND !empty($options['censorwords']))
	{
		if (empty($censorwords))
		{
			$options['censorwords'] = preg_quote($options['censorwords'], '#');
			$censorwords = preg_split('#[ \r\n\t]+#', $options['censorwords'], -1, PREG_SPLIT_NO_EMPTY);
		}

		foreach ($censorwords AS $censorword)
		{
			if (substr($censorword, 0, 2) == '\\{')
			{
				if (substr($censorword, -2, 2) == '\\}')
				{
					// prevents errors from the replace if the { and } are mismatched
					$censorword = substr($censorword, 2, -2);
				}

				// ASCII character search 0-47, 58-64, 91-96, 123-127
				$nonword_chars = '\x00-\x2f\x3a-\x40\x5b-\x60\x7b-\x7f';

				// words are delimited by ASCII characters outside of A-Z, a-z and 0-9
				$text = preg_replace(
					'#(?<=[' . $nonword_chars . ']|^)' . $censorword . '(?=[' . $nonword_chars . ']|$)#si',
					str_repeat($options['censorchar'], yplitgroupStrlen($censorword)),
					$text
				);
			}
			else
			{
				$text = preg_replace("#$censorword#si", str_repeat($options['censorchar'], yplitgroupStrlen($censorword)), $text);
			}
		}
	}

	// strip any admin-specified blank ascii chars
	$text = strip_blank_ascii($text, $options['censorchar']);

	return $text;
}

// ( This function I copy from vbulletin. Thank vbulletin very much )
function yplitgroupSetUserfields( &$values, $verify = true, $all_fields = 'normal', $skip_unset_required_fields = false, &$set_userfields_error = '' )
{
	global $db, $lang, $userid;
	if ( !is_array( $values ) )
	{
		$set_userfields_error = $lang['::$values for profile fields is not an array::'];
		return false;
	}

	$customfields = '';

	$field_ids = array();
	foreach ( array_keys( $values ) AS $key )
	{
		if (preg_match('#^field(\d+)\w*$#', $key, $match))
		{
			$field_ids["$match[1]"] = $match[1];
		}
	}
	if( empty($field_ids) AND $all_fields != 'register')
	{
		return false;
	}

	switch($all_fields)
	{
		case 'admin':
			$all_fields_sql = "WHERE profilefieldid IN(" . implode(', ', $field_ids) . ")";
			break;

		case 'register':
			// must read all fields in order to set defaults for fields that don't display
			//$all_fields_sql = "WHERE editable IN (1,2)";
			$all_fields_sql = '';

			// we need to ensure that each field the user could edit is sent through and processed,
			// so ensure that we process everyone one of these fields
			$profilefields = $db->query("
				SELECT profilefieldid
				FROM " . TABLE_PREFIX . "profilefield
				WHERE editable > 0 AND required <> 0
			");
			while ( $profilefield = $db->fetchrow( $profilefields ) )
			{
				$field_ids["$profilefield[profilefieldid]"] = $profilefield['profilefieldid'];
			}
			break;

		case 'normal':
		default:
			$all_fields_sql = "WHERE profilefieldid IN(" . implode(', ', $field_ids) . ") AND editable IN (1,2)";
			break;
	}

	// check extra profile fields
	$profilefields = $db->query( "
		SELECT profilefieldid, required, size, maxlength, type, data, optional, regex, def, editable
		FROM " . TABLE_PREFIX . "profilefield
		$all_fields_sql
		ORDER BY displayorder
	");
	while( $profilefield = $db->fetchrow( $profilefields ) )
	{
		$varname = 'field' . $profilefield['profilefieldid'];
		$value = $values["$varname"];
		$regex_check = false;

//		if ($all_fields != 'admin' AND $profilefield['editable'] == 2 AND !empty($this->existing["$varname"]))
//		{
//			continue;
//		}

		$phrase = yplitgroupGetPhrase( $varname . '_title', 'register' );
		$profilefield['title'] = (!empty( $phrase ) ? $phrase : $varname);

		$optionalvar = 'field' . $profilefield['profilefieldid'] . '_opt';
		$value_opt =& $values["$optionalvar"];

		// text box / text area
		if ($profilefield['type'] == 'input' OR $profilefield['type'] == 'textarea')
		{
			if (in_array($profilefield['profilefieldid'], $field_ids) AND ($all_fields != 'register' OR $profilefield['editable']))
			{
				$value = trim(substr(fetch_censored_text($value), 0, $profilefield['maxlength']));
				$value = (empty($value) AND $value != '0') ? false : $value;
			}
			else if ($all_fields == 'register' AND $profilefield['data'] !== '')
			{
				$value = unhtmlspecialchars($profilefield['data']);
			}
			else
			{
				continue;
			}
			$customfields .= "$profilefield[title] : $value\n";
			$regex_check = true;
		}
		// radio / select
		else if ($profilefield['type'] == 'radio' OR $profilefield['type'] == 'select')
		{
			if ($profilefield['optional'] AND $value_opt != '')
			{
				$value = trim(substr(fetch_censored_text($value_opt), 0, $profilefield['maxlength']));
				$value = (empty($value) AND $value != '0') ? false : $value;
				$regex_check = true;
			}
			else
			{
				$data = unserialize($profilefield['data']);
				$value -= 1;
				if (in_array($profilefield['profilefieldid'], $field_ids) AND ($all_fields != 'register' OR $profilefield['editable']))
				{
					if (isset($data["$value"]))
					{
						$value = unhtmlspecialchars(trim($data["$value"]));
					}
					else
					{
						$value = false;
					}
				}
				else if ($all_fields == 'register' AND $profilefield['def'])
				{
					$value = unhtmlspecialchars($data[0]);
				}
				else
				{
					continue;
				}
			}
			$customfields .= "$profilefield[title] : $value\n";
		}
		// checkboxes or select multiple
		else if (($profilefield['type'] == 'checkbox' OR $profilefield['type'] == 'select_multiple') AND in_array($profilefield['profilefieldid'], $field_ids))
		{
			if (is_array($value))
			{
				if (($profilefield['size'] == 0) OR (sizeof($value) <= $profilefield['size']))
				{
					$data = unserialize($profilefield['data']);

					$bitfield = 0;
					$cfield = '';
					foreach($value AS $key => $val)
					{
						$val--;
						$bitfield += pow(2, $val);
						$cfield .= (!empty($cfield) ? ', ' : '') . $data["$val"];
					}
					$value = $bitfield;
				}
				else
				{
					$set_userfields_error = str_replace( '#TITLE#', $profilefield['title'], $lang['set_user_fields_checkboxsize_' . $profilefield['size']] );
					$value = false;
				}
				$customfields .= "$profilefield[title] : $cfield\n";
			}
			else
			{
				$value = false;
			}
		}
		else
		{
			continue;
		}

		// check for regex compliance
		if ($verify AND $profilefield['regex'] AND $regex_check)
		{
			if (!preg_match('#' . str_replace('#', '\#', $profilefield['regex']) . '#siU', $value))
			{
				$set_userfields_error = str_replace( '#TITLE#', $profilefield['title'], $lang['regexincorrect'] );
				$value = false;
			}
		}

		// check for empty required fields
		if (($profilefield['required'] == 1 OR $profilefield['required'] == 3) AND $value === false AND $verify)
		{
			if ($skip_unset_required_fields AND !isset($values["$varname"]))
			{
				continue;
			}
			$set_userfields_error = str_replace( '#TITLE#', $profilefield['title'], $lang['required_field_x_missing_or_invalid'] );
		}

		//$this->setfields["$varname"] = true;
		//$this->userfield["$varname"] = htmlspecialchars_uni( $value );
		$userfield["$varname"] = htmlspecialchars_uni( $value );
	}
	$db->freeresult($profilefields);
	// Select all column name from `userfield`, see bugs #1
	$db->query( "SELECT * FROM `". TABLE_PREFIX ."userfield` LIMIT 1" ); // Custom option, Fix later
	if( $db->nums() !=0 )
	{
		$fields_name = $db->sql_fetch_assoc();
		$list = array();
		foreach( $fields_name as $f => $v )
		{
			if( !empty( $f ) )
			$list[] = $f;
		}
		if( count( $list ) )
		{
			foreach( $list as $l => $v )
			{
				if( !isset( $userfield["$v"] ) and $v != 'userid' )
				{
					$userfield["$v"] = '';
				}
			}
		}
	}
	else
	{
		// See bug #2, fix later
	}
	$q = array();
	foreach( $userfield as $k => $v )
	{
		$q[] = " `". $k ."` = '" . $v . "' ";
	}
	$q = implode( ', ', $q );
	$q = 'INSERT INTO `'. TABLE_PREFIX .'userfield` SET ' . $q . ', `userid` = ' . $userid; 
	if(  !$db->query( $q ) )
	{
		print_r( $db->sql_error() );
		exit;
	}
	return $customfields;
}


function fetch_random_string($length = 32)
{
	$hash = sha1( TIMENOW . microtime() . uniqid(mt_rand(), true) . @implode('', @fstat(@fopen( __FILE__, 'r'))));
	return substr($hash, 0, $length);
}

function build_user_activation_id( $userid, $usergroupid, $type, $emailchange = 0 )
{
	global $db;

	if ($usergroupid == 3 OR $usergroupid == 0)
	{ // stop them getting stuck in email confirmation group forever :)
		$usergroupid = 2;
	}

	$db->query( "DELETE FROM " . TABLE_PREFIX . "useractivation WHERE userid = $userid AND type = $type" );
	$activateid = fetch_random_string(40);
	/*insert query*/
	$db->query("
		REPLACE INTO " . TABLE_PREFIX . "useractivation
			(userid, dateline, activationid, type, usergroupid, emailchange)
		VALUES
			($userid, " . TIMENOW . ", '$activateid' , $type, $usergroupid, " . intval($emailchange) . ")
	");
	return $activateid;
}

function yplitgroupFetchRandomPassword($length = 8)
{
	$password_characters = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';
	$total_password_characters = strlen($password_characters) - 1;

	$digit = rand(0, $length - 1);

	$newpassword = '';
	for ($i = 0; $i < $length; $i++)
	{
		if ($i == $digit)
		{
			$newpassword .= chr( rand(48, 57 ) );
			continue;
		}
		$newpassword .= $password_characters{rand(0, $total_password_characters)};
	}
	return $newpassword;
}

// Function from Google :)
function yplitgroupCreateAlias( $str )
{
	$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
	$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	$str = preg_replace("/(đ)/", 'd', $str);
	$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
	$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
	$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	$str = preg_replace("/(Đ)/", 'D', $str);
	//$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
	return $str;
}

function yplitgroupChangeDb( $dbmod )
{
	global $db, $param, $config;

	// Default db
	if( $dbmod == 'vbb' )
	{
		$db = new sql_db( $config['connect']['vbb'] );
		if( !empty( $db->error ) )
		{
			$param['error']->show( '<b>Error!</b><hr /><i>::VbbDb:: ' . $db->error['user_message'] . '</i>' );
			return false;
		}
		$param['is_db'] = 'vbb';
		return true;
	}

	if( !in_array( $dbmod, $param['connect_accept'] ) ) return false;

	if( yplitgroupGetDbName() != $dbmod )
	{
		$db = new sql_db( $param['connect']["$dbmod"] );
		if( !empty( $db->error ) )
		{
			$param['error']->show( '<b>Error!</b><hr /><i>::'. $dbmod .':: ' . $db->error['user_message'] . '</i>' );
			return false;
		}
		$param['is_db'] = $dbmod;
		return true;
	}
	return true;
}

function yplitgroupGetEnv( $key )
{
	if ( ! is_array( $key ) )
		$key = array( $key );
	foreach ( $key as $_key )
	{
		if ( isset( $_SERVER[$_key] ) ) return $_SERVER[$_key];
		elseif ( isset( $_ENV[$_key] ) ) return $_ENV[$_key];
		elseif ( @getenv( $_key ) ) return @getenv( $_key );
		elseif ( function_exists( 'apache_getenv' ) && apache_getenv( $_key, true ) ) return apache_getenv( $_key, true );
	}
	return "";
}

function yplitgroupParseIniFile( $filename )
{
	if( empty( $filename ) or !is_readable( $filename ) ) return false;

	$file = file( $filename );
	if( !$file ) return false;
	$ini = array();
	$array_key = '';
	foreach( $file as $row )
	{
		$row = trim( $row );
		if( empty( $row ) ) continue;
		if( preg_match( '/^;/', $row ) ) return;
		if( preg_match( '/^\[(.*)\]$/', $row, $match ) )
		{
			$array_key = $match[1];
			continue;
		}
		if( !strpos( $row, '=' ) ) continue;
		list( $key, $val ) = explode( '=', $row );
		$key = trim( $key ); $val = trim( $val );
		$val = str_replace( '"', '', $val );
		$val = str_replace( "'", "", $val );
		if( !empty( $array_key ) )
		{
			if( preg_match( '/^(.*?)\[\]$/', $key, $match ) )
			{
				$ini[$array_key][$match[1]][] = $val;
			}
			else
			{
				$ini[$array_key][$key] = $val;
			}
		}
	}
	return $ini;
}

function yplitgroupGetDbName()
{
	global $parmam;
	if( empty( $param['is_db'] ) ) return '';
	return $param['is_db'];
}