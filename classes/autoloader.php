<?php


namespace DoyouWatch;

/**
 * AutoloaderClasses class.
 */
class AutoloaderClasses
{
	
	/**
     * PREFIX
     * 
     * @var string
     * @access public
     */
    const PREFIX = 'DoyouWatch';

	/**
     * register function.
     * 
     * @access public
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }

	/**
     * autoload function.
     * 
	 *
	 * @param string class
     * @access public
     * @return void
     */
    public static function autoload($class)
    {	
        $prefixLength = strlen(self::PREFIX);
		
        if (0 === strncmp(self::PREFIX, $class, $prefixLength)) 
		{
            $file = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, $prefixLength));
            $file = realpath(__DIR__ . (empty($file) ? '' : DIRECTORY_SEPARATOR) . strtolower($file) . '.php');

            if(file_exists($file)) 
			{
				//echo $file;
                require_once $file;
            }
        }
    }
}