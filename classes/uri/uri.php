<?php
namespace DoyouWatch\Uri;

/**
 * Uri class.
 */
Class Uri
{
	/**
     * currentUrl function.
     * 
     * @access public
     * @return void
     */	
	public static function currentUrl() 
	{
		$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
		$host     = $_SERVER['HTTP_HOST'];
		$script   = $_SERVER['SCRIPT_NAME'];
		$params   = $_SERVER['QUERY_STRING'];

		return $protocol . '://' . $host . $script . '?' . $params;
	}
	
	/**
     * baseUrl function.
     * 
     * @access public
     * @return void
     */	
	public static function baseUrl() 
	{
		$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
		$host     = $_SERVER['HTTP_HOST'];
		$script   = $_SERVER['SCRIPT_NAME'];
		$params   = $_SERVER['QUERY_STRING'];

		$url = $protocol . '://' . $host . $script;
		$url = str_replace("index.php", "", $url);
		return $url;
	}
}