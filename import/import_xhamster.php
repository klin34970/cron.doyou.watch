<?php

require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Xml;

if(!file_exists(dirname(__FILE__) . "/.process_import_xhamster"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_xhamster", "w");
	fclose($process);
	
	$urls[] = 'http://partners.xhamster.com/2export.php?ch=!&pr=1&cnt=2&tmb=4&tcnt=1&url=off&em=3&dlm=%7C&fr=2&ttl=on&chs=on&sz=on';
	$urls[] = 'http://partners.xhamster.com/2export.php?ch=!&pr=1&cnt=2&tmb=4&tcnt=1&ord=1&url=off&em=3&dlm=%7C&fr=2&ttl=on&chs=on&sz=on';
	$urls[] = 'http://partners.xhamster.com/2export.php?ch=!&pr=1&cnt=2&tmb=4&tcnt=1&ord=2&url=off&em=3&dlm=%7C&fr=2&ttl=on&chs=on&sz=on';


	foreach($urls as $url)
	{
		Xml::getInstance()->url = $url;
		Xml::getInstance()->clean = true;
		Xml::getInstance()->run();
		echo $url;
	}

	unlink(dirname(__FILE__) . "/.process_import_xhamster");
}
