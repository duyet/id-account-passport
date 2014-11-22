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
class error
{
	private $_sitekey = '';
	private $_error = array();
	private $_logdir = 'tmp/logs/';

	function __construct( $config = array() )
	{
		if( !empty( $config['sitekey'] ) )
			$this->_sitekey = $config['sitekey'];
		if( !empty( $config['logdir'] ) )
			$this->_logdir = $config['logdir'];

		$this->_date = time();
	}

	public function getError( $id = 0 )
	{
		if( intval( $id ) > 0 )
		{
			if( isset( $this->_error[$id] ) )
				return $this->_error[$id];
		}
		else
		{
			return $this->_error;
		}
	}

	public function setSiteKey( $key )
	{
		$this->_sitekey = $key;
	}

	public function setDirLog( $dirname )
	{
		$this->_logdir = $dirname;
	}

	public function getCountError()
	{
		return count( $this->_error );
	}

	public function show( $status = '' )
	{
		if( !empty( $status ) )
		{
			$this->_error[] = array( 'Status' => $status, 'Time' => TIMENOW );
			echo <<<E
<html><head><title>Site Error</title>
	<style>.alert{-webkit-box-shadow:inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);box-shadow:inset 1px 0 0 rgba(0,0,0,.14),inset -1px 0 0 rgba(0,0,0,.07);background-image: -webkit-linear-gradient(top,#f5f5f5,#f1f1f1);background-image: -moz-linear-gradient(top,#f5f5f5,#f1f1f1);background-image: -ms-linear-gradient(top,#f5f5f5,#f1f1f1);background-image: -o-linear-gradient(top,#f5f5f5,#f1f1f1);background-image:linear-gradient(top,#f5f5f5,#f1f1f1);background:#fff;border:1px
solid #ccc;border:1px
solid rgba(0,0,0,.2);width:90%;padding:0}.alert_header{font-weight:bold;color:white;text-align:left;width:60%;height:25px;border:0px
solid black;height:35px;padding-top:10px;background-image: -webkit-gradient(linear,left top,left bottom,from(#eee),to(#e0e0e0));background-image: -webkit-linear-gradient(top,#eee,#e0e0e0);background-image: -moz-linear-gradient(top,#eee,#e0e0e0);background-image: -ms-linear-gradient(top,#eee,#e0e0e0);background-image: -o-linear-gradient(top,#eee,#e0e0e0);background-image:linear-gradient(top,#eee,#e0e0e0);margin:0;color:#666;padding-top:12px;line-height:16px;width:100%;-webkit-border-radius:2px;-moz-border-radius:2px;border-radius:2px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,0.1);-moz-box-shadow:inset 0 1px 1px rgba(0,0,0,0.1);box-shadow:inset 0 1px 1px rgba(0,0,0,0.1);border-collapse:collapse; /**/}.alert_icon
img{height:15px;width:15px;padding-top:2px}.alert_content{border:0px
solid black;min-height:100px;margin-top:10px;width:60%;background:;color:#;text-align:left;width:90%;margin:0;padding-left:10px;padding-right:35px;color:#666;margin-right:0;margin-top:10px;padding-top:10px}.alert_content
.c{padding:4px;margin:4px}.alert_content
a{color:#F99468;text-decoration:none}</style>
</head><body><br /><br /><br /><center><div class="alert"><div class="alert_header clearfix"><span class="icon">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Site Error</span></div><div class="alert_content"><div class="c"><span>$status</span><br /><br />Key: {$this->_sitekey}<br /><br /></div></div></div></center></body></html>
E;
			$this->_errorLog( array( 'status' ) );
			exit(-1);
		}
		else die;
	}

	private function _errorLog( array $error )
	{
		$logfile = $this->_logdir . '/' . substr( md5( $this->_sitekey . date( 'd' ) ), 0, 5 ) . '.txt';
		$fp = @fopen( $logfile, "w" );
		if( $fp )
		{
			@fwrite( "Date: ". date( 'd-m-Y', $this->_date ) . ", Error: " . $error['status'] );
		}
		@fclose( $fp );
	}
}