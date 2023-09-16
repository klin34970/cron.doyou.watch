<?php

namespace DoyouWatch;

/**
 * Config class.
 */
Class Config
{
	/**
     * sql_driver
     * 
     * @var string
     * @access private
     */
	private $sql_driver 				= 'mysql';	
	
	/**
     * sql_host
     * 
     * @var string
     * @access private
     */
	private $sql_host 				= 'localhost';
	
	/**
     * sql_user
     * 
     * @var string
     * @access private
     */
	private $sql_user 				= 'dw_2016';
	
	/**
     * sql_password
     * 
     * @var string
     * @access private
     */
	private $sql_password 			= 'DoyouWatch@2016';
	
	/**
     * sql_dbname
     * 
     * @var string
     * @access private
     */
	private $sql_dbname 				= 'dw_2016';
	
	/**
     * sql_prefix
     * 
     * @var string
     * @access private
     */
	private $sql_prefix 				= 'dw_';
	
	/**
     * error_reporting
     * 
     * @var string
	 *
	 * none
	 * simple
	 * maximum
	 * development
	 *
     * @access private
     */
	private $error_reporting 		= "development";
	
	/**
     * _instance
     * 
     * @var mixed
	 *
     * @access private
     */
	private static $_instance;
	
	/**
     * getInstance function.
     * 
     * @access private
     * @return void
     */
	public static function getInstance()
	{
		if(is_null(self::$_instance))
		{
			self::$_instance = new Config;
		}
		return self::$_instance;
	}
	
	/**
     * get function.
     * 
	 * @param string key
	 *
     * @access private
     * @return void
     */
	public function get($key)
	{
		if(!isset($this->{$key}))
		{
			return null;
		}
		return $this->{$key};
	}
}