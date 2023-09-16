<?php
require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Xml;

if(!file_exists(dirname(__FILE__) . "/.process_import_xtube"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_xtube", "w");
	fclose($process);

	$urls[] = 'http://www.xtube.com/webmaster/api.php?action=getVideosBySearchParams&search=&count=3000&thumbsize=320x180&rating=0&delimiter=pipe&fields=embed,url,categories,rating,username,title,tags,duration,thumbnail&period=lastweek&ordering=rating&format=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.xtube.com/webmaster/api.php?action=getVideosBySearchParams&search=&count=3000&thumbsize=320x180&rating=0&delimiter=pipe&fields=embed,url,categories,rating,username,title,tags,duration,thumbnail&period=lastweek&ordering=mostviewed&format=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.xtube.com/webmaster/api.php?action=getVideosBySearchParams&search=&count=3000&thumbsize=320x180&rating=0&delimiter=pipe&fields=embed,url,categories,rating,username,title,tags,duration,thumbnail&period=lastweek&ordering=latest&format=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	foreach($urls as $url)
	{
		Xml::getInstance()->dev = false;
		Xml::getInstance()->url = $url;
		Xml::getInstance()->run();
	}
	
	unlink(dirname(__FILE__) . "/.process_import_xtube");
}
