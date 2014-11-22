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
class cookie
{
	public $path = '';
	public $domain = '';
	public $secure = null;
	public $httponly = null;

	public function __construct( $config = array() )
	{
		if( !empty( $config['path'] ) ) $this->path = (string)$config['path'];
		if( !empty( $config['domain'] ) ) $this->domain = (string)$config['domain'];
		if( isset( $config['secure'] ) ) $this->secure = (boolean)$config['secure'];
		if( isset( $config['httponly'] ) ) $this->httponly = (boolean)$config['httponly'];
	}

	public function set( $cookie_name, $cookie_value = '', $expire = 0, $path = '', $domain = '', $secure = false, $httponly = false )
	{
		if( is_array( $cookie_value ) ) return false;
		if( empty( $cookie_name ) ) return false;
		$expire = intval( $expire );
		if( empty( $path ) and !empty( $this->path ) )
			$path = $this->path;
		if( empty( $domain ) and !empty( $this->domain ) )
			$domain = $this->domain;
		if( $this->secure != null ) $secure = $this->secure;
		if( $this->httponly != null ) $httponly = $this->httponly;
		
		//echo ("$cookie_name, $cookie_value, $expire, $path, $domain, $secure, $httponly");
		return setcookie( $cookie_name, $cookie_value, $expire, $path, $domain, $secure, $httponly );
	}

	public function get( $cookie_name, $default = '', $type = null )
	{
		if( empty( $cookie_name ) ) return false;
		if( !isset( $_COOKIE["$cookie_name"] ) )
		{
			if( !empty( $default ) ) return $default;
			return false;
		}
		if( $type != null )
		{
			switch( $type )
			{
				case 'int': return intval( $_COOKIE["$cookie_name"] );
				case 'boolean': return (boolean)$_COOKIE["$cookie_name"];
				case 'float':  floatval( $_COOKIE["$cookie_name"] );
				default: return (string)$_COOKIE["$cookie_name"]; // String
			}
		}
		return $_COOKIE["$cookie_name"];
	}

	public function _isset( $cookie_name )
	{
		return ( ( isset( $_COOKIE["$cookie_name"] ) and !empty( $_COOKIE["$cookie_name"] ) ) ? true : false );
	}

	public function _unset( $cookie_name )
	{
		if( $this->_isset( $cookie_name ) )
		{
			$this->set( $cookie_name, '', TIMENOW-3600, $this->path, $this->domain );
		//	@unset( $_COOKIE[$cookie_name] );
		}
		return true;
	}
}