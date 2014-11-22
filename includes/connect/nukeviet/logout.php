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
// Unset Cookie nukeviet
$param['cookie']->_unset( NV_COOKIE_PREFIX . '_nvloginhash' );
?>