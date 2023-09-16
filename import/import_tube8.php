<?php
require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Xml;

if(!file_exists(dirname(__FILE__) . "/.process_import_tube8"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_tube8", "w");
	fclose($process);

	$urls[] = 'http://www.tube8.com/api.php?action=webMaster&orientation=all&count=1000&size=large&rating=0&delimiter=%2C&fields=embed,url,categories,rating,username,title,tags,duration,pornstars,thumbnail&period=td&order=lt&format=XML&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.tube8.com/api.php?action=webMaster&orientation=all&count=1000&size=large&rating=0&delimiter=%2C&fields=embed,url,categories,rating,username,title,tags,duration,pornstars,thumbnail&period=td&order=nt&format=XML&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.tube8.com/api.php?action=webMaster&orientation=all&count=1000&size=large&rating=0&delimiter=%2C&fields=embed,url,categories,rating,username,title,tags,duration,pornstars,thumbnail&period=td&order=tr&format=XML&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';
	
	$urls[] = 'http://www.tube8.com/api.php?action=webMaster&orientation=all&count=1000&size=large&rating=0&delimiter=%2C&fields=embed,url,categories,rating,username,title,tags,duration,pornstars,thumbnail&period=td&order=mv&format=XML&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	foreach($urls as $url)
	{
		Xml::getInstance()->url = $url;
		Xml::getInstance()->run();
	}
	
	unlink(dirname(__FILE__) . "/.process_import_tube8");
}
