<?php
require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Xml;

if(!file_exists(dirname(__FILE__) . "/.process_import_pornhub"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_pornhub", "w");
	fclose($process);
	
	$urls[] = 'http://www.pornhub.com/webmasters/dump_output?keywords=&categories=3,35,1,6,5,40,66,4,7,8,76,44,9,13,10,11,14,74,12,79,57,15,16,47,72,55,48,17,18,19,73,32,80,63,62,20,21,36,70,101,25,39,26,50,27,29,78,22,28,51,2,24,41,53,30,84,31,42,67,75,83,59,92,69,82,33,37,65,23,49,81,43,61&count=1000&size=large_hd&rating=All&delimeter=%7C&fields=embed,url,categories,rating,username,title,tags,duration,pornstars,thumbnail&period=today&order=mr&format=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.pornhub.com/webmasters/dump_output?keywords=&categories=3,35,1,6,5,40,66,4,7,8,76,44,9,13,10,11,14,74,12,79,57,15,16,47,72,55,48,17,18,19,73,32,80,63,62,20,21,36,70,101,25,39,26,50,27,29,78,22,28,51,2,24,41,53,30,84,31,42,67,75,83,59,92,69,82,33,37,65,23,49,81,43,61&count=1000&size=large_hd&rating=All&delimeter=%7C&fields=embed,url,categories,rating,username,title,tags,duration,pornstars,thumbnail&period=today&order=tr&format=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.pornhub.com/webmasters/dump_output?keywords=&categories=3,35,1,6,5,40,66,4,7,8,76,44,9,13,10,11,14,74,12,79,57,15,16,47,72,55,48,17,18,19,73,32,80,63,62,20,21,36,70,101,25,39,26,50,27,29,78,22,28,51,2,24,41,53,30,84,31,42,67,75,83,59,92,69,82,33,37,65,23,49,81,43,61&count=1000&size=large_hd&rating=All&delimeter=%7C&fields=embed,url,categories,rating,username,title,tags,duration,pornstars,thumbnail&period=today&order=mv&format=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';


	foreach($urls as $url)
	{
		Xml::getInstance()->url = $url;
		Xml::getInstance()->clean = true;
		Xml::getInstance()->run();
		echo $url;
	}

	unlink(dirname(__FILE__) . "/.process_import_pornhub");
}