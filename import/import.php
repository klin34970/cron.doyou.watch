<?php
error_reporting(-1);
ini_set('display_errors', 1);

require_once('../autoload.php');

Use DoyouWatch\Import\Xml;
Use DoyouWatch\Import\Rss;

if(!file_exists(".process_import"))
{
	$process = fopen(".process_import", "w");
	fclose($process);

	/*
	$urls[] = 'http://www.spankwire.com/api/HubTrafficApiCall?data=searchVideos&status=active&search=&count=100&thumbsize=all&period=All_Time&ordering=tr&output=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';
	
	

	foreach($urls as $url)
	{
		Xml::getInstance()->dev = true;
		Xml::getInstance()->url = $url;
		Xml::getInstance()->curl = true;
		Xml::getInstance()->clean = false;
		Xml::getInstance()->run();
	}
	*/

	
	$rsss[] = 'https://www.porndig.com/rss/channel/33/anal.xml';
	foreach($rsss as $rss)
	{
		Rss::getInstance()->dev = true;
		Rss::getInstance()->url = $rss;
		Rss::getInstance()->curl = false;
		Rss::getInstance()->clean = false;
		Rss::getInstance()->run();
	}	
	
	
	unlink(".process_import");
}
