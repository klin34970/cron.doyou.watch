<?php
require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Xml;

if(!file_exists(dirname(__FILE__) . "/.process_import_youporn"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_youporn", "w");
	fclose($process);

	$urls[] = 'http://www.youporn.com/videodump/output/?keywords=&orientation=all&categories=63,1,2,3,4,6,7,5,51,9,52,10,11,12,13,37,15,16,44,8,48,17,42,18,62,19,20,58,50,21,65,46,22,23,66,25,41,40,49,26,29,64,55,28,36,56,57,30,53,43,61,54,31,27,60,39,47,59,32,38,33,34,35,45&limit=200&thumbnailsize=640x480&rating=All&delimiter=%7C&fields=embed,url,categories,rating,user_name,title,tags,duration,pornstars,main_thumbnail&period=today&orderby=rating&exportformat=XML&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.youporn.com/videodump/output/?keywords=&orientation=all&categories=63,1,2,3,4,6,7,5,51,9,52,10,11,12,13,37,15,16,44,8,48,17,42,18,62,19,20,58,50,21,65,46,22,23,66,25,41,40,49,26,29,64,55,28,36,56,57,30,53,43,61,54,31,27,60,39,47,59,32,38,33,34,35,45&limit=200&thumbnailsize=640x480&rating=All&delimiter=%7C&fields=embed,url,categories,rating,user_name,title,tags,duration,pornstars,main_thumbnail&period=today&orderby=views&exportformat=XML&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.youporn.com/videodump/output/?keywords=&orientation=all&categories=63,1,2,3,4,6,7,5,51,9,52,10,11,12,13,37,15,16,44,8,48,17,42,18,62,19,20,58,50,21,65,46,22,23,66,25,41,40,49,26,29,64,55,28,36,56,57,30,53,43,61,54,31,27,60,39,47,59,32,38,33,34,35,45&limit=200&thumbnailsize=640x480&rating=All&delimiter=%7C&fields=embed,url,categories,rating,user_name,title,tags,duration,pornstars,main_thumbnail&period=today&orderby=release_date&exportformat=XML&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	foreach($urls as $url)
	{
		Xml::getInstance()->url = $url;
		Xml::getInstance()->clean = true;
		Xml::getInstance()->run();
	}
	
	unlink(dirname(__FILE__) . "/.process_import_youporn");
}
