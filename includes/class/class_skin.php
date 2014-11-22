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
class skin
{
	public $_skindir = '';

	public $_name = '';

	public $_author = '';

	public $_date = '';

	public $_version = '';

	public function __construct( $skinname = '' )
	{
		if( empty( $skinname ) ) $this->_skindir = 'google'; // Default

		$skinname = trim( $skinname );
		if( !file_exists( DIR . '/skin/' . $skinname . '/themes.php' ) )
			die( '<b>Error!</b><hr /> <i>Skin error!!!</i>' );

		$_skindir = $skinname;
		require( DIR . '/skin/' . $_skindir . '/themes.php' );

		if( isset( $themes ) )
		{
			if( !empty( $themes['name'] ) ) $this->_name = $themes['name'];
			if( !empty( $themes['author'] ) ) $this->_author = $themes['author'];
			if( !empty( $themes['date'] ) ) $this->_date = $themes['date'];
			if( !empty( $themes['version'] ) ) $this->_version = $themes['version'];
		}
	}
}