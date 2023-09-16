<?php
require_once(dirname(__FILE__) . '/../autoload.php');

Use DoyouWatch\Import\Xml;

if(!file_exists(dirname(__FILE__) . "/.process_import_redtube"))
{
	$process = fopen(dirname(__FILE__) . "/.process_import_redtube", "w");
	fclose($process);

	$urls[] = 'http://www.redtube.com/_status/export.php?search=&categories=1.2.3.4.5.6.7.8.9.10.11.12.13.14.15.16.17.18.19.20.21.22.23.24.25.26.27.28.29.30.31.32.33.34.35&limit=3000&thumb_size=b&min_rating=0&delimiter=%7C&embed=&include_url=1&include_categories=1&include_duration=1&include_video_id=1&include_title=1&include_tags=1&include_added=1&thumbs_in_one_row=1&added_before_x_days=7&thumbs=1&order_by=time&export=xml&do=export&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.redtube.com/_status/export.php?search=&categories=1.2.3.4.5.6.7.8.9.10.11.12.13.14.15.16.17.18.19.20.21.22.23.24.25.26.27.28.29.30.31.32.33.34.35&limit=3000&thumb_size=b&min_rating=0&delimiter=%7C&embed=&include_url=1&include_categories=1&include_duration=1&include_video_id=1&include_title=1&include_tags=1&include_added=1&thumbs_in_one_row=1&added_before_x_days=7&thumbs=1&order_by=rating&export=xml&do=export&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';

	$urls[] = 'http://www.redtube.com/_status/export.php?search=&categories=1.2.3.4.5.6.7.8.9.10.11.12.13.14.15.16.17.18.19.20.21.22.23.24.25.26.27.28.29.30.31.32.33.34.35&limit=3000&thumb_size=b&min_rating=0&delimiter=%7C&embed=&include_url=1&include_categories=1&include_duration=1&include_video_id=1&include_title=1&include_tags=1&include_added=1&thumbs_in_one_row=1&added_before_x_days=7&thumbs=1&order_by=views&export=xml&do=export&utm_source=paid&utm_medium=hubtraffic&utm_campaign=hubtraffic_klin34970';


	foreach($urls as $url)
	{
		Xml::getInstance()->url = $url;
		Xml::getInstance()->run();
	}

	unlink(dirname(__FILE__) . "/.process_import_redtube");
}

