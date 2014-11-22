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
function nukevietValidUserLog( $array_user, $remember, $opid )
{
    global $db, $crypt, $config, $param;

    $remember = intval( $remember );
    $checknum = nv_genpass( 10 );
    $checknum = $crypt->hash( $checknum );
    $user = array( //
        'userid' => $array_user['userid'], //
        'checknum' => $checknum, //
        'current_agent' => USER_AGENT, //
        'last_agent' => $array_user['last_agent'], //
        'current_ip' => IP, //
        'last_ip' => $array_user['last_ip'], //
        'current_login' => TIMENOW, //
        'last_login' => intval( $array_user['last_login'] ), //
        'last_openid' => $array_user['last_openid'], //
        'current_openid' => $opid );

    $user = nv_base64_encode( serialize( $user ) );

    $this_db = $param['f']->load('yplitgroupGetDbName');
    if( $this_db != 'nukeviet' ) $param['f']->load('yplitgroupChangeDb', array( 'nukeviet' ) );
    $db->sql_query( "UPDATE `" . NV_USERS_GLOBALTABLE . "` SET 
    `checknum` = " . $db->dbescape( $checknum ) . ", 
    `last_login` = " . TIMENOW . ", 
    `last_ip` = " . $db->dbescape( IP ) . ", 
    `last_agent` = " . $db->dbescape( USER_AGENT ) . ", 
    `last_openid` = " . $db->dbescape( $opid ) . ", 
    `remember` = " . $remember . " 
    WHERE `userid`=" . $array_user['userid'] );

    $live_cookie_time = ( $remember ) ? COOKIE_LIVE_TIME : 0;

    $user = encodeCookie( $user ); 

    setcookie( NV_COOKIE_PREFIX . '_nvloginhash', $user, $live_cookie_time, '/', $config['cookie_forum_domain'] );
}

function nv_genpass($length = 8)
{
    $pass = chr(mt_rand(65, 90));
    for ($k = 0; $k < $length - 1; ++$k)
    {
        $probab = mt_rand(1, 10);
        $pass .= ($probab <= 8) ? chr(mt_rand(97, 122)) : chr(mt_rand(48, 57));
    }
    return $pass;
}

function nv_base64_encode($input)
{
    return strtr(base64_encode($input), '+/=', '-_,');
}

function nv_base64_decode($input)
{
    return base64_decode(strtr($input, '-_,', '+/='));
}


function base64Encode ( $input )
{
	return strtr( base64_encode( $input ), '+/=', '-_,' );
}


function encodeCookie ( $string )
{
	global $param;
	$cookie_key = md5( $param['connect']['nukeviet']['sitekey'] );
	$result = '';
	$strlen = strlen( $string );
	for ( $i = 0; $i < $strlen; ++$i )
	{
		$char = substr( $string, $i, 1 );
		$keychar = substr( $cookie_key, ( $i % 32 ) - 1, 1 );
		$result .= chr( ord( $char ) + ord( $keychar ) );
	}
	return base64Encode( $result );
}

function decodeCookie ( $string )
{
	global $param;
	$cookie_key = md5( $param['connect']['nukeviet']['sitekey'] );
	$result = '';
	$string = nv_base64_decode( $string );
	$strlen = strlen( $string );
	for ( $i = 0; $i < $strlen; ++$i )
	{
		$char = substr( $string, $i, 1 );
		$keychar = substr( $cookie_key, ( $i % 32 ) - 1, 1 );
		$result .= chr( ord( $char ) - ord( $keychar ) );
	}
	return $result;
}

?>