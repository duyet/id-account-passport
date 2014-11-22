<?php
/**
* @ Project: ID Account System 1.5.0
* @ Author: Yplitgroup (c)2012
* @ Email: yplitgroup@gmail.com
* @ Website: http://lemon9x.com 
* @ Phone: 0166.26.26.009
* @ Project ID: 876609683c4c7e392848e94d9f62e149
**/
 
if( !defined( 'IS_MAIN' ) ) die( 'Stop!!!' );
if( !isset( $_GET['hash'] ) or empty( $_GET['hash'] ) ) die('Error!!!');
require_once( DIR . '/includes/SimpleCaptcha.class.php' );
$captcha = new SimpleCaptcha;
$captcha->session_var = 'yplitgroupHumanverify';
$captcha->resourcesPath = DIR . '/'. YPLITGROUP_TMP_DIR .'/';
//$captcha->wordsFile = 'captcha.txt';
$captcha->CreateImage();
die();
?>