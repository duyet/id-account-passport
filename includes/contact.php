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

// ############### MINI FUNCTION ##################
function yplitgroupContactForm()
{
	global $lang, $f, $param, $config, $yplitgroupPageTitle, $yplitgroupInfomation, $yplitgroupHeaderTitle, $yplitgroupRightText, $yplitgroupError;

	if( defined( 'IS_USER' ) )
		$f->load('yplitgroupHeaderCp');
	else
		$f->load('yplitgroupThemesHeader');
	require_once( DIR . '/skin/' . SKINDIR . '/contact_form.php' );
	if( defined( 'IS_USER' ) )
		$f->load('yplitgroupFooterCp');
	else
		$f->load('yplitgroupThemesFooter');
}

// ################ START #################
if( !isset( $_POST['submit'] ) )
{
	$f->load('yplitgroupContactForm');
	exit;
}

if( empty( $_POST['humanverify'] ) or ( $_POST['humanverify'] != $_SESSION['yplitgroupHumanverify'] ) )
{
	$yplitgroupError = ( empty( $_POST['humanverify'] ) ? $lang['contact_humanverify_empty'] : $lang['contact_humanverify_fail'] );
	$f->load('yplitgroupContactForm');
	exit;
}

if( !$_POST['name'] or empty( $_POST['name'] ) )
{
	$yplitgroupError = $lang['contact_name_empty'];
	$f->load('yplitgroupContactForm');
	exit;
}

if( !$_POST['email'] or empty( $_POST['email'] ) or yplitgroupCheckEmail( $_POST['email'] ) === false )
{
	$yplitgroupError = ( empty( $_POST['email'] ) ? $lang['contact_email_empty'] : $lang['contact_email_fail'] );
	$f->load('yplitgroupContactForm');
	exit;
}

if( !$_POST['content'] or empty( $_POST['content'] ) )
{
	$yplitgroupError = $lang['contact_content_empty'];
	$f->load('yplitgroupContactForm');
	exit;
}

$name = $f->load('security_post', 'name' );
$email = $f->load('security_post', 'email' );
$content = nl2br( htmlspecialchars( $f->load('security_post', 'content' ) ) );
$url = @parse_url( urldecode( $_SERVER['PHP_SELF'] ) );
$forum = $url['host'];
$toemail = $config['admin_email'];
$subject = $lang['contact_email_subject'];
eval( '$message = "'. $lang['contact_email_message'] .'";' );
$is_sent = false;
if( !empty( $toemail ) )
{
	yplitgroupSendmail( $toemail, $subject, $message, array( 'email'=>'yplitgroup@gmail.com', 'name' => 'Yplitgroup' ) );
}

$fp = @fopen( YPLITGROUP_CONTACT_LOGS_DIR 
			. '/' . 'contact-log-' 
			. time() 
			. '-' . substr( md5( time() . $config['sitekey'] ), 2, 12 ) 
			. '.txt' , 
			'w'
			);
@fwrite( $fp, 
			"Time: " . date( 'h:i:s D-m-y' ) . "\n" 
			. "Name: $name - ( ". yplitgroupCreateAlias( $name ) ." ) \n"
			. "Email: $email \n"
			. "Content: \n"
			. "---------------------------------------\n"
			. "$content \n"
			. "---------- Tieng Viet khong dau --------- \n"
			. yplitgroupCreateAlias( $content ) . "\n"
			. "----------------------------------------\n"
			. ( $is_sent ? "SEND SUCCESSFULLY TO <$toemail>" : "NOT SEND EMAIL" ) . "\n"
			. "----------------------------------------\n"
			. "Logs Key: " . substr( md5( time() . $config['sitekey'] ), 2, 12 )
	);
fclose( $fp );
$yplitgroupContactStatus = $lang['contact_submit_successfully'];
$f->load('yplitgroupThemesHeader');
require_once( DIR . '/skin/' . SKINDIR . '/contact_successfully.php' );
$f->load('yplitgroupThemesFooter');
?>