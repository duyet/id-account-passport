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
class ypfunction
{
	function __contruct()
	{
		
	}

	function load( $function = '', $params = array() )
	{
		if( empty( $function ) ) return false;
		if( !is_array( $params ) ) $params = array( $params );

		$params = $this->fixvalue( $params );

		if( !defined( 'IS_INCLUDE_FUNCTIONS' ) )
			require_once( DIR . '/includes/functions.php' );

		if( !function_exists( "$function" ) ) return false;
		if( count( $params ) == 0 ) return eval("return $function();");
		else
		{
			$eval = implode( ', ', $params );
			// echo( "return $function( $eval );" . '<br>' );
			return eval("return $function( $eval );");
		}
		return false;
	}

	private function fixvalue( $param )
	{
		if( !is_array( $param ) )
		{
			if( is_string( $param ) )
			{
				$param = str_replace( '"', '\"', $param );
				return "\"$param\"";
			}
			if( is_integer( $param ) ) return intval( $param );
			if( is_bool( $param ) ) return (boolean)$param;
			RETURN $param;
		}
		else
		{
			foreach( $param as $id => $value )
			{
				$param[$id] = $this->fixvalue( $value );
			}
			return $param;
		}
	}
}