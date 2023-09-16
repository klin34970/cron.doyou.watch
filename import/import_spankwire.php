<?php
require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Xml;

if(!file_exists(dirname(__FILE__) . "/.process_import_spankwire"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_spankwire", "w");
	fclose($process);

	$urls[] = 'http://www.spankwire.com/api/HubTrafficApiCall?data=searchVideos&status=active&search=&count=1000&thumbsize=large&period=Today&ordering=tr&output=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.spankwire.com/api/HubTrafficApiCall?data=searchVideos&status=active&search=&count=1000&thumbsize=large&period=Today&ordering=mv&output=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.spankwire.com/api/HubTrafficApiCall?data=searchVideos&status=active&search=&count=1000&thumbsize=large&period=Today&ordering=mr&output=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';
	
	$urls[] = 'http://www.spankwire.com/api/HubTrafficApiCall?data=searchVideos&status=active&search=&count=1000&thumbsize=large&period=Today&ordering=lg&output=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';
	
	$urls[] = 'http://www.spankwire.com/api/HubTrafficApiCall?data=searchVideos&status=active&search=&count=1000&thumbsize=large&period=Today&ordering=mc&output=xml&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	foreach($urls as $url)
	{
		Xml::getInstance()->url = $url;
		Xml::getInstance()->run();
	}
	
	unlink(dirname(__FILE__) . "/.process_import_spankwire");
}
