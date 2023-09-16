<?php
require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Rss;

if(!file_exists(dirname(__FILE__) . "/.process_import_vporn_rss"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_vporn_rss", "w");
	fclose($process);
	
	$rsss[] = 'http://www.vporn.com/rss/';
	
	foreach($rsss as $rss)
	{
		Rss::getInstance()->url = $rss;
		Rss::getInstance()->curl = false;
		Rss::getInstance()->clean = true;
		Rss::getInstance()->run();
	}

	unlink(dirname(__FILE__) . "/.process_import_vporn_rss");
}