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
class session{

	public $_value = array( );

	// __contruct -------------------------------------
	function __contruct() {
		if( !$_SESSION ) $this->_start();
	}
	
	// Session start ----------------------------------
	public function _start() 
	{
		if( !headers_sent() )
		{
			return session_start();
		}
	}
	
	// End session ------------------------------------
	public function _end() 
	{
		return session_destroy();
	}
	
	// Set session ------------------------------------
	public function _set( $name, $value, $overwrite = true )
	{
		if( !$_SESSION )
			$this->_start();

		$name = trim( $name );
		$value = trim( $value );

		if( !empty( $_SESSION[$name] ) and !$overwrite )
		{
			return false;
		}

		return ( $_SESSION[$name] = $value );
	}
	
	public function set( $name, $value, $overwrite = true )
	{
		return $this->_set( $name, $value, $overwrite = true );
	}
	
	// Get session ---------------------------------
	public function _get( $name )
	{
		if( empty( $name ) ) return '';
		if( !isset( $_SESSION ) )
		{
			$this->_start();
			return '';
		}
		if( !isset( $_SESSION["$name"] ) or empty( $_SESSION["$name"] ) ) return '';
		return $_SESSION["$name"];
	}
	
	public function get( $name )
	{
		return $this->_get( $name );
	}
	
	// Unset session -----------------------------
	public function _unset( $name )
	{
		if( !isset( $_SESSION["$name"] ) ) return true;
		return ( $_SESSION["$name"] = '' );
	}
}

?>